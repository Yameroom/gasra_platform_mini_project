<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | Advanced Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg-light: #f4f7f6;
            --white: #ffffff;
            --text-main: #111827;
            --text-muted: #64748b;
            --border-color: #f1f5f9;
            --gasra-blue-base: #001d3d; 
            --gasra-blue-mid: #003566;
            --gasra-blue-light: #00509d;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-light); 
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* TOP NAVIGATION */
        .navbar {
            background: var(--white);
            padding: 0.6rem 2%;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .navbar-brand { font-weight: 800; font-size: 1.15rem; color: var(--gasra-blue-base); letter-spacing: -0.5px; }
        
        .nav-item .nav-link { 
            color: var(--text-muted); 
            font-weight: 500; 
            font-size: 0.85rem; 
            margin: 0 8px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .nav-item .nav-link:hover { color: var(--gasra-blue-base); transform: translateY(-2px); }
        .nav-item .nav-link.active { color: var(--gasra-blue-base); position: relative; font-weight: 700; }
        .nav-item .nav-link.active::after {
            content: ''; position: absolute; bottom: -18px; left: 0;
            width: 100%; height: 2.5px; background: var(--gasra-blue-base); border-radius: 10px 10px 0 0;
        }

        .content-wrapper { padding: 2rem 5%; }

        /* ANALYTICS CARDS */
        .analytics-card {
            background: var(--white);
            border-radius: 20px;
            padding: 25px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            height: 100%;
        }

        .card-title {
            font-weight: 700; font-size: 0.95rem; color: var(--gasra-blue-base);
            margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between;
        }

        .filter-box {
            background: white; border-radius: 16px; padding: 15px 25px;
            margin-bottom: 30px; display: flex; align-items: center; gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .ranking-item {
            display: flex; align-items: center; margin-bottom: 18px;
            padding: 12px; border-radius: 12px; transition: 0.3s;
        }
        .ranking-item:hover { background: #f8fafc; transform: translateX(5px); }
        .rank-number {
            width: 32px; height: 32px; background: #f0f7ff;
            color: var(--gasra-blue-light); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 0.8rem; margin-right: 15px;
        }

        .btn-apply {
            background: var(--gasra-blue-base); color: white; border: none; border-radius: 10px;
            padding: 8px 20px; font-weight: 700; transition: 0.3s;
        }
        .btn-apply:hover { background: var(--gasra-blue-mid); transform: translateY(-2px); }
    </style>
</head>
<body>

<script>
    if (history.scrollRestoration) { history.scrollRestoration = 'manual'; }
    window.scrollTo(0, 0);
</script>

<nav class="navbar navbar-expand-lg sticky-top animate__animated animate__fadeInDown">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>"><i class="fas fa-wind me-2"></i>GASRA</a>
        <div class="collapse navbar-collapse justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('laporan') ?>">Transaction List</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('kalkulator') ?>">Calculators</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('analytics') ?>">Analytics</a></li>
            </ul>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('login/logout') ?>" class="btn btn-outline-danger btn-sm fw-bold px-3" style="border-radius: 8px;">Sign Out</a>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="mb-5 animate__animated animate__fadeInLeft" style="animation-duration: 0.6s;">
        <h2 class="fw-bold m-0" style="letter-spacing: -1.5px; color: var(--gasra-blue-base);">Operational Analytics</h2>
        <p class="text-muted small">Strategic insights and asset performance evaluation.</p>
    </div>

    <div class="filter-box animate__animated animate__fadeInRight" style="animation-duration: 0.6s;">
        <form action="<?= base_url('analytics') ?>" method="get" class="d-flex align-items-center w-100 gap-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-calendar-alt text-muted me-2 small"></i>
                <span class="small fw-bold text-muted text-uppercase">Fiscal Year:</span>
            </div>
            <select name="year" class="form-select form-select-sm border-0 fw-bold px-3" style="width: 120px; background-color: #f8fafc; border-radius: 8px;">
                <option value="2026" <?= ($year_selected == '2026') ? 'selected' : '' ?>>2026</option>
                <option value="2025" <?= ($year_selected == '2025') ? 'selected' : '' ?>>2025</option>
            </select>

            <button type="submit" class="btn-apply btn-sm px-4">
                <i class="fas fa-sync-alt me-2"></i>Apply Filter
            </button>

            <a href="<?= base_url('analytics/export_excel?year=' . $year_selected) ?>" class="btn btn-outline-success btn-sm px-4 ms-auto fw-bold" style="border-radius: 10px;">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </a>
        </form>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8 animate__animated animate__zoomIn" style="animation-duration: 0.7s;">
            <div class="analytics-card">
                <div class="card-title">
                    <span><i class="fas fa-chart-line me-2" style="color: var(--gasra-blue-light);"></i> Monthly Volume Trend (SM3)</span>
                    <span class="badge bg-light text-muted fw-normal px-3 py-2" style="border-radius: 8px;"><?= $year_selected ?> Analysis</span>
                </div>
                <div style="height: 350px;">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 animate__animated animate__fadeInRight" style="animation-delay: 0.2s;">
            <div class="analytics-card">
                <div class="card-title">
                    <span><i class="fas fa-truck-loading me-2" style="color: var(--gasra-blue-mid);"></i> Top 5 Cradle Utilization</span>
                </div>
                <div class="ranking-list">
                    <?php if(!empty($chart_cradle)): ?>
                        <?php 
                        $i = 1; 
                        $max_trip = max($chart_cradle);
                        foreach($chart_cradle as $cradle => $trips): 
                        ?>
                        <div class="ranking-item">
                            <div class="rank-number"><?= $i++ ?></div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold" style="color: var(--gasra-blue-base);"><?= $cradle ?></div>
                                <div class="progress mt-1" style="height: 6px; background-color: #f1f5f9;">
                                    <div class="progress-bar" style="width: <?= ($trips/$max_trip)*100 ?>%; background: linear-gradient(90deg, var(--gasra-blue-base), var(--gasra-blue-light));"></div>
                                </div>
                            </div>
                            <div class="ms-3 small fw-bold text-muted"><?= $trips ?> Trips</div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted small text-center py-5">No operational data found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <div class="analytics-card">
                <div class="card-title">
                    <span><i class="fas fa-gauge-high me-2 text-primary"></i> Discharge Efficiency per Client (%)</span>
                </div>
                <div style="height: 350px;"> 
                    <canvas id="efficiencyChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-5 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
            <div class="analytics-card">
                <div class="card-title">
                    <span><i class="fas fa-wallet me-2 text-success"></i> Revenue Share by Client</span>
                </div>
                <div style="height: 350px;">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    // SCANNING LIGHT CONFIGURATION
    let gradientMove = 0;
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    
    function getMovingGradient(context, chartArea) {
        const chartWidth = chartArea.right - chartArea.left;
        const gradient = context.createLinearGradient(
            chartArea.left + (gradientMove * chartWidth), 0, 
            chartArea.left + (gradientMove * chartWidth) + 150, 0
        );
        gradient.addColorStop(0, '#001d3d');
        gradient.addColorStop(0.5, '#ffffff'); // Scanning Pulse
        gradient.addColorStop(1, '#001d3d');
        return gradient;
    }

    const growthChart = new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Volume SM3',
                data: <?= json_encode($chart_growth) ?>,
                borderColor: '#001d3d',
                borderWidth: 4,
                backgroundColor: (context) => {
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) return null;
                    const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    gradient.addColorStop(0, 'rgba(0, 29, 61, 0)');
                    gradient.addColorStop(1, 'rgba(0, 29, 61, 0.15)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 0, // No points to prevent flickering
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#001d3d',
                pointHoverBorderWidth: 3
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: { legend: { display: false } },
            scales: { 
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { weight: '600' } } },
                x: { grid: { display: false }, ticks: { font: { weight: '600' } } }
            }
        },
        plugins: [{
            afterRender: (chart) => {
                if (!chart.isAnimatingNow) {
                    chart.isAnimatingNow = true;
                    setInterval(() => {
                        gradientMove += 0.005;
                        if (gradientMove > 1.2) gradientMove = -0.2;
                        const area = chart.chartArea;
                        if(area) {
                            chart.data.datasets[0].borderColor = getMovingGradient(chart.ctx, area);
                            chart.update('none');
                        }
                    }, 30);
                }
            }
        }]
    });

    // 2. EFFICIENCY CHART (Horizontal Bar)
    new Chart(document.getElementById('efficiencyChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($chart_efficiency)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($chart_efficiency)) ?>,
                backgroundColor: '#003566',
                borderRadius: 10,
                barThickness: 18
            }]
        },
        options: { 
            indexAxis: 'y',
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { max: 100, grid: { display: false } },
                y: { ticks: { font: { weight: '700' } } }
            }
        }
    });

    // 3. REVENUE SHARE CHART (Doughnut Blue Gradient)
    new Chart(document.getElementById('revenueTrendChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_keys($chart_revenue)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($chart_revenue)) ?>,
                backgroundColor: ['#001d3d', '#003566', '#00509d', '#0077b6', '#0096c7', '#48cae4'],
                borderWidth: 6,
                borderColor: '#ffffff'
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 20, font: { size: 11, weight: '700' } }
                } 
            }
        }
    });
</script>

</body>
</html>