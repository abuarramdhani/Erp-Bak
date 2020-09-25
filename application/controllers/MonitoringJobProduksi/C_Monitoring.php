<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringJobProduksi/M_monitoring');

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

		$data['Title'] = 'Monitoring Job Produksi';
		$data['Menu'] = 'Monitoring Job Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kategori'] = $this->M_monitoring->getCategory('');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function search(){
        $kategori   	= $this->input->post('kategori');
		$ctgr 			= $this->M_monitoring->getCategory("where id_category = '".$kategori."'");
		$bulan      	= $this->input->post('bulan');
		$data['kategori'] 	= $ctgr[0]['CATEGORY_NAME'];
		$data['bulan'] 	= $bulan;
		$bulan 			= explode("/", $bulan);
		$inibulan		= $bulan[1].$bulan[0];

        if ($bulan[0] == '01' || $bulan[0] == '03' || $bulan[0] == '05' || $bulan[0] == '07' || $bulan[0] == '08' || $bulan[0] == '10' || $bulan[0] == '12') {
            $data['hari'] = 31;
        }elseif ($bulan[0] == '04' || $bulan[0] == '06' || $bulan[0] == '09' || $bulan[0] == '11') {
            $data['hari'] = 30;
        }elseif ($bulan[0] == '02') {
            if ($bulan[1]%4 == 0) {
                $data['hari'] = 29;
            }else {
                $data['hari'] = 28;
            }
		}

		$getdata = $this->M_monitoring->getdataMonitoring($kategori);
		$cariakt = $this->M_monitoring->getAktual($kategori, $data['bulan']);
		$getplandate = $this->M_monitoring->getPlanDate();
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$item = $this->M_monitoring->getitem($value['INVENTORY_ITEM_ID']);
			$plan = $this->M_monitoring->getPlan($value['INVENTORY_ITEM_ID'], $inibulan);
			$getdata[$key]['ITEM'] = $item[0]['SEGMENT1'];
			$getdata[$key]['DESC'] = $item[0]['DESCRIPTION'];
			$getdata[$key]['jml_plan'] = 0;
			$getdata[$key]['jml_akt'] = 0;
			$getdata[$key]['jml_min'] = 0;
			$getdata[$key]['jml_com'] = 0;
			if (!empty($plan)) {
				$ket = 'not';
				for ($i=0; $i < $data['hari'] ; $i++) { 
					$getdata[$key]['plan'.$i.''] = $this->getPlanDate($plan[0]['PLAN_ID'], ($i+1), $getplandate);
					$ket = $getdata[$key]['plan'.$i.''] != '' ? 'oke': $ket;
					$tgl = $inibulan.sprintf("%02d", ($i+1));
					$aktual = $this->aktualmin($value['INVENTORY_ITEM_ID'], $tgl, $getdata[$key]['plan'.$i.''], $cariakt);
					$getdata[$key]['min'.$i.''] = $aktual[1];
					$getdata[$key]['com'.$i.''] = $aktual[2];
					$getdata[$key]['jml_plan'] += $getdata[$key]['plan'.$i.''] == '' ? 0 : $getdata[$key]['plan'.$i.''];
					if ($data['bulan'] == date('m/Y')) {
						if ($i < date('d')) {
							$getdata[$key]['akt'.$i.''] = $aktual[0];
							$getdata[$key]['com'.$i.''] = $aktual[2];
							$getdata[$key]['jml_akt'] += $aktual[0] == '' ? 0 : $aktual[0];
							$getdata[$key]['jml_com'] += $aktual[2] == '' ? 0 : $aktual[2];
						}else {
							$getdata[$key]['akt'.$i.''] = '';
							$getdata[$key]['com'.$i.''] = '';
						}
					}else {
						$getdata[$key]['akt'.$i.''] = $aktual[0];
						$getdata[$key]['com'.$i.''] = $aktual[2];
						$getdata[$key]['jml_akt'] += $aktual[0] == '' ? 0 : $aktual[0];
						$getdata[$key]['jml_com'] += $aktual[2] == '' ? 0 : $aktual[2];
					}
					$getdata[$key]['jml_min'] += $aktual[1] == '' ? 0 : $aktual[1];
				}
				$ket == 'oke' ? array_push($datanya,$getdata[$key]) : '';
			}
		}
		$data['data'] = $datanya;
		// echo "<pre>";print_r($datanya);exit();

        $this->load->view('MonitoringJobProduksi/V_TblMonitoring', $data);
	}
	
	public function getPlanDate($id, $tgl, $data){
		$value = '';
		foreach ($data as $key => $val) {
			if ($val['PLAN_ID'] == $id && $val['DATE_PLAN'] == $tgl) {
				$value = $val['VALUE_PLAN'];
			}else {
				$value = $value;
			}
		}
		return $value;
	}

	public function aktualmin($inv_id, $tgl, $plan, $cariakt){
		$aktual = '';
		$complete = '';
		foreach ($cariakt as $key => $val) {
			if ($val['INVENTORY_ITEM_ID'] == $inv_id && $val['TGL_URUT'] == $tgl) {
				$aktual = $val['QUANTITY'];
				$complete = $val['QUANTITY_COMPLETE'];
			}else {
				$aktual = $aktual;
				$complete = $complete;
			}
		}
		if ($plan == '' && $aktual != '') {
			$min = $aktual;
		}elseif ($plan == '' && $aktual == '') {
			$min = '';
		}elseif ($plan != '' && $aktual == '') {
			$min = $plan*-1;
		}else {
			$min = $aktual - $plan;
		}
		$data = array($aktual, $min, $complete);
		return $data;
	}
	
	public function simulasi($no, $tgl)
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Simulasi Job Produksi';
		$data['Menu'] = 'Monitoring Job Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['no'] 		= $no;
		$data['tanggal'] 	= $tgl;
        $data['kategori']  	= $this->input->post('kategori'.$no.'');
		$data['bulan'] 		= $this->input->post('bulan'.$no.'');
		$data['item'] 		= $this->input->post('item'.$no.'');
		$data['desc'] 		= $this->input->post('desc'.$no.'');
		$data['plan'] 		= $this->input->post('plan'.$no.''.$tgl.'');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Simulasi', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function searchSimulasi(){
		$item 	= $this->input->post('item');
		$qty 	= $this->input->post('qty');
		$data['level'] = $this->input->post('level');
		$data['nomor'] = $this->input->post('nomor');

		$getdata = $this->M_monitoring->getdataSimulasi($item, $qty);
		// echo "<pre>";print_r($getdata);exit();
		$sorting_item = array();
		foreach ($getdata as $key => $get) {
			if ($get['REQUIRED_QUANTITY'] > $get['ATT']) {
				array_push($sorting_item, $getdata[$key]);
			}
		}
		foreach ($getdata as $key => $get) {
			if ($get['REQUIRED_QUANTITY'] > $get['ATT']) {
			}else {
				array_push($sorting_item, $getdata[$key]);
			}
		}
		$data['data'] = $sorting_item;

		// echo "<pre>";print_r($data['data']);exit();
		$this->load->view('MonitoringJobProduksi/V_TblSimulasi', $data);
	}

	public function detailGudang(){
		$item 		= $this->input->post('item');
		$desc 		= $this->input->post('desc');
		$dfg 		= $this->input->post('dfg');
		$dmc 		= $this->input->post('dmc');
		$fg_tks 	= $this->input->post('fg_tks');
		$int_paint 	= $this->input->post('int_paint');
		$int_weld 	= $this->input->post('int_weld');
		$int_sub 	= $this->input->post('int_sub');
		$pnl_tks 	= $this->input->post('pnl_tks');
		$sm_tks 	= $this->input->post('sm_tks');
		$jumlah 	= $this->input->post('jumlah');
		
		$view = '
				<div class="panel-body">
					<div class="col-md-2" style="font-weight:bold">Kode</div>
					<div class="col-md-10">: '.$item.'</div>
					<div class="col-md-2" style="font-weight:bold">Deskripsi</div>
					<div class="col-md-10">: '.$desc.'</div>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hovered table-stripped text-center" style="width:100%;font-size:12px">
						<thead style="background-color:#82E5FA">
							<tr>
								<th style="vertical-align:middle">DFG</th>
								<th style="vertical-align:middle">DMC</th>
								<th style="vertical-align:middle">FG-TKS</th>
								<th style="vertical-align:middle">INT-PAINT</th>
								<th style="vertical-align:middle">INT-WELD</th>
								<th style="vertical-align:middle">INT-SUB</th>
								<th style="vertical-align:middle">PNL-TKS</th>
								<th style="vertical-align:middle">SM-TKS</th>
								<th style="vertical-align:middle">JUMLAH</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>'.$dfg.'</td>
								<td>'.$dmc.'</td>
								<td>'.$fg_tks.'</td>
								<td>'.$int_paint.'</td>
								<td>'.$int_weld.'</td>
								<td>'.$int_sub.'</td>
								<td>'.$pnl_tks.'</td>
								<td>'.$sm_tks.'</td>
								<td class="bg-info" style="font-weight:bold;">'.$jumlah.'</td>
							</tr>
						</tbody>
					</table>
				</div>
		';
		echo $view;
	}


}