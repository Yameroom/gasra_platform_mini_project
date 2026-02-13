<!DOCTYPE html>
<html>
<head>
    <title>GASRA | Official Operational Report</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #111827; line-height: 1.4; padding: 10px; }
        .header { border-bottom: 3px solid #001d3d; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .company-name { font-size: 22px; font-weight: 800; color: #001d3d; margin: 0; }
        .doc-type { text-transform: uppercase; font-size: 12px; letter-spacing: 2px; color: #64748b; font-weight: bold; }
        
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .meta-table td { padding: 4px 0; font-size: 11px; vertical-align: top; }
        .label { font-weight: bold; color: #64748b; width: 100px; }
        
        .section-title { font-size: 10px; font-weight: 800; color: #001d3d; text-transform: uppercase; margin-bottom: 8px; border-left: 3px solid #001d3d; padding-left: 8px; }

        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .main-table th { background-color: #f8fafc; color: #001d3d; font-size: 9px; text-transform: uppercase; padding: 10px; text-align: left; border: 1px solid #e2e8f0; }
        .main-table td { padding: 10px; font-size: 11px; border: 1px solid #e2e8f0; }
        
        .gas-comp-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background-color: #fcfcfc; }
        .gas-comp-table td { border: 1px solid #eee; padding: 8px; font-size: 10px; text-align: center; }
        .gas-label { font-weight: bold; color: #64748b; font-size: 9px; }

        .summary-box { background-color: #f0f7ff; padding: 15px; border-radius: 12px; border: 1px solid #001d3d; }
        .total-label { font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: bold; }
        .total-value { font-size: 18px; font-weight: bold; color: #001d3d; }
        
        /* FOOTER & SIGNATURE AREA */
        .footer { margin-top: 50px; width: 100%; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { width: 45%; text-align: center; font-size: 11px; vertical-align: bottom; }
        .sig-space { height: 75px; }
        .sign-line { border-top: 1px solid #111827; padding-top: 5px; font-weight: bold; text-transform: uppercase; margin: 0 20px; }
        .issued-date { font-size: 9px; color: #64748b; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <p class="company-name">GASRA INTELLIGENCE SYSTEM</p>
        <span class="doc-type">Official AGA8 Transmission Log</span>
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">CUSTOMER</td>
            <td>: <strong><?= $transaksi->Customer; ?></strong></td>
            <td class="label">LOG ID</td>
            <td>: <strong>#<?= $transaksi->id_transaksi; ?></strong></td>
        </tr>
        <tr>
            <td class="label">DATE</td>
            <td>: <?= date('d F Y', strtotime($transaksi->Tanggal)); ?></td>
            <td class="label">CRADLE UNIT</td>
            <td>: <?= $transaksi->Cradle; ?></td>
        </tr>
    </table>

    <div class="section-title">Gas Composition Parameter</div>
    <table class="gas-comp-table">
        <tr>
            <td><span class="gas-label">CO2</span><br><strong><?= $transaksi->CO2; ?> %</strong></td>
            <td><span class="gas-label">N2</span><br><strong><?= $transaksi->N2; ?> %</strong></td>
            <td><span class="gas-label">SG</span><br><strong><?= $transaksi->SG; ?></strong></td>
        </tr>
    </table>

    <div class="section-title">Operational Measurement</div>
    <table class="main-table">
        <thead>
            <tr>
                <th>Measurement Point</th>
                <th>Departure (Kirim)</th>
                <th>Arrival (Ambil)</th>
                <th>Variance</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>System Pressure</td>
                <td><?= number_format($transaksi->P_Kirim, 2); ?> Bar</td>
                <td><?= number_format($transaksi->P_Ambil, 2); ?> Bar</td>
                <td><?= number_format($transaksi->P_Kirim - $transaksi->P_Ambil, 2); ?> Bar</td>
            </tr>
            <tr>
                <td>Temperature</td>
                <td><?= number_format($transaksi->T_Awal, 1); ?> °C</td>
                <td><?= number_format($transaksi->T_Akhir, 1); ?> °C</td>
                <td><?= number_format($transaksi->T_Awal - $transaksi->T_Akhir, 1); ?> °C</td>
            </tr>
            <tr>
                <td>Fpv (Compressibility)</td>
                <td><?= number_format($transaksi->Fpv_Kirim, 4); ?></td>
                <td><?= number_format($transaksi->Fpv_Ambil, 4); ?></td>
                <td><?= number_format($transaksi->Fpv_Total, 4); ?></td>
            </tr>
            <tr>
                <td>Volume (SM3)</td>
                <td><?= number_format($transaksi->SM3_Kirim, 2); ?></td>
                <td><?= number_format($transaksi->SM3_Ambil, 2); ?></td>
                <td><strong><?= number_format($transaksi->Nilai_SM3_Total, 2); ?> SM3</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="summary-box">
        <table width="100%">
            <tr>
                <td>
                    <span class="total-label">Billing Rate</span><br>
                    <span style="font-size: 14px; font-weight: bold;">IDR <?= number_format($transaksi->Harga, 0, ',', '.'); ?> / SM3</span>
                </td>
                <td align="right">
                    <span class="total-label">Total Revenue Value</span><br>
                    <span class="total-value">IDR <?= number_format($transaksi->Revenue_IDR, 0, ',', '.'); ?></span>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <table class="sig-table">
            <tr>
                <td class="sig-box">
                    <p>Acknowledged by (Customer),</p>
                    <div class="sig-space"></div>
                    <p class="sign-line"><?= $transaksi->Customer; ?></p>
                </td>
                <td width="10%"></td>
                <td class="sig-box">
                    <p>Validated & Authorized by,</p>
                    <div class="sig-space"></div>
                    <p class="sign-line">GASRA OPERATIONAL DIV.</p>
                </td>
            </tr>
        </table>
        <p class="issued-date">System generated log: <?= date('d/m/Y H:i:s'); ?></p>
    </div>
</body>
</html>