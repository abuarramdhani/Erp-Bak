<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_ovpekerja extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE);
        $this->erp          =   $this->load->database('erp_db', TRUE);
        // $this->oracle          =   $this->load->database('oracle', TRUE);
    }

    public function getPekerjanSeksi($noind)
    {
    	$sql = "SELECT
					*
				from
					hrd_khs.tpribadi tp
				left join hrd_khs.tseksi ts on
					ts.kodesie = tp.kodesie
				where noind = '$noind'";
		return $this->personalia->query($sql)->row_array();
    }
}