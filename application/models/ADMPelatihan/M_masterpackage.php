<?php
class M_masterpackage extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//AMBIL SEMUA PAKET PELATIHAN
		public function GetPackage(){
			$sql = "select * from pl.pl_master_package";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//AMBIL SEMUA PELATIHAN
		public function GetTraining(){
			$sql = "select * from pl.pl_master_training order by training_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//AMBIL PAKET PELATIHAN DENGAN NOMOR SPESIFIK
		public function GetPackageId($id = FALSE){
			if ($id == FALSE) {
			$sql = "
				SELECT *
				from pl.pl_master_package a
				left join pl.pl_participant_type b on a.participant_type = b.participant_type_id
				left join pl.pl_training_type c on a.training_type = c.training_type_id
				";
			}else{
			$sql = "
				SELECT *
				from pl.pl_master_package a
				left join pl.pl_participant_type b on a.participant_type = b.participant_type_id
				left join pl.pl_training_type c on a.training_type = c.training_type_id
				where a.package_id=".$id.";";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetTrainingType()
		{
			$sql = "
					SELECT * FROM pl.pl_training_type ORDER BY training_type_id ASC 
				";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

		public function GetParticipantType()
		{
			$sql = "
					SELECT * FROM pl.pl_participant_type ORDER BY participant_type_id ASC 
				";
			$query=$this->db->query($sql);
			return $query->result_array();
		}


		//AMBIL DAFTAR PELATIHAN UNTUK PAKET PELATIHAN DENGAN NOMOR SPESIFIK
		public function GetPackageTrainingId($id){
			$sql = "
				select *
				from pl.pl_master_package_training a
				left join pl.pl_master_training b on a.training_id = b.training_id
				where a.package_id='$id'
				order by a.training_order";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//AMBIL ID PAKET PELATIHAN TERBESAR
		public function GetMaxIdPackage(){
			$sql = "
				select package_id
				from pl.pl_master_package
				order by package_id desc
				limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//INSERT PAKET PELATIHAN BARU
		public function AddPackage($pkgname,$trgtype,$ptctype){
			$sql = "
				insert into pl.pl_master_package
				(package_name,training_type,participant_type)values
				('$pkgname','$trgtype','$ptctype')";
			$query = $this->db->query($sql);
			return;
		}

		//INSERT DAFTAR HARI DAN PELATIHAN
		public function AddPackageTraining($data){
			return $this->db->insert('pl.pl_master_package_training', $data);
		}

		//UBAH DATA PAKET PELATIHAN
		public function UpdatePackage($id,$pkgname,$trgtype,$ptctype){
			$sql = "
			UPDATE pl.pl_master_package set 
				package_name='".$pkgname."',
				training_type='".$trgtype."',
				participant_type='".$ptctype."'
			where package_id=$id
			";
			$query = $this->db->query($sql);
			return;
		}

		//HAPUS PAKET PELATIHAN
		public function DelPackage($id){
			$sql = "delete from pl.pl_master_package where package_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//HAPUS PELATIHAN TERKAIT PAKET PELATIHAN
		public function DelPackageTraining($id){
			$sql = "delete from pl.pl_master_package_training where package_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

}
?>