<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RekapPenerimaanGajiStaff extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/Report/RekapPenerimaanGajiStaff/M_rekappenerimaangajistaff');
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
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['period_shown'] = FALSE;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/Report/RekapPenerimaanGajiStaff/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

    public function search()
	    {
	        $this->checkSession();
	        $user_id = $this->session->userid;
	        			
	        $data['Menu'] = 'Payroll Management';
	        $data['SubMenuOne'] = '';
	        $data['SubMenuTwo'] = '';

	        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

            $periode = $this->input->post('txtPeriodeHitung',TRUE);
            $year    = substr($periode,0,4);
            $month   = substr($periode,5,2);
            $bank = $this->input->post('txtBank', TRUE);

            $data['year'] = $year;
            $data['month'] = $month;
            $data['bank'] = $bank;
            $data['period_shown'] = TRUE;

            $data['data_gaji'] = $this->M_rekappenerimaangajistaff->get_salaries_paid_to_some_bank_on_some_period($bank, $year, $month);
            $data['total'] = $this->M_rekappenerimaangajistaff->get_sum_of_salaries_and_transfer_fees($bank, $year, $month);

	        $this->load->view('V_Header',$data);
	        $this->load->view('V_Sidemenu',$data);
	        $this->load->view('PayrollManagement/Report/RekapPenerimaanGajiStaff/V_index', $data);
	        $this->load->view('V_Footer',$data);
	    }

	public function generatePDF() {
        $this->checkSession();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', 'A4', 9, '', 15, 15, 15, 15, 0, 0, 'P');
        
        $filename = 'Rekap Penerimaan Gaji Staff per Bank';

        $year = $this->input->get('year');
        $month = $this->input->get('month');
        $bank = $this->input->get('bank');

        $data['year'] = $year;
        $data['month'] = $month;
        $data['bank'] = $bank;
        $data['data_gaji'] = $this->M_rekappenerimaangajistaff->get_salaries_paid_to_some_bank_on_some_period($bank, $year, $month);
        $data['total'] = $this->M_rekappenerimaangajistaff->get_sum_of_salaries_and_transfer_fees($bank, $year, $month);

        $stylesheet = file_get_contents(base_url('assets/css/custom.css'));
        $html = $this->load->view('PayrollManagement/Report/RekapPenerimaanGajiStaff/V_report', $data, true);

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