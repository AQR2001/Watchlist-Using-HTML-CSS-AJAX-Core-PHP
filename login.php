<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Support Ticket System</title>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to right, #e3f2fd, #fce4ec);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #2c3e50;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #2e7d32;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background: #1b5e20;
    }
  </style>
</head>

<body>

  <div class="login-box">
    <h2>Login</h2>
    <h3 style="color: <?= $_REQUEST['color'] ?? '' ?>;"><?= $_REQUEST['msg'] ?? '' ?></h3>
    <form id="loginForm" action="process.php" method="POST">
      <input type="text" id="email" name="email" placeholder="Email" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
    </form>
  </div>

</body>

</html>