<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_InputComponent extends CI_Controller 
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

	public function index($message = NULL , $showData = NULL)
	{
		$data = array (
			'message' => $message,
			'lastInsert' => $showData,
        );
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Input Data Component';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/MainMenu/V_InputComponent',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$user 		= $this->session->userdata('user');
		$org_id 	= $this->input->post('IdOrganization');
		$sub_inv 	= $this->input->post('SlcSubInventori');
		$comp_code_data = $this->input->post('SlcItem');
		$ex 		= explode('|', $comp_code_data);
		$comp_code 	= $ex[0];
		$assy_code 	= $this->input->post('SlcKodeAssy');
		$type_assy 	= $this->input->post('txtTypeAssy');
		$locator 	= $this->input->post('txtLocator');
		$address	= strtoupper($this->input->post('txtAlamat'));
		$lmk 		= $this->input->post('txtLmk');
		$picklist 	= $this->input->post('txtPicklist');
		if ($lmk == 'NO') {
			$lmk ="0";
		}elseif ($lmk == 'YES') {
			$lmk ="1";
		}
		
		if ($picklist  == 'NO') {
			$picklist  ="0";
		}elseif ($picklist  == 'YES') {
			$picklist  ="1";
		}

		// $checkData = $this->M_inputcomponent->CekData($org_id,$sub_inv,$assy_code,$type_assy,$comp_code,$locator);
		// if ($checkData>0) {
			// $this->M_inputcomponent->UpdateData($org_id,$sub_inv,$assy_code,$type_assy,$comp_code,$locator,$address,$lmk,$picklist,$user);
			// $id = 'UPDATE';
		// }else{
			$this->M_inputcomponent->insertData($org_id,$sub_inv,$assy_code,$type_assy,$comp_code,$locator,$address,$lmk,$picklist,$user);
			$id = $this->M_inputcomponent->getLastInserted('KHS.KHSLOKASISIMPAN', 'KHSLOKASISIMPAN_ID');
		// }

		// if ($id == 'UPDATE') {
			// $messContent 	= "Data Already Exist. Update Data Success!";
	        // $showData 		= "";
		// }else{
			$messContent = "Input Data Success!";
			$data = $this->M_inputcomponent->getLastData($id);
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
    	                    	foreach ($data as $dt) { ;
        	                	$showData .= "
            	            	<tr>
                	        		<td>".$dt['COMPONENT']."</td>
                    	    		<td>".$dt['DESCRIPTION']."</td>
                        			<td>".$dt['ASSEMBLY']."</td>
                        			<td>".$dt['NAMA_ASSEMBLY']."</td>
                        			<td>".$dt['ASSEMBLY_TYPE']."</td>
	                        		<td>".$dt['SUB_INV']."</td>
    	                    		<td>".$dt['ALAMAT_SIMPAN']."</td>
        	                		<td>".$dt['LPPB_MO_KIB']."</td>
            	            		<td>".$dt['PICKLIST']."</td>
        						</tr>";
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
			 						$message .= $messContent;
			 						$message .='
			 					</div>
			 				</div>
            	        </div>';
        $this->index($message,$showData);
	}
}