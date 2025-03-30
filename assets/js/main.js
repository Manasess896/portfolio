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
function flip(element) {
    element.classList.toggle('flip');
}

// Function to toggle accordion
function toggleAccordion(element) {
    // You can add accordion functionality here if needed
    const mainCon = element.nextElementSibling;
    if (mainCon.classList.contains('flip')) {
        mainCon.classList.remove('flip');
    }
}
