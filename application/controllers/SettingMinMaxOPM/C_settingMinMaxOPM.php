<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_settingMinMaxOPM extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('Excel');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SettingMinMaxOPM/M_settingminmaxopm');

		date_default_timezone_set('Asia/Jakarta');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){		
		}else{
			redirect();
		}
	}

	//------------------------show the dashboard-----------------------------
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function getRouteODM()
	{
		$data = $this->M_settingminmaxopm->TampilRoutingClassODM();
		echo '<option></option>';
		foreach ($data as $route) {
			echo '<option>'.$route['ROUTING_CLASS'].'</option>';
		}
	}
	public function getRouteOPM()
	{
		$data = $this->M_settingminmaxopm->TampilRoutingClass();
		echo '<option></option>';
		foreach ($data as $route) {
			echo '<option>'.$route['ROUTING_CLASS'].'</option>';
		}
	}

	public function Edit()
	{

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil');
		$this->load->view('V_Footer',$data);
	}

	public function IE()
	{

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_TampilIE');
		$this->load->view('V_Footer',$data);
	}

	public function EditbyRoute()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($this->session->flashdata('route') == null) 
		{
			$org = $this->input->post('org');
			$route = $this->input->post('routing_class');
		} 
		elseif ($this->session->flashdata('route') != null)
		{
			$org = $this->session->flashdata('org');
			$route = $this->session->flashdata('route');
		}

		

		$data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();
		if ($org == 'OPM') {
			$data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
		} elseif ($org == 'ODM') {
			$data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMaxODM($route);
		}
		$data['org'] = $org;
		$data['routeaktif'] = $route;

		if ($data['minmax'] == null) {
			$this->session->set_flashdata('kosong', 'Mohon Untuk Input Ulang');
			redirect(base_url('SettingMinMax/Edit/'));
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil_byRoute');
		$this->load->view('V_Footer',$data);
	}


	
	public function EditbyRouteIE()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($this->session->flashdata('route') == null) 
		{
			$org = $this->input->post('org');
			$route = $this->input->post('routing_class');
		} 
		elseif ($this->session->flashdata('route') != null)
		{
			$org = $this->session->flashdata('org');
			$route = $this->session->flashdata('route');
		}

		

		$data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();
		if ($org == 'OPM') {
			$data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
		} elseif ($org == 'ODM') {
			$data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMaxODM($route);
		}
		$data['org'] = $org;
		$data['routeaktif'] = $route;

		if ($data['minmax'] == null) {
			$this->session->set_flashdata('kosong', 'Mohon Untuk Input Ulang');
			redirect(base_url('SettingMinMax/IE/'));
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil_byRouteIE');
		$this->load->view('V_Footer',$data);

		// echo"<pre>";
		// print_r($data);
		// exit();
	}

	public function EditItem($org, $route, $itemcode)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['routeaktif'] = $route;
		if ($org == 'ODM') {
			$data['item_minmax'] = $this->M_settingminmaxopm->TampilDataItemMinMaxODM($route,$itemcode);
		} elseif ($org == 'OPM') {
			$data['item_minmax'] = $this->M_settingminmaxopm->TampilDataItemMinMax($route,$itemcode);
		}
		$data['org'] = $org;
		$data['No_induk'] = $this->session->user;;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil_Edit_Minmax');
		$this->load->view('V_Footer',$data);
	}

	public function SaveMinMax()
	{	
		// echo "<pre>";
		// print_r($_POST);
		// exit();
		$org = $this->input->post('org');
		$induk = $this->input->post('induk');
		$route = $this->input->post('route');
		$itemcode = $this->input->post('segment1');
		$min 	= $this->input->post('min');
		$max 	= $this->input->post('max');
		$rop 	= $this->input->post('rop');
		
		$data =$this->M_settingminmaxopm->save($itemcode, $min, $max, $rop, $induk);

		$this->session->set_flashdata('org', $org);
		$this->session->set_flashdata('route', $route);
		redirect(base_url('SettingMinMax/EditbyRoute/'));
	}

		//upload file ke tmp
	private function do_upload($filename)
		{
			if (!is_dir('./tmp')) {
				mkdir('./tmp', 0777, true);
				chmod('./tmp', 0777);
			}
	
			$config['upload_path']          = './tmp/';
			$config['allowed_types']        = 'csv|xls|xlxs';
			$config['max_size']             = 100;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['overwrite'] 			= TRUE;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload($filename))
			{
				$error = array('error' => $this->upload->display_errors());
				// $this->load->view('upload_form', $error);
				// echo "<pre>";
				// print_r($error);exit()
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				// $this->load->view('upload_success', $data);
				// echo "Berhasil";
			}
		}

	public function Import()
	{
	
		if (isset($_POST)) {
			$fileUpload = $_FILES['fileCsv']['tmp_name'];

			try {
				$inputFileName = str_replace(" ", "_",$fileUpload);
				$filetype = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($filetype);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($inputFileName);

				$readData = array();
				$tmpData = array();
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					$worksheetTitle = $worksheet->getTitle();
					$highestRow = $worksheet->getHighestRow();
					$highestColumn =  $worksheet->getHighestColumn();
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$nsColumn = ord($highestColumn) - 64;

					$index = 1;
					for ($row=3; $row <= $highestRow ; $row++) {
						$val = array();
						for ($col=1; $col <= $highestColumnIndex ; $col++) {
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val[]= $cell->getValue();
						}

						$tmpData = array(
							'SEGMENT1' => $val[0],
							'DESCRIPTION' => $val[1],
							'PRIMARY_UOM_CODE' => $val[2],
							'MIN' => $val[3],
							'MAX' => $val[4],
							'ROP' => $val[5],
							
						);

						// echo "<pre>";
						// print_r()
						//insert to db? by row
						array_push($readData, $tmpData);
						$this->M_settingminmaxopm->saveImport($tmpData['SEGMENT1'], $tmpData['MIN'], $tmpData['MAX'],
													 $tmpData['ROP']);
					}
				}

				echo json_encode($readData);
				// echo 1;
			} catch (Exception $e) {
				echo $e->getMessage();
			}

		}
	}
}