<?php

session_start();
require_once('server/db.php');
require_once('comp/functions.php');

if (!isset($_SESSION["loggedin"])){
    header('Location: login.php');
    exit();
}

$id = $_SESSION["id"];
$username = $_SESSION["username"];


if(!isset($_GET['id'])){
    header('Location: index.php');
    exit();
}

$order_id = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "SELECT * FROM cor_history WHERE id = '$order_id'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if($num == 0){
    header('Location: index.php');
    exit();
}

$orderRow = mysqli_fetch_assoc($result);

if (intval(getUserData($conn, $id, "role")) != 1){

    if($orderRow['buyer'] != $id && $orderRow['seller'] != $id){
        header('Location: index.php');
        exit();
    }

}




?>



<!doctype html>
<html lang="en">
<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - View Order</title>
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
                                    <h4 class="mb-sm-0 font-size-18">Order #<?php echo $order_id; ?></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">View Order</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
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

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Seller</label>
                                                <input type="text" class="form-control" value="<?php echo getUserData($conn, $orderRow['seller'], "username"); ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Buyer</label>
                                                <input type="text" class="form-control" value="<?php echo getUserData($conn, $orderRow['buyer'], "username"); ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Price</label>
                                                <input type="text" class="form-control" value="<?php echo $orderRow['price']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Date</label>
                                                <input type="text" class="form-control" value="<?php echo $orderRow['created_at']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Catagory</label>
                                                <input type="text" class="form-control" value="<?php echo getCatName($conn, $orderRow['catagory_id']); ?>" readonly>
                                            </div>
                                        </div>





                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Product</label>
                                                <input type="text" class="form-control" value="<?php echo $orderRow['product_title']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="select" class="form-label ">Key</label>
                                                <input type="text" class="form-control" value="<?php echo $orderRow['key']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                </div>
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