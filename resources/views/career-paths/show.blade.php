@extends('layouts.app')

@section('title', $careerPath->title . ' - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('career-paths.index') }}" class="inline-flex items-center text-gray-600 hover:text-purple-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Jalur Karir
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-12">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center text-white text-4xl">
                        <i class="fas {{ $careerPath->icon ?? 'fa-briefcase' }}"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $careerPath->title }}</h1>
                        <p class="text-purple-100 text-lg">{{ $careerPath->industry }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Karir</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($careerPath->description)) !!}
                    </div>
                </div>

                <!-- Required Skills -->
                @if($careerPath->required_skills && count($careerPath->required_skills) > 0)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Skill yang Dibutuhkan</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($careerPath->required_skills as $skill)
                        <span class="px-4 py-2 bg-purple-50 text-purple-600 rounded-lg text-sm font-medium">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recommended Certifications -->
                @if($careerPath->recommended_certifications && count($careerPath->recommended_certifications) > 0)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Sertifikasi Rekomendasi</h2>
                    <div class="space-y-3">
                        @foreach($careerPath->recommended_certifications as $cert)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-3">
                                <i class="fas fa-certificate text-sm"></i>
                            </div>
                            <span class="text-gray-700">{{ $cert }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Career Progression -->
                @if($careerPath->career_progression)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Progres Karir</h2>
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-purple-200"></div>
                        @php
                        $levels = explode('→', $careerPath->career_progression);
                        @endphp
                        @foreach($levels as $index => $level)
                        <div class="relative flex items-start mb-6 last:mb-0">
                            <div class="absolute left-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold z-10">
                                {{ $index + 1 }}
                            </div>
                            <div class="ml-12">
                                <p class="text-gray-700">{{ trim($level) }}</p>
                                @if($index < count($levels) - 1)
                                <p class="text-xs text-gray-400 mt-1">{{ $index == 0 ? 'Entry Level' : ($index == 1 ? 'Mid Level' : 'Senior Level') }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recommended Courses -->
                @if($careerPath->courses && $careerPath->courses->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Kursus Rekomendasi</h2>
                    
                    <div class="space-y-4">
                        @foreach($careerPath->courses as $course)
                        <div class="flex items-start p-4 border border-gray-200 rounded-xl hover:shadow-md transition">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                                <i class="fas fa-laptop-code text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $course->course_name }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-sm">
                                    @if($course->platform)
                                    <span class="text-gray-500">
                                        <i class="fas fa-laptop mr-1"></i> {{ $course->platform }}
                                    </span>
                                    @endif
                                    @if($course->university)
                                    <span class="text-gray-500">
                                        <i class="fas fa-university mr-1"></i> {{ $course->university }}
                                    </span>
                                    @endif
                                    @if($course->is_recommended)
                                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">Recommended</span>
                                    @endif
                                </div>
                                @if($course->link)
                                <a href="{{ $course->link }}" target="_blank" 
                                   class="inline-flex items-center mt-3 text-sm font-medium text-purple-600 hover:text-purple-800">
                                    Kunjungi Kursus <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Karir</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 text-purple-600">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Industri</p>
                                <p class="font-medium text-gray-900">{{ $careerPath->industry }}</p>
                            </div>
                        </div>

                        @if($careerPath->avg_salary_min && $careerPath->avg_salary_max)
                        <div class="flex items-start">
                            <div class="w-8 text-purple-600">
                                <i class="fas fa-money-bill-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Rata-rata Gaji</p>
                                <p class="font-semibold text-green-600">
                                    Rp {{ number_format($careerPath->avg_salary_min/1000000,1) }} - {{ number_format($careerPath->avg_salary_max/1000000,1) }} jt
                                </p>
                                <p class="text-xs text-gray-400 mt-1">per bulan</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start">
                            <div class="w-8 text-purple-600">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Kursus</p>
                                <p class="font-medium text-gray-900">{{ $careerPath->courses_count }} Kursus Rekomendasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('jobs.index') }}?search={{ urlencode($careerPath->title) }}" 
                           class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-briefcase text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Cari Lowongan {{ $careerPath->title }}</span>
                        </a>
                        
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-alt text-green-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Download Panduan Karir (PDF)</span>
                        </a>
                        
                        <button onclick="window.print()" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition w-full text-left">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-print text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Cetak Halaman Ini</span>
                        </button>
                    </div>
                </div>

                <!-- Share Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Jalur Karir</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-400 hover:bg-blue-200 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 hover:bg-green-200 transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 hover:bg-blue-200 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Career Paths -->
        @if($relatedPaths->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Jalur Karir Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPaths as $related)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 card-hover">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $related->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $related->industry }}</p>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($related->description, 80) }}</p>
                    <a href="{{ route('career-paths.show', $related->slug) }}" class="text-sm font-medium text-purple-600 hover:text-purple-800">
                        Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection