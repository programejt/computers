let deletePhotoCheckbox, inputFile;

function setInputFileStatus() {
  inputFile.disabled = deletePhotoCheckbox.checked;
}

document.addEventListener('DOMContentLoaded', function () {
  deletePhotoCheckbox = document.getElementById('computer-photo-checkbox');
  inputFile = document.getElementById('computer-photo-input-file');

  if (deletePhotoCheckbox) {
    deletePhotoCheckbox.addEventListener('change', setInputFileStatus);

    setInputFileStatus();
  }
});