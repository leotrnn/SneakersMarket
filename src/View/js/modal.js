var modal = document.getElementById("confirmModal");
var deleteLink = document.querySelectorAll(".linkStarGestion");

deleteLink.forEach(function (link) {
    link.addEventListener("click", function (event) {
        event.preventDefault();
        var idSneaker = this.dataset.id;
        modal.style.display = "block";

        document.getElementById("confirmDelete").onclick = function () {
            window.location.href = "index.php?url=Admin&remove=yes&idSneaker=" + idSneaker;
        }

        document.getElementById("cancelDelete").onclick = function () {
            modal.style.display = "none";
        }
    });
});

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}