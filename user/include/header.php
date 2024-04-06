<nav>
    <div class="d-flex justify-content-between py-1">
        <div class="logo-wrapper">
            <a href="http://localhost/ecommerce/user/homepage.php">
                <img src="./assets/design.png" alt="Logo">
            </a>
        </div>
        <div class="details-wrapper d-flex align-items-center">
            <span>
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-user mr-2"></i> <span id="headerName"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Profile</a>
          <a class="dropdown-item" href="http://localhost/ecommerce/user/orderdetails.php">Orders</a>
          <div class="dropdown-divider"></div>
          <button id="logoutBtn">Logout</button>
        </div>
            </span>
            <a href="http://localhost/ecommerce/user/cart.php">
            <i class="fa-solid fa-cart-shopping mx-3"></i>
            <sup id="orderCount" class="badge badge-primary">0</sup>
            </a>
        </div>
    </div>
</nav>
