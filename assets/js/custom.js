const techTerms = [
  "Frontend Developer",
  "Backend Developer",
  "Fullstack Developer",
  "Web Designer",
  "SEO Specialist",
];
let currentTechIndex = 0;

// Particle Animation System
class ParticleSystem {
  constructor() {
    this.container = null;
    this.particles = [];
    this.init();
  }

  init() {
    this.createContainer();
    this.generateParticles();
    this.startAnimation();
  }

  createContainer() {
    this.container = document.createElement("div");
    this.container.className = "particles-container";
    document.body.appendChild(this.container);
  }

  generateParticles() {
    const particleCount = 25;

    for (let i = 0; i < particleCount; i++) {
      this.createParticle();
    }
  }

  createParticle() {
    const particle = document.createElement("div");
    particle.className = "particle";

    // Random size between 2px and 8px
    const size = Math.random() * 6 + 2;
    particle.style.width = size + "px";
    particle.style.height = size + "px";

    // Random starting position
    particle.style.left = Math.random() * 100 + "%";

    // Random animation delay
    particle.style.animationDelay = Math.random() * 8 + "s";

    // Random horizontal movement
    const horizontalMovement = (Math.random() - 0.5) * 100;
    particle.style.setProperty(
      "--horizontal-movement",
      horizontalMovement + "px"
    );

    this.container.appendChild(particle);
    this.particles.push(particle);
  }

  startAnimation() {
    // Continuously create new particles as old ones disappear
    setInterval(() => {
      // Remove old particles
      const oldParticles = this.particles.filter(
        (p) => !p.parentNode || p.getBoundingClientRect().top < -100
      );

      oldParticles.forEach((particle) => {
        if (particle.parentNode) {
          particle.remove();
        }
        const index = this.particles.indexOf(particle);
        if (index > -1) {
          this.particles.splice(index, 1);
        }
      });

      // Add new particles to maintain count
      while (this.particles.length < 25) {
        this.createParticle();
      }
    }, 1000);
  }
}

class HashRouter {
  constructor() {
    this.routes = {
      "": "home",
      home: "home",
      home: "home",
      about: "about",
      projects: "projects",
      "code-craft": "code-craft",
      contact: "contact",
    };

    this.init();
  }

  init() {
    window.addEventListener("hashchange", () => this.handleRoute());
    window.addEventListener("load", () => this.handleRoute());
  }

  getCurrentRoute() {
    const hash = window.location.hash.slice(1);
    const route = hash.startsWith("/") ? hash.slice(1) : hash;
    return this.routes[route] || "home";
  }

  setRoute(section) {
    const routeKey =
      Object.keys(this.routes).find((key) => this.routes[key] === section) ||
      section;
    window.location.hash = `/${routeKey}`;
  }

  handleRoute() {
    const targetSection = this.getCurrentRoute();
    if (window.scrollToSection) {
      window.scrollToSection(targetSection);
    }
  }
}
const router = new HashRouter();

