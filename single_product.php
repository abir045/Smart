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
</head>

<body>
  <div class="flex flex-col py-5 mx-[10%]">
    <div class="flex space-x-5 items-center justify-between">
      <h1 class="text-sky-400 font-bold text-3xl">
        <a href="/">
          Smart

        </a>
      </h1>

      <!-- <div class="flex pt-2 relative mx-auto text-gray-600">
        <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-2xl text-sm focus:outline-none" type="search" name="search" placeholder="Search" />
        <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
          <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background: new 0 0 56.966 56.966" xml:space="preserve" width="512px" height="512px">
            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </button>
      </div> -->

      <ul class="flex items-center space-x-5 text-amber-500 text-xl">
        <!-- user login redirect -->
        <li class="cursor-pointer"><a href="user.php">
            <i class="fa-solid fa-user"></i>
          </a>

        <li class="cursor-pointer">
          <i class="fa-solid fa-cart-shopping"></i>
        </li>
      </ul>
    </div>


  </div>
  <!-- product -->

  <section class="flex justify-around mx-[10%]">
    <!-- image -->
    <div class="mt-[5%]">
      <?php while ($row = $product->fetch_assoc()) { ?>

        <div class="flex flex-col w-[90%] drop-shadow-xl">
          <img id="main" src="<?php echo $row['img']; ?>" />

        </div>

    </div>
    <!-- text  -->
    <div class="flex flex-col space-y-5 w-full mt-[15%] mr-[5%]">
      <h5 class="text-3xl tracking-wider"><?php echo $row['title']; ?></h5>
      <hr class="bg-sky-400 h-[2px] w-[30%]" />
      <h3 class="text-xl opacity-50 tracking-widest"><?php echo $row['dsc']; ?></h3>
      <h1 class="text-2xl">€<?php echo $row['price'] ?></h1>
      <!-- <div class="flex"> -->
      <input class="w-[50px] h-[50px]" type="number" value="1" name="number" />
      <button class="bg-sky-400 text-white font-bold w-[60%] p-3 rounded-lg  hover:text-sky-400 hover:bg-white">Buy Now</button>
      <!-- </div> -->
      <h2 class="text-lg">Product Details</h2>
      <p class="w-full text-sm">Details of this product will be displayed shortly</p>

    </div>

  <?php } ?>


  </section>


</body>

</html>