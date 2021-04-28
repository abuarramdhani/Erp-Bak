<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// nggak disentuh total sama edwin
class C_Ajax extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');
	}

	public function getComponent()
	{
		$term = strtoupper($this->input->post('term'));
		$data = $this->M_ajax->getComponent($term);

		echo json_encode($data);
	}

	public function getEmployee()
	{
		$term = strtoupper($this->input->post('term'));
		$data = $this->M_ajax->getEmployee($term);

		echo json_encode($data);
	}

	public function getScrap()
	{
		$term = strtoupper($this->input->post('term'));
		$data = $this->M_ajax->getScrap($term);

		echo json_encode($data);
	}

	public function addScrap()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$qty = $this->input->post('qty');

		foreach ($type as $key => $value) {
			$a = explode('|', $value);
			$code = $a[0];
			$desc = $a[1];
			// echo "<pre>"; print_r($this->input->post()); die;
			$this->M_ajax->addScrap($id, $qty[$key], $code, $desc);

			$data = $this->M_ajax->viewScrap($id);
			foreach ($data as $scrap) {
				echo '<li class="list-group-item">' . $scrap['type_scrap'] . ' [' . $scrap['kode_scrap'] . ']' . ' | ' . $scrap['quantity'] . '</li>';
			}
		}
	}


	public function addBongkar()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$qty = $this->input->post('qty');

		foreach ($qty as $key => $value) {
			// echo "<pre>"; print_r($this->input->post()); die;
			$this->M_ajax->addBongkar($id, $qty[$key]);

			$data = $this->M_ajax->viewBongkar($id);
			foreach ($data as $bongkar) {
				echo '<li class="list-group-item">' . $bongkar['moulding_id'] . ' [' . $bongkar['qty'] . ']' . '</li>';
			}
		}

	}

	public function addQuality()
	{
		$id = $this->input->post('ID');
		$checking_date = $this->input->post('CHECKING_DATE');
		$print_code = $this->input->post('PRINT_CODE');
		$checking_quantity = $this->input->post('CHECK');
		$scrap_quantity = $this->input->post('SCRAP');
		$repair_quantity = $this->input->post('REPAIR');
		$remaining_quantity = $this->input->post('REMAIN');
		$component_code = $this->input->post('COMPONENT');
		$employee = $this->input->post('EMPLOYEE');
		$component_description = $this->input->post('DESCRIPTION');
		$selep_quantity = $this->input->post('SELEPQTY');
		$shift = $this->input->post('SHIFT');

		$check_qc = TRUE;

		$this->M_ajax->setQualityControl(
			$checking_date, $print_code, $checking_quantity, $scrap_quantity,
			$remaining_quantity, $component_code, $employee,
			$component_description, $selep_quantity, $shift, $check_qc, $id, $repair_quantity
		);
	}

	public function getPrintCode()
	{
		$monthCode = array(
			array('month' => 1, 'code' => 'A'),
			array('month' => 2, 'code' => 'B'),
			array('month' => 3, 'code' => 'C'),
			array('month' => 4, 'code' => 'D'),
			array('month' => 5, 'code' => 'E'),
			array('month' => 6, 'code' => 'F'),
			array('month' => 7, 'code' => 'G'),
			array('month' => 8, 'code' => 'H'),
			array('month' => 9, 'code' => 'J'),
			array('month' => 10, 'code' => 'K'),
			array('month' => 11, 'code' => 'L'),
			array('month' => 12, 'code' => 'M')
		);
		$yearCode = array(
			array('year' => 0, 'code' => 'N'),
			array('year' => 1, 'code' => 'P'),
			array('year' => 2, 'code' => 'Q'),
			array('year' => 3, 'code' => 'R'),
			array('year' => 4, 'code' => 'S'),
			array('year' => 5, 'code' => 'U'),
			array('year' => 6, 'code' => 'V'),
			array('year' => 7, 'code' => 'W'),
			array('year' => 8, 'code' => 'Y'),
			array('year' => 9, 'code' => 'Z'),
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
                <input type="radio" name="print_code" placeholder="Print Code" value="' . $val[2] . $bulan . ' ' . $tahun . '" required> ' . $val[2] . $bulan . ' ' . $tahun . '
                <br><input type="radio" name="print_code" placeholder="Print Code" value="' . $bulan . $val[2] . ' ' . $tahun . '" required> ' . $bulan . $val[2] . ' ' . $tahun . '
                <br><input type="radio" name="print_code" placeholder="Print Code" value="T' . $val[2] . $bulan . ' ' . $tahun . '" required> T' . $val[2] . $bulan . ' ' . $tahun . '
                <br><input type="radio" name="print_code" placeholder="Print Code" value="T' . $bulan . $val[2] . ' ' . $tahun . '" required> T' . $bulan . $val[2] . ' ' . $tahun . '
            </div>
            <div class="col-md-3">
                <input type="radio" name="print_code" placeholder="Print Code" value="X' . $val[2] . $bulan . ' ' . $tahun . '" required> X' . $val[2] . $bulan . ' ' . $tahun . '
                <br><input type="radio" name="print_code" placeholder="Print Code" value="X' . $bulan . $val[2] . ' ' . $tahun . '" required> X' . $bulan . $val[2] . ' ' . $tahun . '
                <br><input type="radio" name="print_code" placeholder="Print Code" value="XT' . $val[2] . $bulan . ' ' . $tahun . '" required> XT' . $val[2] . $bulan . ' ' . $tahun . '
                <br><input type="radio" name="print_code" placeholder="Print Code" value="XT' . $bulan . $val[2] . ' ' . $tahun . '" required> XT' . $bulan . $val[2] . ' ' . $tahun . '
            </div>';
	}

	public function getShift()
	{
		$tanggal = $_POST['tanggal'];
		$data = $this->M_ajax->getShift($tanggal);
		echo json_encode($data);
	}

	public function getAllShift()
	{
		$term = strtoupper($this->input->get('term', TRUE));
		echo json_encode($this->M_ajax->getAllShift($term));
	}

	public function getJobData()
	{
		$jobCode	= $this->input->post('jobCode');
		$startDate	= $this->input->post('startDate');
		$endDate	= $this->input->post('endDate');

		$data['jobData'] = $this->M_ajax->getJobData($jobCode, $startDate, $endDate);
		$this->load->view('ManufacturingOperationUP2L/ReplaceComp/V_jobtable', $data);
	}

	public function getDatePrintCode()
	{
		$data = $this->input->post('TANGGAL');

		$query = $this->M_ajax->getDatePrintCode($data);

		echo json_encode($query);
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
			'subinventory_code'		=> $this->input->post('subinv'),
			'return_quantity'		=> $this->input->post('returnQty'),
			'return_information'	=> $this->input->post('returnInfo'),
			'created_by'			=> $user_id,
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$data = $this->M_ajax->setRejectComp($value);
		echo json_encode($data);
	}

	public function deleteRejectComp($id)
	{
		$data = $this->M_ajax->getRejectComp($id);
		$this->M_ajax->deleteRejectComp($id);
		echo json_encode($data);
	}

	public function deleteItem($id)
	{
		$data = $this->M_ajax->deleteItem($id);
		echo json_encode($data);
	}

	public function deleteScrap($id)
	{
		$data = $this->M_ajax->deleteScrap($id);
		echo json_encode($data);
	}

	public function deletePerson($id)
	{
		$data = $this->M_ajax->deletePerson($id);
		echo json_encode($data);
	}

	public function editItem($id)
	{
		$data = $this->M_ajax->editItem($id);
		foreach ($data as $edit) {
			echo '
					<div class="row">
					 <form method="post" action="' . base_url('ManufacturingOperationUP2L/MasterItem/updateMasIt') . '">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <input class="form-control" type="text" name="txtType" value="' . $edit['type'] . '" required>
                                <input class="form-control" type="hidden" name="txtId" value="' . $id . '">
                            </div>
                            <div class="form-group">
                                <label for="usr">Kode Barang:</label>
                                <input type="text" class="form-control" name="txtKodeBarang" value="' . $edit['kode_barang'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="usr">Nama Barang:</label>
                                <input type="text" class="form-control" name="txtNamaBarang" value="' . $edit['nama_barang'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="usr">Proses:</label>
                                <input type="text" class="form-control" name="txtProses" value="' . $edit['proses'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="usr">Kode Proses:</label>
                                <input type="text" class="form-control" name="txtKodeProses" value="' . $edit['kode_proses'] . '" required>
							</div>
							<div class="form-group">
								<label for="usr">Berat:</label>
								<input type="text" class="form-control" name="tBerat" value="' . $edit['berat'] . '" required>
							</div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Target</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="usr">Senin-Kamis</label>
                                        <input type="number" class="form-control" name="txtSK" value="' . $edit['target_sk'] . '" required>
                                    </div>
                                    <div class="form-group">
                                       	<label for="usr">Jumat-Sabtu:</label>
                                       	<input type="number" class="form-control" name="txtJS" value="' . $edit['target_js'] . '" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usr">Tanggal Berlaku</label>
                                <input id="tglBerlaku" type="date" class="form-control" name="tglBerlaku" value="' . $edit['tanggal_berlaku'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="usr">Jenis</label>
                                <input id="txtJenis" type="text" class="form-control" name="txtJenis" value="' . $edit['jenis'] . '" required>
                            </div>
                            <button type="submit" class="btn btn-default" >Submit</button>
                        </div>

                        </form>
                     </div>

			';
		}
	}

	public function editScrap($id)
	{
		$data = $this->M_ajax->editScrap($id);
		foreach ($data as $edit) {
			echo '
			<div class="row">
			<form method="post" action="' . base_url('ManufacturingOperationUP2L/MasterScrap/updateMasScrap') . '">
			<div class="col-md-12">
                    <div class="form-group">
                        <label>Description :</label>
                        <input class="form-control" type="text" name="txt_descScrap" placeholder="Deskripsi Scrap" value="' . $edit['description'] . '" required>
                        <input class="form-control" type="hidden" name="txtId" value="' . $edit['id'] . '" required>
                    </div>
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="text_kodeScrap" placeholder="Kode Scrap" value="' . $edit['scrap_code'] . '" required>
                    </div>
                    <button type="submit" class="btn btn-default" style="float:right" >Submit</button>
                  </div>
                  </form>
                  </div>';
		}
	}

	public function editPerson($id)
	{
		$data = $this->M_ajax->editPerson($id);
		foreach ($data as $edit) {
			echo '
			<div class="row">
			<form method="post" action="' . base_url('ManufacturingOperationUP2L/MasterPersonal/updateMasPer') . '">
			<div class="col-md-12">
                    <div class="form-group">
                        <label>Nama:</label>
                        <input class="form-control" type="text" name="tNama" placeholder="Type" value="' . $edit['nama'] . '" required>
                        <input class="form-control" type="hidden" name="txtId" placeholder="Type" value="' . $edit['id'] . '" required>
                    </div>
                    <div class="form-group">
                        <label for="usr">No Induk:</label>
                        <input type="text" class="form-control" name="tNoInduk" placeholder="Kode Barang" value="' . $edit['no_induk'] . '" required>
                    </div>
                    <button type="submit" class="btn btn-default" style="float:right" >Submit</button>
                  </div>
                  </form>
                  </div>';
		}
	}
}
