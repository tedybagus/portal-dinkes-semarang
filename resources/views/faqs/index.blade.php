@extends('layouts.public.app')
@section('title', 'FAQ – Pertanyaan yang Sering Diajukan')

@section('content')
<div class="faq-public-page">

    {{-- Hero Section --}}
    <section class="faq-hero">
        <div class="hero-container">
            <div class="hero-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h1>Pertanyaan yang Sering Diajukan</h1>
            <p>Temukan jawaban atas pertanyaan Anda dengan cepat</p>

            {{-- Search Bar --}}
            <form action="{{ route('faqs.index') }}" method="GET" class="hero-search">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text"
                           name="q"
                           placeholder="Cari pertanyaan..."
                           value="{{ $searchQuery ?? '' }}"
                           autocomplete="off">
                    <button type="submit">Cari</button>
                </div>
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
            </form>
        </div>
    </section>

    <div class="faq-container">

        {{-- Kategori Tabs --}}
        @if($kategoris->count() > 1)
        <div class="kategori-tabs">
            <a href="{{ route('faqs.index', array_filter(['q' => $searchQuery])) }}"
               class="kat-tab {{ !$activeKat ? 'kat-tab-active' : '' }}">
                <i class="fas fa-th-large"></i> Semua
                <span class="kat-count">{{ \App\Models\Faq::active()->count() }}</span>
            </a>
            @foreach($kategoris as $kat)
            <a href="{{ route('faqs.index', array_filter(['kategori' => $kat, 'q' => $searchQuery])) }}"
               class="kat-tab {{ $activeKat == $kat ? 'kat-tab-active' : '' }}">
                <i class="fas {{ \App\Models\Faq::active()->where('kategori', $kat)->count() > 5 ? 'fa-folder-open' : 'fa-folder' }}"></i>
                {{ $kat }}
                <span class="kat-count">{{ \App\Models\Faq::active()->where('kategori', $kat)->count() }}</span>
            </a>
            @endforeach
        </div>
        @endif

        {{-- Search Result Info --}}
        @if($searchQuery)
        <div class="search-info">
            <i class="fas fa-search"></i>
            Hasil pencarian untuk <strong>"{{ $searchQuery }}"</strong>:
            <strong>{{ $faqs->count() }}</strong> pertanyaan ditemukan.
            <a href="{{ route('faqs.index') }}">Hapus pencarian</a>
        </div>
        @endif

        {{-- FAQ Items --}}
        @if($faqs->count())
        <div class="faq-list">
            @php $prevKat = null; @endphp
            @foreach($faqs as $i => $faq)

            {{-- Kategori header (only if showing all) --}}
            @if(!$activeKat && $faq->kategori !== $prevKat)
            <div class="kat-header">
                <i class="fas fa-tag"></i>
                {{ $faq->kategori }}
            </div>
            @php $prevKat = $faq->kategori; @endphp
            @endif

            <div class="faq-item" id="faq-{{ $faq->id }}">
                <button class="faq-question" onclick="toggleFaq({{ $faq->id }}, this)"
                        aria-expanded="false" aria-controls="answer-{{ $faq->id }}">
                    <span class="q-number">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="q-text">{{ $faq->pertanyaan }}</span>
                    <span class="q-chevron">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer" id="answer-{{ $faq->id }}" style="display:none">
                    <div class="answer-inner">
                        {!! nl2br(e($faq->jawaban)) !!}
                    </div>
                    <div class="answer-footer">
                        <span class="answer-kat">
                            <i class="fas fa-tag"></i> {{ $faq->kategori }}
                        </span>
                        <button class="helpful-btn" onclick="markHelpful({{ $faq->id }}, this)">
                            <i class="fas fa-thumbs-up"></i> Jawaban ini membantu
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Empty State --}}
        <div class="faq-empty">
            <i class="fas fa-search"></i>
            <h3>
                @if($searchQuery)
                    Tidak ada hasil untuk "{{ $searchQuery }}"
                @else
                    Belum ada FAQ
                @endif
            </h3>
            <p>
                @if($searchQuery)
                    Coba kata kunci lain atau
                    <a href="{{ route('faqs.index') }}">lihat semua FAQ</a>.
                @else
                    Pertanyaan akan segera ditambahkan.
                @endif
            </p>
        </div>
        @endif

        {{-- Contact CTA --}}
        <div class="faq-cta">
            <div class="cta-content">
                <i class="fas fa-headset"></i>
                <div>
                    <h3>Tidak menemukan jawaban yang dicari?</h3>
                    <p>Tim kami siap membantu Anda secara langsung</p>
                </div>
            </div>
            <div class="cta-actions">
                <a href="/pengaduan/ajukan" class="btn btn-primary">
                    <i class="fas fa-comment-alt"></i> Ajukan Pertanyaan
                </a>
                <a href="/kontak" class="btn btn-secondary">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>

