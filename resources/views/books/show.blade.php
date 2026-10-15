<x-app-layout>
    <div class="max-w-2xl mx-auto my-8 bg-white p-8 rounded-2xl shadow-lg border border-slate-200">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-2">
                <span class="text-xl">📚</span>
            </div>
            <h2 class="text-2xl font-bold text-red-800">Book Detail</h2>
        </div>

        <form class="space-y-4">
            <!-- Book Details Section -->
            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">Book Title</label>
                <input type="text" value="{{ $book->title }}" readonly 
                    class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">
            </div>

            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">Author</label>
                <input type="text" value="{{ $book->author?->name ?? 'N/A' }}" readonly 
                    class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">
            </div>

            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">
                    Description <span class="italic font-normal text-slate-500">(Optional)</span>
                </label>
                <textarea readonly rows="3" 
                        class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">{{ $book->description ?? '' }}</textarea>
            </div>

            <hr class="my-6 border-slate-200">

            <!-- Student Information Section -->
            <h3 class="text-lg font-bold text-red-800 mb-4">Student Information</h3>

            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">Name</label>
                <input type="text" value="{{ auth()->user()->name ?? 'N/A' }}" readonly 
                    class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">
            </div>

            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">LRN</label>
                <input type="text" value="{{ auth()->user()->lrn ?? 'N/A' }}" readonly 
                    class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">
            </div>

            <!-- Date Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-2">
                <div>
                    <label class="block text-xs font-bold text-red-900 mb-1">Date Borrowed</label>
                    <input type="text" value="{{ optional($book->latestBorrow)->borrowed_at?->format('F d, Y') ?? 'N/A' }}" readonly 
                        class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-xs p-2.5 text-center">
                </div>

                <div>
                    <label class="block text-xs font-bold text-red-900 mb-1">Expected Return</label>
                    <input type="text" value="{{ optional($book->latestBorrow)->due_at?->format('F d, Y') ?? 'N/A' }}" readonly 
                        class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-xs p-2.5 text-center">
                </div>

                <div>
                    <label class="block text-xs font-bold text-red-900 mb-1">Date Returned</label>
                    <input type="text" value="{{ optional($book->latestBorrow)->returned_at?->format('F d, Y') ?? 'N/A' }}" readonly 
                        class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-xs p-2.5 text-center">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-6">
                <button type="submit" class="px-6 py-2 bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-sm rounded-full shadow border border-amber-500 transition">
                    Borrow Again?
                </button>
            </div>

            @if(isset($transaction) && $transaction?->fine_amount > 0)
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg flex justify-between items-center text-xs">
                    <span class="font-bold text-red-800">Overdue Fine Pending:</span>
                    <span class="font-extrabold text-red-900 text-sm">
                        ₱{{ number_format($transaction->fine_amount, 2) }}
                    </span>
                </div>
            @endif
        </form>
    </div>
</x-app-layout>