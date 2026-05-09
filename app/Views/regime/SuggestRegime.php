<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestion de regime</title>
</head>

<body>
    <h1>Suggestion de Regime</h1>

    <!-- filtre le regime en fonction de l objectif -->
    <section>
        <form action="">
            <!-- selection de l objectif -->
            <label for="input_objectifs"></label>
            <select name="objectifs" id="">
                <?php foreach ($liste_objectif as $objectifs) { ?>
                    <option value="<?= $objectifs['nom'] ?>">
                        ⚖️ <?= $objectifs['nom'] ?>
                    </option>
                <?php } ?>
            </select>

            <!-- selection du durrer -->
            <label for="input_durrer">Durer du regime</label>
            <input type="number" name="durrer" id="input_durrer">

            <!-- selection du type de proteinne preferer -->
            <p>
                proteine preferer :
                <label for="radio_viande">viande</label>
                <input type="radio" name="preference" id="radio_viande" value="viande">

                <label for="radio_volaille">volaille</label>
                <input type="radio" name="preference" id="radio_volaille" value="volaille">

                <label for="radio_poisson">poisson</label>
                <input type="radio" name="preference" id="radio_poisson" value="poisson">
            </p>
            <input type="submit" value="Rechercher">
        </form>
    </section>

    <section>
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
                        <th>Actions</th>
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
                            <td class="action-buttons">
                                <a href="/Regime/update/<?= $regime['id'] ?>" class="btn-edit">✏️ Modifier</a>
                                <a href="/Regime/supprimer/<?= $regime['id'] ?>" class="btn-delete"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ?')">🗑️ Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>