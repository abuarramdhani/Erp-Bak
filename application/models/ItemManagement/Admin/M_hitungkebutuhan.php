<?php
class M_hitungkebutuhan extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function HitungKebutuhanList(){
		$sql="
			SELECT * FROM es.tb_ttl_keb ke
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = ke.kode_barang
			ORDER BY ke.periode, ke.kode_barang
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function checkKebutuhan($periode, $kode_barang){
		$sql="
			SELECT * FROM es.tb_ttl_keb
			WHERE
				periode = '$periode'
				AND rtrim(kode_barang) = rtrim('$kode_barang')
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function checkBatas($periode, $kodesie, $kode_barang){
		$sql="
			SELECT * FROM es.tb_batas_bon
			WHERE
				periode = '$periode'
				AND kodesie = '$kodesie'
				AND rtrim(kode_barang) = rtrim('$kode_barang')
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function InsertBatasBon($periode, $kodesie, $kode_barang, $jml_akhir){
		$sql="
			INSERT INTO es.tb_batas_bon
			(periode, kodesie, kode_barang, total_kebutuhan)
			VALUES
			('$periode', '$kodesie', '$kode_barang', '$jml_akhir')
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function InsertKebutuhan($periode, $kode_barang, $jml_akhir){
		$sql="
			INSERT INTO es.tb_ttl_keb
			(periode, kode_barang, total_kebutuhan, tgl_hitung, status)
			VALUES
			('$periode', '$kode_barang', '$jml_akhir', now(), 'NEW')
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
			$kodesie_k3 = "k3.kodesie";
			$kodesie_indv = "indv.kodesie";
		}
		else{
			$kodesie_k3 = "'$kodesie'";
			$kodesie_indv = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang_k3 = "k3.kode_barang";
			$kode_barang_indv = "indv.kode_barang";
		}
		else{
			$kode_barang_k3 = "'$kode_barang'";
			$kode_barang_indv = "'$kode_barang'";
		}
		$sql="
			SELECT k3.kodesie, k3.kdpekerjaan pkj_noind, jo.pekerjaan FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan
			WHERE
				k3.periode_mulai <= '$periode'
				AND k3.periode_selesai >= '$periode'
				AND k3.kodesie = $kodesie_k3
				AND k3.kode_barang = $kode_barang_k3
			GROUP BY k3.kodesie, k3.kdpekerjaan, jo.pekerjaan

			UNION

			SELECT indv.kodesie, rtrim(indv.noind) pkj_noind, NULL FROM es.tb_std_indv indv
			WHERE
				indv.periode_mulai <= '$periode'
				AND indv.periode_selesai >= '$periode'
				AND indv.kodesie = $kodesie_indv
				AND indv.kode_barang = $kode_barang_indv
			GROUP BY indv.kodesie, indv.noind
			ORDER BY kodesie, pkj_noind, pekerjaan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UpdateStatus($status, $periode, $kode_barang){
		$sql="
			UPDATE es.tb_ttl_keb
			SET status = '$status'
			WHERE
				periode = '$periode'
				AND kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function getSeksi($periode, $kodesie, $kode_barang){
		if ($kodesie == '') {
			$kodesie_k3 = "k3.kodesie";
			$kodesie_indv = "indv.kodesie";
		}
		else{
			$kodesie_k3 = "'$kodesie'";
			$kodesie_indv = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang_k3 = "k3.kode_barang";
			$kode_barang_indv = "indv.kode_barang";
		}
		else{
			$kode_barang_k3 = "'$kode_barang'";
			$kode_barang_indv = "'$kode_barang'";
		}
		$sql="

			SELECT k3.kodesie, se.seksi FROM es.tb_std_k3 k3 
			LEFT JOIN es.tb_seksi se ON se.kodesie = k3.kodesie 
			WHERE 
				k3.periode_mulai <= '$periode' 
				AND k3.periode_selesai >= '$periode' 
				AND k3.kodesie = $kodesie_k3 
				AND k3.kode_barang = $kode_barang_k3 
			GROUP BY k3.kodesie, se.seksi 

			UNION 

			SELECT indv.kodesie, se.seksi FROM es.tb_std_indv indv 
			LEFT JOIN es.tb_seksi se ON se.kodesie = indv.kodesie 
			WHERE 
				indv.periode_mulai <= '$periode' 
				AND indv.periode_selesai >= '$periode' 
				AND indv.kodesie = $kodesie_indv 
				AND indv.kode_barang = $kode_barang_indv 
			GROUP BY indv.kodesie, se.seksi 

			ORDER BY kodesie, seksi 
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getBarang($periode, $kodesie, $kode_barang){
		if ($kodesie == '') {
			$kodesie_k3 = "k3.kodesie";
			$kodesie_indv = "indv.kodesie";
		}
		else{
			$kodesie_k3 = "'$kodesie'";
			$kodesie_indv = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang_k3 = "k3.kode_barang";
			$kode_barang_indv = "indv.kode_barang";
		}
		else{
			$kode_barang_k3 = "'$kode_barang'";
			$kode_barang_indv = "'$kode_barang'";
		}
		$sql="

			SELECT k3.kodesie, k3.kdpekerjaan pkj_noind, k3.kode_standar kode_standar, k3.kode_barang, mi.detail, sum(k3.jumlah*jp.jumlah_pkj) jumlah_akhir FROM es.tb_std_k3 k3 
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang 
			LEFT JOIN es.tb_jml_pkj jp ON jp.kodesie = k3.kodesie AND jp.kdpekerjaan = k3.kdpekerjaan 
			WHERE 
				k3.periode_mulai <= '$periode' 
				AND k3.periode_selesai >= '$periode' 
				AND k3.kodesie = $kodesie_k3 
				AND k3.kode_barang = $kode_barang_k3 
			GROUP BY k3.kodesie, k3.kdpekerjaan, k3.kode_standar, k3.kode_barang, mi.detail 

			UNION 

			SELECT indv.kodesie, rtrim(indv.noind) pkj_noind, indv.kode_standar_ind kode_standar, indv.kode_barang, mi.detail, sum(indv.jumlah) jumlah_akhir FROM es.tb_std_indv indv  
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = indv.kode_barang 
			WHERE 
				indv.periode_mulai <= '$periode' 
				AND indv.periode_selesai >= '$periode' 
				AND indv.kodesie = $kodesie_indv 
				AND indv.kode_barang = $kode_barang_indv 
			GROUP BY indv.kodesie, indv.noind, indv.kode_standar_ind, indv.kode_barang, mi.detail 

			ORDER BY kodesie, pkj_noind, kode_standar, kode_barang, detail 
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getSummary($periode,$kodesie,$kode_barang){
		if ($kodesie == '') {
			$kodesie_k3 = "k3.kodesie";
			$kodesie_indv = "indv.kodesie";
		}
		else{
			$kodesie_k3 = "'$kodesie'";
			$kodesie_indv = "'$kodesie'";
		}
		if ($kode_barang == '') {
			$kode_barang_k3 = "k3.kode_barang";
			$kode_barang_indv = "indv.kode_barang";
		}
		else{
			$kode_barang_k3 = "'$kode_barang'";
			$kode_barang_indv = "'$kode_barang'";
		}
		$sql="

			SELECT kode_barang, detail, sum(jml_akhir) jml_akhir FROM 

			(
				(SELECT k3.kode_barang, mi.detail, SUM(k3.jumlah*jp.jumlah_pkj) jml_akhir FROM es.tb_std_k3 k3 
				LEFT JOIN es.tb_jml_pkj jp ON jp.kodesie = k3.kodesie AND jp.kdpekerjaan = k3.kdpekerjaan 
				LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan 
				LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang 

				WHERE 
					k3.periode_mulai <= '$periode' 
					AND k3.periode_selesai >= '$periode' 
					AND k3.kodesie = $kodesie_k3 
					AND k3.kode_barang = $kode_barang_k3 

				GROUP BY k3.kode_barang, mi.detail) 

			UNION ALL 

				(SELECT indv.kode_barang, mi.detail, SUM(indv.jumlah) jml_akhir FROM es.tb_std_indv indv	 
				LEFT JOIN es.tb_master_item mi ON mi.kode_barang = indv.kode_barang 

				WHERE 
					indv.periode_mulai <= '$periode' 
					AND indv.periode_selesai >= '$periode' 
					AND indv.kodesie = $kodesie_indv 
					AND indv.kode_barang = $kode_barang_indv 
 
				GROUP BY indv.kode_barang, mi.detail) 
			) as t 

			GROUP BY kode_barang, detail 
			ORDER BY kode_barang 
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UpdateMasterItem($periode, $kode_barang){
		$sql="
			UPDATE es.tb_master_item
			SET stok = stok+(SELECT total_kebutuhan FROM es.tb_ttl_keb WHERE kode_barang = '$kode_barang' AND periode = '$periode')
			WHERE
				kode_barang = '$kode_barang'
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