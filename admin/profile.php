<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./common.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/profile.css">


</head>

<body>
    <div class="container-fluid p-0" id="mainCont">
        <?php include('./include/header.php') ?>
        <div class="d-flex h-100">
            <div class="col-lg-3 p-0">
                <?php include('./include/sidebar.php') ?>
            </div>

            <div class="col-lg-9 p-5">
            <div class="d-flex align-items-center justify-content-between mb-3" id="products">
                    <span class="section">Profile</span>
                </div>
                    <div id="profileCard">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td id="name">Mark</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td id="email">Jacob</td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone</th>
                                    <td id="phone">Larry</td>
                                </tr>
                                <tr>
                                    <th scope="row">Address</th>
                                    <td id="address">Larry</td>
                                </tr>
                                <tr>
                                    <th scope="row">Business Phone</th>
                                    <td id="businessPh">Larry</td>
                                </tr>
                                <tr>
                                    <th scope="row">GST No</th>
                                    <td id="gst">Larry</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

    <script src="./js/profile.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>