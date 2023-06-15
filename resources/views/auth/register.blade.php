<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <link rel="stylesheet"  href="/styles/register.css">
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
      <h1>Registration Form</h1>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required>
          @error('name')
            <span class="error">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
          @error('username')
            <span class="error">{{ $message }}</span>
          @enderror
        </div>

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
          <label for="password_confirmation">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group">
          <button type="submit">Register</button>
        </div>
      </form>

      <p class="login-link">If you already have an account, <a href="{{ route('login')}}">login here</a>.</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>
</body>
</html>
