
document.querySelectorAll('.accordion-header').forEach(function(element) {
    element.addEventListener('click', function () {
        const toggledOnParent = element.parentElement.classList.toggle('active');
        const toggledOn = element.classList.toggle('active');
    });
});
