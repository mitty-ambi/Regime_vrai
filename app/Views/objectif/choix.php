<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir vos objectifs - NutriGain</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/objectif.css') ?>">


</head>
<body>
    
    <?= view("navbar") ?>
    <?= view("sidebar") ?>
    <div class="container">
        <div class="header">
            <div class="logo">🥗 NutriGain</div>
            <h1>Choisissez vos objectifs</h1>
            <p>Sélectionnez jusqu'à 3 objectifs pour personnaliser votre expérience</p>
        </div>

        <div class="navigation">
            <a href="/dashboard">← Retour au dashboard</a>
        </div>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-error">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form id="objectifsForm">
            <div class="objectifs-grid">
                <?php foreach ($objectifs as $objectif): ?>
                    <div class="objectif-card" onclick="toggleObjectif(this, <?= $objectif['id'] ?>)">
                        <div class="objectif-icon">
                            <?php
                            $icon = '🎯';
                            if (strpos($objectif['nom'], 'Augmenter') !== false)
                                $icon = '⬆️';
                            elseif (strpos($objectif['nom'], 'Réduire') !== false)
                                $icon = '⬇️';
                            elseif (strpos($objectif['nom'], 'IMC') !== false)
                                $icon = '⚖️';
                            ?>
                            <?= $icon ?>
                        </div>
                        <div class="objectif-title">
                            <?= esc($objectif['nom']) ?>
                        </div>

                        <?php if (strpos($objectif['nom'], 'Augmenter') !== false): ?>
                            <div class="poids-input-container" id="poids-augmenter-<?= $objectif['id'] ?>"
                                onclick="event.stopPropagation()">
                                <div class="poids-input-group">
                                    <input type="number" class="poids-input" id="poids-augmenter-value-<?= $objectif['id'] ?>"
                                        placeholder="Ex: 5" min="0.5" max="50" step="0.5" onclick="event.stopPropagation()"
                                        onfocus="event.stopPropagation()">
                                    <span class="poids-label">kg à prendre</span>
                                </div>
                            </div>
                        <?php elseif (strpos($objectif['nom'], 'Réduire') !== false): ?>
                            <div class="poids-input-container" id="poids-reduire-<?= $objectif['id'] ?>"
                                onclick="event.stopPropagation()">
                                <div class="poids-input-group">
                                    <input type="number" class="poids-input" id="poids-reduire-value-<?= $objectif['id'] ?>"
                                        placeholder="Ex: 3" min="0.5" max="50" step="0.5" onclick="event.stopPropagation()"
                                        onfocus="event.stopPropagation()">
                                    <span class="poids-label">kg à perdre</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="btn-container">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='/dashboard'">
                    Plus tard
                </button>
                <button type="submit" class="btn btn-primary">
                    Enregistrer mes objectifs
                </button>
            </div>
        </form>
    </div>

    <script>
        let selectedObjectifs = [];

        // Pré-sélectionner les objectifs déjà choisis
        <?php foreach ($userObjectifs as $userObjectif): ?>
            selectedObjectifs.push(<?= $userObjectif['objectif_id'] ?>);
            document.querySelector('.objectif-card').classList.add('selected');
        <?php endforeach; ?>

        function toggleObjectif(card, objectifId) {
            const index = selectedObjectifs.indexOf(objectifId);

            if (index > -1) {
                selectedObjectifs.splice(index, 1);
                card.classList.remove('selected');

                // Cacher le champ de poids correspondant
                const poidsAugmenter = document.getElementById('poids-augmenter-' + objectifId);
                const poidsReduire = document.getElementById('poids-reduire-' + objectifId);
                if (poidsAugmenter) poidsAugmenter.classList.remove('show');
                if (poidsReduire) poidsReduire.classList.remove('show');
            } else {
                if (selectedObjectifs.length >= 3) {
                    alert('Vous pouvez choisir au maximum 3 objectifs');
                    return;
                }
                selectedObjectifs.push(objectifId);
                card.classList.add('selected');

                // Afficher le champ de poids correspondant
                const poidsAugmenter = document.getElementById('poids-augmenter-' + objectifId);
                const poidsReduire = document.getElementById('poids-reduire-' + objectifId);
                if (poidsAugmenter) poidsAugmenter.classList.add('show');
                if (poidsReduire) poidsReduire.classList.add('show');
            }
        }

        document.getElementById('objectifsForm').addEventListener('submit', function (e) {
            e.preventDefault();

            if (selectedObjectifs.length === 0) {
                alert('Veuillez choisir au moins un objectif');
                return;
            }

            // Préparer les données avec les poids
            const objectifsData = [];
            selectedObjectifs.forEach(objectifId => {
                const objectifData = {
                    id: objectifId,
                    poids: null
                };

                // Vérifier si c'est un objectif d'augmentation ou de réduction
                const poidsAugmenterInput = document.getElementById('poids-augmenter-value-' + objectifId);
                const poidsReduireInput = document.getElementById('poids-reduire-value-' + objectifId);

                if (poidsAugmenterInput) {
                    const poids = parseFloat(poidsAugmenterInput.value);
                    if (poids && poids > 0) {
                        objectifData.poids = poids;
                    } else {
                        alert('Veuillez spécifier le nombre de kilos à prendre');
                        poidsAugmenterInput.focus();
                        return;
                    }
                } else if (poidsReduireInput) {
                    const poids = parseFloat(poidsReduireInput.value);
                    if (poids && poids > 0) {
                        objectifData.poids = poids;
                    } else {
                        alert('Veuillez spécifier le nombre de kilos à perdre');
                        poidsReduireInput.focus();
                        return;
                    }
                }
                objectifsData.push(objectifData);
            });

            fetch('/objectif/sauvegarder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    objectifs: objectifsData
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/dashboard';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la sauvegarde');
                });
        });
    </script>
</body>

</html>
