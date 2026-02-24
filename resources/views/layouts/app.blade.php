<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FutureMap') - Platform Akademik & Karir</title>
    
    <!-- Tailwind CSS dengan konfigurasi kustom -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js untuk interaktivitas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2); }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = window.scrollY > 20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">F</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Future<span class="text-blue-600">Map</span></span>
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex ml-10 space-x-8">
                        <a href="{{ route('jobs.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('jobs.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                            <i class="fas fa-briefcase mr-1"></i> Lowongan
                        </a>
                        <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('events.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                            <i class="fas fa-calendar mr-1"></i> Event
                        </a>
                        <a href="{{ route('scholarships.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('scholarships.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                            <i class="fas fa-graduation-cap mr-1"></i> Beasiswa
                        </a>
                        <a href="{{ route('career-paths.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition {{ request()->routeIs('career-paths.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                            <i class="fas fa-road mr-1"></i> Jalur Karir
                        </a>
                    </div>
                </div>
                
                <!-- Right Navigation -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-500 hover:text-gray-700 relative">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg py-2 border z-50"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                                <div class="px-4 py-2 border-b">
                                    <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm text-gray-600">Lamaran Anda untuk posisi Web Developer sedang direview</p>
                                        <p class="text-xs text-gray-400 mt-1">5 menit yang lalu</p>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm text-gray-600">Event "Career Preparation Workshop" akan dimulai besok</p>
                                        <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                                    </a>
                                </div>
                                <div class="px-4 py-2 border-t text-center">
                                    <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <img src="{{ auth()->user()->avatar ? (filter_var(auth()->user()->avatar, FILTER_VALIDATE_URL) ? auth()->user()->avatar : asset('uploads/avatars/'.auth()->user()->avatar)) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&size=32&background=0D8F81&color=fff' }}" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-blue-500">
                                <span class="hidden md:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 border z-50"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                                
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                                    </span>
                                </div>
                                
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user w-5"></i> Profile
                                </a>
                                <a href="{{ route('my-applications') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-file-alt w-5"></i> Lamaran Saya
                                </a>
                                <a href="{{ route('my-events') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-calendar-check w-5"></i> Event Saya
                                </a>
                                
                                <div class="border-t my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt w-5"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="gradient-bg text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-lg transition">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-show="open" class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('jobs.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Lowongan</a>
                <a href="{{ route('events.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Event</a>
                <a href="{{ route('scholarships.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Beasiswa</a>
                <a href="{{ route('career-paths.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Jalur Karir</a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages dengan desain lebih menarik -->
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 animate-slide-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-green-400 hover:text-green-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-4 z-50 animate-slide-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-red-400 hover:text-red-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer Modern -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">F</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Future<span class="text-blue-600">Map</span></span>
                    </div>
                    <p class="text-gray-500 text-sm">Platform terintegrasi untuk membantu mahasiswa menemukan peluang akademik dan karir terbaik.</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Fitur</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('jobs.index') }}" class="text-gray-500 hover:text-blue-600 text-sm">Lowongan Kerja</a></li>
                        <li><a href="{{ route('events.index') }}" class="text-gray-500 hover:text-blue-600 text-sm">Event & Webinar</a></li>
                        <li><a href="{{ route('scholarships.index') }}" class="text-gray-500 hover:text-blue-600 text-sm">Beasiswa</a></li>
                        <li><a href="{{ route('career-paths.index') }}" class="text-gray-500 hover:text-blue-600 text-sm">Jalur Karir</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Perusahaan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-blue-600 text-sm">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-blue-600 text-sm">Blog</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-blue-600 text-sm">Karir</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-blue-600 text-sm">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-blue-600 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-blue-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-pink-600 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-blue-700 hover:text-white transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-800 mb-2">Download App</h4>
                        <div class="flex space-x-2">
                            <a href="#" class="flex-1 bg-gray-900 text-white px-3 py-2 rounded-lg text-xs hover:bg-gray-800 transition">
                                <i class="fab fa-apple mr-1"></i> App Store
                            </a>
                            <a href="#" class="flex-1 bg-gray-900 text-white px-3 py-2 rounded-lg text-xs hover:bg-gray-800 transition">
                                <i class="fab fa-google-play mr-1"></i> Play Store
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">© 2024 FutureMap. All rights reserved. Made with <i class="fas fa-heart text-red-500"></i> for students</p>
            </div>
        </div>
    </footer>

    <!-- Custom CSS Animations -->
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-hover:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
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

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }

    .animate-pulse-slow {
        animation: pulse 2s infinite;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }

    .animation-delay-600 {
        animation-delay: 0.6s;
        opacity: 0;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .gradient-bg-hover:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .glass-morphism {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -10px rgba(0,0,0,0.15);
    }

    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
     .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination .page-item {
        display: inline-block;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        color: #4b5563;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .pagination .page-link:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .pagination .active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }
    
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    </style>

    @stack('scripts')
</body>
</html>