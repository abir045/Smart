<?php

require_once('server/db.php');

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){


        // Verify data
        $email = mysqli_real_escape_string($conn, $_GET['email']); // Set email variable
        $hash = mysqli_real_escape_string($conn, $_GET['hash']); // Set hash variable

        $result = mysqli_query($conn,"SELECT * FROM users WHERE `email`='$email';");
        $row = mysqli_fetch_array($result);
        if(mysqli_num_rows($result) > 0){

            if($row['hash'] == $hash){


                $sql = "UPDATE `users` SET `verified`='1' WHERE `email`='$email'";
                if ($stmt = $conn->prepare($sql)) {
                    if ($stmt->execute()) {
                        header("location: login.php?success");
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
    // Invalid approach
}