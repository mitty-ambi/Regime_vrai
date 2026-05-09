<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - NutriGain</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h3 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
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
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align: center; color: #333;">Créer votre compte</h2>
        
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

        <form action="/auth/register" method="post">
            <!-- Formulaire d'inscription -->
            <div class="form-section">
                <h3>Informations personnelles</h3>
                
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" required 
                           value="<?= old('nom') ?>">
                    <?php if (isset($validation) && $validation->getError('nom')): ?>
                        <div class="error"><?= $validation->getError('nom') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required 
                           value="<?= old('email') ?>">
                    <?php if (isset($validation) && $validation->getError('email')): ?>
                        <div class="error"><?= $validation->getError('email') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe *</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    <?php if (isset($validation) && $validation->getError('mot_de_passe')): ?>
                        <div class="error"><?= $validation->getError('mot_de_passe') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <select id="genre" name="genre" required>
                        <option value="">Sélectionner...</option>
                        <option value="Homme" <?= old('genre') == 'Homme' ? 'selected' : '' ?>>Homme</option>
                        <option value="Femme" <?= old('genre') == 'Femme' ? 'selected' : '' ?>>Femme</option>
                    </select>
                    <?php if (isset($validation) && $validation->getError('genre')): ?>
                        <div class="error"><?= $validation->getError('genre') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Formulaire informations santé -->
            <div class="form-section">
                <h3>Informations santé</h3>
                
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
            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn">S'inscrire</button>
            </div>
        </form>

        <div class="login-link">
            <p>Déjà un compte ? <a href="/auth/login">Connectez-vous ici</a></p>
        </div>
    </div>
</body>
</html>
