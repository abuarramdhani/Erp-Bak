<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PeriodicalMaintenance/M_monitoring');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Uraian Kerja';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		// $tanggal 	= $this->input->post('tglCek');

		// $data['mesin'] = $this->M_monitoring->getMesinFromDate($tanggal);


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Monitoring', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getMesinByDate()
	{
		$term	= $this->input->post('date');
		$tgl = str_replace('/', '-', $term);
		// echo $tgl; exit();
		$mesin = $this->M_monitoring->getMesinFromDate($tgl);


		echo '<option></option>';
		foreach ($mesin as $mach) {
			echo '<option value="' . $mach['NAMA_MESIN'] . '">' . $mach['NAMA_MESIN'] . '</option>';
		}
	}


	public function searchMon()
	{
		$tanggal 	= $this->input->post('tanggal');
		$tgl = str_replace('/', '-', $tanggal);
		$mesin 	= $this->input->post('mesin');
		$dataGET = $this->M_monitoring->getHeaderMon($tgl, $mesin);
		// echo "<pre>"; 
		// print_r($dataGET); exit();
		// pengelompokan data
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			if (!in_array($value['HEADER_MESIN'], $array_sudah)) {
				array_push($array_sudah, $value['HEADER_MESIN']);
				// if(strlen($value['HEADER']) == 0) {
				// 	$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN'], NULL);

				// } else {
				// 	$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN'], $value['HEADER']);

				// }

				$getBody = $this->M_monitoring->getDetailMon($tgl, $value['NAMA_MESIN'], $value['KONDISI_MESIN'], $value['HEADER_MESIN']);


				// echo "<pre>"; 
				// print_r($getBody);

				$array_terkelompok[$value['HEADER_MESIN']]['header'] = $value;
				$array_terkelompok[$value['HEADER_MESIN']]['body'] = $getBody;
			}
		}
		$data['value'] = $array_terkelompok;

		// echo "<pre>"; 
		// print_r($array_terkelompok); exit();

		$this->load->view('PeriodicalMaintenance/V_ResultMon', $data);
	}

	public function printForm()
	{
		// include_once APPPATH.'third_party/mpdf/mpdf.php';

		$tanggal 	= $this->input->post('tglCek');
		$tgl = str_replace('/', '-', $tanggal);
		$mesin 	= $this->input->post('mesinMon');

		$data['mesin'] = $mesin;
		$data['totalDurasi'] = $this->M_monitoring->getSumDurasi($tgl, $mesin);
		$data['sparepart'] = $this->M_monitoring->getDataSparepart($tgl, $mesin);;



		$datapdf = $this->M_monitoring->getDataMon($tgl, $mesin);

		// echo "<pre>";
		// print_r($data['totalDurasi']);
		// exit();

		$array_Resource = array();
		for ($i = 0; $i < sizeof($datapdf); $i++) {
			if ($datapdf[$i]['KONDISI_MESIN'] == null) {
				$alter[$i] = '';
			} else {
				$alter[$i] = $datapdf[$i]['KONDISI_MESIN'];
			}
			$array_Resource['KONDISI_MESIN'][$alter[$i]][$i] = $datapdf[$i]['SUB_HEADER'];
			// $array_Resource['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']][$i] = $datapdf[$i]['SUB_HEADER'];
			$array_Resource['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']][$i] = $datapdf[$i]['SUB_HEADER'];
		}
		// echo "<pre>";
		// exit();

		$array_pdf = array();
		$i = 0;
		foreach ($datapdf as $pdf) {

			// $array_pdf[$i]['PROSES'] = $pdf['PROSES'];
			$array_pdf[$i]['TYPE_MESIN'] = $pdf['TYPE_MESIN'];
			$array_pdf[$i]['PERIODE_CHECK'] = $pdf['PERIODE_CHECK'];
			$array_pdf[$i]['NAMA_MESIN'] = $pdf['NAMA_MESIN'];
			$array_pdf[$i]['KONDISI_MESIN'] = $pdf['KONDISI_MESIN'];
			$array_pdf[$i]['HEADER_MESIN'] = $pdf['HEADER_MESIN'];
			$array_pdf[$i]['SUB_HEADER'] = $pdf['SUB_HEADER'];
			$array_pdf[$i]['STANDAR'] = $pdf['STANDAR'];
			$array_pdf[$i]['PERIODE'] = $pdf['PERIODE'];
			$array_pdf[$i]['DURASI'] = $pdf['DURASI'];
			$array_pdf[$i]['KONDISI'] = $pdf['KONDISI'];
			$array_pdf[$i]['CATATAN'] = $pdf['CATATAN'];

			$array_pdf[$i]['SCHEDULE_DATE'] = $pdf['SCHEDULE_DATE'];
			$array_pdf[$i]['ACTUAL_DATE'] = $pdf['ACTUAL_DATE'];
			$array_pdf[$i]['STATUS'] = $pdf['STATUS'];
			$array_pdf[$i]['JAM_MULAI'] = $pdf['JAM_MULAI'];
			$array_pdf[$i]['JAM_SELESAI'] = $pdf['JAM_SELESAI'];
			$array_pdf[$i]['PELAKSANA'] = $pdf['PELAKSANA'];

			$i++;
		}

		// echo "<pre>";
		// print_r($array_pdf);
		// exit();
		// $data['tabel'] = $tabelBoM;
		// $data['merge'] = $merge;
		$data['arrayR'] = $array_Resource;
		// $data['arrayR2'] = $array_Resource2;
		$data['datapdf'] = $array_pdf;
		// echo "<pre>";
		// print_r(count($data['arrayR']['KONDISI_MESIN']['Mati']));
		// echo "<pre>";
		// print_r(count($data['arrayR']['KONDISI_MESIN']['Beroperasi']));

		// $data['pedidos'] = $arr;

		// $data['organization'] = $organization;

		// // print_r(); exit();
		// $dataRecipe = $this->input->post('recipe');
		// $urutan = $this->generate_Doc_No($data['user'], $kode, $organization, $dataRecipe, $alt);
		// $data['no_doc'] = $urutan;

		// echo "<pre>";
		// print_r($data);
		// exit();


		ob_start();
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		// $pdf = new mPDF('utf-8', 'f4', 0, '', 3, 3, 35, 3, 3, 3); //----- A5-L


		$margin_left = 3; // sizes are defines in millimetres
		$margin_right = 3;
		$margin_top = 35;
		$margin_bottom = 3;
		$header = 3;
		$footer = 3;
		$orientation = "P"; // can be P (Portrait) or L (Landscape)
		$pdf=new mPDF('utf-8',array(210,330), 0, '', $margin_left, $margin_right, $margin_top, $margin_bottom, $header, $footer, $orientation);

		// $pdf = new mPDF('utf-8', 'A4', 0, '', 3, 3, 35, 3, 3, 3); //----- A5-L

		$tglNama = date("d/m/Y-H:i:s");
		$filename = 'Periodical_Maintenance_' . $tglNama . '.pdf';
		$head = $this->load->view('PeriodicalMaintenance/V_CetakanHead', $data, true);
		$html = $this->load->view('PeriodicalMaintenance/V_Cetakan_DetailBackup', $data, true);
		$foot = $this->load->view('PeriodicalMaintenance/V_CetakanFoot', $data, true);

		ob_end_clean();
		$pdf->shrink_tables_to_fit = 1;
		$pdf->use_kwt = true; 
		$pdf->setHTMLHeader($head);
		$pdf->setHTMLFooter($foot);
		$pdf->WriteHTML($html);
		// $pdf->WriteHTML($foot);


		$pdf->Output($filename, 'I');
	}


	public function editSubMonitoring()
	{
		$tanggal 	= $this->input->post('tanggal');
		$tgl = str_replace('/', '-', $tanggal);
		$mesin 	= $this->input->post('mesin');
		$id = $this->input->post('id');
		$dataa = $this->M_monitoring->selectDataEditMon($tgl, $mesin, $id);

		// echo "<pre>";
		// print_r($dataa);
		// exit();

		if ($dataa[0]['PERIODE_CHECK'] == "2 Mingguan") {
			$opsi = '<option selected>2 Mingguan</option>
			<option>Tahunan</option>';
		} else {
			$opsi = '<option>2 Mingguan</option>
			<option selected>Tahunan</option>';
		}


		if ($dataa[0]['KONDISI'] == "OK") {
			$opsiKondisi = '<option selected>OK</option>
			<option>MULAI RUSAK</option>
			<option>RUSAK</option>
			<option>TIDAK ADA PERIODE PENGECEKAN</option>';
		} else if($dataa[0]['KONDISI'] == "MULAI RUSAK") {
			$opsiKondisi = '<option >OK</option>
			<option selected>MULAI RUSAK</option>
			<option>RUSAK</option>
			<option>TIDAK ADA PERIODE PENGECEKAN</option>';
		} else if($dataa[0]['KONDISI'] == "RUSAK") {
			$opsiKondisi = '<option >OK</option>
			<option>MULAI RUSAK</option>
			<option selected>RUSAK</option>
			<option>TIDAK ADA PERIODE PENGECEKAN</option>';
		} else if($dataa[0]['KONDISI'] == "TIDAK ADA PERIODE PENGECEKAN") {
			$opsiKondisi = '<option >OK</option>
			<option>MULAI RUSAK</option>
			<option>RUSAK</option>
			<option selected>TIDAK ADA PERIODE PENGECEKAN</option>';
		}

		$editMonitoring = '
			<div class="panel-body">                            
			<div class="col-md-3" style="text-align: right;"><label>Uraian Kerja</label></div>                                        
				<div class="col-md-9" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="subHeaderEditMon" name="subHeaderEditMon" value="' . $dataa[0]['SUB_HEADER'] . '" disabled /></div>
				<input type="hidden" name="idRowEditMon" id="idRowEditMon" value="' . $id . '"/>
			</div>
			<div class="panel-body">                            
				<div class="col-md-3" style="text-align: right;"><label>Standar</label></div>                                        
				<div class="col-md-9" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="standarEditMon" name="standarEditMon" value="' . $dataa[0]['STANDAR'] . '" disabled /></div>
			</div>
			<div class="panel-body">                            
			<div class="col-md-3" style="text-align: right;"><label>Periode</label></div>                                        
			<div class="col-md-9" style="text-align: left;">
			<select disabled id="periodeEditMon" name="periodeEditMon" class="form-control select2" style="width: 100%" data-placeholder="Periode" value="' . $dataa[0]['PERIODE_CHECK'] . '">
			<option></option>
			' . $opsi . '
			</select>
			</div>
			</div>
			<div class="panel-body">                            
				<div class="col-md-3" style="text-align: right;"><label>Durasi</label></div>                                        
				<div class="col-md-9" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="durasiEditMon" name="durasiEditMon" value="' . $dataa[0]['DURASI'] . '" /></div>
			</div>
			<div class="panel-body">                            
			<div class="col-md-3" style="text-align: right;"><label>Kondisi</label></div>                                        
			<div class="col-md-9" style="text-align: left;">
			<select id="kondisiEditMon" name="kondisiEditMon" class="form-control select2" style="width: 100%" data-placeholder="Kondisi" value="' . $dataa[0]['KONDISI'] . '">
			<option></option>
			' . $opsiKondisi . '
			</select>
			</div>
			</div>
			<div class="panel-body">                            
				<div class="col-md-3" style="text-align: right;"><label>Catatan</label></div>                                        
				<div class="col-md-9" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="catatanEditMon" name="catatanEditMon" value="' . $dataa[0]['CATATAN'] . '" /></div>
			</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button class="btn btn-success button-save-mon">Save</button></div>
			</div>';


		echo $editMonitoring;
	}

	public function updateSubMonitoring()
	{
		$id = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$tgl = str_replace('/', '-', $tanggal);
		$mesin 	= $this->input->post('mesin');


		$subHeader = $this->input->post('subHeader');
		$standar = $this->input->post('standar');
		$periode = $this->input->post('periode');
		$durasi = $this->input->post('durasi');
		$kondisi = $this->input->post('kondisi');
		$catatan = $this->input->post('catatan');


		$this->M_monitoring->updateSubMonitoring($tgl, $mesin, $id, $subHeader, $standar, $periode, $durasi, $kondisi, $catatan);


		// redirect(base_url('DbHandling/SetDataMaster'));
	}

	public function deleteSubMonitoring()
	{
		$id = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$tgl = str_replace('/', '-', $tanggal);
		$mesin 	= $this->input->post('mesin');
		$this->M_monitoring->deleteSubMonitoring($id, $tgl, $mesin);
	}

}
