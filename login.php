<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Include config file
require_once('server/db.php');

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

$cdate = date("Y-m-d H:i:s");

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


  // if(isset($_POST['h-captcha-response']) && !empty($_POST['h-captcha-response'])){
  //     $secret = '0x59Fb3D59DA04b6AF996866e611a4cf5993cefAd3';
  //     $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify?secret='.$secret.'&response='.$_POST['h-captcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
  //     $responseData = json_decode($verifyResponse);
  //         if($responseData->success){
    if(1){
      if(1){

    $user = mysqli_real_escape_string ($conn,$_POST["username"]);
    $pwd = mysqli_real_escape_string ($conn,$_POST["password"]);

    // Check if username is empty
    if (empty(trim($user))) {
      $error = "Please enter your username.";
      $error = urlencode($error);
      header('Location: login.php?error='.$error);
      exit();
    } else {
        $username = trim($user);
    }

    // Check if password is empty
    if (empty(trim($pwd))) {
      $error = "Please enter your password.";
      $error = urlencode($error);
      header('Location: login.php?error='.$error);
      exit();
    } else {
        $password = trim($pwd);
    }

        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE username = ?";

            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);

                // Set parameters
                $param_username = $username;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {

                    // Store result
                    $stmt->store_result();

                    // Check if username exists, if yes then verify password
                    if ($stmt->num_rows == 1) {

                        // Bind result variables

                        $stmt->bind_result($id, $username, $hash_password, $admin, $email, $ip, $verified, $hash, $dark);
                        if ($stmt->fetch()) {
                            if (password_verify($password, $hash_password)) {

                                if(!$verified){
                                  $error = "Please verify your email address.";
                                  $error = urlencode($error);
                                  header('Location: login.php?error='.$error);
                                  exit();
                                }
                                // Password is correct, so start a new session
                                session_start();

                                // Store data in session variables
                                $username = ucfirst($username);
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["admin"] = $admin;
                                $_SESSION["email"] = $email;
                                $_SESSION["dark"] = $dark;





                                // Redirect user to welcome page
                                
                                header("location: index.php");
                            } else {
                                // Display an error message if password is not valid
                                $error = "No account found.";
                                $error = urlencode($error);
                                header('Location: login.php?error='.$error);
                                exit();
                            }
                        }
                    } else {
                      $error = "No account found.";
                      $error = urlencode($error);
                      header('Location: login.php?error='.$error);
                      exit();
                    }
                } else {
                  $error = "Oops! Something went wrong. Please try again later.";
                  $error = urlencode($error);
                  header('Location: login.php?error='.$error);
                  exit();
                }

                // Close statement
                $stmt->close();
            }
    
    // Close connection
    $conn->close();
        }else{
            $error = "Please verify you are a human.";
            $error = urlencode($error);
            header('Location: login.php?error='.$error);
            exit();
        }

    }else{
      $error = "Please verify you are a human.";
      $error = urlencode($error);
      header('Location: login.php?error='.$error);
      exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8" />
      <title>SmartStore - Login</title>
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
                <p>Please Sign-in to your account.</p>
              </div>
              <?php
          
          if(isset($_GET['error'])){
            $error = urldecode($_GET['error']);
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '.$error.'</div>';

          }elseif(isset($_GET['success'])){
            $success = urldecode($_GET['success']);
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> '.$success.'</div>';
          }


          ?>
              <form method="post">
                <div class="mb-3">
                  <div class="form-floating">
                    <input name="username" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Username</label>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="form-floating">
                    <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                  </div>
                  <p style="margin-top: 4px;text-align: right;"><a href="reset.php">Forgot your password?</a></p>
                </div>
                

                
                <div class="mb-3">
                    <div class="h-captcha" data-sitekey="1ea3ac6b-f8d4-4cb6-9e66-98dcfda3d292" data-theme="dark"></div>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-secondary m-b-xs mb-1">Sign In</button>
                </div>
              </form>
              <div class="authent-reg">
                <p>Not registered? <a href="register.php">Create an account</a>
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






















