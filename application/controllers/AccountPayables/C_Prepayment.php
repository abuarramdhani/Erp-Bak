<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Prepayment extends CI_Controller {

   function __construct() {
        parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->helper('html');
		$this->load->helper('download');
	    $this->load->library('form_validation');
	    //load the login model
		$this->load->library('session');
		$this->load->library('csvimport');
		//$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AccountPayables/M_prepayment');

			  
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

	public function index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';			
		$data['UserResponsibility'] = $this->M_user->getUserResponsibility($user_id);
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/Prepayment/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}	

	public function viewPrepayment()
	{
		$this->checkSession();
		$user_id = $this->session->userid;		
		$data['UserResponsibility'] = $this->M_user->getUserResponsibility($user_id);
		$ssn = $this->session->userdata;

		$org_id = $ssn['org_id'];
		$sitesuppRaw = strtoupper($this->input->post('SiteSupp'));
		$tanggal = $this->input->post('tanggal');

		// $result = 'tanggal : '.$tanggal.'<br>sitesuppRaw : '.$sitesuppRaw.'<br>org_id : '.$org_id;
		$prepayment = $this->M_prepayment->getLaporan($org_id, $sitesuppRaw, $tanggal);
		echo "
			<table id='showPrpData' class='table table-striped table-bordered table-hover'style='width: 200%'>
				<thead>
					<tr class='bg-primary'>
						<th rowspan='2' style='text-align: center; vertical-align: middle;'>Supplier</th>
						<th rowspan='2' style='text-align: center; vertical-align: middle;'>No. Induk</th>
						<th rowspan='2' style='text-align: center; vertical-align: middle;'>Nama</th>
						<th colspan='9' style='text-align: center;'>Invoice Prepayement</th>
						<th rowspan='2' style='text-align: center; vertical-align: middle;'>Description</th>
					</tr>
					<tr class='bg-primary'>
						<th style='text-align: center;'>Inv. Date</th>
						<th style='text-align: center;'>Pay Date</th>
						<th style='text-align: center;'>No. Voucher</th>
						<th style='text-align: center;'>No. PO</th>
						<th style='text-align: center;'>No. Invoice</th>
						<th style='text-align: center;'>Curr.</th>
						<th style='text-align: center;'>Amount</th>
						<th style='text-align: center;'>Rate</th>
						<th style='text-align: center;'>Amount[IDR]</th>
					</tr>
				</thead>
				<tbody>"; 
				foreach ($prepayment as $prp) { 
					echo"
					<tr>
						<td>"; echo $prp['VENDOR_NAME']; echo"</td>
						<td>"; echo $prp['VENDOR_SITE_CODE']; echo"</td>
						<td>"; echo $prp['NAMA']; echo"</td>
						<td>"; echo $prp['INV_PREPAYMENT_DATE']; echo"</td>
						<td>"; echo $prp['PAYMENT_DATE']; echo"</td>
						<td>"; echo $prp['NO_VOUCHER']; echo"</td>
						<td>"; echo $prp['PO_NUMBER']; echo"</td>
						<td>"; echo $prp['NO_INV_PREPAYMENT']; echo"</td>
						<td>"; echo $prp['PAYMENT_CURRENCY_CODE']; echo"</td>
						<td class='amt'>"; echo $prp['AMOUNT']; echo"</td>
						<td>"; echo $prp['RATE_PREPAYMENT']; echo"</td>
						<td class='amtIDR'>"; echo $prp['AMOUNT_IDR']; echo"</td>
						<td>"; echo $prp['DESCRIPTION']; echo"</td>
					</tr>";
					};"
				</tbody>
			</table>
		";
	}

	public function testChamber()
	{
		echo "<h2>For Testing Purpose Only</h2>";
		// $sitesuppRaw = strtoupper($this->input->post('SiteSupp'));
		// $tanggal = $this->input->post('tanggal');
		// $data['Prepayment'] = $this->M_prepayment->getLaporan($org_id, $sitesuppRaw, $tanggal);
		// $ssn = $this->session->userdata;
		echo "<pre>";
		// echo $org_id;
		// print_r($ssn['org_id']);
		// echo $sitesuppRaw;
		// echo $tanggal;
		echo "</pre>";
	}

}