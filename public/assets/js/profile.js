function updatePhotoProfile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // Envoyer la photo au serveur
            const formData = new FormData();
            formData.append('photo', input.files[0]);

            fetch('/dashboard/updatePhoto', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Photo mise à jour avec succès!');
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour');
                });
        };

        reader.readAsDataURL(input.files[0]);
    }
}
