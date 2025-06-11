<!DOCTYPE html>
<html lang="id">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $news['judul'] ?? 'Detail Berita' }} | Winnews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>

<body class="bg-dark text-light">
    <!-- Navigation Header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="bg-dark border-bottom py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-3 mb-lg-0">
                    <h1 class="fw-bold text-white mb-3" style="font-size:2rem;">
                        {{ $news['judul'] ?? 'Judul tidak tersedia' }}
                    </h1>
                    <span class="badge bg-warning text-dark mb-2">{{ $news['kategori'] ?? '-' }}</span>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="https://lh3.googleusercontent.com/d/{{ $news['gambar'] ?? '' }}" alt="Gambar Berita"
                        class="img-fluid rounded shadow" style="max-height:240px;object-fit:cover;width:100%;">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Article Content -->
        <div class="mb-4">
            <div class="fs-5 lh-lg bg-secondary bg-opacity-10 rounded p-4 text-light">
                {!! $news['deskripsi'] !!}
            </div>
        </div>

        <!-- Related News Section -->
        <div class="mt-5 pt-4 border-top">
            <h4 class="mb-4 text-white">Berita lain di kategori: <span
                    class="text-warning">{{ $news['kategori'] ?? '-' }}</span></h4>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($otherNews as $item)
                    <div class="col">
                        <div class="card h-100 bg-secondary bg-opacity-25 border-0 shadow-sm">
                            <img src="https://lh3.googleusercontent.com/d/{{ $item['gambar'] ?? '' }}"
                                class="card-img-top" alt="...">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-white">{{ $item['judul'] }}</h5>
                                <a href="{{ route('news.show', $item['id']) }}"
                                    class="btn btn-outline-light mt-auto">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-5">
            <h4 class="mb-3">Komentar</h4>
            <form>
                <div class="mb-3">
                    <textarea class="form-control bg-dark text-light border-secondary" rows="4" placeholder="Masukkan komentar..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">Kirim</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    {{-- <footer class="bg-secondary bg-opacity-25 text-center text-light py-4 mt-5 border-top">
        <div class="container">
            <p class="mb-0">&copy; 2024 Winnews. All rights reserved.</p>
        </div>
    </footer> --}}
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
