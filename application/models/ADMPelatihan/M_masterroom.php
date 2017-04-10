<?php
class M_masterroom extends CI_Model {

		public function __construct(){
			parent::__construct();
		}
		
		//AMBIL DATA RUANGAN
		public function GetRoom(){
			$sql = "select * from pl.pl_room order by room_name ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//AMBIL DATA RUANGAN YANG DIPILIH
		public function GetRoomId($id){
			$sql = "select * from pl.pl_room where room_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//MENAMBAHKAN RUANGAN BARU
		public function AddRoom($RoomName,$RoomCapacity){
			$sql = "
			insert INTO pl.pl_room
			(room_name,description,capacity)values
			('$RoomName','$RoomName','$RoomCapacity')";
			$query = $this->db->query($sql);
			return;
		}
		
		//MENGHAPUS RUANGAN
		public function DeleteRoom($id){
			$sql = "delete from pl.pl_room where room_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//UPDATE DATA RUANGAN
		public function UpdateRoom($id,$RoomName,$RoomCapacity){
			$sql = "
			update pl.pl_room set 
				room_name='$RoomName',
				description='$RoomName',
				capacity='$RoomCapacity'
			where room_id=$id
			";
			$query = $this->db->query($sql);
			return;
		}
}
?>