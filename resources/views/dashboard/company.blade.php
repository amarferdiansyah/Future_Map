@extends('layouts.app')

@section('title', 'Dashboard Perusahaan - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Perusahaan</h1>
                    <p class="mt-2 text-gray-600">Kelola lowongan kerja dan lihat perkembangan pelamar.</p>
                </div>
                <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-medium hover:shadow-lg transition">
                    <i class="fas fa-plus mr-2"></i>
                    Pasang Lowongan Baru
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Lowongan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_jobs'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Lowongan Aktif</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_jobs'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pelamar</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_applications'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pelamar Baru</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_applications'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recent Jobs -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Lowongan Terbaru</h3>
                        <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Kelola Lowongan <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentJobs as $job)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-briefcase text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $job->title }}</h4>
                                    <div class="flex items-center space-x-3 text-sm text-gray-500 mt-1">
                                        <span><i class="fas fa-users mr-1"></i> {{ $job->applications_count }} Pelamar</span>
                                        <span><i class="fas fa-calendar mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 text-xs rounded-full {{ $job->is_active && $job->deadline > now() ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $job->is_active && $job->deadline > now() ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <a href="{{ route('jobs.edit', $job->id) }}" class="p-2 text-gray-400 hover:text-blue-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-4">Belum ada lowongan</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Pelamar Terbaru</h3>

                    <div class="space-y-4">
                        @forelse($recentApplications ?? [] as $application)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:shadow-md transition">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $application->user->avatar ? asset('uploads/avatars/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&size=40' }}" 
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $application->user->name }}</h4>
                                    <p class="text-sm text-gray-500">Melamar: {{ $application->job->title }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($application->applied_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 text-xs rounded-full 
                                    @if($application->status == 'pending') bg-yellow-100 text-yellow-600
                                    @elseif($application->status == 'reviewed') bg-blue-100 text-blue-600
                                    @elseif($application->status == 'interview') bg-purple-100 text-purple-600
                                    @elseif($application->status == 'accepted') bg-green-100 text-green-600
                                    @elseif($application->status == 'rejected') bg-red-100 text-red-600
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                                <a href="{{ route('applications.download-cv', $application->id) }}" class="p-2 text-gray-400 hover:text-blue-600" title="Download CV">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-4">Belum ada pelamar</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Company Profile Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="text-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl mx-auto flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mt-4">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600">Total Lowongan</span>
                            <span class="font-medium text-gray-900">{{ $stats['total_jobs'] }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Total Pelamar</span>
                            <span class="font-medium text-gray-900">{{ $stats['total_applications'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('jobs.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-plus text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Pasang Lowongan Baru</span>
                        </a>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                               <i class="fas fa-file-alt text-green-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Lihat Semua Pelamar</span>
                        </a>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-chart-bar text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Lihat Statistik</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-cog text-yellow-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium">Edit Profil Perusahaan</span>
                        </a>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-sm p-6 text-white">
                    <i class="fas fa-lightbulb text-3xl mb-3 opacity-75"></i>
                    <h4 class="text-lg font-semibold mb-2">Tips Mendapatkan Kandidat Berkualitas</h4>
                    <p class="text-sm text-blue-100 mb-4">Tulis deskripsi pekerjaan yang detail dan spesifik untuk menarik kandidat yang tepat.</p>
                    <a href="#" class="inline-flex items-center text-sm font-medium text-white hover:underline">
                        Pelajari Lebih Lanjut <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection