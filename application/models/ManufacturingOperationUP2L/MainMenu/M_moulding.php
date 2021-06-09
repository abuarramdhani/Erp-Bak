<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_moulding extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    //rozin edit 2021
    //DATATABLE SERVER SIDE MOULDING
    public function selectM($data, $bulan, $tanggal)
    {
      $explode = strtoupper($data['search']['value']);
      $exbulan = explode('-', $bulan);
      $range = explode(' - ', $tanggal);
      if (!empty($bulan) && empty($tanggal)) {
        $tanggal__="";
        $bulan__="AND extract(month from mm.production_date) = '$exbulan[1]'
                  AND extract(year from mm.production_date) = '$exbulan[0]'";
      }else if (!empty($tanggal) && empty($bulan)){
        $tanggal__="AND mm.production_date BETWEEN '{$range[0]}' AND '{$range[1]}'";
        $bulan__="";
      }else {
        $tanggal__="";
        $bulan__="";
      }
        $res = $this->db
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY production_date DESC) as pagination
                        FROM
                            (
                              SELECT mfo.*
                              FROM
                                  (SELECT mm.moulding_id,
                                          mm.component_code,
                                          mm.component_description,
                                          mm.production_date,
                                          mm.shift,
                                          mm.moulding_quantity,
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
                                  $tanggal__
                                  $bulan__
                                  and ma.category_produksi = 'Moulding'
                                  and ma.id_produksi = mm.moulding_id
                                  and ma.no_induk = me.no_induk
                                  GROUP  BY mm.moulding_id,
                                          mm.moulding_quantity,
                                          mm.component_code,
                                          mm.component_description,
                                          mm.production_date,
                                          ma.kode
                                          ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode) mfo
                              WHERE
                                    (
                                      component_code LIKE '%{$explode}%'
                                      OR component_description LIKE '%{$explode}%'
                                      OR production_date::text LIKE '%{$explode}%'
                                      OR kode LIKE '%{$explode}%'
                                      OR shift LIKE '%{$explode}%'
                                    )
                            ) skdav

                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAllM($bulan, $tanggal)
    {
      $exbulan = explode('-', $bulan);
      $range = explode(' - ', $tanggal);
      if (!empty($bulan) && empty($tanggal)) {
        $tanggal__="";
        $bulan__="AND extract(month from mm.production_date) = '$exbulan[1]'
                  AND extract(year from mm.production_date) = '$exbulan[0]'";
      }else if(!empty($tanggal) && empty($bulan)){
        $tanggal__="AND mm.production_date BETWEEN '{$range[0]}' AND '{$range[1]}'";
        $bulan__="";
      }else {
        $tanggal__="";
        $bulan__="";
      }
        return $this->db
            ->query(
                "SELECT
                    COUNT(*) AS jm
                FROM
                (  SELECT mm.moulding_id,
                          mm.component_code,
                          mm.component_description,
                          mm.production_date,
                          mm.shift,
                          mm.moulding_quantity,
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
                  $tanggal__
                  $bulan__
                  and ma.category_produksi = 'Moulding'
                  and ma.id_produksi = mm.moulding_id
                  and ma.no_induk = me.no_induk
                  GROUP  BY mm.moulding_id,
                          mm.moulding_quantity,
                          mm.component_code,
                          mm.component_description,
                          mm.production_date,
                          ma.kode
                          ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode

                ) kdo"
            )->result_array();
    }

    public function countFilteredM($data, $bulan, $tanggal)
    {
        $explode = strtoupper($data['search']['value']);
        $exbulan = explode('-', $bulan);
        $range = explode(' - ', $tanggal);
        if (!empty($bulan) && empty($tanggal)) {
          $tanggal__="";
          $bulan__="AND extract(month from mm.production_date) = '$exbulan[1]'
                    AND extract(year from mm.production_date) = '$exbulan[0]'";
        }else if(!empty($tanggal) && empty($bulan)) {
          $tanggal__="AND mm.production_date BETWEEN '{$range[0]}' AND '{$range[1]}'";
          $bulan__="";
        }else {
          $tanggal__="";
          $bulan__="";
        }
        return $this->db->query(
            "SELECT
                    COUNT(*) AS jm
                FROM
                (SELECT mm.moulding_id,
                        mm.component_code,
                        mm.component_description,
                        mm.production_date,
                        mm.shift,
                        mm.moulding_quantity,
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
                $tanggal__
                $bulan__
                and ma.category_produksi = 'Moulding'
                and ma.id_produksi = mm.moulding_id
                and ma.no_induk = me.no_induk
                GROUP  BY mm.moulding_id,
                        mm.moulding_quantity,
                        mm.component_code,
                        mm.component_description,
                        mm.production_date,
                        ma.kode
                        ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode) kdo
                        WHERE
                         (
                           component_code LIKE '%{$explode}%'
                           OR component_description LIKE '%{$explode}%'
                           OR production_date::text LIKE '%{$explode}%'
                           OR kode LIKE '%{$explode}%'
                           OR shift LIKE '%{$explode}%'
                         )"
        )->row_array();
    }
    //END SERVERSIDE DATATABLE


    public function monitoringMoulding()
    {
        $sql = "SELECT mm.moulding_id,
                mm.component_code,
                mm.component_description,
                mm.production_date,
                mm.shift,
                mm.moulding_quantity,
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
                ma.kode
                ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getMoulding($id = FALSE)
    {
        if ($id === FALSE) {
            $sql = "SELECT mm.moulding_id,
                    mm.component_code,
                    mm.component_description,
                    mm.production_date,
                    mm.moulding_quantity,
                    me.name,
                    me.no_induk,
            from mo.mo_moulding mm,
                 mo.mo_moulding_employee me,
            where mm.moulding_id = me.moulding_id";
            $query = $this->db->query($sql);
        } else {
            $sql = "SELECT mm.*,
                    me.name,
                    me.no_induk,
                    ma.kode kode
            from mo.mo_moulding mm,
                 mo.mo_moulding_employee me,
                 mo.mo_absensi ma
            where mm.moulding_id = me.moulding_id
            and mm.moulding_id = '$id'
            and ma.category_produksi = 'Moulding'
            and ma.id_produksi = mm.moulding_id
            group by ma.kode, mm.moulding_id, me.name, me.no_induk";
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
        $this->db->where('moulding_id', $id);
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
    public function search($mon, $year)
    {
        $sql = "SELECT mm.moulding_id,
                mm.component_code,
                mm.component_description,
                mm.production_date,
                mm.shift,
                mm.moulding_quantity,
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
        WHERE EXTRACT(MONTH FROM mm.production_date) = '$mon'
        and EXTRACT(YEAR FROM mm.production_date) = '$year'
        and mm.moulding_id = me.moulding_id
        and ma.category_produksi = 'Moulding'
        and ma.id_produksi = mm.moulding_id
        and ma.no_induk = me.no_induk
        GROUP  BY mm.moulding_id,
                mm.moulding_quantity,
                mm.component_code,
                mm.component_description,
                mm.production_date,
                ma.kode
        ORDER  BY mm.production_date, ma.kode";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
