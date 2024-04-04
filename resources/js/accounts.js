document.addEventListener('DOMContentLoaded', function () {
    const dropdownElements = document.querySelectorAll('#selectRole-div');
    const changedAccountsInfo = document.getElementById('changedAccountsInfo');

    const changedAccounts = [];

    dropdownElements.forEach(selectDiv => {
        selectDiv.addEventListener("click", function (event) {
            const accountEmail = selectDiv.getAttribute('data-account-email');
            const newRoles = [...selectDiv.querySelectorAll('[data-value]')].filter(option => option.classList.contains('selected')).map(option => option.getAttribute('data-value'));
            const oldRoles = JSON.parse(selectDiv.getAttribute('data-old-roles'));

            console.log(newRoles);

            const existingChangeIndex = changedAccounts.findIndex(account => account.email === accountEmail);

            if (existingChangeIndex !== -1) {
                changedAccounts[existingChangeIndex].newRoles = newRoles;
            } else {
                changedAccounts.push({
                    email: accountEmail,
                    oldRoles: oldRoles,
                    newRoles: newRoles
                });
            }

            updateChangedAccountsInfo();
        });
    });

    function updateChangedAccountsInfo() {
        let infoHtml = '';
        changedAccounts.forEach(account => {
            const oldRoles = account.oldRoles ? account.oldRoles.join(', ') : '';
            const newRoles = account.newRoles.join(', ');
            infoHtml += `<strong>${account.email}</strong>: ${oldRoles} ➔ ${newRoles}<br>`;
        });
        changedAccountsInfo.innerHTML = infoHtml;
    }

    const saveBtn = document.getElementById("saveBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const confirmModalBtn = document.getElementById("confirmModalBtn");
    const confirmModal = document.getElementById("confirmModal");

    saveBtn.addEventListener("click", function () {
        let hasChanges = false;
        dropdownElements.forEach(selectDiv => {
            const oldRoles = JSON.parse(selectDiv.getAttribute('data-old-roles'));
            const newRoles = [...selectDiv.querySelectorAll('[data-value]')].filter(option => option.classList.contains('selected')).map(option => option.getAttribute('data-value'));

            if (JSON.stringify(oldRoles) !== JSON.stringify(newRoles)) {
                hasChanges = true;
            }
        });

        if (!hasChanges) {
            window.location.href = "/warning-toast-accounts";
            return;
        }

        if (!adminRolePresent()) {
            console.log(!adminRolePresent());
            window.location.href = "/warning-toast-no-admins";
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

    function adminRolePresent() {
        let adminRoleFound = false;
        dropdownElements.forEach(selectDiv => {
            Array.from([...selectDiv.querySelectorAll('[data-value]')].filter(option => option.classList.contains('selected')).map(option => option.getAttribute('data-value'))).forEach(option => {
                if (option === "admin") {
                    adminRoleFound = true;
                }
            });
        });
        return adminRoleFound;
    }
});
