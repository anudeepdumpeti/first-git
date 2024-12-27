<?php
// Start session
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ecommerce");  // Update with your DB credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  // 's' stands for string

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create a session for the user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the user's dashboard or homepage
            header("Location: index.html");
            exit;
        } else {
            // Incorrect password
            $error = "Wrong username or password.";
        }
    } else {
        // Username not found
        $error = "Wrong username or password.";
    }

    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Box icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
  </head>
  <body>
    <!-- Navigation -->
    <div class="top-nav">
      <div class="container d-flex">

        <script>
          function openWhatsApp() {
            if (confirm("Do you want to contact us on WhatsApp?")) {
              window.open("https://wa.me/+911234567890", "_blank"); <!-- Add your mobile number-->
            }
          }
        </script>
      </head>
      <body>
        <p><a href="#" onclick="openWhatsApp()">Order Online Or Call Us: (+91) 1234567890</a></p> <!-- Add your mobile number-->
        <ul class="d-flex">
          <li><a href="about.html">About Us</a></li>
          <li><a href="contact.html">FAQ</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
    </div>
    <div class="navigation">
      <div class="nav-center container d-flex">

        <a href="index.html" class="logo"><h1>Hanger<img src="images/logo.jpeg" alt="Logo" 
          style="height: 40px; margin-right: 10px;  width: 60px; height: 60px; border-radius: 50px; margin: 5px;"></h1></a>
        
        <ul class="nav-list d-flex">
          <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="product.html" class="nav-link">Shop</a>
          </li>
          <li class="nav-item">
            <a href="terms.html" class="nav-link">Terms</a>
          </li>
          <li class="nav-item">
            <a href="about.html" class="nav-link">About</a>
          </li>
          <li class="nav-item">
            <a href="contact.html" class="nav-link">Contact</a>
          </li>
        </ul>

        <div class="icons d-flex">
          <a href="login.html" class="icon">
              <i class="bx bx-user"></i>
          </a>
          <a href="search.html" class="icon">
              <i class="bx bx-search"></i>
          </a>
          <a href="login.html" class="icon">
              <i class="bx bx-cart"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- Login -->
    <div class="container">
      <div class="login-form">
        <form action="login.php" method="post">
          <h1>Login</h1>
          <p>
            Already have an account? Login in or <a href="signup.html">Sign Up</a>
          </p>
          
          <p>
            <a href="forgot-password.html">Forgot Password?</a>
          </p>

          <label for="email">Email</label>
          <input type="email" placeholder="Enter Email" name="username" required>

          <label for="psw">Password</label>
          <input type="password" placeholder="Enter Password" name="password" required>
          
          <label>
            <input type="checkbox" name="remember" style="margin-bottom: 15px"> Remember me
          </label>

          <p>
            By creating an account you agree to our <a href="terms.html">Terms & Privacy</a>.
          </p>

          <div class="buttons">
            <button  type="button" class="cancelbtn">Cancel</button>
            <button type="submit" class="signupbtn">Login</button>
          </div>

	 <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        </form>
      </div>
    </div>


    <!-- Custom Script -->
    <script src="js/index.js"></script>
  </body>
</html>
