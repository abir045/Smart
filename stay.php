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
</head>


<body>


    <div>
        <!-- Navbar -->
        <div class="flex flex-col py-5 mx-[10%]">
            <div class="flex space-x-5 items-center justify-between">
                <h1 class="text-sky-400 font-bold text-3xl">
                    <a href="/">
                        Smart

                    </a>
                </h1>



                <ul class="flex items-center space-x-5 text-amber-500 text-xl">
                    <!-- user login redirect -->
                    <li class="cursor-pointer"><a href="user.php">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>
                    <li class="cursor-pointer">
                        <a href="cart.html">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>

                    </li>
                    <li onclick="showNav();" class="cursor-pointer flex md:hidden">

                        <i class="fa-solid fa-bars"></i>

                    </li>


                </ul>
            </div>



            <ul class="hidden  text-base  font-medium tracking-wider   md:flex md:space-x-10  items-center mt-10">
                <a href="#allProducts">
                    <li>
                        <p class="hover:text-sky-400">All our Boxes</p>
                    </li>
                </a>

                <a href="#stayProducts">
                    <p class="hover:text-sky-400">Stay</p>
                    </li>
                </a>

                <a href="#sportsProducts">
                    <li>
                        <p class="hover:text-sky-400">Sports & Adventure</p>
                    </li>
                </a>

                <a href="#foodProducts">
                    <li>
                        <p class="hover:text-sky-400">Gastronomy</p>
                    </li>
                </a>

                <a href="#wellnessProducts">
                    <li>
                        <p class="hover:text-sky-400">Wellness</p>
                    </li>
                </a>


                <a href="#multiProducts">
                    <li>
                        <p class="hover:text-sky-400">Multi-Activities</p>
                    </li>
                </a>

            </ul>



        </div>

        <!-- mb nav -->
        <!-- <div id="mbNav" onclick="showNav();">
            <ul
                class="fixed top-0 left-0 right-0 h-[400px]   py-[10%] rounded-lg flex flex-col leading-[30px] bg-sky-400 text-amber-50 justify-between text-sm items-center mt-10">
                <a href="#allProducts">
                    <li>
                        <p class="text-lg tracking-widest font-bold">All our Boxes</p>
                    </li>
                </a>

                <a href="#stayProducts">
                    <li>
                        <p class="text-lg tracking-widest font-bold">Stay</p>
                    </li>
                </a>

                <a href="#sportsProducts">
                    <li>
                        <p class="text-lg tracking-widest font-bold">Sports & Adventure</p>
                    </li>
                </a>

                <a href="#foodProducts">
                    <li>
                        <p class="text-lg tracking-widest font-bold">Gastronomy</p>
                    </li>
                </a>

                <a href="#wellnessProducts">
                    <li>
                        <p class="text-lg tracking-widest font-bold">Wellness</p>
                    </li>
                </a>


                <a href="#multiProducts">
                    <li>
                        <p class="text-lg tracking-widest font-bold">Multi-Activities</p>
                    </li>
                </a>

            </ul>
        </div> -->

        <?php include('server/db.php'); ?>


        <section class="flex flex-col" id="stay">

            <!-- serachbar -->
            <div class="flex pt-2 relative mx-auto text-gray-600">
                <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-2xl text-sm focus:outline-none" id="searchbar" type="text" name="search" placeholder="Search for a product.." onkeyup="searchProduct();">
                <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                    <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                        <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col items-center">
                <div class="flex flex-col">
                    <h1 class="flex text-center text-xl font-bold mt-[5%] tracking-widest">Stay products</h1>
                    <hr class="mx-auto bg-sky-400 h-[3px] w-[5%] mt-5" />
                </div>
                <div class="flex mx-[5%]">
                    <div class="grid  grid-cols-1 md:grid-cols-4 ">

                        <?php while ($stay_row = $stayProducts->fetch_assoc()) { ?>

                            <div class="justify-evenly mx-2">
                                <div class="flex flex-col space-y-5 items-center my-5  drop-shadow-lg">
                                    <div class="flex flex-col space-y-5 items-center my-5  drop-shadow-lg Products">
                                        <img class="flex" src="<?php echo $stay_row['img'] ?>" />
                                        <h2 class="text-xl font-bold tracking-wider"><?php echo $stay_row['title'] ?></h2>
                                        <hr class="mx-auto bg-sky-400 h-[2px] w-[85%]" />
                                        <h2 class="text-xl font-semibold tracking-widest opacity-40"><?php echo $stay_row['dsc'] ?></h2>
                                        <h3 class="text-xl font-medium opacity-70">€<?php echo $stay_row['price'] ?></h3>

                                        <!-- redirect to single product page by clicking buy -->
                                        <a href="<?php echo 'single_product.php?id=' . $stay_row['id'] ?>">
                                            <button class="bg-sky-400 hover:text-sky-400 hover:bg-white font-bold text-white rounded-lg p-3">Buy Now</button>
                                        </a>
                                    </div>


                                </div>

                            </div>

                        <?php } ?>


                    </div>
                </div>

                <div class="flex mx-[10%] justify-between space-x-5 mb-[5%]">
                    <h3 class="text-lg font-bold">pages</h3>

                    <?php

                    $total_pages = ceil($stay_total_rows / $stay_limit);

                    $pageURL = "";


                    if ($stay_page_number >= 2) {
                        echo "<a href='stay.php?page=" . ($stay_page_number - 1) . "'>Prev</a>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {

                        if ($i == $stay_page_number) {

                            $pageURL .= "<a class = 'active' href='stay.php?page="

                                . $i . "'>" . $i . " </a>";
                        } else {

                            $pageURL .= "<a href='stay.php?page=" . $i . "'>   

                                                " . $i . " </a>";
                        }
                    };

                    echo $pageURL;

                    if ($stay_page_number < $total_pages) {

                        echo "<a href='stay.php?page=" . ($stay_page_number + 1) . "'>  Next </a>";
                    }


                    ?>

                    <!-- <div class="flex ">
                        <input id="page" type="number" min="1" max="<?php echo $total_pages ?>" placeholder="<?php echo $page_number . "/" . $total_pages; ?>" required>

                        <button onClick="go2Page();">Go</button>



                    </div> -->
                </div>

            </div>

        </section>

    </div>




    <script src="/assets/js/Search.js">

    </script>
</body>

</html>