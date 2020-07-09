<?php defined('BASEPATH') OR die('No direct script access allowed');

class C_Revisi extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if(!$this->session->is_logged) { redirect(''); }
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Grapic/M_Revisi');
	}

	public function index() {
		$data['UserMenu'] = $this->M_user->getUserMenu($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->session->userid, $this->session->responsibility_id);
		$data['Menu'] = $data['UserMenu'][3]['menu'];
		$data['Title'] = $data['UserMenu'][3]['menu_title'];
		$data['SubMenuOne'] = $data['SubMenuTwo'] = '';
		$data['dataTimeStamp'] = date('d/m/Y H:i:s', strtotime($this->M_Revisi->getDataTimeStamp()));
		$data['dataFilterList'] = $this->getDataFilterList();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('Grapic/V_Revisi', $data);
		$this->load->view('V_Footer', $data);
	}
	
	public function getDataFilterList() {
		return array(1 => 'Keuangan', 2 => 'Pemasaran', 3 => 'Produksi', 4 => 'Personalia');
	}

    public function getData() {
		$data['currentMonth'] = date('m');
		$data['currentMonthFormatted'] = $data['currentMonth'].'.'.(date('d') <= 30 ? date('d') : 30);
		$data['yearList'] = array(2019, 2019, 2019, 2019, 2019, 2019);
		$data['monthList'] = array('Juli' => 1, 'Agustus' =>  4, 'September' => 4, 'Oktober' => 4, 'November' => 4, 'Desember' => 4);
		$data['monthListNumber'] = array(7, 8, 9, 10, 11, 12);
		$data['monthListFormatted'] = array();
		for($i = 0; $i < count($data['monthListNumber']); $i++) { $data['monthListFormatted'][$i] = date('m', strtotime($data['monthListNumber'][$i].'/1/'.$data['yearList'][$i])).'.'.(date('t', strtotime($data['monthListNumber'][$i].'/1/'.$data['yearList'][$i])) <= 30 ? date('t', strtotime($data['monthListNumber'][$i].'/1/'.$data['yearList'][$i])) : 30); }
		if($this->input->post('select-filter-data') == 0) { $titleList = $this->getDataFilterList(); for($i = 0; $i < count($titleList); $i++) { $data['title'][$i] = $titleList[$i + 1]; for($j = 0; $j < count($data['monthListNumber']); $j++) { $data['tableData'][$data['title'][$i]][$j] = $this->M_Revisi->getData(strtolower($data['title'][$i]), $data['monthListNumber'][$j], $data['yearList'][$j]); } } }
		else { $data['title'][0] = $this->getDataFilterList()[$this->input->post('select-filter-data')]; for($i = 0; $i < count($data['monthListNumber']); $i++) { $data['tableData'][$data['title'][0]][$i] = $this->M_Revisi->getData(strtolower($data['title'][0]), $data['monthListNumber'][$i], $data['yearList'][$i]); } }
		echo json_encode(array('view' => $this->load->view('Grapic/V_Revisi_Content', $data, true), 'titleList' => $data['title'], 'monthList' => $data['monthList'], 'monthListFormatted' => $data['monthListFormatted']));
	}

	public function exportPDF() {
		$content = empty($this->input->post('content')) ? '' : $this->input->post('content');
		$title = empty($this->input->post('fileName')) ? '' : $this->input->post('fileName');
		$fileName = (empty($this->input->post('fileName')) ? 'Refisi Efisiensi - ' : $this->input->post('fileName').' - ').time().'.pdf';
		$chartTitles = empty($this->input->post('chartTitles')) ? null : json_decode($this->input->post('chartTitles'));
		$chartBlobs = empty($this->input->post('chartBlobs')) ? null : json_decode($this->input->post('chartBlobs'));
		$path = 'assets/generated/Efisiensi SDM/Revisi Efisiensi/';
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		if (!file_exists($path)) { if (!mkdir(FCPATH.$path, 0777, true)) { die('Failed to create folder '.$path); } }
		$pdf->AddPage('L');
		$pdf->WriteHTML('<link type="text/css" rel="stylesheet" href="'.base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css').'" />');
		$pdf->WriteHTML('<link type="text/css" rel="stylesheet" href="'.base_url('assets/theme/css/AdminLTE.min.css').'" />');
		$pdf->WriteHTML('<style type="text/css">@page { margin: 0px; } tbody tr td { height: 60px; } thead tr th { height: auto; } .fixed-column { position: absolute; background: white; width: 100px; left: 16px; margin-bottom: 2px; } .background-red { background-color: #FF5252; color: white; } .row { padding: 0px !important; margin: 0px !important; } .row > div { margin: 0px !important; padding: 0px !important; } .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 { border: 0; padding: 0; margin-left: -0.00001; }</style>');
		if(!empty($title)) { $pdf->WriteHTML('<h1 style="font-size: 1.4rem; margin-bottom: 12px;">'.$title.'</h1>'); }
		$pdf->WriteHTML($content);
		if(!empty($chartTitles) && !empty($chartBlobs)) {
			$j = 0;
			if(count($chartBlobs) % 2 == 0) {
				for($i = 0; $i < count($chartBlobs) / 2; $i++) {
					if(count($titleList) <= 4) {
						$pdf->WriteHTML('
							<div class="row">
								<div class="col-xs-6 text-center" style="margin-top: 20px; margin-bottom: 20px;"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
								<div class="col-xs-6 text-center"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
							</div>
						');
					} else {
						$pdf->WriteHTML('
							<div class="row">
								<div class="col-xs-6 text-center" style="margin-top: 20px;"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
								<div class="col-xs-6 text-center"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
							</div>
						');
					}
				}
			} else {
				for($i = 0; $i < (count($chartBlobs) - 1) / 2; $i++) {
					if(count($titleList) <= 4) {
						$pdf->WriteHTML('
							<div class="row">
								<div class="col-xs-6 text-center" style="margin-top: 20px; margin-bottom: 20px;"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
								<div class="col-xs-6 text-center"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
							</div>
						');
					} else {
						$pdf->WriteHTML('
							<div class="row">
								<div class="col-xs-6 text-center" style="margin-top: 20px;"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
								<div class="col-xs-6 text-center"><b style="font-size: 0.8rem;">'.$chartTitles[$j].'</b><img src="'.$chartBlobs[$j++].'" style="width: 100%; height: 280px;" /></div>
							</div>
						');
					}
				}
				if(count($titleList) <= 4) {
					$pdf->WriteHTML('<div class="row"><div class="col-xs-6 text-center" style="margin-top: 20px; margin-bottom: 20px;"><b style="font-size: 0.8rem;">'.$chartTitles[count($chartTitles) - 1].'</b><img src="'.$chartBlobs[count($chartBlobs) - 1].'" style="width: 100%; height: 280px;" /></div></div>');	
				} else {
					$pdf->WriteHTML('<div class="row"><div class="col-xs-6 text-center" style="margin-top: 20px;"><b style="font-size: 0.8rem;">'.$chartTitles[count($chartTitles) - 1].'</b><img src="'.$chartBlobs[count($chartBlobs) - 1].'" style="width: 100%; height: 280px;" /></div></div>');	
				}
			}
		}
		$pdf->Output(FCPATH.$path.'/'.$fileName, 'F');
		echo json_encode(array('filePath' => base_url($path.$fileName), 'fileName' => $fileName));
	}
}