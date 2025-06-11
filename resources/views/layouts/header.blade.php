<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="{{asset('images/logo1.PNG')}}" alt="Winnews Logo">
  </a>

  <form class="d-flex ms-auto me-3">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
  </form>

  @auth
    <div class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-light" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle me-1"></i> <!-- Atau ikon lain seperti fas fa-user -->
        {{ auth()->user()->name }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarUserDropdown">
        <li>
          <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
            @csrf
            <button type="submit" class="dropdown-item text-light bg-dark">
              <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
          </form>
        </li>
        <!-- Tambahkan item dropdown lain di sini jika perlu -->
      </ul>
    </div>
  @else
    <!-- Tombol Sign In -->
    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Sign In</a>

    <!-- Tombol Register -->
    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
  @endauth
</nav>
