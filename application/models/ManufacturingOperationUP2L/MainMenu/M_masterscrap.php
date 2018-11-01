<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterscrap extends CI_Model
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
    	$sql="select mss.id,
                     mss.description,
                     mss.scrap_code
    			from mo.mo_master_scrap mss
                order by 3";
    	$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function updateMasterScrap($desc,$code,$user_id,$id)
    {
        $sql = "
            update mo.mo_master_scrap
            SET description ='$desc', scrap_code= '$code', user_id=$user_id, creation_date=current_date
            WHERE id =$id";
        $query = $this->db->query($sql);
    }

    public function insertMasScrap($desc,$code,$creation_date,$user_id)
    {
        $sql = "
            insert into mo.mo_master_scrap 
           (description, scrap_code, user_id, creation_date) 
           values ('$desc', '$code', '$user_id', current_date)
          ";
        $query = $this->db->query($sql);
    }


}

/* End of file M_mixing.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_mixing.php */
/* Generated automatically on 2017-12-20 14:47:57 */