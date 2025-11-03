<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Category</h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input name="name" value="{{ old('name', $category->name) }}" class="mt-1 w-full rounded border p-2">
                @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" class="mt-1 w-full rounded border p-2">{{ old('description', $category->description) }}</textarea>
                @error('description') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                <span>Active</span>
            </label>

            <div class="flex gap-2">
                <button class="rounded bg-blue-600 px-4 py-2 text-white">Update</button>
                <a href="{{ route('categories.index') }}" class="rounded bg-gray-200 px-4 py-2">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
