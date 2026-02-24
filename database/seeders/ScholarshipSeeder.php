<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholarship;
use Carbon\Carbon;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        $scholarships = [
            [
                'name' => 'Beasiswa Unggulan Kemendikbud',
                'provider' => 'Kementerian Pendidikan dan Kebudayaan',
                'description' => 'Program beasiswa untuk mahasiswa berprestasi di seluruh Indonesia.',
                'requirements' => "- IPK minimal 3.50\n- Aktif dalam organisasi\n- Surat rekomendasi dari dosen",
                'amount' => 12000000,
                'deadline' => Carbon::now()->addMonths(2),
                'type' => 'academic',
                'level' => 'undergraduate',
                'link' => 'https://beasiswa.kemdikbud.go.id',
                'is_active' => true,
            ],
            [
                'name' => 'LPDP Beasiswa Magister',
                'provider' => 'Lembaga Pengelola Dana Pendidikan',
                'description' => 'Beasiswa penuh untuk program magister dalam dan luar negeri.',
                'requirements' => "- IPK minimal 3.00\n- Usia maksimal 35 tahun\n- Lulus tes bahasa Inggris",
                'amount' => 250000000,
                'deadline' => Carbon::now()->addMonths(3),
                'type' => 'government',
                'level' => 'graduate',
                'link' => 'https://lpdp.kemenkeu.go.id',
                'is_active' => true,
            ],
            [
                'name' => 'Beasiswa Data Science',
                'provider' => 'Tech Company Foundation',
                'description' => 'Beasiswa untuk mahasiswa jurusan Ilmu Komputer yang fokus pada Data Science.',
                'requirements' => "- IPK minimal 3.25\n- Semester 5-7\n- Menguasai dasar pemrograman",
                'amount' => 15000000,
                'deadline' => Carbon::now()->addMonths(1),
                'type' => 'special',
                'level' => 'undergraduate',
                'link' => 'https://techfoundation.org',
                'is_active' => true,
            ],
        ];

        foreach ($scholarships as $scholarship) {
            Scholarship::create($scholarship);
        }

        $this->command->info('Scholarships seeded successfully!');
    }
}