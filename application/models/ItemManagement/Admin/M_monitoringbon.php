<?php
class M_monitoringbon extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function MonitoringBonList(){
		$sql="
			SELECT * FROM es.tb_bon bo
			LEFT JOIN (SELECT substr(kodesie, 0, 8) kodesie, seksi FROM es.tb_seksi GROUP BY substr(kodesie, 0, 8), seksi) AS t ON t.kodesie = bo.kodesie
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = bo.kode_barang
			ORDER BY seksi
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function checkKebutuhan($periode, $kodesie, $kode_barang){
		$sql="
			SELECT * FROM es.tb_ttl_keb
			WHERE
				periode = '$periode'
				AND kodesie = '$kodesie'
				AND rtrim(kode_barang) = rtrim('$kode_barang')
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function insert($periode, $kodesie, $kode_barang, $jml_akhir){
		$sql="
			INSERT INTO es.tb_keb_k3
			(periode, kodesie, kode_barang, total_kebutuhan)
			VALUES
			('$periode', '$kodesie', '$kode_barang', '$jml_akhir')
			";
		$query = $this->db->query($sql);

		$sql="
			INSERT INTO es.tb_ttl_keb
			(periode, kodesie, kode_barang, total_kebutuhan, tgl_hitung)
			VALUES
			('$periode', '$kodesie', '$kode_barang', '$jml_akhir', now())
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function getPekerjaan($periode, $kodesie, $kode_barang){
		if ($kodesie == '') {
			$kodesie = "k3.kodesie";
		}
		else{
			$kodesie = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang = "k3.kode_barang";
		}
		else{
			$kode_barang = "'$kode_barang'";
		}
		$sql="
			SELECT k3.kodesie, k3.kdpekerjaan, jo.pekerjaan FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan
			WHERE
				k3.periode_mulai <= '$periode'
				AND k3.periode_selesai >= '$periode'
				AND k3.kodesie = $kodesie
				AND k3.kode_barang = $kode_barang
			GROUP BY k3.kodesie, k3.kdpekerjaan, jo.pekerjaan
			ORDER BY k3.kodesie, k3.kdpekerjaan, jo.pekerjaan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getSeksi($periode, $kodesie, $kode_barang){
		if ($kodesie == '') {
			$kodesie = "k3.kodesie";
		}
		else{
			$kodesie = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang = "k3.kode_barang";
		}
		else{
			$kode_barang = "'$kode_barang'";
		}
		$sql="
			SELECT k3.kodesie, se.seksi FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_seksi se ON se.kodesie = k3.kodesie
			WHERE
				k3.periode_mulai <= '$periode'
				AND k3.periode_selesai >= '$periode'
				AND k3.kodesie = $kodesie
				AND k3.kode_barang = $kode_barang
			GROUP BY k3.kodesie, se.seksi
			ORDER BY k3.kodesie, se.seksi
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getBarang($periode, $kodesie, $kode_barang){
		if ($kodesie == '') {
			$kodesie = "k3.kodesie";
		}
		else{
			$kodesie = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang = "k3.kode_barang";
		}
		else{
			$kode_barang = "'$kode_barang'";
		}
		$sql="
			SELECT k3.kodesie, k3.kdpekerjaan, k3.kode_standar, k3.kode_barang, mi.detail, sum(k3.jumlah*jp.jumlah_pkj) jumlah_akhir FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang
			LEFT JOIN es.tb_jml_pkj jp ON jp.kodesie = k3.kodesie AND jp.kdpekerjaan = k3.kdpekerjaan
			WHERE
				k3.periode_mulai <= '$periode'
				AND k3.periode_selesai >= '$periode'
				AND k3.kodesie = $kodesie
				AND k3.kode_barang = $kode_barang
			GROUP BY k3.kodesie, k3.kdpekerjaan, k3.kode_standar, k3.kode_barang, mi.detail
			ORDER BY k3.kodesie, k3.kdpekerjaan, k3.kode_standar, k3.kode_barang, mi.detail
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getSummary($periode,$kodesie,$kode_barang){
		if ($kodesie == '') {
			$kodesie = "k3.kodesie";
		}
		else{
			$kodesie = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang = "k3.kode_barang";
		}
		else{
			$kode_barang = "'$kode_barang'";
		}
		$sql="
			SELECT se.kodesie, se.seksi, k3.kode_barang, mi.detail, SUM(k3.jumlah*jp.jumlah_pkj) jml_akhir FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_jml_pkj jp ON jp.kodesie = k3.kodesie AND jp.kdpekerjaan = k3.kdpekerjaan
			LEFT JOIN es.tb_seksi se ON se.kodesie = k3.kodesie
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang
			WHERE
				k3.periode_mulai <= '$periode'
				AND k3.periode_selesai >= '$periode'
				AND k3.kodesie = $kodesie
				AND k3.kode_barang = $kode_barang
			GROUP BY se.kodesie, se.seksi, k3.kode_barang, mi.detail
			ORDER BY seksi, kode_barang
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}
?>