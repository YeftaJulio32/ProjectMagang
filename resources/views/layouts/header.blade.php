<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="{{asset('images/logo1.PNG')}}" alt="Winnews Logo">
  </a>

  <form class="d-flex ms-auto me-3">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
  </form>

  <!-- Tombol Sign In -->
  <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Sign In</a>

  <!-- Tombol Register -->
  <a href="{{ route('register') }}" class="btn btn-light">Register</a>
</nav>
