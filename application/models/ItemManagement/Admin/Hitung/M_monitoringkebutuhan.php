<?php
class M_monitoringkebutuhan extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function MonitoringKebutuhan(){
		$sql="
			SELECT kk.periode, kk.kodesie, se.seksi FROM es.tb_keb_k3 kk
			LEFT JOIN es.tb_seksi se ON substr(se.kodesie, 0, 8) = kk.kodesie
			GROUP BY kk.periode, kk.kodesie, se.seksi
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetPekerjaan($periode, $kodesie){
		$sql="
			SELECT kk.kodesie, kk.kdpekerjaan_noind, t.detail FROM es.tb_keb_k3 kk
			LEFT JOIN (
			SELECT kdpekerjaan kdpekerjaan_noind, pekerjaan detail  FROM es.tb_job
			UNION
			SELECT employee_code kdpekerjaan_noind, employee_name detail FROM er.er_employee_all
			) as t ON t.kdpekerjaan_noind = kk.kdpekerjaan_noind
			WHERE
				kk.periode = '$periode'
				AND kk.kodesie = '$kodesie'
			GROUP BY kk.kodesie, kk.kdpekerjaan_noind, t.detail
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetDetailBarang($periode, $kodesie){
		$sql="
			SELECT kk.kodesie, kk.kdpekerjaan_noind, t.detail, kk.kode_barang, mi.detail detail_barang, kk.total_kebutuhan FROM es.tb_keb_k3 kk
			LEFT JOIN (
			SELECT kdpekerjaan kdpekerjaan_noind, pekerjaan detail  FROM es.tb_job
			UNION
			SELECT employee_code kdpekerjaan_noind, employee_name detail FROM er.er_employee_all
			) as t ON t.kdpekerjaan_noind = kk.kdpekerjaan_noind
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = kk.kode_barang
			WHERE
				kk.periode = '$periode'
				AND kk.kodesie = '$kodesie'
			GROUP BY kk.kodesie, kk.kdpekerjaan_noind, t.detail, kk.kode_barang, mi.detail, kk.total_kebutuhan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function PeriodeMonitoring(){
		$sql="
			SELECT periode FROM es.tb_keb_k3
			GROUP BY periode
			ORDER BY periode
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function BarangMonitoring(){
		$sql="
			SELECT bo.periode, bo.kode_barang, mi.detail FROM es.tb_keb_k3 bo
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = bo.kode_barang
			GROUP BY bo.periode, bo.kode_barang, mi.detail
			ORDER BY bo.periode, bo.kode_barang, mi.detail
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
			SELECT * FROM es.tb_keb_k3
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
			INSERT INTO es.tb_keb_k3
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

			SELECT kode_barang, detail, set_buffer, sum(jml_akhir) jml_akhir FROM 

			(
				(SELECT k3.kode_barang, mi.detail, mi.set_buffer, SUM(k3.jumlah*jp.jumlah_pkj) jml_akhir FROM es.tb_std_k3 k3 
				LEFT JOIN es.tb_jml_pkj jp ON jp.kodesie = k3.kodesie AND jp.kdpekerjaan = k3.kdpekerjaan 
				LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = k3.kdpekerjaan 
				LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang 

				WHERE 
					k3.periode_mulai <= '$periode' 
					AND k3.periode_selesai >= '$periode' 
					AND k3.kodesie = $kodesie_k3 
					AND k3.kode_barang = $kode_barang_k3 

				GROUP BY k3.kode_barang, mi.detail, mi.set_buffer) 

			UNION ALL 

				(SELECT indv.kode_barang, mi.detail, mi.set_buffer, SUM(indv.jumlah) jml_akhir FROM es.tb_std_indv indv	 
				LEFT JOIN es.tb_master_item mi ON mi.kode_barang = indv.kode_barang 

				WHERE 
					indv.periode_mulai <= '$periode' 
					AND indv.periode_selesai >= '$periode' 
					AND indv.kodesie = $kodesie_indv 
					AND indv.kode_barang = $kode_barang_indv 
 
				GROUP BY indv.kode_barang, mi.detail, mi.set_buffer) 
			) as t 

			GROUP BY kode_barang, set_buffer, detail 
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