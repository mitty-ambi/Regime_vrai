<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NutriGain</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">

</head>
<?= view("navbar") ?>
<?= view("sidebar") ?>

<body>

    <main>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-header">
            <h1 class="dashboard-title">Bienvenue, <?= esc($utilisateur['nom']) ?> !</h1>
            <p class="dashboard-subtitle">Voici votre tableau de bord personnel</p>
        </div>

        <!-- STATISTIQUES -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">IMC</div>
                    <div class="stat-icon primary">📊</div>
                </div>
                <div class="stat-value">
                    <?= number_format($utilisateur['poids'] / pow($utilisateur['taille'] / 100, 2), 1) ?>
                </div>
                <div class="stat-description">Indice de Masse Corporelle</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Taille</div>
                    <div class="stat-icon info">📏</div>
                </div>
                <div class="stat-value"><?= esc($utilisateur['taille']) ?></div>
                <div class="stat-description">centimètres</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Poids</div>
                    <div class="stat-icon warning">⚖️</div>
                </div>
                <div class="stat-value" id="poids-display">
                    <?= esc($utilisateur['poids']) ?>
                    <button class="edit-poids-btn" onclick="togglePoidsEdit()" title="Modifier le poids">✏️</button>
                </div>
                <div class="stat-description">kilogrammes</div>
                <div class="poids-edit-container" id="poids-edit" style="display: none;">
                    <input type="number" id="poids-input" class="poids-input" value="<?= esc($utilisateur['poids']) ?>"
                        step="0.1" min="30" max="300" placeholder="Nouveau poids">
                    <div class="pois-edit-buttons">
                        <button class="btn-save" onclick="savePoids()">✓</button>
                        <button class="btn-cancel" onclick="cancelPoidsEdit()">✕</button>
                    </div>
                    <div class="edit-help">Appuyez sur Entrée pour valider</div>
                </div>
            </div>
        </div>

        <!-- PROFIL -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">👤 Profil</h2>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nom complet</div>
                    <div class="info-value"><?= esc($utilisateur['nom']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?= esc($utilisateur['email']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Genre</div>
                    <div class="info-value"><?= esc($utilisateur['genre']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date d'inscription</div>
                    <div class="info-value"><?= date('d/m/Y', strtotime($utilisateur['date_creation'])) ?></div>
                </div>
            </div>
        </div>

        <!-- INFORMATIONS SANTÉ -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">💪 Informations santé</h2>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Taille</div>
                    <div class="info-value"><?= esc($utilisateur['taille']) ?> cm</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Poids</div>
                    <div class="info-value"><?= esc($utilisateur['poids']) ?> kg</div>
                </div>
                <div class="info-item">
                    <div class="info-label">IMC</div>
                    <div class="info-value">
                        <?= number_format($utilisateur['poids'] / pow($utilisateur['taille'] / 100, 2), 1) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Catégorie IMC</div>
                    <div class="info-value">
                        <?php
                        $imc = $utilisateur['poids'] / pow($utilisateur['taille'] / 100, 2);
                        if ($imc < 18.5)
                            echo 'Insuffisance pondérale';
                        elseif ($imc < 25)
                            echo 'Poids normal';
                        elseif ($imc < 30)
                            echo 'Surpoids';
                        else
                            echo 'Obésité';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        let originalPoids = <?= $utilisateur['poids'] ?>;

        function togglePoidsEdit() {
            const editContainer = document.getElementById('poids-edit');
            const displayElement = document.getElementById('poids-display');
            const input = document.getElementById('poids-input');

            if (editContainer.style.display === 'none') {
                editContainer.style.display = 'block';
                displayElement.style.display = 'none';
                input.focus();
                input.select();
            } else {
                cancelPoidsEdit();
            }
        }

        function cancelPoidsEdit() {
            const editContainer = document.getElementById('poids-edit');
            const displayElement = document.getElementById('poids-display');
            const input = document.getElementById('poids-input');

            editContainer.style.display = 'none';
            displayElement.style.display = 'block';
            input.value = originalPoids;
        }

        function savePoids() {
            const input = document.getElementById('poids-input');
            const nouveauPoids = parseFloat(input.value);

            if (!nouveauPoids || nouveauPoids < 30 || nouveauPoids > 300) {
                showMessage('Le poids doit être entre 30 et 300 kg', 'error');
                return;
            }

            if (nouveauPoids === originalPoids) {
                cancelPoidsEdit();
                return;
            }

            // Ajouter l'animation de mise à jour
            const poidsCard = document.querySelector('.stat-card:nth-child(3)');
            poidsCard.classList.add('updating');

            // Envoyer la requête AJAX
            fetch('/dashboard/updatePoids', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'poids=' + nouveauPoids
            })
                .then(response => response.json())
                .then(data => {
                    poidsCard.classList.remove('updating');

                    if (data.success) {
                        // Mettre à jour l'affichage
                        updatePoidsDisplay(nouveauPoids, data.imc);
                        originalPoids = nouveauPoids;

                        // Afficher le message de succès
                        showMessage(data.message, 'success');


                        cancelPoidsEdit();
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    poidsCard.classList.remove('updating');
                    console.error('Erreur:', error);
                    showMessage('Erreur lors de la mise à jour du poids', 'error');
                });
        }

        function updatePoidsDisplay(nouveauPoids, nouvelIMC) {
            console.log('Mise à jour poids:', nouveauPoids, 'IMC:', nouvelIMC);

            // Mettre à jour le poids dans la carte
            const poidsDisplay = document.getElementById('poids-display');
            if (poidsDisplay) {
                poidsDisplay.innerHTML = `${nouveauPoids}<button class="edit-poids-btn" onclick="togglePoidsEdit()" title="Modifier le poids">✏️</button>`;
            }

            // Mettre à jour l'IMC dans la carte (première carte)
            const imcCard = document.querySelector('.stat-card:first-child .stat-value');
            if (imcCard) {
                imcCard.textContent = nouvelIMC;
                console.log('IMC carte mis à jour:', nouvelIMC);
            }

            // Mettre à jour toutes les valeurs IMC dans la page
            const allElements = document.querySelectorAll('.info-value, .stat-value');
            allElements.forEach(element => {
                const text = element.textContent;
                // Vérifier si c'est un IMC (nombre avec décimale)
                if (text.match(/^\d+\.\d+$/) && !text.includes('kg') && !text.includes('cm')) {
                    element.textContent = nouvelIMC;
                    console.log('IMC mis à jour dans:', element, 'ancienne valeur:', text, 'nouvelle:', nouvelIMC);
                }
                // Mettre à jour le poids s'il contient "kg"
                if (text.includes('kg')) {
                    element.textContent = `${nouveauPoids} kg`;
                    console.log('Poids mis à jour dans:', element);
                }
            });

            // Recalculer et mettre à jour la catégorie IMC
            updateCategorieIMC(nouvelIMC);

            console.log('Mise à jour terminée');
        }

        function updatePhotoProfile(input) {
            const file = input.files[0];

            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showMessage('Veuillez sélectionner une image valide.', 'error');
                    input.value = '';
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showMessage('L\'image ne doit pas dépasser 5MB.', 'error');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const photoData = e.target.result;

                    // Send AJAX request to update photo
                    fetch('/dashboard/updatePhoto', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            photo_profil: photoData
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the avatar image
                                const avatar = document.querySelector('.user-avatar img');
                                if (avatar) {
                                    avatar.src = photoData;
                                } else {
                                    // If no img exists, create one
                                    const avatarContainer = document.querySelector('.user-avatar');
                                    avatarContainer.innerHTML = `<img src="${photoData}" alt="Photo de profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                                }

                                // Update session data
                                const utilisateur = JSON.parse(sessionStorage.getItem('utilisateur') || '{}');
                                utilisateur.photo_profil = photoData;
                                sessionStorage.setItem('utilisateur', JSON.stringify(utilisateur));

                                showMessage('Photo de profil mise à jour avec succès!', 'success');
                            } else {
                                showMessage(data.message || 'Erreur lors de la mise à jour de la photo.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('Erreur lors de la mise à jour de la photo.', 'error');
                        });
                };
                reader.readAsDataURL(file);
            }

            // Reset input
            input.value = '';
        }

        function updateCategorieIMC(imc) {
            let categorie = '';
            if (imc < 18.5) {
                categorie = 'Insuffisance pondérale';
            } else if (imc < 25) {
                categorie = 'Poids normal';
            } else if (imc < 30) {
                categorie = 'Surpoids';
            } else {
                categorie = 'Obésité';
            }

            // Mettre à jour la catégorie IMC dans la section santé
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                const label = item.querySelector('.info-label');
                const value = item.querySelector('.info-value');
                if (label && value && label.textContent.includes('Catégorie IMC')) {
                    value.textContent = categorie;
                }
            });
        }

        function showMessage(message, type) {
            // Supprimer les messages existants
            const existingMessages = document.querySelectorAll('.success-message, .error-message');
            existingMessages.forEach(msg => msg.remove());

            // Créer le nouveau message
            const messageDiv = document.createElement('div');
            messageDiv.className = type + '-message';
            messageDiv.textContent = message;
            document.body.appendChild(messageDiv);

            // Supprimer le message après 3 secondes
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        // Gérer la touche Entrée dans le champ de saisie
        document.addEventListener('DOMContentLoaded', function () {
            const poidsInput = document.getElementById('poids-input');
            if (poidsInput) {
                poidsInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        savePoids();
                    } else if (e.key === 'Escape') {
                        cancelPoidsEdit();
                    }
                });
            }
        });
    </script>
</body>

</html>