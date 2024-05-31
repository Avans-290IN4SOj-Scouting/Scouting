document.addEventListener('DOMContentLoaded', function () {
    const rolesDataElement = document.getElementById('roles-data');
    const rolesDataString = rolesDataElement.getAttribute('data-roles');
    const rolesData = JSON.parse(JSON.parse(rolesDataString));

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
        const selectedValue = selectElement.value;

        const savedRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || [];

        let userRoleChange = savedRoleChanges.find(account => account.email === email);
        if (!userRoleChange) {
            userRoleChange = {email: email, oldRoles: [], newRoles: []};
            savedRoleChanges.push(userRoleChange);
        }

        if (userRoleChange.oldRoles.length === 0) {
            userRoleChange.oldRoles = getOldRoles(email);
        }

        userRoleChange.newRoles.push(selectedValue.toString());

        localStorage.setItem('roleChanges', JSON.stringify(savedRoleChanges));
    }

    function getOldRoles(email) {
        const account = accountsData.find(account => account.email === email);
        if (account) {
            return account.roles.map(role => role.id.toString());
        }
        return [];
    }

    function updateChangedAccountsInfo() {
        const savedRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || [];
        let infoHtml = '';

        savedRoleChanges.forEach(account => {
            const { email, oldRoles, newRoles } = account;
            const changes = newRoles.filter((newRole, index) => newRole !== oldRoles[index]);

            if (changes.length > 0) {
                const formattedOldRoles = oldRoles.map(roleId => getRoleNameById(roleId)).join(', ');
                const formattedNewRoles = newRoles.map(roleId => getRoleNameById(roleId)).join(', ');
                infoHtml += `<strong>${email}</strong>: ${formattedOldRoles} -> ${formattedNewRoles}<br>`;
            }
        });

        changedAccountsInfo.innerHTML = infoHtml;
    }

    function formatRoleName(roleName) {
        const parts = roleName.split('_');
        if (parts.length > 1) {
            return parts.map(part => part.charAt(0).toUpperCase() + part.slice(1)).join(' ');
        }
        return roleName.charAt(0).toUpperCase() + roleName.slice(1);
    }

    function getRoleNameById(roleId) {
        const role = rolesData.find(role => role.id === parseInt(roleId));
        return role ? formatRoleName(role.name) : 'Unknown Role';
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
                    const selectedValue = select.value;
                    if (selectedValue) {
                        roleSelections.push(selectedValue.toString());
                    }
                });

                if (roleSelections.length > 0) {
                    const oldRoles = getOldRoles(email);
                    selectedRoles.push({email: email, oldRoles: oldRoles, newRoles: roleSelections});
                }
            }
        });

        console.log(selectedRoles);

        return selectedRoles;
    }
});
