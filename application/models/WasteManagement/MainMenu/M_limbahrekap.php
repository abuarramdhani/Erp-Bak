<?php 
defined('BASEPATH') or exit('No Direct Access Allowed');
/**
 * 
 */
class M_limbahrekap extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSeksi(){
		$sql = "select left(sect.section_code, 7) section_code, 
                    sect.section_name 
                    from er.er_section sect 
                    where sect.section_code like '%00' 
                    and sect.section_name != '-' 
                    order by sect.section_name;";

		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getLimbah(){
		$sql = "select id_jenis_limbah,jenis_limbah,kode_limbah 
				from ga.ga_limbah_jenis 
				order by kode_limbah";

		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDataExport($aw,$ak,$li,$se){
		$sql = "select limjen.jenis_limbah jenis,
				limkir.tanggal_kirim::date tanggal, 
				tanggal_kirim::time waktu, 
				concat(limkir.noind_pengirim,' ',employee.employee_name) pengirim,
				sec.section_name,
				case when bocor = '1' then
				'Ya'
				else
				'Tidak'
				end bocor,
				concat(limkir.jumlah_kirim,' ',limsat.limbah_satuan) jumlah,
				limkir.berat_kirim berat,
				limkir.ket_kirim keterangan
				from ga.ga_limbah_kirim limkir
				inner join ga.ga_limbah_jenis limjen 
				on limjen.id_jenis_limbah = limkir.id_jenis_limbah
				left join er.er_section sec 
				on sec.section_code = concat(limkir.kodesie_kirim,'00')
				left join ga.ga_limbah_satuan limsat
				on limsat.id_jenis_limbah = limkir.id_jenis_limbah
				left join er.er_employee_all employee 
				on employee.employee_code = limkir.noind_pengirim
				where tanggal_kirim between '$aw' and '$ak' 
				and status_kirim = '1'
				$li
				$se 
				order by tanggal_kirim desc";

		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getExportAll($tgl_awal,$tgl_akhir,$id_limbah,$kd_sie){
		$query = "	select 	limjen.kode_limbah,
							cast(limkir.tanggal_kirim as date) tanggal_dihasilkan, 
							'90' masa_simpan,
							'MASUK KE TPS INTERNAL' tps,
							'TPS INTERNAL' sumber,
							'' kode_manifest,
							'CV. CV. KARYA HIDUP SENTOSA' pengirim_nama,
							cast(limkir.berat_kirim as float)/1000 jumlah,
							'' catatan
					from ga.ga_limbah_kirim limkir
					inner join ga.ga_limbah_jenis limjen
						on limjen.id_jenis_limbah = limkir.id_jenis_limbah
					where tanggal_kirim between '$tgl_awal' and '$tgl_akhir'
					and limkir.status_kirim = '1'
					$id_limbah
					$kd_sie
					order by tanggal_kirim desc";
		$result = $this->db->query($query);
		return $result->result_array();
	}
}
?>