let token;
let details=[];

let name  = document.getElementById("name");
let email  = document.getElementById("email");
let phone  = document.getElementById("phone");
let address  = document.getElementById("address");
let businessPh  = document.getElementById("businessPh");
let gst  = document.getElementById("gst");

function renderDetails(callback){
    if(token != null){
        console.log(token);
        let url= "request.php/profile";
        fetch(url,{
            "method" : "GET",
            "headers":{
                "content" : "application",
                "token" : token
            }
        }).then((resposne)=>{
            if(resposne.ok){
                return resposne.json();
            }else{
                throw new Error("Error in receiving resposne");
            }
        }).then((data)=>{
            console.log(data);
            details = data["details"];
            callback();
        }).catch((error)=>{
            console.log("Error")
        })
    }else{
        console.log("Token not found")
    }
}

function init(){
    let user= document.getElementById("user");
    user.innerText = details["name"];

    name.innerText = details["name"];
    email.innerText = details["email"];
    phone.innerText=details["phone"];
    address.innerText= details["address"];
    businessPh.innerText=details["business_ph"];
    gst.innerText = details["gst"];
}
window.addEventListener("load", (event) => {
    console.log("page is fully loaded");
    token = localStorage.getItem("token");
    if(token != null){
        renderDetails(()=>{
            init();
        });
    }else{
        window.location.replace("http://localhost/ecommerce/admin/login.php");
    }
});