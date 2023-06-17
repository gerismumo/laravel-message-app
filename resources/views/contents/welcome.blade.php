<!DOCTYPE html>
<html>
<head>
  <title>My Website</title>
  <link rel="stylesheet"  href="/styles/welcome.css">
</head>
<body>
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="/">Home</a></li>
        <li><a href="/">About</a></li>
        <li><a href="{{ route('register')}}">Register</a></li>
        <li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Login</a>
          <div class="dropdown-content">
            <a href="{{ route('login')}}">User Login</a>
            <a href="{{ route('admin')}}">Admin Login</a>
          </div>
        </li>
      </ul>
    </nav>
  </header>

  <main class="content">
    <section>
      <h1>Laravel Messenger</h1>
      <p>Try a chat</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>
</body>
</html>
