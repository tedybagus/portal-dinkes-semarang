<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Review Artikel</h2>
                <p class="mt-1 text-sm text-gray-500">Berikan keputusan untuk artikel ini</p>
            </div>
            <a href="{{ route('reviewer.articles.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Article Detail Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-white">
                <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        <div>
                            <p class="text-blue-100 text-xs">Penulis</p>
                            <p class="font-semibold">{{ $article->author->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-folder"></i>
                        <div>
                            <p class="text-blue-100 text-xs">Kategori</p>
                            <p class="font-semibold">{{ $article->category->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-building"></i>
                        <div>
                            <p class="text-blue-100 text-xs">Bidang</p>
                            <p class="font-semibold">{{ $article->department->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar"></i>
                        <div>
                            <p class="text-blue-100 text-xs">Tanggal Artikel</p>
                            <p class="font-semibold">{{ $article->article_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Image -->
            @if($article->image)
            <div class="px-6 pt-6">
                <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-auto max-h-96 object-cover rounded-lg shadow-md">
            </div>
            @endif

            <!-- Article Content -->
            <div class="px-6 py-6">
                <div class="prose max-w-none">
                    {!! $article->content !!}
                </div>
            </div>

            <!-- Metadata -->
            <div class="px-6 pb-6 border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div>
                        <i class="far fa-clock"></i> Dibuat pada {{ $article->created_at->format('d M Y H:i') }}
                    </div>
                    <div>
                        <i class="fas fa-file-alt"></i> Slug: <code class="bg-gray-100 px-2 py-1 rounded">{{ $article->slug }}</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Decision Card -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Keputusan Review</h3>
                <p class="text-sm text-gray-600 mt-1">Pilih salah satu: setujui atau tolak artikel ini</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Approve Button -->
                    <div class="border-2 border-green-200 rounded-lg p-6 hover:border-green-400 transition">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-green-500 flex items-center justify-center">
                                <i class="fas fa-check text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Setujui Artikel</h4>
                                <p class="text-sm text-gray-600">Artikel memenuhi standar</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('reviewer.articles.approve', $article) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui artikel ini?')">
                            @csrf
                            <button 
                                type="submit" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition shadow-md flex items-center justify-center gap-2"
                            >
                                <i class="fas fa-thumbs-up"></i>
                                <span>Setujui Artikel</span>
                            </button>
                        </form>

                        <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-3">
                            <p class="text-xs text-green-700">
                                <i class="fas fa-info-circle"></i> Artikel yang disetujui akan siap untuk dipublikasi oleh Super Admin
                            </p>
                        </div>
                    </div>

                    <!-- Reject Button with Form -->
                    <div class="border-2 border-red-200 rounded-lg p-6 hover:border-red-400 transition">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-red-500 flex items-center justify-center">
                                <i class="fas fa-times text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Tolak Artikel</h4>
                                <p class="text-sm text-gray-600">Perlu perbaikan</p>
                            </div>
                        </div>
                        
                        <button 
                            type="button"
                            onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition shadow-md flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-ban"></i>
                            <span>Tolak Artikel</span>
                        </button>

                        <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-xs text-red-700">
                                <i class="fas fa-exclamation-triangle"></i> Artikel akan dikembalikan ke penulis untuk diperbaiki
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Tolak Artikel</h3>
                            <p class="text-sm text-red-100">Berikan alasan penolakan yang jelas</p>
                        </div>
                    </div>
                    <button 
                        type="button"
                        onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="text-white hover:text-red-100 transition"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('reviewer.articles.reject', $article) }}" method="POST" id="rejectForm">
                @csrf
                
                <div class="p-6 space-y-6">
                    <!-- Article Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Artikel yang akan ditolak:</p>
                        <p class="font-semibold text-gray-900">{{ $article->title }}</p>
                        <p class="text-sm text-gray-600 mt-1">oleh {{ $article->author->name }}</p>
                    </div>

                    <!-- Rejection Reason -->
                    <div>
                        <label for="rejection_reason" class="block text-sm font-semibold text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="rejection_reason" 
                            id="rejection_reason" 
                            rows="8" 
                            required
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition resize-none"
                            placeholder="Jelaskan secara detail mengapa artikel ini ditolak dan apa yang perlu diperbaiki oleh penulis...&#10;&#10;Contoh:&#10;- Judul kurang menarik dan tidak sesuai dengan isi&#10;- Konten terlalu pendek, minimal 500 kata&#10;- Gambar tidak relevan dengan artikel&#10;- Tata bahasa perlu diperbaiki"
                        ></textarea>
                        <p class="mt-2 text-sm text-gray-500">
                            <i class="fas fa-lightbulb"></i> Berikan feedback yang konstruktif agar penulis dapat memperbaiki artikel dengan baik
                        </p>
                        @error('rejection_reason')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quick Suggestions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-blue-900 mb-2">
                            <i class="fas fa-info-circle"></i> Saran Template Alasan Penolakan:
                        </p>
                        <div class="space-y-2">
                            <button 
                                type="button"
                                onclick="setRejectionReason('Judul artikel kurang menarik dan tidak menggambarkan isi artikel. Mohon perbaiki judul agar lebih informatif dan menarik perhatian pembaca.')"
                                class="text-xs text-blue-700 hover:text-blue-900 underline block"
                            >
                                • Judul kurang menarik
                            </button>
                            <button 
                                type="button"
                                onclick="setRejectionReason('Konten artikel terlalu pendek. Minimal 500 kata diperlukan untuk menjelaskan topik secara mendalam. Mohon tambahkan informasi yang lebih detail dan lengkap.')"
                                class="text-xs text-blue-700 hover:text-blue-900 underline block"
                            >
                                • Konten terlalu pendek
                            </button>
                            <button 
                                type="button"
                                onclick="setRejectionReason('Terdapat beberapa kesalahan tata bahasa dan ejaan. Mohon periksa kembali artikel menggunakan PUEBI (Pedoman Umum Ejaan Bahasa Indonesia) yang benar.')"
                                class="text-xs text-blue-700 hover:text-blue-900 underline block"
                            >
                                • Tata bahasa perlu diperbaiki
                            </button>
                            <button 
                                type="button"
                                onclick="setRejectionReason('Gambar yang digunakan tidak relevan dengan isi artikel atau kualitasnya kurang baik. Mohon gunakan gambar yang berkualitas tinggi dan sesuai dengan topik.')"
                                class="text-xs text-blue-700 hover:text-blue-900 underline block"
                            >
                                • Gambar tidak relevan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="sticky bottom-0 bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-2xl">
                    <div class="flex items-center justify-end gap-4">
                        <button 
                            type="button"
                            onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium"
                        >
                            <i class="fas fa-times mr-2"></i> Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-lg"
                        >
                            <i class="fas fa-ban mr-2"></i> Tolak Artikel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function setRejectionReason(text) {
            document.getElementById('rejection_reason').value = text;
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('rejectModal').classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout>