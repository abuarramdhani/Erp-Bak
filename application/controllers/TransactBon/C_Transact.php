<?php defined('BASEPATH') ;
class C_Transact extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		  
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('TransactBon/M_Transact'); 
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession()
		{
			if($this->session->is_logged){
				}else{
					redirect();
				}
		}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$val = $this->M_Transact->getNoind();
		$list = array_column($val, 'NOMOR_INDUK');
		$find = in_array($noind, $list);
		// echo $find;
		// echo "<pre>";
		// print_r($noind); 
		// echo "<pre>";
		// print_r($val);
		// echo "<pre>";
		// print_r($list);
		// echo "<pre>";
		// print_r($find);
		// exit();
		// $data['warehouse'] = $this->M_Transact->getWarehouse();
		// $data['SUBKONT'] = $this->M_Transact->getSubkont();
		if($find){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('TransactBon/Transaksi/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$this->load->view('TransactBon/V_Call',$data);
		}	
		// exit();
	}
	public function Transaksi()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$val = $this->M_Transact->getNoind();
		$list = array_column($val, 'NOMOR_INDUK');
		$find = in_array($noind, $list);

		// echo $find;
		// echo "<pre>";
		// print_r($list);exit();
		// $data['warehouse'] = $this->M_Transact->getWarehouse();
		// $data['SUBKONT'] = $this->M_Transact->getSubkont();
		// print_r('<pre>'); print_r($list); print_r($noind); exit();
		if($find) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('TransactBon/Transaksi/V_Transact',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$this->load->view('TransactBon/V_Call',$data);
		}	
	}

	public function Transaksi2()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$val = $this->M_Transact->getNoind();
		$list = array_column($val, 'NOMOR_INDUK');
		$find = in_array($noind, $list);
		// echo $find;
		// echo "<pre>";
		// print_r($list);exit();
		// $data['warehouse'] = $this->M_Transact->getWarehouse();
		// $data['SUBKONT'] = $this->M_Transact->getSubkont();
		if($find){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('TransactBon/Transaksi2/V_TransactBSTBP',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$this->load->view('TransactBon/V_Call',$data);
		}	
	}

	public function search()
	{
		$noind = $this->session->user;
		$tampilTB = $this->input->post('slcNoBon');
		$data['datatabel']=$this->M_Transact->search($tampilTB);
		$data['usr_id'] = $this->M_Transact->usrID($noind);
			// print_r($data['usr_id']);exit;
		echo $this->load->view('TransactBon/V_Table', $data, TRUE);
	}

	public function searchBSTBP()
	{
		// print_r($_POST);exit();
		$noind = $this->session->user;
		$org_id = $this->input->post('tsc_org');
		// $sub_inv = $this->input->post('tsc_tjnGudang');
		$tampilTB = $this->input->post('slcNoBon');
		
		$data['datatabel']=$this->M_Transact->searchBSTBP($tampilTB);
		// $tujuan_gudang = $this->M_Transact->searchBSTBP($tampilTB);
		
		// echo "<pre>";
		// print_r($data['datatabel']);
		// echo "</pre>";
		// exit();
		$data['usr_id'] = $this->M_Transact->usrID($noind);
		$i = 0;
		
		foreach ($data['datatabel'] as $sub_inv) {
			
			if(!empty($sub_inv['tujuan_gudang'])){
				$org_id = $this->M_Transact->orgID($sub_inv['tujuan_gudang']);
				foreach($org_id as $org){
					$org_id_array[] = $org['ORGANIZATION_ID'];
				}
				$data['datatabel'][$i]['org_id'] = $org_id_array[$i];
			}else{
				$data['datatabel'][$i]['org_id'] = "";
			}
			$i++;
		}

		echo $this->load->view('TransactBon/V_TableBSTBP', $data, TRUE);

	}

	public function insertData() {
		$serah =$this->input->post('penyerahan');
		$no_id =$this->input->post('no_id');
		// echo $serah;
		// exit();
		$this->M_Transact->updatePostgre($serah, $no_id); 
	}

	public function insertOracle(){
		// echo "<pre>";
		// print_r($_POST);
		// exit();
		$kode_barang =$this->input->post('tsc_kodeBarang');
		$account =$this->input->post('tsc_Account');
		$nama_barang =$this->input->post('tsc_NamaBarang');
		$serah =$this->input->post('penyerahan');
		$penyerahan = $this->input->post('tsc_Penyerahan'); 
		$no_urut = $this->input->post('tsc_noUrut');
		$tujuan_gudang =$this->input->post('tsc_tujuanGudang');
		$lokator =$this->input->post('tsc_Lokator');
		$ip =$this->input->post('tsc_IP');
		$produk =$this->input->post('tsc_Produk');
		$keterangan =$this->input->post('tsc_Keterangan');
		$satuan =$this->input->post('tsc_Satuan');
		$kode_cabang =$this->input->post('tsc_kodeCabang');
		$seksi_bon =$this->input->post('tsc_seksiBon');
		$no_bon =  $this->input->post('tsc_noBon');
		$no_id = $this->input->post('tsc_noID');
		// $flag = $this->input->post('flag');
		$usr_id= $this->input->post('tsc_usr');
		$cost_center = $this->input->post('tsc_costCenter');
		$sub_inv = $this->input->post('tsc_tjnGudang');
		$ip_address =  $this->input->ip_address();
		$a = $this->input->post('tsc_Permintaan');
		$b = $this->input->post('tsc_Give');
		// echo "<pre>";
		// print_r($ip_address);
		// exit();
	// echo count($account);
		for ($i = 0; $i < count($account); $i++){
			$this->M_Transact->insertData($account[$i],$kode_barang[$i],$serah[$i],$no_urut[$i],
			$tujuan_gudang[$i],$lokator[$i],$ip_address,$produk[$i],$keterangan[$i],$satuan[$i],
			$kode_cabang[$i]);
			// $this->M_Transact->updatePostgre($serah[$i], $no_id[$i]);
			if($a == $b){
				$flag = 'Y';
			}else{
				$flag = 'N';
			} //echo $flag;
			$this->M_Transact->updateFlag($no_bon[$i],$no_id[$i], $flag);
			
		}	
			// echo "user id ".$usr_id." nobon ".$no_bon[$i]." account ".$account[$i]." cost ".$cost_center." sub inv ".$sub_inv[$i]."<br>";	
		// exit();
			// $this->M_Transact->runAPI($usr_id,$no_bon,$account,$cost_center,$sub_inv);
			
			$this->M_Transact->runAPI($usr_id,$no_bon[0],$account[0],$cost_center,$sub_inv[0]);
			$this->M_Transact->delete($ip_address);	
			$this->M_Transact->Fnd($usr_id);

		redirect("TransactBon/Transact/Transaksi");
		// exit();
	}

	public function insertOracle2(){
		// echo "<pre>";
		// print_r($_POST);
		$kode_barang =$this->input->post('tsc_kodeBarang');
		$account =$this->input->post('tsc_Account');
		$nama_barang =$this->input->post('tsc_NamaBarang');
		$serah =$this->input->post('penyerahan');
		$penyerahan = $this->input->post('tsc_Penyerahan'); 
		$no_urut = $this->input->post('tsc_noUrut');
		$tujuan_gudang =$this->input->post('tsc_tujuanGudang');
		$lokator =$this->input->post('tsc_Lokator');
		$ip =$this->input->post('tsc_IP');
		$produk =$this->input->post('tsc_Produk');
		$keterangan =$this->input->post('tsc_Keterangan');
		$satuan =$this->input->post('tsc_Satuan');
		$kode_cabang =$this->input->post('tsc_kodeCabang');
		$seksi_bon =$this->input->post('tsc_seksiBon');
		$no_bon =  $this->input->post('tsc_noBon');
		$no_id = $this->input->post('tsc_noID');
		$flag = $this->input->post('flag');
		$usr_id= $this->input->post('tsc_usr');
		$cost_center = $this->input->post('tsc_costCenter');
		$sub_inv = $this->input->post('tsc_tjnGudang');
		$org_id_array = $this->input->post('tsc_org');
		$ip_address =  $this->input->ip_address();
		$a = $this->input->post('tsc_Permintaan');
		$b = $this->input->post('tsc_Give');
		// echo "<pre>";
		// print_r($ip_address);exit();

		for ($i = 0; $i < count($account); $i++){
			$this->M_Transact->insertData2($account[$i],$kode_barang[$i],$serah[$i],$no_urut[$i],$tujuan_gudang[$i],$lokator[$i],$ip_address,$produk[$i],$keterangan[$i],$satuan[$i],$kode_cabang[$i]);
			// $this->M_Transact->updatePostgre($serah[$i], $no_id[$i]);
			if($a == $b){
				$flag = 'Y';
			}else{
				$flag = 'N';
			} //echo $flag;
			$this->M_Transact->updateFlag($no_bon[$i],$no_id[$i], $flag);
		}
			$this->M_Transact->runAPI2($usr_id,$no_bon[0],$account[0],$cost_center,$ip_address,$org_id_array[0],$sub_inv[0],$lokator[0]);
			$this->M_Transact->delete($ip_address[0]);
			$this->M_Transact->Fnd($usr_id);

		redirect("TransactBon/Transact/Transaksi2");
		// exit();
		}

}
?> 
