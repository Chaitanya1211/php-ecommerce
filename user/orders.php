<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/orders.css">
    <link rel="stylesheet" href="./css/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container">
        <?php include('./include/header.php') ?>
        <div id="loading" class="text-center">Loading...</div>
        <div id="content-wrapper">
            <section id="noOrders" class="text-center">
                <!-- image for no orders -->
                <img src="./assets/noOrders.jpg" alt="No orders found">
            </section>
            <section id="orders" class="my-3">
                <!-- Sample order card -->
                <div id="sampleOrder">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-1">
                                <strong>Id<br></strong>
                                <span><strong>#</strong></span>
                                <span class="order_id">1</span>
                            </div>
                            <div class="col-lg-2">
                                <!-- Image of the procudt -->
                                <img src="" alt="Product Image" class="order_image img-fluid">
                            </div>
                            <div class="col-lg-3">
                                <strong class="mb-2">Item Details</strong>
                                <p class="order_name">Item name</p>
                                <p class="order_desc">Descroption</p>
                                <p class="order_cost">Cost</p>
                            </div>
                            <div class="col-lg-2">
                                <strong class="mb-2">Seller Details</strong>
                                <p class="seller_name">Seller name</p>
                                <p class="seller_address">Seller address</p>
                                <p class="seller_gst">Seller gst no</p>
                            </div>
                            <div class="col-lg-2">
                                <strong class="mb-2">Shipping Details</strong>
                                <p class="user_name">User name</p>
                                <p class="user_add">USer address</p>
                                <p class="user_ph">user ph no</p>
                            </div>
                            <div class="col-lg-2">
                                <strong class="mb-2">Status</strong>
                                <div class="content d-flex flex-column px-3">
                                    <span class="badge my-2 placed">Placed</span>
                                    <span class="badge my-2 shipped">Shipped</span>
                                    <span class="badge my-2 delivery">Out for delivery</span>
                                    <span class="badge my-2 delivered">Delivered</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right date">Last updated : <span class="updated"></span></div>
                        <hr class="my-3" />
                    </div>
                </div>

                <div id="placed">
                    <div class="card-header">
                        <h5 class="mb-0">Placed Orders</h5>
                    </div>
                    <div id="placedColumn">

                    </div>
                </div>

                <div id="shipped">
                    <div class="card-header">
                        <h5 class="mb-0">Shipped</h5>
                    </div>
                    <div id="shippedColumn">

                    </div>
                </div>

                <div id="delivery">
                    <div class="card-header">
                        <h5 class="mb-0">Out for Delivery</h5>
                    </div>
                    <div id="deliveryColumn">

                    </div>
                </div>

                <div id="delivered">
                <div class="card-header">
                        <h5 class="mb-0">Delivered</h5>
                    </div>
                    <div id="deliveredColumn">

                    </div>
                </div>
            </section>
        </div>
        <?php include('./include/footer.php') ?>
    </div>

    <script src="./js/orders.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>