const timeUntilFade = 4000;
const fadeInterval = 8;
const removeAtOpacity = 0.05;
const maxOpacity = 1;
const removePerInterval = 0.01;

function createToast(text, type) {
    const toastContainer = document.createElement('div');
    toastContainer.classList.add('.norefresh-toast');

    let toastTypeClass = '';
    switch (type)
    {
        case 'success':
            toastTypeClass = 'toast-success';
            break;
        case 'error':
            toastTypeClass =  'toast-error';
            break;
        case 'warning':
            toastTypeClass =  'toast-warning';
            break;
        default:
            toastTypeClass =  'toast-info';
            break;
    }

    const toastHTML =
    `
    <div class="absolute bottom-0 end-0" style="margin: 1rem;">
        <div class="${toastTypeClass}" role="alert">
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
