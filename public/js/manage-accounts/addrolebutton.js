document.addEventListener('DOMContentLoaded', function () {
    const addRoleButtons = document.querySelectorAll('#addRoleButton');

    addRoleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const parent = button.parentElement;
            const selectRoleContainer = parent.querySelector('#selectRoleContainer');
            const cancelButton = parent.querySelector('#cancelButton');
            const selectRole = selectRoleContainer.querySelector("select[name='selectRole']");

            cancelButton.addEventListener('click', function () {
                selectRoleContainer.classList.add('hidden');
                button.classList.remove('hidden');
                selectRole.selectedIndex = 0;
            });

            selectRole.addEventListener('change', function (event) {
                const selectedValue = event.target.value;
                if (selectedValue) {
                    selectRoleContainer.classList.add('hidden');
                    selectRole.selectedIndex = 0;
                    button.classList.remove('hidden');
                }
            });

            selectRoleContainer.classList.remove('hidden');
            button.classList.add('hidden');
        });
    });
});
