let activeButton = document.getElementById("about-me-btn");
let statusBar = document.getElementById("bar");

function openaboutme() {
    setActiveButton("about-me-btn");
    moveStatusBar("about-me-btn");
    showContent("about-me");
}

function openeducation() {
    setActiveButton("edu-btn");
    moveStatusBar("edu-btn");
    showContent("education");
}

function openskills() {
    setActiveButton("skill-btn");
    moveStatusBar("skill-btn");
    showContent("skills");
}

function setActiveButton(buttonId) {
    if (activeButton) {
        activeButton.classList.remove("active");
    }
    activeButton = document.getElementById(buttonId);
    activeButton.classList.add("active");
}

function moveStatusBar(buttonId) {
    const button = document.getElementById(buttonId);
    const buttonRect = button.getBoundingClientRect();
    const containerRect = document.querySelector(".main-title").getBoundingClientRect();
    const offset = buttonRect.left - containerRect.left;
    const width = buttonRect.width;

    statusBar.style.width = `${width}px`;
    statusBar.style.transform = `translateX(${offset}px)`;
}

function showContent(contentId) {
    const contents = document.querySelectorAll(".aboutme");
    contents.forEach(content => content.classList.remove("active"));
    document.getElementById(contentId).classList.add("active");
    contents.style.color = "yellow";
}

// Initialize the first button as active
window.onload = () => {
    openaboutme();
};