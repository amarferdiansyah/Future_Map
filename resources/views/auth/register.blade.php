@extends('layouts.app')

@section('title', 'Daftar - FutureMap')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Gradient Background dengan Gambar -->
    <div class="hidden lg:flex lg:w-1/2 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3')] bg-cover bg-center mix-blend-overlay"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center w-full h-full px-12 text-white">
            <div class="max-w-md">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600">F</span>
                    </div>
                    <span class="text-2xl font-bold">FutureMap</span>
                </div>
                
                <h1 class="text-4xl font-bold mb-6">Mulai Perjalanan Karirmu!</h1>
                <p class="text-xl text-blue-100 mb-8">Bergabung dengan ribuan mahasiswa dan perusahaan terbaik di Indonesia.</p>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <p class="text-sm">Akses ribuan lowongan kerja dan magang</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <p class="text-sm">Ikuti webinar dan workshop eksklusif</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <p class="text-sm">Dapatkan rekomendasi karir personalized</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <p class="text-sm">Bangun jaringan dengan profesional</p>
                    </div>
                </div>

                <!-- Testimoni Singkat -->
                <div class="mt-12 p-6 bg-white bg-opacity-10 rounded-2xl backdrop-blur-sm">
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-300">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-sm italic mb-3">"Berkat FutureMap, saya berhasil mendapatkan pekerjaan impian di perusahaan teknologi ternama. Fitur job matching-nya sangat membantu!"</p>
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&size=32&background=FFFFFF&color=667eea" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-sm font-medium">Budi Santoso</span>
                        <span class="text-xs text-blue-200 ml-2">- Alumni Teknik Informatika</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Side - Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 overflow-y-auto" style="max-height: 100vh;">
        <div class="max-w-md w-full py-8">
            <div class="text-center lg:text-left mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                <p class="text-gray-600 mt-2">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk</a></p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sebagai</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-user-tag"></i>
                        </span>
                        <select name="role" required 
                                class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                            <option value="">Pilih peran</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="alumni" {{ old('role') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Perusahaan</option>
                        </select>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- NIM (untuk mahasiswa/alumni) - Muncul dengan animasi -->
                <div id="nim-field" style="{{ old('role') == 'mahasiswa' || old('role') == 'alumni' ? '' : 'display: none;' }}" class="transition-all duration-300">
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input type="text" name="nim" value="{{ old('nim') }}"
                               class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan NIM">
                    </div>
                </div>
                
                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePassword('password', 'password-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Ulangi password">
                        <button type="button" onclick="togglePassword('password_confirmation', 'confirm-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="confirm-icon"></i>
                        </button>
                    </div>
                </div>

                @error('password')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Password Strength Indicator -->
                <div id="password-strength" class="hidden">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-500">Kekuatan Password:</span>
                        <span id="strength-text" class="text-xs font-medium"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div id="strength-bar" class="h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Terms -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-600">
                            Saya menyetujui 
                            <a href="#" class="text-blue-600 font-medium hover:underline">Syarat & Ketentuan</a>
                            dan 
                            <a href="#" class="text-blue-600 font-medium hover:underline">Kebijakan Privasi</a>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="w-full gradient-bg text-white py-3 px-4 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>
            
            <!-- Social Register -->
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau daftar dengan</span>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition transform hover:-translate-y-0.5">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        Google
                    </a>
                    <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition transform hover:-translate-y-0.5">
                        <i class="fab fa-github text-gray-800 mr-2"></i>
                        GitHub
                    </a>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400">
                    Dengan mendaftar, Anda setuju untuk menerima email tentang update karir dan event dari FutureMap.
                    Anda dapat berhenti berlangganan kapan saja.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(fieldId, iconId) {
    const password = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Toggle NIM field based on role
document.querySelector('select[name="role"]').addEventListener('change', function() {
    const nimField = document.getElementById('nim-field');
    if (this.value === 'mahasiswa' || this.value === 'alumni') {
        nimField.style.display = 'block';
        nimField.classList.add('animate-fade-in');
    } else {
        nimField.style.display = 'none';
    }
});

// Password strength checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthDiv = document.getElementById('password-strength');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    if (password.length > 0) {
        strengthDiv.classList.remove('hidden');
        
        // Calculate strength
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 15;
        
        // Character variety checks
        if (password.match(/[a-z]/)) strength += 15;
        if (password.match(/[A-Z]/)) strength += 15;
        if (password.match(/[0-9]/)) strength += 15;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 15;
        
        // Cap at 100
        strength = Math.min(strength, 100);
        
        // Update bar
        strengthBar.style.width = strength + '%';
        
        // Update color and text
        if (strength < 40) {
            strengthBar.className = 'h-1.5 rounded-full bg-red-500';
            strengthText.textContent = 'Lemah';
            strengthText.className = 'text-xs font-medium text-red-500';
        } else if (strength < 70) {
            strengthBar.className = 'h-1.5 rounded-full bg-yellow-500';
            strengthText.textContent = 'Sedang';
            strengthText.className = 'text-xs font-medium text-yellow-500';
        } else {
            strengthBar.className = 'h-1.5 rounded-full bg-green-500';
            strengthText.textContent = 'Kuat';
            strengthText.className = 'text-xs font-medium text-green-500';
        }
    } else {
        strengthDiv.classList.add('hidden');
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const terms = document.getElementById('terms').checked;
    
    if (password !== confirm) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak cocok!');
        return;
    }
    
    if (!terms) {
        e.preventDefault();
        alert('Anda harus menyetujui Syarat & Ketentuan');
        return;
    }
});
</script>

<style>
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

/* Custom scrollbar untuk form yang panjang */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}
</style>
@endsection