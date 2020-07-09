<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_List extends CI_Controller
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
		$this->load->model('CateringTambahan/M_pesanan');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;
    $noind = $this->session->user;

		$data['Title'] = 'List Pesanan Seksi';
		$data['Menu'] = 'Pesanan Tambah Kurang ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['list'] = $this->M_pesanan->DataList($noind);
    $data['sesiUser'] = $this->M_pesanan->getSeksiHeader($noind);
    $data['sie'] = $this->M_pesanan->getPemesan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringTambahan/V_list');
		$this->load->view('V_Footer',$data);
	}

	public function detailList()
	{
		$id = $_POST['id'];
		$data = $this->M_pesanan->ambildetail1($id);
		$ket = explode(", ",$data['0']['keterangan']);
		if ($ket > 1) {
			for ($i=0; $i < count($ket) ; $i++) {
				$nama[] = $this->M_pesanan->getNamaa(true, $ket[$i])[0]['nama'];
			}
			$nama = implode(', ',$nama);
		}else {
			$ket = $data['0']['keterangan'];
			$nama = $this->M_pesanan->getNamaa(false, $ket)[0]['nama'];
		}

		$getSeksi1 = $this->M_pesanan->getSeksi1($data['0']['kodesie']);
		$data['0']['seksi'] = $getSeksi1;
		$data['0']['nama'] 	= $nama;
		$data['0']['nama1'] = $data['0']['nama1'];
		echo json_encode($data);
	}

}
