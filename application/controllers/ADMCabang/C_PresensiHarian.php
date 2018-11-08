<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
set_time_limit(0);
/**
 * 
 */
class C_PresensiHarian extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ADMCabang/M_presensiharian');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Presensi Harian';
		$data['Menu'] = 'Lihat Presensi Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensiharian->getSeksiByKodesie($kodesie);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/Presensi/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportExcel(){
		$this->load->library('excel');

		$kodesie = $this->session->kodesie;
		$pekerja = $this->M_presensiharian->getPekerjaByKodesie($kodesie);
		$seksi = $this->M_presensiharian->getSeksiByKodesie($kodesie);
		$tanggal = $this->input->post('txtPeriodePresensiHarian');
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,1,'Data Presensi');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'Kodesie');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'Seksi');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,4,'Tanggal');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,2,': '.$seksi['0']['kodesie']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,3,': '.$seksi['0']['seksi']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,4,': '.$tanggal);
		
		$i = 6;
		foreach ($pekerja as $val) {
			$i = $i+1;
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,'Noind');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$val['noind']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+1,'Nama');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+1,$val['nama']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+2,'seksi');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+2,$seksi['0']['seksi']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+3,'Tanggal');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+3,'Shift');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+3,'Point');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$i+3,'Waktu');

			$i = $i+4;
			$shift = $this->M_presensiharian->getShiftByNoind($val['noind'],$tanggal);
			foreach ($shift as $key) {
				$presensi = $this->M_presensiharian->getPresensiByNoind($val['noind'],$key['tanggal']);
				$tim = $this->M_presensiharian->getTIMByNoind($val['noind'],$key['tanggal']);
				$ket = $this->M_presensiharian->getKeteranganByNoind($val['noind'],$key['tanggal']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$key['tgl']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$key['shift']);
				if (!empty($tim)) {
					foreach ($tim as $valTim) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$valTim['point']);
					}
				}
				if (!empty($presensi)) {
					$j = 3;
					foreach ($presensi as $waktu) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$waktu['waktu']);
						$j++;
					}
					foreach ($ket as $keterangan) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$keterangan['keterangan']);
						$j++;
					}
				}else{
					$j = 3;
					foreach ($ket as $keterangan) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$keterangan['keterangan']);
						$j++;
					}
				}
				$i++;
			}
		}

		$filename ='Daftar Hadir '.$tanggal.'_'.$seksi['0']['seksi'].'.ods';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
}
?>