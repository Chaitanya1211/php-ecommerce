<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/register.css">
    <link rel="stylesheet" href="common.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
<div class="container my-5 px-5" id="wrapper">
        <div id="main" class="p-5">
           <h2>User Registration</h2>
            <div class="blue-line"></div>
                <div class="px-4 my-4" id="leftForm">
                    <form name="userRegistration">
                        <div class="form-item">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Name">
                            <span class="error" id="nameError">Please enter Name</span>
                        </div>
                        <div class="form-item">
                            <label for="email">Email</label>
                            <input type="text" name="email" placeholder= "Email">
                            <span class="error" id="emailError">Please enter valid Email Id</span>
                        </div>

                        <div class="form-item">
                            <label for="phoneNo">Phone Number</label>
                            <input type="text" name="phoneNo" placeholder= "Phone Number">
                            <span class="error" id="numberError">Please enter valid Phone number</span>
                        </div>

                        <div class="form-item">
                            <label for="address">Address</label>
                            <input type="text" name="address" placeholder="Address">
                            <span class="error" id="addressError">Please enter address</span>
                        </div>

                        <div class="form-item">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="Password">
                            <span class="error" id="passwordError">Password must not be empty</span>
                        </div>

                        <div class="form-item">
                            <label for="cpassword">Confirm Password</label>
                            <input type="password" name="cpassword" placeholder="Confirm Password">
                            <span class="error" id="cpassError">Please enter valid password</span>
                        </div>
                    </form>
                </div>
            <div class="w-100 text-center mt-3">
                <button class="blue-btn" id="registerBtn">Register</button>
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
<script src="./js/register.js"></script>
</body>

</html>