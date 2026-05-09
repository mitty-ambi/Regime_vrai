<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NutriGain</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary: #8b5cf6;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
            --info: #3b82f6;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--light);
            color: var(--dark);
        }

        /* HEADER */
        header {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-right {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: var(--primary-light);
            border-radius: 8px;
        }

        .user-avatar-container {
            position: relative;
            cursor: pointer;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.1);
        }

        .edit-photo-btn {
            position: absolute;
            bottom: -2px;
            right: -2px;
            background: var(--primary);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            border: 2px solid white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-photo-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.2);
        }

        .objectifs-btn {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .objectifs-btn:hover {
            background: #7c3aed;
            transform: translateY(-1px);
        }

        .logout-btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* MAIN CONTENT */
        main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px;
        }

        .dashboard-header {
            margin-bottom: 32px;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .dashboard-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.primary {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon.info {
            background: #dbeafe;
            color: var(--info);
        }

        .stat-icon.warning {
            background: #fef3c7;
            color: var(--warning);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .stat-description {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* SECTIONS */
        .content-section {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--gray-light);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 20px;
            background: var(--light);
            border-radius: 8px;
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease;
        }

        .info-item:hover {
            transform: translateX(4px);
        }

        .info-label {
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: var(--dark);
            font-size: 1.25rem;
            font-weight: 600;
        }

        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border-left: 4px solid var(--success);
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            nav {
                padding: 12px 16px;
            }

            main {
                padding: 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }
        }

        /* Styles pour l'édition du poids */
        .edit-poids-btn {
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 14px;
            margin-left: 8px;
            padding: 2px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .edit-poids-btn:hover {
            background: var(--gray-light);
            color: var(--primary);
        }

        .poids-edit-container {
            margin-top: 12px;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
            border: 1px solid var(--gray-light);
        }

        .poids-input {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid var(--primary);
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            font-family: 'Manrope', sans-serif;
        }

        .poids-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .pois-edit-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 8px;
        }

        .btn-save, .btn-cancel {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-save {
            background: var(--success);
            color: white;
        }

        .btn-save:hover {
            background: #059669;
            transform: scale(1.1);
        }

        .btn-cancel {
            background: var(--danger);
            color: white;
        }

        .btn-cancel:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .edit-help {
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray);
            margin-top: 6px;
        }

        /* Animation de mise à jour */
        .updating {
            animation: pulse 1s ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Message de succès */
        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--danger);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                🥗 NutriGain
            </div>
            <div class="nav-right">
                <div class="user-profile">
                    <div class="user-avatar-container">
                        <div class="user-avatar" onclick="document.getElementById('photo_upload').click()">
                            <?php if (!empty($utilisateur['photo_profil'])): ?>
                                <img src="<?= esc($utilisateur['photo_profil']) ?>" alt="Photo de profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <?= strtoupper(substr(esc($utilisateur['nom']), 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                        <div class="edit-photo-btn" onclick="document.getElementById('photo_upload').click()">📷</div>
                        <input type="file" id="photo_upload" style="display: none;" accept="image/*" onchange="updatePhotoProfile(this)">
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--dark);"><?= esc($utilisateur['nom']) ?></div>
                        <div style="font-size: 0.85rem; color: var(--gray);"><?= esc($utilisateur['email']) ?></div>
                    </div>
                </div>
                <a href="/objectif/choix" class="objectifs-btn">🎯 Objectifs</a>
                <a href="/auth/logout" class="logout-btn">Déconnexion</a>
            </div>
        </nav>
    </header>

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
                    <input type="number" id="poids-input" class="poids-input" 
                           value="<?= esc($utilisateur['poids']) ?>" 
                           step="0.1" min="30" max="300" 
                           placeholder="Nouveau poids">
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
                    <div class="info-value"><?= number_format($utilisateur['poids'] / pow($utilisateur['taille'] / 100, 2), 1) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Catégorie IMC</div>
                    <div class="info-value">
                        <?php 
                        $imc = $utilisateur['poids'] / pow($utilisateur['taille'] / 100, 2);
                        if ($imc < 18.5) echo 'Insuffisance pondérale';
                        elseif ($imc < 25) echo 'Poids normal';
                        elseif ($imc < 30) echo 'Surpoids';
                        else echo 'Obésité';
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
                reader.onload = function(e) {
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
        document.addEventListener('DOMContentLoaded', function() {
            const poidsInput = document.getElementById('poids-input');
            if (poidsInput) {
                poidsInput.addEventListener('keypress', function(e) {
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
