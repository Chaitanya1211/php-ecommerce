<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/cart.css">
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

        <!-- loading -->
        <div id="loading" class="text-center">Loading...</div>

        <!-- Content -->
        <div id="content-wrapper">
            <section class="container text-center" id="emptyCart">
                <img src="./assets/empty-cart.png" alt="">
            </section>

            <!-- Order placed pop up -->
            <section>
                <div class="popup" id="popup">
                    <img src="./assets/404-tick.png" alt="" width="100px" height="100px">
                    <h2>Thank You</h2>
                    <p>Your order has been placed successfuly</p>
                    <p class="mb-4">Thank you for shopping with us</p>
                    <div class="d-flex justify-content-between">
                        <button id="close-btn" onclick="closePopup()">OK</button>
                        <a href="http://localhost/ecommerce/user/orders.php"><button id="close-btn">View
                                Orders</button></a>
                    </div>
                </div>
            </section>

            <!-- Cart section -->
            <section class="gradient-custom" id="cartSection">
                <div class="container">
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-md-8">
                            <!-- Sample cart card -->
                            <div id="sampleCart">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded"
                                                data-mdb-ripple-color="light">
                                                <img class="product-image img-fluid"
                                                    src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Vertical/12a.webp"
                                                    class="w-100" alt="Blue Jeans Jacket" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <p><strong>Details</strong></p>
                                            <p><strong class="product-name">Blue denim shirt</strong></p>
                                            <p class="product-desc">Description</p>
                                            <button type="button" class="btn btn-danger btn-sm me-1 mb-2 delete-btn"
                                                data-mdb-toggle="tooltip" title="Remove item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="col-lg-4">
                                            <p><strong>Quantity</strong></p>
                                            <div class="d-flex mb-4">
                                                <button class="btn btn-primary sub-quant-btn"><i
                                                        class="fa-solid fa-minus"></i></button>
                                                <input min="0" name="quantity" value="1" type="text"
                                                    class="product-quantity mx-2" readonly>
                                                <button class="btn btn-primary add-quant-btn"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </div>
                                            <div class="d-flex mb-3">
                                                <span class="mr-2"><strong>Price :</strong></span>
                                                <input type="text" class="unit-price" value="20" readonly>
                                                <strong>/-</strong>
                                            </div>
                                            <div class="d-flex">
                                                <span class="mr-2"><strong>Total :</strong></span>
                                                <input type="text" class="product-cost" id="costInp" readonly>
                                                <strong>/-</strong>
                                            </div>

                                        </div>
                                    </div>
                                    <hr class="my-3" />
                                </div>

                            </div>

                            <!-- Cart section -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h5 class="mb-0">Your Cart</h5>
                                </div>
                                <div id="cartColumn">
                                </div>
                            </div>
                        </div>

                        <!-- Right column -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h5 class="mb-0">Summary</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                            Products
                                            <span><strong><i class="fa-solid fa-indian-rupee-sign mx-2"></i></strong><strong id="total"></strong><strong> /-</strong></span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            Shipping
                                            <span class="badge badge-success">FREE</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                            <div>
                                                <strong>Total amount</strong>
                                                <strong>
                                                    <p class="mb-0">(including TAX)</p>
                                                </strong>
                                            </div>
                                            <span><strong><i class="fa-solid fa-indian-rupee-sign mx-2"></i></strong><strong id="finalPrice"></strong> <strong> /-</strong></span>
                                        </li>
                                    </ul>

                                    <button type="button" class="btn btn-primary btn-lg btn-block" id="checkoutButton">
                                        Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('./include/footer.php') ?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="./js/cart.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>