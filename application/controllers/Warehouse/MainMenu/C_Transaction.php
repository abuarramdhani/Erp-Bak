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
		// ------ GET DATA ------
			$data['spbNumber']		= $spbNumber;
			$data['destination']	= $this->M_transaction->getPackinglistDestination($spbNumber);
			$total					= $this->M_transaction->getPackinglistTotalPack($spbNumber);
			$packCode 				= $this->M_transaction->getPackingCode($spbNumber);
			$temp = array();
			foreach ($packCode as $value) {
				$list = $this->M_transaction->getPackingList($spbNumber,  $value['PACKING_CODE']);
				if(strlen($value['PACKING_CODE'])>6){
					$desc = ' ';
				}else{
					if(substr($value['PACKING_CODE'],0,2)=='KK'){
						$desc = 'KARDUS KECIL';
					}elseif (substr($value['PACKING_CODE'],0,2)=='KS') {
						$desc = 'KARDUS SEDANG';
					}elseif (substr($value['PACKING_CODE'],0,2)=='KP') {
						$desc = 'KARDUS PANJANG';
					}elseif (substr($value['PACKING_CODE'],0,2)=='PP') {
						$desc = 'KARUNG';
					}elseif (substr($value['PACKING_CODE'],0,2)=='PT') {
						$desc = 'PETI';
					}elseif (substr($value['PACKING_CODE'],0,2)=='LL') {
						$desc = 'LAIN-LAIN';
					}
				}
				$a = array(
					'PACKING_CODE'	=> $value['PACKING_CODE'],
					'TOTAL'			=> $total[0]['TOTAL'],
					'DESC'			=> $desc,
					'LIST'			=> $list
				);
				array_push($temp, $a);
			}
			$data['list']		= $temp;
		// ------ GENERATE QRCODE ------
			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
				if(!is_dir('./assets/upload/Warehouse'))
				{
					mkdir('./assets/upload/Warehouse', 0777, true);
					chmod('./assets/upload/Warehouse', 0777);
				}
				if(!is_dir('./assets/upload/Warehouse/temp'))
				{
					mkdir('./assets/upload/Warehouse/temp', 0777, true);
					chmod('./assets/upload/Warehouse/temp', 0777);
				}
				if(!is_dir('./assets/upload/Warehouse/temp/qrcode'))
				{
					mkdir('./assets/upload/Warehouse/temp/qrcode', 0777, true);
					chmod('./assets/upload/Warehouse/temp/qrcode', 0777);
				}
			$params['data']		= $spbNumber;
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './assets/upload/Warehouse/temp/qrcode/'.$spbNumber.'.png';
			$this->ciqrcode->generate($params);
		// ------ GENERATE PDF ------
			$this->load->library('Pdf');
			$pdf 		= $this->pdf->load();
			$pdf 		= new mPDF('utf-8','A5-L', 0, '', 5, 5, 45, 40, 5, 3);
			$filename 	= 'PACKINGLIST_'.date('d-M-Y').'.pdf';
			$header 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/Report/V_Header', $data, true);
			$content 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/Report/V_Content', $data, true);
			$footer 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/Report/V_Footer', $data, true);
			$pdf->SetHTMLHeader($header);
			$pdf->SetHTMLFooter($footer);
			$pdf->WriteHTML($content, 0);
			$pdf->debug = true;
			$pdf->Output($filename, 'I');
		if(is_file($params['savename'])){
			unlink($params['savename']);
		}
	}
}
