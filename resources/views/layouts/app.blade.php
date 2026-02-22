<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal Berita') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
     <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Filament Style -->
    <link rel="stylesheet" href="{{ asset('css/filament-style.css') }}">
  
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .sidebar-link {
            transition: all 0.2s ease;
        }
        
        .sidebar-link:hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            border-left-color: #3b82f6;
        }
        
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-left-color: #3b82f6;
            font-weight: 600;
        }
        
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .submenu.open {
            max-height: 500px;
        }
        #map {
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }
          #map {
            height: calc(100vh - 4rem);
            width: 100%;
        }
        
        .leaflet-popup-content {
            min-width: 200px;
        }
        
        .marker-cluster-small {
            background-color: rgba(181, 226, 140, 0.6);
        }
        
        .marker-cluster-small div {
            background-color: rgba(110, 204, 57, 0.6);
        }
        
        .marker-cluster-medium {
            background-color: rgba(241, 211, 87, 0.6);
        }
        
        .marker-cluster-medium div {
            background-color: rgba(240, 194, 12, 0.6);
        }
        
        .marker-cluster-large {
            background-color: rgba(253, 156, 115, 0.6);
        }
        
        .marker-cluster-large div {
            background-color: rgba(241, 128, 23, 0.6);
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <div class="min-h-full">
        @include('layouts.navigation')
        
        <!-- Page Content -->
        <div class="lg:pl-64">
            <main>
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </div>

    @stack('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
      <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Validation Script -->

    <script src="{{ asset('js/validation-script.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
</body>
</html>