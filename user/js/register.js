let registerBtn = document.getElementById("registerBtn");
let nameError = document.getElementById("nameError");
let emailError =document.getElementById("emailError");
let numberError = document.getElementById("numberError");
let addressError = document.getElementById("addressError");
let passwordError = document.getElementById("passwordError");
let cpassError =document.getElementById("cpassError");

registerBtn.addEventListener("click", () => {
    // get the form data
    let userForm = document.forms["userRegistration"];
    let formData = new FormData();

    formData.append("name", userForm["name"].value);
    formData.append("email", userForm["email"].value);
    formData.append("phoneNo", userForm["phoneNo"].value);
    formData.append("address", userForm["address"].value);
    formData.append("password", userForm["password"].value);
    // send the request
    if (!validate(formData)) {
        let url="request.php/register";
        fetch(url,{
            "method" : "POST",
            "body" : formData
        }).then((response)=>{
            if(response.ok){
                return response.json();
            }else{
                throw new Error("Error in fetching response");
            }
        }).then((data)=>{
            console.log(data);
            if(data["status"] == "success"){
                snackBarSuccess("Registration Successsfull" , ()=>{
                    window.location.replace("http://localhost/ecommerce/user/login.php");
                })
            }else{
                snackBarError("Registration Failed")
            }
        }).catch((error)=>{
            snackBarError("Registration Failed")
        })
    } else {
        snackBarError("Please fill details")
    }
})

function validate(userData) {
    let errorFlag = false;
    let name = userData.get("name");

    if (name == "") {
        nameError.style.display = "block";
        errorFlag = true;
    } else {
        nameError.style.display = "none";
    }

    let email = userData.get("email");

    if (!validateEmail(email)) {
        emailError.style.display = "block";
        errorFlag = true;
    } else {
        emailError.style.display = "none";
    }

    let phoneNo = userData.get("phoneNo")
    if(phoneNo == "" || phoneNo.length !== 10 || !/^\d+$/.test(phoneNo)){
        numberError.style.display = "block";
        errorFlag = true;
    }else{
        numberError.style.display = "none";
    }

    let address = userData.get("address");
    if (address == "") {
        addressError.style.display = "block";
        errorFlag = true;
    } else {
        addressError.style.display = "none";
    }

    let password= userData.get("password");
    if(password == ""){
        passwordError.style.display = "block";
        errorFlag=true;
    }else{
        passwordError.style.display = "none";
    }

    var cpass = document.querySelector('input[name="cpassword"]').value;
    if(cpass ==""){
        cpassError.innerText="Please enter valid password";
        cpassError.style.display="block";
        errorFlag=true;
    }else{
        if(cpass != password){
            cpassError.innerText ="Passwords do not match";
            cpassError.style.display= "block";
            errorFlag=true;
        }else{
            cpassError.style.display = "none";
        }
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