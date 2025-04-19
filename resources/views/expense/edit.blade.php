@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-red-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Edit Pemasukan
</h1>

<form action="{{ route('expense.update', $expense->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    
    <div class="space-y-4 bg-white p-6 rounded-2xl shadow-lg">
        <!-- Input Judul -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title', $expense->title) }}" 
                   class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400" required>
        </div>
    
        <!-- Input Jumlah -->
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}"
                   class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400" required>
        </div>
    
        <!-- Input Tanggal -->
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="date" id="date" value="{{ old('date', $expense->date->toDateString()) }}" 
                   class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400 cursor-pointer" required>
        </div>
    
        <!-- Tombol Simpan -->
        <button type="submit"
                class="w-full bg-red-500 text-white py-3 rounded-xl font-semibold hover:bg-red-600 transition duration-300">
            Simpan Perubahan
        </button>
    </div>    
</form>
@endsection
