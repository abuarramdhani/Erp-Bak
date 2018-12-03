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
        $this->load->model('WarehouseSPB/MainMenu/M_transaction');
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
		$this->load->view('WarehouseSPB/MainMenu/TransactionSPB/V_Index',$data);
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
		$this->load->view('WarehouseSPB/MainMenu/TransactionPackingList/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function PackingListReset($id)
	{
		$this->M_transaction->deletePackingList($id);
		redirect(base_url('WarehouseSPB/Transaction/PackingList'));
	}

	public function cetakPackingListPDF($spbNumber)
	{		
		
		// ------ GET DATA ------
			$data['spbNumber']		= $spbNumber;
			$data['destination']	= $this->M_transaction->getPackinglistDestination($spbNumber);
			$total					= $this->M_transaction->getPackinglistTotalPack($spbNumber);
			$packCode 				= $this->M_transaction->getPackingCode($spbNumber);
			$data['ekspedisi'] 		= $this->M_transaction->getPackingEkspedisi($spbNumber);
			$temp = array();

			

			// foreach ($packCode as $value) {
			// 	$list = $this->M_transaction->getPackingList($spbNumber,  $value['PACKING_CODE']);
			// 	$weight = $this->M_transaction->getPackingWeight($spbNumber, $value['PACKING_CODE']);

			// 	if(strlen($value['PACKING_CODE'])>6){
			// 		$desc = ' ';
			// 	}else{
			// 		if(substr($value['PACKING_CODE'],0,2)=='KK'){
			// 			$desc = 'KARDUS KECIL';
			// 		}elseif (substr($value['PACKING_CODE'],0,2)=='KS') {
			// 			$desc = 'KARDUS SEDANG';
			// 		}elseif (substr($value['PACKING_CODE'],0,2)=='KP') {
			// 			$desc = 'KARDUS PANJANG';
			// 		}elseif (substr($value['PACKING_CODE'],0,2)=='PP') {
			// 			$desc = 'KARUNG';
			// 		}elseif (substr($value['PACKING_CODE'],0,2)=='PT') {
			// 			$desc = 'PETI';
			// 		}elseif (substr($value['PACKING_CODE'],0,2)=='LL') {
			// 			$desc = 'LAIN-LAIN';
			// 		}
			// 	}
			// 	$a = array(
			// 		'PACKING_CODE'	=> $value['PACKING_CODE'],
			// 		'TOTAL'			=> $total[0]['TOTAL'],
			// 		'DESC'			=> $desc,
			// 		'LIST'			=> $list,
			// 		'WEIGHT'		=> $weight[0]['WEIGHT']
			// 	);
			// 	array_push($temp, $a);
			// }

				$list = $this->M_transaction->getPackingList($spbNumber,  $packCode[0]['PACKING_CODE']);

				$max_data = 10;
				$total_page = ceil(sizeof($list)/$max_data);
				$size = sizeof($list);

				$temp2 = array();
				$loop = 0;
				$x = 0;
				for ($i=0; $i < $total_page; $i++){ 

					if($size < $max_data){
						$loop = $size;
					}else{
						$loop = $max_data;
					}

					for ($j=0; $j < $loop; $j++) { 
						$temp2[$i][$j] = $list[$x];
						$x++;
					}

					$size -= $max_data;

				}

				$weight = $this->M_transaction->getPackingWeight($spbNumber, $packCode[0]['PACKING_CODE']);

				if(strlen($packCode[0]['PACKING_CODE'])>6){
					$desc = '';
				}else{
					if(substr($packCode[0]['PACKING_CODE'],0,2)=='KK'){
						$desc = 'KARDUS KECIL';
					}elseif (substr($packCode[0]['PACKING_CODE'],0,2)=='KS') {
						$desc = 'KARDUS SEDANG';
					}elseif (substr($packCode[0]['PACKING_CODE'],0,2)=='KP') {
						$desc = 'KARDUS PANJANG';
					}elseif (substr($packCode[0]['PACKING_CODE'],0,2)=='PP') {
						$desc = 'KARUNG';
					}elseif (substr($packCode[0]['PACKING_CODE'],0,2)=='PT') {
						$desc = 'PETI';
					}elseif (substr($packCode[0]['PACKING_CODE'],0,2)=='LL') {
						$desc = 'LAIN-LAIN';
					}
				}

				$a = array(
					'PACKING_CODE'	=> $packCode[0]['PACKING_CODE'],
					'TOTAL'			=> $total[0]['TOTAL'],
					'DESC'			=> $desc,
					'LIST'			=> $temp2,
					'WEIGHT'		=> $weight[0]['WEIGHT']
				);

			// 	echo "<pre>";
			// print_r($a);
			// exit();	

				// array_push($temp, $a);
			// }


			$data['list']		= $a;
			

		// ------ GENERATE QRCODE ------
			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
				if(!is_dir('./assets/upload/WarehouseSPB'))
				{
					mkdir('./assets/upload/WarehouseSPB', 0777, true);
					chmod('./assets/upload/WarehouseSPB', 0777);
				}
				if(!is_dir('./assets/upload/WarehouseSPB/temp'))
				{
					mkdir('./assets/upload/WarehouseSPB/temp', 0777, true);
					chmod('./assets/upload/WarehouseSPB/temp', 0777);
				}
				if(!is_dir('./assets/upload/WarehouseSPB/temp/qrcode'))
				{
					mkdir('./assets/upload/WarehouseSPB/temp/qrcode', 0777, true);
					chmod('./assets/upload/WarehouseSPB/temp/qrcode', 0777);
				}
			$params['data']		= $spbNumber;
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './assets/upload/WarehouseSPB/temp/qrcode/'.$spbNumber.'.png';
			$this->ciqrcode->generate($params);
		// ------ GENERATE PDF ------
			// $this->load->library('Pdf');
			// $pdf 		= $this->pdf->load();
			// $pdf 		= new mPDF('utf-8','A5-L', 0, '', 5, 5, 45, 40, 5, 3);
			// $filename 	= 'PACKINGLIST_'.date('d-M-Y').'.pdf';
			// $header 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/Report/V_Header', $data, true);
			// $content 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/Report/V_Content', $data, true);
			// $footer 		= $this->load->view('Warehouse/MainMenu/TransactionPackingList/Report/V_Footer', $data, true);
			// $pdf->SetHTMLHeader($header);
			// $pdf->SetHTMLFooter($footer);
			// $pdf->WriteHTML($content, 0);

				$this->load->library('Pdf');
			$pdf 		= $this->pdf->load();
			$pdf 		= new mPDF('utf-8','A4', 0, '', 5, 5, 5, 5, 5, 3);
			$filename 	= 'PACKINGLIST_'.date('d-M-Y').'.pdf';
			$header 		= $this->load->view('WarehouseSPB/MainMenu/TransactionPackingList/Report/V_Header', $data, true);
			$content 		= $this->load->view('WarehouseSPB/MainMenu/TransactionPackingList/Report/V_Content', $data, true);
			$footer 		= $this->load->view('WarehouseSPB/MainMenu/TransactionPackingList/Report/V_Footer', $data, true);
			
				// $pdf->WriteHTML($header, 0);
				$pdf->WriteHTML($content, 0);
				// $pdf->WriteHTML($footer, 0);	
				// $pdf->WriteHTML('<hr>', 0);	
				// $pdf->WriteHTML($header, 0);
				// $pdf->WriteHTML($content, 0);
				// $pdf->WriteHTML($footer, 0);	
			
			$pdf->debug = true;
			$pdf->Output($filename, 'I');
		if(is_file($params['savename'])){
			unlink($params['savename']);
		}
	}
}
