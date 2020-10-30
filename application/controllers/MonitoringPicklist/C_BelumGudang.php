<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_BelumGudang extends CI_Controller
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
		$this->load->model('MonitoringPicklist/M_pickgudang');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Belum Approve Gudang';
		$data['Menu'] = 'Belum Approve Gudang';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/GUDANG/V_BelumGudang');
		$this->load->view('V_Footer',$data);
	}

	function getsubinv()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_pickgudang->getSubinv($term);
		echo json_encode($data);
	}
	
	function getDept()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_pickgudang->getDept($term);
		echo json_encode($data);
	}


	function searchData(){
		$subinv 	= $this->input->post('subinv');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');
		$dept 		= $this->input->post('dept');

		if (!empty($dept)) {
			$department = "and bd.DEPARTMENT_CLASS_CODE = '$dept'";
		}else {
			$department = '';
		}

		$getdata = $this->M_pickgudang->getdataBelum($subinv, $tanggal1, $tanggal2, $department);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_pickgudang->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$datanya = $this->sortbyTanggalPelayanan($getdata);
		$data['data'] = $datanya;
		// echo "<pre>";print_r($getdata);exit();
		
		$this->load->view('MonitoringPicklist/GUDANG/V_TblBelumGudang', $data);
	}

	public function sortbyTanggalPelayanan($getdata){
		$pelayanan = $this->M_pickgudang->cariReqPelayanan();
		$datanya = $nojob = $datanya2 = array();
		foreach ($pelayanan as $key => $value) {
			foreach ($getdata as $key2 => $get) {
				if ($get['JOB_NO'] == $value['JOB_NUMBER']) {
					$getdata[$key2]['TGL_PELAYANAN'] = $value['TANGGAL_PELAYANAN'];
					$shift = $this->M_pickgudang->getShift($value['SHIFT']);
					$getdata[$key2]['SHIFT'] = $shift[0]['DESCRIPTION'];
					array_push($datanya, $getdata[$key2]);
					array_push($nojob, $get['JOB_NO']);
				}
			}
		}
		foreach ($getdata as $key => $val) {
			if (!in_array($val['JOB_NO'], $nojob)) {
				$getdata[$key]['TGL_PELAYANAN'] = $getdata[$key]['SHIFT'] = '';
				array_push($datanya2, $getdata[$key]);
			}
		}
		
		foreach ($datanya as $key => $value) {
			array_push($datanya2, $datanya[$key]);
		}
		// echo "<pre>";print_r($datanya);exit();
		return $datanya2;
	}

	function searchData2(){
		$subinv 	= $this->input->post('subinv');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');
		$dept 		= $this->input->post('dept');

		if (!empty($dept)) {
			$department = "and bd.DEPARTMENT_CLASS_CODE = '$dept'";
		}else {
			$department = '';
		}

		$getdata = $this->M_pickgudang->getdataBelum($subinv, $tanggal1, $tanggal2, $department);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_pickgudang->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$data['data'] = $getdata;
		$jml = count($data['data']);
		echo json_encode($jml);
	}

	function modalData(){
		$nojob 	= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		$deliver 	= $this->input->post('deliver');
		$cekapp = $this->M_pickgudang->cekapp($nojob, $picklist);
		if (!empty($cekapp) || $deliver != '') {
			$btn = 'disabled';
			$warna = '';
		}else {
			$btn = '';
			$warna = 'btn-danger';
		}

		$getdata = $this->M_pickgudang->getdetail($picklist);
		// echo "<pre>";print_r($get);exit();
		
		$tr = '';
		$no = 1;
		foreach ($getdata as $get) {
			$tr .= '<tr>
						<td>'.$no.'</td>
						<td>'.$get['SEGMENT1'].'</td>
						<td style="text-align:left">'.$get['DESCRIPTION'].'</td>
						<td>'.$get['QUANTITY'].'</td>
					</tr>';
			$no++;
		}

		$tabel = '<table class="datatable table table-bordered table-hover table-striped myTable text-center" id="tb_sdhppic" style="width: 100%;">
					<thead class="bg-primary">
						<tr>
							<td>No</td>
							<td>Item</td>
							<td>Deskripsi</td>
							<td>Rec</td>
						</tr>
					</thead>
					<tbody>
						'.$tr.'
					</tbody>
				</table>
				<input type="hidden" id="nojob" value="'.$nojob.'">
				<input type="hidden" id="picklist" value="'.$picklist.'">
				
				<span>Picklist sudah melakukan allocate, jadi sudah pasti bisa di-transact.</span>
				<div class="panel-body">
					<div class="col-md-12 text-center">
						<button type="button" class="btn '.$warna.'" '.$btn.' id="btn_appgdg" onclick="approveGudang(this)">Approve</button>
					</div>
				</div>
				';

		echo $tabel;
	}

	function approveData(){
		$picklist = $this->input->post('picklist');
		$nojob = $this->input->post('nojob');
		$user = $this->session->user;
		$cek2 = $this->M_pickgudang->cekapprove2($nojob);
		if (empty($cek2)) {
			$this->M_pickgudang->approveData($picklist, $nojob, $user);
		}
	}

	function approveData2(){
		$nojob 		= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		$cek 		= $this->input->post('cek');
		$user 		= $this->session->user;
		// echo "<pre>";print_r($cek);exit();

		for ($i=0; $i < count($nojob); $i++) { 
			if ($cek[$i] == 'uncek') {
				$cek2 = $this->M_pickgudang->cekapprove2($nojob[$i]);
				if (empty($cek2)) {
					$this->M_pickgudang->approveData($picklist[$i], $nojob[$i], $user);
				}
			}
		}

	}


}