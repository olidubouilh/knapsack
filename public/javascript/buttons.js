/**
 * Augmente la quantité d'un article jusqu'à une quantité maximale spécifiée.
 * @param {string} id - L'ID de l'élément dont la quantité est à augmenter.
 * @param {number} maxQty - La quantité maximale autorisée.
 */
function increaseQuantity(id, maxQty) {
    // Récupère la quantité actuelle à partir du contenu de l'élément
    const Element = document.getElementById(id).textContent;
    
    // Initialise la variable de quantité
    let quantity;

    // Si la quantité actuelle est inférieure à maxQty, l'augmente de 1, sinon la fixe à maxQty
    if (parseInt(Element) < maxQty) {
        quantity = parseInt(Element) + 1;
    } else {
        quantity = maxQty;
    }

    // Met à jour le contenu de l'élément avec la nouvelle quantité
    document.getElementById(id).textContent = quantity;
}

/**
 * Diminue la quantité d'un article si elle est supérieure à 1.
 * @param {string} id - L'ID de l'élément dont la quantité est à diminuer.
 */
function decreaseQuantity(id) {
    const Element = document.getElementById(id).textContent;
    
    // Si la quantité actuelle est supérieure à 1, la diminue de 1, sinon la fixe à 1.
    // Ceci est fait pour s'assurer que la quantité n'est jamais inférieure à 1.
    let quantity;
    if (parseInt(Element) > 1) {
        quantity = parseInt(Element) - 1;
    } else {
        quantity = 1;
    }
    
    // Met à jour le contenu de l'élément avec la nouvelle quantité
    document.getElementById(id).textContent = quantity;
}

/**
 * Met à jour le prix total des articles dans le panier.
 */
function updateTotal() {
    let total = 0;

    // Parcourt tous les éléments .quantite de la page
    document.querySelectorAll('.quantite').forEach(span => {
        // Récupère la quantité à partir du contenu de l'élément
        const quantity = parseInt(span.innerText);
        // Récupère le prix de l'article à partir de l'attribut data-prix
        const price = parseInt(span.getAttribute('data-prix'));
        // Ajoute la quantité multipliée par le prix au total
        total += quantity * price;
    });

    // Met à jour l'élément #totalPrix avec le nouveau prix total
    document.getElementById('totalPrix').innerText = "Prix total : " + total + " caps";
}

/**
 * Met à jour le poids total des articles dans le panier.
 */
function updatePoids() {
    let poids = 0;

    // Parcourt tous les éléments .quantite de la page
    document.querySelectorAll('.quantite').forEach(span => {
        // Récupère la quantité à partir du contenu textuel de l'élément
        const quantity = parseInt(span.innerText);
        // Récupère le poids de l'article à partir de l'attribut data-poids
        const poidsItem = parseFloat(span.getAttribute('data-poids'));
        // Si le poids n'est pas NaN, ajoute la quantité multipliée par le poids au total
        if (!isNaN(poidsItem)) {
            poids += quantity * poidsItem;
        }
    });

    // Met à jour l'élément #poidsTotal avec le nouveau poids total
    const poidsElem = document.getElementById('poidsTotal');
    if (poidsElem) {
        poidsElem.innerText = "Poids total : " + poids.toFixed(2) + " lbs";
    } else {
        console.log("Élément #poidsTotal introuvable");
    }
}

/**
 * Synchronise les valeurs de tous les éléments .quantite de la page avec la valeur de
 * l'élément input correspondant.
 */
function syncQuantites() {
    // Parcourt tous les éléments .quantite de la page
    document.querySelectorAll('.quantite').forEach(span => {
        // Récupère l'ID de l'élément à partir de l'attribut data-id
        const id = span.getAttribute('data-id');
        // Trouve l'élément input correspondant
        const input = document.getElementById('input-' + id);
        // Si l'élément input existe, met sa valeur à jour avec la valeur de l'élément .quantite
        if (input) input.value = span.innerText.trim();
    });
}

/**
 * Supprime un article du panier.
 * @param {number} itemId - L'ID de l'article à supprimer.
 * @param {number} userId - L'ID du joueur.
 */
function supprimerItemPanier(itemId, userId) {
    if (!confirm("Voulez-vous vraiment supprimer cet article du panier ?")) return;

    // Crée un objet FormData pour envoyer la requête
    let formData = new FormData();

    // Ajoute l'ID de l'article et l'ID du joueur à l'objet FormData
    formData.append("idItems", itemId);
    formData.append("idJoueurs", userId);

    // Envoie la requête au serveur
    fetch("../../models/ItemsModel.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(responseText => {
        // Si la réponse est "success", supprime l'article de la page
        if (responseText.trim() === "success") {
            document.getElementById(itemId).closest('.item-slot').remove();
            alert("Article supprimé !");
            // Met à jour le prix total et le poids total des articles dans le panier
            updateTotal();
            updatePoids();
        } else {
            // Si la réponse n'est pas "success", affiche un message d'erreur
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

