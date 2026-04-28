<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@sidok.id',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Sample documents
        $samples = [
            ['title' => 'Surat Keputusan Direktur No. 001/2024', 'document_number' => 'SK/001/2024', 'category' => 'Surat Keputusan', 'cabinet_number' => '1', 'ordner_number' => '01', 'cabinet_label' => 'Lemari SK & Peraturan', 'ordner_label' => 'SK Tahun 2024'],
            ['title' => 'Surat Masuk dari Kementerian PUPR', 'document_number' => 'SM/0023/2024', 'category' => 'Surat Masuk', 'cabinet_number' => '1', 'ordner_number' => '02', 'cabinet_label' => 'Lemari SK & Peraturan', 'ordner_label' => 'Surat Masuk 2024 Jan-Jun'],
            ['title' => 'Laporan Keuangan Q1 2024', 'document_number' => 'LK/Q1/2024', 'category' => 'Laporan', 'cabinet_number' => '2', 'ordner_number' => '01', 'cabinet_label' => 'Lemari Keuangan', 'ordner_label' => 'Laporan Keuangan 2024'],
            ['title' => 'Kontrak Pengadaan Alat Tulis Kantor', 'document_number' => 'KTR/ATK/2024', 'category' => 'Kontrak', 'cabinet_number' => '2', 'ordner_number' => '02', 'cabinet_label' => 'Lemari Keuangan', 'ordner_label' => 'Kontrak Pengadaan 2024'],
            ['title' => 'Notulen Rapat Pimpinan Januari 2024', 'document_number' => 'NOT/001/2024', 'category' => 'Notulen Rapat', 'cabinet_number' => '3', 'ordner_number' => '01', 'cabinet_label' => 'Lemari Rapat & Dokumen Umum', 'ordner_label' => 'Notulen Rapat 2024'],
            ['title' => 'Izin Mendirikan Bangunan Gedung Baru', 'document_number' => 'IMB/2024/001', 'category' => 'Izin', 'cabinet_number' => '3', 'ordner_number' => '02', 'cabinet_label' => 'Lemari Rapat & Dokumen Umum', 'ordner_label' => 'Perizinan 2024'],
        ];

        foreach ($samples as $i => $s) {
            Document::create([
                ...$s,
                'description'       => 'Dokumen ' . $s['category'] . ' - contoh data demo sistem SIDOK',
                'document_date'     => now()->subDays(rand(1, 180)),
                'document_sequence' => $i + 1,
                'status'            => 'active',
                'created_by'        => $admin->id,
            ]);
        }
    }
}
