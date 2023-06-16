<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="styles/dashboard.css" rel="stylesheet">
  <link href="styles/styles.css" rel="stylesheet">
  @csrf
  <title>My website</title>
</head>

<body>
  <div class="dashboard-container">
    <div class="profile-area">
      <!-- Display user profile here -->
      <h2>{{ Auth::user()->name }}</h2>
      <p>Email: {{ Auth::user()->email }}</p>
      <a href="{{ route('logout') }}" class="logout-button">Logout</a>
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
        displayMessages(messages, receiverName, receiverId);

        // Handle sending a new message
        sendButton.addEventListener('click', () => {
          const text = messageInput.value.trim();
          if (text !== '') {
            const senderName = getSenderName(); // Get the sender name

            // Send the message data to the server
            fetch('/messages/send', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add Laravel CSRF token
              },
              body: JSON.stringify({
                sender_id: '{{ Auth::user()->id }}',
                receiver_id: receiverId,
                message: text
              })
            })
            .then(response => response.json())
            .then(result => {
              if (result.success) {
                // Message sent successfully
                const newMessage = {
                  id: result.message.id,
                  sender: senderName,
                  text: text,
                  liked: false
                };
                displayMessage(newMessage);
                messageInput.value = '';

                // Show notification
                showNotification(`Message sent to ${receiverName}`, 5000);
              } else {
                // Error sending the message
                console.error(result.message);
                showNotification('Error sending the message. Please try again later.', 5000);
              }
            })
            .catch(error => {
              console.error(error);
              showNotification('Error sending the message. Please try again later.', 5000);
            });
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
      return '{{ Auth::user()->name }}';
    }

    // Display messages in the dialog
    function displayMessages(messages, receiverName, receiverId) {
      messagesContainer.innerHTML = '';
      messages.forEach(message => {
        displayMessage(message);
      });
      // Update receiver name in the dialog header
      const receiverNameHeader = document.querySelector('.receiver-name');
      receiverNameHeader.textContent = receiverName;
      receiverNameHeader.dataset.receiverId = receiverId;
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
        deleteMessage(message.id);
        messageElement.remove();
      });

      messagesContainer.appendChild(messageElement);
    }

    // Delete message function
    function deleteMessage(messageId) {
      // Send the delete request to the server
      fetch(`/messages/delete/${messageId}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add Laravel CSRF token
        }
      })
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          // Message deleted successfully
          showNotification('Message deleted', 5000);
        } else {
          // Error deleting the message
          console.error(result.message);
          showNotification('Error deleting the message. Please try again later.', 5000);
        }
      })
      .catch(error => {
        console.error(error);
        showNotification('Error deleting the message. Please try again later.', 5000);
      });
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
