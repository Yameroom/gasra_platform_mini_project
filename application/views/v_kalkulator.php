<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | AGA8 Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

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
        .nav-item .nav-link.active { 
            color: var(--gasra-blue-base); 
            position: relative;
            font-weight: 700;
        }
        .nav-item .nav-link.active::after {
            content: ''; position: absolute; bottom: -18px; left: 0;
            width: 100%; height: 2.5px; background: var(--gasra-blue-base); border-radius: 10px 10px 0 0;
        }

        .content-wrapper { padding: 2rem 5%; }

        .calc-card {
            background: var(--white); border-radius: 20px;
            padding: 30px; border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            height: 100%;
        }

        .section-title { font-weight: 700; font-size: 1.1rem; color: var(--gasra-blue-base); margin-bottom: 25px; display: flex; align-items: center; letter-spacing: -0.5px; }
        .section-title i { color: var(--gasra-blue-light); margin-right: 12px; }

        .form-label { font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .form-control { border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px; font-size: 0.9rem; transition: 0.3s; }
        .form-control:focus { border-color: var(--gasra-blue-light); box-shadow: 0 0 0 3px rgba(0, 80, 157, 0.1); }

        .btn-calc {
            background: var(--gasra-blue-base); color: white;
            border: none; border-radius: 12px; padding: 14px;
            font-weight: 700; width: 100%; transition: 0.3s;
            text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;
        }
        .btn-calc:hover { 
            background: var(--gasra-blue-mid); 
            transform: translateY(-2px); 
            box-shadow: 0 6px 15px rgba(0, 29, 61, 0.2); 
            color: white;
        }

        .result-box {
            background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 16px;
            padding: 25px; text-align: center; margin-top: 25px;
            transition: 0.3s;
        }
        .result-box:hover { border-color: var(--gasra-blue-light); background: #f0f7ff; }
        .result-val { font-size: 2.2rem; font-weight: 800; color: var(--gasra-blue-base); letter-spacing: -1px; }

        /* TABLE & PAGINATION CUSTOM STYLING */
        .table thead th {
            background: #f8fafc; color: var(--text-muted);
            font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px;
            padding: 15px; border: none; font-weight: 800;
        }
        .table tbody td { padding: 18px 15px; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; vertical-align: middle; }
        
        .badge-param { background: #f0f9ff; color: #0369a1; border: 1px solid #e0f2fe; padding: 5px 10px; border-radius: 8px; font-weight: 600; }

        /* Menghilangkan elemen DataTables yang tidak perlu untuk history */
        .dataTables_length, .dataTables_filter { display: none; }
        
        .pagination .page-item.active .page-link {
            background-color: var(--gasra-blue-base) !important;
            border-color: var(--gasra-blue-base) !important;
            color: #ffffff !important;
        }
        .pagination .page-link {
            color: var(--gasra-blue-base);
            border-radius: 8px !important;
            margin: 0 2px;
            border: none;
            background: #f8fafc;
            font-size: 0.75rem;
            font-weight: 600;
        }
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
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('kalkulator') ?>">Calculators</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('analytics') ?>">Analytics</a></li>
            </ul>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('login/logout') ?>" class="btn btn-outline-danger btn-sm fw-bold px-3" style="border-radius: 8px;">Sign Out</a>
        </div>
    </div>
</nav>

<div class="container-fluid content-wrapper">
    <div class="row g-4">
        <div class="col-lg-5 animate__animated animate__fadeInLeft" style="animation-duration: 0.6s;">
            <div class="calc-card">
                <div class="section-title">
                    <i class="fas fa-calculator"></i> AGA8 Parameter Input
                </div>
                <form action="<?php echo base_url('kalkulator/hitung'); ?>" method="post">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Pressure (Bar)</label>
                            <input type="number" step="0.01" name="p" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Temp (°C)</label>
                            <input type="number" step="0.1" name="t" class="form-control" placeholder="0.0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vol (LWC)</label>
                            <input type="number" step="0.1" name="lwc" class="form-control" placeholder="Liter" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Specific Gravity (SG)</label>
                        <input type="number" step="0.0001" name="sg" class="form-control" value="0.5841" required>
                    </div>
                    <div class="row g-3 mb-5">
                        <div class="col-6">
                            <label class="form-label">CO2 (%)</label>
                            <input type="number" step="0.0001" name="co2" class="form-control" value="0.8477" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">N2 (%)</label>
                            <input type="number" step="0.0001" name="n2" class="form-control" value="0.7632" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-calc">Calculate & Save History</button>
                </form>

                <?php if(isset($hasil) && $hasil): ?>
                <div class="result-box animate__animated animate__zoomIn">
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Compressibility Factor (Fpv)</small>
                    <div class="result-val mb-2"><?php echo number_format($hasil->fpv, 5); ?></div>
                    <hr class="opacity-10">
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Result Volume (SM3)</small>
                    <div class="h3 fw-bold mt-2" style="color: #059669;"><?php echo number_format($hasil->hasil_sm3, 2, ',', '.'); ?> m³</div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-7 animate__animated animate__fadeInRight" style="animation-duration: 0.6s;">
            <div class="calc-card">
                <div class="section-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history"></i> Calculation History</span>
                    <span class="badge bg-light text-muted fw-normal px-3 py-2" style="border-radius: 8px;">User: <?php echo $this->session->userdata('nama'); ?></span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle m-0" id="historyTable">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Parameters (P/T/V)</th>
                                <th class="text-center">Fpv</th>
                                <th class="text-end">Result SM3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($history)): ?>
                                <?php foreach($history as $h): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold" style="color: var(--gasra-blue-base);"><?php echo date('d M Y', strtotime($h->created_at)); ?></div>
                                        <div class="text-muted small"><?php echo date('H:i', strtotime($h->created_at)); ?> WIB</div>
                                    </td>
                                    <td>
                                        <span class="badge-param">
                                            <?php echo $h->pressure_bar; ?> bar | <?php echo $h->temp_c; ?>°C | <?php echo $h->tube_volume_liter; ?>L
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold" style="color: var(--gasra-blue-light);"><?php echo number_format($h->fpv, 5); ?></td>
                                    <td class="text-end fw-bold" style="color: #059669;"><?php echo number_format($h->hasil_sm3, 2, ',', '.'); ?> SM3</td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#historyTable').DataTable({
            "pageLength": 5, // Cukup 5 data saja per halaman
            "order": [[0, "desc"]], // Urutan paling baru ke paling lama
            "language": {
                "zeroRecords": "No calculation records available.",
                "info": "Page _PAGE_ of _PAGES_",
                "infoEmpty": "",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            },
            "dom": 'rt<"d-flex justify-content-between align-items-center mt-3"i p>', // Hanya tampil info dan paginasi
            "ordering": true,
            "responsive": true
        });
    });
</script>

</body>
</html>