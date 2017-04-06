<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_reportrincianhutang extends CI_Model
{

    public $hubker = 'pr.pr_master_status_kerja';
    public $id = 'id_insentif_kemahalan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function hubker()
    {
    	return $this->db->get($this->hubker)->result();
    }
	
}
/* End of file M_riwayatinsentifkemahalan.php */
/* Location: ./application/models/PayrollManagement/MasterInsKemahalan/M_riwayatinsentifkemahalan.php */
/* Generated automatically on 2016-11-26 10:46:12 */