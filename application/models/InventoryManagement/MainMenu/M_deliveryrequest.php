<?php
class M_deliveryrequest extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getDeliveryRequest($id = FALSE,$org_id = FALSE)
		{	if($org_id == "82"){
				$and = "and kdr.org_id = kdr.org_id";
			}else{
				$and = "and kdr.org_id = $org_id";
			}
			
			if($id === FALSE){
				$sql = "select kdr.*,mp.organization_code,mp_interorg.organization_code interorg_organization_code,
						papf.national_identifier,papf.full_name
						from khs_delivery_requests kdr,
						mtl_parameters mp,
						mtl_parameters mp_interorg,
						per_all_people_f papf
						where 1=1
						and kdr.org_id = $org_id
						and kdr.organization_id = mp.organization_id(+)
						and kdr.interorg_organization_id = mp_interorg.organization_id(+)
						and kdr.requestor = papf.person_id(+) 
						order by kdr.segment1";
			}else{
				$sql = "select kdr.*,mp.organization_code,mp_interorg.organization_code interorg_organization_code,
						papf.national_identifier,papf.full_name
						from khs_delivery_requests kdr,
						mtl_parameters mp,
						mtl_parameters mp_interorg,
						per_all_people_f papf
						where 1=1
						$and
						and kdr.organization_id = mp.organization_id(+)
						and kdr.interorg_organization_id = mp_interorg.organization_id(+)
						and kdr.requestor = papf.person_id(+)
						and kdr.delivery_request_id = $id order by kdr.segment1";
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
		
		public function getDeliveryProcess($id = FALSE,$org_id = FALSE)
		{	if($id === FALSE){
				$sql = "select kdr.*,mp.organization_code,papf.national_identifier,papf.full_name
						from khs_delivery_requests kdr,
						mtl_parameters mp,
						per_all_people_f papf
						where 1=1
						and kdr.organization_id = mp.organization_id(+)
						and kdr.requestor = papf.person_id(+) 
						and (kdr.status like 'PROCESS%' or kdr.status = 'REQUEST APPROVED')
						order by kdr.segment1";
			}else{
				$sql = "select kdr.*,mp.organization_code,papf.national_identifier,papf.full_name
						from khs_delivery_requests kdr,
						mtl_parameters mp,
						per_all_people_f papf
						where 1=1
						and kdr.organization_id = mp.organization_id(+)
						and kdr.requestor = papf.person_id(+) 
						and kdr.delivery_request_id = $id 
						and (kdr.status like 'PROCESS%' or kdr.status = 'REQUEST APPROVED')
						order by kdr.segment1";
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
		
		public function getDeliveryRequestLines($delivery_request_id = FALSE,$line_id = FALSE)
		{	if($line_id === FALSE){
				$and1 = "";
			}else{
				$and1 = "and kdrl.line_id = $line_id";
			}
			if($delivery_request_id === FALSE){
				$sql = "select kdr.segment1 delivery_number, kdr.status, kdr.request_type, kdrl.*,msib.segment1,msib.description,
							(select sum(kdrm.quantity_processed) from khs_delivery_request_mo kdrm where kdr.delivery_request_id = kdrm.delivery_request_id
							and kdrm.line_id = kdrl.line_id  and kdrm.part_id is null) processed_quantity,
							(select count(kdrp.part_id) from khs_delivery_request_parts kdrp where kdrp.delivery_request_id = kdrl.delivery_request_id
							and kdrp.line_id = kdrl.line_id) check_component
						from khs_delivery_request_lines kdrl, mtl_system_items_b msib, khs_delivery_requests kdr
						where kdr.delivery_request_id = kdrl.delivery_request_id
						and msib.inventory_item_id = kdrl.line_item_id 
						and msib.organization_id = 102 
						order by line_id";
			}else{
				$sql = "select kdr.segment1 delivery_number, kdr.status, kdr.request_type,kdrl.*,msib.segment1,msib.description,
							(select sum(kdrm.quantity_processed) from khs_delivery_request_mo kdrm where kdr.delivery_request_id = kdrm.delivery_request_id
							and kdrm.line_id = kdrl.line_id and kdrm.part_id is null) processed_quantity,
							(select count(kdrp.part_id) from khs_delivery_request_parts kdrp where kdrp.delivery_request_id = kdrl.delivery_request_id
							and kdrp.line_id = kdrl.line_id) check_component
						from khs_delivery_request_lines kdrl, mtl_system_items_b msib, khs_delivery_requests kdr
						where kdr.delivery_request_id = kdrl.delivery_request_id
						and msib.inventory_item_id = kdrl.line_item_id
						AND	kdr.delivery_request_id = $delivery_request_id 
						and msib.organization_id = 102
						$and1						
						order by line_id";
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
		
		public function getComponent($delivery_request_id = FALSE,$line_id = FALSE, $picked = FALSE)
		{	if($line_id==FALSE){
				$and1= "";
			}else{
				$and1="and line_id = $line_id";
			}
			if($picked==FALSE){
				$and2 = "";
			}else{
				$and2 = "and picked = '$picked'";
			}
			if($delivery_request_id === FALSE){
				$sql = "select kdrp.*, 
						(select sum(kdrm.quantity_processed) from khs_delivery_request_mo kdrm where kdrp.delivery_request_id = kdrm.delivery_request_id
						and kdrm.line_id = kdrp.line_id and kdrm.part_id = kdrp.part_id) part_processed_quantity
						from khs_delivery_request_parts kdrp 
						where 1=1 $and1 order by kdrp.part_sequence";
			}else{
				$sql = "select kdrp.*, msib_component.segment1 kode_component, msib_component.description description_component,
						msib_option.segment1 kode_option, msib_option.description description_option,
                        count(kdrp.part_id) over(partition by kdrp.part_item_id) jumlah, 
						(select sum(kdrm.quantity_processed) from khs_delivery_request_mo kdrm where kdrp.delivery_request_id = kdrm.delivery_request_id
						and kdrm.line_id = kdrp.line_id and kdrm.part_id = kdrp.part_id) part_processed_quantity
						from khs_delivery_request_parts kdrp,
						(select * from mtl_system_items_b where organization_id = 102) msib_component,
						(select * from mtl_system_items_b where organization_id = 102) msib_option
						where kdrp.delivery_request_id = $delivery_request_id 
						$and1 $and2
						and kdrp.part_item_id = msib_component.inventory_item_id(+)
						and kdrp.option_item_id = msib_option.inventory_item_id(+)
						order by kdrp.part_sequence,kdrp.part_sequence";
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
		
		public function getItemProcessed($delivery_request_id = FALSE,$line_id = FALSE)
		{	if($line_id==FALSE){
				$and1= "";
			}else{
				$and1="and kdrm.line_id = $line_id";
			}
			if($delivery_request_id === FALSE){
				$sql = "select kdrm.*,to_char(kdrm.process_date,'DD-MON-YYYY HH24:MI:SS') process_date2 from khs_delivery_request_mo kdrm where 1=1 
						$and1 order by process_date";
			}else{
				$sql = "select kdrm.*,to_char(kdrm.process_date,'DD-MON-YYYY HH24:MI:SS') process_date2 from khs_delivery_request_mo kdrm 
						where kdrm.delivery_request_id = '$delivery_request_id' 
						$and1 order by process_date";
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
		
		public function setDeliveryRequest($data)
		{	$oracle =  $this->load->database('oracle',TRUE);
		
			$date = $data['CREATION_DATE'];
			unset($data['CREATION_DATE']);
			$oracle->set('CREATION_DATE',"to_date('$date','dd-Mon-yyyy HH24:MI:SS')",false);
			$oracle->insert('KHS_DELIVERY_REQUESTS', $data);
			
			$sql = "select delivery_request_id from khs_delivery_requests where rownum=1 order by delivery_request_id desc";
			$query = $oracle->query($sql);
			return $query->result_array();
		}
		
		public function setComponent($delivery_request_id = FALSE)
		{	$oracle =  $this->load->database('oracle',TRUE);
						
			$sql = "select * from khs_delivery_request_lines 
			where delivery_request_id=$delivery_request_id order by line_id";
			$query = $oracle->query($sql);
			$check =  $query->result_array();
			
			foreach($check as $i=>$check_item){
				$check_component = $this->getComponent($check_item['DELIVERY_REQUEST_ID'],$check_item['LINE_ID']);
				// $check_component = self::getComponent($check_item['DELIVERY_ID'],$check_item['LINE_ID']);
				$item_id = $check_item['LINE_ITEM_ID'];
				$qty = intval($check_item['QUANTITY']);
				if(count($check_component) < 1){
					$sql = "SELECT bbom.bill_sequence_id,bbom.assembly_item_id,msib_item.segment1 kode_item,msib_item.description description_item,
							bic.item_num seq, bic.component_sequence_id,bic.component_item_id, msib_part.segment1 kode_component, msib_part.description description_komponen,
							bic.component_quantity, bic_option.item_num option_seq, bic_option.component_item_id option_item_id, 
							msib_option.segment1 kode_option, msib_option.description description_option,
							bic_option.component_quantity option_quantity
							FROM
							bom_bill_of_materials bbom,
							(select bom.* 
							from bom_bill_of_materials bom,
							mtl_system_items_b msib
							where bom.assembly_item_id = msib.inventory_item_id
							and bom.organization_id = msib.organization_id
							and msib.segment1 like '%PIL') bbom_option,
							bom_inventory_components bic,
							bom_inventory_components bic_option,
							mtl_system_items_b msib_item,
							mtl_system_items_b msib_part,
							mtl_system_items_b msib_option,
							mtl_item_categories mic
							WHERE
							bbom.bill_sequence_id = bic.bill_sequence_id
							AND bic.pk2_value = bbom_option.organization_id(+)
							AND bic.component_item_id = bbom_option.assembly_item_id(+)
							AND bbom_option.bill_sequence_id = bic_option.bill_sequence_id(+)
							AND bbom_option.organization_id = bic_option.pk2_value(+)
							AND bbom.assembly_item_id = msib_item.inventory_item_id
							AND bbom.organization_id = msib_item.organization_id
							AND msib_item.organization_id = 102
							AND msib_item.item_type in ('K','PTO','KIT')
							and msib_item.inventory_item_id = mic.inventory_item_id
							AND msib_item.organization_id = mic.organization_id
							AND mic.category_set_id = 1100000041--KHS KELOMPOK PENJUALAN
							AND msib_item.enabled_flag = 'Y'
							and msib_item.segment1 not like '%PLAN'
							AND msib_item.customer_order_flag = 'Y'
							AND bic.component_item_id = msib_part.inventory_item_id
							AND bbom.organization_id = msib_part.organization_id
							AND bic_option.component_item_id = msib_option.inventory_item_id(+)
							AND bic_option.pk2_value = msib_option.organization_id(+)
							AND msib_part.enabled_flag = 'Y'
							AND bic.disable_date IS NULL
							AND msib_item.inventory_item_id = $item_id
							order by msib_item.segment1,bic.item_num,bic_option.item_num";
							
					$query = $oracle->query($sql);
					$component =  $query->result_array();
					
					foreach($component as $i => $component_item){
						$data_component[$i] = array(
							'LINE_ID' 				=> intval($check_item['LINE_ID']),
							'DELIVERY_REQUEST_ID' 	=> intval($check_item['DELIVERY_REQUEST_ID']),
							'PART_SEQUENCE' 		=> $component_item['SEQ'],
							'PART_ITEM_ID' 			=> $component_item['COMPONENT_ITEM_ID'],
							'PART_QUANTITY' 		=> $component_item['COMPONENT_QUANTITY'],
							'OPTION_SEQUENCE' 		=> $component_item['OPTION_SEQ'],
							'OPTION_ITEM_ID' 		=> $component_item['OPTION_ITEM_ID'],
							'OPTION_QUANTITY' 		=> $component_item['OPTION_QUANTITY'],
							'PICKED_QUANTITY' 		=> ((isset($component_item['OPTION_QUANTITY']))?$component_item['OPTION_QUANTITY']:$component_item['COMPONENT_QUANTITY'])*$qty,
						);
					
						$part = $oracle->insert('KHS_DELIVERY_REQUEST_PARTS', $data_component[$i]);
					}
					
				}
			}
			return $part;
		}
		
		public function setDeliveryRequestLine($data)
		{	$oracle =  $this->load->database('oracle',TRUE);
			return $oracle->insert('KHS_DELIVERY_REQUEST_LINES', $data);
		}
		
		public function setDeliveryProcessMo($data)
		{	$oracle =  $this->load->database('oracle',TRUE);
			$date = $data['PROCESS_DATE'];
			unset($data['PROCESS_DATE']);
			$oracle->set('PROCESS_DATE',"to_date('$date','dd-Mon-yyyy HH24:MI:SS')",false);
			return $oracle->insert('KHS_DELIVERY_REQUEST_MO', $data);
		}
		
		public function updateDeliveryRequest($data, $request_id)
		{		$oracle =  $this->load->database('oracle',TRUE);
				$date = $data['LAST_UPDATE_DATE'];
				unset($data['LAST_UPDATE_DATE']);
				$oracle->set('LAST_UPDATE_DATE',"to_date('$date','dd-Mon-yyyy HH24:MI:SS')",false);
				$oracle->where('DELIVERY_REQUEST_ID',$request_id);
				$oracle->update('KHS_DELIVERY_REQUESTS', $data);

		}
		
		
		public function updateDeliveryRequestLine($data, $line_id)
		{		$oracle =  $this->load->database('oracle',TRUE);
				$oracle->where('LINE_ID',$line_id);
				$oracle->update('KHS_DELIVERY_REQUEST_LINES', $data); 

		}
		
		public function updateComponent($data, $part_id)
		{		$oracle =  $this->load->database('oracle',TRUE);
				$oracle->where('PART_ID',$part_id);
				$oracle->update('KHS_DELIVERY_REQUEST_PARTS', $data); 

		}
		
		public function updateMenu($data, $menu_id)
		{		
				$this->db->where('menu_id',$menu_id);
				$this->db->update('sys.sys_menu', $data); 

		}
		
		public function getItemDelivery($id = FALSE)
		{	
			if($id === FALSE){
				$sql = "select * from mtl_system_items_b where organization_id = 102
						AND enabled_flag = 'Y'
						and segment1 not like '%PLAN'
						AND customer_order_flag = 'Y'
						AND inventory_item_status_code != 'Inactive'
						and rownum <= 100						
						order by segment1";
			}elseif(is_numeric($id)){
				$sql = "select * from mtl_system_items_b where organization_id = 102 
						AND enabled_flag = 'Y'
						and segment1 not like '%PLAN'
						AND inventory_item_status_code != 'Inactive'
						AND customer_order_flag = 'Y'
						and rownum <= 100
						and inventory_item_id = $id order by segment1";
			}else{
				$sql = "select * from mtl_system_items_b where organization_id = 102 
						AND enabled_flag = 'Y'
						AND segment1 not like '%PLAN'
						AND inventory_item_status_code != 'Inactive'
						AND customer_order_flag = 'Y'
						and rownum <= 100
						AND (segment1 like '%$id%' or description like '%$id%')
						order by segment1";
			}
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
		
		public function getItemHarvester($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('im.im_master_items');
						$this->db->where('category_id', 2);
						$this->db->order_by('segment1', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if(gettype($id) == 'integer')
						{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('item_id', $id);
							$this->db->where('category_id', 2);
							$this->db->order_by('segment1', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							$this->db->where('category_id', 2);
							$this->db->like('upper(segment1)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('segment1', 'ASC');
						}
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getItemSparePart($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('im.im_master_items');
						$this->db->where('category_id', 3);
						$this->db->order_by('segment1', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if(gettype($id) == 'integer')
						{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('item_id', $id);
							$this->db->where('category_id', 3);
							$this->db->order_by('segment1', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							$this->db->where('category_id', 3);
							$this->db->like('upper(segment1)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('segment1', 'ASC');
						}
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getItemId($id)
		{	if($id===FALSE){
				$sql = "select * from im.im_master_items order by segment1";
			}else{
				$sql = "select * from im.im_master_items where item_id in ($id) order by segment1";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getPeople($id)
		{	if(is_int($id)){
				$sql = "select * from per_all_people_f where person_id = $id
					and EFFECTIVE_END_DATE > sysdate and current_employee_flag = 'Y' order by NATIONAL_IDENTIFIER";
			
			}else{
				$sql = "select * from per_all_people_f where (full_name like '%$id%' or NATIONAL_IDENTIFIER like '%$id%')
					and EFFECTIVE_END_DATE > sysdate and current_employee_flag = 'Y' order by NATIONAL_IDENTIFIER";
			
			}
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
		}
		
		public function getInventoryOrganization($io)
		{	
			$sql = "select * from mtl_parameters where organization_code like '%$io%' order by organization_code";
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
		}
		
		public function getSubIo($io,$sub_io)
		{	
			$sql = "select mp.organization_id,mp.organization_code, msi.secondary_inventory_name, msi.description
					from 
						mtl_parameters mp,
						mtl_secondary_inventories msi
					where
						1=1
						and mp.organization_id = msi.organization_id
						and msi.disable_date is null
						and msi.status_id != 60
						and mp.organization_id = $io
						and msi.secondary_inventory_name like '%$sub_io%'
						order by mp.organization_code,msi.secondary_inventory_name";
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
		}
		
		public function getLastRequestNumber($search)
		{	$sequence = "KHS_OPK_NUM_".substr($search,0,2)."_SEQ";
		
			$sql = "select SEGMENT1
					from( 
						 select kdr.SEGMENT1
						from khs_delivery_requests kdr
						where kdr.SEGMENT1 like '$search%'
						order by kdr.segment1 desc) a
					where rownum =1";
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			$result =  $query->result_array();
			
			if(count($result) > 0){
				
				$sql = "select ".$sequence.".nextval from dual";
				$query2 = $oracle->query($sql);
				$result3 =  $query2->result_array();
			}else{
				$sql = "SELECT sequence_name 
						FROM all_sequences 
						WHERE sequence_name = '$sequence'
						AND sequence_owner = 'APPS'";
				$query2 = $oracle->query($sql);
				$result2 =  $query2->result_array();
				if(count($result2) > 0){
					$sql = "CALL reset_seq('$sequence')";
					$query3 = $oracle->query($sql);
					
					$sql = "select ".$sequence.".nextval from dual";
					$query3 = $oracle->query($sql);
					$result3 =  $query3->result_array();
				}else{
					$sql = "CREATE SEQUENCE ".$sequence." 
							  START WITH 1
							  MAXVALUE 999999999999999999999999999
							  MINVALUE 0
							  NOCYCLE
							  NOCACHE
							  NOORDER";
					$query3 = $oracle->query($sql);
					
					$sql = "select ".$sequence.".nextval from dual";
					$query3 = $oracle->query($sql);
					$result3 =  $query3->result_array();
				}
			}
			return $result3;
		}
		
		public function getMoNumber(){
			$oracle =  $this->load->database('oracle',TRUE);
			
			$head = "W".date("y");
			
			$sql = "select kdrm.MOVE_ORDER_NUMBER
					from khs_delivery_request_mo kdrm
					where kdrm.MOVE_ORDER_NUMBER like '$head%'
					order by kdrm.MOVE_ORDER_NUMBER desc";
					
			$query = $oracle->query($sql);
			$result =  $query->result_array();
			
			if(count($result) > 0){
				$sql = "select KHS_MO_FROM_OPK_NUM_SEQ.nextval from dual";
				$query2 = $oracle->query($sql);
				$result2 =  $query2->result_array();
			}else{
				$sql = "CALL reset_seq('KHS_MO_FROM_OPK_NUM_SEQ')";
				$query2 = $oracle->query($sql);
				
				$sql = "select KHS_MO_FROM_OPK_NUM_SEQ.nextval from dual";
				$query2 = $oracle->query($sql);
				$result2 =  $query2->result_array();
			}
			$move_order_num = $head.str_pad($result2[0]['NEXTVAL'],6,"0",STR_PAD_LEFT);
			return $move_order_num;
		}
		
		public function processMoveOrder($move_order,$request_num,$user){
			$oracle =  $this->load->database('oracle',TRUE);
			
			$sql = "CALL CREATE_MOVE_ORDER_FROM_OPK('$move_order','$request_num','$user')";
			$query2 = $oracle->query($sql);
			
			
		}
		
}