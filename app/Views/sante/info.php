<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 2 - Régime App</title>
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

        .register-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .register-header p {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gray-light);
            z-index: 1;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gray-light);
            color: var(--gray);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step-number.active {
            background: var(--primary);
            color: white;
        }

        .step-number.completed {
            background: var(--success);
            color: white;
        }

        .step-label {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .step-label.active {
            color: var(--primary);
            font-weight: 600;
        }

        .step-label.completed {
            color: var(--success);
            font-weight: 600;
        }

        .register-card {
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

        .alert-info {
            background: #e0f2fe;
            color: #0369a1;
            border-left: 4px solid #0ea5e9;
        }

        .info-box {
            background: #f0fdf4;
            border: 1px solid var(--primary-light);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .info-box h3 {
            color: var(--primary-dark);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .info-box p {
            color: var(--gray);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .input-group {
            position: relative;
        }

        .input-suffix {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Informations santé</h1>
            <p>Dernière étape pour personnaliser votre expérience</p>
        </div>

        <div class="progress-bar">
            <div class="progress-step">
                <div class="step-number completed">1</div>
                <div class="step-label completed">Informations</div>
            </div>
            <div class="progress-step">
                <div class="step-number active">2</div>
                <div class="step-label active">Santé</div>
            </div>
        </div>

        <div class="register-card">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php $errors = session()->getFlashdata('errors'); ?>
                    <?php if (is_array($errors)): ?>
                        <?php foreach ($errors as $error): ?>
                            <div class="error-message"><?= $error ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="error-message"><?= $errors ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="info-box">
                <h3>📊 Pourquoi ces informations ?</h3>
                <p>Vos données de santé nous permettent de calculer votre IMC et de vous proposer des recommandations personnalisées pour atteindre vos objectifs.</p>
            </div>

            <form action="/sante/save" method="post">
                <div class="form-group">
                    <label for="taille" class="form-label">Taille *</label>
                    <div class="input-group">
                        <input type="number" id="taille" name="taille" class="form-input" required 
                               min="50" max="300" step="0.1" value="<?= old('taille') ?>" placeholder="170">
                        <span class="input-suffix">cm</span>
                    </div>
                    <?php if (isset($validation) && $validation->getError('taille')): ?>
                        <div class="error-message"><?= $validation->getError('taille') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="poids" class="form-label">Poids *</label>
                    <div class="input-group">
                        <input type="number" id="poids" name="poids" class="form-input" required 
                               min="1" max="500" step="0.1" value="<?= old('poids') ?>" placeholder="70">
                        <span class="input-suffix">kg</span>
                    </div>
                    <?php if (isset($validation) && $validation->getError('poids')): ?>
                        <div class="error-message"><?= $validation->getError('poids') ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn">Terminer l'inscription</button>
            </form>
        </div>
    </div>
</body>
</html>
