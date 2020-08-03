<?php

class M_recycle extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	/**
	 * @param (Date, Date)
	 * @example ('2020-01-01', '2020-02-01')
	 * @return Array
	 */
	public function getDeletedMail($surat = null, $period)
	{
		// $babsp3 =
		// 	$resign =
		// 	$demosi =
		// 	$isolasi =
		// 	$mutasi =
		// 	$pengangkatan =
		// 	$perbantuan =
		// 	$promosi =
		// 	$rotasi =
		// 	$tugas =
		// 	$usiaLanjut =
		// 	$cutoff = [];

		// $this->personalia->where('deleted_date is not null');
		// $this->personalia->order_by('deleted_date', 'desc');
		// $this->db->where('deleted_date is not null');
		// $this->db->order_by('deleted_date', 'desc');


		// $resign = $this->personalia->get('hrd_khs.t_pengajuan_resign_pekerja')->result_array();
		// $demosi = $this->personalia->get('"Surat".tsurat_demosi')->result_array();
		// $mutasi = $this->personalia->get('"Surat".tsurat_mutasi')->result_array();
		// $pengangkatan = $this->personalia->get('"Surat".tsurat_pengangkatan')->result_array();
		// $perbantuan = $this->personalia->get('"Surat".tsurat_perbantuan')->result_array();
		// $promosi = $this->personalia->get('"Surat".tsurat_promosi')->result_array();
		// $rotasi = $this->personalia->get('"Surat".tsurat_rotasi')->result_array();
		// $tugas = $this->personalia->get('"Surat".tsurat_tugas')->result_array();
		// $usiaLanjut = $this->personalia->get('"Surat".tsurat_usialanjut')->result_array();
		// $cutoff = $this->personalia->get('"Surat".t_memo_cutoff')->result_array();

		switch ($surat) {
			case 'bapsp3':
				return $sql_babsp3 = $this->getBabSp3();
			case 'demosi':
				return $sql_demosi = $this->getDemosi();
			case 'isolasi':
				return $sql_isolasi = $this->getIsolasi();
			case 'mutasi':
				return $sql_mutasi = $this->getMutasi();
			case 'cutoff':
				return $sql_cutoff =  $this->getCutoff();
			case 'resign':
				return $sql_resign = $this->getResign();
			case 'pengangkatan':
				return $sql_pengangkatan = $this->getPengangkatan();
			case 'perbantuan':
				return $sql_perbantuan = $this->getPerbantuan();
			case 'usiaLanjut':
				return $sql_usiaLanjut = $this->getUsiaLanjut();
			case 'promosi':
				return $sql_promosi = $this->getPromosi();
			case 'rotasi':
				return $sql_rotasi = $this->getRotasi();
			case 'tugas':
				return $sql_tugas = $this->getTugas();
			case 'workexp':
				return [];
			default;
				return [];
		}
	}

	private function getCutoff()
	{
		$sql = "SELECT * FROM \"Surat\".t_memo_cutoff where deleted_date is not null ORDER BY update_date DESC";
		return $this->personalia->query($sql)->result_array();
	}

	private function getUsiaLanjut()
	{
		$ambilDaftarSuratUsiaLanjut = "
      SELECT *,
        (select seksi from hrd_khs.tseksi b where b.kodesie = a.kodesie  ) seksi 
      FROM \"Surat\".tsurat_usialanjut a 
      WHERE deleted_date is not null";

		$query   = $this->personalia->query($ambilDaftarSuratUsiaLanjut);
		return $query->result_array();
	}

	private function getTugas()
	{
		$sql = "select 
          ts.no_surat,
          concat(ts.noind,' - ',trim(tp.nama)) as pekerja,
          ts.tgl_dibuat,
          ts.tgl_dicetak,
          ts.surat_tugas_id,
          ts.deleted_by,
          ts.deleted_date
      from \"Surat\".tsurat_tugas ts
      left join hrd_khs.tpribadi tp 
      on ts.noind = tp.noind
      where deleted_date is not null
      order by ts.tgl_dibuat desc ";
		return $this->personalia->query($sql)->result_array();
	}

	private function getRotasi()
	{
		$ambilDaftarSuratRotasi     = "	select 		concat
															(
																rotasi.no_surat, 
																'/'||rotasi.kode||'/', 
																to_char(rotasi.tanggal_cetak, 'MM'), 
																'/', 
																to_char(rotasi.tanggal_cetak, 'YY')
															) as no_surat,
															rotasi.tanggal_berlaku::date as tanggal_berlaku,
															rotasi.noind,
															rotasi.nama,
															concat_ws
															(
																' - ',
																rotasi.kodesie_lama,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																rotasi.kodesie_baru,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																rotasi.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=rotasi.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																rotasi.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=rotasi.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															rotasi.tanggal_cetak::date,
															rotasi.cetak,
															rotasi.deleted_by,
															rotasi.deleted_date
												from 		\"Surat\".tsurat_rotasi as rotasi
												where deleted_date is not null";
		$query           =  $this->personalia->query($ambilDaftarSuratRotasi);
		return $query->result_array();
	}

	public function getPromosi()
	{
		$ambilDaftarSuratPromosi     = "	select 		concat
															(
																promosi.no_surat, 
																'/'||promosi.kode||'/', 
																to_char(promosi.tanggal_cetak, 'MM'), 
																'/', 
																to_char(promosi.tanggal_cetak, 'YY')
															) as no_surat,
															promosi.tanggal_berlaku::date as tanggal_berlaku,
															promosi.noind,
															promosi.nama,
															concat_ws
															(
																' - ',
																promosi.kodesie_lama,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=promosi.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=promosi.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																promosi.kodesie_baru,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=promosi.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=promosi.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																promosi.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=promosi.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																promosi.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=promosi.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															promosi.tanggal_cetak::date,
															promosi.cetak,
															promosi.deleted_by,
															promosi.deleted_date
												from 		\"Surat\".tsurat_promosi as promosi
												where deleted_date is not null";
		$query           =  $this->personalia->query($ambilDaftarSuratPromosi);
		return $query->result_array();
	}

	private function getPerbantuan()
	{
		$ambilDaftarSuratPerbantuan     = "	select 		concat
															(
																perbantuan.no_surat, 
																'/'||perbantuan.kode||'/', 
																to_char(perbantuan.tanggal_cetak, 'MM'), 
																'/', 
																to_char(perbantuan.tanggal_cetak, 'YY')
															) as no_surat,
															perbantuan.tanggal_mulai_perbantuan::date as tanggal_mulai_perbantuan,
															perbantuan.tanggal_selesai_perbantuan::date as tanggal_selesai_perbantuan,
															perbantuan.noind,
															perbantuan.nama,
															concat_ws
															(
																' - ',
																perbantuan.kodesie_lama,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=perbantuan.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=perbantuan.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																perbantuan.kodesie_baru,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=perbantuan.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=perbantuan.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																perbantuan.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=perbantuan.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																perbantuan.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=perbantuan.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															perbantuan.tanggal_cetak::date,
															perbantuan.cetak,
															perbantuan.deleted_by,
															perbantuan.deleted_date
												from 		\"Surat\".tsurat_perbantuan as perbantuan
												where deleted_date is not null
												";
		$query           =  $this->personalia->query($ambilDaftarSuratPerbantuan);
		return $query->result_array();
	}

	private function getResign()
	{
		$sql = "select a.*,b.nama 
    from hrd_khs.t_pengajuan_resign_pekerja a 
    inner join hrd_khs.tpribadi b 
    on a.noind = b.noind
    where deleted_date is not null";

		return $this->personalia->query($sql)->result_array();
	}

	private function getIsolasi()
	{
		$sql = "select 
            ts.no_surat,
            concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
            ts.tgl_wawancara,
            ts.tgl_cetak,
						ts.id_isolasi_mandiri,
						ts.deleted_by,
						ts.deleted_date
        from \"Surat\".tsurat_isolasi_mandiri ts
        left join hrd_khs.tpribadi tp 
        on ts.pekerja = tp.noind
        where deleted_date is not null
        order by ts.created_timestamp desc";
		return $this->personalia->query($sql)->result_array();
	}

	private function getBabSp3()
	{
		$sql = "select
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
    where deleted_date is not null";
		return $this->db->query($sql)->result_array();
	}

	private function getDemosi()
	{
		$sql = "	select 		concat
    (
      demosi.no_surat, 
      '/'||demosi.kode||'/', 
      to_char(demosi.tanggal_cetak, 'MM'), 
      '/', 
      to_char(demosi.tanggal_cetak, 'YY')
    ) as no_surat,
    demosi.tanggal_berlaku::date as tanggal_berlaku,
    demosi.noind,
    demosi.nama,
    concat_ws
    (
      ' - ',
      demosi.kodesie_lama,
      (			
        select 		case 	when 	rtrim(seksi)!='-'
                      then 	'Seksi ' || rtrim(seksi)
                  else	(
                        case 	when 	rtrim(unit)!='-'
                                then 	'Unit ' || rtrim(unit)
                            else 	(
                                  case 	when 	rtrim(bidang)!='-'
                                          then 	'Bidang ' || rtrim(bidang)
                                      else 	'Departemen ' || rtrim(dept)
                                  end
                                )
                        end
                      )
              end
        from	 	hrd_khs.tseksi as tseksi
        where 		tseksi.kodesie=demosi.kodesie_lama
      ),
      (
        select		case 	when 	rtrim(pekerjaan)!='-'
                      then 	rtrim(pekerjaan)
              end
        from 		hrd_khs.tseksi as tseksi
        where 		tseksi.kodesie=demosi.kodesie_lama
      )
    ) as seksi_lama,
    concat_ws
    (
      ' - ',
      demosi.kodesie_baru,
      (			
        select 		case 	when 	rtrim(seksi)!='-'
                      then 	'Seksi ' || rtrim(seksi)
                  else	(
                        case 	when 	rtrim(unit)!='-'
                                then 	'Unit ' || rtrim(unit)
                            else 	(
                                  case 	when 	rtrim(bidang)!='-'
                                          then 	'Bidang ' || rtrim(bidang)
                                      else 	'Departemen ' || rtrim(dept)
                                  end
                                )
                        end
                      )
              end
        from	 	hrd_khs.tseksi as tseksi
        where 		tseksi.kodesie=demosi.kodesie_baru
      ),
      (
        select		case 	when 	rtrim(pekerjaan)!='-'
                      then 	rtrim(pekerjaan)
              end
        from 		hrd_khs.tseksi as tseksi
        where 		tseksi.kodesie=demosi.kodesie_baru
      )
    ) as seksi_baru,
    concat_ws
    (
      ' - ',
      demosi.lokasi_kerja_lama,
      (
        select 		lokker.lokasi_kerja
        from 		hrd_khs.tlokasi_kerja as lokker
        where 		lokker.id_=demosi.lokasi_kerja_lama
      )
    ) as lokasi_kerja_lama,
    concat_ws
    (
      ' - ',
      demosi.lokasi_kerja_baru,
      (
        select 		lokker.lokasi_kerja
        from 		hrd_khs.tlokasi_kerja as lokker
        where 		lokker.id_=demosi.lokasi_kerja_baru
      )
    ) as lokasi_kerja_baru,
    demosi.tanggal_cetak::date,
		demosi.cetak,
		demosi.deleted_by,
		demosi.deleted_date
    from 		\"Surat\".tsurat_demosi as demosi
    where deleted_date is not null";

		return $this->personalia->query($sql)->result_array();
	}

	private function getMutasi()
	{
		$this->personalia->select('	tsurat_mutasi.*,
	    		 						tpribadi.nama,
	    		 						tsurat_mutasi.lokasi_kerja_lama kode_lokasi_kerja_lama,
	    		 						tsurat_mutasi.lokasi_kerja_baru kode_lokasi_kerja_baru,
	    		 						lokasi_lama.lokasi_kerja lokasi_kerja_lama,
	    		 						lokasi_baru.lokasi_kerja lokasi_kerja_baru,
	    								tseksi_lama.dept dept_lama,
	    								tseksi_lama.bidang bidang_lama,
	    								tseksi_lama.unit unit_lama,
	    								tseksi_lama.seksi seksi_lama,
	    								tseksi_lama.pekerjaan pekerjaan_lama,
	    								tseksi_baru.dept dept_baru,
	    								tseksi_baru.bidang bidang_baru,
	    								tseksi_baru.unit unit_baru,
	    								tseksi_baru.seksi seksi_baru,
	    								tseksi_baru.pekerjaan pekerjaan_baru');
		$this->personalia->from('"Surat".tsurat_mutasi');
		$this->personalia->join('hrd_khs.v_hrd_khs_tseksi tseksi_lama', 'tseksi_lama.kodesie = tsurat_mutasi.kodesie_lama');
		$this->personalia->join('hrd_khs.v_hrd_khs_tseksi tseksi_baru', 'tseksi_baru.kodesie = tsurat_mutasi.kodesie_baru');
		$this->personalia->join('hrd_khs.v_hrd_khs_tpribadi tpribadi', 'tpribadi.noind=tsurat_mutasi.noind');
		$this->personalia->join('hrd_khs.tlokasi_kerja lokasi_lama', 'lokasi_lama.id_ = tsurat_mutasi.lokasi_kerja_lama');
		$this->personalia->join('hrd_khs.tlokasi_kerja lokasi_baru', 'lokasi_baru.id_ = tsurat_mutasi.lokasi_kerja_baru');

		$this->personalia->where('deleted_date is not null');

		$this->personalia->order_by('tanggal_cetak', 'desc');
		return $this->personalia->get()->result_array();
	}

	private function getPengangkatan()
	{
		$ambilDaftarSuratPengangkatan     = "	select 		concat
															(
																pengangkatan.no_surat, 
																'/'||pengangkatan.kode||'/', 
																to_char(pengangkatan.tanggal_cetak, 'MM'), 
																'/', 
																to_char(pengangkatan.tanggal_cetak, 'YY')
															) as no_surat,
															pengangkatan.tanggal_berlaku::date as tanggal_berlaku,
															pengangkatan.noind,
															pengangkatan.nama,
															concat_ws
															(
																' - ',
																pengangkatan.kodesie_lama,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=pengangkatan.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=pengangkatan.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																pengangkatan.kodesie_baru,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=pengangkatan.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=pengangkatan.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																pengangkatan.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=pengangkatan.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																pengangkatan.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=pengangkatan.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															pengangkatan.tanggal_cetak::date,
															pengangkatan.cetak,
															pengangkatan.deleted_by,
															pengangkatan.deleted_date
												from 		\"Surat\".tsurat_pengangkatan as pengangkatan
												where deleted_date is not null";
		$query           =  $this->personalia->query($ambilDaftarSuratPengangkatan);
		return $query->result_array();
	}

	/**
	 * @return void
	 * @table: Surat.tpindah_finger
	 * @info: Mengubah status finger_pindah menjadi false(f)
	 */
	public function restorePindahFinger($no_surat)
	{
		$sql = "UPDATE \"Surat\".tpindah_finger
							SET finger_pindah = 'f'
							WHERE concat
													(
														no_surat, 
														'/'||kode||'/',
														to_char(created_date, 'MM'), 
														'/', 
														to_char(created_date, 'YY')
													)
													=
													'$no_surat'";
		$query =  $this->personalia->query($sql);
	}

	public function restoreBapSp3($id)
	{
		$this->db
			->where('bap_id', $id)
			->set('deleted_by', null)
			->set('deleted_date', null)
			->update('hr.hr_bap');
	}

	public function restoreDemosi($no_surat_decode)
	{
		$sql = "UPDATE \"Surat\".tsurat_demosi
						SET deleted_by = null, deleted_date = null
						WHERE concat
									(
										no_surat, 
										'/'||kode||'/',
										to_char(tanggal_cetak, 'MM'), 
										'/', 
										to_char(tanggal_cetak, 'YY')
									)
									=
									'$no_surat_decode'";
		$query 	=	$this->personalia->query($sql);
	}

	public function restoreIsolasi($id)
	{
		$this->personalia->where('id_isolasi_mandiri', $id);
		$this->personalia->set('deleted_by', null);
		$this->personalia->set('deleted_date', null);
		$this->personalia->update("\"Surat\".tsurat_isolasi_mandiri");
	}

	public function restoreMutasi($tanggal, $kode, $no_surat_decode)
	{
		$no_surat = $no_surat_decode;
		$waktu = date("Y/m/d", $tanggal);

		$this->personalia->where('no_surat=', $no_surat);
		$this->personalia->where('tanggal_cetak', $waktu);
		$this->personalia->where('kode=', $kode);
		$this->personalia->set('deleted_by', null);
		$this->personalia->set('deleted_date', null);
		$this->personalia->update('"Surat".tsurat_mutasi');
	}

	public function restoreCutoff($id)
	{
		$sql = "UPDATE \"Surat\".t_memo_cutoff set deleted_by = null , deleted_date = null WHERE id='$id'";
		$this->personalia->query($sql);
	}

	public function restoreResign($id)
	{
		$this->personalia->where('pengajuan_id', $id);
		$this->personalia->set('deleted_by', null);
		$this->personalia->set('deleted_date', null);
		$this->personalia->update("hrd_khs.t_pengajuan_resign_pekerja");
	}

	public function restorePengangkatan($id)
	{
		$this->restorePindahFinger($id);
		$sql = "UPDATE \"Surat\".tsurat_pengangkatan
		SET deleted_by = null, deleted_date = null
		WHERE concat
								(
									no_surat, 
									'/'||kode||'/',
									to_char(tanggal_cetak, 'MM'), 
									'/', 
									to_char(tanggal_cetak, 'YY')
								)
								= '$id'";
		$query 	=	$this->personalia->query($sql);
	}

	public function restorePerbantuan($id)
	{
		$this->restorePindahFinger($id);

		$queryUpdateDelete = "UPDATE \"Surat\".tsurat_perbantuan 
		SET deleted_by = null, deleted_date = null
		WHERE 
		concat (no_surat, '/'||kode||'/', to_char(tanggal_cetak, 'MM'), '/', to_char(tanggal_cetak, 'YY')) = '$id'";

		$query =	$this->personalia->query($queryUpdateDelete);
	}

	public function restoreUsiaLanjut($noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->set('deleted_by', null);
		$this->personalia->set('deleted_date', null);
		$this->personalia->update('"Surat".tsurat_usialanjut');
	}

	public function restorePromosi($no_surat_decode)
	{
		$sql = "UPDATE \"Surat\".tsurat_promosi 
						SET deleted_by = null, deleted_date = null
						WHERE 		concat
													(
														no_surat, 
														'/'||kode||'/',
														to_char(tanggal_cetak, 'MM'), 
														'/', 
														to_char(tanggal_cetak, 'YY')
													)
													=
													'$no_surat_decode'";
		$query 	=	$this->personalia->query($sql);
	}

	public function restoreRotasi($no_surat_decode)
	{
		$this->restorePindahFinger($no_surat_decode);
		$sql = "UPDATE \"Surat\".tsurat_rotasi
						SET deleted_by = null, deleted_date = null
						WHERE concat
								(
									no_surat, 
									'/'||kode||'/',
									to_char(tanggal_cetak, 'MM'), 
									'/', 
									to_char(tanggal_cetak, 'YY')
								)
								=
								'$no_surat_decode'";
		$query = $this->personalia->query($sql);
	}

	public function restoreTugas($id)
	{
		$this->personalia->where('surat_tugas_id', $id);
		$this->personalia->set('deleted_by', null);
		$this->personalia->set('deleted_date', null);
		$this->personalia->update("\"Surat\".tsurat_tugas");
	}

	public function restoreWorkExp($id)
	{
	}
}
