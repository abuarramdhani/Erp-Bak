<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Transaction extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('Warehouse/MainMenu/M_transaction');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function Spb()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Transaction Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransactionSPB/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function PackingList()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Transaction Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransactionPackingList/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function PackingListReset($id)
	{
		$this->M_transaction->deletePackingList($id);
		redirect(base_url('Warehouse/Transaction/PackingList'));
	}

	public function cetakPackingListPDF($spbNumber)
	{

		// ------ GENERATE QRCODE ------
			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
				if(!is_dir('./assets/upload/ManufacturingOperation'))
				{
					mkdir('./assets/upload/ManufacturingOperation', 0777, true);
					chmod('./assets/upload/ManufacturingOperation', 0777);
				}
				if(!is_dir('./assets/upload/ManufacturingOperation/temp'))
				{
					mkdir('./assets/upload/ManufacturingOperation/temp', 0777, true);
					chmod('./assets/upload/ManufacturingOperation/temp', 0777);
				}
				if(!is_dir('./assets/upload/ManufacturingOperation/temp/qrcode'))
				{
					mkdir('./assets/upload/ManufacturingOperation/temp/qrcode', 0777, true);
					chmod('./assets/upload/ManufacturingOperation/temp/qrcode', 0777);
				}
			$params['data']		= $data['replacement_number'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './assets/upload/ManufacturingOperation/temp/qrcode/'.$data['replacement_number'].'.png';
			$this->ciqrcode->generate($params);
		// ------ GENERATE PDF ------
			$this->load->library('Pdf');
			$pdf 		= $this->pdf->load();
			$mpdf 		= new mPDF('utf-8','A5-L', 0, '', 5, 5, 5, 5);
			$filename 	= 'PACKINGLIST_'.date('d-M-Y').'.pdf';
			$html 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/V_Report', $data, true);
			$pdf->WriteHTML($html, 0);
			$pdf->Output($filename, 'I');
		if(is_file($params['savename'])){
			unlink($params['savename']);
		}
	}
}
