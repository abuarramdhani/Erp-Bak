<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
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
		$this->load->model('PerizinanDinas/AtasanApproval/M_index');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Dinas';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['nama'] = $this->M_index->getAllNama();
		$data['izin'] = $this->M_index->GetIzin($no_induk);
		$data['IzinApprove'] = $this->M_index->IzinApprove($no_induk);
		$data['IzinUnApprove'] = $this->M_index->IzinUnApprove($no_induk);
		$data['IzinReject'] = $this->M_index->IzinReject($no_induk);

		$today = date('Y-m-d');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerizinanDinas/AtasanApproval/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function update()
	{
		$status = $this->input->post('keputusan');
		$idizin = $this->input->post('id');
		$update= $this->M_index->update($status, $idizin);

		if ($status == 1) {
			$data['cekizin'] = $this->M_index->cekIzin($idizin);
			$nama = explode(', ', $data['cekizin'][0]['noind']);
			$tujuan = $this->M_index->getTujuanMakan($idizin);

			for ($i=0; $i < count($nama); $i++) {
				for ($j=0; $j < count($tujuan) ; $j++) {
					if ($nama[$i] == $tujuan[$j]['noind']) {
						$data = array(
							'izin_id'	=> $idizin,
							'noinduk' 	=> $nama[$i],
							'tujuan' => $tujuan[$j]['tujuan'],
							'created_date' => date('Y-m-d H:i:s')
						);
						$insert = $this->M_index->taktual_izin($data);
					}
				}
			}
		}elseif ($status == 2) {
			redirect('PerizinanDinas/AtasanApproval');
		}else{
		redirect('PerizinanDinas/AtasanApproval');
		}
	}

}
?>
