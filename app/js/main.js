document.querySelector("#add_cat").addEventListener('click',()=>{
    document.querySelector(".modal-bg").style.display = "flex";
})
document.querySelector(".close-modal").addEventListener('click',()=>{
    document.querySelector(".modal-bg").style.display = "none";
})


document.querySelector("#toggle-menu").addEventListener('click',()=>{
    var display = document.querySelector(".menu-content");
    if(display.style.display == "none"){
        document.querySelector(".menu-content").style.display = "flex";
    }else{
        document.querySelector(".menu-content").style.display = "none";
    }
})