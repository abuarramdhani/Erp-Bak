<?php 
Defined('BASEPATH') or exit('No Direct Script Acces Allowed');
/**
 * 
 */
date_default_timezone_set('Asia/Jakarta');
class C_ImportNilai extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('JurnalPenilaian/M_importnilai');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Import Nilai';
		$data['Menu'] = 'import data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/V_importnilai',$data);
		$this->load->view('V_Footer',$data);
	}

	public function GetData(){
		$user = $this->session->user;
		$gpTahun = $this->input->post('txtTahunGP');
		$fileName = 'GP_'.$gpTahun.'_date_'.date('Y_m_d').'_time_'.date('His');

		$config['upload_path'] = 'assets/upload/ImportNilaiGP';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv|odf';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

        if (! $this->upload->do_upload('txtFileGP')) {
        	$error = $this->upload->display_errors();
        	echo "Error :".$error;
        }else{
        	$media	= $this->upload->data();
        	$inputFileName 	= 'assets/upload/ImportNilaiGP/'.$media['file_name'];

        	 try{
                $inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
                $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel    = $objReader->load($inputFileName);
            }catch(Exception $e){
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet          = $objPHPExcel->getSheet(0);
            $highestRow     = $sheet->getHighestRow();
            $highestColumn  = $sheet->getHighestColumn();
            $j = 0;
            for ($i=2; $i <= $highestRow; $i++) { 
            	$arrData = $sheet->rangeToArray('A'.$i.':C'.$i);

            	if (!empty($arrData['0']['0']) and !empty($arrData['0']['1']) and !empty($arrData['0']['2'])) {
            		$arrCek = array(
	            		'noind' => $arrData['0']['0'],
	            		'tahun' => $gpTahun
	            	);
            		$cek = $this->M_importnilai->getNilai($arrCek);
            		
            		$insert[$j] = array(
		            		'noind' 		=> $arrData['0']['0'],
		            		'nama' 			=> $arrData['0']['1'],
		            		'tahun' 		=> $gpTahun,
		            		'gp' 			=> $arrData['0']['2'],
		            		'created_by' 	=> $user
		            	);
            		if ($cek == '0') {
		            	$this->M_importnilai->insertNilai($insert[$j]);
            		}else{
            			
		            	$where = array(
		            		'noind' => $arrData['0']['0'],
		            		'tahun' => $gpTahun
		            	);
		            	$this->M_importnilai->updateNilai($insert[$j],$where);
            		}
            		
	            	$data['table'][$j] = $insert[$j];
	            	$j++;
            	}
            	
            }

	        $user_id = $this->session->userid;

			$data['Title'] = 'Import Nilai';
			$data['Menu'] = 'import data';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('JurnalPenilaian/V_importnilai',$data);
			$this->load->view('V_Footer',$data);



        }
	}
}
?>