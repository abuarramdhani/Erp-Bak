<?php
class C_ServiceProducts extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/MainMenu/M_serviceproducts');
                $this->load->model('CustomerRelationship/Setting/M_serviceproblem');
                $this->load->model('CustomerRelationship/MainMenu/M_customer');
				$this->load->model('CustomerRelationship/MainMenu/M_ownership');
				// $this->load->model('CustomerRelationship/M_servicelinestatus');
				$this->load->model('CustomerRelationship/MainMenu/M_customercontacts');
				$this->load->model('CustomerRelationship/Setting/M_Checklist');
				$this->load->model('CustomerRelationship/Setting/M_additionalactivity');
				$this->load->model('EmployeeRecruitment/MainMenu/M_employee');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				$this->load->helper('form');
				$this->load->library('upload');
				$this->load->helper('file');
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->helper('url');
				$this->checkSession();
        }
		
		public function checkSession(){
			if($this->session->is_logged){
				
			}else{
				redirect('');
			}
		}

        public function index()
		{		$user_id = $this->session->userid;
				if ($this->session->userdata('tempServiceNumber')) {
					$id = $this->session->userdata('tempServiceNumber');
					$dataTemp 		= $this->M_serviceproducts->getServiceNumber($id);
					$service_number = $dataTemp[0]['activity_number'];
					$year 			= date('Y', strtotime($dataTemp[0]['creation_date']));
					$custId 		= $dataTemp[0]['customer_id'];
					$dataLineTemp 	= $this->M_serviceproducts->getServiceLineTemp($service_number);
					foreach ($dataLineTemp as $dlt) {
						unlink('./'.$dlt['image_name']);
						$this->M_serviceproducts->deleteLineImageTemp($dlt['service_product_image_id']);
					}
					if (is_dir('./assets/upload_cr/ServiceProducts/'.$custId.'/'.$year.'/'.$service_number)) {
						rmdir('./assets/upload_cr/ServiceProducts/'.$custId.'/'.$year.'/'.$service_number);
					}
					$this->M_serviceproducts->deleteImageTemp($service_number);
					$this->M_serviceproducts->deleteActivityTemp($id);
					$this->session->unset_userdata('tempServiceNumber');
				}else{	}
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['Activity'] = $this->M_serviceproducts->getActivity();
				
				//$data['Connect'] = $this->M_serviceproducts->getConnect();
				$data['title'] = 'Activity';

				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Activity';
				$data['SubMenuOne'] = '';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function AjaxSearching()
		{
				$name = $this->input->get('name');
				$service_number = $this->input->get('service_number');
				$activity = $this->input->get('activity');
				$method = $this->input->get('method');
				$contact = $this->input->get('contact');
				//$data['Customer'] = $this->M_customer->getFilteredCustomer($nama,$village,$city,$category);
				$data['Activity'] = $this->M_serviceproducts->getFilteredServiceProducts($name,$service_number,$activity,$method,$contact);
				$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_ajax_cari',$data);
		}
		/*
		public function details($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				settype($plaintext_string, 'integer');
				
				$data['ServiceProducts'] = $this->M_serviceproducts->getServiceProducts($plaintext_string);
				$data['ServiceProductsLines'] = $this->M_serviceproducts->getServiceProductLines($plaintext_string);
				$data['title'] = 'Service Products';

				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/ServiceProducts/V_details', $data);
				//$this->load->view('templates/footer');
		}
		*/
		public function searchCustomer($id = FALSE)
		{		$id = str_replace("~", " ", $id);
		
				$data['Customer'] = $this->M_customer->getCustomer($id);
				$data['title'] = 'Customer';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_search_customer', $data);
		}
		
		
		public function searchEmployee($id = FALSE)
		{		$id = str_replace("~", " ", $id);
		
				$data['Employee'] = $this->M_employee->getEmployee($id);
				$data['title'] = 'Employee';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_search_employee', $data);
		}
		
		public function searchOwnership($cust= 2,$id= FALSE)
		{		$id = str_replace("~", " ", $id);
		
				$data['Ownership'] = $this->M_ownership->getOwnershipService($id,$cust );
				$data['title'] = 'Ownership';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_search_ownership', $data);
		}

		public function Update($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['ServiceProducts'] = $this->M_serviceproducts->getServiceProducts($plaintext_string);
				$data['ServiceProductLines'] = $this->M_serviceproducts->getServiceProductLines($plaintext_string);
				$data['imgClaim'] = $this->M_serviceproducts->getImageData($data['ServiceProducts'][0]['service_number']);
				$data['ServiceProductFaqs'] = $this->M_serviceproducts->getServiceProductFaqs($plaintext_string,'cr_service_products');
				$data['ServiceProductLineHistories'] = $this->M_serviceproducts->getServiceLineHistory($plaintext_string);
				$data['ServiceProductAdditionalAct'] = $this->M_serviceproducts->getServiceProductAddAct($plaintext_string);
				$data['Checklist'] = $this->M_Checklist->getChecklistActive();
				$data['AdditionalActivity'] = $this->M_additionalactivity->getAdditionalActivity();
				$data['Province'] 	= $this->M_serviceproducts->province();
				$data['city'] 		= $this->M_serviceproducts->cityRegency($data['ServiceProducts'][0]['location_province']);
				$data['district'] 	= $this->M_serviceproducts->district($data['ServiceProducts'][0]['location_city']);
				$data['village'] 	= $this->M_serviceproducts->village($data['ServiceProducts'][0]['location_district']);
				
				$ServiceProductLines = $this->M_serviceproducts->getServiceProductLines($plaintext_string);
				$a=1;
				foreach($ServiceProductLines as $ServiceProductLines_item){
					$line_id = $ServiceProductLines_item['service_product_line_id'];
					$data['history'.$a] = $this->M_serviceproducts->getServiceHistory($line_id);
					$data['tes'.$a] = $a;
					$a++;
				}
								
				$data['counter'] = count($data['ServiceProductLines']);
				$data['title'] = 'Update Activity';
				$data['id'] = $id;
				
				//$data['tes'.$a] = "halo";

				$this->form_validation->set_rules('txtServiceNumber', 'Service Number', 'required');
				//$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Activity';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_update', $data);
						if ($data['ServiceProducts'][0]['approval_status'] == NULL or $data['ServiceProducts'][0]['approval_status'] == 'NOT APPROVED 1' or $data['ServiceProducts'][0]['approval_status'] == 'NOT APPROVED 2') {
							$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_ask_approval', $data);
						}elseif ($data['ServiceProducts'][0]['approval_status'] == 'ASK FOR APPROVAL') {
							$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_branch_approval', $data);
						}elseif ($data['ServiceProducts'][0]['approval_status'] == 'BRANCH APPROVAL') {
							$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_central_approval', $data);
						}
						$this->load->view('V_Footer',$data);
				}
				else
				{	
						//if($data['customer_id'] == '')
						//{	$data['customer_id'] = NULL; }
											
						//$count = count($this->input->post('txtProblemDescription'));
						//$count = sizeof($_POST['txtProblemDescription']);
						//if($count = NULL){$count=1;}
						/*
						$problem = $this->input->post('slcProblem');
						$problem_description = $this->input->post('txtProblemDescription');
						$count = count($problem_description);
						$action = $this->input->post('txtAction');
						$action_date = $this->input->post('txtActionDate');
						$finish_date = $this->input->post('txtFinishDate');
						$tech_id = $this->input->post('hdnEmployeeId');
						$ownership_id = $this->input->post('hdnOwnershipId');
						$service_lines_id = $this->input->post('hdnServiceLinesId');
						$warranty = $this->input->post('txtWarranty');
						$claim_number = $this->input->post('txtClaimNum');
						$spare_part = $this->input->post('hdnSparePartId');
						$line_status = $this->input->post('slcServiceLineStatus');
						*/
						$problem 				= $this->input->post('slcProblem');
						$problem_description 	= $this->input->post('txtProblemDescription');
						$count 					= count($problem_description);
						$action 				= $this->input->post('txtAction');
						$action_date 			= $this->input->post('txtActionDate');
						$finish_date 			= $this->input->post('txtFinishDate');
						$tech_id 				= $this->input->post('slcEmployeeNum');
						$ownership_id 			= $this->input->post('hdnOwnershipId');
						$service_lines_id 		= $this->input->post('hdnServiceLinesId');
						$warranty 				= $this->input->post('txtWarranty');
						$claim_number 			= $this->input->post('txtClaimNum');
						$spare_part 			= $this->input->post('slcSparePart');
						$line_status 			= $this->input->post('slcServiceLineStatus');
						$process 				= $this->input->post('actionClaim');
						$line_image_id 			= $this->input->post('claimImageData');
						
						for($i=0; $i<$count; $i++) {
						//foreach($problem_description as $prob => $i):
							$own_id[$i] = intval($ownership_id[$i]);
							if($own_id[$i] == 0)
							{	$own_id[$i] = NULL; }
							if($action_date[$i] == '')
							{	$action_date[$i] = NULL; }
							if($finish_date[$i] == '')
							{	$finish_date[$i] = NULL; }
							if($tech_id[$i] == '')
							{	$tech_id[$i] = NULL; }
							if($line_status[$i] == '')
							{	$line_status[$i] = NULL; }
							if($spare_part[$i] == '')
							{	$spare_part[$i] = NULL; }
							if($problem[$i] == '')
							{	$problem[$i] = NULL; }
							if($claim_number[$i] == '')
							{	$claim_number[$i] = NULL; }
						
							$data_lines1[$i] = array(
								//'service_product_line_id'	=> $service_lines_id[$i],
								'problem_description'		=> $problem_description[$i],
								'action'					=> $action[$i],
								'action_date' 				=> $action_date[$i],
								'warranty' 					=> $warranty[$i],
								'claim_number'				=> $claim_number[$i],
								'service_product_id'		=> $plaintext_string,
								'ownership_id' 				=> $own_id[$i],
								'technician_id' 			=> $tech_id[$i],
								'last_update_date' 			=> $this->input->post('hdnDate'),
								'last_updated_by' 			=> $this->input->post('hdnUser'),
								'spare_part_id' 			=> $spare_part[$i],
								'line_status' 				=> $line_status[$i],
								'problem_id' 				=> $problem[$i],
								'process'					=> $process[$i],
								'service_product_line_image_id'=> $line_image_id[$i]
							);
							
							$data_lines2[$i] = array(
								//'service_product_line_id'	=> $service_lines_id[$i],
								'problem_description'		=> $problem_description[$i],
								'action'					=> $action[$i],
								'action_date' 				=> $action_date[$i],
								'warranty' 					=> $warranty[$i],
								'claim_number'				=> $claim_number[$i],
								'service_product_id'		=> $plaintext_string,
								'technician_id' 			=> $tech_id[$i],
								'ownership_id' 				=> $own_id[$i],
								'last_update_date' 			=> $this->input->post('hdnDate'),
								'last_updated_by' 			=> $this->input->post('hdnUser'),
								'creation_date' 			=> $this->input->post('hdnDate'),
								'created_by'	 			=> $this->input->post('hdnUser'),
								'spare_part_id' 			=> $spare_part[$i],
								'line_status' 				=> $line_status[$i],
								'problem_id' 				=> $problem[$i],
								'process'					=> $process[$i],
								'service_product_line_image_id'=> $line_image_id[$i]
							);
							
							//////////////////////////////////////////////////////////
							/*If dibawah untuk melakukan penginputan terhadap service
							line history. Bila service line baru maka dia akan menginputkan
							data terlebih dahulu pada table cr_service_product_lines kemudian
							baru menginputkan pada table cr_service_line_histories. Tetapi
							bila line service telah ada maka dia langusung menginputkan
							pada table cr_service_line_histories.
							*/
							//////////////////////////////////////////////////////////
							
							
							$line_id2 = intval($service_lines_id[$i]);
							if($line_id2 == 0){
								if($own_id[$i] != NULL){
								$this->M_serviceproducts->setServiceProductLines($data_lines2[$i]);
								//echo "1";print_r ($id);echo "|";
								$lines_id = $this->M_serviceproducts->getServiceProductLinesId($data_lines2[$i]);
								unset($data_lines2[$i]['last_update_date']);
								unset($data_lines2[$i]['last_updated_by']);
								unset($data_lines2[$i]['creation_date']);
								unset($data_lines2[$i]['created_by']);
								unset($data_lines2[$i]['claim_number']);
								$data_lines2[$i]['service_product_line_id'] = $lines_id[0]['service_product_line_id'];
								$this->M_serviceproducts->setServiceProductLineHistories($data_lines2[$i]);
								}
							}
							else{
								$ServiceProductHistoryTop = $this->M_serviceproducts->getServiceLineHistoryTop($line_id2);			
								$ServiceProductLineHistoryStatus = $ServiceProductHistoryTop[0]['line_status'];
								//.$ServiceProductLineConsNumHist = $ServiceProductHistoryTop[0]['consecutive_number'];
								
								$this->M_serviceproducts->updateServiceProductLines($data_lines1[$i],$line_id2);
								
								$ServiceProductTop = $this->M_serviceproducts->getServiceLineTop($line_id2);
								$ServiceProductLineStatus = $ServiceProductTop[0]['line_status'];
								
								//echo "2";print_r ($id);echo "|";
								unset($data_lines1[$i]['last_update_date']);
								unset($data_lines1[$i]['last_updated_by']);
								unset($data_lines1[$i]['claim_number']);
								$data_lines1[$i]['service_product_line_id'] = $line_id2;
								if(intval($ServiceProductLineHistoryStatus) > intval($ServiceProductLineStatus)){
									//$data_lines1[$i]['action'] = $id."/".$ServiceProductLineTopStatus."/".$line_status[$i];
									$this->M_serviceproducts->setServiceProductLineHistories($data_lines1[$i]);
								}
							}
							
							//print_r ($data_lines[$i]);
							//echo 'tes';
							//print_r ($count);
						}
						//data header dinputkan terakhir agar dapat dicek status line terlebih dahulu
						
						$result = $this->M_serviceproducts->checkForClose($plaintext_string);
						$connect_id = $this->input->post('slcConnectNum');
						
						if($connect_id == '')
							{	$connect_id = NULL; }
						
						if($result == 'CLOSE' and isset($connect_id)){
							$data_connect = array(
								'connect_status' 			=> 'CLOSE'
							);
							$this->M_serviceproducts->updateConnect($data_connect,$this->input->post('slcConnectNum'));
							
						}

						$durationUse 			= $this->input->post('durationUse');
						$durationUseType 		= $this->input->post('durationUseType');
							$duration_of_use 	= $durationUse.' '.$durationUseType;
						$sentDate 				= $this->input->post('sentDate');
							if ($sentDate==NULL) {$shipped = 'NO';}
							else {$shipped = 'YES';}
						$reasonVal 				= $this->input->post('reason');
							if ($reasonVal == NULL) {$reason = 'NO REASON';}
							else{$reason = $reasonVal;}
						if ($sentDate == NULL AND $reasonVal == NULL) {$noEvidence = 'YES';}
						else{$noEvidence = 'NO';}
						$area 					= $this->input->post('area');
							$landCategory 		= implode($area, ', ');
						$Soil 					= $this->input->post('Soil');
							$typeOfSoil 		= implode($Soil, ', ');
						$Depth 					= $this->input->post('Depth');
							$landDepth 			= implode($Depth, ', ');
						$Weeds 					= $this->input->post('Weeds');
							$WeedsItem 			= implode($Weeds, ', ');
						$Topography 			= $this->input->post('Topography');
							$TopographyItem 	= implode($Topography, ', ');
						$data = array(
							//'service_number'			=> $this->input->post('txtServiceNumber'),
							'service_status'			=> $result,
							'service_date' 				=> $this->input->post('txtServiceDate'),
							//'service_type' 				=> $this->input->post('slcActivityType'),
							'claim_method' 				=> $this->input->post('txtOtherType'),
							'description' 				=> $this->input->post('txtDescription'),
							'feedback' 					=> $this->input->post('txtFeedback'),
							'customer_id' 				=> $this->input->post('hdnCustomerId'),
							'connect_id' 				=> $connect_id,
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser'),
							'duration_of_use' 			=> $duration_of_use,
							'location_address' 			=> $this->input->post('AddressIncident'),
							'location_village' 			=> $this->input->post('VillageIncident'),
							'location_district' 		=> $this->input->post('DistrictIncident'),
							'location_city' 			=> $this->input->post('CityIncident'),
							'location_province' 		=> $this->input->post('provinceIncident'),
							'shipped' 					=> $shipped,
							'shipment_date' 			=> $sentDate,
							'not_shipped_reason' 		=> $reason,
							'no_evidence' 				=> $noEvidence,
							'land_category' 			=> $landCategory,
							'type_of_soil' 				=> $typeOfSoil,
							'land_depth' 				=> $landDepth,
							'weeds' 					=> $WeedsItem,
							'topography' 				=> $TopographyItem,
							'event_chronology' 			=> $this->input->post('Chronology'),
							'officer_id'				=> $this->input->post('officer'),
							'qty'						=> $this->input->post('QtyClaim')
						);
				
						$this->M_serviceproducts->updateServiceProducts($data,$plaintext_string);
						
						$faq_type = $this->input->post('slcFaqType');
						$faq_description1 = $this->input->post('txtFaqDescription1');
						$faq_description2 = $this->input->post('txtFaqDescription2');
						$faq_id = $this->input->post('hdnFaqId');
						$count2 = count($faq_description1);
						
						$data_faqs1 = array();
						$data_faqs2 = array();
						for($i=0; $i<$count2; $i++) {
							if($faq_description1[$i] != ''){
								$data_faqs1[$i] = array(
									'faq_type'					=> $faq_type[$i],
									'faq_description1'			=> strtoupper($faq_description1[$i]),
									'faq_description2'			=> strtoupper($faq_description2[$i]),
									'service_connect_id'		=> $plaintext_string,
									'from_table'				=> 'cr_service_products',
									'last_update_date' 			=> $this->input->post('hdnDate'),
									'last_update_by' 			=> $this->input->post('hdnUser')
								);
								
								$data_faqs2[$i] = array(
									'faq_type'					=> $faq_type[$i],
									'faq_description1'			=> strtoupper($faq_description1[$i]),
									'faq_description2'			=> strtoupper($faq_description2[$i]),
									//'service_product_id'		=> $plaintext_string,
									'service_connect_id'		=> $plaintext_string,
									'from_table'				=> 'cr_service_products',
									'last_update_date' 			=> $this->input->post('hdnDate'),
									'last_update_by' 			=> $this->input->post('hdnUser'),
									'creation_date' 			=> $this->input->post('hdnDate'),
									'created_by' 				=> $this->input->post('hdnUser')
								);								
							}
							$faqs_id = intval($faq_id[$i]);
							if(count($data_faqs1) != 0){ 
								if($faqs_id == 0){
									$this->M_serviceproducts->setServiceProductFaqs($data_faqs2[$i]);
									//echo "1";print_r ($id);echo "|";
								}
								else{
									$this->M_serviceproducts->updateServiceProductFaqs($data_faqs1[$i],$faqs_id);
									//echo "2";print_r ($id);echo "|";
								}
							}
						}
						
		
						$add_act = $this->input->post('txtAdditionalAct');
						$desc	 = $this->input->post('txtActDescription');
						$service_additional_activity_id = $this->input->post('hdnAddActId');
						$count3 = count($add_act);
						
						$data_add_act = array();
						for($i=0; $i<$count3; $i++) {
							if($add_act[$i] != ''){
								$data_add_act[$i] = array(
									'additional_activity'		=> $add_act[$i],
									'service_product_id'		=> $plaintext_string,
									'description'				=> $desc[$i],
									'last_update_date' 			=> $this->input->post('hdnDate'),
									'last_updated_by' 			=> $this->input->post('hdnUser'),
									'creation_date' 			=> $this->input->post('hdnDate'),
									'created_by' 				=> $this->input->post('hdnUser')
								);
								
							}
							$service_additional_activities_id = intval($service_additional_activity_id[$i]);
							if(count($data_add_act) != 0){
								if($service_additional_activities_id == 0){
									unset($data_add_act[$i]['last_update_date']);
									unset($data_add_act[$i]['last_updated_by']);
									$this->M_serviceproducts->setServiceProductAddAct($data_add_act[$i]);
									//echo "1";print_r ($service_additional_activities_id);echo "|<br />";
								}
								else{
									unset($data_add_act[$i]['creation_date']);
									unset($data_add_act[$i]['created_by']);
									$ServiceProductAdditionalAct = $this->M_serviceproducts->getServiceProductAddAct($plaintext_string,$service_additional_activities_id);
									if($data_add_act[$i]['additional_activity']!=$ServiceProductAdditionalAct[0]['additional_activity'] 
									or $data_add_act[$i]['description']!=$ServiceProductAdditionalAct[0]['description']){
										$this->M_serviceproducts->updateServiceProductAddAct($data_add_act[$i],$service_additional_activities_id);
									}
									
									//echo "2";print_r ($ServiceProductAdditionalAct);echo "| <br />";
								};
							};
							
						}
						
						//endforeach;
						//print_r ($data_lines[2]);
						//print_r ($service_lines_id[1]);
						//$encrypted_string = $this->encrypt->encode($id);
						//$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
						redirect('CustomerRelationship/ServiceProducts/Update/'.$id);
				}
		}				
		
		public function UpdateConnect($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				
				$data['Connect'] = $this->M_serviceproducts->getConnect($plaintext_string);
				$service_number = $this->M_serviceproducts->getServiceProductColumn('service_number','connect_id',$plaintext_string);
				if($service_number == NULL){
					$data['Connect'][0]['service_number'] = "";
					$data['Connect'][0]['service_product_id'] = "";
				}else{
					$data['Connect'][0]['service_number'] = $service_number['0']['service_number'];
					$service_product_id = $this->M_serviceproducts->getServiceProductColumn('service_product_id','connect_id',$plaintext_string);
					$data['Connect'][0]['service_product_id'] = $service_product_id['0']['service_product_id'];
				}
				
				
				$data['ConnectUnit'] = $this->M_serviceproducts->getConnectUnit($plaintext_string);
				$data['ServiceProductFaqs'] = $this->M_serviceproducts->getServiceProductFaqs($plaintext_string,'cr_connect_headers');
				$data['Checklist'] = $this->M_Checklist->getChecklistActive();
				/*$data['ServiceProductLineHistories'] = $this->M_serviceproducts->getServiceLineHistory($plaintext_string);
				//$data['ServiceProductAdditionalAct'] = $this->M_serviceproducts->getServiceProductAddAct($plaintext_string);
				
				$ConnectUnit = $this->M_serviceproducts->getConnectUnit($plaintext_string);
				$a=1;
				foreach($ConnectUnit as $ConnectUnit_item){
					$line_id = $ConnectUnit_item['service_product_line_id'];
					$data['history'.$a] = $this->M_serviceproducts->getServiceHistory($line_id);
					$data['tes'.$a] = $a;
					$a++;
				}
				*/
				
				$data['counter'] = count($data['ConnectUnit']);
				$data['title'] = 'Update Connect';
				$data['id'] = $id;
				
				//$data['tes'.$a] = "halo";

				$this->form_validation->set_rules('txtServiceNumber', 'Service Number', 'required');
				//$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Activity';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_update_connect', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{	
						if (isset($_POST['btnClose']))
						{
							 $connect_status = 'CLOSE';
						}
						else
						{
							$connect_status = $this->input->post('txtActivityStatus');
						}
						
						$use = $this->input->post('txtUse');
						$unit_id = $this->input->post('txtUsedUnitId');
						$count = count($use);
						
						for($i=0; $i<$count; $i++) {
						//foreach($problem_description as $prob => $i):
							//$own_id[$i] = intval($ownership_id[$i]);
						
							if($use[$i] == '')
							{	$use[$i] = NULL; }
						
							$data_unit[$i] = array(
								//'service_product_line_id'	=> $service_lines_id[$i],
								'use'						=> $use[$i],
								'last_update_date' 			=> $this->input->post('hdnDate'),
								'last_updated_by' 			=> $this->input->post('hdnUser')
								
							);
								$used_unit_id = intval($unit_id[$i]);
							
								$this->M_serviceproducts->updateConnectUnit($data_unit[$i],$used_unit_id);
								
						}
						//data header dinputkan terakhir agar dapat dicek status line terlebih dahulu
						
						//$result = $this->M_serviceproducts->checkForClose($plaintext_string);
						//$date = '1-'.$this->input->post('txtHarvestTime');
						//$harvest_time = date_create($date);
						if($this->input->post('txtHarvestTime')!=="")
						{
							$harvest_time = '1-'.$this->input->post('txtHarvestTime');
						}else{
							$harvest_time = NULL;
						}
						$data = array(
							'connect_status' 			=> $connect_status,
							'connect_date' 				=> $this->input->post('txtServiceDate'),
							//'connect_type' 				=> $this->input->post('slcActivityType'),
							'other_type' 				=> $this->input->post('txtOtherType'),
							'description' 				=> $this->input->post('txtDescription'),
							'harvest_time' 				=> $harvest_time,
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser'),
							'line_operator' 			=> $this->input->post('txtLineOperator'),
							'employee_id ' 				=> $this->input->post('slcEmployeeNum')
							
						);
				
						$this->M_serviceproducts->updateConnect($data,$plaintext_string);
						
						$service = array(
							'connect_id' 				=> $plaintext_string
						);
						$service_id = $this->input->post('slcServiceNum');
						if($service_id!=""){
							$this->M_serviceproducts->updateServiceProducts($service,$service_id);
						}
						
						$faq_type = $this->input->post('slcFaqType');
						$faq_description1 = $this->input->post('txtFaqDescription1');
						$faq_description2 = $this->input->post('txtFaqDescription2');
						$faq_id = $this->input->post('hdnFaqId');
						$count2 = count($faq_description1);
						
						$data_faqs1 = array();
						$data_faqs2 = array();
						for($i=0; $i<$count2; $i++) {
							if($faq_description1[$i] != ''){
								$data_faqs1[$i] = array(
									'faq_type'					=> $faq_type[$i],
									'faq_description1'			=> strtoupper($faq_description1[$i]),
									'faq_description2'			=> strtoupper($faq_description2[$i]),
									//'service_product_id'		=> $plaintext_string,
									'service_connect_id'		=> $plaintext_string,
									'from_table'				=> 'cr_connect_headers',
									'last_update_date' 			=> $this->input->post('hdnDate'),
									'last_update_by' 			=> $this->input->post('hdnUser')
								);
								
								$data_faqs2[$i] = array(
									'faq_type'					=> $faq_type[$i],
									'faq_description1'			=> strtoupper($faq_description1[$i]),
									'faq_description2'			=> strtoupper($faq_description2[$i]),
									//'service_product_id'		=> $plaintext_string,
									'service_connect_id'		=> $plaintext_string,
									'from_table'				=> 'cr_connect_headers',
									'last_update_date' 			=> $this->input->post('hdnDate'),
									'last_update_by' 			=> $this->input->post('hdnUser'),
									'creation_date' 			=> $this->input->post('hdnDate'),
									'created_by' 				=> $this->input->post('hdnUser')
								);								
							}
							$faqs_id = intval($faq_id[$i]);
							if(count($data_faqs1) != 0){ 
								if($faqs_id == 0){
									$this->M_serviceproducts->setServiceProductFaqs($data_faqs2[$i]);
									//echo "1";print_r ($id);echo "|";
								}
								else{
									$this->M_serviceproducts->updateServiceProductFaqs($data_faqs1[$i],$faqs_id);
									//echo "2";print_r ($id);echo "|";
								}
							}
						}
						
						$data_contact = array(
							'name'					=> $this->input->post('txtServiceNumber'),
							'data'					=> $this->input->post('slcContact'),
							'type' 					=> $this->input->post('slcContactType'),
							'connector_id' 			=> $this->input->post('hdnCustomerId'),
							'table' 				=> 'cr.cr_customers',
							'creation_date' 		=> $this->input->post('hdnDate'),
							'created_by' 			=> $this->input->post('hdnUser')
						);
						
						$save = $this->input->post('chkSave');
						$check_contact = $this->M_customercontacts->getCustomerNumber($this->input->post('slcContact'));
						if(count($check_contact)== 0 && $save == 'Save'){
							$this->M_customercontacts->setCustomerContacts($data);
						}						
						
						//endforeach;
						//print_r ($data_faqs2);
						//print_r ($service_lines_id[1]);
						//$encrypted_string = $this->encrypt->encode($id);
						//$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
						redirect('CustomerRelationship/ServiceProducts/UpdateConnect/'.$id);
				}
		}

		public function Create()
		{		$this->form_validation->set_rules('txtServiceNumber', 'Service Number', 'required');
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['problem'] = $this->M_serviceproblem->getServiceProblem();
				//$data['servicestatus'] = $this->M_servicelinestatus->getServiceLineStatus();
				$data['Checklist'] = $this->M_Checklist->getChecklistActive();
				$data['AdditionalActivity'] = $this->M_additionalactivity->getAdditionalActivity();
				 
				$data['title'] = 'New Service';
				$data['province']	= $this->M_serviceproducts->province();
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Activity';
						$data['SubMenuOne'] = '';
						$data['notif'] 	= '';

						//----Insert data ke table temporary dulu.
						if ($this->session->userdata('tempServiceNumber')) {
							$id 		= $this->session->userdata('tempServiceNumber');
							$data 		= $this->M_serviceproducts->getServiceNumber($id);
							$actNumb 	= $data[0]['activity_number'];
							$data['imgClaim'] = $this->M_serviceproducts->getDataClaimImage($actNumb);
						}else
						{
							$dataTemp = array(
								'created_by'		=> $user_id,
								'creation_date'		=> date("Y-m-d H:i:s")
							);
							$data['id']	= $this->M_serviceproducts->setNewActivityTemp($dataTemp);
							$data['imgClaim'] = NULL;
							$this->session->set_userdata('tempServiceNumber', $data['id']);
						}
						
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_create', $data);
						$this->load->view('V_Footer',$data);
				}
				else
				{
					$customerName 	= $this->input->post('txtCustomerName');
					$con_id = $this->input->post('slcConnectNum');
					$custdata		= $this->M_serviceproducts->customerDataEC($customerName);
					$custId 		= $custdata[0]['oracle_customer_id'];
					$own_phone		= $custdata[0]['data'];
					$own_address	= $custdata[0]['address'];
					$durationUse = $this->input->post('durationUse');
					$durationUseType = $this->input->post('durationUseType');
						$duration_of_use = $durationUse.' '.$durationUseType;
					$sentDate 	= $this->input->post('sentDate');
						if ($sentDate==NULL) {$shipped = 'NO';}
						else {$shipped = 'YES';}
					$reasonVal 	= $this->input->post('reason');
						if ($reasonVal == NULL) {$reason = 'NO REASON';}
						else{$reason = $reasonVal;}
					if ($sentDate == NULL AND $reasonVal == NULL) {$noEvidence = 'YES';}
					else{$noEvidence = 'NO';}
					$area 				= $this->input->post('area');
						$landCategory 	= implode($area, ', ');
					$Soil 				= $this->input->post('Soil');
						$typeOfSoil 	= implode($Soil, ', ');
					$Depth 				= $this->input->post('Depth');
						$landDepth 		= implode($Depth, ', ');
					$Weeds 				= $this->input->post('Weeds');
						$WeedsItem 		= implode($Weeds, ', ');
					$Topography 		= $this->input->post('Topography');
						$TopographyItem = implode($Topography, ', ');
					if($con_id == ''){	$con_id = NULL; }
						$data_headers = array(
							'service_number'			=> $this->input->post('txtServiceNumber'),
							'service_status'			=> $this->input->post('txtActivityStatus'),
							'service_date' 				=> $this->input->post('txtServiceDate'),
							'service_type' 				=> $this->input->post('slcActivityType'),
							'claim_method' 				=> $this->input->post('txtOtherType'),
							'description' 				=> $this->input->post('txtDescription'),
							'feedback' 					=> $this->input->post('txtFeedback'),
							'connect_id' 				=> $con_id,
							'customer_id' 				=> $this->input->post('hdnCustomerId'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser'),
							'user_id' 					=> $this->input->post('hdnUser'),
							'cust_account_id' 			=> $custId,
							'owner_name' 				=> $customerName,
							'owner_address' 			=> $own_address,
							'owner_phone_number' 		=> $own_phone,
							'duration_of_use' 			=> $duration_of_use,
							'location_address' 			=> $this->input->post('AddressIncident'),
							'location_village' 			=> $this->input->post('VillageIncident'),
							'location_district' 		=> $this->input->post('DistrictIncident'),
							'location_city' 			=> $this->input->post('CityIncident'),
							'location_province' 		=> $this->input->post('provinceIncident'),
							'shipped' 					=> $shipped,
							'shipment_date' 			=> $sentDate,
							'not_shipped_reason' 		=> $reason,
							'no_evidence' 				=> $noEvidence,
							'land_category' 			=> $landCategory,
							'type_of_soil' 				=> $typeOfSoil,
							'land_depth' 				=> $landDepth,
							'weeds' 					=> $WeedsItem,
							'topography' 				=> $TopographyItem,
							'event_chronology' 			=> $this->input->post('Chronology'),
							'officer_id' 				=> $this->input->post('officer'),
							'qty'						=> $this->input->post('QtyClaim')
						);

						//$service_id = 0;
						$this->M_serviceproducts->setServiceProducts($data_headers);
						$service_id = $this->M_serviceproducts->getServiceProductNumber($data_headers['service_number']);
						$service_aidi = $service_id[0]['service_product_id'];
						
						//$count = count($this->input->post('txtProblemDescription'));
						//$count = sizeof($_POST['txtProblemDescription']);
						//if($count = NULL){$count=1;}
						
						$problem_description 	= $this->input->post('txtProblemDescription');
						$action 				= $this->input->post('txtAction');
						$action_date 			= $this->input->post('txtActionDate');
						//$finish_date 			= $this->input->post('txtFinishDate');
						$ownership_id 			= $this->input->post('hdnOwnershipId');
						//$tech_id 				= $this->input->post('slcEmployeeNum');
						$warranty 				= $this->input->post('txtWarranty');
						$claim_number 			= $this->input->post('txtClaimNum');
						$spare_part 			= $this->input->post('slcSparePart');
						$line_status 			= $this->input->post('slcServiceLineStatus');
						$problem 				= $this->input->post('slcProblem');
						$actionClaim 			= $this->input->post('actionClaim');
						$count1 				= count($ownership_id);
						$imgLines 				= $this->input->post('claimImageData');
						
						$data_lines =array();
						for($i=0; $i<$count1; $i++) {
						//foreach($problem_description as $prob => $i):
							if($ownership_id[$i] == '')
							{	$ownership_id[$i] = NULL; }
							//if($action_date[$i] == '')
							//{	$action_date[$i] = NULL; }
							//if($finish_date[$i] == '')
							//{	$finish_date[$i] = NULL; }
							//if($tech_id[$i] == '')
							//{	$tech_id[$i] = NULL; }
							if($spare_part[$i] == '')
							{	$spare_part[$i] = NULL; }
							//if($line_status[$i] == '')
							//{	$line_status[$i] = NULL; }
							if($problem[$i] == '')
							{	$problem[$i] = NULL; }
							if($claim_number[$i] == '')
							{	$claim_number[$i] = NULL; }
							//$cs_id[$i]=1;
							if($ownership_id[$i] != NULL){
								$data_lines[$i] = array(
								'problem_description'		=> $problem_description[$i],
								'action'					=> $action[$i],
								//'action_date' 				=> $action_date[$i],
								'warranty'					=> $warranty[$i],
								'claim_number'				=> $claim_number[$i],
								//'technician_id' 			=> $tech_id[$i],
								'service_product_id'		=> $service_aidi,
								'ownership_id' 				=> $ownership_id[$i],
								'creation_date' 			=> $this->input->post('hdnDate'),
								'created_by' 				=> $this->input->post('hdnUser'),
								'spare_part_id' 			=> $spare_part[$i],
								//'line_status' 				=> $line_status[$i],
								'problem_id' 				=> $problem[$i],
								'process' 					=> $actionClaim[$i],
								'service_product_line_image_id'=> $imgLines[$i]
								);
							}
							if(count($data_lines[$i]) != 0){
								$this->M_serviceproducts->setServiceProductLines($data_lines[$i]);
								$lines_id = $this->M_serviceproducts->getServiceProductLinesId();
								// $idImgLine = explode(',', $imgLines[$i]);
								// $dataUpdateImgLine =	array(
								// 							'service_product_line_id' => $lines_id,
								// 							'last_update_date' => $this->input->post('hdnDate'),
								// 							'last_updated_by' => $this->input->post('hdnUser')
								// 						);
								// $updateImageDataLine 	= $this->M_serviceproducts->updateImageDataLine($dataUpdateImgLine, $id);
								unset($data_lines[$i]['creation_date']);
								unset($data_lines[$i]['created_by']);
								unset($data_lines[$i]['claim_number']);
								$data_lines[$i]['service_product_line_id'] = $lines_id[0]['service_product_line_id'];
								$this->M_serviceproducts->setServiceProductLineHistories($data_lines[$i]);
							}
						}
						//endforeach;
						
						$faq_type = $this->input->post('slcFaqType');
						$faq_description1 = $this->input->post('txtFaqDescription1');
						$faq_description2 = $this->input->post('txtFaqDescription2');
						$count2 = count($faq_description1);
						
						$data_faqs = array();
						for($i=0; $i<$count2; $i++) {
							if($faq_description1[$i] != ''){
								$data_faqs[$i] = array(
									'faq_type'					=> $faq_type[$i],
									'faq_description1'			=> strtoupper($faq_description1[$i]),
									'faq_description2'			=> strtoupper($faq_description2[$i]),
									'service_connect_id'		=> $service_aidi,
									'from_table'				=> 'cr_service_products',
									'creation_date' 			=> $this->input->post('hdnDate'),
									'created_by' 				=> $this->input->post('hdnUser')
								);
								
							}
							if(count($data_faqs) != 0){
								$this->M_serviceproducts->setServiceProductFaqs($data_faqs[$i]);
							}
						}
						
						
						$add_act = $this->input->post('txtAdditionalAct');
						$desc = $this->input->post('txtActDescription');
						$count3 = count($add_act);
						
						$data_add_act = array();
						for($i=0; $i<$count3; $i++) {
							if($add_act[$i] != ''){
								$data_add_act[$i] = array(
									
									'additional_activity'		=> $add_act[$i],
									'service_product_id'		=> $service_aidi,
									'description'				=> $desc[$i]
								);
								
							}
							if(count($data_add_act) != 0){
								$this->M_serviceproducts->setServiceProductAddAct($data_add_act[$i]);
							}
						}
						$id = $this->session->userdata('tempServiceNumber');
						$this->M_serviceproducts->deleteActivityTemp($id);
						$this->session->unset_userdata('tempServiceNumber');
						redirect('CustomerRelationship/ServiceProducts');
				}
		}

		public function CreateConnect()
		{		$this->form_validation->set_rules('txtServiceNumber', 'Service Number', 'required');
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

				$data['Menu'] = 'activity';
				$data['Checklist'] = $this->M_Checklist->getChecklistActive();

				$data['title'] = 'New Connect';
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Activity';
						$data['SubMenuOne'] = '';
						//$this->load->view('templates/header', $data);
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_create_connect', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{	
						if($this->input->post('txtHarvestTime')!=="")
						{
							$harvest_time = '1-'.$this->input->post('txtHarvestTime');
						}else{
							$harvest_time = NULL;
						}
						$data_headers = array(
							'connect_number'			=> $this->input->post('txtServiceNumber'),
							'connect_status'			=> $this->input->post('txtActivityStatus'),
							'connect_date' 				=> $this->input->post('txtServiceDate'),
							'connect_type' 				=> $this->input->post('slcActivityType'),
							'other_type' 				=> $this->input->post('txtOtherType'),
							'description' 				=> $this->input->post('txtDescription'),
							'harvest_time' 				=> $harvest_time,
							'employee_id ' 				=> $this->input->post('slcEmployeeNum'),
							'customer_id' 				=> $this->input->post('hdnCustomerId'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser'),
							'contact_type' 				=> $this->input->post('slcContactType'),
							'contact_number' 			=> $this->input->post('slcContact'),
							'line_operator' 			=> $this->input->post('txtLineOperator')
						);
						

						//$service_id = 0;
						$this->M_serviceproducts->setConnect($data_headers);
						$connect_id = $this->M_serviceproducts->getConnectId();
						$connect_idi = $connect_id[0]['connect_id'];
						
						$service = array(
							'connect_id' 				=> $connect_idi
						);
						$service_id = $this->input->post('slcServiceNum');
						if($service_id!=""){
							$this->M_serviceproducts->updateServiceProducts($service,$service_id);
						}
						
						//$count = count($this->input->post('txtProblemDescription'));
						//$count = sizeof($_POST['txtProblemDescription']);
						//if($count = NULL){$count=1;}
						
						$ownership_id = $this->input->post('hdnOwnershipId');
						$count1 = count($ownership_id);
						$segment1 = $this->input->post('txtOwnership');
						$description = $this->input->post('txtItemDescription');
						$body_num = $this->input->post('txtBody');
						$engine_num = $this->input->post('txtEngine');
						$use = $this->input->post('txtUse');
						
						$units =array();
						for($i=0; $i<$count1; $i++) {
						//foreach($problem_description as $prob => $i):
							if($ownership_id[$i] == '')
							{	$ownership_id[$i] = NULL; }
							if($segment1[$i] == '')
							{	$segment1[$i] = NULL; }
							if($description[$i] == '')
							{	$description[$i] = NULL; }
							if($body_num[$i] == '')
							{	$body_num[$i] = NULL; }
							if($engine_num[$i] == '')
							{	$engine_num[$i] = NULL; }
							if($use[$i] == '')
							{	$use[$i] = NULL; }
							
							if($use[$i] != NULL){
								$units[$i] = array(
								'ownership_id'				=> $ownership_id[$i],
								'segment1'					=> $segment1[$i],
								'description' 				=> $description[$i],
								'body_num' 					=> $body_num[$i],
								'engine_num'				=> $engine_num[$i],
								'use'						=> $use[$i],
								'creation_date' 			=> $this->input->post('hdnDate'),
								'created_by' 				=> $this->input->post('hdnUser'),
								'connect_id'				=> $connect_idi,
								);							
							}
							if(count($units) != 0){ 
								$this->M_serviceproducts->setConnectUnit($units[$i]);
							}
							
						}
						//endforeach;
						
						$faq_type = $this->input->post('slcFaqType');
						$faq_description1 = $this->input->post('txtFaqDescription1');
						$faq_description2 = $this->input->post('txtFaqDescription2');
						$count2 = count($faq_description1);
						
						$data_faqs = array();
						for($i=0; $i<$count2; $i++) {
							if($faq_description1[$i] != ''){
								$data_faqs[$i] = array(
									'faq_type'					=> $faq_type[$i],
									'faq_description1'			=> strtoupper($faq_description1[$i]),
									'faq_description2'			=> strtoupper($faq_description2[$i]),
									'service_connect_id'		=> $connect_idi,
									'from_table'				=> 'cr_connect_headers',
									'creation_date' 			=> $this->input->post('hdnDate'),
									'created_by' 				=> $this->input->post('hdnUser')
								);
								
							}
							if(count($data_faqs) != 0){ 						
								$this->M_serviceproducts->setServiceProductFaqs($data_faqs[$i]);
							}
						}
						
						/*
						$add_act = $this->input->post('txtAdditionalAct');
						$desc = $this->input->post('txtDescription');
						$count3 = count($add_act,$desc);
						
						$data_add_act = array();
						for($i=0; $i<$count2; $i++) {
							if($add_act[$i] != ''){
								$data_add_act[$i] = array(
									
									'additional_activity'	=> $add_act[$i],
									'service_product_id'	=> $service_aidi,
									'description'			=> $desc
								);
								
							}
							if(count($data_add_act) != 0){ 						
								$this->M_serviceproducts->setServiceProductAddAct($data_add_act[$i]);
							}
						}
						*/
						$data_contact = array(
							'name'					=> $this->input->post('txtServiceNumber'),
							'data'					=> $this->input->post('slcContact'),
							'type' 					=> $this->input->post('slcContactType'),
							'connector_id' 			=> $this->input->post('hdnCustomerId'),
							'table' 				=> 'cr.cr_customers',
							'creation_date' 		=> $this->input->post('hdnDate'),
							'created_by' 			=> $this->input->post('hdnUser')
						);

						/*if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }
						if($data['customer_status_id'] == '')
						{	$data['customer_status_id'] = NULL; }
						if($data['customer_group_id'] == '')
						{	$data['customer_group_id'] = NULL; }
						*/
						$save = $this->input->post('chkSave');
						$check_contact = $this->M_customercontacts->getCustomerNumber($this->input->post('slcContact'));
						if(count($check_contact)== 0 && $save == 'Save'){
							$this->M_customercontacts->setCustomerContacts($data_contact);
						}
						
						redirect('CustomerRelationship/ServiceProducts');
						
						//print_r($service_aidi);
						//print_r($data_lines[$i]);
						
				}
		}
		
		public function Location()
		{
			$name 	= $this->input->post('data_name');
			$modul 	= $this->input->post('modul');
	
			echo '
				<option value=""></option>
				<option value="muach" disabled >-- Choose One --</option>
			';
			if ($modul == 'CityRegency') {
				$data = $this->M_serviceproducts->cityRegency($name);
				foreach ($data as $data) {
					echo '<option value="'.$data['regency_name'].'">'.strtoupper($data['regency_name']).'</option>';
				}
			}
			elseif ($modul == 'District') {
				$data = $this->M_serviceproducts->district($name);
				foreach ($data as $data) {
					echo '<option value="'.$data['district_name'].'">'.strtoupper($data['district_name']).'</option>';
				}
			}
			elseif ($modul == 'Village') {
				$data = $this->M_serviceproducts->village($name);
				foreach ($data as $data) {
					echo '<option value="'.$data['village_name'].'">'.strtoupper($data['village_name']).'</option>';
				}
			}
		}
		public function shipped(){
			$this->load->view('CustomerRelationship/MainMenu/ServiceProducts/V_shipped');
		}

		public function Approval($id)
		{
			$plaintext_string 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$plaintext_string 	= $this->encrypt->decode($plaintext_string);
			$serviceid 			= $this->input->post('ServiceProductId');
			$stat 				= $this->input->post('status');
			$approver 			= $this->input->post('hdnUser');
			$approve_date 		= $this->input->post('hdnDate');
			$type 				= $this->input->post('approveval');
			if ($type == 'N' AND $stat == 'BRANCH APPROVAL') {
				$reason	= $this->input->post('reasonnotapprove');
				$status = 'NOT APPROVED 1';
				$this->M_serviceproducts->noApprove($plaintext_string,$serviceid,$status,$approver,$approve_date,$reason);

			}elseif ($type == 'N' AND $stat == 'CENTRAL APPROVAL') {
				$reason	= $this->input->post('reasonnotapprove');
				$status = 'NOT APPROVED 2';
				$this->M_serviceproducts->noApprove($plaintext_string,$serviceid,$status,$approver,$approve_date,$reason);

			}elseif (($type == 'Y' or $type == NULL) AND $stat == 'CENTRAL APPROVAL') {
				$status = $stat;
				$header = $this->M_serviceproducts->getServiceProducts($serviceid);
				$custId 		= $header[0]['cust_account_id'];
				$customerName	= $header[0]['owner_name'];
				$own_address 	= $header[0]['owner_address'];
				$own_phone 		= $header[0]['owner_phone_number'];
				$province 		= $header[0]['location_province'];
				$City 			= $header[0]['location_city'];
				$District 		= $header[0]['location_district'];
				$Village 		= $header[0]['location_village'];
				$Address 		= $header[0]['location_address'];
				$duration 		= $header[0]['duration_of_use'];
				$shipped 		= $header[0]['shipped'];
				$shipment_date 	= $header[0]['shipment_date'];
				$reason 		= $header[0]['not_shipped_reason'];
				$noEvidence 	= $header[0]['no_evidence'];
				$landCategory 	= $header[0]['land_category'];
				$typeOfSoil 	= $header[0]['type_of_soil'];
				$landDepth 		= $header[0]['land_depth'];
				$WeedsItem 		= $header[0]['weeds'];
				$TopographyItem = $header[0]['topography'];
				$Chronology 	= $header[0]['event_chronology'];
				$created_by 	= $header[0]['officer_code'];
				$oraInsert		= $this->M_serviceproducts->processClaimHeader($custId,$customerName,$own_address,$own_phone,$province,$City,$District,$Village,$Address,$duration,$shipped,$shipment_date,$reason,$noEvidence,$landCategory,$typeOfSoil,$landDepth,$WeedsItem,$TopographyItem,$Chronology,$created_by);
				$this->M_serviceproducts->approval($plaintext_string,$serviceid,$status,$approver,$approve_date);

			}elseif ($type == 'Y' or $type == NULL) {
				$status = $stat;
				$this->M_serviceproducts->approval($plaintext_string,$serviceid,$status,$approver,$approve_date);
			}

			redirect('CustomerRelationship/ServiceProducts');
		}

		function getCustVal()
		{
			$idTmp	= $this->session->userdata('tempServiceNumber');
			$data 	= array(
				'customer_id'		=> $_POST['id'],
				'last_updated_by'	=> $this->session->userid,
				'last_update_date'	=> date("Y-m-d H:i:s")
			);
			$saveDbTemporary = $this->M_serviceproducts->updateTempCustId($data,$idTmp);
		}
		public function UploadImage()
		{
			$id 	= $this->session->userdata('tempServiceNumber');
			$data 	= $this->M_serviceproducts->getServiceNumber($id);
			$year	= date("Y");
			$time 	= date('d/m/YHms');
			$type 	= substr($_FILES['qqfile']['type'],6);

			$config['upload_path']          = './assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year.'/'.$data[0]['activity_number'];
	       	//$config['file_name']         	= 'Claim_Image_';
	       	$config['remove_spaces']        = TRUE;
	       	$config['allowed_types']        = '*';
	       	$config['max_size']             = 10000;
	       	$config['max_width']            = 2562;
	       	$config['max_height']           = 2050;
	       	$this->upload->initialize($config);

	       	if(!is_dir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id']))
	       	{
	       		mkdir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'], 0777, true);
	       		chmod('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'], 0777);
	       	}

	       	if(!is_dir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year))
	       	{
	       		mkdir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year, 0777, true);
	       		chmod('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year, 0777);
	       	}

	       	$dir_exist = true;

	       	if (!is_dir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year.'/'.$data[0]['activity_number']))
	       	{
	       		mkdir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year.'/'.$data[0]['activity_number'], 0777, true);
	       		chmod('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year.'/'.$data[0]['activity_number'], 0777);
	       		$dir_exist = false;
	       	}else{}
	       	
	       	if ($this->upload->do_upload('qqfile')) {
	       		$img = array(
	       			'service_number' 	=> $data[0]['activity_number'],
	       			'image_name' 		=> '/assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year.'/'.$data[0]['activity_number'].'/'.$_FILES['qqfile']['name'],
	       			'type' 				=> $type,
	       			'customer_id'		=> $data[0]['customer_id'],
	       			'creation_date' 	=> 'now()',
	       			'created_by' 		=> $this->session->userid
	       			);
	       		$this->M_serviceproducts->setDataClaimImage($img);
           		$this->upload->data();
       		} else {
       			if(!$dir_exist){
       				rmdir('./assets/upload_cr/ServiceProducts/'.$data[0]['customer_id'].'/'.$year.'/'.$data[0]['activity_number']);
       			}
       			$errorinfo = $this->upload->display_errors();
           		echo $errorinfo;
       		}
		}

		public function getImageData(){
			$id 	= $this->session->userdata('tempServiceNumber');
			$data 	= $this->M_serviceproducts->getServiceNumber($id);
			$service_number = $data[0]['activity_number'];
			$getImageData = $this->M_serviceproducts->getImageData($service_number);
			echo '<div id="modalImg-content">';
      		foreach ($getImageData as $ic) {
        	    echo '
        	    	<div class="col-lg-3 col-md-4 col-xs-6" style="padding-top: 15px;">
        	    		<input id="'.$ic['service_product_image_id'].'" type="hidden" name="imgLineSelect[]" value="'.$ic['service_product_image_id'].'" disabled>
        	        	<img id="img'.$ic['service_product_image_id'].'" onclick="checkThis('.$ic['service_product_image_id'].')" class="img-responsive" style="width: 100%; height: 150px; padding-top: 15px;" src="'.base_url($ic['image_name']).'">
        	    	</div>
        	    ';
        	}
      		echo '</div>';
		}

		public function ChooseImage(){
			$image_id 	= $this->input->post('imgLineSelect');
			$ownerId 	= $this->input->post('txtOwnerId');
			$rowId 		= $this->input->post('txtLineId');
			$no 		= 0;
			foreach ($image_id as $img) {
				$dataImg 		= $this->M_serviceproducts->getDataSelectedImg($image_id[$no++]);
				$dataImgLine	= 	array(
										'service_product_image_id' => $dataImg[0]['service_product_image_id'],
										'ownership_id' 	=> $ownerId,
										'row_id' 		=> $rowId,
										'creation_date' => 'now()',
										'created_by' 	=> $this->session->userid
									);
				$saveImgData 	= $this->M_serviceproducts->setImageDataLine($dataImgLine);
				$id_img[] = $saveImgData;
			}
			$line 		= "";
			$i = count($id_img);
			foreach ($id_img as $imgL) {
				$i--;
				if ($i == 0) {
					$line .= $imgL;
				}
				else{
					$line .= $imgL.',';
				}
			}
			echo $line;
		}

		public function ChooseImageUpdate(){
			$image_id 	= $this->input->post('imgLineSelect');
			$ownerId 	= $this->input->post('txtOwnerId');
			$rowId 		= $this->input->post('txtLineId');
			$no 		= 0;
			$deleteDataLine	= $this->M_serviceproducts->deleteImageDataLine($ownerId,$rowId);
			foreach ($image_id as $img) {
				$dataImg 		= $this->M_serviceproducts->getDataSelectedImg($image_id[$no++]);
				$dataImgLine	= 	array(
										'service_product_image_id' => $dataImg[0]['service_product_image_id'],
										'ownership_id' 	=> $ownerId,
										'row_id' 		=> $rowId,
										'creation_date' => 'now()',
										'created_by' 	=> $this->session->userid
									);
				$saveImgData 	= $this->M_serviceproducts->setImageDataLine($dataImgLine);
				$id_img[] = $saveImgData;
			}
			$line 		= "";
			$i = count($id_img);
			foreach ($id_img as $imgL) {
				$i--;
				if ($i == 0) {
					$line .= $imgL;
				}
				else{
					$line .= $imgL.',';
				}
			}
			echo $line;
		}

		function getImageDataUpdate(){
			$selected 		= $this->input->post('selected');
			$serviceNumb 	= $this->input->post('serviceNumb');
			$getImageData 	= $this->M_serviceproducts->getImageData($serviceNumb);
			$i=0;
      		if ($getImageData == NULL) {
      			echo '0';
      		}elseif ($selected !== '') {
				$selImg 		= explode(',', $selected);
				echo '<div id="modalImg-content">';
      			$selected_image = array();
      			foreach ($selImg as $si) {
      				$imgId = $this->M_serviceproducts->getImgIdSelected($selImg[$i++]);
      				array_push($selected_image, $imgId[0]['service_product_image_id']);
      			}
      			foreach ($getImageData as $ic) {
      				$status="";
      				$disabled="disabled";
      				if(in_array($ic['service_product_image_id'], $selected_image)){
      					$status="img-selected";
      					$disabled="";
      				}
        			echo '
        			  	<div class="col-lg-3 col-md-4 col-xs-6" style="padding-top: 15px;">
    	 	   	   		<input id="'.$ic['service_product_image_id'].'" type="hidden" name="imgLineSelect[]" value="'.$ic['service_product_image_id'].'"'.$disabled.'>
	        		       	<img id="img'.$ic['service_product_image_id'].'" onclick="checkThis('.$ic['service_product_image_id'].')" class="img-responsive '.$status.' " style="width: 100%; height: 150px; padding-top: 15px;" src="'.base_url($ic['image_name']).'">
	        		   	</div>
        	    		';
      			}
      			echo '</div>';
      		}else{
      			foreach ($getImageData as $ic) {
        			echo '
        			  	<div class="col-lg-3 col-md-4 col-xs-6" style="padding-top: 15px;">
    	 	   	   		<input id="'.$ic['service_product_image_id'].'" type="hidden" name="imgLineSelect[]" value="'.$ic['service_product_image_id'].'" disabled>
	        		       	<img id="img'.$ic['service_product_image_id'].'" onclick="checkThis('.$ic['service_product_image_id'].')" class="img-responsive" style="width: 100%; height: 150px; padding-top: 15px;" src="'.base_url($ic['image_name']).'">
	        		   	</div>
        	    		';
      			}
      		}
		}
}