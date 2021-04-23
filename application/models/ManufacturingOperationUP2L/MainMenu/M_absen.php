<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_absen extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // rozin edit 2021
    // DATATABLE SERVERSIDE ABSEN
    public function selectAbs($data)
    {
      $explode = ucwords($data['search']['value']);
      $explode2 = strtoupper($data['search']['value']);
        $res = $this->db->query(
          "SELECT kdav.*
          FROM
              (
              SELECT
                      skdav.*,
                      ROW_NUMBER () OVER (ORDER BY created_date DESC) as pagination
                  FROM
                      (
                        SELECT mfo.*
                        FROM
                            (SELECT * FROM mo.mo_absensi WHERE presensi != 'HDR'
                              ORDER BY extract(month from created_date) desc, extract(year from created_date) desc, extract(day from created_date)) mfo
                        WHERE
                            (
                              nama LIKE '%{$explode}%'
                              OR no_induk LIKE '%{$explode}%'
                              OR created_date::text LIKE '%{$explode}%'
                              OR presensi LIKE '%{$explode2}%'
                            )
                      ) skdav
              ) kdav
          WHERE
              pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
          )->result_array();

      return $res;
    }

    public function countAllAbs()
    {
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
        (SELECT * FROM mo.mo_absensi WHERE presensi != 'HDR'
          ORDER BY extract(month from created_date) desc, extract(year from created_date) desc, extract(day from created_date)
          ) kdo"
        )->row_array();
    }

    public function countFilteredAbs($data)
    {
      $explode = ucwords($data['search']['value']);
      $explode2 = strtoupper($data['search']['value']);
      return $this->db->query(
        "SELECT
              COUNT(*) AS \"count\"
            FROM
            (SELECT * FROM mo.mo_absensi WHERE presensi != 'HDR'
              ORDER BY extract(month from created_date) desc, extract(year from created_date) desc, extract(day from created_date)) kdo
            WHERE
            (
              nama LIKE '%{$explode}%'
              OR no_induk LIKE '%{$explode}%'
              OR created_date::text LIKE '%{$explode}%'
              OR presensi LIKE '%{$explode2}%'
            )"
        )->row_array();
    }
    // END DATATABLE SERVERSIDE
    public function index_data()
    {
        $sql = "SELECT * FROM mo.mo_absensi WHERE presensi != 'HDR' ORDER BY extract(month from created_date) desc, extract(year from created_date) desc, extract(day from created_date)";
        return $this->db->query($sql)->result_array();
    }

    public function save_create($data)
    {
        $this->db->insert('mo.mo_absensi', $data);
    }

    public function byId($id)
    {
        $this->db->select('*');
        $query = $this->db->get_where('mo.mo_absensi', array('id_absensi' => $id));
        return $query->result_array();
    }

    public function save_update($data, $id)
    {
        $this->db->where('id_absensi', $id);
        $this->db->update('mo.mo_absensi', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_absensi', $id);
        $this->db->delete('mo.mo_absensi');
    }

    public function pekerja()
    {
        $this->db->select('no_induk, nama');
        $query = $this->db->get('mo.mo_master_personal');
        return $query->result_array();
    }
    public function pekerjaAjax($term)
    {
        $sql = "SELECT DISTINCT no_induk, nama FROM mo.mo_master_personal WHERE LOWER(nama) LIKE '%$term%' OR LOWER(no_induk) LIKE '%$term%'";
        return $this->db->query($sql)->result_array();
    }

}
