<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_Retirementasset extends CI_COntroller
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
		$this->load->model('SiteManagement/MainMenu/M_retirementasset');

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

		$data['Title'] = 'Retirement Asset';
		$data['Menu'] = 'Retirement Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabel'] = $this->M_retirementasset->getRetirementAsset();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_indexretirement',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputNew(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Retirement Asset';
		$data['Menu'] = 'Retirement Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['tabel'] = $this->M_pembelianasset->getPembelianAsset();
		$data['usulan'] = $this->M_retirementasset->getUsulanSeksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_inputretirement',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getTagNumber(){
		$id = $this->input->get('term');
		$data = $this->M_retirementasset->getTagNumber($id);
		echo json_encode($data);
	}

	public function getBarang(){
		$id = $this->input->post('id');
		$data = $this->M_retirementasset->getBarang($id);
		echo json_encode($data);
	}

	public function SaveRetirement(){
		$lainnya = $this->input->post('txtUsulanLainnyaRetirementAsset');
		if (!empty($lainnya)) {
			$usul = ($this->input->post('txtUsulanSeksiRetirementAsset'))." - ".($this->input->post('txtUsulanLainnyaRetirementAsset'));
		}else{
			$usul = $this->input->post('txtUsulanSeksiRetirementAsset');
		}

		$arrSimpan = array(
			'tag_number' => $this->input->post('txtTagNumberRetirementAsset'),
			'no_retirement' => $this->input->post('txtNoRetirementAsset'),
			'nama_barang' => $this->input->post('txtNamaBarangRetirementAsset'),
			'merk' => $this->input->post('txtMerkBarangRetirementAsset'),
			'model' => $this->input->post('txtModelBarangRetirementAsset'),
			'negara_pembuat' => $this->input->post('txtNegaraPembuatbarangRetirementAsset'),
			'serial_number' => $this->input->post('txtSerialNumberBarangRetirementAsset'),
			'lokasi' => $this->input->post('txtSeksiRetirementAsset'),
			'kota' => $this->input->post('txtKotaRetirementAsset'),
			'gedung' => $this->input->post('txtGedungRetirementAsset'),
			'lantai' => $this->input->post('txtLantaiRetirementAsset'),
			'ruang' => $this->input->post('txtRuangRetirementAsset'),
			'rencana_penghentian' => $this->input->post('txtRencanaRetirementAsset'),
			'usulan_seksi' => $usul,
			'alasan' => $this->input->post('txtAlasanRetirementAsset'),
			'created_by' => $this->session->user,
		);
 		$tag = $this->input->post('txtTagNumberRetirementAsset');
		$this->M_retirementasset->insertRetirementAsset($arrSimpan,$tag);
		redirect(site_url('SiteManagement/RetirementAsset'));
	}

	public function getDaerah(){
		$nama = $this->input->get('term');
		$data = $this->M_retirementasset->getDaerah($nama);

		echo json_encode($data);
	}

	public function Aktif($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data = explode("_-_", $plaintext_string);
		$id = $data['0'];
		$tag = $data['1'];

		$this->M_retirementasset->nonAktifRetirementAsset($id);
		$this->M_retirementasset->resetStatusRetired($tag);

		redirect(site_url('SiteManagement/RetirementAsset'));
	}
}
?>