<header class="bg-body shadow-sm sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            {{-- Logo mengarah ke Halaman Utama --}}
            <a class="navbar-brand fw-bolder fs-2 text-primary" href="{{ url('/') }}">Winnews</a>
            {{-- Aksi Pengguna & Pencarian dipindah ke ujung kanan --}}
            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="#" class="btn btn-link text-body-secondary me-2"><i class="bi bi-search fs-5"></i></a>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-body-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @else
                    <div class="dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4 text-body-secondary"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest

                <!-- [BARU] Tombol Pengalih Tema Terang/Gelap -->
                <button type="button" class="btn btn-outline-secondary" id="theme-toggle" title="Ganti tema">
                    {{-- Ikon akan diatur oleh JavaScript, 'd-none' menyembunyikan salah satunya --}}
                    <i class="bi bi-moon-stars-fill"></i>
                    <i class="bi bi-sun-fill d-none"></i>
                </button>
            </div>
        </div>
    </nav>
</header>
