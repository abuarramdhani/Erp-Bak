<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterpersonal extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function insert($dataIns,$tbName)
    {
       $this->db->insert($tbName, $dataIns);
    }

    public function monitor()
    {
    	$sql="select msp.id,
                    msp.nama,
                    msp.no_induk
    			from mo.mo_master_personal msp
                order by 2";
    	$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function updateMasterPerson($nama,$noInduk,$user_id,$id)
    {
        $sql = "
            update mo.mo_master_personal
            SET nama ='$nama', no_induk= '$noInduk', created_by=$user_id, creation_date=current_date
            WHERE id =$id";
        $query = $this->db->query($sql);
    }

    public function insertMasPer($nama,$noInduk,$userid)
    {
        $sql = "
            insert into mo.mo_master_personal 
           (nama, no_induk, created_by) 
           values ('$nama', '$noInduk', '$userid')
          ";
        $query = $this->db->query($sql);
    }


}

/* End of file M_mixing.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_mixing.php */
/* Generated automatically on 2017-12-20 14:47:57 */