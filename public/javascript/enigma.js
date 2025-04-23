//bouton confirmer difficulté question Enigma

document.addEventListener('DOMContentLoaded', () => {
    setHiddenValue();

    document.querySelectorAll('input[name="difficulte"]').forEach(radio => {
        radio.addEventListener('change', setHiddenValue);
    });
});
function setHiddenValue() {
    const selected = document.querySelector('input[name="difficulte"]:checked');
    if (selected) {
        document.getElementById('difficulte_id').value = selected.value;
        return true;
    } else {
        return false; // prevent form submission if nothing selected
    }
}

//boutton confirmer réponse question Enigma
//Ca ne fonctionne pas trop, je suis pu capable 

document.querySelector('form').addEventListener('submit', setReponseValue); //Ajoute un eventListener au formulaire pour appeler la fonction setReponseValue lors de la soumission
function setReponseValue() {
    const radios = document.getElementsByName('reponse'); // Récupère tous les éléments radio avec le nom 'reponse'
    //Je sais qu'un foreach est bien meilleur, mais j'ai déjà essayé et ça ne fonctionnais pas.
    for(let i = 0; i < radios.length; i++) {
        if(radios[i].checked) {
            const reponseIdInput = document.getElementById('reponse_id'); // Récupère l'élément input caché avec l'ID 'reponse_id' qui correspond à la réponse du user
            reponseIdInput.value = radios[i].value; // Définit la valeur de l'input caché sur la valeur de l'élément radio sélectionné
            document.querySelector('form').submit(); // Soummet le form après avoir défini la valeur de l'input caché pour que la réponse soit prise dans le controller
            break;
        }
    }
}
