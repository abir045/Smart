<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Smart</span>
                    </span>
                </a>
                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Smart</span>
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            
        </div>
        <div class="d-flex">

            <div class="dropdown d-inline-block">
                <a href="deposit.php" class="btn me-2 d-flex" style="display: flex;justify-content: center;align-items: center;height: 100%;">
                    <!-- plus icon circule -->
                    <?php echo getUserData($conn, $id, "bal"); ?>
                    <i class="mdi mdi-plus-circle-outline d-none d-xl-inline-block m-1"></i>
                    
                </a>
            </div>
            

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="https://ui-avatars.com/api/?background=282f36&color=fff&name=<?php echo $username[0]; ?>" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?php echo $username; ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- <a class="dropdown-item" href="apps-contacts-profile.html"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="auth-lock-screen.html"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock screen</a>
                    <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
            
            







            <li class="menu-title" data-key="t-menu">Menu</li>

            <li>
                <a href="store.php">
                    <i data-feather="dollar-sign"></i>
                    <span data-key="t-dashboard">Store</span>
                </a>
            </li>

            <li>
                <a href="history.php">
                    <i data-feather="list"></i>
                    <span data-key="t-dashboard">My Orders</span>
                </a>
            </li>


            <?php
            
            $role = intval(getUserData($conn, $id, "role"));

            if($role == 1) {

            ?>
            <li class="menu-title" data-key="t-menu">Admin Panel</li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="tool"></i>
                    <span data-key="t-authentication">Manager</span>
                </a>
                <ul class="sub-menu mm-collapse" aria-expanded="false">
                    <li><a href="admin_cat_new.php" data-key="t-login">Catagory Manager</a></li>
                    <li><a href="admin_prods.php" data-key="t-register">Product Manager</a></li>
                    <li><a href="admin_payout.php" data-key="t-recover-password">Payout Manager</a></li>
                    <li><a href="admin_settings.php" data-key="t-lock-screen">Site Manager</a></li>
                    <li><a href="admin_users.php" data-key="t-lock-screen">User Manager</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="list"></i>
                    <span data-key="t-authentication">View</span>
                </a>
                <ul class="sub-menu mm-collapse" aria-expanded="false">
                    <li><a href="admin_deposits.php" data-key="t-login">View Deposit</a></li>
                    <li><a href="admin_history.php" data-key="t-register">View Orders</a></li>
                </ul>
            </li>

            <?php
            
            }

            if($role == 2 || $role == 1) {


            ?>



            <li class="menu-title" data-key="t-menu">Seller Panel</li>
            <li>
                <a href="seller_prods.php">
                    <i data-feather="tool"></i>
                    <span data-key="t-dashboard">Product Manager</span>
                </a>
            </li>

            <li>
                <a href="seller_history.php">
                    <i data-feather="list"></i>
                    <span data-key="t-dashboard">View Orders</span>
                </a>
            </li>

            <li>
                <a href="seller_payout.php">
                    <i data-feather="dollar-sign"></i>
                    <span data-key="t-dashboard">Request Payout</span>
                </a>
            </li>


            <li>
                <a href="feedbacks.php">
                    <i data-feather="log-out"></i>
                    <span data-key="t-dashboard">Logout</span>
                </a>
            </li>

            <?php } ?>





            </ul>
        </div>
    </div>
</div>




