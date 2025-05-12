/**
 * Ce script est exécuté lorsque la page est chargée et que la variable window.afficherConfirmationDex est définie à true.
 * Il affichera un dialogue de confirmation à l'utilisateur, lui demandant s'il veut payer les objets dans son panier
 * même si cela va lui faire perdre de la dextérité.
 * Si l'utilisateur confirme, il soumettra un formulaire au serveur avec les objets et la confirmation.
 * Si l'utilisateur annule, il sera redirigé vers la page de l'inventaire.
 */
document.addEventListener("DOMContentLoaded", () => {
    if (!window.afficherConfirmationDex || !window.quantitesEnAttente) return;

    const message = "Votre inventaire est trop lourd. Si vous payez, vous allez perdre de la dextérité.\n\nVoulez-vous continuer ou aller à l'inventaire ?";

    // Afficher le dialogue de confirmation
    if (confirm(message)) {
        // Créer un formulaire à soumettre au serveur
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/panier";

        // Ajouter les objets au formulaire
        for (const id in window.quantitesEnAttente) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = `quantites[${id}]`;
            input.value = window.quantitesEnAttente[id];
            form.appendChild(input);
        }

        // Ajouter un champ caché pour confirmer la perte de dextérité
        const confirmation = document.createElement("input");
        confirmation.type = "hidden";
        confirmation.name = "confirmerDex";
        confirmation.value = "1";
        form.appendChild(confirmation);

        // Ajouter un champ caché pour soumettre le formulaire comme action "payer"
        const boutonPayer = document.createElement("input");
        boutonPayer.type = "hidden";
        boutonPayer.name = "payer";
        boutonPayer.value = "1";
        form.appendChild(boutonPayer);

        // Ajouter le formulaire à la page et le soumettre
        document.body.appendChild(form);
        form.submit();
    } else {
        // Rediriger vers la page de l'inventaire
        window.location.href = "/inventaire";
    }
});