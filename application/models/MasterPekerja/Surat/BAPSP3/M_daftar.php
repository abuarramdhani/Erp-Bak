<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_Daftar extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->khs_erp 		= 	$this->load->database('erp_db', TRUE);
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
    }
	
	public function ambilDataSP3($filter)
	{
		$sql = "select p.noind, p.nama, sp.no_surat, sp.berlaku as berlaku_mulai,
				(date_trunc('month', sp.berlaku) + '6month'::interval - '1day'::interval)::date as berlaku_selesai
			from hrd_khs.tpribadi p inner join
			(select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp union
			select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp_nonabsen union
			select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp_prestasi) sp on p.noind=sp.noind
			where p.keluar='0' and sp.sp_ke='3' and (p.noind like '%$filter%' or p.nama like '%$filter%')
			order by sp.berlaku desc";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}
	
	public function ambilDataBAP($filter){
		if(!empty($filter)){	$filter = "where bap.bap_id='$filter'";	}else{	$filter = "";	}
		$sql = "select bap.*, em.employee_name, em.section_code, em.location_code
			from hr.hr_bap bap inner join er.er_employee_all em on bap.noind=em.employee_code $filter";
		$query = $this->khs_erp->query($sql);
		return $query->result_array();
	}
	
	public function ambilLayoutSurat()
	{
		$this->personalia->where('jenis_surat=', 'BAPSP3');
		$this->personalia->select('isi_surat');
		$this->personalia->from('"Surat".tisi_surat"');
		return $this->personalia->get()->result_array();
	}
	
	public function inputBAPSP3($data)
	{
	 	$this->khs_erp->insert('hr.hr_bap', $data);
	}
	
	public function updateBAPSP3($data_id, $data)
	{
	 	$this->khs_erp->where('bap_id', $data_id);
	 	$this->khs_erp->update('hr.hr_bap', $data);
	}
	
	public function deleteBAPSP3($data_id)
	{
	 	$this->khs_erp->where('bap_id', $data_id);
	 	$this->khs_erp->delete('hr.hr_bap');
	}
	
	
}