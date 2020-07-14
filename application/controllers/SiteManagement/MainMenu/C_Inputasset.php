<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 * 
 */
class C_Inputasset extends CI_Controller
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
		$this->load->model('SiteManagement/MainMenu/M_inputasset');

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

		$data['Title'] = 'Input Asset';
		$data['Menu'] = 'Input Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabel'] = $this->M_inputasset->getAsset();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_indexinput',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputNew(){
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Input Asset';
		$data['Menu'] = 'Input Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenis'] = $this->M_inputasset->getJenisAsset();
		$data['kategori'] = $this->M_inputasset->getKategoriAsset();
		$data['perolehan'] = $this->M_inputasset->getPerolehanAsset();
		$data['seksi'] = $this->M_inputasset->getSeksiPemakaiAsset();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_inputasset',$data);
		$this->load->view('V_Footer',$data);
	}

	public function GetRequester(){
		$noind = $this->input->get('term');
		$noind = strtoupper($noind);
		$pekerja = $this->M_inputasset->getRequesterAsset($noind);
		echo json_encode($pekerja);
	}

	public function GetItem(){
		$kata = $this->input->get('term');
		$kata = strtoupper($kata);
		$item = $this->M_inputasset->getItemAsset($kata);
		echo json_encode($item);
	}

	public function InputData(){
		$dataInsert = array(
			'tgl_pp' 		=> $this->input->post('txtTanggalPP'), 
			'no_ppa' 		=> $this->input->post('txtNomorPPA'), 
			'no_pp' 		=> $this->input->post('txtNomorPP'), 
			'id_kat' 		=> $this->input->post('txtKategoriAsset'), 
			'id_jenis' 		=> $this->input->post('txtJenisAsset'), 
			'id_perolehan' 	=> $this->input->post('txtPerolehanAsset'), 
			'seksi_pemakai' => $this->input->post('txtSeksiPemakaiAsset'), 
			'requester' 	=> $this->input->post('txtRequesterAsset'), 
		);
		$pp = $this->input->post('txtNomorPP');
		$id = $this->M_inputasset->insertAsset($dataInsert);
		$encrypted_string = $this->encrypt->encode($id.' - '.$pp);
        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
        redirect(site_url('SiteManagement/InputAsset/InputDetail/'.$encrypted_string));
	}

	public function InputDetail($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;

		$data['Title'] = 'Input Asset';
		$data['Menu'] = 'Input Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$idPP = explode(' - ', $plaintext_string);
		$data['idAsset'] = $idPP['0'];
		$data['noPP'] = $idPP['1'];
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_inputdetailasset',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputDetailData(){
		$kode = $this->input->post('txtKodebarang');
		$nama = $this->input->post('txtNamaBarang');
		$spek = $this->input->post('txtSpesifikasi');
		$jumlah = $this->input->post('txtJumlah');
		$umur = $this->input->post('txtUmur');
		$angka = 0;
		foreach ($kode as $key) {
			$InsertData = array(
				'id_input_asset' => $this->input->post('txtIDAsset'),
				'kode_item' => $kode[$angka],
				'nama_item' => $nama[$angka],
				'spesifikasi_asset' => $spek[$angka],
				'jumlah_diminta' => $jumlah[$angka],
				'umur_teknis' => $umur[$angka]
			);
			$this->M_inputasset->insertDetailAsset($InsertData);
			$angka++;
		}

		
		redirect(site_url('SiteManagement/InputAsset'));
	}

	public function EditAsset($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Edit Asset';
		$data['Menu'] = 'Input Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenis'] = $this->M_inputasset->getJenisAsset();
		$data['kategori'] = $this->M_inputasset->getKategoriAsset();
		$data['perolehan'] = $this->M_inputasset->getPerolehanAsset();
		$data['seksi'] = $this->M_inputasset->getSeksiPemakaiAsset();
		$data['asset'] = $this->M_inputasset->getAssetByID($plaintext_string);
		$data['link'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_editasset',$data);
		$this->load->view('V_Footer',$data);
	}

	public function EditData($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$dataUpdate = array(
			'tgl_pp' 		=> $this->input->post('txtTanggalPP'), 
			'no_ppa' 		=> $this->input->post('txtNomorPPA'), 
			'no_pp' 		=> $this->input->post('txtNomorPP'), 
			'id_kat' 		=> $this->input->post('txtKategoriAsset'), 
			'id_jenis' 		=> $this->input->post('txtJenisAsset'), 
			'id_perolehan' 	=> $this->input->post('txtPerolehanAsset'), 
			'seksi_pemakai' => $this->input->post('txtSeksiPemakaiAsset'), 
			'requester' 	=> $this->input->post('txtRequesterAsset'), 
		);
		$pp = $this->input->post('txtNomorPP');
		$id = $this->M_inputasset->updateAsset($dataUpdate,$plaintext_string);
		$encrypted_string = $this->encrypt->encode($id.' - '.$pp);
        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
        redirect(site_url('SiteManagement/InputAsset/EditDetail/'.$encrypted_string));
	}

	public function EditDetail($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;

		$data['Title'] = 'Input Asset';
		$data['Menu'] = 'Input Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$idPP = explode(' - ', $plaintext_string);
		$data['idAsset'] = $idPP['0'];
		$data['noPP'] = $idPP['1'];
		$data['asset'] = $this->M_inputasset->getAssetDetailByID($data['idAsset']);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_editdetailasset',$data);
		$this->load->view('V_Footer',$data);
	}

	public function EditDetailData(){
		$kode = $this->input->post('txtKodebarang');
		$nama = $this->input->post('txtNamaBarang');
		$spek = $this->input->post('txtSpesifikasi');
		$jumlah = $this->input->post('txtJumlah');
		$umur = $this->input->post('txtUmur');
		$id = $this->input->post('txtIDAsset');
		$this->M_inputasset->deleteAssetDetailByID($id);
		$angka = 0;
		foreach ($kode as $key) {
			$InsertData = array(
				'id_input_asset' => $this->input->post('txtIDAsset'),
				'kode_item' => $kode[$angka],
				'nama_item' => $nama[$angka],
				'spesifikasi_asset' => $spek[$angka],
				'jumlah_diminta' => $jumlah[$angka],
				'umur_teknis' => $umur[$angka]
			);
			$this->M_inputasset->insertDetailAsset($InsertData);
			$angka++;
		}

		
		redirect(site_url('SiteManagement/InputAsset'));
	}

	public function RemoveAsset($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_inputasset->deleteAssetByID($plaintext_string);

		redirect(site_url('SiteManagement/InputAsset'));
	}
}
?>