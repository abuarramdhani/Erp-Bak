<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DeliveryRequest extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
          parent::__construct();
		  
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->library('form_validation');
          //load the login model
		  $this->load->library('session');
		  $this->load->library('encrypt');
		  $this->load->model('M_index');
		  $this->load->model('InventoryManagement/MainMenu/M_deliveryrequest');
		  $this->load->model('InventoryManagement/Setting/M_deliveryrequestapproval');
		  $this->load->model('SystemAdministration/MainMenu/M_user');
		  $this->load->model('SystemAdministration/MainMenu/M_responsibility');
		  $this->load->model('SystemAdministration/MainMenu/M_menu');
		  //$this->load->model('Setting/M_usermenu');
		  //$this->load->library('encryption');
		  $this->checkSession();
    }
	
	public function checkSession()
	{
		if($this->session->is_logged){
			//redirect('Home');
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->user;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;
		
		$data['Title'] = 'List Delivery Request';
		$data['Menu'] = 'Delivery Request';
		$data['SubMenuOne'] = 'Delivery Request';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';
		
		$org_id = $data['UserMenu'][0]['org_id'];
		$data['DeliveryRequest'] = $this->M_deliveryrequest->getDeliveryRequest(FALSE,$org_id);
		
		//Load halaman
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InventoryManagement/MainMenu/DeliveryRequest/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function CreateDeliveryRequest()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Create Delivery Request';
		$data['Menu'] = 'Delivery Request';
		$data['SubMenuOne'] = 'Delivery Request';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['DeliveryItem'] = $this->M_deliveryrequest->getItemDelivery();
		
		if(intval($this->session->org_id) === 82){
					$int_org_id = $this->input->post('slcIoInterOrg');
					$int_subinv = $this->input->post('slcSubInventoryInterOrg');
					$data['address']	= "Jl. Magelang Km. 7,8 Dukuh Glondong, Desa Sinduadi, Mlati, Sleman";
					$data['telp']		= "0274-512095 hunting 584874, 563217, 513025";
		}else{
			
			if(intval($this->session->org_id) === 121){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id = 210;
					$int_subinv = "FG-SFG";
				}else{
					$int_org_id = 211;
					$int_subinv = "SP-SSP";
				}
				$data['address']	= "Pergudangan Margomulyo Jaya Jl Sentong Asri Blok F 10 Surabaya";
				$data['telp']		= "031-3525687";
			}elseif(intval($this->session->org_id) === 141){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id = 207;
					$int_subinv = "FG-JFG";
				}else{
					$int_org_id = 208;
					$int_subinv = "SP-JSP";
				}
				$data['address']	= "Jl. Gajahmada No.154 Jakarta Barat";
				$data['telp']		= "021-6292044";
			}elseif(intval($this->session->org_id) === 144){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id = 201;
					$int_subinv = "FG-MFG";
				}else{
					$int_org_id = 202;
					$int_subinv = "SP-MSP";
				}
				$data['address']	= "Komplek Pergudangan Intan Tembung No. 13 Deli Serdang Medan";
				$data['telp']		= "061-7384680";
			}elseif(intval($this->session->org_id) === 142){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id = 204;
					$int_subinv = "FG-TFG";
				}else{
					$int_org_id = 205;
					$int_subinv = "SP-TSP";
				}
				$data['address']	= "Jl. Raden Intan No. 159 Tanjung Karang";
				$data['telp']		= "0721-268498";
			}elseif(intval($this->session->org_id) === 143){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id = 213;
					$int_subinv = "FG-UFG";
				}else{
					$int_org_id = 214;
					$int_subinv = "SP-USP";
				}
				$data['address']	= "Jl. Kima 4 No. M4 Dayak Biringkanaya Makassar";
				$data['telp']		= "0411-514573";
			}elseif(intval($this->session->org_id) === 506){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id =508;
					$int_subinv = "FG-NFG";
				}else{
					$int_org_id = 509;
					$int_subinv = "SP-NSP";
				}
				$data['address']	= "";
				$data['telp']		= "";
			}elseif(intval($this->session->org_id) === 507){
				if($this->input->post('slcRequestType') === "UNIT"){
					$int_org_id = 511;
					$int_subinv = "FG-RFG";
				}else{
					$int_org_id = 512;
					$int_subinv = "SP-RSP";
				}
				$data['address']	= "";
				$data['telp']		= "";
			}
		}
		
		$this->form_validation->set_rules('slcRequestType', 'num', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('InventoryManagement/MainMenu/DeliveryRequest/V_create',$data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');

		}
		else
		{		$request_number = $this->GetLastRequestNumber($this->input->post('slcRequestType'));
				
				
				$data = array(
					'SEGMENT1' 					=> $request_number,
					'BLANKET' 					=> !empty($this->input->post('txtBlanket')) ? $this->input->post('txtBlanket') : NULL,
					'EXPEDITION' 				=> !empty($this->input->post('txtExpedition')) ? $this->input->post('txtExpedition') : NULL,
					'REQUEST_TYPE' 				=> !empty($this->input->post('slcRequestType')) ? $this->input->post('slcRequestType') : NULL,
					'DESTINATION' 				=> !empty($this->input->post('txtDestination')) ? $this->input->post('txtDestination') : NULL,
					'ORDER_DATE' 				=> $this->input->post('txtOrderDate'),
					'SHIP_REQUEST_DATE' 		=> $this->input->post('txtShipRequestDate'),
					'STATUS' 					=> $this->input->post('txtDeliveryStatus'),
					'NOTES' 					=> !empty($this->input->post('txtNotes')) ? $this->input->post('txtNotes') : NULL,
					'INTERORG_ORGANIZATION_ID' 	=> $int_org_id ,
					'INTERORG_SUBINVENTORY' 	=> $int_subinv,
					'CATEGORY	' 				=> 'R',
					'CONTRACT_NUMBER' 			=> ($this->input->post('txtContractNumber')=="")?NULL:$this->input->post('txtContractNumber'),
					'EMBLEM' 					=> ($this->input->post('txtEmblem')=="")?NULL:$this->input->post('txtEmblem'),
					'ALLOCATION' 				=> ($this->input->post('txtAllocation')=="")?NULL:$this->input->post('txtAllocation'),
					'REQUESTOR' 				=> intval(($this->input->post('slcRequestor')=="")?NULL:$this->input->post('slcRequestor')),
					'ORG_ID' 					=> ($this->input->post('txtOrgId')=="")?$data['UserMenu'][0]['org_id']:$this->input->post('txtOrgId'),
					'CREATION_DATE' 			=> date('d-M-Y',strtotime($this->input->post('hdnDate'))),
					'CREATED_BY' 				=> $this->input->post('hdnUser')
				);
				
				$id = $this->M_deliveryrequest->setDeliveryRequest($data);
				// print_r($id[0]['DELIVERY_REQUEST_ID']);
				
				$item = $this->input->post('slcDeliveryItem');
				$qty = $this->input->post('txtQuantity');
				
				foreach($item as $i => $loop){
					if($item[$i]!=""){
						$data_lines = array(
							'DELIVERY_REQUEST_ID' 	=> $id,
							'LINE_ITEM_ID' 			=> $item[$i],
							'QUANTITY' 				=> $qty[$i]
						);
					
						$this->M_deliveryrequest->setDeliveryRequestLine($data_lines);
					}
				}
				
				$this->M_deliveryrequest->setComponent($id);
				
				$encrypted_string = $this->encrypt->encode($id[0]['DELIVERY_REQUEST_ID']);
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				
				redirect('InventoryManagement/DeliveryRequest/UpdateDeliveryRequest/'.$encrypted_string);
				
				//print_r($request_number);
		}
		
		
		
		
	}
	
	public function UpdateDeliveryRequest($id)
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['Title'] = 'Update DeliveryRequest';
		$data['Menu'] = 'Delivery Request';//menu title
		$data['SubMenuOne'] = 'Delivery Request';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$org_id = $data['UserMenu'][0]['org_id'];
		$data['DeliveryRequest'] = $this->M_deliveryrequest->getDeliveryRequest($plaintext_string,$org_id);
		$data['DeliveryRequestLines'] = $this->M_deliveryrequest->getDeliveryRequestLines($plaintext_string);
		$data['Approver'] = $this->M_deliveryrequestapproval->getApprover($user);
		
		$data['num'] = count($data['DeliveryRequestLines']);
		$data['id'] = $id;
		
		$this->form_validation->set_rules('txtDeliveryRequestNum', 'menuname', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('InventoryManagement/MainMenu/DeliveryRequest/V_update',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{		$item = $this->input->post('slcDeliveryItem');
				$qty = $this->input->post('txtQuantity');
				$line_id = $this->input->post('hdnLineId');
				$btn = $this->input->post('btnDeliveryRequestApproval');
				
				foreach($qty as $i => $loop){
					if($qty[$i]!=""){
						if($line_id[$i] == ""){
							$data_lines[$i] = array(
								'DELIVERY_REQUEST_ID' 	=> $plaintext_string,
								'LINE_ITEM_ID' 			=> intval($item[$i]),
								'QUANTITY' 				=> intval($qty[$i])
							);
						
							$this->M_deliveryrequest->setDeliveryRequestLine($data_lines[$i]);
							// print_r("9");
						}else{
							$data_lines[$i] = array(
								// 'LINE_ITEM_ID' 			=> $item[$i],
								'QUANTITY' 				=> $qty[$i]
							);
						
							$this->M_deliveryrequest->updateDeliveryRequestLine($data_lines[$i],$line_id[$i]);
							// print_r($line_id[$i]."/");
						}
					}
				}
				if(is_numeric($btn)){
					$next_status = "REQUEST NEW";
				}else{
					$next_status = $btn;
				}
				
				if(intval($this->session->org_id) === 82){
					$int_org_id = $this->input->post('slcIoInterOrg');
					$int_subinv = $this->input->post('slcSubInventoryInterOrg');
				}else{
					
					if(intval($this->session->org_id) === 121){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id = 210;
							$int_subinv = "FG-SFG";
						}else{
							$int_org_id = 211;
							$int_subinv = "SP-SSP";
						}
					}elseif(intval($this->session->org_id) === 141){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id = 207;
							$int_subinv = "FG-JFG";
						}else{
							$int_org_id = 208;
							$int_subinv = "SP-JSP";
						}
					}elseif(intval($this->session->org_id) === 144){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id = 201;
							$int_subinv = "FG-MFG";
						}else{
							$int_org_id = 202;
							$int_subinv = "SP-MSP";
						}
					}elseif(intval($this->session->org_id) === 142){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id = 204;
							$int_subinv = "FG-TFG";
						}else{
							$int_org_id = 205;
							$int_subinv = "SP-TSP";
						}
					}elseif(intval($this->session->org_id) === 143){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id = 213;
							$int_subinv = "FG-UFG";
						}else{
							$int_org_id = 214;
							$int_subinv = "SP-USP";
						}
					}elseif(intval($this->session->org_id) === 506){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id =508;
							$int_subinv = "FG-NFG";
						}else{
							$int_org_id = 509;
							$int_subinv = "SP-NSP";
						}
					}elseif(intval($this->session->org_id) === 507){
						if($this->input->post('slcRequestType') === "UNIT"){
							$int_org_id = 511;
							$int_subinv = "FG-RFG";
						}else{
							$int_org_id = 512;
							$int_subinv = "SP-RSP";
						}
					}
				}
				
				if($next_status != 'REQUEST APPROVED'){
					$data = array(
						'BLANKET' 					=> !empty($this->input->post('txtBlanket')) ? $this->input->post('txtBlanket') : NULL,
						'EXPEDITION' 				=> !empty($this->input->post('txtExpedition')) ? $this->input->post('txtExpedition') : NULL,
						'REQUEST_TYPE' 				=> !empty($this->input->post('slcRequestType')) ? $this->input->post('slcRequestType') : NULL,
						'DESTINATION' 				=> !empty($this->input->post('txtDestination')) ? $this->input->post('txtDestination') : NULL,
						'ORDER_DATE' 				=> $this->input->post('txtOrderDate'),
						'SHIP_REQUEST_DATE' 		=> $this->input->post('txtShipRequestDate'),
						'STATUS' 					=> $next_status,
						'NOTES' 					=> !empty($this->input->post('txtNotes')) ? $this->input->post('txtNotes') : NULL,
						'INTERORG_ORGANIZATION_ID' 	=> $int_org_id ,
						'INTERORG_SUBINVENTORY' 	=> $int_subinv,
						'CONTRACT_NUMBER' 			=> ($this->input->post('txtContractNumber')=="")?NULL:$this->input->post('txtContractNumber'),
						'EMBLEM' 					=> ($this->input->post('txtEmblem')=="")?NULL:$this->input->post('txtEmblem'),
						'ALLOCATION' 				=> ($this->input->post('txtAllocation')=="")?NULL:$this->input->post('txtAllocation'),
						'REQUESTOR' 				=> intval(($this->input->post('slcRequestor')=="")?NULL:$this->input->post('slcRequestor')),
						'LAST_UPDATE_DATE' 			=> date('d-M-Y',strtotime($this->input->post('hdnDate'))),
						'LAST_UPDATED_BY' 			=> intval($this->input->post('hdnUser'))
					);
				}else{
					$data = array(
						'STATUS' 			=> $next_status,
						'LAST_UPDATE_DATE' 			=> date('d-M-Y',strtotime($this->input->post('hdnDate'))),
						'LAST_UPDATED_BY' 			=> intval($this->input->post('hdnUser'))
					);
				}
				
				
				$this->M_deliveryrequest->updateDeliveryRequest($data,intval($plaintext_string));
				
				
				$this->M_deliveryrequest->setComponent($plaintext_string);
				// print_r($btn);
				if($btn == "" or !is_numeric($btn)){
					redirect('InventoryManagement/DeliveryRequest/UpdateDeliveryRequest/'.$id);
				}
				else{
					$encrypted_string = $this->encrypt->encode($btn);
					$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
					
					redirect('InventoryManagement/DeliveryRequest/DeliveryRequestComponent/'.$id.'/'.$encrypted_string);
				}
		}
			
		
	}
	
	public function DeliveryRequestComponent($delivery_id,$line_id)
	{	$user_id = $this->session->userid;
		
		$data['Title'] = 'Delivery Request Component';
		$data['Menu'] = 'Delivery Request';//menu title
		$data['SubMenuOne'] = 'Delivery Request';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$plaintext_string1 = str_replace(array('-', '_', '~'), array('+', '/', '='), $delivery_id);
		$plaintext_string1 = $this->encrypt->decode($plaintext_string1);
		
		$plaintext_string2 = str_replace(array('-', '_', '~'), array('+', '/', '='), $line_id);
		$plaintext_string2 = $this->encrypt->decode($plaintext_string2);
		
		$data['ComponenHeader'] = $this->M_deliveryrequest->getDeliveryRequestLines($plaintext_string1,$plaintext_string2);
		$data['Component'] = $this->M_deliveryrequest->getComponent($plaintext_string1,$plaintext_string2);
		
		// $data['num'] = count($data['DeliveryRequestLines']);
		$data['delivery_id'] = $delivery_id;
		$data['line_id'] = $line_id;
		
		$this->form_validation->set_rules('txtDeliveryRequestNum', 'deliverynum', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				
				// Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('InventoryManagement/MainMenu/DeliveryRequest/V_componen',$data);
				$this->load->view('V_Footer',$data);
				// print_r($delivery_id);
				// echo "<br>";
				// print_r($line_id);

		}
		else
		{		
				$choose = $this->input->post('hdnPartId');
				$picked_quantity = $this->input->post('txtPickedQuantity');
				
				foreach($choose as $i => $choose_item){
					if($picked_quantity[$i]=="0" or $picked_quantity[$i]==""){
						$data_option = array(
							'PICKED' 				=> 'N',
							'PICKED_QUANTITY' 		=> ""
						);
					}else{
						$data_option = array(
							'PICKED' 				=> 'Y',
							'PICKED_QUANTITY' 		=> $picked_quantity[$i]
						);
					}
					
				
					$this->M_deliveryrequest->updateComponent($data_option,$choose_item);
					print_r($choose_item);
				}
				
				// print_r($choose);
				
				redirect('InventoryManagement/DeliveryRequest/DeliveryRequestComponent/'.$delivery_id.'/'.$line_id);
		}
			
		
	}
	
	public function GetLastRequestNumber($term)
	{		
			$org_id = $this->session->org_id;
			
			if($org_id == 82){
				$head = 'AA';
			}elseif($org_id == 121){
				$head = 'CA';
			}elseif($org_id == 141){
				$head = 'BA';
			}elseif($org_id == 142){
				$head = 'BB';
			}elseif($org_id == 143){
				$head = 'CB';
			}elseif($org_id == 144){
				$head = 'BC';
			}elseif($org_id == 145){
				$head = 'CE';
			}
			
			if($term == 'UNIT'){
				$type = '01';
			}elseif($term == 'SPARE PART'){
				$type = '02';
			}
			$date = date("ym");// "ym" 2 digit year & month
			$search = $head.$type.$date;
			
			$num = $this->M_deliveryrequest->getLastRequestNumber($search,$org_id);
			
			$running_number = $search.str_pad($num[0]['NEXTVAL'],4,"0",STR_PAD_LEFT);
			
			/*
			if(strlen($num[0]['NEXTVAL'])== 1){
				$running_number = $search."000".$num[0]['NEXTVAL'];
			}elseif(strlen($num[0]['NEXTVAL'])== 2){
				$running_number = $search."00".$num[0]['NEXTVAL'];
			}elseif(strlen($num[0]['NEXTVAL'])== 3){
				$running_number = $search."0".$num[0]['NEXTVAL'];
			}else{
				$running_number = $search.$num[0]['NEXTVAL'];
			}
			*/
			return $running_number;
			
	}
}
