<?php
class M_inputpekerja extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function JumlahPekerja($kodesie){
		$sql="
			SELECT * FROM es.tb_jml_pkj jp
			LEFT JOIN es.tb_job jo ON jo.kdpekerjaan = jp.kdpekerjaan
			WHERE jp.kodesie = '$kodesie'
			ORDER BY jp.kdpekerjaan ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function KodeBon($kodesie){
		$sql="
			SELECT kode_blanko FROM es.tb_bon
			WHERE kodesie = '$kodesie'
			GROUP BY kode_blanko
			ORDER BY kode_blanko ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UserKodesie($user_id){
		$sql="
			SELECT *, substr(kodesie, 0, 8) kodesie FROM es.tb_seksi
			WHERE kodesie = (	SELECT section_code FROM er.er_employee_all
									WHERE employee_id = (	SELECT employee_id FROM sys.sys_user
															WHERE user_id = '$user_id'))

			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getPekerjaan($term,$kodesie){
		$sql="
			SELECT * FROM es.tb_job
			WHERE substr(kdpekerjaan, 0, 8) = '$kodesie' AND (kdpekerjaan ILIKE '%$term%' OR pekerjaan ILIKE '%$term%')
			ORDER BY pekerjaan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getItem($term,$kodesie){
		$sql="
			SELECT * FROM es.tb_std_k3 k3
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = k3.kode_barang
			WHERE (k3.kode_barang ILIKE '%$term%' OR mi.detail ILIKE '%term%') AND k3.kodesie = '$kodesie'
			ORDER BY k3.kode_barang
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getBonItem($kode_barang){
		$sql="
			SELECT * FROM es.tb_master_item
			WHERE kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function CheckBlanko($kode_blanko){
		$sql="
			SELECT * FROM es.tb_bon
			WHERE kode_blanko = '$kode_blanko'
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function insert($periode, $kodesie, $kdpekerjaan, $jumlah){
		$sql="
			INSERT INTO es.tb_jml_pkj
			(periode, kodesie, kdpekerjaan, jumlah_pkj)
			VALUES
			('$periode', '$kodesie', '$kdpekerjaan', '$jumlah')
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function UpdateData($id_jml_pkj){
		$sql="
			SELECT * FROM es.tb_jml_pkj jp
			LEFT JOIN es.tb_job jo ON jp.kdpekerjaan = jo.kdpekerjaan
			WHERE
				jp.id_jml_pkj = '$id_jml_pkj'
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update($id_jml_pkj, $periode, $kodesie, $kdpekerjaan, $jumlah){
		$sql="
			UPDATE es.tb_jml_pkj
			SET periode = '$periode',
				kodesie = '$kodesie',
				kdpekerjaan = '$kdpekerjaan',
				jumlah_pkj = '$jumlah'
			WHERE
				id_jml_pkj = '$id_jml_pkj'
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function delete($id_jml_pkj){
		$sql="
			DELETE FROM es.tb_jml_pkj
			WHERE
				id_jml_pkj = '$id_jml_pkj'
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