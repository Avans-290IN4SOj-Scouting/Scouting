function createToast(text, type) {
    const toast = document.createElement('div');
    toast.classList.add('norefresh-toast');
    toast.classList.add(type);

    const textElement = document.createElement('p');
    textElement.textContent = text;

    toast.appendChild(textElement);

    const container = document.querySelector('.norefresh-toast-container');
    container.appendChild(toast);

    setTimeout(() => {
        const intervalId = setInterval(() => {
            const currentOpacity = parseFloat(toast.style.opacity) || 1;
            toast.style.opacity = currentOpacity - 0.01;

            if (currentOpacity <= 0.05) {
                toast.remove();
                clearInterval(intervalId);
            }
        }, 8);
    }, 5000);
}
