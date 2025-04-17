<div class="fixed bottom-0 left-0 right-0 bg-white shadow-md border-t z-50">
    <div class="flex justify-around items-center py-2">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
            </svg>
            <span class="text-xs">Beranda</span>
        </a>

        <a href="{{ route('income.index') }}" class="flex flex-col items-center {{ request()->routeIs('income.*') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3C7.03 3 3 7.03 3 12s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm1 13h-2v-2h2v2zm0-4h-2V7h2v5z"/>
            </svg>
            <span class="text-xs">Pemasukan</span>
        </a>

        <a href="{{ route('expense.index') }}" class="flex flex-col items-center {{ request()->routeIs('expense.*') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
            </svg>
            <span class="text-xs">Pengeluaran</span>
        </a>

        <a href="{{ route('goals.index') }}" class="flex flex-col items-center {{ request()->routeIs('goals.*') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
            </svg>
            <span class="text-xs">Goals</span>
        </a>
    </div>
</div>
