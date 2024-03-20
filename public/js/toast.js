const timeUntilFade = 4000;
const fadeInterval = 8;
const removeAtOpacity = 0.05;
const maxOpacity = 1;
const removePerInterval = 0.01;

function createToast(text, type) {
    const toastContainer = document.createElement('div');
    toastContainer.classList.add('.norefresh-toast');

    let toastBackgroundColorStyle = '';
    switch (type)
    {
        case 'success':
            toastBackgroundColorStyle = 'max-w-xs bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500';
            break;
        case 'error':
            toastBackgroundColorStyle = 'max-w-xs bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg dark:bg-red-800/10 dark:border-red-900 dark:text-red-500';
            break;
        case 'warning':
            toastBackgroundColorStyle = 'max-w-xs bg-yellow-100 border border-yellow-200 text-sm text-yellow-800 rounded-lg dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500';
            break;
        default:
            toastBackgroundColorStyle = 'max-w-xs bg-gray-100 border border-gray-200 text-sm text-gray-800 rounded-lg dark:bg-white/10 dark:border-white/20 dark:text-white';
            break;
    }

    const toastHTML =
    `
    <div class="absolute bottom-0 end-0" style="margin: 1rem;">
        <div class="${toastBackgroundColorStyle}" role="alert">
            <div class="flex p-4">
                ${text}
            </div>
        </div>
    </div>
    `;

    toastContainer.innerHTML = toastHTML;
    let toast = toastContainer.firstElementChild;
    document.body.appendChild(toast);

    setTimeout(() => {
        const intervalId = setInterval(() => {
            const currentOpacity = parseFloat(toast.style.opacity) || maxOpacity;
            toast.style.opacity = currentOpacity - removePerInterval;

            if (currentOpacity <= removeAtOpacity) {
                toast.remove();
                clearInterval(intervalId);
            }
        }, fadeInterval);
    }, timeUntilFade);
}
