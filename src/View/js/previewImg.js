function previewFile() {
    var preview = document.querySelector('.imgSneaker'); 
    var fileInput = document.querySelector('.selectImg');
    var file = fileInput.files[0];
    var reader = new FileReader();

    if (file && isFileExtensionAllowed(file.name)) {
        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        reader.readAsDataURL(file);

    }
}

function isFileExtensionAllowed(filename) {
    var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    var ext = filename.split('.').pop().toLowerCase();
    return allowedExtensions.includes(ext);
}
