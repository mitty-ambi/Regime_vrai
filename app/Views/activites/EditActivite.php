<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une activité</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/CrudRegime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">
        <h1 class="page-title">✏️ Modifier l'activité</h1>

        <div class="form-container">
            <form action="/Activites/edit/<?= $activite['id'] ?>" method="POST" class="regime-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom de l'activité :</label>
                        <input type="text" id="nom" name="nom" value="<?= $activite['nom'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="calories_brulees">🔥 Calories brûlées (par heure) :</label>
                        <input type="number" step="1" id="calories_brulees" name="calories_brulees"
                            value="<?= $activite['calories_brulees'] ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/Activites/add" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">💾 Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>