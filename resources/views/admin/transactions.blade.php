<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Borrowing Management & Transactions') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl text-xs font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Section 1: Requests to Borrow (Pending) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Requests to Borrow
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">{{ count($requests) }} Requests</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($requests as $req)
                        <div class="p-4 rounded-xl bg-amber-50/40 border border-amber-200/60 flex justify-between flex-col space-y-3">
                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-[10px] text-slate-400 font-mono">
                                    <span>RFID: {{ $req->rfid_uid ?? 'N/A' }}</span>
                                    <span>{{ $req->created_at->format('m/d/Y') }}</span>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $req->book->title }}</h4>
                                <p class="text-xs text-slate-600">Student: <strong>{{ $req->user->name }}</strong></p>
                            </div>
                            <div class="flex gap-2 pt-2 border-t border-amber-100">
                                <form method="POST" action="{{ route('admin.borrows.approve', $req->id) }}" class="w-1/2">
                                    @csrf
                                    <button class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition shadow-sm">
                                        Accept
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.borrows.deny', $req->id) }}" class="w-1/2">
                                    @csrf
                                    <button class="w-full py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg transition shadow-sm">
                                        Deny
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-xs text-slate-400 italic">No borrow requests awaiting action.</div>
                    @endforelse
                </div>
            </div>

            <!-- Section 2: Unborrowed (Returned / Cancelled / In Stock) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Unborrowed / Returned History
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">{{ count($unborrowed) }} Items</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($unborrowed as $unb)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 text-xs space-y-1">
                            <span class="text-[10px] font-mono text-slate-400 uppercase">Status: {{ $unb->status }}</span>
                            <h4 class="font-bold text-slate-800 line-clamp-1">{{ $unb->book->title }}</h4>
                            <p class="text-slate-500 text-[11px]">{{ $unb->user->name }}</p>
                        </div>
                    @empty
                        <div class="col-span-full py-4 text-center text-xs text-slate-400 italic">No historical records available.</div>
                    @endforelse
                </div>
            </div>

            <!-- Section 3: Borrowed (Active Loans) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Borrowed Books (On Loan)
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">{{ count($borrowed) }} Active</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($borrowed as $bor)
                        <div class="p-4 rounded-xl bg-sky-50/40 border border-sky-200/60 flex justify-between flex-col space-y-3">
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] text-slate-400 font-mono">
                                    <span>Borrowed: {{ optional($bor->borrowed_at)->format('m/d/Y') }}</span>
                                    <span>Due: {{ optional($bor->due_at)->format('m/d/Y') }}</span>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $bor->book->title }}</h4>
                                <p class="text-xs text-slate-600">Borrower: <strong>{{ $bor->user->name }}</strong></p>
                            </div>
                            <form method="POST" action="{{ route('admin.borrows.return', $bor->id) }}" class="pt-2 border-t border-sky-100">
                                @csrf
                                <button class="w-full py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-lg transition shadow-sm">
                                    Mark as Returned
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-xs text-slate-400 italic">No books currently borrowed.</div>
                    @endforelse
                </div>
            </div>

            <!-- Section 4: Overdue Books -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4 border-l-4 border-l-red-500">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-red-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span> Overdue Books
                    </h3>
                    <span class="text-xs font-semibold text-red-500">{{ count($overdue) }} Overdue</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($overdue as $ovd)
                        <div class="p-4 rounded-xl bg-red-50/60 border border-red-200 flex justify-between flex-col space-y-3">
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] text-red-500 font-mono font-bold">
                                    <span>Due Date Passed: {{ optional($ovd->due_at)->format('m/d/Y') }}</span>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $ovd->book->title }}</h4>
                                <p class="text-xs text-slate-600">Student: <strong>{{ $ovd->user->name }}</strong></p>
                                <div class="mt-2 text-xs font-bold text-red-700 bg-red-100 p-1.5 rounded-md text-center">
                                    Fine Accrued: ₱{{ number_format($ovd->fine_amount ?? 0, 2) }}
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.borrows.return', $ovd->id) }}" class="pt-2 border-t border-red-200">
                                @csrf
                                <button class="w-full py-1.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-lg transition shadow-sm">
                                    Collect Fine & Mark Returned
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-xs text-slate-400 italic">No overdue items detected.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>