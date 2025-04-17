@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-red-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
    </svg>
    Pengeluaran
</h1>

<div class="space-y-4">
    @if($expenses->isEmpty())
        <div class="text-center text-gray-400 mt-20 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6M15 14l-6-6" />
            </svg>
            <p class="text-lg font-semibold text-gray-600">Belum ada Pengeluaran</p>
            <p class="mt-1 text-sm text-gray-500">Ingat jangan boros-boros!</p>
            <a href="{{ route('expense.create') }}"
               class="mt-4 bg-red-500 text-white px-6 py-3 rounded-xl hover:bg-red-600 transition duration-300">
                + Tambah Pengeluaran
            </a>
        </div>
    @else
        <a href="{{ route('expense.create') }}" class="bg-red-500 text-white px-6 py-3 rounded-xl hover:bg-red-600 transition duration-300 inline-block mb-4">
            + Tambah
        </a>

        @foreach($expenses as $expense)
            <div class="bg-white shadow-md p-4 rounded-lg flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $expense->title }}</p>
                    <p class="text-gray-500 text-sm">{{ $expense->date }}</p>
                </div>
                <div class="text-red-600 font-bold">Rp {{ number_format($expense->amount, 0, ',', '.') }}</div>
            </div>
        @endforeach
    @endif
</div>
@endsection
