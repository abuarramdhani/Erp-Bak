<?php
class C_Search extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('InventoryManagement/MainMenu/M_deliveryrequest');
				$this->load->helper('form');
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
		{
				$data['ServiceProducts'] = $this->M_serviceproducts->getServiceProducts();
				//$data['ServiceProductLines'] = $this->M_serviceproducts->getServiceProductLines();
				$data['title'] = 'Activity';

				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'serviceProduct';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/ServiceProducts/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function DeliveryItem()
		{		$id = strtoupper($this->input->get('term'));
				$data['DeliveryItem'] = $this->M_deliveryrequest->getItemDelivery($id);
				echo json_encode($data['DeliveryItem']);
				
		}
		
		public function OracleEmployee()
		{		$id = strtoupper($this->input->get('term'));
				$data = $this->M_deliveryrequest->getPeople($id);
				echo json_encode($data);
				
		}
		
		public function InvOrg()
		{		$id = strtoupper($this->input->get('term'));
				$data = $this->M_deliveryrequest->getInventoryOrganization($id);
				echo json_encode($data);
				
		}
		
		public function SubIo()
		{		$io = strtoupper($this->input->get('term2'));
				$sub_io = strtoupper($this->input->get('term'));
				$data = $this->M_deliveryrequest->getSubIo($io,$sub_io);
				echo json_encode($data);
				
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
		public function Customer($id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				
				
				$data['Customer'] = $this->M_customer->getCustomerActive($id);
				$data['title'] = 'Customer';
				//$this->load->view('templates/header', $data);

				$this->load->view('CustomerRelationship/Additional/Search/V_search_customer', $data);
		}
		
		
		public function Employee($rowid,$id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				$id = str_replace("NULL", "", $id);
				
				$data['Employee'] = $this->M_employee->getEmployee($id);
				$data['title'] = 'Employee';
				$data['rowid'] = $rowid;
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_employee', $data);
		}
		
		public function Item($id = FALSE)
		{		
				$id = str_replace("~", " ", $id);
		
				$data['Item'] = $this->M_item->getItemHarvester($id);
				$data['title'] = 'Item';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_item', $data);
		}
		
		public function SparePart($rowid, $id = FALSE)
		{		
				$id = str_replace("~", "%", $id);
				$id = str_replace("%20", " ", $id);
				$id = str_replace("NULL", "", $id);
				$id = str_replace("%999", "%", $id);
		
				$data['Item'] = $this->M_item->getItemSparePart($id);
				$data['title'] = 'Spare part';
				$data['rowid'] = $rowid;
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_item_spare_part', $data);
		}
		
		public function Ownership()
		{		/*$id = str_replace("~", "%", $id);
				$id = str_replace("%20", " ", $id);
				$id = str_replace("NULL", "", $id);
				$id = str_replace("%999", "%", $id);*/
				$cust = $this->input->post("cust");
				$id='';
				$data['Ownership'] = $this->M_ownership->getOwnershipService($id,$cust );
				//$data['title'] = 'Ownership';
				//$data['rowid'] = $rowid;
				//$this->load->view('templates/header', $data);
				//$this->load->view('CustomerRelationship/Additional/Search/V_search_ownership', $data);
				echo json_encode($data['Ownership']);
		}
		
		public function CustomerGroup()
		{		//$id = str_replace("~", " ", $id);
				//$id = str_replace("%20", " ", $id);
				
				$term = strtoupper($this->input->get('term'));
				$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroupName($term);
				//$data['title'] = 'Customer Group';
				//$this->load->view('templates/header', $data);
				//$this->load->view('CustomerRelationship/Additional/Search/V_search_customer_group', $data);
				echo json_encode($data['CustomerGroup']);
		}
		
		public function CustomerCategory($id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				
				$data['CustomerCategory'] = $this->M_customercategory->getCustomerCategoryName($id);
				$data['title'] = 'Customer Category';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_customer_category', $data);
		}
		
		public function BuyingType($id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				$id = str_replace("NULL", "", $id);
				
				$data['BuyingType'] = $this->M_buyingtype->getBuyingTypeName($id);
				$data['title'] = 'Buying Type';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_buying_type', $data);
		}
		
		public function CustomerDriver($id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				
				
				$data['CustomerDriver'] = $this->M_customer->getCustomerDriver($id);
				$data['title'] = 'CustomerDriver';
				//$this->load->view('templates/header', $data);

				$this->load->view('CustomerRelationship/Additional/Search/V_search_customer_driver', $data);
		}
		
		public function CustomerOwner($id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				
				
				$data['CustomerOwner'] = $this->M_customer->getCustomerOwner($id);
				$data['title'] = 'Owner';
				//$this->load->view('templates/header', $data);
				//echo json_encode($data['CustomerOwner']);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_customer_owner', $data);
		}
		
		public function CustomerAdditional($id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				
				
				$data['CustomerAdditional'] = $this->M_customeradditional->getCustomerAdditionalName($id);
				$data['title'] = 'Additional Information';
				//$this->load->view('templates/header', $data);

				$this->load->view('CustomerRelationship/Additional/Search/V_search_customer_additional', $data);
		}
		/*
		public function searchServiceLineStatus($rowid,$id = FALSE)
		{		$id = str_replace("~", " ", $id);
				$id = str_replace("%20", " ", $id);
				$id = str_replace("NULL", "", $id);
				
				$data['ServiceLineStatus'] = $this->M_servicelinestatus->getServiceLineStatusName2($id);
				$data['title'] = 'Status Name';
				$data['rowid'] = $rowid;
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Additional/Search/V_search_service_line_status', $data);
		}
		
		public function searchServiceLineStatus()
		{		$id = strtoupper($this->input->get('term'));
				$data['ServiceLineStatus'] = $this->M_servicelinestatus->getServiceLineStatusName($id);
				echo json_encode($data['ServiceLineStatus']);
				
		}*/
		
		public function ServiceProblem()
		{		$id = strtoupper($this->input->get('term'));
				$data['ServiceProblem'] = $this->M_serviceproblem->getServiceProblemName($id);
				echo json_encode($data['ServiceProblem']);
				
		}
		
		public function SparePartData()
		{		$id = strtoupper($this->input->get('term'));
				$data['SparePartData'] = $this->M_report->getSPSearch($id);
				echo json_encode($data['SparePartData']);
				
		}
		
		
		public function ItemData()
		{		$id = strtoupper($this->input->get('term'));
				$data['ItemData'] = $this->M_report->getItemLikeId($id);
				echo json_encode($data['ItemData']); 
				
		}
		
		public function EmployeeData()
		{		
				$id = strtoupper($this->input->get('term'));
				//$id = '';
				$data['EmployeeData'] = $this->M_report->getEmployeeLikeId($id);
				echo json_encode($data['EmployeeData']); 
				
		}
		
		public function BodyNumberData()
		{		$id = strtoupper($this->input->get('term'));
				$data['BodyNumberData'] = $this->M_report->getBNSearch($id);
				echo json_encode($data['BodyNumberData']);
				
		}
		
		public function EngineNumberData()
		{		$id = strtoupper($this->input->get('term'));
				$data['EngineNumberData'] = $this->M_report->getENSearch($id);
				echo json_encode($data['EngineNumberData']);
				
		}
		
		public function BuyingTypeData()
		{		$id = strtoupper($this->input->get('term'));
				$data['BuyingTypeData'] = $this->M_report->getBTSearch($id);
				echo json_encode($data['BuyingTypeData']);
				
		}
		
		public function OwnerNameData()
		{		$id = strtoupper($this->input->get('term'));
				$data['OwnerNameData'] = $this->M_report->getONSearch($id);
				echo json_encode($data['OwnerNameData']);
				
		}
		
		public function ProvinceData()
		{		$id = strtoupper($this->input->get('term'));
				$data['ProvinceData'] = $this->M_report->getProvinceSearch($id);
				echo json_encode($data['ProvinceData']);
				
		}
		
		public function CityData()
		{		$id = strtoupper($this->input->get('term'));
				$data['CityData'] = $this->M_report->getCitySearch($id);
				echo json_encode($data['CityData']);
				
		}
		
		public function AreaData()
		{		$id = strtoupper($this->input->get('term'));
				$data['AreaData'] = $this->M_report->getAreaSearch($id);
				echo json_encode($data['AreaData']);
				
		}
		
		public function DistrictData()
		{		$id = strtoupper($this->input->get('term'));
				$data['DistrictData'] = $this->M_report->getDistrictSearch($id);
				echo json_encode($data['DistrictData']);
				
		}
		
		public function VillageData()
		{		$id = strtoupper($this->input->get('term'));
				$data['VillageData'] = $this->M_report->getVillageSearch($id);
				echo json_encode($data['VillagetData']);
				
		}
		
		public function ServiceNumber()
		{		$input = strtoupper($this->input->get('term'));
				$cust_id = strtoupper($this->input->get('cust'));
				$activity = 'service';
				$data['ServiceNumber'] = $this->M_serviceproducts->getActivityNumber($activity,$cust_id,$input);
				echo json_encode($data['ServiceNumber']);
				
		}
		
		public function ConnectNumber()
		{		$input = strtoupper($this->input->get('term'));
				$cust_id = strtoupper($this->input->get('cust'));
				$activity = 'connect';
				$data['ConnectNumber'] = $this->M_serviceproducts->getActivityNumber($activity,$cust_id,$input);
				echo json_encode($data['ConnectNumber']);
				
		}
		
		/*public function searchAdditionalActivity($service_id)
		{		$term = strtoupper($this->input->get('term'));//term = karakter yang kita ketikkan
				$data['AdditionalActivity'] = $this->M_serviceproducts->getServiceProductAddActTerm($service_id,$term);
				echo json_encode($data['AdditionalActivity']);
				
		}*/
		
		public function AdditionalActivity()
		{		
				//if (isset($_GET['term'])){
					$term = strtoupper($this->input->get('term'));//term = id dari karakter yang kita ketikkan
					$data['AdditionalActivity'] = $this->M_serviceproducts->getServiceProductAddActTerm($term);
				echo json_encode($data['AdditionalActivity']);
				//}
				//echo $data['AdditionalActivity'];
		}
		
		public function FaqDescription()
		{		
				if (isset($_GET['term'])){
					$term = strtolower($_GET['term']);//term = id dari karakter yang kita ketikkan
					$faq_type = strtolower($_GET['faq_type']);
					$data['FaqDescription'] = $this->M_serviceproducts->getServiceProductFaqsTerm($term,$faq_type);
				//echo json_encode($data['AdditionalActivity']);
				}
				//echo $data['AdditionalActivity'];
		}

		
}

