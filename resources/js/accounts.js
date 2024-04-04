document.addEventListener('DOMContentLoaded', function () {
    const dropdownElements = document.querySelectorAll('#selectRole');
    const changedAccountsInfo = document.getElementById('changedAccountsInfo');

    const changedAccounts = [];

    dropdownElements.forEach(select => {
        select.addEventListener("input", function(event){
            const accountEmail = select.getAttribute('data-account-email');
            const newRoles = [...select.selectedOptions].map(option => option.value);
            const oldRoles = JSON.parse(select.getAttribute('data-old-roles'));

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
            const oldRoles = account.oldRoles.join(', ');
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
        dropdownElements.forEach(select => {
            const oldRoles = JSON.parse(select.getAttribute('data-old-roles'));
            const newRoles = [...select.selectedOptions].map(option => option.value);

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
        dropdownElements.forEach(select => {
            [...select.selectedOptions].forEach(option => {
                if (option.value === "admin") {
                    adminRoleFound = true;
                }
            });
        });
        return adminRoleFound;
    }
});

