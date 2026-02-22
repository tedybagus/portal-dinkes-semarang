@extends('layouts.app')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Pengumuman') }}
            </h2>
            </div>
            <a href="{{ route('admin.announcements.create') }}" class="bg-red-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Pengumuman
            </a>
        </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($announcements as $announcement)
                        <div class="border rounded-lg p-4 {{ $announcement->is_active ? 'border-green-200 bg-green-50' : 'border-gray-200' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                                        <span class="text-xs px-2 py-1 rounded {{ $announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $announcement->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 mb-2">{{ Str::limit($announcement->content, 200) }}</p>
                                    <div class="text-sm text-gray-500">
                                        @if($announcement->start_date)
                                        <span>Mulai: {{ $announcement->start_date->format('d M Y H:i') }}</span>
                                        @endif
                                        @if($announcement->end_date)
                                        <span class="ml-4">Selesai: {{ $announcement->end_date->format('d M Y H:i') }}</span>
                                        @endif
                                        @if(!$announcement->start_date && !$announcement->end_date)
                                        <span>Berlaku selamanya</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 ml-4">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus pengumuman ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-8">Belum ada pengumuman.</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection