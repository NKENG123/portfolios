document.addEventListener('DOMContentLoaded', () => {
    // --- Sélection des éléments DOM ---
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');
    const heroBackground = document.querySelector('.hero-background');
    const animElements = document.querySelectorAll('.anim-element'); // Éléments avec animations d'apparition
    const themeToggle = document.getElementById('checkbox'); // Le bouton du switch de thème
    const body = document.body; // Le corps du document pour changer les classes de thème

    // --- 1. Gestion du mode sombre/clair ---
    // Charge la préférence de l'utilisateur depuis le stockage local (localStorage)
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        body.classList.add(savedTheme); // Applique la classe enregistrée
        // Ajuste l'état du switch si le mode enregistré est 'light-mode'
        if (savedTheme === 'light-mode') {
            themeToggle.checked = false;
        } else {
            themeToggle.checked = true; // S'assure que le switch est coché pour 'dark-mode'
        }
    } else {
        // Si aucune préférence n'est enregistrée, utilise 'dark-mode' par défaut
        body.classList.add('dark-mode');
        themeToggle.checked = true; // S'assure que le switch est coché
    }

    // Ajoute un écouteur d'événement pour le changement d'état du switch
    if (themeToggle) {
        themeToggle.addEventListener('change', () => {
            if (body.classList.contains('dark-mode')) {
                // Si actuellement en mode sombre, passe en mode clair
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                localStorage.setItem('theme', 'light-mode'); // Enregistre la préférence
            } else {
                // Si actuellement en mode clair, passe en mode sombre
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark-mode'); // Enregistre la préférence
            }
        });
    }

    // --- 2. Animations au chargement de la page ---
    // Animation du fond de la section d'accueil (retardée pour un meilleur effet)
    setTimeout(() => {
        if (heroBackground) {
            heroBackground.style.opacity = 1;
        }
    }, 200);

    // Animation des éléments `anim-element` avec un délai basé sur leur position
    animElements.forEach((element, index) => {
        const dataDelay = parseFloat(element.dataset.delay) || 0; // Récupère le délai du HTML
        setTimeout(() => {
            element.style.opacity = 1;
            element.style.transform = 'translateY(0)';
        }, 300 * index + 800 + (dataDelay * 1000)); // Calcul du délai total
    });

    // --- 3. Fonctionnalité du menu Burger pour mobile ---
    if (burger && nav && navLinks) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('nav-active'); // Active/désactive le menu
            // Anime les liens de navigation un par un
            navLinks.forEach((link, index) => {
                if (link.style.animation) {
                    link.style.animation = ''; // Réinitialise l'animation si déjà appliquée
                } else {
                    link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
                }
            });
            burger.classList.toggle('toggle'); // Anime l'icône du burger
        });

        // Ferme le menu quand un lien de navigation est cliqué
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (nav.classList.contains('nav-active')) {
                    nav.classList.remove('nav-active');
                    burger.classList.remove('toggle');
                    navLinks.forEach(item => item.style.animation = ''); // Supprime les animations
                }
            });
        });
    }

    // --- 4. Défilement fluide (Smooth Scroll) et activation des liens de navigation ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        // Exclut le bouton flottant WhatsApp et les autres boutons si non destinés au smooth scroll
        if (anchor.classList.contains('floating-contact-btn') || (anchor.classList.contains('btn') && !anchor.classList.contains('smooth-scroll'))) {
            return;
        }
        
        anchor.addEventListener('click', function (e) {
            e.preventDefault(); // Empêche le comportement par défaut du lien

            // Désactive la classe 'active' de tous les liens de navigation
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.classList.remove('active');
            });

            this.classList.add('active'); // Ajoute la classe 'active' au lien cliqué

            // Ferme le menu mobile si ouvert
            if (nav.classList.contains('nav-active')) {
                nav.classList.remove('nav-active');
                burger.classList.remove('toggle');
                navLinks.forEach(item => item.style.animation = '');
            }

            const targetId = this.getAttribute('href'); // Récupère l'ID de la section cible
            const targetElement = document.querySelector(targetId); // Sélectionne la section

            if (targetElement) {
                const headerOffset = document.querySelector('.navbar').offsetHeight; // Hauteur de la navbar fixe
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - headerOffset; // Position ajustée

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth' // Défilement fluide
                });
            }
        });
    });

    // 5. Met à jour la classe 'active' des liens de navigation pendant le défilement
    const sections = document.querySelectorAll('section');
    const observerOptions = {
        root: null, // L'élément racine est le viewport
        rootMargin: '-50% 0px -49% 0px', // Déclenche quand le milieu de la section est visible
        threshold: 0 // Seuil de visibilité
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const currentSectionId = entry.target.id;
                document.querySelectorAll('.nav-links a').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentSectionId}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    // Observe chaque section
    sections.forEach(section => {
        sectionObserver.observe(section);
    });

    // --- 6. Logique pour les barres de compétences horizontales ---
    const skillCategories = document.querySelectorAll('.skill-category');

    const skillObserverOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5 // Déclenche l'animation quand 50% de la catégorie est visible
    };

    const skillObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const skillBars = entry.target.querySelectorAll('.skill-bar');
                skillBars.forEach(bar => {
                    const level = bar.dataset.level; // Récupère le niveau de compétence du data-attribute
                    bar.style.width = `${level}%`; // Applique la largeur pour l'animation
                });
                observer.unobserve(entry.target); // Arrête d'observer une fois l'animation déclenchée
            }
        });
    }, skillObserverOptions);

    skillCategories.forEach(category => {
        skillObserver.observe(category);
    });

    // --- 7. Logique pour les images de la philosophie avec transitions ---
    const philosophyImagesContainer = document.querySelector('.philosophy-images-container');
    if (philosophyImagesContainer) {
        const philosophyImages = philosophyImagesContainer.querySelectorAll('img');
        let currentImageIndex = 0;

        // Fonction pour changer l'image active
        function changePhilosophyImage() {
            // Masque l'image actuellement active
            philosophyImages[currentImageIndex].classList.remove('philosophy-active-image');
            philosophyImages[currentImageIndex].classList.add('philosophy-image-hidden'); // Ajoute la classe cachée

            // Passe à l'image suivante (boucle)
            currentImageIndex = (currentImageIndex + 1) % philosophyImages.length;

            // Affiche la nouvelle image active
            philosophyImages[currentImageIndex].classList.remove('philosophy-image-hidden'); // Supprime la classe cachée
            philosophyImages[currentImageIndex].classList.add('philosophy-active-image');
        }

        // S'assure que la première image est visible au départ
        if (philosophyImages.length > 0) {
            philosophyImages[0].classList.add('philosophy-active-image');
        }

        // Démarrer le carrousel d'images après un délai initial
        setTimeout(() => {
             setInterval(changePhilosophyImage, 3000); // Change d'image toutes les 3 secondes
        }, 1000); // Délai d'une seconde avant de commencer le carrousel
    }

    // --- 8. Logique du Formulaire de Contact ---
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche l'envoi traditionnel du formulaire

            // Récupère et nettoie les valeurs des champs
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            // Validation simple côté client
            if (!name || !email || !message) {
                displayMessage("Veuillez remplir tous les champs obligatoires.", 'error');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                displayMessage("Veuillez entrer une adresse email valide.", 'error');
                return;
            }
            
            // Si la validation est réussie, simule l'envoi du formulaire
            console.log('Formulaire envoyé avec succès (validation client OK):', { name, email, message });
            
            displayMessage("Message envoyé avec succès !", 'success');
            contactForm.reset(); // Réinitialise le formulaire
        });
    }

    // --- Fonction utilitaire pour afficher un message (remplace alert()) ---
    function displayMessage(msg, type) {
        const messageBox = document.createElement('div');
        messageBox.textContent = msg;
        messageBox.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            border-radius: 8px;
            font-family: 'Open Sans', sans-serif;
            font-size: 1.1em;
            color: #fff;
            z-index: 2000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        `;

        if (type === 'success') {
            messageBox.style.backgroundColor = '#28a745'; // Vert pour le succès
        } else if (type === 'error') {
            messageBox.style.backgroundColor = '#dc3545'; // Rouge pour l'erreur
        } else {
            messageBox.style.backgroundColor = '#007bff'; // Bleu par défaut
        }

        document.body.appendChild(messageBox); // Ajoute le message au DOM

        // Anime l'apparition du message
        setTimeout(() => {
            messageBox.style.opacity = 1;
        }, 100);

        // Fait disparaître le message après 3 secondes
        setTimeout(() => {
            messageBox.style.opacity = 0;
            messageBox.addEventListener('transitionend', () => messageBox.remove()); // Supprime le message après la transition
        }, 3000);
    }
});