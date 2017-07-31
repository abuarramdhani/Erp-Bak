<?php
class M_setupkebutuhan extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function SetupKebutuhanList(){
		$sql="
			SELECT * FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_seksi se ON se.kodesie = k3.kodesie
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan

			ORDER BY kode_standar ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function insert($kode_standar, $kodesie, $kdpekerjaan, $kode_barang, $periode_mulai, $periode_selesai, $jumlah){
		$sql="
			INSERT INTO es.tb_std_k3
			(kode_standar,kodesie,kdpekerjaan,kode_barang,periode_mulai,periode_selesai,jumlah)
			VALUES
			('$kode_standar', '$kodesie', '$kdpekerjaan', '$kode_barang', '$periode_mulai', '$periode_selesai', '$jumlah')
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}
	public function CheckStd($kode_standar){
		$sql="
			SELECT * FROM es.tb_std_k3
			WHERE kode_standar = '$kode_standar'
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getSeksi($term){
		$sql="
			SELECT distinct(substr(kodesie, 0, 8)) kodesie, seksi FROM es.tb_seksi
			WHERE seksi NOT LIKE '-%' AND (kodesie ILIKE '%$term%' OR seksi ILIKE '%$term%')
			ORDER BY kodesie, seksi
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getKodePekerjaan($term){
		$sql="
			SELECT * FROM es.tb_job
			WHERE kdpekerjaan ILIKE '$term%'
			ORDER BY kdpekerjaan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getNoInduk($term){
		$sql="
			SELECT employee_code, employee_name FROM er.er_employee_all
			WHERE section_code ILIKE '$term%'
			ORDER BY employee_code
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getKodeBarang($term){
		$sql="
			SELECT * FROM es.tb_master_item
			WHERE kode_barang ILIKE '%$term%' OR detail ILIKE '%$term%'
			ORDER BY kode_barang
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDetail($kode_barang){
		$sql="
			SELECT * FROM es.tb_master_item
			WHERE kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	

}
?>