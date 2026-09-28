<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ProfilSekolah, Guru, Staf, DataSiswaTahunan, Sarpras, Akreditasi, StrukturOrganisasi, Jurusan, Prestasi, Galeri, Artikel, Pengaturan};

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        ProfilSekolah::create([
            'nama_sekolah' => 'SMK Teknologi Informasi',
            'npsn' => '12345678',
            'alamat' => 'Jl. Contoh Alamat No. 1, Banjarnegara',
            'kode_pos' => '53400',
            'nama_kepala_sekolah' => 'Drs. Contoh Nama, M.Pd.',
            'visi' => 'Menjadi SMK unggulan berbasis teknologi informasi yang menghasilkan lulusan kompeten dan berdaya saing global.',
            'misi' => ['Menyelenggarakan pendidikan kejuruan berkualitas', 'Membangun kerjasama industri', 'Mengembangkan karakter dan kompetensi digital siswa'],
            'profil_yayasan' => 'Yayasan pengelola sekolah ini berdiri sejak lama dan berkomitmen pada pendidikan vokasi berkualitas.',
        ]);

        foreach (['Budi Santoso', 'Siti Aminah', 'Agus Prasetyo', 'Rina Wijaya', 'Dedi Kurniawan', 'Fitri Handayani'] as $i => $nama) {
            Guru::create(['nama' => $nama, 'jabatan' => 'Guru Produktif RPL', 'urutan' => $i]);
        }

        foreach (['Wati Susanti', 'Hendra Gunawan', 'Lestari Putri', 'Ahmad Fauzi'] as $nama) {
            Staf::create(['nama' => $nama, 'jabatan' => 'Staf Tata Usaha']);
        }

        foreach ([2021 => 620, 2022 => 680, 2023 => 720, 2024 => 760, 2025 => 810, 2026 => 850] as $tahun => $jumlah) {
            DataSiswaTahunan::create(['tahun_ajaran' => $tahun, 'jumlah' => $jumlah]);
        }

        foreach ([
            ['nama' => 'Lab Komputer', 'deskripsi' => '3 ruang lab dengan total 90 unit PC.'],
            ['nama' => 'Perpustakaan', 'deskripsi' => 'Koleksi buku teknis dan umum, ruang baca nyaman.'],
            ['nama' => 'Bengkel Praktik Jaringan', 'deskripsi' => 'Peralatan praktik instalasi jaringan lengkap.'],
        ] as $s) {
            Sarpras::create($s);
        }

        Akreditasi::create(['peringkat' => 'A', 'lembaga_penerbit' => 'BAN-SM', 'tahun_berlaku' => 2028]);

        foreach ([
            ['jabatan' => 'Kepala Sekolah', 'nama_pejabat' => 'Drs. Contoh Nama, M.Pd.', 'urutan' => 1],
            ['jabatan' => 'Waka Kurikulum', 'nama_pejabat' => 'Rina Wijaya, S.Kom.', 'urutan' => 2],
            ['jabatan' => 'Waka Kesiswaan', 'nama_pejabat' => 'Agus Prasetyo, S.Pd.', 'urutan' => 3],
            ['jabatan' => 'Waka Sarpras', 'nama_pejabat' => 'Dedi Kurniawan, S.T.', 'urutan' => 4],
        ] as $s) {
            StrukturOrganisasi::create($s);
        }

        foreach ([
            ['nama' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Fokus pada pengembangan aplikasi web dan mobile.'],
            ['nama' => 'Teknik Komputer & Jaringan', 'deskripsi' => 'Fokus pada instalasi dan administrasi jaringan.'],
            ['nama' => 'Multimedia', 'deskripsi' => 'Fokus pada desain grafis, video, dan animasi.'],
            ['nama' => 'Sistem Informasi Jaringan', 'deskripsi' => 'Fokus pada pengelolaan sistem dan basis data.'],
        ] as $j) {
            Jurusan::create($j);
        }

        foreach (range(1, 4) as $i) {
            Prestasi::create(['judul' => "Juara Lomba Contoh $i", 'deskripsi' => 'Deskripsi singkat prestasi.', 'tanggal' => now()->subMonths($i)]);
        }

        foreach (range(1, 6) as $i) {
            Galeri::create(['judul' => "Kegiatan Contoh $i", 'foto' => 'placeholder.jpg', 'kategori' => 'kegiatan', 'urutan' => $i]);
        }

        foreach (range(1, 9) as $i) {
            Artikel::create([
                'judul' => "Judul Artikel Contoh $i",
                'slug' => "judul-artikel-contoh-$i",
                'kategori' => ['prestasi', 'kegiatan', 'pengumuman', 'berita'][$i % 4],
                'excerpt' => 'Ringkasan singkat artikel contoh untuk keperluan pengembangan tampilan.',
                'konten' => '<p>Konten lengkap artikel contoh ini digunakan untuk keperluan pengembangan tampilan halaman detail.</p>',
                'status' => 'publish',
                'pinned' => $i === 1,
                'published_at' => now()->subDays($i),
            ]);
        }

        Pengaturan::create(['key' => 'alumni_terserap_persen', 'value' => '92']);
        Pengaturan::create(['key' => 'link_ppdb', 'value' => 'https://forms.google.com/contoh']);
    }
}