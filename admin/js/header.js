let user=document.getElementById("user");

function renderName(){
    if(token != null){
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
            details = data["details"];
            user.innerHTML=details["name"]
        }).catch((error)=>{
            console.log("Error : ", error)
        })
    }else{
        console.log("Token not found")
    }
}
window.addEventListener("load", (event) => {
    token = localStorage.getItem("token");
    renderName();
});