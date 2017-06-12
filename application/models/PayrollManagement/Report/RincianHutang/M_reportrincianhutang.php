<?php
	class M_reportrincianhutang extends CI_Model {

		public function __construct()
        {
            $this->load->database();
			$this->load->library('encrypt');
        }

        public function getEmployeeData($noind) 
        {
        	$this->load->helper('url');
        	$this->db->select('pr.pr_master_pekerja.noind, pr.pr_master_pekerja.nama, pr.pr_master_pekerja.kd_status_kerja, pr.pr_master_pekerja.jabatan,  pr.pr_master_seksi.seksi');
        	$this->db->from('pr.pr_master_pekerja');
            $this->db->join('pr.pr_master_seksi', 'pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie');
        	$this->db->where('pr.pr_master_pekerja.noind', $noind);

        	$query = $this->db->get();
        	return $query->result_array();
        }

        public function getLoanData($no_hutang)
        {
        	$this->load->helper('url');
        	$this->db->select('*');
        	$this->db->from('pr.pr_hutang_karyawan');
        	$this->db->where('no_hutang', $no_hutang);

        	$query = $this->db->get();
        	return $query->result_array();
        }

        public function getLoanPayment($no_hutang)
        {
        	$this->load->helper('url');
        	$this->db->select('*');
        	$this->db->from('pr.pr_transaksi_hutang');
        	$this->db->where('no_hutang', $no_hutang);
        	$this->db->order_by('tgl_transaksi', 'asc');

        	$query = $this->db->get();
        	return $query->result_array();
        }
	}
?>