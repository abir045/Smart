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





if(isset($_GET['act']) && $_GET['act'] == 'del'){
    

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    //delete catagory from database
    $sql = "DELETE FROM cor_prods WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    //delete keys
    $sql = "DELETE FROM cor_keys WHERE prod_id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    exitWithSuccess("Product deleted successfully");

}

?>





<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Products</title>
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
                                <h4 class="mb-sm-0 font-size-18">Product Manager</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Product Manager</li>
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


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Seller</th>
                                                <th>Catagory</th>
                                                <th>Stock</th>
                                                <th>Date</th>

                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                $showorders = mysqli_query($conn, "SELECT * FROM cor_prods ORDER BY id DESC");
        
                while($row = mysqli_fetch_array($showorders)) { 
                    $prod_id = $row['id'];
                    $sql2 = "SELECT * FROM cor_keys WHERE prod_id = '$prod_id';";
                    $result2 = mysqli_query($conn, $sql2);
                    $stock = mysqli_num_rows($result2);

                    echo '            
                    <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['title'].'</td>
                    <td>'.$row['price'].'</td>
                    <td>'.getUserData($conn, $row['seller'], 'username').'</td>
                    <td>'.getCatName($conn, $row['cat']).'</td>
                    <td>'.$stock.'</td>
                    <td>'.$row['created_at'].'</td>
                    <td>
                        <a href="admin_prods.php?act=del&id='.$row['id'].'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                    </td>
                    </tr>';
                }

                ?>


                                        </tbody>
                                    </table>
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