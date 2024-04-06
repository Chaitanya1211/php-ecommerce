let token;
let totalProducts = document.getElementById("productCount");
let totalOrders = document.getElementById("orderCount");;
let salesCount = document.getElementById("salesCount");;
let pendingOrdersCount = document.getElementById("pendingOrdersCount");;
let ordersTable = document.getElementById("ordersTable");

function render() {
  let url = "request.php/dashboard";
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
    totalProducts.innerText = data["total_products"];
    totalOrders.innerText = data["count"][0]["total_orders"];
    salesCount.innerText = data["count"][0]["total_sales"];
    pendingOrdersCount.innerText = data["count"][0]["pending_orders"];
    categoryVsSales(data["categoryVsSales"]);
    orderVsStatus(data["orderVsStatus"]);
    recentOrders(data["recentOrders"])
  }).catch((error) => {
    console.log("Error :", error)
  });
}

function categoryVsSales(data) {
  console.log(data);
  const allCategories = ["fashion", "food", "household", "consmetics", "electronics", "furniture"];
  const xValues = [];
  const yValues = [];
  allCategories.forEach((category) => {
    xValues.push(category);
    yValues.push(data[category] || 0);
  });
  const barColors = ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "brown", "indigo"];
  new Chart("barChart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Categories'
          }
        }],
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Sales'
          },
          ticks: {
            beginAtZero: true,
            stepSize: 1,
            maxTicksLimit: 10
          }
        }]
      },
      legend: { display: false },
      title: {
        display: true,
        text: "Category v/s Sales"
      }
    }
  });
}

function orderVsStatus(data) {
  const xValues = [];
  const yValues = [];
  for (key in data) {
    xValues.push(key);
    yValues.push(data[key]);
  }
  const barColor = [
    "#28a745",
    "#007bff",
    "#dc3545",
    "#6c757d",
  ];

  new Chart("pieChart", {
    type: "pie",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColor,
        data: yValues
      }]
    },
    options: {
      title: {
        display: true,
        text: "Order Status"
      }
    }
  });
}

function recentOrders(data) {
  ordersTable.innerText = "";
  let sr_no = 1;
  data.forEach((order) => {
    let newRow = createRow(order, sr_no)
    sr_no++;
    ordersTable.appendChild(newRow)
  });
}
function createRow(order, sr_no) {

  let row = document.createElement("tr");
  row.setAttribute("id", order.order_id);
  let sr = document.createElement("th");
  sr.setAttribute("scope", "row")
  sr.innerText = sr_no;
  let id = document.createElement("td");
  id.innerText = "#" + order.order_id;
  let product_name = document.createElement("td");
  product_name.innerText = order.product_name;
  let buyer_details = document.createElement("td");
  buyer_details.innerText = order.user_name + " " + order.user_phone + " " + order.user_email;;
  let buyer_address = document.createElement("td");
  buyer_address.innerText = order.user_address;
  let orderStatus = document.createElement("td");
  // orderStatus.innerText = order.order_status;
  let badge = document.createElement("span");
  badge.setAttribute("class", "badge");
  if (order.order_status == "placed") {
    badge.classList.add("badge-primary");
    badge.innerText = "Placed"
  } else if (order.order_status == "accepted") {
    badge.classList.add("badge-info");
    badge.innerText = "Accepted"
  } else if (order.order_status == "shipped") {
    badge.classList.add("badge-secondary");
    badge.innerText = "Shipped"
  } else if (order.order_status == "delivery") {
    badge.classList.add("badge-warning");
    badge.innerText = "Out for delivery"
  } else {
    badge.classList.add("badge-success");
    badge.innerText = "Delivered";
  }
  orderStatus.appendChild(badge);

  row.appendChild(sr);
  row.appendChild(id);
  row.appendChild(product_name);
  row.appendChild(buyer_details);
  row.appendChild(buyer_address);
  row.appendChild(orderStatus);

  return row;
}
window.addEventListener("load", () => {
  console.log("Init")
  token = localStorage.getItem("token");
  console.log(token);
  if (token != null) {
    render();
  } else {
    window.location.replace("http://localhost/ecommerce/admin/login.php");
  }
})