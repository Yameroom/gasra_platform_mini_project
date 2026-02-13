<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | Edit Transaction</title>
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
        }
        .nav-item .nav-link:hover { color: var(--gasra-blue-base); transform: translateY(-2px); }
        .nav-item .nav-link.active { 
            color: var(--gasra-blue-base); 
            position: relative;
            font-weight: 700;
        }
        .nav-item .nav-link.active::after { 
            content: ''; position: absolute; bottom: -18px; left: 0; width: 100%; height: 2.5px; 
            background: var(--gasra-blue-base); border-radius: 10px 10px 0 0; 
        }

        .content-wrapper { padding: 3rem 5%; }

        /* FORM CARD STYLE */
        .form-card { 
            background: var(--white); 
            border-radius: 24px; 
            padding: 40px; 
            border: none; 
            box-shadow: 0 15px 35px rgba(0, 29, 61, 0.05); 
            max-width: 850px; 
            margin: auto; 
        }

        .form-title { 
            font-weight: 800; 
            font-size: 1.4rem; 
            color: var(--gasra-blue-base); 
            margin-bottom: 30px; 
            display: flex; 
            align-items: center; 
            letter-spacing: -0.5px;
        }
        .form-title i { color: var(--gasra-blue-light); margin-right: 15px; }

        .form-label { 
            font-size: 0.7rem; 
            font-weight: 800; 
            color: var(--text-muted); 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            margin-bottom: 10px; 
        }

        .form-control, .form-select { 
            border-radius: 12px; 
            border: 1px solid #e2e8f0; 
            padding: 12px 18px; 
            font-size: 0.95rem; 
            transition: 0.3s; 
            background-color: #f8fafc;
        }
        .form-control:focus, .form-select:focus { 
            border-color: var(--gasra-blue-light); 
            box-shadow: 0 0 0 4px rgba(0, 80, 157, 0.1); 
            background-color: #fff;
        }

        /* BUTTONS */
        .btn-save { 
            background: var(--gasra-blue-base); 
            color: white; 
            border: none; 
            border-radius: 14px; 
            padding: 14px 40px; 
            font-weight: 700; 
            transition: 0.3s; 
            font-size: 0.95rem; 
            letter-spacing: 0.5px;
        }
        .btn-save:hover { 
            background: var(--gasra-blue-mid); 
            transform: translateY(-3px); 
            box-shadow: 0 8px 20px rgba(0, 29, 61, 0.2); 
            color: white;
        }

        .btn-cancel { 
            background: #f1f5f9; 
            color: var(--text-muted); 
            border: none; 
            border-radius: 14px; 
            padding: 14px 40px; 
            font-weight: 700; 
            transition: 0.3s; 
            font-size: 0.95rem; 
            text-decoration: none; 
        }
        .btn-cancel:hover { background: #e2e8f0; color: var(--text-main); }

        .input-group-text { 
            background: #f1f5f9; 
            color: var(--gasra-blue-mid); 
            font-weight: 800; 
            font-size: 0.8rem; 
            border: 1px solid #e2e8f0;
            border-radius: 0 12px 12px 0 !important;
            padding: 0 20px;
        }
        
        .input-group > .form-control {
            border-radius: 12px 0 0 12px !important;
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
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('laporan') ?>">Transaction List</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('kalkulator') ?>">Calculators</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('analytics') ?>">Analytics</a></li>
            </ul>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('login/logout') ?>" class="btn btn-outline-danger btn-sm fw-bold px-3" style="border-radius: 8px;">Sign Out</a>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="form-card animate__animated animate__zoomIn" style="animation-duration: 0.6s;">
        <div class="form-title">
            <i class="fas fa-edit"></i> Edit Operational Log #<?= $transaksi->id_transaksi ?>
        </div>
        
        <form action="<?= base_url('transaksi/aksi_edit') ?>" method="post">
            <input type="hidden" name="id_transaksi" value="<?= $transaksi->id_transaksi ?>">
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Client / Customer</label>
                    <select name="customer" class="form-select" required>
                        <?php foreach($customers as $c): ?>
                            <option value="<?= $c->nama ?>" <?= ($c->nama == $transaksi->customer) ? 'selected' : '' ?>>
                                <?= $c->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cradle (Trailer Unit)</label>
                    <select name="craddle" class="form-select" required>
                        <?php foreach($trailers as $t): ?>
                            <option value="<?= $t->nama ?>" <?= ($t->nama == $transaksi->craddle) ? 'selected' : '' ?>>
                                <?= $t->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Departure Date</label>
                    <input type="datetime-local" name="tgl_kirim" class="form-control" 
                           value="<?= date('Y-m-d\TH:i', strtotime($transaksi->tgl_kirim)) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Arrival Date</label>
                    <input type="datetime-local" name="tgl_ambil" class="form-control" 
                           value="<?= date('Y-m-d\TH:i', strtotime($transaksi->tgl_ambil)) ?>" required>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label">Departure Pressure</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="p_awal" class="form-control" value="<?= $transaksi->p_awal ?>" required>
                        <span class="input-group-text">BAR</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Arrival Pressure</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="p_akhir" class="form-control" value="<?= $transaksi->p_akhir ?>" required>
                        <span class="input-group-text">BAR</span>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                <a href="<?= base_url('laporan') ?>" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>