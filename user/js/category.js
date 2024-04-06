let token;
let category;
let details=[];
let coverImage = document.getElementById("categoryHeader");
let title = document.getElementById("category-head");
let content = document.getElementById("category-content");
let loading = document.getElementById("loading");
let content_wrapper = document.getElementById("content-wrapper");
let products=[];
let productRow = document.getElementById("productRow");
function renderDetails(){
    // fetch category details 
    loading.style.display = "block";
    let url = `request.php/category/${category}`;
    fetch(url,{
        "method" : "GET",
        "headers":{
            "token": token
        }
    }).then((resposne)=>{
        if(resposne.ok){
            return resposne.json()
        }else{
            throw new Error("Error in receiving resposne")
        }
    }).then((data)=>{
        console.log(data);
        details=data["details"];
        products = data["products"];
        // set the header data
        coverImage.style.backgroundImage = `url(${details.image})`;
        title.innerHTML = details.title;
        content.innerHTML = details.content;
        products.forEach((product,index) => {
            let card = productCard(product,index);
            productRow.appendChild(card);
        });

        loading.style.display = "none";
        content_wrapper.style.display = "block";
    }).catch((error)=>{
        console.log("error :" ,error)
        loading.style.display = "none";
        content_wrapper.style.display = "block";
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
    button.setAttribute("onclick", `addToCart('${product.id}')`);

    return newCard;
}
function addToCart(productId){
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
window.addEventListener("load", (event) => {
    token = localStorage.getItem("token");
    if(token != null){
        const urlParams = new URLSearchParams(window.location.search);
        category = urlParams.get('category');
        console.log(category);
        renderDetails();
    }else{
        window.location.replace("http://localhost/ecommerce/user/login.php");
    }
});