<style>
* { box-sizing:border-box; margin:0; padding:0; }

.faq-public-page { background:#f8fafc; min-height:100vh; }

/* Hero */
.faq-hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 60%, #60a5fa 100%);
    padding: 4rem 1rem 5rem;
    text-align: center;
    position: relative;
}
.faq-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 60px;
    background: #f8fafc;
    clip-path: ellipse(55% 100% at 50% 100%);
}
.hero-container { max-width: 700px; margin: 0 auto; }
.hero-icon { font-size: 4rem; color: rgba(255,255,255,.85); margin-bottom: 1rem; }
.faq-hero h1 { font-size: 2.5rem; font-weight: 800; color: white; margin-bottom: .75rem; }
.faq-hero p { font-size: 1.125rem; color: rgba(255,255,255,.85); margin-bottom: 2rem; }

.hero-search { max-width: 600px; margin: 0 auto; }
.search-wrap {
    display: flex; align-items: center;
    background: white; border-radius: 50px;
    padding: .375rem .375rem .375rem 1.25rem;
    box-shadow: 0 8px 24px rgba(0,0,0,.18);
}
.search-wrap i { color: #94a3b8; font-size: 1.125rem; margin-right: .75rem; }
.search-wrap input {
    flex: 1; border: none; outline: none;
    font-size: 1rem; color: #1e293b; background: transparent;
}
.search-wrap button {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white; border: none; padding: .75rem 1.5rem;
    border-radius: 40px; font-weight: 700; font-size: .9375rem;
    cursor: pointer; transition: all .2s;
}
.search-wrap button:hover { transform: scale(1.04); }

/* Container */
.faq-container { max-width: 900px; margin: 0 auto; padding: 2rem 1rem 4rem; }

/* Kategori Tabs */
.kategori-tabs {
    display: flex; gap: .625rem; flex-wrap: wrap;
    margin-bottom: 2rem;
}
.kat-tab {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .625rem 1.125rem; border-radius: 30px;
    background: white; color: #64748b; font-weight: 600; font-size: .875rem;
    text-decoration: none; border: 2px solid #e2e8f0;
    transition: all .2s;
}
.kat-tab:hover { border-color: #3b82f6; color: #3b82f6; }
.kat-tab-active { background: #3b82f6; color: white !important; border-color: #3b82f6 !important; }
.kat-count {
    background: rgba(255,255,255,.3); color: inherit;
    padding: .125rem .5rem; border-radius: 12px; font-size: .75rem;
}
.kat-tab-active .kat-count { background: rgba(255,255,255,.3); }
.kat-tab:not(.kat-tab-active) .kat-count { background: #f1f5f9; color: #64748b; }

/* Search info */
.search-info {
    background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
    padding: .75rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem;
    font-size: .9375rem; display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
}
.search-info a { color: #2563eb; font-weight: 600; margin-left: auto; }

/* Kategori header */
.kat-header {
    display: flex; align-items: center; gap: .625rem;
    font-size: .8125rem; font-weight: 700; color: #64748b;
    text-transform: uppercase; letter-spacing: .06em;
    margin: 2rem 0 .875rem; padding: 0 .25rem;
}
.kat-header i { color: #94a3b8; }

/* FAQ Item */
.faq-list { display: flex; flex-direction: column; gap: .75rem; margin-bottom: 3rem; }

.faq-item {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,.06);
    border: 2px solid transparent;
    transition: all .25s;
    overflow: hidden;
}
.faq-item:hover { border-color: #dbeafe; }
.faq-item.faq-open { border-color: #3b82f6; box-shadow: 0 4px 16px rgba(59,130,246,.12); }

.faq-question {
    width: 100%; background: none; border: none; cursor: pointer;
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.5rem; text-align: left;
    transition: background .15s;
}
.faq-question:hover { background: #f8fafc; }

.q-number {
    flex-shrink: 0; width: 32px; height: 32px; border-radius: 8px;
    background: #eff6ff; color: #3b82f6; font-size: .8125rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    transition: all .25s;
}
.faq-open .q-number { background: #3b82f6; color: white; }

.q-text { flex: 1; font-size: 1.0625rem; font-weight: 600; color: #1e293b; line-height: 1.5; }

.q-chevron { flex-shrink: 0; color: #94a3b8; font-size: 1rem; transition: transform .3s; }
.faq-open .q-chevron { transform: rotate(180deg); color: #3b82f6; }

/* Answer */
.faq-answer { border-top: 1px solid #f1f5f9; }
.answer-inner {
    padding: 1.25rem 1.5rem 1rem;
    font-size: 1rem; color: #475569; line-height: 1.8;
}
.answer-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: .75rem 1.5rem 1.25rem; flex-wrap: wrap; gap: .75rem;
}
.answer-kat { display: flex; align-items: center; gap: .375rem; font-size: .8125rem; color: #94a3b8; }
.answer-kat i { color: #cbd5e1; }

.helpful-btn {
    background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;
    padding: .375rem .875rem; border-radius: 20px; font-size: .8125rem; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; gap: .375rem; transition: all .2s;
}
.helpful-btn:hover { background: #dcfce7; }
.helpful-btn.clicked { background: #16a34a; color: white; border-color: #16a34a; cursor: default; }

/* CTA */
.faq-cta {
    background: white; border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    padding: 2rem; border: 2px solid #e0e7ff;
    display: flex; align-items: center; justify-content: space-between;
    gap: 2rem; flex-wrap: wrap;
}
.cta-content { display: flex; align-items: center; gap: 1.25rem; }
.cta-content > i { font-size: 2.5rem; color: #3b82f6; }
.cta-content h3 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: .25rem; }
.cta-content p { color: #64748b; }
.cta-actions { display: flex; gap: .75rem; flex-wrap: wrap; }

/* Empty */
.faq-empty { text-align: center; padding: 4rem 2rem; }
.faq-empty i { font-size: 4rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
.faq-empty h3 { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: .5rem; }
.faq-empty p { color: #64748b; }
.faq-empty a { color: #3b82f6; font-weight: 600; }

/* Buttons */
.btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:8px; font-weight:600; font-size:.9375rem; text-decoration:none; transition:all .2s; border:none; cursor:pointer; }
.btn-primary { background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; }
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(59,130,246,.35); }
.btn-secondary { background:#f1f5f9; color:#475569; }
.btn-secondary:hover { background:#e2e8f0; }

@media (max-width:768px) {
    .faq-hero h1 { font-size:1.875rem; }
    .faq-cta { flex-direction:column; }
    .cta-actions { width:100%; }
    .cta-actions .btn { flex:1; justify-content:center; }
}
</style>

<script>
function toggleFaq(id, btn) {
    const answer  = document.getElementById('answer-' + id);
    const item    = btn.closest('.faq-item');
    const isOpen  = item.classList.contains('faq-open');

    // Close all open
    document.querySelectorAll('.faq-item.faq-open').forEach(el => {
        el.classList.remove('faq-open');
        el.querySelector('.faq-answer').style.display = 'none';
        el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
    });

    // Open clicked if it was closed
    if (!isOpen) {
        item.classList.add('faq-open');
        answer.style.display = 'block';
        btn.setAttribute('aria-expanded', 'true');

        // Smooth scroll
        setTimeout(() => {
            item.scrollIntoView({ behavior:'smooth', block:'nearest' });
        }, 50);
    }
}

function markHelpful(id, btn) {
    if (btn.classList.contains('clicked')) return;
    btn.classList.add('clicked');
    btn.innerHTML = '<i class="fas fa-check"></i> Terima kasih!';

    fetch('/faq/' + id + '/helpful', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
            'Content-Type': 'application/json'
        }
    }).catch(() => {});
}

// Open FAQ from URL hash (#faq-XX)
window.addEventListener('load', () => {
    const hash = window.location.hash;
    if (hash && hash.startsWith('#faq-')) {
        const id  = hash.replace('#faq-', '');
        const btn = document.querySelector(`#faq-${id} .faq-question`);
        if (btn) setTimeout(() => btn.click(), 200);
    }
});
</script>
@endsection