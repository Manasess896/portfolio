// Custom JavaScript for Manases' Portfolio

(function() {
    "use strict";

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 74, // Adjust this value if your navbar height changes
        });
    }

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Collapse responsive navbar when a toggler is visible and a nav-link is clicked
    const navLinks = document.querySelectorAll('.nav-link');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(navLinks);
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Typed.js initialization (Hero Text Animation)
    if (document.getElementById('intro-text')) {
        var typed = new Typed('#intro-text', {
            strings: ['A Passionate Web Developer.', 'Frontend Specialist.', 'Building Cool Things Online.', 'Turning Ideas into Reality.'],
            typeSpeed: 60,
            backSpeed: 30,
            loop: true,
            smartBackspace: true, // Default
            showCursor: true,
            cursorChar: '|',
            autoInsertCss: true
        });
    }

    // Set current year in footer
    const currentYearSpan = document.getElementById('currentYear');
    if (currentYearSpan) {
        currentYearSpan.textContent = new Date().getFullYear();
    }

    // Bootstrap form validation (from your original HTML)
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Simple fade-in animation on scroll
    const fadeInElements = document.querySelectorAll('.fade-in');
    const observerOptions = {
        root: null, // relative to document viewport 
        rootMargin: '0px',
        threshold: 0.1 // 10% of item has to be visible to trigger
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // observer.unobserve(entry.target); // Optional: stop observing once animated
            }
        });
    }, observerOptions);

    fadeInElements.forEach(el => {
        observer.observe(el);
    });

    // Add .fade-in class to sections you want to animate
    // Example: document.querySelectorAll('section').forEach(sec => sec.classList.add('fade-in'));
    // For more targeted animations, add the class directly in your HTML or here:
    const sectionsToAnimate = ['#aboutme', '#my-projects', '#contact'];
    sectionsToAnimate.forEach(selector => {
        const section = document.querySelector(selector);
        if (section) {
            section.classList.add('fade-in');
        }
    });
    
    // Add fade-in to project cards for a staggered effect if desired
    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach((card, index) => {
        card.classList.add('fade-in');
        card.style.transitionDelay = `${index * 0.1}s`; // Stagger the animation
    });

    // Back to top button functionality (if you add the HTML for it)
    const backToTopButton = document.querySelector(".back-to-top");
    if (backToTopButton) {
        window.addEventListener("scroll", () => {
            if (window.pageYOffset > 300) { // Show button after 300px of scroll
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        });
        backToTopButton.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }

})();
