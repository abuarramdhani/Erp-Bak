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

	function searchData(){
		$subinv 	= $this->input->post('subinv');
		$tanggal 	= $this->input->post('tanggal');

		$data['data'] = $this->M_pickgudang->getdataBelum($subinv, $tanggal);
		
		$this->load->view('MonitoringPicklist/GUDANG/V_TblBelumGudang', $data);
	}

	function modalData(){
		$nojob 	= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		$cekapp = $this->M_pickgudang->cekapp($nojob, $picklist);
		if (!empty($cekapp)) {
			$btn = 'disabled';
		}else {
			$btn = '';
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
						<button type="button" class="btn btn-danger" '.$btn.' onclick="approveGudang(this)">Approve</button>
					</div>
				</div>
				';

		echo $tabel;
	}

	function approveData(){
		$picklist = $this->input->post('picklist');
		$nojob = $this->input->post('nojob');
		$user = $this->session->user;
		$this->M_pickgudang->approveData($picklist, $nojob, $user);
	}


}