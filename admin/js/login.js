let signUpBtn = document.getElementById("signUpBtn");
let loginBtn = document.getElementById("loginBtn");

let emailError = document.getElementById("emailError")
let passwordError = document.getElementById("passwordError")

signUpBtn.addEventListener("click", (event)=>{
    event.preventDefault();
    window.location.replace("http://localhost/ecommerce/admin/register.php");
});

loginBtn.addEventListener("click", (event)=>{
    event.preventDefault();
    let loginData={};
    let loginForm = document.forms["login"];
    loginData["email"] = loginForm["username"].value;
    loginData["password"] = loginForm["password"].value;

    if(!validate(loginData)){
        //proceed
        console.log(loginData);
        // make a request 
        let url="request.php/login";
        fetch(url,{
            "method" : "POST",
            "headers":{
                "content":"application/json"
            },
            "body": JSON.stringify(loginData)
        }).then((response)=>{
            if(response.ok){
                return response.json();
            }else{
                throw new Error("Error in recieving resposne")
            }
        }).then((data)=>{
            console.log(data);
            if(data["status"] == "success"){
                snackBarSuccess("Login Successfull",()=>{
                    localStorage.setItem("token", data["token"]);
                    window.location.replace("http://localhost/ecommerce/admin/dashboard.php");
                })
            }else{
                // show error login failed
                snackBarError("Login failed")
            }
        }).catch((error)=>{
            console.log("error :" , error)
        })
    }else{
        // show error
        console.log("Error");
        // enter form details 
        snackBarError("Please fill details")
    }

});

function validate(data){
    let errorFlag = false;

    if (!validateEmail(data.email)) {
        emailError.style.display = "block";
        errorFlag = true;
    } else {
        emailError.style.display = "none";
    }

    if(data.password == ""){
        passwordError.style.display = "block";
        errorFlag = true;
    }else{
        passwordError.style.display = "none";
    }

    return errorFlag;
    
}

function validateEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let result = emailRegex.test(email);
    return result;
}

function snackBarSuccess(message, callback) {
    var x = document.getElementById("snackBarSuccess");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden";callback ();}, 3000);
}

function snackBarError(message) {
    var x = document.getElementById("snackBarError");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 3000);
}
window.addEventListener("load", ()=>{
    let token = localStorage.getItem("token");
    if(token != null){
        window.location.replace("http://localhost/ecommerce/admin/dashboard.php");
    }
})


