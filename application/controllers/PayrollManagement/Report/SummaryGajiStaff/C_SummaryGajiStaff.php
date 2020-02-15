<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SummaryGajiStaff extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/Report/SummaryGajiStaff/M_summarygajistaff');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Laporan Penggajian';
        $data['SubMenuOne'] = 'Lap. Summary Gaji Staff';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['period_shown'] = FALSE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/SummaryGajiStaff/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

    public function search()
	    {
	        $this->checkSession();
	        $user_id = $this->session->userid;

	        $data['Menu'] = 'Laporan Penggajian';
	        $data['SubMenuOne'] = 'Lap. Summary Gaji Staff';
	        $data['SubMenuTwo'] = '';

	        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

            $periode = $this->input->post('txtPeriodeHitung',TRUE);
            $year    = substr($periode,0,4);
            $month   = substr($periode,5,2);

            $data['summary'] = $this->generateDataArray($year, $month);

	        $data['year'] = $year;
            $data['month'] = $month;
            $data['period_shown'] = TRUE;

	        $this->load->view('V_Header',$data);
	        $this->load->view('V_Sidemenu',$data);
	        $this->load->view('PayrollManagement/Report/SummaryGajiStaff/V_index', $data);
	        $this->load->view('V_Footer',$data);
	    }

	public function generatePDF() {
        $this->checkSession();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', 'A4', 10, '', 10, 10, 15, 15, 0, 0, 'P');

        $filename = 'Summary Gaji Staff';

        $year = $this->input->get('year');
        $month = $this->input->get('month');
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Export PDF Laporan Summary gaji staf bulan=$month tahun=$year";
        $this->log_activity->activity_log($aksi, $detail);
        //

        $data['summary'] = $this->generateDataArray($year, $month);
        $data['year'] = $year;
        $data['month'] = $month;

        $stylesheet = file_get_contents(base_url('assets/css/custom.css'));
        $html = $this->load->view('PayrollManagement/Report/SummaryGajiStaff/V_report', $data, true);

        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html, 2);
        $pdf->Output($filename, 'D');
    }

    public function checkSession(){
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }

    public function generateDataArray($year, $month)
    {
        $source = $this->M_summarygajistaff->get_salaries_by_dept($year, $month);
        $total = $this->M_summarygajistaff->get_total($year, $month);

        $result = array();

        $ar_gaji_pokok = array("Gaji Pokok");
        $ar_i_f = array("Ins. Fungsional");
        $ar_i_kmhl = array("Ins. Kemahalan");
        $ar_i_p = array("Ins. Prestasi");
        $ar_i_k = array("Ins. Kondite");
        $ar_i_ms = array("Ins. Masuk Siang");
        $ar_i_mm = array("Ins. Masuk Malam");
        $ar_lembur = array("Lembur");
        $ar_ubt = array("UBT");
        $ar_upamk = array("UPAMK");
        $ar_klaim_bln_lalu = array("Klm. Bulan Lalu");
        $ar_klaim_pengangkatan = array("Klm. Pengangkatan");
        $ar_konpensasi_lembur = array("Kompensasi Lembur");
        $ar_pot_htm = array("Pot. HTM");
        $ar_pot_sakit_lama = array("Pot. Sakit Lama");
        $ar_subtotal_dibayarkan = array("Subtotal Dibayarkan");
        $ar_klaim_sudah_bayar = array("Klm. Sudah Bayar");
        $ar_tamb_subs_pajak = array("Tamb. Subs. Pajak");
        $ar_subtotal1 = array("Subtotal 1");
        $ar_pot_klm_sdh_byr = array("Pot. Klm. Sdh. Bayar");
        $ar_pot_subs_pajak = array("Pot. Subs. Pajak");
        $ar_subtotal2 = array("Subtotal 2");
        $ar_pot_jht = array("Pot. JHT");
        $ar_pot_jkn = array("Pot. JKN");
        $ar_pot_kop = array("Pot. Koperasi");
        $ar_pot_utang = array("Pot. Hutang");
        $ar_pot_duka = array("Pot. Duka");
        $ar_pot_spsi = array("Pot. SPSI");
        $ar_pot_pensiun = array("Pot. Pensiun");
        $ar_pot_transfer = array("Pot. Transfer");
        $ar_thp = array("Terima");

        for ($i = 0; $i < 4; $i++) {
            array_push($ar_gaji_pokok, isset($source[$i]['gaji_pokok']) ? $source[$i]['gaji_pokok'] : 0);
            array_push($ar_i_f, isset($source[$i]['i_f']) ? $source[$i]['i_f'] : 0);
            array_push($ar_i_kmhl, isset($source[$i]['i_kmhl']) ? $source[$i]['i_kmhl'] : 0);
            array_push($ar_i_p, isset($source[$i]['i_p']) ? $source[$i]['i_p'] : 0);
            array_push($ar_i_k, isset($source[$i]['i_k']) ? $source[$i]['i_k'] : 0);
            array_push($ar_i_ms, isset($source[$i]['i_ms']) ? $source[$i]['i_ms'] : 0);
            array_push($ar_i_mm, isset($source[$i]['i_mm']) ? $source[$i]['i_mm'] : 0);
            array_push($ar_lembur, isset($source[$i]['lembur']) ? $source[$i]['lembur'] : 0);
            array_push($ar_ubt, isset($source[$i]['ubt']) ? $source[$i]['ubt'] : 0);
            array_push($ar_upamk, isset($source[$i]['upamk']) ? $source[$i]['upamk'] : 0);
            array_push($ar_klaim_bln_lalu, isset($source[$i]['klaim_bln_lalu']) ? $source[$i]['klaim_bln_lalu'] : 0);
            array_push($ar_klaim_pengangkatan, isset($source[$i]['klaim_pengangkatan']) ? $source[$i]['klaim_pengangkatan'] : 0);
            array_push($ar_konpensasi_lembur, isset($source[$i]['konpensasi_lembur']) ? $source[$i]['konpensasi_lembur'] : 0);
            array_push($ar_pot_htm, isset($source[$i]['pot_htm']) ? $source[$i]['pot_htm'] : 0);
            array_push($ar_pot_sakit_lama, isset($source[$i]['pot_sakit_lama']) ? $source[$i]['pot_sakit_lama'] : 0);
            array_push($ar_subtotal_dibayarkan, isset($source[$i]['subtotal_dibayarkan']) ? $source[$i]['subtotal_dibayarkan'] : 0);
            array_push($ar_klaim_sudah_bayar, isset($source[$i]['klaim_sdh_byr']) ? $source[$i]['klaim_sdh_byr'] : 0);
            array_push($ar_tamb_subs_pajak, isset($source[$i]['tamb_subs_pajak']) ? $source[$i]['tamb_subs_pajak'] : 0);
            array_push($ar_subtotal1, isset($source[$i]['subtotal1']) ? $source[$i]['subtotal1'] : 0);
            array_push($ar_pot_klm_sdh_byr, isset($source[$i]['pot_klaim_sdh_byr']) ? $source[$i]['pot_klaim_sdh_byr'] : 0);
            array_push($ar_pot_subs_pajak, isset($source[$i]['pot_subs_pajak']) ? $source[$i]['pot_subs_pajak'] : 0);
            array_push($ar_subtotal2, isset($source[$i]['subtotal2']) ? $source[$i]['subtotal2'] : 0);
            array_push($ar_pot_jht, isset($source[$i]['pot_jht']) ? $source[$i]['pot_jht'] : 0);
            array_push($ar_pot_jkn, isset($source[$i]['pot_jkn']) ? $source[$i]['pot_jkn'] : 0);
            array_push($ar_pot_kop, isset($source[$i]['pot_kop']) ? $source[$i]['pot_kop'] : 0);
            array_push($ar_pot_utang, isset($source[$i]['pot_utang']) ? $source[$i]['pot_utang'] : 0);
            array_push($ar_pot_duka, isset($source[$i]['pot_duka']) ? $source[$i]['pot_duka'] : 0);
            array_push($ar_pot_spsi, isset($source[$i]['pot_spsi']) ? $source[$i]['pot_spsi'] : 0);
            array_push($ar_pot_pensiun, isset($source[$i]['pot_pensiun']) ? $source[$i]['pot_pensiun'] : 0);
            array_push($ar_pot_transfer, isset($source[$i]['pot_transfer']) ? $source[$i]['pot_transfer'] : 0);
            array_push($ar_thp, isset($source[$i]['thp']) ? $source[$i]['thp'] : 0);
        }

        array_push($ar_gaji_pokok, isset($total['gaji_pokok']) ? $total['gaji_pokok'] : 0);
        array_push($ar_i_f, isset($total['i_f']) ? $total['i_f'] : 0);
        array_push($ar_i_kmhl, isset($total['i_kmhl']) ? $total['i_kmhl'] : 0);
        array_push($ar_i_p, isset($total['i_p']) ? $total['i_p'] : 0);
        array_push($ar_i_k, isset($total['i_k']) ? $total['i_k'] : 0);
        array_push($ar_i_ms, isset($total['i_ms']) ? $total['i_ms'] : 0);
        array_push($ar_i_mm, isset($total['i_mm']) ? $total['i_mm'] : 0);
        array_push($ar_lembur, isset($total['lembur']) ? $total['lembur'] : 0);
        array_push($ar_ubt, isset($total['ubt']) ? $total['ubt'] : 0);
        array_push($ar_upamk, isset($total['upamk']) ? $total['upamk'] : 0);
        array_push($ar_klaim_bln_lalu, isset($total['klaim_bln_lalu']) ? $total['klaim_bln_lalu'] : 0);
        array_push($ar_klaim_pengangkatan, isset($total['klaim_pengangkatan']) ? $total['klaim_pengangkatan'] : 0);
        array_push($ar_konpensasi_lembur, isset($total['konpensasi_lembur']) ? $total['konpensasi_lembur'] : 0);
        array_push($ar_pot_htm, isset($total['pot_htm']) ? $total['pot_htm'] : 0);
        array_push($ar_pot_sakit_lama, isset($total['pot_sakit_lama']) ? $total['pot_sakit_lama'] : 0);
        array_push($ar_subtotal_dibayarkan, isset($total['subtotal_dibayarkan']) ? $total['subtotal_dibayarkan'] : 0);
        array_push($ar_klaim_sudah_bayar, isset($total['klaim_sdh_byr']) ? $total['klaim_sdh_byr'] : 0);
        array_push($ar_tamb_subs_pajak, isset($total['tamb_subs_pajak']) ? $total['tamb_subs_pajak'] : 0);
        array_push($ar_subtotal1, isset($total['subtotal1']) ? $total['subtotal1'] : 0);
        array_push($ar_pot_klm_sdh_byr, isset($total['pot_klaim_sdh_byr']) ? $total['pot_klaim_sdh_byr'] : 0);
        array_push($ar_pot_subs_pajak, isset($total['pot_subs_pajak']) ? $total['pot_subs_pajak'] : 0);
        array_push($ar_subtotal2, isset($total['subtotal2']) ? $total['subtotal2'] : 0);
        array_push($ar_pot_jht, isset($total['pot_jht']) ? $total['pot_jht'] : 0);
        array_push($ar_pot_jkn, isset($total['pot_jkn']) ? $total['pot_jkn'] : 0);
        array_push($ar_pot_kop, isset($total['pot_kop']) ? $total['pot_kop'] : 0);
        array_push($ar_pot_utang, isset($total['pot_utang']) ? $total['pot_utang'] : 0);
        array_push($ar_pot_duka, isset($total['pot_duka']) ? $total['pot_duka'] : 0);
        array_push($ar_pot_spsi, isset($total['pot_spsi']) ? $total['pot_spsi'] : 0);
        array_push($ar_pot_pensiun, isset($total['pot_pensiun']) ? $total['pot_pensiun'] : 0);
        array_push($ar_pot_transfer, isset($total['pot_transfer']) ? $total['pot_transfer'] : 0);
        array_push($ar_thp, isset($total['thp']) ? $total['thp'] : 0);

        array_push($result, $ar_gaji_pokok);
        array_push($result, $ar_i_f);
        array_push($result, $ar_i_kmhl);
        array_push($result, $ar_i_p);
        array_push($result, $ar_i_k);
        array_push($result, $ar_i_ms);
        array_push($result, $ar_i_mm);
        array_push($result, $ar_lembur);
        array_push($result, $ar_ubt);
        array_push($result, $ar_upamk);
        array_push($result, $ar_klaim_bln_lalu);
        array_push($result, $ar_klaim_pengangkatan);
        array_push($result, $ar_konpensasi_lembur);
        array_push($result, $ar_pot_htm);
        array_push($result, $ar_pot_sakit_lama);
        array_push($result, $ar_subtotal_dibayarkan);
        array_push($result, $ar_klaim_sudah_bayar);
        array_push($result, $ar_tamb_subs_pajak);
        array_push($result, $ar_subtotal1);
        array_push($result, $ar_pot_klm_sdh_byr);
        array_push($result, $ar_pot_subs_pajak);
        array_push($result, $ar_subtotal2);
        array_push($result, $ar_pot_jht);
        array_push($result, $ar_pot_jkn);
        array_push($result, $ar_pot_kop);
        array_push($result, $ar_pot_utang);
        array_push($result, $ar_pot_duka);
        array_push($result, $ar_pot_spsi);
        array_push($result, $ar_pot_pensiun);
        array_push($result, $ar_pot_transfer);
        array_push($result, $ar_thp);

        return $result;
    }
}
