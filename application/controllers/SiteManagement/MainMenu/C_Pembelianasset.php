<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_Pembelianasset extends CI_COntroller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SiteManagement/MainMenu/M_pembelianasset');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Pembelian Asset';
		$data['Menu'] = 'Pembelian Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabel'] = $this->M_pembelianasset->getPembelianAsset();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_indexpembelian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputNew(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Input Pembelian Asset';
		$data['Menu'] = 'Pembelian Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_inputpembelian',$data);
		$this->load->view('V_Footer',$data);

		// $encrypted_string = $this->encrypt->encode($id.' - '.$pp);
  //       $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
  //       redirect(site_url('SiteManagement/InputAsset/InputDetail/'.$encrypted_string));
  //      
	}

	public function getNoPP(){
		$noPP = $this->input->get('term');
		$hasil = $this->M_pembelianasset->getNoPP($noPP);
		echo json_encode($hasil);
	}

	public function getNamaBarang(){
		$id = $this->input->post('nopp');
		$hasil = $this->M_pembelianasset->getBarangByID($id);
		echo json_encode($hasil);
	}

	public function getCostCenter(){
		$id = $this->input->get('term');
		$hasil = $this->M_pembelianasset->getCostCenter($id);
		echo json_encode($hasil);
	}

	public function InputTag(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Input Tag Number Pembelian Asset';
		$data['Menu'] = 'Pembelian Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id_asset_detail = $this->input->post('txtNamaBarang');
		$kode_cost_center = $this->input->post('txtCostCenter');
		$jumlah_diterima = $this->input->post('txtJumlahDiterima');
		$tanggal_pembelian = $this->input->post('txtTanggalPembelian');
		$id_asset = $this->input->post('txtNoPPAsset');
		$no_bppba = $this->input->post('txtNoBPPBA');

		$link = $id_asset.";".$id_asset_detail.";".$no_bppba.";".$tanggal_pembelian.";".$kode_cost_center.";".$jumlah_diterima;
 		$encrypted_string = $this->encrypt->encode($link);
        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
		$data['link'] = $encrypted_string;
		$data['banyak'] = $jumlah_diterima;
		$noPP = $this->M_pembelianasset->getNoPPByID($id_asset);
		$data['noPP'] = $noPP['0']['no_pp'];
		$data['noBPPBA'] = $no_bppba;
		$data['tglBeli'] = $tanggal_pembelian;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_inputtagnumber',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveInput($data){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $data);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data = explode(";", $plaintext_string);

		$user = $this->session->user;  

		$arrPost = $this->input->post('txtTagNumber');

		foreach ($arrPost as $key) {
			$this->M_pembelianasset->insertPembelianAsset($data,$key,$user);
		}

		redirect(site_url('SiteManagement/PembelianAsset'));
	}
}
?>