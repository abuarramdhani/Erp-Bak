<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Deliver extends CI_Controller
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
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Deliver';
		$data['Menu'] = 'History';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ReceivePO/V_Deliver');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

	 public function getPO()
	{

		$lppb	= $this->input->post('lppbno');

		$hasilnya =  $this->M_receive->getPO($lppb);

		// echo"<pre>";print_r($hasilnya);exit();

		$i = 0;
		foreach ($hasilnya as $has) {

			$datanya = $this->M_receive->detailPO($has['PO'], $has['SP']);

			$datalppb =  $this->M_receive->lppb_number($has['PO'], $has['SP']);



			foreach ($datalppb as $lpb) {
				$datanya[$i]['LPPB'] = $lpb['RECEIPT_NUM'];

			}

			$a = 0;
			foreach ($datanya as  $value) {

				$datanya[$a]['LOCATOR'] =  $this->M_receive->getLocator($value['ITEM']);	

				if ($value['SERIAL_STATUS'] == 'SERIAL') {

					$datanya[$a]['SERIAL_NUMBER'] =  $this->M_receive->serial_number($value['PO_NUMBER'],$value['ID'],$value['SHIPMENT_NUMBER']);	

					
				} else if($value['SERIAL_STATUS'] == 'NON SERIAL')  {
					
				}
				$a++;
			}

			$i++;
		}

		// echo"<pre>";print_r($datanya);exit();

		$data['datanya'] = $datanya;

		$this->load->view('ReceivePO/V_Deliver_Result', $data);
	}
	
	public function Insertketable()
	{
		$this->M_receive->deletefromtemporaryserial();
		$this->M_receive->deletefromtemporary();

		$itemdelive	= $this->input->post('itemdelive');
		$descdelive	= $this->input->post('descdelive');
		$qtydelive	= $this->input->post('qtydelive');
		$commentsdelive	= $this->input->post('commentsdelive');
		$podelive	= $this->input->post('podelive');
		$sujadelive	= $this->input->post('sujadelive');
		$serialstatus	= $this->input->post('serialstatus');
		$lppbnumber	= $this->input->post('lppbnumber');
		$iddelive	= $this->input->post('iddelive');
		$pilihloc	= $this->input->post('pilihloc');

		// echo "<pre>";print_r($itemdelive);exit();
		$array_insert = array();
		for ($i=0; $i < sizeof($itemdelive) ; $i++) { 
			$array_insert[$i]['itemdelive'] = $itemdelive[$i];
			$array_insert[$i]['descdelive'] = $descdelive[$i];
			$array_insert[$i]['qtydelive'] = $qtydelive[$i];
			$array_insert[$i]['commentsdelive'] = $commentsdelive[$i];
			$array_insert[$i]['podelive'] = $podelive[0];
			$array_insert[$i]['sujadelive'] = $sujadelive[$i];
			$array_insert[$i]['serialstatus'] = $serialstatus[$i];
			$array_insert[$i]['lppbnumber'] = $lppbnumber[0];
			$array_insert[$i]['iddelive'] = $iddelive[$i];
			$array_insert[$i]['pilihloc'] = $pilihloc[$i];
			if ($serialstatus[$i] == 'SERIAL') {
				$array_insert[$i]['nomor_serial'] = $this->M_receive->serial_number($podelive[0],$iddelive[$i],$sujadelive[$i]);		
			} else if ($serialstatus[$i] == 'NON SERIAL') {
				$array_insert[$i]['nomor_serial'] = '-';
			}

		}
		// echo "<pre>";print_r($array_insert);exit();

		foreach ($array_insert as  $array) {
			if ($array['serialstatus'] == 'SERIAL') {
				foreach ($array['nomor_serial'] as $serial) {
					$this->M_receive->insertserial(	$array['lppbnumber'],$array['iddelive'],$array['qtydelive'] ,$array['podelive'],$array['commentsdelive'],$serial['SERIAL_NUMBER'],$array['pilihloc']);
				}
			}else if ($array['serialstatus'] == 'NON SERIAL') {
				$this->M_receive->insertnonserial($array['lppbnumber'],$array['iddelive'],$array['qtydelive'] ,$array['podelive'],$array['commentsdelive'],$array['pilihloc']);
			}
		}

			$this->M_receive->runAPI($lppbnumber[0],$podelive[0]);





	}

}