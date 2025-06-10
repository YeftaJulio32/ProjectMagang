<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $news['judul'] ?? 'Berita' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #363535; color: white;">
  @include('layouts.header')

  <div class="container mt-5">
    <h2>{{ $news['judul'] ?? 'Judul tidak tersedia' }}</h2>
    <img src="https://lh3.googleusercontent.com/d/{{ $news['gambar'] ?? '' }}" class="img-fluid my-3" alt="Gambar Berita">
    <p>{!! nl2br(e($news['konten'] ?? 'Konten tidak tersedia')) !!}</p>

    <hr class="my-5">

    <h4>Berita lain di kategori: {{ $news['kategori'] ?? '-' }}</h4>
    <div class="row row-cols-1 row-cols-md-2 g-4 mt-2">
      @foreach ($otherNews as $item)
        <div class="col">
          <div class="card h-100">
            <img src="https://lh3.googleusercontent.com/d/{{ $item['gambar'] ?? '' }}" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">{{ $item['judul'] }}</h5>
              <a href="{{ route('news.show', $item['id']) }}" class="btn btn-dark btn-sm">Lihat</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @include('layouts.footer')
</body>
</html>
