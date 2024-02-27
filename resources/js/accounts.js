document.addEventListener('DOMContentLoaded', function () {
    const dropdownElements = document.querySelectorAll('[data-account-email]');
    const changedAccountsInfo = document.getElementById('changedAccountsInfo');

    const changedAccounts = [];

    dropdownElements.forEach(select => {
        select.addEventListener('change', function () {
            const accountEmail = this.getAttribute('data-account-email');
            const originalRole = this.getAttribute('data-original-role');
            const newRole = this.value;

            const existingChangeIndex = changedAccounts.findIndex(account => account.email === accountEmail);

            if (existingChangeIndex !== -1) {
                changedAccounts[existingChangeIndex].newRole = newRole;
            } else {
                changedAccounts.push({
                    email: accountEmail,
                    originalRole: originalRole,
                    newRole: newRole
                });
            }

            updateChangedAccountsInfo();
        });
    });

    function updateChangedAccountsInfo() {
        let infoHtml = '';
        changedAccounts.forEach(account => {
            infoHtml += `<strong>${account.email}</strong>: ${account.originalRole} naar ${account.newRole}<br>`
        });
        changedAccountsInfo.innerHTML = infoHtml;
    }

    const saveBtn = document.getElementById("saveBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const confirmModalBtn = document.getElementById("confirmModalBtn");
    const confirmModal = document.getElementById("confirmModal");

    saveBtn.addEventListener("click", () => {
        confirmModal.classList.remove("hidden");
    });

    closeModalBtn.addEventListener("click", () => {
        confirmModal.classList.add("hidden");
    });

    confirmModalBtn.addEventListener("click", () => {
        confirmModal.classList.add("hidden");
        showToast();
    });

    function showToast() {
        const toast = document.getElementById("toast");

        toast.classList.remove("opacity-0");
        toast.classList.add("opacity-100");

        setTimeout(function () {
            toast.classList.remove("opacity-100");
            toast.classList.add("opacity-0");
        }, 3000);
    }

})
