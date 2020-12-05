<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_BelumFabrikasi extends CI_Controller
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
		$this->load->model('MonitoringPicklist/M_pickfabrikasi');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Belum Approve Fabrikasi';
		$data['Menu'] = 'Belum Approve Fabrikasi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/FABRIKASI/V_BelumFabrikasi');
		$this->load->view('V_Footer',$data);
	}
	
	public function getShift(){
		$date 		= $this->input->post('tgl');
		$date2 		= explode('/', $date);
		$datenew 	= $date ? $date2[2].'/'.$date2[1].'/'.$date2[0] : '';
		$data 		= $this->M_pickfabrikasi->getShift($datenew);
		
		echo '<option></option>';
		foreach ($data as $val) {
			echo '<option value="'.$val['SHIFT_NUM'].'">'.$val['DESCRIPTION'].'</option>';
		}
	}

	public function modalApprove(){
		$no = $this->input->post('no');
		$view = '<div class="panel-body">
					<div class="col-md-4 text-right">
						<label>Tanggal Pelayanan :</label>
					</div>
					<div class="col-md-6">
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input id="tgl_minta" class="form-control datepicklist" placeholder="Pilih Tanggal Pelayanan" style="width:100%" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-4 text-right">
						<label>Shift Pelayanan :</label>
					</div>
					<div class="col-md-6">
						<select id="shift_minta" name="shift_minta" class="form-control select2 approve_required" style="width:100%" data-placeholder="Pilih Shift"></select>
					</div>
				</div>
				<div class="panel-body text-center">
					<button id="btnsaveappFab" class="btn btn-success" onclick="approveFabrikasi('.$no.')" disabled>Approve</button>
				</div>';
		echo $view;
	}

	public function modalApproveSelect(){
		$view = '<div class="panel-body">
					<div class="col-md-4">
						<input type="radio" id="appbersama" name="ket_app" value="bersama">Dilayani Bersama
					</div>
					<div class="col-md-6">
						<input type="radio" id="appsendiri" name="ket_app" value="sendiri">Dilayani Pada Waktu Yang Berbeda
					</div>
				</div>
				<div class="panel-body" id="input_permintaan">
				</div>
				<div class="panel-body text-center">
					<button id="btnsaveappFab" class="btn btn-success" onclick="approveFabrikasi2()" disabled>Approve</button>
				</div>';
		echo $view;
	}

	public function permintaanApprove(){
		$ket = $this->input->post('ket');

		if ($ket == 'bersama') {
			$view = '<div class="panel-body">
						<div class="col-md-4 text-right">
							<label>Tanggal Pelayanan :</label>
						</div>
						<div class="col-md-6">
							<div class="input-group date">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input id="tgl_minta" class="form-control datepicklist" placeholder="Pilih Tanggal Pelayanan" style="width:100%" autocomplete="off">
								<input type="hidden" id="ket_app" value="'.$ket.'">
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-4 text-right">
							<label>Shift Pelayanan :</label>
						</div>
						<div class="col-md-6">
							<select id="shift_minta" name="shift_minta" class="form-control select2 approve_required" style="width:100%" data-placeholder="Pilih Shift"></select>
						</div>
					</div>';
		}else {
			$nojob = $this->input->post('nojob');
			$cek = $this->input->post('cek');
			$td = '';
			for ($i=0; $i < count($nojob) ; $i++) { 
				if ($cek[$i] == 'uncek') {
					$td .= '<tr>
								<td>'.$nojob[$i].'</td>
								<td><div class="input-group date">
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
										<input id="tgl_minta'.$i.'" class="form-control datepicklist tgl_minta" placeholder="Pilih Tanggal Pelayanan" style="width:180px" autocomplete="off" onchange="gantisift('.$i.')">
										<input type="hidden" id="ket_app" value="'.$ket.'">
									</div>
								</td>
								<td><select id="shift_minta'.$i.'" name="shift_minta" class="form-control select2 shift_minta approve_required" style="width:180px" data-placeholder="Pilih Shift"></select></td>
							</tr>';
				}
			}
			$view = '<table class="table text-center" style="width:100%">
						<thead>
							<tr>
								<th>No Job</th>
								<th>Tanggal Pelayanan</th>
								<th>Shift</th>
							</tr>
						<thead>
						<tbody>'.$td.'</tbody>
					</table>';
		}
		echo $view;
	}

	function searchData(){
		$dept 		= $this->input->post('dept');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');

		$getdata = $this->M_pickfabrikasi->getdataBelum($dept, $tanggal1, $tanggal2);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_pickfabrikasi->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$data['data'] = $getdata;
		
		$this->load->view('MonitoringPicklist/FABRIKASI/V_TblBelumFabrikasi', $data);
	}

	function searchData2(){
		$dept 		= $this->input->post('dept');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');

		$data['data'] = $this->M_pickfabrikasi->getdataBelum($dept, $tanggal1, $tanggal2);
		$jml = count($data['data']);
		echo json_encode($jml);
	}

	function approveData(){
		$picklist 	= $this->input->post('picklist');
		$nojob 		= $this->input->post('nojob');
		$user 		= $this->session->user;
		$tgl_minta 	= $this->input->post('tgl_minta');
		$shift_minta = $this->input->post('shift_minta');
		// echo "<pre>";print_r($nojob);exit();
		$cek2 = $this->M_pickfabrikasi->cekapprove2($nojob);
		$cek3 = $this->M_pickfabrikasi->cekpermintaanPelayanan($nojob);
		if (empty($cek2) && empty($cek3)) {
			$this->M_pickfabrikasi->approveData($picklist, $nojob, $user);
			$this->M_pickfabrikasi->permintaanApprove($nojob, $tgl_minta, $shift_minta);
		}
	}

	function approveData2(){
		$nojob 		= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		$cek 		= $this->input->post('cek');
		$user 		= $this->session->user;
		$ket 		= $this->input->post('ket');
		$tgl_minta 	= $this->input->post('tgl_minta');
		$shift_minta = $this->input->post('shift_minta');
		// echo "<pre>";print_r($cek);exit();

		$x = 0;
		for ($i=0; $i < count($nojob); $i++) { 
			if ($cek[$i] == 'uncek') {
				$cek2 = $this->M_pickfabrikasi->cekapprove2($nojob[$i]);
				$cek3 = $this->M_pickfabrikasi->cekpermintaanPelayanan($nojob[$i]);
				if (empty($cek2) && empty($cek3)) {
					$this->M_pickfabrikasi->approveData($picklist[$i], $nojob[$i], $user);
					if ($ket == 'bersama') {
						$this->M_pickfabrikasi->permintaanApprove($nojob[$i], $tgl_minta, $shift_minta);
					}else {
						$this->M_pickfabrikasi->permintaanApprove($nojob[$i], $tgl_minta[$x], $shift_minta[$x]);
						$x++;
					}
				}
			}
		}

	}

	function printBelumFabrikasi($picklist){
		$date = date('dMY');
		$getdata = $this->M_pickfabrikasi->getdataBelum2($picklist);
		// echo "<pre>";print_r($getdata);exit();

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(82,112), 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'BelumFabrikasi-'.$date.'.pdf';

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		
		foreach ($getdata as  $get) {
			$params['data']		= $get['NO_PICKLIST'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($get['NO_PICKLIST']).'.png';
			$this->ciqrcode->generate($params);
		}

		$data['data'] = $getdata;
		$data['beda'] = $this->M_pickfabrikasi->getPerbedaan($picklist);
    	$html = $this->load->view('MonitoringPicklist/FABRIKASI/V_PdfBelumFabrikasi', $data,true);
    	ob_end_clean();
    	$pdf->WriteHTML($html);												
    	$pdf->Output($filename, 'I');
		
	}

	public function cetaksemua(){
		$date = date('dMY');
		$picklist = $this->input->post('picklist[]');
		$cek = $this->input->post('printsemua[]');

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(82,112), 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'BelumFabrikasi-'.$date.'.pdf';

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}

		for ($i=0; $i < count($picklist) ; $i++) { 
			if ($cek[$i] == 'uncek') {
				$getdata = $this->M_pickfabrikasi->getdataBelum2($picklist[$i]);
				// echo "<pre>";print_r($getdata);exit();
				foreach ($getdata as  $get) {
					$params['data']		= $get['NO_PICKLIST'];
					$params['level']	= 'H';
					$params['size']		= 10;
					$params['black']	= array(255,255,255);
					$params['white']	= array(0,0,0);
					$params['savename'] = './img/'.($get['NO_PICKLIST']).'.png';
					$this->ciqrcode->generate($params);
				}
		
				$data['data'] = $getdata;
				$data['beda'] = $this->M_pickfabrikasi->getPerbedaan($picklist[$i]);
				$html = $this->load->view('MonitoringPicklist/FABRIKASI/V_PdfBelumFabrikasi', $data,true);
				ob_end_clean();
				$pdf->WriteHTML($html);	
			}
		}										
    	$pdf->Output($filename, 'I');
	}


}