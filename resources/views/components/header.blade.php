<nav class="navbar navbar-expand navbar-light bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Admin Markdown</span>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a
          class="nav-link {{ url()->current() === url('/') ? 'active' : '' }}"
          aria-current="page"
          href="/">
          Posts
        </a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link {{ url()->current() === url('/login') ? 'active' : '' }}"
          aria-current="page"
          href="/login">
          Login
        </a>
      </li>
    </ul>
  </div>
</nav>
