<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">Selamat datang kembali, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                    {{ auth()->user()->role->name }}
                </span>
            </div>
        </div>
    </x-slot>

    <!-- Your content here -->
    <div class="space-y-6">
        <!-- Stats cards, etc -->
    </div>
</x-app-layout>