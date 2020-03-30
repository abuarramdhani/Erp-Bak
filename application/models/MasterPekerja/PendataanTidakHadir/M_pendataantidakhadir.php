<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_pendataantidakhadir extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->dinas_luar = $this->load->database('dinas_luar', TRUE);
	}

	public function getDataAll(){
		$sql = "select t1.noind,
					t2.nama,
					case when t1.jenis = 1 then 
						'SAKIT'
					when t1.jenis = 2 then 
						'LAINNYA' 
					else 
						'-'
					end as jenis, 
					case when t1.batuk = 1 then 
						'YA' 
					when t1.batuk = 0 then 
						'TIDAK'
					else 
						'-' 
					end as batuk,
					case when t1.pilek = 1 then 
						'YA' 
					when t1.batuk = 0 then 
						'TIDAK'
					else 
						'-' 
					end as pilek,
					case when t1.demam = 1 then 
						'YA' 
					when t1.batuk = 0 then 
						'TIDAK'
					else 
						'-'  
					end as demam,
					case when t1.sesak = 1 then 
						'YA' 
					when t1.batuk = 0 then 
						'TIDAK'
					else 
						'-'  
					end as sesak,
					t1.diagnosa,
					t1.tanggal_mulai,
					t1.tanggal_selesai,
					t1.status_sakit,
					case when t1.lokasi_pekerja = 1 then 
						concat(t2.alamat,', ',t2.desa,', ',t2.kec,', ',t2.kab,', ',t2.prop) 
					when t1.lokasi_pekerja = 2 then 
						t2.almt_kost
					when t1.lokasi_pekerja = 3 then 
						t1.lokasi_lainnya
					else
						'-'
					end as lokasi_pekerja, 
					t1.sk, 
					t1.foto_sk,
					t1.keterangan,
					t1.user_input,
					t1.tanggal_input,
					t1.ip_address
				from pendataan.tpendataan_sakit t1 
				left join pendataan.tpribadi t2 
				on t1.noind = t2.noind
				order by t1.tanggal_input desc";
		return $this->dinas_luar->query($sql)->result_array();
	}
}

?>