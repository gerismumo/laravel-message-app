<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  <link rel="stylesheet"  href="/styles/login.css">
</head>
<body>
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="/">Home</a></li>
        <li><a href="/">About</a></li>
      </ul>
    </nav>
  </header>

  <main class="content">
    <section>
      <h1>Login Form</h1>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
          @error('email')
            <span class="error">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
          @error('password')
            <span class="error">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <button type="submit">Login</button>
        </div>
      </form>

      <p class="register-link">If you haven't registered yet, <a href="{{ route('register') }}">register here</a>.</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>
</body>
</html>
