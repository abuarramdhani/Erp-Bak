<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_OperationSetup extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('FlowProcessDestination/M_operationsetup');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}


	public function viewOperation()
	{
		$component_id = $this->input->post('component_id');
		$data['operation'] = $this->M_operationsetup->getOperation($component_id);
		foreach ($data['operation'] as $key => $value) {
			$data['operation'][$key]['tool_name'] = '';
			$data['operation'][$key]['tool_nomor'] = '';
			$data['operation'][$key]['tool'] = '';
			$data['operation'][$key]['measurement_tool_name'] = '';
			if ($value['measurement_tool_id']) {
				$data['operation'][$key]['measurement_tool_name'] = $this->M_operationsetup->getToolName($value['measurement_tool_id']);
			}
			if ($value['tool_id']) {
				$newarr = explode('>>', $value['tool_id']);
				if (count($newarr) > 1) {
					$nomor_tool = $newarr[1];
					$data['operation'][$key]['tool_name'] = $this->M_operationsetup->getToolName($nomor_tool);
					$data['operation'][$key]['tool_nomor'] = $nomor_tool;

				}
					$tool = $newarr[0];
					$data['operation'][$key]['tool'] = $tool;
			}
		}
		$data['component_id'] = $component_id;
		$this->load->view('FlowProcessDestination/MainMenu/OperationSetup/V_ViewOperation',$data);
	}

	public function setupOperation()
	{
		$component_id = $this->input->post('component_id');
		$data['component_id'] = $component_id;
		$data['process'] = $this->M_operationsetup->getProcess();
		$this->load->view('FlowProcessDestination/MainMenu/OperationSetup/V_AddOperation',$data);
	}


	public function getTool()
	{
		$param = $this->input->post('term');
		$param = strtoupper($param);
		$dataTool = $this->M_operationsetup->getTool($param);
		echo json_encode($dataTool);
	}

	public function saveOperation()
	{
		$da = $this->input->post('txtDateACtive');
		// if (empty($eda)){
		// 		$da = 'NULL';
		// 		$tl= '';
		// } else {
		// 	$tl = 'end_date_active,';
		// 	$da = $eda;
		// }
		
    	$sn = $this->input->post('txtSeqNumber');
    	$pl = $this->input->post('slcPlanning');
    	$op = $this->input->post('slcOperationProcess');
    	$pd = $this->input->post('txtProcessDetail');
    	$mmr = $this->input->post('txtMachineMinReq');
    	$pt = $this->input->post('slcPlanningTool');
    	$t = $this->input->post('slcTool');
    	$te = $this->input->post('slcToolExist');
    	$pmt = $this->input->post('slcPlannigMeasurementTool');
    	$mt = $this->input->post('slcMeasurementTool');
    	$oc = $this->input->post('txtOracleCode');
    	$od = $this->input->post('txtOracleDesc');
    	$uloc = $this->input->post('txtUpperLvlOracleCode');
    	$ulod = $this->input->post('txtUpperLvlOracleDesc');
    	$osn = $this->input->post('txtOracleSeqNumber');
    	$ort = $this->input->post('slcOraResourceType');
    	$ci = $this->input->post('componentId');
    	$component_id = $this->input->post('componentId');
    	$date_now = date('Y-m-d H:i:s');
    	$user_id = $this->session->userid;
		$ti= $t.'>>'.$te;
		if (empty($da)) {
			
			$data = array(
				'component_id' => $ci,
				'creation_date' => $date_now ,
				'created_by' => $user_id,
				'start_date_active' => $date_now,
				'end_date_active' => null,
				'operation_seq_num' => $sn,
				'planning_make_buy' => $pl,
				'operation_process' => $op,
				'operation_process_detail' => $pd,
				'machine_min_requirement' => $mmr,
				'planning_tool' => $pt,
				'tool_id' => $t.'>>'.$te,
				'planning_measurement_tool' => $pmt,
				'measurement_tool_id' => $mt,
				'oracle_code' => $oc,
				'oracle_description' => $od, 
				'upper_lvl_oracle_code' => $uloc,
				'upper_lvl_oracle_desc' => $ulod,
				'oracle_operation_seq_num' => $osn,
				'oracle_resource_type' => $ort
			);
			// echo "pre";
			// print_r($_FILES);
			// exit;
			$saveAndGetId = $this->M_operationsetup->saveOperation($data);
			// $saveAndGetId = $this->M_operationsetup->saveOperation($ci,$date_now ,$user_id,$date_now,$da,$sn,$pl,$op,$pd,$mmr,$pt,$ti,
			// $pmt,$mt,$oc,$od, $uloc,$ulod,$osn,$ort,$tl);
			$idOperation = $saveAndGetId;

		} else {
			$data = array(
				'component_id' => $ci,
				'creation_date' => $date_now ,
				'created_by' => $user_id,
				'start_date_active' => $date_now,
				'end_date_active' => $da,
				'operation_seq_num' => $sn,
				'planning_make_buy' => $pl,
				'operation_process' => $op,
				'operation_process_detail' => $pd,
				'machine_min_requirement' => $mmr,
				'planning_tool' => $pt,
				'tool_id' => $t.'>>'.$te,
				'planning_measurement_tool' => $pmt,
				'measurement_tool_id' => $mt,
				'oracle_code' => $oc,
				'oracle_description' => $od, 
				'upper_lvl_oracle_code' => $uloc,
				'upper_lvl_oracle_desc' => $ulod,
				'oracle_operation_seq_num' => $osn,
				'oracle_resource_type' => $ort
			);
			// echo "pre";
			// print_r($_FILES);
			// exit;
			$saveAndGetId = $this->M_operationsetup->saveOperation($data);
			// $saveAndGetId = $this->M_operationsetup->saveOperation($ci,$date_now ,$user_id,$date_now,$sn,$pl,$op,$pd,$mmr,$pt,$ti,
			// $pmt,$mt,$oc,$od, $uloc,$ulod,$osn,$ort,$tl);
			$idOperation = $saveAndGetId;
		}
		
    	// $data = array(
    	// 	'component_id' => $ci,
		// 	'creation_date' => $date_now ,
		// 	'created_by' => $user_id,
		// 	'start_date_active' => $date_now,
		// 	'end_date_active' => $da,
		// 	'operation_seq_num' => $sn,
		// 	'planning_make_buy' => $pl,
		// 	'operation_process' => $op,
		// 	'operation_process_detail' => $pd,
		// 	'machine_min_requirement' => $mmr,
		// 	'planning_tool' => $pt,
		// 	'tool_id' => $t.'>>'.$te,
		// 	'planning_measurement_tool' => $pmt,
		// 	'measurement_tool_id' => $mt,
		// 	'oracle_code' => $oc,
		// 	'oracle_description' => $od, 
		// 	'upper_lvl_oracle_code' => $uloc,
		// 	'upper_lvl_oracle_desc' => $ulod,
		// 	'oracle_operation_seq_num' => $osn,
		// 	'oracle_resource_type' => $ort
    	// );
		// // echo "pre";
		// // print_r($_FILES);
		// // exit;
    	// // $saveAndGetId = $this->M_operationsetup->saveOperation($data);
    	// $saveAndGetId = $this->M_operationsetup->saveOperation($ci,$date_now ,$user_id,$date_now,$da,$sn,$pl,$op,$pd,$mmr,$pt,$ti,
		// $pmt,$mt,$oc,$od, $uloc,$ulod,$osn,$ort,$tl);
    	// $idOperation = $saveAndGetId;

		// exit();
    	$data2= array();
    	// if ($_FILES) {
    	// 	if (file_exists($_FILES['fileProcessSheet']['tmp_name']) || is_uploaded_file($_FILES['fileProcessSheet']['tmp_name'])) {
		// 		$ext = explode('.', $_FILES['fileProcessSheet']['name']);
		// 		$file_process_sheet = 'process_sheet'.$idOperation.'.'.$ext[1];
		//         $config['upload_path']          = './assets/upload_flow_process/operation/process_sheet';
		//         $config['allowed_types']        = 'gif|jpg|png|pdf';
		//         $config['file_name']			= 'process_sheet'.$idOperation;

		//         $this->load->library('upload', $config,'upd_process_sheet');

		//         if (!$this->upd_process_sheet->do_upload('fileProcessSheet'))
		//         {
		//                 $error = array('error' => $this->upload->display_errors());
		//                 print_r($error);
		//                 die();
		//         }

		//         $data2['process_sheet_doc'] = $file_process_sheet;
		// 	}
		// 	if (file_exists($_FILES['fileQCPC']['tmp_name']) || is_uploaded_file($_FILES['fileQCPC']['tmp_name'])) {
		// 		$ext = explode('.', $_FILES['fileQCPC']['name']);
		// 		$file_qcpc = 'qcpc'.$idOperation.'.'.$ext[1];
		//         $config['upload_path']          = './assets/upload_flow_process/operation/qcpc';
		//         $config['allowed_types']        = 'gif|jpg|png|pdf';
		//         $config['file_name']			= 'qcpc'.$idOperation;

		//         $this->load->library('upload', $config,'upd_qcpc');

		//         if (!$this->upd_qcpc->do_upload('fileQCPC'))
		//         {
		//                 $error = array('error' => $this->upload->display_errors());
		//                 print_r($error);
		//                 die();
		//         }
		//         $data2['qcpc_doc'] = $file_qcpc;
		// 	}
		// 	if (file_exists($_FILES['filCBO']['tmp_name']) || is_uploaded_file($_FILES['filCBO']['tmp_name'])) {
		// 		$ext = explode('.', $_FILES['filCBO']['name']);
		// 		$file_cbo = 'cbo'.$idOperation.'.'.$ext[1];
		//         $config['upload_path']          = './assets/upload_flow_process/operation/cbo';
		//         $config['allowed_types']        = 'gif|jpg|png|pdf';
		//         $config['file_name']			= 'cbo'.$idOperation;

		//         $this->load->library('upload', $config,'upd_cbo');

		//         if (!$this->upd_cbo->do_upload('filCBO'))
		//         {
		//                 $error = array('error' => $this->upload->display_errors());
		//                 print_r($error);
		//                 die();
		//         }
		//         $data2['cbo_doc'] = $file_cbo;
		// 	}
    	// }

    	// if ($data2) {
    	// 	$this->M_operationsetup->updateFileOperation($idOperation,$data2);
		// }
		$component_id = $this->input->post('component_id');
		$data['component_id'] = $component_id;
		$data['process'] = $this->M_operationsetup->getProcess();
		$this->load->view('FlowProcessDestination/MainMenu/OperationSetup/V_AddOperation',$data);
		// $component_id = $this->input->post('component_id');
		// $data['operation'] = $this->M_operationsetup->getOperation2($component_id);
		// $data['component_id'] = $component_id;
		// $load = $this->load->view('FlowProcessDestination/MainMenu/OperationSetup/V_ViewOperation',$data);
		// $status= 'sampai sini udah bisa';
    	// redirect(base_url('FlowProcess/ProductSearch'));

	}

	public function deleteOperation()
	{
		$operation_id = $this->input->post('operation_id');
		$operation_id = explode(',', $operation_id);
		foreach ($operation_id as $key => $value) {
			$dataOpera = $this->M_operationsetup->getOperationById($value);
			foreach ($dataOpera as $keyOpr => $valOpr) {
				if ($valOpr['process_sheet_doc']) {
					$linkgmb = './assets/upload_flow_process/operation/process_sheet/'.$valOpr['process_sheet_doc'];
					if (is_file($linkgmb)) {
						unlink($linkgmb);
					}
				}
				if ($valOpr['qcpc_doc']) {
					$linkgmb = './assets/upload_flow_process/operation/qcpc/'.$valOpr['qcpc_doc'];
					if (is_file($linkgmb)) {
						unlink($linkgmb);
					}
				}
				if ($valOpr['cbo_doc']) {
					$linkgmb = './assets/upload_flow_process/operation/cbo/'.$valOpr['cbo_doc'];
					if (is_file($linkgmb)) {
						unlink($linkgmb);
					}
				}
			}
			$this->M_operationsetup->deleteOperation($value);
		}

		$component_id = $this->input->post('component_id');
		$data['operation'] = $this->M_operationsetup->getOperation($component_id);
		$data['component_id'] = $component_id;
		$this->load->view('FlowProcessDestination/MainMenu/OperationSetup/V_ViewOperation',$data);
	}

	public function editOperation()
	{
		$component_id = $this->input->post('component_id');
		$operation_id = $this->input->post('operation_id');
		$data['operation'] = $this->M_operationsetup->getDataOperation($operation_id,$component_id);
		$data['component_id'] = $component_id;
		$data['process'] = $this->M_operationsetup->getProcess();
		$data['operation_id'] = $operation_id;
		// echo "<pre>";
		foreach ($data['operation'] as $key => $value) {
			if ($value['measurement_tool_id']) {
				$data['operation'][0]['measurement_tool_name'] = '' ;
				$data['operation'][0]['measurement_tool_name'] = $this->M_operationsetup->getToolName($value['measurement_tool_id']);
			}
			if ($value['tool_id']) {
				$newarr = explode('>>', $value['tool_id']);
				if (count($newarr) > 1) {
					$nomor_tool = $newarr[1];
					$data['operation'][0]['tool_name'] = '';
					$data['operation'][0]['tool_nomor'] = '';
					$data['operation'][0]['tool_name'] = $this->M_operationsetup->getToolName($nomor_tool);
					$data['operation'][0]['tool_nomor'] = $nomor_tool;

				}
					$tool = $newarr[0];
					$data['operation'][0]['tool'] = '';
					$data['operation'][0]['tool'] = $tool;
			}
		}

		$this->load->view('FlowProcessDestination/MainMenu/OperationSetup/V_EditOperation',$data);
	}

	public function deleteFIleGambar()
	{
		$user_id = $this->session->userid;
		$operation_id = $this->input->post('param_id');
		$file_gambar = $this->input->post('file_gambar');
		$type =  $this->input->post('type');
		$last_edit_date = date('Y-m-d H:i:s');
		$last_edit_by = $this->session->userid;
		switch ($type) {
			case '1':
				$folder = 'process_sheet';
				$kolom = 'process_sheet_doc';
				break;
			case '2':
				$folder = 'qcpc';
				$kolom = 'qcpc_doc';
				break;
			case '3':
				$folder = 'cbo';
				$kolom = 'cbo_doc';
				break;
		}
		if ($file_gambar) {
			$linkgmb = './assets/upload_flow_process/operation/'.$folder.'/'.$file_gambar;
			if (is_file($linkgmb)) {
				unlink($linkgmb);
			}
			$data =array(
					'last_update_date' => $last_edit_date,
					'last_update_by' => $last_edit_by,
					$kolom => null
				);
			$this->M_operationsetup->deleteFIleGambar($operation_id,$data);
		}
	}

	public function saveEditOperation()
	{
		$da = $this->input->post('txtDateACtive');
    	$sn = $this->input->post('txtSeqNumber');
    	$pl = $this->input->post('slcPlanning');
    	$op = $this->input->post('slcOperationProcess');
    	$pd = $this->input->post('txtProcessDetail');
    	$mmr = $this->input->post('txtMachineMinReq');
    	$pt = $this->input->post('slcPlanningTool');
    	$t = $this->input->post('slcTool');
    	$te = $this->input->post('slcToolExist');
    	$pmt = $this->input->post('slcPlannigMeasurementTool');
    	$mt = $this->input->post('slcMeasurementTool');
    	$oc = $this->input->post('txtOracleCode');
    	$od = $this->input->post('txtOracleDesc');
    	$uloc = $this->input->post('txtUpperLvlOracleCode');
    	$ulod = $this->input->post('txtUpperLvlOracleDesc');
    	$osn = $this->input->post('txtOracleSeqNumber');
    	$ort = $this->input->post('slcOraResourceType');
    	$date_now = date('Y-m-d H:i:s');
    	$user_id = $this->session->userid;
    	$operation_id = $this->input->post('operationId');

    	$data = array(
	    		'last_update_date' => $date_now,
				'last_update_by' => $user_id,
				'end_date_active' => ($da) ? date('Y-m-d',strtotime($da)) : '',
				'operation_seq_num' => $sn,
				'planning_make_buy' => $pl,
				'operation_process' => $op,
				'operation_process_detail' => $pd,
				'machine_min_requirement' => $mmr,
				'planning_tool' => $pt,
				'tool_id' => $t.'>>'.$te,
				'planning_measurement_tool' => $pmt,
				'measurement_tool_id' => $mt,
				'oracle_code' => $oc,
				'oracle_description' => $od, 
				'upper_lvl_oracle_code' => $uloc,
				'upper_lvl_oracle_desc' => $ulod,
				'oracle_operation_seq_num' => $osn,
				'oracle_resource_type' => $ort
	    	);


    	if ($_FILES) {
    		if (file_exists($_FILES['fileProcessSheet']['tmp_name']) || is_uploaded_file($_FILES['fileProcessSheet']['tmp_name'])) {
				$ext = explode('.', $_FILES['fileProcessSheet']['name']);
				$file_process_sheet = 'process_sheet'.$operation_id.'.'.$ext[1];
		        $config['upload_path']          = './assets/upload_flow_process/operation/process_sheet';
		        $config['allowed_types']        = 'gif|jpg|png|pdf';
		        $config['file_name']			= 'process_sheet'.$operation_id;

		        $linkgmb = './assets/upload_flow_process/operation/process_sheet/'.$file_process_sheet;
				if (is_file($linkgmb)) {
					unlink($linkgmb);
				}

		        $this->load->library('upload', $config,'upd_process_sheet');

		        if (!$this->upd_process_sheet->do_upload('fileProcessSheet'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print_r($error);
		                die();
		        }

		        $data['process_sheet_doc'] = $file_process_sheet;
			}
			if (file_exists($_FILES['fileQCPC']['tmp_name']) || is_uploaded_file($_FILES['fileQCPC']['tmp_name'])) {
				$ext = explode('.', $_FILES['fileQCPC']['name']);
				$file_qcpc = 'qcpc'.$operation_id.'.'.$ext[1];
		        $config['upload_path']          = './assets/upload_flow_process/operation/qcpc';
		        $config['allowed_types']        = 'gif|jpg|png|pdf';
		        $config['file_name']			= 'qcpc'.$operation_id;

		        $linkgmb = './assets/upload_flow_process/operation/qcpc/'.$file_qcpc;
				if (is_file($linkgmb)) {
					unlink($linkgmb);
				}

		        $this->load->library('upload', $config,'upd_qcpc');

		        if (!$this->upd_qcpc->do_upload('fileQCPC'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print_r($error);
		                die();
		        }
		        $data['qcpc_doc'] = $file_qcpc;
			}
			if (file_exists($_FILES['filCBO']['tmp_name']) || is_uploaded_file($_FILES['filCBO']['tmp_name'])) {
				$ext = explode('.', $_FILES['filCBO']['name']);
				$file_cbo = 'cbo'.$operation_id.'.'.$ext[1];
		        $config['upload_path']          = './assets/upload_flow_process/operation/cbo';
		        $config['allowed_types']        = 'gif|jpg|png|pdf';
		        $config['file_name']			= 'cbo'.$operation_id;

		        $linkgmb = './assets/upload_flow_process/operation/cbo/'.$file_cbo;
				if (is_file($linkgmb)) {
					unlink($linkgmb);
				}

		        $this->load->library('upload', $config,'upd_cbo');

		        if (!$this->upd_cbo->do_upload('filCBO'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print_r($error);
		                die();
		        }
		        $data['cbo_doc'] = $file_cbo;
			}
    	}
    	$this->M_operationsetup->saveEditOperation($operation_id,$data);
    	redirect(base_url('FlowProcess/ProductSearch'));

	}

	public function getInfoTool()
	{
		$nomor_tool = $this->input->post('nomor');
		$data = $this->M_operationsetup->getInfoTool($nomor_tool);
		if ($data) {
			$status_proses = '';
			if(($data[0]['fb_cancel'] != '1') && ($data[0]['fb_pending'] != '1')){
				if (($data[0]['fs_status'] == 'PPC TM')) {
							$status_proses = 'Sudah Terdaftar';
				}elseif (($data[0]['fd_tgl_tmd'] != '9999-01-01')
						&& ($data[0]['fd_tgl_backtmc'] == '9999-01-01')) {
							$status_proses = 'WIP DESIGN';
				}elseif (($data[0]['fd_tgl_tmd'] != '9999-01-01')
						&& ($data[0]['fd_tgl_backtmc'] != '9999-01-01') 
						&& ($data[0]['fd_tgl_order'] != '9999-01-01') 
						&& ($data[0]['fd_tgl_mach'] != '9999-01-01')
						&& ($data[0]['fd_tgl_real'] == '9999-01-01')) {
							$status_proses = 'FINISH DESIGN';
				}elseif (($data[0]['fd_tgl_real'] != '9999-01-01')
						&& ($data[0]['fd_tgl_trial'] != '9999-01-01') 
						&& ($data[0]['fd_tgl_ptr'] == '9999-01-01') 
						&& ($data[0]['fd_tgl_kirim'] == '9999-01-01')
						&& ($data[0]['fd_tgl_backtmc'] != '9999-01-01')) {
							$status_proses = 'WIP TRIAL';
				}elseif (($data[0]['fd_tgl_kirim'] != '9999-01-01')
						&& ($data[0]['fd_tgl_ptr'] != '9999-01-01') 
						&& ($data[0]['fd_tgl_backtmc'] != '9999-01-01') 
						&& ($data[0]['fd_tgl_real'] != '9999-01-01')){
							$status_proses = 'FINISH ALL';
				}
			}elseif(($data[0]['fb_cancel'] != '1')){
				$status_proses = 'Canceled';
			}elseif ($data[0]['fb_pending']) {
				$status_proses = 'Pending';
			}
				echo "<table class='table table-hovered table-striped'>
						<thead>
							<tr>
								<th>Nomor Order</th>
								<th>Tool Code</th>
								<th>Tool Name</th>
								<th>Component Code</th>
								<th>Component Name</th>
								<th>Type</th>
								<th>Status Tool</th>
								<th>Status Process</th>
							</tr>
						</thead>
						<tbody>";
			foreach ($data as $key => $value) {
				echo "<tr>";
					echo "<td>".$value['fs_no_order']."</td>";
					echo "<td>".$value['fs_no_tool']."</td>";
					echo "<td>".$value['fs_no_order']."</td>";
					echo "<td>".$value['fs_kd_komp']."</td>";
					echo "<td>".$value['fs_nm_komp']."</td>";
					echo "<td>".$value['fs_type']."</td>";
					echo "<td>".$value['fs_status_alat']."</td>";
					echo "<td> $status_proses </td>";
				echo "</tr>";
			}
				echo "</tbody></table>";
		}
	}




}