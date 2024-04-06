let token;
let allOrders = document.getElementById("allOrders");
let acceptedOrders = document.getElementById("acceptedOrders");
let shippedOrders = document.getElementById("shippedOrders");
let outForDelivery = document.getElementById("outForDelivery");
let deliveredOrders = document.getElementById("deliveredOrders");
let noAllOrders = document.getElementById("noAllOrders");
let noAcceptedOrders = document.getElementById("noAcceptedOrders");
let noShippedOrders = document.getElementById("noShippedOrders");
let noDeliveryOrders = document.getElementById("noDeliveryOrders");
let noDeliveredOrders = document.getElementById("noDeliveredOrders");

function init() {
    let url = 'request.php/orders';
    fetch(url, {
        "method": "GET",
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
            allOrders.innerText = "";
            acceptedOrders.innerText = "";
            shippedOrders.innerText = "";
            outForDelivery.innerText = "";
            deliveredOrders.innerText = "";

            // All Orders
            if (data["all"].length > 0) {
                allOrders.style.display = "block";
                noAllOrders.style.display = "none";
                data["all"].forEach((order) => {
                    let newRow = createOrderCard(order);
                    allOrders.appendChild(newRow);
                });
            } else {
                allOrders.style.display = "none";
                noAllOrders.style.display = "flex";
            }
            // Accepted orders
            if (data["accepted"].length > 0) {
                acceptedOrders.style.display = "block";
                noAcceptedOrders.style.display = "none";
                data["accepted"].forEach((order) => {
                    let newRow = createOrderCard(order);
                    acceptedOrders.appendChild(newRow);
                });
            } else {
                acceptedOrders.style.display = "none";
                noAcceptedOrders.style.display = "flex";
            }
            // Shipped
            if (data["shipped"].length > 0) {
                shippedOrders.style.display = "block";
                noShippedOrders.style.display = "none";
                data["shipped"].forEach((order) => {
                    let newRow = createOrderCard(order);
                    shippedOrders.appendChild(newRow);
                });
            } else {
                shippedOrders.style.display = "none";
                noShippedOrders.style.display = "flex";
            }

            // Out for delivery
            if (data["delivery"].length > 0) {
                outForDelivery.style.display = "block";
                noDeliveryOrders.style.display = "none";
                data["delivery"].forEach((order) => {
                    let newRow = createOrderCard(order);
                    outForDelivery.appendChild(newRow);
                });
            } else {
                outForDelivery.style.display = "none";
                noDeliveryOrders.style.display = "flex";
            }

            // Delivered
            if (data["delivered"].length > 0) {
                deliveredOrders.style.display = "block";
                noDeliveredOrders.style.display = "none";
                data["delivered"].forEach((order) => {
                    let newRow = createOrderCard(order);
                    deliveredOrders.appendChild(newRow);
                });
            } else {
                deliveredOrders.style.display = "none";
                noDeliveredOrders.style.display = "flex";
            }
        } else {
            // no data got
        }

    }).catch((error) => {
        console.log("Error :", error)
    })
}

function createOrderCard(order) {
    let sampleOrder = document.getElementById("sampleCard");
    let newOrder = sampleOrder.cloneNode(true);
    newOrder.style.display = "block";
    let image = newOrder.querySelector(".product-image");
    image.setAttribute("src", order.product_img);
    // Product details
    let name = newOrder.querySelector(".product-name");
    name.innerText = order.product_name;
    let quantity = newOrder.querySelector(".product-quantity");
    quantity.innerText = order.quantity;
    let price = newOrder.querySelector(".product-price");
    price.innerText = order.product_price;

    // badge
    let badge = newOrder.querySelector(`.${order.status}`);
    badge.style.display="inline-block"
    if (order.status == "placed") {
        badge.classList.add("badge-primary");
        badge.innerText = "Placed"
    } else if (order.status == "accepted") {
        badge.classList.add("badge-info");
        badge.innerText = "Accepted"
    } else if (order.status == "shipped") {
        badge.classList.add("badge-secondary");
        badge.innerText = "Shipped"
    } else if (order.status == "delivery") {
        badge.classList.add("badge-warning");
        badge.innerText = "Out for delivery"
    } else {
        badge.classList.add("badge-success");
        badge.innerText = "Delivered";
    }

    // last updated
    let updated = newOrder.querySelector(".last-updated");
    readableDate = convertDateFormat(order.latestUpdate);
    updated.innerHTML = readableDate;

    // User details
    let userName = newOrder.querySelector(".user-name");
    userName.innerText = order.user_name;
    let useraddress = newOrder.querySelector(".user-address");
    if(order.user_address2){
        useraddress.innerText = order.user_address2;
    }else{
        useraddress.innerText = order.user_add;
    }
    let userphone = newOrder.querySelector(".user-phone");
    userphone.innerText = order.user_phone;

    let sellername = newOrder.querySelector(".seller-name");
    sellername.innerText = order.seller_name;
    let selleraddress = newOrder.querySelector(".seller-address");
    selleraddress.innerText = order.seller_add;
    let sellergst = newOrder.querySelector(".seller-gst");
    sellergst.innerText = order.seller_gst;
    let sellerphemal = newOrder.querySelector(".seller-ph-email");
    sellerphemal.innerText = order.seller_phone + " " + order.seller_email;

    return newOrder;
}

function convertDateFormat(dateString) {
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const [datePart, timePart] = dateString.split(" ");
    const [year, month, day] = datePart.split("-");
    
    let [hours, minutes] = timePart.split(":").slice(0, 2);
    const ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12;
    const monthAbbreviation = monthNames[parseInt(month) - 1];
    const formattedDate = `${day} ${monthAbbreviation} ${year} <br> ${hours}:${minutes} ${ampm}`;
    return formattedDate;
}

window.addEventListener("load", () => {
    console.log("INit")
    token = localStorage.getItem("token");
    if (token != null) {
        init();
    } else {
        window.location.replace("http://localhost/ecommerce/user/login.php");
    }
})