document.addEventListener('DOMContentLoaded', function () {
    const rolesDataElement = document.getElementById('roles-data');
    const rolesDataString = rolesDataElement.getAttribute('data-roles');
    const rolesData = JSON.parse(JSON.parse(rolesDataString));

    const accountsDataElement = document.getElementById('accounts-data');
    const accountsDataString = accountsDataElement.getAttribute('data-accounts');
    const accountsData = JSON.parse(accountsDataString);

    setupDropdownsForAccountsData();

    document.querySelectorAll("select[name='selectRole']").forEach(function (select) {
        select.addEventListener('change', function (event) {
            const selectedValue = event.target.value;
            if (selectedValue) {
                const tdElement = event.target.closest('td');
                const selectedOption = event.target.selectedOptions[0];
                const selectedGroupId = selectedOption.dataset.groupId;
                if (selectedGroupId) {
                    if (selectedValue === 'admin') {
                        addAdminTag(selectedValue, tdElement);
                    } else {
                        const availableOptions = rolesData.filter(role => role.group_id === parseInt(selectedGroupId));
                        const existingSelections = Array.from(document.querySelectorAll(`select[data-group-id='${selectedGroupId}']`))
                            .map(select => select.value);

                        const filteredOptions = availableOptions.filter(option => !existingSelections.includes(option.id.toString()));

                        if (filteredOptions.length > 0) {
                            addDropdown(selectedValue, selectedGroupId, tdElement, filteredOptions);
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
        accountsData.data.forEach(account => {
            const email = account.email;
            const roles = account.roles;

            const trElement = document.querySelector(`tr[data-email='${email}']`);

            if (trElement) {
                roles.forEach(role => {
                    const groupId = role.group_id;
                    const roleId = role.id;
                        const roleData = rolesData.find(roleData => roleData.id === roleId);
                        if (roleData) {
                            addDropdown(roleData.name, groupId, trElement, [{
                                id: roleData.id,
                                display_name: roleData.display_name
                            }]);
                        }
                });
            }
        });

        console.log('klaar');
    }


    function addDropdown(selectedValue, selectedGroupId, tdElement, options) {
        const newElement = document.createElement('div');
        newElement.className = 'relative';

        const selectElement = document.createElement('select');
        selectElement.id = `subroleSelect${selectedValue}`;
        selectElement.style = 'border-right-width:28px';
        selectElement.style.width = '150px';
        selectElement.className = 'peer p-4 pr-10 block border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-gray-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2 appearance-none bg-no-repeat bg-right pr-10';
        selectElement.dataset.groupId = selectedGroupId;

        options.forEach(option => {
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
            updateAvailableOptions(selectedGroupId);
        });

        newElement.appendChild(removeButton);

        tdElement.prepend(newElement);

        selectElement.addEventListener('change', function () {
            updateDropdowns(selectedGroupId);
        });

        updateAvailableOptions(selectedGroupId);
    }

    function updateDropdowns(groupId) {
        const selects = document.querySelectorAll(`select[data-group-id='${groupId}']`);
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

    function updateAvailableOptions(groupId) {
        const selects = document.querySelectorAll(`select[data-group-id='${groupId}']`);
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

    function addAdminTag(selectedValue, tdElement) {
        const adminTag = document.createElement('p');
        adminTag.className = 'bg-red-600 p-2 rounded font-bold';
        adminTag.textContent = selectedValue.toUpperCase();

        tdElement.prepend(adminTag);
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
