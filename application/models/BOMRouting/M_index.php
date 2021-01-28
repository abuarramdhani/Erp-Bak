<?php
class M_index extends CI_Model
{
    public $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
        // $this->oracle  = $this->load->database('oracle', true);
    }

    public function setHeader($data)
    {
        return $this->db->insert('pbr.pbr_bom_header', $data);
    }

    public function setUser($data)
    {
        return $this->db->insert('pbr.pbr_user', $data);
    }

    public function setComponent($data)
    {
        return $this->db->insert('pbr.pbr_bom_penyusun', $data);
    }

    public function getHeader($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('pbr.pbr_bom_header');
        return $query->result_array();
    }

    public function delete_penyusun($id)
    {
        $sql = "DELETE FROM pbr.pbr_bom_penyusun WHERE id = $id";
        $query = $this->db->query($sql);
        return $sql;
    }

    // datatable serverside1
    public $table = "pbr.pbr_bom_header";
    public $select_column = array("id", "no_document", "tgl_pembuatan", "kode_item_parent", "nama_barang", "seksi", "io", "tgl_berlaku");
    public $order_column = array(null, null, "tgl_pembuatan", null, null, null, null, null);

    public function make_query()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("no_document", $_POST["search"]["value"]);
            $this->db->or_like("kode_item_parent", $_POST["search"]["value"]);
            $this->db->or_like("nama_barang", $_POST["search"]["value"]);
            $this->db->or_like("tgl_berlaku", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_component_update($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('pbr.pbr_bom_penyusun');

        $query = $this->db->get();
        return $query->result_array();
    }

    // serverSide2
    public $table2 = "pbr.pbr_bom_penyusun";
    public $select_column2 = array("id", "kode_komponen_penyusun", "deskripsi_penyusun", "quantity", "uom", "supply_type", "supply_subinventory", "supply_locator", "subinventory_picklist", "locator_picklist", "id_header");
    public $order_column2 = array(null, "kode_komponen_penyusun", "deskripsi_penyusun", null, "uom", null, null, null, null, null, null);

    public function make_query2()
    {
        $this->db->select('*');
        $this->db->from($this->table2);
        if (isset($_POST["search"]["value"])) {
            $this->db->or_like("deskripsi_penyusun", $_POST["search"]["value"]);
            $this->db->or_like("quantity", $_POST["search"]["value"]);
            $this->db->or_like("uom", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function make_datatables2($var)
    {
        // $var = '20';
        if ($_POST["length"] != -1) {
            $this->db->select('*');
            $this->db->from($this->table2);
            $this->db->where('id_header', $var);
            $this->db->order_by('id', 'DESC');
            $this->db->limit($_POST['length'], $_POST['start']);
            // $this->db->get();
        }
        // $this->make_query2();

        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data2()
    {
        $this->make_query2();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data2()
    {
        $this->db->select("*");
        $this->db->from($this->table2);
        return $this->db->count_all_results();
    }
    //end serverside datatable

    public function updateHeader($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('pbr.pbr_bom_header', $data);
    }

    public function MupdatePenyusun($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('pbr.pbr_bom_penyusun', $data);
    }

    public function getUser()
    {
        $this->db->select('*');
        $this->db->from('pbr.pbr_user');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function CekUser($kamu)
    {
        $this->db->select('no_induk');
        $this->db->from('pbr.pbr_user');
        $this->db->where('no_induk', $kamu);
        $this->db->where('role_access', 'Member');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function CekUserAll($kamu)
    {
        $this->db->select('no_induk');
        $this->db->from('pbr.pbr_user');
        $this->db->where('no_induk', $kamu);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function CariSelect2($keyword)
    {
        return $this->personalia->select('nama, noind')->like('nama', strtoupper($keyword), 'after')-> or_like('noind', strtoupper($keyword), 'after')->order_by('noind', 'asc')->get('hrd_khs.tpribadi')->result_array();
    }

    public function getUsera()
    {
        $this->personalia->select('nama, noind');
        $this->personalia->from('hrd_khs.tpribadi');

        $query = $this->personalia->get();
        return $query->result_array();
    }

    public function getUserUpdate($id)
    {
        $this->db->select('*');
        $this->db->from('pbr.pbr_user');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataUserCreate($id)
    {
        $this->personalia->select('nama, noind');
        $this->personalia->from('hrd_khs.tpribadi');
        $this->personalia->where('noind', $id);

        $query = $this->personalia->get();
        return $query->result_array();
    }


    public function updateUser($id, $data)
    {
        // echo "<pre>";
        // print_r($id);
        $this->db->where('id', $id);
        $this->db->update('pbr.pbr_user', $data);
    }

    public function delete_header($id)
    {
        $sql = "DELETE FROM pbr.pbr_bom_header WHERE id = '$id'";
        $query = $this->db->query($sql);
        return $sql;
    }

    public function delete_user($id)
    {
        $sql = "DELETE FROM pbr.pbr_user WHERE id = '$id'";
        $query = $this->db->query($sql);
        return $sql;
    }

    public function getLatestNoNumber($time)
    {
        $sql = "SELECT max(substring(mm.no_document, 1, 2)) last_number
                FROM pbr.pbr_bom_header mm
                WHERE mm.no_document LIKE '%$time'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
