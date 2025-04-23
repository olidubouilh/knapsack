document.addEventListener("DOMContentLoaded", () => {
    if (!window.afficherConfirmationDex || !window.quantitesEnAttente) return;

    const message = "Votre inventaire est trop lourd. Si vous payez, vous allez perdre de la dextérité.\n\nVoulez-vous continuer ou aller à l'inventaire ?";

    if (confirm(message)) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/panier";

        for (const id in window.quantitesEnAttente) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = `quantites[${id}]`;
            input.value = window.quantitesEnAttente[id];
            form.appendChild(input);
        }

        const confirmation = document.createElement("input");
        confirmation.type = "hidden";
        confirmation.name = "confirmerDex";
        confirmation.value = "1";
        form.appendChild(confirmation);

        document.body.appendChild(form);
        form.submit();
    } else {
        window.location.href = "/inventaire";
    }
});
