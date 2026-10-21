<x-app-layout>
    <div class="max-w-2xl mx-auto my-8 bg-white p-8 rounded-2xl shadow-lg border border-slate-200"
         x-data="{
             selectedBookId: '{{ request('book_id', '') }}',
             books: {{ $books->keyBy('id')->toJson() }},
             currentBook: {},
             init() {
                 if (this.selectedBookId && this.books[this.selectedBookId]) {
                     this.currentBook = this.books[this.selectedBookId];
                 }
             },
             updateBookDetails() {
                 this.currentBook = this.books[this.selectedBookId] || {};
             }
         }">

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-2">
                <span class="text-xl"></span>
            </div>
            <h2 class="text-2xl font-bold text-red-800">Borrow Form</h2>
            <p class="text-xs text-slate-500 mt-1">Select a book to initiate a borrowing request.</p>
        </div>

        <!-- Session Messages -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-lg text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('borrow.store') }}" class="space-y-4">
            @csrf

            <!-- Book Selection -->
            <div>
                <label for="book_id" class="block text-xs font-bold text-red-900 mb-1">Book Title</label>
                <select name="book_id" id="book_id" required
                        x-model="selectedBookId"
                        @change="updateBookDetails()"
                        class="w-full rounded-lg border-slate-300 bg-white text-slate-700 text-sm p-2.5 focus:ring-red-800 focus:border-red-800">
                    <option value="">-- Choose a Book --</option>
                    <template x-for="book in Object.values(books)" :key="book.id">
                        <option :value="book.id" :selected="book.id == selectedBookId" x-text="book.title"></option>
                    </template>
                </select>
            </div>

            <!-- Auto-populated Author -->
            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">Author</label>
                <input type="text" :value="currentBook.author ? currentBook.author.name : 'N/A'" readonly 
                       class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">
            </div>

            <!-- Auto-populated Description -->
            <div>
                <label class="block text-xs font-bold text-red-900 mb-1">
                    Description <span class="italic font-normal text-slate-500"></span>
                </label>
                <textarea readonly rows="3" 
                          x-text="currentBook.description || 'No description available.'"
                          class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5"></textarea>
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
                <label class="block text-xs font-bold text-red-900 mb-1">LRN / RFID</label>
                <input type="text" value="{{ auth()->user()->lrn ?? auth()->user()->rfid_uid ?? 'N/A' }}" readonly 
                       class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-sm p-2.5">
            </div>

            <!-- Functional Dates Section -->
            @php
                $today = \Carbon\Carbon::now();
                $expectedReturn = \Carbon\Carbon::now()->addDays(7); // Default 7-day loan window
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-2">
                <div>
                    <label class="block text-xs font-bold text-red-900 mb-1">Date Borrowed</label>
                    <input type="text" value="{{ $today->format('F d, Y') }}" readonly 
                           class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-xs p-2.5 text-center">
                </div>

                <div>
                    <label class="block text-xs font-bold text-red-900 mb-1">Expected Return</label>
                    <input type="text" value="{{ $expectedReturn->format('F d, Y') }}" readonly 
                           class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-xs p-2.5 text-center">
                </div>

                <div>
                    <label class="block text-xs font-bold text-red-900 mb-1">Date Returned</label>
                    <input type="text" value="Pending Return" readonly 
                           class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-700 text-xs p-2.5 text-center italic text-slate-400">
                </div>
            </div>

            <!-- Submit Action -->
            <div class="text-center pt-6">
                <button type="submit" 
                        :disabled="!selectedBookId"
                        :class="selectedBookId ? 'bg-amber-400 hover:bg-amber-500 cursor-pointer' : 'bg-slate-300 cursor-not-allowed'"
                        class="px-8 py-2.5 text-slate-900 font-bold text-sm rounded-full shadow border border-amber-500 transition">
                    Submit Borrow Request
                </button>
            </div>
        </form>
    </div>
</x-app-layout>