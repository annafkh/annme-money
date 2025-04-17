@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-green-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Pemasukan
</h1>

<div class="space-y-4">
    @if($incomes->isEmpty())
        <div class="text-center text-gray-400 mt-20 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <p class="text-lg font-semibold text-gray-600">Belum ada Pemasukan</p>
            <p class="mt-1 text-sm text-gray-500">Yok ditambah Yok!</p>
            <a href="{{ route('income.create') }}"
               class="mt-4 bg-green-500 text-white px-6 py-3 rounded-xl hover:bg-green-600 transition duration-300">
                + Tambah Pemasukan
            </a>
        </div>
    @else
        <a href="{{ route('income.create') }}" class="bg-green-500 text-white px-6 py-3 rounded-xl hover:bg-green-600 transition duration-300 inline-block mb-4">
            + Tambah
        </a>

        @foreach($incomes as $income)
            <div class="bg-white shadow-md p-4 rounded-lg flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $income->title }}</p>
                    <p class="text-gray-500 text-sm">{{ $income->date }}</p>
                </div>
                <div class="text-green-600 font-bold">Rp {{ number_format($income->amount, 0, ',', '.') }}</div>
            </div>
        @endforeach
    @endif
</div>
@endsection