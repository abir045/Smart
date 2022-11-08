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


?>


<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - View Deposits</title>
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
                                <h4 class="mb-sm-0 font-size-18">Deposits</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Deposits</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row layout-spacing">


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

                        <div class="bio layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <h3 class="">History</h3>


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>User</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                
                                            $showorders = mysqli_query($conn, "SELECT * FROM billing ORDER BY id DESC;");
                                    
                                            while($row = mysqli_fetch_array($showorders)) { 
                                                //remove "charge:" from the string
                                                if($row['status'] == 'pending' || $row['status'] == 'charge:created') {
                                                    $status = '<span class="badge bg-warning">Created</span>';
                                                }elseif($row['status'] == 'charge:confirmed') {
                                                    $status = '<span class="badge bg-success">Paid</span>';
                                                }else{
                                                    $status = '<span class="badge bg-danger">'.str_replace("charge:","",$row['status']).'</span>';
                                                }
                                                

                                                echo '            
                                                <tr>
                                                <td>'.$row['amount'].'</td>
                                                <td>'.getUserData($conn, $row['user_id'], "username").'</td>
                                                <td>'.$status.'</td>
                                                <td>'.$row['created_at'].'</td>
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



    <style>
    .popSelect {
        flex-direction: column;
        margin: auto;
        height: 250px;
        width: 200px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0.3;
    }

    .popSelect.active {
        opacity: 1;
        border: 4px solid #1b55e2;
    }

    .popSelect.active img {
        -webkit-filter: none !important;
        filter: none !important;
    }



    .popSelect:hover {
        transform: scale(1.06);
    }
    </style>

    <script>
    $(document).ready(function() {


        $('.popSelect').click(function() {

            $('.popSelect').removeClass('active');
            $(this).addClass('active');
            
        });



    });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>

</html>