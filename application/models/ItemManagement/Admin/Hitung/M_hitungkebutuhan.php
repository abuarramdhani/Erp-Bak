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
		return $query;
	}

	public function deleteKebutuhan($periode, $kode_barang){
		$sql="
			DELETE FROM es.tb_ttl_keb
			WHERE
				periode = '$periode'
				AND rtrim(kode_barang) = rtrim('$kode_barang')
			";
		$query = $this->db->query($sql);
		return;
	}

	public function checkBatas($periode, $kodesie, $kdpekerjaan, $kode_barang){
		$sql="
			SELECT * FROM es.tb_keb_k3
			WHERE
				periode = '$periode'
				AND kodesie = '$kodesie'
				AND kdpekerjaan_noind = '$kdpekerjaan'
				AND rtrim(kode_barang) = rtrim('$kode_barang')
			";
		$query = $this->db->query($sql);
		return $query;
	}

	public function InsertBatasBon($periode, $kodesie, $kdpekerjaan, $kode_barang, $jml_akhir){
		$sql="
			INSERT INTO es.tb_keb_k3
			(periode, kodesie, kdpekerjaan_noind, kode_barang, total_kebutuhan, sisa_stok)
			VALUES
			('$periode', '$kodesie', '$kdpekerjaan', '$kode_barang', '$jml_akhir', '$jml_akhir')
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

	public function GenerateKebutuhan($periode, $kode_barang){
		$sql="
			SELECT kk.periode, kk.kode_barang, (sum(kk.total_kebutuhan)*((100+mi.set_buffer)/100))-mi.stok total_kebutuhan FROM es.tb_keb_k3 kk
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = kk.kode_barang
			WHERE
				kk.periode = '$periode'
				AND kk.kode_barang = '$kode_barang'
			GROUP BY kk.periode, kk.kode_barang, mi.set_buffer, mi.stok
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UpdateBatasBon($periode, $kodesie, $kdpekerjaan, $kode_barang, $jml_akhir){
		$sql="
			UPDATE es.tb_keb_k3
			SET total_kebutuhan = '$jml_akhir',
				sisa_stok = '$jml_akhir'
			WHERE
				periode = '$periode'
				AND kodesie = '$kodesie'
				AND kdpekerjaan_noind = '$kdpekerjaan'
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

			SELECT indv.kodesie, rtrim(indv.noind) pkj_noind, ea.employee_name pekerjaan FROM es.tb_std_indv indv
			LEFT JOIN er.er_employee_all ea ON ea.employee_code = rtrim(indv.noind)
			WHERE
				indv.periode_mulai <= '$periode'
				AND indv.periode_selesai >= '$periode'
				AND indv.kodesie = $kodesie_indv
				AND indv.kode_barang = $kode_barang_indv
			GROUP BY indv.kodesie, indv.noind, ea.employee_name
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
			LEFT JOIN es.tb_seksi se ON substr(se.kodesie, 0, 8) = k3.kodesie 
			WHERE 
				k3.periode_mulai <= '$periode' 
				AND k3.periode_selesai >= '$periode' 
				AND k3.kodesie = $kodesie_k3 
				AND k3.kode_barang = $kode_barang_k3 
			GROUP BY k3.kodesie, se.seksi 

			UNION 

			SELECT indv.kodesie, se.seksi FROM es.tb_std_indv indv 
			LEFT JOIN es.tb_seksi se ON substr(se.kodesie, 0, 8) = indv.kodesie 
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

			SELECT kode_barang, detail, set_buffer, sisa_stok, sum(jml_akhir) jml_akhir FROM 

			(
				(SELECT k3.kode_barang, mi.detail, mi.set_buffer, mi.stok sisa_stok, SUM(k3.jumlah*jp.jumlah_pkj) jml_akhir FROM es.tb_std_k3 k3 
				LEFT JOIN es.tb_jml_pkj jp ON jp.kodesie = k3.kodesie AND jp.kdpekerjaan = k3.kdpekerjaan 
				LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan 
				LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang 

				WHERE 
					k3.periode_mulai <= '$periode' 
					AND k3.periode_selesai >= '$periode' 
					AND k3.kodesie = $kodesie_k3 
					AND k3.kode_barang = $kode_barang_k3 

				GROUP BY k3.kode_barang, mi.detail, mi.set_buffer, mi.stok) 

			UNION ALL 

				(SELECT indv.kode_barang, mi.detail, mi.set_buffer, mi.stok sisa_stok, SUM(indv.jumlah) jml_akhir FROM es.tb_std_indv indv	 
				LEFT JOIN es.tb_master_item mi ON mi.kode_barang = indv.kode_barang 

				WHERE 
					indv.periode_mulai <= '$periode' 
					AND indv.periode_selesai >= '$periode' 
					AND indv.kodesie = $kodesie_indv 
					AND indv.kode_barang = $kode_barang_indv 
 
				GROUP BY indv.kode_barang, mi.detail, mi.set_buffer, mi.stok) 
			) as t 

			GROUP BY kode_barang, set_buffer, detail, sisa_stok
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