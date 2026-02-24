@extends('layouts.app')

@section('title', 'Beasiswa - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Beasiswa</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan berbagai beasiswa untuk mendukung pendidikanmu, baik dari dalam maupun luar negeri</p>
        </div>

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-3xl shadow-xl overflow-hidden mb-12">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12 text-white">
                    <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-medium mb-4">Beasiswa Unggulan</span>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">LPDP Beasiswa Magister</h2>
                    <p class="text-green-100 mb-6">Beasiswa penuh untuk program magister dalam dan luar negeri dari pemerintah Indonesia. Kesempatan emas untuk melanjutkan studi S2.</p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center">
                            <i class="fas fa-calendar w-6"></i>
                            <span>Deadline: 30 April 2024</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap w-6"></i>
                            <span>Jenjang: S2 (Magister)</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>Kuota: 2000 penerima</span>
                        </div>
                    </div>

                    <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-teal-600 rounded-xl font-medium hover:shadow-lg transition">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="hidden md:block bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3')"></div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
            <form method="GET" action="{{ route('scholarships.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari beasiswa..."
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            <option value="">Semua Tipe</option>
                            @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('-', ' ', $type)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="level" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            <option value="">Semua Jenjang</option>
                            @foreach($levels as $level)
                            <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Scholarships Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($scholarships as $scholarship)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group">
                <div class="h-40 bg-gradient-to-r from-green-500 to-teal-600 relative">
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-xs font-medium text-green-600">
                        {{ ucfirst($scholarship->type) }}
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <span class="text-white text-lg font-bold">{{ substr($scholarship->provider, 0, 2) }}</span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-green-600 transition">
                        <a href="{{ route('scholarships.show', $scholarship->id) }}">{{ $scholarship->name }}</a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-3">
                        <i class="fas fa-building mr-1"></i> {{ $scholarship->provider }}
                    </p>
                    
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $scholarship->description }}</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar text-gray-400 w-5"></i>
                            <span class="text-gray-600">Deadline: <span class="font-medium {{ now() > $scholarship->deadline ? 'text-red-600' : 'text-green-600' }}">
                                {{ \Carbon\Carbon::parse($scholarship->deadline)->format('d M Y') }}
                            </span></span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-graduation-cap text-gray-400 w-5"></i>
                            <span class="text-gray-600">Jenjang: <span class="font-medium">{{ ucfirst($scholarship->level) }}</span></span>
                        </div>
                        @if($scholarship->amount)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-money-bill-wave text-gray-400 w-5"></i>
                            <span class="text-gray-600">Nominal: <span class="font-medium text-green-600">Rp {{ number_format($scholarship->amount) }}</span></span>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            <i class="far fa-clock mr-1"></i>
                            {{ \Carbon\Carbon::parse($scholarship->deadline)->diffForHumans() }}
                        </span>
                        <a href="{{ route('scholarships.show', $scholarship->id) }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Beasiswa</h3>
                <p class="text-gray-500">Belum ada beasiswa yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $scholarships->withQueryString()->links() }}
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
}
</style>
@endsection