<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterGajiKaryawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/Report/MasterGajiKaryawan/M_mastergajikaryawan');
        if($this->session->userdata('logged_in')!=TRUE)
        {
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
        $data['SubMenuOne'] = 'Lap. Master Gaji';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


        $data['departments'] = $this->M_mastergajikaryawan->get_departments();
        $data['dept_selected'] = "-";

		$data['ShowPeriod'] = FALSE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/MasterGajiKaryawan/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

    public function search()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

		$periode = $this->input->post('txtPeriodeHitung',TRUE);
		$dt = explode("/",$periode);
		$year	 = $dt[1];
		$month	 = $dt[0];
        $data['Menu'] = 'Laporan Penggajian';
        $data['SubMenuOne'] = 'Lap. Master Gaji';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['departments'] = $this->M_mastergajikaryawan->get_departments();
        $selected = $this->input->post('txtDept', TRUE);

        $data['dept_selected'] = $selected;

        $data['master_gaji'] = $this->M_mastergajikaryawan->get_all($year, $month, $selected);
        $data['year'] = $year;
        $data['month'] = $month;
        $data['ShowPeriod'] = TRUE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/MasterGajiKaryawan/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function generatePDF()
    {
        $this->checkSession();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', 'A4', 8, '', '', '', '', '', '', '', 'L');
        $pdf->AddPage('L', '', '', '', '', 15, 15, 10, 10, 0, 0);
        $pdf->setFooter('{PAGENO}');
        $filename = 'Master Gaji Karyawan.pdf';
        $this->checkSession();

        $year	 = $this->input->get('year');
		$month	 = $this->input->get('month');
        $selected = $this->input->get('dept');
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Export PDF Laporan Master Gaji Karyawan dept=$selected bulan=$month-$year";
        $this->log_activity->activity_log($aksi, $detail);
        //

        $data['dept_selected'] = $selected;

        $data['master_gaji'] = $this->M_mastergajikaryawan->get_all($year, $month, $selected);
        $data['year'] = $year;
	    $data['month'] = $month;

        $stylesheet = file_get_contents(base_url('assets/css/custom.css'));
        $html = $this->load->view('PayrollManagement/Report/MasterGajiKaryawan/V_report', $data, true);



        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html, 2);
        $pdf->Output($filename, 'D');
    }

    public function checkSession()
    {
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }
}
