document.addEventListener('DOMContentLoaded', function () {
    const addRoleButtons = document.querySelectorAll('#addRoleButton');

    addRoleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const parent = button.parentElement;
            const selectRoleContainer = parent.querySelector('#selectRoleContainer');
            const cancelButton = parent.querySelector('#cancelButton');

            cancelButton.addEventListener('click', function () {
                selectRoleContainer.classList.add('hidden');
                button.classList.remove('hidden');
            });

            selectRoleContainer.classList.remove('hidden');

            button.classList.add('hidden');
        });
    });
});
