<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      padding: 20px;
    }

    .card {
      max-width: 500px;
      margin: auto;
      background: #ffffff;
      border-radius: 8px;
      padding: 25px;
      text-align: center;
    }

    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 25px;
      background: #0d6efd;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .footer {
      font-size: 12px;
      color: #999;
      margin-top: 20px;
    }

    .card .heading {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 1.5rem;
      color: rgb(0, 179, 0);
    }

    .card p {
      font-size: 20px;
      font-weight: bold;
    }

    .card .acivate {
      color: white;
      font-weight: bold;
      font-size: 20px;
    }
  </style>
</head>

<body>

  <div class="card">
    <h2 class="text-success heading">Welcome, {{ $user->name }} 👋</h2>

    <p>Thanks for signing up. Please activate your account by clicking the button below.</p>

    <a href="{{ route('activate.account', $user->activation_token) }}" class="btn acivate">
      Activate Account
    </a>

    <p class="footer">
      This link will expire in 24 hours.<br>
      If you didn’t create this account, ignore this email.
    </p>
  </div>

</body>

</html>
