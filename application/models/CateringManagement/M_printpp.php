<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_printpp extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getPrintpp($id = FALSE)
    {
    	if ($id === FALSE) {
            $sql = "select * from ga.ga_printpp where pp_catering_lokasi is null order by tgl_buat desc";
    		// $query = $this->db->get('ga.ga_printpp');
            $query = $this->db->query($sql);
    	} else {
    		// $query = $this->db->get_where('ga.ga_printpp', array('pp_id' => $id));
    		$query = $this->db->query("
    			select
					pp.*,
					er1.employee_name as kadept,
					er2.employee_name as direksi,
					er3.employee_name as kasie,
					er4.employee_name as kaunit,
					er5.employee_name as siepembelian
				from
					ga.ga_printpp pp
				left join er.er_employee_all er1 on er1.employee_id = cast(pp.pp_kadept as integer)
				left join er.er_employee_all er2 on er2.employee_id = cast(pp.pp_direksi as integer)
				left join er.er_employee_all er3 on er3.employee_id = cast(pp.pp_kasie as integer)
				left join er.er_employee_all er4 on er4.employee_id = cast(pp.pp_kaunit as integer)
				left join er.er_employee_all er5 on er5.employee_id = cast(pp.pp_siepembelian as integer)
				where
					pp.pp_id = '".$id."' order by pp.tgl_buat desc"
    		);
    	}

    	return $query->result_array();
    }

    public function getPrintppDetail($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_printpp_detail');
    	} else {
    		$query = $this->db->get_where('ga.ga_printpp_detail', array('pp_id' => $id));
    	}

    	return $query->result_array();
    }

    public function createPrintpp($temp)
    {
        return $this->db->insert('ga.ga_printpp', $temp);
    }

    public function createPrintppDetail($lines)
    {
        return $this->db->insert('ga.ga_printpp_detail', $lines);
    }

    public function updatePrintpp($temp, $id)
    {
        $this->db->where('pp_id', $id);
        $this->db->update('ga.ga_printpp', $temp);
    }

    public function updatePrintppDetail($lines, $id)
    {
        $this->db->where('pp_detail_id', $id);
        $this->db->update('ga.ga_printpp_detail', $lines);
    }

    public function deletePrintpp($id)
    {
        $this->db->where('pp_id', $id);
        $this->db->delete('ga.ga_printpp');

        $this->db->where('pp_id', $id);
        $this->db->delete('ga.ga_printpp_detail');

    }

    public function deletePrintppDetail($id)
    {
    	$this->db->where('pp_detail_id', $id);
        $this->db->delete('ga.ga_printpp_detail');
    }

	public function getSection()
	{
		$query = $this->db->query("select er_section_id,section_name from er.er_section where job_name='-' and section_name not in ('-')");

		return $query->result_array();
	}


	public function getEmployeeAll($key)
	{
		// $query = $this->db->get_where('er.er_employee_all', array('employee_name' => $key));
		$query = $this->db->query("SELECT * from er.er_employee_all where employee_name like '%".$key."%'");
		return $query->result_array();
	}

	public function getEmployeeSelected()
	{
		$query = $this->db->get('er.er_employee_all');
		return $query->result_array();
	}

	public function getBranch()
	{
		$query = $this->db->get('ga.ga_branch');

		return $query->result_array();
	}

	public function getCostCenter()
	{
		$query = $this->db->get('ga.ga_cost_center');

		return $query->result_array();
	}

    public function kodeItem()
    {
        $query = $this->db->get('ga.ga_master_item');

        return $query->result_array();
    }

    public function kodeItem2($key)
    {
        $sql = "select * from ga.ga_master_item where kode_item like '%$key%'";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    public function namaItem($key)
    {
        $sql = "select * from ga.ga_master_item where kode_item = '$key'";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}

/* End of file M_printpp.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */