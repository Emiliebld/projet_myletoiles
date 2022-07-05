let navbar = document.getElementById("mySidenav");
let openBtn = document.getElementById("openBtn");
let closeBtn = document.getElementById("closeBtn");

openBtn.onclick = () => openNav();
closeBtn.onclick = () => closeNav();

/* Set the width of the side navigation to 250px */
function openNav() {
    console.log('ici')
    navbar.classList.add("active");
}

/* Set the width of the side navigation to 0 */
function closeNav() {

    console.log('la')
    navbar.classList.remove("active");
}
