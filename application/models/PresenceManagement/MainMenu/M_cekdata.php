<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_cekdata extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->quick = $this->load->database('quick',TRUE);
	}

	public function getCabang(){
		$sql = "select * from hrd_khs.tlokasi_kerja order by id_";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}

	public function getCabangByKd($kd){
		$sql = "select * from hrd_khs.tlokasi_kerja where id_ = '$kd'";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}

	public function getPekerjaUtama($kd){
		$sql =	"select count(*) from
				(select DISTINCT noind from db_datapresensi.tb_data_utama where office = '$kd')utama";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}

	public function getUtamaBanding($kd){
		$sql =	"select 
				(select count(*) 
					from
					(select DISTINCT noind 
					from db_datapresensi.tb_data_utama 
					where office = '$kd')utama
				) pekerja_utama,
				(select count(*) 
					from
					(select DISTINCT noind 
					from db_datapresensi.tb_data_banding 
					where office = '$kd')banding
				) pekerja_banding,
				(select count(*) 
					from 
					(select DISTINCT noind 
					from db_datapresensi.tb_data_utama 
					where pwd != '0' and office = '$kd') utama
				) password_utama,
				(select count(*) 
					from 
					(select DISTINCT noind 
					from db_datapresensi.tb_data_banding 
					where pwd != '0' and office = '$kd') banding
				) password_banding,
				(select count(*) 
					from 
					(select noind 
					from db_datapresensi.tb_data_utama 
					where office = '$kd' group by noind, kode_finger) utama
				) finger_utama,
				(select count(*) 
					from 
					(select noind 
					from db_datapresensi.tb_data_banding 
					where office = '$kd' group by noind, kode_finger) banding
				) finger_banding";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}

	public function getPembandingUtama($kd){
		$sql = "select * 
				from ( 
					select DISTINCT du.noind,
						(
							select nama 
							from hrd_khs.tpribadi tp 
							where tp.noind = du.noind
						) nama,
						(
							select Noind_Baru 
							from hrd_khs.tpribadi tp 
							where tp.noind = du.noind
						) noind_baru,
						(
							select count(*) 
							from db_datapresensi.tb_data_utama du2 
							where du2.noind = du.noind 
						) finger_utama,
						(
							select count(*) 
							from db_datapresensi.tb_data_banding db2 
							where db2.noind = du.noind 
						) finger_banding,
						(
							select DISTINCT pwd 
							from db_datapresensi.tb_data_utama du2 
							where du2.noind = du.noind 
						) password_utama,
						(
							select DISTINCT pwd 
							from db_datapresensi.tb_data_banding db2 
							where db2.noind = du.noind 
						) password_banding
					from db_datapresensi.tb_data_utama du
					where du.office = '$kd'
					union
					select DISTINCT db.noind,
						(
							select nama 
							from hrd_khs.tpribadi tp 
							where tp.noind = db.noind
						) nama,
						(
							select Noind_Baru 
							from hrd_khs.tpribadi tp 
							where tp.noind = db.noind
						) noind_baru,
						(
							select count(*) 
							from db_datapresensi.tb_data_utama du2 
							where du2.noind = db.noind 
						) finger_utama,
						(
							select count(*) 
							from db_datapresensi.tb_data_banding db2 
							where db2.noind = db.noind 
						) finger_banding,
						(
							select DISTINCT pwd 
							from db_datapresensi.tb_data_utama du2 
							where du2.noind = db.noind 
						) password_utama,
						(
							select DISTINCT pwd 
							from db_datapresensi.tb_data_banding db2 
							where db2.noind = db.noind 
						) password_banding
					from db_datapresensi.tb_data_banding db
					where db.office = '$kd' 
					and db.noind not in  
						(
						select DISTINCT du.noind 
						from db_datapresensi.tb_data_utama du
						where du.office = db.office
						)
				) data_pembanding 
				order by noind asc;";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}

	public function getPembandingFinger($noind){
		$sql = "select 	du.kode_finger kode_finger_utama,
						du.jari jari_utama,
						(
							select kode_finger 
							from db_datapresensi.tb_data_banding db 
							where db.noind = du.noind 
							and du.kode_finger = db.kode_finger
						) kode_finger_banding,
						(
							select jari 
							from db_datapresensi.tb_data_banding db 
							where db.noind = du.noind 
							and du.kode_finger = db.kode_finger
						) jari_banding
				from db_datapresensi.tb_data_utama du 
				where du.noind = '$noind'
				UNION
				select (
							select kode_finger 
							from db_datapresensi.tb_data_utama du 
							where db.noind = du.noind 
							and du.kode_finger = db.kode_finger
						) kode_finger_utama,
						(
							select jari 
							from db_datapresensi.tb_data_utama du 
							where db.noind = du.noind 
							and du.kode_finger = db.kode_finger
						) jari_utama,
						db.kode_finger kode_finger_banding,
						db.jari jari_banding
				from db_datapresensi.tb_data_banding db
				where db.noind = '$noind' 
				and db.kode_finger not in 	(select kode_finger 
											from db_datapresensi.tb_data_utama du 
											where db.noind = du.noind)";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}
}
?>