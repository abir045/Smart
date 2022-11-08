<?php

session_start();
require_once('server/db.php');
include('comp/functions.php');

if (!isset($_SESSION["loggedin"])){
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id'];
$username = $_SESSION['username'];

if (intval(getUserData($conn, $id, "role")) != 1){
    header('Location: login.php');
    exit();
}

if(!isset($_GET['id'])){
    header('Location: admin_users.php');
    exit();
}else{
    $sel_user_id = mysqli_real_escape_string($conn, $_GET['id']);
    //get catagory data
    $sql = "SELECT * FROM users WHERE id = '$sel_user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sel_user = $row;


}

$error = $success = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $admin = mysqli_real_escape_string($conn, $_POST['admin']);
    $bal = mysqli_real_escape_string($conn, $_POST['bal']);

    //update news in database
    $sql = "UPDATE users SET `role` = '$admin', `bal` = '$bal' WHERE id = '$sel_user_id'";
   
    
    $result = mysqli_query($conn, $sql);
    if($result){
        exitWithSuccess("User updated successfully");

    }else{
        exitWithError("Error updating user");
    }

}

?>

<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Edit User</title>
</head>

<body data-topbar="dark" data-layout-mode="dark" data-sidebar="dark">
    <div id="layout-wrapper">
        <?php include 'comp/nav.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Edit <?php echo $sel_user['username'] ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Create User</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
        
                        if(isset($_GET['error'])){
							$error = htmlspecialchars(urldecode($_GET['error']));
                            echo '<div class="alert alert-danger mb-4" role="alert"> <strong>Error!</strong> '.$error.'</div>';
                        }elseif(isset($_GET['success'])){
							$success = htmlspecialchars(urldecode($_GET['success']));
                            echo '<div class="alert alert-success mb-4" role="alert"> <strong>Success!</strong> '.$success.'</div>';
                        }

                        ?>

                    <!-- Content -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

                        <div class="bio layout-spacing ">
                            <div class="widget-content widget-content-area">



                                <form role="form" method="post">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label class="form-label">ID</label>
                                        <input name="title" type="text" class="form-control"
                                            value="<?php echo $sel_user['id'] ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input name="title" type="text" class="form-control"
                                            value="<?php echo $sel_user['username'] ?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input name="title" type="text" class="form-control"
                                            value="<?php echo $sel_user['email'] ?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">IP</label>
                                        <input name="title" type="text" class="form-control"
                                            value="<?php echo $sel_user['ip'] ?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Balance</label>
                                        <input name="bal" type="text" class="form-control"
                                            value="<?php echo $sel_user['bal'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">User Type</label>
                                        <select class="form-control" name="admin" id="">
                                            <option value="1" <?php if($sel_user['role'] == 1){ echo 'selected'; } ?>>Admin</option>
                                            <option value="2" <?php if($sel_user['role'] == 2) echo ' selected'; ?>>Seller</option>
                                            <option value="0" <?php if($sel_user['role'] == 0) echo ' selected'; ?>>User</option>
                                        </select>
                                    </div>

                                    <input value="Save" class="mt-4 mb-4 btn btn-primary" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include 'comp/footer.php'; ?>
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