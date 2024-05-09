document.addEventListener('click', function (event) {

    const spanElement = event.target.querySelector('span');
    if (spanElement) {
        const observer = new MutationObserver(function (mutationsList, observer) {
            for (let mutation of mutationsList) {
                if (mutation.type === 'childList' && mutation.target === spanElement) {
                    const spanValue = spanElement.textContent.trim();

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'status';
                    hiddenInput.value = spanValue;
                    document.getElementById('statusform').appendChild(hiddenInput);

                    document.getElementById('statusform').submit();
                    observer.disconnect();
                }
            }
        });

        observer.observe(spanElement, {childList: true, subtree: true});
    }
});
