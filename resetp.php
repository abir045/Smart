<?php

require_once('server/db.php');

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){


        // Verify data
        $email = mysqli_real_escape_string($conn, $_GET['email']);
        $hash = mysqli_real_escape_string($conn, $_GET['hash']);

        $result = mysqli_query($conn,"SELECT * FROM users WHERE `email`='$email';");
        $row = mysqli_fetch_array($result);
        if(mysqli_num_rows($result) > 0){

            $myArray = explode(',', $row['hash']);
            $DBhash = $myArray[0];
            $DBtime = $myArray[1];


            if($DBhash == $hash){

                if(time() < $DBtime){

                        $length = 8;
                        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
                        $pass = '';
                        $max = mb_strlen($keyspace, '8bit') - 1;
                        for ($i = 0; $i < $length; ++$i) {
                            $pass .= $keyspace[random_int(0, $max)];
                        }

                        $pass;
                    



                    $username = $row['username'];

                    $hashed_password = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
                    
                    $sql = "UPDATE `users` SET `password`='$hashed_password' WHERE `email`='$email'";
                    if ($stmt = $conn->prepare($sql)) {
                        if ($stmt->execute()) {


                            $to      = $email; // Send email to our user
$subject = 'Password Reset | Success'; // Give the email a subject 
$message = 'Hello '.$username.', Thanks for reseting your password!
You can login using your new password:
===================
Username: '.$username.'
Password: '.$pass.'
==================='

; // Our message above including the link
										
					$headers = 'From:noreply@trixdev.me' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send our email


                        echo 'Check your email';
                        }else {
                            echo "Error";
                        }
                        $stmt->close();
                    }


                }else{
                    die('Verification Error Failed Successfully');
                }

            }else{
                die('Verification Error Failed Successfully');
            }



        }else{
            die('Verification Error Failed Successfully');
        }

    

}else{
    // Invalid approach
}