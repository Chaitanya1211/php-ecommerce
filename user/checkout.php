<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/checkout.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container">
        <?php include('./include/header.php') ?>
        <!-- Order placed pop up -->
        <section>
            <div class="overlay" id="overlay"></div>
            <div class="popup" id="popup">
                <img src="./assets/404-tick.png" alt="" width="100px" height="100px">
                <h2>Thank You</h2>
                <p>Your order has been placed successfuly</p>
                <p class="mb-4">Thank you for shopping with us</p>
                <div class="d-flex justify-content-between">
                    <button id="close-btn" onclick="closePopup()">OK</button>
                    <a href="http://localhost/ecommerce/user/orderdetails.php"><button id="close-btn">View
                            Orders</button></a>
                </div>
            </div>
        </section>

        <section id="summary" class="my-3">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="row">
                <div class="col-lg-8 my-3">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Product Details</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody id="productsBody">

                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4 my-3">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Products
                                    <span>
                                        <strong><i class="fa-solid fa-indian-rupee-sign mx-2"></i></strong>
                                        <strong id="total"></strong>
                                        <strong> /-</strong>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
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
                                    <span>
                                        <strong><i class="fa-solid fa-indian-rupee-sign mx-2"></i></strong>
                                        <strong id="finalPrice"></strong>
                                        <strong> /-</strong>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="shipping" class="my-3">
            <div class="card-header">
                <h5 class="mb-0">Shipping Details</h5>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <h5 class="m-3">Primary / Billing Address</h5>
                    <div class="card m-3">
                        <div class="card-body">
                            <h5 class="card-title" id="userName">Name of user</h5>
                            <h6 class="card-subtitle mb-2 text-muted" id="userPhone">+91 4860531659</h6>
                            <h6 class="card-subtitle mb-2 text-muted" id="userEmail">abc@gmail.com</h6>
                            <p class="card-text" id="userAddress">Address of the user</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="m-3">
                        <span>
                            <h5>Add Shipping address</h5>
                            <p class="mb-2">Orders will be shipped/delivered to this address</p>
                        </span>
                        <form name="addressForm">
                            <div class="d-flex flex-column">
                                <label for="address2">Address</label>
                                <input name="address2" id="address2" placeholder="Enter new address"
                                    class="mb-0"></input>
                                <span class="error my-2" id="address2Error">Address must not be empty</span>
                                <button type="button" class="btn btn-primary float-right my-2"
                                    onclick="updateAddress(event)">Add
                                    Address</button>
                            </div>
                        </form>
                        <div class="success" id="addressSuccess">
                            Address updated successfully
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="deliveryDate" class="my-3">
            <div class="card-header">
                <h5 class="mb-0">Delivery Details</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Your order is estimated to be delivered within <strong>7 business days</strong>
                    from the date of purchase. Please note that delivery times may vary depending on factors such as product
                    availability, shipping location, and courier service.</p>
            </div>
        </section>

        <section id="payment" class="my-3">
            <div class="card-header">
                <h5 class="mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                <p class="card-text">We accept only <strong>Cash On Delivery (COD) </strong>as a payment method. Please
                    have exact cash ready upon delivery. Our delivery personnel will collect
                    payment at your doorstep.</p>
            </div>
        </section>

        <section class="placeOrder my-4">
            <button type="button" class="btn btn-success btn-lg btn-block" id="checkoutButton" onclick="placeOrder()">
                Confirm Order
            </button>
        </section>
        <?php include('./include/footer.php') ?>
    </div>

    <script src="./js/checkout.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>