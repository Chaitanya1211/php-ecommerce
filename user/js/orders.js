let token;
let loading = document.getElementById("loading");
let content_wrapper = document.getElementById("content-wrapper");
let noOrders = document.getElementById("noOrders");
let ordersSection = document.getElementById("orders");

let placed = document.getElementById("placed");
let placedColumn = document.getElementById("placedColumn");

let shipped = document.getElementById("shipped");
let shippedColumn = document.getElementById("shippedColumn");

let outForDelivery = document.getElementById("delivery");
let deliveryColumn = document.getElementById("deliveryColumn");

let delivered = document.getElementById("delivered");
let deliveredColumn = document.getElementById("deliveredColumn");

function init() {
    loading.style.display = "block";
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
        console.log(data)
        loading.style.display = "none";
        content_wrapper.style.display = "block";
        if (data["status"] == "success") {
            noOrders.style.display = "none";
            ordersSection.style.display = "block";

            if (data["placed"].length > 0) {
                placed.style.display = "block";
                placedColumn.innerText = "";
                let sr = 1;
                data["placed"].forEach((order) => {
                    let newRow = createOrderCard(order);
                    placedColumn.appendChild(newRow);
                    sr++;
                });
            } else {
                placed.style.display = "none";
            }
            if (data["shipped"].length > 0) {
                shipped.style.display = "block";
                shippedColumn.innerText = "";
                let sr = 1;
                data["shipped"].forEach((order) => {
                    let newRow = createOrderCard(order, sr);
                    shippedColumn.appendChild(newRow);
                });
            } else {
                shipped.style.display = "none";
            }

            if (data["delivery"].length > 0) {
                outForDelivery.style.display = "block";
                deliveryColumn.innerText = "";
                let sr = 1;
                data["delivery"].forEach((order) => {
                    let newRow = createOrderCard(order, sr);
                    deliveryColumn.appendChild(newRow);
                });
            } else {
                outForDelivery.style.display = "none";
            }

            if (data["delivered"].length > 0) {
                delivered.style.display = "block";
                deliveredColumn.innerText = "";
                let sr = 1;
                data["delivered"].forEach((order) => {
                    let newRow = createOrderCard(order, sr);
                    deliveredColumn.appendChild(newRow);
                });
            } else {
                // hide
                delivered.style.display = "none";
            }

        } else {
            // no orders found
            noOrders.style.display = "block";
            ordersSection.style.display = "none";
        }
    }).catch((error) => {
        console.log("Error :", error)
    })
}

function createOrderCard(order) {
    let sampleOrder = document.getElementById("sampleOrder");
    let newOrder = sampleOrder.cloneNode(true);
    newOrder.style.display = "block";

    let orderId = newOrder.querySelector(".order_id");
    orderId.innerText = order.order_id;
    let orderImg = newOrder.querySelector(".order_image");
    orderImg.setAttribute("src", order.product_img);

    let orderName = newOrder.querySelector(".order_name");
    orderName.innerText = order.product_name;
    let orderDesc = newOrder.querySelector(".order_desc");
    orderDesc.innerText = order.product_desc;
    let orderCost = newOrder.querySelector(".order_cost");
    orderCost.innerText = order.product_price;

    let sellerName = newOrder.querySelector(".seller_name")
    sellerName.innerText = order.seller_name;
    let sellerAddress = newOrder.querySelector(".seller_address")
    sellerAddress.innerText = order.seller_add;
    let sellerGst = newOrder.querySelector(".seller_gst");
    sellerGst.innerText = order.seller_gst;

    let userName = newOrder.querySelector(".user_name");
    userName.innerText = order.user_name;
    let userAdd = newOrder.querySelector(".user_add");
    if(order.user_address2 != ""){
        userAdd.innerText = order.user_address2;
    }else{
        userAdd.innerText = order.user_add;
    }
    let userPh = newOrder.querySelector(".user_ph");
    userPh.innerText = order.user_phone;

    let badge = newOrder.querySelector(`.${order.status}`);
    if (order.status == "placed") {
        badge.classList.add("badge-danger");
        badge.innerText = "Placed"
    } else if (order.status == "shipped") {
        badge.classList.add("badge-secondary");
        badge.innerText = "Shipped"
    } else if (order.status == "delivery") {
        badge.classList.add("badge-primary");
        badge.innerText = "Out for delivery"
    } else {
        badge.classList.add("badge-success");
        badge.innerText = "Delivered";
    }

    let updated = newOrder.querySelector(".updated");
    let date = new Date(order.latestUpdate);
    let readableDate = date.toLocaleString();
    updated.innerText = readableDate;
    return newOrder;

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