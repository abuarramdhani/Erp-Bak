<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_prosesgaji extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	public function ambilNominalGaji()
	{
		$query = "select * from hlcm.hlcm_datagaji";
		$data = $this->erp->query($query);
		return $data->result_array();
	}

	public function ambilNominalGajiPotTam($noind){
		$sql = "select a.noind,a.nama,b.pekerjaan,b.lokasi_kerja,b.nominal,b.uang_makan,b.uang_makan_puasa 
				from hlcm.hlcm_datapekerja a
				inner join hlcm.hlcm_datagaji b 
				on a.kode_pekerjaan = b.kode_pekerjaan 
				and a.lokasi_kerja = b.lokasi_kerja
				where a.noind = '$noind'";
		return $this->erp->query($sql)->row();
	}

	public function getPekerjaPotTam($text){
		$sql = "select noind,nama 
				from hlcm.hlcm_datapekerja 
				where upper(nama) like upper('%$text%') or upper(noind) like upper('%$text%')";
		return $this->erp->query($sql)->result_array();
	}

	public function insertPotTam($table,$data){
		$this->erp->insert($table,$data);
	}

	public function getLastTamPot($noind = FALSE,$awal = FALSE,$akhir = FALSE){
		if ($noind == FALSE) {
			if ($awal !== FALSE & $akhir !== FALSE){
				$kondisi = "where tgl_awal_periode = '$awal'
				and tgl_akhir_periode = '$akhir'";
			}else {
				$kondisi = "";
			}
		}else {
			$kondisi = "where noind = '$noind'
				and tgl_awal_periode = '$awal'
				and tgl_akhir_periode = '$akhir'";
		}
		$sql = "select 'tambahan' as sumber,(select employee_name from er.er_employee_all e where e.employee_code = a.noind) as nama,* 
				from hlcm.hlcm_tambahan a
				$kondisi
				union all
				select 'potongan' as sumber,(select employee_name from er.er_employee_all e where e.employee_code = a.noind) as nama, * 
				from hlcm.hlcm_potongan a
				$kondisi";
		return $this->erp->query($sql)->result_array();
	}

	public function getTamPotAll($awal,$akhir,$noind = FALSE){
		$where = "";
		if ($noind != FALSE) {
			$where = "and a.noind = '$noind'";
		}
		$sql = "select 	a.noind,a.nama,d.pekerjaan,'$awal'::date as awal, '$akhir'::date as akhir,
						(select location_name from er.er_location where location_code = a.lokasi_kerja) as lokasi_kerja,
						coalesce(b.gp, 0) as tam_gp, coalesce(b.um, 0) as tam_um, coalesce(b.lembur, 0) as tam_lembur,
						coalesce(c.gp, 0) as pot_gp, coalesce(c.um, 0) as pot_um, coalesce(c.lembur, 0) as pot_lembur,
						coalesce(b.nominal_gp, 0) as nom_tam_gp, coalesce(b.nominal_um, 0) as nom_tam_um, coalesce(b.nominal_lembur, 0) as nom_tam_lembur,
						coalesce(c.nominal_gp, 0) as nom_pot_gp, coalesce(c.nominal_um, 0) as nom_pot_um, coalesce(c.nominal_lembur, 0) as nom_pot_lembur
				from hlcm.hlcm_datapekerja a
				left join hlcm.hlcm_tambahan b 
				on a.noind = b.noind 
				and b.tgl_awal_periode = '$awal'
				and b.tgl_akhir_periode = '$akhir'
				left join hlcm.hlcm_potongan c 
				on a.noind = c.noind 
				and c.tgl_awal_periode = '$awal'
				and c.tgl_akhir_periode = '$akhir'
				left join hlcm.hlcm_datagaji d 
				on a.kode_pekerjaan = d.kode_pekerjaan
				and a.lokasi_kerja = d.lokasi_kerja
				where 	(
							b.tgl_awal_periode is not null 
						or 
							c.tgl_awal_periode is not null
						)
						$where
				order by a.noind";
		return $this->erp->query($sql)->result_array();
	}

	public function deleteTamPot($awal,$akhir,$noind){
		$sql = "delete from hlcm.hlcm_potongan 
				where tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir' and noind = '$noind'";
		$this->erp->query($sql);
		$sql = "delete from hlcm.hlcm_tambahan 
				where tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir' and noind = '$noind'";
		$this->erp->query($sql);
	}

	public function insertHistoryPotTam($awal,$akhir,$noind,$user,$action){
		$waktu = time();
		$sql = "insert into hlcm.hlcm_tambahan_history
				(id_tambahan, noind, tgl_awal_periode, tgl_akhir_periode, gp, um, lembur, created_timestamp, created_by, nominal_gp, nominal_um, nominal_lembur, gp_perhari, um_perhari, lembur_perjam,action,action_user,action_time)
				select id_tambahan, noind, tgl_awal_periode, tgl_akhir_periode, gp, um, lembur, created_timestamp, created_by, nominal_gp, nominal_um, nominal_lembur, gp_perhari, um_perhari, lembur_perjam,'$action','$user','$waktu'
				from hlcm.hlcm_tambahan 
				where noind = '$noind' and tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir';";
		$this->erp->query($sql);

		$sql = "insert into hlcm.hlcm_potongan_history
				(id_potongan, noind, tgl_awal_periode, tgl_akhir_periode, gp, um, lembur, created_timestamp, created_by, nominal_gp, nominal_um, nominal_lembur, gp_perhari, um_perhari, lembur_perjam,action,action_user,action_time)
				select id_potongan, noind, tgl_awal_periode, tgl_akhir_periode, gp, um, lembur, created_timestamp, created_by, nominal_gp, nominal_um, nominal_lembur, gp_perhari, um_perhari, lembur_perjam,'$action','$user','$waktu'
				from hlcm.hlcm_potongan 
				where noind = '$noind' and tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir';";
		$this->erp->query($sql);
	}

	public function getHistoryTamPot(){
		$sql = "select a.noind,a.nama,p.tgl_awal_periode,p.tgl_akhir_periode 
				from hlcm.hlcm_datapekerja a 
				join hlcm.hlcm_potongan_history p
				on a.noind = p.noind
				join hlcm.hlcm_tambahan_history t
				on p.noind = t.noind 
				and p.tgl_awal_periode = t.tgl_awal_periode
				and p.tgl_akhir_periode = t.tgl_akhir_periode
				and p.action_time = t.action_time
				group by a.noind,p.tgl_awal_periode,p.tgl_akhir_periode,a.nama
				order by p.tgl_awal_periode desc ,p.tgl_akhir_periode desc ,a.noind";
		return $this->erp->query($sql)->result_array();
	}

	public function getDetailHistoryTamPot($noind,$awal,$akhir){
		$sql = "select 	to_timestamp(p.action_time)::timestamp as waktu, 
						p.action_user,
						case when p.\"action\" = 1 then 
							'Created' 
						when p.\"action\" = 2 then 
							'Before Edit' 
						when p.\"action\" = 3 then 
							'After Edit' 
						else 
							'Deleted' 
						end as kegiatan,
						p.gp as pgp,p.nominal_gp as pnominal_gp,p.gp_perhari as pgp_perhari,
						p.um as pum,p.nominal_um as pnominal_um,p.um_perhari as pum_perhari,
						p.lembur as plembur, p.nominal_lembur as pnominal_lembur,p.lembur_perjam as plembur_perjam,
						t.gp as tgp,t.nominal_gp as tnominal_gp,t.gp_perhari as tgp_perhari,
						t.um as tum,t.nominal_um as tnominal_um,t.um_perhari as tum_perhari,
						t.lembur as tlembur, t.nominal_lembur as tnominal_lembur,t.lembur_perjam as tlembur_perjam
				from hlcm.hlcm_datapekerja a 
				join hlcm.hlcm_potongan_history p
				on a.noind = p.noind
				join hlcm.hlcm_tambahan_history t
				on p.noind = t.noind 
				and p.tgl_awal_periode = t.tgl_awal_periode
				and p.tgl_akhir_periode = t.tgl_akhir_periode
				and p.action_time = t.action_time
				where a.noind = '$noind' 
				and (
					(p.tgl_awal_periode = '$awal' and p.tgl_akhir_periode = '$akhir') 
					or 
					(t.tgl_awal_periode = '$awal' and t.tgl_akhir_periode = '$akhir')
				)
				order by p.action_time desc ";
		return $this->erp->query($sql)->result_array();
	}

	public function getTambahan($noind,$awal,$akhir){
		$sql = "select * from hlcm.hlcm_tambahan where noind = '$noind' and tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir'";
		return $this->erp->query($sql)->row();
	}

	public function getPotongan($noind,$awal,$akhir){
		$sql = "select * from hlcm.hlcm_potongan where noind = '$noind' and tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir'";
		return $this->erp->query($sql)->row();
	}

	public function getApproval($jenis){
		$sql = "select c.posisi,a.noind,trim(a.nama) as nama,a.jabatan,a.id_status,a.lokasi_kerja 
				from hlcm.hlcm_approval a 
				inner join hlcm.hlcm_document b 
				on a.document_id = b.id_document
				inner join hlcm.hlcm_posisi c 
				on a.id_status = c.id_status
				where b.nama_document = '$jenis'";
		return $this->erp->query($sql)->result_array();
	}

	public function getCutOffGaji($all = FALSE){
		if (isset($all) and !empty($all)) {
			$all = "";
		}else{
			$all ="where left(periode,4) = to_char(current_timestamp,'YYYY')";
		}
		
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
						concat(tanggal_awal::date,' - ',tanggal_akhir::date) rangetanggal,
						tanggal_awal::date,
						tanggal_akhir::date
				from \"Presensi\".tcutoff $all 
				order by periode";

		$data = $this->personalia->query($sql);
		return $data->result_array();
	}

	public function getCutOffGajiPotTam(){
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
						concat(tanggal_awal::date,' - ',tanggal_akhir::date) rangetanggal,
						tanggal_awal::date,
						tanggal_akhir::date
				from \"Presensi\".tcutoff where tanggal_awal >= current_timestamp - interval '6 month'
				order by periode";
		$data = $this->personalia->query($sql);
		return $data->result_array();
	}

	public function updateTamPot($awal,$akhir,$noind,$data,$jenis,$gp,$um,$lembur){
		$sql = "update hlcm.hlcm_$jenis 
				set gp = $gp, um = $um, lembur = $lembur ,
				nominal_gp = $gp*gp_perhari, nominal_um = $um*um_perhari, nominal_lembur = $lembur*lembur_perjam 
				where noind = '$noind' and tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir'";
		$this->erp->query($sql);
	}

	public function cekTambahanPotongan($jenis,$awal,$akhir,$noind){
		$sql = "select * from hlcm.hlcm_$jenis
				where noind = '$noind' and tgl_awal_periode = '$awal' and tgl_akhir_periode = '$akhir'";
		return $this->erp->query($sql)->num_rows();
	}

	public function getNominalFromTamPot($awal,$akhir,$noind){
		$kondisi = "where a.noind = '$noind' and a.tgl_awal_periode = '$awal' and a.tgl_akhir_periode = '$akhir'";
		$sql = "select * 
				from hlcm.hlcm_tambahan a
				$kondisi
				union all
				select * 
				from hlcm.hlcm_potongan a
				$kondisi ";
		return $this->erp->query($sql)->row();
	}

	public function getLocationCode($noind){
		$sql = "select b.lokasi_kerja
				from hrd_khs.tpribadi a 
				inner join  hrd_khs.tlokasi_kerja b 
				on a.lokasi_kerja = b.id_
				where noind = '$noind';";
		$data = $this->personalia->query($sql)->row();
		if (isset($data) and !empty($data)) {
			return $data->lokasi_kerja;
		}else{
			return "-";
		}
	}

	public function getHlcmProses($periode,$noind){
		$sql = "select * from hlcm.hlcm_proses where noind = '$noind' and periode = '$periode'";
		$result = $this->erp->query($sql);
		return $result->num_rows();
	}
	
	public function getHlcmProsesDetail($periode,$noind,$kode_pekerjaan){
		$sql = "select * from hlcm.hlcm_proses_detail where noind = '$noind' and periode = '$periode' and kode_pekerjaan = '$kode_pekerjaan'";
		$result = $this->erp->query($sql);
		return $result->num_rows();
	}

	public function insertHlcmProses($data){
		$this->erp->insert('hlcm.hlcm_proses',$data);
	}

	public function insertHlcmProsesDetail($data){
		$this->erp->insert('hlcm.hlcm_proses_detail',$data);
	}

	public function updateHlcmproses($data){
		$this->erp->where('noind',$data['noind']);
		$this->erp->where('periode',$data['periode']);
		$this->erp->update('hlcm.hlcm_proses',$data);
	}
	
	public function updateHlcmprosesDetail($data){
		$this->erp->where('noind',$data['noind']);
		$this->erp->where('periode',$data['periode']);
		$this->erp->where('kode_pekerjaan',$data['kode_pekerjaan']);
		$this->erp->update('hlcm.hlcm_proses_detail',$data);
	}

	public function getHlcmProsesPrint($tglBln,$keluar = FALSE,$lokasi = FALSE){
		$where_keluar = "";
		if ($keluar !== FALSE) {
			$sql = "select tanggal_awal::date as awal, tanggal_akhir::date as akhir from \"Presensi\".tcutoff where periode = '$tglBln' and os='0'";
			$query_1 = $this->personalia->query($sql)->row();
			$tanggalawal = $query_1->awal;
			$tanggalakhir = $query_1->akhir;
			if ($keluar == "1") {
				$where_keluar = "and (eall.resign_date between '$tanggalawal' and '$tanggalakhir' or eall.resign = '0')";
			}elseif($keluar == "2"){
				$where_keluar = " and eall.resign = '0' ";
			}else{
				$where_keluar = " and eall.resign_date between '$tanggalawal' and '$tanggalakhir' ";
			}
			
		}
		$lokasi_kerja = '';
		if (isset($lokasi) and !empty($lokasi)) {
			$lokasi_kerja = " and prs.lokasi_kerja = '$lokasi' ";
		}
		$sql = "select prs.* ,
					(	select pekerjaan 
						from hlcm.hlcm_datagaji 
						where prs.kode_pekerjaan = kode_pekerjaan 
						and prs.lokasi_kerja::int = lokasi_kerja::int) pekerjaan,
					employee_name nama
				from hlcm.hlcm_proses prs
				inner join er.er_employee_all eall
					on prs.noind = eall.employee_code
				where prs.periode = '$tglBln'
				$lokasi_kerja
				$where_keluar
				order by prs.kode_pekerjaan";

		$result = $this->erp->query($sql);
		return $result->result_array();
	}

	public function getHlcmSlipGajiPrint($tgl_awal,$tgl_akhir,$noind,$status = FALSE){
		$where_keluar = "";
		if ($status !== FALSE) {
			if ($status == "1") {
				$where_keluar = "and (eall.resign_date between '$tgl_awal' and '$tgl_akhir' or eall.resign = '0')";
			}elseif($status == "2"){
				$where_keluar = " and eall.resign = '0' ";
			}else{
				$where_keluar = " and eall.resign_date between '$tgl_awal' and '$tgl_akhir' ";
			}
		}
		$no_induk = '';
		if (isset($noind) and !empty($noind)) {
			$no_induk = " and prs.noind = '$noind' ";
		}
		$sql = "select prs.* ,
					(	select pekerjaan 
						from hlcm.hlcm_datagaji 
						where prs.kode_pekerjaan = kode_pekerjaan 
						and concat('0',prs.lokasi_kerja) = lokasi_kerja) pekerjaan,
					trim(employee_name) nama
				from hlcm.hlcm_proses prs
				inner join er.er_employee_all eall
					on prs.noind = eall.employee_code
				where prs.tgl_awal_periode = '$tgl_awal'
				and prs.tgl_akhir_periode = '$tgl_akhir'
				$no_induk
				$where_keluar
				order by prs.noind asc";
				
		$result = $this->erp->query($sql);
		return $result->result_array();
	}

	public function cekPuasa($noind){
		$sql = "select puasa from hrd_khs.tpribadi where noind = '$noind' and puasa = '1'";
		$result = $this->personalia->query($sql);
		return $result->num_rows();
	}

	public function getRecordAbsenPekerjaByPeriode($periode){
		$sql = "select *
				from hlcm.record_absen_pekerja
				where to_char(periode,'yyyy-mm') = to_char('$periode'::date,'yyyy-mm')";
		$result = $this->erp->query($sql);
		return $result->result_array();
	}
	
	public function prosesHitung($tanggalawal,$tanggalakhir,$lokasi_kerja,$keluar,$puasa = FALSE)
	{
		if ($puasa !== FALSE) {
			$periode_puasa = explode(" - ", $puasa);
			$puasaAwal = $periode_puasa['0'];
			$puasaAkhir = $periode_puasa['1'];
		}else{
			$puasaAwal = '1990-01-01';
			$puasaAkhir = '1990-01-01';
		}

		if ($keluar == "1") {
			$where_keluar = "and (tp.tglkeluar between '$tanggalawal' and '$tanggalakhir' or tp.keluar = '0')";
		}elseif($keluar == "2"){
			$where_keluar = " and tp.keluar = '0' ";
		}else{
			$where_keluar = " and tp.tglkeluar between '$tanggalawal' and '$tanggalakhir' ";
		}
		
		
		$query = "select tp.noind,tp.nama,tp.lokasi_kerja, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tpk.kdpekerjaan=tp.kd_pkj) as pekerjaan, (select tpk.kdpekerjaan from hrd_khs.tpekerjaan tpk where tpk.kdpekerjaan=tp.kd_pkj) as kdpekerjaan, 
				round((
	case
		when
			substring(tp.noind,1,1)='R'
		then
			count(tsp.tanggal)			
			-
			(
				case
					when
						(extract(month from ('$tanggalakhir')::date)+1)=extract(month from ('$tanggalakhir')::date)
					then
						case
							when
								(30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))>=0
							then
								(30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))
							else
								0
						end
					else
						0
				end
			)
			-
			(
				case when tp.tglkeluar < '$tanggalakhir' and tp.tglkeluar != '1900-01-01' then 
					(select count(*) from \"Presensi\".tshiftpekerja tsp2 where tsp2.noind = tp.noind and tsp2.tanggal between tp.tglkeluar and '$tanggalakhir')
				else 
					0
				end
			)
			-
			(
			    select count(*)
			    from \"Presensi\".tdatapresensi tdpx
			    where tdpx.noind = tp.noind 
			    and tdpx.tanggal between '$tanggalawal' and '$tanggalakhir'
			    and tdpx.kd_ket = 'PRM'
			)
			-
			sum(
						coalesce((
							select 
								sum(case
									when
										tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0')
									then
										tsp.jam_kerja / tsp.jam_kerja
									when
										tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0')
									then
									case
									when
										(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time<=tsp.ist_mulai::time
									then
										case
											when
												tdt1.keluar::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then 
													case
													--1
														when
															tdt1.masuk::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from (tdt1.masuk::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from 
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tdt1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tdt1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then
													case
													--7
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--8
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then 
																extract(epoch from
																	tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-tsp.ist_selesai::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
											then
													case
													--12
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from
																	tdt1.masuk::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then 
																extract(epoch from
																	tsp.ist_mulai::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.masuk::time-tsp.ist_selesai::time)+
																	(tsp.ist_mulai::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then 
													case
													--16
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--17
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.masuk::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
										end
									else
										case
											when
												tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
											then 
													case
													--1
														when
															tdt1.masuk::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from (tdt1.masuk::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from (tsp.ist_mulai::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.break_mulai::time - interval '1 second')
															then
																extract(epoch from 
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	(tdt1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tdt1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then
													case
													--7
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--8
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	tdt1.keluar::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then
													case
													--12
														when
															tdt1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	tdt1.masuk::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)+
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then 
													case
													--16
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--17
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.masuk::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
										end
									end
								end )
							from \"Presensi\".tdatatim tdt1
							where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal
						),0)
				)
-
sum(
	coalesce(
				(	
				select
					sum(case
						when
							tdp1.kd_ket='PSK'
						then
							 1 
						else 0						
					end)
				from \"Presensi\".tdatapresensi tdp1
				where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
			),0)
		)
				-
				sum(
					coalesce((
							select
								sum(case
									when
										tdp1.kd_ket = rtrim('PSP')
									then
case when tp.lokasi_kerja='06'
then 0
else
									case
									when
										(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time<=tsp.ist_mulai::time
									then
										case
											when
												tdp1.keluar::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then 
												case
													--1
														when
															tdp1.masuk::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from (tdp1.masuk::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from 
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tdp1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tdp1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then
													case
													--7
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--8
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then 
																extract(epoch from
																	tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-tsp.ist_selesai::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
											then
													case
													--12
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from
																	tdp1.masuk::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then 
																extract(epoch from
																	tsp.ist_mulai::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.masuk::time-tsp.ist_selesai::time)+
																	(tsp.ist_mulai::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then 
													case
													--16
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--17
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.masuk::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
										end
									else
										case
											when
												tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
											then 
												case
													--1
														when
															tdp1.masuk::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from (tdp1.masuk::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from (tsp.ist_mulai::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from 
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	(tdp1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tdp1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then
													case
													--7
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--8
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	tdp1.keluar::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then
													case
													--12
														when
															tdp1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	tdp1.masuk::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)+
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then 
													case
													--16
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--17
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.masuk::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
											end		end
										end
									end
								end)
							from \"Presensi\".tdatapresensi tdp1
							where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
						),0)
				)
				
		else
			0
	end
)::decimal,2) 
as gpokok,
round((
 count(tsp.tanggal)
 -
 (
  case
   when
    (extract(month from ('$tanggalakhir')::date)+1)=extract(month from ('$tanggalakhir')::date)
   then
    case
     when
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))>=0
     then
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))
     else
      0
    end
   else
    0
  end
 )
 -
 (
	 case when tp.tglkeluar < '$tanggalakhir' and tp.tglkeluar != '1900-01-01' then 
		 (select count(*) from \"Presensi\".tshiftpekerja tsp2 where tsp2.noind = tp.noind and tsp2.tanggal between tp.tglkeluar and '$tanggalakhir')
	 else 
		 0
	 end
 )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0') or tdt1.point='1'
      then
       1
      when
       tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0')
      then
       case
        when
         tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')			
        then
         case
          when
           tdt1.masuk::time between tsp.jam_msk::time and tsp.ist_mulai::time	
          then
           0
          else
           1
         end
        when
         tdt1.keluar::time between tsp.ist_mulai::time and (tsp.jam_plg::time - interval '1 second')
        then
         case
          when
           tdt1.masuk::time > tsp.ist_mulai::time
          then
           0														
          else
           1														
         end
       end
     end)
    from \"Presensi\".tdatatim tdt1
    where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal
   ),0)
  )
+
sum(
 coalesce(
    ( 
    select
     sum(case
         when
          tdp1.kd_ket='Sudah Tidak Digunakan PLB'
         then
          case
           when
            extract(dow from tsp.tanggal::date)='7'         
           then
            case
             when
              tdp1.keluar::time >='12:15:00'::time
             then
              1
             else
              0
            end
           else
            case
             when
              tdp1.keluar::time >='11:45:00'::time 
             then
              1
             else
              0
            end
          end
         else
          0
        end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
   ),0)
  )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       (tdp1.kd_ket in ('PSK','PRM','PKK','PIP','PCZ')  or (tdp1.kd_ket!='CB' and tdp1.kd_ket like 'C%')) or (tdp1.kd_ket='PDL' and (tdp1.masuk='0' or tdp1.masuk='' ))
      then
       1
      when
       tdp1.kd_ket = rtrim('PSP')
      then
       case
        when
         tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')   
        then
         case
          when
           tdp1.masuk::time > tsp.ist_selesai::time
          then
           0              
          else
           1              
         end
       end
     end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
   ),0)
  )
  +
  sum((select count(*) 
  from \"Presensi\".tdatapresensi tdp2 
  where tdp2.tanggal between '$tanggalawal' and '$tanggalakhir' 
  and tdp2.noind = tsp.noind
  and tdp2.kd_ket='HL'))/count(tsp.tanggal
  )
)::decimal,2)
as um,
round((
 (
 	select count(tsp1.tanggal)
 	from \"Presensi\".tshiftpekerja tsp1 
 	where tsp1.tanggal between '$tanggalawal' and '$tanggalakhir' 
  	and tsp1.tanggal between '$puasaAwal' and '$puasaAkhir'
 	and tsp1.noind = tp.noind
 )
 -
 (
	 case when tp.tglkeluar < '$tanggalakhir' and tp.tglkeluar != '1900-01-01' then 
		 (select count(*) from \"Presensi\".tshiftpekerja tsp2 where tsp2.noind = tp.noind and tsp2.tanggal between tp.tglkeluar and '$tanggalakhir' and tsp2.tanggal between '$puasaAwal' and '$puasaAkhir')
	 else 
		 0
	 end
 )
 -
 (
  case
   when
    (extract(month from ('$tanggalakhir')::date)+1)=extract(month from ('$tanggalakhir')::date)
   then
    case
     when
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))>=0
     then
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))
     else
      0
    end
   else
    0
  end
 )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0') or tdt1.point='1'
      then
       1
      when
       tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0')
      then
       case
        when
         tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')			
        then
         case
          when
           tdt1.masuk::time between tsp.jam_msk::time and tsp.ist_mulai::time	
          then
           0
          else
           1
         end
        when
         tdt1.keluar::time between tsp.ist_mulai::time and (tsp.jam_plg::time - interval '1 second')
        then
         case
          when
           tdt1.masuk::time > tsp.ist_mulai::time
          then
           0														
          else
           1														
         end
       end
     end)
    from \"Presensi\".tdatatim tdt1
    where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal 
  	and tdt1.tanggal between '$puasaAwal' and '$puasaAkhir'
   ),0)
  )
