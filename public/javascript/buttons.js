/**
 * Augmente la quantité affichée d'un élément spécifique de 1, 
 * jusqu'à un maximum spécifié.
 *
 * @param {string} id - L'ID de l'élément dont la quantité va être augmentée.
 * @param {number} maxQty - La quantité maximale autorisée pour l'élément.
 * @return {void}
 */

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

/**
 * Réduit la quantité affichée d'un item spécifique de 1, en s'assurant que la quantité ne soit pas en dessous de 1.
 *
 * @param {string} id - L'ID de l'élément duquel la quantité va être réduite.
 * @return {void}
 */

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



/**
 * Met à jour le prix total affiché en fonction des quantités 
 * définies pour chaque article dans le panier.
 *
 * @return {void}
 */
function updateTotal() {
    let total = 0;

    document.querySelectorAll('.quantite').forEach(span => {
        const quantity = parseInt(span.innerText);
        const price = parseInt(span.getAttribute('data-prix'));

        total += quantity * price;
    });

    document.getElementById('totalPrix').innerText = "Prix total : " + total + " caps";
}



/**
 * Supprime un article du panier après confirmation de l'utilisateur.
 * 
 * Cette fonction envoie une requête POST au serveur pour supprimer un article
 * du panier en utilisant son identifiant et celui de l'utilisateur. Si la
 * suppression est réussie, l'article est retiré de l'affichage et un message
 * de confirmation est affiché. En cas d'erreur, un message d'erreur est affiché.
 * 
 * @param {number} itemId - L'identifiant de l'article à supprimer.
 * @param {number} userId - L'identifiant de l'utilisateur qui supprime l'article.
 */
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

//Met à jour le prix total du panier en appelant updateTotal() lors du chargement de la page(après le DOM)
document.addEventListener('DOMContentLoaded', () => {
    updateTotal();

    document.querySelectorAll('.boutonquanti').forEach(button => {
        button.addEventListener('click', () => {
            setTimeout(updateTotal, 50); 
        });
    });
});

