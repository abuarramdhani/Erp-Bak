<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RekapPembayaranJHT extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/Report/RekapPembayaranJHT/M_rekappembayaranjht');
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
        $data['SubMenuOne'] = 'Lap. Rekap Pembayaran JHT';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['period_shown'] = FALSE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/RekapPembayaranJHT/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

    public function search()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Laporan Penggajian';
        $data['SubMenuOne'] = 'Lap. Rekap Pembayaran JHT';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $no_induk = $this->input->post('txt_no_induk',TRUE);
        $year = $this->input->post('txtPeriodeTahun',TRUE);

        $data['data_karyawan'] = $this->M_rekappembayaranjht->get_employee_data($no_induk);
        $data['pembayaran_jht'] = $this->M_rekappembayaranjht->get_jht_year($no_induk, $year);
        $data['total_pembayaran_jht'] = $this->M_rekappembayaranjht->get_sum($no_induk, $year);
        $data['no_induk'] = $no_induk;
        $data['year'] = $year;

        $data['period_shown'] = TRUE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/RekapPembayaranJHT/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function generatePDF()
    {
        $this->checkSession();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', 'A4', 9, '', 15, 15, 15, 15, 0, 0, 'P');

        $filename = 'Rekap Pembayaran JHT.pdf';

        $no_induk = $this->input->get('no_induk');
        $year	 = $this->input->get('year');
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Export PDF Laporan Rekap Pembayaran JHT noind=$no_induk tahun=$year";
        $this->log_activity->activity_log($aksi, $detail);
        //

        $data['data_karyawan'] = $this->M_rekappembayaranjht->get_employee_data($no_induk);
        $data['pembayaran_jht'] = $this->M_rekappembayaranjht->get_jht_year($no_induk, $year);
        $data['total_pembayaran_jht'] = $this->M_rekappembayaranjht->get_sum($no_induk, $year);
        $data['year'] = $year;

        $stylesheet = file_get_contents(base_url('assets/css/custom.css'));
        $html = $this->load->view('PayrollManagement/Report/RekapPembayaranJHT/V_report', $data, true);

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
}
