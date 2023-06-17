// Get DOM elements
const userList = document.querySelector('.user-list');
const userSearch = document.querySelector('#user-search');
const messagesContainer = document.querySelector('.messages');
const messageForm = document.querySelector('#message-form');
const messageInput = document.querySelector('.message-text');
const sendButton = document.querySelector('.send-button');
const receiverNameElement = document.querySelector('.receiver-name');
const receiverIdInput = document.querySelector('#receiver-id');

// '{{ $senderName }}'
const senderName = "{{ Auth::user()->name }}";
// Handle user selection
userList.addEventListener('click', event => {
  const selectedUser = event.target;
  if (selectedUser.classList.contains('user')) {
    const receiverId = selectedUser.dataset.userId;
    const receiverName = selectedUser.textContent;

    // Update message input placeholder
    messageInput.placeholder = `Message ${receiverName}`;
    receiverNameElement.textContent = receiverName;
    receiverNameElement.dataset.senderName = senderName;
    receiverIdInput.value = receiverId;

    // Fetch messages for the selected user
    fetchMessages(receiverId);
  }
});

// Function to display messages
function displayMessages(messages) {
  messagesContainer.innerHTML = '';
  messages.forEach(message => {
    displayMessage(message);
  });
}

// Function to display a single message
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

// Function to delete a message
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

// Function to show a notification
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

// Function to fetch messages for the selected user
function fetchMessages(userId) {
  // Send request to fetch messages
  fetch(`/messages/fetch/${userId}`)
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        const messages = result.messages;
        displayMessages(messages);
      } else {
        console.error(result.message);
        showNotification('Error fetching messages. Please try again later.', 5000);
      }
    })
    .catch(error => {
      console.error(error);
      showNotification('Error fetching messages. Please try again later.', 5000);
    });
}

// Handle sending a new message
messageForm.addEventListener('submit', event => {
  event.preventDefault();

  const formData = new FormData(messageForm);
  const receiverName = receiverNameElement.textContent; // Store the receiver name
  const senderName = receiverNameElement.dataset.senderName;

  // Send the message via AJAX request
  fetch(messageForm.action, {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Display success message or update the messages list
        const message = {
          sender: senderName,
          text: formData.get('message'),
          liked: false
        };
        displayMessage(message);

        // Clear the message input
        messageInput.value = '';

        // Show notification
        showNotification(`Message sent to ${receiverName}`, 5000);
      } else {
        // Error sending the message
        console.error(data.message);
        showNotification('Error sending the message. Please try again later.', 5000);
      }
    })
    .catch(error => {
      console.error(error);
      showNotification('Error sending the message. Please try again later.', 5000);
    });
});
