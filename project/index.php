<?php
session_start();
include 'db_conn.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Variables to store specific errors
$emailError = "";
$passError = "";
$enteredEmail = ""; // To keep email in box if password is wrong

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $enteredEmail = $email; // Save entered email

    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify Password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['fullname'];
            header("Location: dashboard.php");
            exit();
        } else {
            $passError = "Wrong Password";
        }
    } else {
        $emailError = "Wrong Email";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - VIP Portal</title>
  <link rel="stylesheet" href="auth_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- Simple Background -->
  <div class="auth-container">
    <div class="auth-header">
      <h2>Welcome Back</h2>
      <p>Login to DSA Visualization</p>
    </div>
    
    <form method="POST" action="">
      
      <div class="input-group">
        <label>Email Address</label>
        <div class="input-wrapper">
          <input type="email" name="email" 
                 class="<?php if($emailError != "") echo 'error'; ?>" 
                 value="<?php echo $enteredEmail; ?>" 
                 placeholder="name@example.com" required />
          <i class="fa-solid fa-envelope"></i>
        </div>
        <?php if($emailError != "") { echo "<div class='error-msg'>$emailError</div>"; } ?>
      </div>

      <div class="input-group">
        <label>Password</label>
        <div class="input-wrapper">
          <input type="password" name="password" 
                 class="<?php if($passError != "") echo 'error'; ?>" 
                 placeholder="Enter password" required />
          <i class="fa-solid fa-lock"></i>
        </div>
        <?php if($passError != "") { echo "<div class='error-msg'>$passError</div>"; } ?>
      </div>

      <button type="submit" class="btn-auth">Sign In</button>
    </form>

    <div class="auth-footer">
      New here? <a href="register.php">Create an Account</a>
    </div>
  </div>
</body>
</html>
