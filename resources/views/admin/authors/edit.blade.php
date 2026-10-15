<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <!-- Header section with Title and Add Button -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-bold text-gray-900">Edit Author</h4>
                    <a href="{{ url('authors') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        Back
                    </a>
                </div>

                <!-- Styled Tailwind Responsive Table -->
                <div class="overflow-x-auto">
                    <form action="{{route('admin.authors.update', $author->id)}}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Cover Image</label>
                            
                            <!-- 1. Show the CURRENT image if it exists -->
                            @if($author->image)
                                <div class="my-2">
                                    <p class="text-xs text-gray-500 mb-1">Current Image:</p>
                                    <img src="{{ asset('storage/' . $author->image) }}" alt="Current Cover" class="w-20 h-20 object-cover rounded border">
                                </div>
                            @endif

                            <!-- 2. The input to upload a NEW image -->
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500">
                            
                            @error('image')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="">Name</label>
                            <input type="text" name="name" value="{{$author->name}}">
                            @error('name')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label for="">Bio</label>
                            <textarea type="text" name="bio">{{!! $author->bio !!}}</textarea>
                            @error('bio')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label for="">Status</label>
                            <input type="checkbox" name="status" {{$author->status == 1 ? 'Active':'notActive'}} checked>
                            @error('status')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <button type="submit">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
