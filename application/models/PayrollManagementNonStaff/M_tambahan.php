<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tambahan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTambahan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_tambahan');
    	} else {
    		//$query = $this->db->get_where('pr.pr_tambahan', array('tambahan_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_tambahan')->join('er.er_employee_all', 'er.er_employee_all.employee_code=pr.pr_tambahan.noind')->where('tambahan_id', $id)->get();
    	}

    	return $query->result_array();
    }

    public function getTambahanDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_tambahan pta
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pta.noind
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTambahanSearch($searchValue)
    {
        $sql = "
            SELECT * FROM pr.pr_tambahan pta
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pta.noind
            WHERE
                    pta.\"noind\" ILIKE '%$searchValue%'
                OR  CAST(pta.\"bulan_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pta.\"tahun_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pta.\"kurang_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pta.\"lain_lain\" AS TEXT) ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTambahanOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    pta.\"noind\" ILIKE '%$searchValue%'
                OR  CAST(pta.\"bulan_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pta.\"tahun_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pta.\"kurang_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pta.\"lain_lain\" AS TEXT) ILIKE '%$searchValue%'

                OR  eea.employee_name ILIKE '%$searchValue%'
            ";
        }
        $sql="
            SELECT * FROM pr.pr_tambahan pta
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pta.noind

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function setTambahan($data)
    {
        return $this->db->insert('pr.pr_tambahan', $data);
    }

    public function updateTambahan($data, $id)
    {
        $this->db->where('tambahan_id', $id);
        $this->db->update('pr.pr_tambahan', $data);
    }

    public function deleteTambahan($id)
    {
        $this->db->where('tambahan_id', $id);
        $this->db->delete('pr.pr_tambahan');
    }

	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}

}

/* End of file M_tambahan.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_tambahan.php */
/* Generated automatically on 2017-03-20 13:43:45 */