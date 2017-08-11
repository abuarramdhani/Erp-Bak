<?php
class M_Realization extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_realization(){
		$sql="select * from ga.ga_outstation_realization aa, ga.ga_outstation_area ar, ga.ga_outstation_city_type ct, er.er_employee_all emp, er.er_section sec where aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id and aa.employee_id=emp.employee_id and emp.section_code= sec.section_code order by aa.realization_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	} 

	public function new_realization($employee_id,$area_id,$city_type_id,$depart,$return,$bon){
		$sql="insert into ga.ga_outstation_realization (employee_id,area_id,city_type_id,depart_time,return_time,bon_nominal) values ('$employee_id','$area_id','$city_type_id','$depart','$return','$bon')";
		$query = $this->db->query($sql);
		return;
	}

	public function new_realization_detail($component_id,$info,$qty,$component_nominal){
		$sql="insert into ga.ga_outstation_realization_detail (realization_id, component_id, info, qty, nominal) values ((select realization_id from ga.ga_outstation_realization order by realization_id desc limit 1),'$component_id','$info','$qty','$component_nominal')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_realization($realization_id){
		$sql="select * from ga.ga_outstation_realization aa, ga.ga_outstation_area ar, er.er_employee_all emp, er.er_section sec, ga.ga_outstation_position pst, ga.ga_outstation_city_type ct where aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id and aa.employee_id = emp.employee_id and emp.section_code = sec.section_code and emp.outstation_position = pst.position_id and aa.realization_id = '$realization_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function select_edit_realization_detail($realization_id){
		$sql="select * from ga.ga_outstation_realization_detail rel_det, ga.ga_outstation_realization real where rel_det.realization_id = real.realization_id and rel_det.realization_id = '$realization_id' order by rel_det.realization_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_realization($realization_id,$employee_id,$area_id,$city_type_id,$depart,$return,$bon){
		$sql="update ga.ga_outstation_realization set employee_id='$employee_id', area_id='$area_id', city_type_id='$city_type_id', depart_time='$depart', return_time='$return', bon_nominal='$bon' where realization_id='$realization_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_before_update($realization_id){
		$sql="delete from ga.ga_outstation_realization_detail where realization_id='$realization_id'";
		$query = $this->db->query($sql);
		return;
	}
	public function update_realization_detail($realization_id,$component_id,$info,$qty,$component_nominal){
		$sql="insert into ga.ga_outstation_realization_detail (realization_id, component_id, info, qty, nominal) values ('$realization_id','$component_id','$info','$qty','$component_nominal')";
		$query = $this->db->query($sql);
		return;
	}

	public function show_meal_allowance($position_id,$dest,$time_name){
		$sql="select * from ga.ga_outstation_meal_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_time ti where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.time_id=ti.time_id AND op.position_id='$position_id' AND aa.area_id = '$dest' AND ti.time_name ILIKE '%$time_name%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_accomodation_allowance($position_id,$dest,$type){
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id AND op.position_id = '$position_id' AND aa.area_id = '$dest' AND aa.city_type_id = '$type'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_group_ush($position_id,$return_time,$have_sunday,$is_foreign){
		$sql="select * from ga.ga_outstation_ush ush, ga.ga_outstation_groupush grp, ga.ga_outstation_position op where ush.group_id = grp.group_id AND ush.position_id = op.position_id AND op.position_id = '$position_id' AND grp.time_1 <= '$return_time' AND grp.time_2 >= '$return_time' AND grp.holiday = '$have_sunday' AND grp.foreign = '$is_foreign'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function check_holiday($depart,$return){
		$sql="select * from ga.ga_outstation_holiday where tanggal between '$depart' AND '$return'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function show_employee(){
		$sql="select * from er.er_employee_all where resign = 0 OR resign is null order by employee_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function show_position(){
		$sql="select * from ga.ga_outstation_position where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function show_area(){
		$sql="select * from ga.ga_outstation_area where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_city_type(){
		$sql="select * from ga.ga_outstation_city_type where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_component(){
		$sql="select * from ga.ga_outstation_component where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function delete_realization($realization_id){
		$sql="delete from ga.ga_outstation_realization where realization_id = '$realization_id'";
		$query = $this->db->query($sql);
		return;
	}	

	public function save_realization_mail($id,$to,$cc,$bcc,$sub,$val,$status){
		$sql="insert into ga.ga_outstation_email(realization_id,email_subject,email_to,email_cc,email_bcc,email_date,email_content,email_status) 
			values ('$id','$sub','$to','$cc','$bcc',now(),'$val','$status')";
		$query = $this->db->query($sql);
		return;
	}
}
?>