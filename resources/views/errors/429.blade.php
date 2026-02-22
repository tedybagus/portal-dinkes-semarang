@extends('layouts.public.app')

@section('content')
<div style="text-align: center; padding: 4rem 2rem;">
    <i class="fas fa-hourglass-half" style="font-size: 4rem; color: #ef4444;"></i>
    <h1 style="font-size: 2rem; margin: 1rem 0;">Terlalu Banyak Percobaan</h1>
    <p style="color: #6b7280;">
        Anda sudah mencapai batas maksimal komentar. 
        Silakan coba lagi dalam beberapa menit.
    </p>
    <a href="{{ route('articles.public') }}" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem; background: #1e40af; color: white; text-decoration: none; border-radius: 8px;">
        Kembali ke Berita
    </a>
</div>
@endsection