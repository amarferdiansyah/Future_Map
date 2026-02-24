@extends('layouts.app')

@section('title', $scholarship->name . ' - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('scholarships.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Beasiswa
            </a>
        </div>

        <!-- Scholarship Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="h-48 bg-gradient-to-r from-green-600 to-teal-600 relative">
                <div class="absolute top-6 right-6 bg-white px-4 py-2 rounded-full text-sm font-medium text-green-600">
                    {{ ucfirst($scholarship->type) }}
                </div>
                <div class="absolute bottom-6 left-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $scholarship->name }}</h1>
                    <p class="text-green-100">{{ $scholarship->provider }}</p>
                </div>
            </div>
        </div>

        <!-- Scholarship Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Beasiswa</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($scholarship->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Persyaratan</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($scholarship->requirements)) !!}
                    </div>
                </div>

                <!-- How to Apply -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Cara Mendaftar</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">1</div>
                            <div>
                                <p class="text-gray-700">Siapkan dokumen persyaratan (CV, transkrip, surat rekomendasi)</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">2</div>
                            <div>
                                <p class="text-gray-700">Buat akun di portal pendaftaran</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">3</div>
                            <div>
                                <p class="text-gray-700">Isi formulir pendaftaran dan upload dokumen</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">4</div>
                            <div>
                                <p class="text-gray-700">Submit sebelum deadline</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Beasiswa</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 text-green-600">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Penyelenggara</p>
                                <p class="font-medium text-gray-900">{{ $scholarship->provider }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 text-green-600">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tipe Beasiswa</p>
                                <p class="font-medium text-gray-900">{{ ucfirst($scholarship->type) }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 text-green-600">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jenjang</p>
                                <p class="font-medium text-gray-900">{{ ucfirst($scholarship->level) }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 text-green-600">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Deadline</p>
                                <p class="font-medium {{ now() > $scholarship->deadline ? 'text-red-600' : 'text-green-600' }}">
                                    {{ \Carbon\Carbon::parse($scholarship->deadline)->format('d F Y') }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($scholarship->deadline)->diffForHumans() }}</p>
                            </div>
                        </div>

                        @if($scholarship->amount)
                        <div class="flex items-start">
                            <div class="w-8 text-green-600">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nominal Beasiswa</p>
                                <p class="font-semibold text-green-600">Rp {{ number_format($scholarship->amount) }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    @if($scholarship->link)
                    <a href="{{ $scholarship->link }}" target="_blank" 
                       class="w-full inline-flex items-center justify-center px-6 py-4 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition mb-3">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Kunjungi Website Resmi
                    </a>
                    @endif
                    
                    <button onclick="window.print()" 
                            class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition">
                        <i class="fas fa-print mr-2"></i>
                        Cetak Informasi
                    </button>
                </div>

                <!-- Share Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Beasiswa</h3>
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

        <!-- Related Scholarships -->
        @if($relatedScholarships->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Beasiswa Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedScholarships as $related)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 card-hover">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $related->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $related->provider }}</p>
                    <p class="text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($related->deadline)->format('d M Y') }}
                    </p>
                    <a href="{{ route('scholarships.show', $related->id) }}" class="text-sm font-medium text-green-600 hover:text-green-800">
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