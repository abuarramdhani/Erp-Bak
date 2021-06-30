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
		$this->load->model('PeriodicalMaintenance/M_approval');


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

		$data['Title'] = 'Lihat Hasil Preventive';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		
		$admin = ['a'=>'T0015' , 'b'=>'B0847', 'c'=>'B0655', 'd'=>'B0908']; 
		if (empty(array_search($this->session->user, $admin))) {
			unset($data['UserMenu'][0]);
			unset($data['UserMenu'][1]);
			unset($data['UserMenu'][2]);
		}

		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['nodoc'] = $this->M_monitoring->getNoDocMPA();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Monitoring', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getNoDocByBetween(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		// echo $from; exit;
		echo '<option></option>';
		$data = $this->M_monitoring->getNoDocMPABetween($from, $to);
		foreach ($data as $mach) {
			echo '<option value="' . $mach['DOCUMENT_NUMBER'] . '">' . $mach['DOCUMENT_NUMBER'] . '-' . $mach['NAMA_MESIN'] . '</option>';
		}
	}

	public function getMesinByDate()
	{
		$term	= $this->input->post('date');
		$tgl = str_replace('/', '-', $term);
		$mesin = $this->M_monitoring->getMesinFromDate($tgl);

		echo '<option></option>';
		foreach ($mesin as $mach) {
			echo '<option value="' . $mach['NAMA_MESIN'] . '">' . $mach['NAMA_MESIN'] . '</option>';
		}
	}


	public function searchMon()
	{
		$nodoc 	= $this->input->post('nodoc');

		$dataGET = $this->M_monitoring->getHeaderMon($nodoc);
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			// if (!in_array($value['HEADER_MESIN'], $array_sudah)) {
			// 	array_push($array_sudah, $value['HEADER_MESIN']);

			// 	$getBody = $this->M_monitoring->getDetailMon($nodoc, $value['NAMA_MESIN'], $value['KONDISI_MESIN'], $value['HEADER_MESIN']);

			// 	$array_terkelompok[$value['HEADER_MESIN']]['header'] = $value;
			// 	$array_terkelompok[$value['HEADER_MESIN']]['body'] = $getBody;
			// }
			if (!in_array($value['KONDISI_MESIN'], $array_sudah)) {
				array_push($array_sudah, $value['KONDISI_MESIN']);

				$getBody = $this->M_monitoring->getDetailMon($nodoc, $value['NAMA_MESIN'], $value['KONDISI_MESIN']);

				$array_terkelompok[$value['KONDISI_MESIN']]['header'] = $value;
				$array_terkelompok[$value['KONDISI_MESIN']]['body'] = $getBody;
			}
		}
		$data['value'] = $array_terkelompok;
		$data['top'] = $this->M_monitoring->getDataHeader($nodoc);
		$data['footer'] = $this->M_monitoring->getDataFooter($nodoc);

		// echo "<pre>"; 
		// print_r($data); exit();

		$this->load->view('PeriodicalMaintenance/V_ResultMon', $data);
	}

	public function printForm()
	{
		$nodoc 	= $this->input->post('nodocMPA');
		
		$data['totalDurasi'] = $this->M_monitoring->getSumDurasi($nodoc);
		$data['sparepart'] = $this->M_monitoring->getDataSparepart($nodoc);
		$data['header'] = $this->M_monitoring->getDataHeader($nodoc);

		$datapdf = $this->M_monitoring->getDataMon($nodoc);

		$data['gambar'] = $this->M_monitoring->getDataGambar($datapdf[0]['NAMA_MESIN']);

		// echo "<pre>"; 
		// print_r($datapdf); exit();

		$array_Resource = array();
		for ($i = 0; $i < sizeof($datapdf); $i++) {
			if ($datapdf[$i]['KONDISI_MESIN'] == null) {
				$alter[$i] = '';
			} else {
				$alter[$i] = $datapdf[$i]['KONDISI_MESIN'];
			}
			if ($datapdf[$i]['HEADER_MESIN'] == null) {
				$altar[$i] = '';
			} else {
				$altar[$i] = $datapdf[$i]['HEADER_MESIN'];
			}
			$array_Resource['KONDISI_MESIN'][$alter[$i]][$i] = $datapdf[$i]['SUB_HEADER'];
			// $array_Resource['HEADER_MESIN'][$altar[$i]][$i] = $datapdf[$i]['SUB_HEADER'];
			$array_Resource['HEADER_MESIN'][$alter[$i]][$i] = $datapdf[$i]['HEADER_MESIN'];

		}

		$array_pdf = array();
		$i = 0;
		foreach ($datapdf as $pdf) {
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

			$array_pdf[$i]['REQUEST_BY'] = $pdf['REQUEST_BY'];
			$array_pdf[$i]['REQUEST_BY_NAME'] = $this->M_approval->getNama( $pdf['REQUEST_BY']);
			$array_pdf[$i]['CREATION_DATE'] = $pdf['CREATION_DATE'];
			$array_pdf[$i]['REQUEST_TO'] = $pdf['REQUEST_TO'];
			$array_pdf[$i]['REQUEST_TO_2'] = $pdf['REQUEST_TO_2'];
			$array_pdf[$i]['APPROVED_BY'] = $pdf['APPROVED_BY'];
			$array_pdf[$i]['APPROVED_BY_NAME'] = $this->M_approval->getNama( $pdf['REQUEST_TO']);
			$array_pdf[$i]['APPROVED_DATE'] = $pdf['APPROVED_DATE'];
			$array_pdf[$i]['APPROVED_BY_2'] = $pdf['APPROVED_BY_2'];
			$array_pdf[$i]['APPROVED_BY_2_NAME'] = $this->M_approval->getNama( $pdf['REQUEST_TO_2']);
			$array_pdf[$i]['APPROVED_DATE_2'] = $pdf['APPROVED_DATE_2'];
			$array_pdf[$i]['DOCUMENT_NUMBER'] = $pdf['DOCUMENT_NUMBER'];

			$array_pdf[$i]['CATATAN_TEMUAN'] = $pdf['CATATAN_TEMUAN'];


			$i++;
		}

		$data['arrayR'] = $array_Resource;
		$data['datapdf'] = $array_pdf;

		// echo "<pre>"; 
		// print_r($data['arrayR']); exit();

		ob_start();
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();

		$margin_left = 3; // sizes are defines in millimetres
		$margin_right = 3;
		$margin_top = 40;
		$margin_bottom = 100;
		$header = 3;
		$footer = 3;
		$orientation = "P"; // can be P (Portrait) or L (Landscape)
		$pdf=new mPDF('utf-8',array(210,330), 0, '', $margin_left, $margin_right, $margin_top, $margin_bottom, $header, $footer, $orientation);

		$tglNama = date("d/m/Y-H:i:s");
		$filename = 'Periodical_Maintenance_' . $tglNama . '.pdf';
		$head = $this->load->view('PeriodicalMaintenance/V_CetakanHead', $data, true);
		$html = $this->load->view('PeriodicalMaintenance/V_Cetakan_DetailBackup', $data, true);
		$foot = $this->load->view('PeriodicalMaintenance/V_CetakanFoot', $data, true);
		$html2 = $this->load->view('PeriodicalMaintenance/V_Cetakan_Lampiran', $data, true);

		ob_end_clean();
		$pdf->shrink_tables_to_fit = 1;
		$pdf->use_kwt = true; 
		$pdf->setHTMLHeader($head);
		$pdf->setHTMLFooter($foot);
		$pdf->WriteHTML($html);
		if(sizeof($data['gambar'])>0){
			$pdf->WriteHTML($html2);
		}

		$pdf->Output($filename, 'I');
	}


	public function editSubMonitoring()
	{
		$nodoc 	= $this->input->post('nodoc');
		$id = $this->input->post('id');
		$dataa = $this->M_monitoring->selectDataEditMon($nodoc, $id);

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
				<div class="col-md-9" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="standarEditMon" name="standarEditMon" value="' . $dataa[0]['PERIODE_CHECK'] . '" disabled /></div>
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
		$nodoc 	= $this->input->post('nodoc');

		$subHeader = $this->input->post('subHeader');
		$standar = $this->input->post('standar');
		$periode = $this->input->post('periode');
		$durasi = $this->input->post('durasi');
		$kondisi = $this->input->post('kondisi');
		$catatan = $this->input->post('catatan');


		$this->M_monitoring->updateSubMonitoring($nodoc, $id, $subHeader, $standar, $periode, $durasi, $kondisi, $catatan);

	}

	public function deleteSubMonitoring()
	{
		$id = $this->input->post('id');
		$nodoc 	= $this->input->post('nodoc');

		$this->M_monitoring->deleteSubMonitoring($id, $nodoc);
	}

	public function deleteCekMPA()
	{
		$from = $this->input->post('from');
		$to 	= $this->input->post('to');

		$this->M_monitoring->deleteCekMPARange($from, $to);

		$this->M_monitoring->deleteSparepartMPARange($from, $to);
	}

}
