<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/login.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="container my-5 px-5" id="wrapper">
        <div id="main">
            <div class="d-flex p-5">
                <!-- sign Up -->
                <div class="blue-band"></div>
                <div class="col-lg-6 p-0">
                    <div id="signUp">
                        <h3>Welcome Seller</h3>
                        <h4>Create your account</h4>
                        <h4>it's free</h4>
                        <button id="signUpBtn">Sign Up</button>
                    </div>
                </div>

                <!-- login -->
                <div class="col-lg-6 p-0">
                    <div id="login">
                        <h3 class="mb-4">Login</h3>
                        <form name="login">
                            <div class="form-item">
                                <label for="username">Email</label>
                                <input type="text" name="username" placeholder="Email">
                                <span class="error" id="emailError">Please enter valid Email Id</span>
                            </div>
                            <div class="form-item">
                                <label for="password">Password</label>
                                <input type="password" name="password" placeholder="Password">
                                <span class="error" id="passwordError">Password must not be empty</span>
                            </div>
                            <button type="button" id="loginBtn">Login</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Snack bar success -->
            <div id="snackBarSuccess">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check mr-3"></i>
                    <span>Note added successfully</span>
                </div>
            </div>

            <!-- Snack bar error -->
            <div id="snackBarError">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-xmark mr-3"></i>
                    <span>Please fill the details properly</span>
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

    <!-- Script -->
    <script src="./js/login.js"></script>

</body>

</html>