<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PekerjaMakanKhusus extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Setup/M_pekerjamakankhusus');
		$this->load->model('CateringManagement/Setup/M_menu');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'List Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data'] = $this->M_pekerjamakankhusus->getPekerjaMakanKhususAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['sayur'] = $this->M_menu->getSayur();
		$data['lauk_utama'] = $this->M_menu->getLaukUtama();
		$data['lauk_pendamping'] = $this->M_menu->getLaukPendamping();
		$data['buah'] = $this->M_menu->getBuah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$key = $this->input->Get('term');
		$data = $this->M_pekerjamakankhusus->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function simpan(){
		$pekerja = $this->input->post('pekerja');
		$sayur = $this->input->post('sayur');
		$lauk_utama = $this->input->post('lauk_utama');
		$lauk_pendamping = $this->input->post('lauk_pendamping');
		$buah = $this->input->post('buah');
		$sayur_pengganti = $this->input->post('sayur_pengganti');
		$lauk_utama_pengganti = $this->input->post('lauk_utama_pengganti');
		$lauk_pendamping_pengganti = $this->input->post('lauk_pendamping_pengganti');
		$buah_pengganti = $this->input->post('buah_pengganti');
		$pekerja_makan_khusus_id = $this->input->post('pekerja_makan_khusus_id');
		$tanggal_mulai = $this->input->post('tanggal_mulai');
		$tanggal_selesai = $this->input->post('tanggal_selesai');

		$khusus = $this->M_pekerjamakankhusus->getPekerjaMakanKhususByNoindSayurLaukUtamaLaukPendampingBuah($pekerja,$sayur,$lauk_utama,$lauk_pendamping,$buah);
		if (!empty($khusus)) {
			$data_update = array(
				'pengganti_sayur' => $sayur_pengganti,
				'pengganti_lauk_utama' => $lauk_utama_pengganti,
				'pengganti_lauk_pendamping' => $lauk_pendamping_pengganti,
				'pengganti_buah' => $buah_pengganti,
				'updated_by' => $this->session->user,
				'updated_date' => date('Y-m-d H:i:s'),
				'tanggal_mulai' => $tanggal_mulai,
				'tanggal_selesai' => $tanggal_selesai
			);
			$this->M_pekerjamakankhusus->updatePekerjaMakanKhususByPekerjaMenuKhususId($data_update,$khusus[0]['pekerja_menu_khusus_id']);
		}elseif ($pekerja_makan_khusus_id !== "0") {
			$data_update = array(
				'menu_sayur' => $sayur,
				'menu_lauk_utama' => $lauk_utama,
				'menu_lauk_pendamping' => $lauk_pendamping,
				'menu_buah' => $buah,
				'pengganti_sayur' => $sayur_pengganti,
				'pengganti_lauk_utama' => $lauk_utama_pengganti,
				'pengganti_lauk_pendamping' => $lauk_pendamping_pengganti,
				'pengganti_buah' => $buah_pengganti,
				'updated_by' => $this->session->user,
				'updated_date' => date('Y-m-d H:i:s'),
				'tanggal_mulai' => $tanggal_mulai,
				'tanggal_selesai' => $tanggal_selesai
			);
			$this->M_pekerjamakankhusus->updatePekerjaMakanKhususByPekerjaMenuKhususId($data_update,$pekerja_makan_khusus_id);
		}else{
			$data_insert = array(
				'noind' => $pekerja,
				'menu_sayur' => $sayur,
				'menu_lauk_utama' => $lauk_utama,
				'menu_lauk_pendamping' => $lauk_pendamping,
				'menu_buah' => $buah,
				'pengganti_sayur' => $sayur_pengganti,
				'pengganti_lauk_utama' => $lauk_utama_pengganti,
				'pengganti_lauk_pendamping' => $lauk_pendamping_pengganti,
				'pengganti_buah' => $buah_pengganti,
				'created_by' => $this->session->user,
				'created_date' => date('Y-m-d H:i:s'),
				'tanggal_mulai' => $tanggal_mulai,
				'tanggal_selesai' => $tanggal_selesai
			);
			$this->M_pekerjamakankhusus->insertPekerjaMakanKhusus($data_insert);
		}
	}

	public function edit(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['data'] = $this->M_pekerjamakankhusus->getPekerjaMakanKhususById($plaintext_string);

		$data['Title']			=	'Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['sayur'] = $this->M_menu->getSayur();
		$data['lauk_utama'] = $this->M_menu->getLaukUtama();
		$data['lauk_pendamping'] = $this->M_menu->getLaukPendamping();
		$data['buah'] = $this->M_menu->getBuah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function delete(){
		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_pekerjamakankhusus->deletePekerjaMakanKhususById($plaintext_string);

		$data_awal = $this->M_pekerjamakankhusus->getPekerjaMakanKhususAll();
		$data_akhir = array();
		if (!empty($data_awal)) {
			foreach ($data_awal as $key => $value) {
				$encrypted_string = $this->encrypt->encode($value['pekerja_menu_khusus_id']);
	    		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

				$data_akhir[$key]['action'] = "<a href=\"".base_url('CateringManagement/Setup/PekerjaMakanKhusus/edit?id='.$encrypted_string)."\" class=\"btn btn-info\"><span class=\"fa fa-pencil-square-o\"></span> Edit</a>
						<button class=\"btn btn-danger btn-CM-PekerjaMakanKhusus-Hapus\" data-id=\"".$encrypted_string."\"><span class=\"fa fa-trash\"></span> Hapus</button>";
				$data_akhir[$key]['pekerja'] = $value['noind'].' - '.$value['nama'];
				$data_akhir[$key]['menu'] = $value['menu_sayur'].' - '.$value['menu_lauk_utama'].' - '.$value['menu_lauk_pendamping'].' - '.$value['menu_buah'];
				$data_akhir[$key]['pengganti'] = $value['pengganti_sayur'].' - '.$value['pengganti_lauk_utama'].' - '.$value['pengganti_lauk_pendamping'].' - '.$value['pengganti_buah'];
				$data_akhir[$key]['tanggal_mulai'] = $value['tanggal_mulai'];
				$data_akhir[$key]['tanggal_selesai'] = $value['tanggal_selesai'];
				
			}
		}

		echo json_encode($data_akhir);
	}

	public function importExcel(){
		$user_id = $this->session->userid;

		$data['Title']			=	'Pekerja Makan Khusus';
		$data['Header']			=	'Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_import',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportData(){
		$isi = $this->input->post('txt-CM-PekerjaMakanKhusus-Export-Isi');
		$status = $this->input->post('slc-CM-PekerjaMakanKhusus-Export-Status');
		$lokasi = $this->input->post('slc-CM-PekerjaMakanKhusus-Export-Lokasi');

		if ($isi == "Isi") {
			if ($status == "Aktif") {
				$where_status = "(tanggal_selesai > current_date and tanggal_mulai < current_date)";
			}elseif ($status == "Non-Aktif") {
				$where_status = "(tanggal_selesai < current_date or tanggal_mulai > current_date)";
			}else{
				$where_status = "";
			}

			if ($lokasi == "Yogyakarta & Mlati") {
				$where_lokasi = "t3.fs_lokasi = '1'";
			}elseif ($lokasi == "Tuksono") {
				$where_lokasi = "t3.fs_lokasi = '2'";
			}else{
				$where_lokasi = "";
			}

			$data = $this->M_pekerjamakankhusus->getPekerjaMakanKhususByStatusLokasi($where_lokasi,$where_status);
		}else{
			$data = array();
		}

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();
		
		$worksheet->setCellValue('A1','pekerja_menu_khusus_id');
		$worksheet->setCellValue('B1','noind');
		$worksheet->setCellValue('C1','menu_sayur');
		$worksheet->setCellValue('D1','menu_lauk_utama');
		$worksheet->setCellValue('E1','menu_lauk_pendamping');
		$worksheet->setCellValue('F1','menu_buah');
		$worksheet->setCellValue('G1','pengganti_sayur');
		$worksheet->setCellValue('H1','pengganti_lauk_utama');
		$worksheet->setCellValue('I1','pengganti_lauk_pendamping');
		$worksheet->setCellValue('J1','pengganti_buah');
		$worksheet->setCellValue('K1','tanggal_mulai');
		$worksheet->setCellValue('L1','tanggal_selesai');
		
		$y_index = 2;
		if (isset($data) && !empty($data)) {
			foreach ($data as $key => $value) {
				$encrypted_string = $this->encrypt->encode($value['pekerja_menu_khusus_id']);
	    		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				$worksheet->setCellValue('A'.$y_index,$encrypted_string);
				$worksheet->setCellValue('B'.$y_index,$value['noind']);
				$worksheet->setCellValue('C'.$y_index,$value['menu_sayur']);
				$worksheet->setCellValue('D'.$y_index,$value['menu_lauk_utama']);
				$worksheet->setCellValue('E'.$y_index,$value['menu_lauk_pendamping']);
				$worksheet->setCellValue('F'.$y_index,$value['menu_buah']);
				$worksheet->setCellValue('G'.$y_index,$value['pengganti_sayur']);
				$worksheet->setCellValue('H'.$y_index,$value['pengganti_lauk_utama']);
				$worksheet->setCellValue('I'.$y_index,$value['pengganti_lauk_pendamping']);
				$worksheet->setCellValue('J'.$y_index,$value['pengganti_buah']);
				$worksheet->setCellValue('K'.$y_index,$value['tanggal_mulai']);
				$worksheet->setCellValue('L'.$y_index,$value['tanggal_selesai']);		
				$y_index++;
			}	
		}

		$worksheet->getProtection()->setPassword('catering');

		$worksheet->getProtection()->setSheet(true); //kunci 1 sheet
		$worksheet->getStyle('B2:L'.($y_index + 1000))->getProtection()->setlocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED); //membuka kunci cell range
		
		$filename ="CM_Pekerja_Makan_Khusus_".date('Y-m-d_H-i-s').".xls";
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	public function ImportData(){
		$filename = $_FILES['file']['name'];
        $waktu = date('Y-m-d_H-i-s');
        $filename = $waktu.str_replace(' ','_', $filename);
    	
    	$config['upload_path'] 		= './assets/upload/CateringManagement/';
        $config['file_name'] 		= $filename;
        $config['allowed_types'] 	= 'xls|xlsx';
        $config['max_size'] 		= 10000;
        $config['overwrite']		= TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if(! $this->upload->do_upload('file') ){
        	print_r($this->upload->data());
            echo $this->upload->display_errors();exit();
        }

        $this->load->library('excel');
        $inputFileName = $config['upload_path'].$filename;
        $inputFileType = $this->upload->data()['file_type'];
        
        try {
		    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		    $objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
		    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();

		for ($row = 2; $row <= $highestRow; $row++){ 
		    $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
		    $text = $rowData[0][1].$rowData[0][2].$rowData[0][3].$rowData[0][4].$rowData[0][5].$rowData[0][6].$rowData[0][7].$rowData[0][8].$rowData[0][9].$rowData[0][10].$rowData[0][11];
		    if (strlen($text) > 0) {
			    if (empty($rowData[0][0])) {
				    $insert = array(
				    	'noind'						=> $rowData[0][1],
						'menu_sayur'				=> $rowData[0][2],
						'menu_lauk_utama'			=> $rowData[0][3],
						'menu_lauk_pendamping'		=> $rowData[0][4],
						'menu_buah'					=> $rowData[0][5],
						'pengganti_sayur'			=> $rowData[0][6],
						'pengganti_lauk_utama'		=> $rowData[0][7],
						'pengganti_lauk_pendamping'	=> $rowData[0][8],
						'pengganti_buah'			=> $rowData[0][9],
						'created_by' 				=> $this->session->user,
						'created_date' 				=> date('Y-m-d H:i:s'),
						'tanggal_mulai'				=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][10])),
						'tanggal_selesai'			=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][11]))
				    );
				    $this->M_pekerjamakankhusus->insertPekerjaMakanKhusus($insert);
			    }else{
				    $decrypted_id = str_replace(array('-', '_', '~'), array('+', '/', '='), $rowData[0][0]);
					$decrypted_id = $this->encrypt->decode($decrypted_id);
			    	$update = array(
				    	'noind'						=> $rowData[0][1],
						'menu_sayur'				=> $rowData[0][2],
						'menu_lauk_utama'			=> $rowData[0][3],
						'menu_lauk_pendamping'		=> $rowData[0][4],
						'menu_buah'					=> $rowData[0][5],
						'pengganti_sayur'			=> $rowData[0][6],
						'pengganti_lauk_utama'		=> $rowData[0][7],
						'pengganti_lauk_pendamping'	=> $rowData[0][8],
						'pengganti_buah'			=> $rowData[0][9],
						'updated_by' 				=> $this->session->user,
						'updated_date' 				=> date('Y-m-d H:i:s'),
						'tanggal_mulai'				=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][10])),
						'tanggal_selesai'			=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][11]))
				    );
			    	$this->M_pekerjamakankhusus->updatePekerjaMakanKhususByPekerjaMenuKhususId($update,$decrypted_id);
			    }
		    }
		}
		redirect(base_url('CateringManagement/Setup/PekerjaMakanKhusus/ImportExcel'));
	}

} ?>