<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les activités</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">
        <h1 class="page-title">🏃 Gérer les activités</h1>

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
            <button class="tab-btn active" onclick="showTab('ajout')">➕ Ajouter une activité</button>
            <button class="tab-btn" onclick="showTab('liste')">📋 Liste des activités</button>
            <button class="tab-btn" onclick="showTab('associer')">🔗 Associer à un régime</button>
        </div>

        <!-- ONGLET AJOUT -->
        <div id="tab-ajout" class="tab-content active">
            <div class="form-container">
                <h2 class="form-title">➕ Ajouter une activité</h2>
                <form action="/Activites/insert" method="POST" class="regime-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom de l'activité :</label>
                            <input type="text" id="nom" name="nom" required placeholder="Ex: Course à pied">
                        </div>
                        <div class="form-group">
                            <label for="calories_brulees">🔥 Calories brûlées (par jour) :</label>
                            <input type="number" step="1" id="calories_brulees" name="calories_brulees" required placeholder="500">
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">✅ Ajouter l'activité</button>
                </form>
            </div>
        </div>

        <!-- ONGLET LISTE -->
        <div id="tab-liste" class="tab-content">
            <div class="table-container">
                <h2 class="table-title">📋 Liste des activités</h2>
                <table class="regime-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Calories brûlées / heure</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($liste_activite as $activite): ?>
                            <tr>
                                <td><strong><?= $activite['nom'] ?></strong></td>
                                <td>🔥 <?= $activite['calories_brulees'] ?> cal</td>
                                <td class="action-buttons">
                                    <a href="/Activites/update/<?= $activite['id'] ?>" class="btn-edit">✏️ Modifier</a>
                                    <a href="/Activites/supprimer/<?= $activite['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer cette activité ?')">🗑️ Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ONGLET ASSOCIER -->
        <div id="tab-associer" class="tab-content">
            <div class="form-container">
                <h2 class="form-title">🔗 Associer une activité à un régime</h2>
                <form action="/Activites/associer" method="POST" class="regime-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id_regime">Choisir un régime :</label>
                            <select name="id_regime" id="id_regime" required>
                                <option value="">-- Sélectionnez un régime --</option>
                                <?php foreach ($liste_regime as $regime): ?>
                                    <option value="<?= $regime['id'] ?>"><?= $regime['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_activite">Choisir une activité :</label>
                            <select name="id_activite" id="id_activite" required>
                                <option value="">-- Sélectionnez une activité --</option>
                                <?php foreach ($liste_activite as $activite): ?>
                                    <option value="<?= $activite['id'] ?>"><?= $activite['nom'] ?> (<?= $activite['calories_brulees'] ?> cal)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">🔗 Associer</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Cacher tous les onglets
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.classList.remove('active');
                tab.style.display = 'none';
            });
            
            // Désactiver tous les boutons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Afficher l'onglet sélectionné
            const selectedTab = document.getElementById('tab-' + tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }
            
            // Activer le bouton cliqué
            event.target.classList.add('active');
        }
        
        // Initialiser les onglets au chargement
        document.addEventListener('DOMContentLoaded', function() {
            // Cacher tous les onglets sauf le premier
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