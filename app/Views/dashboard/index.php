<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Régime App</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
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

        .info-value {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .edit-btn {
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-family: 'Manrope', sans-serif;
        }

        .edit-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .poids-input {
            width: 80px;
            padding: 4px 8px;
            border: 1px solid var(--gray-light);
            border-radius: 4px;
            font-size: 14px;
            margin-right: 8px;
        }

        .save-btn, .cancel-btn {
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            margin-left: 4px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-family: 'Manrope', sans-serif;
        }

        .save-btn {
            background: var(--success);
            color: white;
        }

        .save-btn:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .cancel-btn {
            background: var(--danger);
            color: white;
        }

        .cancel-btn:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        #poids-edit {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Header styles */
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

        /* Main content */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px;
        }

        .dashboard-header {
            margin-bottom: 32px;
        }

        .dashboard-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .section-header {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .info-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }
    </style>

</head>

<body>
    <?= view("navbar") ?>
    <?= view("sidebar") ?>

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
                    <div class="info-value">
                        <span id="poids-display"><?= esc($utilisateur['poids']) ?> kg</span>
                        <button class="edit-btn" onclick="showEditPoids()">📝 Modifier</button>
                    </div>
                    <div id="poids-edit" style="display: none;">
                        <input type="number" id="poids-input" value="<?= esc($utilisateur['poids']) ?>" 
                               min="30" max="300" step="0.1" class="poids-input">
                        <button onclick="savePoids()" class="save-btn">✓ Valider</button>
                        <button onclick="cancelEditPoids()" class="cancel-btn">✗ Annuler</button>
                    </div>
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
        function showMessage(message, type = 'success') {
            // Créer un élément pour le message
            const messageDiv = document.createElement('div');
            messageDiv.className = `alert alert-${type}`;
            messageDiv.textContent = message;
            messageDiv.style.cssText = `
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 1000;
                animation: slideInRight 0.3s ease-out;
            `;
            
            if (type === 'success') {
                messageDiv.style.background = '#f0fdf4';
                messageDiv.style.color = '#16a34a';
                messageDiv.style.border = '1px solid #bbf7d0';
            } else {
                messageDiv.style.background = '#fef2f2';
                messageDiv.style.color = '#dc2626';
                messageDiv.style.border = '1px solid #fecaca';
            }
            
            document.body.appendChild(messageDiv);
            
            // Supprimer le message après 3 secondes
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        function updatePhotoProfile(input) {
            const file = input.files[0];
            
            if (file) {
                if (!file.type.startsWith('image/')) {
                    showMessage('Veuillez sélectionner une image valide.', 'error');
                    input.value = '';
                    return;
                }
                
                if (file.size > 5 * 1024 * 1024) {
                    showMessage('L\'image ne doit pas dépasser 5MB.', 'error');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const photoData = e.target.result;
                    
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
                            const avatar = document.querySelector('.user-avatar img');
                            if (avatar) {
                                avatar.src = photoData;
                            } else {
                                const avatarContainer = document.querySelector('.user-avatar');
                                avatarContainer.innerHTML = `<img src="${photoData}" alt="Photo de profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                            }
                            
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
            
            input.value = '';
        }

        function showEditPoids() {
            document.getElementById('poids-display').parentElement.style.display = 'none';
            document.getElementById('poids-edit').style.display = 'block';
            document.getElementById('poids-input').focus();
        }

        function cancelEditPoids() {
            document.getElementById('poids-edit').style.display = 'none';
            document.getElementById('poids-display').parentElement.style.display = 'block';
        }

        function savePoids() {
            const nouveauPoids = parseFloat(document.getElementById('poids-input').value);
            
            if (!nouveauPoids || nouveauPoids < 30 || nouveauPoids > 300) {
                showMessage('Le poids doit être entre 30 et 300 kg', 'error');
                return;
            }

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
                if (data.success) {
                    // Mettre à jour l'affichage du poids
                    document.getElementById('poids-display').textContent = nouveauPoids + ' kg';
                    
                    // Calculer et mettre à jour l'IMC
                    const taille = <?= $utilisateur['taille'] ?>;
                    const nouvelIMC = nouveauPoids / Math.pow(taille / 100, 2);
                    
                    // Mettre à jour l'affichage de l'IMC
                    const imcElements = document.querySelectorAll('.info-value');
                    imcElements.forEach(element => {
                        if (element.textContent.includes('.')) { // C'est probablement l'IMC
                            element.textContent = nouvelIMC.toFixed(1);
                        }
                    });
                    
                    // Mettre à jour la catégorie IMC
                    let categorie = '';
                    if (nouvelIMC < 18.5) {
                        categorie = 'Insuffisance pondérale';
                    } else if (nouvelIMC < 25) {
                        categorie = 'Poids normal';
                    } else if (nouvelIMC < 30) {
                        categorie = 'Surpoids';
                    } else {
                        categorie = 'Obésité';
                    }
                    
                    // Mettre à jour la catégorie IMC
                    const categorieElements = document.querySelectorAll('.info-value');
                    categorieElements.forEach(element => {
                        if (element.textContent.includes('Insuffisance') || 
                            element.textContent.includes('Poids normal') || 
                            element.textContent.includes('Surpoids') || 
                            element.textContent.includes('Obésité')) {
                            element.textContent = categorie;
                        }
                    });
                    
                    cancelEditPoids();
                    showMessage('Poids mis à jour avec succès!', 'success');
                } else {
                    showMessage(data.message || 'Erreur lors de la mise à jour', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Erreur lors de la mise à jour', 'error');
            });
        }
    </script>
</body>

</html>