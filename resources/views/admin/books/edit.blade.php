<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <!-- Header section with Title and Add Button -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-bold text-gray-900">Edit Book</h4>
                    <a href="{{ url('books') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        Back
                    </a>
                </div>

                <!-- Styled Tailwind Responsive Table -->
                <div class="overflow-x-auto">
                    <form action="{{route('admin.books.update', $book->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="image">Cover</label>
                            <input type="file" name="image" id="image">
                            @error('image')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label >Title</label>
                            <input type="text" name="title" value="{{$book->title}}">
                            @error('title')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label for="author_id">Author</label>
                            <select name="author_id" id="author_id">
                                @foreach($authors as $author)
                                    <!-- FIXED: Added 'selected' attribute check so it reflects the book's current author -->
                                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Isbn</label>
                            <input type="number" name="isbn" value="{{$book->isbn}}">
                            @error('isbn')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label>Quantity</label>
                            <input type="number" name="quantity" value="{{$book->quantity}}">
                            @error('quantity')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id">
                                <!-- FIXED: Changed variable name to singular $category to prevent collision -->
                                @foreach($categories as $category)
                                    <!-- FIXED: Added 'selected' attribute check for current category state -->
                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Status</label>
                            <!-- FIXED: Tied checking state to database value (assuming 1 is visible, 0 is hidden) -->
                            <input type="checkbox" name="status" value="1" {{ $book->status == 1 ? 'checked' : '' }}> checked=visible unchecked=not visible
                            @error('status')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update book</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
