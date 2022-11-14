<?php
include('server/db.php');

if (isset($_GET['id'])) {

  // create a prepared statement
  $stmt =  $conn->prepare("SELECT * FROM  `cor_prods` WHERE id = ?");

  //getting the product id 
  $product_id = $_GET['id'];

  //bind parameters for markers
  //type integer, parameter id
  $stmt->bind_param("i", $product_id);

  // execute query
  $stmt->execute();


  $product =  $stmt->get_result();
} else {
  header('location: index.php');
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/5720664193.js" crossorigin="anonymous"></script>
  <!-- style sheet -->
  <link rel="stylesheet" href="assets/css/styles.css" />
  <!-- tailwind css -->
  <script src="https://cdn.tailwindcss.com"></script>

  <title>Smart</title>
  <?php include('./navbar.php'); ?>
</head>

<body>
  <div class="flex flex-col py-5 mx-[10%]">




  </div>
  <!-- product -->

  <section class="flex flex-col md:flex-row justify-around mx-[10%]">
    <!-- image -->
    <div class="mt-[5%]">
      <?php while ($row = $product->fetch_assoc()) { ?>

        <div class="flex flex-col w-[90%] drop-shadow-xl">
          <img id="main" src="<?php echo $row['img']; ?>" />

        </div>

    </div>
    <!-- text  -->
    <div class="flex flex-col space-y-5 w-full mt-[15%] mr-[5%] mb-[5%]">
      <h5 class="text-3xl tracking-wider"><?php echo $row['title']; ?></h5>
      <hr class="bg-sky-400 h-[2px] w-[30%]" />
      <h3 class="text-xl opacity-50 tracking-widest"><?php echo $row['dsc']; ?></h3>
      <h1 class="text-2xl">€<?php echo $row['price'] ?></h1>
      <!-- <div class="flex"> -->
      <input class="w-[50px] h-[50px]" type="number" value="1" name="number" />
      <button class="bg-sky-400 text-white font-bold w-[60%] p-3 rounded-lg  hover:text-sky-400 hover:bg-white">Buy Now</button>
      <!-- </div> -->
      <!-- <h2 class="text-lg">Product Details</h2>
      <p class="w-full text-sm">Details of this product will be displayed shortly</p> -->

    </div>

  <?php } ?>


  </section>

  <script src="/assets//js/MbNav.js"></script>
</body>

</html>