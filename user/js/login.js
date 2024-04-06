let signUpBtn = document.getElementById("signUpBtn");
let loginBtn = document.getElementById("loginBtn");

let emailError = document.getElementById("emailError")
let passwordError = document.getElementById("passwordError")

signUpBtn.addEventListener("click", (event)=>{
    event.preventDefault();
    window.location.replace("http://localhost/ecommerce/user/register.php");
});

loginBtn.addEventListener("click", (event)=>{
    event.preventDefault();
    let loginForm = document.forms["login"];
    let formData = new FormData();
    formData.append("email",loginForm["username"].value);
    formData.append("password",loginForm["password"].value);
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }
    if(!validate(formData)){
        let url="request.php/login";
        fetch(url,{
            "method" : "POST",
            "body": formData
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
                    window.location.replace("http://localhost/ecommerce/user/homepage.php");
                })
            }else{
                snackBarError("Login Failed");
            }
        }).catch((error)=>{
            snackBarError("Login Failed");
        })
    }else{
        snackBarError("Please fill details")
    }

});

function validate(data){
    let errorFlag = false;

    if (!validateEmail(data.get("email"))) {
        emailError.style.display = "block";
        errorFlag = true;
    } else {
        emailError.style.display = "none";
    }

    if(data.get("password") == ""){
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
window.addEventListener("load",()=>{
    let token = localStorage.getItem("token");
    if(token != null){
        window.location.replace("http://localhost/ecommerce/user/homepage.php");
    }
})


