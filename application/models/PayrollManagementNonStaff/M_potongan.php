<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_potongan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPotongan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_potongan');
    	} else {
    		//$query = $this->db->get_where('pr.pr_potongan', array('potongan_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_potongan')->join('er.er_employee_all', 'er.er_employee_all.employee_code=pr.pr_potongan.noind')->where('potongan_id', $id)->get();
    	}

    	return $query->result_array();
    }

    public function getPotonganDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_potongan ppo
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = ppo.noind
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPotonganSearch($searchValue)
    {
        $numericValue = "";
        if (is_numeric($searchValue)) {
            $numericValue = "
                OR  ppo.\"bulan_gaji\" = '$searchValue'
                OR  ppo.\"tahun_gaji\" = '$searchValue'
                OR  ppo.\"pot_lebih_bayar\" = '$searchValue'
                OR  ppo.\"pot_gp\" = '$searchValue'
                OR  ppo.\"pot_dl\" = '$searchValue'
                OR  ppo.\"pot_spsi\" = '$searchValue'
                OR  ppo.\"pot_duka\" = '$searchValue'
                OR  ppo.\"pot_koperasi\" = '$searchValue'
                OR  ppo.\"pot_hutang_lain\" = '$searchValue'
                OR  ppo.\"pot_dplk\" = '$searchValue'
                OR  ppo.\"pot_thp\" = '$searchValue'
            ";
        }
        $sql = "
            SELECT * FROM pr.pr_potongan ppo
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = ppo.noind
            WHERE
                    ppo.\"noind\" ILIKE '%$searchValue%'
                $numericValue
                OR  eea.employee_name ILIKE '%$searchValue%'
                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPotonganOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $numericValue = "";
            if (is_numeric($searchValue)) {
                $numericValue = "
                    OR  ppo.\"bulan_gaji\" = '$searchValue'
                    OR  ppo.\"tahun_gaji\" = '$searchValue'
                    OR  ppo.\"pot_lebih_bayar\" = '$searchValue'
                    OR  ppo.\"pot_gp\" = '$searchValue'
                    OR  ppo.\"pot_dl\" = '$searchValue'
                    OR  ppo.\"pot_spsi\" = '$searchValue'
                    OR  ppo.\"pot_duka\" = '$searchValue'
                    OR  ppo.\"pot_koperasi\" = '$searchValue'
                    OR  ppo.\"pot_hutang_lain\" = '$searchValue'
                    OR  ppo.\"pot_dplk\" = '$searchValue'
                    OR  ppo.\"pot_thp\" = '$searchValue'
                ";
            }
            $condition = "
                WHERE
                    ppo.\"noind\" ILIKE '%$searchValue%'
                $numericValue
                OR  eea.employee_name ILIKE '%$searchValue%'
            ";
        }
        $sql="
            SELECT * FROM pr.pr_potongan ppo
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = ppo.noind

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function setPotongan($data)
    {
        return $this->db->insert('pr.pr_potongan', $data);
    }

    public function updatePotongan($data, $id)
    {
        $this->db->where('potongan_id', $id);
        $this->db->update('pr.pr_potongan', $data);
    }

    public function deletePotongan($id)
    {
        $this->db->where('potongan_id', $id);
        $this->db->delete('pr.pr_potongan');
    }

	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}

}

/* End of file M_potongan.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_potongan.php */
/* Generated automatically on 2017-03-20 13:40:14 */