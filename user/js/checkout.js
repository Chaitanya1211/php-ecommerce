let token;
function init() {
    let url = "request.php/checkout";
    fetch(url, {
        "method": "GET",
        "headers": {
            "token": token
        }
    }).then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("error in response")
        }
    }).then((data) => {
        console.log(data);
        setUserDetails(data["userdata"][0]);
        setItems(data["productdata"]);
    }).catch((error) => {
        console.log("Error :", error)
    })
}

function setItems(cartItems) {
    let productsBody = document.getElementById("productsBody");
    productsBody.innerText="";
    let total=0;
    cartItems.forEach((item) => {
        let temp = createRow(item);
        productsBody.appendChild(temp);
        total += item.price * item.quantity;
    });
    console.log("total:", total);
    let totalSection = document.getElementById("total");
    totalSection.innerText = total;
    let finalPrice = document.getElementById("finalPrice");
    finalPrice.innerText = total;
}

function createRow(item) {
    let row = document.createElement("tr");

    let image = document.createElement("td");
    let div = document.createElement("div");
    div.setAttribute("class", "image-wrapper");
    let img = document.createElement("img");
    img.setAttribute("src", item.image);
    img.setAttribute("class", "img-fluid");
    div.appendChild(img);
    image.appendChild(div)

    let details = document.createElement("td");
    let name = document.createElement("p");
    name.classList.add("font-weight-bold", "mb-2");
    name.innerText = item.name;
    details.appendChild(name);
    let p = document.createElement("p");
    p.classList.add("details-css")
    // append ruppee symbol
    let icon= document.createElement("i");
    icon.classList.add("fa-solid","fa-indian-rupee-sign", "mx-1");
    let unit = document.createElement("span");
    unit.innerText = item.price;
    let symbol = document.createElement("span");
    symbol.innerText = " X ";
    let quant = document.createElement("span");
    quant.innerText = item.quantity;
    p.appendChild(icon)
    p.appendChild(unit);
    p.appendChild(symbol);
    p.appendChild(quant);
    details.appendChild(p);

    let total = document.createElement("td");
    let icon2= document.createElement("i");
    icon2.classList.add("fa-solid","fa-indian-rupee-sign", "mx-1");
    total.appendChild(icon2);
    let priceSpan = document.createElement("span");
    priceSpan.innerText = item.quantity * item.price;
    total.appendChild(priceSpan);
    total.classList.add("font-weight-bold");
    row.appendChild(image);
    row.appendChild(details);
    row.appendChild(total);

    return row;
}

function setUserDetails(user) {
    let userName = document.getElementById("userName");
    userName.innerText = user.user_name;
    let userPhone = document.getElementById("userPhone");
    userPhone.innerText = user.user_phone;
    let userEmail = document.getElementById("userEmail");
    userEmail.innerText = user.user_email;
    let userAddress = document.getElementById("userAddress");
    userAddress.innerText = user.user_address;
    let address2= document.getElementById("address2");
    if(address2 != null){
        address2.value = user.user_address2;
    }else{
        address2.value="";
    }
}

let popup = document.getElementById("popup")

let overlay = document.getElementById("overlay");
function openPopup() {
    overlay.style.display = "block";
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
    popup.classList.add("openPopup")
}

function closePopup() {
    overlay.style.display = "none";
    popup.classList.remove("openPopup");
    //redirect to home page 
    window.location.replace("http://localhost/ecommerce/user/homepage.php");
}
function placeOrder() {
    console.log("Hello");
    let url="request.php/placeOrder";
    fetch(url,{
        "method" : "POST",
        "headers":{
            "token" : token
        }
    }).then((response)=>{
        if(response.ok){
            return response.json();
        }else{
            throw new Error("Error in Response")
        }
    }).then((data)=>{
        console.log(data)
        if(data["status"] == "success"){
            openPopup();
        }else{
            console.log("Error in placing order")
        }
    }).catch((error)=>{
        console.log("Error :",error);
    })
}

function updateAddress(event) {
    event.preventDefault();
    let addressForm = document.forms["addressForm"];
    let newAddress = addressForm["address2"].value;
    let address2Err = document.getElementById("address2Error");
    if(newAddress == ""){
        address2Err.style.display = "block";
    }else{
        address2Err.style.display = "none";    
        let formData = new FormData();
        formData.append("address", newAddress);
        let url = "request.php/updateAddress";
        fetch(url,{
            "method" : "POST",
            "headers":{
                "token":token
            },
            "body" : formData
        }).then((response)=>{
            if(response.ok){
                return response.json()
            }else{
                throw new Error("Error in receiving response")
            }
        }).then((data)=>{
            console.log(data);
            if(data["status"] == "success"){
                addressSuccess();  
            }
        }).catch((error)=>{
            console.log("Error :",error)
        })
    }
}

function addressSuccess(){
    let addressSuccess=document.getElementById("addressSuccess");
    addressSuccess.style.display = "block";
    setTimeout(() => { addressSuccess.style.display = "none";}, 2000);
}

window.addEventListener("load", () => {
    token = localStorage.getItem("token");
    if(token != null){
        init();
    }else{
        window.location.replace("http://localhost/ecommerce/user/login.php");
    }
})