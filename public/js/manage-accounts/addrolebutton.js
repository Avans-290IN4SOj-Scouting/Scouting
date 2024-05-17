document.addEventListener('DOMContentLoaded', function () {
    const addRoleButtons = document.querySelectorAll('#addRoleButton');

    addRoleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const parent = button.parentElement;
            const selectRoleDiv = parent.querySelector('#selectRole-div');

            selectRoleDiv.classList.remove('hidden');
            button.classList.add('hidden');
        });
    });
});
