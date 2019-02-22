<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_LimbahRekap extends CI_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_limbahrekap');

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

		$data['Title'] = 'Rekap Limbah';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Rekap Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_limbahrekap->getSeksi();
		$data['limbah'] = $this->M_limbahrekap->getLimbah();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahRekap/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Excel(){
		
		$periode = $this->input->post('txtPeriodeRekap');
		$jenisLimbah = $this->input->post('slcJenisLimbahRekap');
		$kodeSeksi = $this->input->post('slcSeksiAsalLimbahRekap');

		$prd = explode(" - ", $periode);
		$tglAwal = $prd[0];
		$tglAkhir = $prd[1];
		$limbah = "";
		if (isset($jenisLimbah) and !empty($jenisLimbah)) {
			foreach ($jenisLimbah as $key) {
				if ($limbah == "") {
					$limbah = "'".$key."'";
				}else{
					$limbah .= ",'".$key."'";
				}
			}
			$limbah = "and limkir.id_jenis_limbah in($limbah)";
		}
		$seksi = "";
		if (isset($kodeSeksi) and !empty($kodeSeksi)) {
			foreach ($kodeSeksi as $key) {
				if ($seksi == "") {
					$seksi = "'".$key."'";
				}else{
					$seksi .= ",'".$key."'";
				}
			}
			$seksi = "and limkir.kodesie_kirim in($seksi)";
		}

		$data = $this->M_limbahrekap->getDataExport($tglAwal,$tglAkhir,$limbah,$seksi);

		$this->load->library('excel');

		$this->excel->getActiveSheet()->setCellValue('A1','No');
		$this->excel->getActiveSheet()->setCellValue('B1','Jenis Limbah');
		$this->excel->getActiveSheet()->setCellValue('C1','Tanggal Kirim');
		$this->excel->getActiveSheet()->setCellValue('D1','Waktu Kirim');
		$this->excel->getActiveSheet()->setCellValue('E1','Pengirim');
		$this->excel->getActiveSheet()->setCellValue('F1','Seksi Asal Limbah');
		$this->excel->getActiveSheet()->setCellValue('G1','Bocor');
		$this->excel->getActiveSheet()->setCellValue('H1','Jumlah');
		$this->excel->getActiveSheet()->setCellValue('I1','Berat(Kg)');
		$this->excel->getActiveSheet()->setCellValue('J1','keterangan');

		$angka = 1;
		foreach ($data as $key) {
			$this->excel->getActiveSheet()->setCellValue('A'.($angka+1),$angka);
			$this->excel->getActiveSheet()->setCellValue('B'.($angka+1),$key['jenis']);
			$this->excel->getActiveSheet()->setCellValue('C'.($angka+1),$key['tanggal']);
			$this->excel->getActiveSheet()->setCellValue('D'.($angka+1),$key['waktu']);
			$this->excel->getActiveSheet()->setCellValue('E'.($angka+1),$key['pengirim']);
			$this->excel->getActiveSheet()->setCellValue('F'.($angka+1),$key['section_name']);
			$this->excel->getActiveSheet()->setCellValue('G'.($angka+1),$key['bocor']);
			$this->excel->getActiveSheet()->setCellValue('H'.($angka+1),$key['jumlah']);
			$this->excel->getActiveSheet()->setCellValue('I'.($angka+1),$key['berat']);
			$this->excel->getActiveSheet()->setCellValue('J'.($angka+1),$key['keterangan']);

			$angka++;
		}

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('40');
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('10');
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth('50');

		$filename ='Limbah'.$periode.'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
}

?>