document.addEventListener('DOMContentLoaded', function () {
    collapseAllAccordions();
    hideHr();
});

function collapseAllAccordions() {
    const accordionContents = document.querySelectorAll('.hs-accordion-content');

    accordionContents.forEach(function (content) {
        content.classList.add('hidden');
    });
}

function hideHr() {
    const accordionButtons = document.querySelectorAll('.hs-accordion-toggle');

    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const hrElement = button.nextElementSibling;

            if (hrElement && hrElement.classList.contains('border-gray-200')) {
                hrElement.classList.toggle('hidden');
            }
        });
    });
}

function toggleAccordion(button) {
    const isOpen = button.getAttribute('data-open') === 'true';
    const allButtons = document.querySelectorAll('.hs-accordion-toggle');

    allButtons.forEach(otherButton => {
        if (otherButton !== button) {
            otherButton.setAttribute('data-open', 'false');
            const firstSvg = otherButton.querySelector('svg:first-child');
            const secondSvg = otherButton.querySelector('svg:last-child');
            firstSvg.classList.remove('hidden');
            secondSvg.classList.add('hidden');
        }
    });

    button.setAttribute('data-open', String(!isOpen));
    const firstSvg = button.querySelector('svg:first-child');
    const secondSvg = button.querySelector('svg:last-child');

    if (isOpen) {
        firstSvg.classList.remove('hidden');
        secondSvg.classList.add('hidden');
    } else {
        firstSvg.classList.add('hidden');
        secondSvg.classList.remove('hidden');
    }
}
