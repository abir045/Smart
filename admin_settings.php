<?php

session_start();
require_once('server/db.php');
include('comp/functions.php');

if (!isset($_SESSION["loggedin"])){
    header('Location: login.php');
}

$id = $_SESSION["id"];
$username = $_SESSION["username"];

$sql = "SELECT * FROM `site_settings` WHERE `id`='1';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if($_SERVER['REQUEST_METHOD'] == 'POST'){


    $cut = mysqli_real_escape_string($conn,$_POST['cut']);
    $coinbase_secret = mysqli_real_escape_string($conn,$_POST['coinbase_secret']);
    $coinbase_api = mysqli_real_escape_string($conn,$_POST['coinbase_api']);

    $sql = "UPDATE `site_settings` SET `coinbase_secret`='$coinbase_secret', `coinbase_api`='$coinbase_api', `cut`='$cut' WHERE `id`='1';";
    $result = mysqli_query($conn, $sql);

    if($result){
        exitWithSuccess("Settings updated successfully!");
    }else{
        exitWithError("Error updating settings!");
    }


}

?>


<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Settings</title>
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
                                <h4 class="mb-sm-0 font-size-18">Deposit</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Deposit</li>
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

                    <div class="row layout-spacing">

                        <!-- Content -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

                            <div class="bio layout-spacing ">
                                <div class="widget-content widget-content-area">


                                    <form role="form" method="post" >
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label class="form-label">Coinbase API Key</label>
                                            <input name="coinbase_api" type="text" class="form-control" placeholder="Enter API Key" value="<?php echo $row['coinbase_api']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Coinbase Secret Key</label>
                                            <input name="coinbase_secret" type="text" class="form-control" placeholder="Enter Secret Key" value="<?php echo $row['coinbase_secret']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Site Percentage</label>
                                            <input name="cut" type="text" class="form-control" placeholder="Enter Site Percentage" value="<?php echo $row['cut']; ?>">
                                        </div>


                                        

                                        <button class="waves-effect waves-light btn btn-primary mb-5" type="submit" style="width: 100%;margin-block: 20px;">Save</button>

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



    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>

</html>