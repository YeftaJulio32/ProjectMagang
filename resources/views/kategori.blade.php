@extends('layouts.app')

@section('title', 'Kategori: ' . ucfirst($kategori))

@section('content')
    {{-- Header Kategori --}}
    <div class="bg-primary text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('welcome') }}" class="text-decoration-none text-secondary-emphasis">
                                    <i class="bi bi-house-door"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-decoration-none text-secondary-emphasis" aria-current="page">
                                {{ ucfirst($kategori) }}
                            </li>
                        </ol>
                    </nav>
                    <h1 class="h2 mb-0 fw-bold">{{ ucfirst($kategori) }}</h1>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-newspaper"></i>
                        Menampilkan semua berita kategori ini
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        {{-- Konten Berita --}}
        @if (isset($error))
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                {{ $error }}
            </div>
        @elseif($filteredNews->count() > 0)
            {{-- Info Jumlah Berita --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    Ditemukan {{ $filteredNews->count() }} berita
                </h4>
            </div>

            {{-- Grid Berita --}}
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($filteredNews as $news)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                            <a href="{{ route('news.show', $news['id']) }}" class="text-decoration-none">
                                <img src="https://lh3.googleusercontent.com/d/{{ $news['gambar'] ?? '' }}"
                                    class="card-img-top" alt="{{ $news['judul'] }}"
                                    style="height: 200px; object-fit: cover;"
                                    onerror="this.onerror=null;this.src='https://placehold.co/400x250/343a40/dee2e6?text=Image+Error';">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold flex-grow-1">
                                    <a href="{{ route('news.show', $news['id']) }}" class="text-body text-decoration-none">
                                        {{ $news['judul'] ?? 'Judul tidak tersedia' }}
                                    </a>
                                </h5>

                                {{-- Excerpt/Preview Konten --}}
                                @if (isset($news['konten']))
                                    <p class="card-text text-muted small">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($news['konten']), 120) }}
                                    </p>
                                @endif

                                {{-- Footer Card --}}
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge text-bg-primary">
                                            {{ $news['kategori'] ?? 'Umum' }}
                                        </span>
                                        <small class="text-body-secondary">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($news['created_at'] ?? now())->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-body-secondary">
                                            <i class="bi bi-calendar3"></i>
                                            {{ \Carbon\Carbon::parse($news['created_at'] ?? now())->isoFormat('dddd, D MMMM Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination (jika diperlukan di masa depan) --}}
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Pagination">
                    <p class="text-muted small">
                        <i class="bi bi-info-circle"></i>
                        Menampilkan semua berita kategori "{{ ucfirst($kategori) }}"
                    </p>
                </nav>
            </div>
        @else
            {{-- Tidak Ada Berita --}}
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-newspaper display-1 text-muted"></i>
                </div>
                <h3 class="fw-bold mb-3">Belum Ada Berita</h3>
                <p class="text-muted mb-4">
                    Tidak ada berita untuk kategori "<strong>{{ ucfirst($kategori) }}</strong>".
                </p>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('welcome') }}" class="btn btn-primary">
                        <i class="bi bi-house-door"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Kategori Lainnya --}}
    @if ($filteredNews->count() > 0)
        <div class="bg-body-tertiary border-top mt-5 py-4">
            <div class="container">
                <h5 class="fw-bold mb-3">Lihat Juga Kategori Lainnya</h5>
                <div class="d-flex flex-wrap gap-2">
                    @php
                        $currentCategory = strtolower($kategori);
                    @endphp

                    @if (isset($availableCategories) && $availableCategories->count() > 0)
                        @foreach ($availableCategories as $cat)
                            @if ($cat !== $currentCategory)
                                <a href="{{ route('news.kategori', \Illuminate\Support\Str::slug($cat)) }}"
                                    class="btn btn-sm btn-outline-secondary text-nowrap text-secondary-emphasis">
                                    {{ \Illuminate\Support\Str::title($cat) }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <p class="text-muted small mb-0">
                            <i class="bi bi-info-circle"></i>
                            Belum ada kategori tambahan yang tersedia saat ini.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
