<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Contact Message</title>
  <style>
    /* General Styles */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333333;
    }

    .email-container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      padding: 20px;
    }

    .header {
      background-color: #1e3a8a;
      /* AdminLTE primary blue */
      color: #ffffff;
      padding: 20px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }

    .content {
      padding: 20px;
      line-height: 1.6;
    }

    .content p {
      margin: 10px 0;
    }

    .label {
      font-weight: bold;
      color: #1e3a8a;
    }

    .divider {
      border-top: 1px solid #e0e0e0;
      margin: 20px 0;
    }

    .footer {
      font-size: 12px;
      color: #888888;
      text-align: center;
      padding: 15px;
    }

    /* Button (optional) */
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #1e3a8a;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="email-container">
    {{-- Header --}}
    <div class="header">
      New Contact Message
    </div>

    {{-- Content --}}
    <div class="content">
      <p><span class="label">Name:</span> {{ $data['name'] }}</p>
      <p><span class="label">Email:</span> {{ $data['email'] }}</p>
      <p><span class="label">Subject:</span> {{ $data['subject'] }}</p>

      <div class="divider"></div>

      <p>{{ $data['message'] }}</p>

      {{-- Optional button --}}
      {{-- <a href="mailto:{{ $data['email'] }}" class="btn">Reply to User</a> --}}
    </div>

    {{-- Footer --}}
    <div class="footer">
      &copy; {{ date('Y') }} Your Company / School Name. All rights reserved.
    </div>
  </div>
</body>

</html>
