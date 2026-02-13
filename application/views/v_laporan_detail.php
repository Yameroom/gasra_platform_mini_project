<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | Detail #<?php echo $d->id_transaksi; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --bg-light: #f4f7f6;
            --white: #ffffff;
            --text-main: #111827;
            --text-muted: #64748b;
            --border-color: #f1f5f9;
            /* Sinkronisasi warna Biru Gelap GASRA */
            --gasra-blue-base: #001d3d; 
            --gasra-blue-mid: #003566;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-light); 
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* TOP NAVIGATION SAMA DENGAN DASHBOARD */
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
        }
        .nav-item .nav-link:hover { color: var(--gasra-blue-base); transform: translateY(-2px); }
        .nav-item .nav-link.active { color: var(--gasra-blue-base); position: relative; font-weight: 700; }
        .nav-item .nav-link.active::after {
            content: ''; position: absolute; bottom: -18px; left: 0;
            width: 100%; height: 2.5px; background: var(--gasra-blue-base); border-radius: 10px 10px 0 0;
        }

        .content-wrapper { padding: 2rem 5%; }

        /* DETAIL CARD STYLE */
        .detail-card {
            background: var(--white); border-radius: 24px; border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden;
        }
        /* Header Menggunakan Gradient Biru Gelap GASRA */
        .header-detail { 
            background: linear-gradient(135deg, var(--gasra-blue-base) 0%, var(--gasra-blue-mid) 100%); 
            color: white; 
            padding: 35px; 
        }
        
        .spec-label { color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px; }
        .spec-value { font-size: 1.15rem; font-weight: 700; color: #1e293b; }
        
        .param-box { 
            background: #f8fafc; border-radius: 16px; padding: 20px; 
            border: 1px solid #f1f5f9; text-align: center;
            transition: 0.3s;
        }
        .param-box:hover { transform: translateY(-5px); border-color: var(--gasra-blue-base); }
        
        .table-calc thead th { 
            background: #f8fafc; color: var(--text-muted); 
            border: none; font-size: 0.7rem; padding: 15px; 
            text-transform: uppercase; font-weight: 800;
        }
        .table-calc tbody td { padding: 18px 15px; border-bottom: 1px solid #f1f5f9; }

        .btn-back {
            border-radius: 12px;
            font-weight: 700;
            transition: 0.3s;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
        }
        .btn-back:hover { background: white; color: var(--gasra-blue-base); }
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
                <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('laporan'); ?>">Transaction List</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('kalkulator'); ?>">Calculators</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('analytics'); ?>">Analytics</a></li>
            </ul>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('login/logout'); ?>" class="btn btn-outline-danger btn-sm fw-bold px-3" style="border-radius: 8px;">Sign Out</a>
        </div>
    </div>
</nav>

<div class="container content-wrapper">
    <div class="detail-card animate__animated animate__zoomIn" style="animation-duration: 0.6s;">
        <div class="header-detail d-flex justify-content-between align-items-center">
            <div>
                <small class="opacity-75 fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Technical Report ID</small>
                <h3 class="m-0 fw-bold">#TRX-<?php echo str_pad($d->id_transaksi, 5, '0', STR_PAD_LEFT); ?></h3>
            </div>
            <a href="<?php echo base_url('laporan'); ?>" class="btn btn-back btn-sm px-4 py-2">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
        
        <div class="p-4 p-md-5">
            <div class="row mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="spec-label">Customer Name</div>
                    <div class="spec-value" style="color: var(--gasra-blue-base);"><?php echo $d->Customer; ?></div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="spec-label">Cradle Assigned</div>
                    <div class="spec-value"><i class="fas fa-truck-moving text-muted me-2"></i><?php echo $d->Cradle; ?></div>
                </div>
                <div class="col-md-2 mb-3 mb-md-0">
                    <div class="spec-label">Transaction Date</div>
                    <div class="spec-value"><?php echo date('d M Y', strtotime($d->Tanggal)); ?></div>
                </div>
                <div class="col-md-3 text-md-end">
                    <div class="spec-label">Revenue Estimate</div>
                    <div class="h3 fw-bold m-0" style="color: #059669;">Rp <?php echo number_format($d->Revenue_IDR, 0, ',', '.'); ?></div>
                </div>
            </div>

            <h6 class="fw-bold mb-4 text-uppercase animate__animated animate__fadeIn" style="letter-spacing: 1px; color: var(--gasra-blue-base);">
                <i class="fas fa-microscope me-2"></i>Gas Quality Parameters
            </h6>
            <div class="row g-3 mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <div class="col-6 col-md-3">
                    <div class="param-box">
                        <div class="spec-label">CO2</div>
                        <div class="spec-value"><?php echo $d->CO2; ?> %</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="param-box">
                        <div class="spec-label">N2</div>
                        <div class="spec-value"><?php echo $d->N2; ?> %</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="param-box">
                        <div class="spec-label">SG</div>
                        <div class="spec-value"><?php echo $d->SG; ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="param-box">
                        <div class="spec-label">Temp (In/Out)</div>
                        <div class="spec-value"><?php echo $d->T_Awal; ?> / <?php echo $d->T_Akhir; ?> °C</div>
                    </div>
                </div>
            </div>

            <h6 class="fw-bold mb-4 text-uppercase animate__animated animate__fadeIn" style="letter-spacing: 1px; color: var(--gasra-blue-base);">
                <i class="fas fa-calculator me-2"></i>Transmission Summary
            </h6>
            <div class="table-responsive animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <table class="table table-calc m-0">
                    <thead>
                        <tr>
                            <th>OPERATIONAL CONDITION</th>
                            <th class="text-center">PRESSURE (BAR)</th>
                            <th class="text-center">FPV FACTOR</th>
                            <th class="text-end">VOLUME (SM3)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">Departure / Kirim</td>
                            <td class="text-center"><?php echo $d->P_Kirim; ?></td>
                            <td class="text-center"><?php echo $d->Fpv_Kirim; ?></td>
                            <td class="text-end fw-bold"><?php echo number_format($d->SM3_Kirim, 2); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Arrival / Ambil</td>
                            <td class="text-center"><?php echo $d->P_Ambil; ?></td>
                            <td class="text-center"><?php echo $d->Fpv_Ambil; ?></td>
                            <td class="text-end fw-bold"><?php echo number_format($d->SM3_Ambil, 2); ?></td>
                        </tr>
                        <tr style="background: #f0fdf4; border-radius: 12px;">
                            <td colspan="3" class="fw-bold text-success py-3 text-uppercase">Net Volume Delivered</td>
                            <td class="text-end fw-bold text-success py-3 h5 m-0"><?php echo number_format($d->Nilai_SM3_Total, 2); ?> SM3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html> 