<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_Upload extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('Excel');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CheckPPHPusatDanCabang/M_uploadpph');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	function checkSession()
	{
		if($this->session->is_logged){
				
		}else{
			redirect();
		}
	}

	public function index($error = null)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Upload';
		$data['SubMenuOne'] = '';
		$data['errorupd'] = $error;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CheckPPhPusatDanCabang/Upload/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}


	function proccess()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		// if(!is_dir('./assets/upload_pph'))
		// 	{
		// 		mkdir('./assets/upload_pph', 0777, true);
		// 		chmod('./assets/upload_pph', 0777);
		// 	}

		if(isset($_FILES['file_pph']['name']) &&  $_FILES['file_pph']['name'] != ''):
			 $valid_extension = array('xls','xlsx','ods');
			 $file_data = explode('.', $_FILES['file_pph']['name']);
			 $file_extension = end($file_data);
			 $file_name = $file_data[0];
			 $array_error = array();
			 if(in_array($file_extension, $valid_extension))
			 {
			 	$excelReader 	= PHPExcel_IOFactory::createReaderForFile($_FILES['file_pph']['tmp_name']);
				$excelObj  		= $excelReader->load($_FILES['file_pph']['tmp_name']);
				$worksheet 		= $excelObj->getSheet(0);
				$lastRow 		= $worksheet->getHighestRow();
				$lastCol 		= $worksheet->getHighestColumn();
				$lastIndexCol 	= PHPExcel_Cell::columnIndexFromString($lastCol);

				$getUrut = $this->M_uploadpph->getBatch();
				$batch 	 = str_pad($getUrut[0]['batch_num']+1, 3, 0 , STR_PAD_LEFT);

				for ($i=0; $i <= $lastRow ; $i++) { 
					$jenis_pph = strtoupper(str_replace(' ', '', $worksheet->getCell('A'.$i)->getValue()));
					$jns = $jenis_pph ? substr($jenis_pph, 0,3) : '';
					if ($jns == 'PPH') {
					$jenispph[$i]['jenis_pph']	 = $worksheet->getCell('A'.$i)->getValue();
					$jenispph[$i]['tarif_pph'] 	 = $worksheet->getCell('B'.$i)->getValue();
					$jenispph[$i]['no_npwp'] 		 = $worksheet->getCell('C'.$i)->getValue();
					$jenispph[$i]['nama_vendor']   = $worksheet->getCell('D'.$i)->getValue();
					$jenispph[$i]['nama_npwp'] 	 = $worksheet->getCell('E'.$i)->getValue();
					$jenispph[$i]['alamat_npwp']   = $worksheet->getCell('F'.$i)->getValue();
					$jenispph[$i]['no_invoice'] 	 = $worksheet->getCell('G'.$i)->getValue();
					$jenispph[$i]['tgl_transaksi'] = $worksheet->getCell('H'.$i)->getValue();
					$jenispph[$i]['bank'] 		 = $worksheet->getCell('I'.$i)->getValue();
					$jenispph[$i]['currency'] 	 = $worksheet->getCell('J'.$i)->getValue();
					$jenispph[$i]['dpp'] 			 = $worksheet->getCell('K'.$i)->getValue();
					$jenispph[$i]['pph'] 			 = $worksheet->getCell('L'.$i)->getValue();
					$jenispph[$i]['jenis_jasa'] 	 = $worksheet->getCell('M'.$i)->getValue();
					$jenispph[$i]['lokasi'] 		 = $worksheet->getCell('N'.$i)->getValue();
					$jenispph[$i]['tgl_invoice']   = $worksheet->getCell('O'.$i)->getValue();

					$jenispph[$i]['creation_date'] = date('Y-m-d H:i:s');
					$jenispph[$i]['created_by'] = $user_id;
					$jenispph[$i]['update_date'] = date('Y-m-d H:i:s');
					$jenispph[$i]['update_by'] = $user_id;
					$jenispph[$i]['batch_num'] = $batch;
					$jenispph[$i]['tgl_upload'] = date('Y-m-d H:i:s');
					$jenispph[$i]['arsip'] = 0;
					$jenispph[$i]['nama_file'] = $file_name;

					$checkexist = $this->M_uploadpph->checkVendorInvoice($jenispph[$i]['nama_vendor'], $jenispph[$i]['no_invoice']);
					if ($checkexist > 0) {
						array_push($array_error, $jenispph[$i]);
					}
					
					}
				}
			 }

			 foreach ($jenispph as $key => $value) {
			 	$this->M_uploadpph->saveData($value);
			 }
			 // echo "<pre>";
			 // print_r($jenispph);
			 // exit();
		endif;

		if ($array_error) {
			$this->index($array_error);
		}else{
			redirect('AccountPayables/CheckPPhPusatDanCabang/List');
		}
	}


}