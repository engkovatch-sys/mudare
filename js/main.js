// ===== Espaço Máxima — scripts =====

// Mark JS as enabled so scroll-reveal styles apply (graceful degradation without JS)
document.documentElement.classList.add('js');

// Mobile menu toggle
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('.nav-menu');

if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        menuToggle.classList.toggle('active');
        const open = navMenu.classList.contains('active');
        const spans = menuToggle.querySelectorAll('span');
        spans[0].style.transform = open ? 'rotate(45deg) translate(5px, 5px)' : 'none';
        spans[1].style.opacity = open ? '0' : '1';
        spans[2].style.transform = open ? 'rotate(-45deg) translate(6px, -6px)' : 'none';
    });

    // Close menu when a normal link is tapped (mobile)
    navMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 680 && !link.parentElement.classList.contains('has-dropdown')) {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    });
}

// Reveal on scroll
const revealEls = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window && revealEls.length) {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    revealEls.forEach(el => obs.observe(el));
} else {
    revealEls.forEach(el => el.classList.add('visible'));
}

// Contact form -> opens WhatsApp with the message pre-filled (no backend needed)
const form = document.querySelector('.contact-form');
if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nome = form.querySelector('[name="nome"]')?.value.trim() || '';
        const servico = form.querySelector('[name="servico"]')?.value.trim() || '';
        const msg = form.querySelector('[name="mensagem"]')?.value.trim() || '';
        const texto = encodeURIComponent(
            `Olá! Meu nome é ${nome}. Tenho interesse em: ${servico}. ${msg}`
        );
        window.open(`https://wa.me/5511950218191?text=${texto}`, '_blank');
        form.reset();
    });
}
