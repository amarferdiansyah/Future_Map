<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Major;
use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = ['admin', 'mahasiswa', 'dosen', 'alumni', 'company'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Create Admin - menggunakan firstOrCreate untuk menghindari duplikasi
        $admin = User::firstOrCreate(
            ['email' => 'admin@futuremap.com'],
            [
                'name' => 'Admin FutureMap',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        
        // Assign role hanya jika user baru dibuat atau belum punya role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
        
        // Create profile untuk admin jika belum ada
        if (!$admin->profile) {
            Profile::create(['user_id' => $admin->id]);
        }

        // Create Mahasiswa
        $mahasiswa = User::firstOrCreate(
            ['email' => 'budi@student.com'],
            [
                'name' => 'Budi Mahasiswa',
                'password' => Hash::make('password'),
                'nim' => '2021001',
                'is_active' => true,
            ]
        );
        
        if (!$mahasiswa->hasRole('mahasiswa')) {
            $mahasiswa->assignRole('mahasiswa');
        }

        // Create Dosen
        $dosen = User::firstOrCreate(
            ['email' => 'siti@lecturer.com'],
            [
                'name' => 'Dr. Siti Dosen',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        
        if (!$dosen->hasRole('dosen')) {
            $dosen->assignRole('dosen');
        }

        // Create Company
        $company = User::firstOrCreate(
            ['email' => 'hr@teknologimaju.com'],
            [
                'name' => 'PT Teknologi Maju',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        
        if (!$company->hasRole('company')) {
            $company->assignRole('company');
        }

        // Create Alumni
        $alumni = User::firstOrCreate(
            ['email' => 'ani@alumni.com'],
            [
                'name' => 'Ani Alumni',
                'password' => Hash::make('password'),
                'nim' => '2017001',
                'is_active' => true,
            ]
        );
        
        if (!$alumni->hasRole('alumni')) {
            $alumni->assignRole('alumni');
        }

        // Create Department
        $dept = Department::firstOrCreate(
            ['code' => 'FASILKOM'],
            [
                'name' => 'Fakultas Ilmu Komputer',
                'description' => 'Fakultas Ilmu Komputer dan Teknologi Informasi',
            ]
        );

        // Create Majors
        $if = Major::firstOrCreate(
            ['code' => 'IF'],
            [
                'department_id' => $dept->id,
                'name' => 'Teknik Informatika',
                'degree_level' => 'S1',
                'description' => 'Program Studi Teknik Informatika',
            ]
        );

        $si = Major::firstOrCreate(
            ['code' => 'SI'],
            [
                'department_id' => $dept->id,
                'name' => 'Sistem Informasi',
                'degree_level' => 'S1',
                'description' => 'Program Studi Sistem Informasi',
            ]
        );

        // Create Profiles jika belum ada
        if (!$mahasiswa->profile) {
            Profile::create([
                'user_id' => $mahasiswa->id,
                'major_id' => $if->id,
                'semester' => 5,
                'gpa' => 3.75,
                'bio' => 'Mahasiswa Teknik Informatika semester 5',
            ]);
        }

        if (!$alumni->profile) {
            Profile::create([
                'user_id' => $alumni->id,
                'major_id' => $if->id,
                'graduation_date' => '2021-08-15',
                'bio' => 'Alumni Teknik Informatika 2021',
            ]);
        }

        if (!$dosen->profile) {
            Profile::create([
                'user_id' => $dosen->id,
                'bio' => 'Dosen Fakultas Ilmu Komputer',
            ]);
        }

        if (!$company->profile) {
            Profile::create([
                'user_id' => $company->id,
                'bio' => 'Perusahaan teknologi yang bergerak di bidang pengembangan software',
            ]);
        }

        // Create Skills
        $skills = [
            ['name' => 'PHP', 'category' => 'technical'],
            ['name' => 'Laravel', 'category' => 'technical'],
            ['name' => 'JavaScript', 'category' => 'technical'],
            ['name' => 'React', 'category' => 'technical'],
            ['name' => 'Python', 'category' => 'technical'],
            ['name' => 'UI/UX Design', 'category' => 'technical'],
            ['name' => 'Public Speaking', 'category' => 'softskill'],
            ['name' => 'Teamwork', 'category' => 'softskill'],
            ['name' => 'Leadership', 'category' => 'softskill'],
            ['name' => 'Problem Solving', 'category' => 'softskill'],
            ['name' => 'English', 'category' => 'language'],
        ];
        
        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['name' => $skill['name']],
                ['category' => $skill['category']]
            );
        }

        // Attach skills to mahasiswa (hapus dulu yang lama lalu attach yang baru)
        $mahasiswa->skills()->detach();
        $mahasiswa->skills()->attach([1, 2, 3, 7, 10], ['proficiency_level' => 4]);

        $this->command->info('Database seeded successfully!');
    }
}