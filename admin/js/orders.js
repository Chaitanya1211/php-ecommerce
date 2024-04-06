
let token;
let orders = [];
let noOrdersSection = document.getElementById("noOrdersSection");
let ordersSection = document.getElementById("ordersSection");

let placed = document.getElementById("placed");
let placedTable = document.getElementById("placedTable");
let noPlacedOrders = document.getElementById("noPlacedOrders");

let accepted = document.getElementById("accepted");
let acceptedTable = document.getElementById("acceptedTable");
let noAccepted = document.getElementById("noAccepted");

let shipped = document.getElementById("shipped");
let shippedTable = document.getElementById("shippedTable");
let noShipped = document.getElementById("noShipped");

let outForDelivery = document.getElementById("outForDelivery");
let deliveryTable = document.getElementById("deliveryTable");
let noDelivery = document.getElementById("noDelivery");

let delivered = document.getElementById("delivered");
let deliveredTable = document.getElementById("deliveredTable");
let noDelivered = document.getElementById("noDelivered");

function init() {
    console.log("init called");
    let url = "request.php/orders";
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
        console.log("Data recieved");
        console.log(data);

        if (data["status"] == "success") {

            setSatistics(data);
            noOrdersSection.style.display = "none";
            ordersSection.style.display = "block";
            // allOrdersTable.innerText = "";
            placedTable.innerText = "";
            acceptedTable.innerText = "";
            shippedTable.innerText = "";
            deliveryTable.innerText = "";
            deliveredTable.innerText = "";

            // placed orders
            if (data["placed"].length != 0) {
                placed.style.display = "block";
                noPlacedOrders.style.display = "none";
                let sr = 1;
                data["placed"].forEach((order) => {
                    let newRow = createRow(order, sr);
                    placedTable.appendChild(newRow);
                    sr++;
                });
            } else {
                placed.style.display = "none";
                noPlacedOrders.style.display = "flex";
            }

            // Accepted orders
            if (data["accepted"].length != 0) {
                accepted.style.display = "block";
                noAccepted.style.display = "none";
                let sr = 1;
                data["accepted"].forEach((order) => {
                    let newRow = createRow(order, sr);
                    acceptedTable.appendChild(newRow);
                    sr++;
                });
            } else {
                accepted.style.display = "none";
                noAccepted.style.display = "flex";
            }

            // Shipped orders
            if (data["shipped"].length != 0) {
                shipped.style.display = "block";
                noShipped.style.display = "none";
                let sr = 1;
                data["shipped"].forEach((order) => {
                    let newRow = createRow(order, sr);
                    shippedTable.appendChild(newRow);
                    sr++;
                });
            } else {
                shipped.style.display = "none";
                noShipped.style.display = "flex";
            }

            // Delivery orders
            if (data["delivery"].length != 0) {
                outForDelivery.style.display = "block";
                noDelivery.style.display = "none";
                let sr = 1;
                data["delivery"].forEach((order) => {
                    let newRow = createRow(order, sr);
                    deliveryTable.appendChild(newRow);
                    sr++;
                });
            } else {
                outForDelivery.style.display = "none";
                noDelivery.style.display = "flex";
            }

            // Delivered orders
            if (data["delivered"].length != 0) {
                delivered.style.display = "block";
                noDelivered.style.display = "none";
                let sr = 1;
                data["delivered"].forEach((order) => {
                    let newRow = createRow(order, sr);
                    deliveredTable.appendChild(newRow);
                    sr++;
                });
            } else {
                // hide
                delivered.style.display = "none";
                noDelivered.style.display = "flex";
            }
        } else {
            // no orders found
            noOrdersSection.style.display = "block";
            ordersSection.style.display = "none";
        }
    }).catch((error) => {
        console.log(error)
    })
}

function updateStatus(id) {
    let selectId = `order${id}`;
    let selected = document.getElementById(selectId).value;
    let url = `request.php/changeStatus/${id}`;
    let formData = new FormData();
    formData.append("status", selected);
    fetch(url, {
        "method": "POST",
        "headers": {
            "token": token
        },
        "body": formData
    }).then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("Error in receiving response")
        }

    }).then((data) => {
        console.log(data);
        if (data["status"] == "success") {
            snackBarSuccess("Status Updated Successfully")
        } else {
            snackBarError("Status Updation Failed");
        }
        init();
    }).catch((error) => {
        console.log("Error :", error)
    })
}

function snackBarSuccess(message) {
    var x = document.getElementById("snackBarSuccess");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 3000);
}

function snackBarError(message) {
    var x = document.getElementById("snackBarError");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 3000);
}

