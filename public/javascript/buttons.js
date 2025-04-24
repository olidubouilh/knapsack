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

function updateTotal() {
    let total = 0;

    document.querySelectorAll('.quantite').forEach(span => {
        const quantity = parseInt(span.innerText);
        const price = parseInt(span.getAttribute('data-prix'));
        total += quantity * price;
    });

    document.getElementById('totalPrix').innerText = "Prix total : " + total + " caps";
}

function updatePoids() {
    let poids = 0;

    document.querySelectorAll('.quantite').forEach(span => {
        const quantity = parseInt(span.innerText);
        const poidsItem = parseFloat(span.getAttribute('data-poids'));
        console.log("poidsItem:", poidsItem, " × ", quantity); // DEBUG
        if (!isNaN(poidsItem)) {
            poids += quantity * poidsItem;
        }
    });

    const poidsElem = document.getElementById('poidsTotal');
    if (poidsElem) {
        poidsElem.innerText = "Poids total : " + poids.toFixed(2) + " lbs";
    } else {
        console.log("Élément #poidsTotal introuvable");
    }
}

function syncQuantites() {
    document.querySelectorAll('.quantite').forEach(span => {
        const id = span.getAttribute('data-id');
        const input = document.getElementById('input-' + id);
        if (input) input.value = span.innerText.trim();
    });
}

function supprimerItemPanier(itemId, userId) {
    if (!confirm("Voulez-vous vraiment supprimer cet article du panier ?")) return;

    let formData = new FormData();
    formData.append("idItems", itemId);
    formData.append("idJoueurs", userId);

    fetch("../../models/ItemsModel.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(responseText => {
        if (responseText.trim() === "success") {
            document.getElementById(itemId).closest('.item-slot').remove();
            alert("Article supprimé !");
            updateTotal();
            updatePoids();
        } else {
            alert("Erreur : " + responseText);
        }
    })
    .catch(error => console.error("Erreur:", error));
}

document.addEventListener('DOMContentLoaded', () => {
    syncQuantites();
    updateTotal();
    updatePoids(); // <- important ici

    document.querySelectorAll('.boutonquanti').forEach(button => {
        button.addEventListener('click', () => {
            setTimeout(() => {
                syncQuantites();
                updateTotal();
                updatePoids(); // <- et ici
            }, 50);
        });
    });
});
