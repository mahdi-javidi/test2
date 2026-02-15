<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<header class="glass-header" id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="1.png" alt="Arcade Logo" width="30" height="24" class="d-inline-block align-text-top">
                Arcade
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#home"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-gamepad"></i> Games
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-fist-raised"></i> Action</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-map"></i> Adventure</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chess"></i> Strategy</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-rocket"></i> Sci-Fi</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-dragon"></i> Fantasy</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-shopping-cart"></i> Store
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-laptop"></i> Gaming PCs</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-headset"></i> Accessories</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-tshirt"></i> Merchandise</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-trophy"></i> Tournaments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-users"></i> Community</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about"><i class="fas fa-info-circle"></i> About</a>
                    </li>
                </ul>
                <div class="nav-extras ms-auto">
                    <button class="btn btn-outline-light" id="searchBtn"><i class="fas fa-search"></i></button>
                    <button class="btn btn-outline-light" id="themeToggle"><i class="fas fa-moon"></i></button>
                    <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign Up</button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" id="loginBtn">Login</button>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="modal fade" id="signUpModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light border-0">
      <div class="modal-header">
        <h5 class="modal-title">Create Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" id="su-username" class="form-control" minlength="2" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" id="su-email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" id="su-password" class="form-control" minlength="6" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="tel" id="su-phone" class="form-control" placeholder="+1 555 555 5555">
        </div>
        <div class="mb-3">
          <label class="form-label">Profile Picture</label>
          <input type="file" id="su-avatar" class="form-control" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="su-submit">Sign Up</button>
      </div>
    </div>
  </div>
 </div>
 <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-animate">
    <div class="modal-content bg-dark text-light border-0">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" id="li-username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" id="li-password" class="form-control" required>
        </div>
        <div class="mt-2">
          <small class="text-muted">Don't have an account? <a href="#" id="openRegister" class="link-info">Register</a></small>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="li-submit">Login</button>
      </div>
    </div>
  </div>
 </div>
 <style>
 .modal-animate { transform: translateY(20px) scale(0.98); transition: transform .2s ease, opacity .2s ease; }
 .modal.show .modal-animate { transform: translateY(0) scale(1); }
 @media (max-width: 576px) { .modal-dialog.modal-md { max-width: 95%; margin: 0 auto; } }
 </style>
 <script>
 (function(){
  window.IS_LOGGED_IN = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
  function postForm(url, data) {
    return fetch(url, {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams(data)
    }).then(r => r.json().then(j => ({ ok: r.ok, data: j })));
  }
  let CSRF_TOKEN = null;
  async function ensureCsrf() {
    if (CSRF_TOKEN) return CSRF_TOKEN;
    try {
      const r = await fetch('php_admin/api/csrf.php', { cache:'no-store' });
      const j = await r.json();
      CSRF_TOKEN = j.token;
      return CSRF_TOKEN;
    } catch(e) { return null; }
  }
   const suBtn = document.getElementById('su-submit');
   if (suBtn) {
     suBtn.addEventListener('click', async function(){
       const username = document.getElementById('su-username').value.trim();
       const email = document.getElementById('su-email').value.trim();
      const password = document.getElementById('su-password').value;
      const phone = document.getElementById('su-phone').value.trim();
      const avatarEl = document.getElementById('su-avatar');
      if (!username || username.length < 2) { alert('Username must be at least 2 characters'); return; }
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert('Enter a valid email'); return; }
      if (!password || password.length < 6) { alert('Password must be at least 6 characters'); return; }
      if (phone && !/^[0-9+\-() ]{7,20}$/.test(phone)) { alert('Enter a valid phone'); return; }
      const fd = new FormData();
      fd.append('action','register');
      fd.append('username', username);
      fd.append('email', email);
      fd.append('password', password);
      if (phone) fd.append('phone', phone);
      if (avatarEl && avatarEl.files && avatarEl.files[0]) fd.append('profile_picture', avatarEl.files[0]);
      const token = await ensureCsrf();
      const resRaw = await fetch('php_admin/api/auth.php', { method:'POST', headers: token ? {'X-CSRF-Token': token} : {}, body: fd });
      let resData = null;
      try { resData = await resRaw.json(); } catch(e) { resData = null; }
      const res = { ok: resRaw.ok, data: resData };
       if (res.ok && res.data && res.data.ok) {
         const modal = bootstrap.Modal.getInstance(document.getElementById('signUpModal'));
         if (modal) modal.hide();
         alert('Registration successful. Welcome, ' + res.data.username + '!');
          window.IS_LOGGED_IN = true;
       } else {
         alert(res.data && res.data.error ? res.data.error : 'Registration failed');
       }
     });
   }
   const openRegister = document.getElementById('openRegister');
   if (openRegister) {
     openRegister.addEventListener('click', function(e){
       e.preventDefault();
       const lm = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
       if (lm) lm.hide();
       const sm = new bootstrap.Modal(document.getElementById('signUpModal'));
       sm.show();
     });
   }
   const liBtn = document.getElementById('li-submit');
   if (liBtn) {
     liBtn.addEventListener('click', async function(){
       const username = document.getElementById('li-username').value.trim();
       const password = document.getElementById('li-password').value;
       if (!username || !password) return;
      const token = await ensureCsrf();
      const resRaw = await fetch('php_admin/api/auth.php', {
        method:'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded', ...(token ? {'X-CSRF-Token': token} : {})},
        body: new URLSearchParams({ action:'login', username, password })
      });
      let resData = null;
      try { resData = await resRaw.json(); } catch(e) { resData = null; }
      const res = { ok: resRaw.ok, data: resData };
       if (res.ok && res.data && res.data.ok) {
         const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
         if (modal) modal.hide();
         alert('Logged in as ' + res.data.username);
         window.IS_LOGGED_IN = true;
       } else {
         alert(res.data && res.data.error ? res.data.error : 'Login failed');
       }
     });
   }
 })();
 </script>
