<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3">
                back</a>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        @csrf
                        <div>

                            <label for="text-sm font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" value = "{{ old('name',$role->name) }}" name="name" placeholder="Enter Name" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message}}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4">
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                    <div class="my-3">
                                        <input type="checkbox"  {{ ($hasPermissions->contains($permission->name)) ? 'checked' : '' }} id="permission-{{ $permission->id }}" name="permission[]" value="{{$permission->name}}">
                                        <label for="permission-{{ $permission->id }}">{{$permission->name}}</label>
                                        
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="submit" class="bg-slate-700 text-sm text-white rounded-md px-5 py-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>