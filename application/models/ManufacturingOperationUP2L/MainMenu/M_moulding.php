<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_moulding extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function monitoringMoulding()
    {
       $sql="select mm.moulding_id,
                    mm.component_code,
                    mm.component_description,
                    mm.production_date,
                    mm.moulding_quantity,
                    mm.keterangan,
                    mm.print_code,
                    count(me.name) jumlah_pekerja,
                    (select sum(ms.quantity) from mo.mo_moulding_scrap ms where ms.moulding_id = mm.moulding_id) scrap_qty
            from mo.mo_moulding mm,
                 mo.mo_moulding_employee me
            where mm.moulding_id = me.moulding_id
            group by 
                    mm.moulding_id,
                    mm.moulding_quantity,
                    mm.component_code,
                    mm.component_description,
                    mm.production_date,
                    mm.keterangan
            order by 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMoulding($id = FALSE)
    {
    	if ($id === FALSE) {
            $sql="select mm.moulding_id,
                    mm.component_code,
                    mm.component_description,
                    mm.production_date,
                    mm.moulding_quantity,
                    mm.keterangan,
                    me.name,
                    me.no_induk 
            from mo.mo_moulding mm,
                 mo.mo_moulding_employee me
            where mm.moulding_id = me.moulding_id";
    		$query = $this->db->query($sql);
    	} else {
    		$sql="select mm.moulding_id,
                    mm.component_code,
                    mm.component_description,
                    mm.production_date,
                    mm.moulding_quantity,
                    mm.keterangan,
                    me.name,
                    me.no_induk 
            from mo.mo_moulding mm,
                 mo.mo_moulding_employee me
            where mm.moulding_id = me.moulding_id
                  and mm.moulding_id = '$id'";
            $query = $this->db->query($sql);
    	}

    	return $query->result_array();
    }

    public function getScrap($id)
    {
        $sql = "select type_scrap,
                    kode_scrap,
                    moulding_id,
                    quantity,
                    (select sum(quantity) from mo.mo_moulding_scrap where moulding_id=$id) jumlah
                from mo.mo_moulding_scrap
              where moulding_id = $id";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getBongkar($id)
    {
        $sql = "select 
                    moulding_id,
                    qty,
                    (select sum(qty) from mo.mo_moulding_bongkar where moulding_id=$id) jumlah
                from mo.mo_moulding_bongkar
              where moulding_id = $id";
      $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function setMoulding($data)
    {
        return $this->db->insert('mo.mo_moulding', $data);
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }

    public function insMouldingEmployee($header_id, $no_induk, $nama)
    {
        $sql = "
            INSERT into mo.mo_moulding_employee (moulding_id, name, no_induk) VALUES ('$header_id', '$nama', '$no_induk')
        ";
        $query = $this->db->query($sql);
    }

    public function updateMoulding($data, $id)
    {
        $this->db->where('moulding_id', $id);
        $this->db->update('mo.mo_moulding', $data);
    }

    public function deleteMoulding($id)
    {
        $this->db->where('moulding_id', $id);
        $this->db->delete('mo.mo_moulding');
    }
}

/* End of file M_moulding.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_moulding.php */
/* Generated automatically on 2017-12-20 14:49:32 */