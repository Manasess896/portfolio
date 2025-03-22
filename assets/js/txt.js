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
    }, typingSpeed);});