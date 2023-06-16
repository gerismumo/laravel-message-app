<!DOCTYPE html>
<html>
<head>
  <title>My Website</title>
  <link rel="stylesheet" href="/styles/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="/">Home</a></li>
        <li><a href="/">About</a></li>
        @if(Auth::check())
          <li class="user-name">Welcome, {{ Auth::user()->name }}</li>
        @else
          <li class="user-name">User not logged in.</li>
        @endif
        <li class="logout"><a href="{{ route('logout')}}">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="content">
    <section>
      <button class="start-chat"><i class="fas fa-comments"></i> <a href="/dashboard">start a chat</a></button>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>
</body>
</html>
