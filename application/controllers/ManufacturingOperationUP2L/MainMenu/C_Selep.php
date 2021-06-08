<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Selep extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_selep');

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

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		// $data['Selep'] = $this->M_selep->getSelep(); // hehe

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update_user_subinv($value='')
	{
		// echo "<pre>";
		// print_r($this->input->post());
		if (!empty($this->input->post('no_induk'))) {
			$this->db->where('id IS NOT', NULL)->delete('mo.mo_selep_subinv');
			foreach ($this->input->post('no_induk') as $key => $value) {
				if (!empty($value) && !empty( $this->input->post('subinv')[$key])) {
					$data = [
						'no_induk' => strtoupper($value),
						'subinv' => $this->input->post('subinv')[$key]
					];
					$this->db->insert('mo.mo_selep_subinv', $data);
				}
			}
			if ($this->db->affected_rows()) {
				echo json_encode(200);
			}else {
				echo json_encode(500);
			}
		}else {
			echo json_encode(500);
		}


	}

	public function user_subinv($value='')
	{
		$data['get'] = $this->db->get('mo.mo_selep_subinv')->result_array();
		$this->load->view('ManufacturingOperationUP2L/Selep/V_setting_subinv', $data);
	}

	public function cek_user($value='')
	{
		// SEBELUM PUSH PRODUKSI PASTIKAN TABEL INI ADA //
		$data_ = $this->db->where('no_induk', $this->input->post('noind'))->get('mo.mo_selep_subinv')->row_array();
		if (!empty($data_['no_induk'])) {
			$res = $data_['subinv'];
		}else {
			$res = 'gada';
		}
		echo json_encode($res);
	}

	public function get_qty_handling($value='')
	{
		$data = 'gada';
		$res =  $this->M_selep->get_qty_handling($this->input->post('component_code'), $this->input->post('org_code'));
		if (!empty($res['HANDLING'])) {
			$data = $res['HANDLING'];
		}
		echo json_encode($data);
	}

	public function get_io_subinv_locator_tujuan($value='')
	{
		$data = $this->M_selep->get_io_subinv_locator_tujuan($this->input->post('batch_no'));
		echo json_encode($data);
	}

	public function generate_kib()
	{
		if (!empty($this->input->post('batch_no'))) {
	    $batch_no = $this->input->post('batch_no');
	    $data = $this->M_selep->get_data_kib($batch_no);
			$qty_selep = $this->input->post('qty_selep');
			$qty_handling = $this->input->post('qty_handling');

			if ($qty_handling != 0) {
					$locator = explode(' - ', $this->input->post('locator'));
					$org_id = explode(' - ', $this->input->post('io'));
		  		//SCHEDULED_QUANTITY => qty handling => misal handling 50 qty_kib 205 jadi 50 50 50 50 5
					if ($qty_selep > $qty_handling) {
						$loop = floor($qty_selep/$qty_handling);
						$modulus = $qty_selep%$qty_handling;
						for ($i=0; $i < $loop; $i++) {
							$get_kib =  $this->M_selep->generate_no_kib($batch_no);
							$data[0]['NO_KIB'] = $get_kib['NO_KIB'];
							$data[0]['FROM_SUBINVENTORY_CODE'] = $this->input->post('from_sub_code');
							$data[0]['TO_ORG_ID'] = $org_id[1];
							$data[0]['TO_SUBINVENTORY_CODE'] = $this->input->post('subinv');
							$data[0]['TO_LOCATOR_ID'] = $locator[1];
							$data[0]['QTY_HANDLING'] = $qty_handling;
							$data[0]['NO_INDUK'] = $this->session->user;
							$data[0]['QTY_SELEP'] = $qty_handling;
							$insert = $this->M_selep->insertKIB($data);
						}
						if (!empty($modulus)) {
							$get_kib =  $this->M_selep->generate_no_kib($batch_no);
							$data[0]['NO_KIB'] = $get_kib['NO_KIB'];
							$data[0]['FROM_SUBINVENTORY_CODE'] = $this->input->post('from_sub_code');
							$data[0]['TO_ORG_ID'] = $org_id[1];
							$data[0]['TO_SUBINVENTORY_CODE'] = $this->input->post('subinv');
							$data[0]['TO_LOCATOR_ID'] = $locator[1];
							$data[0]['QTY_HANDLING'] = $qty_handling;
							$data[0]['NO_INDUK'] = $this->session->user;
							$data[0]['QTY_SELEP'] = $modulus;
							$insert = $this->M_selep->insertKIB($data);
						}
					}else {
						$get_kib =  $this->M_selep->generate_no_kib($batch_no);
						$data[0]['NO_KIB'] = $get_kib['NO_KIB'];
						$data[0]['FROM_SUBINVENTORY_CODE'] = $this->input->post('from_sub_code');
						$data[0]['TO_ORG_ID'] = $org_id[1];
						$data[0]['TO_SUBINVENTORY_CODE'] = $this->input->post('subinv');
						$data[0]['TO_LOCATOR_ID'] = $locator[1];
						$data[0]['QTY_HANDLING'] = $qty_handling;
						$data[0]['NO_INDUK'] = $this->session->user;
						$data[0]['QTY_SELEP'] = $qty_selep;
						$insert = $this->M_selep->insertKIB($data);
					}

			    if ($insert == 1) {
						// redirect('InventoryManagement/CreateKIBDEV/pdf/1/'.$batch_no.'/0');
						// echo "Karena masih di local, Klik link berikut <a href='http://192.168.168.196/erp-2021/ManufacturingOperationUP2L/CreateKIBDEV/pdf/1/$batch_no/0'>$batch_no</a>";
						echo json_encode("<a href='http://erp.quick.com/ManufacturingOperationUP2L/CreateKIB/pdf/1/$batch_no/0'>$batch_no</a>");
			    }else {
						echo json_encode(500);
			    }
			}else {
				// echo "QTY_HANDLING can't 0";
				echo json_encode(500);
			}

	  }else {
	    // echo "Batch Number can't null";
			echo json_encode(500);
	  }
	}

	// public function report_kib_opm($batch_no)
	// {
	// 	$get = $this->M_selep->report_kib($batch_no);
	// 	// echo "<PRE>";
	// 	// print_r($get);
	// 	// die;
	// 	$data['get'] = $get;
	// 	ob_start();
	// 	$this->load->library('ciqrcode');
	// 	if (!is_dir('./assets/img/PBIQRCode')) {
	// 			mkdir('./assets/img/PBIQRCode', 0777, true);
	// 			chmod('./assets/img/PBIQRCode', 0777);
	// 	}
	// 	foreach ($get as $key => $value) {
	// 		// ------ GENERATE QRCODE ------
	// 		$params['data']		= $value['SERIAL_NUMBER'];
	// 		$params['level']	= 'H';
	// 		$params['size']		= 5;
	// 		$params['black']	= array(255,255,255);
	// 		$params['white']	= array(0,0,0);
	// 		$params['savename'] = './assets/img/PBIQRCode/'.$value['NOKIB'].'.png';
	// 		$this->ciqrcode->generate($params);
	// 	}
	//
	// 	$pdf 		= $this->pdf->load();
	// 	// $pdf 		= new mPDF('utf-8', array(120, 210), 0, 'calibri', 3, 3, 15, 0, 0, 0);
	// 	$pdf 		= new mPDF('utf-8', array(120, 210), 0, 'calibri', 3, 3, 10, 3, 3, 3);
	// 	ob_end_clean() ;
	//
	// 	$doc = 'Cetak-KIB-'.$batch_no;
	// 	$filename 	= $doc.'.pdf';
	// 	if (!empty($data['get'])) {
	// 		$isi 	= $this->load->view('ManufacturingOperationUP2L/Selep/V_cetak_kib', $data, true);
	// 	}else {
	// 		$isi 	= 'Data is empty';
	// 	}
	// 	$pdf->WriteHTML($isi);
	// 	$pdf->Output($filename, 'I');
	//
	// 	foreach ($get as $key => $value) {
	// 		if (!unlink('./assets/img/PBIQRCode/'.$value['NOKIB'].'.png')) {
	// 				echo("Error deleting");
	// 		}
	// 	}
	// }

	public function batch_completion($value='')
	{
		$data = 'gada';
		$no_batch = $this->input->post('batch_no');
		$qty = $this->input->post('qty');
		if (!empty($no_batch) && !empty($qty)) {
			$this->M_selep->batch_completion($no_batch, $qty);
			$data = 1;
		}
		echo json_encode($data);
	}

	public function update_subinv_complation()
	{
		$update = $this->M_selep->update_subinv_complation($this->input->post('item_id'), $this->input->post('batch_no'), $this->input->post('subinv'));
		if ($update == 100) {
			echo json_encode(100);
		}else {
			echo json_encode('gada');
		}
	}

	public function check_detail_onhand($value='')
	{
		$data = '';
		$merah = 0;
		if (!empty($this->input->post('batch_no'))) {
			$res = $this->M_selep->check_onhand($this->input->post('batch_no'));
			if (!empty($res[0]['BATCH_NO'])) {
				foreach ($res as $key => $value) {
					if ($value['ONHAND'] <= 0 || empty($value['SUBINVENTORY'])) {
						$style = 'class="up2l_selep_merah"';
						$merah = 500;
					}else {
						$style = '';
					}
					if (!empty($value['SUBINVENTORY'])) {
						$sub_to = $value['SUBINVENTORY'];
					}else {
						$user_login = $this->session->user;
						$cek_sub_inv_user = $this->db->select('subinv')->where('no_induk', $user_login)->get('mo.mo_selep_subinv')->row_array();
						if (!empty($cek_sub_inv_user)) {
							if ($cek_sub_inv_user['subinv'] == 'INT-FDY') {
								$option = '<option value="INT-FDY">INT-FDY - GUDANG INTERNAL UNIT FOUNDRY</option>';
							}else {
								$option = '<option value="INT-FDYTKS">INT-FDYTKS - GUDANG INTERNAL UNIT FOUNDRY DI TUKSONO</option>';
							}
							$sub_to = '<select class="select2subinv_up2l_complation" onchange="set_tosubinv_up2l(\''.$value['INVENTORY_ITEM_ID'].'\', \''.$value['BATCH_NO'].'\')" name="" style="width:150px;">
													<option value=""></option>
													'.$option.'
												</select>';
						}else {
							$sub_to = '<select class="select2subinv_up2l_complation" onchange="set_tosubinv_up2l(\''.$value['INVENTORY_ITEM_ID'].'\', \''.$value['BATCH_NO'].'\')" name="" style="width:150px;">
													<option value=""></option>
													<option value="INT-FDY">INT-FDY - GUDANG INTERNAL UNIT FOUNDRY</option>
													<option value="INT-FDYTKS">INT-FDYTKS - GUDANG INTERNAL UNIT FOUNDRY DI TUKSONO</option>
												</select>';
						}
					}
					$tampung[] = '<tr '.$style.'>
		                      <td>'.$value['BATCH_NO'].'</td>
		                      <td>
													'.$sub_to.'
													</td>
		                      <td>'.$value['ITEM'].'</td>
													<td>'.$value['DESCRIPTION'].'</td>
													<td>'.number_format($value['ATT'],2).'</td>
													<td>'.number_format($value['PLAN_QTY'],2).'</td>
													<td>'.number_format($value['ONHAND'],2).'</td>
		                    </tr>';
				}
				$response = implode('', $tampung);
			}else {
				$response = '<tr><td colspan="7">Onhand dengan batch '.$this->input->post('batch_no').' tidak ditemukan, Hubungi ICT</td></tr>';
				$merah = 500;
			}
		}else {
			$response = '<tr><td colspan="7">Batch Number NULL</td></tr>';
			$merah = 500;
		}
		$data = [
			'data' => $response,
			'merah' => $merah
		];
		echo json_encode($data);
	}


	public function check_onhand($value='')
	{
		$data = 'gada';
		$res = $this->M_selep->check_onhand($this->input->post('batch_no'));
		if (!empty($res[0]['BATCH_NO'])) {
			$data = $res;
		}
		echo json_encode($data);
	}

	public function create_batch($value='')
	{
		$job_date=date_create($this->input->post('job_date'));
		$job_date=strtoupper(date_format($job_date,"d-M-Y H:i:s"));
		$res = $this->M_selep->create_batch($this->input->post('item'),
																				$this->input->post('recipe_no'),
																				$this->input->post('recipe_version'),
																				$this->input->post('uom'),
																				$this->input->post('subinv'),
																				$this->input->post('qty'),
																				$job_date);
		if (!empty($res['no_batch'])) {
			$data = $res;
		}else {
			$data = [
				'no_batch' => 'gada',
				'reason' => $res['reason']
			];
		}
		echo json_encode($data);
	}

	public function SubInv($value='')
	{
		$data = $this->M_selep->SubInv($this->input->post('io'));
		$tampung[] = '<option value="">Select..</option>';
		foreach ($data as $key => $value) {
			$tampung[] = '<option value="'.$value['SUBINV'].'">'.$value['SUBINV'].' - '.$value['DESCRIPTION'].'</option>';
		}
		if (empty($tampung)) $tampung = [];
		echo json_encode(implode('', $tampung));
	}

	public function get_recipe($value='')
	{
		$data = $this->M_selep->get_recipe($this->input->post('component_code'));
		echo json_encode(!empty($data)?$data:'gada');
	}

	public function buildSelepDataTable()
	{
		$post = $this->input->post();

		foreach ($post['columns'] as $val) {
			$post['search'][$val['data']]['value'] = $val['search']['value'];
		}

		$countall = $this->M_selep->countAllSelep()['count'];
		$countfilter = $this->M_selep->countFilteredSelep($post)['count'];

		$post['pagination']['from'] = $post['start'] + 1;
		$post['pagination']['to'] = $post['start'] + $post['length'];

		$protodata = $this->M_selep->selectSelep($post);

		$data = [];
		foreach ($protodata as $row) {
			if (!empty($row['batch_no'])) {
				$cetak_kib = '<a style="margin-right:4px" href="http://erp.quick.com/ManufacturingOperationUP2L/CreateKIB/pdf/1/'.$row['batch_no'].'/0"  title="Cetak KIB" target="_blank"><span class="fa fa-file-pdf-o fa-2x"></span></a>';
			}else {
				$cetak_kib = '';
			}
			$sub_array = [];
			$sub_array[] = '<center>'.$row['pagination'].'</center>';
			$sub_array[] = '<center>
											'.$cetak_kib.'
											<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Selep/read/'.$row['selep_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
											<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Selep/edit/'.$row['selep_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
											<a href="'.base_url('ManufacturingOperationUP2L/Selep/delete/'.$row['selep_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm(\'Are you sure you want to delete this item?\');"><span class="fa fa-trash fa-2x"></span></a>
										</center>';
			$sub_array[] = '<center>'.$row['selep_date'].'</center>';
			$sub_array[] = '<center>'.$row['batch_no'].'</center>';
			$sub_array[] = '<center>'.$row['component_code'].'</center>';
			$sub_array[] = '<center>'.$row['component_description'].'</center>';
			$sub_array[] = '<center>'.$row['selep_quantity'].'</center>';
			$sub_array[] = '<center>'.$row['scrap_quantity'].'</center>';
			$sub_array[] = '<center>'.$row['shift'].'</center>';
			$sub_array[] = '<center>'.$row['job_id'].'</center>';

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

	public function view_create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// $data['io'] = $this->M_selep->get_io();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_create', $data);
		$this->load->view('V_Footer', $data);
	}
	public function create()
	{
		$emp = $this->input->post('txt_employee[]');
		$employee	= '';

		for ($i = 0; $i < sizeof($emp); $i++) {
			if ($i == 0) {
				$employee = substr($emp[$i], 0, 5);
			} else {
				$employee .= "," . substr($emp[$i], 0, 5);
			}
		}
		$selepData = array();
		$aksen1 = 0;
		foreach ($this->input->post('txtSelepQuantityHeader[]') as $a) {
			$selepData[$aksen1]['selep_quantity'] = $a;
			$aksen1++;
		}

		$aksen2 = 0;
		$date_nya = explode(' ', $this->input->post('txtSelepDateHeader'));
		foreach ($this->input->post('component_code[]') as $b) {
			$pec = explode(' | ', $b);
			$selepData[$aksen2]['component_code'] = trim($pec[0]);
			$selepData[$aksen2]['component_description'] = trim($pec[1]);
			$selepData[$aksen2]['kode_proses'] = trim($pec[2]);
			$selepData[$aksen2]['selep_date'] = $date_nya[0];
			$selepData[$aksen2]['shift'] = $this->input->post('txtShift');
			$selepData[$aksen2]['scrap_quantity'] = '0';
			$selepData[$aksen2]['job_id'] = $employee;
			$selepData[$aksen2]['ket_pengurangan'] = $this->input->post('txtKeteranganPemotonganTarget');
			if ($selepData[$aksen2]['ket_pengurangan'] != '') {
				$selepData[$aksen2]['jam_pengurangan'] = $this->input->post('txtJamPemotonganTarget');
			} else {
				$selepData[$aksen2]['jam_pengurangan'] = '';
			}
			$selepData[$aksen2]['batch_no'] = $this->input->post('txtSelepBatchHeader');
			// $selepData[$aksen2]['jam_pengurangan'] = $this->input->post('txtJamPemotonganTarget');
			$aksen2++;
		}

		$aksen3 = 0;
		foreach ($this->input->post('txtKeterangan[]') as $c) {
			$selepData[$aksen3]['keterangan'] = $c;
			$aksen3++;
		}

		foreach ($selepData as $se) {
			$this->M_selep->setSelep($se);
		}

		echo json_encode('done');

		//// redirect(site_url('ManufacturingOperationUP2L/Selep/view_create'));
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['id'] = $id;
		$data['Selep'] = $this->M_selep->getSelepById($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_update', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update($id)
	{
		$component = explode(' | ', $this->input->post('cmbComponentCodeHeader', TRUE));
		$data = array(
			'component_code'		=> $component[0],
			'component_description' => $component[1],
			'kode_proses'			=> $component[2],
			'selep_date' => $this->input->post('txtSelepDateHeader', TRUE),
			'selep_quantity' => $this->input->post('txtSelepQuantityHeader', TRUE),
			'job_id' => $this->input->post('txtJobIdHeader', TRUE),
			'keterangan' => $this->input->post('txtKeterangan', TRUE),
			'shift' => $this->input->post('txtShift', TRUE),
		);

		$this->M_selep->updateSelep($data, $id);
		redirect(site_url('ManufacturingOperationUP2L/Selep'));
	}

	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['id'] = $id;
		$data['Selep'] = $this->M_selep->getSelepById($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_read', $data);
		$this->load->view('V_Footer', $data);
	}

	public function delete($id)
	{
		$this->M_selep->deleteSelep($id);
		redirect(site_url('ManufacturingOperationUP2L/Selep'));
	}

	public function delete2($id)
	{
		$this->M_selep->deleteSelep($id);
		redirect(base_url('ManufacturingOperationUP2L/QualityControl'));
	}
}
