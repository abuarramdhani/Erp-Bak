<?php defined('BASEPATH') OR die('No direct script access allowed');

class C_Revisi extends CI_Controller {

	var $currentYear = 2019;
	
	function __construct() {
		parent::__construct();
		if(!$this->session->is_logged) { redirect('index'); }
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
		$data['monthList'] = array('Juli' => 1, 'Agustus' =>  4, 'September' => 4, 'Oktober' => 4, 'November' => 4, 'Desember' => 4);
		$data['monthListNumber'] = array(7, 8, 9, 10, 11, 12);
		$data['monthListFormatted'] = array(); for($i = 0; $i < count($data['monthListNumber']); $i++) { $data['monthListFormatted'][$i] = date('m', strtotime($data['monthListNumber'][$i].'/1/'.$this->currentYear)).'.'.(date('t', strtotime($data['monthListNumber'][$i].'/1/'.$this->currentYear)) <= 30 ? date('t', strtotime($data['monthListNumber'][$i].'/1/'.$this->currentYear)) : 30); }
		if($this->input->post('select-filter-data') == 0) { $titleList = $this->getDataFilterList(); for($i = 0; $i < count($titleList); $i++) { $data['title'][$i] = $titleList[$i + 1]; for($j = 0; $j < 6; $j++) { $data['tableData'][$data['title'][$i]][$j] = $this->M_Revisi->getData(strtolower($data['title'][$i]), ($j + 7), $this->currentYear); } } }
		else { $data['title'][0] = $this->getDataFilterList()[$this->input->post('select-filter-data')]; for($i = 0; $i < 6; $i++) { $data['tableData'][$data['title'][0]][$i] = $this->M_Revisi->getData(strtolower($data['title'][0]), ($i + 7), $this->currentYear); } }
		echo json_encode(array('view' => $this->load->view('Grapic/V_Revisi_Content', $data, true), 'titleList' => $data['title'], 'monthList' => $data['monthList'], 'monthListFormatted' => $data['monthListFormatted']));
	}

	public function exportPDF() {
		$content = empty($this->input->post('content')) ? '' : $this->input->post('content');
		$title = empty($this->input->post('fileName')) ? '' : $this->input->post('fileName');
		$fileName = (empty($this->input->post('fileName')) ? 'Refisi Efisiensi - ' : $this->input->post('fileName').' - ').time().'.pdf';
		$path = 'assets/generated/Efisiensi SDM/Revisi Efisiensi/';
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		if (!file_exists($path)) { if (!mkdir(FCPATH.$path, 0777, true)) { die('Failed to create folder '.$path); } }
		$pdf->AddPage('L');
		$pdf->WriteHTML('<link type="text/css" rel="stylesheet" href="'.base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css').'" />');
		$pdf->WriteHTML('<link type="text/css" rel="stylesheet" href="'.base_url('assets/theme/css/AdminLTE.min.css').'" />');
		$pdf->WriteHTML('<style type="text/css">tbody tr td { height: 60px; } thead tr th { height: auto; } .fixed-column { position: absolute; background: white; width: 100px; left: 16px; margin-bottom: 2px; } .background-red { background-color: #FF5252; color: white; }</style>');
		if(!empty($title)) { $pdf->WriteHTML('<h1 style="font-size: 1.4rem; margin-bottom: 12px;">'.$title.'</h1>'); }
		$pdf->WriteHTML($content);
		$pdf->Output(FCPATH.$path.'/'.$fileName, 'F');
		echo json_encode(array('filePath' => base_url($path.$fileName), 'fileName' => $fileName));
	}
}