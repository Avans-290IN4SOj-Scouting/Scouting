const saveBtn = document.getElementById("saveBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const confirmModalBtn = document.getElementById("confirmModalBtn");
const confirmModal = document.getElementById("confirmModal");

saveBtn.addEventListener("click", () => {
    confirmModal.classList.remove("hidden");
});

closeModalBtn.addEventListener("click", () => {
    confirmModal.classList.add("hidden");
});

confirmModalBtn.addEventListener("click", () => {
    confirmModal.classList.add("hidden");
});
