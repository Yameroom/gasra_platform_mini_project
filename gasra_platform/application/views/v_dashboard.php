<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | Dashboard Overview</title>
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
            --gasra-green: #1b4332;
            --gasra-accent: #2d6a4f;
            /* Base Blue Color for consistency */
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

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .navbar {
            background: var(--white);
            padding: 0.6rem 2%;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .navbar-brand { font-weight: 800; font-size: 1.15rem; color: var(--gasra-green); letter-spacing: -0.5px; }
        
        .nav-item .nav-link { 
            color: var(--text-muted); 
            font-weight: 500; 
            font-size: 0.85rem; 
            margin: 0 8px; 
            transition: all 0.3s ease; 
            display: inline-block;
        }
        .nav-item .nav-link:hover { 
            color: var(--gasra-blue-base); 
            transform: translateY(-2px); 
        }
        .nav-item .nav-link.active { color: var(--gasra-blue-base); position: relative; font-weight: 700; }
        .nav-item .nav-link.active::after {
            content: ''; position: absolute; bottom: -18px; left: 0;
            width: 100%; height: 2.5px; background: var(--gasra-blue-base); border-radius: 10px 10px 0 0;
        }

        .content-wrapper { padding: 2rem 5%; }

        /* USER AVATAR COLOR */
        .user-avatar {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--gasra-blue-base); color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; margin-right: 15px;
            box-shadow: 0 4px 10px rgba(0, 29, 61, 0.2);
        }

        /* STAT CARDS GRADIENT */
        .stat-card {
            border-radius: 20px;
            padding: 24px;
            border: none;
            height: 100%;
            transition: all 0.3s ease;
            color: white;
        }
        .stat-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
        
        .card-vol { background: linear-gradient(135deg, var(--gasra-blue-base) 0%, var(--gasra-blue-mid) 100%); }
        .card-rev { background: linear-gradient(135deg, var(--gasra-blue-mid) 0%, var(--gasra-blue-light) 100%); }
        .card-pres { background: linear-gradient(135deg, var(--gasra-blue-light) 0%, #0077b6 100%); }

        .icon-box-new {
            width: 42px; height: 42px; border-radius: 12px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px; font-size: 1.1rem;
        }

        .stat-label-new { font-size: 0.7rem; opacity: 0.8; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .stat-value-new { font-size: 1.8rem; font-weight: 800; letter-spacing: -1px; }

        .widget-box {
            background: var(--white); border-radius: 20px;
            padding: 24px; border: 1px solid rgba(0,0,0,0.02);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            height: 100%;
        }

        .performance-description {
            background: #f8fafc; border-radius: 16px; padding: 20px;
            margin-top: 25px; border-left: 5px solid var(--gasra-blue-base);
        }

        .market-item { border-bottom: 1px solid #f8f9fa; padding: 10px 0; }
        .market-item:last-child { border: none; }
        .market-price { font-weight: 700; color: var(--text-main); font-size: 1rem; }
        .trend-tag { font-size: 0.7rem; padding: 2px 6px; border-radius: 4px; font-weight: 700; }
        .tag-up { background: #dcfce7; color: #166534; }
        .tag-down { background: #fee2e2; color: #991b1b; }

        .entry-widget { background: #eef2ff; border-radius: 20px; padding: 24px; border: 1px solid #e0e7ff; }
        
        /* NEW ENTRY BUTTON */
        .btn-new-entry {
            background: var(--gasra-blue-base); color: white; width: 100%; border: none;
            border-radius: 12px; padding: 12px; font-weight: 700; margin-top: 15px;
            transition: 0.3s; text-decoration: none; display: inline-block; text-align: center;
        }
        .btn-new-entry:hover { 
            background: var(--gasra-blue-mid); 
            transform: scale(1.02); 
            color: white; 
            box-shadow: 0 4px 12px rgba(0, 29, 61, 0.3);
        }

        .table thead th {
            background: #f8fafc; color: var(--text-muted);
            font-weight: 700; font-size: 0.65rem; letter-spacing: 1px;
            padding: 12px 15px; text-transform: uppercase; border: none;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top animate__animated animate__fadeInDown">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('dashboard'); ?>"><i class="fas fa-wind me-2"></i>GASRA</a>
        <div class="collapse navbar-collapse justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('laporan'); ?>">Transaction List</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('kalkulator'); ?>">Calculators</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('analytics'); ?>">Analytics</a></li>
            </ul>
        </div>
        <div class="header-actions d-flex align-items-center">
            <span class="text-muted small me-3 d-none d-md-block"><?= date('d M Y'); ?></span>
            <a href="<?= base_url('login/logout'); ?>" class="btn btn-outline-danger btn-sm fw-bold px-3" style="border-radius: 8px;">Sign Out</a>
        </div>
    </div>
</nav>

<div class="container-fluid content-wrapper">
    <div class="d-flex align-items-center mb-5 animate__animated animate__fadeInLeft">
        <div class="user-avatar"><?php echo strtoupper(substr($user_now, 0, 1)); ?></div>
        <div>
            <h4 class="fw-bold m-0" style="letter-spacing: -0.5px;">Welcome back, <?php echo $user_now; ?>!</h4>
            <p class="text-muted m-0 small">Operational intelligence and transmission monitoring.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4 animate__animated animate__zoomIn delay-1">
            <div class="stat-card card-vol">
                <div class="icon-box-new"><i class="fas fa-database"></i></div>
                <div class="stat-label-new">TOTAL VOLUME MONTHLY</div>
                <div class="stat-value-new"><?= number_format($summary->avg_vol * 30, 0, ',', '.'); ?> <small class="fs-6 opacity-75">SM3</small></div>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__zoomIn delay-2">
            <div class="stat-card card-rev">
                <div class="icon-box-new"><i class="fas fa-wallet"></i></div>
                <div class="stat-label-new">ESTIMATED REVENUE</div>
                <div class="stat-value-new">Rp <?= number_format($summary->avg_rev / 1000000, 1, ',', '.'); ?>M</div>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__zoomIn delay-3">
            <div class="stat-card card-pres">
                <div class="icon-box-new"><i class="fas fa-bolt"></i></div>
                <div class="stat-label-new">SYSTEM PRESSURE AVG</div>
                <div class="stat-value-new"><?= number_format($summary->avg_p, 2); ?> <small class="fs-6 opacity-75">Bar</small></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-8 animate__animated animate__fadeInUp delay-3">
            <div class="widget-box">
                <h6 class="fw-bold m-0">Performance Trend</h6>
                <span class="text-muted small mb-4 d-block">Volume transmission (SM3) over time</span>
                
                <div class="chart-container" style="height: 480px; position: relative; overflow: hidden;">
                    <canvas id="salesChart"></canvas>
                </div>
                
                <div class="performance-description">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0"><i class="fas fa-info-circle me-2 text-success"></i> Operational Insight</h6>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            <i class="fas fa-check-circle me-1"></i> SYSTEM HEALTHY
                        </span>
                    </div>
                    
                    <div class="row g-0 align-items-center">
                        <div class="col-md-9 pe-3">
                            <p class="small text-muted mb-0" style="line-height: 1.6;">
                                Volume transmisi harian mencapai rata-rata 
                                <strong><?= number_format($summary->avg_vol, 1, ',', '.'); ?> SM3</strong>. 
                                Sistem stabil pada <strong><?= number_format($summary->avg_p, 1); ?> Bar</strong>. Pastikan seluruh log harian telah terverifikasi sebelum penutupan operasional.
                            </p>
                        </div>
                        <div class="col-md-3 text-end border-start ps-3">
                            <div class="small text-muted mb-1" style="font-size: 0.6rem; font-weight: 700; text-transform: uppercase;">Quick Link</div>
                            <a href="<?= base_url('analytics'); ?>" class="btn btn-sm btn-outline-success border-0 fw-bold p-0" style="font-size: 0.75rem;">
                                View Analytics <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 animate__animated animate__fadeInRight delay-4">
            <div class="d-flex flex-column gap-4">
                <div class="entry-widget">
                    <h6 class="fw-bold mb-1">Ready to log data?</h6>
                    <p class="text-muted small mb-0">Input new operational transactions.</p>
                    <a href="<?= base_url('transaksi/tambah'); ?>" class="btn-new-entry"><i class="fas fa-plus me-2"></i> New Entry</a>
                </div>

                <div class="widget-box">
                    <h6 class="fw-bold m-0">Market Indicators</h6>
                    <span class="text-muted small mb-3 d-block">Live commodities index (IGX)</span>
                    <div class="market-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="market-name">Natural Gas (JKM)</span>
                            <span class="trend-tag tag-up">+2.41%</span>
                        </div>
                        <div class="market-price mt-1">$13.45</div>
                    </div>
                    <div class="market-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="market-name">CNG Index</span>
                            <span class="trend-tag tag-down">-0.12%</span>
                        </div>
                        <div class="market-price mt-1">452.10</div>
                    </div>
                </div>

                <div class="widget-box">
                    <h6 class="fw-bold m-0">Customer Share</h6>
                    <span class="text-muted small mb-3 d-block">Volume distribution percentage</span>
                    <div class="chart-container" style="height: 220px;">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-box mb-5 animate__animated animate__fadeInUp delay-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold m-0">Recent Operational Logs</h6>
            <a href="<?= base_url('laporan'); ?>" class="text-decoration-none small fw-bold text-success">View All History <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle m-0">
                <thead>
                    <tr>
                        <th class="border-0">CUSTOMER</th>
                        <th class="border-0">LOG ID</th>
                        <th class="border-0">DATE</th>
                        <th class="border-0 text-center">STATUS</th>
                        <th class="border-0 text-end">VOLUME</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($recent_logs)): ?>
                        <?php foreach($recent_logs as $log): ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?= $log->Customer ?></div>
                                <div class="text-muted small">Cradle <?= $log->Cradle ?></div>
                            </td>
                            <td><code class="text-muted">#<?= $log->log_id ?></code></td>
                            <td><?= date('d M Y', strtotime($log->Tanggal)) ?></td>
                            <td class="text-center"><span class="badge rounded-pill bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.7rem; padding: 5px 12px;">Completed</span></td>
                            <td class="fw-bold text-end"><?= number_format($log->vol, 1, ',', '.') ?> SM3</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    /* RESET SCROLL KE ATAS SAAT REFRESH */
    if (history.scrollRestoration) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0, 0);

    const ctx = document.getElementById('salesChart').getContext('2d');
    
    let gradientMove = 0;
    function getMovingGradient(context, chartArea) {
        const chartWidth = chartArea.right - chartArea.left;
        const gradient = context.createLinearGradient(
            chartArea.left + (gradientMove * chartWidth), 0, 
            chartArea.left + (gradientMove * chartWidth) + 200, 0
        );
        
        gradient.addColorStop(0, '#1b4332');
        gradient.addColorStop(0.5, '#ffffff');
        gradient.addColorStop(1, '#1b4332');
        return gradient;
    }

    const gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
    gradientFill.addColorStop(0, 'rgba(27, 67, 50, 0.3)');
    gradientFill.addColorStop(1, 'rgba(27, 67, 50, 0.0)');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php foreach($chart_data as $c) echo "'".date('d M', strtotime($c->Tanggal))."',"; ?>],
            datasets: [{
                data: [<?php foreach($chart_data as $c) echo $c->daily_vol.","; ?>],
                borderColor: '#1b4332',
                borderWidth: 5,
                fill: true,
                backgroundColor: gradientFill,
                tension: 0.45,
                /* HILANGKAN BULLET POINT SEPENUHNYA */
                pointRadius: 0, 
                pointHoverRadius: 0, 
                pointHitRadius: 25, 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false, 
                mode: 'index',
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    enabled: true, 
                    backgroundColor: 'rgba(27, 67, 50, 0.95)',
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false 
                }
            },
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
                        gradientMove += 0.007;
                        if (gradientMove > 1.3) gradientMove = -0.3;
                        
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

    const ctxDist = document.getElementById('distributionChart').getContext('2d');
    new Chart(ctxDist, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach($dist_data as $d) echo "'".$d->Customer."',"; ?>],
            datasets: [{
                data: [<?php foreach($dist_data as $d) echo $d->total_vol.","; ?>],
                backgroundColor: ['#001d3d', '#003566', '#00509d'],
                borderWidth: 8,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { 
                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15, font: { size: 11, weight: '700' } } } 
            }
        }
    });
</script>
</body>
</html>