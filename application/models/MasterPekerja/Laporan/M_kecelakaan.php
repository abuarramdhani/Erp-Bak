<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kecelakaan extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}
	
	public function getPekerja($pekerja)
	{
		$data_pekerja = $this->personalia->query("select pri.noind, pri.nama
									from hrd_khs.v_hrd_khs_tpribadi as pri 
									where (pri.noind like '%$pekerja%' or pri.nama like '%$pekerja%' )");
		return $data_pekerja->result_array();
	}
	public function ambilDataPribadi($noinduk)
	{
		$this->personalia->where('noind', $noinduk);
		$dataPribadi = $this->personalia->get('hrd_khs.v_hrd_khs_tpribadi');
		return $dataPribadi->result_array();
	}
	public function getPerusahaan($a)
	{
		$data_perusahaan = $this->erp->query("select * from kk.kk_perusahaan
												where ( kode_mitra like '%$a%' or kota like '%$a%')");
		return $data_perusahaan->result_array();
	}
	public function tampilPerusahaan($id_perusahaan = FALSE)
	{
		if ( $id_perusahaan !== FALSE )
		{
			$where_id_perusahaan 	= "	where id_perusahaan='$id_perusahaan'";
		}
		else
		{
			$where_id_perusahaan 	=	"";
		}
		$sql 	= "	select * from kk.kk_perusahaan ".$where_id_perusahaan." order by id_perusahaan";
		$hasil = $this->erp->query("select * from kk.kk_perusahaan order by id_perusahaan");
		return $hasil->result_array();
	}

	public function insert_perusahaan($insert_perusahaan)
	{
		$this->erp->insert('kk.kk_perusahaan', $insert_perusahaan);
		return $this->erp->insert_id();
	}
	public function infoPerusahaan($id)
	{
	 	$query = $this->erp->query("select * from kk.kk_perusahaan where id_perusahaan=$id");
	 	return $query->result_array();
	}

	public function deletePerusahaan($id)
	{
		$this->erp->where('id_perusahaan',$id);
		$this->erp->delete('kk.kk_perusahaan');
		return $this->erp->insert_id();
	}
	public function update_perusahaan($update_perusahaan,$id)
	{
		$this->erp->where('id_perusahaan',$id);
		$this->erp->update('kk.kk_perusahaan', $update_perusahaan);
		return;
	}
	public function kk_perusahaan_history($history)
	{
		$this->erp->insert('kk.kk_perusahaan_history', $history);
	}
	public function kk_kecelakaan_detail()
	{
		$query = $this->erp->get('kk.kk_kecelakaan_detail');
		return $query->result_array();
	}
	public function kk_kecelakaan_detail_view($id)
	{
		$this->erp->where('id_laporan_tahap_1', $id);
		$query = $this->erp->get('kk.kk_laporan_kecelakaan');
		return $query->result_array();
	}
	public function simpanDeskripsi($arraySimpan)
	{
		$this->erp->insert('kk.kk_laporan_kecelakaan', $arraySimpan);
		return $this->erp->insert_id();
	}
	public function simpanfaskes($data_faskes)
	{
		$this->erp->insert('kk.kk_faskes', $data_faskes);
	}
	public function ambilIdFaskes($namafaskes,$jenisfaskes,$alamatfaskes)
	{
		$this->erp->where('nama', $namafaskes);
		$this->erp->where('jenis_faskes', $jenisfaskes);
		$this->erp->where('alamat', $alamatfaskes);
		$query	=	$this->erp->get('kk.kk_faskes');
		return $query->result_array();
	}
	public function simpanLaporanTahap1($simpan_tahap_1)
	{
		$this->erp->insert('kk.kk_laporan_tahap_1', $simpan_tahap_1);
		return $this->erp->insert_id();
	}
	public function simpanHistoryTahap1($history)
	{
		$this->erp->insert('kk.kk_laporan_tahap_1_history', $history);
		return;
	}
	public function updateTahap1($id,$updateThp1)
	{
		$this->erp->where('id_lkk_1', $id);
		$this->erp->update('kk.kk_laporan_tahap_1', $updateThp1);
		return;
	}
	public function deleteKecelakaanDetailLama($id)
	{
		$this->erp->where('id_laporan_tahap_1',$id);
		$this->erp->delete('kk.kk_laporan_kecelakaan');
		return;
	}
	public function historyKecelakaanDetail($historyKec)
	{
		$this->erp->insert('kk.kk_laporan_kecelakaan_history', $historyKec);
		return;
	}
	public function tampilRecord()
	{
		$query = $this->erp->query("select kk.kk_laporan_tahap_1.id_lkk_1, 
											kk.kk_laporan_tahap_1.kode_mitra, 
											kk.kk_laporan_tahap_1.noind, 
											kk.kk_laporan_tahap_1.nama, 
											kk.kk_laporan_tahap_1.tgl_kk, 
											kk.kk_laporan_tahap_1.akibat_diderita

									FROM kk.kk_laporan_tahap_1 order by kk.kk_laporan_tahap_1.id_lkk_1
									");
		return $query->result_array();
	}
	public function getLKK1($id)
	{
		$this->erp->where('id_lkk_1', $id);
		$query = $this->erp->get('kk.kk_laporan_tahap_1');
		return $query->result_array();
	}
	public function getNomorBPJS($noind)
	{
		$this->personalia->where('noind', $noind);
		$query = $this->personalia->get('hrd_khs.tbpjstk');
		return $query->result_array();
	}

	public function getPerusahaanByKode($kode_mitra)
	{
		$this->erp->where('kode_mitra', $kode_mitra);
		$query = $this->erp->get('kk.kk_perusahaan');
		return $query->result_array();
	}
	public function tempatKecelakaan($id_tempat)
	{
		$this->erp->where('id_lokasi', $id_tempat);
		$query = $this->erp->get('kk.kk_lokasi_kejadian');
		return $query->result_array();
	}
	public function faskesAll($id_faskes)
	{
		$this->erp->where('id_faskes', $id_faskes);
		$query = $this->erp->get('kk.kk_faskes');
		return $query->result_array();
	}
	public function upahKet($id_upah)
	{
		$this->erp->where('id', $id_upah);
		$query = $this->erp->get('kk.kk_upah_status');
		return $query->result_array();
	}
	public function unitPekerja($kodesie)
	{
		$this->personalia->where('kodesie', $kodesie);
		$query = $this->personalia->get('hrd_khs.tseksi');
		return $query->result_array();
	}
	public function ambilAlamatPerusahaan($kode_mitra)
	{
		$this->erp->where('kode_mitra', $kode_mitra);
		$alamat = $this->erp->get('kk.kk_perusahaan');
		return $alamat->result_array();
	}
	public function kk4()
	{
		$query = $this->erp->get('kk.kk_ket_kk4');
		return $query->result_array();
	}
	public function biayaKategori()
	{
		$query = $this->erp->get('kk.kk_biaya_kategori');
		return $query->result_array();
	}
	public function simpanTahap2($tahap2)
	{
		$this->erp->insert('kk.kk_laporan_tahap_2', $tahap2);
		return $this->erp->insert_id();
	}
	public function simpanHistoryTahap2($history)
	{
		$this->erp->insert('kk.kk_laporan_tahap_2_history', $history);
		return;
	}
	public function simpanKKBiaya($biayasimpan)
	{
		$this->erp->insert('kk.kk_biaya_kk', $biayasimpan);
		return $this->erp->insert_id();
	}
	public function simpanhistoryBiaya($biaya_history)
	{
		$this->erp->insert('kk.kk_biaya_kk_history', $biaya_history);
		return;
	}
	public function simpanSTMB($arraystmb)
	{
		$this->erp->insert('kk.kk_pengajuan_stmb', $arraystmb);
		return $this->erp->insert_id();
	}
	public function simpanHistorySTMB($historystmb)
	{
		$this->erp->insert('kk.kk_pengajuan_stmb_history', $historystmb);
		return;
	}
	public function simpanKK4($dataKK4)
	{
		$this->erp->insert('kk.kk_laporan_keterangan', $dataKK4);
		return $this->erp->insert_id();
	}
	public function simpanHistoryKK4($history_kk4)
	{
		$this->erp->insert('kk.kk_laporan_keterangan_history', $history_kk4);
		return;
	}
	public function updateT1wIdT2($dataUpdateT1,$id_lkk1_s)
	{
		$this->erp->where('id_lkk_1', $id_lkk1_s);
		$this->erp->update('kk.kk_laporan_tahap_1', $dataUpdateT1);
		return;
	}
	public function getLKK2($id2)
	{
		$this->erp->where('id_lkk_2', $id2);
		$query = $this->erp->get('kk.kk_laporan_tahap_2');
		return $query->result_array();
	}
	public function ambilBiaya($id2)
	{
		$this->erp->where('id_lkk_2', $id2);
		$query = $this->erp->get('kk.kk_biaya_kk');
		return $query->result_array();
	}
	public function ambilSTMB($id2)
	{
		$this->erp->where('id_lkk_2', $id2);
		$query = $this->erp->get('kk.kk_pengajuan_stmb');
		return $query->result_array();
	}
	public function ambilKK4($id2)
	{
		$this->erp->where('id_lkk_2', $id2);
		$query = $this->erp->get('kk.kk_laporan_keterangan');
		return $query->result_array();
	}
	public function updateTahap2($tahap2,$id)
	{
		$this->erp->where('id_lkk_2', $id);
		$this->erp->update('kk.kk_laporan_tahap_2', $tahap2);
		return;
	}
	public function updateKKBiaya($biayasimpan,$id,$i)
	{
		$this->erp->where('id_lkk_2', $id);
		$this->erp->where('id_biaya_kategori',$i);
		$this->erp->update('kk.kk_biaya_kk', $biayasimpan);
		return;
	}
	public function ambilIdBiaya($id)
	{
		$this->erp->where('id_lkk_2', $id);
		$this->erp->select('id_biaya_kk');
		$query = $this->erp->get('kk.kk_biaya_kk');
		return $query->result_array();
	}
	public function updateSTMB($arraystmb,$id,$id_pengajuan_stmb)
	{
		$this->erp->where('id_lkk_2',$id);
		$this->erp->where('id_pengajuan_stmb',$id_pengajuan_stmb);
		$this->erp->update('kk.kk_pengajuan_stmb', $arraystmb);
		return;
	}
	public function ambilIdSTMB($id)
	{
		$this->erp->where('id_lkk_2', $id);
		$this->erp->select('id_pengajuan_stmb');
		$query = $this->erp->get('kk.kk_pengajuan_stmb');
		return $query->result_array();
	}
	public function updateKK4($dataKK4,$id)
	{
		$this->erp->where('id_lkk_2', $id);
		$this->erp->update('kk.kk_laporan_keterangan', $dataKK4);
		return;
	}
	public function ambilDataKK4($id)
	{
		$this->erp->where('id_lkk_2', $id);
		$query = $this->erp->get('kk.kk_laporan_keterangan');
		return $query->result_array();
	}
	public function deleteKK4lama($id,$idketkk4)
	{
		$this->erp->where('id_lkk_2',$id);
		$this->erp->where('id_ket_kk4',$idketkk4);
		$this->erp->delete('kk.kk_laporan_keterangan');
		return $this->erp->insert_id();
	}
	public function resetIDkk4($idkk4lama)
	{
		$this->erp->query("ALTER SEQUENCE kk.kk_laporan_keterangan_id_laporan_keterangan_seq RESTART WITH $idkk4lama");
		return;
	}
	public function ambilLaporanKecelakaan($id,$i)
	{
		$this->erp->where('id_laporan_tahap_1', $id);
		$this->erp->where('id_kecelakaan', $i);
		$query = $this->erp->get('kk.kk_laporan_kecelakaan');
		return $query->result_array();
	}
	
};
