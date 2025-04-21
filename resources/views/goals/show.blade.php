@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold mb-6 text-teal-700">{{ $goal->title }}</h1>

    <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Deskripsi</h2>
        <p class="text-sm text-gray-500 mt-2">{{ $goal->description }}</p>
        <p class="mt-4 text-sm text-gray-400">Target: Rp {{ number_format($goal->target, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-400">Progress: Rp {{ number_format($goal->progress, 0, ',', '.') }}</p>

        @if ($goal->progress >= $goal->target)
        <span class="inline-block px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full mt-4">
            🎉 Goal Tercapai!
        </span>
        @endif
    </div>

    <!-- Form Transaksi Baru -->
    <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
        <h2 class="text-2xl font-semibold text-teal-700 mb-4">Tambah Transaksi</h2>
        <form action="{{ route('goals.storeTransaction', $goal->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Transaksi</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-teal-500 focus:border-teal-500" required>
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="amount" id="amount" class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-teal-500 focus:border-teal-500" required>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="date" id="date" class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-teal-500 focus:border-teal-500" required>
            </div>

            <button type="submit" class="bg-teal-600 text-white py-2 px-6 rounded-xl hover:bg-teal-700 transition duration-300">
                Tambah Transaksi
            </button>
        </form>
    </div>

    <!-- Riwayat Transaksi -->
    <h2 class="text-2xl font-semibold text-teal-700 mb-4">Riwayat Transaksi</h2>

    <div class="space-y-4">
        @if ($transactions->isEmpty())
        <div class="text-center text-gray-400 mt-20">
            <p class="text-lg font-semibold">Belum ada transaksi 😢</p>
        </div>
        @else
            @foreach ($transactions as $transaction)
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $transaction->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Tanggal: {{ $transaction->date }}</p>
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-bold text-green-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

</div>
@endsection