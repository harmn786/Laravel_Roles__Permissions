<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User_Edit') }}
            </h2>
            <a href="" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3">
                back</a>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        <div>

                            <label for="text-sm font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" value = "{{ old('name',$user->name) }}" name="name" placeholder="Enter Name" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message}}</p>
                                @enderror
                            </div>
                            <div class="my-3">
                                <input type="text" value = "{{ old('email',$user->email) }}" name="email" placeholder="Enter Email" 
                                class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('email')
                                <p class="text-red-400 font-medium">{{ $message}}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                    
                                    <div class="my-3">
                                        <input type="checkbox" {{ ($hasRoles->contains($role->id)) ? 'checked' : '' }}   id="permission-{{ $role->id }}" name="role[]" value="{{$role->name}}">
                                        <label for="permission-{{ $role->id }}">{{$role->name}}</label>
                                        
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