<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Rekap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_cetakdata');
		$this->load->model('UpahHlCm/M_prosesgaji');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MenuCetak/V_Rekap',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function cetakpdf()
	{
		$this->load->library('pdf');

		$data['periode'] = $this->input->post('periode');
		$periodew = explode(' - ', $data['periode']);
		$tanggalawal = date('Y-m-d',strtotime($periodew[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periodew[1]));

		$tgl = date('F-Y',strtotime($tanggalawal));
		$noind = "";

		$data['kom'] = $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$noind);
		$data['nom'] = $this->M_prosesgaji->ambilNominalGaji();
		$data['rekap'] = $this->M_cetakdata->ambildataRekap($tanggalawal,$tanggalakhir);

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'F4', 8, '', 12, 15, 15, 15, 10, 20);
		$filename = 'Rekap-'.$tgl.'.pdf';

		$html = $this->load->view('UpahHlCm/MenuCetak/V_cetakRekap', $data, true);

		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'D');


	}
}
