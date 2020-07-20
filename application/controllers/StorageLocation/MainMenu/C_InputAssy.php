<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_InputAssy extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StorageLocation/MainMenu/M_inputcomponent');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}

	public function index($message = NULL, $showData = NULL)
	{
		$data = array (
			'message' => $message,
			'lastInsert' => $showData,
        );
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Input Data by Sub Assy';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/MainMenu/V_InputAssy',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$user 		= $this->session->userdata('user');
		$org_id 	= $this->input->post('IdOrganization');
		$sub_inv 	= $this->input->post('SlcSubInventori2');
		$assy 		= $this->input->post('SlcKodeAssy');
		$a 			= explode('|', $assy);
		$kode_assy 	= $a[0];
		$type_assy 	= $this->input->post('txtTypeAssy');
		$locator 	= $this->input->post('txtLocator');
		$kode_item 	= $this->input->post('SlcItem');
		$address 	= $this->input->post('txtAlamat');
		$lppbmokib 	= $this->input->post('txtLmk');
		$picklist 	= $this->input->post('txtPicklist');

		$i=0;
		foreach($kode_item as $loop){
			$component = explode('|', $kode_item[$i]);
			$kode_item_save		= $component[0];
			$alamat_simpan_save = strtoupper($address[$i]);
			$lppbmokib_save 	= $lppbmokib[$i];
			$picklist_save 		= $picklist[$i];

			// $checkData = $this->M_inputcomponent->CekData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator);
			// if ($checkData>0) {
				// $this->M_inputcomponent->UpdateData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user);
				// $id[$i] = 'UPDATE';
			// }
			// else{
				$this->M_inputcomponent->insertData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user);
				$id[$i] = $this->M_inputcomponent->getLastInserted('KHS.KHSLOKASISIMPAN', 'KHSLOKASISIMPAN_ID');
			// }
			$i++;
		}

		$x = 0;
		$updCount = 0;
		$n = 1;
		foreach ($id as $aidi) {
			// if ($aidi == 'UPDATE') {
				// $messContent[$x]	= "Data-".$n." Already Exist. Update Data Success!";
	        	// $data[$x] = array(array('KHSLOKASISIMPAN_ID' => '0'));
	        	// $updCount++;
			// }else{
				$messContent[$x] = "Input Data-".$n." Success!";
				$data[$x] = $this->M_inputcomponent->getLastData($aidi);
			// }
			$x++;
			$n++;
		}

		// if ($updCount == $x) {
			// $showData = "";
		// }else{
			$showData = "
    	    	<div class='box box-primary box-solid'>
        	        <div class='box-header with-border'>
            	        Last Inserted Data
                	</div>
	                <div class='box-body'>
    	                <table class='table table-striped table-bordered'>
        	                <thead>
            	                <tr class='bg-primary'>
                	            	<td width='10%'>COMPONENT</td>
                    	        	<td width='15%'>DESCRIPTION</td>
                        	    	<td width='10%'>ASSEMBLY CODE</td>
                            		<td width='15%'>ASSEMBLY NAME</td>
                            		<td width='10%'>ASSEMBLY TYPE</td>
	                            	<td width='10%'>SUBINVENTORY</td>
    	                        	<td width='10%'>STORAGE LOCATION</td>
        	                    	<td width='10%'>LPPB/MO/KIB</td>
            	                	<td width='10%'>PICKLIST</td>
                	            </tr>
                    	    </thead>
	                        <tbody>";
    	                    	foreach ($data as $dt => $d) {
    	                    		if ($d[0]['KHSLOKASISIMPAN_ID'] == '0') {
    	                    		 	// nothing to do
    	                    		}else{ ;
        	                			$showData .= "
            	            				<tr>
                	        					<td>".$d[0]['COMPONENT']."</td>
                    	    					<td>".$d[0]['DESCRIPTION']."</td>
                        						<td>".$d[0]['ASSEMBLY']."</td>
                        						<td>".$d[0]['NAMA_ASSEMBLY']."</td>
                        						<td>".$d[0]['ASSEMBLY_TYPE']."</td>
	                        					<td>".$d[0]['SUB_INV']."</td>
    	                    					<td>".$d[0]['ALAMAT_SIMPAN']."</td>
        	                					<td>".$d[0]['LPPB_MO_KIB']."</td>
            	            					<td>".$d[0]['PICKLIST']."</td>
        									</tr>";
        							}
        						} ;
        					$showData .= "
        					</tbody>
        				</table>
        			</div>
        		</div>
        		";
			// }
		
			$message = '<div class="row">
		 					<div class="col-md-10 col-md-offset-1 col-sm-12">
		 						<div class="alert alert-success" role="alert">
		 							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			 							<span aria-hidden="true">&times;</span>
			 						</button>';
			 						foreach ($messContent as $msg) { 
			 							$message .= $msg.'<br>';
			 						};
			 						$message .='
		 						</div>
		 					</div>
                    	</div>';
	    $this->index($message,$showData);
	}
}