<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_History extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		

		
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ReceivePO/M_receive');

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

		$data['Title'] = 'History Penerimaan';
		$data['Menu'] = 'History';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ReceivePO/V_History');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

	 public function Hist()
	{

		$datefrom	= $this->input->post('datefrom');
		$dateto	= $this->input->post('dateto');
		$result =  $this->M_receive->historyPO($datefrom,$dateto);
		// echo"<pre>";print_r($result);exit();

		$data['result'] = $result;

		$this->load->view('ReceivePO/V_History_Result', $data);
	}

	public function Detail()
	{

		$po	= $this->input->post('buttonpo');
		$sj	= $this->input->post('suratjalan');
		$detail =  $this->M_receive->detailPO($po,$sj);

		// echo "<pre>";print_r($detail);exit();

		$i=0;
		foreach ($detail as $value) {
			$detail[$i]['SERIAL_NUMBER'] =  $this->M_receive->serial_number($value['PO_NUMBER'],$value['ID'],$value['SHIPMENT_NUMBER']);
			$detail[$i]['LPPB_NUMBERS'] =  $this->M_receive->lppb_number($value['PO_NUMBER'],$value['SHIPMENT_NUMBER']);

			

		$i++;
		}

		$data['detail'] = $detail;

		 // echo"<pre>";print_r($detail);exit();

		$this->load->view('ReceivePO/V_History_Detail', $data);
	}

	public function CetakKartu(){

		$serial	= $this->input->post('serial');
		$descrecipt	= $this->input->post('descrecipt');
		$itemrecipt	= $this->input->post('itemrecipt');
		$ket	= $this->input->post('ket');



		
		// echo "<pre>";
		// print_r($descrecipt);	
		// exit();	


		ob_start();

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(210,310), 0, '', 1, 1, 5, 1, 1, 1); 
		// $tglNama = date("d/m/Y");

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		
		foreach ($serial as  $value) {
			$params['data']		= $value;
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($value).'.png';
			$this->ciqrcode->generate($params);

		}
			

			$data['itemrecipt'] = $itemrecipt;
			$data['descrecipt'] = $descrecipt;
			$data['serial'] = $serial;
			$data['ket'] = $ket;


    	$pdf_dir = './assets/upload/KartuReceivePo/';
    	if (preg_match("/diesel/i", $descrecipt)) {
    		$filename = 'Kartu Identitas Diesel'.'.pdf';
    		$html = $this->load->view('ReceivePO/V_KartuDiesel', $data, true);		//-----> Fungsi Cetak PDF
    	}else if (preg_match("/engine/i", $descrecipt)) {
    		$filename = 'Kartu Identitas Engine'.'.pdf';
    		$html = $this->load->view('ReceivePO/V_KartuEngine', $data, true);		//-----> Fungsi Cetak PDF
    	}
    	ob_end_clean();
    	$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
    	// $pdf->Output($filename, 'I');
    	$pdf->Output($pdf_dir.$filename, 'F');

    	echo base_url().$pdf_dir.$filename;

	}


}