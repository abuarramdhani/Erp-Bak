<?php
class M_setupkebutuhanindv extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function SetupKebutuhanList(){
		$sql="
			SELECT rtrim(indv.kode_standar_ind) kode_standar_ind, se.seksi, indv.kodesie, indv.noind FROM es.tb_std_indv indv
			LEFT JOIN es.tb_seksi se ON se.kodesie = indv.kodesie
			GROUP BY indv.kode_standar_ind, se.seksi, indv.kodesie, indv.noind
			ORDER BY kode_standar_ind ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function insert($kode_standar, $noind, $kode_barang, $periode_mulai, $periode_selesai, $jumlah, $kodesie){
		$sql="
			INSERT INTO es.tb_std_indv
			(kode_standar_ind,noind,kode_barang,periode_mulai,periode_selesai,jumlah,kodesie)
			VALUES
			('$kode_standar', '$noind', '$kode_barang', '$periode_mulai', '$periode_selesai', '$jumlah', '$kodesie')
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
			SELECT * FROM es.tb_std_indv
			WHERE kode_standar_ind = '$kode_standar'
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function checkBarang($kode_standar,$noind,$kode_barang,$kodesie){
		$sql="
			SELECT * FROM es.tb_std_indv
			WHERE kode_standar_ind = '$kode_standar'
			AND kodesie = '$kodesie'
			AND noind = '$noind'
			AND kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function UpdateData($kode_standar,$kodesie,$noind){
		$sql="
			SELECT *, rtrim(kode_standar_ind) kode_standar_ind FROM es.tb_std_indv indv
			LEFT JOIN es.tb_seksi se ON se.kodesie = indv.kodesie
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = indv.kode_barang

			WHERE
				indv.kode_standar_ind = '$kode_standar'
				AND indv.kodesie = '$kodesie'
				AND indv.noind = '$noind'
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function DeleteBarang($kode_standar,$kodesie,$noind,$kode_barang){
		if ($kode_barang == NULL) {
			$kode_barang = 'kode_barang';
		}
		else{
			$kode_barang = "'$kode_barang'";
		}
		$sql="
			DELETE FROM es.tb_std_indv
			WHERE
				kode_standar_ind = '$kode_standar'
				AND kodesie = '$kodesie'
				AND noind = '$noind'
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