function createRow(order, sr_no) {
    let row = document.createElement("tr");
    row.setAttribute("id", order.order_id);
    // Sr no
    let sr = document.createElement("th");
    sr.setAttribute("scope", "row")
    sr.innerText = sr_no;
    // Order id
    let id = document.createElement("td");
    id.innerText = "#" + order.order_id;
    // Product name
    let product_name = document.createElement("td");
    product_name.innerText = order.product_name;
    // buyer details
    let buyer_details = document.createElement("td");
    buyer_details.innerHTML = order.user_name + "<br>" + order.user_phone + "<br>" + order.user_email;
    // date and time of order
    let date_time = document.createElement("td");
    let date = getDateFormatted(order.order_date);
    let time = getTimeFormatted(order.order_time);
    date_time.innerText = date + " " + time;
    // quantity
    let quantity_cell = document.createElement("td");
    quantity_cell.innerText = order.order_quantity;
    // buyer address
    let buyer_address = document.createElement("td");
    if (order.user_address2) {
        buyer_address.innerText = order.user_address2;
    } else {
        buyer_address.innerText = order.user_address;
    }
    let orderStatus = document.createElement("td");
    let select = document.createElement("select");
    select.setAttribute("id", `order${order.order_id}`);
    // Create options
    let placedOption = createOption("placed", "Placed", order.order_status);
    let acceptOption = createOption("accepted", "Accept", order.order_status);
    let shippedOption = createOption("shipped", "Shipped", order.order_status);
    let deliveryOption = createOption("delivery", "Out for delivery", order.order_status);
    let deliveredOption = createOption("delivered", "Delivered", order.order_status);
    if(order.order_status == "placed"){
        select.appendChild(placedOption);
        select.appendChild(acceptOption);
        select.appendChild(shippedOption);
        select.appendChild(deliveryOption);
        select.appendChild(deliveredOption);
    }else if(order.order_status == "accepted"){
        select.appendChild(acceptOption);
        select.appendChild(shippedOption);
        select.appendChild(deliveryOption);
        select.appendChild(deliveredOption);
    }else if(order.order_status == "shipped"){
        select.appendChild(shippedOption);
        select.appendChild(deliveryOption);
        select.appendChild(deliveredOption);
    }else if(order.order_status == "delivery"){
        select.appendChild(deliveryOption);
        select.appendChild(deliveredOption);
    }else{
        select.appendChild(deliveredOption);
    }

    orderStatus.appendChild(select);

    let actionCell = document.createElement("td");
    let action = document.createElement("button");
    action.setAttribute("class", "btn btn-primary");
    action.setAttribute('onclick', `updateStatus('${order.order_id}')`);
    action.innerText = "Update";
    actionCell.appendChild(action);

    row.appendChild(id);
    row.appendChild(product_name);
    row.appendChild(buyer_details);
    row.appendChild(date_time);
    row.appendChild(quantity_cell)
    row.appendChild(buyer_address);
    row.appendChild(orderStatus);
    row.appendChild(actionCell);

    return row;
}

// Function to create option element
function createOption(value, text, selectedValue) {
    let option = document.createElement("option");
    option.value = value;
    option.text = text;
    if (selectedValue === value) {
        option.selected = true;
    }
    return option;
}

function setSatistics(data) {
    let orderCount = document.getElementById("orderCount");
    orderCount.innerText = data["allOrders"].length;
    let acceptedCount = document.getElementById("acceptedCount");
    acceptedCount.innerText = data["accepted"].length;
    let shippedCount = document.getElementById("shippedCount");
    shippedCount.innerText = data["shipped"].length;
    let deliveryCount = document.getElementById("deliveryCount");
    deliveryCount.innerText = data["delivery"].length;
    let deliveredCount = document.getElementById("deliveredCount");
    deliveredCount.innerText = data["delivered"].length;
}

function getDateFormatted(dateString) {
    var date = new Date(dateString);
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
    var monthName = monthNames[date.getMonth()];
    var formattedDate = date.getDate() + ' ' + monthName + ' ' + date.getFullYear();
    return formattedDate;
}

function getTimeFormatted(timeString) {
    var timeParts = timeString.split(':');
    var hours = parseInt(timeParts[0], 10);
    var minutes = parseInt(timeParts[1], 10);
    var period = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    var formattedTime = hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + period;
    return formattedTime;

}
window.addEventListener("load", () => {
    token = localStorage.getItem("token");
    if (token != null) {
        init();
    } else {
        window.location.replace("http://localhost/ecommerce/admin/login.php");
    }
})
