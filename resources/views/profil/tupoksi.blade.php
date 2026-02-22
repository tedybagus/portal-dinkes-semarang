@extends('layouts.public.app')

@section('title', 'Tugas Pokok & Fungsi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="header-container">
        <h1 class="page-title">Tugas Pokok & Fungsi</h1>
        <p class="page-subtitle">Tupoksi Dinas Kesehatan Kabupaten Semarang</p>
    </div>
</div>

@if($tupoksi->count() > 0)
    <div class="content-container">
        <div class="tupoksi-accordion">
            @foreach($tupoksi as $index => $item)
                <div class="accordion-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div class="header-left">
                            <span class="accordion-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="accordion-title">{{ $item->title }}</h3>
                        </div>
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    
                    <div class="accordion-content">
                        <div class="content-grid">
                            <!-- Tugas Pokok -->
                            <div class="content-section tugas-section">
                                <div class="section-header">
                                    <i class="fas fa-clipboard-check"></i>
                                    <h4>Tugas Pokok</h4>
                                </div>
                                <div class="section-body">
                                    {!! $item->tugas_pokok !!}
                                </div>
                            </div>

                            <!-- Fungsi -->
                            <div class="content-section fungsi-section">
                                <div class="section-header">
                                    <i class="fas fa-cogs"></i>
                                    <h4>Fungsi</h4>
                                </div>
                                <div class="section-body">
                                    {!! $item->fungsi !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-tasks"></i>
        <h3>Data Belum Tersedia</h3>
        <p>Tupoksi belum ditambahkan</p>
    </div>
@endif

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    color: white;
    padding: 4rem 0 3rem;
    margin-bottom: 3rem;
}

.header-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.page-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.page-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
}

/* Content Container */
.content-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem 4rem;
}

/* Accordion */
.tupoksi-accordion {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.accordion-item {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s;
}

.accordion-item:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.accordion-header {
    padding: 1.5rem 2rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-bottom: 2px solid transparent;
    transition: all 0.3s;
}

.accordion-item.active .accordion-header {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-bottom-color: #1e40af;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.accordion-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #1e40af;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    flex-shrink: 0;
}

.accordion-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.accordion-icon {
    color: #1e40af;
    font-size: 1.25rem;
    transition: transform 0.3s;
}

.accordion-item.active .accordion-icon {
    transform: rotate(180deg);
}

.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease-out;
}

.accordion-item.active .accordion-content {
    max-height: 2000px;
    transition: max-height 0.5s ease-in;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    padding: 2rem;
}

.content-section {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 8px;
}

.tugas-section {
    border-left: 4px solid #10b981;
}

.fungsi-section {
    border-left: 4px solid #6366f1;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.section-header i {
    font-size: 1.5rem;
}

.tugas-section .section-header i {
    color: #10b981;
}

.fungsi-section .section-header i {
    color: #6366f1;
}

.section-header h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.section-body {
    font-size: 0.9375rem;
    line-height: 1.7;
    color: #374151;
}

.section-body ul {
    margin: 0;
    padding-left: 1.5rem;
}

.section-body li {
    margin-bottom: 0.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 6rem 2rem;
}

.empty-state i {
    font-size: 5rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #9ca3af;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .page-subtitle {
        font-size: 1rem;
    }

    .content-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .accordion-header {
        padding: 1.25rem 1.5rem;
    }

    .accordion-number {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .accordion-title {
        font-size: 1.0625rem;
    }
}
</style>

<script>
function toggleAccordion(header) {
    const item = header.closest('.accordion-item');
    const wasActive = item.classList.contains('active');
    
    // Close all accordion items
    document.querySelectorAll('.accordion-item').forEach(el => {
        el.classList.remove('active');
    });
    
    // Open clicked item if it wasn't already open
    if (!wasActive) {
        item.classList.add('active');
    }
}

// Open first item by default on load
document.addEventListener('DOMContentLoaded', function() {
    const firstItem = document.querySelector('.accordion-item');
    if (firstItem) {
        firstItem.classList.add('active');
    }
});
</script>
@endsection