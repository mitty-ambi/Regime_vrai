<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter du crédit</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
    <style>
        .credit-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .credit-card h3 {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .credit-amount {
            font-size: 32px;
            font-weight: bold;
        }

        .gold-badge {
            display: inline-block;
            background: rgba(255, 215, 0, 0.3);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 10px;
            border: 1px solid rgba(255, 215, 0, 0.5);
        }
    </style>
</head>

<body>

    <?= view("navbar") ?>

    <div class="container">
        <h1 class="page-title">💰 Ajouter du crédit</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('utilisateur')): ?>
            <?php $utilisateur = session()->get('utilisateur'); ?>
            <div class="credit-card">
                <h3>💳 Votre solde actuel</h3>
                <div class="credit-amount"><?= number_format($utilisateur['solde'], 2) ?>€</div>
                <?php if (isset($utilisateur['is_gold']) && $utilisateur['is_gold']): ?>
                    <div class="gold-badge">⭐ Abonné GOLD</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h2 class="form-title">🎁 Entrez votre code promo</h2>
            
            <?php if (!session()->has('utilisateur')): ?>
                <div style="background: #fee2e2; padding: 20px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 20px;">
                    <p style="font-size: 14px; color: #991b1b; margin-bottom: 15px;">
                        🔐 <strong>Vous devez être connecté pour utiliser un code</strong>
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <a href="/auth/login" style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">Se connecter</a>
                        <a href="/" style="background: #10b981; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">S'inscrire</a>
                    </div>
                </div>
            <?php else: ?>
                <form action="/codes/valider" method="POST" class="regime-form">
                    <div class="form-group">
                        <label for="code">Code promo :</label>
                        <input type="text" id="code" name="code" required placeholder="Entrez votre code ici" style="text-transform: uppercase; font-size: 16px; letter-spacing: 2px;">
                    </div>

                    <div style="background: #f0fdf4; padding: 15px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #10b981;">
                        <p style="font-size: 14px; color: #047857;">
                            💡 Entrez le code promo que vous avez reçu pour ajouter du crédit à votre porte-monnaie. Les codes peuvent être utilisés une seule fois.
                        </p>
                    </div>

                    <button type="submit" class="btn-submit">✅ Valider le code</button>
                </form>
            <?php endif; ?>
        </div>

        <div style="background: #eff6ff; padding: 20px; border-radius: 12px; border-left: 4px solid #3b82f6; margin-top: 30px;">
            <h3 style="margin-bottom: 10px;">📌 Comment ça marche ?</h3>
            <ul style="margin-left: 20px; font-size: 14px; line-height: 1.8; color: #1f2937;">
                <li>Entrez votre code promo dans le champ ci-dessus</li>
                <li>Le crédit sera automatiquement ajouté à votre solde</li>
                <li>Chaque code ne peut être utilisé qu'une seule fois</li>
                <li>Utilisez votre crédit pour acheter des régimes et des activités</li>
            </ul>
        </div>
    </div>

</body>

</html>
