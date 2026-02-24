<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CareerPath;
use App\Models\CareerPathCourse;

class CareerPathSeeder extends Seeder
{
    public function run(): void
    {
        $careerPaths = [
            [
                'title' => 'Web Developer',
                'description' => 'Web developer bertanggung jawab untuk membangun dan memelihara website. Mereka bekerja dengan bahasa pemrograman seperti HTML, CSS, JavaScript, dan framework seperti Laravel atau React.',
                'industry' => 'Teknologi Informasi',
                'avg_salary_min' => 5000000,
                'avg_salary_max' => 15000000,
                'required_skills' => ['HTML', 'CSS', 'JavaScript', 'PHP', 'Laravel', 'Database'],
                'recommended_certifications' => ['Certified Web Developer', 'Laravel Certification', 'JavaScript Developer Certificate'],
                'career_progression' => "Junior Web Developer (0-2 tahun) → Web Developer (2-4 tahun) → Senior Web Developer (4-6 tahun) → Lead Developer/Technical Lead (6+ tahun) → CTO",
                'icon' => null,
            ],
            [
                'title' => 'Data Scientist',
                'description' => 'Data Scientist menganalisis dan menginterpretasikan data kompleks untuk membantu perusahaan mengambil keputusan. Mereka menggunakan statistika, machine learning, dan programming.',
                'industry' => 'Data & Analytics',
                'avg_salary_min' => 8000000,
                'avg_salary_max' => 20000000,
                'required_skills' => ['Python', 'R', 'SQL', 'Machine Learning', 'Statistika', 'Data Visualization'],
                'recommended_certifications' => ['Certified Data Scientist', 'Google Data Analytics', 'IBM Data Science'],
                'career_progression' => "Junior Data Analyst → Data Analyst → Data Scientist → Senior Data Scientist → Head of Data",
                'icon' => null,
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => 'UI/UX Designer bertanggung jawab untuk mendesain tampilan dan pengalaman pengguna aplikasi atau website agar mudah digunakan dan menarik.',
                'industry' => 'Desain Digital',
                'avg_salary_min' => 4500000,
                'avg_salary_max' => 12000000,
                'required_skills' => ['Figma', 'Adobe XD', 'Sketch', 'User Research', 'Wireframing', 'Prototyping'],
                'recommended_certifications' => ['Google UX Design', 'Certified UI/UX Designer', 'Interaction Design Certification'],
                'career_progression' => "Junior Designer → UI/UX Designer → Senior Designer → Design Lead → Head of Design",
                'icon' => null,
            ],
        ];

        foreach ($careerPaths as $pathData) {
            $path = CareerPath::create($pathData);

            // Add courses for each career path
            $courses = [
                [
                    'course_name' => 'Belajar Dasar Web Development',
                    'platform' => 'Dicoding',
                    'university' => 'Dicoding Academy',
                    'link' => 'https://www.dicoding.com/',
                    'is_recommended' => true,
                ],
                [
                    'course_name' => 'Full Stack Web Developer',
                    'platform' => 'Coursera',
                    'university' => 'University of Michigan',
                    'link' => 'https://www.coursera.org/',
                    'is_recommended' => true,
                ],
            ];

            foreach ($courses as $courseData) {
                $path->courses()->create($courseData);
            }
        }

        $this->command->info('Career paths seeded successfully!');
    }
}