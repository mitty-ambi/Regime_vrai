<?php
if (session()->getFlashdata('succes')) {
    var_dump(session()->getFlashdata('succes'));
}
if (session()->getFlashdata('erreur')) {
    var_dump(session()->getFlashdata('erreur'));
}
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
        <section class="message">
            <?php if (session()->get('achat_effectuer')) { ?>
                <p class="message-success">Achat effectué avec succès</p>
            <?php } ?>
            <?php if (session()->get('erreur_solde_insufisant')) { ?>
                <p class="message-error">Erreur : solde insuffisant</p>
            <?php } ?>
        </section>
        <section>
            <div class="obj-grid">

                <div class="obj-card accent-top">
                    <span class="obj-label">Objectif</span>
                    <div><span class="obj-badge"><?= esc($objectif['objectif_nom']) ?></span></div>
                </div>

                <div class="obj-card">
                    <span class="obj-label">Poids initial</span>
                    <div class="obj-value"><?= $objectif['poids_initial'] ?> <span class="obj-unit">kg</span></div>
                </div>

                <div class="obj-card accent-warn">
                    <span class="obj-label">Poids actuel</span>
                    <div class="obj-value"><?= $user['poids'] ?> <span class="obj-unit">kg</span></div>
                </div>

                <div class="obj-card accent-ok">
                    <span class="obj-label">Poids cible</span>
                    <div class="obj-value"><?= $objectif['poids_cible'] ?> <span class="obj-unit">kg</span></div>
                </div>

                <div class="obj-card">
                    <span class="obj-label">Variation nécessaire</span>
                    <div class="<?= $variation_poid <= 0 ? 'variation-neg' : 'variation-pos' ?>">
                        <?= ($variation_poid > 0 ? '+' : '') . $variation_poid ?> <span class="obj-unit">kg</span>
                    </div>
                </div>

            </div>
        </section>
        <!-- ── En-tête ── -->
        <div class="page-header">
            <h1 class="page-title">🥗 Suggestion de régime</h1>
            <p class="page-subtitle">Filtr ez et trouvez le plan nutritionnel adapté à vos objectifs</p>
        </div>

        <!-- GOLD OFFER CARD -->
        <?php if (!$userIsGold): 
            $reductionPercent = round((1 - $goldReduction) * 100);
        ?>
        <div class="card gold-offer" style="background: linear-gradient(135deg, #FCD34D 0%, #FBBF24 100%); padding: 24px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div class="card-header" style="color: #78350F; font-size: 18px; font-weight: 700; margin-bottom: 8px;">⭐ Offre Premium Gold</div>
                    <p style="margin-bottom: 12px; font-size: 14px; color: #92400E;">Obtenez <?= $reductionPercent ?>% de réduction sur tous les régimes</p>
                    <p style="font-size: 24px; font-weight: 700; color: #78350F; margin-bottom: 12px;"><?= number_format($goldPrix, 2) ?>€<span style="font-size: 13px;"> (une seule fois)</span></p>
                    <p style="font-size: 12px; color: #92400E;">Solde actuel: <strong><?= number_format($userSolde, 2) ?></strong>€</p>
                </div>
                <button id="activateGoldBtn" style="background: white; color: #FCD34D; border: 2px solid white; padding: 12px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; white-space: nowrap;">
                    Activer Premium
                </button>
            </div>
        </div>
        <?php else: 
            $reductionPercent = round((1 - $goldReduction) * 100);
        ?>
        <div class="alert alert-success" style="margin-bottom: 24px;">
            ✅ Vous êtes membre GOLD! Profitez de <?= $reductionPercent ?>% de réduction sur tous les régimes.
        </div>
        <?php endif; ?>

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

            <form action="/Regime/suggest" method="get" class="filter-form">
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
                <div style="display: flex; align-items: center; gap: 10px;">
                    <h2 class="table-section-header__title">📋 Liste des régimes</h2>
                    <?php if (!empty($liste_regime)): ?>
                        <span class="result-count">
                            <?= count($liste_regime) ?> résultat<?= count($liste_regime) > 1 ? 's' : '' ?>
                        </span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($liste_regime)): ?>
                    <a href="/Regime/get/suggestion/pdf" class="btn-export">
                        ⬇ Exporter PDF
                    </a>
                <?php endif; ?>
            </div>

            <!-- Onglets de prix -->
            <div style="display: flex; gap: 12px; margin-bottom: 16px; border-bottom: 2px solid #E5E7EB;">
                <button class="price-tab active" data-tab="standard" style="padding: 12px 24px; background: none; border: none; cursor: pointer; font-weight: 600; color: #6B7280; border-bottom: 3px solid #3B82F6; margin-bottom: -2px;">
                    💵 Prix Standard
                </button>
                <?php if ($userIsGold): ?>
                <button class="price-tab" data-tab="gold" style="padding: 12px 24px; background: none; border: none; cursor: pointer; font-weight: 600; color: #6B7280;">
                    ⭐ Prix GOLD (-<?= $goldReduction*100 ?>%)
                </button>
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
                                <th>Prix</th>
                                <th>Durée</th>
                                <th>Gain</th>
                                <th>% Viande</th>
                                <th>% Poisson</th>
                                <th>% Volaille</th>
                                <th>Sport</th>
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
                                
                                $priceStandard = (float) $regime['prix'];
                                $priceGold = $priceStandard * $goldReduction;
                                ?>
                                <tr class="regime-row" data-regime-id="<?= $regime['id'] ?>">
                                    <td class="regime-name"><?= esc($regime['nom']) ?></td>

                                    <td class="cell-price">
                                        <span class="price-standard" style="display: inline;">
                                            <?= number_format($priceStandard, 2) ?> $
                                        </span>
                                        <?php if ($userIsGold): ?>
                                        <span class="price-gold" style="display: none;">
                                            <span style="text-decoration: line-through; color: #999; margin-right: 8px;"><?= number_format($priceStandard, 2) ?></span>
                                            <strong style="color: #10B981;"><?= number_format($priceGold, 2) ?> $</strong>
                                        </span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= (int) $regime['duree'] ?> j</td>

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
                                    <td>
                                        <?php if (isset($regime['nom_activite'])) { ?>
                                            <?= $regime['nom_activite'] ?>
                                        <?php } else { ?>
                                            aucun
                                        <?php } ?>
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
        document.querySelectorAll('.protein-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                document.querySelectorAll('.protein-chip').forEach(c => c.classList.remove('selected'));
                chip.classList.add('selected');
            });
        });

        // ── Onglets de prix ──
        document.querySelectorAll('.price-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                // Mettre à jour les onglets
                document.querySelectorAll('.price-tab').forEach(t => {
                    t.style.color = '#6B7280';
                    t.style.borderBottom = 'none';
                    t.style.marginBottom = '0';
                });
                
                this.style.color = '#3B82F6';
                this.style.borderBottom = '3px solid #3B82F6';
                this.style.marginBottom = '-2px';
                
                document.querySelectorAll('.regime-row').forEach(row => {
                    row.querySelectorAll('.price-' + (tabName === 'standard' ? 'standard' : 'gold')).forEach(p => p.style.display = 'inline');
                    row.querySelectorAll('.price-' + (tabName === 'standard' ? 'gold' : 'standard')).forEach(p => p.style.display = 'none');
                });
            });
        });

        document.getElementById('activateGoldBtn')?.addEventListener('click', async function() {
            const btn = this;
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btn.textContent = '⏳ Chargement...';

            try {
                const response = await fetch('/dashboard/activateGold', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ Erreur: ' + data.message);
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.textContent = 'Activer Premium';
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('❌ Erreur réseau: ' + error.message);
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.textContent = 'Activer Premium';
            }
        });
    </script>

</body>

</html>