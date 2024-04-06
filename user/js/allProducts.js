let fashionRow = document.getElementById("fashionRow");
let foodRow = document.getElementById("foodRow");
let householdRow = document.getElementById("householdRow");
let cosmeticsRow = document.getElementById("cosmeticsRow");
let electronicsRow = document.getElementById("electronicsRow");
let furnitureRow = document.getElementById("furnitureRow");

function init(){
    let url="request.php/allProducts";
    fetch(url,{
        "method" : "GET",
        "headers":{
            "token" :token
        }
    }).then((response) =>{
        if(response.ok){
            return response.json()
        }else{
            throw new Error("Error in response")
        }
    }).then((data)=>{
        console.log(data);
        if(data["status"] == "success"){
            if(data["fashion"].length != 0){
                data["fashion"].forEach((product) => {
                    let newCard = productCard(product);
                    fashionRow.appendChild(newCard);
                });
            }

            if(data["food"].length != 0){
                data["food"].forEach((product) => {
                    let newCard = productCard(product);
                    foodRow.appendChild(newCard);
                });
            }
            if(data["household"].length != 0){
                data["household"].forEach((product) => {
                    let newCard = productCard(product);
                    householdRow.appendChild(newCard);
                });
            }
            if(data["cosmetics"].length != 0){
                data["cosmetics"].forEach((product) => {
                    let newCard = productCard(product);
                    cosmeticsRow.appendChild(newCard);
                });
            }
            if(data["electronics"].length != 0){
                data["electronics"].forEach((product) => {
                    let newCard = productCard(product);
                    electronicsRow.appendChild(newCard);
                });
            }
            if(data["furniture"].length != 0){
                data["furniture"].forEach((product) => {
                    let newCard = productCard(product);
                    furnitureRow.appendChild(newCard);
                });
            }
           
        }else{
            // unable to fetch data
        }
    }).catch((error)=>{
        console.log("Error :", error)
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


window.addEventListener("load", () => {
    console.log("INit")
    token = localStorage.getItem("token");
    if(token != null){
        init();
    }else{
        window.location.replace("http://localhost/ecommerce/user/login.php");
    }
})