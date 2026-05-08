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
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        form {
            width: 400px;
            margin: auto;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
        }

        button {
            background: green;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>➕ Ajouter un régime</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="/Regime/insert" method="POST">
        <label>Nom du régime :</label>
        <input type="text" name="nom" required>

        <label>Type :</label>
        <select name="type" required>
            <option value="augmentation">Augmentation</option>
            <option value="reduction">Réduction</option>
            <option value="IMC ideal">IMC idéal</option>
        </select>

        <label>Prix (€) :</label>
        <input type="number" step="0.01" name="prix" required>

        <label>Durée (semaines) :</label>
        <input type="number" name="duree" required>

        <label>Variation de poids (kg) :</label>
        <input type="number" step="0.1" name="variation" required>

        <label>Pourcentage viande (%) :</label>
        <input type="number" step="1" name="viande" required>

        <label>Pourcentage poisson (%) :</label>
        <input type="number" step="1" name="poisson" required>

        <label>Pourcentage volaille (%) :</label>
        <input type="number" step="1" name="volaille" required>

        <button type="submit">✅ Ajouter le régime</button>
    </form>
    liste :
    <?php foreach ($liste_regime as $regime) { ?>
        <p>id : <?= $regime['id'] ?></p>
    <?php } ?>
</body>

</html>