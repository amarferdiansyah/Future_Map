@extends('layouts.app')

@section('title', 'Jalur Karir - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Jalur Karir</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan jalur karir yang sesuai dengan minat dan potensimu, lengkap dengan panduan skill dan kursus rekomendasi</p>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
            <form method="GET" action="{{ route('career-paths.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[300px]">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari jalur karir (contoh: Web Developer, Data Scientist)..."
                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                </div>
                <div class="w-64">
                    <select name="industry" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="">Semua Industri</option>
                        @foreach($industries as $industry)
                        <option value="{{ $industry }}" {{ request('industry') == $industry ? 'selected' : '' }}>
                            {{ $industry }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Career Paths Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($careerPaths as $path)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center text-white text-2xl">
                            <i class="fas {{ $path->icon ?? 'fa-briefcase' }}"></i>
                        </div>
                        <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-medium">
                            {{ $path->industry }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition">
                        <a href="{{ route('career-paths.show', $path->slug) }}">{{ $path->title }}</a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $path->description }}</p>
                    
                    <div class="space-y-2 mb-4">
                        @if($path->avg_salary_min && $path->avg_salary_max)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-money-bill-alt text-gray-400 w-5"></i>
                            <span class="text-gray-600">Rp {{ number_format($path->avg_salary_min/1000000,1) }} - {{ number_format($path->avg_salary_max/1000000,1) }} jt/bulan</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center text-sm">
                            <i class="fas fa-graduation-cap text-gray-400 w-5"></i>
                            <span class="text-gray-600">{{ $path->courses_count }} Kursus Rekomendasi</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($path->required_skills)
                            @foreach(array_slice($path->required_skills, 0, 3) as $skill)
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $skill }}</span>
                            @endforeach
                            @if(count($path->required_skills) > 3)
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">+{{ count($path->required_skills) - 3 }}</span>
                            @endif
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            <i class="far fa-clock mr-1"></i> Update {{ $path->updated_at->diffForHumans() }}
                        </span>
                        <a href="{{ route('career-paths.show', $path->slug) }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
                            Jelajahi <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-road text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Jalur Karir</h3>
                <p class="text-gray-500">Belum ada data jalur karir yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $careerPaths->withQueryString()->links() }}
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