+
sum(
 coalesce(
    ( 
    select
     sum(case
         when
          tdp1.kd_ket='Sudah Tidak Digunakan PLB'
         then
          case
           when
            extract(dow from tsp.tanggal::date)='7'         
           then
            case
             when
              tdp1.keluar::time >='12:15:00'::time
             then
              1
             else
              0
            end
           else
            case
             when
              tdp1.keluar::time >='11:45:00'::time 
             then
              1
             else
              0
            end
          end
         else
          0
        end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal 
  	and tdp1.tanggal between '$puasaAwal' and '$puasaAkhir'
   ),0)
  )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       (tdp1.kd_ket in ('PSK','PRM','PKK','PIP','PCZ')  or (tdp1.kd_ket!='CB' and tdp1.kd_ket like 'C%')) or (tdp1.kd_ket='PDL' and (tdp1.masuk='0' or tdp1.masuk='' ))
      then
       1
      when
       tdp1.kd_ket = rtrim('PSP')
      then
       case
        when
         tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')   
        then
         case
          when
           tdp1.masuk::time > tsp.ist_selesai::time
          then
           0              
          else
           1              
         end
       end
     end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal 
  	and tdp1.tanggal between '$puasaAwal' and '$puasaAkhir'
   ),0)
  )
  +
  sum((select count(*) 
  from \"Presensi\".tdatapresensi tdp2 
  where tdp2.tanggal between '$tanggalawal' and '$tanggalakhir' 
  and tdp2.tanggal between '$puasaAwal' and '$puasaAkhir'
  and tdp2.noind = tsp.noind
  and tdp2.kd_ket='HL'))/count(tsp.tanggal
  )
)::decimal,2)
as ump,
round(
coalesce(
	(
		select sum(tdp1.total_lembur) 
		from \"Presensi\".tdatapresensi tdp1 
		where tdp1.noind=tp.noind 
		and tanggal between '$tanggalawal' and '$tanggalakhir'
		and tanggal not in	(
								select tssl.tanggal 
								from \"Presensi\".tsusulan tssl
								where tssl.noind = tp.noind
								and ket = 'LEMBUR'
							)
	)
,0)::decimal
+
coalesce(
	(
		select sum(tdp1.total_lembur) 
		from \"Presensi\".tdatapresensi tdp1 
		where tdp1.noind=tp.noind 
		and tanggal in	(	
							select tssl.tanggal 
							from \"Presensi\".tsusulan tssl
							where tssl.noind = tp.noind
							and (reffgaji is null or reffgaji = '$tanggalakhir')
							and ket = 'LEMBUR'
						)
	)
,0)::decimal
,2)
as lembur,
tp.puasa
from hrd_khs.tpribadi tp
left join \"Presensi\".tshiftpekerja tsp on tsp.noind=tp.noind
where left(tp.noind,1)='R' and tsp.tanggal between '$tanggalawal' and '$tanggalakhir' 
$where_keluar
$lokasi_kerja
group by tp.noind,tp.nama,tp.kd_pkj,tp.lokasi_kerja,tp.puasa,tp.tglkeluar
order by tp.noind";
$data = $this->personalia->query($query);


