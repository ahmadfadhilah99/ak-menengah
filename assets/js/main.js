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


document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
});



const whatsappButton = document.querySelector('.whatsapp-button');
const whatsappIcon = document.querySelector('.whatsapp-icon');

// Animasi muncul setelah scroll
window.addEventListener('scroll', () => {
  if (window.scrollY > 300) {
    whatsappIcon.style.animation = 'float 2s ease-in-out infinite';
  }
});

// Efek klik pada kontak
document.querySelectorAll('.whatsapp-contact').forEach(contact => {
  contact.addEventListener('click', function() {
    // Tambahkan efek ripple atau highlight saat diklik
    this.style.backgroundColor = '#e0e0e0';
    setTimeout(() => {
      this.style.backgroundColor = '';
    }, 200);
  });
});

// Tambahkan deteksi klik di luar untuk menutup dropdown (opsional)
document.addEventListener('click', (e) => {
  if (!whatsappButton.contains(e.target)) {
    whatsappButton.querySelector('.whatsapp-dropdown').style.visibility = 'hidden';
  }
});