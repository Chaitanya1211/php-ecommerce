<?php
    $url=$_SERVER["REQUEST_URI"];
    $parts = explode('/',$url);
    $current = $parts[3];
?>
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 100%;height: 100%">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="./assets/finalLogo.png" width="50%" alt="Company Logo">
    </a>
    <div class="line my-3"></div>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="http://localhost/ecommerce/admin/dashboard.php" id="dashboard"
                <?php if($current == "dashboard.php"){ ?> class="nav-link active" <?php }else{ ?> class="nav-link"
                <?php } ?>>
                <i class="fa-solid fa-house mr-3"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="http://localhost/ecommerce/admin/products.php" id="products"
                <?php if($current == "products.php"){ ?> class="nav-link active" <?php }else{ ?> class="nav-link"
                <?php } ?>>
                <i class="fa-brands fa-product-hunt mr-3"></i>
                Products
            </a>
        </li>
        <li>
            <a href="http://localhost/ecommerce/admin/orders.php" id="orders" <?php if($current == "orders.php"){ ?>
                class="nav-link active" <?php }else{ ?> class="nav-link" <?php } ?>>
                <i class="fa-solid fa-boxes-stacked mr-3"></i>
                Orders
            </a>
        </li>
        <li>
            <a href="http://localhost/ecommerce/admin/profile.php" id="profile" <?php if($current == "profile.php"){ ?>
                class="nav-link active" <?php }else{ ?> class="nav-link" <?php } ?>>
                <i class="fa-solid fa-user mr-3"></i>
                Profile
            </a>
        </li>

        <button id="logoutBtn">
            <i class="fa-solid fa-right-from-bracket mr-3"></i> <span>Logout</span>
        </button>
    </ul>
    <hr>
</div>

<script>
let logoutBtn = document.getElementById("logoutBtn");
logoutBtn.addEventListener("click", () => {
    console.log("logout")
    // clear the token 
    localStorage.clear();
    // redirect to login page
    window.location.replace("http://localhost/ecommerce/admin/login.php")
})
</script>