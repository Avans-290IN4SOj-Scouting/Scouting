document.addEventListener('DOMContentLoaded', function () {
    const accordionContents = document.querySelectorAll('.hs-accordion-content');

    accordionContents.forEach(function (content) {
        content.classList.add('hidden');
    });
});
