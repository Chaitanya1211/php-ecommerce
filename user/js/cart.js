let token;
let cartItems = [];
let cartColumn = document.getElementById("cartColumn");
let totalCost = 0;
let gst = 0;
let total = document.getElementById("total");
let gstSection = document.getElementById("gst");
let finalPrice = document.getElementById("finalPrice");
let checkoutButton = document.getElementById("checkoutButton");
let cartSection = document.getElementById("cartSection");
let emptyCart = document.getElementById("emptyCart");

let loading = document.getElementById("loading");
let content_wrapper = document.getElementById("content-wrapper");

function init() {
    loading.style.display = "block";
    let url = "request.php/cart";
    fetch(url, {
        "method": "GET",
        "headers": {
            "token": token
        }
    }).then((resposne) => {
        if (resposne.ok) {
            return resposne.json();
        } else {
            throw new Error("Error in receiving response")
        }
    }).then((data) => {
        console.log(data);
        cartItems = data["cart"];
        loading.style.display = "none";
        content_wrapper.style.display = "block";
        if (cartItems.length == 0) {
            // show no cart and hide cart section
            emptyCart.style.display = "block";
            cartSection.style.display = "none";
        } else {
            // hide no cart and show cart section
            emptyCart.style.display = "none";
            cartSection.style.display = "block";
            cartColumn.innerText = "";
            totalCost = 0;
            cartItems.forEach((product, index) => {
                totalCost += product.quantity * product.price;
                let card = cartCard(product, index);
                cartColumn.append(card);
            });
            total.innerText = totalCost;
            finalPrice.innerText = totalCost;
            console.log(totalCost)
        }
    }).catch((error) => {
        console.log(("Error  :", error));
        loading.style.display = "none";
        content_wrapper.style.display = "block";
    })
    getOrderCount();
}

function cartCard(product, index) {
    let sampleCart = document.getElementById("sampleCart");
    let newCart = sampleCart.cloneNode(true);
    newCart.style.display = "flex";

    let product_img = newCart.querySelector(".product-image");
    product_img.setAttribute("src", product.image);

    let name = newCart.querySelector(".product-name");
    name.innerText = product.name;

    let desc = newCart.querySelector(".product-desc");
    desc.innerText = product.description;

    let addQuant = newCart.querySelector(".add-quant-btn");
    addQuant.setAttribute("onclick", `addQuantity('${product.cart_id}')`)

    let quantity = newCart.querySelector(".product-quantity");
    quantity.setAttribute("value", product.quantity);
    quantity.setAttribute("id", `cart${product.cart_id}quantity`);
    quantity.setAttribute("data-cartId", `${product.cart_id}`);

    let removeQuant = newCart.querySelector(".sub-quant-btn");
    removeQuant.setAttribute("onclick", `removeQuantity('${product.cart_id}')`)

    let deleteBtn = newCart.querySelector(".delete-btn");
    deleteBtn.setAttribute("onclick", `deleteItem('${product.cart_id}')`);

    let unitPrice = newCart.querySelector(".unit-price");
    unitPrice.setAttribute("value", product.price);
    unitPrice.setAttribute("id", `cart${product.cart_id}unitPrice`)

    let cost = newCart.querySelector(".product-cost");
    cost.setAttribute("value", product.price * product.quantity);
    cost.setAttribute("id", `cart${product.cart_id}cost`);

    return newCart;
}

function addQuantity(productId) {
    let currentQuantity = document.getElementById(`cart${productId}quantity`);
    let newQuant = parseFloat(currentQuantity.value) + 1;
    currentQuantity.setAttribute("value", newQuant);
    let unitPrice = document.getElementById(`cart${productId}unitPrice`).value;
    let cost = newQuant * parseFloat(unitPrice);
    let currentTotal = document.getElementById(`cart${productId}cost`);
    currentTotal.setAttribute("value", cost);
    updateCartTotal();
}

function removeQuantity(productId) {
    let currentQuantity = document.getElementById(`cart${productId}quantity`);
    if (currentQuantity.value == 1) {
        console.log("Quantity can't be 0")
    } else {
        let newQuant = parseFloat(currentQuantity.value) - 1;
        currentQuantity.setAttribute("value", newQuant);
        let unitPrice = document.getElementById(`cart${productId}unitPrice`).value;
        let cost = newQuant * parseFloat(unitPrice);
        let currentTotal = document.getElementById(`cart${productId}cost`);
        currentTotal.setAttribute("value", cost)
    }
    updateCartTotal();
}
function updateCartTotal() {
    let totalCost = 0;
    let allTotal = document.querySelectorAll(".product-cost");
    allTotal.forEach((itemTotal) => {
        if (itemTotal.value != '') {
            totalCost += parseFloat(itemTotal.value);
        }
    });
    let finalPrice=document.getElementById("finalPrice");
    finalPrice.innerText = totalCost;
    let total=document.getElementById("total");
    total.innerText = totalCost;
    console.log("Cart total :", totalCost)
}
function deleteItem(itemId) {
    let url = `request.php/deleteItem/${itemId}`;
    fetch(url, {
        "method": "DELETE",
        "headers": {
            "token": token
        }
    }).then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("Error in receiving response")
        }
    }).then((data) => {
        console.log(data);
        if (data["status"] == "success") {
            console.log("Item deleted")
        } else {
            console.log("Item not deleted")
        }
        init();

    }).catch((error) => {
        console.log("Error:", error)
    })
}
function getOrderCount() {
    let orderCount = document.getElementById("orderCount");
    console.log("Order count called")
    let url = "request.php/orderCount";
    fetch(url, {
        "method": "GET",
        "headers": {
            "token": localStorage.getItem("token")
        }
    }).then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("error in response")
        }
    }).then((data) => {
        console.log(data);
        orderCount.innerText = data["cart"]
    }).catch((error) => {
        console.log("Error :", error)
    })
}

checkoutButton.addEventListener("click", () => {
    // get all the product id and quantity;
    let tempCart = {};
    let data= [];
    let allQuant = document.querySelectorAll(".product-quantity");
    // make an array of objects with product id and quantity
    allQuant.forEach((element)=>{
        tempCart={};
        tempCart["cart_id"] = element.getAttribute("data-cartId");
        tempCart["quantity"] = element.value;
        data.push(tempCart);
    });
    console.log(data)
    // update them in cart 
    let url = "request.php/updateCart";
    fetch(url,{
        "method" : "POST",
        "headers":{
            "token":token
        },
        "body" : JSON.stringify(data)
    }).then((response)=>{
        if(response.ok){
            return response.json();
        }else{
            throw new Error("Error in receiving response")
        }
    }).then((result)=>{
       if(result["status"] == "success"){
            window.location.assign("http://localhost/ecommerce/user/checkout.php")
       }else{
            console.log("Unable to update cart")
       }
    }).catch((error)=>{
        console.log("Error :", error)
    })
});

function snackBarSuccess(message, callback) {
    var x = document.getElementById("snackBarSuccess");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; callback(); }, 2000);
}

function snackBarError(message) {
    var x = document.getElementById("snackBarError");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 2000);
}

let popup = document.getElementById("popup")

function openPopup() {
    popup.classList.add("openPopup")
}

function closePopup() {
    popup.classList.remove("openPopup");
    init();
}
window.addEventListener("load", (event) => {
    console.log("INit")
    token = localStorage.getItem("token");
    if(token != null){
        init();
    }else{
        window.location.replace("http://localhost/ecommerce/user/login.php");
    }
});