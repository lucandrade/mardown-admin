<nav class="navbar navbar-expand navbar-light bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Admin Markdown</span>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a
          class="nav-link {{ url()->current() === url('/admin') ? 'active' : '' }}"
          aria-current="page"
          href="/admin">
          Posts
        </a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link {{ url()->current() === url('/admin/create') ? 'active' : '' }}"
          aria-current="page"
          href="/admin/create">
          New post
        </a>
      </li>
    </ul>
  </div>
</nav>
