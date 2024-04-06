<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/orders.css">

</head>

<body>
    <div class="container-fluid p-0">
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

        <div class="d-flex">
            <div class="col-lg-3 p-0">
                <?php include('./include/sidebar.php') ?>
            </div>
            <div class="col-lg-9 p-4">
                <div class="d-flex align-items-center justify-content-between mb-3" id="products">
                    <span class="section">Orders</span>
                </div>
                <!-- Statistics numbers -->
                <div class="d-flex mb-3 py-3">
                    <div class="col-lg-3">
                        <div class="total-products p-3">
                            <h5>Total Orders</h5>
                            <i class="fa-solid fa-book"></i>
                            <span id="orderCount">0</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="total-orders p-3">
                            <h5>Accepted</h5>
                            <i class="fa-solid fa-check-to-slot"></i>
                            <span id="acceptedCount">0</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="total-sales p-3">
                            <h5>Shipped</h5>
                            <i class="fa-solid fa-truck-plane"></i>
                            <span id="shippedCount">0</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="delivery-orders p-3">
                            <h5>Out for Delivery</h5>
                            <i class="fa-solid fa-truck"></i>
                            <span id="deliveryCount">0</span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="pending-orders p-3">
                            <h5>Delivered</h5>
                            <i class="fa-solid fa-circle-check"></i>
                            <span id="deliveredCount">0</span>
                        </div>
                    </div>
                </div>

                <!-- No orders -->
                <div id="noOrdersSection">
                    You have no orders
                </div>

                <div id="ordersSection">
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-placed-tab" data-toggle="pill" href="#pills-placed"
                                role="tab" aria-controls="pills-placed" aria-selected="false">Placed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-accepted-tab" data-toggle="pill" href="#pills-accepted"
                                role="tab" aria-controls="pills-accepted" aria-selected="false">Accepted</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-shipped-tab" data-toggle="pill" href="#pills-shipped"
                                role="tab" aria-controls="pills-shipped" aria-selected="false">Shipped</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-outForDelivery-tab" data-toggle="pill"
                                href="#pills-outForDelivery" role="tab" aria-controls="pills-outForDelivery"
                                aria-selected="false">Out for Delivery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-delivered-tab" data-toggle="pill" href="#pills-delivered"
                                role="tab" aria-controls="pills-delivered" aria-selected="false">Delivered</a>
                        </li>
                    </ul>

                    <!-- All orders -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Placed Table -->
                        <div class="tab-pane fade show active" id="pills-placed" role="tabpanel"
                            aria-labelledby="pills-placed-tab">
                            <div id="placed">
                                <div class="card-header mb-2">
                                    <strong>Placed</strong>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Buyer Details</th>
                                            <th scope="col" style="width:125px;">Date / Time</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Shipping Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="placedTable">
                                    </tbody>
                                </table>
                            </div>
                            <div id="noPlacedOrders" class="no-orders">
                                <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                                <p>NO ORDERS FOUND</p>
                            </div>
                        </div>

                        <!-- Accepted Section -->
                        <div class="tab-pane fade" id="pills-accepted" role="tabpanel"
                            aria-labelledby="pills-accepted-tab">
                            <div id="accepted">
                                <div class="card-header mb-2">
                                    <strong>Placed</strong>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Buyer Details</th>
                                            <th scope="col" style="width:125px;">Date / Time</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Shipping Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="acceptedTable">
                                    </tbody>
                                </table>
                            </div>
                            <div id="noAccepted" class="no-orders">
                                <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                                NO ORDERS FOUND
                            </div>
                        </div>

                        <!-- Shipped Section -->
                        <div class="tab-pane fade" id="pills-shipped" role="tabpanel"
                            aria-labelledby="pills-shipped-tab">
                            <div id="shipped">
                                <div class="card-header mb-2">
                                    <strong>Shipped</strong>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Buyer Details</th>
                                            <th scope="col" style="width:125px;">Date / Time</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Shipping Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="shippedTable">
                                    </tbody>
                                </table>
                            </div>
                            <div id="noShipped" class="no-orders">
                                <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                                NO ORDERS FOUND
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-outForDelivery" role="tabpanel"
                            aria-labelledby="pills-outForDelivery-tab">
                            <div id="outForDelivery">
                                <div class="card-header mb-2">
                                    <strong>Out for delivery</strong>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Buyer Details</th>
                                            <th scope="col" style="width:125px;">Date / Time</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Shipping Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deliveryTable">
                                    </tbody>
                                </table>
                            </div>
                            <div id="noDelivery" class="no-orders">
                                <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                                NO ORDERS FOUND
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-delivered" role="tabpanel"
                            aria-labelledby="pills-delivered-tab">
                            <div id="delivered">
                                <div class="card-header mb-2">
                                    <strong>Delivered</strong>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Buyer Details</th>
                                            <th scope="col" style="width:125px;">Date / Time</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Shipping Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deliveredTable">
                                    </tbody>
                                </table>
                            </div>
                            <div id="noDelivered" class="no-orders">
                                <img src="./assets/noOrders.jpg" class="img-fluid" alt="">
                                NO ORDERS FOUND
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    <script src="./js/orders.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>