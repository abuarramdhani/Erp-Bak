<?php 
class M_input extends CI_Model
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->oracle = $this->load->database('oracle',true);
		}
	public function getData(){
		$sql = "SELECT kmpt.UPDATE_ID, kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN, kmpt.RECEIVE_CLOSE_TOLERANCE, kmpt.QTY_RCV_TOLERANCE ,kmpt.CETAK
			FROM KHS_MONITORING_PEMBELIAN_TEMP kmpt
			ORDER BY kmpt.UPDATE_ID";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	// datatable serverside1
	    public $table = "KHS_MONITORING_PEMBELIAN_TEMP";
	    public $select_column = array("UPDATE_ID", "UPDATE_DATE", "SEGMENT1", "DESCRIPTION", "PRIMARY_UOM_CODE", "SECONDARY_UOM_CODE", "FULL_NAME", "PREPROCESSING_LEAD_TIME", "PREPARATION_PO", "DELIVERY", "FULL_LEAD_TIME", "POSTPROCESSING_LEAD_TIME", "TOTAL_LEADTIME"
			, "MINIMUM_ORDER_QUANTITY", "FIXED_LOT_MULTIPLIER", "ATTRIBUTE18", "STATUS", "KETERANGAN", "RECEIVE_CLOSE_TOLERANCE", "QTY_RCV_TOLERANCE", "CETAK");
	    public $order_column = array("UPDATE_ID", null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null );

	    public function make_query()
	    {
	        $this->oracle->select($this->select_column);
	        $this->oracle->from($this->table);
	        if (isset($_POST["search"]["value"])) {
	            $this->oracle->like("UPDATE_ID", $_POST["search"]["value"]);
	            $this->oracle->or_like("UPDATE_DATE", $_POST["search"]["value"]);
	            $this->oracle->or_like("SEGMENT1", $_POST["search"]["value"]);
							$this->oracle->or_like("DESCRIPTION", $_POST["search"]["value"]);
							$this->oracle->or_like("PRIMARY_UOM_CODE", $_POST["search"]["value"]);
							$this->oracle->or_like("SECONDARY_UOM_CODE", $_POST["search"]["value"]);
							$this->oracle->or_like("FULL_NAME", $_POST["search"]["value"]);
							$this->oracle->or_like("STATUS", $_POST["search"]["value"], 'after');
	        }
	        if (isset($_POST["order"])) {
	            $this->oracle->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } else {
	            $this->oracle->order_by('UPDATE_ID', 'DESC');
	        }
	    }

	    public function make_datatables()
	    {
	        $this->make_query();
	        if ($_POST["length"] != -1) {
	            $this->oracle->limit($_POST['length'], $_POST['start']);
	        }
	        $query = $this->oracle->get();
	        return $query->result();
	    }

	    public function get_filtered_data()
	    {
	        $this->make_query();
	        $query = $this->oracle->get();
	        return $query->num_rows();
	    }

	    public function get_all_data()
	    {
	        $this->oracle->select($this->select_column);
	        $this->oracle->from($this->table);
	        return $this->oracle->count_all_results();
	    }

		public function searchselect2($keyword)
		{
			return $this->oracle->select('UPDATE_ID')->distinct()->like('UPDATE_ID', $keyword, 'after')->order_by('UPDATE_ID', 'asc')->get('KHS_MONITORING_PEMBELIAN_TEMP')->result_array();
		}
}

?>