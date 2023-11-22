<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <div class="login-form">
      <img src="logo.png" alt="Logo" class="logo">
      <h1>Login</h1>

      <form id="login-form" action="loginScript.php" method="post" onsubmit="test(event)">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email address">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">
        <button type="submit">Login</button>
      </form>

      <a href="register.html" class="registration-button">Sign Up</a>

      <!-- Display error message if there is an error -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message" id="error-message">
          <?php echo $_SESSION['error']; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>