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
                        addDropdown(selectedValue, selectedGroupId, tdElement);
                    }
                }
            }
        });
    });

    function addDropdown(selectedValue, selectedGroupId, tdElement) {
        const newElement = document.createElement('div');
        newElement.className = 'relative';

        const selectElement = document.createElement('select');
        selectElement.id = `subroleSelect${selectedValue}`;
        selectElement.style.width = '150px';
        selectElement.className = 'peer p-4 pe-9 block border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-gray-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2';

        // Exclude already selected options in the same group
        const existingSelections = Array.from(document.querySelectorAll(`select[data-group-id='${selectedGroupId}']`))
            .map(select => select.value);

        const options = rolesData.filter(role => {
            return role.group_id === parseInt(selectedGroupId) && !existingSelections.includes(role.id.toString());
        });

        options.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.textContent = option.display_name;
            optionElement.value = option.id;
            selectElement.appendChild(optionElement);
        });

        selectElement.dataset.groupId = selectedGroupId;
        newElement.appendChild(selectElement);

        const labelElement = document.createElement('label');
        labelElement.setAttribute('for', `subroleSelect${selectedValue}`);
        labelElement.className = 'absolute top-0 start-0 p-4 h-full truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500 dark:peer-focus:text-neutral-500 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500 dark:peer-[:not(:placeholder-shown)]:text-gray-500 dark:text-gray-500';
        labelElement.textContent = selectedValue;

        newElement.appendChild(labelElement);

        tdElement.prepend(newElement);

        selectElement.addEventListener('change', function() {
            updateDropdowns(selectedGroupId);
        });
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
});
