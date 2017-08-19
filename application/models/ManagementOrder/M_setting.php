<?php
class M_setting extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				
        }
		
		function saveTag($tags){
			$sql = "insert into mo.mo_tags (tags) values ('$tags')";
			$query = $this->db->query($sql);
			return;
		}
		
		function selectTags(){
			$sql = "select * from mo.mo_tags order by id asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		function deleteTag($tag){
			$sql = "delete from mo.mo_tags where id='$tag'";
			$query = $this->db->query($sql);
			return;
		}
		
		function updateTag($id,$tag){
			$sql = "update mo.mo_tags set tags='$tag' where id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		function saveClass($class_,$date,$user){
			$sql = "insert into mo.mo_classification (classification,user_,create_date) values ('$class_','$user','$date')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function selectClass($menu_id=FALSE)
		{	if($menu_id === FALSE){
				$sql = "select * from mo.mo_classification order by id asc";
			}else{
				$sql = "select * from mo.mo_classification  where id=$menu_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
		function deleteClass($class_){
			$sql = "delete from mo.mo_classification where id='$class_'";
			$query = $this->db->query($sql);
			return;
		}
		
		function updateClass($id,$class_,$user_id,$date){
			$sql = "update mo.mo_classification set classification='$class_',last_update='$date',last_updated_by='$user_id' where id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		function check_class_group($cl_group){
			$sql = "select * from mo.mo_classification_group where classification_group='$cl_group'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		function save_class_group($data){
			return $this->db->insert('mo.mo_classification_group', $data);
		}
		
		function select_class_group(){
			$sql = "select *,(select count(b.*) from mo.mo_classification_group_list b where b.classification_group_id=a.classification_group_id) total_class from mo.mo_classification_group a";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveClassificationGroupList($data)
		{
			return $this->db->insert('mo.mo_classification_group_list', $data);
		}
		
		public function getClassificationGroup($classification_group_id=FALSE)
		{	if($classification_group_id === FALSE){
				$sql = "select *, 
						(select count(*) from  mo.mo_classification_group_list smgl where smg.classification_group_id = smgl.classification_group_id) menu
						from mo.mo_classification_group smg order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from mo.mo_classification_group  where classification_group_id=$classification_group_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getClassificationGroupList($classification_group_id=FALSE,$classification_group_list_id=FALSE)
		{	if($classification_group_list_id === FALSE){
				$and1 = "";
			}else{
				$and1 = "AND classification_group_list_id = $classification_group_list_id";
			}
			if($classification_group_id === FALSE){
				$sql = "select * from mo.mo_classification_group_list where 1=1 $and1 
						order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from mo.mo_classification_group_list  where classification_group_id=$classification_group_id
						and classification_level=1 $and1";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
		public function getClassificationGroupListSub($classification_group_list_id=FALSE,$sub_classification_group_list_id=FALSE)
		{	if($sub_classification_group_list_id === FALSE){
				$and1 = "";
			}else{
				$and1 = "AND classification_group_list_id = $sub_classification_group_list_id";
			}
			if($classification_group_list_id === FALSE){
				$sql = "select * from mo.mo_classification_group_list order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from mo.mo_classification_group_list  where root_id=$classification_group_list_id
						$and1";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
}