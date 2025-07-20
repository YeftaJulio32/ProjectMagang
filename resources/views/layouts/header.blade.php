<header class="bg-body shadow-sm sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            {{-- Logo / Judul --}}
            <a class="navbar-brand fw-bold fs-3 text-primary" href="{{ url('/') }}">
                Winnews
            </a>

            {{-- Bagian kanan --}}
            <div class="d-flex align-items-center flex-wrap gap-2">

                {{-- Tombol Pencarian --}}
                <a href="#" class="btn btn-link text-body-secondary me-2" title="Cari">
                    <i class="bi bi-search fs-5"></i>
                </a>

                {{-- Auth --}}
                @guest
                    <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-body-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @else
                    <div class="dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                                $avatar = Auth::user()->avatar_url
                                    ? Auth::user()->avatar_url
                                    : asset('/storage/avatars/default-avatar.png');
                            @endphp
                            <img src="{{ $avatar }}" alt="avatar" class="rounded-circle me-1 border"
                                width="36" height="36">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                            </li>
                            @if (Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.profile.edit', Auth::user()->id) }}">Edit Profil</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('user.profile.show') }}">Profil Saya</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </div>
                @endguest

                {{-- Tombol Toggle Tema --}}
                <button type="button" class="btn btn-outline-secondary" id="theme-toggle" title="Ganti Tema">
                    <i class="bi bi-moon-stars-fill"></i>
                    <i class="bi bi-sun-fill d-none"></i>
                </button>
            </div>
        </div>
    </nav>
</header>
