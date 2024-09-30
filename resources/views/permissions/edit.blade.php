<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions_Edit') }}
            </h2>
            <a href="{{ route('permissions.show') }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3">
                back</a>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permissions.update',$permission->id) }}" method="post">
                        @csrf
                        <div>

                            <label for="text-sm font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" value="{{ old('name',$permission->name) }}"  name="name" placeholder="Enter Name" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
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