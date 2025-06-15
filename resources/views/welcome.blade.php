@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- Bagian Sub-Header untuk Kategori --}}
<div class="bg-body-tertiary border-bottom border-top">
    <div class="container">
        <nav class="nav nav-pills flex-column flex-sm-row nav-fill py-2">
            <a class="nav-link" href="#">Politik</a>
            <a class="nav-link" href="#">Hukum</a>
            <a class="nav-link" href="#">Olahraga</a>
            <a class="nav-link" href="#">Hiburan</a>
            <a class="nav-link" href="#">Otomotif</a>
            <a class="nav-link" href="#">Bisnis</a>
            <a class="nav-link" href="#">Teknologi</a>
        </nav>
    </div>
</div>

<div class="container my-4">
    <!-- Berita Utama & Terbaru -->
    <section class="row g-4 mb-5">

        <!-- Kolom Berita Utama (Headline) -->
        <div class="col-lg-8">
            <a href="{{ route('news.show', $headline['id'] ?? '1') }}" class="card text-white border-0 shadow-lg h-100 overflow-hidden text-decoration-none">
                {{-- Gambar dari data $headline Anda --}}
                <img src="https://lh3.googleusercontent.com/d/{{ $headline['gambar'] ?? '' }}"
                     class="card-img h-100 object-fit-cover"
                     alt="{{ $headline['judul'] ?? 'Berita Utama' }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/800x500/343a40/dee2e6?text=Gambar+Utama+Error';">

                <div class="card-img-overlay d-flex flex-column justify-content-end p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.9) 20%, transparent 80%);">
                    <span class="badge bg-danger align-self-start mb-2">HEADLINE</span>
                    <h1 class="card-title fs-2 fw-bolder">
                        {{ $headline['judul'] ?? 'Judul Berita Utama Tidak Tersedia' }}
                    </h1>
                </div>
            </a>
        </div>

        <!-- Sidebar Berita Terbaru (diambil dari $groupedNews) -->
        <div class="col-lg-4">
            <h4 class="fw-bold mb-3">Terbaru</h4>
            <div class="list-group">
                @foreach ($groupedNews->flatten(1)->take(5) as $news)
                <a href="{{ route('news.show', $news['id']) }}" class="list-group-item list-group-item-action d-flex gap-3 py-3">
                    {{-- Gambar dari data $groupedNews Anda --}}
                    <img src="https://lh3.googleusercontent.com/d/{{ $news['gambar'] ?? '' }}"
                         alt="{{ $news['judul'] }}"
                         width="80" height="80"
                         class="rounded-3 flex-shrink-0 object-fit-cover"
                         onerror="this.onerror=null;this.src='https://placehold.co/100x100/343a40/dee2e6?text=Error';">

                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-1 fw-semibold lh-sm">{{ \Illuminate\Support\Str::limit($news['judul'], 65) }}</h6>
                        <small class="text-body-secondary"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($news['created_at'] ?? now())->diffForHumans() }}</small>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Berita Lainnya (diambil dari $latestNews / $groupedNews) -->
    <section>
        <h2 class="fs-4 fw-bold pb-2 border-bottom mb-4">Berita Lainnya</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            @php
                // Mengambil 4 berita setelah 5 berita pertama yang sudah ditampilkan di sidebar
                $latestNews = $groupedNews->flatten(1)->slice(0, 4);
            @endphp

            @foreach ($latestNews as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                    <a href="{{ route('news.show', $item['id']) }}">
                        {{-- Gambar dari data $latestNews Anda --}}
                        <img src="https://lh3.googleusercontent.com/d/{{ $item['gambar'] ?? '' }}"
                             class="card-img-top"
                             alt="{{ $item['judul'] }}"
                             style="height: 180px; object-fit: cover;"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x250/343a40/dee2e6?text=Image+Error';">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold flex-grow-1">
                            <a href="{{ route('news.show', $item['id']) }}" class="text-body text-decoration-none">
                                {{ \Illuminate\Support\Str::limit($item['judul'] ?? 'Judul tidak tersedia', 70) }}
                            </a>
                        </h6>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                             <a href="#" class="badge text-bg-primary text-decoration-none">{{ $item['kategori'] ?? 'Umum' }}</a>
                             <small class="text-body-secondary">{{ \Carbon\Carbon::parse($item['created_at'] ?? now())->isoFormat('D MMM') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
