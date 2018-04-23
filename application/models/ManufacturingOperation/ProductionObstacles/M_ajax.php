<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_ajax extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);     
    }

    function delete($id)
    {
    	$this->db->where('id', $id);
      	$this->db->delete('mo.mo_master_induk');
    }

    function deleteCabang($id)
    {
    	$this->db->where('id', $id);
      	$this->db->delete('mo.mo_master_cabang');
    }

    function deleteHam($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mo.mo_hambatan_mesin');
    }

     function deleteHamNon($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mo.mo_hambatan_non_mesin');
    }

    function UpdateInduk($id,$val)
    {
        $sql = "update mo.mo_master_induk set induk = '$val' where id = $id";
        $query= $this->db->query($sql);
        return $query;
    }

    function UpdateCabang($id,$val)
    {
        $sql = "update mo.mo_master_cabang set cabang = '$val' where id = $id";
        // $query= $this->db->query($sql);
        return $this->db->query($sql);
    }

    function selectInduk($term, $type, $kategori)
    {   if ($type=='n') {
            $paramType='';
        }else{
            $paramType="and cetak = '$type'";
        }

        if ($kategori == 'n') {
            $kate= '';
        }elseif($kategori=='non-mesin'){
            $kate = "and hambatan ='$kategori'";
        }
        else{
            $kate = "and kategori = '$kategori'";
        }

        $sql = "select * from mo.mo_master_induk where  induk like '%$term%' $paramType $kate";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function selectCabang($induk, $term)
    {
        $sql = "select * from mo.mo_master_cabang where induk_id = $induk and cabang like '%$term%'";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function searchHambatan($tgl1,$tgl2,$type,$kategori)
    {
        $sql = "select induk,
                        cabang,
                        sum(selesai-mulai) total,
                        count(induk||' '||cabang) frekuensi
                from mo.mo_hambatan_mesin
                where mulai between '$tgl1' and '$tgl2'
                    and cetak = '$type'
                    and kategori = '$kategori'
                group by induk,cabang
                order by sum(selesai-mulai) desc";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function searchHambatanNon($tgl1,$tgl2,$type)
    {
        $sql = "select induk,
                        cabang,
                        sum(selesai-mulai) total,
                        count(induk||' '||cabang) frekuensi
                from mo.mo_hambatan_non_mesin
                where mulai between '$tgl1' and '$tgl2'
                    and cetak = '$type'
                group by induk,cabang
                order by sum(selesai-mulai) desc";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function reportHambatan($tgl1,$tgl2,$type,$kategori)
    {
        $sql = "select induk||' - '||cabang hambatan,
                        sum(selesai-mulai) total,
                        count(induk||' '||cabang) frekuensi
                from mo.mo_hambatan_mesin
                where mulai between '$tgl1' and '$tgl2'
                    and cetak = '$type'
                    and kategori = '$kategori'
                group by induk||' - '||cabang
                order by sum(selesai-mulai) desc
                        ";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function reportHambatanNon($tgl1,$tgl2,$type)
    {
        $sql = "select induk||' - '||cabang hambatan,
                        sum(selesai-mulai) total,
                        count(induk||' '||cabang) frekuensi
                from mo.mo_hambatan_non_mesin
                where mulai between '$tgl1' and '$tgl2'
                    and cetak = '$type'
                group by induk||' - '||cabang
                order by sum(selesai-mulai) desc
                        ";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function updateindukCabang($induk,$id)
    {
        $sql = "update mo.mo_master_cabang set induk = '$induk' where id= $id";
        $query= $this->db->query($sql);
        return $query;
    }
}