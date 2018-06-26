<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_email extends CI_Model
 	{
 		public function __construct()
	    {
	        parent::__construct();
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	    }

	    public function pemberitahuan_email($hari_ini)
	    {
			$this->db->select('
								proses_pemberitahuan.id_proses_pemberitahuan,
								proses_pemberitahuan.id_proses,
								proses_pemberitahuan.tanggal,
								proses.tahapan,
								proses.tgl_awal,
								proses.tgl_akhir,
								pekerja.noind,
								pekerja.atasan,
								pekerja.email_pekerja,
								pekerja.email_atasan,
								pekerja_psn.employee_name nama_pekerja_ojt,
								pekerja_psn_2.employee_name nama_atasan_pekerja,
								seksi_psn.section_name seksi_pekerja_ojt,
								format.format,
								format.id_tujuan,
								format.nama_tujuan
								');
			$this->db->from('ojt.tb_proses_pemberitahuan proses_pemberitahuan');
			$this->db->join('ojt.tb_proses proses', 'proses.id_proses = proses_pemberitahuan.id_proses');
			$this->db->join('ojt.tb_pekerja pekerja', 'pekerja.noind = proses.noind');
			$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja.noind');
			$this->db->join('er.er_employee_all pekerja_psn_2', 'pekerja_psn_2.employee_code = pekerja.atasan');
			$this->db->join('er.er_section seksi_psn', 'seksi_psn.section_code = pekerja_psn.section_code');
			$this->db->join('er.er_section seksi_psn_2', 'seksi_psn_2.section_code = pekerja_psn_2.section_code');
			$this->db->join('ojt.tb_pemberitahuan_email_format format', 'format.id_tujuan = proses_pemberitahuan.tujuan');
			$this->db->where('proses_pemberitahuan.tanggal =', $hari_ini);

			return $this->db->get()->result_array();
	    }

	    public function jabatan_atasan_pekerja($noind_atasan)
	    {
	    	$this->personalia->select('jabatan');
	    	$this->personalia->from('hrd_khs.trefjabatan');
	    	$this->personalia->where('noind =', $noind_atasan);

	    	return $this->personalia->get()->result_array();
	    }
	}