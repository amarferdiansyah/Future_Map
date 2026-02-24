@extends('layouts.app')

@section('title', 'FutureMap - Platform Informasi Akademik & Karir')

@section('content')
<!-- Hero Section dengan Animasi -->
<section class="relative overflow-hidden">
    <div class="gradient-bg absolute inset-0 opacity-90"></div>
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3')] bg-cover bg-center mix-blend-overlay"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">
                Temukan Masa Depan <br>Karir Impianmu
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto animate-fade-in-up animation-delay-200">
                Platform terintegrasi untuk membantu mahasiswa menemukan peluang akademik, magang, dan karir terbaik sesuai potensi mereka.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-400">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('jobs.index') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-blue-600 transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-search mr-2"></i>
                    Jelajahi Lowongan
                </a>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16">
                <div>
                    <div class="text-3xl md:text-4xl font-bold">500+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">Perusahaan Mitra</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold">1000+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">Lowongan Tersedia</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold">50+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">Event Tahunan</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold">5000+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">Mahasiswa Terbantu</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Jobs -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Lowongan Unggulan</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Temukan Pekerjaan Impianmu</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Ribuan lowongan dari perusahaan terbaik menanti Anda</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @for($i = 1; $i <= 6; $i++)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition border card-hover">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                        </div>
                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">Full Time</span>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Frontend Developer</h3>
                    <p class="text-gray-600 text-sm mb-4">PT Teknologi Maju • Jakarta</p>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">React</span>
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">JavaScript</span>
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Tailwind</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-blue-600 font-semibold">Rp 5-8 Juta</span>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800">
                Lihat Semua Lowongan <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Mengapa Memilih FutureMap?</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Fitur Unggulan Kami</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-8 text-center card-hover">
                <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-brain text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Smart Job Matching</h3>
                <p class="text-gray-600">Dapatkan rekomendasi lowongan yang sesuai dengan skill, minat, dan profil akademikmu.</p>
            </div>
            
            <div class="bg-white rounded-xl p-8 text-center card-hover">
                <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Event & Webinar</h3>
                <p class="text-gray-600">Ikuti workshop, seminar, dan job fair dari perusahaan terkemuka secara gratis.</p>
            </div>
            
            <div class="bg-white rounded-xl p-8 text-center card-hover">
                <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-road text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Career Path Guide</h3>
                <p class="text-gray-600">Panduan lengkap jalur karir beserta skill dan sertifikasi yang dibutuhkan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
            <div>
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Event Mendatang</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Tingkatkan Skillmu</h2>
            </div>
            <a href="{{ route('events.index') }}" class="mt-4 md:mt-0 text-blue-600 font-semibold hover:text-blue-800">
                Lihat Semua Event <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-40 bg-gradient-to-r from-blue-500 to-purple-600 relative">
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-xs font-semibold text-blue-600">
                        Webinar
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-calendar mr-2"></i> 25 Maret 2024 • 14:00 WIB
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Career Preparation Workshop</h3>
                    <p class="text-gray-600 text-sm mb-4">Pelajari tips & trik lolos interview kerja dari HRD berpengalaman</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500"><i class="fas fa-users mr-1"></i> 150+ Peserta</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Daftar →</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-40 bg-gradient-to-r from-green-500 to-teal-600 relative">
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-xs font-semibold text-green-600">
                        Workshop
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-calendar mr-2"></i> 28 Maret 2024 • 09:00 WIB
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Fullstack Web Development</h3>
                    <p class="text-gray-600 text-sm mb-4">Hands-on membuat aplikasi web dengan Laravel & React</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500"><i class="fas fa-users mr-1"></i> 80+ Peserta</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Daftar →</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-40 bg-gradient-to-r from-yellow-500 to-orange-600 relative">
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-xs font-semibold text-orange-600">
                        Job Fair
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-calendar mr-2"></i> 5-7 April 2024 • 10:00 WIB
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Virtual Career Expo 2024</h3>
                    <p class="text-gray-600 text-sm mb-4">Bertemu langsung dengan 50+ perusahaan top Indonesia</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500"><i class="fas fa-users mr-1"></i> 500+ Peserta</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Daftar →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Testimoni</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Apa Kata Mereka</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                <div class="flex items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&size=60&background=0D8F81&color=fff" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                        <p class="text-sm text-gray-500">Alumni Teknik Informatika</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Berkat FutureMap, saya berhasil mendapatkan pekerjaan impian di perusahaan teknologi ternama. Fitur job matching-nya sangat membantu!"</p>
                <div class="mt-4 text-yellow-400">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                <div class="flex items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name=Ani+Wijaya&size=60&background=0D8F81&color=fff" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Ani Wijaya</h4>
                        <p class="text-sm text-gray-500">Mahasiswa Semester 6</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Sering mengikuti webinar di FutureMap. Materinya selalu update dan pembicaranya expert di bidangnya. Sangat recommended!"</p>
                <div class="mt-4 text-yellow-400">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                <div class="flex items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name=PT+Teknologi&size=60&background=0D8F81&color=fff" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">PT Teknologi Maju</h4>
                        <p class="text-sm text-gray-500">HRD</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"FutureMap membantu kami menemukan talenta-talenta muda berkualitas. Proses rekrutmen jadi lebih efisien."</p>
                <div class="mt-4 text-yellow-400">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="gradient-bg py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Memulai Perjalanan Karirmu?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Bergabung dengan ribuan mahasiswa lainnya yang sudah menemukan masa depan mereka</p>
        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 inline-flex items-center">
            <i class="fas fa-user-plus mr-2"></i>
            Daftar Gratis Sekarang
        </a>
    </div>
</section>

<!-- Custom Animations -->
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }
    
    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
    
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -10px rgba(0,0,0,0.15);
    }
</style>
@endsection