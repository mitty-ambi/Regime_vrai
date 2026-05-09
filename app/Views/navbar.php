<header>
    <nav>
        <div class="logo">
            🥗 Régime 
        </div>
        <div class="nav-right">
            <?php if (session()->get('is_logged_in')): ?>
                <?php $user = session()->get('utilisateur'); ?>
                <div class="user-profile">
                    <div class="user-avatar" style="position: relative; cursor: pointer;">
                        <?= strtoupper(substr(esc($user['nom']), 0, 1)) ?>
                        <div class="edit-photo-btn" onclick="document.getElementById('photo_upload').click()">📷</div>
                        <input type="file" id="photo_upload" style="display: none;" accept="image/*"
                            onchange="updatePhotoProfile(this)">
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
                <a href="/objectif/choix" class="credit-btn"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    💳 Objectifs</a>

                <a href="/codes/ajouter-credit" class="credit-btn"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    💳 Créditer</a>
                <a href="/auth/logout" class="logout-btn">Déconnexion</a>
            <?php else: ?>
                <a href="/auth/login" class="login-btn">Connexion</a>
                <a href="/" class="register-btn">Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script src="<?= base_url('assets/js/profile.js') ?>"></script>