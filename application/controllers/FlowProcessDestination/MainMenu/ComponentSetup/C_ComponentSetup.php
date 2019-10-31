<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_ComponentSetup extends CI_Controller
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
			$this->load->model('FlowProcessDestination/M_componentsetup');
			// $this->load->model('FlowProcessDestination/M_productsearch');
			  
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


	public function saveComponent() {
			$user_id = $this->session->userid;
			$d_group = $this->input->post('txtDrawingGroup');
			$d_code = $this->input->post('txtDrawingCode');
			$d_desc = $this->input->post('txtDrawingDesc');
			$rev = $this->input->post('txtRev');
			$d_date = $this->input->post('dateDrawingDate');
			$d_material = $this->input->post('txtDrawingMaterial');
			$d_status = $this->input->post('slcDrawingStatus');
			$d_upperCode = $this->input->post('txtUpperLevelCode');
			$d_upperDesc = $this->input->post('txtUpperLevelDesc');
			$c_status = $this->input->post('slcStatusComponent');
			$d_oldCode = $this->input->post('txtOldDrawingCode');
			$c_changingRef = $this->input->post('txtChangingRefDoc');
			$c_changingExpl = $this->input->post('txtChangingExpl');
			$c_changingDue = $this->input->post('dateChangingDueDate');
			$c_qty = $this->input->post('qtyComponent');
			$product_id = $this->input->post('productId');
			$weight = $this->input->post('weightComponent');
			$start_date = date('Y-m-d');
			$date_now = date('Y-m-d H:i:s');
			$file_change_ref_name = '';
			$file_gambar_unit_name = '';
			$file_document = '';

			// echo"<pre>";
			// print_r($_POST);
			// exit;

			if($_FILES) {
				// if (file_exists($_FILES['fileChangingRefDoc']['tmp_name']) || is_uploaded_file($_FILES['fileChangingRefDoc']['tmp_name'])) {
				// 	$ext = explode('.', $_FILES['fileChangingRefDoc']['name']);
				// 	$file_change_ref_name = $d_code.'.'.$ext[1];
			  //       $config['upload_path']          = './assets/upload_flow_process/component/changing_ref';
			  //       $config['allowed_types']        = 'gif|jpg|png|pdf';
			  //       $config['file_name']			= $d_code;

			  //       $this->load->library('upload', $config,'upd_changingref');

			  //       if (!$this->upd_changingref->do_upload('fileChangingRefDoc'))
			  //       {
			  //               $error = array('error' => $this->upload->display_errors());
			  //               print_r($error);
			  //               die();
			  //       }
				// }
				if (file_exists($_FILES['fileGambarUnit']['tmp_name']) || is_uploaded_file($_FILES['fileGambarUnit']['tmp_name'])) {
					$ext = explode('.', $_FILES['fileGambarUnit']['name']);
					$file_gambar_unit_name = $d_code.'.'.$ext[1];
			        $config['upload_path']          = './assets/upload_flow_process/component/gambar_unit';
			        $config['allowed_types']        = 'gif|jpg|png|pdf';
			        $config['file_name']			= $d_code;

			        $this->load->library('upload', $config,'upd_gambarunit');

			        if (!$this->upd_gambarunit->do_upload('fileGambarUnit'))
			        {
			                $error = array('error' => $this->upload->display_errors());
			                print_r($error);
			                die();
			        }
				}
				if (file_exists($_FILES['fileDocument']['tmp_name']) || is_uploaded_file($_FILES['fileDocument']['tmp_name'])) {
					$ext = explode('.', $_FILES['fileDocument']['name']);
					$file_document = 'document'.$d_code.'.'.$ext[1];
							$config['upload_path']          = './assets/upload_flow_process/component/dokumen';
							$config['allowed_types']        = 'gif|jpg|png|pdf';
							$config['file_name']			= 'document'.$d_code;
	
							$this->load->library('upload', $config,'upd_document');
	
							if (!$this->upd_document->do_upload('fileDocument'))
							{
											$error = array('error' => $this->upload->display_errors());
											print_r($error);
											die();
							}
	
							// $data2['process_sheet_doc'] = $file_process_sheet;
				}

				// if (file_exists($_FILES['fileProcessSheet']['tmp_name']) || is_uploaded_file($_FILES['fileProcessSheet']['tmp_name'])) {
				// 	$ext = explode('.', $_FILES['fileProcessSheet']['name']);
				// 	$file_process_sheet = 'process_sheet'.$d_code.'.'.$ext[1];
				// 			$config['upload_path']          = './assets/upload_flow_process/operation/process_sheet';
				// 			$config['allowed_types']        = 'gif|jpg|png|pdf';
				// 			$config['file_name']			= 'process_sheet'.$d_code;
	
				// 			$this->load->library('upload', $config,'upd_process_sheet');
	
				// 			if (!$this->upd_process_sheet->do_upload('fileProcessSheet'))
				// 			{
				// 							$error = array('error' => $this->upload->display_errors());
				// 							print_r($error);
				// 							die();
				// 			}
	
				// 			// $data2['process_sheet_doc'] = $file_process_sheet;
				// }
				// if (file_exists($_FILES['fileQCPC']['tmp_name']) || is_uploaded_file($_FILES['fileQCPC']['tmp_name'])) {
				// 	$ext = explode('.', $_FILES['fileQCPC']['name']);
				// 	$file_qcpc = 'qcpc'.$d_code.'.'.$ext[1];
				// 			$config['upload_path']          = './assets/upload_flow_process/operation/qcpc';
				// 			$config['allowed_types']        = 'gif|jpg|png|pdf';
				// 			$config['file_name']			= 'qcpc'.$d_code;
	
				// 			$this->load->library('upload', $config,'upd_qcpc');
	
				// 			if (!$this->upd_qcpc->do_upload('fileQCPC'))
				// 			{
				// 							$error = array('error' => $this->upload->display_errors());
				// 							print_r($error);
				// 							die();
				// 			}
				// 			// $data2['qcpc_doc'] = $file_qcpc;
				// }
				// if (file_exists($_FILES['filCBO']['tmp_name']) || is_uploaded_file($_FILES['filCBO']['tmp_name'])) {
				// 	$ext = explode('.', $_FILES['filCBO']['name']);
				// 	$file_cbo = 'cbo'.$d_code.'.'.$ext[1];
				// 			$config['upload_path']          = './assets/upload_flow_process/operation/cbo';
				// 			$config['allowed_types']        = 'gif|jpg|png|pdf';
				// 			$config['file_name']			= 'cbo'.$d_code;
	
				// 			$this->load->library('upload', $config,'upd_cbo');
	
				// 			if (!$this->upd_cbo->do_upload('filCBO'))
				// 			{
				// 							$error = array('error' => $this->upload->display_errors());
				// 							print_r($error);
				// 							die();
				// 			}
				// 			// $data2['cbo_doc'] = $file_cbo;
				// }
			}


			$dataComp = array(	'product_id' => $product_id,
							'creation_date' => $date_now,
							'created_by' => $user_id,
							'start_date_active' => $date_now,
							'drw_group' => $d_group,
							'drw_code' => $d_code,
							'drw_description' => $d_desc,
							'rev' => $rev,
							'drw_date' => $d_date ?: null,
							'drw_material' => $d_material,
							'drw_status' => $d_status,
							'drw_upper_level_code' => $d_upperCode,
							'drw_upper_level_desc' => $d_upperDesc,
							'component_status' => $c_status,
							'component_qty_per_unit' => $c_qty,
							'gambar_kerja' => $file_gambar_unit_name,
							'dokumen' => $file_document,
							// 'cbo_doc' => $file_cbo,
							// 'qcpc_doc' => $file_qcpc,
							// 'process_sheet_doc' => $file_process_sheet,
							'weight' => $weight,
							'old_drw_code' => $d_oldCode,
							'changing_ref_doc' => $c_changingRef,
							'changing_ref_expl' => $c_changingExpl,
							'changing_due_date' => $c_changingDue
						);
			// if ($c_status == '2') {
			// 	$dataComp['old_drw_code'] = $d_oldCode;
			// 	$dataComp['changing_ref_doc'] = $file_change_ref_name;
			// 	$dataComp['changing_ref_expl'] = $c_changingExpl;
			// 	$dataComp['changing_due_date'] = $c_changingDue ?: null;
			// }
			$this->M_componentsetup->saveComponent($dataComp);
			// $this->session->set_flashdata('response',"Komponen Telah Ditambahkan");
			// redirect(base_url('FlowProcess/ProductSearch'));


			$this->load->model('FlowProcessDestination/M_productsearch');
			$data['component'] = $this->M_productsearch->getComponent($product_id);
			$data['product_id'] = $product_id;
			$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_ViewComponent',$data);


			// echo("<script language='javascript' type='text/javascript'>
			// alert('Save Successfully');
			// </script>");

		// $productId = $this->input->post('productId');
		// $data['component'] = $this->M_componentsetup->getComponent($product_id);
		// $data['product_id'] = $productId;
		// $this->session->set_flashdata('response',"Komponen Telah Ditambahkan");
		
		// $this->checkSession();
		// $user_id = $this->session->userid;
		// $data['Menu'] = 'Dashboard';
		// $data['SubMenuOne'] = '';
		// $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		// $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		// $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_ViewComponent',$data);
		// $this->load->view('V_Footer',$data);
		}

	public function selectdrwcode() {
		$term = $this->input->post('term');
		$productId = $this->input->post('productId');
		// echo "<pre>";
		// print_r($productId);
		// exit();
		$data = $this->M_componentsetup->selectdrwcode(strtoupper($term), $productId);
		// echo "<pre>";
		// print_r($data);
		// exit();
		echo json_encode($data);
	}
	public function deleteComponent()
	{
		$this->load->model('FlowProcessDestination/M_productsearch');
		$this->load->model('FlowProcessDestination/M_operationsetup');
		$component_id = $this->input->post('component_id');
		$component_id = explode(',', $component_id);
		foreach ($component_id as $key => $value) {
			$dataComp = $this->M_componentsetup->getComponentById($value);
			foreach ($dataComp as $keyComp => $valComp) {
				if ($valComp['changing_ref_doc']) {
					$linkgmb = './assets/upload_flow_process/component/changing_ref/'.$valComp['changing_ref_doc'];
					if (is_file($linkgmb)) {
						unlink($linkgmb);
					}
				}
				if ($valComp['gambar_kerja']) {
					$linkgmb = './assets/upload_flow_process/component/gambar_unit/'.$valComp['gambar_kerja'];
					if (is_file($linkgmb)) {
						unlink($linkgmb);
					}
				}
			}
			$this->M_componentsetup->deleteComponent($value);

			//delete operation
			$getOperation = $this->M_operationsetup->getOperation($component_id);
			if($getOperation){
					foreach ($getOperation as $keyOpr => $valOpr) {
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
						$this->M_operationsetup->deleteOperation($valOpr['operation_id']);
					}
			}
		}
		$product_id = $this->input->post('product_id');
		$data['component'] = $this->M_productsearch->getComponent($product_id);
		$data['product_id'] = $product_id;
		$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_ViewComponent',$data);
	}

	public function InnactiveComponent()
	{
		$this->load->model('FlowProcessDestination/M_productsearch');
		$user_id = $this->session->userid;
		$component_id = $this->input->post('component_id');
		$component_status = 'N';
		$date_now = date('Y-m-d H:i:s');
		$date_end = date('Y-m-d');
		$dataComp = array('last_update_date' => $date_now,
							'last_update_by' => $user_id,
							'end_date_active' => $date_end,
							'component_status' => $component_status);
		$this->M_componentsetup->saveEditComponent($component_id,$dataComp);
		$product_id = $this->input->post('product_id');
		$data['component'] = $this->M_productsearch->getComponent($product_id);
		$data['product_id'] = $product_id;
		$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_ViewComponent',$data);
	}

	public function editComponent()
	{
		$product_id = $this->input->post('product_id');
		$component_id = $this->input->post('component_id');
		$data['component'] = $this->M_componentsetup->getDataComponent($product_id,$component_id);
		$data['product_id'] = $product_id;
		$data['component_id'] = $component_id;
		$this->load->view('FlowProcessDestination/MainMenu/ComponentSetup/V_EditComponent',$data);
	}

	 public function saveEditComponent()
	 {
	 	$user_id = $this->session->userid;
		$d_group = $this->input->post('txtDrawingGroup');
		// $d_code = $this->input->post('txtDrawingCode');
		$code = $this->input->post('txtDrawingCode');
		$code1 = $this->input->post('txtDrawingCode2');
		if ($code = $code1) {
			$d_code = $code;
		} else {
			$d_code = $code1;
		}
		$d_desc = $this->input->post('txtDrawingDesc');
		$rev = $this->input->post('txtRev');
		$d_date = $this->input->post('dateDrawingDate');
		$d_material = $this->input->post('txtDrawingMaterial');
		$weight = $this->input->post('txtWeight');
		$d_status = $this->input->post('slcDrawingStatus');
		$d_upperCode = $this->input->post('txtUpperLevelCode');
		$d_upperDesc = $this->input->post('txtUpperLevelDesc');
		$c_status = $this->input->post('slcStatusComponent');
		$d_oldCode = $this->input->post('txtOldDrawingCode');
		$c_changingRef = $this->input->post('txtChangingRefDoc');
		$c_changingExpl = $this->input->post('txtChangingExpl');
		$c_changingDue = $this->input->post('dateChangingDueDate');
		$c_qty = $this->input->post('qtyComponent');
		$product_id = $this->input->post('productId');
		$component_id = $this->input->post('componentId');
		$start_date = date('Y-m-d');
		$date_now = date('Y-m-d H:i:s');
		// $file_change_ref_name = '';
		$file_gambar_unit_name = '';
		$file1 = $file2 = 0;

		if($_FILES){
			// if (file_exists($_FILES['fileChangingRefDoc']['tmp_name']) || is_uploaded_file($_FILES['fileChangingRefDoc']['tmp_name'])) {

			// 	$ext = explode('.', $_FILES['fileChangingRefDoc']['name']);
			// 	$file_change_ref_name = $d_code.'.'.$ext[1];
		  //       $config['upload_path']          = './assets/upload_flow_process/component/changing_ref';
		  //       $config['allowed_types']        = 'gif|jpg|png|pdf';
		  //       $config['file_name']			= $d_code;

			// 	$linkgmb = './assets/upload_flow_process/component/changing_ref/'.$file_change_ref_name;
			// 	if (is_file($linkgmb)) {
			// 		unlink($linkgmb);
			// 	}

		  //       $this->load->library('upload', $config,'upd_changingref');

		  //       if (!$this->upd_changingref->do_upload('fileChangingRefDoc'))
		  //       {
		  //               $error = array('error' => $this->upload->display_errors());
		  //               print_r($error);
		  //               die();
		  //       }
		  //       $file1 = 1;
			// }
			if (file_exists($_FILES['fileGambarUnit']['tmp_name']) || is_uploaded_file($_FILES['fileGambarUnit']['tmp_name'])) {
				$ext = explode('.', $_FILES['fileGambarUnit']['name']);
				$file_gambar_unit_name = $d_code.'.'.$ext[1];
		        $config['upload_path']          = './assets/upload_flow_process/component/gambar_unit';
		        $config['allowed_types']        = 'gif|jpg|png|pdf';
		        $config['file_name']			= $d_code;

		        $linkgmb = './assets/upload_flow_process/component/gambar_unit/'.$file_gambar_unit_name;
				if (is_file($linkgmb)) {
					unlink($linkgmb);
				}

		        $this->load->library('upload', $config,'upd_gambarunit');

		        if (!$this->upd_gambarunit->do_upload('fileGambarUnit'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print_r($error);
		                die();
		        }
		        $file2 = 1;
			}

			if (file_exists($_FILES['fileDocument']['tmp_name']) || is_uploaded_file($_FILES['fileDocument']['tmp_name'])) {
				$ext = explode('.', $_FILES['fileDocument']['name']);
				$file_document = 'document'.$component_id.'.'.$ext[1];
		        $config['upload_path']          = './assets/upload_flow_process/component/dokumen';
		        $config['allowed_types']        = 'gif|jpg|png|pdf';
		        $config['file_name']			= 'document'.$component_id;

		        $this->load->library('upload', $config,'upd_document');

		        if (!$this->upd_document->do_upload('fileDocument'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print_r($error);
		                die();
		        }

		        // $data2['process_sheet_doc'] = $file_process_sheet;
			}

			// if (file_exists($_FILES['fileProcessSheet']['tmp_name']) || is_uploaded_file($_FILES['fileProcessSheet']['tmp_name'])) {
			// 	$ext = explode('.', $_FILES['fileProcessSheet']['name']);
			// 	$file_process_sheet = 'process_sheet'.$component_id.'.'.$ext[1];
		  //       $config['upload_path']          = './assets/upload_flow_process/operation/process_sheet';
		  //       $config['allowed_types']        = 'gif|jpg|png|pdf';
		  //       $config['file_name']			= 'process_sheet'.$component_id;

		  //       $this->load->library('upload', $config,'upd_process_sheet');

		  //       if (!$this->upd_process_sheet->do_upload('fileProcessSheet'))
		  //       {
		  //               $error = array('error' => $this->upload->display_errors());
		  //               print_r($error);
		  //               die();
		  //       }

		  //       // $data2['process_sheet_doc'] = $file_process_sheet;
			// }
			// if (file_exists($_FILES['fileQCPC']['tmp_name']) || is_uploaded_file($_FILES['fileQCPC']['tmp_name'])) {
			// 	$ext = explode('.', $_FILES['fileQCPC']['name']);
			// 	$file_qcpc = 'qcpc'.$component_id.'.'.$ext[1];
		  //       $config['upload_path']          = './assets/upload_flow_process/operation/qcpc';
		  //       $config['allowed_types']        = 'gif|jpg|png|pdf';
		  //       $config['file_name']			= 'qcpc'.$component_id;

		  //       $this->load->library('upload', $config,'upd_qcpc');

		  //       if (!$this->upd_qcpc->do_upload('fileQCPC'))
		  //       {
		  //               $error = array('error' => $this->upload->display_errors());
		  //               print_r($error);
		  //               die();
		  //       }
		  //       // $data2['qcpc_doc'] = $file_qcpc;
			// }
			// if (file_exists($_FILES['filCBO']['tmp_name']) || is_uploaded_file($_FILES['filCBO']['tmp_name'])) {
			// 	$ext = explode('.', $_FILES['filCBO']['name']);
			// 	$file_cbo = 'cbo'.$component_id.'.'.$ext[1];
		  //       $config['upload_path']          = './assets/upload_flow_process/operation/cbo';
		  //       $config['allowed_types']        = 'gif|jpg|png|pdf';
		  //       $config['file_name']			= 'cbo'.$component_id;

		  //       $this->load->library('upload', $config,'upd_cbo');

		  //       if (!$this->upd_cbo->do_upload('filCBO'))
		  //       {
		  //               $error = array('error' => $this->upload->display_errors());
		  //               print_r($error);
		  //               die();
		  //       }
		  //       // $data2['cbo_doc'] = $file_cbo;
			// }
		}


		$dataComp = array(	'product_id' => $product_id,
						'last_update_date' => $date_now,
						'last_update_by' => $user_id,
						'drw_group' => $d_group,
						'drw_code' => $d_code,
						'drw_description' => $d_desc,
						'rev' => $rev,
						'drw_date' => $d_date,
						'drw_material' => $d_material,
						'weight' => $weight,
						'drw_status' => $d_status,
						'drw_upper_level_code' => $d_upperCode,
						'drw_upper_level_desc' => $d_upperDesc,
						'component_status' => $c_status,
						'old_drw_code' => $d_oldCode,
						'component_qty_per_unit' => $c_qty);
		// if ($c_status == '2') {
		// 		$dataComp['old_drw_code'] = $d_oldCode;
		// 		$dataComp['changing_ref_expl'] = $c_changingExpl;
		// 		$dataComp['changing_due_date'] = $c_changingDue ?: null;
		// 	}
		// if ($file1 == 1) {
		// 	$dataComp['changing_ref_doc'] = $file_change_ref_name;
		// }
		if ($file2 == 1) {
			$dataComp['gambar_kerja'] = $file_gambar_unit_name;
			$dataComp['dokumen'] = $file_document;
			// $dataComp['process_sheet_doc'] = $file_process_sheet;
			// $dataComp['qcpc_doc'] = $file_qcpc;
			// $dataComp['cbo_doc'] = $file_cbo;
		}
		$this->M_componentsetup->saveEditComponent($component_id,$dataComp);
		redirect(base_url('FlowProcess/ProductSearch'));
	 }

	 public function deleteFIleGambar()
	 {
	 	$user_id = $this->session->userid;
		$component_id = $this->input->post('param_id');
		$file_gambar = $this->input->post('file_gambar');
		$type =  $this->input->post('type');
		$last_edit_date = date('Y-m-d H:i:s');
		$last_edit_by = $this->session->userid;
		$folder = ($type == '2') ? 'gambar_unit' : 'changing_ref' ;
		$kolom = ($type == '2') ? 'gambar_kerja' : 'changing_ref_doc' ;
		if ($file_gambar) {
			$linkgmb = './assets/upload_flow_process/component/'.$folder.'/'.$file_gambar;
			if (is_file($linkgmb)) {
				unlink($linkgmb);
			}
			$data =array(
					'last_update_date' => $last_edit_date,
					'last_update_by' => $last_edit_by,
					$kolom => null
				);
			$this->M_componentsetup->deleteFIleGambar($component_id,$data);
		}
	 }


	 public function uploadDataComponent()
	 {
	 	$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProcessDestination/MainMenu/ComponentSetup/V_Upload',$data);
			$this->load->view('V_Footer',$data);
	 }

	 public function ProcessUpload(){
	 	$this->load->library('Excel');
	 	if(isset($_FILES['file_upload']['name']) &&  $_FILES['file_upload']['name'] != ''):
			 $valid_extension = array('xls','xlsx','ods');
			 $file_data = explode('.', $_FILES['file_upload']['name']);
			 $file_extension = end($file_data);
			 $file_name = $file_data[0];
			 $array_error = array();
			 if(in_array($file_extension, $valid_extension))
			 {
			 	$excelReader 	= PHPExcel_IOFactory::createReaderForFile($_FILES['file_upload']['tmp_name']);
				$excelObj  		= $excelReader->load($_FILES['file_upload']['tmp_name']);
				$worksheet 		= $excelObj->getSheet(0);
				$lastRow 		= $worksheet->getHighestRow();
				$lastCol 		= $worksheet->getHighestColumn();
				$lastIndexCol 	= PHPExcel_Cell::columnIndexFromString($lastCol);

				for ($i=2; $i <= $lastRow ; $i++) { 
					if ($worksheet->getCell('A'.$i)->getValue() != '') {
						$hasilupload[$i]['product_id'] = $worksheet->getCell('A'.$i)->getValue();
						$hasilupload[$i]['created_by'] = $worksheet->getCell('B'.$i)->getValue();
						$hasilupload[$i]['creation_date'] = $worksheet->getCell('C'.$i)->getValue();
						$hasilupload[$i]['drw_group'] = $worksheet->getCell('D'.$i)->getValue();
						$hasilupload[$i]['drw_code'] = $worksheet->getCell('E'.$i)->getValue();
						$hasilupload[$i]['drw_description'] = $worksheet->getCell('F'.$i)->getValue();
						$hasilupload[$i]['drw_date'] = ($worksheet->getCell('G'.$i)->getValue() == 'null') ? null : date('Y-m-d',strtotime($worksheet->getCell('G'.$i)->getValue())) ;
						$hasilupload[$i]['drw_material'] = $worksheet->getCell('H'.$i)->getValue();
						$hasilupload[$i]['drw_status'] = $worksheet->getCell('I'.$i)->getValue();
						$hasilupload[$i]['component_qty_per_unit'] = $worksheet->getCell('J'.$i)->getValue() ?: null;
					}
				}
			 }
			 echo "<pre>";
			 print_r($hasilupload);
			 // exit();

			 $this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('FlowProcessDestination/MainMenu/ComponentSetup/V_Upload',$data);
				$this->load->view('V_Footer',$data);

			 // foreach ($hasilupload as $key => $value) {
			 // 	$this->M_componentsetup->saveComponent($value);
			 // }
		endif;
	 }
	 public function searchgroupbbg()
	 {
		 $product_component_code = $this->input->POST('product_component_code'); // Ambil data product_number yang dikirim lewat AJAX
		 $productId = $this->input->POST('productId');
		 echo '<pre>';
		   print_r($productId);
		   exit();
		 $data = $this->M_componentsetup->viewBy_drwgroupbbg($product_component_code);
		//  echo '<pre>';
		//    print_r($data);
		//    exit();
		 if( ! empty($data)){ // Jika data ada/ditemukan
		//    BUat sebuah array
		//    echo '<pre>';
		//    print_r($product_component_code);
		//    exit();
		   $callback = array(
			   'status' => 'success', // Set array status dengan success
			 //   'product_number' => $data['product_number'], // Set array product_number dengan isi kolom product_number pada tabel khs_fpd_data_gambar
			   'drw_code' => $data[0]['drw_code'], // Set array product_description dengan isi kolom product_description pada tabel khs_fpd_data_gambar
			   'drw_description' => $data[0]['drw_description'], // Set array status_product dengan isi kolom status_product pada tabel khs_fpd_data_gambar
			   'drw_date' => $data[0]['drw_date'], // Set array end_date_active dengan isi kolom end_date_active pada tabel khs_fpd_data_gambar
			   'drw_material' => $data[0]['drw_material'],
			   'drw_status' => $data[0]['drw_status'],
			   'drw_upper_level_code' => $data[0]['drw_upper_level_code'],
			   'drw_upper_level_desc' => $data[0]['drw_upper_level_desc'],
			   'component_status' => $data[0]['component_status'],
			   'component_qty_per_unit' => $data[0]['component_qty_per_unit'],
			   'qty' => $data[0]['qty'],
			//    'changing_ref_doc' => $data[0]['changing_ref_doc'],
			//    'changing_ref_expl' => $data[0]['changing_ref_expl'],
			//    'changing_due_date' => $data[0]['changing_due_date']
			);
		 }else{
			 $callback = array('status' => 'failed'); // set array status dengan failed
		 }
		 echo json_encode($callback); // konversi varibael $callback menjadi JSON
		 
	 }

	 public function searchdetail()
	 {
		 $drwcode = $this->input->POST('drwcode'); 
		 $productId = $this->input->POST('productId');
		 $componentchecking = $this->M_componentsetup->check_component($drwcode, $productId);
		 $data = $this->M_componentsetup->viewBy_drwcode($drwcode, $productId);
		 
		 if( ! empty($data) && empty($componentchecking)){
		   $callback = array(
				'status' => 'success', 
				'drw_group' => $data[0]['drw_group'],
				'drw_description' => $data[0]['drw_description'],
				'rev' => $data[0]['rev'],
				'statuscomponent' => $data[0]['status'],
			  'drw_date' => $data[0]['drw_date'], 
			  'drw_material' => $data[0]['drw_material'],
				'weight' => $data[0]['weight'],
				'changing_ref_doc' => $data[0]['changing_ref_doc'],
				'changing_ref_expl' => $data[0]['changing_ref_expl'],
				'drw_code' => $data[0]['drw_code']
			);
		 }else if( empty($data) && empty($componentchecking)){
				$callback = array('status' => 'empty'); 
		 }else{
				$callback = array('status' => 'failed');
		 }
		 echo json_encode($callback); 
		 
	 }

	 public function searchgroup3()
	 {
		 $product_component_code = $this->input->POST('product_component_code'); 
		 $productId = $this->input->POST('productId'); 
		 $data = $this->M_componentsetup->viewBy_drwgroup3($product_component_code, $productId);
		 if( ! empty($data)){ // Jika data ada/ditemukan
		//    BUat sebuah array
		   $callback = array(
			   'status' => 'success', // Set array status dengan success
			 //   'product_number' => $data['product_number'], // Set array product_number dengan isi kolom product_number pada tabel khs_fpd_data_gambar
			   'drw_code' => $data[0]['component_code'], // Set array product_description dengan isi kolom product_description pada tabel khs_fpd_data_gambar
			   'drw_description' => $data[0]['component_name'], // Set array status_product dengan isi kolom status_product pada tabel khs_fpd_data_gambar
			//    'rev' => $data[0]['rev']
			   'drw_date' => $data[0]['revision_date'], // Set array end_date_active dengan isi kolom end_date_active pada tabel khs_fpd_data_gambar
			   'drw_material' => $data[0]['material_type'],
			   'weight' => $data[0]['weight']
			//    'drw_upper_level_code' => $data[0]['drw_upper_level_code'],
			//    'drw_upper_level_desc' => $data[0]['drw_upper_level_desc'],
			//    'component_status' => $data[0]['component_status'],
			//    'component_qty_per_unit' => $data[0]['component_qty_per_unit'],
			//    'old_drw_code' => $data[0]['old_drw_code'],
			//    'changing_ref_doc' => $data[0]['changing_ref_doc'],
			//    'changing_ref_expl' => $data[0]['changing_ref_expl'],
			//    'changing_due_date' => $data[0]['changing_due_date']
			);
		 }else{
			 $callback = array('status' => 'failed'); // set array status dengan failed
		 }
		 echo json_encode($callback); // konversi varibael $callback menjadi JSON
		 
	 }
}
