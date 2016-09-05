<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Receipt extends CI_Controller {

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
		$this->load->model('CateringManagement/M_receipt');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Receipt'] = $this->M_receipt->GetReceipt();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function create()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Catering'] = $this->M_receipt->GetCatering();
		$data['Type'] = $this->M_receipt->GetOrderType();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Create',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function details($id)
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Receipt'] = $this->M_receipt->GetReceiptDetails($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Details',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function edit($id)
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Receipt'] = $this->M_receipt->GetReceiptForEdit($id);
		$data['Catering'] = $this->M_receipt->GetCatering();
		$data['Type'] = $this->M_receipt->GetOrderType();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Edit',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function printreceipt($id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(215,80), 0, '', 0, 0, 0, 0);

		$filename = 'Catering-Receipt-'.$id;
		$this->checkSession();

		$data['Receipt'] = $this->M_receipt->GetReceiptDetails($id);

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('CateringManagement/Receipt/V_Print', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}
	
	public function add()
	{
		$no 		= $this->input->post('TxtNo');
		$date 		= $this->input->post('TxtReceiptDate');
		$place 		= $this->input->post('TxtPlace');
		$from 		= $this->input->post('TxtFrom');
		$signer		= $this->input->post('TxtSigner');
		$ordertype	= $this->input->post('TxtOrderType');
		$catering	= $this->input->post('TxtCatering');
		
		$Doubledate = $this->input->post('TxtOrderDate');
		$ex_Doubledate = explode(' ', $Doubledate);
		$startdate 	= $ex_Doubledate[0];
		$enddate 	= $ex_Doubledate[2];
		
		$orderqty 	= $this->input->post('TxtOrderQty');
		$orderprice	= $this->input->post('TxtSinglePrice');
		$fine 		= $this->input->post('TxtFine');
		$pph 		= $this->input->post('TxtPPH');
		$payment	= $this->input->post('TxtPayment');
		
		$this->M_receipt->AddReceipt($no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment);
		redirect('CateringManagement/Receipt');
		
	}
	
		public function update()
	{
		$id			= $this->input->post('TxtId');
		$no 		= $this->input->post('TxtNo');
		$date 		= $this->input->post('TxtReceiptDate');
		$place 		= $this->input->post('TxtPlace');
		$from 		= $this->input->post('TxtFrom');
		$signer		= $this->input->post('TxtSigner');
		$ordertype	= $this->input->post('TxtOrderType');
		$catering	= $this->input->post('TxtCatering');
		
		$Doubledate = $this->input->post('TxtOrderDate');
		$ex_Doubledate = explode(' ', $Doubledate);
		$startdate 	= $ex_Doubledate[0];
		$enddate 	= $ex_Doubledate[2];
		
		$orderqty 	= $this->input->post('TxtOrderQty');
		$orderprice	= $this->input->post('TxtSinglePrice');
		$fine 		= $this->input->post('TxtFine');
		$pph 		= $this->input->post('TxtPPH');
		$payment	= $this->input->post('TxtPayment');
		
		$this->M_receipt->UpdateReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment);
		redirect('CateringManagement/Receipt');
		
	}
	
	public function delete($id)
	{
		$this->M_receipt->DeleteReceipt($id);
		redirect('CateringManagement/Receipt');
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
