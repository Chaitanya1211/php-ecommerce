let logoutBtn = document.getElementById("logoutBtn");
let orderCount1 = document.getElementById("orderCount");
let headerName = document.getElementById("headerName");
logoutBtn.addEventListener("click",()=>{
    console.log("logout")
    localStorage.clear();
    window.location.replace("http://localhost/ecommerce/user/login.php")
});

function getOrderCount(){
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
            throw new Error("error in response")
        }
    }).then((data)=>{
        orderCount1.innerText= data["cart"];
        let fullname = data["name"];
        let firstName = fullname.split(" ")[0];
        headerName.innerText = firstName;
    }).catch((error)=>{
        console.log("Error :",error)
    })
}
getOrderCount();