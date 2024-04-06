<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/allProducts.css">
    <link rel="stylesheet" href="./css/footer.css">

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

        <section>
            <div class="d-flex justify-content-center my-3" id="title">
                All your favorites in one place.<br>From fashion to home goods, discover a diverse selection that caters
                to
                every taste.
            </div>
        </section>

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
        
        <!-- Fashion -->
        <section id="fashionSection">
            <div class="category-head d-flex justify-content-start align-items-center">
                <!-- box icon -->
                <div class="category-wrapper mr-3">
                    <i class="fa-solid fa-shirt"></i>
                </div>
                <!-- category name -->
                <span class="category-name">Fashion</span>
            </div>

            <div id="fashionRow" class="d-flex flex-wrap">
                <!-- Add fashion items -->

            </div>
        </section>

        <!-- Food -->
        <section id="foodSection">
            <div class="category-head d-flex justify-content-start align-items-center">
                <!-- box icon -->
                <div class="category-wrapper mr-3">
                <i class="fa-solid fa-utensils"></i>
                </div>
                <!-- category name -->
                <span class="category-name">Food</span>
            </div>

            <div id="foodRow" class="d-flex flex-wrap">
                <!-- Add food items -->

            </div>
        </section>

        <!-- Household -->
        <section id="householdSection">
            <div class="category-head d-flex justify-content-start align-items-center">
                <!-- box icon -->
                <div class="category-wrapper mr-3">
                <i class="fa-solid fa-house-chimney-window"></i>
                </div>
                <!-- categoty name -->
                <span class="category-name">Household</span>
            </div>

            <div id="householdRow" class="d-flex flex-wrap">
                <!-- Add fashion items -->

            </div>
        </section>

        <!-- Cosmetics -->
        <section id="cosmeticsSection">
            <div class="category-head d-flex justify-content-start align-items-center">
                <!-- box icon -->
                <div class="category-wrapper mr-3">
                <i class="fa-regular fa-face-smile-beam"></i>
                </div>
                <!-- categoty name -->
                <span class="category-name">Cosmetics</span>
            </div>

            <div id="cosmeticsRow" class="d-flex flex-wrap">
                <!-- Add fashion items -->

            </div>
        </section>

        <!-- Electronics -->
        <section id="electronicsSection">
            <div class="category-head d-flex justify-content-start align-items-center">
                <!-- box icon -->
                <div class="category-wrapper mr-3">
                <i class="fa-solid fa-plug-circle-check"></i>
                </div>
                <!-- categoty name -->
                <span class="category-name">Electronics</span>
            </div>

            <div id="electronicsRow" class="d-flex flex-wrap">
                <!-- Add fashion items -->

            </div>
        </section>

        <!-- Furniture -->
        <section id="furnitureSection">
            <div class="category-head d-flex justify-content-start align-items-center">
                <!-- box icon -->
                <div class="category-wrapper mr-3">
                <i class="fa-solid fa-couch"></i>
                </div>
                <!-- categoty name -->
                <span class="category-name">Furniture</span>
            </div>

            <div id="furnitureRow" class="d-flex flex-wrap">
                <!-- Add fashion items -->

            </div>
        </section>
        <?php include('./include/footer.php') ?>
    </div>

    <script src="./js/allProducts.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>