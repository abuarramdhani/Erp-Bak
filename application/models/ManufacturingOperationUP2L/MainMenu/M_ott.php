<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_ott extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // rozin edit 2021
    // DATATABLE SERVERSIDE OTT
    public function selectOtt($data)
    {
      $explode = strtoupper($data['search']['value']);
        $res = $this->db
            ->query(
              "SELECT kdav.*
              FROM
                  (
                  SELECT
                        skdav.*,
                        ROW_NUMBER () OVER (ORDER BY otttgl DESC) as pagination
                    FROM
                        (
                          SELECT mfo.*
                          FROM
                              (SELECT * FROM mo.mo_ott
                                ORDER BY extract(month from otttgl) desc, extract(year from otttgl) desc, extract(day from otttgl)) mfo
                          WHERE
                                (
                                  nama LIKE '%{$explode}%'
                                  OR otttgl::text LIKE '%{$explode}%'
                                  OR kode_cor LIKE '%{$explode}%'
                                  OR shift LIKE '%{$explode}%'
                                  OR pekerjaan LIKE '%{$explode}%'
                                  OR kode LIKE '%{$explode}%'
                                )
                        ) skdav
                ) kdav
            WHERE
                pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
              )->result_array();

          return $res;
    }

    public function countAllOtt()
    {
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
            (SELECT * FROM mo.mo_ott
              ORDER BY extract(month from otttgl) desc, extract(year from otttgl) desc, extract(day from otttgl)
            )kdo"
        )->row_array();
    }

    public function countFilteredOtt($data)
    {
      $explode = strtoupper($data['search']['value']);
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
          (SELECT * FROM mo.mo_ott
            ORDER BY extract(month from otttgl) desc, extract(year from otttgl) desc, extract(day from otttgl)) kdo
            WHERE
            (
              nama LIKE '%{$explode}%'
              OR otttgl::text LIKE '%{$explode}%'
              OR kode_cor LIKE '%{$explode}%'
              OR shift LIKE '%{$explode}%'
              OR pekerjaan LIKE '%{$explode}%'
              OR kode LIKE '%{$explode}%'
            )"
        )->row_array();
    }
    // END SERVERSIDE DATATABLE
    public function index_data()
    {
        $sql = "SELECT * FROM mo.mo_ott ORDER BY extract(month from otttgl) desc, extract(year from otttgl) desc, extract(day from otttgl)";
        return $this->db->query($sql)->result_array();
    }

    public function save_create($data)
    {
        $this->db->insert('mo.mo_ott', $data);
    }

    public function byId($id)
    {
        $this->db->select('*');
        $query = $this->db->get_where('mo.mo_ott', array('id' => $id));
        return $query->result_array();
    }

    public function save_update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('mo.mo_ott', $data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM mo.mo_ott WHERE id = '$id';
                DELETE FROM mo.mo_absensi WHERE category_produksi = 'OTT' AND id_produksi = '$id'";
        $this->db->query($sql);
    }

    public function pekerja()
    {
        $this->db->select('no_induk, nama');
        $query = $this->db->get('mo.mo_master_personal');
        return $query->result_array();
    }

    public function createAbs($dataAbs)
    {
        $this->db->insert('mo.mo_absensi', $dataAbs);
    }

    public function updateAbs($dataAbs, $id)
    {
        $this->db->where('id_absensi', $id);
        $this->db->update('mo.mo_absensi', $dataAbs);
    }

    public function v_absensi($id)
    {
        $sql = "SELECT id_absensi, id_produksi FROM mo.mo_absensi WHERE id_produksi = '$id'";
        return $this->db->query($sql)->result_array();
    }
}
