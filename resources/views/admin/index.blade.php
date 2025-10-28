<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Admin Dashboard</h2>
    </x-slot>
    <div class="p-6">
        Hai, {{ Auth::user()->name }} (role: {{ Auth::user()->role }})
    </div>
</x-app-layout>
