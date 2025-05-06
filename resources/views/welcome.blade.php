<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Winnews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>

<body style="background-color: #363535;">
  <!-- Navbar -->
  @include('layouts.header')

  <!-- Horizontal Menu -->
  <br>
  <div class="bg-dark text-white py-2">
    <div class="container">
      <ul class="nav justify-content">
        <li class="nav-item"><a class="nav-link text-white" href="#">Politik</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Hukum</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Olahraga</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Hiburan</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Otomotif</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Bisnis</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Teknologi</a></li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mt-4">
    <div class="row main-content-news justify-content">
      <!-- Headline -->
      <div class="col-md-10">
        <div class="news-title text-white">Berita utama hari ini</div>
        <div class="container mt-4">
          <div class="row g-3">
            <!-- Gambar Utama -->
            <div class="col-md-8 position-relative">
              <img src="{{ asset('images/berita1.jpeg') }}" class="img-fluid w-100" alt="Berita Utama">
              <div class="bottom-0 start-0 p-3 text-white" style="background: rgba(0, 0, 0, 0.5); width: 100%;">
                <h5 class="mb-0">Jalan utama Batutulis Bogor ditutup karena bencana</h5>
              </div>
            </div>

            <!-- Sidebar Berita Terbaru -->
            <div class="col-md-4 bg-dark text-white p-3">
              <h6>Terbaru</h6>
              <ol class="ps-3">
                <li class="mb-2">Ledakan dahsyat di pelabuhan terbesar, 40 orang tewas</li>
                <li class="mb-2">Korut konfirmasi telah kirim pasukan ke Rusia</li>
                <li class="mb-2">Mobil listrik sudah mulai banyak digunakan di Indonesia</li>
              </ol>
            </div>
          </div>
        </div>

        <div class="mt-5">
          <h5 class="section-title text-white">Berita terbaru</h5>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            @for ($i = 0; $i < 6; $i++)
              <div class="col">
                <div class="card news-card h-100">
                  <img src="{{ asset('images/berita2.jpeg') }}" class="card-img-top" alt="News Image">
                  <div class="card-body">
                    <p class="card-text">Rapat anggota 2025 komite olimpiade Indonesia</p>
                  </div>
                </div>
              </div>
            @endfor
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  @include('layouts.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
