<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: dashboard.php");
  exit;
}

// Include config file
require_once('server/db.php');

$cdate = date("Y-m-d H:i:s");

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ip = $_SERVER['REMOTE_ADDR'];

  // if(isset($_POST['h-captcha-response']) && !empty($_POST['h-captcha-response'])){
  //   $secret = '0x59Fb3D59DA04b6AF996866e611a4cf5993cefAd3';
  //   $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify?secret='.$secret.'&response='.$_POST['h-captcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
  //   $responseData = json_decode($verifyResponse);
  //       if($responseData->success){
  if (1) {
    if (1) {

      $username = mysqli_real_escape_string($conn, $_POST["username"]);
      $password = mysqli_real_escape_string($conn, $_POST["password"]);
      $email = mysqli_real_escape_string($conn, $_POST["email"]);
      $confirm_password = mysqli_real_escape_string($conn, $_POST["confirmpassword"]);
      $hash = md5(rand(0, 1000));

      // Validate email
      if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      }


      // Validate username
      if (empty(trim($username))) {
        $error = "Please enter a username.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      } elseif (strlen(trim($username)) < 2) {
        $error = "Username must have at least 2 characters.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      } elseif (strlen(trim($username)) > 99) {
        $error = "Username cannot have more than 99 characters.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
          // Bind variables to the prepared statement as parameters
          $stmt->bind_param("s", $param_username);

          // Set parameters
          $param_username = trim($username);

          // Attempt to execute the prepared statement
          if ($stmt->execute()) {
            // store result
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
              $error = "This username is already taken.";
              $error = urlencode($error);
              header('Location: register.php?error=' . $error);
              exit();
            } else {
              $username = trim($username);
            }
          } else {
            $error =  "Oops! Something went wrong. Please try again later.";
            $error = urlencode($error);
            header('Location: register.php?error=' . $error);
            exit();
          }

          // Close statement
          $stmt->close();
        }
      }

      // Validate email
      $sql = "SELECT id FROM users WHERE email = ?";

      if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_email);

        // Set parameters
        $param_email = trim($email);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
          // store result
          $stmt->store_result();

          if ($stmt->num_rows > 0) {
            $error = "This email is already taken.";
            $error = urlencode($error);
            header('Location: register.php?error=' . $error);
            exit();
          } else {
            $email = trim($email);
          }
        } else {
          $error = "Oops! Something went wrong. Please try again later.";
          $error = urlencode($error);
          header('Location: register.php?error=' . $error);
          exit();
        }

        // Close statement
        $stmt->close();
      }


      // Validate password
      if (empty(trim($password))) {
        $error = "Please enter a password.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      } elseif (strlen(trim($password)) < 6) {
        $error = "Password must have at least 6 characters.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      } else {
        $password = trim($password);
      }

      // Validate confirm password
      if (empty(trim($confirm_password))) {
        $error = "Please confirm password.";
        $error = urlencode($error);
        header('Location: register.php?error=' . $error);
        exit();
      } else {
        $confirm_password = trim($confirm_password);
        if ($password != $confirm_password) {
          $error = "Password did not match.";
          $error = urlencode($error);
          header('Location: register.php?error=' . $error);
          exit();
        }
      }

      // Prepare an insert statement
      $sql = "INSERT INTO users (username, password, email, hash, ip) VALUES (?, ?, ?, ?, ?)";

      if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $param_username, $param_password, $email, $hash, $ip);

        // Set parameters
        $param_username = preg_replace("/[^A-Za-z0-9 ]/", '', $username);
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
          // Redirect to login page


          $to      = $email; // Send email to our user
          $subject = 'Signup | Verification'; // Give the email a subject 
          $message = 'Hello ' . $param_username . ', Thanks for signing up!
Your account has been created, but requires email verification.


Please click this link to activate your account:
http://www.trixdev.me/w/smart/ver.php?email=' . $email . '&hash=' . $hash . '		
'; // Our message above including the link

          $headers = 'From:noreply@trixdev.me' . "\r\n"; // Set from headers
          if (!empty($email)) {
            mail($to, $subject, $message, $headers); // Send our email
          }



          header("location: login.php?success");
        } else {
          $error = "Something went wrong. Please try again later.";
          $error = urlencode($error);
          header('Location: register.php?error=' . $error);
          exit();
        }

        // Close statement
        $stmt->close();
      }


      // Close connection
      $conn->close();
    } else {
      $error = "Please fill in all fields.";
      $error = urlencode($error);
      header('Location: register.php?error=' . $error);
      exit();
    }
  } else {
    $error = "Please fill in all fields.";
    $error = urlencode($error);
    header('Location: register.php?error=' . $error);
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>SmartStore - Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <link rel="shortcut icon" href="assets/images/favicon.ico">
  <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />
  <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
  <script src="https://hcaptcha.com/1/api.js?hl=en" async defer></script>
</head>

<body data-topbar="dark" data-layout-mode="dark" data-sidebar="dark" style="display: flex;justify-content: center;align-items: center;height: 100vh;">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-lg-4">
        <div class="card login-box-container">
          <div class="card-body">
            <div class="navbar-brand-box" style="margin: auto;">

              <a href="index.php" class="logo logo-light" style="text-align: center;">
                <span class="logo-sm">
                  <img src="assets/images/logo-sm.svg" alt="" height="30">
                </span>
                <span class="logo-lg">
                  <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">SmartStore</span>
                </span>
              </a>
            </div>
            <div class="authent-text">
              <p>Welcome to Smart Store</p>
              <p>Enter your details to create your account</p>
            </div>
            <?php

            if (isset($_GET['error'])) {
              $error = urldecode($_GET['error']);
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ' . $error . '</div>';
            } elseif (isset($_GET['success'])) {
              $success = urldecode($_GET['success']);
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> ' . $success . '</div>';
            }


            ?>
            <form method="post">
              <div class="mb-3">
                <div class="form-floating">
                  <input type="email" class="form-control" id="floatingInput" placeholder="email" name="email">
                  <label for="floatingInput">Email</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingInput1" placeholder="Username" name="username">
                  <label for="floatingInput">Username</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                  <label for="floatingPassword">Password</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="password" class="form-control" id="floatingPassword1" placeholder="Confirm Password" name="confirmpassword">
                  <label for="floatingPassword">Confirm Password</label>
                </div>
              </div>

              <div class="mb-3">
                <div class="h-captcha" data-sitekey="1ea3ac6b-f8d4-4cb6-9e66-98dcfda3d292" data-theme="dark"></div>
              </div>

              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">I agree the Terms and Conditions</label>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-secondary m-b-xs mb-1">Register</button>
              </div>
            </form>
            <div class="authent-login">
              <p>Already have an account? <a href="login.php">Sign in</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="rightbar-overlay"></div>
  <script src="assets/libs/jquery/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/metismenu/metisMenu.min.js"></script>
  <script src="assets/libs/feather-icons/feather.min.js"></script>
  <script src="assets/js/app.js"></script>
</body>

</html>