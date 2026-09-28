<?php

namespace App\Support;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Closure;

class ImageUpload
{
    /**
     * Closure yang dipakai di ->saveUploadedFileUsing() pada field FileUpload Filament.
     * Otomatis convert gambar apapun (jpg/png) jadi .webp sebelum disimpan.
     */
    public static function webp(string $directory, int $quality = 80): Closure
    {
        return function (TemporaryUploadedFile $file) use ($directory, $quality) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            $filename = Str::uuid() . '.webp';
            $encoded = $image->toWebp($quality);

            Storage::disk('public')->put($directory . '/' . $filename, (string) $encoded);

            return $directory . '/' . $filename;
        };
    }
}