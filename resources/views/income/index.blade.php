@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6 text-green-600 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20,15c.552,0,1,.448,1,1s-.448,1-1,1-1-.448-1-1,.448-1,1-1Zm3.665-5.75c-.139-.24-.447-.322-.683-.183-.239,.138-.321,.444-.183,.683,.131,.227,.2,.486,.2,.75v11c0,.827-.673,1.5-1.5,1.5H4.5c-1.93,0-3.5-1.57-3.5-3.5V8.5c0-.349,.067-.679,.162-.997,.845,.935,2.053,1.497,3.338,1.497H15c.276,0,.5-.224,.5-.5s-.224-.5-.5-.5H4.5c-1.145,0-2.214-.571-2.864-1.5,.633-.904,1.679-1.5,2.864-1.5H13.5c.276,0,.5-.224,.5-.5s-.224-.5-.5-.5H4.5c-2.498-.004-4.482,2.074-4.5,4.5v11c0,2.481,2.019,4.5,4.5,4.5H21.5c1.379,0,2.5-1.121,2.5-2.5V10.5c0-.439-.116-.872-.335-1.25Zm-5.245-.695c.585,.563,1.528,.562,2.114,.007l2.812-2.701c.199-.191,.205-.508,.014-.707-.191-.2-.507-.204-.707-.015l-2.653,2.549V.5c0-.276-.224-.5-.5-.5s-.5,.224-.5,.5V7.724l-2.651-2.582c-.195-.191-.512-.188-.707,.01-.192,.198-.188,.514,.01,.707l2.769,2.696Z" />
        </svg>
        Pemasukan
    </h1>

    <!-- Add Button -->
    <div class="flex justify-end items-center mb-4">
        <a href="{{ route('income.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 transition duration-300">
            + Tambah
        </a>
    </div>

    <!-- Income List -->
    <div class="space-y-6">
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
            @foreach($incomes as $income)
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $income->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $income->description ?? '-' }}</p>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-400">{{ $income->date }}</p>
                            <p class="text-lg font-bold text-green-600">Rp {{ number_format($income->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Edit & Delete -->
                    <div class="flex justify-end items-center space-x-2 mt-4">
                        <form action="{{ route('income.edit', $income->id) }}" method="GET">
                            <button type="submit"
                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('income.destroy', $income->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus pemasukan ini?');"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 text-sm text-white bg-red-500 rounded-lg hover:bg-red-600">
                                Hapus
                            </button>
                        </form>  
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
