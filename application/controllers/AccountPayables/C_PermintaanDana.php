<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_PermintaanDana extends CI_Controller {

   function __construct() 
   {
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
		$this->load->model('AccountPayables/M_Permintaandana');

			  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			//redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/PermintaanDana/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function saldo()
	{
		$date = $_POST['date'];
		// Get All
		$data['All'] = $this->M_Permintaandana->getData($date);

		// Get Saldo Suntikan Total
		$data['Saldo'] = $this->M_Permintaandana->getSaldo($date);
		$data['SaldoSetorTotal'] = $this->M_Permintaandana->getSaldoSetorTotal($date);
		$data['Aug'] = $this->M_Permintaandana->getAug($date);
		$data['ReceiptInAll'] = $this->M_Permintaandana->getReceiptInAll($date);
		$data['SetorAll'] = $this->M_Permintaandana->getSetorAll($date);
		$data['SaldoNetAll'] = $this->M_Permintaandana->getSaldoNetAll($date);
		$data['SaldoSuntikanTotal'] = $this->M_Permintaandana->getSaldoSuntikanTotal($data['Saldo'][0]['V_SALDO'], $data['SaldoSetorTotal'][0]['V_SALDO_SETOR_TOTAL'], $data['Aug'][0]['AMOUNT'], $data['ReceiptInAll'][0]['V_RECEIPT_IN_ALL'], $data['SetorAll'][0]['AMOUNT'], $data['SaldoNetAll'][0]['V_SALDO_NET_ALL'], $date);

		// Get Debet Total
		$data['DebetTotal'][0]['AMOUNT'] = 0;
		foreach ($data['All'] as $value) {
			$data['DebetTotal'][0]['AMOUNT'] += $value['DEBET'];
		}

		// Get Saldo Setor
		$data['Setor'] = $this->M_Permintaandana->getSetor($date);
		$data['SaldoSetor'] = $this->M_Permintaandana->getSaldoSetor($date, $data['Setor'][0]['AMOUNT']);

		// Get Saldo Suntikan
		$data['SAug'] = $this->M_Permintaandana->getSAug($date);
		$data['ReceiptIn'] = $this->M_Permintaandana->getReceiptIn($date);
		$data['SaldoSuntikan'] = $this->M_Permintaandana->getSaldoSuntikan($date, $data['SAug'][0]['AMOUNT'], $data['ReceiptIn'][0]['V_RECEIPT_IN']);

		// Get Kredit Total
		$data['KreditTotal'][0]['AMOUNT'] = 0;
		foreach ($data['All'] as $value) {
			$data['KreditTotal'][0]['AMOUNT'] += $value['KREDIT'];
		}

		// Get Saldo Net
		$data['Saldonet'] = $this->M_Permintaandana->getSaldoNet($date);

		// Get Saldo Akhir
		$data['SaldoAkhir'] = round($data['SaldoSuntikanTotal'][0]['V_SALDO_SUNTIKAN_TOTAL'] + $data['DebetTotal'][0]['AMOUNT'] - $data['SaldoSetor'][0]['V_SALDO_SETOR1'] + $data['SaldoSuntikan'][0]['V_SALDO_SUNTIKAN'] - $data['KreditTotal'][0]['AMOUNT'] + $data['Saldonet'][0]['V_SALDO_NET']);

		echo json_encode($data['SaldoAkhir']);
	}

	public function checkSession()
	{
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function create()
	{
		$this->checkSession();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A5', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$filename = 'KHS Permintaan Dana Kasir.pdf';

		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->form_validation->set_rules('txtCashLimit', 'plafon', 'required');
		$this->form_validation->set_rules('txtCashBalance', 'saldokas', 'required');
		$this->form_validation->set_rules('txtLackAmount', 'kekurangandana', 'required');
		$this->form_validation->set_rules('txtNeedByDate', 'tanggaldibutuhkan', 'required');
		$this->form_validation->set_rules('txtExpenseTotal', 'total', 'required');
		$this->form_validation->set_rules('txtTotalDemand', 'jumlahdana', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('AccountPayables/PermintaanDana/V_Index',$data);
			$this->load->view('V_Footer',$data);
		} else {
			$data_demand_h = array(
				'SEGMENT1' 		=> date('Ymd'),
				'NEED_BY_DATE'	=> date("d-M-Y H:i:s", strtotime($this->input->post('txtNeedByDate', true))),
				'CASH_AMOUNT'	=> $this->input->post('txtCashBalance', true),
				'CASH_LIMIT'	=> $this->input->post('txtCashLimit', true),
				'CREATION_DATE'	=> date("d-M-Y H:i:s", strtotime($this->input->post('hdnDate'))),
				'CREATED_BY'	=> $this->input->post('hdnUser')
			);
			$this->M_Permintaandana->setDemand($data_demand_h);
			
		    $insert_id = $this->M_Permintaandana->getLastInserted('KHS_DEMAND_FOR_FUND_HEADERS', 'HEADER_ID');

			$desc = $this->input->post('txtExpenseDescription');
			$amount = $this->input->post('txtExpenseAmount');

			foreach($amount as $i => $loop) {
				$data_demand_l[$i] = array(
					'HEADER_ID' 	=> $insert_id,
					'DESCRIPTION' 	=> $desc[$i],
					'AMOUNT' 		=> $amount[$i],
					'CREATION_DATE' => date("d-M-Y H:i:s", strtotime($this->input->post('hdnDate'))),
					'CREATED_BY' 	=> $this->input->post('hdnUser')
				);
				$this->M_Permintaandana->setDemandLines($data_demand_l[$i]);
			}

			$data['DemandHeader'] = $data_demand_h;
			$data['DemandLine'] = $data_demand_l;
			$data['BalanceDate'] = date("d M Y", strtotime($this->input->post('hdnBalanceDate', true)));
			$data['type'] = $this->input->post('txtLackAmountHidden', true);
			$data['LackAmount'] = $this->input->post('txtLackAmount', true);
			$data['TotalDemand'] = $this->input->post('txtTotalDemand', true);

			$stylesheet = file_get_contents(base_url('assets/css/custom.css'));
			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
			$html = $this->load->view('AccountPayables/PermintaanDana/V_Report', $data, true);

			$pdf->WriteHTML($stylesheet, 1);
			$pdf->WriteHTML($stylesheet1, 1);
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'D');

			redirect('AccountPayables/Dana');
		}
	}
}