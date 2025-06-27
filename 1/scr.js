document.addEventListener('DOMContentLoaded', () => {
    // 1. Défilement fluide pour la navigation
    document.querySelectorAll('.main-nav a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault(); // Empêche le comportement par défaut du lien

            const targetId = this.getAttribute('href'); // Récupère l'ID de la cible (ex: #accueil)
            const targetSection = document.querySelector(targetId);

            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 70, // Ajuste la position pour laisser de l'espace pour une éventuelle barre de navigation fixe
                    behavior: 'smooth' // Active le défilement fluide
                });
            }
        });
    });

    // 2. Animations d'apparition pour la galerie (au défilement)
    const galleryItems = document.querySelectorAll('.gallery-grid img');

    const observerOptions = {
        root: null, // La fenêtre d'affichage est la racine
        rootMargin: '0px',
        threshold: 0.3 // L'élément devient visible à 30%
    };

    const galleryObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Ajoute la classe 'active' pour déclencher l'animation CSS
                entry.target.classList.add('active');
                // Une fois animé, on peut arrêter d'observer pour cet élément
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    galleryItems.forEach(item => {
        galleryObserver.observe(item);
    });

    // 3. Validation de base des formulaires (exemple simple)
    const reservationForm = document.querySelector('.reservation-form');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche l'envoi du formulaire par défaut

            // Récupérer les valeurs des champs
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;
            const adults = parseInt(document.getElementById('adults').value);

            // Exemple de validation simple
            if (!checkin || !checkout || adults < 1) {
                alert("Veuillez remplir tous les champs obligatoires et assurer qu'il y a au moins 1 adulte.");
                return;
            }

            if (new Date(checkin) >= new Date(checkout)) {
                alert("La date de départ doit être postérieure à la date d'arrivée.");
                return;
            }

            // Si la validation passe, vous pouvez envoyer les données (ex: via fetch API à un backend)
            alert("Formulaire de réservation soumis ! (Ceci est une simulation)");
            console.log("Réservation soumise:", { checkin, checkout, adults, children: document.getElementById('children').value, roomType: document.getElementById('room-type').value });
            this.reset(); // Réinitialise le formulaire après soumission
        });
    }

    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche l'envoi du formulaire par défaut

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (!name || !email || !message) {
                alert("Veuillez remplir tous les champs du formulaire de contact.");
                return;
            }

            alert("Message envoyé ! (Ceci est une simulation)");
            console.log("Contact soumis:", { name, email, message });
            this.reset();
        });
    }
});