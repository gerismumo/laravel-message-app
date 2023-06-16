<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="styles/dashboard.css" rel="stylesheet">
  {{-- <link href="styles/styles.css" rel="stylesheet"> --}}
  <title>My website</title>
</head>

<body>
  <div class="message-container">
    <div class="user-selection">
      <h2>Users</h2>
      <input type="text" id="user-search" placeholder="Search users">
      <ul class="user-list">
        {{-- <!-- User list items -->
        {{-- @foreach($users as $user)
        <li class="user" data-user-id="{{ $user->id }}">
          {{ $user->name }}
          {{-- @if(Auth::user()->isAdmin()) 
          <input type="button" class="delete-button" value="delete">
          {{-- @endif 
        </li>
        @endforeach --}}
      </ul>
    </div>
    <div class="message-area">
      <div class="message-header">
        <a href="/" class="home-tab">Home</a>
        <a href="{{ route('index') }}" class="back-tab">Back</a>
        <h2 class="receiver-name"></h2>
      </div>
      <div class="dialog-container">
        <div class="messages">
          <!-- Display messages here -->
        </div>
        <div class="message-input">
          <input type="text" placeholder="Type your message" class="message-text">
          <button class="send-button">Send</button>
        </div>
      </div>
      <div class="notification-area">
        <!-- Display notifications here -->
      </div>
    </div>
  </div>

  <script>
    // Get DOM elements
    const userList = document.querySelector('.user-list');
    const userSearch = document.querySelector('#user-search');
    const messagesContainer = document.querySelector('.messages');
    const messageInput = document.querySelector('.message-text');
    const sendButton = document.querySelector('.send-button');

    // Handle user selection
    userList.addEventListener('click', event => {
      const selectedUser = event.target;
      if (selectedUser.classList.contains('user')) {
        const receiverId = selectedUser.dataset.userId;
        const receiverName = selectedUser.textContent;

        // Update message input placeholder
        messageInput.placeholder = `Message ${receiverName}`;

        // Fetch messages for the selected user
        // Simulating the messages for demonstration purposes
        const messages = [
          // { id: 1, sender: 'User 1', text: 'Hello', liked: false },
          // { id: 2, sender: 'User 2', text: 'Hi', liked: false },
          // { id: 3, sender: 'User 1', text: 'How are you?', liked: false }
        ];
        displayMessages(messages, receiverName);

        // Handle sending a new message
        sendButton.addEventListener('click', () => {
          const text = messageInput.value.trim();
          if (text !== '') {
            const senderName = getSenderName(); // Get the sender name

            // Simulating the creation of a new message for demonstration purposes
            const newMessage = {
              id: Math.floor(Math.random() * 1000) + 1,
              sender: senderName,
              text: text,
              liked: false
            };
            displayMessage(newMessage);

            // Clear message input
            messageInput.value = '';

            // Show notification
            showNotification(`Message sent to ${receiverName}`, 5000);
          }
        });
      }
    });

    // Handle delete user button click
    userList.addEventListener('click', event => {
      const selectedUser = event.target;
      if (selectedUser.classList.contains('delete-button')) {
        const userItem = selectedUser.parentNode;
        const userId = userItem.dataset.userId;

        // Perform the delete user action
        deleteUser(userId);

        // Remove the user from the user list
        userItem.remove();
      }
    });

    // Delete user function
    function deleteUser(userId) {
      console.log(`Deleting user with ID ${userId}`);
    }

    // Handle user search
    userSearch.addEventListener('input', () => {
      const searchTerm = userSearch.value.toLowerCase();
      const users = document.querySelectorAll('.user-list li');
      users.forEach(user => {
        const userName = user.textContent.toLowerCase();
        if (userName.includes(searchTerm)) {
          user.style.display = 'block';
        } else {
          user.style.display = 'none';
        }
      });
    });

    // Get the sender name
    function getSenderName() {
      // Simulating the sender name for demonstration purposes
      return 'Admin';
    }

    // Display messages in the dialog
    function displayMessages(messages, receiverName) {
      messagesContainer.innerHTML = '';
      messages.forEach(message => {
        displayMessage(message);
      });
      // Update receiver name in the dialog header
      const receiverNameHeader = document.querySelector('.receiver-name');
      receiverNameHeader.textContent = receiverName;
    }

    // Display a single message
    function displayMessage(message) {
      const messageElement = document.createElement('div');
      messageElement.classList.add('message');

      const senderName = message.sender;

      messageElement.innerHTML = `
        <p><strong>${senderName}:</strong> ${message.text}</p>
        <button class="like-button">Like</button>
        <button class="delete-button">Delete</button>
      `;

      // Handle like button click
      const likeButton = messageElement.querySelector('.like-button');
      likeButton.addEventListener('click', () => {
        if (!message.liked) {
          likeButton.textContent = 'Unlike';
          message.liked = true;
          // Handle liking the message
        } else {
          likeButton.textContent = 'Like';
          message.liked = false;
          // Handle unliking the message
        }
      });

      // Handle delete button click
      const deleteButton = messageElement.querySelector('.delete-button');
      deleteButton.addEventListener('click', () => {
        messageElement.remove();
        // Handle deleting the message
      });

      messagesContainer.appendChild(messageElement);
    }

    // Show notification in the notification area
    function showNotification(message, duration = 3000) {
      const notificationArea = document.querySelector('.notification-area');
      const notificationElement = document.createElement('div');
      notificationElement.classList.add('notification');
      notificationElement.textContent = message;
      notificationArea.appendChild(notificationElement);

      setTimeout(() => {
        notificationElement.remove();
      }, duration);
    }
  </script>
</body>

</html>
