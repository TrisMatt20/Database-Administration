document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const messageID = button.getAttribute('data-message-id');
        const inputField = document.getElementById('modalMessageID');
        inputField.value = messageID;
    });
});


