<?php
class M_masteritem extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function MasterItemList(){
		$sql="
			SELECT *, st.satuan satuan_lang, uk.ukuran ukuran_lang FROM es.tb_master_item mi
			LEFT JOIN es.tb_satuan st ON st.kode = mi.satuan
			LEFT JOIN es.tb_ukuran uk ON uk.kode = mi.ukuran

			ORDER BY kode_barang ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function SatuanList(){
		$sql="
			SELECT * FROM es.tb_satuan
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UkuranList(){
		$sql="
			SELECT * FROM es.tb_ukuran
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function CheckItem($kode_barang){
		$sql="
			SELECT * FROM es.tb_master_item
			WHERE kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function insert($kode_barang, $detail, $umur, $satuan, $stok, $ukuran, $dikembalikan, $peringatan, $interval_peringatan, $satuan_peringatan, $set_buffer){
		$sql="
			INSERT INTO es.tb_master_item
			(kode_barang,detail,umur,satuan,stok,ukuran,tgl_update,dikembalikan,peringatan,interval_peringatan,satuan_peringatan,set_buffer)
			VALUES
			('$kode_barang','$detail','$umur','$satuan','$stok','$ukuran',now(),'$dikembalikan','$peringatan','$interval_peringatan','$satuan_peringatan','$set_buffer')
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function UpdateData($kode_barang){
		$sql="
			SELECT * FROM es.tb_master_item
			WHERE kode_barang = '$kode_barang'
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update($kode_barang, $detail, $umur, $satuan, $stok, $ukuran, $dikembalikan, $peringatan, $interval_peringatan, $satuan_peringatan, $set_buffer, $kode_barang_old){
		$sql="
			UPDATE es.tb_master_item
			SET	kode_barang 			= '$kode_barang',
				detail					= '$detail',
				umur					= '$umur',
				satuan					= '$satuan',
				stok					= '$stok',
				ukuran					= '$ukuran',
				dikembalikan			= '$dikembalikan',
				peringatan				= '$peringatan',
				interval_peringatan		= '$interval_peringatan',
				satuan_peringatan		= '$satuan_peringatan',
				set_buffer				= '$set_buffer'
			WHERE
				kode_barang = '$kode_barang_old'
			";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function delete($kode_barang){
		$sql="
			DELETE FROM es.tb_master_item
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