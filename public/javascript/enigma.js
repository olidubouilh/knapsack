//Bouton confirmer difficulté question Enigma

document.addEventListener('DOMContentLoaded', () => {
    setHiddenValue();

    document.querySelectorAll('input[name="difficulte"]').forEach(radio => {
        radio.addEventListener('change', setHiddenValue);
    });
});
/**
 * Définit la valeur du champ de formulaire caché "difficulte_id" en fonction de
 * la radio bouton sélectionnée pour la difficulté de la question.
 *
 * @return {boolean} True si une radio bouton est sélectionnée, false sinon.
 */
function setHiddenValue() {
    const selected = document.querySelector('input[name="difficulte"]:checked');
    if (selected) {
        document.getElementById('difficulte_id').value = selected.value;
        return true;
    } else {
        return false;
    }
}


document.querySelector('form').addEventListener('submit', setReponseValue);

/**
 * Définit la valeur du champ de formulaire caché "reponse_id" en fonction du bouton radio
 * sélectionné pour la réponse et soumet le formulaire.
 */
function setReponseValue() {
    const radios = document.getElementsByName('reponse'); // Get all radio elements with the name 'reponse'

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            const reponseIdInput = document.getElementById('reponse_id'); // Récupère le champ de formulaire caché avec l'ID 'reponse_id'
            reponseIdInput.value = radios[i].value; // Fixer la valeur du champ caché avec la valeur du bouton radio sélectionné 
            document.querySelector('form').submit(); // Soumettre le formulaire après avoir fixé la valeur du champ caché 
            break;
        }
    }
}