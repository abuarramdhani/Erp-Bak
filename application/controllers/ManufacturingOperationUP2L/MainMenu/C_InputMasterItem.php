<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_InputMasterItem extends CI_Controller
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
		$this->load->library('Excel');
        $this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_masteritem');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!$this->session->is_logged){
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] 		= 'Master';
		$data['Menu'] 		= 'Manufacturing Operation';
		$data['SubMenuOne'] = 'Master Item';
		$data['SubMenuTwo'] = '';


		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/master/V_InputMasterItem', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$this->checkSession();
		$user_id  			= $this->session->userid;
		$data['Menu'] 		= 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/master/V_MasterItem',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateSubmit()
	{
		$user_id = $this->session->userid;
		$fileName 					= $_FILES['item']['name'] .'-'. time();
		$config['upload_path']		= 'assets/download/ManufacturingOperationUP2L/masterItem/';
		$config['allowed_types']	= '*';
		$config['max_size'] 	 	= '8096';
		$config['overwrite'] 		= true;
		$config['file_name'] 		= $fileName;

		$this->upload->initialize($config);

		if($this->upload->do_upload('item')) {
			$media			= $this->upload->data();
			$inputFileName 	= 'assets/download/ManufacturingOperationUP2L/masterItem/'.$media['file_name'];
			chmod('./' . $inputFileName, 0777);
            try {
            	$inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
            	$objReader      = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel    = $objReader->load($inputFileName);
            } catch(Exception $e) {
            	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			$sheet          = $objPHPExcel->getSheet(0);
            $highestRow     = $sheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				$rowData = $sheet->rangeToArray('A' . $row . ':' . 'K' . $row, NULL, FALSE, TRUE);
				$value = array(
					'id'				=> (empty($rowData[0][0]) ? 0 : $rowData[0][0]),
					'type'				=> (empty($rowData[0][1]) ? null : $rowData[0][1]),
					'kode_barang' 		=> (empty($rowData[0][2]) ? null : $rowData[0][2]),
					'nama_barang'		=> (empty($rowData[0][3]) ? null : $rowData[0][3]),
					'proses'			=> (empty($rowData[0][4]) ? null : $rowData[0][4]),
					'kode_proses'		=> (empty($rowData[0][5]) ? null : $rowData[0][5]),
					'target_sk'			=> (empty($rowData[0][6]) ? 0 : $rowData[0][6]),
					'target_js'			=> (empty($rowData[0][7]) ? 0 : $rowData[0][7]),
					'tanggal_berlaku' 	=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][8])),
					'created_by'		=> $user_id,
					'creation_date'		=> date("Y-m-d H:i:s"),
					'jenis'				=> (empty($rowData[0][9]) ? null : $rowData[0][9]),
					'berat' 			=> (empty($rowData[0][10]) ? 0 : $rowData[0][10]),
				);

					if ($value['id'] == 0) {
						unset($value['id']);
						$this->M_masteritem->insert($value, 'mo.mo_master_item');
					} else {
						$this->M_masteritem->updateMasterItem(
							$value['type'], $value['kode_barang'], $value['nama_barang'], $value['proses'],
							$value['kode_proses'], $value['target_sk'], $value['target_js'], $value['tanggal_berlaku'],
							$user_id, $value['id'], $value['jenis'], $value['berat']
						);
					}
			}
		} else {
			echo '<pre>Error : <br>';print_r($this->upload->display_errors());
		}
		unlink($inputFileName);
		redirect(base_url('ManufacturingOperationUP2L/InputMasterItem'));
	}
	
	public function insertMasIt()
	{
		$user_id 		= $this->session->userid;
		$type 			= $this->input->post('tType');
		$kodBar 		= $this->input->post('tKodeBarang');
		$namBar 		= $this->input->post('tNamaBarang');
		$proses 		= $this->input->post('tProses');
		$kodPros 		= $this->input->post('tKodeProses');
		$berat			= $this->input->post('tBerat');
		$SK 			= $this->input->post('tSK');
		$JS 			= $this->input->post('tJS');
		$jenis 			= $this->input->post('tJenis');
		$tglBerlaku 	= $this->input->post('tBerlaku');
		$creation_date 	= date('d/m/y');
		$this->M_masteritem->insertMasIt($type,$kodBar,$namBar,$proses,$kodPros,$SK,$JS,$tglBerlaku,$user_id,$creation_date,$jenis,$berat);
		redirect(base_url('ManufacturingOperationUP2L/InputMasterItem'));
	}


}