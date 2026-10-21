<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Admin Library Overview') }}
            </h2>
            <a href="{{ route('admin.transactions') }}" 
               class="px-4 py-2 bg-red-900 hover:bg-red-800 text-amber-300 font-semibold text-xs rounded-lg shadow transition">
                Manage Borrow Transactions &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Summary Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card 1: Available Books (Excludes borrowed & overdue) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                            Available Books
                        </span>
                        <div class="p-2.5 bg-emerald-100 rounded-xl text-emerald-700 text-lg"></div>
                    </div>
                    <div class="text-3xl font-black text-slate-900">{{ $availableBooksCount ?? 0 }}</div>
                    <p class="text-xs text-slate-500 mt-2">Physical stock ready on shelves for checkout.</p>
                </div>

                <!-- Card 2: Currently Borrowed -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 bg-sky-50 px-2.5 py-1 rounded-md border border-sky-100">
                            Borrowed Books
                        </span>
                        <div class="p-2.5 bg-sky-100 rounded-xl text-sky-700 text-lg"></div>
                    </div>
                    <div class="text-3xl font-black text-slate-900">{{ $borrowedBooksCount ?? 0 }}</div>
                    <p class="text-xs text-slate-500 mt-2">Active loans within approved lending window.</p>
                </div>

                <!-- Card 3: Overdue Books -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 px-2.5 py-1 rounded-md border border-red-100">
                            Overdue Books
                        </span>
                        <div class="p-2.5 bg-red-100 rounded-xl text-red-700 text-lg"></div>
                    </div>
                    <div class="text-3xl font-black text-red-600">{{ $overdueBooksCount ?? 0 }}</div>
                    <p class="text-xs text-slate-500 mt-2">Past expected return date with daily fines accrued.</p>
                </div>

            </div>

            

        </div>
    </div>
</x-app-layout>