<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Régime App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
        .welcome h1 {
            color: #333;
            margin: 0;
        }
        .user-info {
            color: #666;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .profile-section {
            margin-bottom: 30px;
        }
        .profile-section h3 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        .info-item {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
            font-size: 18px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome">
                <h1>Bienvenue, <?= esc($utilisateur['nom']) ?> !</h1>
                <div class="user-info">Connecté en tant que : <?= esc($utilisateur['email']) ?></div>
            </div>
            <a href="/auth/logout" class="logout-btn">Déconnexion</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="profile-section">
            <h3>Profil</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nom</div>
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

        <div class="profile-section">
            <h3>Informations santé</h3>
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
            </div>
        </div>
    </div>
</body>
</html>
