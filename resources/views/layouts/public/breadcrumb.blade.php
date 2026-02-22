<div class="breadcrumb-section">
    <div class="breadcrumb-container">
        <nav class="breadcrumb" aria-label="breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Beranda
                </a>
            </div>

            @foreach($breadcrumbs as $index => $breadcrumb)
                <i class="fas fa-chevron-right breadcrumb-separator"></i>
                
                @if($loop->last)
                    <div class="breadcrumb-item active" aria-current="page">
                        {{ $breadcrumb['title'] }}
                    </div>
                @else
                    <div class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">
                            {{ $breadcrumb['title'] }}
                        </a>
                    </div>
                @endif
            @endforeach
        </nav>
    </div>
</div>