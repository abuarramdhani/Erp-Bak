<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
  {
    parent::__construct();

	$this->load->library('General');
	$this->load->library('Log_Activity');

    $this->load->model('M_Index');
	$this->load->model('SystemAdministration/MainMenu/M_user');
	$this->load->model('ADMPelatihan/Pekerja/M_pekerja');

  	if($this->session->userdata('logged_in')!=TRUE) {
  		$this->load->helper('url');
  		// $this->load->helper('terbilang_helper');
  		$this->session->set_userdata('last_page', current_url());
  			  //redirect('index');
  		$this->session->set_userdata('Responsbility', 'some_value');
  	}
  	date_default_timezone_set('Asia/Jakarta');
  	$this->checkSession();
  }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Pekerja/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function data_pekerja()
	{
		$keluar 	= $this->input->get('rd_keluar');
		$pekerja 	= strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerja->getPekerja($pekerja,$keluar);

		echo json_encode($data);
	}

	public function data_pekerjaan()
	{
		$pekerja 	    = strtoupper($this->input->get('term'));
		$kd_pekerjaan = $this->input->get('kd_pekerjaan');
		$data = $this->M_pekerja->getkdPekerja($pekerja,$kd_pekerjaan);
		echo json_encode($data);
	}

	

	public function viewData()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$noind 					    = $this->input->post('slc_Pekerja');
		$keluar 				    = $this->input->post('rd_keluar');


		$pekerja 	        	= $this->M_pekerja->dataPekerja($noind,$keluar);
		$kontak 		        = $this->M_pekerja->kontakPekerja($noind);
		$pekerjaan          =$this->M_pekerja->getPekerjaan($noind);
		$data['training'] = $this->M_pekerja->training($noind);
		$data['keluar'] = $this->input->post('rd_keluar');


		if ($pekerja != null) {
			$kodesie 		= $pekerja[0]['kodesie'];
			$seksi 			= $this->M_pekerja->dataSeksi($kodesie);


			if ( $kontak == null )
			{
			$data['data'] 	= array(
									'photo' 	          => $pekerja[0]['photo'],
									'noind' 	          => $pekerja[0]['noind'],
									'nama' 		          => $pekerja[0]['nama'],
									'jabatan' 	        => $pekerja[0]['jabatanref'],
									'kerja'         => $pekerja[0]['kerja'],
									'kd_pekerjaan'      =>  $pekerjaan[0]['kd_pekerjaan'],
									'seksi' 	          => $seksi[0]['seksi'],
									'unit' 		          => $seksi[0]['unit'],
									'bidang' 	          => $seksi[0]['bidang'],
									'dept' 		          => $seksi[0]['dept']


								);
		}else{
		$data['data'] 	= array(
									'photo' 	          => $pekerja[0]['photo'],
									'noind' 	          => $pekerja[0]['noind'],
									'nama' 		          => $pekerja[0]['nama'],
									'jabatan' 	        => $pekerja[0]['jabatanref'],
									'kerja'         => $pekerja[0]['kerja'],
									'kd_pekerjaan'      =>  $pekerjaan[0]['kd_pekerjaan'],
									'seksi' 	          => $seksi[0]['seksi'],
									'unit' 		          => $seksi[0]['unit'],
									'bidang' 	          => $seksi[0]['bidang'],
									'dept' 		          => $seksi[0]['dept']

					
								);
		}


			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/Pekerja/V_Edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/Pekerja/V_Index',$data);
			$this->load->view('V_Footer',$data);

			print "<script type='text/javascript'>alert('Data yang Anda masukan tidak ditemukan. Mohon coba kembali');</script>";


	}



}

 public function pdf(){  

           	$noind 		= $this->input->get('noind');

		    $keluar 				    = $this->input->get('keluar');
		    $pekerja 	        	= $this->M_pekerja->dataPekerja($noind,$keluar);
		   // echo "<pre>";
		    //print_r($pekerja);
		    //die;
		   $kontak 		        = $this->M_pekerja->kontakPekerja($noind);
		   $pekerjaan          =$this->M_pekerja->getPekerjaan($noind);
		   $data['training'] = $this->M_pekerja->training($noind);
		
		 
		   $kodesie 		= $pekerja[0]['kodesie'];
			$seksi 			= $this->M_pekerja->dataSeksi($kodesie);
			$data['data'] 	= array(
									'photo' 	          => $pekerja[0]['photo'],
									'noind' 	          => $pekerja[0]['noind'],
									'nama' 		          => $pekerja[0]['nama'],
									'jabatan' 	        => $pekerja[0]['jabatanref'],
									'kerja'         => $pekerja[0]['kerja'],
									'kd_pekerjaan'      =>  $pekerjaan[0]['kd_pekerjaan'],
									'seksi' 	          => $seksi[0]['seksi'],
									'unit' 		          => $seksi[0]['unit'],
									'bidang' 	          => $seksi[0]['bidang'],
									'dept' 		          => $seksi[0]['dept']


								);

			$this->load->library('pdf');

			$pdf = $this->pdf->load();
			$pdf = new mPDF('','A4',0,'',10,5,10,5,0,0);
			$filename = 'Data Pekerja.pdf';


			$html = $this->load->view('ADMPelatihan/Pekerja/V_pdf', $data, true);

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
		    $pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
	   }



     public function excel(){
 
		$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
		
       	$noind 		= $this->input->get('noind');
	    $keluar 	= $this->input->get('keluar');
	    $pekerja 	= $this->M_pekerja->dataPekerja($noind,$keluar);
	    $kontak 	= $this->M_pekerja->kontakPekerja($noind);
	    $pekerjaan  = $this->M_pekerja->getPekerjaan($noind);
	    $training   = $this->M_pekerja->training($noind);
	   	$kodesie 	= $pekerja[0]['kodesie'];
		$seksi 		= $this->M_pekerja->dataSeksi($kodesie);
		$data1 		= array(
						'photo' 	    => $pekerja[0]['photo'],
						'noind' 	    => $pekerja[0]['noind'],
						'nama' 		    => $pekerja[0]['nama'],
						'jabatan' 	    => $pekerja[0]['jabatanref'],
						'kerja'         => $pekerja[0]['kerja'],
						'kd_pekerjaan'  => $pekerjaan[0]['kd_pekerjaan'],
						'seksi' 	    => $seksi[0]['seksi'],
						'unit' 		    => $seksi[0]['unit'],
						'bidang' 	    => $seksi[0]['bidang'],
						'dept' 		    => $seksi[0]['dept']
					);
		$objPHPExcel = new PHPExcel();

		$sheet = $objPHPExcel->getActiveSheet()->setTitle('Data Pribadi Pekerja'); // first sheet
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		// $logo = $data1['photo']; // Provide path to your logo file

		// make an dir ini bu yang untuk membuat direktori folder temp nya
		if(!is_dir(APPPATH."../assets/img/temp/")) {
			mkdir(APPPATH."../assets/img/temp/", 0777);
		}
		// temp image
		$from = $data1['photo'];
		$to = APPPATH."../assets/img/temp/temp.jpg";
		copy($from, $to);
		//
		// echo $to;die;
		$me = $objDrawing->setPath(APPPATH.'../assets/img/temp/temp.jpg'); // just file path from local, not from outside, example '../asstes/img/'
		$objDrawing->setOffsetX(24);    // setOffsetX works properly
		$objDrawing->setOffsetY(900);  //setOffsetY has no effect
		$objDrawing->setCoordinates('A3');
		$objDrawing->setHeight(151); // logo height
		$objDrawing->setWorksheet($sheet);
		$objPHPExcel->getProperties()->setCreator('KHS ERP')
             ->setTitle("Data Pribadi Pekerja")
             ->setSubject("Export Data Load")
             ->setDescription("Export Data Load")
             ->setKeywords("Export Data Load");

      	    // $objPHPExcel->getActiveSheet()->setTitle('Data Pribadi Pekerja');
 
        $objPHPExcel->setActiveSheetIndex(0);  
            
              // Set tiltle
    	$objPHPExcel->setActiveSheetIndex(0)
     				->setCellValue('A1', 'DATA PEKERJA')
	              	// ->setCellValue('A3', $objDrawing->setPath($to), PHPExcel_Cell_DataType::TYPE_STRING)
	 				->setCellValue('A12', 'Noind      ')
     				->setCellValue('A13', 'Nama       ')
     				->setCellValue('A14', 'Jabatan    ')
                    ->setCellValue('A15', 'Seksi      ')
                    ->setCellValue('A16', 'Pekerjaan  ')
                    ->setCellValue('A17', 'Unit       ')
                    ->setCellValue('A18', 'Bidang     ')
                    ->setCellValue('A19', 'Dept ')
                    ->setCellValue('C12', ':    ')
                    ->setCellValue('C13', ':    ')
                    ->setCellValue('C14', ':    ')
                    ->setCellValue('C15', ':    ')
                    ->setCellValue('C16', ':    ')
                    ->setCellValue('C17', ':    ')
                    ->setCellValue('C18', ':    ')
                    ->setCellValue('C19', ':    ');
        // merge cell
        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');	
        $objPHPExcel->getActiveSheet()->mergeCells('A12:B12');	
        $objPHPExcel->getActiveSheet()->mergeCells('A13:B13');	
        $objPHPExcel->getActiveSheet()->mergeCells('A14:B14');	
        $objPHPExcel->getActiveSheet()->mergeCells('A15:B15');	
        $objPHPExcel->getActiveSheet()->mergeCells('A16:B16');	
        $objPHPExcel->getActiveSheet()->mergeCells('A17:B17');	
        $objPHPExcel->getActiveSheet()->mergeCells('A18:B18');	
        $objPHPExcel->getActiveSheet()->mergeCells('A19:B19');	

        $objPHPExcel->getActiveSheet()->mergeCells('D12:H12');	
        $objPHPExcel->getActiveSheet()->mergeCells('D13:H13');	
        $objPHPExcel->getActiveSheet()->mergeCells('D14:H14');	
        $objPHPExcel->getActiveSheet()->mergeCells('D15:H15');	
        $objPHPExcel->getActiveSheet()->mergeCells('D16:H16');	
        $objPHPExcel->getActiveSheet()->mergeCells('D17:H17');	
        $objPHPExcel->getActiveSheet()->mergeCells('D18:H18');	
        $objPHPExcel->getActiveSheet()->mergeCells('D19:H19');	

     			// set value
 				
		$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValueExplicit('D12', $data1['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D13', ucwords(strtolower($data1['nama'])), PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D14', ucwords(strtolower($data1['jabatan'])), PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D15', ucwords(strtolower($data1['seksi'])), PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D16', ucwords(strtolower($data1['kerja'])), PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D17', ucwords(strtolower($data1['unit'])), PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D18', ucwords(strtolower($data1['bidang'])), PHPExcel_Cell_DataType::TYPE_STRING)
	              ->setCellValueExplicit('D19', ucwords(strtolower($data1['dept'])), PHPExcel_Cell_DataType::TYPE_STRING);

		$objPHPExcel->setActiveSheetIndex(0)
     				->setCellValue('A21', 'No')
	 				->setCellValue('B21', 'Pelatihan ')
     				->setCellValue('E21', 'Tanggal')
     				->setCellValue('F21', 'Waktu ')
                    ->setCellValue('G21', 'Ruang')
                    ->setCellValue('H21', 'Trainer');
        $objPHPExcel->getActiveSheet()->mergeCells('B21:D21');	

		$coor_x = 22; //coordinat x mulainya tabel
		$nomor = 1;
		foreach ($training as $key => $value) {//variabel yang digunakan untuk looping apa bu ? $training
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$coor_x,$nomor);		
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$coor_x,$value['training_name']);
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$coor_x.':D'.$coor_x);		
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$coor_x,date('d-m-Y', strtotime($value['date'])));		
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$coor_x,$value['waktu']);		
			// $objPHPExcel->getActiveSheet()->mergeCells('F'.$coor_x.':G'.$coor_x);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$coor_x,ucwords(strtolower($value['room'])));		
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$coor_x,trim(ucwords(strtolower($value['trainer_name']))));
			
			$coor_x ++;		
			$nomor ++;
		}	
    // die;

		//style
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('5');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('30');
				
					
	   	$objPHPExcel->getActiveSheet()->duplicateStyleArray( // ini buat border tabel A22:H.($coor_x -1)
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A21:H'.($coor_x -1)); 
		// $objPHPExcel->getActiveSheet()->duplicateStyleArray(
		// 	array(
		// 		'borders' => array(
		// 			'bottom' => array(
		// 				'style' => PHPExcel_Style_Border::BORDER_THIN)
		// 		)
		// 	),'A21:H21'); // ini nggak perlu kalo bordernya sama kaya yang di atas, yang di atasa sudah allborders
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ffff00')
					)
				),'A21:H21');
		$filename = urlencode("Data Pekerja".".xls"); // ini buat nama file hasil cetaknya
	       
	    header('Content-Type: application/vnd.ms-excel'); //mime type
	    header("Content-disposition: attachment; filename=\"".$filename."\""); //tell browser what's the file name
	    header('Cache-Control: max-age=0'); //no cache
	    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
	    $objWriter->save('php://output');
		
	    //redirect('ADMPelatihan/DataPekerja/viewData');

    }


	
};
