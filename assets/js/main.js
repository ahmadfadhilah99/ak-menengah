const navbar = document.getElementById('navbar');
let lastScrollTop = 0;

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 50) {
        navbar.classList.add('navbar-container2');
        navbar.classList.remove('navbar-container1');
    } else {
        navbar.classList.remove('navbar-container2');
        navbar.classList.add('navbar-container1');
    }
    
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
}, false);
