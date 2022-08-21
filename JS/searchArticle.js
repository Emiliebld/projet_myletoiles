'use strict';

if (document.querySelector("#search") !== null) {
    //select input id search

    let input = document.querySelector("#search");

    input.addEventListener('keyup', () => { // EventListener keyup

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
            })
    })
}
