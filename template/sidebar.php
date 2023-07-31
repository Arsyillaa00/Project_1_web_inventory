<style>
    .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 150px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
</style>

<main class="col-2 sidebar">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark vh-100">
        <h2>Inventory</h2>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto sidebar-sticky">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link active" aria-current="page">
            <span class="fa-solid fa-house"></span>
            Home
            </a>
        </li>
        <li>
            <a href="user.php?db=user" class="nav-link text-white">
            <span class="fa-solid fa-user"></span>
            User
            </a>
        </li>
        <li>
            <a href="products.php?db=products" class="nav-link text-white">
            <span class="fa-solid fa-box-open"></span>
            Products
            </a>
        </li>
        <li>
            <a href="status.php?db=status" class="nav-link text-white">
            <span class="fa-solid fa-check-to-slot"></span>
            Status
            </a>
        </li>
        <li>
            <a href="log.php" class="nav-link text-white">
            <span class="fa-solid fa-clock-rotate-left"></span>
            Log
            </a>
        </li>
        </ul>
        <hr>
        <div class="dropdown">
        <a data-bs-toggle="dropdown" id="dropdown-menu" href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle">
            <strong><?php echo $_SESSION['nama'];?></strong>
        </a>
        <ul id="dropdown-item" class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li>
                <a class="dropdown-item" href="profil.php?id=<?php echo $_SESSION['id_user']; ?>">
                    <span class="fa-solid fa-address-card"></span>
                    Profile
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="logout.php">
                    <span class="fa-solid fa-right-from-bracket"></span>
                    Sign out
                </a>
            </li>
        </ul>
        </div>
    </div>    
</main>
