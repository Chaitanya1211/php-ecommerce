let token;
let addProductParent = document.getElementById("addProductParent");
let addProduct = document.getElementById("addProduct");
let addProductBtn = document.getElementById("addProductBtn");
let discardAdd= document.getElementById("discardAdd");
let discardEdit= document.getElementById("discardEdit");

let editParent = document.getElementById("editProductParent");

let nameErr = document.getElementById("name-error");
let categoryErr = document.getElementById("category-error");
let descErr = document.getElementById("desc-err");
let fileErr = document.getElementById("file-err");
let costErr = document.getElementById("cost-err");

let noProducts = document.getElementById("noProduct");
let productRow=  document.getElementById("productRow")
let productArray=[];

let editProductBtn = document.getElementById("editProduct");

addProductBtn.addEventListener("click", (event)=>{
    event.preventDefault();
    // open the add product box
    let productForm = document.forms["newProduct"];
    productForm.reset();
    addProductParent.style.display = "block";
})

discardAdd.addEventListener("click", ()=>{
    let productForm = document.forms["newProduct"];
    productForm.reset();
    addProductParent.style.display ="none";
})
discardEdit.addEventListener("click", ()=>{
    let editForm = document.forms["editProductForm"];
    editForm.reset();
    let editParent = document.getElementById("editProductParent");
    editParent.style.display="none";
})

addProduct.addEventListener("click", (event) => {
    event.preventDefault();
    let newProduct = {};
    let productForm = document.forms["newProduct"];
    newProduct["name"] = productForm["name"].value;
    newProduct["category"] = productForm["category"].value;
    newProduct["description"] = productForm["description"].value;
    newProduct["formFile"] = productForm["formFile"].value;
    newProduct["cost"] = productForm["cost"].value;
    
    // Create FormData object to handle multipart/form-data
    let formData = new FormData();
    formData.append('name', productForm["name"].value);
    formData.append('category', productForm["category"].value);
    formData.append('description', productForm["description"].value);
    formData.append('cost', productForm["cost"].value);
    
    // Append file to FormData
    formData.append('image', productForm["formFile"].files[0]);

    if(!validate(newProduct)){
        // make a request to add product
        let url="request.php/addProduct";
        fetch(url,{
            "method" : "POST",
            "headers" :{
                "token" : token
            },
            "body" : formData
        }).then((response)=>{
            console.log(response)
            if(response.ok){
                return response.json();
            }else{
                throw new Error("Error in resposne")
            }
        }).then((data)=>{
            console.log(data);
            if(data["status"] == "success"){
                // success
                snackBarSuccess("Product Added Successfully");
                renderProducts();
            }else{
                snackBarError("Product Addition Failed")
                renderProducts();
            }
            // hide the parent
            addProductParent.style.display="none";
        }).catch((error)=>{
            console.log("error", error)
            snackBarError("Error occured");
            addProductParent.style.display="none";
        })
    }else{
        console.log("Error");
    }
});

function validate(product) {
    let errorFlag = false;

    if (product["name"] == "") {
        nameErr.style.display = "block";
        errorFlag = true;
    } else {
        nameErr.style.display = "none";
    }

    if (product["category"] == "") {
        categoryErr.style.display = "block";
        errorFlag = true;
    } else {
        categoryErr.style.display = "none";
    }

    if (product["description"] == "") {
        descErr.style.display = "block";
        errorFlag = true;
    } else {
        descErr.style.display = "none";
    }

    if (product["formFile"] == "") {
        fileErr.style.display = "block";
        errorFlag = true;
    } else {
        fileErr.style.display = "none";
    }

    if (product["cost"] == "") {
        costErr.style.display = "block";
        errorFlag = true;
    } else {
        costErr.style.display = "none";
    }
    return errorFlag;
}

window.addEventListener("load", (event) => {
    event.preventDefault();
    token = localStorage.getItem("token");
    console.log("token :", token)
    if(token != null){
        renderProducts();
    }else{
        window.location.replace("http://localhost/ecommerce/admin/login.php");
    }
});

function snackBarSuccess(message) {
    var x = document.getElementById("snackBarSuccess");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden";}, 3000);
}

function snackBarError(message) {
    var x = document.getElementById("snackBarError");
    var span = x.querySelector("span");
    span.innerText = message;
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 3000);
}

function snackBarDelete() {
    var x = document.getElementById("snackBarDelete");
    x.style.visibility = "visible";
    setTimeout(() => { x.style.visibility = "hidden"; }, 3000);
}

