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
			redirect('');
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

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	//edit rozin
	public function buildMDataTable()
	{
		$post = $this->input->post();
		$bulan = $this->input->post('bulan');
		$tanggal = $this->input->post('tanggal');

		foreach ($post['columns'] as $val) {
				$post['search'][$val['data']]['value'] = $val['search']['value'];
		}

		$countall = $this->M_moulding->countAllM($bulan, $tanggal)[0]['jm'];
		$countfilter = $this->M_moulding->countFilteredM($post, $bulan, $tanggal)['jm'];
		 // echo "<pre>"; print_r($countfilter);die;
		$post['pagination']['from'] = $post['start'] + 1;
		$post['pagination']['to'] = $post['start'] + $post['length'];

		$protodata = $this->M_moulding->selectM($post, $bulan, $tanggal);
		// echo "<pre>";
		// print_r($protodata);
		// die;
		$data = [];
		foreach ($protodata as $row) {
		$encrypted_string = $this->encrypt->encode($row['moulding_id']);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

				$sub_array   = [];
				$sub_array[] = '<center>'.$row['pagination'].'</center>';
				$sub_array[] = '<center>
													<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Moulding/read/'.$encrypted_string.'').'" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
													<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Moulding/edit/'.$row['moulding_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
													<a href="'.base_url('ManufacturingOperationUP2L/Moulding/delete/'.$encrypted_string.'').'" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm(\'Are you sure you want to delete this item?\');"><span class="fa fa-trash fa-2x"></span></a>
												</center>';
				$sub_array[] = '<center>'.$row['component_code'].'</center>';
				$sub_array[] = '<center>'.$row['component_description'].'</center>';
				$sub_array[] = '<center>'.$row['production_date'].'</center>';
				$sub_array[] = '<center>'.$row['print_code'].'</center>';
				$sub_array[] = '<center>'.$row['shift'].'</center>';
				$sub_array[] = '<center>'.$row['moulding_quantity'].'</center>';
				$sub_array[] = '<center>'.$row['kode'].'</center>';
				$sub_array[] = '<center>'.$row['jumlah_pekerja'].'</center>';
				$sub_array[] = '<center>'.$row['bongkar_qty'].'</center>';
				$sub_array[] = '<center>'.$row['scrap_qty'].'</center>';
				$sub_array[] = '<center>'.($row['bongkar_qty'] - $row['scrap_qty']).'</center>';

				$data[] = $sub_array;
		}

		$output = [
				'draw' => $post['draw'],
				'recordsTotal' => $countall,
				'recordsFiltered' => $countfilter,
				'data' => $data,
		];

		die($this->output
						->set_status_header(200)
						->set_content_type('application/json')
						->set_output(json_encode($output))
						->_display());
	}

	public function getAjax()
	{
		$data['bulan'] = $this->input->post('bulan');
		$data['tanggal'] = $this->input->post('tanggal');
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_ajax', $data);
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

		$mouldingData = array();
		$aksen1 = 0;
		foreach ($this->input->post('txtMouldingQuantityHeader[]') as $a) {
			$mouldingData[$aksen1]['moulding_quantity'] = $a;
			$aksen1++;
		}

		$aksen2 = 0;
		foreach ($this->input->post('component_code[]') as $b) {
			$pecMoulding = explode(' | ', $b);
			$mouldingData[$aksen2]['component_code'] = trim($pecMoulding[0]);
			$mouldingData[$aksen2]['component_description'] = trim($pecMoulding[1]);
			$mouldingData[$aksen2]['kode_proses'] = trim($pecMoulding[2]);
			$mouldingData[$aksen2]['production_date'] = $this->input->post('production_date');
			$mouldingData[$aksen2]['shift'] = $this->input->post('txtShift');
			$mouldingData[$aksen2]['print_code'] = $this->input->post('print_code');
			$mouldingData[$aksen2]['ket_pengurangan'] = $this->input->post('txtKeteranganPemotonganTarget');
			if (array_key_exists('txtJamPemotonganTarget', $_POST)) {
				$mouldingData[$aksen2]['jam_pengurangan'] = str_replace(' ', '', $this->input->post('txtJamPemotonganTarget')) ;
			} else {
				$mouldingData[$aksen2]['jam_pengurangan'] = '';
			}

			$aksen2++;
		}


		foreach ($mouldingData as $mo) {

			$this->M_moulding->setMoulding($mo);
			$header_id = $this->db->insert_id();

			$emp = $this->input->post('txt_employee[]');
			$produksi = $this->input->post('txt_produksi[]');
			$lembur = $this->input->post('txt_lembur[]');
			$presensi = $this->input->post('txt_presensi[]');
			$ott = $this->input->post('txt_ott[]');
			$kode = $this->input->post('kode_kel');

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
		}

		redirect(site_url('ManufacturingOperationUP2L/Moulding/view_create'));
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['id'] = $id;

		$data['Moulding'] = $this->M_moulding->getMoulding($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_update', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update($id)
	{
		$component = explode(' | ', $this->input->post('cmbComponentCodeHeader', TRUE));
			$data = array(
				'component_code'		=> $component[0],
				'component_description' => $component[1],
				'kode_proses'			=> $component[2],
				'production_date' => $this->input->post('txtProductionDateHeader', TRUE),
				'print_code'			=> $this->input->post('print_code'),
				'shift'					=> $this->input->post('txtShift'),
				'moulding_quantity' => $this->input->post('txtMouldingQuantityHeader', TRUE),
			);
			$this->M_moulding->updateMoulding($id, $data);

			redirect(site_url('ManufacturingOperationUP2L/Moulding'));
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
			'kode_proses' => $mould[0]['kode_proses'],
			'print_code' => $mould[0]['print_code'],
			'production_date' => $mould[0]['production_date'],
			'shift' => $mould[0]['shift'],
			'kode' => $mould[0]['kode'],
			'moulding_quantity' => $mould[0]['moulding_quantity'],
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
	public function search()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$mon = explode('-', $this->input->post('bulan'));
		$data['Moulding'] = $this->M_moulding->search($mon[1], $mon[0]);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Moulding/V_searche', $data);
		$this->load->view('V_Footer', $data);
	}

}
