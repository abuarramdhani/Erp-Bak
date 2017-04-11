<?php
class M_penjadwalanpackage extends CI_Model {

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
		
		//AMBIL SEMUA PENJADWALAN PAKET
		public function GetScheduledPackage(){
			$sql = "
				select *
				from pl.pl_scheduling_package a
				left join pl.pl_master_package b on a.package_id = b.package_id
				";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//AMBIL SEMUA PENJADWALAN PAKET
		public function GetScheduledPackageId($id){
			$sql = "
				select
					a.package_scheduling_id,
					b.package_name,
					a.package_scheduling_name,
					a.participant_number,
					c.participant_type_description,
					d.training_type_description
				from pl.pl_scheduling_package a
					left join pl.pl_master_package b on a.package_id = b.package_id
					left join pl.pl_participant_type c on a.participant_type = c.participant_type_id
					left join pl.pl_training_type d on a.training_type = d.training_type_id
				where a.package_scheduling_id = '$id'
				";
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
		public function GetPackageId($id){
			$sql = "
				select *
				from pl.pl_master_package a
				left join pl.pl_participant_type b on a.participant_type = b.participant_type_id
				left join pl.pl_training_type c on a.training_type = c.training_type_id
				where a.package_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//AMBIL DATA DAFTAR PELATIHAN YANG ADA DALAM SUATU PAKET
		public function GetPackageIdNumber($id){
			$sql = "
				select package_id
				from pl.pl_scheduling_package
				where package_scheduling_id=$id";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//AMBIL DATA PENJADWALAN PELATIHAN YANG SESUAI DENGAN PENJADWALAN PAKET
		public function GetScheduledTraining($id){
			$sql = " select * from pl.pl_scheduling_training where package_scheduling_id=$id";
			$query = $this->db->query($sql);
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

		public function GetMaxIdSchedulingPackage(){
			$sql = "
				select package_scheduling_id
				from pl.pl_scheduling_package
				order by package_scheduling_id desc
				limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//INSERT PENJADWALAN PELATIHAN BARU
		public function AddSchedule($pkgid,$schname,$trgtype,$ptctype){
			$sql = "
				insert into pl.pl_scheduling_package
				(package_id,package_scheduling_name,training_type,participant_type)values
				('$pkgid','$schname','$trgtype','$ptctype')";
			$query = $this->db->query($sql);
			return;
		}

		//INSERT DAFTAR HARI DAN PELATIHAN
		public function AddPackageTraining($data){
			return $this->db->insert('pl.pl_master_package_training', $data);
		}

		//UBAH DATA PAKET PELATIHAN
		public function UpdatePackage($orgnum,$pkgname,$pkgnumb,$trgtype,$ptctype){
			$sql = "
			update pl.pl_master_package set 
				package_name='$pkgname',
				package_number='$pkgnumb',
				training_type='$trgtype',
				participant_type='$ptctype'
			where package_number=$orgnum
			";
			$query = $this->db->query($sql);
			return;
		}

		//HAPUS PAKET PELATIHAN
		public function DeletePackageScheduling($id){
			$sql = "delete from pl.pl_scheduling_package where 	package_scheduling_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

//------------------------------------- DELETE PACKAGE SCHEDULING -------------------------------
		//DELETE1
		public function DeletePackageScheduling1($id){
			$sql = "delete from pl.pl_scheduling_package where package_scheduling_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//DELETE2
		public function DeletePackageScheduling2($id){
			$sql = "
				select scheduling_id
				from pl.pl_scheduling_training
				where package_scheduling_id=$id";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//DELETE3
		public function DeletePackageScheduling3($schedulingid){
			$sql = "delete from pl.pl_objective where scheduling_id='$schedulingid'";
			$query = $this->db->query($sql);
			return;
		}

		//DELETE4
		public function DeletePackageScheduling4($schedulingid){
			$sql = "delete from pl.pl_participant where scheduling_id='$schedulingid'";
			$query = $this->db->query($sql);
			return;
		}

		//DELETE5
		public function DeletePackageScheduling5($id){
			$sql = "delete from pl.pl_scheduling_training where package_scheduling_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
//--------------------------------------------- END ----------------------------------------------

		//HAPUS PAKET PELATIHAN
		public function DelPackage($num){
			$sql = "delete from pl.pl_master_package where package_number='$num'";
			$query = $this->db->query($sql);
			return;
		}

		//HAPUS PELATIHAN TERKAIT PAKET PELATIHAN
		public function DelPackageNum($num){
			$sql = "delete from pl.pl_master_package_training where package_number='$num'";
			$query = $this->db->query($sql);
			return;
		}

}
?>