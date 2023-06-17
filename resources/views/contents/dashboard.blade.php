<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="styles/dashboard.css" rel="stylesheet">
  <link href="styles/styles.css" rel="stylesheet">
  <title>My website</title>
  
</head>

<body>
  <div class="dashboard-container">
    <div class="profile-area">
      <!-- Display user profile here -->
      <h2 class="log-user">{{ Auth::user()->name }}</h2>
      <p>Email: {{ Auth::user()->email }}</p>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-button">Logout</button>
      </form>
    </div>
    <div class="message-container">
      <div class="user-selection">
        <h2>Users</h2>
        <input type="text" id="user-search" placeholder="Search users">
        <ul class="user-list">
          <!-- Display list of registered users here -->
          @foreach($users as $user)
            @if($user->id !== Auth::user()->id)
              <li class="user" data-user-id="{{ $user->id }}">
                {{ $user->name }}
              </li>
            @endif
          @endforeach
        </ul>
      </div>
      <div class="message-area">
        <div class="message-header">
          <a href="/" class="home-tab">Home</a>
          <a href="/index" class="back-tab">Back</a>
          <h2 class="receiver-name"></h2>
        
        </div>
        <div class="dialog-container">
          <div class="messages">
            <!-- Display messages here -->
          </div>
          <div class="message-input">
            <form id="message-form" action="{{ route('dashboard') }}" method="POST">
              @csrf
              <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}">
              <input type="hidden" name="receiver_id" id="receiver-id" value="">
              <input type="text" name="message" placeholder="Type your message" class="message-text">
              <button type="submit" class="send-button">Send</button>
            </form>
          </div>
        </div>
        <div class="notification-area">
          <!-- Display notifications here -->
        </div>
      </div>
    </div>
  </div>
  <script src="JS/dashboard.js"></script>
  
  
</body>

</html>
