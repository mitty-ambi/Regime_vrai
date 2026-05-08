<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Régime App</title>
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
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                🥗 Régime App
            </div>
            <div class="nav-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        <?= strtoupper(substr(esc($utilisateur['nom']), 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--dark);"><?= esc($utilisateur['nom']) ?></div>
                        <div style="font-size: 0.85rem; color: var(--gray);"><?= esc($utilisateur['email']) ?></div>
                    </div>
                </div>
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
</body>
</html>
