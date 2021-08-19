<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('LaporanPenjualanTraktor/M_pipeline');
	}

	// public function index(){
	// 	print_r('Masih dalam perbaikan');
	// }

	public function index(){

		$max_req_type = $this->M_pipeline->get_max_request('khs_lpb_type')[0]['REQ_ID'];
		$max_req_detail = $this->M_pipeline->get_max_request('khs_lpb_penjualan_detail')[0]['REQ_ID'];

		$validate_type = $this->M_pipeline->check_data_availability('khs_lpb_type_hari', 'REQUEST_ID', $max_req_type);
		$validate_detail = $this->M_pipeline->check_data_availability('khs_lpb_type_hari', 'REQUEST_ID', $max_req_detail);

		if ($validate_type[0]['count'] == 0){
			$sales = $this->M_pipeline->get_data_sales(); // DATA PENJUALAN
			$this->M_pipeline->insert_sales_data('khs_lpb_type_hari', $sales);
		}

		if ($validate_type[0]['count'] == 0){
			$detail = $this->M_pipeline->get_data_sales_detail(); // DATA PENJUALAN DETAIL
			$this->M_pipeline->insert_sales_data('khs_lpb_penjualan_detail', $detail);
		}		

		$skip = $this->M_pipeline->get_support_data('khs_lpb_skip_date', 'DATE_ID'); // TANGGAL MERAH
		$target = $this->M_pipeline->get_support_data('khs_lpb_targets', 'TARGET_ID'); // TARGET PENJUALAN
		$analys = $this->M_pipeline->get_support_data('khs_lpb_analys', 'ANALYS_ID'); // ANALISA PENJUALAN
		$market = $this->M_pipeline->get_support_data('khs_lpb_market', 'MARKET_ID'); // KONDISI PASAR		

		$this->support_data($skip, "khs_lpb_skip_date", "DATE_ID");
		$this->support_data($target, "khs_lpb_targets", "TARGET_ID");
		$this->support_data($analys, "khs_lpb_analys", "ANALYS_ID");
		$this->support_data($market, "khs_lpb_market", "MARKET_ID");

		print_r('Success');
	}

	public function support_data($data, $table, $pk){
		foreach ($data as $key => $dt) {
			$validate = $this->M_pipeline->check_data_availability($table, $pk, $dt[$pk]);

			if ($validate[0]['count'] > 0){
				// update data
				$this->M_pipeline->update_supporting_data($table, $dt);
			} else {
				// insert data
				$this->M_pipeline->insert_supporting_data($table, $dt);
			}
		}
	}

}
?>