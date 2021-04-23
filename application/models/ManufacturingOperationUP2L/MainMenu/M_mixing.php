<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mixing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // edit rozin
    // DATATABLE SERVERSIDE MIXING
    public function selectMix($data)
    {
      $explode = strtoupper($data['search']['value']);
      $res = $this->db->query(
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
                    (SELECT mm.*, ma.kode kode
                            FROM mo.mo_mixing mm, mo.mo_absensi ma
                            WHERE ma.id_produksi = mm.mixing_id AND ma.category_produksi = 'Mixing'
                            GROUP BY mm.mixing_id, ma.kode
                            ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode) mfo
                WHERE
                    (
                      component_code LIKE '%{$explode}%'
                      OR component_description LIKE '%{$explode}%'
                      OR production_date::text LIKE '%{$explode}%'
                      OR shift LIKE '%{$explode}%'
                      OR kode LIKE '{%$explode%}'
                    )
                  ) skdav
            ) kdav
          WHERE
              pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
        )->result_array();

        return $res;
    }

    public function countAllMix()
    {
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
        (SELECT mm.*, ma.kode kode
                FROM mo.mo_mixing mm, mo.mo_absensi ma
                WHERE ma.id_produksi = mm.mixing_id AND ma.category_produksi = 'Mixing'
                GROUP BY mm.mixing_id, ma.kode
                ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode
              ) kdo"
        )->row_array();
    }

    public function countFilteredMix($data)
    {
      $explode = strtoupper($data['search']['value']);
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
          FROM
          (SELECT mm.*, ma.kode kode
                  FROM mo.mo_mixing mm, mo.mo_absensi ma
                  WHERE ma.id_produksi = mm.mixing_id AND ma.category_produksi = 'Mixing'
                  GROUP BY mm.mixing_id, ma.kode
                  ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode
                ) kdo
                WHERE
                  (
                    component_code LIKE '%{$explode}%'
                    OR component_description LIKE '%{$explode}%'
                    OR production_date::text LIKE '%{$explode}%'
                    OR shift LIKE '%{$explode}%'
                    OR kode LIKE '%{$explode}%'
                  )"
        )->row_array();
    }
    // END SERVERSIDE DATATABLE
    public function getMixing()
    {
        $sql = "SELECT mm.*, ma.kode kode
                FROM mo.mo_mixing mm, mo.mo_absensi ma
                WHERE ma.id_produksi = mm.mixing_id AND ma.category_produksi = 'Mixing'
                GROUP BY mm.mixing_id, ma.kode
                ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode";
        return $this->db->query($sql)->result_array();
    }

    public function getMixingById($id)
    {
        $query = "SELECT mm.*, ma.kode kode
                FROM mo.mo_mixing mm, mo.mo_absensi ma
                WHERE ma.id_produksi = mm.mixing_id AND ma.category_produksi = 'Mixing' AND mm.mixing_id = '$id'
                GROUP BY mm.mixing_id, ma.kode";
        return $this->db->query($query)->result_array();
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }


    public function setMixing($data)
    {
        return $this->db->insert('mo.mo_mixing', $data);
    }

    public function updateMixing($data, $id)
    {
        $this->db->where('mixing_id', $id);
        $this->db->update('mo.mo_mixing', $data);
    }

    public function deleteMixing($id)
    {
        $sql = "DELETE FROM mo.mo_mixing WHERE mixing_id = '$id'; DELETE FROM mo.mo_absensi WHERE id_produksi = '$id'";
        $this->db->query($sql);
    }

}
