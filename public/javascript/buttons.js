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



function supprimerItemPanier(itemId, userId) {
    if (!confirm("Voulez-vous vraiment supprimer cet article du panier ?")) return;

    let formData = new FormData();
    formData.append("idItems", itemId);
    formData.append("idJouers", userId);

    fetch("../../models/ItemsModel.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(responseText => {
        if (responseText.trim() === "success") {
            document.getElementById(itemId).closest('.item-slot').remove();
            alert("Article supprimé !");
        } else {
            alert("Erreur : " + responseText);
        }
    })
    .catch(error => console.error("Erreur:", error));
}
