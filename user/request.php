<?php 
    require "../token.php";
    $endpoint = $_SERVER["REQUEST_URI"];
    $secret = "Yaza8sFtvAa5yXbOv5rZn2xsgEuD5z73";
    $parts= explode("/", $endpoint);
    // after request.php
    $base = $parts[4]; 
    

    $host="localhost";
    $username="root";
    $password="";
    $database="ecom";

    $conn = new mysqli($host,$username,$password,$database);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }else{
        global $base;
        global $conn;

        switch ($base){
            case 'register':
                register();
                break;

            case 'login':
                login();
                break;

            case 'products':
                products();
                break;

            case 'allProducts':
                getAllProducts();
                break;

            case 'category':
                $category=$parts[5];
                getCategory($category);
                break;

            case 'addToCart':
                $productId = $parts[5];
                addToCart($productId);
                break;

            case 'cart':
                getCart();
                break;
            
            case 'updateCart':
                updateCart();
                break;

            case 'deleteItem':
                $item_id = $parts[5];
                deleteFromCart($item_id);
                break;

            case 'placeOrder':
                placeOrder();
                break;

            case 'orders':
                getOrders();
                break;

            case 'orderCount':
                getOrderCount();
                break;

            case 'checkout':
                checkout();
                break;
            
            case 'updateAddress':
                updateAddress();
                break;

            default :
                $response = array("status" => "failure", "message"=>"cannot handle request on this endpoint");
                echo json_encode($response);
        }
            
    }

    function register(){
        global $conn;
        if(!empty($_POST)){
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phoneNo = $_POST["phoneNo"];
            $address = $_POST["address"];
            $password_temp = $_POST["password"];
            $password = password_hash($password_temp,PASSWORD_BCRYPT);
            try{
                $add = "INSERT INTO users(name,email,phone_no,address,password) VALUES('$name','$email','$phoneNo','$address','$password')";
                $res= $conn->query($add);
                    if($res === true){
                        $response = array("status" => "success", "message"=>"User added");
                        echo json_encode($response);
                    }else{
                        $response = array("status" => "failure", "message"=>"User not added", "error" => $res);
                        echo json_encode($response);
            }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            $response = array("status" => "failure", "message" => "Request body not found");
            echo json_encode($response);
        }
    }

    function login(){
        global $conn;
        global $secret;
        if(!empty($_POST)){
            $email = $_POST["email"];
            $password = $_POST["password"];
            try{
                $get_user = "SELECT * from users WHERE email='$email'";
                $result= $conn->query($get_user);

                if($result->num_rows > 0){
                    $user = $result->fetch_assoc();
                    if(password_verify($password, $user["password"])){
                        $payload=[
                            "id" => $user["user_id"],
                            "userEmail" => $user["email"]
                        ];
                        $token = Token::Sign($payload, $secret);
                        $response = array("status"=>"success", "message"=>"Login success", "user" => $user, "token"=>$token);
                        echo json_encode($response);
                    }else{
                        $response = array("status"=>"failure", "message"=>"Incorrect password");
                        echo json_encode($response);
                    }
                }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            $response = array("status" => "failure", "message" => "Request body not found");
            echo json_encode($response);
        }
    }

    function products(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            // valid user
            $userId = $res["id"];
            try{
                // get all products
                $products = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
                $result = $conn->query($products);
                if($result->num_rows > 0){
                    $productsArray=array();
                    while($row = $result->fetch_assoc()){
                        $productsArray[] = $row;
                    }
                    $response = array("status" => "success", "message" => "Products Found","products" => $productsArray);
                    echo json_encode($response);
                }else{
                    // no products present
                    $response = array("status" => "failure", "message" => "No Products Found");
                    echo json_encode($response);
                }

            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }
    }

    function getAllProducts(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
             // valid user
             $userId = $res["id"];
             try{
                // get all products
                $products = "SELECT * FROM products ORDER BY category";
                $result = $conn->query($products);
                if($result->num_rows > 0){
                    // $productsArray=array();
                    $fashionArray=array();
                    $foodArray=array();
                    $householdArray=array();
                    $cosmeticsArray=array();
                    $electronicsArray=array();
                    $furnitureArray=array();
                    while($row = $result->fetch_assoc()){
                        if($row["category"] == "fashion"){
                            $fashionArray[] = $row;
                        }else if($row["category"] == "food"){
                            $foodArray[] = $row;
                        }else if($row["category"] == "household"){
                            $householdArray[] = $row;
                        }else if($row["category"] == "cosmetics"){
                            $cosmeticsArray[] = $row;
                        }else if($row["category"] == "electronics"){
                            $electronicsArray[] = $row;
                        }else if($row["category"] == "furniture"){
                            $furnitureArray[] = $row;
                        }
                        
                    }
                    $response = array("status" => "success", "message" => "Products Found","fashion" => $fashionArray, "food" => $foodArray, "household" => $householdArray, "cosmetics" => $cosmeticsArray, "electronics" => $electronicsArray, "furniture" => $furnitureArray);
                    echo json_encode($response);
                }else{
                    // no products present
                    $response = array("status" => "failure", "message" => "No Products Found");
                    echo json_encode($response);
                }

            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }

        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }
    }
    function getCategory($category){
        global $conn;
        global $secret;

        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            try{
                // echo $category;
                $categoryQuery ="SELECT * from categories WHERE name='$category'";
                $result = $conn->query($categoryQuery);

                if($result->num_rows > 0){
                    $category_details = $result->fetch_assoc();
                    $allProducts ="SELECT * from products WHERE category='$category'";
                    $allres = $conn->query($allProducts);
                    $productsArray=array();
                    if($allres->num_rows > 0){
                        while($row = $allres->fetch_assoc()){
                            $productsArray[] = $row;
                        }
                    }else{
                        echo "No products found";
                    }
                    $response = array("status" => "success", "message" => "Category Found","details" => $category_details , "products" => $productsArray);
                    echo json_encode($response);
                }else{
                    // no data found
                    $response = array("status" => "failure", "message" => "No Products Found");
                    echo json_encode($response);
                }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }

    }

    function addToCart($productId){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            // success
            $userId = $res["id"];
                try{
                    // check if already presesnt
                    $check = "SELECT * from cart WHERE cart.product_id='$productId' AND cart.user_id='$userId'";
                    $checkResult = $conn->query($check);
                    if($checkResult->num_rows > 0){
                        // update the quantity to +1
                        $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$userId' AND product_id = '$productId'";
                        $updateResult = $conn->query($updateQuery);
        
                        if ($updateResult) {
                            $response = array("status" => "success", "message" => "Quantity Updated in Cart");
                            echo json_encode($response);
                        } else {
                            $response = array("status" => "failure", "message" => "Failed to update quantity in Cart");
                            echo json_encode($response);
                        }

                    }else{
                        $addQuery = "INSERT INTO cart(`user_id`,`product_id`) VALUES('$userId','$productId')";
                        $result=$conn->query($addQuery);
        
                        if($result == true){
                            $response = array("status" => "success", "message" => "Product Added to Cart");
                            echo json_encode($response);
                        }else{
                            $response = array("status" => "failure", "message" => "Product Not Added");
                            echo json_encode($response);
                        }
                    }
    
                }catch(mysqli_sql_exception $e){
                    $response = array("status" => "error", "message" => $e->getMessage());
                    echo json_encode($response);
                }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }

    }

    function getCart(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $userId= $res["id"];
            try{
                $cart = "SELECT cart.id AS cart_id ,cart.quantity AS quantity, cart.product_id AS product_id ,products.* FROM cart INNER JOIN products ON cart.product_id=products.id WHERE cart.user_id='$userId'";
                $result=$conn->query($cart);
                $cartArray =array();
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $cartArray[] = $row;
                    }
                    $response = array("status" => "success", "message" => "Cart Items", "cart" => $cartArray);
                    echo json_encode($response);
                }else{
                    $response = array("status" => "success", "message" => "Cart Empty", "cart" => $cartArray);
                    echo json_encode($response);
                }

            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }

    }

    function updateCart(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $json_data = file_get_contents('php://input');
            $dataArray = json_decode($json_data, true);
            if($dataArray != null){
                foreach($dataArray as $data){
                    $id = $data["cart_id"];
                    $quantity = $data["quantity"];
                    $sql = "UPDATE cart SET quantity='$quantity' WHERE id='$id'";
                    $result = $conn->query($sql);
                    if($result != true){
                        $response = array("status"=>"failure", "message"=>"unable to update cart");
                        echo json_encode($response);
                    }
                }
                $response = array("status"=>"success", "message"=>"cart updated");
                echo json_encode($response);
            }else{
                $response = array("status"=>"failure", "message"=>"request body not found");
                echo json_encode($response);
            }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }
    }

    function deleteFromCart($item_id){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $userId = $res["id"];
            try{
                // delete the item from cart
                $deleteQuery = "DELETE FROM cart WHERE id='$item_id'";
                $result=$conn->query($deleteQuery);
                if($result==true){
                    $response = array("status" => "success", "message" => "Product Deleted From cart");
                    echo json_encode($response);
                }else{
                    $response = array("status" => "failure", "message" => "Product Not Deleted");
                    echo json_encode($response);
                }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }

    }

    function placeOrder(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);

        if($res == true){
            $userId = $res["id"];
            try{
                // move all items in cart into orders 
                $addToOrders = "INSERT INTO orders(user_id,product_id,quantity) SELECT user_id,product_id,quantity FROM cart WHERE user_id='$userId'";
                $result = $conn->query($addToOrders);

                $deleteFromCart = "DELETE FROM cart WHERE user_id='$userId'";
                $deleteRes = $conn->query($deleteFromCart);

                if($result && $deleteRes){
                        $response = array("status" => "success", "message" => "Order placed");
                        echo json_encode($response);
                }else{
                    $response = array("status" => "failure", "message" => "Failed to place order");
                    echo json_encode($response);
                }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }

        }else{
             // invalid token
             $response = array("status" => "failure", "message" => "Invalid Token");
             echo json_encode($response);
        }

    }

    function getOrders(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $userId=$res["id"];
            $orders = "SELECT orders.*, products.name AS product_name, products.description AS product_desc, products.price AS product_price, products.image AS product_img, seller.name AS seller_name, seller.address AS seller_add, seller.gst AS seller_gst,seller.phone AS seller_phone,seller.email AS seller_email, users.name AS user_name , users.address AS user_add, users.phone_no AS user_phone , users.address2 AS user_address2 FROM orders INNER JOIN products ON orders.product_id=products.id INNER JOIN seller ON products.seller_id=seller.id INNER JOIN users ON orders.user_id = users.user_id WHERE orders.user_id='$userId' ORDER BY latestUpdate DESC";
            $result = $conn->query($orders);
            $ordersArray=array();
            $accepted=array();
            $shipped=array();
            $outForDelivery=array();
            $delivered=array();

            if($result->num_rows > 0){
                while($row= $result->fetch_assoc()){
                    $ordersArray[] = $row;
                    if($row["status"] == "accepted"){
                        $accepted[] =$row;
                    }else if($row["status"] == "shipped"){
                        $shipped[] = $row;
                    }else if($row["status"] == "delivery"){
                        $outForDelivery[] = $row;
                    }else if($row["status"] == "delivered"){
                        $delivered[] = $row;
                    }
                }
                $response = array("status" => "success", "message" => "Orders found","all" => $ordersArray ,"accepted"=> $accepted, "shipped"=>$shipped, "delivery"=>$outForDelivery, "delivered"=>$delivered);
                echo json_encode($response);
            }else{
                $response = array("status" => "failure", "message" => "No orders", "orders"=>$ordersArray);
                echo json_encode($response);
            }
        }else{
             // invalid token
             $response = array("status" => "failure", "message" => "Invalid Token");
             echo json_encode($response);
        }
    }

    function getOrderCount(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);

        if($res == true){
            $userId=$res["id"];
            try{
                $count = "SELECT COUNT(*) AS cart_count from cart WHERE user_id='$userId'";
                $result = $conn->query($count);
                $cartCount;

                $name = "SELECT users.name AS user_name from users WHERE user_id='$userId'";
                $userDet= $conn->query($name);
                $userName;
                if($userDet){
                    while($row = $userDet->fetch_assoc()){
                        $userName = $row["user_name"];
                    }
                }

                if($result){
                    while($row = $result->fetch_assoc()){
                        $cartCount = $row['cart_count'];
                    }
                }

                $response = array("status" => "success", "message" => "Details Found", "cart" => $cartCount, "name" => $userName);
                echo json_encode($response);
                // else{
                //     $response = array("status" => "failues", "message" => "Cart not found", "cart" => $cartCount);
                //     echo json_encode($response);
                // }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }
    }

    function checkout(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $userId=$res["id"];
            $userDetails = "SELECT users.name AS user_name, users.email AS user_email, users.phone_no AS user_phone, users.address AS user_address, users.address2 AS user_address2 from users WHERE users.user_id='$userId'";
            $result = $conn->query($userDetails);
            $userData=array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $userData[] = $row;
                }
            }else{
                $userData = [];
            }

            $products = "SELECT cart.id AS cart_id ,cart.quantity AS quantity, cart.product_id AS product_id ,products.* FROM cart INNER JOIN products ON cart.product_id=products.id WHERE cart.user_id='$userId'";
            $prodRes = $conn->query($products);
            $productData=array();
            if($prodRes->num_rows > 0){
                while($row = $prodRes->fetch_assoc()){
                    $productData [] = $row;
                }
            }

            $response = array("status" => "success", "message" => "Checkout Items", "userdata" => $userData, "productdata" => $productData);
            echo json_encode($response);

        }else{
            // invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }
    }
    
    function updateAddress(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            if(!empty($_POST)){
                $address=$_POST["address"];
                $userId = $res["id"];
                try{
                    $updateQuery = "UPDATE users SET address2='$address' WHERE user_id='$userId'";
                    $result = $conn->query($updateQuery);
                    if($result == true){
                        $response = array("status" => "success", "message" => "Address updated");
                        echo json_encode($response);
                    }else{
                        $response = array("status" => "failure", "message" => "Address updated");
                        echo json_encode($response);
                    }
                }catch(mysqli_sql_exception $e){
                   $response = array("status" => "error", "message" => $e->getMessage());
                   echo json_encode($response);
                }
            }
        }else{
             // invalid token
             $response = array("status" => "failure", "message" => "Invalid Token");
             echo json_encode($response);
        }
    }
?>