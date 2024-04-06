let token;
let products=[];
let productRow = document.getElementById("productRow");
function init(){
    let url="request.php/products";
    fetch(url,{
        "method": "GET",
        "headers":{
            "token" : token
        }
    }).then((response)=>{
        if(response.ok){
            return response.json();
        }else{
            throw new Error("Error in receiving resposne")
        }
    }).then((data)=>{
        // console.log(data);
        if(data["status"] == "success"){
            products= data["products"];
            console.log(products)
            products.forEach((product,index) => {
                let card = productCard(product,index);
                productRow.appendChild(card);
            });
        }else{
            console.log("Unable to get products");
        }
    }).catch((error)=>{
        console.log("Wrror : ",error);
    })
}

function addCart(productId){
    let url=`request.php/addToCart/${productId}`;
    fetch(url,{
        "method" : "POST",
        "headers":{
            "token": token
        }
    }).then((response) =>{
        if(response.ok){
            return response.json();
        }else{
            throw new Error("Error in receiving resposne");
        }
    }).then((data)=>{
        console.log("Here")
        if(data["status"] == "success"){
            console.log("Success")
            snackBarSuccess("Item Added to Cart");
        }else{
            snackBarError("Item not Added");
        }
        getOrderCount();
    }).catch((error)=>{
        console.log("Error :" ,error)
    })
}

function productCard(product,index){
    let sampleCard = document.getElementById("sampleCard");
    let newCard = sampleCard.cloneNode(true);
    newCard.style.display = "block";
    let name = newCard.querySelector(".product-name");
    name.innerText = product.name;

    let cost= newCard.querySelector(".product-cost");
    cost.innerText = product.price;

    let proImg = newCard.querySelector(".product-image");
    proImg.setAttribute("src", product.image);

    let desc = newCard.querySelector(".product-desc");
    desc.innerText = product.description;

    let button = newCard.querySelector(".add-to-cart");
    button.setAttribute("onclick", `addCart('${product.id}')`);

    return newCard;
}
function snackBarSuccess(message) {
    var x = document.getElementById("snackBarSuccess");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden";}, 2000);
}

function snackBarError(message) {
    var x = document.getElementById("snackBarError");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 2000);
}

function getOrderCount(){
    let orderCount = document.getElementById("orderCount");
    console.log("Order count called")
    let url="request.php/orderCount";
    fetch(url,{
        "method": "GET",
        "headers":{
            "token" : localStorage.getItem("token")
        }
    }).then((response)=>{
        if(response.ok){
            return response.json();
        }else{
            throw new Error("errorn in response")
        }
    }).then((data)=>{
        console.log(data);
        orderCount.innerText= data["cart"]
    }).catch((error)=>{
        console.log("Error :",error)
    })
}
window.addEventListener("load", (event) => {
    token = localStorage.getItem("token");
    if(token != null){
        init();
    }else{
        window.location.replace("http://localhost/ecommerce/user/login.php");
    }
});