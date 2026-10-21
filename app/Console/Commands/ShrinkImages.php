<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ShrinkImages extends Command
{
    protected $signature = 'images:shrink
        {folder=guru : Folder di storage/app/public}
        {--width=600 : Lebar maksimum (px)}
        {--quality=80 : Kualitas WebP (1-100)}
        {--dry-run : Hanya tampilkan, tidak mengubah file}';

    protected $description = 'Perkecil resolusi & ukuran foto WebP di satu folder storage (hanya menimpa jika hasilnya lebih kecil).';

    public function handle(): int
    {
        if (!function_exists('imagecreatefromwebp')) {
            $this->error('PHP GD dengan dukungan WebP tidak tersedia.');
            return self::FAILURE;
        }

        $folder  = trim($this->argument('folder'), '/');
        $maks    = (int) $this->option('width');
        $kualitas = (int) $this->option('quality');
        $dry     = (bool) $this->option('dry-run');
        $disk    = Storage::disk('public');

        $total0 = $total1 = $diubah = 0;

        foreach ($disk->files($folder) as $path) {
            if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'webp') {
                continue;
            }

            $abs = $disk->path($path);
            $sebelum = filesize($abs);
            $total0 += $sebelum;

            $img = @imagecreatefromwebp($abs);
            if (!$img) { $total1 += $sebelum; $this->warn("Lewati (gagal dibaca): $path"); continue; }

            $w = imagesx($img);
            if ($w > $maks) {
                $baru = imagescale($img, $maks, -1, IMG_BICUBIC);
                imagedestroy($img);
                $img = $baru;
            }
            imagealphablending($img, false);
            imagesavealpha($img, true);

            ob_start();
            imagewebp($img, null, $kualitas);
            $data = ob_get_clean();
            imagedestroy($img);

            if (strlen($data) < $sebelum) {
                if (!$dry) { file_put_contents($abs, $data); }
                $total1 += strlen($data);
                $diubah++;
                $this->line(sprintf('%s  %s -> %s', basename($path), $this->kb($sebelum), $this->kb(strlen($data))));
            } else {
                $total1 += $sebelum;
            }
        }

        $this->info(sprintf('%s%d file diperkecil. Total %s -> %s',
            $dry ? '[SIMULASI] ' : '', $diubah, $this->kb($total0), $this->kb($total1)));

        return self::SUCCESS;
    }

    private function kb(int $b): string
    {
        return $b >= 1048576 ? round($b / 1048576, 1) . ' MB' : round($b / 1024) . ' KB';
    }
}