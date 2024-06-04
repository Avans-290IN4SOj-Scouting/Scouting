function showToast(type, message) {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'dismiss-toast';
    toastContainer.className = 'z-50 fixed bottom-0 end-0 m-6 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-md bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700';
    toastContainer.setAttribute('role', 'alert');

    const toast = document.createElement('div');
    toast.className = `toast-${type} flex p-4`;
    toastContainer.appendChild(toast);

    const boldText = document.createElement('span');
    boldText.className = 'font-bold';
    boldText.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} - `;
    toast.appendChild(boldText);

    const messageText = document.createElement('p');
    messageText.className = 'text-sm text-gray-700 dark:text-gray-400';
    messageText.textContent = message;
    toast.appendChild(messageText);

    const closeButtonContainer = document.createElement('div');
    closeButtonContainer.className = 'ms-auto';
    toast.appendChild(closeButtonContainer);

    const closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'inline-flex flex-shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white';
    closeButton.dataset.hsRemoveElement = '#dismiss-toast';
    closeButton.innerHTML = `
            <span class="sr-only">Close</span>
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
            </svg>
        `;
    closeButton.addEventListener('click', function () {
        toastContainer.classList.add('hs-removing');
        setTimeout(() => toastContainer.remove(), 300);
    });
    closeButtonContainer.appendChild(closeButton);

    document.body.appendChild(toastContainer);
}
