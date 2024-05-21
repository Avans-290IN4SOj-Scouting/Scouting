document.addEventListener('DOMContentLoaded', function () {
    const rolesDataElement = document.getElementById('roles-data');
    const rolesDataString = rolesDataElement.getAttribute('data-roles');
    const rolesData = JSON.parse(JSON.parse(rolesDataString));

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

    function addDropdown(selectedValue, selectedGroupId, tdElement, options) {
        const newElement = document.createElement('div');
        newElement.className = 'relative';

        const selectElement = document.createElement('select');
        selectElement.id = `subroleSelect${selectedValue}`;
        selectElement.style.width = '150px';
        selectElement.className = 'peer p-4 pe-9 block border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-gray-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2';
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

    function addAdminTag(selectedValue, tdElement) {
        const adminTag = document.createElement('p');
        adminTag.className = 'bg-red-600 p-2 rounded font-bold';
        adminTag.textContent = selectedValue.toUpperCase();

        tdElement.prepend(adminTag);
    }

    function showToast(type, message) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'dismiss-toast';
        toastContainer.className = 'z-50 fixed bottom-0 end-0 m-6 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-md bg -white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700';
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

    function updateAvailableOptions(groupId) {
        const selects = document.querySelectorAll(`select[data-group-id='${groupId}']`);
        const selectedValues = Array.from(selects).flatMap(select => Array.from(select.options).filter(option => option.selected).map(option => option.value));
        const availableOptions = rolesData.filter(role => role.group_id === parseInt(groupId));

        selects.forEach(select => {
            const firstOption = select.querySelector('option');

            select.innerHTML = '';
            select.appendChild(firstOption);

            availableOptions.forEach(option => {
                if (!selectedValues.includes(option.id.toString())) {
                    const optionElement = document.createElement('option');
                    optionElement.textContent = option.display_name;
                    optionElement.value = option.id;
                    select.appendChild(optionElement);
                }
            });
        });
    }
});
