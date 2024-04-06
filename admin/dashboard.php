<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/dashboard.css">

    <!-- Font aawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container-fluid p-0" id="mainCont">
        <?php include('./include/header.php') ?>
        <div class="d-flex flex-wrap h-100">
            <div class="col-lg-3 p-0">
                <?php include('./include/sidebar.php') ?>
            </div>

            <div class="col-lg-9 p-4">
                <!-- Statistics numbers -->
                <div class="d-flex flex-wrap mb-5">
                    <div class="col-lg-3">
                        <div class="total-products p-3">
                            <h5>Total Products</h5>
                            <i class="fa-solid fa-book"></i>
                            <span id="productCount">0</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="total-orders p-3">
                            <h5>Total orders</h5>
                            <i class="fa-solid fa-arrow-up-1-9"></i>
                            <span id="orderCount">0</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="total-sales p-3">
                            <h5>Total Sales</h5>
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                            <span id="salesCount">0</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="pending-orders p-3">
                            <h5>Pending Orders</h5>
                            <i class="fa-solid fa-truck"></i>
                            <span id="pendingOrdersCount">0</span>
                        </div>
                    </div>
                </div>
                <!-- Charts -->
                <div class="d-flex flex-wrap mb-5">
                    <div class="col-lg-6">
                        <div class="categoryVsSales">
                            <h4>Category Sales</h4>
                            <!-- // chart here -->
                            <canvas id="barChart" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="orderVsStatus">
                            <h4>Order Status</h4>
                            <canvas id="pieChart" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>

                <div id="recentOrders">
                        <div class="card-header mb-2">
                            <strong>Recent Orders</strong>
                        </div>
                        <table class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr No</th>
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Buyer Details</th>
                                        <th scope="col">Shipping Address</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTable">

                                    </tbody>
                            </table>
                        </table>
                    </div>

            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="./js/dashboard.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>