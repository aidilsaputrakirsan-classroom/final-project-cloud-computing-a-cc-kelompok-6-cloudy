<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Categories</h2>
    </x-slot>

    <div class="p-6 space-y-4">
        @if (session('success'))
            <div class="rounded bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
        @endif

        <a href="{{ route('categories.create') }}"
           class="rounded bg-blue-600 px-4 py-2 text-white">+ New Category</a>

        <div class="overflow-x-auto">
            <table class="min-w-full border mt-3">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left">#</th>
                        <th class="p-2 text-left">Name</th>
                        <th class="p-2 text-left">Slug</th>
                        <th class="p-2 text-left">Active</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($categories as $i => $c)
                    <tr class="border-t">
                        <td class="p-2">{{ $categories->firstItem() + $i }}</td>
                        <td class="p-2">{{ $c->name }}</td>
                        <td class="p-2 text-gray-500">{{ $c->slug }}</td>
                        <td class="p-2">
                            <span class="rounded px-2 py-1 text-xs {{ $c->is_active ? 'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">
                                {{ $c->is_active ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('categories.edit',$c) }}" class="text-blue-600 underline">Edit</a>
                            <form action="{{ route('categories.destroy',$c) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-4 text-center text-gray-500">No data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $categories->links() }}</div>
    </div>
</x-app-layout>
