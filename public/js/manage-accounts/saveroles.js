document.addEventListener('DOMContentLoaded', function () {
    const saveButton = document.getElementById('saveBtn');
    if (saveButton) {
        saveButton.addEventListener('click', function () {
            saveRoles();
        });
    }
});

function saveRoles() {
    const selectedRoles = getSelectedRoles();
    console.log('Saving roles:', JSON.stringify(selectedRoles));
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
