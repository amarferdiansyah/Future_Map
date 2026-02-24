@extends('layouts.app')

@section('title', 'Lamaran Saya - FutureMap')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Lamaran Saya</h1>
            <p class="mt-1 text-sm text-gray-500">
                Daftar lamaran pekerjaan yang telah Anda kirim
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>
                Cari Lowongan Lain
            </a>
        </div>
    </div>

    <!-- Applications List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($applications->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($applications as $application)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-medium text-blue-600 truncate">
                                            <a href="{{ route('jobs.show', $application->job->id) }}" class="hover:underline">
                                                {{ $application->job->title }}
                                            </a>
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($application->status == 'reviewed') bg-blue-100 text-blue-800
                                            @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                            @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                            @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                            @endif">
                                            @if($application->status == 'pending')
                                                Menunggu
                                            @elseif($application->status == 'reviewed')
                                                Direview
                                            @elseif($application->status == 'interview')
                                                Interview
                                            @elseif($application->status == 'accepted')
                                                Diterima
                                            @elseif($application->status == 'rejected')
                                                Ditolak
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <div class="mt-2 flex flex-col sm:flex-row sm:flex-wrap sm:space-x-6">
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <i class="fas fa-building mr-1.5"></i>
                                            {{ $application->job->company->name }}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <i class="fas fa-calendar mr-1.5"></i>
                                            Dilamar: {{ \Carbon\Carbon::parse($application->applied_at)->format('d M Y, H:i') }}
                                        </div>
                                        @if($application->match_score)
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                <i class="fas fa-chart-line mr-1.5"></i>
                                                Match Score: 
                                                <span class="ml-1 font-semibold 
                                                    @if($application->match_score >= 80) text-green-600
                                                    @elseif($application->match_score >= 60) text-yellow-600
                                                    @else text-gray-600
                                                    @endif">
                                                    {{ $application->match_score }}%
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @if($application->job->type)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($application->job->type) }}
                                            </span>
                                        @endif
                                        @if($application->job->work_style)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($application->job->work_style) }}
                                            </span>
                                        @endif
                                        @if($application->job->location)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $application->job->location }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="ml-4 flex-shrink-0 flex space-x-2">
                                    <a href="{{ route('jobs.show', $application->job->id) }}" 
                                       class="inline-flex items-center p-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                                       title="Lihat Lowongan">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('applications.download-cv', $application->id) }}" 
                                       class="inline-flex items-center p-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                                       title="Download CV">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>

                            @if($application->notes)
                                <div class="mt-3 p-3 bg-gray-50 rounded-md">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Catatan:</span> {{ $application->notes }}
                                    </p>
                                </div>
                            @endif

                            @if($application->cover_letter)
                                <div class="mt-2">
                                    <details class="text-sm">
                                        <summary class="text-blue-600 cursor-pointer hover:text-blue-800">
                                            Lihat Cover Letter
                                        </summary>
                                        <div class="mt-2 p-3 bg-gray-50 rounded-md whitespace-pre-line">
                                            {{ $application->cover_letter }}
                                        </div>
                                    </details>
                                </div>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-file-alt text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">Belum Ada Lamaran</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Anda belum mengirimkan lamaran pekerjaan apapun.
                </p>
                <div class="mt-6">
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>
                        Cari Lowongan
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Tips Section -->
    <div class="mt-8 bg-blue-50 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-900">Tips Meningkatkan Peluang Diterima</h3>
                <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                    <li>Pastikan profil Anda lengkap, termasuk CV dan portofolio</li>
                    <li>Tambahkan skill yang relevan dengan lowongan yang dilamar</li>
                    <li>Pantau status lamaran secara berkala</li>
                    <li>Persiapkan diri untuk sesi interview jika dipanggil</li>
                    <li>Jangan ragu untuk menghubungi perusahaan jika diperlukan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection