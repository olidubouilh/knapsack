/**
 * Affiche une notification popup pendant une courte durée.
 */
function alertShow() {
    // Obtenir l'élément de notification popup par son ID
    const popup = document.getElementById('popupNotification');
    
    // Afficher la popup
    popup.style.display = 'block'; 

    // Masquer la popup après 3 secondes
    setTimeout(() => {
        popup.style.display = 'none'; 
    }, 3000);
}