<?php if (!isset($codes)) $codes = []; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des codes</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">
        <h1 class="page-title">💳 Gestion des codes promo</h1>

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

        <!-- ONGLETS -->
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('ajout')">➕ Ajouter un code</button>
            <button class="tab-btn" onclick="showTab('liste')">📋 Liste des codes</button>
        </div>

        <!-- ONGLET AJOUT -->
        <div id="tab-ajout" class="tab-content active">
            <div class="form-container">
                <h2 class="form-title">➕ Créer un nouveau code</h2>
                <form action="/codes/inserer" method="POST" class="regime-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="code">Code :</label>
                            <input type="text" id="code" name="code" required placeholder="Ex: WELCOME10" style="text-transform: uppercase;">
                        </div>

                        <div class="form-group">
                            <label for="montant">💰 Montant (€) :</label>
                            <input type="number" step="0.01" id="montant" name="montant" required placeholder="10.00">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">✅ Créer le code</button>
                </form>
            </div>
        </div>

        <!-- ONGLET LISTE -->
        <div id="tab-liste" class="tab-content">
            <div class="table-container">
                <h2 class="table-title">📋 Liste de tous les codes</h2>
                <table class="regime-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($codes as $code): ?>
                            <tr>
                                <td><strong><?= $code['code'] ?></strong></td>
                                <td>💰 <?= $code['montant'] ?>€</td>
                                <td>
                                    <?php if ($code['est_utilise']): ?>
                                        <span style="color: #ef4444; font-weight: 600;">🔒 Utilisé</span>
                                    <?php else: ?>
                                        <span style="color: #10b981; font-weight: 600;">✅ Disponible</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-buttons">
                                    <a href="/codes/modifier/<?= $code['id'] ?>" class="btn-edit">✏️ Modifier</a>
                                    <a href="/codes/supprimer/<?= $code['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer ce code ?')">🗑️ Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.classList.remove('active');
                tab.style.display = 'none';
            });

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            const selectedTab = document.getElementById('tab-' + tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }

            event.target.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach((tab, index) => {
                if (index !== 0) {
                    tab.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>
