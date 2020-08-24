<?php defined('BASEPATH') or die('No direct script access allowed');

class M_Daftar extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->khs_erp = $this->load->database('default', TRUE); // postgres erp
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function ambilDataSP3($filter)
	{
		if (empty($filter)) {
			return null;
		}
		return $this->personalia->query("
			select p.noind, p.nama, sp.no_surat, sp.berlaku as berlaku_mulai, (date_trunc('month', sp.berlaku) + '6month'::interval - '1day'::interval)::date as berlaku_selesai
			from hrd_khs.tpribadi p inner join
			(select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp union
			select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp_nonabsen union
			select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp_prestasi) sp on p.noind=sp.noind
			where p.keluar='0' and sp.sp_ke='3' and (p.noind like '%$filter%' or p.nama like '%$filter%')
			order by sp.berlaku desc
		")->result_array();
	}

	public function ambilDataBAP($filter = "")
	{
		return $this->khs_erp->query("
			select
				bap.*,
				upper(trim(em.employee_name)) as employee_name,
				trim(em.section_code) as section_code,
				trim(em.location_code) as location_code,
				upper(trim((
					select
						concat(
							trim(upper(section.department_name)),
							' / ',
							trim(upper(section.field_name)),
							' / ',
							trim(upper(section.unit_name)),
							' / ',
							trim(upper(section.section_name))
						)
					from er.er_section as section
					where section.section_code = em.section_code
				))) as section
			from hr.hr_bap as bap
			inner join er.er_employee_all em on bap.noind=em.employee_code
			where deleted_date is null
		" . (!empty($filter) ? $filter = " and bap.bap_id='$filter'" : ""))->result_array();
	}

	public function ambilLayoutSurat()
	{
		return $this->personalia->select('isi_surat')->where('jenis_surat', 'BAPSP3')->get('Surat.tisi_surat')->result_array();
	}

	public function inputBAPSP3($data)
	{
		$this->khs_erp->insert('hr.hr_bap', $data);
	}

	public function updateBAPSP3($data_id, $data)
	{
		$this->khs_erp->where('bap_id', $data_id)->update('hr.hr_bap', $data);
	}

	public function deleteBAPSP3($data_id)
	{
		$this->khs_erp
			->where('bap_id', $data_id)
			->set('deleted_by', $this->session->user)
			->set('deleted_date', date('Y-m-d H:i:s'))
			->update('hr.hr_bap');
	}

	public function getPekerjaData($noind)
	{
		if (empty($noind)) {
			return null;
		}
		return $this->personalia->select('trim(upper(noind)) as noind, trim(upper(nama)) as nama')->where('noind', $noind)->limit(1)->get('hrd_khs.tpribadi')->row();
	}
}
