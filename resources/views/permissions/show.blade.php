
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions_List') }}
        </h2>
        @can('create permissions')
        <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3">
            Create</a>
        </div>
        @endcan
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr class="border-b">
                                <th class="px-6 py-5 text-left">#</th>
                                <th class="px-6 py-5 text-left">Name</th>
                                <th class="px-6 py-5 text-left">Created_at</th>
                                <th class="px-6 py-5 text-left">Action</th>
                            </tr>
                        </thead>
                        @if ($permissions->isNotEmpty())
                            @foreach ($permissions as $permission)
                            <tbody class="bg-whie">
                                <tr class="border-b">
                                    <td class="px-6 py-5 text-left">{{ $permission->id }}</td>
                                    <td class="px-6 py-5 text-left">{{ $permission->name }}</td>
                                    <td class="px-6 py-5 text-left">{{ \Carbon\Carbon::parse($permission->created_at)->format('d M,Y') }}</td>
                                    <td class="px-6 py-5 text-left">
                                        @can('edit permissions')
                                        <a href="{{ route("permissions.edit",$permission->id) }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3 hover:bg-slate-600"> Edit </a> 
                                        @endcan
                                        @can('delete permissions')
                                        <a href="javascript:void(0);" onclick="deletePermission({{ $permission->id }})" class="bg-red-700 text-sm text-white rounded-md px-3 py-3 hover:bg-red-600 ml-5"> Delete </a>
                                        @endcan
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
            <div class="my-3">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
        function deletePermission(id){
            if(confirm('Are you want to sure to delete this permission')){
                $.ajax({
                    url: '{{ route("permissions.delete") }}',
                    type: 'delete',
                    data: {id: id},
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response){
                        window.location.href = '{{ route("permissions.show") }}';
                    } 
                });
            }
        }
        </script>
    </x-slot>
</x-app-layout>