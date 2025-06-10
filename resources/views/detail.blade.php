<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $news['judul'] ?? 'Berita' }} - Winnews</title>
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #363535;
      color: white;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Main Content Container */
    .main-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Article Title */
    .article-title {
      font-size: 1.8rem;
      font-weight: bold;
      color: #ffffff;
      margin-bottom: 20px;
      line-height: 1.3;
      text-align: left;
    }

    /* Article Image */
    .article-image {
      width: 100%;
      height: auto;
      max-height: 400px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 20px;
      display: block;
    }

    /* Article Content */
    .article-content {
      font-size: 0.95rem;
      line-height: 1.6;
      color: #ffffff;
      text-align: justify;
    }

    .article-content p {
      margin-bottom: 15px;
    }

    /* Related News Section */
    .related-section {
      margin-top: 40px;
      border-top: 1px solid #404040;
      padding-top: 30px;
    }

    .related-title {
      font-size: 1.3rem;
      color: #ffffff;
      margin-bottom: 20px;
    }

    .related-card {
      background-color: #2c2c2c;
      border: none;
      border-radius: 8px;
      overflow: hidden;
      height: 100%;
    }

    .related-card img {
      height: 200px;
      object-fit: cover;
      width: 100%;
    }

    .related-card .card-body {
      background-color: #2c2c2c;
      color: #ffffff;
      padding: 15px;
    }

    .related-card .card-title {
      font-size: 1rem;
      color: #ffffff;
      margin-bottom: 10px;
      line-height: 1.3;
    }

    .btn-read {
      background-color: #404040;
      color: #ffffff;
      border: none;
      padding: 6px 15px;
      font-size: 0.85rem;
      border-radius: 4px;
      text-decoration: none;
      display: inline-block;
    }

    .btn-read:hover {
      background-color: #555555;
      color: #ffffff;
    }

    /* Comments Section */
    .comments-section {
      background-color: #2c2c2c;
      padding: 20px;
      border-radius: 8px;
      margin-top: 30px;
    }

    .comments-title {
      font-size: 1.2rem;
      margin-bottom: 15px;
      color: #ffffff;
    }

    .comment-form textarea {
      background-color: #404040;
      border: 1px solid #555;
      color: #ffffff;
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      resize: vertical;
      min-height: 80px;
    }

    .comment-form textarea:focus {
      outline: none;
      border-color: #00ff00;
    }

    .btn-submit {
      background-color: #00ff00;
      border: none;
      color: #000000;
      font-weight: bold;
      padding: 8px 20px;
      border-radius: 4px;
      margin-top: 10px;
    }

    /* Footer */
    .footer {
      background-color: #2c2c2c;
      color: #ffffff;
      text-align: center;
      padding: 20px 0;
      margin-top: 40px;
      border-top: 1px solid #404040;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .main-container {
        padding: 15px;
      }

      .article-title {
        font-size: 1.5rem;
      }

      .article-content {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation Header -->
  @include('layouts.header')


  <!-- Main Content -->
  <div class="main-container">
    <!-- Article Title -->
    <h1 class="article-title">{{ $news['judul'] ?? 'Judul tidak tersedia' }}</h1>

    <!-- Article Image -->
    <img src="https://lh3.googleusercontent.com/d/{{ $news['gambar'] ?? '' }}"
         class="article-image"
         alt="Gambar Berita">

    <!-- Article Content -->
    <div class="article-content">
      {!! $news['deskripsi'] !!}
    </div>

    <!-- Related News Section -->
    <div class="related-section">
      <h4 class="related-title">Berita lain di kategori: {{ $news['kategori'] ?? '-' }}</h4>
      <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($otherNews as $item)
          <div class="col">
            <div class="card related-card h-100">
              <img src="https://lh3.googleusercontent.com/d/{{ $item['gambar'] ?? '' }}"
                   class="card-img-top"
                   alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $item['judul'] }}</h5>
                <a href="{{ route('news.show', $item['id']) }}" class="btn-read">Lihat</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
      <h4 class="comments-title">Komentar</h4>
      <div class="comment-form">
        <textarea placeholder="Masukkan komentar..."></textarea>
        <button class="btn-submit">Kirim</button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 Winnews. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
