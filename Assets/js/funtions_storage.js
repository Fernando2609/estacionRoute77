//Dark mode

let btnSwitch = document.querySelector('.switch');
btnSwitch.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    //document.querySelector('#navegacion').classList.replace("navbar-white", "navbar-dark")
    $(".navbar-light").toggleClass("navbar-dark navbar-white")
    btnSwitch.classList.toggle('active');
    //Guardar en localStorage
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('dark', 'true')
    } else {
        localStorage.setItem('dark', 'false')
    }
});

//Saber el modo actual del switch
if (localStorage.getItem('dark') === 'true') {
    document.body.classList.add('dark-mode');
    btnSwitch.classList.add('active');
    document.querySelector('#navegacion').classList.replace("navbar-white", "navbar-dark")
} else {
    document.body.classList.remove('dark-mode');
    btnSwitch.classList.remove('active');
    document.querySelector('#navegacion').classList.remove("navbar-dark")
    document.querySelector('#navegacion').classList.add("navbar-white")
}

//Nav bar collapse, guardar en locale Storage
let btnNav = document.querySelector('#nav-bar');
btnNav.addEventListener('click', () => {
    document.body.classList.toggle('nav-Activa');

    if (document.body.classList.contains('nav-Activa')) {
        localStorage.setItem('barra', 'true')
    } else {
        localStorage.setItem('barra', 'false')
    }
});
//Saber el modo actual de la barra
if (localStorage.getItem('barra') === 'true') {
    document.body.classList.add('sidebar-collapse');
    document.body.classList.add('nav-Activa');
} else {
    document.body.classList.remove('sidebar-collapse');

}
