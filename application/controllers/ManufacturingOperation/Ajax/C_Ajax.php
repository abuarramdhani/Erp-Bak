<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Ajax extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('ManufacturingOperation/Ajax/M_ajax');
	}

	public function getComponent()
	{
		$term = strtoupper($this->input->post('term'));
		$data = $this->M_ajax->getComponent($term);

		echo json_encode($data);
	}

	public function getPrintCode()
	{
		$monthCode = array(
			array('month' => 1,'code' => 'A'),
			array('month' => 2,'code' => 'B'),
			array('month' => 3,'code' => 'C'),
			array('month' => 4,'code' => 'D'),
			array('month' => 5,'code' => 'E'),
			array('month' => 6,'code' => 'F'),
			array('month' => 7,'code' => 'G'),
			array('month' => 8,'code' => 'H'),
			array('month' => 9,'code' => 'J'),
			array('month' => 10,'code' => 'K'),
			array('month' => 11,'code' => 'L'),
			array('month' => 12,'code' => 'M')
		);
		$yearCode = array(
			array('year' => 0,'code' => 'N'),
			array('year' => 1,'code' => 'P'),
			array('year' => 2,'code' => 'Q'),
			array('year' => 3,'code' => 'R'),
			array('year' => 4,'code' => 'S'),
			array('year' => 5,'code' => 'U'),
			array('year' => 6,'code' => 'V'),
			array('year' => 7,'code' => 'W'),
			array('year' => 8,'code' => 'Y'),
			array('year' => 9,'code' => 'Z'),
		);

		$tanggal = $this->input->post('tanggal');
		$val = explode('/', $tanggal);

		foreach ($monthCode as $value) {
			if ($val[1] == $value['month']) {
				$bulan = $value['code'];
			}
		}
		foreach ($yearCode as $v) {
			if (substr($val[0], 3) == $v['year']) {
				$tahun = $v['code'];
			}
		}

		echo '<div class="col-md-3">
                <input type="radio" name="print_code" placeholder="Print Code" value="22M W" required> '.$val[2].$bulan.' '.$tahun.'
                <br><input type="radio" name="print_code" placeholder="Print Code" value="M22 W" required> '.$bulan.$val[2].' '.$tahun.'
                <br><input type="radio" name="print_code" placeholder="Print Code" value="T22M W" required> T'.$val[2].$bulan.' '.$tahun.'
                <br><input type="radio" name="print_code" placeholder="Print Code" value="TM22 W" required> T'.$bulan.$val[2].' '.$tahun.'
            </div>
            <div class="col-md-3">
                <input type="radio" name="print_code" placeholder="Print Code" value="X22M W" required> X'.$val[2].$bulan.' '.$tahun.'
                <br><input type="radio" name="print_code" placeholder="Print Code" value="XM22 W" required> X'.$bulan.$val[2].' '.$tahun.'
                <br><input type="radio" name="print_code" placeholder="Print Code" value="XT22M W" required> XT'.$val[2].$bulan.' '.$tahun.'
                <br><input type="radio" name="print_code" placeholder="Print Code" value="XTM22 W" required> XT'.$bulan.$val[2].' '.$tahun.'
            </div>';
	}

	public function getJobData()
	{
		$jobCode	= $this->input->post('jobCode');
		$startDate	= $this->input->post('startDate');
		$endDate	= $this->input->post('endDate');

		$data['jobData'] = $this->M_ajax->getJobData($jobCode, $startDate, $endDate);
		$this->load->view('ManufacturingOperation/ReplaceComp/V_jobtable', $data);
	}

	public function setRejectComp()
	{
		$user_id = $this->session->userid;
		$value = array(
			'job_number'			=> $this->input->post('jobNumber'),
			'assy_code'				=> $this->input->post('assyCode'),
			'assy_description'		=> $this->input->post('assyDesc'),
			'section'				=> $this->input->post('section'),
			'component_code'		=> $this->input->post('compCode'),
			'component_description' => $this->input->post('compDesc'),
			'picklist_quantity'		=> $this->input->post('qty'),
			'uom'					=> $this->input->post('uom'),
			'return_quantity'		=> $this->input->post('returnQty'),
			'return_information'	=> $this->input->post('returnInfo'),
			'created_by'			=> $user_id,
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$data = $this->M_ajax->setRejectComp($value);
		echo json_encode($data);
	}
}