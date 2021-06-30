<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
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

		$data['Title'] = 'Input Cat';
		$data['Menu'] = 'Input Cat';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCat/V_Input', $data);
		$this->load->view('V_Footer',$data);
	}

	public function searchLppb(){
		$lppb = $this->input->post('no_lppb');
		$data['data'] = $this->M_moncat->getdataLPPB($lppb);
		// echo "<pre>";print_r($data);exit();
		$this->load->view('MonitoringCat/ajax/V_Input_Table', $data);
	}

	public function cetak_cat(){
		$no_lppb 	= $this->input->post('receipt_num[]');
		$inv 		= $this->input->post('inv[]');
		$item 		= $this->input->post('kode_item[]');
		$qty 		= $this->input->post('qty[]');
		$uom 		= $this->input->post('uom[]');
		$trans_date = $this->input->post('transaction_date[]');
		$pail 		= $this->input->post('pail[]');
		
		$cek_lppb = $this->M_moncat->getdataCetakCat2($no_lppb[0]);
		if (empty($cek_lppb)) {
			// echo "<pre>";
			// $cek_kode = $this->M_moncat->getdataCat(date('d/m/Y')); 
			// if (empty($cek_kode)) {
			// 	$urut = 1;
			// }else {
			// 	$urut = explode("-",$cek_kode[0]['CODE']);
			// 	$urut = $urut[2] + 1;
			// }
			for ($i=0; $i < count($no_lppb) ; $i++) { 
				$trans = DateTime::createFromFormat('d/m/Y H:i:s', $trans_date[$i])->format('d/m/Y');
				$cek_kode = $this->M_moncat->getdataCat($trans, $item[$i]); 
				if (empty($cek_kode)) {
					$urut = 1;
				}else {
					$urut = explode("-",$cek_kode[0]['CODE']);
					$urut = $urut[2] + 1;
				}
				for ($p=0; $p < $pail[$i] ; $p++) { 
					$kd = substr($item[$i],4);
					$td = DateTime::createFromFormat('d/m/Y H:i:s', $trans_date[$i])->format('ymd');
					$code = $kd.'-'.$td.'-'.sprintf("%03d", $urut);
					$urut = $urut + 1;
					// echo "<br>";
					// print_r($code);
					$this->M_moncat->input_cat($no_lppb[$i], $inv[$i], $qty[$i], $trans_date[$i], $code, $this->session->user);
				}
			}
			// exit();
		}
		
		$getdata = $this->M_moncat->getdataCetakCat2($no_lppb[0]);
		// echo "<pre>";print_r($getdata);exit();
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

		// redirect(base_url('MonitoringCat/InputCat'));
	}
	
    
}