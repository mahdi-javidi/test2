<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 - Not Found</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #ff7a00, #00d9d9);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      text-shadow: 0 2px 10px rgba(0,0,0,0.4);
    }
    .error-box {
      text-align: center;
      padding: 40px;
      background: rgba(0,0,0,0.35);
      border-radius: 20px;
      backdrop-filter: blur(8px);
    }
    .error-code {
      font-size: 120px;
      font-weight: 800;
    }
    .btn-custom {
      background-color: #ff7a00;
      border: none;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #e86c00;
    }
  </style>
</head>
<body>
  <div class="error-box">
    <div class="error-code">404</div>
    <h2 class="mb-3">Oops! Page Not Found</h2>
    <p class="mb-4">Looks like you took a wrong turn in the game.<br>Don't worry, let's get you back on track!</p>
    <a href="/" class="btn btn-custom btn-lg text-white">Return Home</a>
  </div>
</body>
</html>
