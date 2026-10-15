<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Library Inventory Stock Monitoring') }}
            </h2>
            <span class="text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-600 rounded-full border border-slate-200">
                Total Titles Tracked: {{ $books->count() }}
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Information Banner -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Live Stock Status Overview</h3>
                    <p class="text-xs text-slate-500">Real-time view of physical book copies currently available on shelves versus active loans.</p>
                </div>
            </div>

            <!-- Inventory Data Table -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-200">
                            <tr>
                                <th class="p-4 w-16 text-center">Cover</th>
                                <th class="p-4">Title & Author</th>
                                <th class="p-4 text-center">Total Stock</th>
                                <th class="p-4 text-center">Currently Borrowed</th>
                                <th class="p-4 text-center">Available on Shelf</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($books as $book)
                                @php
                                    $borrowed = $book->borrowed_count ?? 0;
                                    $available = max(0, $book->quantity - $borrowed);
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <!-- Book Cover Image Column -->
                                    <td class="p-4 text-center">
                                        @if(!empty($book->image))
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="Cover" class="w-10 h-14 object-cover rounded-md shadow-sm mx-auto border border-slate-200">
                                        @else
                                            <div class="w-10 h-14 bg-slate-100 rounded-md flex items-center justify-center text-[10px] text-slate-400 font-bold mx-auto border border-slate-200">
                                                No Img
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Title & Author Column -->
                                    <td class="p-4">
                                        <div class="font-bold text-slate-800 text-sm">{{ $book->title }}</div>
                                        <div class="text-slate-400 text-[11px]">{{ $book->author }}</div>
                                    </td>

                                    <!-- Total Stock Column -->
                                    <td class="p-4 text-center font-bold text-slate-700">
                                        {{ $book->quantity }}
                                    </td>

                                    <!-- Currently Borrowed Column -->
                                    <td class="p-4 text-center">
                                        <span class="px-2.5 py-1 bg-sky-50 text-sky-700 font-bold rounded-lg border border-sky-100">
                                            {{ $borrowed }}
                                        </span>
                                    </td>

                                    <!-- Available on Shelf Column -->
                                    <td class="p-4 text-center">
                                        <span class="px-2.5 py-1 {{ $available > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' }} font-bold rounded-lg">
                                            {{ $available }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400 italic">No inventory records found in the database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>