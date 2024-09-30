
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles_Edit') }}
            </h2>
            <a href="{{ route('articles.show') }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3">
                back</a>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.update',$article->id) }}" method="post">
                        @csrf
                        <div>

                            <label for="text-sm font-medium">Title</label>
                            <div class="my-3">
                                <input type="text" value="{{ old('title',$article->title) }}" name="title" placeholder="Enter Title" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium">{{ $message}}</p>
                                @enderror
                            </div>
                            <label for="text-sm font-medium">Description</label>
                            <div class="my-3">
                                <textarea type="text" value="{{ old('content',$article->content) }}" name="content" placeholder="Enter Description" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg" >{{$article->content}}</textarea>
                            </div>
                            <label for="text-sm font-medium">Author</label>
                            <div class="my-3">
                                <input type="text" value="{{ old('author',$article->author) }}" name="author" placeholder="Enter Author Name" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('author')
                                <p class="text-red-400 font-medium">{{ $message}}</p>
                                @enderror
                            </div>

                            <button type="submit" class="bg-slate-700 text-sm text-white rounded-md px-5 py-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

