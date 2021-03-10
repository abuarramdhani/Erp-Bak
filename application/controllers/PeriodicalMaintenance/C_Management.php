<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Management extends CI_Controller
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
		$this->load->model('PeriodicalMaintenance/M_management');

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

		$data['Title'] = 'Management Uraian Kerja';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


		$data['mesin'] = $this->M_management->getMesin();


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Management', $data);
		$this->load->view('V_Footer', $data);
	}

	public function search()
	{
		$mesin 	= $this->input->post('mesin');

		// $data['value'] = $this->M_management->getAll($mesin);

		// $this->load->view('PeriodicalMaintenance/V_Result',$data);


		// $dataGET = $this->M_monitoring->getSearch($no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item);				
		$dataGET = $this->M_management->getAll($mesin);
		// echo "<pre>"; 
		// print_r($dataGET); exit();
		// pengelompokan data
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			if (!in_array($value['HEADER'], $array_sudah)) {
				array_push($array_sudah, $value['HEADER']);
				// if(strlen($value['HEADER']) == 0) {
				// 	$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN'], NULL);

				// } else {
				// 	$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN'], $value['HEADER']);

				// }

				$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN'], $value['HEADER']);


				// echo "<pre>"; 
				// print_r($getBody);

				$array_terkelompok[$value['HEADER']]['header'] = $value;
				$array_terkelompok[$value['HEADER']]['body'] = $getBody;
			}
		}
		$data['value'] = $array_terkelompok;

		// echo "<pre>"; 
		// print_r($array_terkelompok); exit();

		$this->load->view('PeriodicalMaintenance/V_Result', $data);
	}

	// public function Report()
	// {
	// 	$data['databaseValues'] =  $this->M_management->getHead1();
	// 	// echo "<pre>"; 
	// 	// // echo count($data['databaseValues']);
	// 	// print_r($data['databaseValues']); exit();
	// 	$this->load->view('PeriodicalMaintenance/V_Report', $data, true);

	// 	// $this->load->library('pdf');
	// 	// $pdf = $this->pdf->load();
	// 	// $pdf = new mPDF('utf-8',array(210,330), 0, '', 1, 1, 1, 1, 1, 1);

	// 	// $tglNama = date("dmY");
	// 	// $filename = 'PeriodicalMaintenance'.$tglNama.'.pdf';
	// 	// $html = $this->load->view('PeriodicalMaintenance/V_Report', true);		//-----> Fungsi Cetak PDF
	// 	// ob_end_clean();
	// 	// $pdf->WriteHTML($html);												//-----> Pakai Library MPDF
	// 	// $pdf->Output($filename, 'I');
	// }

	public function editSubManagement()
	{
		$id = $this->input->post('id');
		$dataa = $this->M_management->selectDataToEdit($id);

		// echo "<pre>";
		// print_r($dataa);
		// exit();

		// $editmasterhandling = '
		//     <div class="panel-body">                            
		//         <div class="col-md-5" style="text-align: right;"><label>Uraian Kerja</label></div>                                        
		//             <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="subHeaderEdit" name="subHeaderEdit" value="' . $dataa[0]['SUB_HEADER'] . '" /></div>
		//             <input type="hidden" name="idRowEdit" id="idRowEdit" value="' . $id . '"/>
		//         </div>
		//         <div class="panel-body">                            
		//             <div class="col-md-5" style="text-align: right;"><label>Standar</label></div>                                        
		//             <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="standarEdit" name="standarEdit" value="' . $dataa[0]['STANDAR'] . '" /></div>
		// 		</div>
		// 		<div class="panel-body">                            
		// 		<div class="col-md-5" style="text-align: right;"><label>Periode</label></div>                                        
		// 		<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="periodeEdit" name="periodeEdit" value="' . $dataa[0]['PERIODE'] . '" /></div>
		// 	</div>
		//         <div class="panel-body">
		//             <div class="col-md-12" style="text-align:right"><button class="btn btn-success button-save-edit">Save</button></div>
		//         </div>';

		if ($dataa[0]['PERIODE'] == "2 Mingguan") {
			$opsi = '<option selected>2 Mingguan</option>
			<option>Tahunan</option>';
		} else {
			$opsi = '<option>2 Mingguan</option>
			<option selected>Tahunan</option>';
		}

		$editmasterhandling = '
		<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Uraian Kerja</label></div>                                        
				<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="subHeaderEdit" name="subHeaderEdit" value="' . $dataa[0]['SUB_HEADER'] . '" /></div>
				<input type="hidden" name="idRowEdit" id="idRowEdit" value="' . $id . '"/>
			</div>
			<div class="panel-body">                            
				<div class="col-md-5" style="text-align: right;"><label>Standar</label></div>                                        
				<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="standarEdit" name="standarEdit" value="' . $dataa[0]['STANDAR'] . '" /></div>
			</div>
			<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Periode</label></div>                                        
			<div class="col-md-4" style="text-align: left;">
			<select id="periodeEdit" name="periodeEdit" class="form-control select2" style="width: 100%" data-placeholder="Periode" value="' . $dataa[0]['PERIODE'] . '">
			<option></option>
			' . $opsi . '
		</select>
			</div>
		</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button class="btn btn-success button-save-edit">Save</button></div>
			</div>';


		echo $editmasterhandling;
	}

	public function updateSubManagement()
	{
		$id = $this->input->post('id');
		$subHeader = $this->input->post('subHeader');
		$standar = $this->input->post('standar');
		$periode = $this->input->post('periode');

		$this->M_management->updateSubManagement($id, $subHeader, $standar, $periode);


		// redirect(base_url('DbHandling/SetDataMaster'));
	}

	public function deleteSubManagement()
	{
		$id = $this->input->post('id');
		$this->M_management->deleteSubManagement($id);
	}


	public function cetakForm()
	{

		$mesin = $this->input->post('list_mesin');
		$data['mesin'] = $mesin;

		$datapdf = $this->M_management->getdatapdf($mesin);
		// $datapdf2 = $this->M_cetakbom->getdatapdf2($kode, $alt);

		// $arr = array();
		// foreach($datapdf as $key =>$pedido){
		// $arr[$pedido['KONDISI_MESIN']][] = $pedido;
		// $count = count($arr[$pedido['KONDISI_MESIN']]);
		// $arr[$pedido['KONDISI_MESIN']][0]['rowspan'] = $count;
		// }
		// echo "<pre>";
		// print_r($pedidos);
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
			$array_Resource['HEADER'][$datapdf[$i]['HEADER']][$i] = $datapdf[$i]['SUB_HEADER'];
			
		}
		// echo "<pre>";
		// exit();

		$array_pdf = array();
		$i = 0;
		foreach ($datapdf as $pdf) {

			// $array_pdf[$i]['PROSES'] = $pdf['PROSES'];
			$array_pdf[$i]['NAMA_MESIN'] = $pdf['NAMA_MESIN'];
			$array_pdf[$i]['KONDISI_MESIN'] = $pdf['KONDISI_MESIN'];
			$array_pdf[$i]['HEADER'] = $pdf['HEADER'];
			$array_pdf[$i]['SUB_HEADER'] = $pdf['SUB_HEADER'];
			$array_pdf[$i]['STANDAR'] = $pdf['STANDAR'];
			$array_pdf[$i]['PERIODE'] = $pdf['PERIODE'];
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
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'f4', 0, '', 3, 3, 35, 3, 3, 3); //----- A5-L
		$tglNama = date("d/m/Y-H:i:s");
		$filename = 'Periodical_Maintenance_' . $tglNama . '.pdf';
		$head = $this->load->view('PeriodicalMaintenance/V_CetakanHead', $data, true);
		$html = $this->load->view('PeriodicalMaintenance/V_Cetakan_Detail', $data, true);
		$foot = $this->load->view('PeriodicalMaintenance/V_CetakanFoot', $data, true);

		ob_end_clean();
		$pdf->shrink_tables_to_fit = 0;
		$pdf->setHTMLHeader($head);
		$pdf->setHTMLFooter($foot);												//-----> Pakai Library MPDF
		$pdf->WriteHTML($html);

		$pdf->Output($filename, 'I');
	}
}

