<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations santé - Régime App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .step-indicator {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
        }
        .step-indicator .step {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 5px;
            border-radius: 20px;
            background-color: #e9ecef;
            color: #6c757d;
        }
        .step-indicator .step.active {
            background-color: #007bff;
            color: white;
        }
        .step-indicator .step.completed {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="step-indicator">
            <span class="step completed">Étape 1</span>
            <span class="step active">Étape 2</span>
        </div>
        
        <h2>Informations santé</h2>
        
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
                        <div class="error"><?= $error ?></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="error"><?= $errors ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="alert alert-info">
            Veuillez compléter vos informations de santé pour personnaliser votre expérience.
        </div>

        <form action="/sante/save" method="post">
            <div class="form-group">
                <label for="taille">Taille (cm) *</label>
                <input type="number" id="taille" name="taille" required 
                       min="50" max="300" step="0.1" value="<?= old('taille') ?>">
                <?php if (isset($validation) && $validation->getError('taille')): ?>
                    <div class="error"><?= $validation->getError('taille') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="poids">Poids (kg) *</label>
                <input type="number" id="poids" name="poids" required 
                       min="1" max="500" step="0.1" value="<?= old('poids') ?>">
                <?php if (isset($validation) && $validation->getError('poids')): ?>
                    <div class="error"><?= $validation->getError('poids') ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Enregistrer et terminer</button>
        </form>
    </div>
</body>
</html>
