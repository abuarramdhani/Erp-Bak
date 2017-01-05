<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/Report/M_report');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	public function kenaikangaji(){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(210,297), 0, '', 0, 0, 0, 0);

		$filename = 'CrystalReport-KenaikanGaji-';
		$this->checkSession();

		$data['main_data'] = $this->M_report->kenaikangaji();

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('PayrollManagement/Report/V_Kenaikangaji', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}

	public function rincianhutang($id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(297,210), 0, '', 0, 0, 0, 0);

		$filename = 'CrystalReport-KenaikanGaji-';
		$this->checkSession();

		$data['main_data'] = $this->M_report->rincianhutang($id);
		$data['secondary_data'] = $this->M_report->cicilanhutang($id);

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('PayrollManagement/Report/V_RincianHutang', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}

    public function checkSession(){
        if($this->session->is_logged){
            
        }else{
            redirect(site_url());
        }
    }

    public function formValidation()
    {
	}

}

/* End of file C_DataGajianPersonalia.php */
/* Location: ./application/controllers/PayrollManagement/DataHariMasuk/C_DataGajianPersonalia.php */
/* Generated automatically on 2016-11-29 11:21:18 */