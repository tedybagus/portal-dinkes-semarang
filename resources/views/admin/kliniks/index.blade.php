@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Kategori Fasyankes</h2>
                <p class="mt-1 text-sm text-gray-500">Manajemen data kategori fasyankes</p>
            </div>
            <a href="{{ route('admin.kliniks.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md font-medium">
                <i class="fas fa-plus mr-2"></i> Tambah Kategori
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Klinik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Fasyankes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Telp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($kliniks as $index => $klinik)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $kliniks->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $klinik->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($klinik->alamat, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-mono bg-blue-100 text-blue-800 rounded">
                                        {{ $klinik->kode_fasyankes }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $klinik->no_telp ?: '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($klinik->latitude && $klinik->longitude)
                                        {{-- <a href="{{ $klinik->map_url }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Lihat Map
                                        </a> --}}
                                        <button type="button" onclick="openMapModal({{ $klinik->latitude }}, {{ $klinik->longitude }}, '{{ $klinik->nama }}')"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                            📍 Lihat
                                        </button>
                                    @else
                                        <span class="text-gray-400">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $klinik->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $klinik->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.kliniks.show', $klinik) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.kliniks.edit', $klinik) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button 
                                        type="button"
                                        onclick="openDeleteModal({{ $klinik->id }}, '{{ addslashes($klinik->nama) }}')"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i class="fas fa-hospital text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada data kategori</p>
                                        <p class="text-sm text-gray-400 mt-1">Tambahkan kategori fasyankes pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $kliniks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Map -->
<div id="mapModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center"
>
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-4 relative">
        <h3 class="text-lg font-semibold mb-2">Lokasi Klinik</h3>

        <div id="previewMap" style="height:400px; width:100%;" class="w-full h-96 rounded-lg"></div>

        <button
            onclick="closeMapModal()"
            class="absolute top-3 right-3 text-gray-500 hover:text-red-500"
        >
            ✕
        </button>
        <br>
        <div class="flex justify-end gap-2 mb-3">
    <a
        id="googleMapsLink"
        href="#"
        target="_blank"
        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/>
        </svg>
        Buka Google Maps
    </a>
</div>
    </div>
</div>


<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-trash text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Hapus Klinik</h3>
                </div>
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="text-white hover:text-red-100 transition"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Hapus klinik ini?</p>
                    <p class="text-sm text-gray-600 mb-4" id="deleteKlinikName"></p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-left">
                        <p class="text-sm text-red-800">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Peringatan:</strong> Data klinik akan dihapus permanen dan tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-2xl flex items-center justify-end gap-3">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="px-6 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-lg"
                >
                    <i class="fas fa-trash mr-2"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(klinikId, klinikName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nameElement = document.getElementById('deleteKlinikName');
        
        form.action = `/admin/kliniks/${klinikId}`;
        nameElement.textContent = `"${klinikName}"`;
        
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
        let previewMap = null;
        let previewMarker = null;

        function openMapModal(lat, lng, nama) {
            const modal = document.getElementById('mapModal');
            modal.classList.remove('hidden');
             // 👉 SET LINK GOOGLE MAPS
            const googleLink = document.getElementById('googleMapsLink');
            googleLink.href = `https://www.google.com/maps?q=${lat},${lng}`;

            setTimeout(() => {
                if (!previewMap) {
                    previewMap = L.map('previewMap').setView([lat, lng], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(previewMap);

                    previewMarker = L.marker([lat, lng]).addTo(previewMap);
                } else {
                    previewMap.setView([lat, lng], 15);
                    previewMarker.setLatLng([lat, lng]);
                }

                previewMarker.bindPopup(`<strong>${nama}</strong>`).openPopup();
                previewMap.invalidateSize(); // penting untuk modal
            }, 300);
        }

        function closeMapModal() {
            document.getElementById('mapModal').classList.add('hidden');
        }
</script>
@endsection