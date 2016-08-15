<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DeliveryProcess extends CI_Controller {

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
			redirect('index');
		}
	}
	
	public function index()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->user;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Delivery Process';
		$data['Menu'] = 'Delivery Request';
		$data['SubMenuOne'] = 'Delivery Process';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';
		
		$org_id = $data['UserMenu'][0]['org_id'];
		$data['DeliveryRequest'] = $this->M_deliveryrequest->getDeliveryProcess(FALSE,$org_id);
		
		//Load halaman
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InventoryManagement/MainMenu/DeliveryProcess/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function DeliveryProcessComponent($delivery_id,$line_id)
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['Title'] = 'Delivery Request Component';
		$data['Menu'] = 'Delivery Request';//menu title
		$data['SubMenuOne'] = 'Delivery Process';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$plaintext_string1 = str_replace(array('-', '_', '~'), array('+', '/', '='), $delivery_id);
		$plaintext_string1 = $this->encrypt->decode($plaintext_string1);
		
		$plaintext_string2 = str_replace(array('-', '_', '~'), array('+', '/', '='), $line_id);
		$plaintext_string2 = $this->encrypt->decode($plaintext_string2);
		
		$data['ComponenHeader'] = $this->M_deliveryrequest->getDeliveryRequestLines($plaintext_string1,$plaintext_string2);
		$data['Component'] = $this->M_deliveryrequest->getComponent($plaintext_string1,$plaintext_string2, 'Y');
		$data['ComponentProcessed'] = $this->M_deliveryrequest->getItemProcessed($plaintext_string1,$plaintext_string2);
		
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
				$this->load->view('InventoryManagement/MainMenu/DeliveryProcess/V_componen',$data);
				$this->load->view('V_Footer',$data);
				// print_r($delivery_id);
				// echo "<br>";
				// print_r($line_id);

		}
		else
		{		
				$part_id = $this->input->post('hdnPartId');
				$qty = $this->input->post('txtQtyToProcess');
				$num = $this->M_deliveryrequest->getMoNumber();
				
				foreach($part_id as $i => $part_id_item){
					if($qty[$i]!="" and $qty[$i]!="0"){
						$data_lines[$i] = array(
							'DELIVERY_REQUEST_ID' 		=> intval($plaintext_string1),
							'LINE_ID' 					=> intval($plaintext_string2),
							'PART_ID' 					=> intval($part_id[$i]),
							'QUANTITY_PROCESSED' 		=> intval($qty[$i]),
							'MOVE_ORDER_NUMBER'			=> $num,
							'PROCESS_DATE' 				=> date("d-M-Y H:i:s"),
							'WORKER' 					=> $user
						);
					
						$this->M_deliveryrequest->setDeliveryProcessMo($data_lines[$i]);
							
					}
				}
				
				if($data['ComponenHeader'][0]['REQUEST_TYPE'] === 'UNIT'){
					$user = 'AA PMP1 TR 02';
				}else{
					$user = 'AA PMP2 TR 02';
				}
				
				$this->M_deliveryrequest->processMoveOrder($num,$data['ComponenHeader'][0]['DELIVERY_NUMBER'],$user);
				
				// print_r($data_lines);
				?>
					<script>alert('Move Order Number = <?php echo $num?>');
							window.location.href = '<?= base_url('InventoryManagement/DeliveryProcess/DeliveryProcessComponent/'.$delivery_id.'/'.$line_id)?>';
					</script>
					<?php
				// redirect('InventoryManagement/DeliveryProcess/DeliveryProcessComponent/'.$delivery_id.'/'.$line_id);
		}
			
		
	}
	
	public function UpdateDeliveryProcess($id)
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['Title'] = 'Process DeliveryRequest';
		$data['Menu'] = 'Delivery Request';//menu title
		$data['SubMenuOne'] = 'Delivery Process';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$org_id = $data['UserMenu'][0]['org_id'];
		$data['DeliveryRequest'] = $this->M_deliveryrequest->getDeliveryRequest($plaintext_string,$org_id);
		$data['DeliveryRequestLines'] = $this->M_deliveryrequest->getDeliveryRequestLines($plaintext_string);
		$data['ItemProcessed'] = $this->M_deliveryrequest->getItemProcessed($plaintext_string);
		// $data['Approver'] = $this->M_deliveryrequest->getApprover($user);
		
		$data['num'] = count($data['DeliveryRequestLines']);
		$data['id'] = $id;
		
		$this->form_validation->set_rules('txtDeliveryRequestNum', 'menuname', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('InventoryManagement/MainMenu/DeliveryProcess/V_process',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{		
				$qty = $this->input->post('txtQtyToProcess');
				$line_id = $this->input->post('hdnLineId');
				$btn = $this->input->post('btnDeliveryRequestApproval');
				$date = $this->input->post('hdnDate');
					
				$data_header = array(
					'CATEGORY	' 		=> 'P',
					'ORGANIZATION_ID' 	=> $this->input->post('slcIo'),
					'SUBINVENTORY' 		=> $this->input->post('slcSubInventory'),
					'TO_SUBINVENTORY' 	=> $this->input->post('slcToSubInventory'),
					'BLANKET' 			=> $this->input->post('txtBlanket'),
					'EXPEDITION' 		=> $this->input->post('txtExpedition'),
					'ENGINE' 			=> $this->input->post('slcEngine'),
					'TRACTOR' 			=> $this->input->post('slcTractor'),
					'LAST_UPDATE_DATE' 	=> date("d-M-Y H:i:s"),
					'LAST_UPDATED_BY' 	=> intval($this->input->post('hdnUser'))
				);
				
				$tes = $this->M_deliveryrequest->updateDeliveryRequest($data_header,intval($plaintext_string));
				$num = $this->M_deliveryrequest->getMoNumber();
				// print_r($data);
				if($btn == "" or !is_numeric($btn)){
					foreach($qty as $i => $loop){
						if($qty[$i]){
							$data_lines[$i] = array(
								'DELIVERY_REQUEST_ID' 		=> intval($plaintext_string),
								'LINE_ID' 					=> intval($line_id[$i]),
								'QUANTITY_PROCESSED' 		=> intval($qty[$i]),
								'MOVE_ORDER_NUMBER'			=> $num,
								'PROCESS_DATE' 				=> date("d-M-Y H:i:s"),
								'WORKER' 					=> $user
							);
						
							$this->M_deliveryrequest->setDeliveryProcessMo($data_lines[$i]);
								
						}
					}
					if($data['DeliveryRequest'][0]['REQUEST_TYPE'] === 'UNIT'){
						$user = 'AA PMP1 TR 02';
					}else{
						$user = 'AA PMP2 TR 02';
					}
					// print_r($data_lines);
					// print_r($qty); 
					$this->M_deliveryrequest->processMoveOrder($num,$data['DeliveryRequest'][0]['SEGMENT1'],$user);
					?>
					<script>alert('Move Order Number = <?php echo $num?>');
							window.location.href = '<?= base_url('InventoryManagement/DeliveryProcess/UpdateDeliveryProcess/'.$id)?>';
					</script>
					<?php
					// redirect('InventoryManagement/DeliveryProcess/UpdateDeliveryProcess/'.$id); 
					
					
				}
				else{
					$encrypted_string = $this->encrypt->encode($btn);
					$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
					
					redirect('InventoryManagement/DeliveryProcess/DeliveryProcessComponent/'.$id.'/'.$encrypted_string);
				}
		}
	
	}
}
