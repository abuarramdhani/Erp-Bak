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
        $sql = "SELECT mm.moulding_id, 
                mm.component_code, 
                mm.component_description, 
                mm.production_date, 
                mm.shift, 
                mm.moulding_quantity, 
                mm.keterangan, 
                mm.print_code, 
                Count(me.name)                           jumlah_pekerja, 
                (SELECT Sum(ms.quantity) 
                FROM   mo.mo_moulding_scrap ms 
                WHERE  ms.moulding_id = mm.moulding_id) scrap_qty, 
                (SELECT Sum(mb.qty) 
                FROM   mo.mo_moulding_bongkar mb 
                WHERE  mb.moulding_id = mm.moulding_id) bongkar_qty,
                ma.kode
        FROM   mo.mo_moulding mm, 
                mo.mo_moulding_employee me,
        mo.mo_absensi ma
        WHERE  mm.moulding_id = me.moulding_id 
        and ma.category_produksi = 'Moulding'
        and ma.id_produksi = mm.moulding_id
        and ma.no_induk = me.no_induk
        GROUP  BY mm.moulding_id, 
                mm.moulding_quantity, 
                mm.component_code, 
                mm.component_description, 
                mm.production_date, 
                mm.keterangan,
                ma.kode
        ORDER  BY mm.production_date, ma.kode";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMoulding($id = FALSE)
    {
        if ($id === FALSE) {
            $sql = "select mm.moulding_id,
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
            $sql = "select mm.moulding_id,
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
                    scrap_id,
                    (select sum(quantity) from mo.mo_moulding_scrap where moulding_id='$id') jumlah
                from mo.mo_moulding_scrap
              where moulding_id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getBongkar($id)
    {
        $sql = "select 
                    moulding_id,
                    qty,
                    bongkar_id,
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

    public function updateMoulding($id, $data)
    {
        // $sql = "
        //     SET mo.mo_moulding
        //     (component_code = '$component_code', component_description = '$component_description', production_date = '$production_date,
        //     moulding_quantity = '$moulding_quantity', job_id = '$job_id', scrap_quantity = '$scrap_quantity', scrap_type = '$scrap_type')
        //     WHERE id = $id;

        // ";
        //VALUES ($component_code, $component_description, $production_date, $moulding_quantity, $job_id, $scrap_quantity, $scrap_type)
        // $query = $this->db->query($sql);

        $this->db->where('moulding_id', $id); //$this->db->where('moulding_id', $id);
        $this->db->update('mo.mo_moulding', $data);
    }

    public function editScrap($id)
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

    public function deleteMoulding($id)
    {
        $sql = "DELETE FROM mo.mo_moulding WHERE moulding_id = '$id'; DELETE FROM mo.mo_absensi WHERE id_produksi = '$id';
                DELETE FROM mo.mo_moulding_employee WHERE moulding_id = '$id'; DELETE FROM mo.mo_moulding_bongkar WHERE moulding_id = '$id';
                DELETE FROM mo.mo_moulding_scrap WHERE moulding_id = '$id';";
        $this->db->query($sql);
    }

    public function delScr($ids)
    {
        $sql = "DELETE FROM mo.mo_moulding_scrap WHERE scrap_id = '$ids'";
        $query = $this->db->query($sql);
    }
    public function delBon($idb)
    {
        $sql = "DELETE FROM mo.mo_moulding_bongkar WHERE bongkar_id = '$idb'";
        $query = $this->db->query($sql);
    }
    public function updBon($qtyBon, $idBongkar)
    {

        $sql = "UPDATE mo.mo_moulding_bongkar SET qty = '$qtyBon' WHERE bongkar_id = '$idBongkar'";
        $query = $this->db->query($sql);
    }
    public function updScr($qtyScr, $idScr, $codeScrap, $typeScrap)
    {

        $sql = "UPDATE mo.mo_moulding_scrap SET quantity = '$qtyScr', kode_scrap = '$codeScrap', type_scrap = '$typeScrap' WHERE scrap_id = '$idScr'";
        $query = $this->db->query($sql);
    }
}

/* End of file M_moulding.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_moulding.php */
/* Generated automatically on 2017-12-20 14:49:32 */
