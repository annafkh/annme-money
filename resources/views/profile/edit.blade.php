@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gradient-to-b from-indigo-50 via-white to-white min-h-screen">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-2xl font-semibold mb-4">Edit Profil</h1>
        
        <!-- Menampilkan status -->
        @if(session('status'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="text-sm text-gray-600">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2 border rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="text-sm text-gray-600">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 border rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('email')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="text-sm text-gray-600">Password Baru</label>
                <input id="password" type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                       class="w-full px-4 py-2 border rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('password')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="text-sm text-gray-600">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="w-full px-4 py-2 border rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Perbarui Profil
                </button>
            </div>
            <form action="{{ route('profile.destroy') }}" method="POST" class="mt-6">
                @csrf
                @method('DELETE')
            
                <button type="submit" onclick="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')"
                        class="text-red-600 hover:underline text-sm">
                    Hapus Akun
                </button>
            </form>
            
        </form>
    </div>
</div>
@endsection
