<?php
class M_monitoringbon extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function MonitoringBonList($kodesie, $periode){
		$sql="
			SELECT * FROM es.tb_bon bn
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = bn.kode_barang
			WHERE bn.kodesie = '$kodesie' AND bn.periode = '$periode'
			ORDER BY kode_blanko ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function KodeBon($kodesie, $periode){
		$sql="
			SELECT kode_blanko FROM es.tb_bon
			WHERE kodesie = '$kodesie' AND periode = '$periode'
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

	public function getPekerjaan($term){
		$sql="
			SELECT * FROM es.tb_job
			WHERE kdpekerjaan ILIKE '%$term%' OR pekerjaan ILIKE '%$term%'
			ORDER BY pekerjaan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getItem($term,$kodesie,$periode){
		$sql="
			SELECT * FROM es.tb_keb_k3 bb
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = bb.kode_barang
			WHERE (bb.kode_barang ILIKE '%$term%' OR mi.detail ILIKE '%$term%') AND bb.kodesie = '$kodesie' AND bb.total_kebutuhan != 0 AND bb.periode = '$periode'
			ORDER BY bb.kode_barang
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getBonItem($periode, $kodesie, $kode_barang){
		$sql="
			SELECT * FROM es.tb_keb_k3 bb
			LEFT JOIN es.tb_master_item mi ON mi.kode_barang = bb.kode_barang
			WHERE
				bb.periode = '$periode'
				AND bb.kodesie = '$kodesie'
				AND bb.kode_barang = '$kode_barang'
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

	public function insert($kode_blanko, $periode, $kodesie, $kode_barang, $jumlah){
		$sql="
			INSERT INTO es.tb_bon
			(kode_blanko, periode, kodesie, kode_barang, jumlah, jumlah_batas, sisa_stok, tgl_bon)
			VALUES
			('$kode_blanko', '$periode', '$kodesie', '$kode_barang', '$jumlah', (SELECT total_kebutuhan FROM es.tb_keb_k3 WHERE periode='$periode' AND kodesie='$kodesie' AND kode_barang='$kode_barang'), (SELECT total_kebutuhan-'$jumlah' FROM es.tb_keb_k3 WHERE periode='$periode' AND kodesie='$kodesie' AND kode_barang='$kode_barang'), now())
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function UpdateStock($periode, $kodesie, $kode_barang, $jumlah){
		$sql="
			UPDATE es.tb_keb_k3
			SET sisa_stok = sisa_stok-'$jumlah'
			WHERE
				periode = '$periode'
				AND kodesie = '$kodesie'
				AND kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return;
	}

	public function UpdateStockMaster($kode_barang, $jumlah){
		$sql="
			UPDATE es.tb_master_item
			SET stok = stok-'$jumlah'
			WHERE
				kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return;
	}

}
?>