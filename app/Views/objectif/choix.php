<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir vos objectifs - NutriGain</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --dark: #1f2937;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
            --light: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--light);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header .logo {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .header h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .header p {
            color: var(--gray);
            font-size: 16px;
        }

        .objectifs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .objectif-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 2px solid var(--gray-light);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .objectif-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .objectif-card.selected {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .objectif-card.selected::after {
            content: '✓';
            position: absolute;
            top: 16px;
            right: 16px;
            background: var(--primary);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .poids-input-container {
            margin-top: 16px;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
            display: none;
        }

        .poids-input-container {
            cursor: default;
        }

        .poids-input-container.show {
            display: block;
        }

        .poids-input-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .poids-input {
            flex: 1;
            padding: 8px 12px;
            border: 2px solid var(--gray-light);
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Manrope', sans-serif;
        }

        .poids-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .poids-label {
            font-size: 12px;
            color: var(--gray);
            font-weight: 500;
        }

        .objectif-icon {
            font-size: 48px;
            margin-bottom: 16px;
            text-align: center;
        }

        .objectif-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            text-align: center;
        }

        .objectif-description {
            font-size: 14px;
            color: var(--gray);
            text-align: center;
            line-height: 1.4;
        }

        .btn-container {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Manrope', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-secondary {
            background: var(--gray);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--dark);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .navigation {
            text-align: center;
            margin-bottom: 30px;
        }

        .navigation a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .navigation a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .objectifs-grid {
                grid-template-columns: 1fr;
            }

            .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
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
