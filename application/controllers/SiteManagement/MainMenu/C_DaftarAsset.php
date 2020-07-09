<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_DaftarAsset extends Ci_Controller
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
		$this->load->model('SiteManagement/MainMenu/M_daftarasset');

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

		$data['Title'] = 'Data Asset';
		$data['Menu'] = 'Asset';
		$data['SubMenuOne'] = 'Data Asset';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabel'] = $this->M_daftarasset->getDataAsset();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Asset/V_indexdaftar',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Tag(){
		$tag = $this->input->post('tag_number');
		$data = $this->M_daftarasset->getTagNumber($tag);
		
		echo json_encode($data['0']);
	}

	public function TransferHistory(){
		$tag = $this->input->post('tag_number');
		$data = $this->M_daftarasset->getTransferHistory($tag);
		$text = "";
		$angka = 1;
		foreach ($data as $key) {
			$text .="<tr><td>$angka</td><td>".$key['seksi_awal']."</td><td>".$key['seksi_baru']."</td><td class='text-center'>".$key['tanggal_terima']."</td></tr>";
			$angka++;
		}
		echo $text;
	}
}
?>