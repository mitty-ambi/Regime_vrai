<?php if (!isset($code)) $code = []; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un code</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">
        <h1 class="page-title">✏️ Modifier le code</h1>

        <div class="form-container">
            <form action="/codes/update/<?= $code['id'] ?>" method="POST" class="regime-form">
                <div class="form-group">
                    <label for="code">Code :</label>
                    <input type="text" id="code" name="code" value="<?= $code['code'] ?>" disabled style="background: #f0f0f0;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="montant">💰 Montant (€) :</label>
                        <input type="number" step="0.01" id="montant" name="montant" value="<?= $code['montant'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Statut :</label>
                        <div style="padding-top: 8px;">
                            <?php if ($code['est_utilise']): ?>
                                <span style="color: #ef4444; font-weight: 600;">🔒 Code utilisé</span>
                            <?php else: ?>
                                <span style="color: #10b981; font-weight: 600;">✅ Code disponible</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/codes/liste" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">💾 Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
