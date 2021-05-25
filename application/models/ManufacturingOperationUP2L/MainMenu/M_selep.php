<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_selep extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getSelep()
    {
        $sql = "SELECT * FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // DATATABLE SERVERSIDE CORE
    public function selectSelep($data)
    {
      $explode = strtoupper($data['search']['value']);
        $res = $this->db
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY selep_date DESC) as pagination
                        FROM
                            (
                              SELECT mfo.*
                              FROM
                                  (SELECT * FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id) mfo
                              WHERE
                                    (
                                      component_code LIKE '%{$explode}%'
                                      OR component_description LIKE '%{$explode}%'
                                      OR selep_date::text LIKE '%{$explode}%'
                                      OR job_id LIKE '%{$explode}%'
                                      OR shift LIKE '%{$explode}%'
                                    )
                            ) skdav

                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAllSelep()
    {
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
        (SELECT selep_id FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id) kdo"
        )->row_array();
    }

    public function countFilteredSelep($data)
    {
      $explode = strtoupper($data['search']['value']);
      return $this->db->query(
        "SELECT
              COUNT(*) AS \"count\"
            FROM
            (SELECT * FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id) kdo
            WHERE
            (
              component_code LIKE '%{$explode}%'
              OR component_description LIKE '%{$explode}%'
              OR selep_date::text LIKE '%{$explode}%'
              OR job_id LIKE '%{$explode}%'
              OR shift LIKE '%{$explode}%'
            )"
        )->row_array();
    }
    // END SERVERSIDE DATATABLE

    public function getSelepById($id)
    {
        $query = $this->db->get_where('mo.mo_selep', array('selep_id' => $id));
        return $query->result_array();
    }

    public function setSelep($data)
    {
        return $this->db->insert('mo.mo_selep', $data);
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }

    public function updateSelep($data, $id)
    {
        $this->db->where('selep_id', $id);
        $this->db->update('mo.mo_selep', $data);
    }

    public function deleteSelep($id)
    {
        $sql = "DELETE FROM mo.mo_selep WHERE selep_id = '$id'; DELETE FROM mo.mo_quality_control WHERE selep_id_c = '$id';";
        $this->db->query($sql);
    }

    public function getSelepDate($txtStartDate, $txtEndDate)
    {
        $sql = "SELECT * FROM mo.mo_selep WHERE selep_date BETWEEN '$txtStartDate' AND '$txtEndDate' ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date)";
        return $this->db->query($sql)->result_array();
    }

    public function getKodeProses($kode_barang)
    {
        $query = $this->db->query("
        SELECT kode_proses FROM mo.mo_master_item WHERE (kode_barang = '$kode_barang')
        order by kode_proses
        ");
        return $query->result_array();
    }
}
