<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un régime</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">
        <h1 class="page-title">✏️ Modifier le régime</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form action="/Regime/edit/<?= $regime['id'] ?>" method="POST" class="regime-form">
                <div class="form-group">
                    <label for="nom">Nom du régime :</label>
                    <input type="text" id="nom" name="nom" value="<?= $regime['nom'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="type">Type :</label>
                    <select id="type" name="type" required>
                        <?php foreach ($liste_objectif as $objectif): ?>
                            <option value="<?= $objectif['nom'] ?>" <?= $regime['type'] == $objectif['nom'] ? 'selected' : '' ?>>
                                ⚖️ <?= $objectif['nom'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="prix">Prix (€) :</label>
                        <input type="number" step="0.01" id="prix" name="prix" value="<?= $regime['prix'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="duree">Durée (semaines) :</label>
                        <input type="number" id="duree" name="duree" value="<?= $regime['duree'] ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="variation">Variation de poids (kg) :</label>
                    <input type="number" step="0.1" id="variation" name="variation"
                        value="<?= $regime['variation_poids'] ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="viande">🥩 Pourcentage viande (%) :</label>
                        <input type="number" step="1" id="viande" name="viande"
                            value="<?= $regime['pourcentage_viande'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="poisson">🐟 Pourcentage poisson (%) :</label>
                        <input type="number" step="1" id="poisson" name="poisson"
                            value="<?= $regime['pourcentage_poisson'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="volaille">🍗 Pourcentage volaille (%) :</label>
                        <input type="number" step="1" id="volaille" name="volaille"
                            value="<?= $regime['pourcentage_volaille'] ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/Regime/go_to_regime" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">💾 Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>