function increaseQuantity(){
    //Ne fonctionne pas encore
    const Element = document.getElementById('quantity').textContent;
    quantity = parseInt(Element) + 1;
    document.getElementById('quantity').textContent = quantity;
}

function decreaseQuantity(){
    //Ne fonctionne pas encore
    const Element = document.getElementById('quantity').textContent;
    quantity = parseInt(Element) - 1;
    document.getElementById('quantity').textContent = quantity;
}