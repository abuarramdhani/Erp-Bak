<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_datalkhseksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLKHSeksi($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_lkh_seksi');
    	} else {
    		$query = $this->db->get_where('pr.pr_lkh_seksi', array('lkh_seksi_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getLKHSeksiDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_lkh_seksi pls
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pls.noind
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getLKHSeksiSearch($searchValue)
    {
        $sql = "
            SELECT * FROM pr.pr_lkh_seksi pls
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pls.noind
            WHERE
                    pls.\"noind\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses\"  ILIKE '%$searchValue%'
                OR  pls.\"shift\"  ILIKE '%$searchValue%'
                OR  pls.\"status\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang_target_sementara\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses_target_sementara\"  ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  CAST(pls.\"jml_barang\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmat\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmch\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"repair\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"reject\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"setting_time\" AS TEXT) ILIKE '%$searchValue%'

                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getLKHSeksiOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    pls.\"noind\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses\"  ILIKE '%$searchValue%'
                OR  pls.\"shift\"  ILIKE '%$searchValue%'
                OR  pls.\"status\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang_target_sementara\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses_target_sementara\"  ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  CAST(pls.\"jml_barang\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmat\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmch\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"repair\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"reject\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"setting_time\" AS TEXT) ILIKE '%$searchValue%'

            ";
        }
        $sql="
            SELECT * FROM pr.pr_lkh_seksi pls
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pls.noind

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function setLKHSeksi($data)
    {
        return $this->db->insert('pr.pr_lkh_seksi', $data);
    }

    public function updateKondite($data, $id)
    {
        $this->db->where('kondite_id', $id);
        $this->db->update('pr.pr_kondite', $data);
    }

    public function deleteKondite($id)
    {
        $this->db->where('kondite_id', $id);
        $this->db->delete('pr.pr_kondite');
    }

	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}


	public function getSection()
	{
		$query = $this->db->get('er.er_section');

		return $query->result_array();
	}

    public function clearData($firstdate, $lastdate)
    {
        $sql = "
            DELETE

            FROM
                pr.pr_lkh_seksi pls

            WHERE
                pls.\"tgl\" BETWEEN '$firstdate' AND '$lastdate'
        ";

        $query = $this->db->query($sql);
        return;
    }

}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */