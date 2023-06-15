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
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="{{ route('register')}}">Register</a></li>
        <li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Login</a>
          <div class="dropdown-content">
            <a href="{{ route('login')}}">User Login</a>
            <a href="#">Admin Login</a>
          </div>
        </li>
      </ul>
    </nav>
  </header>

  <main class="content">
    <section>
      <h1>Laravel Messenger</h1>
      <p>This is the content area where you can display the Laravel Messenger text or any other content you'd like.</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>
</body>
</html>
