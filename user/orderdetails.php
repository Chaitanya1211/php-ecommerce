<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/orderdetails.css">
    <link rel="stylesheet" href="./css/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container">
        <?php include('./include/header.php') ?>
        <div id="sampleCard" class="mb-3">
            <div class="top-left"></div>
            <div class="d-flex flex-column p-3">
                <!-- Product details -->
                <div class="products">
                    <!-- image -->
                    <div class="d-flex product-details p-3 flex-wrap">
                        <div class="col-lg-4">
                            <div class="image-wrapper mb-3">
                                <img src="./assets/samplephone.jpg" alt="" class="product-image">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <strong class="product-name">Product name</strong>
                            <div class="product-description">Product description</div>
                            <div class="d-flex">
                                <strong class="product-quantity">quantity </strong>
                                <strong class="mx-2">X</strong>
                                <strong class="product-price">unit price</strong>
                            </div>
                            <p>Payment mode : <strong>Cash On Deliery</strong></p>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-lg-right text-sm-left">
                                <span class="badge placed">Placed</span>
                                <span class="badge accepted">Accepted</span>
                                <span class="badge shipped">Shipped</span>
                                <span class="badge delivery">Out for Delivery</span>
                                <span class="badge delivered">Delivered</span>
                                <div class="last">Last updated</div>
                                <p class="last-updated">12th March 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Address details -->
                <div class="d-flex px-3 pt-3 flex-wrap">
                    <div class="col-lg-6 userDetails">
                        <strong class="mb-3">Shipping Address</strong>
                        <div class="user-name">User name</div>
                        <div class="user-address">User address</div>
                        <div class="user-phone mb-3">user phone</div>

                    </div>

                    <div class=" col-lg-6 sellerDetails">
                        <strong>Seller Details</strong>
                        <div class="seller-name">seller name</div>
                        <div class="seller-address">seller address</div>
                        <div class="seller-gst">seller gst no</div>
                        <div class="seller-ph-email mb-3">seller business phone,seller business email</div>

                    </div>
                </div>
            </div>
            <div class="bottom-right"></div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="col-lg-3 left-nav my-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
                        aria-controls="v-pills-home" aria-selected="true">  <i class="fa-solid fa-book mr-2"></i> All</a>
                    <a class="nav-link" id="v-pills-accepted-tab" data-toggle="pill" href="#v-pills-accepted" role="tab"
                        aria-controls="v-pills-accepted" aria-selected="false"><i class="fa-solid fa-check-to-slot mr-2"></i>Accepted</a>
                    <a class="nav-link" id="v-pills-shipped-tab" data-toggle="pill" href="#v-pills-shipped" role="tab"
                        aria-controls="v-pills-shipped" aria-selected="false"> <i class="fa-solid fa-truck-plane mr-2"></i>Shipped</a>
                    <a class="nav-link" id="v-pills-delivery-tab" data-toggle="pill" href="#v-pills-delivery" role="tab"
                        aria-controls="v-pills-delivery" aria-selected="false"><i class="fa-solid fa-truck mr-2"></i>Out for delivery</a>
                    <a class="nav-link" id="v-pills-delivered-tab" data-toggle="pill" href="#v-pills-delivered"
                        role="tab" aria-controls="v-pills-delivered" aria-selected="false"><i class="fa-solid fa-circle-check mr-2"></i>Delivered</a>
                </div>
            </div>
            <div class="col-lg-9 my-3">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <!-- All orders -->
                        <div id="allOrders">

                        </div>
                        <div id="noAllOrders" class="no-orders">
                            <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                            <p>NO ORDERS FOUND</p>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="v-pills-accepted" role="tabpanel"
                        aria-labelledby="v-pills-accepted-tab">
                        <div id="acceptedOrders">

                        </div>
                        <div id="noAcceptedOrders" class="no-orders">
                            <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                            <p>NO ORDERS FOUND</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-shipped" role="tabpanel"
                        aria-labelledby="v-pills-shipped-tab">
                        <div id="shippedOrders">

                        </div>
                        <div id="noShippedOrders" class="no-orders"> 
                            <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                            <p>NO ORDERS FOUND</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-delivery" role="tabpanel"
                        aria-labelledby="v-pills-delivery-tab">
                        <div id="outForDelivery">

                        </div>
                        <div id="noDeliveryOrders" class="no-orders">
                            <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                            <p>NO ORDERS FOUND</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-delivered" role="tabpanel"
                        aria-labelledby="v-pills-delivered-tab">
                        <div id="deliveredOrders">

                        </div>
                        <div id="noDeliveredOrders" class="no-orders">
                            <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                            <p>NO ORDERS FOUND</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="./js/orderDetails.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>