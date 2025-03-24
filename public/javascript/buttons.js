function increaseQuantity(id){
    const Element = document.getElementById(id).textContent;
    if(parseInt(Element) <= 20){
            quantity = parseInt(Element) + 1;
    }
    else{
        
    }
    document.getElementById(id).textContent = quantity;
}

function decreaseQuantity(id){
    const Element = document.getElementById(id).textContent;
    if(parseInt(Element) > 1){
        quantity = parseInt(Element) - 1;
    }
    else{
        quantity = 1;
    }
    document.getElementById(id).textContent = quantity;
}
function payerPanier(id, montantTotal){

}