$sql = "update \"Presensi\".tsusulan set reffgaji = '$tanggalakhir', stat = true where left(noind,1)='R' and reffgaji is null and stat = false";
$this->personalia->query($sql);
return $data->result_array();
	}
	
	public function getUbahPekerjaan($noind,$kdpekerjaan,$awal,$akhir,$proses){
		$sql = "select * , (tanggal_mulai_berlaku - interval '1 day')::date tanggal_akhir_berlaku
				from hlcm.hlcm_datapekerja
				where noind = '$noind' 
				and kode_pekerjaan = '$kdpekerjaan' 
				and tanggal_mulai_berlaku between '$awal' and '$akhir'" ;
		$result = $this->erp->query($sql);
		if ($proses == 'cek') {
			return $result->num_rows();
		}else{
			return $result->result_array();
		}
		
	}

	public function getNominalPerubahan($tanggalawal,$tanggalakhir,$noind){
		$query = "select tp.noind,tp.nama,tp.lokasi_kerja, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tpk.kdpekerjaan=tp.kd_pkj) as pekerjaan, (select tpk.kdpekerjaan from hrd_khs.tpekerjaan tpk where tpk.kdpekerjaan=tp.kd_pkj) as kdpekerjaan, 
				round((
	case
		when
			substring(tp.noind,1,1)='R'
		then
			count(tsp.tanggal)			
			-
			(
				case
					when
						(extract(month from ('$tanggalakhir')::date)+1)=extract(month from ('$tanggalakhir')::date)
					then
						case
							when
								(30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))>=0
							then
								(30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))
							else
								0
						end
					else
						0
				end
			)
			-
			(
				case when tp.tglkeluar < '$tanggalakhir' and tp.tglkeluar != '1900-01-01' then 
					(select count(*) from \"Presensi\".tshiftpekerja tsp2 where tsp2.noind = tp.noind and tsp2.tanggal between tp.tglkeluar and '$tanggalakhir')
				else 
					0
				end
			)
			-
			(
			    select count(*)
			    from \"Presensi\".tdatapresensi tdpx
			    where tdpx.noind = tp.noind 
			    and tdpx.tanggal between '$tanggalawal' and '$tanggalakhir'
			    and tdpx.kd_ket = 'PRM'
			)
			-
			sum(
						coalesce((
							select 
								sum(case
									when
										tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0')
									then
										tsp.jam_kerja / tsp.jam_kerja
									when
										tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0')
									then
									case
									when
										(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time<=tsp.ist_mulai::time
									then
										case
											when
												tdt1.keluar::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then 
													case
													--1
														when
															tdt1.masuk::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from (tdt1.masuk::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from 
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tdt1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tdt1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then
													case
													--7
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--8
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then 
																extract(epoch from
																	tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-tsp.ist_selesai::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
											then
													case
													--12
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from
																	tdt1.masuk::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then 
																extract(epoch from
																	tsp.ist_mulai::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.masuk::time-tsp.ist_selesai::time)+
																	(tsp.ist_mulai::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then 
													case
													--16
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--17
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.masuk::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
										end
									else
										case
											when
												tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
											then 
													case
													--1
														when
															tdt1.masuk::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from (tdt1.masuk::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from (tsp.ist_mulai::time-tdt1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and (tsp.break_mulai::time - interval '1 second')
															then
																extract(epoch from 
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	(tdt1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tdt1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdt1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then
													case
													--7
														when
															tdt1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--8
														when 
															tdt1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	tdt1.keluar::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then
													case
													--12
														when
															tdt1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	tdt1.masuk::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)+
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdt1.keluar::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then 
													case
													--16
														when
															tdt1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--17
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdt1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdt1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdt1.masuk::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdt1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
										end
									end
								end )
							from \"Presensi\".tdatatim tdt1
							where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal
						),0)
				)
-
sum(
	coalesce(
				(	
				select
					sum(case
						when
							tdp1.kd_ket='PSK'
						then
							 1 
						else 0						
					end)
				from \"Presensi\".tdatapresensi tdp1
				where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
			),0)
		)
				-
				sum(
					coalesce((
							select
								sum(case
									when
										tdp1.kd_ket = rtrim('PSP')
									then
case when tp.lokasi_kerja='06'
then 0
else
									case
									when
										(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time<=tsp.ist_mulai::time
									then
										case
											when
												tdp1.keluar::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then 
												case
													--1
														when
															tdp1.masuk::time between tsp.jam_msk::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from (tdp1.masuk::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from 
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tdp1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tdp1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then
													case
													--7
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--8
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then 
																extract(epoch from
																	tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from
																	tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-tsp.ist_selesai::time) +
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	(tsp.ist_mulai::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
											then
													case
													--12
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from
																	tdp1.masuk::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then 
																extract(epoch from
																	tsp.ist_mulai::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.masuk::time-tsp.ist_selesai::time)+
																	(tsp.ist_mulai::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then 
													case
													--16
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--17
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.masuk::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
										end
									else
										case
											when
												tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
											then 
												case
													--1
														when
															tdp1.masuk::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')
															then
																extract(epoch from (tdp1.masuk::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--2
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																extract(epoch from (tsp.ist_mulai::time-tdp1.keluar::time))::numeric/(tsp.jam_kerja*60*60)
													--3
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from 
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	(tdp1.masuk::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--4
														when tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--5
														when tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then 
																extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tdp1.masuk::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--6
														else
															extract(epoch from
																	(tsp.ist_mulai::time-tdp1.keluar::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
											then
													case
													--7
														when
															tdp1.masuk::time between tsp.ist_mulai::time and (tsp.ist_selesai::time - interval '1 second')
															then
																0
													--8
														when 
															tdp1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	tdp1.keluar::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--9
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time
																)::numeric/(tsp.jam_kerja*60*60)
													--10
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time) +
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--11
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tsp.ist_selesai::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
											then
													case
													--12
														when
															tdp1.masuk::time between tsp.ist_selesai::time and ((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time - interval '1 second')
															then
																extract(epoch from
																	tdp1.masuk::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--13
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then 
																extract(epoch from
																	(
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time
																)::numeric/(tsp.jam_kerja*60*60)
													--14
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)+
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--15
														else
															extract(epoch from
																	((
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time-tdp1.keluar::time) +
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
											then 
													case
													--16
														when
															tdp1.masuk::time between (
	case
		when
			tsp.break_mulai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_mulai
	end
)::time and ((
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time - interval '1 second')
															then
																0
													--17
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.keluar::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--18
														else
															extract(epoch from
																	(tsp.jam_plg::time-(
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time)
																)::numeric/(tsp.jam_kerja*60*60)
													end
											when
												tdp1.keluar::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
											then
													case
													--19
														when 
															tdp1.masuk::time between (
	case
		when
			tsp.break_selesai='__:__:__'
		then
			tsp.ist_mulai
		else
			tsp.break_selesai
	end
)::time and (tsp.jam_plg::time - interval '1 second')
															then
																extract(epoch from
																	(tdp1.masuk::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
													--20
														else
															extract(epoch from
																	(tsp.jam_plg::time-tdp1.keluar::time)
																)::numeric/(tsp.jam_kerja*60*60)
											end		end
										end
									end
								end)
							from \"Presensi\".tdatapresensi tdp1
							where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
						),0)
				)
				
		else
			0
	end
)::decimal,2) 
as gpokok,
round((
 count(tsp.tanggal)
 -
 (
  case
   when
    (extract(month from ('$tanggalakhir')::date)+1)=extract(month from ('$tanggalakhir')::date)
   then
    case
     when
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))>=0
     then
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))
     else
      0
    end
   else
    0
  end
 )
 -
 (
	 case when tp.tglkeluar < '$tanggalakhir' and tp.tglkeluar != '1900-01-01' then 
		 (select count(*) from \"Presensi\".tshiftpekerja tsp2 where tsp2.noind = tp.noind and tsp2.tanggal between tp.tglkeluar and '$tanggalakhir')
	 else 
		 0
	 end
 )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0') or tdt1.point='1'
      then
       1
      when
       tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0')
      then
       case
        when
         tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')			
        then
         case
          when
           tdt1.masuk::time between tsp.jam_msk::time and tsp.ist_mulai::time	
          then
           0
          else
           1
         end
        when
         tdt1.keluar::time between tsp.ist_mulai::time and (tsp.jam_plg::time - interval '1 second')
        then
         case
          when
           tdt1.masuk::time > tsp.ist_mulai::time
          then
           0														
          else
           1														
         end
       end
     end)
    from \"Presensi\".tdatatim tdt1
    where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal
   ),0)
  )
+
sum(
 coalesce(
    ( 
    select
     sum(case
         when
          tdp1.kd_ket='Sudah Tidak Digunakan PLB'
         then
          case
           when
            extract(dow from tsp.tanggal::date)='7'         
           then
            case
             when
              tdp1.keluar::time >='12:15:00'::time
             then
              1
             else
              0
            end
           else
            case
             when
              tdp1.keluar::time >='11:45:00'::time 
             then
              1
             else
              0
            end
          end
         else
          0
        end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
   ),0)
  )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       (tdp1.kd_ket in ('PSK','PRM','PKK','PIP','PCZ')  or (tdp1.kd_ket!='CB' and tdp1.kd_ket like 'C%')) or (tdp1.kd_ket='PDL' and (tdp1.masuk='0' or tdp1.masuk='' ))
      then
       1
      when
       tdp1.kd_ket = rtrim('PSP')
      then
       case
        when
         tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')   
        then
         case
          when
           tdp1.masuk::time > tsp.ist_selesai::time
          then
           0              
          else
           1              
         end
       end
     end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
   ),0)
  )
  +
  sum((select count(*) 
  from \"Presensi\".tdatapresensi tdp2 
  where tdp2.tanggal between '$tanggalawal' and '$tanggalakhir' 
  and tdp2.noind = tsp.noind
  and tdp2.kd_ket='HL'))/count(tsp.tanggal
  )
)::decimal,2)
as um,
round((
 (
 	select count(tsp.tanggal)
 	from \"Presensi\".tshiftpekerja tsp1 
 	where tsp1.tanggal between '$tanggalawal' and '$tanggalakhir' 
  	and tsp1.tanggal between '$puasaAwal' and '$puasaAkhir'
 	and tsp1.noind = tsp.noind
 )
 -
 (
  case
   when
    (extract(month from ('$tanggalakhir')::date)+1)=extract(month from ('$tanggalakhir')::date)
   then
    case
     when
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))>=0
     then
      (30-(('$tanggalakhir'::date - '$tanggalawal'::date)+1))
     else
      0
    end
   else
    0
  end
 )
 -
 (
	 case when tp.tglkeluar < '$tanggalakhir' and tp.tglkeluar != '1900-01-01' then 
		 (select count(*) from \"Presensi\".tshiftpekerja tsp2 where tsp2.noind = tp.noind and tsp2.tanggal between tp.tglkeluar and '$tanggalakhir' and tsp2.tanggal between '$puasaAwal' and '$puasaAkhir')
	 else 
		 0
	 end
 )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0') or tdt1.point='1'
      then
       1
      when
       tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0')
      then
       case
        when
         tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')			
        then
         case
          when
           tdt1.masuk::time between tsp.jam_msk::time and tsp.ist_mulai::time	
          then
           0
          else
           1
         end
        when
         tdt1.keluar::time between tsp.ist_mulai::time and (tsp.jam_plg::time - interval '1 second')
        then
         case
          when
           tdt1.masuk::time > tsp.ist_mulai::time
          then
           0														
          else
           1														
         end
       end
     end)
    from \"Presensi\".tdatatim tdt1
    where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal 
  	and tdt1.tanggal between '$puasaAwal' and '$puasaAkhir'
   ),0)
  )
+
sum(
 coalesce(
    ( 
    select
     sum(case
         when
          tdp1.kd_ket='Sudah Tidak Digunakan PLB'
         then
          case
           when
            extract(dow from tsp.tanggal::date)='7'         
           then
            case
             when
              tdp1.keluar::time >='12:15:00'::time
             then
              1
             else
              0
            end
           else
            case
             when
              tdp1.keluar::time >='11:45:00'::time 
             then
              1
             else
              0
            end
          end
         else
          0
        end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal 
  	and tdp1.tanggal between '$puasaAwal' and '$puasaAkhir'
   ),0)
  )
 -
 sum(
 coalesce(
    ( 
    select
     sum(case
      when
       (tdp1.kd_ket in ('PSK','PRM','PKK','PIP','PCZ')  or (tdp1.kd_ket!='CB' and tdp1.kd_ket like 'C%')) or (tdp1.kd_ket='PDL' and (tdp1.masuk='0' or tdp1.masuk='' ))
      then
       1
      when
       tdp1.kd_ket = rtrim('PSP')
      then
       case
        when
         tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second')   
        then
         case
          when
           tdp1.masuk::time > tsp.ist_selesai::time
          then
           0              
          else
           1              
         end
       end
     end)
    from \"Presensi\".tdatapresensi tdp1
    where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal 
  	and tdp1.tanggal between '$puasaAwal' and '$puasaAkhir'
   ),0)
  )
  +
  sum((select count(*) 
  from \"Presensi\".tdatapresensi tdp2 
  where tdp2.tanggal between '$tanggalawal' and '$tanggalakhir' 
  and tdp2.tanggal between '$puasaAwal' and '$puasaAkhir'
  and tdp2.noind = tsp.noind
  and tdp2.kd_ket='HL'))/count(tsp.tanggal
  )
)::decimal,2)
as ump,
round(
coalesce(
	(
		select sum(tdp1.total_lembur) 
		from \"Presensi\".tdatapresensi tdp1 
		where tdp1.noind=tp.noind 
		and tanggal between '$tanggalawal' and '$tanggalakhir'
		and tanggal not in	(
								select tssl.tanggal 
								from \"Presensi\".tsusulan tssl
								where tssl.noind = tp.noind
								and ket = 'LEMBUR'
							)
	)
,0)::decimal
+
coalesce(
	(
		select sum(tdp1.total_lembur) 
		from \"Presensi\".tdatapresensi tdp1 
		where tdp1.noind=tp.noind 
		and tanggal in	(	
							select tssl.tanggal 
							from \"Presensi\".tsusulan tssl
							where tssl.noind = tp.noind
							and (reffgaji is null or reffgaji = '$tanggalakhir')
							and ket = 'LEMBUR'
						)
	)
,0)::decimal
,2)
as lembur,
tp.puasa
from hrd_khs.tpribadi tp
left join \"Presensi\".tshiftpekerja tsp on tsp.noind=tp.noind
where tsp.tanggal between '$tanggalawal' and '$tanggalakhir'
and tp.noind = '$noind'
group by tp.noind,tp.nama,tp.kd_pkj,tp.lokasi_kerja,tp.puasa,tp.tglkeluar";

$data = $this->personalia->query($query);

return $data->result_array();
	}
};
 ?>