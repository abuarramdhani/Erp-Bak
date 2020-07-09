<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_LimbahMaster extends CI_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_limbahmaster');

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

		$data['Title'] = 'Master Data Limbah B3';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['LimbahJenis'] = $this->M_limbahmaster->getLimbahJenis();
		// echo "<pre>";
		// print_r($data['LimbahJenis']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/MasterData/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Data Limbah B3';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['SatuanLimbahAll'] = $this->M_limbahmaster->getSatuanLimbahAll();

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtJenisLimbahHeader', 'jenislimbah', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/MasterData/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$id = $this->M_limbahmaster->getLimbahJenisID();
			$data = array(
				'id_jenis_limbah' => $id['0']['id'],
				'jenis_limbah' => $this->input->post('txtJenisLimbahHeader'),
				'kode_limbah' => $this->input->post('txtKodeLimbahHeader'),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'creation_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
    		);
			$this->M_limbahmaster->setLimbahJenis($data);
			$header_id = $id['0']['id'];

				// $satuan = array(
				// 	'id_jenis_limbah' => $header_id,
				// 	'limbah_satuan' => $this->input->post('txtSatuanLimbahHeader'),
				// );
				// $this->M_limbahmaster->setLimbahSatuan($satuan);
				$jumlahSatuan = count($_POST['txtSatuanLimbahHeader']);
				for ($i=0; $i < $jumlahSatuan ; $i++) {
					$newId = $this->M_limbahmaster->getMaxIDSatuanAll();
					$newId = $newId['0']['id'];
					$satuan = array(
						'id_satuan_all' => $newId,
						'id_jenis_limbah' => $header_id,
						'limbah_satuan_all' => $_POST['txtSatuanLimbahHeader'][$i]
					);
					$this->M_limbahmaster->setSatuanAll($satuan);
				}

				$sumber = array(
					'id_jenis_limbah' => $header_id,
					'sumber' => $this->input->post('txtSumberLimbahHeader'),
				);
				$this->M_limbahmaster->setLimbahSumber($sumber);

				$konversi = array(
					'id_jenis_limbah' => $header_id,
					'konversi' => $this->input->post('txtKonversiLimbahHeader'),
				);
				$this->M_limbahmaster->setLimbahKonversi($konversi);

			redirect(site_url('WasteManagement/MasterData'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Data Limbah B3';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahJenis'] = $this->M_limbahmaster->getLimbahJenis($plaintext_string);
		$data['SatuanLimbahAll'] = $this->M_limbahmaster->getSatuanLimbahAll();

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtJenisLimbahHeader', 'jenislimbah', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/MasterData/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {

			$data = array(
				'jenis_limbah' => $this->input->post('txtJenisLimbahHeader',TRUE),
				'kode_limbah' => $this->input->post('txtKodeLimbahHeader'),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'last_updated' => date('Y-m-d h:i:s'),
				'last_update_by' => $this->session->userid,
    			);
			$this->M_limbahmaster->updateLimbahJenis($data, $plaintext_string);

				// 	$satuan = array(
				// 		'limbah_satuan' => $this->input->post('txtSatuanLimbahHeader'),
				// 	);
				// $id_satuan = $this->input->post('txtIDSatuanLimbahHeader');
				// $this->M_limbahmaster->updateLimbahSatuan($satuan, $id_satuan);

			//inactive first all//
			$this->M_limbahmaster->updateOffAll($plaintext_string);
				$jumlahSatuan = count($_POST['txtSatuanLimbahHeader']);
				for ($i=0; $i < $jumlahSatuan ; $i++) {
					$newId = $this->M_limbahmaster->getMaxIDSatuanAll();
					$newId = $newId['0']['id'];
					$satuan = array(
						'id_satuan_all' => $newId,
						'id_jenis_limbah' => $plaintext_string,
						'limbah_satuan_all' => $_POST['txtSatuanLimbahHeader'][$i],
						'status' => '1'
					);
					$this->M_limbahmaster->updateSatuanAll($satuan);
				}

					$id_sumber = $this->input->post('txtIDSumberLimbahHeader',TRUE);

					$sumber = array(
						'sumber' => $this->input->post('txtSumberLimbahHeader'),
					);

				$this->M_limbahmaster->updateLimbahSumber($sumber, $id_sumber);

					$id_konversi = $this->input->post('txtIDKonversiLimbahHeader',TRUE);

					$konversi = array(
						'konversi' => $this->input->post('txtKonversiLimbahHeader'),
					);

				$this->M_limbahmaster->updateLimbahKonversi($konversi, $id_konversi);

			redirect(site_url('WasteManagement/MasterData'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Data Limbah B3';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahJenis'] = $this->M_limbahmaster->getLimbahJenis($plaintext_string);
		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/MasterData/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->M_limbahmaster->deleteLimbahJenis($plaintext_string);
		$this->M_limbahmaster->deleteLimbahSatuan($plaintext_string);
		$this->M_limbahmaster->deleteLimbahSumber($plaintext_string);
		$this->M_limbahmaster->deleteLimbahKonversi($plaintext_string);
		$this->M_limbahmaster->deleteLimbahSatuanAll($plaintext_string);

		redirect(site_url('WasteManagement/MasterData'));
    }

		public function ajaxAddSatuan(){
			$newId = $this->M_limbahmaster->getMaxIDSatuanAll();
			$newId = $newId['0']['id'];
			$satuanall = array(
				'id_satuan_all' => $newId,
				'limbah_satuan_all' => $this->input->post('satuan'),
				'id_jenis_limbah' => NULL
			 );
			$add = $this->M_limbahmaster->setLimbahSatuanAll($satuanall);
			echo json_encode($add);
		}



}

/* End of file C_LimbahJenis.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_LimbahJenis.php */
/* Generated automatically on 2017-11-13 08:49:52 */
