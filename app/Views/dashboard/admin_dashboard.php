<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NutriGain</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/info_client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/objectif.css') ?>">
</head>

<body>
    <?= view("navbar") ?>
    <?= view("sidebar") ?>

    <div class="admin-wrapper">
        <div class="main-content">
            <div class="content">
                <!-- STATS CARDS -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Utilisateurs Total</div>
                        <div class="stat-value"><?= $total_utilisateurs ?? 0 ?></div>
                        <div class="stat-change">📊 Utilisateurs actifs</div>
                    </div>

                    <div class="stat-card secondary">
                        <div class="stat-label">Régimes Actifs</div>
                        <div class="stat-value"><?= $regimes_actifs ?? 0 ?></div>
                        <div class="stat-change">💪 Achats en cours</div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-label">Revenus (Mois)</div>
                        <div class="stat-value"><?= number_format($revenues_mois ?? 0, 2) ?>€</div>
                        <div class="stat-change">💰 Dernier mois</div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-label">Codes Utilisés</div>
                        <div class="stat-value"><?= $codes_utilises ?? 0 ?></div>
                        <div class="stat-change">🎁 Codes validés</div>
                    </div>
                </div>

                <!-- CHARTS -->
                <div class="charts-grid">
                    <!-- INSCRIPTIONS CHART -->
                    <div class="chart-card">
                        <div class="chart-title">Inscriptions (7 derniers jours)</div>
                        <canvas id="registrationsChart"></canvas>
                    </div>

                    <!-- TYPES REGIMES DONUT -->
                    <div class="chart-card">
                        <div class="chart-title">Régimes par Type</div>
                        <canvas id="typesChart"></canvas>
                    </div>
                </div>

                <!-- TOP REGIMES -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <div class="chart-title">Top 5 Régimes</div>
                        <canvas id="topRegimesChart"></canvas>
                    </div>
                </div>

                <!-- REGIMES TABLE -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>📊 Gestion des Régimes</h3>
                        <div class="table-header-actions">
                            <a href="/Regime/go_to_regime" class="btn btn-primary">+ Nouveau Régime</a>
                            <button class="btn btn-secondary">Exporter</button>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Prix</th>
                                <th>Durée</th>
                                <th>Composition</th>
                                <th>Actifs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($regimes_stats)): ?>
                                <?php foreach ($regimes_stats as $regime): ?>
                                    <tr>
                                        <td><strong><?= $regime['nom'] ?></strong></td>
                                        <td><?= ucfirst($regime['type']) ?></td>
                                        <td><?= number_format($regime['prix'], 2) ?>€</td>
                                        <td><?= $regime['duree'] ?> jours</td>
                                        <td>
                                            🥩 <?= $regime['pourcentage_viande'] ?>%
                                            🐟 <?= $regime['pourcentage_poisson'] ?>%
                                            🍗 <?= $regime['pourcentage_volaille'] ?>%
                                        </td>
                                        <td><span class="badge badge-success"><?= $regime['actifs'] ?? 0 ?></span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="/Regime/update/<?= $regime['id'] ?>" class="action-btn"
                                                    title="Modifier">✏️</a>
                                                <a href="/Regime/supprimer/<?= $regime['id'] ?>" class="action-btn"
                                                    title="Supprimer" onclick="return confirm('Supprimer?')">🗑️</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px;">Aucun régime trouvé</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // INSCRIPTIONS CHART
        const inscriptions = <?= json_encode($inscriptions ?? []) ?>;
        const labels = inscriptions.map(i => i.date);
        const data = inscriptions.map(i => i.count);

        const registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
        new Chart(registrationsCtx, {
            type: 'line',
            data: {
                labels: labels.length > 0 ? labels : ['Pas de données'],
                datasets: [{
                    label: 'Inscriptions',
                    data: data.length > 0 ? data : [0],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // TYPES REGIMES CHART
        const typesRegimes = <?= json_encode($types_regimes ?? []) ?>;
        const typesLabels = typesRegimes.map(t => t.type || 'Non défini');
        const typesData = typesRegimes.map(t => t.actifs);
        const colors = ['#10b981', '#8b5cf6', '#3b82f6', '#f59e0b', '#ef4444'];

        const typesCtx = document.getElementById('typesChart').getContext('2d');
        new Chart(typesCtx, {
            type: 'doughnut',
            data: {
                labels: typesLabels.length > 0 ? typesLabels : ['Pas de données'],
                datasets: [{
                    data: typesData.length > 0 ? typesData : [1],
                    backgroundColor: colors.slice(0, typesLabels.length),
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // TOP REGIMES CHART
        const topRegimes = <?= json_encode($top_regimes ?? []) ?>;
        const topLabels = topRegimes.map(r => r.nom);
        const topData = topRegimes.map(r => r.actifs);

        const topCtx = document.getElementById('topRegimesChart').getContext('2d');
        new Chart(topCtx, {
            type: 'bar',
            data: {
                labels: topLabels.length > 0 ? topLabels : ['Pas de données'],
                datasets: [{
                    label: 'Nombre d\'achats',
                    data: topData.length > 0 ? topData : [0],
                    backgroundColor: '#10b981',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>