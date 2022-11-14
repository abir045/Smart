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

            <li onclick="showNav();" class="cursor-pointer flex md:hidden">

                <i class="fa-solid fa-bars"></i>

            </li>


        </ul>
    </div>



    <ul class="hidden  text-base  font-medium tracking-wider   md:flex md:space-x-10  items-center mt-10">


        <a href="stay.php">
            <li>
                <p class="hover:text-sky-400">Stay</p>
            </li>
        </a>

        <a href="wellness.php">
            <li>
                <p class="hover:text-sky-400">Wellness</p>
            </li>
        </a>
        <a href="sports.php">
            <li>
                <p class="hover:text-sky-400">Sports & Adventure</p>
            </li>
        </a>

        <a href="gastronomy.php">
            <li>
                <p class="hover:text-sky-400">Gastronomy</p>
            </li>
        </a>

        <a href="multi-themes.php">
            <li>
                <p class="hover:text-sky-400">Multi Activities</p>
            </li>
        </a>




        <a href="spa.php">
            <li>
                <p class="hover:text-sky-400">Spa</p>
            </li>
        </a>



    </ul>



</div>

<!-- mb nav -->
<div id="mbNav" onclick="showNav();">
    <ul class="fixed top-0 left-0 right-0 h-[400px] z-[100]   py-[10%] rounded-lg flex flex-col leading-[30px] bg-sky-400 text-amber-50 justify-between text-sm items-center mt-10">



        <a href="stay.php">
            <li>
                <p class="text-lg tracking-widest font-bold">Stay</p>
            </li>
        </a>

        <a href="wellness.php">
            <li>
                <p class="text-lg tracking-widest font-bold">Wellness</p>
            </li>
        </a>
        <a href="sports.php">
            <li>
                <p class="text-lg tracking-widest font-bold">Sports & Adventure</p>
            </li>
        </a>

        <a href="gastronomy.php">
            <li>
                <p class="text-lg tracking-widest font-bold">Gastronomy</p>
            </li>
        </a>

        <a href="multi-themes.php">
            <li>
                <p class="text-lg tracking-widest font-bold">Multi Activities</p>
            </li>
        </a>


        <a href="spa.php">
            <li>
                <p class="text-lg tracking-widest font-bold">Spa</p>
            </li>
        </a>

    </ul>
</div>