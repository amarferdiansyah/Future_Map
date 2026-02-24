@extends('layouts.app')

@section('title', $job->title . ' - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Lowongan
            </a>
        </div>

        <!-- Job Detail Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="p-8 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($job->company->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-600 mt-1">{{ $job->company->name }}</p>
                            <div class="flex flex-wrap items-center gap-3 mt-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 text-sm rounded-full">{{ ucfirst($job->type) }}</span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">{{ ucfirst($job->work_style) }}</span>
                                @auth
                                @if(isset($matchScore))
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($matchScore >= 80) bg-green-100 text-green-600
                                    @elseif($matchScore >= 60) bg-yellow-100 text-yellow-600
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    Match Score: {{ $matchScore }}%
                                </span>
                                @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    @auth
                    @if(auth()->user()->hasRole(['mahasiswa', 'alumni']) && !$hasApplied)
                    <button onclick="document.getElementById('applyModal').classList.remove('hidden')" 
                            class="mt-4 md:mt-0 px-8 py-4 gradient-bg text-white rounded-xl font-medium hover:shadow-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Lamar Sekarang
                    </button>
                    @elseif($hasApplied)
                    <div class="mt-4 md:mt-0 px-8 py-4 bg-green-100 text-green-600 rounded-xl font-medium">
                        <i class="fas fa-check-circle mr-2"></i>
                        Sudah Dilamar
                    </div>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Quick Info -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-8 bg-gray-50">
                <div class="text-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <p class="text-sm text-gray-500">Lokasi</p>
                    <p class="font-medium text-gray-900">{{ $job->location ?? 'Remote' }}</p>
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-money-bill-alt text-green-600"></i>
                    </div>
                    <p class="text-sm text-gray-500">Gaji</p>
                    @if($job->salary_min && $job->salary_max)
                    <p class="font-medium text-gray-900">Rp {{ number_format($job->salary_min/1000000,1) }} - {{ number_format($job->salary_max/1000000,1) }}jt</p>
                    @else
                    <p class="font-medium text-gray-900">Disebutkan</p>
                    @endif
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-graduation-cap text-purple-600"></i>
                    </div>
                    <p class="text-sm text-gray-500">Jurusan</p>
                    <p class="font-medium text-gray-900">{{ $job->major->name ?? 'Semua Jurusan' }}</p>
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-calendar text-yellow-600"></i>
                    </div>
                    <p class="text-sm text-gray-500">Deadline</p>
                    <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-8">
                <!-- Skills -->
                @if($job->skills->count() > 0)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Skill yang Dibutuhkan</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($job->skills as $skill)
                        <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium">
                            {{ $skill->name }}
                            @if($skill->pivot->importance_level > 3)
                            <span class="ml-1 text-xs">★</span>
                            @endif
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Pekerjaan</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Kualifikasi</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>

                <!-- Benefits -->
                @if($job->benefits)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Benefit</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($job->benefits)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Jobs -->
        @if($relatedJobs->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Lowongan Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedJobs as $related)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 card-hover">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $related->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $related->company->name }}</p>
                    <p class="text-sm text-gray-500 mb-4">
                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $related->location ?? 'Remote' }}
                    </p>
                    <a href="{{ route('jobs.show', $related->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Apply Modal -->
<div id="applyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl max-w-lg w-full mx-4">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Lamar Pekerjaan</h3>
                <button onclick="document.getElementById('applyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload CV</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-1">Drag & drop atau klik untuk upload</p>
                    <p class="text-xs text-gray-400 mb-3">PDF, DOC, DOCX (Maks. 2MB)</p>
                    <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" required class="hidden">
                    <button type="button" onclick="document.getElementById('cv').click()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                        Pilih File
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cover Letter (Opsional)</label>
                <textarea name="cover_letter" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                          placeholder="Tuliskan motivasi dan alasan Anda melamar..."></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                    Kirim Lamaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('cv').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        alert('File ' + fileName + ' siap diupload');
    }
});
</script>
@endsection