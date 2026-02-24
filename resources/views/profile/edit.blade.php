@extends('layouts.app')

@section('title', 'Profile Saya - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Saya</h1>
            <p class="mt-2 text-gray-600">Kelola informasi pribadi dan preferensi akun Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 sticky top-24">
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <img src="{{ $user->avatar ? (filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset('uploads/avatars/'.$user->avatar)) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=100&background=0D8F81&color=fff' }}" 
                                 class="w-24 h-24 rounded-full mx-auto border-4 border-blue-100 object-cover"
                                 id="profile-avatar">
                            <label for="avatar-input" class="absolute bottom-0 right-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700 transition border-2 border-white">
                                <i class="fas fa-camera text-sm"></i>
                            </label>
                            <form id="avatar-form" action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                <input type="file" name="avatar" id="avatar-input" accept="image/*">
                            </form>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 mt-4">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mt-2">
                            {{ ucfirst($user->getRoleNames()->first()) }}
                        </span>
                    </div>

                    <nav class="space-y-1">
                        <a href="#basic" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ !request()->has('tab') || request()->tab == 'basic' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-user w-5 mr-3"></i>
                            Informasi Dasar
                        </a>
                        <a href="#profile" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->tab == 'profile' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-id-card w-5 mr-3"></i>
                            Data Profil
                        </a>
                        <a href="#skills" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->tab == 'skills' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-code w-5 mr-3"></i>
                            Skill & Keahlian
                        </a>
                        <a href="#password" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->tab == 'password' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-lock w-5 mr-3"></i>
                            Keamanan
                        </a>
                        <a href="#cv" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->tab == 'cv' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-file-pdf w-5 mr-3"></i>
                            CV & Dokumen
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Basic Information -->
                <div id="basic" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Dasar</h3>
                    
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            @if($user->hasRole(['mahasiswa', 'alumni']))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                                <input type="text" name="nim" value="{{ old('nim', $user->nim) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Profile Data -->
                <div id="profile" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Data Profil</h3>
                    
                    <form method="POST" action="{{ route('profile.update-profile') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                                <select name="major_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($majors as $major)
                                    <option value="{{ $major->id }}" {{ $user->profile && $user->profile->major_id == $major->id ? 'selected' : '' }}>
                                        {{ $major->name }} ({{ $major->degree_level }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            @if($user->hasRole('mahasiswa'))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                                <input type="number" name="semester" value="{{ old('semester', $user->profile->semester ?? '') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">IPK</label>
                                <input type="number" step="0.01" name="gpa" value="{{ old('gpa', $user->profile->gpa ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            @endif

                            @if($user->hasRole('alumni'))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lulus</label>
                                <input type="date" name="graduation_date" value="{{ old('graduation_date', $user->profile->graduation_date ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->profile->linkedin_url ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                       placeholder="https://linkedin.com/in/username">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Portfolio URL</label>
                                <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $user->profile->portfolio_url ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                       placeholder="https://github.com/username">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio / Tentang Saya</label>
                            <textarea name="bio" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                Simpan Data Profil
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Skills -->
                <div id="skills" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Skill & Keahlian</h3>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-medium flex items-center">
                            Laravel <i class="fas fa-times ml-2 cursor-pointer hover:text-red-500"></i>
                        </span>
                        <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-medium flex items-center">
                            React <i class="fas fa-times ml-2 cursor-pointer hover:text-red-500"></i>
                        </span>
                        <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-medium flex items-center">
                            JavaScript <i class="fas fa-times ml-2 cursor-pointer hover:text-red-500"></i>
                        </span>
                        <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-medium flex items-center">
                            Python <i class="fas fa-times ml-2 cursor-pointer hover:text-red-500"></i>
                        </span>
                        <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-medium flex items-center">
                            MySQL <i class="fas fa-times ml-2 cursor-pointer hover:text-red-500"></i>
                        </span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="text" placeholder="Tambah skill baru..." 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <button class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                            Tambah
                        </button>
                    </div>
                </div>

                <!-- Change Password -->
                <div id="password" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Ubah Password</h3>
                    
                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="new_password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- CV & Documents -->
                <div id="cv" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">CV & Dokumen</h3>
                    
                    @if($user->profile && $user->profile->cv_path)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">CV.pdf</p>
                                <p class="text-xs text-gray-500">Diupload: {{ \Carbon\Carbon::parse($user->profile->updated_at)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ asset('uploads/cvs/'.$user->profile->cv_path) }}" target="_blank" 
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                                <i class="fas fa-eye mr-2"></i> Lihat
                            </a>
                            <a href="{{ asset('uploads/cvs/'.$user->profile->cv_path) }}" download 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-download mr-2"></i> Download
                            </a>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.upload-cv') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 transition group">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 group-hover:text-blue-500 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Upload CV baru</p>
                            <p class="text-xs text-gray-400 mb-4">Format: PDF, DOC, DOCX (Maks. 2MB)</p>
                            <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" class="hidden">
                            <button type="button" onclick="document.getElementById('cv').click()"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                Pilih File
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-red-200">
                    <h3 class="text-lg font-semibold text-red-600 mb-4">Zona Berbahaya</h3>
                    
                    <p class="text-sm text-gray-600 mb-6">
                        Menghapus akun akan menghilangkan semua data Anda secara permanent. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    
                    <form method="POST" action="{{ route('profile.destroy') }}" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Semua data akan hilang permanent.')">
                        @csrf
                        @method('DELETE')
                        
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus Akun Saya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('avatar-input').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-avatar').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
        document.getElementById('avatar-form').submit();
    }
});
</script>
@endsection