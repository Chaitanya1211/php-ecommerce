let registerBtn = document.getElementById("registerBtn");
let header ={
    "content-type" : "application"
}
let nameError = document.getElementById("nameError")
let numberError = document.getElementById("numberError")
let emailError = document.getElementById("emailError")
let passwordError = document.getElementById("passwordError")
let addressError = document.getElementById("addressError")
let contactError = document.getElementById("contactError")
let gstError = document.getElementById("gstError")
let cpassError = document.getElementById("cpassError")

registerBtn.addEventListener("click", () => {
    console.log("here");
    let seller_det = {};
    let registerForm_1 = document.forms["register-1"];
    let registerForm_2 = document.forms["register-2"];
    seller_det["name"] = registerForm_1["name"].value;
    seller_det["email"] = registerForm_1["email"].value;
    seller_det["number"] = registerForm_1["number"].value;
    seller_det["password"] = registerForm_1["password"].value;

    seller_det["address"] = registerForm_2["address"].value;
    seller_det["contact"] = registerForm_2["contact"].value;
    seller_det["gst"] = registerForm_2["gst"].value;
    seller_det["cpassword"] = registerForm_2["cpassword"].value;

    if (!validate(seller_det)) {
        console.log(seller_det);
        let url = "request.php/register";
        fetch(url,{
            "method" : "POST",
            "headers" : header,
            "body" : JSON.stringify(seller_det)
        }).then((response)=>{
            console.log(response);
            if(response.ok){
                return response.json();
            }else{
                throw new Error("Error in fetching response");
            }
        }).then((data)=>{
            console.log(data);
            if(data["status"] == "success"){
                 snackBarSuccess("Registration Successfull. Please login", ()=>{
                    window.location.replace("http://localhost/ecommerce/admin/login.php");
                });
            }else{
                snackBarError("Registration Failed. Try again later")
            }
        }).catch((err)=>{
            console.log("Error occured :", err)
        })
    } else {
        // snackbar for fill details
        snackBarError("Please Fill Details Properly")
    }
})

function registerApi(){
    
}

function validate(seller) {
    let errorFlag = false;

    if (seller.name == "") {
        nameError.style.display = "block";
        errorFlag = true;
    } else {
        nameError.style.display = "none";
    }

    if (!validateEmail(seller.email)) {
        emailError.style.display = "block";
        errorFlag = true;
    } else {
        emailError.style.display = "none";
    }

    if(seller.number == "" || seller.number.length !== 10 || !/^\d+$/.test(seller.number)){
        numberError.style.display = "block";
        errorFlag = true;
    }else{
        numberError.style.display = "none";
    }

    if (seller.password == "") {
        passwordError.style.disply = "block";
        errorFlag = true;
    } else {
        passwordError.style.disply = "none";
    }

    if (seller.address == "") {
        addressError.style.display = "block";
        errorFlag = true;
    } else {
        addressError.style.display = "none";
    }

    if(seller.contact == "" || seller.contact.length !== 10 || !/^\d+$/.test(seller.contact)){
        contactError.style.display = "block";
        errorFlag = true;
    }else{
        contactError.style.display = "none";
    }

    if (seller.gst == "") {
        gstError.style.display = "block";
        errorFlag = true;
    } else {
        gstError.style.display = "none";
    }

    if (seller.cpassword == "") {
        cpassError.style.display = "block";
        errorFlag = true;
    } else if (seller.cpassword != seller.password) {
        cpassError.innerHTML = "Password and confirm password does not match";
        cpassError.style.display = "block";
        errorFlag = true;
    } else {
        cpassError.style.display = "none";
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