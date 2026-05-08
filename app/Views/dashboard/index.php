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
                <div class="stat-value"><?= esc($utilisateur['poids']) ?></div>
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
                    <div class="info-value"><?= esc($utilisateur['poids']) ?> kg</div>
                </div>
                <div class="info-item">
                    <div class="info-label">IMC</div>
                    <div class="info-value">
                        <?= number_format($utilisateur['poids'] / pow($utilisateur['taille'] / 100, 2), 1) ?>
                    </div>
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
</body>

</html>