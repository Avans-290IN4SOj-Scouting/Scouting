document.addEventListener('DOMContentLoaded', function () {
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
            saveRoles();
        });
    }

    document.querySelectorAll("[id^='roleContainer']").forEach(container => {
        container.addEventListener('change', function (event) {
            if (event.target.tagName.toLowerCase() === 'select') {
                console.log('Selectie gewijzigd:', event.target.value);
                const select = event.target;
                const email = select.closest('tr').querySelector('td').innerText.trim();
                const groupId = select.dataset.groupId;
                const selectedValue = select.value;
                saveRoleChange(email, groupId, selectedValue);
                updateChangedAccountsInfo();
            }
        });
    });

    function updateChangedAccountsInfo() {
        const savedRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || {};
        let infoHtml = '';

        Object.entries(savedRoleChanges).forEach(([email, roles]) => {
            const oldRoles = [];
            const newRoles = [];

            if (roles.oldRoles) {
                Object.entries(roles.oldRoles).forEach(([groupId, role]) => {
                    if (roles.newRoles[groupId] !== role) {
                        oldRoles.push(role);
                    }
                });
            }

            if (roles.newRoles) {
                Object.entries(roles.newRoles).forEach(([groupId, role]) => {
                    if (roles.oldRoles[groupId] !== role) {
                        newRoles.push(role);
                    }
                });
            }

            if (oldRoles.length > 0 || newRoles.length > 0) {
                infoHtml += `<strong>${email}</strong>: ${oldRoles.join(', ')} ➔ ${newRoles.join(', ')}<br>`;
            }
        });

        changedAccountsInfo.innerHTML = infoHtml;
    }
});

function saveRoles() {
    const selectedRoles = getSelectedRoles();
    console.log('Rollen opgeslagen:', JSON.stringify(selectedRoles));
}

function saveRoleChange(email, groupId, roleId) {
    const savedRoleChanges = JSON.parse(localStorage.getItem('roleChanges')) || {};
    if (!savedRoleChanges[email]) {
        savedRoleChanges[email] = {oldRoles: {}, newRoles: {}};
    }

    const userRoles = savedRoleChanges[email];

    userRoles.newRoles[groupId] = roleId;

    localStorage.setItem('roleChanges', JSON.stringify(savedRoleChanges));
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
                selectedRoles.push({email: email, roles: roleSelections});
            }
        }
    });

    return selectedRoles;
}

function getTrElementByEmail(email) {
    return Array.from(document.querySelectorAll('tr')).find(tr => {
        const emailElement = tr.querySelector('td');
        return emailElement && emailElement.innerText.trim() === email;
    });
}
