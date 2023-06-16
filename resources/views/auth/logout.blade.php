<!DOCTYPE html>
<html>
<head>
  <title>Logout Form</title>
  <link rel="stylesheet"  href="/styles/logout.css">
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
      <h1>Logout Form</h1>

      <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-button">Logout</button>
      </form>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>

  <script>
    document.getElementById('logout-form').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent the default form submission
      this.submit(); // Manually submit the form
    });
  </script>
</body>
</html>
