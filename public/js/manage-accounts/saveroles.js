document.addEventListener('DOMContentLoaded', function () {
    const accountsDataElement = document.getElementById('accounts-data');
    const accountsDataString = accountsDataElement.getAttribute('data-accounts');
    const accountsData = JSON.parse(accountsDataString);

    const confirmModal = document.getElementById('confirmModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const confirmModalBtn = document.getElementById('confirmModalBtn');
    const changedAccountsInfo = document.getElementById('changedAccountsInfo');

    const saveButton = document.getElementById('saveBtn');
    if (saveButton) {
        saveButton.addEventListener('click', function () {
            confirmModal.classList.remove('hidden');
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function () {
            confirmModal.classList.add('hidden');
        });
    }

    if (confirmModalBtn) {
        confirmModalBtn.addEventListener('click', function () {
            confirmModal.classList.add('hidden');
        });
    }

    document.querySelectorAll("[id^='roleContainer']").forEach(container => {
        container.addEventListener('change', function (event) {
            if (event.target.tagName.toLowerCase() === 'select') {
                saveRoleChange(event.target);
                saveRoles();
                updateChangedAccountsInfo();
            }
        });
    });

    function saveRoleChange(selectElement) {
        const email = selectElement.closest('tr').querySelector('td').innerText.trim();
        const groupId = selectElement.dataset.groupId;
        const selectedValue = selectElement.value;

        const savedRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || [];

        let userRoleChange = savedRoleChanges.find(account => account.email === email);
        if (!userRoleChange) {
            userRoleChange = {email: email, oldRoles: {}, newRoles: {}};
            savedRoleChanges.push(userRoleChange);
        }

        if (!userRoleChange.oldRoles[groupId]) {
            userRoleChange.oldRoles[groupId] = getOldRole(email, groupId);
        }

        userRoleChange.newRoles[groupId] = selectedValue;

        localStorage.setItem('roleChanges', JSON.stringify(savedRoleChanges));
    }

    function getOldRole(email, groupId) {
        const account = accountsData.find(account => account.email === email);
        if (account) {
            const role = account.roles.find(role => role.group_id == groupId);
            return role ? role.role : null;
        }
        return null;
    }

    function updateChangedAccountsInfo() {
        const savedRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || [];
        let infoHtml = '';

        savedRoleChanges.forEach(account => {
            const { email, oldRoles, newRoles } = account;
            const oldRolesList = Object.values(oldRoles).filter(role => role !== null);
            const newRolesList = Object.values(newRoles).filter(role => role !== null);

            if (oldRolesList.length > 0 || newRolesList.length > 0) {
                infoHtml += `<strong>${email}</strong>: ${oldRolesList.join(', ')} -> ${newRolesList.join(', ')}<br>`;
            }
        });

        changedAccountsInfo.innerHTML = infoHtml;
    }

    function saveRoles() {
        const existingRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || [];
        const selectedRoles = getSelectedRoles();

        selectedRoles.forEach(newChange => {
            const existingChangeIndex = existingRoleChanges.findIndex(change => change.email === newChange.email);
            if (existingChangeIndex !== -1) {
                existingRoleChanges[existingChangeIndex] = newChange;
            } else {
                existingRoleChanges.push(newChange);
            }
        });

        localStorage.setItem('roleChanges', JSON.stringify(existingRoleChanges));
        console.log('Rollen opgeslagen:', JSON.stringify(existingRoleChanges));
    }

    function getSelectedRoles() {
        const selectedRoles = [];

        document.querySelectorAll('tr').forEach(tr => {
            const emailElement = tr.querySelector('td');

            if (emailElement) {
                const email = emailElement.innerText.trim();

                const roleSelections = [];
                tr.querySelectorAll('select[data-group-id]').forEach(select => {
                    const groupId = select.dataset.groupId;
                    const selectedValue = select.value;
                    if (selectedValue) {
                        roleSelections.push({group: groupId, role: selectedValue});
                    }
                });

                if (roleSelections.length > 0) {
                    const oldRoles = {};
                    const newRoles = {};
                    roleSelections.forEach(({group, role}) => {
                        oldRoles[group] = getOldRole(email, group);
                        newRoles[group] = role;
                    });
                    selectedRoles.push({email: email, oldRoles: oldRoles, newRoles: newRoles});
                }
            }
        });

        return selectedRoles;
    }
});
