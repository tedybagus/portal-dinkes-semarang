
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <div style="display:flex;justify-content:space-between;align-items:center;background:#fff;padding:1rem 1.5rem;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.06);margin-bottom:1.5rem;">
            <span style="color:#64748b;font-size:.9375rem;">
                Menampilkan <strong style="color:#1e293b;">{{ $paginator->firstItem() }}</strong> - <strong style="color:#1e293b;">{{ $paginator->lastItem() }}</strong> dari <strong style="color:#1e293b;">{{ $paginator->total() }}</strong>
            </span>
            <span style="color:#64748b;font-size:.9375rem;">
                Halaman <strong style="color:#1e293b;">{{ $paginator->currentPage() }}</strong> dari <strong style="color:#1e293b;">{{ $paginator->lastPage() }}</strong>
            </span>
        </div>
        
        <ul style="display:flex;gap:.5rem;list-style:none;padding:0;margin:0;align-items:center;justify-content:center;">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;background:#f8fafc;color:#cbd5e1;border:2px solid #f1f5f9;cursor:not-allowed;">‹ Prev</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;text-decoration:none;background:white;color:#475569;border:2px solid #e2e8f0;transition:all .2s;" onmouseover="this.style.background='#fef3c7';this.style.borderColor='#f59e0b';this.style.color='#f59e0b';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='white';this.style.borderColor='#e2e8f0';this.style.color='#475569';this.style.transform='translateY(0)'">‹ Prev</a>
                </li>
            @endif

            {{-- Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;background:transparent;color:#94a3b8;border:2px solid transparent;">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:2px solid #f59e0b;box-shadow:0 4px 12px rgba(245,158,11,.35);">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;text-decoration:none;background:white;color:#475569;border:2px solid #e2e8f0;transition:all .2s;" onmouseover="this.style.background='#fef3c7';this.style.borderColor='#f59e0b';this.style.color='#f59e0b';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='white';this.style.borderColor='#e2e8f0';this.style.color='#475569';this.style.transform='translateY(0)'">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;text-decoration:none;background:white;color:#475569;border:2px solid #e2e8f0;transition:all .2s;" onmouseover="this.style.background='#fef3c7';this.style.borderColor='#f59e0b';this.style.color='#f59e0b';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='white';this.style.borderColor='#e2e8f0';this.style.color='#475569';this.style.transform='translateY(0)'">Next ›</a>
                </li>
            @else
                <li>
                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 .875rem;border-radius:10px;font-size:.9375rem;font-weight:700;background:#f8fafc;color:#cbd5e1;border:2px solid #f1f5f9;cursor:not-allowed;">Next ›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
