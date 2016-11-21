<?php
class M_setupkebutuhankodesie extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function SetupKebutuhanList(){
		$sql="
			SELECT rtrim(k3.kode_standar) kode_standar, se.seksi, k3.kodesie, jo.pekerjaan, k3.kdpekerjaan FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_seksi se ON se.kodesie = k3.kodesie
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan
			GROUP BY k3.kode_standar, se.seksi, k3.kodesie, jo.pekerjaan, k3.kdpekerjaan
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

	public function checkBarang($kode_standar,$kodesie,$kdpekerjaan,$kode_barang){
		$sql="
			SELECT * FROM es.tb_std_k3
			WHERE kode_standar = '$kode_standar'
			AND kodesie = '$kodesie'
			AND kdpekerjaan = '$kdpekerjaan'
			AND kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function UpdateData($kode_standar,$kodesie,$kdpekerjaan){
		$sql="
			SELECT *, rtrim(kode_standar) kode_standar FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_seksi se ON se.kodesie = k3.kodesie
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang

			WHERE
				k3.kode_standar = '$kode_standar'
				AND k3.kodesie = '$kodesie'
				AND k3.kdpekerjaan = '$kdpekerjaan'
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function DeleteBarang($kode_standar,$kodesie,$kdpekerjaan,$kode_barang){
		if ($kode_barang == NULL) {
			$kode_barang = 'kode_barang';
		}
		else{
			$kode_barang = "'$kode_barang'";
		}
		$sql="
			DELETE FROM es.tb_std_k3
			WHERE
				kode_standar = '$kode_standar'
				AND kodesie = '$kodesie'
				AND kdpekerjaan = '$kdpekerjaan'
				AND kode_barang = $kode_barang
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}
}
?>