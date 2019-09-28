<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pekerjakeluar extends CI_Model {
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
		$this->daerah 		=	$this->load->database('daerah', TRUE);

	}

	public function getPekerja($pekerja,$keluar)
	{
		// $this->personalia->like('noind', $pekerja);
		// $this->personalia->or_like('nama', $pekerja);
		// $this->personalia->where('keluar', $keluar);
		// $this->personalia->select('nama,noind');
		$data = "select * from hrd_khs.tpribadi where (noind like '%$pekerja%' or nama like '%$pekerja%') and keluar='$keluar'";
		// $query = $this->personalia->get('hrd_khs.tpribadi');
		$query = $this->personalia->query($data);
		return $query->result_array();
	}

	public function getKontakPekerja($kontak)
	{
		$data = "select internal_mail,telkomsel_mygroup,external_mail,pidgin_account from er.er_employee_all";
		$query = $this->erp->query($data);
		return $query->result_array();

	}

	public function getPekerjaan($noind)
	 	{
	 		$data= "select (case 	when 	pri.kd_pkj is not null
 								then 	pri.kd_pkj || ' - ' || rtrim(tpekerjaan.pekerjaan)
								end
								) as pekerjaan,pri.kd_pkj as kd_pekerjaan
								from hrd_khs.tpribadi as pri
								left join hrd_khs.tpekerjaan as tpekerjaan
								on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
								where pri.noind='$noind'";
   			$query 	=	$this->personalia->query($data);
			return $query->result_array();
			 // return $data;
	 	}

	 /*public function getkdPekerja($pekerja,$kd_pekerjaan)
	 {
	 	$kd_pekerjaan = substr($kd_pekerjaan, 0,7);
	 	$sql = "select distinct(case 	when 	pri.kd_pkj is not null
					then 	pri.kd_pkj || ' - ' || rtrim(tpekerjaan.pekerjaan)
				end
				) as pekerjaan,pri.kd_pkj
				from hrd_khs.tpribadi as pri
			    right join hrd_khs.tpekerjaan as tpekerjaan
				on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
				where left(pri.kodesie,7) like '$kd_pekerjaan%' and upper(pekerjaan) like upper('%$pekerja%') order by pri.kd_pkj asc";
				// echo $sql;exit();
		$query 	=	$this->personalia->query($sql);
			return $query->result_array();
			 // return $data;

	 }
	 */

	  public function getkdPekerja($pekerja,$kd_pekerjaan)
	 {
	 	$kd_pekerjaan = substr($kd_pekerjaan, 0,7);
	 	$sql = "select concat_ws(' - ', kdpekerjaan, pekerjaan) as pekerjaan,kdpekerjaan
					from hrd_khs.tpekerjaan as tpekerjaan
				where left(tpekerjaan.kdpekerjaan,7) like '$kd_pekerjaan%' and status='0'
 					order by kdpekerjaan asc";
		$query 	=	$this->personalia->query($sql);
			return $query->result_array();
			 // return $data;

	 }

	public function dataPekerja($noind,$keluar)
	{
		$sql = "SELECT tp.*, tref.jabatan as jabatanref
						FROM hrd_khs.tpribadi tp
						LEFT JOIN hrd_khs.trefjabatan tref on tp.noind = tref.noind and tp.kodesie = tref.kodesie
						WHERE tp.noind = '$noind' AND keluar = '$keluar'";
		return $this->personalia->query($sql)->result_array();
	}

	public function kontakPekerja($noind)
	{
		$this->erp->where('employee_code', $noind);
		$query = $this->erp->get('er.er_employee_all');
		return $query->result_array();
	}

	public function dataSeksi($kodesie)
	{
		$this->personalia->where('kodesie', $kodesie);
		$query = $this->personalia->get('hrd_khs.tseksi');
		return $query->result_array();
	}
	public function updateDataPekerja($data,$noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tpribadi',$data);
		return;
	}

	public function updateDataPekerjaa($mail,$noind)
	{
		$this->erp->where('employee_code', $noind);
		$this->erp->update('er.er_employee_all',$mail);
		return;
	}

	public function historyUpdatePekerja($history)
	{
		$this->personalia->insert('hrd_khs.tpribadi_log', $history);
		return;
	}
	public function historyTlog($tlog)
	{
		$this->personalia->insert('hrd_khs.tlog', $tlog);
		return;
	}
	public function getProvinsi($provinsi)
	{
		$this->daerah->like('nama', $provinsi);
		$query = $this->daerah->get('provinsi');
		return $query->result_array();
	}
	public function getKabupaten($kabupaten,$id_prov)
	{
		$this->daerah->where('id_prov', $id_prov);
		$this->daerah->like('nama', $kabupaten);
		$query = $this->daerah->get('kabupaten');
		return $query->result_array();
	}
	public function getKecamatan($kecamatan,$id_kab)
	{
		$this->daerah->where('id_kab', $id_kab);
		$this->daerah->like('nama', $kecamatan);
		$query = $this->daerah->get('kecamatan');
		return $query->result_array();
	}
	public function getDesa($desa,$id_kec)
	{
		$this->daerah->where('id_kec', $id_kec);
		$this->daerah->like('nama', $desa);
		$query = $this->daerah->get('kelurahan');
		return $query->result_array();
	}
	public function ambilProv($prop)
	{
		$this->daerah->where('id_prov', $prop);
		$query = $this->daerah->get('provinsi');
		return $query->result_array();
	}
	public function ambilKab($kab)
	{
		$this->daerah->where('id_kab', $kab);
		$query = $this->daerah->get('kabupaten');
		return $query->result_array();
	}
	public function ambilKec($kec)
	{
		$this->daerah->where('id_kec', $kec);
		$query = $this->daerah->get('kecamatan');
		return $query->result_array();
	}
	public function ambilDesa($desa)
	{
		$this->daerah->where('id_kel', $desa);
		$query = $this->daerah->get('kelurahan');
		return $query->result_array();
	}
};
