<?php 
defined('BASEPATH') or exit("No Direct Script Access Allowed");

/**
 * 
 */
class C_SebabKeluar extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		// $this->load->helper('form');
		// $this->load->helper('html');
		$this->load->helper('url');

		$this->load->library('session');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/SebabKeluar/M_sebabkeluar');

		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if(!$this->session->is_logged) redirect('');
	}

	function index()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Sebab Keluar';
		$data['Header'] = 'Sebab Keluar';
		$data['Menu'] = 'Setup Master';
		$data['SubMenuOne'] = 'Sebab Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_sebabkeluar->getSebabKeluarAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/SebabKeluar/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	function getData($encrypted_id)
	{
		$id = base64_decode(str_replace(['+','/','='], ['-','_','~'],$encrypted_id));
		$data = $this->M_sebabkeluar->getSebabKeluarById($id);
		echo json_encode($data);
	}

	function simpanData(){
		$encrypted_id = $this->input->post('id');

		$input = array(
			'kode' 					=> $this->input->post('kode'),
			'sebab_keluar' 			=> $this->input->post('sebab_keluar'),
			'dasar_hukum' 			=> $this->input->post('dasar_hukum'),
			'pengali_u_pesangon' 	=> $this->input->post('pengali_u_pes'),
			'pengali_u_pmk' 		=> $this->input->post('pengali_u_pmk'),
			'urutan' 				=> $this->input->post('urutan')
		);


		if (!empty($encrypted_id)) {
			$id = base64_decode(str_replace(['+','/','='], ['-','_','~'],$encrypted_id));
			$sebelum = $this->M_sebabkeluar->getSebabKeluarById($id);
			if ($sebelum->urutan != $input['urutan']) {
				if ($sebelum->urutan < $input['urutan']) {
					$this->M_sebabkeluar->updateUrutanBetween($sebelum->urutan,$input['urutan'],"-");
				}else{
					$this->M_sebabkeluar->updateUrutanBetween($input['urutan'],$sebelum->urutan,"+");
				}
			}
			$this->M_sebabkeluar->updateSebabKeluarById($input,$id);
			$sesudah = $this->M_sebabkeluar->getSebabKeluarById($id);
			$this->M_sebabkeluar->insertLog('UPDATE',json_encode($sebelum)." => ".json_encode($sesudah));
		}else{
			$urut = $this->M_sebabkeluar->getSebabKeluarByUrutan($input['urutan']);
			if (!empty($urut)) {
				$this->M_sebabkeluar->updateUrutanAfter($input['urutan']);
			}
			$this->M_sebabkeluar->insertSebabKeluar($input);
			$this->M_sebabkeluar->insertLog('INSERT',json_encode($input));
		}

		$data = $this->M_sebabkeluar->getSebabKeluarAll();
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$data[$key]['id'] = str_replace(['+','/','='], ['-','_','~'], base64_encode($value['id']));
			}
		}
		echo json_encode($data);
	}

	function deleteData($encrypted_id){
		$id = base64_decode(str_replace(['+','/','='], ['-','_','~'],$encrypted_id));

		$sebelum = $this->M_sebabkeluar->getSebabKeluarById($id);
		$this->M_sebabkeluar->deleteSebabKeluarById($id);
		$this->M_sebabkeluar->insertLog('DELETE',json_encode($sebelum));

		$data = $this->M_sebabkeluar->getSebabKeluarAll();
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$data[$key]['id'] = str_replace(['+','/','='], ['-','_','~'], base64_encode($value['id']));
			}
		}
		echo json_encode($data);
	}
}