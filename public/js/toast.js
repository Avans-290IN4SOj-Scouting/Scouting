function createToast(text, type) {
    const toastContainer = document.createElement('div');
    toastContainer.classList.add('.norefresh-toast');

    const toastHTML =
    `
    <div id="dismiss-toast" class="absolute bottom-0 end-0 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700" role="alert"
            style="margin-right: 1rem; margin-bottom: 1rem;">
        <div class="flex p-4">
            <p class="text-sm text-gray-700 dark:text-gray-400">${text}</p>
        </div>
    </div>
    `;
    toastContainer.innerHTML = toastHTML;
    document.body.appendChild(toastContainer);

    setTimeout(() => {
        const intervalId = setInterval(() => {
            const currentOpacity = parseFloat(toastContainer.style.opacity) || 1;
            toastContainer.style.opacity = currentOpacity - 0.01;

            if (currentOpacity <= 0.05) {
                toastContainer.remove();
                clearInterval(intervalId);
            }
        }, 8);
    }, 4000);
}
