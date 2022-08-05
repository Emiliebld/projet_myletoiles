document.addEventListener("DOMContentLoaded", function() {
    //DOM : chargement du html,se déclenche lorsque le contenu DOM est chargé, 
    //sans attendre la fin du chargement des images et des feuilles de style.

    let input;
    let logoEye;

    if (document.querySelector("#password") !== null) {
        //!==null : car il n'apparait pas dans les autres pages
        input = document.getElementById('password');
    }
    if (document.querySelector("#eye") !== null) {
        document.getElementById('eye').addEventListener('click', openEye);

    }
    if (document.querySelector("#logoEye") !== null) {
        logoEye = document.getElementById('logoEye');
    }


    function openEye(e) {
        e.preventDefault();
        if (input.type == 'password') {
            input.setAttribute("type", "text");
            logoEye.setAttribute("style", "color:red");
            logoEye.classList.remove("fa-eye-slash");
            logoEye.classList.add("fa-eye");
        }
        else {
            input.setAttribute("type", "password");
            logoEye.removeAttribute("style");
            logoEye.classList.remove("fa-eye");
            logoEye.classList.add("fa-eye-slash");
        }
        window.setTimeout(closeEye, 5000);
    }

    function closeEye() {
        input.setAttribute("type", "password");
        logoEye.removeAttribute("style");
        logoEye.classList.remove("fa-eye");
        logoEye.classList.add("fa-eye-slash");
    }


});
