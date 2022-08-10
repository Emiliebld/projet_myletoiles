'use strict';

let input = document.querySelector("#search");

input.addEventListener('keyup', () => { // Ecoute d'évènement au keyup

    // Récupérer le text tapé dans l'input par l'utilisateur
    let textFind = document.querySelector('#search').value;

    // Faire un objet de type request
    let myRequest = new Request('Model/class/searchArticle.php', {
        method: 'POST',
        body: JSON.stringify({ textToFind: textFind })
    })
    // On attend la réponse du fichier searchArticle.php

    fetch(myRequest)
        // Récupère les données
        .then(res => res.text())

        // Exploite les données
        .then(res => {
            document.getElementById("target").innerHTML = res;
            // On met search_article.phtml dans la div -> id=target

        })
})
