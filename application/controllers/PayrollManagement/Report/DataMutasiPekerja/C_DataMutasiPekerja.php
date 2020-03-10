<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DataMutasiPekerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/Report/DataMutasiPekerja/M_datamutasipekerja');
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
        $data['SubMenuOne'] = 'Lap. Data Mutasi Pekerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['period_shown'] = FALSE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/DataMutasiPekerja/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

    public function search()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Laporan Penggajian';
        $data['SubMenuOne'] = 'Lap. Data Mutasi Pekerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $tgl_awal = $this->input->post('TxtStartDate',TRUE);
        $tgl_akhir = $this->input->post('TxtEndDate',TRUE);

        $data['data_mutasi'] = $this->M_datamutasipekerja->get_data_mutasi($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $data['period_shown'] = TRUE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/DataMutasiPekerja/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function generatePDF()
    {
        $this->checkSession();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', 'A4', 9, '', 10, 10, 10, 10, 0, 0, 'L');
        $pdf->AddPage('L', '', '', '', '', 10, 10, 10, 10, 8 , 8);

        $filename = 'Data Mutasi Pekerja.pdf';

        $tgl_awal = $this->input->get('awal');
        $tgl_akhir = $this->input->get('akhir');
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Export PDF Laporan Data Mutasi Pekerja range=".$tgl_awal." - ".$tgl_akhir;
        $this->log_activity->activity_log($aksi, $detail);
        //

        $data['data_mutasi'] = $this->M_datamutasipekerja->get_data_mutasi($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $stylesheet = file_get_contents(base_url('assets/css/custom.css'));
        $html = $this->load->view('PayrollManagement/Report/DataMutasiPekerja/V_report', $data, true);

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
