<?php

session_start();
require_once('server/db.php');
include('comp/functions.php');

if (!isset($_SESSION["loggedin"])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$balance = getUserData($conn, $id, "bal");

if (isset($_GET['buy'])) {
    $buyID = mysqli_real_escape_string($conn, $_GET['buy']);
    $sql = "SELECT * FROM cor_prods WHERE id = '$buyID'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        $sql2 = "SELECT * FROM cor_keys WHERE prod_id = '$buyID';";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {

            $row = mysqli_fetch_assoc($result);

            $price = $row['price'];
            $title = $row['title'];
            $cat = $row['cat'];
            //check if user balance is enough
            if ($balance >= $price) {
                //update user balance
                $sql = "UPDATE users SET bal = bal - '$price' WHERE id = '$id'";
                $result = mysqli_query($conn, $sql);

                //update product sold
                $sql3 = "SELECT * FROM cor_keys WHERE prod_id = '$buyID' LIMIT 1;";
                $result3 = mysqli_query($conn, $sql3);
                $row3 = mysqli_fetch_assoc($result3);
                $key = $row3['key'];
                $key_id = $row3['id'];
                $sql4 = "DELETE FROM cor_keys WHERE id = '$key_id'";
                $result4 = mysqli_query($conn, $sql4);

                $seller = $row['seller'];
                //get site settings
                $sql = "SELECT * FROM site_settings WHERE id = '1'";
                $cut = mysqli_query($conn, $sql);
                $cut = mysqli_fetch_assoc($cut);
                $site_percentage = $cut['cut'];

                //calculate seller earnings
                $earnings = $price - ($price * ($site_percentage / 100));

                //add balance to seller
                $sql5 = "UPDATE users SET bal = bal + '$earnings' WHERE id = '$seller'";
                $result5 = mysqli_query($conn, $sql5);




                $sql6 = "INSERT INTO `cor_history` (`buyer`, `seller`, `key`, `product_title`, `catagory_id`, `price`) VALUES ('$id', '$seller', '$key', '$title', '$cat', '$price');";
                $result6 = mysqli_query($conn, $sql6);




                if (!$result) {
                    exitWithError("Error updating user balance");
                } elseif (!$result4) {
                    exitWithError("Error updating product");
                } elseif (!$result5) {
                    exitWithError("Error updating history");
                } else {
                    exitWithSuccess("Product purchased " . $row['title'] . " successfully");
                }
            } else {
                exitWithError("Insufficient balance");
            }
        } else {
            exitWithError("Product out of stock");
        }
    } else {
        exitWithError("Product not found");
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Store </title>
</head>

<body data-topbar="light" data-layout-mode="light" data-sidebar="light">
    <div id="layout-wrapper">
        <?php include 'comp/nav.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Payout Requests</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Payout Requests</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php

                    if (isset($_GET['error'])) {
                        $error = urldecode($_GET['error']);
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> ' . $error . '
                                </div>';
                    } elseif (isset($_GET['success'])) {
                        $success = urldecode($_GET['success']);
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ' . $success . '
                                </div>';
                    }


                    ?>

                    <div class="row">

                        <div class="col-md-9 col-12">

                            <input type="text" class="form-control" name="search" placeholder="Search for a produt..." style="margin-top:10px;" id="searchBox">

                        </div>

                        <div class="col-md-3 col-12">
                            <!-- dropdown menu for categories -->

                            <?php
                            $printedCats = array();
                            $sql = "SELECT * FROM cor_cat";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {

                                echo '<select name="cat" id="catBtn" class="form-control" style="margin-top:10px;">
                    <option value="0" selected>All Categories</option>';


                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cat_id = $row['id'];
                                    $sql = "SELECT count(*) as count FROM `cor_prods` WHERE `cat` = '$cat_id';";
                                    $result2 = mysqli_query($conn, $sql);
                                    $row2 = mysqli_fetch_assoc($result2);
                                    if ($row2['count'] > 0) {
                                        $printedCats[$row['id']] = $row['title'];
                                        echo '<option value="' . $cat_id . '">' . $row['title'] . '</option>';
                                    }
                                }
                                echo '</select>';
                            }


                            ?>
                        </div>
                    </div>

                    <div class="row">

                        <?php

                        foreach ($printedCats as $key => $value) {
                            $cat_id = $key;
                            $cat_name = $value;
                            $sql = "SELECT * FROM cor_prods WHERE `cat` = '$cat_id';";
                            $result = mysqli_query($conn, $sql);
                            echo '
                    <div id="card_9" class="col-lg-12 catSections layout-spacing ' . $cat_id . 'sec">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>' . $cat_name . '</h4>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-content widget-content-area">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                //get stock |
                                $prod_id = $row['id'];
                                $sql = "SELECT * FROM `cor_keys` WHERE `prod_id` = '$prod_id';";
                                $result2 = mysqli_query($conn, $sql);
                                $row2 = mysqli_fetch_assoc($result2);
                                $stock = mysqli_num_rows($result2);
                                echo '
                        <div class="card component-card_9">
                            <img src="' . $row['img'] . '" class="card-img-top" alt="widget-card-2">
                            <div class="card-body">

                                <div class="box-footer" style="border-top: none;padding-top: 0px;display: flex;justify-content: space-between;align-items: center;">
                                <h5 class="card-title" style=" margin: 0px;">' . $row['title'] . '</h5>
                                    <span class="badge bg-dark">$ ' . $row['price'] . '</span>
                                </div>

                                <div class="meta-info">
                                    <div class="meta-user" style="margin: 20px 0px;color: #a3a3a3;">' . $row['dsc'] . '</div>


                                    <div class="box-footer" style="border-top: none;padding-top: 0px;display: flex;justify-content: space-between;align-items: flex-end;">
                                        <a href="store.php?buy=' . $row['id'] . '" class="btn btn-primary">Buy</a>
                                        <span class="badge bg-primary-light">' . $stock . ' Stock</span>
                                    </div>

                                </div>

                            </div>
                        </div>';
                            }
                            echo '
                    </div>
                    </div></div>';
                        }




                        ?>

                    </div>

                </div>

            </div>
        </div>

        <!-- <?php include('comp/footer.php'); ?>  -->




    </div>
    <!-- END MAIN CONTAINER -->

    <style>
        .card {
            display: inline-block;
            width: 350px;
            margin: 10px;
            background: #ffffff;
            /* #191e3a; */
        }

        #card_9 {
            padding-top: 20px;
            height: fit-content;
        }

        .widget-content {
            padding-top: 0px;
        }

        .card-img-top {
            max-height: 250px;
        }
    </style>

    <div class="rightbar-overlay"></div>
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            $('#catBtn').change(function() {



                var id = $(this).val();
                if (id == '0') {
                    //show all products and categories
                    $('.catSections').slideDown().after(function() {
                        $('.catSections').css('display', 'flex');
                    });


                } else {

                    $('.catSections').slideUp().after(function() {
                        $('.' + id + 'sec').slideDown().after(function() {
                            $('.' + id + 'sec').css('display', 'flex');
                        });
                    });

                }
            });


            var id = $('#catBtn').val();
            // $('.catSections').slideUp().after(function() {
            //     $('.' + id + 'sec').slideDown().after(function() {
            //         $('.' + id + 'sec').css('display', 'flex');
            //     });;
            // });

            $('#searchBox').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('.card').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

        });
    </script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>

</html>