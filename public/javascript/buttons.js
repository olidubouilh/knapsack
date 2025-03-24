function increaseQuantity(id){
    //Ne fonctionne pas encore
    const Element = document.getElementById(id).textContent;
    quantity = parseInt(Element) + 1;
    document.getElementById(id).textContent = quantity;
}

function decreaseQuantity(id){
    //Ne fonctionne pas encore
    const Element = document.getElementById(id).textContent;
    quantity = parseInt(Element) - 1;
    document.getElementById(id).textContent = quantity;
}