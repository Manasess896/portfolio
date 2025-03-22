

    // Add event listeners for navbar buttons
    document.getElementById('navbtn-home').addEventListener('click', () => {
        document.getElementById('home').scrollIntoView({ behavior: 'smooth' });
    });
    document.getElementById('navbtn-about').addEventListener('click', () => {
        document.getElementById('aboutme').scrollIntoView({ behavior: 'smooth' });
    });
    document.getElementById('navbtn-projects').addEventListener('click', () => {
        document.getElementById('my-projects').scrollIntoView({ behavior: 'smooth' });
    });
    document.getElementById('navbtn-contact').addEventListener('click', () => {
        document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
    });






    
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
