<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_targetbenda extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTargetBenda($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_target_benda');
    	} else {
    		//$query = $this->db->get_where('pr.pr_target_benda', array('target_benda_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_target_benda')->join('er.er_section', 'er.er_section.section_code=pr.pr_target_benda.kodesie')->where('target_benda_id', $id)->get();
            $sql = "
                SELECT * FROM pr.pr_target_benda ptb
                LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = ptb.kodesie
                WHERE
                    ptb.target_benda_id = '$id'
            ";
            $query = $this->db->query($sql);
    	}

    	return $query->result_array();
    }

    public function getTargetBendaDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_target_benda ptb
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = ptb.kodesie
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTargetBendaSearch($searchValue)
    {
        $numericValue = "";
        if (is_numeric($searchValue)) {
            $numericValue = "
                OR  ptb.\"jumlah_operator\" = '$searchValue'
                OR  ptb.\"target_utama\" = '$searchValue'
                OR  ptb.\"target_sementara\" = '$searchValue'
                OR  ptb.\"waktu_setting\" = '$searchValue'
                OR  ptb.\"learning_periode\" = '$searchValue'

            ";
        }
        $sql = "
            SELECT * FROM pr.pr_target_benda ptb
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = ptb.kodesie
            WHERE
                    ptb.\"kodesie\" ILIKE '%$searchValue%'
                OR  ptb.\"kodesie\" ILIKE '%$searchValue%'
                OR  ptb.\"kodesie\" ILIKE '%$searchValue%'
                OR  ptb.\"kode_barang\" ILIKE '%$searchValue%'
                OR  ptb.\"nama_barang\" ILIKE '%$searchValue%'
                OR  ptb.\"kode_proses\" ILIKE '%$searchValue%'
                OR  ptb.\"nama_proses\" ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'

                $numericValue
                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTargetBendaOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $numericValue = "";
            if (is_numeric($searchValue)) {
                $numericValue = "
                    OR  ptb.\"jumlah_operator\" = '$searchValue'
                    OR  ptb.\"target_utama\" = '$searchValue'
                    OR  ptb.\"target_sementara\" = '$searchValue'
                    OR  ptb.\"waktu_setting\" = '$searchValue'
                    OR  ptb.\"learning_periode\" = '$searchValue'
                ";
            }
            $condition = "
                WHERE
                    ptb.\"kodesie\" ILIKE '%$searchValue%'
                OR  ptb.\"kodesie\" ILIKE '%$searchValue%'
                OR  ptb.\"kodesie\" ILIKE '%$searchValue%'
                OR  ptb.\"kode_barang\" ILIKE '%$searchValue%'
                OR  ptb.\"nama_barang\" ILIKE '%$searchValue%'
                OR  ptb.\"kode_proses\" ILIKE '%$searchValue%'
                OR  ptb.\"nama_proses\" ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'

                $numericValue
            ";
        }
        $sql="
            SELECT * FROM pr.pr_target_benda ptb
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = ptb.kodesie

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function setTargetBenda($data)
    {
        return $this->db->insert('pr.pr_target_benda', $data);
    }

    public function updateTargetBenda($data, $id)
    {
        $this->db->where('target_benda_id', $id);
        $this->db->update('pr.pr_target_benda', $data);
    }

    public function deleteTargetBenda($id)
    {
        $this->db->where('target_benda_id', $id);
        $this->db->delete('pr.pr_target_benda');
    }
}

/* End of file M_targetbenda.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_targetbenda.php */
/* Generated automatically on 2017-03-23 13:51:52 */