<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PENTING: Namespace 'use' harus berada di luar class.
 * Ini memberitahu PHP di mana letak library PhpSpreadsheet berada.
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_transaksi $M_transaksi
 */
class Analytics extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /**
         * SOLUSI FATAL ERROR:
         * Baris ini memaksa CodeIgniter memuat library dari folder vendor.
         * FCPATH merujuk ke direktori utama (C:\xampp\htdocs\gasra_platform\).
         */
        if (file_exists(FCPATH . 'vendor/autoload.php')) {
            require_once FCPATH . 'vendor/autoload.php';
        }

        $this->load->model('M_transaksi');
        
        // Proteksi login
        if($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index() {
        $year = $this->input->get('year') ? $this->input->get('year') : date('Y');
        $raw_data = $this->M_transaksi->get_analytics_data($year);

        $monthly_sm3 = array_fill(1, 12, 0); 
        $cradle_usage = [];
        $client_efficiency = [];
        $revenue_by_client = [];

        foreach ($raw_data as $row) {
            $month_idx = (int)$row->Month;
            $monthly_sm3[$month_idx] += (float)$row->Nilai_SM3_Total;

            if (!isset($cradle_usage[$row->Cradle])) $cradle_usage[$row->Cradle] = 0;
            $cradle_usage[$row->Cradle]++;

            if (!isset($client_efficiency[$row->Customer])) {
                $client_efficiency[$row->Customer] = ['total_eff' => 0, 'count' => 0];
            }
            $p_awal = (float)$row->P_Kirim;
            $p_akhir = (float)$row->P_Ambil;
            $eff = ($p_awal > 0) ? (($p_awal - $p_akhir) / $p_awal) * 100 : 0;
            
            $client_efficiency[$row->Customer]['total_eff'] += $eff;
            $client_efficiency[$row->Customer]['count']++;

            if (!isset($revenue_by_client[$row->Customer])) $revenue_by_client[$row->Customer] = 0;
            $revenue_by_client[$row->Customer] += (float)$row->Revenue_IDR;
        }

        arsort($cradle_usage); 
        arsort($revenue_by_client); 

        $data['user_now'] = $this->session->userdata('nama');
        $data['year_selected'] = $year;
        $data['chart_growth'] = array_values($monthly_sm3);
        $data['chart_cradle'] = array_slice($cradle_usage, 0, 5); 
        $data['chart_revenue'] = $revenue_by_client;
        
        $eff_final = [];
        foreach ($client_efficiency as $client => $val) {
            $eff_final[$client] = round($val['total_eff'] / $val['count'], 2);
        }
        arsort($eff_final);
        $data['chart_efficiency'] = $eff_final;

        $this->load->view('v_analytics', $data);
    }

    public function export_excel() {
        $year = $this->input->get('year') ? $this->input->get('year') : date('Y');
        $raw_data = $this->M_transaksi->get_analytics_data($year);

        if (empty($raw_data)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Tidak ada data untuk diekspor pada tahun ' . $year . '</div>');
            redirect(base_url('analytics'));
        }

        // Inisialisasi Class Spreadsheet (Baris 99)
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1B4332']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $sheet->setCellValue('A1', 'LAPORAN OPERASIONAL GASRA TAHUN ' . $year);
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headers = ['ID', 'Customer', 'Tanggal', 'Cradle', 'P Kirim (Bar)', 'P Ambil (Bar)', 'Fpv Total', 'SM3 Kirim', 'SM3 Ambil', 'SM3 Total', 'Harga (Rp)', 'Total Revenue (Rp)'];
        $column = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($column . '3', $h);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }
        $sheet->getStyle('A3:L3')->applyFromArray($styleHeader);

        $row_num = 4;
        foreach ($raw_data as $row) {
            $sheet->setCellValue('A' . $row_num, $row->id_transaksi);
            $sheet->setCellValue('B' . $row_num, $row->Customer);
            $sheet->setCellValue('C' . $row_num, $row->Tanggal);
            $sheet->setCellValue('D' . $row_num, $row->Cradle);
            $sheet->setCellValue('E' . $row_num, $row->P_Kirim);
            $sheet->setCellValue('F' . $row_num, $row->P_Ambil);
            $sheet->setCellValue('G' . $row_num, $row->Fpv_Total);
            $sheet->setCellValue('H' . $row_num, $row->SM3_Kirim);
            $sheet->setCellValue('I' . $row_num, $row->SM3_Ambil);
            $sheet->setCellValue('J' . $row_num, $row->Nilai_SM3_Total);
            $sheet->setCellValue('K' . $row_num, $row->Harga);
            $sheet->setCellValue('L' . $row_num, $row->Revenue_IDR);
            
            $sheet->getStyle('K' . $row_num . ':L' . $row_num)->getNumberFormat()->setFormatCode('#,##0.00');
            $row_num++;
        }

        $sheet->getStyle('A3:L' . ($row_num - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $filename = "Laporan_GASRA_" . $year . ".xlsx";
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}