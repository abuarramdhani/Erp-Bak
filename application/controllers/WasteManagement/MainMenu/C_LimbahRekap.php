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
			redirect('');
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
		$data['loc'] = $this->M_limbahrekap->getLokasi();
		
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahRekap/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Excel(){
		
		$periode = $this->input->post('txtPeriodeRekap');
		$jenisLimbah = $this->input->post('slcJenisLimbahRekap');
		$kodeSeksi = $this->input->post('slcSeksiAsalLimbahRekap');
		$lokasi = $this->input->post('slclokasiLimbahRekap');

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
		$loc = "";
		if (isset($lokasi) and !empty($lokasi)) {
			foreach ($lokasi as $key) {
				if ($loc == "") {
					$loc = "'".$key."'";
				}else{
					$loc .= ",'".$key."'";
				}
			}
			$loc = "and limkir.lokasi_kerja in($loc)";
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

		$data = $this->M_limbahrekap->getExportAll($tglAwal,$tglAkhir,$limbah,$seksi,$loc);

		$this->load->library('excel');
		
		$this->excel->setActiveSheetIndex(0);

		$this->excel->getActiveSheet()->setTitle('REKAP');
		$this->excel->getActiveSheet()->setCellValue('A1', 'KODE LIMBAH');
		$this->excel->getActiveSheet()->setCellValue('B1', 'TANGGAL DIHASILKAN/DITERIMA');
		$this->excel->getActiveSheet()->setCellValue('C1', 'MASA SIMPAN (HARI)');
		$this->excel->getActiveSheet()->setCellValue('D1', 'TPS');
		$this->excel->getActiveSheet()->setCellValue('E1', 'SUMBER LIMBAH');
		$this->excel->getActiveSheet()->setCellValue('F1', 'KODE MANIFEST');
		$this->excel->getActiveSheet()->setCellValue('G1', 'NAMA PENGHASIL/PENGIRIM');
		$this->excel->getActiveSheet()->setCellValue('H1', 'JUMLAH (TON)');
		$this->excel->getActiveSheet()->setCellValue('I1', 'CATATAN');
		$this->excel->getActiveSheet()->setCellValue('J1', 'LOKASI KERJA');

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);


		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
		$border = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_style_border::BORDER_THIN
				)
			)
		);
		$this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getDefaultStyle()->applyFromArray($style);
		$a = 2;
		foreach ($data as $row) {
			$this->excel->getActiveSheet()->setCellValue('A'.$a, $row['kode_limbah']);
			$this->excel->getActiveSheet()->setCellValue('B'.$a, $row['tanggal_dihasilkan']);
			$this->excel->getActiveSheet()->setCellValue('C'.$a, $row['masa_simpan']);
			$this->excel->getActiveSheet()->setCellValue('D'.$a, $row['tps']);
			$this->excel->getActiveSheet()->setCellValue('E'.$a, $row['sumber']);
			$this->excel->getActiveSheet()->setCellValue('F'.$a, $row['kode_manifest']);
			$this->excel->getActiveSheet()->setCellValue('G'.$a, $row['pengirim_nama']);
			$this->excel->getActiveSheet()->setCellValue('H'.$a, $row['jumlah']);
			$this->excel->getActiveSheet()->setCellValue('I'.$a, $row['catatan']);
			$this->excel->getActiveSheet()->setCellValue('J'.$a, $row['noind_location']);
			$a++;
		}
		$a -= 1;
		$this->excel->getActiveSheet()->getStyle('A1:J'.$a)->applyFromArray($border);
		$filename ='SIMPLE.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
}

?>