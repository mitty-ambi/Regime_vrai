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
    <style>
    </style>
</head>

<body>
    <div class="admin-wrapper">

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-left">Dashboard Admin</div>
                <div class="topbar-right">
                    <div class="admin-avatar">AD</div>
                    <span>Admin</span>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="content">
                <!-- STATS CARDS -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Utilisateurs Total</div>
                        <div class="stat-value">1,248</div>
                        <div class="stat-change">↑ 12% cette semaine</div>
                    </div>

                    <div class="stat-card secondary">
                        <div class="stat-label">Régimes Actifs</div>
                        <div class="stat-value">856</div>
                        <div class="stat-change">↑ 8% cette semaine</div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-label">Revenus (Mois)</div>
                        <div class="stat-value">5,420€</div>
                        <div class="stat-change">↑ 25% vs mois dernier</div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-label">Codes Utilisés</div>
                        <div class="stat-value">142</div>
                        <div class="stat-change negative">↓ 5% cette semaine</div>
                    </div>
                </div>

                <!-- CHARTS -->
                <div class="charts-grid">
                    <!-- INSCRIPTIONS CHART -->
                    <div class="chart-card">
                        <div class="chart-title">Inscriptions (7 derniers jours)</div>
                        <canvas id="registrationsChart"></canvas>
                    </div>

                    <!-- REGIMES DONUT -->
                    <div class="chart-card">
                        <div class="chart-title">Top Régimes</div>
                        <canvas id="regimesChart"></canvas>
                    </div>
                </div>

                <!-- REGIMES TABLE -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>Gestion des Régimes</h3>
                        <div class="table-header-actions">
                            <button class="btn btn-primary">+ Nouveau Régime</button>
                            <button class="btn btn-secondary">Exporter</button>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Durée</th>
                                <th>Composition</th>
                                <th>Actifs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Régime Équilibré</strong></td>
                                <td>19,99€</td>
                                <td>30 jours</td>
                                <td>50% Viande, 30% Volaille, 20% Poisson</td>
                                <td><span class="badge badge-success">245</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">✎</button>
                                        <button class="action-btn">👁</button>
                                        <button class="action-btn">✕</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Régime Protéiné</strong></td>
                                <td>34,99€</td>
                                <td>60 jours</td>
                                <td>70% Viande, 40% Volaille, 30% Poisson</td>
                                <td><span class="badge badge-success">189</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">✎</button>
                                        <button class="action-btn">👁</button>
                                        <button class="action-btn">✕</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Régime Léger</strong></td>
                                <td>12,99€</td>
                                <td>15 jours</td>
                                <td>40% Viande, 20% Volaille, 40% Légumes</td>
                                <td><span class="badge badge-info">156</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">✎</button>
                                        <button class="action-btn">👁</button>
                                        <button class="action-btn">✕</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Régime Détox</strong></td>
                                <td>24,99€</td>
                                <td>21 jours</td>
                                <td>30% Viande, 50% Poisson, 20% Légumes</td>
                                <td><span class="badge badge-warning">78</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">✎</button>
                                        <button class="action-btn">👁</button>
                                        <button class="action-btn">✕</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Régime Haute Performance</strong></td>
                                <td>39,99€</td>
                                <td>90 jours</td>
                                <td>60% Viande, 50% Volaille, 40% Poisson</td>
                                <td><span class="badge badge-info">67</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">✎</button>
                                        <button class="action-btn">👁</button>
                                        <button class="action-btn">✕</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="pagination">
                        <a href="#" class="page-link">← Précédent</a>
                        <a href="#" class="page-link active">1</a>
                        <a href="#" class="page-link">2</a>
                        <a href="#" class="page-link">3</a>
                        <a href="#" class="page-link">Suivant →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // REGISTRATIONS CHART
        const registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
        new Chart(registrationsCtx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Inscriptions',
                    data: [45, 52, 48, 61, 55, 67, 72],
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
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // REGIMES DONUT CHART
        const regimesCtx = document.getElementById('regimesChart').getContext('2d');
        new Chart(regimesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Équilibré', 'Protéiné', 'Léger', 'Détox', 'Performance'],
                datasets: [{
                    data: [245, 189, 156, 78, 67],
                    backgroundColor: [
                        '#10b981',
                        '#8b5cf6',
                        '#3b82f6',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>