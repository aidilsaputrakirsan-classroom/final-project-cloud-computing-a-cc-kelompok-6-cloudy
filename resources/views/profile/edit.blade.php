<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Profile</h2>
    </x-slot>

    <div class="p-6 space-y-4">
        <p>Nama: <strong>{{ $user->name }}</strong></p>
        <p>Email: <strong>{{ $user->email }}</strong></p>
        <p>Role: <strong>{{ $user->role }}</strong></p>

        <a href="{{ route('dashboard') }}" class="text-blue-600 underline">Kembali ke Dashboard</a>
    </div>
</x-app-layout>
