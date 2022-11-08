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

if ( !(intval(getUserData($conn, $id, "role")) == 1 || intval(getUserData($conn, $id, "role")) == 2) ){
    header('Location: login.php');
    exit();
}

if(!isset($_GET['id'])){
    header('Location: seller_prods.php');
    exit();
}

$prod_id = mysqli_real_escape_string($conn, $_GET['id']);
//get catagory data
$sql = "SELECT * FROM cor_prods WHERE id = '$prod_id' AND seller = '$id'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) == 0){
    $error = "You are not authorized to edit this product";
    $error = urlencode($error);
    header('Location: seller_prods.php?error=' . $error);
    exit();
}
$row = mysqli_fetch_assoc($result);
$prod = $row;


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $dsc = mysqli_real_escape_string($conn, $_POST['dsc']);
    $tut = mysqli_real_escape_string($conn, $_POST['tut']);
    $cat = mysqli_real_escape_string($conn, $_POST['cat']);
    $img = mysqli_real_escape_string($conn, $_POST['img']);


    //check if catagory exists
    $sql = "SELECT * FROM cor_cat WHERE id = '$cat'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0){
        exitWithError("Catagory does not exist");
    }


    //update product in database
    $sql = "UPDATE cor_prods SET title = '$title', price = '$price', dsc = '$dsc', tut = '$tut', cat = '$cat', img = '$img' WHERE id = '$prod_id'";

    $result = mysqli_query($conn, $sql);
  //delete all lines in the table
    $sql2 = "DELETE FROM cor_keys WHERE prod_id = '$prod_id'";
    $result2 = mysqli_query($conn, $sql2);

    $arr = explode("\r\n", trim($_POST['keys']));
    foreach ($arr as $line) {
      
        $sql = "INSERT INTO cor_keys (`prod_id`, `key`) VALUES ('$prod_id', '$line')";
        $result = mysqli_query($conn, $sql);
    }
    
    
    if($result && $result2){
        exitWithSuccess("Product updated successfully");

    }else{
        exitWithError("Error updating product");
    }

}

?>


<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Edit Product</title>
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
                                <h4 class="mb-sm-0 font-size-18">Edit <?php echo $prod['title'] ?> product</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Seller</a></li>
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


                                <form role="form" method="post" action="seller_edit.php?id=<?php echo $prod['id']; ?>">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <input name="title" type="text" class="form-control"
                                            placeholder="Amazon Giftcard" value="<?php echo $prod['title'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <input name="dsc" type="text" class="form-control"
                                            placeholder="This is a product about ..."
                                            value="<?php echo $prod['dsc'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Tutorial</label>
                                        <textarea name="tut" cols="30" rows="10"
                                            placeholder="This is a pop up description" required
                                            class="form-control"><?php echo $prod['tut'] ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Key/Accounts (Split by linebreak)</label>
                                        <textarea name="keys" class="form-control" cols="30" rows="10"><?php 
                      
                      $sql = "SELECT * FROM cor_keys WHERE prod_id = '$prod_id'";
                      $result = mysqli_query($conn, $sql);
                      while($row = mysqli_fetch_assoc($result)){
                          echo $row['key']."
";
                      }
                      

                      ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Image link</label>
                                        <input name="img" type="text" class="form-control"
                                            placeholder="https://img.com/img.png" value="<?php echo $prod['img'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        <input name="price" type="number" class="form-control" placeholder="20.00"
                                            value="<?php echo $prod['price'] ?>">
                                    </div>


                                    <div class="form-group">
                                        <label class="form-label">Catagory</label>
                                        <select name="cat" class="form-control">
                                            <option value="" disabled>Select Catagory</option>
                                            <?php
                        
                        $sql = "SELECT * FROM cor_cat";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<option value="'.$row['id'].'"';
                            if($row['id'] == $prod['cat']){
                                echo ' selected';
                            }
                            
                            echo '>'.$row['title'].'</option>';
                        }

                        ?>
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