<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_StokCat extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
		$this->load->helper('url');
        $this->load->helper('html');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('QuickDataCat/MainMenu/M_lihatstockcat');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
public function Index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'QuickDataCat/DataCatKeluar/insert_act';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['data_cat_masuk_keluar'] = $this->M_lihatstockcat->getDataCatKeluarMasuk();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('QuickDataCat/MainMenu/V_LihatStockCat', $data);
		$this->load->view('V_Footer',$data);
		
	}

public function stockonhand2(){
		if($this->session->userdata('is_logged_in')){
		$data['username'] = $this->session->userdata('username');
		$data['data_onhand'] = $this->M_lihatstockcat->getDataCatOnHand();
		$this->load->view('template/header');
		$this->load->view('template/sidemenu', $data);
		$this->load->view('V_LihatStockOnHand',$data);
		$this->load->view('template/footer');
		}else{
			redirect('');
		}
}

public function stockonhand(){
		if($this->session->userdata('is_logged_in')){
		$data['username'] = $this->session->userdata('username');
		$data['data_onhand'] = $this->M_lihatstockcat->getDataCatOnHand2();
		$this->load->view('template/header');
		$this->load->view('template/sidemenu', $data);
		$this->load->view('V_LihatStockOnHand',$data);
		$this->load->view('template/footer'); 
		}else{
			redirect('');
		}

}
	
public function exportpdfDataStock(){
		$this->load->library('pdf');
		$data['data_cat_masuk_keluar'] = $this->M_lihatstockcat->getDataCatKeluarMasuk();
		$filename= 'datastockcat'.time().'.pdf';
		$data['page_title'] = 'datastockcat';
		ini_set('memory_limit','300M');
		$html = $this->load->view('QuickDataCat/Report/V_PDFExportDataStock', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');
	}

public function exportexcelDataStock(){
		$data['data_cat_masuk_keluar'] = $this->M_lihatstockcat->getDataCatKeluarMasuk();
		$this->load->view('QuickDataCat/Report/V_EXCELExportDataStock',$data);

}

public function exportpdfDataStockPeriode(){
		$this->load->library('pdf');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$paint_code = $this->input->post('paint_code');
		$paint_desc = $this->input->post('paint_desc');
		if ($paint_code==null && $paint_desc==null) {
			$data['getDataCat'] = $this->M_lihatstockcat->getDataCat($start_date,$end_date);
		}
		else {
			$data['getDataCat'] = $this->M_lihatstockcat->getDataCat2($start_date,$end_date,$paint_code,$paint_desc);
		}
		$filename= 'datacatperiode.pdf';
		$data['page_title'] = 'Data Stock Periode';
		ini_set('memory_limit','300M');
		$html = $this->load->view('QuickDataCat/Report/V_PDFExportDataStockPeriode', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');
	}

function excelOnHand()
	{
		$data['data_onhand'] = $this->M_lihatstockcat->getDataCatOnHand();
		$this->load->view('QuickDataCat/Report/V_exportexcel',$data);
	}

public function ajaxSearching()
	{
		$start_date =$this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$paint_code =strtoupper($this->input->post('paint_code'));
		$paint_desc =strtoupper($this->input->post('paint_desc'));
		$data['getDataCat'] = $this->M_lihatstockcat->findDataCat($start_date,$end_date,$paint_code,$paint_desc);
		/*
		if ($paint_code==null && $paint_desc==null) {
			$data['getDataCat'] = $this->M_lihatstockcat->getDataCat($start_date,$end_date);
		}
		elseif ($start_date==null && $end_date==null) {
			$data['getDataCat'] = $this->M_lihatstockcat->getDataCat3($paint_code,$paint_desc);
		}
		else {
			$data['getDataCat'] = $this->M_lihatstockcat->getDataCat2($start_date,$end_date,$paint_code,$paint_desc);
		} */
		$this->load->view('V_LihatStockCat2',$data);
	}
	
public function ajaxDelStokCat(){
	$paint_in	= $this->M_lihatstockcat->getPaintIn();
	$paint_out	= $this->M_lihatstockcat->getPaintOut();
	if(empty($paint_in) && empty($paint_out)){
		$rates = "empty";
		$this->output->set_output(json_encode($rates));
	}else{
		foreach($paint_in as $rw){
			$ins_in	= $this->M_lihatstockcat->ins_del_in(
				$rw['paint_code'],$rw['paint_description'],
				$rw['expired_date'],$rw['quantity'],
				$rw['evidence_number'],$rw['employee'],
				date("Y-m-d H:i:s",strtotime($rw['sysdate'])),$rw['on_hand']
			);
		}
		foreach($paint_out as $rw){
			$ins_out	= $this->M_lihatstockcat->ins_del_out(
				$rw['paint_code'],$rw['paint_description'],
				$rw['expired_date'],$rw['quantity'],
				$rw['evidence_number'],$rw['employee'],
				date("Y-m-d H:i:s",strtotime($rw['sysdate']))
			);
		}
		$this->M_lihatstockcat->del_im_out();
		$this->M_lihatstockcat->del_im_in();
		$this->M_lihatstockcat->del_on_hand();
		$rates = "success";
		$this->output->set_output(json_encode($rates));
	}
}
	
}