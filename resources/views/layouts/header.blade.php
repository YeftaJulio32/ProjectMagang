<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="{{asset('images/logo1.PNG')}}" alt="Winnews Logo">
  </a>

  <form class="d-flex ms-auto me-3">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
  </form>

  @auth
    <span class="navbar-text text-light me-3">
      Selamat datang, {{ auth()->user()->name }}!
    </span>
    <form method="POST" action="{{ route('logout') }}" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-outline-light">Logout</button>
    </form>
  @else
    <!-- Tombol Sign In -->
    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Sign In</a>

    <!-- Tombol Register -->
    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
  @endauth
</nav>
