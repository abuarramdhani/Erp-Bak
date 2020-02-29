<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cetakdata extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	public function ambilPekerja($p)
	{
		$query = "select noind,nama from hrd_khs.tpribadi where (noind like '%$p%' or nama like '%$p%') and keluar='0' and noind like 'R%' order by noind";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function ambilKepalaTukang()
	{
		$query = "select tp.noind,tp.nama,tp.lokasi_kerja,(select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) as pekerjaan from hrd_khs.tpribadi tp where tp.noind like 'R%' and tp.keluar='0' group by tp.noind,tp,nama,tp.lokasi_kerja,pekerjaan order by tp.noind";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function ambildataRekap()
	{
		$query = "select pk.no_rekening, pk.noind, pk.atas_nama, (select b.nama_bank from hlcm.hlcm_bank b where pk.bank=b.code_bank) as bank from hlcm.hlcm_datapekerja pk";
		$data = $this->erp->query($query);
		return $data->result_array();
	}
	public function ambilPenanggungjawab()
	{
		$data = $this->erp->get('hlcm.hlcm_approval');
		return $data->result_array();
	}

	public function getCutOffGaji(){
		$sql = "select distinct periode,
						case when substring(periode,5,2) = '01' then
							'Januari'
						when substring(periode,5,2) = '02' then
							'Februari'
						when substring(periode,5,2) = '03' then
							'Maret'
						when substring(periode,5,2) = '04' then
							'April'
						when substring(periode,5,2) = '05' then
							'Mei'
						when substring(periode,5,2) = '06' then
							'Juni'
						when substring(periode,5,2) = '07' then
							'Juli'
						when substring(periode,5,2) = '08' then
							'Agustus'
						when substring(periode,5,2) = '09' then
							'September'
						when substring(periode,5,2) = '10' then
							'Oktober'
						when substring(periode,5,2) = '11' then
							'November'
						when substring(periode,5,2) = '12' then
							'Desember'
						end bulan,
						left(periode,4) tahun,
						concat(to_char(tgl_awal_periode, 'dd'),
						' ',
						(case when extract(month from tgl_awal_periode) = '1' then
							'Januari'
						when extract(month from tgl_awal_periode) = '2' then
							'Februari'
						when extract(month from tgl_awal_periode) = '3' then
							'Maret'
						when extract(month from tgl_awal_periode) = '4' then
							'April'
						when extract(month from tgl_awal_periode) = '5' then
							'Mei'
						when extract(month from tgl_awal_periode) = '6' then
							'Juni'
						when extract(month from tgl_awal_periode) = '7' then
							'Juli'
						when extract(month from tgl_awal_periode) = '8' then
							'Agustus'
						when extract(month from tgl_awal_periode) = '9' then
							'September'
						when extract(month from tgl_awal_periode) = '10' then
							'Oktober'
						when extract(month from tgl_awal_periode) = '11' then
							'November'
						when extract(month from tgl_awal_periode) = '12' then
							'Desember'
						end),
						' ',
						to_char(tgl_awal_periode, 'YYYY')
						) awal,
						concat(to_char(tgl_akhir_periode, 'dd'),
						' ',
						(case when extract(month from tgl_akhir_periode) = '1' then
							'Januari'
						when extract(month from tgl_akhir_periode) = '2' then
							'Februari'
						when extract(month from tgl_akhir_periode) = '3' then
							'Maret'
						when extract(month from tgl_akhir_periode) = '4' then
							'April'
						when extract(month from tgl_akhir_periode) = '5' then
							'Mei'
						when extract(month from tgl_akhir_periode) = '6' then
							'Juni'
						when extract(month from tgl_akhir_periode) = '7' then
							'Juli'
						when extract(month from tgl_akhir_periode) = '8' then
							'Agustus'
						when extract(month from tgl_akhir_periode) = '9' then
							'September'
						when extract(month from tgl_akhir_periode) = '10' then
							'Oktober'
						when extract(month from tgl_akhir_periode) = '11' then
							'November'
						when extract(month from tgl_akhir_periode) = '12' then
							'Desember'
						end),
						' ',
						to_char(tgl_awal_periode, 'YYYY')
						) akhir,
						concat(tgl_awal_periode,' - ',tgl_akhir_periode) rangetanggal
				from hlcm.hlcm_proses
				order by periode desc";
		$data = $this->erp->query($sql);
		return $data->result_array();
	}

	public function ambilPotTam($awal,$akhir){
		$sql = "select noind,nama,
						sum(nominal_gp) as total_gp, 
						sum(nominal_um) as total_um, 
						sum(nominal_lembur) as total_lembur
				from (
					select 'tambahan' as sumber,noind,
						(select employee_name from er.er_employee_all e where e.employee_code = a.noind) as nama,
						nominal_gp, nominal_um,nominal_lembur 
					from hlcm.hlcm_tambahan a
					where tgl_awal_periode = '$awal'
					and tgl_akhir_periode = '$akhir'
				union all
					select 'potongan' as sumber,noind,
						(select employee_name from er.er_employee_all e where e.employee_code = a.noind) as nama,
						(-1*nominal_gp), (-1*nominal_um),(-1*nominal_lembur)
					from hlcm.hlcm_potongan a
					where tgl_awal_periode = '$awal'
					and tgl_akhir_periode = '$akhir'
				) as tbl
				group by noind, nama";
		$data = $this->erp->query($sql);
		return $data->result_array();
	}
	
	public function ambilPotTam_detail($awal,$akhir){
		$sql = "select noind,nama,
						nominal_gp, 
						nominal_um, 
						nominal_lembur,
						gp,
						um,
						lembur,
						gp_perhari,
						um_perhari,
						lembur_perjam,
						sumber
				from (
					select 'tambahan' as sumber,noind,
						(select employee_name from er.er_employee_all e where e.employee_code = a.noind) as nama,
						nominal_gp, nominal_um,nominal_lembur,gp,um,lembur,gp_perhari,um_perhari,lembur_perjam
					from hlcm.hlcm_tambahan a
					where tgl_awal_periode = '$awal'
					and tgl_akhir_periode = '$akhir'
				union all
					select 'potongan' as sumber,noind,
						(select employee_name from er.er_employee_all e where e.employee_code = a.noind) as nama,
						nominal_gp,nominal_um,nominal_lembur,gp,um,lembur,gp_perhari,um_perhari,lembur_perjam
					from hlcm.hlcm_potongan a
					where tgl_awal_periode = '$awal'
					and tgl_akhir_periode = '$akhir'
				) as tbl";
		$data = $this->erp->query($sql);
		return $data->result_array();
	}
	
};
