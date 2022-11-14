<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/5720664193.js" crossorigin="anonymous"></script>
    <!-- style sheet -->
    <link rel="stylesheet" href="assets/css/styles.css" />
    <!-- tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Smart.</title>
    <?php include('./navbar.php'); ?>
</head>

<body>


    <div>


        <!-- hero section -->
        <div class="flex flex-col items-center mx-[10%]">
            <img class="hidden md:flex w-full rounded-lg" src="./assets/images/rsz_bg-3.jpg" />
            <img class="w-full flex md:hidden rounded-lg" src="./assets/images/hero_mb.jpg" />
        </div>

        <!-- category section -->
        <!-- our universe -->
        <section class="flex flex-col items-center">
            <h1 class="text-center text-3xl font-bold mt-[5%] tracking-widest">Our Universe</h1>

            <div class="hidden md:flex  justify-between  mt-5 mx-[10%]">
                <ul class="flex  items-center md:flex-row md:space-x-5 w-full ">
                    <li id="stayProducts" class="flex flex-col text-center w-full">

                        <a href="stay.php"><img class="hidden md:flex rounded-lg hover:opacity-50 " src="./assets/images/stay.jpg " /></a>
                        <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Stay</p>
                    </li>
                    <li id="wellnessProducts" class="text-center w-full ">

                        <a href="wellness.php"><img class="hidden md:flex rounded-lg  hover:opacity-50 " src="./assets/images/wellness.jpg " /></a>
                        <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Wellness</p>

                    </li>
                    <li id="sportsProducts" class="text-center w-full">

                        <a href="sports.php"><img class="hidden md:flex rounded-lg  hover:opacity-50 " src="./assets/images/sports.jpg " /></a>
                        <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Sports</p>

                    </li>
                </ul>




            </div>

            <div class="hidden md:flex  justify-center items-center   mx-[10%]">
                <ul class="flex  md:justify-center  md:space-x-5  font-medium">
                    <li id="foodProducts" class="text-center w-full">

                        <a href="gastronomy.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/steak.jpg " /></a>
                        <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Gastronomy</p>

                    </li>

                    <li id="multiProducts" class="text-center w-full">


                        <a href="multi-themes.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/multi2.jpg " /></a>
                        <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Multi-Themes</p>

                    </li>
                    <li id="spaProducts" class="text-center w-full ">


                        <a href="spa.php"><img class="hidden md:flex rounded-lg  hover:opacity-50 " src="./assets/images/spa2.jpg " /></a>
                        <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Spa</p>
                    </li>

                </ul>

            </div>

            <!-- mb category -->

            <div class="flex flex-col md:hidden items-center mt-[5%]">
                <div class="flex flex-col">
                    <ul class="flex mx-[5%] space-x-3 ">
                        <li id="stayProducts" class="flex flex-col text-center ">

                            <a href="stay.php"><img class="flex rounded-lg hover:opacity-50 " src="./assets/images/stay.jpg " /></a>
                            <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Stay</p>
                        </li>
                        <li id="wellnessProducts" class="text-center  ">

                            <a href="wellness.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/wellness.jpg " /></a>
                            <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Wellness</p>

                        </li>

                    </ul>

                    <ul class="flex mx-[5%] space-x-3 ">
                        <li id="sportsProducts" class="text-center w-full">

                            <a href="sports.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/sports.jpg " /></a>
                            <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Sports</p>

                        </li>
                        <li id="foodProducts" class="text-center w-full">

                            <a href="gastronomy.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/steak.jpg " /></a>
                            <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Gastronomy</p>

                        </li>



                    </ul>

                    <ul class="flex mx-[5%] space-x-3 ">
                        <li id="multiProducts" class="text-center w-full">


                            <a href="multi-themes.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/multi2.jpg " /></a>
                            <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Multi-Themes</p>

                        </li>
                        <li id="spaProducts" class="text-center w-full ">


                            <a href="spa.php"><img class="flex rounded-lg  hover:opacity-50 " src="./assets/images/spa2.jpg " /></a>
                            <p class="text-lg tracking-wider my-5 font-bold hover:opacity-50">Spa</p>
                        </li>



                    </ul>

                </div>

            </div>


        </section>
        <?php include('server/db.php'); ?>


        <h1 class="text-center text-xl font-bold mt-[5%] tracking-widest">
            Featured products
        </h1>
        <hr class="mx-auto bg-sky-400 h-[3px] w-[5%] mt-5" />

        <section class="flex flex-col md:flex-row mt-[5%] mx-[5%] mb-[10%]">

            <?php while ($row = $featuredProducts->fetch_assoc()) { ?>

                <div class="flex   justify-evenly mx-2">
                    <div class="flex flex-col space-y-5 items-center my-5  drop-shadow-lg">

                        <img class="flex" src="<?php echo $row['img'] ?>" />
                        <h2 class="text-xl font-bold tracking-wider"><?php echo $row['title'] ?></h2>
                        <hr class="mx-auto bg-sky-400 h-[2px] w-[85%]" />
                        <h2 class="text-xl font-semibold tracking-widest opacity-40"><?php echo $row['dsc'] ?></h2>
                        <h3 class="text-xl font-medium opacity-70">€<?php echo $row['price'] ?></h3>
                        <!-- redirect to single product page by clicking buy -->
                        <a href="<?php echo 'single_product.php?id=' . $row['id'] ?>">
                            <button class="bg-sky-400 hover:text-sky-400 hover:bg-white font-bold text-white rounded-lg p-3">Buy Now</button>
                        </a>

                    </div>

                </div>
            <?php } ?>

        </section>

        <!-- all products section -->



    </div>

    <script src="/assets/js/MbNav.js">

    </script>

</body>

</html>