function renderProducts(){
    console.log("Render called")
    url="request.php/getProducts";
    fetch(url,{
        "method" : "GET",
        "headers":{
            "content-type":"application-json",
            "token" : token
        }
    }).then((response)=>{
        if(response.ok){
            return response.json();
        }else{
            throw new Error("Error in resposne")
        }
    }).then((data)=>{
        console.log(data)
        productArray=data["products"];
        // productRow.innerText="";
        if(data["count"] != 0){
            // hide no product section
            noProducts.style.display="none";
            productRow.style.display="flex";
            productRow.innerText="";
            productArray.forEach((product,index)=>{
                console.log(product);
                let productCard = createProductCard(product,index);
                productRow.append(productCard);
            })
        }else{
            // hide row and show no products screen
            noProducts.style.display = "flex";
            productRow.style.display = "none";
        }
    }).catch((error)=>{
        console.log("error :" ,error)
    })
}

function createProductCard(product,index){
    let sampleProduct = document.getElementById("sampleProduct");
    let newProduct = sampleProduct.cloneNode(true);
    newProduct.style.display ="block";

    let productImage = newProduct.querySelector(".productImage");
    productImage.setAttribute("src", product.image);

    let productName = newProduct.querySelector(".productName");
    productName.innerText = product.name;

    let productDesc = newProduct.querySelector(".productDesc");
    productDesc.innerText=product.description;

    let productCost = newProduct.querySelector(".productCost");
    productCost.innerText =  product.price;
    let deleteBtn=newProduct.querySelector(".deleteBtn");
    deleteBtn.setAttribute("onclick", `deleteProduct('${product.id}')`);

    let editBtn = newProduct.querySelector(".editBtn");
    editBtn.setAttribute("onclick", `edit('${product.id}','${index}')`);

    return newProduct;
}

async function deleteProduct(id) {
    // show modal and ask for conformation
    console.log("Called")
    var result = await getConfirmation();
    if (result) {
        let url=`request.php/deleteProduct/${id}`;
        fetch(url,{
            "method" : "DELETE",
            "headers":{
                "content-type" : "application-json",
                "token" : token
            }
        }).then((response)=>{
            if(response.ok){
                return response.json();
            }else{
                throw new Error("Error in receiving response")
            }
        }).then((data)=>{
            if(data["status"]== "success"){
                snackBarDelete();
                // renderProducts();
            }else{
                snackBarError("Product Deletion Failed")
            }
            renderProducts();
        }).catch((error)=>{
            console.log("Error : ",error)
        })
    }
}

async function getConfirmation() {
    return new Promise((resolve) => {
        let deleteModal = document.getElementById("deleteModal")
        deleteModal.style.display = "block";
        var deleteItemFlag;
        let deleteButton = document.getElementById("confirmDelete");
        deleteButton.addEventListener("click", () => {
            deleteItemFlag = true;
            resolve(deleteItemFlag);
            deleteModal.style.display = "none";
        });
        let closeButton = document.getElementById("closeButton");
        closeButton.addEventListener("click", () => {
            deleteItemFlag = false;
            resolve(deleteItemFlag);
            deleteModal.style.display = "none";
        });
    })
}

function edit(id,index){
    let editParent = document.getElementById("editProductParent");
    editParent.style.display="block";
    setModalValues(productArray[index],id);
}

function setModalValues(product,id){
    let editForm = document.forms["editProductForm"];
    console.log(product);
    editForm["name"].value = product.name;
    editForm["category"].value = product.category;
    editForm["description"].value = product.description;
    editForm["image"].src = product.image;
    editForm["cost"].value = product.price;
  
    let editBtn= editParent.querySelector("#editProduct");
    editBtn.setAttribute("onclick",`makeEditRequest('${id}')`)
}

function makeEditRequest(id){
    // get form data of edit
    let newProduct={};
    let editForm = document.forms["editProductForm"];
    newProduct["name"] = editForm["name"].value;
    newProduct["category"] = editForm["category"].value;
    newProduct["description"] = editForm["description"].value;
    newProduct["formFile"] = editForm["formFile"].value;
    newProduct["cost"] = editForm["cost"].value;

    let formData = new FormData();
    formData.append('name', editForm["name"].value);
    formData.append('category', editForm["category"].value);
    formData.append('description', editForm["description"].value);
    formData.append('cost', editForm["cost"].value);
    
    // Append file to FormData
    formData.append('image', editForm["formFile"].files[0]);

    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

    if(!validate(newProduct)){
        // make a request
        let url=`request.php/editProduct/${id}`;
        fetch(url,{
            "method" : "POST",
            "headers":{
                "token" : token
            },
            "body" : formData
        }).then((response)=>{
            if(response.ok){
                return response.json();
            }else{
                throw new Error("Error in resposne")
            }
        }).then((data)=>{
            if(data["status"] == "success"){
                editParent.style.display="none";
                snackBarSuccess("Note edited");
            }else{
                snackBarError("Note edit failed");
                editParent.style.display="none";
            }
            renderProducts();
        }).catch((error)=>{
            console.log("Error caught :" ,error)
        })
    }else{
        console.log("Error in form filling");
    }

}
