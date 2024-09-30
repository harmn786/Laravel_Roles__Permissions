
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Article_List') }}
        </h2>
        @can('create articles')
        <a href="{{ route('articles.create') }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3">
            Create</a>
        @endcan
        </div>
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
                                <th class="px-6 py-5 text-left">Title</th>
                                <th class="px-6 py-5 text-left">Description</th>
                                <th class="px-6 py-5 text-left">Author</th>
                                <th class="px-6 py-5 text-left">Created_at</th>
                                <th class="px-6 py-5 text-left">Action</th>
                            </tr>
                        </thead>
                        @if ($articles->isNotEmpty())
                            @foreach ($articles as $article)
                            <tbody class="bg-whie">
                                <tr class="border-b">
                                    <td class="px-6 py-5 text-left">{{ $article->id }}</td>
                                    <td class="px-6 py-5 text-left">{{ $article->title }}</td>
                                    <td class="px-6 py-5 text-left">{{ $article->content }}</td>
                                    <td class="px-6 py-5 text-left">{{ $article->author }}</td>
                                    <td class="px-6 py-5 text-left">{{ \Carbon\Carbon::parse($article->created_at)->format('d M,Y') }}</td>
                                    <td class="px-6 py-5 text-left">
                                        @can('edit articles')
                                        <a href="{{ route("articles.edit",$article->id) }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-3 hover:bg-slate-600"> Edit </a>
                                        @endcan
                                        @can('delete articles')
                                        <a href="javascript:void(0);" onclick="deleteArticle({{ $article->id }})" class="bg-red-700 text-sm text-white rounded-md px-3 py-3 hover:bg-red-600 ml-5"> Delete </a>
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
                {{ $articles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
        function deleteArticle(id){
            if(confirm('Are you want to sure to delete this Article')){
                $.ajax({
                    url: '{{ route("articles.delete") }}',
                    type: 'delete',
                    data: {id: id},
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response){
                        window.location.href = '{{ route("articles.show") }}';
                    } 
                });
            }
        }
        </script>
    </x-slot>
</x-app-layout>