@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-teal-700">➕ Tambah Goal Baru</h1>

    <form action="{{ route('goals.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-md space-y-5" onsubmit="formatAndSubmit()">
        @csrf

        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Goal</label>
            <input type="text" name="title" id="title"
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500"
                placeholder="Contoh: Beli Rumah 1M" required>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500"
                placeholder="Contoh: Menabung untuk beli rumah di Kediri..."></textarea>
        </div>

        <div>
            <label for="target" class="block text-sm font-semibold text-gray-700 mb-1">Target Nominal</label>
            <input type="text" name="target" id="target"
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500"
                placeholder="Contoh: 10.000.000" required min="1">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-teal-600 text-white px-6 py-2 rounded-xl hover:bg-teal-700 transition duration-300">
                Simpan Goal
            </button>
        </div>
    </form>
</div>

<script>
    const targetInput = document.getElementById('target');

    // Function to format input as Rupiah
    function formatRupiah(angka, prefix = 'Rp ') {
        let number_string = angka.replace(/[^,\d]/g, '').toString();
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        if (split[1] != undefined) {
            rupiah = rupiah + ',' + split[1];
        }

        return prefix + rupiah;
    }

    targetInput.addEventListener('keyup', function(e) {
        e.target.value = formatRupiah(this.value);
    });

    // Function to remove 'Rp' and '.' before submitting the form
    function formatAndSubmit() {
        // Remove 'Rp' and '.' characters before submitting
        const targetValue = targetInput.value.replace(/[^0-9]/g, '');
        targetInput.value = targetValue;
    }

    // Set initial value to formatted Rupiah if there's any preset value
    if (targetInput.value) {
        targetInput.value = formatRupiah(targetInput.value);
    }
</script>

@endsection
