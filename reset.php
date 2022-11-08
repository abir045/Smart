<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Include config file
require_once('server/db.php');

$cdate = date("Y-m-d H:i:s");

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST['h-captcha-response']) && !empty($_POST['h-captcha-response'])){
        $secret = '0x59Fb3D59DA04b6AF996866e611a4cf5993cefAd3';
        $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify?secret='.$secret.'&response='.$_POST['h-captcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
        $responseData = json_decode($verifyResponse);
            if($responseData->success){



        $email = mysqli_real_escape_string ($conn,$_POST["email"]);
        $time = time() + (60 * 15);
        $hash = md5(rand(0, 1000));
		$hashedTime = $hash.','.$time;


         // Validate email
		if (empty(trim($email))) {
            $error = "Please enter your email address.";
            $error = urlencode($error);
            header("location:reset.php?error=". $error);
            exit();
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
            $error = urlencode($error);
            header("location:reset.php?error=". $error);
            exit();
        }else {
			// Prepare a select statement
			$sql = "SELECT * FROM users WHERE email = ?";

			if ($stmt = $conn->prepare($sql)) {
				// Bind variables to the prepared statement as parameters
				$stmt->bind_param("s", $email);


				// Attempt to execute the prepared statement
				if ($stmt->execute()) {
					// store result
					$stmt->store_result();

					if ($stmt->num_rows == 1) {


                    $sql = "UPDATE `users` SET `hash`='$hashedTime' WHERE `email`='$email';";
                    if ($stmt = $conn->prepare($sql)) {
                        if ($stmt->execute()) {
                        } else {
                            echo "Error";
                        }
                    $stmt->close();
                    }
					
                    
$to      = $email; // Send email to our user
$subject = 'Password Reset'; // Give the email a subject 
$message = 'Your requested an password reset.


Please click this link to reset your account:
http://www.trixdev.me/w/smart/resetp.php?email='.$email.'&hash='.$hash.'		

If you didnt request this, please ignore this email.
'; // Our message above including the link
										
					$headers = 'From:noreply@trixdev.me' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send our email
                    header("location:reset.php?success");

					} else {
                        $error = "No account found with that email.";
                        $error = urlencode($error);
                        header("location:reset.php?error=". $error);
                        exit;
					}
				} else {
                    
                    $error = "Something went wrong. Please try again later.";
                    $error = urlencode($error);
                    header("location:reset.php?error=". $error);
                    exit();
				}


			}
		}

    }else{
        $error = "Invalid Captcha";
        $error = urlencode($error);
        header('Location:reset.php?error='.$error);
        exit();
    }
}else{
    $error = "Captcha failed";
    $error = urlencode($error);
    header('Location:reset.php?error='.$error);
    exit();
}

	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8" />
      <title>SmartStore - Reset Password</title>
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
                <p>Password Reset</p>
                <p>Enter your Email and instructions will be sent to you!</p>
              </div>
              <?php
          
                if(isset($_GET['error'])){
                    $error = urldecode($_GET['error']);
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> '.$error.'
                    </div>';

                }elseif(isset($_GET['success'])){
                    $success = urldecode($_GET['success']);
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> '.$success.'
                    </div>';
                }


                ?>
              <form method="post">
                <div class="mb-3">
                  <div class="form-floating">
                    <input name="email" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email</label>
                  </div>
                </div>

                <div class="mb-3">
                    <div class="h-captcha" data-sitekey="1ea3ac6b-f8d4-4cb6-9e66-98dcfda3d292" data-theme="dark"></div>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-secondary m-b-xs mb-1">Reset</button>
                </div>
              </form>
              <div class="authent-reg">
                <p>Remember your password? <a href="login.php">Login now!</a>
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









