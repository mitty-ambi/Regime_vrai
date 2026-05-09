<?php
use App\Models\SanteModel;
$santeModel = new SanteModel();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestion de régime</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/suggestion_regime.css') ?>">
</head>

<body>

    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="container">

        <!-- ── En-tête ── -->
        <div class="page-header">
            <h1 class="page-title">🥗 Suggestion de régime</h1>
            <p class="page-subtitle">Filtrez et trouvez le plan nutritionnel adapté à vos objectifs</p>
        </div>

        <!-- ── Alertes flash ── -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- ── Carte de filtres ── -->
        <div class="filter-card">
            <h2 class="filter-card__title">Filtres de recherche</h2>

            <form action="/Regime/get/suggestion" method="get" class="filter-form">

                <div class="filter-grid">

                    <!-- Objectif -->
                    <div class="filter-group">
                        <label for="objectif_id">Objectif</label>
                        <div class="select-wrapper">
                            <select name="objectif_id" id="objectif_id">
                                <?php foreach ($liste_objectif as $objectif): ?>
                                    <option
                                        value="<?= $objectif['id'] ?>"
                                        <?= (isset($_GET['objectif_id']) && $_GET['objectif_id'] == $objectif['id']) ? 'selected' : '' ?>>
                                        ⚖️ <?= esc($objectif['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="select-arrow">&#8964;</span>
                        </div>
                    </div>

                    <!-- Durée -->
                    <div class="filter-group">
                        <label for="durrer">Durée (semaines)</label>
                        <input
                            type="number"
                            name="durrer"
                            id="durrer"
                            placeholder="ex : 8"
                            min="1"
                            value="<?= esc($_GET['durrer'] ?? '') ?>">
                    </div>

                    <!-- Variation voulue -->
                    <div class="filter-group">
                        <label for="variationVoulu">Variation souhaitée (kg)</label>
                        <input
                            type="number"
                            name="variationVoulu"
                            id="variationVoulu"
                            placeholder="ex : −5"
                            step="0.5"
                            value="<?= esc($_GET['variationVoulu'] ?? '') ?>">
                    </div>

                </div><!-- /.filter-grid -->

                <!-- Préférence protéine -->
                <span class="protein-row-label">Protéine préférée</span>
                <div class="protein-row">

                    <label class="protein-chip <?= (($_GET['preference'] ?? '') === 'viande')  ? 'selected' : '' ?>">
                        <input type="radio" name="preference" value="viande"
                            <?= (($_GET['preference'] ?? '') === 'viande')  ? 'checked' : '' ?>>
                        🥩 Viande
                    </label>

                    <label class="protein-chip <?= (($_GET['preference'] ?? '') === 'volaille') ? 'selected' : '' ?>">
                        <input type="radio" name="preference" value="volaille"
                            <?= (($_GET['preference'] ?? '') === 'volaille') ? 'checked' : '' ?>>
                        🍗 Volaille
                    </label>

                    <label class="protein-chip <?= (($_GET['preference'] ?? '') === 'poisson')  ? 'selected' : '' ?>">
                        <input type="radio" name="preference" value="poisson"
                            <?= (($_GET['preference'] ?? '') === 'poisson')  ? 'checked' : '' ?>>
                        🐟 Poisson
                    </label>

                </div><!-- /.protein-row -->

                <button type="submit" class="btn-search">
                    🔍 Rechercher des régimes
                </button>

            </form>
        </div><!-- /.filter-card -->

        <!-- ── Bloc IMC (affiché uniquement si les données sont disponibles) ── -->
        <?php if (isset($data_imc_ideal)): ?>
            <div class="imc-card">
                <span class="imc-card__label">📊 Informations IMC</span>

                <div class="imc-stats">
                    <div class="imc-stat">
                        <span class="stat-label">IMC actuel</span>
                        <span class="stat-val"><?= number_format($data_imc_ideal['imc'], 1) ?></span>
                    </div>
                    <div class="imc-divider"></div>
                    <div class="imc-stat">
                        <span class="stat-label">IMC idéal</span>
                        <span class="stat-val"><?= number_format($data_imc_ideal['imc_ideal'], 1) ?></span>
                    </div>
                    <div class="imc-divider"></div>
                    <div class="imc-stat">
                        <span class="stat-label">Poids actuel</span>
                        <span class="stat-val"><?= number_format($data_imc_ideal['poids'], 1) ?> <span class="stat-unit">kg</span></span>
                    </div>
                    <div class="imc-divider"></div>
                    <div class="imc-stat">
                        <span class="stat-label">Poids pour IMC idéal</span>
                        <span class="stat-val"><?= number_format($data_imc_ideal['poids_ideal'], 1) ?> <span class="stat-unit">kg</span></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ── Tableau des régimes ── -->
        <div class="table-section">

            <div class="table-section-header">
                <h2 class="table-section-header__title">📋 Liste des régimes</h2>
                <?php if (!empty($liste_regime)): ?>
                    <span class="result-count"><?= count($liste_regime) ?> résultat<?= count($liste_regime) > 1 ? 's' : '' ?></span>
                <?php endif; ?>
            </div>

            <?php if (empty($liste_regime)): ?>
                <div class="empty-state">
                    <span class="empty-state__icon">🔎</span>
                    <p class="empty-state__text">Aucun régime ne correspond à vos critères.</p>
                    <p class="empty-state__hint">Essayez d'élargir vos filtres.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="regime-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Prix</th>
                                <th>Durée</th>
                                <th>Variation poids</th>
                                <th>% Viande</th>
                                <th>% Poisson</th>
                                <th>% Volaille</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($liste_regime as $regime): ?>
                                <?php
                                    $variation   = (float) $regime['variation_poids'];
                                    $pctViande   = (int)   $regime['pourcentage_viande'];
                                    $pctPoisson  = (int)   $regime['pourcentage_poisson'];
                                    $pctVolaille = (int)   $regime['pourcentage_volaille'];
                                    $variationClass = $variation >= 0 ? 'variation-pos' : 'variation-neg';
                                    $variationSign  = $variation >= 0 ? '+' : '';
                                ?>
                                <tr>
                                    <!-- Nom -->
                                    <td class="regime-name"><?= esc($regime['nom']) ?></td>

                                    <!-- Type -->
                                    <td>
                                        <span class="type-badge">
                                            ⚖️ <?= esc($regime['type']) ?>
                                        </span>
                                    </td>

                                    <!-- Prix -->
                                    <td class="cell-price"><?= number_format($regime['prix'], 2) ?> $</td>

                                    <!-- Durée -->
                                    <td><?= (int) $regime['duree'] ?> j</td>

                                    <!-- Variation poids -->
                                    <td>
                                        <span class="<?= $variationClass ?>">
                                            <?= $variationSign . number_format($variation, 1) ?> kg
                                        </span>
                                    </td>

                                    <!-- % Viande -->
                                    <td>
                                        <div class="pct-bar">
                                            <div class="pct-track">
                                                <div class="pct-fill" style="width: <?= min($pctViande, 100) ?>%"></div>
                                            </div>
                                            <span class="pct-label"><?= $pctViande ?> %</span>
                                        </div>
                                    </td>

                                    <!-- % Poisson -->
                                    <td>
                                        <div class="pct-bar">
                                            <div class="pct-track">
                                                <div class="pct-fill" style="width: <?= min($pctPoisson, 100) ?>%"></div>
                                            </div>
                                            <span class="pct-label"><?= $pctPoisson ?> %</span>
                                        </div>
                                    </td>

                                    <!-- % Volaille -->
                                    <td>
                                        <div class="pct-bar">
                                            <div class="pct-track">
                                                <div class="pct-fill" style="width: <?= min($pctVolaille, 100) ?>%"></div>
                                            </div>
                                            <span class="pct-label"><?= $pctVolaille ?> %</span>
                                        </div>
                                    </td>

                                    <!-- Bouton Acheter -->
                                    <td>
                                        <a href="/Regime/acheter/<?= $regime['id'] ?>" class="btn-buy">
                                            🛒 Acheter
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- /.table-wrap -->
            <?php endif; ?>

        </div><!-- /.table-section -->

    </div><!-- /.container -->

    <script>
        /* ── Chips protéine : synchronise la classe CSS avec l'état du radio ── */
        document.querySelectorAll('.protein-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                document.querySelectorAll('.protein-chip').forEach(c => c.classList.remove('selected'));
                chip.classList.add('selected');
            });
        });
    </script>

</body>
</html>