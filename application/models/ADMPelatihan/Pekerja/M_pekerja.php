<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pekerja extends CI_Model {
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


	public function dataPekerja($noind,$keluar)
	{
		$sql = "SELECT tp.*, tref.jabatan as jabatanref,(case when p.pekerjaan isnull then concat('-')else p.pekerjaan end) as kerja,
		            trim(tp.photo) as photo
						FROM hrd_khs.tpribadi tp
						LEFT JOIN hrd_khs.trefjabatan tref on tp.noind = tref.noind and tp.kodesie = tref.kodesie
						left join hrd_khs.tpekerjaan p on tp.kd_pkj= p.kdpekerjaan
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
    
    public function training($noind)
    {
	$sql= "select a.noind ,c.training_name,b.date,concat(b.start_time,' s.d ',b.end_time)as waktu,b.room,d.trainer_name
					from pl.pl_participant a
					inner join pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id
					inner join pl.pl_master_training c on b.training_id=c.training_id
                                        inner join pl.pl_master_trainer d on d.trainer_id = cast(b.trainer as int)
					where a.noind='$noind' order by b.date ,c.training_name asc";
    return $this->erp->query($sql)->result_array();

	}


};
