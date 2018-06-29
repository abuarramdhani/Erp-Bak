<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSeksi($seksi){
    	$query = $this->db->query("select      seksi.section_code as kode_seksi,
                                            concat_ws(' - ', seksi.unit_name, seksi.section_name) as nama_seksi
                                from        er.er_section as seksi
                                where       seksi.job_name='-'
                                            and     seksi.section_name!='-'
                                            and     right(seksi.section_code,2)='00'
                                            and 	seksi.section_name like upper('%$seksi%')
                                order by    nama_seksi");
    	return $query->result_array();
    }
}