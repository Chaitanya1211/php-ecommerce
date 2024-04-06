<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- CSS -->
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/products.css">

</head>

<body>
    <div class="container-fluid p-0" id="mainCont">
        <?php include('./include/header.php') ?>
        <div class="d-flex h-100">
            <div class="col-lg-3 p-0">
                <?php include('./include/sidebar.php') ?>
            </div>

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

            <!-- Snack bar delete -->
            <div id="snackBarDelete">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-trash-can mr-3"></i>
                    <span>Product Deleted Successfully</span>
                </div>
            </div>

            <div class="col-lg-9 p-0 p-5">
                <div class="d-flex align-items-center justify-content-between" id="products">
                    <span class="section">Products</span>
                    <span><button id="addProductBtn"><i class="fa-solid fa-plus mr-3"></i>Add Product</button></span>
                </div>

                <!-- product section -->
                <div id="productSection">
                    <!-- No product found -->
                    <div id="noProduct">
                        <img src="./assets/img-no-products.png" alt="">
                    </div>

                    <!-- Sample product card -->
                    <div id="sampleProduct" class="col-lg-3 my-3">
                        <div class="product">
                            <div class="image-wrapper">
                                <img alt="Product Image" class="productImage">
                            </div>
                            <div class="details-wrapper p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="productName">ProductName</span>
                                    <span class="productCost"><span><i class="fa-solid fa-indian-rupee-sign"></i></span>Cost</span>
                                </div>
                                <div class="productDesc my-2">Description</div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button class="delete deleteBtn mx-2">Delete</button>
                                    <button class="edit editBtn mx-2">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product row -->
                    <div id="productRow">
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete confirmation modal -->
        <div id="deleteModal">
            <div class="card" id="confirmModal">
                <div class="card-body">
                    <h5 class="card-title">Delete</h5>
                    <p class="card-text">Are you sure to delete this Product. <br>The product will be deleted
                        permanently.
                    </p>
                    <button id="closeButton" class="btn btn-secondary">Close</button>
                    <button id="confirmDelete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>

        <!-- Add New Product -->
        <div id="addProductParent">
            <div id="addProductContainer">
                <div class="top-left-band"></div>
                <!-- top -->
                <div class="form-parent">
                    <div id="productTitle" class="mb-4 text-center">
                        <span>Add Product</span>
                    </div>
                    <form name="newProduct" enctype="multipart/form-data">
                        <!-- Name -->
                        <div class="form-item">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Product name">
                            <span class="error" id="name-error">Please enter valid name</span>
                        </div>

                        <!-- select category -->
                        <div class="form-item">
                            <label for="category" class="m-0">Category</label>
                            <select name="category">
                                <option value="">Select Product category</option>
                                <option value="fashion">Fashion</option>
                                <option value="food">Food</option>
                                <option value="household">Household</option>
                                <option value="cosmetics">Cosmetics</option>
                                <option value="electronics">Electronics</option>
                                <option value="furniture">Furniture</option>
                            </select>
                            <span class="error" id="category-error">Pelect valid category</span>
                        </div>

                        <!-- Description -->
                        <div class="form-item">
                            <label for="description">Description</label>
                            <textarea name="description" cols="30" rows="3"></textarea>
                            <span class="error" id="desc-err">Please write description</span>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="formFile" name="image">
                            <div class="error" id="file-err">Please select product image</div>
                        </div>

                        <!-- Price -->
                        <div class="form-item mb-4">
                            <label for="cost">Price (INR)</label>
                            <input type="text" name="cost" placeholder="Product cost">
                            <div class="error" id="cost-err">Please enter valid cost</div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger" id="discardAdd">Discard</button>
                        <button class="btn" id="addProduct">Add Product</button>
                    </div>
                </div>
                <div class="bottom-right-band"></div>
            </div>
        </div>

        <!-- Edit Product -->
        <div id="editProductParent">
            <div id="editProductContainer">
                <div class="top-left-band"></div>
                <!-- top -->
                <div class="form-parent">
                    <div id="productTitle" class="mb-4 text-center">
                        <span>Edit Product Details</span>
                    </div>
                    <form name="editProductForm" enctype="multipart/form-data">

                        <!-- Name -->
                        <div class="form-item">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Product name">
                            <span class="error" id="name-error">Please enter valid name</span>
                        </div>

                        <!-- select category -->
                        <div class="form-item">
                            <label for="category" class="m-0">Category</label>
                            <select name="category">
                                <option value="">Select Product category</option>
                                <option value="fashion">Fashion</option>
                                <option value="food">Food</option>
                                <option value="household">Household</option>
                                <option value="cosmetics">Cosmetics</option>
                                <option value="electronics">Electronics</option>
                                <option value="furniture">Furniture</option>
                            </select>
                            <span class="error" id="category-error">Pelect valid category</span>
                        </div>

                        <!-- Description -->
                        <div class="form-item">
                            <label for="description">Description</label>
                            <textarea name="description" cols="30" rows="3"></textarea>
                            <span class="error" id="desc-err">Please write description</span>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="formFile" name="image">
                            <div class="error" id="file-err">Please select product image</div>
                        </div>

                        <!-- Price -->
                        <div class="form-item mb-4">
                            <label for="cost">Price (INR)</label>
                            <input type="text" name="cost" placeholder="Product cost">
                            <div class="error" id="cost-err">Please enter valid cost</div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger" id="discardEdit">Discard</button>
                        <button class="btn" id="editProduct">Edit Details</button>
                    </div>
                </div>
                <div class="bottom-right-band"></div>
            </div>
        </div>

    </div>
    <script src="./js/product.js"></script>
    <script src="./js/header.js"></script>
</body>

</html>