<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $setting->site_name ?? 'CourseEdx' }}</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- FontAwesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  {{-- Toastr CSS (GLOBAL) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  {{-- Tailwind CSS --}}
  {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('storage/' . $setting->favion) }}" type="image/x-icon">


  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <style>
    #chat-toggle {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 60px;
      height: 60px;
      background: #0B8E96;
      color: white;
      font-size: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      z-index: 999;
    }

    #chat-container {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      height: 420px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 999;
    }

    .chat-header {
      background: #4f46e5;
      color: white;
      padding: 12px;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
    }

    .chat-body {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      background: #f5f5f5;
    }

    .bot-message {
      background: white;
      padding: 8px 12px;
      border-radius: 10px;
      margin-bottom: 8px;
      width: fit-content;
    }

    .user-message {
      background: #4f46e5;
      color: white;
      padding: 8px 12px;
      border-radius: 10px;
      margin-left: auto;
      margin-bottom: 8px;
      width: fit-content;
    }

    .chat-footer {
      display: flex;
      border-top: 1px solid #ddd;
    }

    #chat-input {
      flex: 1;
      border: none;
      padding: 10px;
      outline: none;
    }

    #send-btn {
      background: #4f46e5;
      color: white;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
    }

    #chat-close {
      cursor: pointer;

    }
  </style>

  @stack('styles')
</head>

<body>

  {{-- Navbar --}}
  @include('home.partials.navbar')

  {{-- Header --}}
  @include('home.partials.header')

  {{-- MAIN CONTENT --}}
  <main>

    @yield('content')
  </main>

  <!-- Chat Icon -->
  <div id="chat-toggle">
    <i class="fas fa-comments"></i>
  </div>

  <!-- Chat Box -->
  <div id="chat-container">
    <div class="chat-header">
      LMS Assistant
      <span id="chat-close">✖</span>
    </div>

    <div class="chat-body" id="chat-body">
      <div class="bot-message">Hello 👋 How can I help you?</div>
    </div>

    <div class="chat-footer">
      <input type="text" id="chat-input" placeholder="Type a message...">
      <button id="send-btn">Send</button>
    </div>
  </div>
  {{-- Footer --}}
  @include('home.partials.footer')


  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  {{-- jQuery (Required for Toastr) --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  {{-- Toastr JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  {{-- GLOBAL TOAST MESSAGE --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      toastr.options = {
        closeButton: true,
        progressBar: true,
        timeOut: 3000,
        extendedTimeOut: 1000,
        positionClass: "toast-top-right",
      };

      @if (session('success'))
        toastr.success(@json(session('success')));
      @endif

      @if (session('error'))
        toastr.error(@json(session('error')));
      @endif
    });
  </script>

  {{-- Global Custom Scripts --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const clearBtn = document.querySelector('.clear-icon');
      const searchInput = document.querySelector('.search-input');

      if (clearBtn && searchInput) {
        clearBtn.addEventListener('click', function() {
          searchInput.value = '';
          searchInput.focus();
        });
      }

      const hamburger = document.querySelector('.hamburger');
      const navLinks = document.querySelector('.nav-links');

      if (hamburger && navLinks) {
        hamburger.addEventListener('click', function() {
          navLinks.classList.toggle('active');
        });
      }

    });
  </script>

  <script>
    const chatToggle = document.getElementById("chat-toggle");
    const chatBox = document.getElementById("chat-container");
    const chatClose = document.getElementById("chat-close");

    chatToggle.onclick = () => {
      chatBox.style.display = "flex";
    }

    chatClose.onclick = () => {
      chatBox.style.display = "none";
    }

    const sendBtn = document.getElementById("send-btn");
    const input = document.getElementById("chat-input");
    const body = document.getElementById("chat-body");

    sendBtn.onclick = function() {

      let message = input.value;

      if (message == "") return;

      body.innerHTML += `<div class="user-message">${message}</div>`;

      fetch('/chatbot/message', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            message: message
          })
        })
        .then(res => res.json())
        .then(data => {
          body.innerHTML += `<div class="bot-message">${data.reply}</div>`;
          console.log(data.reply);

        });

      input.value = "";
    }
  </script>

  {{-- Page Specific Scripts --}}
  @stack('js')

</body>

</html>
