<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un régime</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">
        <h1 class="page-title">➕ Ajouter un régime</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form action="/Regime/insert" method="POST" class="regime-form">
                <div class="form-group">
                    <label for="nom">Nom du régime :</label>
                    <input type="text" id="nom" name="nom" required placeholder="Ex: Régime Méditerranéen">
                </div>

                <div class="form-group">
                    <label for="type">Type :</label>
                    <select id="type" name="type" required>
                        <option value="">Sélectionnez un type</option>
                        <?php foreach ($liste_objectif as $objectifs) { ?>
                            <option value="<?= $objectifs['nom'] ?>">
                                ⚖️ <?= $objectifs['nom'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="prix">Prix (€) :</label>
                        <input type="number" step="0.01" id="prix" name="prix" required placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label for="duree">Durée (semaines) :</label>
                        <input type="number" id="duree" name="duree" required placeholder="4">
                    </div>
                </div>

                <div class="form-group">
                    <label for="variation">Variation de poids (kg) :</label>
                    <input type="number" step="0.1" id="variation" name="variation" required placeholder="-2.5 ou +3.0">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="viande">🥩 Pourcentage viande (%) :</label>
                        <input type="number" step="1" id="viande" name="viande" required placeholder="30">
                    </div>

                    <div class="form-group">
                        <label for="poisson">🐟 Pourcentage poisson (%) :</label>
                        <input type="number" step="1" id="poisson" name="poisson" required placeholder="30">
                    </div>

                    <div class="form-group">
                        <label for="volaille">🍗 Pourcentage volaille (%) :</label>
                        <input type="number" step="1" id="volaille" name="volaille" required placeholder="40">
                    </div>
                </div>

                <button type="submit" class="btn-submit">✅ Ajouter le régime</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="table-title">📋 Liste des régimes</h2>
            <table class="regime-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Prix</th>
                        <th>Durée(jours)</th>
                        <th>Variation poids</th>
                        <th>% Viande</th>
                        <th>% Poisson</th>
                        <th>% Volaille</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($liste_regime as $regime): ?>
                        <tr>
                            <td><?= $regime['nom'] ?></td>
                            <td><?= $regime['type'] ?></td>
                            <td><?= $regime['prix'] ?>$</td>
                            <td><?= $regime['duree'] ?> </td>
                            <td><?= $regime['variation_poids'] ?></td>
                            <td><?= $regime['pourcentage_viande'] ?></td>
                            <td><?= $regime['pourcentage_poisson'] ?></td>
                            <td><?= $regime['pourcentage_volaille'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>