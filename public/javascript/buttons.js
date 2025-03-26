function increaseQuantity(id, maxQty){
    const Element = document.getElementById(id).textContent;
    if(parseInt(Element) < maxQty){
            quantity = parseInt(Element) + 1;
    }
    else{
        quantity = maxQty;
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
document.addEventListener('DOMContentLoaded', () => {
    updateTotal();

    document.querySelectorAll('.boutonquanti').forEach(button => {
        button.addEventListener('click', () => {
            setTimeout(updateTotal, 50); 
        });
    });
});

function updateTotal() {
    let total = 0;

    document.querySelectorAll('.quantite').forEach(span => {
        const quantity = parseInt(span.innerText);
        const price = parseInt(span.getAttribute('data-prix'));

        total += quantity * price;
    });

    document.getElementById('totalPrix').innerText = total;
}