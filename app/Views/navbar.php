<header>
    <nav>
        <div class="logo">
            🥗 Régime App
        </div>
        <div class="nav-right">
            <?php if (session()->get('is_logged_in')): ?>
                <a href="/objectif/choix" class="nav-link">🎯 Objectifs</a>
                <?php $user = session()->get('utilisateur'); ?>
                <div class="user-profile">
                    <div class="user-avatar">
                        <?= strtoupper(substr(esc($user['nom']), 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--dark);">
                            <?= esc($user['nom']) ?>
                        </div>
                        <div style="font-size: 0.85rem; color: var(--gray);">
                            💰
                            <?= number_format($user['solde'], 2) ?>€
                        </div>
                    </div>
                </div>
                <a href="/codes/ajouter-credit" class="credit-btn">
                    💳 Créditer</a>
                <a href="/auth/logout" class="logout-btn">Déconnexion</a>
            <?php else: ?>
                <a href="/auth/login" class="login-btn">Connexion</a>
                <a href="/" class="register-btn">Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>"