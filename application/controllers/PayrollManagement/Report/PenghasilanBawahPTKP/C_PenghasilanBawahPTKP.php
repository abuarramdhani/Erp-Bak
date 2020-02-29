<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class C_PenghasilanBawahPTKP extends CI_Controller {

		function __construct()
	    {
	        parent::__construct();
	        $this->load->library('session');
			$this->load->library('Log_Activity');
	        $this->load->helper('url');
	        $this->load->model('SystemAdministration/MainMenu/M_user');
	        $this->load->model('PayrollManagement/Report/PenghasilanBawahPTKP/M_penghasilanbawahptkp');

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
	        $data['SubMenuOne'] = 'Lap. Gaji Bawah PTKP';
	        $data['SubMenuTwo'] = '';

	        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	        $data['ShowPeriod'] = FALSE;
	        $data['current_year'] = 2017;

	        $this->load->view('V_Header',$data);
	        $this->load->view('V_Sidemenu',$data);
	        $this->load->view('PayrollManagement/Report/PenghasilanBawahPTKP/V_index', $data);
	        $this->load->view('V_Footer',$data);
	    }

	    public function search()
	    {
	        $this->checkSession();
	        $user_id = $this->session->userid;

			$year = $this->input->post('txtPeriodeTahun',TRUE);

	        $data['Menu'] = 'Laporan Penggajian';
	        $data['SubMenuOne'] = 'Lap. Gaji Bawah PTKP';
	        $data['SubMenuTwo'] = '';

	        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	        $data['daftar_karyawan'] = $this->M_penghasilanbawahptkp->get_all($year);
	        $data['year'] = $year;
	        $data['current_year'] = $year;
	        $data['ShowPeriod'] = TRUE;

	        $this->load->view('V_Header',$data);
	        $this->load->view('V_Sidemenu',$data);
	        $this->load->view('PayrollManagement/Report/PenghasilanBawahPTKP/V_index', $data);
	        $this->load->view('V_Footer',$data);
	    }

	    public function generatePDF() {
	        $this->checkSession();

	        $this->load->library('pdf');
	        $pdf = $this->pdf->load();
	        $pdf = new mPDF('utf-8', 'A4', 9, '', 5, 5, 15, 15, 0, 0, 'P');
	        $pdf->setFooter('{PAGENO}');
	        $filename = 'Karyawan dengan Penghasilan di Bawah PTKP.pdf';
	        $this->checkSession();

			$year = $this->input->get('year');
			//insert to sys.log_activity
			$aksi = 'Payroll Management';
			$detail = "Export PDF Laporan Penghasilan dibawah PTKP tahun=$year";
			$this->log_activity->activity_log($aksi, $detail);
			//

			$data['year'] = $year;

	        $data['daftar_karyawan'] = $this->M_penghasilanbawahptkp->get_all($year);

	        $stylesheet = file_get_contents(base_url('assets/css/custom.css'));
	        $html = $this->load->view('PayrollManagement/Report/PenghasilanBawahPTKP/V_report', $data, true);

	        $pdf->WriteHTML($stylesheet, 1);
	        $pdf->WriteHTML($html, 2);
	        $pdf->Output($filename, 'D');
	    }

	    public function checkSession()
	    {
	        if ($this->session->is_logged)
	        {

	        } else {
	            redirect(site_url());
	        }
	    }
	}
?>
