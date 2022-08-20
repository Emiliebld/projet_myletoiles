'use strict';

if (document.querySelector("#search") !== null) {

    let input = document.querySelector("#search");

    input.addEventListener('keyup', () => { // Ecoute d'évènement au keyup

        // Take the Input Text by user
        let textFind = document.querySelector('#search').value;

        // To do an object : type request
        let myRequest = new Request('Model/class/searchArticle.php', {
            method: 'POST',
            body: JSON.stringify({ textToFind: textFind })
        })
        //We wait the answer of searchArticle.php

        fetch(myRequest)
            // Récup data
            .then(res => res.text())

            // Exploit data
            .then(res => {
                document.getElementById("target").innerHTML = res;
                // search_article.phtml in div -> id=target
                //on mets search.phtml dans la div

            })
    })
}
