function setProgress(percent) {
    const circle = document.querySelector('.progress');
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    const offset = circumference - (percent / 100) * circumference;
    circle.style.strokeDashoffset = offset;
}
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