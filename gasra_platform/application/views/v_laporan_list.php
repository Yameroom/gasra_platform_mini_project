<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | Transaction List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
        
        .report-card {
            background: var(--white); border-radius: 20px; padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid rgba(0,0,0,0.02);
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
            outline: none;
        }

        .table thead th {
            background: #f8fafc; 
            color: var(--text-muted);
            font-size: 0.65rem; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            padding: 15px; 
            border: none; 
            font-weight: 800;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--gasra-blue-base) !important;
            border-color: var(--gasra-blue-base) !important;
            color: #ffffff !important; 
            font-weight: 700;
        }

        .pagination .page-link {
            color: var(--gasra-blue-base);
            border-radius: 8px !important;
            margin: 0 3px;
            border: none;
            font-size: 0.85rem;
            padding: 8px 14px;
            background: #f8fafc;
        }

        /* ACTIONS BUTTON STYLING - TETAP MINIMALIS */
        .btn-action {
            width: 34px; height: 34px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: 0.3s; border: none; font-size: 0.9rem;
            text-decoration: none;
        }
        .btn-view { background: #e0f2fe; color: #0369a1; }
        .btn-pdf { background: #fef2f2; color: #dc2626; } /* Warna merah pucat minimalis */
        .btn-edit { background: #fef3c7; color: #b45309; }
        .btn-delete { background: #fee2e2; color: #ef4444; cursor: pointer; }
        .btn-action:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        .badge-vol { 
            background: #f0f9ff; 
            color: #0369a1; 
            font-weight: 700; 
            padding: 6px 14px; 
            border-radius: 10px; 
            font-size: 0.8rem; 
            border: 1px solid #e0f2fe;
        }
        
        .btn-entry {
            background: var(--gasra-blue-base); color: white;
            border: none; border-radius: 12px; padding: 12px 24px;
            font-weight: 600; font-size: 0.85rem; transition: 0.3s;
            text-decoration: none;
        }

        /* ULTIMATE MINIMALIST SWEETALERT CUSTOMIZATION */
        .swal2-popup {
            border-radius: 28px !important;
            padding: 2.5rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 29, 61, 0.15) !important;
        }
        .swal2-title {
            font-size: 1.4rem !important;
            font-weight: 800 !important;
            color: var(--gasra-blue-base) !important;
            letter-spacing: -0.5px !important;
        }
        .swal2-html-container {
            color: var(--text-muted) !important;
            font-size: 0.9rem !important;
            font-weight: 500 !important;
        }
        .swal2-actions {
            margin-top: 2rem !important;
            gap: 12px !important;
        }
        .swal2-styled {
            margin: 0 !important;
            padding: 12px 35px !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            border-radius: 14px !important;
            transition: 0.3s !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        .swal2-styled.swal2-confirm {
            background-color: var(--gasra-blue-base) !important;
            box-shadow: 0 4px 12px rgba(0, 29, 61, 0.2) !important;
        }
        .swal2-styled.swal2-cancel {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
        }
        .swal2-icon {
            border: none !important;
            margin-bottom: 1.5rem !important;
        }
    </style>
</head>
<body>

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

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="animate__animated animate__fadeInLeft" style="animation-duration: 0.6s;">
            <h2 class="fw-bold m-0" style="letter-spacing: -1.5px; color: var(--gasra-blue-base);">Technical Book Report</h2>
            <p class="text-muted small m-0">Detailed operational logs and transmission history.</p>
        </div>
        <a href="<?php echo base_url('transaksi/tambah'); ?>" class="btn-entry animate__animated animate__fadeInRight" style="animation-duration: 0.6s;">
            <i class="fas fa-plus me-2"></i> New Transaction
        </a>
    </div>

    <div class="report-card animate__animated animate__zoomIn" style="animation-duration: 0.7s;">
        <div class="table-responsive">
            <table class="table m-0 align-middle" id="laporanTable">
                <thead>
                    <tr>
                        <th>Customer & Date</th>
                        <th>Cradle ID</th>
                        <th>Total Volume</th>
                        <th>Revenue Est.</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($report)): ?>
                        <?php foreach($report as $r): ?>
                        <tr>
                            <td>
                                <div class="fw-bold" style="color: var(--gasra-blue-base);"><?php echo $r->Customer; ?></div>
                                <div class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-calendar-alt me-1"></i> <?php echo date('d M Y', strtotime($r->Tanggal)); ?></div>
                            </td>
                            <td><code class="px-2 py-1 bg-light rounded text-primary" style="font-size: 0.8rem;">#<?php echo $r->Cradle; ?></code></td>
                            <td><span class="badge-vol"><?php echo number_format($r->Nilai_SM3_Total, 2, ',', '.'); ?> SM3</span></td>
                            <td class="fw-bold text-dark">Rp <?php echo number_format($r->Revenue_IDR, 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo base_url('laporan/detail/'.$r->id_transaksi); ?>" class="btn-action btn-view" title="View Detail"><i class="fas fa-eye"></i></a>
                                    
                                    <a href="<?php echo base_url('laporan/cetak_pdf/'.$r->id_transaksi); ?>" target="_blank" class="btn-action btn-pdf" title="Cetak PDF Resmi">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>

                                    <a href="<?php echo base_url('transaksi/edit/'.$r->id_transaksi); ?>" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                    
                                    <button type="button" onclick="confirmDelete('<?= $r->id_transaksi; ?>')" class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        if (history.scrollRestoration) { history.scrollRestoration = 'manual'; }
        window.scrollTo(0, 0);

        $('#laporanTable').DataTable({
            "pageLength": 10,
            "order": [[0, "desc"]],
            "language": {
                "search": "Filter Data:",
                "lengthMenu": "Show _MENU_ records",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": { "next": "<i class='fas fa-chevron-right'></i>", "previous": "<i class='fas fa-chevron-left'></i>" }
            },
            "dom": '<"d-flex justify-content-between align-items-center mb-3"l f>rt<"d-flex justify-content-between align-items-center mt-4"i p>',
            "ordering": true
        });

        <?php if($this->session->flashdata('pesan')): ?>
            setTimeout(() => {
                Swal.fire({
                    title: 'SUCCESS',
                    text: '<?= strip_tags($this->session->flashdata('pesan')); ?>',
                    icon: 'success',
                    iconColor: '#001d3d',
                    timer: 2000,
                    showConfirmButton: false,
                    backdrop: `rgba(0, 29, 61, 0.1)`,
                    showClass: { popup: 'animate__animated animate__fadeIn' },
                    hideClass: { popup: 'animate__animated animate__fadeOut' }
                });
            }, 800);
        <?php endif; ?>
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete this record?',
            text: "This operation cannot be reversed.",
            icon: 'question',
            iconColor: '#ef4444',
            showCancelButton: true,
            confirmButtonText: 'Confirm Delete',
            cancelButtonText: 'Go Back',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#f1f5f9',
            reverseButtons: true,
            backdrop: `rgba(0, 29, 61, 0.4)`,
            showClass: { popup: 'animate__animated animate__zoomIn' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('transaksi/hapus/'); ?>" + id;
            }
        })
    }
</script>

</body>
</html>