<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 2 - NutriGain</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
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
            overflow: hidden;
        }

        .progress-step.active {
            background: var(--primary);
        }

        .progress-step.completed {
            background: var(--success);
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

        .progress-label.completed {
            color: var(--success);
            font-weight: 600;
        }

        .progress-label.active {
            color: var(--primary);
            font-weight: 600;
        }

        /* FORM */
        .register-form {
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

        .input-group {
            position: relative;
        }

        .input-addon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-weight: 500;
            font-size: 14px;
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

        .info-box {
            background: var(--primary-light);
            border: 1px solid var(--primary);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box .icon {
            color: var(--primary);
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-box .content {
            flex: 1;
        }

        .info-box h4 {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .info-box p {
            color: var(--dark);
            font-size: 13px;
            line-height: 1.4;
        }

        @media (max-width: 640px) {
            .register-container {
                padding: 0;
            }
            
            .register-form {
                padding: 30px 20px;
                border-radius: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo">🥗 NutriGain</div>
            <h1>Informations santé</h1>
            <p>Dernière étape pour compléter votre profil</p>
        </div>

        <div class="progress-bar">
            <div class="progress-step completed"></div>
            <div class="progress-step active"></div>
        </div>

        <div class="progress-labels">
            <div class="progress-label completed">Informations</div>
            <div class="progress-label active">Santé</div>
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

        <form class="register-form" action="/sante/save" method="post">
            <?= csrf_field() ?>
            
            <div class="info-box">
                <div class="icon">💡</div>
                <div class="content">
                    <h4>Pourquoi ces informations ?</h4>
                    <p>Vos données de santé nous permettent de calculer votre IMC et de vous fournir des recommandations personnalisées.</p>
                </div>
            </div>

            <div class="form-section">
                <h3>Mesures corporelles</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="taille">Taille</label>
                        <div class="input-group">
                            <input type="number" id="taille" name="taille" class="form-control" 
                                   placeholder="170" min="100" max="250" required step="1">
                            <span class="input-addon">cm</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="poids">Poids</label>
                        <div class="input-group">
                            <input type="number" id="poids" name="poids" class="form-control" 
                                   placeholder="70" min="30" max="300" required step="0.1">
                            <span class="input-addon">kg</span>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Terminer l'inscription</button>
        </form>
    </div>

    <script>
        // Auto-focus sur le premier champ vide
        document.addEventListener('DOMContentLoaded', function() {
            const tailleField = document.getElementById('taille');
            const poidsField = document.getElementById('poids');
            
            if (!tailleField.value) {
                tailleField.focus();
            } else if (!poidsField.value) {
                poidsField.focus();
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
        const tailleField = document.getElementById('taille');
        tailleField.addEventListener('blur', function() {
            const taille = parseInt(this.value);
            
            if (taille && (taille < 100 || taille > 250)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });

        const poidsField = document.getElementById('poids');
        poidsField.addEventListener('blur', function() {
            const poids = parseFloat(this.value);
            
            if (poids && (poids < 30 || poids > 300)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</body>
</html>
