function opennavbar() {
    const navbar = document.getElementById('navbar');
    navbar.style.height = '100%';
    
}
function closenavbar() {
    const navbar = document.getElementById('navbar');
    navbar.style.height = '0%';
}

document.addEventListener('DOMContentLoaded', () => {
    const content = "Hello there ,\n am manases a front-end developer from kenya ";

    let index = 0;
    const typingSpeed = 100; // Adjust typing speed in milliseconds
    const interval = setInterval(() => {
        document.getElementById('intro-text').textContent += content[index];
        index++;
        if (index === content.length) {
            clearInterval(interval);
        }
    }, typingSpeed);

    // Initialize the "about me" section
    openaboutme();

    // Add event listeners for the accordion functionality
    const scontElements = document.querySelectorAll('.scont');
    scontElements.forEach(scont => {
        scont.addEventListener('click', () => {
            const content = scont.nextElementSibling;
            if (content.style.display === 'block') {
                content.style.display = 'none';
            } else {
                content.style.display = 'block';
            }
        });
    });

    // Add event listeners for navbar buttons
    document.getElementById('navbtn-home').addEventListener('click', () => {
        document.getElementById('home').scrollIntoView({ behavior: 'smooth' });
    });
    document.getElementById('navbtn-about').addEventListener('click', () => {
        document.getElementById('about').scrollIntoView({ behavior: 'smooth' });
    });
    document.getElementById('navbtn-projects').addEventListener('click', () => {
        document.getElementById('projects').scrollIntoView({ behavior: 'smooth' });
    });
    document.getElementById('navbtn-contact').addEventListener('click', () => {
        document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
    });

    // Initialize theme toggling functionality
    const toggleButton = document.getElementById('theme-toggle');
    toggleButton.addEventListener('click', changetheme);

    // Back to top button functionality
    const backToTopButton = document.createElement('button');
    backToTopButton.classList.add('back-to-top');
    backToTopButton.innerHTML = `
        <svg class="progress-circle" width="50" height="50" viewBox="0 0 36 36">
            <circle class="progress-bg" cx="18" cy="18" r="15.915" fill="none" stroke="#e6e6e6" stroke-width="4"/>
            <circle class="progress" cx="18" cy="18" r="15.915" fill="none" stroke="rgb(248, 0, 0)" stroke-width="4" stroke-dasharray="100" stroke-dashoffset="100"/>
        </svg>
        <i class="fa fa-arrow-up"></i>
    `;
    document.body.appendChild(backToTopButton);

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = (scrollTop / docHeight) * 100;
        setProgress(progress);

        if (scrollTop > 100) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });
});

function openaboutme() {
    activateSection('about-me');
    moveStatusBar(document.getElementById('about-me-btn'));
}

function openeducation() {
    activateSection('education');
    moveStatusBar(document.getElementById('edu-btn'));
}

function openskills() {
    activateSection('skills');
    moveStatusBar(document.getElementById('skill-btn'));
}

function activateSection(sectionId) {
    const sections = document.querySelectorAll('.aboutme');
    sections.forEach(section => section.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
}

function moveStatusBar(activeButton) {
    const bar = document.getElementById('bar');
    bar.style.width = `${activeButton.offsetWidth}px`;
    bar.style.marginLeft = `${activeButton.offsetLeft}px`;
}

// Function to flip project cards
function flip(card) {
    card.classList.toggle('flip');
}

// Function to toggle accordion
function toggleAccordion(title) {
    title.classList.toggle('active');
    const mainCon = title.nextElementSibling;
    if (mainCon.style.display === 'block') {
        mainCon.style.display = 'none';
    } else {
        mainCon.style.display = 'block';
    }
}

// JavaScript to handle theme toggling
function changetheme() {
    const body = document.body;
    const toggleButton = document.getElementById('theme-toggle');
    if (body.classList.contains('light')) {
        body.classList.replace('light', 'dark');
        toggleButton.classList.replace('fa-sun', 'fa-moon');
      
    } else {
        body.classList.replace('dark', 'light');
        toggleButton.classList.replace('fa-moon', 'fa-sun');
        
    }
}
// JavaScript to handle theme toggling 2
function theme() {
    const body = document.body;
    const toggleButton = document.getElementById('theme');
    if (body.classList.contains('light')) {
        body.classList.replace('light', 'dark');
        toggleButton.classList.replace('fa-sun', 'fa-moon');
      
    } else {
        body.classList.replace('dark', 'light');
        toggleButton.classList.replace('fa-moon', 'fa-sun');
        
    }
}

function setProgress(percent) {
    const circle = document.querySelector('.progress');
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    const offset = circumference - (percent / 100) * circumference;
    circle.style.strokeDashoffset = offset;
}


