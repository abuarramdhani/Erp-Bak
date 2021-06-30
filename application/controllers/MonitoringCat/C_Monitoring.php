<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringCat/M_moncat');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Cat';
		$data['Menu'] = 'Monitoring Cat';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCat/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function view_monitoring(){
		$data['data'] = $this->M_moncat->getMonitoringCat();
		// echo "<pre>";print_r($data);exit();
		$this->load->view('MonitoringCat/ajax/V_Monitoring_Table', $data);
	}
	
	public function hapus_cat(){
		$code = $this->input->post('code');
		$datanya = $this->M_moncat->getdataCetakCat($code);
		$this->M_moncat->input_history_cat($datanya[0]['RECEIPT_NUM'], $datanya[0]['INVENTORY_ITEM_ID'], $datanya[0]['QUANTITY'], $datanya[0]['TRANSACTION_DATE'], $datanya[0]['CODE'], $datanya[0]['CREATION_DATE'], $datanya[0]['CREATED_BY']);
		$this->M_moncat->hapus_cat($code);
	}

	public function cetak_cat($code){
		$getdata = $this->M_moncat->getdataCetakCat($code);
		// echo "<pre>";print_r($data);exit();
		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8',array(110,80), 0, '', 0, 0, 2, 2, 7, 4);
		$filename 	= 'monitoring-cat.pdf';
		
		$this->load->library('ciqrcode');
		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		
		foreach ($getdata as  $get) {
			$params['data']		= $get['CODE'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($get['CODE']).'.png';
			$this->ciqrcode->generate($params);
		}
		$data['data'] = $getdata;
		
		$html 	= $this->load->view('MonitoringCat/V_Pdf_Cat', $data, true);	
		ob_end_clean();
		$pdf->WriteHTML($html);	
			
		$pdf->Output($filename, 'I');
	}
    
}