function changeTechText() {
  const techChanger = document.getElementById("techChanger");
  if (techChanger) {
    techChanger.classList.add("slide-out");

    setTimeout(() => {
      currentTechIndex = (currentTechIndex + 1) % techTerms.length;
      techChanger.textContent = techTerms[currentTechIndex];
      techChanger.classList.remove("slide-out");
      techChanger.classList.add("slide-in");
      setTimeout(() => {
        techChanger.classList.remove("slide-in");
      }, 500);
    }, 250);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Initialize particle system
  const particleSystem = new ParticleSystem();

  const techChanger = document.getElementById("techChanger");
  if (techChanger) {
    techChanger.textContent = techTerms[0];
    setInterval(changeTechText, 3000);
  }

  const mainContainer = document.getElementById("main-container");
  const customNavItems = document.querySelectorAll(".mainnav .nav-item");
  const mobileNavLinks = document.querySelectorAll(".mobile-nav-link");
  const mobileMenuToggle = document.getElementById("mobileMenuToggle");
  const mobileMenuOverlay = document.getElementById("mobileMenuOverlay");
  const mobileMenuClose = document.getElementById("mobileMenuClose");
  const allSections = document.querySelectorAll(".scroll-section");

  let currentSectionIndex = 0;
  let isTransitioning = false;
  const sections = ["home", "about", "projects", "code-craft", "contact"];

  function isMobile() {
    return window.innerWidth <= 768;
  }

  function showSection(targetSection) {
    allSections.forEach((section) => {
      section.classList.remove("active");
    });

    const targetElement = document.getElementById(targetSection);
    if (targetElement) {
      targetElement.classList.add("active");
    }
  }

  function updateActiveNav(targetSection) {
    customNavItems.forEach((item) => {
      item.classList.remove("active");
    });

    const sectionIndex = sections.indexOf(targetSection);
    if (sectionIndex !== -1 && customNavItems[sectionIndex]) {
      customNavItems[sectionIndex].classList.add("active");
      currentSectionIndex = sectionIndex;
    }
    mobileNavLinks.forEach((link) => {
      link.classList.remove("active");
      if (link.getAttribute("href") === `#${targetSection}`) {
        link.classList.add("active");
      }
    });
  }
  function scrollToSection(targetSection) {
    if (isTransitioning) return;

    // Update URL hash
    router.setRoute(targetSection);

    if (isMobile()) {
      const targetElement = document.getElementById(targetSection);
      if (targetElement) {
        targetElement.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
        updateActiveNav(targetSection);
      }
    } else {
      isTransitioning = true;
      showSection(targetSection);
      updateActiveNav(targetSection);

      setTimeout(() => {
        isTransitioning = false;
      }, 800);
    }
  }
  function scrollToNext() {
    if (
      !isMobile() &&
      !isTransitioning &&
      currentSectionIndex < sections.length - 1
    ) {
      scrollToSection(sections[currentSectionIndex + 1]);
    }
  }

  function scrollToPrev() {
    if (!isMobile() && !isTransitioning && currentSectionIndex > 0) {
      scrollToSection(sections[currentSectionIndex - 1]);
    }
  }

  function openMobileMenu() {
    if (mobileMenuOverlay) {
      mobileMenuOverlay.classList.add("active");
      document.body.style.overflow = "hidden";
    }
  }

  function closeMobileMenu() {
    if (mobileMenuOverlay) {
      mobileMenuOverlay.classList.remove("active");
      document.body.style.overflow = isMobile() ? "auto" : "hidden";
    }
  }
  if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener("click", openMobileMenu);
  }

  if (mobileMenuClose) {
    mobileMenuClose.addEventListener("click", closeMobileMenu);
  }
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener("click", function (e) {
      if (e.target === mobileMenuOverlay) {
        closeMobileMenu();
      }
    });
  }
  function handleNavClick(e) {
    e.preventDefault();
    const targetSection = e.target.getAttribute("href").substring(1);
    scrollToSection(targetSection);
    if (mobileMenuOverlay && mobileMenuOverlay.classList.contains("active")) {
      setTimeout(() => {
        closeMobileMenu();
      }, 100);
    }
  }
  mobileNavLinks.forEach((link) => {
    link.addEventListener("click", handleNavClick);
  });
  function onWheel(e) {
    if (isMobile() || isTransitioning) return;

    e.preventDefault();
    const delta = e.deltaY || e.detail || e.wheelDelta;

    if (delta > 0) {
      scrollToNext();
    } else if (delta < 0) {
      scrollToPrev();
    }
  }
  let startX = 0;
  let startY = 0;

  mainContainer.addEventListener(
    "touchstart",
    function (e) {
      if (!isMobile()) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
      }
    },
    { passive: true }
  );

  mainContainer.addEventListener(
    "touchend",
    function (e) {
      if (isMobile() || isTransitioning) return;

      const endX = e.changedTouches[0].clientX;
      const endY = e.changedTouches[0].clientY;
      const diffX = startX - endX;
      const diffY = startY - endY;

      if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
        if (diffX > 0) {
          scrollToNext();
        } else {
          scrollToPrev();
        }
      }
    },
    { passive: true }
  );
  document.addEventListener("keydown", function (e) {
    if (!isMobile()) {
      switch (e.key) {
        case "ArrowRight":
        case "ArrowDown":
          e.preventDefault();
          scrollToNext();
          break;
        case "ArrowLeft":
        case "ArrowUp":
          e.preventDefault();
          scrollToPrev();
          break;
      }
    }
  });
  window.addEventListener("resize", function () {
    if (isMobile()) {
      allSections.forEach((section) => {
        section.classList.remove("active");
        section.style.position = "relative";
        section.style.opacity = "1";
        section.style.visibility = "visible";
      });
      document.body.style.overflow = "auto";
      if (mobileMenuOverlay && mobileMenuOverlay.classList.contains("active")) {
        closeMobileMenu();
      }
    } else {
      allSections.forEach((section) => {
        section.classList.remove("active");
        section.style.position = "absolute";
        section.style.opacity = "0";
        section.style.visibility = "hidden";
      });
      showSection(sections[currentSectionIndex]);
      document.body.style.overflow = "hidden";
    }
  });
  if (window.IntersectionObserver) {
    const observerOptions = {
      root: null,
      rootMargin: "-50% 0px -50% 0px",
      threshold: 0,
    };

    const observer = new IntersectionObserver(function (entries) {
      if (isMobile()) {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const sectionId = entry.target.id;
            updateActiveNav(sectionId);
          }
        });
      }
    }, observerOptions);
    sections.forEach((sectionId) => {
      const element = document.getElementById(sectionId);
      if (element) {
        observer.observe(element);
      }
    });
  }
  if (mainContainer) {
    mainContainer.addEventListener("wheel", onWheel, { passive: false });
  }
  document.addEventListener("wheel", onWheel, { passive: false });
  if (isMobile()) {
    allSections.forEach((section) => {
      section.classList.remove("active");
      section.style.position = "relative";
      section.style.opacity = "1";
      section.style.visibility = "visible";
    });
    document.body.style.overflow = "auto";
  } else {
    document.body.style.overflow = "hidden";
    // Check if there's a hash route, otherwise show home
    const initialSection = router.getCurrentRoute();
    showSection(initialSection);
    updateActiveNav(initialSection);
  }

  if (!window.location.hash) {
    router.setRoute("home");
  }
});
window.scrollToSection = function (targetSection) {
  const sections = ["home", "about", "projects", "code-craft", "contact"];

  function isMobile() {
    return window.innerWidth <= 768;
  }

  function showSection(targetSection) {
    const allSections = document.querySelectorAll(".scroll-section");
    allSections.forEach((section) => {
      section.classList.remove("active");
    });

    const targetElement = document.getElementById(targetSection);
    if (targetElement) {
      targetElement.classList.add("active");
    }
  }

  function updateActiveNav(targetSection) {
    const customNavItems = document.querySelectorAll(".mainnav .nav-item");
    customNavItems.forEach((item) => {
      item.classList.remove("active");
    });

    const sectionIndex = sections.indexOf(targetSection);
    if (sectionIndex !== -1 && customNavItems[sectionIndex]) {
      customNavItems[sectionIndex].classList.add("active");
    }

    // Update mobile nav active state
    const mobileNavLinks = document.querySelectorAll(".mobile-nav-link");
    mobileNavLinks.forEach((link) => {
      link.classList.remove("active");
      if (link.getAttribute("href") === `#${targetSection}`) {
        link.classList.add("active");
      }
    });
  }

  if (isMobile()) {
    const targetElement = document.getElementById(targetSection);
    if (targetElement) {
      targetElement.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
      updateActiveNav(targetSection);
    }
  } else {
    showSection(targetSection);
    updateActiveNav(targetSection);
  }
};
function submitForm(event) {
  event.preventDefault();

  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const message = document.getElementById("message").value;

  if (!name || !email || !message) {
    alert("Please fill in all fields");
    return;
  }
  const subject = encodeURIComponent(`Contact from ${name}`);
  const body = encodeURIComponent(
    `Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`
  );
  const mailtoLink = `mailto:manasesotieno@gmail.com?subject=${subject}&body=${body}`;
  window.location.href = mailtoLink;
  document.getElementById("contactForm").reset();
  alert("Thank you for your message! Your email client should open now.");
}
