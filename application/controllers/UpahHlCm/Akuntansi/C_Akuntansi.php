<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Akuntansi extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('upload');
		$this->load->library('Excel_reader');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
		$this->load->model('UpahHlCm/M_akuntansi');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

    public function index(){
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['rekap']	= $this->M_akuntansi->getData();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/Akuntansi/V_Index',$data);
		$this->load->view('V_Footer',$data);
    }

    function importData(){

    	$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/Akuntansi/V_Import',$data);
		$this->load->view('V_Footer',$data);
    }

    function deleteRekap(){
    	$periode = $this->input->post('periode');
        $this->M_akuntansi->deleteRekap($periode);
    }


    function getDetail($periode){
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';
        
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['detail_rekap']   = $this->M_akuntansi->getDetail($periode);
        $data['periode']        = $periode;
        // echo "<pre>";
        // print_r($data['detail_rekap']);exit();
        
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('UpahHlCm/Akuntansi/V_Detail',$data);
        $this->load->view('V_Footer',$data);
    }

    function do_import(){
    	$filename = $_FILES['file']['name'];
        $waktu = date('Y-m-d_H-i-s');
        $filename = $waktu.str_replace(' ','_', $filename);
    	// echo $filename;exit();
    	$config['upload_path'] = './assets/upload/RekapPresensiHLCM/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $filename;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
        $config['overwrite']            = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);

         if(! $this->upload->do_upload('file') ){
            echo $this->upload->display_errors();exit();
        }

        $periode = "";
        if(strpos($filename, 'Januari') !== false){
        	$periode = date('Y').'-01-01';
        }else if (strpos($filename, 'Februari') !== false) {
        	$periode = date('Y').'-02-01';
        }else if (strpos($filename, 'Maret') !== false) {
        	$periode = date('Y').'-03-01';
        }else if (strpos($filename, 'April') !== false) {
        	$periode = date('Y').'-04-01';
        }else if (strpos($filename, 'Mei') !== false) {
        	$periode = date('Y').'-05-01';
        }else if (strpos($filename, 'Juni') !== false) {
        	$periode = date('Y').'-06-01';
        }else if (strpos($filename, 'Juli') !== false) {
        	$periode = date('Y').'-07-01';
        }else if (strpos($filename, 'Agustus') !== false) {
        	$periode = date('Y').'-08-01';
        }else if (strpos($filename, 'September') !== false) {
        	$periode = date('Y').'-09-01';
        }else if (strpos($filename, 'Oktober') !== false) {
        	$periode = date('Y').'-10-01';
        }else if (strpos($filename, 'November') !== false) {
        	$periode = date('Y').'-11-01';
        }else if (strpos($filename, 'Desember') !== false) {
            $periode = date('Y').'-12-01';
        }
        else{
        	$periode = '0000-00-00';
        }

		$media = $this->upload->data('file');
        // echo $media;exit();


	
        $inputFileName = './assets/upload/RekapPresensiHLCM/'.$filename;
        // echo $inputFileName;exit();

        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            // echo $highestColumn;exit();

            for ($row = 5; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                $data_import					= array();

                $data_import['noind'] 								= $rowData[0][1];
                $data_import['nama'] 								= $rowData[0][2];
                $data_import['lokasi'] 								= $rowData[0][3];
				$data_import['status'] 								= $rowData[0][4];
				$data_import['proses_komponen_gaji_pokok'] 			= $rowData[0][5];
                $data_import['proses_komponen_lembur'] 				= $rowData[0][6];
				$data_import['proses_komponen_uang_makan'] 			= $rowData[0][7];
				$data_import['proses_komponen_uang_makan_puasa'] 	= $rowData[0][8];
                $data_import['tambahan_komponen_gaji_pokok'] 		= $rowData[0][9];
				$data_import['tambahan_komponen_lembur'] 			= $rowData[0][10];
				$data_import['tambahan_komponen_uang_makan'] 		= $rowData[0][11];
                $data_import['potongan_komponen_gaji_pokok'] 		= $rowData[0][12];
				$data_import['potongan_komponen_lembur'] 			= $rowData[0][13];
				$data_import['potongan_komponen_uang_makan'] 		= $rowData[0][14];

				  	// echo "<pre>";
   				// 	print_r($data_import);

                $check_data             = $this->M_akuntansi->checkDataImport($data_import['noind'],$periode);
                $check_data_history     = $this->M_akuntansi->checkDataImportHistory($data_import['noind'],$periode);
                // echo $check_data;
                $insert_import                                      = array();
                    $insert_import = array(
                    'noind'                                         => $data_import['noind'],
                    'periode'                                       => $periode,
                    'status'                                        => $data_import['status'],
                    'lokasi_kerja'                                  => $data_import['lokasi'],
                    'proses_komponen_gaji_pokok'                    => $data_import['proses_komponen_gaji_pokok'],
                    'proses_komponen_lembur'                        => $data_import['proses_komponen_lembur'],
                    'proses_komponen_uang_makan'                    => $data_import['proses_komponen_uang_makan'],
                    'proses_komponen_uang_makan_puasa'              => $data_import['proses_komponen_uang_makan_puasa'],
                    'tambahan_komponen_gaji_pokok'                  => $data_import['tambahan_komponen_gaji_pokok'],
                    'tambahan_komponen_lembur'                      => $data_import['tambahan_komponen_lembur'],
                    'tambahan_komponen_uang_makan'                  => $data_import['tambahan_komponen_uang_makan'],
                    'potongan_komponen_gaji_pokok'                  => $data_import['potongan_komponen_gaji_pokok'],
                    'potongan_komponen_lembur'                      => $data_import['potongan_komponen_lembur'],
                    'potongan_komponen_uang_makan'                  => $data_import['potongan_komponen_uang_makan'],
                    'nama'                                          => $data_import['nama']
                    );

                if($check_data < 1){                 
                 $insert = $this->M_akuntansi->insertRecord($insert_import);
                }

                //table history
                if($check_data_history < 1 ){
                  $insertHistory = $this->M_akuntansi->insertRecordHistory($insert_import);
                }

                 
                 
				
			}

			// exit();
   		 
   		 redirect('UpahHlCm/Akuntansi');
	}
}