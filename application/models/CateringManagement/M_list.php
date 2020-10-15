<?php
class M_list extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//select
		public function GetCateringList(){
			$sql = "
				select *,
					case when catering_phone is null then '-' else catering_phone end as phone
				from cm.cm_catering a 
				order by a.catering_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//select
		public function GetCateringForEdit($id){
			$sql = "
				select *,
					case when catering_phone is null then '-' else catering_phone end as phone
				from cm.cm_catering a 
				where a.catering_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//create
		public function AddCatering($name,$code,$address,$phone,$pph,$status,$pph_value){
			$sql = "
			insert into cm.cm_catering
			(catering_name,catering_code,catering_address,catering_phone,catering_status,catering_pph,pph_value)values
			('$name','$code','$address','$phone','$status','$pph','$pph_value')";
			$query = $this->db->query($sql);
			return;
		}
		
		//update
		public function UpdateCatering($id,$name,$code,$address,$phone,$pph,$status,$pph_value){
			$sql = "
			update cm.cm_catering set 
				catering_name='$name',
				catering_code='$code',
				catering_address='$address',
				catering_phone='$phone',
				catering_status='$status',
				catering_pph='$pph',
				pph_value='$pph_value'
			where catering_id='$id'
			";
			$query = $this->db->query($sql);
			return;
		}
		
		//create
		public function DeleteCatering($id){
			$sql = "delete from cm.cm_catering where catering_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
}
?>