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
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	public function index()
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
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

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Catering'] = $this->M_receipt->GetCatering();
		$data['Type'] = $this->M_receipt->GetOrderType();
		$data['FineType'] = $this->M_receipt->GetFineType();
		$data['LatestId'] = $this->M_receipt->GetLatestId();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Create',$data);
		$this->load->view('V_Footer',$data);

	}

	public function details($id)
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Receipt'] = $this->M_receipt->GetReceiptDetails($id);
		$data['ReceiptFine'] = $this->M_receipt->GetReceiptFineForEdit($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Details',$data);
		$this->load->view('V_Footer',$data);

	}

	public function edit($id)
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Receipt'] = $this->M_receipt->GetReceiptForEdit($id);
		$data['ReceiptFine'] = $this->M_receipt->GetReceiptFineForEdit($id);
		$data['Catering'] = $this->M_receipt->GetCatering();
		$data['FineType'] = $this->M_receipt->GetFineType();
		$data['Type'] = $this->M_receipt->GetOrderType();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Receipt/V_Edit',$data);
		$this->load->view('V_Footer',$data);

	}

	public function printreceipt($id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(215,120), 0, '', 0, 0, 0, 0);

		$filename = 'Catering-Receipt-'.$id.'.pdf';
		$this->checkSession();

		$data['Receipt'] = $this->M_receipt->GetReceiptDetails($id);
		$data['ReceiptFine'] = $this->M_receipt->GetReceiptFineForEdit($id);

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('CateringManagement/Receipt/V_Print', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}

	public function add()
	{
		$id 		= $this->input->post('TxtID');
		$no 		= $this->input->post('TxtNo');

		// $date 		= date("Y-m-d",strtotime($this->input->post('TxtReceiptDate')));

		//$date 		= $this->input->post('TxtReceiptDate');
		// $date=str_replace('/', '-', $date);
		// $date=date_create($date);
		// $date=date_format($date,"Y-m-d");

		$date 	= 	date('Y-m-d', strtotime($this->input->post('TxtReceiptDate')));

		$place 		= $this->input->post('TxtPlace');
		$from 		= $this->input->post('TxtFrom');
		$signer		= $this->input->post('TxtSigner');
		$ordertype	= $this->input->post('TxtOrderType');
		$catering	= $this->input->post('TxtCatering');
		$menu		= $this->input->post('TxtMenu');

		$Doubledate = $this->input->post('TxtOrderDate');
		$ex_Doubledate = explode(' ', $Doubledate);
		$startdate 	= date('Y-m-d',strtotime($ex_Doubledate[0]));
		$enddate 	= date('Y-m-d',strtotime($ex_Doubledate[2]));

		$bonus 		= $this->input->post('TxtBonus');
		$orderqty 	= $this->input->post('TxtOrderQty');
		$orderprice	= $this->input->post('TxtSinglePrice');
		$fine 		= $this->input->post('TxtFine');
		$pph 		= $this->input->post('TxtPPH');
		$payment	= $this->input->post('TxtTotal');

		$this->M_receipt->AddReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment,$menu,$bonus);

		$finedate = $this->input->post('TxtFineDate');
		// $finedate=str_replace('/', '-', $finedate);
		// $finedate=date_create($finedate);
		// $finedate=date_format($finedate,"Y-m-d");

		// $finedate = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('TxtFineDate'))));

		$fineqty = $this->input->post('TxtFineQty');
		$fineprice = $this->input->post('TxtFinePrice');
		$finetype = $this->input->post('TxtFineType');
		$finedesc = $this->input->post('TxtFineDesc');
		$finenominal = $this->input->post('TxtFineNominal');

			$i=0;
			foreach($finedate as $loop){
				// $finedate[$i]=str_replace('/', '-', $finedate[$i]);
				// $finedate[$i]=date_create($finedate[$i]);
				// $finedate[$i]=date_format($finedate[$i],"Y-m-d");
				$finedate[$i] 	= 	date('Y-m-d', strtotime($finedate[$i]));
				$data_fine[$i] = array(
					'receipt_id' 			=> $this->input->post('TxtID'),
					'receipt_fine_date' 	=> $finedate[$i],
					'receipt_fine_qty'		=> $fineqty[$i],
					'receipt_fine_price'	=> $fineprice[$i],
					'fine_type_percentage'	=> $finetype[$i],
					'fine_description'		=> $finedesc[$i],
					'fine_nominal'			=> $finenominal[$i]
				);
				if( !empty($finedate[$i]) && !empty($fineqty[$i]) && !empty($fineprice[$i]) && !empty($finetype[$i]) ){
					$this->M_receipt->AddReceiptFine($data_fine[$i]);
				}
				$i++;
			}
		redirect('CateringManagement/Receipt');
	}

	public function update()
	{
		$id			= $this->input->post('TxtID');
		$no 		= $this->input->post('TxtNo');
		//$date 		= $this->input->post('TxtReceiptDate');
		// $date=str_replace('/', '-', $date);
		// $date=date_create($date);
		// $date=date_format($date,"Y-m-d");

		$date 	= 	date('Y-m-d', strtotime($this->input->post('TxtReceiptDate', TRUE)));

		$place 		= $this->input->post('TxtPlace');
		$from 		= $this->input->post('TxtFrom');
		$signer		= $this->input->post('TxtSigner');
		$ordertype	= $this->input->post('TxtOrderType');
		$catering	= $this->input->post('TxtCatering');
		$menu		= $this->input->post('TxtMenu');

		$Doubledate = $this->input->post('TxtOrderDate');
		$ex_Doubledate = explode(' ', $Doubledate);
		$startdate 	= date('Y-m-d',strtotime($ex_Doubledate[0]));
		$enddate 	= date('Y-m-d', strtotime($ex_Doubledate[2]));

		$bonus 		= $this->input->post('TxtBonus');
		$orderqty 	= $this->input->post('TxtOrderQty');
		$orderprice	= $this->input->post('TxtSinglePrice');
		$fine 		= $this->input->post('TxtFine');
		$pph 		= $this->input->post('TxtPPH');
		$payment	= $this->input->post('TxtTotal');

		$this->M_receipt->UpdateReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment,$menu,$bonus);

		$this->M_receipt->DeleteReceiptFine($id);

		$finedate = $this->input->post('TxtFineDate');
		// $finedate=str_replace('/', '-', $finedate);
		// $finedate=date_create($finedate);
		// $finedate=date_format($finedate,"Y-m-d");

		$fineqty = $this->input->post('TxtFineQty');
		$fineprice = $this->input->post('TxtFinePrice');
		$finetype = $this->input->post('TxtFineType');
		$finedesc = $this->input->post('TxtFineDesc');
		$finenominal = $this->input->post('TxtFineNominal');

			$i=0;
			foreach($finedate as $loop){


				// $finedate[$i]=str_replace('/', '-', $finedate[$i]);
				// $finedate[$i]=date_create($finedate[$i]);
				// $finedate[$i]=date_format($finedate[$i],"Y-m-d");
				$finedate[$i] 	= 	date('Y-m-d', strtotime($finedate[$i]));
				$data_fine[$i] = array(
					'receipt_id' 		=> $this->input->post('TxtID'),
					'receipt_fine_date' 	=> $finedate[$i],
					'receipt_fine_qty'	=> $fineqty[$i],
					'receipt_fine_price'	=> $fineprice[$i],
					'fine_type_percentage'	=> $finetype[$i],
					'fine_description'	=> $finedesc[$i],
					'fine_nominal'		=> $finenominal[$i]
				);
				if( !empty($finedate[$i]) && !empty($fineqty[$i]) && !empty($fineprice[$i]) && !empty($finetype[$i]) ){
					$this->M_receipt->AddReceiptFine($data_fine[$i]);
				}
				$i++;
			}

		redirect('CateringManagement/Receipt/Details/'.$id);
	}

	public function delete($id)
	{
		$this->M_receipt->DeleteReceipt($id);
		redirect('CateringManagement/Receipt');

	}

	public function checkpph(){
		$id 	= $this->input->post('id');

		$cater_data = $this->M_receipt->GetPphStatus($id);
			foreach($cater_data as $cater){
				echo $cater['catering_pph'];
			}
	}

	public function checkfine(){
		$id 	= $this->input->post('id');

		$fine_data = $this->M_receipt->GetFineValue($id);
			foreach($fine_data as $fine){
				echo $fine['percentage'];
			}
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
}
