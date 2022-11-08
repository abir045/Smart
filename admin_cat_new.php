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



if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    //insert catagory in database
    $sql = "INSERT INTO cor_cat (title) VALUES ('$title')";
    $result = mysqli_query($conn, $sql);
    if($result){
        exitWithSuccess("Catagory added successfully");
    }else{
		exitWithError("Error adding catagory");

    }

}

if(isset($_GET['act']) && $_GET['act'] == 'del'){
    

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    //delete catagory from database
    $sql = "DELETE FROM cor_cat WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        exitWithSuccess("Catagory deleted successfully");
    }else{
		exitWithError("Error deleting catagory");

    }

}

?>



<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Catagory Manager</title>
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
                                <h4 class="mb-sm-0 font-size-18">New Catagory</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">New Catagory</li>
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


                                <form method="post">

                                    <div class="form-group mb-4">
                                        <label for="exampleFormControlInput2">Title</label>
                                        <input name="title" type="text" class="form-control"
                                            id="exampleFormControlInput2">
                                    </div>

                                    <input name="Create" class="mt-4 mb-4 btn btn-primary" type="submit">

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">



                        <div class="bio layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Catagory List</h3>


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

								$showorders = mysqli_query($conn, "SELECT * FROM cor_cat ORDER BY id DESC;");
						
								while($row = mysqli_fetch_array($showorders)) { 

									echo '            
									<tr>
									<td>'.$row['id'].'</td>
									<td>'.$row['title'].'</td>
									<td>'.$row['created_at'].'</td>
									<td>
										<a href="admin_cat_edit.php?id='.$row['id'].'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>

										<a href="admin_cat_new.php?act=del&id='.$row['id'].'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
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