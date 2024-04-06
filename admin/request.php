<?php 
    require "../token.php";
    $endpoint = $_SERVER["REQUEST_URI"];
    $secret = "3P328LIC8X5RWB9PWW0UWRSB002X6W97";
    $parts= explode("/", $endpoint);
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

        switch($base){
            case 'register':
                register();
                break;

            case 'login':
                login();
                break;

            case 'profile':
                profile();
                break;

            case 'addProduct':
                addProduct();
                break;

            case 'getProducts':
                getProducts();
                break;

            case 'deleteProduct':
                $productId= $parts[5];
                deleteProduct($productId);
                break;
            
            case 'editProduct':
                $productId = $parts[5];
                editProduct($productId);
                break;
            
            case 'orders':
                getOrders();
                break;

            case 'dashboard':
                getDashboard();
                break;

            case 'changeStatus':
                $orderId=$parts[5];
                changeOrderStatus($orderId);

                break;

            default :
                $response = array("status" => "failure", "message"=>"cannot handle request on this endpoint");
                echo json_encode($response);
        }
    }

    function register(){
        global $conn;
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if($data != null){
            $name=$data["name"];
            $email=$data["email"];
            $phone=$data["number"];
            $password = password_hash($data["password"],PASSWORD_BCRYPT);
            $address = $data["address"];
            $businessContact = $data["contact"];
            $gst = $data["gst"];

            try{
                $addSeller = "INSERT INTO seller(name,email,phone,address,business_ph,gst,password) VALUES ('$name','$email','$phone','$address','$businessContact','$gst','$password')";
                $result = $conn->query($addSeller);
    
                if($result === true){
                    $response = array("status"=>"success", "message"=>"Seller added successfully");
                    echo json_encode($response);
                }else{
                    $response = array("status"=>"success", "message"=>"Seller not added", "error"=>$result);
                    echo json_encode($response);
                }
            }catch (mysqli_sql_exception $e){
                    $response = array("status" => "error", "message" => $e->getMessage());
                    echo json_encode($response);
            }
        }else{
            $response = array("status"=>"failure", "message"=>"request body not found");
            echo json_encode($response);
        }
    }

    function login(){
        global $secret;
        global $conn;
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if($data != null){
            $email = $data["email"];
            $password = $data["password"];

            $getSeller = "SELECT * from seller WHERE email='$email'";
            $result = $conn->query($getSeller);
            if($result->num_rows > 0){
                $seller = $result->fetch_assoc();
                if(password_verify($password, $seller["password"])){
                    $payload=[
                        "id" => $seller["id"],
                        "sellerEmail" => $seller["email"]
                    ];
                    $token = Token::Sign($payload, $secret);
                    $response = array("status"=>"success", "message"=>"Login success", "seller" => $seller, "token"=>$token);
                    echo json_encode($response);
                }else{
                    $response = array("status"=>"failure", "message"=>"Incorrect password");
                    echo json_encode($response);
                }
            }else{
                $response = array("status"=>"failure", "message"=>"Seller not found");
                echo json_encode($response);
            }
        }else{
            $response = array("status"=>"failure", "message"=>"request body not found");
            echo json_encode($response);
        }
    }

    function profile(){
        global $conn;
        global $secret;
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == false){
            // false invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);

        }else{
            // true res madhe payload
            $sellerId=$res["id"];
            $sellerQuery = "SELECT * FROM seller WHERE id='$sellerId'";
            $result = $conn->query($sellerQuery);
            if($result->num_rows > 0){
                $seller = $result->fetch_assoc();
                $response = array("status" => "success","details" => $seller);
                echo json_encode($response);
            }else{
                $response = array("status" => "failure", "message" => "Unable to fetch seller details");
                echo json_encode($response);
            }
        }
    }

    function addProduct(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == false){
            // false invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        } else {
            $sellerId = $res["id"];
            // Check if form data is present
            if (!empty($_POST)) {
                $name = $_POST['name'];
                $category = $_POST['category'];
                $description = $_POST['description'];
                $cost = $_POST['cost'];

                if(isset($_FILES['image'])) {
                    $file_name = $_FILES['image']['name'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
    
                    $upload_dir = '../uploads/'; 
                    $timestamp = time(); // Get the current Unix timestamp
                    $unique_filename = $timestamp . '_' . $file_name;
                    $upload_path = $upload_dir . $unique_filename;
                    
                    if(move_uploaded_file($file_tmp, $upload_path)){
                        // insert into databse
                        $insertProduct= "INSERT INTO products(name,category,description,price,image,seller_id) VALUES ('$name','$category','$description','$cost','$upload_path','$sellerId')";
                        $result = $conn->query($insertProduct);
                        if($result === true){
                            $response = array("status" => "success","message" => "Product added");
                            echo json_encode($response);
                        }else{
                            $response = array("status" => "success","message" => "Failed to add Product");
                            echo json_encode($response);
                        }
                    } else {
                        $response = array("status" => "failure", "message" => "Failed to upload image");
                        echo json_encode($response);
                    }
                } else {
                    // No image uploaded
                    $response = array("status" => "failure", "message" => "No image uploaded");
                    echo json_encode($response);
                }
            } else {
                $response = array("status" => "failure", "message" => "Request body not found");
                echo json_encode($response);
            }
        }
    }

    function getProducts(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);

        if($res == false){
             // false invalid token
             $response = array("status" => "failure", "message" => "Invalid Token");
             echo json_encode($response);
        }else{
            // fetch all the products of the particular seller id
            $sellerId = $res["id"];
            $productQuery = "SELECT * FROM products WHERE seller_id='$sellerId'";
            $result=$conn->query($productQuery);
            $productCount=0;
            if($result->num_rows > 0){
                $products=array();
                while($row = $result->fetch_assoc()){
                    $products[] = $row;
                    $productCount++;
                }
                $response = array("status" => "success", "message" => "Products Found","count"=> $productCount ,"products" => $products);
                echo json_encode($response);

            }else{
                // no products found
                $response = array("status" => "success", "message" => "No Products Found","count"=> $productCount);
                echo json_encode($response);
            }
        }
    }

    function deleteProduct($productId){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res === false){
            // false invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }else{
            if($productId != null){
                $delete = "DELETE FROM products WHERE id='$productId'";
                $res= $conn->query($delete);
                if($res === true){
                    $response = array("status" => "success", "message" => "Product Deleted");
                    echo json_encode($response);
                }else{
                    $response = array("status" => "failure", "message" => "Product Not Deleted");
                    echo json_encode($response);
                }
            }else{
                $response = array("status" => "error", "message" => "Id not found");
                echo json_encode($response);
            }
        }
    }

    function editProduct($productId){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res === false){
            // false invalid token
            $response = array("status" => "failure", "message" => "Invalid Token");
            echo json_encode($response);
        }else{
            $sellerId = $res["id"];
            if(!empty($_POST)){
                $name = $_POST['name'];
                $category = $_POST['category'];
                $description = $_POST['description'];
                $cost = $_POST['cost'];

                if(isset($_FILES['image'])){
                    $file_name = $_FILES['image']['name'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
    
                    $upload_dir = 'uploads/'; 
                    $timestamp = time(); // Get the current Unix timestamp
                    $unique_filename = $timestamp . '_' . $file_name;
                    $upload_path = $upload_dir . $unique_filename;

                    if(move_uploaded_file($file_tmp, $upload_path)){
                        $update = "UPDATE products SET name='$name',category='$category',description='$description',price='$cost',image='$upload_path' WHERE id='$productId'";
                        $res=$conn->query($update);
                        if($res === true){
                            $response = array("status" => "success", "message" => "Product updated");
                            echo json_encode($response);
                        }else{
                            $response = array("status" => "failure", "message" => "Product updation failed");
                            echo json_encode($response);
                        }
                    }
                }
            }else{
                $response = array("status" => "failure", "message" => "Request body not found");
                echo json_encode($response);
            }

        }
    }
    
    function getOrders(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $sellerId=$res["id"];
            try{
                $getOrders = "SELECT orders.order_id AS order_id,orders.status AS order_status,orders.date AS order_date,orders.time AS order_time,orders.quantity AS order_quantity, users.name AS user_name, users.email AS user_email, users.phone_no AS user_phone, users.address AS user_address,users.address2 AS user_address2 ,products.name AS product_name FROM orders INNER JOIN users ON orders.user_id=users.user_id INNER JOIN products ON orders.product_id=products.id WHERE products.seller_id='$sellerId' ORDER BY latestUpdate DESC";
                $result = $conn->query($getOrders);
                $allOrders = array();
                $placed=array();
                $accepted =array();
                $shipped=array();
                $outForDelivery=array();
                $delivered=array();
                $count=0;
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $allOrders[] = $row;
                        if($row["order_status"] == "placed"){
                            $placed[] =$row;
                        }else if($row["order_status"] == "accepted"){
                            $accepted[] = $row;
                        }else if($row["order_status"] == "shipped"){
                            $shipped[] = $row;
                        }else if($row["order_status"] == "delivery"){
                            $outForDelivery[] = $row;
                        }else if($row["order_status"] == "delivered"){
                            $delivered[] = $row;
                        }
                        $count++;
                    }
                    $response = array("status" => "success", "message" => "Orders found","total"=>$count,"allOrders" => $allOrders ,"placed"=> $placed, "accepted" => $accepted ,"shipped"=>$shipped, "delivery"=>$outForDelivery, "delivered"=>$delivered);
                    echo json_encode($response);
                }else{
                    // no orders found
                    $response = array("status" => "failure", "message" => "No orders found","total"=>$count, "placed"=> $placed, "shipped"=>$shipped, "delivery"=>$outForDelivery, "delivered"=>$delivered);
                    echo json_encode($response);
                }
            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            $response = array("status" => "failure", "message" => "Invalid token");
            echo json_encode($response);
        }
    }

    function getDashboard(){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res == true){
            $sellerId=$res["id"];
            try{

                // Total products count
                $productCount = "SELECT COUNT(*) AS total_count FROM products WHERE seller_id='$sellerId'";
                $productCountQuery = $conn->query($productCount);
                $totalProducts = 0;
                if($productCountQuery == true){
                    $row = $productCountQuery->fetch_assoc();
                    $totalProducts = $row['total_count']; 
                }else{
                    $totalProducts = 0;
                }
                
                // Category vs sales bar graph
                $graphData1 = "SELECT products.category, COUNT(*) AS order_count FROM orders INNER JOIN products ON orders.product_id=products.id WHERE products.seller_id='$sellerId' GROUP BY products.category";
                $graph1 = $conn->query($graphData1);
                $categoryVsSales=[];
                if($graph1->num_rows > 0){
                    while($row = $graph1->fetch_assoc()){
                        $categoryVsSales[$row["category"]] = $row["order_count"];
                    }
                }

                // Orders status
                $graphData2= "SELECT orders.status, COUNT(*) AS status_count FROM orders INNER JOIN products ON orders.product_id=products.id WHERE products.seller_id='$sellerId' GROUP BY orders.status";
                $graph2 = $conn->query($graphData2);
                $orderVsStatus=[];
                if($graph2->num_rows > 0){
                    while($row = $graph2->fetch_assoc()){
                        $orderVsStatus[$row["status"]] = $row["status_count"];
                    }
                }

                $numbers = "SELECT COUNT(*) AS total_orders, COUNT(IF (orders.status!='delivered',1,null)) AS pending_orders, SUM(products.price) AS total_sales FROM orders INNER JOIN products ON orders.product_id=products.id WHERE products.seller_id='$sellerId'";
                $result=$conn->query($numbers);
                $resultArray=array();
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $resultArray[] = $row;
                    }
                }

                $recentQuery = "SELECT orders.order_id AS order_id,orders.status AS order_status, users.name AS user_name, users.email AS user_email, users.phone_no AS user_phone, users.address AS user_address, products.name AS product_name FROM orders INNER JOIN users ON orders.user_id=users.user_id INNER JOIN products ON orders.product_id=products.id WHERE products.seller_id='$sellerId' ORDER BY orders.date DESC LIMIT 5";
                $ordersRes = $conn->query($recentQuery);
                $recentOrders=array();
                if($ordersRes->num_rows > 0){
                    while($row = $ordersRes->fetch_assoc()){
                        $recentOrders[] = $row;
                    }
                }
                
                $response = array("status" => "success", "message" => "Data found","total_products"=>$totalProducts,"count" => $resultArray,"categoryVsSales"=>$categoryVsSales, "orderVsStatus"=>$orderVsStatus, "recentOrders" => $recentOrders);
                echo json_encode($response);

            }catch(mysqli_sql_exception $e){
                $response = array("status" => "error", "message" => $e->getMessage());
                echo json_encode($response);
            }
        }else{
            $response = array("status" => "failure", "message" => "Invalid token");
            echo json_encode($response);
        }
    }

    function changeOrderStatus($orderId){
        global $conn;
        global $secret;
    
        $token = $_SERVER['HTTP_TOKEN'];
        $res = Token::Verify($token,$secret);
        if($res==true){
            if(!empty($_POST)){
                $newStatus = $_POST['status'];
                try{
                    $update="UPDATE orders SET status='$newStatus' WHERE order_id='$orderId'";
                    $result=$conn->query($update);
                    if($result === true){
                        $response = array("status" => "success", "message" => "Status updated");
                        echo json_encode($response);
                    }else{
                        $response = array("status" => "failure", "message" => "Status updation failed");
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
        }else{
            $response = array("status" => "failure", "message" => "Invalid token");
            echo json_encode($response);
        }
    }
?>