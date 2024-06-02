document.addEventListener('DOMContentLoaded', function () {
    const rolesDataElement = document.getElementById('roles-data');
    const rolesDataString = rolesDataElement.getAttribute('data-roles');
    const rolesData = JSON.parse(JSON.parse(rolesDataString));

    const accountsDataElement = document.getElementById('accounts-data');
    const accountsDataString = accountsDataElement.getAttribute('data-accounts');
    const accountsData = JSON.parse(accountsDataString);

    setupDropdownsForAccountsData();

    restoreSelectionsFromLocalStorage();

    document.querySelectorAll("select[name='selectRole']").forEach(function (select) {
        select.addEventListener('change', function (event) {
            const selectedValue = event.target.value;
            if (selectedValue) {
                const tdElement = event.target.closest('td');
                const email = tdElement.closest('tr').getAttribute('data-email');
                const selectedOption = event.target.selectedOptions[0];
                const selectedGroupId = selectedOption.dataset.groupId;
                if (selectedGroupId) {
                    if (selectedValue === 'admin') {
                        addAdminTag(selectedValue, tdElement, email);
                    } else {
                        const selectedRoles = Array.from(document.querySelectorAll(`select[name='selectRole']`))
                            .map(select => select.value);

                        const availableOptions = rolesData.filter(role => role.group_id === parseInt(selectedGroupId));
                        const existingSelections = Array.from(document.querySelectorAll(`select[data-group-id='${selectedGroupId}']`))
                            .map(select => select.value);

                        const filteredOptions = availableOptions.filter(option => !selectedRoles.includes(option.id.toString()) || existingSelections.includes(option.id.toString()));

                        if (filteredOptions.length > 0) {
                            addDropdown(selectedValue, selectedGroupId, tdElement, filteredOptions, email);
                        } else {
                            const translation = document.getElementById('translation')
                                .getAttribute('data-translation');

                            showToast('warning', translation);
                        }
                    }
                }
            }
        });
    });

    function setupDropdownsForAccountsData() {
        accountsData.forEach(account => {
            const email = account.email;
            const roles = account.roles;

            const trElement = document.querySelector(`tr[data-email='${email}']`);

            if (trElement) {
                roles.forEach(role => {
                    const groupId = role.group_id;
                    const roleId = role.id;
                    const roleData = rolesData.find(roleData => roleData.id === roleId);
                    if (roleData) {
                        const tdElement = trElement.querySelector(`td#roleContainer${account.id}`);
                        if (tdElement) {
                            const formattedRoleName = formatRoleName(roleData.name);
                            if (roleData.name === 'admin') {
                                addAdminTag(roleData.name, tdElement, email);
                            } else {
                                addDropdown(formattedRoleName, groupId, tdElement, [{
                                    id: roleData.id,
                                    display_name: roleData.display_name,
                                }], email);
                            }
                        }
                    }
                });
            }
        });
    }

    function restoreSelectionsFromLocalStorage() {
        const roleChanges = JSON.parse(localStorage.getItem('roleChanges')) || [];

        roleChanges.forEach(change => {
            const {email, newRoles} = change;
            const trElement = document.querySelector(`tr[data-email='${email}']`);

            if (trElement) {
                const email = trElement.getAttribute('data-email');
                const account = accountsData.find(account => account.email === email);

                if (account) {
                    const tdElement = trElement.querySelector(`td#roleContainer${account.id}`);

                    if (tdElement) {
                        const existingSelects = tdElement.querySelectorAll('select');
                        const existingRoles = Array.from(existingSelects).map(select => select.value);

                        existingSelects.forEach(select => {
                            const roleId = select.value;
                            if (!newRoles.includes(roleId)) {
                                if (select.id.includes('subrole')) {
                                    select.parentElement.remove();
                                }
                            }
                        });

                        newRoles.forEach(roleId => {
                            if (!existingRoles.includes(roleId)) {
                                const roleData = rolesData.find(role => role.id === parseInt(roleId));
                                if (roleData) {
                                    const groupId = roleData.group_id;
                                    const formattedRoleName = formatRoleName(roleData.name);
                                    const option = {
                                        id: roleData.id,
                                        display_name: roleData.display_name
                                    };
                                    if (roleData.name === 'admin') {
                                        addAdminTag(roleData.name, tdElement, email);
                                    } else {
                                        addDropdown(formattedRoleName, groupId, tdElement, [option], email);
                                    }
                                }
                            }
                        });
                    }
                }
            }
        });
    }

    function formatRoleName(roleName) {
        const parts = roleName.split('_');
        if (parts.length > 1) {
            return parts[0].charAt(0).toUpperCase() + parts[0].slice(1);
        }
        return roleName;
    }

    function addDropdown(selectedValue, selectedGroupId, tdElement, options, email) {
        const existingRoles = Array.from(tdElement.querySelectorAll('select')).map(select => select.value);

        const nonSelectedOptions = options.filter(option => !existingRoles.includes(option.id.toString()));

        if (nonSelectedOptions.length > 0) {
            const newElement = document.createElement('div');
            newElement.className = 'relative';

            const selectElement = document.createElement('select');
            selectElement.id = `subroleSelect${selectedValue}`;
            selectElement.style = 'border-right-width:28px';
            selectElement.style.width = '150px';
            selectElement.className = 'peer p-4 pr-10 block border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-gray-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2 appearance-none bg-no-repeat bg-right pr-10';
            selectElement.dataset.groupId = selectedGroupId;
            selectElement.dataset.email = email;

            nonSelectedOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.textContent = option.display_name;
                optionElement.value = option.id;
                selectElement.appendChild(optionElement);
            });

            newElement.appendChild(selectElement);

            const labelElement = document.createElement('label');
            labelElement.setAttribute('for', `subroleSelect${selectedValue}`);
            labelElement.className = 'absolute top-0 start-0 p-4 h-full truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500 dark:peer-focus:text-neutral-500 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500 dark:peer-[:not(:placeholder-shown)]:text-gray-500 dark:text-gray-500';
            labelElement.textContent = selectedValue;

            newElement.appendChild(labelElement);

            const removeButton = document.createElement('div');
            removeButton.className = 'absolute text-red-600 cursor-pointer';
            removeButton.style.top = '17px';
            removeButton.style.right = '4px';
            removeButton.innerHTML = `
<svg class="svg-icon" width="20px" height="20px" viewBox="0 0 1024 1024" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path d="M810.66 170.66q18.33 0 30.49 12.17t12.17 30.49q0 18-12.33 30.33L572.34 512l268.81 268.34q12.33 12.33 12.33 30.33 0 18.33-12.17 30.49t-30.49 12.17q-18 0-30.33-12.33L512 572.34 243.66 841.15q-12.33 12.33-30.33 12.33-18.33 0-30.49-12.17t-12.17-30.49q0-18 12.33-30.33L451.66 512 182.99 243.66q-12.33-12.33-12.33-30.33 0-18.33 12.17-30.49t30.49-12.17q18 0 30.33 12.33L512 451.66 780.34 182.99q12.33-12.33 30.33-12.33z"/>
</svg>
`;
            removeButton.addEventListener('click', function () {
                newElement.remove();
                updateAvailableOptions(selectedGroupId, email);
            });

            newElement.appendChild(removeButton);

            tdElement.prepend(newElement);

            selectElement.addEventListener('change', function () {
                updateDropdowns(selectedGroupId, email);
            });

            updateAvailableOptions(selectedGroupId, email);
        } else {
            const translation = document.getElementById('translation').getAttribute('data-translation');
            showToast('warning', translation);
        }
    }

    function updateDropdowns(groupId, email) {
        const selects = document.querySelectorAll(`select[data-group-id='${groupId}'][data-email='${email}']`);
        const selectedValues = Array.from(selects).map(select => select.value);

        selects.forEach(select => {
            const currentValue = select.value;
            const options = rolesData.filter(role => {
                return role.group_id === parseInt(groupId) && (role.id.toString() === currentValue || !selectedValues.includes(role.id.toString()));
            });

            while (select.firstChild) {
                select.removeChild(select.firstChild);
            }

            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.textContent = option.display_name;
                optionElement.value = option.id;
                if (option.id.toString() === currentValue) {
                    optionElement.selected = true;
                }
                select.appendChild(optionElement);
            });
        });
    }

    function updateAvailableOptions(groupId, email) {
        const selects = document.querySelectorAll(`select[data-group-id='${groupId}'][data-email='${email}']`);
        const selectedValues = Array.from(selects).map(select => select.value);

        selects.forEach(select => {
            const currentValue = select.value;
            const options = rolesData.filter(role => {
                return role.group_id === parseInt(groupId) && (role.id.toString() === currentValue || !selectedValues.includes(role.id.toString()));
            });

            while (select.firstChild) {
                select.removeChild(select.firstChild);
            }

            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.textContent = option.display_name;
                optionElement.value = option.id;
                if (option.id.toString() === currentValue) {
                    optionElement.selected = true;
                }
                select.appendChild(optionElement);
            });
        });
    }

    function addAdminTag(selectedValue, tdElement, email) {
        if (!tdElement.querySelector('.admin-tag')) {
            const adminTag = document.createElement('div');
            adminTag.className = 'bg-red-600 p-2 rounded font-bold admin-tag flex items-center justify-between';
            adminTag.dataset.email = email
            adminTag.innerHTML = `
            <span>${selectedValue.toUpperCase()}</span>
            <button class="remove-admin-tag text-white" style="padding-left: 8px;">&times;</button>
        `;

            tdElement.prepend(adminTag);

            const removeButton = adminTag.querySelector('.remove-admin-tag');
            removeButton.addEventListener('click', function () {
                adminTag.remove();
            });
        }
    }

    function showToast(type, message) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'dismiss-toast';
        toastContainer.className = 'z-50 fixed bottom-0 end-0 m-6 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-md bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700';
        toastContainer.setAttribute('role', 'alert');

        const toast = document.createElement('div');
        toast.className = `toast-${type} flex p-4`;
        toastContainer.appendChild(toast);

        const boldText = document.createElement('span');
        boldText.className = 'font-bold';
        boldText.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} - `;
        toast.appendChild(boldText);

        const messageText = document.createElement('p');
        messageText.className = 'text-sm text-gray-700 dark:text-gray-400';
        messageText.textContent = message;
        toast.appendChild(messageText);

        const closeButtonContainer = document.createElement('div');
        closeButtonContainer.className = 'ms-auto';
        toast.appendChild(closeButtonContainer);

        const closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'inline-flex flex-shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white';
        closeButton.dataset.hsRemoveElement = '#dismiss-toast';
        closeButton.innerHTML = `
            <span class="sr-only">Close</span>
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
            </svg>
        `;
        closeButton.addEventListener('click', function () {
            toastContainer.classList.add('hs-removing');
            setTimeout(() => toastContainer.remove(), 300);
        });
        closeButtonContainer.appendChild(closeButton);

        document.body.appendChild(toastContainer);
    }
});
