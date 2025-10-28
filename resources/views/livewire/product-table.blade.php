<div class="p-4 bg-white shadow rounded-lg">

    <!-- Form Produk -->
    <form wire:submit.prevent="save" class="mb-6 space-y-2">
        <input type="text" wire:model="name" placeholder="Nama Produk" class="border rounded p-2 w-full">
        <textarea wire:model="description" placeholder="Deskripsi" class="border rounded p-2 w-full"></textarea>
        <input type="number" wire:model="price" placeholder="Harga" class="border rounded p-2 w-full">
        <input type="number" wire:model="stock" placeholder="Stok" class="border rounded p-2 w-full">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>

    <!-- Tabel Produk -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->price }}</td>
                    <td class="px-4 py-2">{{ $product->stock }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <button wire:click="edit({{ $product->id }})" class="text-blue-500">Edit</button>
                        <button wire:click="delete({{ $product->id }})" class="text-red-500">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
