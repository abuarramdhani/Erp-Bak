<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Moulding extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_moulding');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Moulding'] = $this->M_moulding->monitoringMoulding();
		
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	function view_create()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Moulding'] = $this->M_moulding->monitoringMoulding();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_create', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$comp = explode(' | ', $this->input->post('component_code'));

		$data = array(
			'component_code' => trim($comp[0]),
			'component_description' => trim($comp[1]),
			'production_date' => $this->input->post('production_date'),
			'moulding_quantity' => $this->input->post('txtMouldingQuantityHeader'),
			'shift' => $this->input->post('txtShift'),
			'keterangan' => $this->input->post('textarea_ket'),
			'print_code' => $this->input->post('print_code')
		);
		$this->M_moulding->setMoulding($data);
		$header_id = $this->db->insert_id();

		$emp = $this->input->post('txt_employee[]');
		$produksi = $this->input->post('txt_produksi[]');
		$lembur = $this->input->post('txt_lembur[]');
		$presensi = $this->input->post('txt_presensi[]');
		$ott = $this->input->post('txt_ott[]');
		$kode = $this->input->post('ottKodeP');

		$i = 0;
		foreach ($emp as $val) {

			$employee = explode('|', $val);
			$no_induk = $employee[0];
			$nama = $employee[1];
			$data =  array(
				'nama'		=> $nama,
				'no_induk' => $no_induk,
				'category_produksi' => 'Moulding',
				'id_produksi' => $header_id,
				'presensi' => $presensi[$i],
				'produksi' => $produksi[$i],
				'nilai_ott' => $ott[$i],
				'lembur' => $lembur[$i],
				'kode' => $kode,
				'created_date' =>  $this->input->post('production_date')
			);

			$this->M_moulding->insMouldingEmployee($header_id, $no_induk, $nama);
			$this->M_moulding->setAbsensi($data);
			$i++;
		}

		redirect(site_url('ManufacturingOperationUP2L/Moulding'));
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data['id'] = $id;

		$data['Moulding'] = $this->M_moulding->getMoulding($plaintext_string);

		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtComponentDescriptionHeader', 'ComponentDescription', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMouldingQuantityHeader', 'MouldingQuantity', 'required');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'component_code' => $this->input->post('txtComponentCodeHeader', TRUE),
				'component_description' => $this->input->post('txtComponentDescriptionHeader', TRUE),
				'production_date' => $this->input->post('txtProductionDateHeader', TRUE),
				'moulding_quantity' => $this->input->post('txtMouldingQuantityHeader', TRUE),
				// 'job_id' => $this->input->post('txtJobIdHeader',TRUE),
				// 'scrap_quantity' => $this->input->post('txtScrapQuantityHeader',TRUE),
				// 'scrap_type' => $this->input->post('txtScrapTypeHeader',TRUE),
				// 'last_updated_by' => $this->session->userid,
			);
			$this->M_moulding->updateMoulding($plaintext_string, $data);

			redirect(site_url('ManufacturingOperationUP2L/Moulding'));
		} else {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/Moulding/V_update', $data);
			$this->load->view('V_Footer', $data);
		}
	}

	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$mould = $this->M_moulding->getMoulding($plaintext_string);
		$scrap = $this->M_moulding->getScrap($mould[0]['moulding_id']);
		$bongkar = $this->M_moulding->getBongkar($mould[0]['moulding_id']);

		for ($i = 0; $i < count($mould); $i++) {
			$employee[] = array(
				'name' 	=> $mould[$i]['name'],
				'no_induk' => $mould[$i]['no_induk'],
			);
		}

		if (count($scrap) >= 1) {
			for ($i = 0; $i < count($scrap); $i++) {
				$scrap2[] = array(
					'type_scrap' => $scrap[$i]['type_scrap'],
					'kode_scrap' => $scrap[$i]['kode_scrap'],
					'quantity' => $scrap[$i]['quantity'],
					'jumlah' => $scrap[$i]['jumlah'],
					'scrap_id' => $scrap[$i]['scrap_id'],
					'no'	=> $i + 1,
				);
			}
		} else {
			$scrap2[] = array(
				'type_scrap' => '-',
				'kode_scrap' => '-',
				'quantity' => '-',
				'jumlah' => '-',
				'scrap_id' => '-',
				'no' => '-'
			);
		}

		if (count($bongkar) >= 1) {
			for ($i = 0; $i < count($bongkar); $i++) {
				$bongkar2[] = array(
					'quantity' => $bongkar[$i]['qty'],
					'jumlah' => $bongkar[$i]['jumlah'],
					'bongkar_id' => $bongkar[$i]['bongkar_id'],
					'no'	=> $i + 1,
				);
			}
		} else {
			$bongkar2[] = array(
				'quantity' => '-',
				'jumlah' => '-',
				'bongkar_id' => '-',
				'no' => '-'
			);
		}

		$head[] = array(
			'component_code' => $mould[0]['component_code'],
			'component_description' => $mould[0]['component_description'],
			'production_date' => $mould[0]['production_date'],
			'moulding_quantity' => $mould[0]['moulding_quantity'],
			'keterangan' => $mould[0]['keterangan'],
			'moulding_id' => $mould[0]['moulding_id'],
			'employee' => $employee,
			'scrap' => $scrap2,
			'bongkar' => $bongkar2
		);

		$data['Moulding'] = $head;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_read', $data);
		$this->load->view('V_Footer', $data);
	}

	public function delete($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_moulding->deleteMoulding($plaintext_string);

		redirect(site_url('ManufacturingOperationUP2L/Moulding'));
	}

	public function delScr($ids)
	{
		$this->M_moulding->delScr($ids);
		echo 1;
	}

	public function delBon($idb)
	{
		$this->M_moulding->delBon($idb);
		echo 1;
	}

	public function updScr()
	{
		$idScr = $this->input->post('idScr');
		$qtyScr = $this->input->post('qtyScr');
		$typeScr = $this->input->post('typeScr');
		$typeScrEx = explode("|", $typeScr);

		$codeScrap = $typeScrEx[0];
		$typeScrap = $typeScrEx[1];

		$this->M_moulding->updScr($qtyScr, $idScr, $codeScrap, $typeScrap);
		echo 1;
	}

	public function updBon()
	{
		$idBongkar = $this->input->post('idBongkar');
		$qtyBon = $this->input->post('qtyBon');

		$this->M_moulding->updBon($qtyBon, $idBongkar);
		echo 1;
	}
}