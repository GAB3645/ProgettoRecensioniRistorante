function toggleDeleteButton() {
    const checkboxes = document.querySelectorAll('input[name="recensioni[]"]');
    const deleteBtn = document.getElementById("eliminaBtn");
    deleteBtn.disabled = [...checkboxes].every(cb => !cb.checked);
}
