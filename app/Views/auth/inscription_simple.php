<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 1 - NutriGain</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --dark: #1f2937;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
            --light: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--light);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .register-container {
            max-width: 600px;
            margin: 0 auto;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-header .logo {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .register-header h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .register-header p {
            color: var(--gray);
            font-size: 14px;
        }

        /* PROGRESS BAR */
        .progress-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
            justify-content: center;
        }

        .progress-step {
            flex: 1;
            height: 8px;
            background: var(--gray-light);
            border-radius: 4px;
            max-width: 80px;
            position: relative;
            overflow: hidden;
        }

        .progress-step.active {
            background: var(--primary);
        }

        .progress-step.completed::after {
            content: '✓';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 12px;
        }

        .progress-labels {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
            justify-content: center;
        }

        .progress-label {
            flex: 1;
            text-align: center;
            font-size: 12px;
            color: var(--gray);
            max-width: 80px;
        }

        .progress-label.active {
            color: var(--primary);
            font-weight: 600;
        }

        /* FORM CARD */
        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 24px;
        }

        .form-section {
            margin-bottom: 32px;
        }

        .form-section h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section h3::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary);
            border-radius: 2px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--gray-light);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Manrope', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .clear-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .clear-btn:hover {
            background: var(--gray-light);
            color: var(--dark);
        }

        .radio-group {
            display: flex;
            gap: 16px;
        }

        .radio-option {
            flex: 1;
            position: relative;
        }

        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .radio-label {
            display: block;
            padding: 12px 16px;
            border: 2px solid var(--gray-light);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .radio-option input[type="radio"]:checked + .radio-label {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .radio-label:hover {
            border-color: var(--primary);
        }

        .photo-upload-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .photo-preview {
            width: 120px;
            height: 120px;
            border: 2px dashed var(--gray-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 auto;
        }

        .photo-preview:hover {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            text-align: center;
            color: var(--gray);
        }

        .photo-icon {
            font-size: 32px;
            display: block;
            margin-bottom: 4px;
        }

        .photo-text {
            font-size: 12px;
            font-weight: 500;
        }

        .btn {
            width: 100%;
            padding: 14px 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Manrope', sans-serif;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .btn:disabled {
            background: var(--gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .login-link {
            text-align: center;
            color: var(--gray);
            font-size: 14px;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .register-container {
                padding: 0;
            }
            
            .form-card {
                padding: 30px 20px;
                border-radius: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .radio-group {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo">🥗 NutriGain</div>
            <h1>Créez votre compte</h1>
            <p>Rejoignez notre plateforme de suivi nutritionnel</p>
        </div>

        <div class="progress-bar">
            <div class="progress-step active"></div>
            <div class="progress-step"></div>
        </div>

        <div class="progress-labels">
            <div class="progress-label active">Informations</div>
            <div class="progress-label">Santé</div>
        </div>

        <?php if (session()->has('errors')): ?>
                <div class="alert alert-error">
                    <?php foreach (session('errors') as $error): ?>
                            <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
        <?php endif; ?>

        <form action="/auth/register" method="post">
            <?= csrf_field() ?>
            
            <div class="form-card">
                <div class="form-section">
                    <h3>Informations personnelles</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom complet</label>
                            <input type="text" id="nom" name="nom" class="form-control" 
                                   placeholder="Jean Dupont" required
                                   value="<?= old('nom') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="email" id="email" name="email" class="form-control" 
                                       placeholder="jean@example.com" required autocomplete="email"
                                       value="<?= old('email') ?>">
                                <button type="button" class="clear-btn" onclick="clearInput('email')">✕</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" 
                               placeholder="••••••••" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label>Genre</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="homme" name="genre" value="Homme" required>
                                <label for="homme" class="radio-label">👨 Homme</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="femme" name="genre" value="Femme" required>
                                <label for="femme" class="radio-label">👩 Femme</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo_profil">Photo de profil (optionnel)</label>
                        <div class="photo-upload-container">
                            <div class="photo-preview" id="photo-preview">
                                <div class="photo-placeholder">
                                    <span class="photo-icon">📷</span>
                                    <span class="photo-text">Ajouter une photo</span>
                                </div>
                            </div>
                            <input type="file" id="photo_profil" name="photo_profil" class="form-control" 
                                   accept="image/*" onchange="previewPhoto(event)">
                            <input type="hidden" id="photo_data" name="photo_data">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Continuer vers les infos santé</button>
        </form>

        <div class="login-link">
            <p>Déjà un compte ? <a href="/auth/login">Se connecter</a></p>
        </div>
    </div>

    <script>
        function clearInput(fieldId) {
            document.getElementById(fieldId).value = '';
            document.getElementById(fieldId).focus();
        }

        // Auto-focus sur le premier champ vide
        document.addEventListener('DOMContentLoaded', function() {
            const nomField = document.getElementById('nom');
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('mot_de_passe');
            
            if (!nomField.value) {
                nomField.focus();
            } else if (!emailField.value) {
                emailField.focus();
            } else if (!passwordField.value) {
                passwordField.focus();
            }
        });

        // Animation des champs
        document.querySelectorAll('.form-control').forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            field.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Validation en temps réel
        const emailField = document.getElementById('email');
        emailField.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });

        const passwordField = document.getElementById('mot_de_passe');
        passwordField.addEventListener('blur', function() {
            const password = this.value;
            
            if (password && password.length < 6) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });

        // Photo preview functionality
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photo-preview');
            const photoData = document.getElementById('photo_data');
            
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner une image valide.');
                    event.target.value = '';
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('L\'image ne doit pas dépasser 5MB.');
                    event.target.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Photo de profil">`;
                    photoData.value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Click on preview to trigger file input
        document.getElementById('photo-preview').addEventListener('click', function() {
            document.getElementById('photo_profil').click();
        });
    </script>
</body>
</html>
