@extends('layouts.app')

@section('title', 'Lowongan Kerja - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Lowongan Kerja & Magang</h1>
                <p class="mt-2 text-gray-600">Temukan peluang karir terbaik sesuai dengan minat dan skill Anda</p>
            </div>
            @can('create', App\Models\JobListing::class)
            <a href="{{ route('jobs.create') }}" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-medium hover:shadow-lg transition">
                <i class="fas fa-plus mr-2"></i>
                Pasang Lowongan
            </a>
            @endcan
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
            <form method="GET" action="{{ route('jobs.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Lowongan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Judul atau perusahaan..."
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pekerjaan</label>
                        <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Semua Tipe</option>
                            @foreach($filters['types'] as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Work Style</label>
                        <select name="work_style" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Semua</option>
                            @foreach($filters['work_styles'] as $style)
                            <option value="{{ $style }}" {{ request('work_style') == $style ? 'selected' : '' }}>
                                {{ ucfirst($style) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                        <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Deadline Terdekat</option>
                            <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Gaji Tertinggi</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                        <i class="fas fa-filter mr-2"></i>
                                           <i class="fas fa-filter mr-2"></i>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Job Listings -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobs as $job)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                                <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $job->company->name }}</p>
                            </div>
                        </div>
                        @auth
                        @if(isset($job->match_score))
                        <span class="px-3 py-1 text-xs rounded-full 
                            @if($job->match_score >= 80) bg-green-100 text-green-600
                            @elseif($job->match_score >= 60) bg-yellow-100 text-yellow-600
                            @else bg-gray-100 text-gray-600
                            @endif">
                            Match {{ $job->match_score }}%
                        </span>
                        @endif
                        @endauth
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span>{{ $job->location ?? 'Remote / Flexible' }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-briefcase w-5"></i>
                            <span>{{ ucfirst($job->type) }} • {{ ucfirst($job->work_style) }}</span>
                        </div>
                        @if($job->salary_min && $job->salary_max)
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-money-bill-alt w-5"></i>
                            <span>Rp {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($job->skills->take(3) as $skill)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $skill->name }}</span>
                        @endforeach
                        @if($job->skills->count() > 3)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">+{{ $job->skills->count() - 3 }}</span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            <i class="far fa-clock mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                        </span>
                        <a href="{{ route('jobs.show', $job->id) }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Lowongan</h3>
                <p class="text-gray-500 mb-6">Belum ada lowongan yang tersedia saat ini.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                    Kembali ke Beranda
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $jobs->withQueryString()->links() }}
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