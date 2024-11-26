document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const messageID = button.getAttribute('data-message-id');
        const inputField = document.getElementById('modalMessageID');
        inputField.value = messageID;
    });
});

var editFormContainer = document.getElementById('editFormContainer');
var inputMessContainer = document.getElementById('inputMessContainer');
var editMessageID = document.getElementById('editMessageID');
var editMessageInput = document.getElementById('editMessageInput');

function openEditForm(messageID, currentMessage) {

    editMessageID.value = messageID;
    editMessageInput.value = currentMessage;

    inputMessContainer.classList.add('d-none');
    editFormContainer.classList.remove('d-none');

}

function dismissEditForm() {
    inputMessContainer.classList.remove('d-none');
    editFormContainer.classList.add('d-none');
}



