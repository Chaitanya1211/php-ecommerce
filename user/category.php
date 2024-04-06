<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/category.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container">
        <?php include('./include/header.php') ?>
        <!-- Snack bar success -->
        <div id="snackBarSuccess">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check mr-3"></i>
                <span>Product Added Successfully</span>
            </div>
        </div>

        <!-- Snack bar error -->
        <div id="snackBarError">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-xmark mr-3"></i>
                <span>Please fill the details properly</span>
            </div>
        </div>
        
        <div id="loading" class="text-center">Loading...</div>

        <div id="content-wrapper">
            <div id="categoryHeader">
                <div class="overlay"></div>
                <div class="d-flex justify-content-center">
                    <div class="content">
                        <div id="category-head">Innovate Your Lifestyle, Enhance Your Tech</div>
                        <div id="category-content">Discover cutting-edge gadgets, home electronics, and smart solutions.
                            Upgrade your lifestyle with the latest technology. Explore now for a smarter tomorrow.</div>
                    </div>
                </div>
            </div>

            <!-- sample product card -->
            <div class="col-lg-3" id="sampleCard">
                <div class="product-card p-3 my-3">
                    <div class="band"></div>
                    <div class="product-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="product-name">Name</span>
                            <span class="product-cost">2000</span>
                        </div>
                        <div class="image-wrapper pb-3">
                            <img src="./assets/1710221310_phone.jpg" alt="" class="product-image">
                        </div>
                        <div class="product-desc py-2">This will be product descriptino</div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <span class="stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </span>
                            <button class="add-to-cart">Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <section>
                <div id="products" class="my-4">
                    <h3 class="mb-4">Products</h3>
                    <div id="productRow">
                    </div>
                </div>
            </section>
        </div>
        <?php include('./include/footer.php') ?>
    </div>
    <!-- Links -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="./js/category.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>