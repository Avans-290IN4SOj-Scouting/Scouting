document.addEventListener('DOMContentLoaded', function () {
    const dropdownElements = document.querySelectorAll('[data-account-email]');
    const changedAccountsInfo = document.getElementById('changedAccountsInfo');

    const changedAccounts = [];

    dropdownElements.forEach(select => {
        select.addEventListener('change', function () {
            const accountEmail = this.getAttribute('data-account-email');
            const oldRole = this.getAttribute('data-old-role');
            const newRole = this.value;

            const existingChangeIndex = changedAccounts.findIndex(account => account.email === accountEmail);

            if (existingChangeIndex !== -1) {
                if (oldRole === newRole) {
                    changedAccounts.splice(existingChangeIndex, 1);
                } else {
                    changedAccounts[existingChangeIndex].newRole = newRole;
                }
            } else {
                changedAccounts.push({
                    email: accountEmail,
                    oldRole: oldRole,
                    newRole: newRole
                });
            }

            updateChangedAccountsInfo();
        });
    });

    function updateChangedAccountsInfo() {
        let infoHtml = '';
        changedAccounts.forEach(account => {
            infoHtml += `<strong>${account.email}</strong>: ${account.oldRole} ➔ ${account.newRole}<br>`
        });
        changedAccountsInfo.innerHTML = infoHtml;
    }

    const saveBtn = document.getElementById("saveBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const confirmModalBtn = document.getElementById("confirmModalBtn");
    const confirmModal = document.getElementById("confirmModal");

    saveBtn.addEventListener("click", function () {
        if (!(Array.isArray(changedAccounts) && changedAccounts.length)) {
            window.location.href = "/warning-toast-accounts";
            return;
        }
        confirmModal.classList.remove("hidden");
    });

    closeModalBtn.addEventListener("click", () => {
        confirmModal.classList.add("hidden");
    });

    confirmModalBtn.addEventListener("click", () => {
        submitForm();
        confirmModal.classList.add("hidden");
    });

    function submitForm() {
        document.getElementById("userRoles").value = JSON.stringify(changedAccounts);

        document.getElementById("updateRoleForm").submit();
    }
});

