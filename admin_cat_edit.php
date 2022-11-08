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
    header('Location: admin_cat_new.php');
    exit();
}else{
    $cat_id = mysqli_real_escape_string($conn, $_GET['id']);
    //get catagory data
    $sql = "SELECT * FROM cor_cat WHERE id = '$cat_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $cat_name = $row['title'];


}



if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    //update cat title
    $sql = "UPDATE cor_cat SET title = '$title' WHERE id = '$cat_id'";
    $result = mysqli_query($conn, $sql);
    if($result){
        exitWithSuccess("Catagory updated successfully");
    }else{
        exitWithError("Error updating catagory");
    }

}

?>


<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Edit Catagory</title>
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
                                <h4 class="mb-sm-0 font-size-18">Edit <?php echo $cat_name; ?> Catagory</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Edit Catagory</li>
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



                                <form method="post" action="admin_cat_edit.php?id=<?php echo $cat_id; ?>">

                                    <div class="form-group mb-4">
                                        <label for="exampleFormControlInput2">Title</label>
                                        <input name="title" type="text" class="form-control"
                                            id="exampleFormControlInput2" value="<?php echo $cat_name; ?>">
                                    </div>


                                    <input type="submit" name="Save" class="mt-4 mb-4 btn btn-primary" type="submit">

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