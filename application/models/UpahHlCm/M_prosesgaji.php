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
						concat(tanggal_awal::date,' - ',tanggal_akhir::date) rangetanggal,
						tanggal_awal::date,
						tanggal_akhir::date
				from \"Presensi\".tcutoff where left(periode,4) = to_char(current_timestamp,'YYYY') 
				order by periode";
		$data = $this->personalia->query($sql);
		return $data->result_array();
	}

	public function getHlcmProses($periode,$noind){
		$sql = "select * from hlcm.hlcm_proses where noind = '$noind' and periode = '$periode'";
		$result = $this->erp->query($sql);
		return $result->num_rows();
	}

	public function insertHlcmProses($data){
		$this->erp->insert('hlcm.hlcm_proses',$data);
	}

	public function updateHlcmproses($data){
		$this->erp->where('noind',$data['noind']);
		$this->erp->where('periode',$data['periode']);
		$this->erp->update('hlcm.hlcm_proses',$data);
	}

	public function getHlcmProsesPrint($tglBln,$lokasi = FALSE){
		$lokasi_kerja = '';
		if (isset($lokasi) and !empty($lokasi)) {
			$lokasi_kerja = " and prs.lokasi_kerja = '$lokasi' ";
		}
		$sql = "select prs.* ,
					(	select pekerjaan 
						from hlcm.hlcm_datagaji 
						where prs.kode_pekerjaan = kode_pekerjaan 
						and prs.lokasi_kerja = lokasi_kerja) pekerjaan,
					employee_name nama
				from hlcm.hlcm_proses prs
				inner join er.er_employee_all eall
					on prs.noind = eall.employee_code
				where prs.periode = '$tglBln'
				$lokasi_kerja
				order by prs.kode_pekerjaan";
		$result = $this->erp->query($sql);
		return $result->result_array();
	}
	
	public function prosesHitung($tanggalawal,$tanggalakhir,$lokasi_kerja)
	{
		$query="select tp.noind,tp.nama,tp.lokasi_kerja, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tpk.kdpekerjaan=tp.kd_pkj) as pekerjaan, (select tpk.kdpekerjaan from hrd_khs.tpekerjaan tpk where tpk.kdpekerjaan=tp.kd_pkj) as kdpekerjaan, 
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
    (extract(month from ('2018-12-19')::date)+1)=extract(month from ('2018-12-19')::date)
   then
    case
     when
      (30-(('2018-12-19'::date - '2018-11-21'::date)+1))>=0
     then
      (30-(('2018-12-19'::date - '2018-11-21'::date)+1))
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
  where tdp2.tanggal between '2018-11-21' and '2018-12-19' 
  and tdp2.noind = tsp.noind
  and tdp2.kd_ket='HL'))/count(tsp.tanggal
  )
)::decimal,2)
as um,
round(coalesce(
	(
		select sum(tdp1.total_lembur) from \"Presensi\".tdatapresensi tdp1 where tdp1.noind=tp.noind and tanggal between '$tanggalawal' and '$tanggalakhir'
),0)::decimal,2)
as lembur
from hrd_khs.tpribadi tp
left join \"Presensi\".tshiftpekerja tsp on tsp.noind=tp.noind
where left(tp.noind,1)='R' and tsp.tanggal between '$tanggalawal' and '$tanggalakhir' and tp.keluar='0'
$lokasi_kerja
group by tp.noind,tp.nama,tp.kd_pkj,tp.lokasi_kerja
order by tp.noind";
$data = $this->personalia->query($query);
return $data->result_array();
	}
	
};
