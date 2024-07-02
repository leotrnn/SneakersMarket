// Récupérez le modal
var modal = document.getElementById("confirmModal");

// Récupérez le lien de suppression
var deleteLink = document.querySelectorAll(".linkStarGestion");

// Bouclez sur tous les liens de suppression pour ajouter un événement de clic
deleteLink.forEach(function (link) {
    link.addEventListener("click", function (event) {
        event.preventDefault(); // Empêcher le lien de se comporter par défaut
        var userId = this.dataset.userId; // Récupérer l'ID de l'utilisateur
        var sneakerId = this.dataset.sneakerId; // Récupérer l'ID de la sneaker
        
        // Afficher le modal de confirmation
        modal.style.display = "block";

        // Confirmer la suppression
        document.getElementById("confirmDelete").onclick = function () {
            // Rediriger vers la page de suppression avec les IDs de l'utilisateur et de la sneaker
            window.location.href = "index.php?url=ManageUser&remove=yes&idUser=" + userId + "&idSneaker=" + sneakerId;
        }

        // Annuler la suppression
        document.getElementById("cancelDelete").onclick = function () {
            modal.style.display = "none"; // Cacher le modal
        }
    });
});
