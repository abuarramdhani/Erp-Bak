<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Management extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PeriodicalMaintenance/M_management');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Management Uraian Kerja';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


		$data['mesin'] = $this->M_management->getMesin();


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Management', $data);
		$this->load->view('V_Footer', $data);
	}

	public function search()
	{
		$mesin 	= $this->input->post('mesin');

		$dataGET = $this->M_management->getAll($mesin);
		// echo "<pre>"; 
		// print_r($dataGET); exit();
		// pengelompokan data
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			if (!in_array($value['HEADER'], $array_sudah)) {
				array_push($array_sudah, $value['HEADER']);
				$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN'], $value['HEADER']);

				$array_terkelompok[$value['HEADER']]['header'] = $value;
				$array_terkelompok[$value['HEADER']]['body'] = $getBody;
			}
		}
		$data['value'] = $array_terkelompok;

		$this->load->view('PeriodicalMaintenance/V_Result', $data);
	}

	public function editSubManagement()
	{
		$id = $this->input->post('id');
		$dataa = $this->M_management->selectDataToEdit($id);

		if ($dataa[0]['PERIODE'] == "2 Mingguan") {
			$opsi = '<option selected>2 Mingguan</option>
			<option>Tahunan</option>';
		} else {
			$opsi = '<option>2 Mingguan</option>
			<option selected>Tahunan</option>';
		}

		$editmasterhandling = '
		<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Uraian Kerja</label></div>                                        
				<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="subHeaderEdit" name="subHeaderEdit" value="' . $dataa[0]['SUB_HEADER'] . '" /></div>
				<input type="hidden" name="idRowEdit" id="idRowEdit" value="' . $id . '"/>
			</div>
			<div class="panel-body">                            
				<div class="col-md-5" style="text-align: right;"><label>Standar</label></div>                                        
				<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="standarEdit" name="standarEdit" value="' . $dataa[0]['STANDAR'] . '" /></div>
			</div>
			<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Periode</label></div>                                        
			<div class="col-md-4" style="text-align: left;">
			<select id="periodeEdit" name="periodeEdit" class="form-control select2" style="width: 100%" data-placeholder="Periode" value="' . $dataa[0]['PERIODE'] . '">
			<option></option>
			<option>Harian</option>
			<option>Mingguan</option>
			<option>2 Mingguan</option>
			<option>Bulanan</option>
			<option>2 Bulanan</option>
			<option>3 Bulanan</option>
			<option>4 Bulanan</option>
			<option>5 Bulanan</option>
			<option>6 Bulanan</option>
			<option>8 Bulanan</option>
			<option>9 Bulanan</option>
			<option>Tahunan</option>
			<option>2 Tahunan</option>
			<option>3 Tahunan</option>
			<option>4 Tahunan</option>
			<option>5 Tahunan</option>
		</select>
			</div>
		</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button class="btn btn-success button-save-edit">Save</button></div>
			</div>';


		echo $editmasterhandling;
	}

	public function updateSubManagement()
	{
		$id = $this->input->post('id');
		$subHeader = $this->input->post('subHeader');
		$standar = $this->input->post('standar');
		$periode = $this->input->post('periode');

		$this->M_management->updateSubManagement($id, $subHeader, $standar, $periode);
	}

	public function deleteSubManagement()
	{
		$id = $this->input->post('id');
		$this->M_management->deleteSubManagement($id);
	}
}

