<?php 
Defined('BASEPATH') or exit('No Dirext Access Allowed');
/**
 * 
 */
class C_Transferasset extends CI_Controller
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
		$this->load->model('SiteManagement/MainMenu/M_transferasset');

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

		$data['Title'] = 'Transfer Asset';
		$data['Menu'] = 'Transfer Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabel'] = $this->M_transferasset->getTransferAsset();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_indextransfer',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputNew(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Transfer Asset';
		$data['Menu'] = 'Transfer Asset';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_inputtransfer',$data);
		$this->load->view('V_Footer',$data);
	}

	public function GetSeksi(){
		$nama = $this->input->get('term');
		$data = $this->M_transferasset->getSeksi($nama);
		echo json_encode($data);
	}

	public function GetRequester(){
		$nama = $this->input->get('term');
		$data = $this->M_transferasset->getRequesterBaru($nama);
		echo json_encode($data);
	}

	public function InputTransfer(){

		$arrSimpan = array(
			'tag_number' => $this->input->post('txtTagNumberTransferAsset'),
			'no_blanko' => $this->input->post('txtNoBlankoTransferAsset'),
			'nama_barang' => $this->input->post('txtNamaBarangTransferAsset'),
			'seksi_awal' => $this->input->post('txtSeksiLamaTransferAsset'),
			'seksi_baru' => $this->input->post('txtSeksiBaruTransferAsset'),
			'requester_baru' => $this->input->post('txtRequesterBaru'),
			'tanggal_terima' => $this->input->post('txtTanggalDiterimaTransferAsset'),
			'created_by' => $this->session->user
		);

		$id = $this->input->post('txtIdTagNumber');

		$this->M_transferasset->insertTransferAsset($arrSimpan);

		$this->M_transferasset->updateSeksiAsset($id,$arrSimpan['seksi_baru']);

		redirect(site_url('SiteManagement/TransferAsset'));
	}
}
?>