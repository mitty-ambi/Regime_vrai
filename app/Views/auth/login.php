<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Régime App</title>
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

        .login-container {
            max-width: 500px;
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

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--gray-light);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Manrope', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .form-input.error {
            border-color: var(--danger);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .btn {
            width: 100%;
            padding: 14px 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Manrope', sans-serif;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .alert-success {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary);
        }

        .alert-danger {
            background: #fef2f2;
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .register-link {
            text-align: center;
            margin-top: 24px;
            color: var(--gray);
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .back-link {
            text-align: center;
            margin-bottom: 24px;
        }

        .back-link a {
            color: var(--gray);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: var(--primary);
        }

        .input-group {
            position: relative;
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
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .clear-btn:hover {
            background: var(--gray-light);
            color: var(--dark);
        }

        .form-input:placeholder-shown + .clear-btn {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="back-link">
            <a href="/">← Retour à l'accueil</a>
        </div>

        <div class="login-header">
            <h1>Connexion</h1>
            <p>Bon retour parmi nous !</p>
        </div>

        <div class="login-card">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/authenticate" method="post">
                <div class="form-group">
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-group">
                        <input type="email" id="email" name="email" class="form-input" required 
                               value="<?= old('email') ?>" placeholder="exemple@email.com"
                               autocomplete="email">
                        <button type="button" class="clear-btn" onclick="clearInput('email')" title="Effacer">
                            ✕
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mot_de_passe" class="form-label">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-input" required 
                           placeholder="Entrez votre mot de passe" autocomplete="current-password">
                </div>

                <button type="submit" class="btn">Se connecter</button>
            </form>

            <div class="register-link">
                <p>Pas encore de compte ? <a href="/">Créez votre compte ici</a></p>
            </div>
        </div>
    </div>

    <script>
        function clearInput(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.value = '';
                input.focus();
            }
        }

        // Gérer l'affichage du bouton clear
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const clearBtn = emailInput?.nextElementSibling;
            
            if (emailInput && clearBtn) {
                function toggleClearBtn() {
                    if (emailInput.value.trim() !== '') {
                        clearBtn.style.display = 'flex';
                    } else {
                        clearBtn.style.display = 'none';
                    }
                }
                
                emailInput.addEventListener('input', toggleClearBtn);
                toggleClearBtn(); // État initial
            }
        });
    </script>
</body>
</html>
