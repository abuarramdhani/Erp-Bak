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
		$this->load->model('MonitoringJobProduksi/M_usermng');

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
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Job Produksi';
		$data['Menu'] = 'Monitoring Job Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		
		$user = $this->session->user;
		$cekHak = $this->M_usermng->getUser("where no_induk = '$user'");
		if (!empty($cekHak)) {
			if ($cekHak[0]['JENIS'] == 'Admin') {
				$data['UserMenu'] = array($UserMenu[0], $UserMenu[1]);
			}else {
				$data['UserMenu'] = $UserMenu;
			}
		}else {
			$data['UserMenu'] = $UserMenu;
		}

		$data['kategori'] = $this->M_monitoring->getCategory('');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getdataMonitoring($kategori, $inibulan, $hari, $bulan){
		$getdata = $this->M_monitoring->getdataMonitoring($kategori);
		$cariakt = $this->M_monitoring->getAktual2($kategori, $inibulan);
		// $cariakt = $this->M_monitoring->getAktual($kategori, $data['bulan']);
		$getplandate = $this->M_monitoring->getPlanDate();
		$datanya = array();
		$total['item'] = $total['ttl_jml_plan'] = $total['ttl_jml_akt'] = $total['ttl_jml_min'] = 0;
		$total['ttl_jml_com'] = $total['ttl_jml_pl'] = $total['ttl_jml_plmin'] = $total['ttl_jml_cmin'] = 0;
		foreach ($getdata as $key => $value) {
			$item = $this->M_monitoring->getitem($value['INVENTORY_ITEM_ID']);
			$plan = $this->M_monitoring->getPlan($value['INVENTORY_ITEM_ID'], $inibulan);
			$getdata[$key]['ITEM'] = $item[0]['SEGMENT1'];
			$getdata[$key]['DESC'] = $item[0]['DESCRIPTION'];
			$getdata[$key]['jml_plan'] = 0;
			$getdata[$key]['jml_akt'] = 0;
			$getdata[$key]['jml_min'] = 0;
			$getdata[$key]['jml_com'] = 0;
			$getdata[$key]['jml_pl'] = 0;
			$getdata[$key]['jml_plmin'] = 0;
			$getdata[$key]['jml_cmin'] = 0;
			if (!empty($plan)) {
				$ket = 'not';
				for ($i=0; $i < $hari ; $i++) {
					$getdata[$key]['plan'.$i.''] = $this->getPlanDate($plan[0]['PLAN_ID'], ($i+1), $getplandate);
					$ket = $getdata[$key]['plan'.$i.''] != '' ? 'oke': $ket;
					$tgl = $inibulan.sprintf("%02d", ($i+1));
					$aktual = $this->aktualmin($value['INVENTORY_ITEM_ID'], $tgl, $getdata[$key]['plan'.$i.''], $cariakt);
					$getdata[$key]['jml_plan'] += $getdata[$key]['plan'.$i.''] == '' ? 0 : $getdata[$key]['plan'.$i.''];
					
					$getdata[$key]['akt'.$i.''] = $aktual[0];
					$getdata[$key]['com'.$i.''] = $aktual[2];
					$getdata[$key]['pl'.$i.''] = $aktual[3];
					$getdata[$key]['jml_akt'] += $aktual[0] == '' ? 0 : $aktual[0];
					$getdata[$key]['jml_com'] += $aktual[2] == '' ? 0 : $aktual[2];
					$getdata[$key]['jml_pl'] += $aktual[3] == '' ? 0 : $aktual[3];
					if ($bulan == date('m/Y')) {
						if ($i < date('d')) {
							$getdata[$key]['min'.$i.''] = $aktual[1];
							$getdata[$key]['plmin'.$i.''] = $aktual[4];
							$getdata[$key]['cmin'.$i.''] = $aktual[5];
							$getdata[$key]['jml_min'] += $aktual[1] == '' ? 0 : $aktual[1];
							$getdata[$key]['jml_plmin'] += $aktual[4] == '' ? 0 : $aktual[4];
							$getdata[$key]['jml_cmin'] += $aktual[5] == '' ? 0 : $aktual[5];
						}else {
							$getdata[$key]['min'.$i.''] = '';
							$getdata[$key]['plmin'.$i.''] = '';
							$getdata[$key]['cmin'.$i.''] = '';
						}
					}else {
						$getdata[$key]['min'.$i.''] = $aktual[1];
						$getdata[$key]['plmin'.$i.''] = $aktual[4];
						$getdata[$key]['cmin'.$i.''] = $aktual[4];
						$getdata[$key]['jml_min'] += $aktual[1] == '' ? 0 : $aktual[1];
						$getdata[$key]['jml_plmin'] += $aktual[4] == '' ? 0 : $aktual[4];
						$getdata[$key]['jml_cmin'] += $aktual[5] == '' ? 0 : $aktual[5];
					}
					
				}
				if ($ket == 'oke') {
					array_push($datanya,$getdata[$key]);
					// $total['item'] += 1;
					$total['ttl_jml_plan'] += $getdata[$key]['jml_plan'];
					$total['ttl_jml_akt'] += $getdata[$key]['jml_akt'];
					$total['ttl_jml_min'] += $getdata[$key]['jml_min'];
					$total['ttl_jml_com'] += $getdata[$key]['jml_com'];
					$total['ttl_jml_pl'] += $getdata[$key]['jml_pl'];
					$total['ttl_jml_plmin'] += $getdata[$key]['jml_plmin'];
					$total['ttl_jml_cmin'] += $getdata[$key]['jml_cmin'];
				}
			}
		}
		$hasil = array($datanya, $total);
		return $hasil;
	}

	public function jumlahHari($bulan){
        if ($bulan[0] == '01' || $bulan[0] == '03' || $bulan[0] == '05' || $bulan[0] == '07' || $bulan[0] == '08' || $bulan[0] == '10' || $bulan[0] == '12') {
            $hari = 31;
        }elseif ($bulan[0] == '04' || $bulan[0] == '06' || $bulan[0] == '09' || $bulan[0] == '11') {
            $hari = 30;
        }elseif ($bulan[0] == '02') {
            if ($bulan[1]%4 == 0) {
                $hari = 29;
            }else {
                $hari = 28;
            }
		}
		return $hari;
	}
    
    public function search(){
        $data['ket']   	= $this->input->post('ket');
        $kategori   	= $this->input->post('kategori');
		$ctgr 			= $this->M_monitoring->getCategory("where id_category = '".$kategori."'");
		$bulan      	= $this->input->post('bulan');
		$data['kategori'] 	= $ctgr[0]['CATEGORY_NAME'];
		$data['kategori2'] 	= $kategori;
		$data['bulan'] 	= $bulan;
		$bulan 			= explode("/", $bulan);
		$inibulan		= $bulan[1].$bulan[0];
		$data['bulan2'] = $inibulan;

		$data['hari'] = $this->jumlahHari($bulan);

		$datanya = $this->getdataMonitoring($kategori, $inibulan, $data['hari'], $data['bulan']);
		// echo "<pre>";print_r($datanya);exit();

		$data['data'] = $datanya[0];
		$data['total'] = $datanya[1];

        $this->load->view('MonitoringJobProduksi/V_TblMonitoring', $data);
	}

	public function searchReport(){
        $tglawal   		= $this->input->post('tglawal');
        $tglakhir   	= $this->input->post('tglakhir');
        $kategori   	= $this->input->post('kategori');
		$bulan      	= $this->input->post('bulan');
		$bulan2 		= explode("/", $bulan);
		$inibulan		= $bulan2[1].$bulan2[0];
		$hari			= $this->jumlahHari($bulan2);
		$inidata = array();
		for ($i=0; $i < count($kategori) ; $i++) { 
			$datanya 	= $this->getdataMonitoring($kategori[$i], $inibulan, $hari, $bulan);
			$ctgr 		= $this->M_monitoring->getCategory("where id_category = '".$kategori[$i]."'");
			$datanya['kategori'] = $ctgr[0]['CATEGORY_NAME'];
			$datanya['kategori2'] = $kategori[$i];
			array_push($inidata, $datanya);
		}
		$data['data'] = $inidata;
		$data['hari'] = $hari;
		$data['bulan'] = $bulan;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;

		// echo "<pre>";print_r($kategori);exit();
        $this->load->view('MonitoringJobProduksi/V_TblReport', $data);
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
		$picklist = '';
		foreach ($cariakt as $key => $val) {
			if ($val['INVENTORY_ITEM_ID'] == $inv_id && $val['TGL_URUT'] == $tgl) {
				$aktual = $val['QUANTITY'];
				$complete = $val['QUANTITY_COMPLETE'];
				$picklist = $val['QUANTITY_PICKLIST'];
			}else {
				$aktual = $aktual;
				$complete = $complete;
				$picklist = $picklist;
			}
		}
		$min = $this->minplan($plan, $aktual);
		$plmin = $this->minplan($plan, $picklist);
		$cmin = $this->minplan($plan, $complete);
		$data = array($aktual, $min, $complete, $picklist, $plmin, $cmin);
		return $data;
	}

	public function minplan($plan, $plakt){
		if ($plan == '' && $plakt != '') {
			$min = $plakt;
		}elseif ($plan == '' && $plakt == '') {
			$min = '';
		}elseif ($plan != '' && $plakt == '') {
			$min = $plan*-1;
		}else {
			$min = $plakt - $plan;
		}
		return $min;
	}

	public function commentmin(){
		$item 		= $this->input->post('item');
		$desc 		= $this->input->post('desc');
		$inv 		= $this->input->post('inv');
		$bulan 		= $this->input->post('bulan');
		$bulan2 	= $this->input->post('bulan2');
		$kategori 	= $this->input->post('kategori');
		$tgl 		= $this->input->post('tgl');
		$ket 		= $this->input->post('ket');
		
		if ($ket == 'MIN') {
			$comment = $this->M_monitoring->getcomment($kategori, $bulan2, $inv, $tgl);
			$tanda = 1;
			$warna = '#F6D673';
			$judul = 'A - P';
		}elseif ($ket == 'PLMIN') {
			$comment = $this->M_monitoring->getcommentPL($kategori, $bulan2, $inv, $tgl);
			$tanda = 2;
			$warna = '#FFB670';
			$judul = 'PL - P';
		}else {
			$comment = $this->M_monitoring->getcommentC($kategori, $bulan2, $inv, $tgl);
			$tanda = 3;
			$warna = '#F5817F';
			$judul = 'C - P';
		}
		if (!empty($comment)) {
			$komen = $comment[0]['KETERANGAN'];
			$save = 'style="display:none"';
			$edit = '';
			$diss = 'readonly';
		}else {
			$komen = $save = $diss = '';
			$edit = 'style="display:none"';
		}

		$view = '<div class="modal-header" style="font-size:25px;background-color:'.$warna.'">
					<i class="fa fa-list-alt"></i> Comment '.$judul.'
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="panel-body">
						<input type="hidden" id="kategori" value="'.$kategori.'">
						<input type="hidden" id="bulanmin" value="'.$bulan2.'">
						<input type="hidden" id="inv" value="'.$inv.'">
						<input type="hidden" id="tgl" value="'.$tgl.'">
						<div class="col-md-2" style="font-weight:bold">Kode</div>
						<div class="col-md-10">: '.$item.'</div>
						<div class="col-md-2" style="font-weight:bold">Deskripsi</div>
						<div class="col-md-10">: '.$desc.'</div>
						<div class="col-md-2" style="font-weight:bold">Tanggal</div>
						<div class="col-md-10">: '.$tgl.'/'.$bulan.'</div>
					</div>
					<div class="panel-body">
						<div class="input-group">
							<input name="comment" id="comment" class="form-control" value="'.$komen.'" placeholder="comment..." '.$diss.' autocomplete="off">
							<span class="input-group-btn">
								<button type="button" id="editcommentmin" class="btn bg-orange" onclick="editcomment()" '.$edit.'><i class="fa fa-pencil"></i> Edit</button>
								<button type="button" id="savecommentmin" class="btn btn-danger" onclick="saveCommentmin('.$tanda.')" '.$save.'><i class="fa fa-save"></i> Save</button>
							</span>
						</div>
					</div>
				</div>
		';
		echo $view;
	}

	public function saveComment(){
		$inv 		= $this->input->post('inv');
		$kategori 	= $this->input->post('kategori');
		$bulan 		= $this->input->post('bulan');
		$tgl 		= $this->input->post('tgl');
		$comment 	= $this->input->post('comment');
		$cek = $this->M_monitoring->getcomment($kategori, $bulan, $inv, $tgl);
		if (empty($cek)) {
			$this->M_monitoring->savecomment($kategori, $bulan, $inv, $tgl, $comment);
		}else {
			$this->M_monitoring->updatecomment($kategori, $bulan, $inv, $tgl, $comment);
		}
	}
	
	public function saveCommentPL(){
		$inv 		= $this->input->post('inv');
		$kategori 	= $this->input->post('kategori');
		$bulan 		= $this->input->post('bulan');
		$tgl 		= $this->input->post('tgl');
		$comment 	= $this->input->post('comment');
		$cek = $this->M_monitoring->getcommentPL($kategori, $bulan, $inv, $tgl);
		if (empty($cek)) {
			$this->M_monitoring->savecommentPL($kategori, $bulan, $inv, $tgl, $comment);
		}else {
			$this->M_monitoring->updatecommentPL($kategori, $bulan, $inv, $tgl, $comment);
		}
	}
	
	public function saveCommentC(){
		$inv 		= $this->input->post('inv');
		$kategori 	= $this->input->post('kategori');
		$bulan 		= $this->input->post('bulan');
		$tgl 		= $this->input->post('tgl');
		$comment 	= $this->input->post('comment');
		$cek = $this->M_monitoring->getcommentC($kategori, $bulan, $inv, $tgl);
		if (empty($cek)) {
			$this->M_monitoring->savecommentC($kategori, $bulan, $inv, $tgl, $comment);
		}else {
			$this->M_monitoring->updatecommentC($kategori, $bulan, $inv, $tgl, $comment);
		}
	}

	public function simulasi($no, $tgl)
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Simulasi Job Produksi';
		$data['Menu'] = 'Monitoring Job Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$user = $this->session->user;
		$cekHak = $this->M_usermng->getUser("where no_induk = '$user'");
		if (!empty($cekHak)) {
			if ($cekHak[0]['JENIS'] == 'Admin') {
				$data['UserMenu'] = array($UserMenu[0], $UserMenu[1]);
			}else {
				$data['UserMenu'] = $UserMenu;
			}
		}else {
			$data['UserMenu'] = $UserMenu;
		}

		$data['no'] 		= $no;
		$data['tanggal'] 	= $tgl;
        $data['kategori']  	= $this->input->post('kategori');
		$data['bulan'] 		= $this->input->post('bulan');
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
		$ket 	= $this->input->post('ket');
		$data['level'] = $this->input->post('level');
		$data['nomor'] = $this->input->post('nomor');

		$param = $ket == 'z' ? "and msib2.SEGMENT1 like '%Z-%'" : '';

		$getdata = $this->M_monitoring->getdataSimulasi($item, $qty, $param);
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
		$int_assygt = $this->input->post('int_assygt');
		$int_assy 	= $this->input->post('int_assy');
		$int_macha 	= $this->input->post('int_macha');
		$int_machb 	= $this->input->post('int_machb');
		$int_machc 	= $this->input->post('int_machc');
		$int_machd 	= $this->input->post('int_machd');
		$jumlah 	= $this->input->post('jumlah');
		
		$view = '
			<div class="modal-header" style="font-size:25px;background-color:#82E5FA">
				<i class="fa fa-list-alt"></i> Detail Gudang
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="panel-body">
					<div class="col-md-2" style="font-weight:bold">Kode</div>
					<div class="col-md-10">: '.$item.'</div>
					<div class="col-md-2" style="font-weight:bold">Deskripsi</div>
					<div class="col-md-10">: '.$desc.'</div>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hovered table-stripped text-center" id="tbl_modal_simulasi" style="width:100%;font-size:12px">
						<thead style="background-color:#82E5FA">
							<tr>
								<th style="vertical-align:middle">DFG</th>
								<th style="vertical-align:middle">DMC</th>
								<th style="vertical-align:middle">FG-TKS</th>
								<th style="vertical-align:middle">INT-PAINT</th>
								<th style="vertical-align:middle">INT-WELD</th>
								<th style="vertical-align:middle">INT-SUB</th>
								<th style="vertical-align:middle">INT-ASSYGT</th>
								<th style="vertical-align:middle">INT-ASSY</th>
								<th style="vertical-align:middle">INT-MACHA</th>
								<th style="vertical-align:middle">INT-MACHB</th>
								<th style="vertical-align:middle">INT-MACHC</th>
								<th style="vertical-align:middle">INT-MACHD</th>
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
								<td>'.$int_assygt.'</td>
								<td>'.$int_assy.'</td>
								<td>'.$int_macha.'</td>
								<td>'.$int_machb.'</td>
								<td>'.$int_machc.'</td>
								<td>'.$int_machd.'</td>
								<td>'.$pnl_tks.'</td>
								<td>'.$sm_tks.'</td>
								<td class="bg-info" style="font-weight:bold;">'.$jumlah.'</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		';
		echo $view;
	}
	
	public function detailWIP(){
		$item 		= $this->input->post('item');
		$desc 		= $this->input->post('desc');
		$wip 		= $this->input->post('wip');
		$getdata = $this->M_monitoring->getdataWIP($item);
		// echo "<pre>";print_r($getdata);exit();
		$no = 1;
		$td = '';
		foreach ($getdata as $key => $val) {
			$td .= '
				<tr>
					<td>'.$no.'</td>
					<td>'.$val['WIP_ENTITY_NAME'].'</td>
					<td>'.$val['START_QUANTITY'].'</td>
					<td>'.$val['SCHEDULED_START_DATE'].'</td>
					<td>'.$val['REMAINING_QTY'].'</td>
				</tr>
			';
			$no++;
		}
		
		$view = '
			<div class="modal-header" style="font-size:25px;background-color:#82E5FA">
				<i class="fa fa-list-alt"></i> Detail WIP
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="panel-body">
					<div class="col-md-2" style="font-weight:bold">Kode</div>
					<div class="col-md-10">: '.$item.'</div>
					<div class="col-md-2" style="font-weight:bold">Deskripsi</div>
					<div class="col-md-10">: '.$desc.'</div>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hovered table-stripped text-center" id="tbl_modal_simulasi" style="width:100%;">
						<thead style="background-color:#82E5FA">
							<tr>
								<th style="width:7%">No</th>
								<th>No Job</th>
								<th>Qty</th>
								<th>Tanggal</th>
								<th>Remaining Qty</th>
							</tr>
						</thead>
						<tbody>
							'.$td.'
						</tbody>
					</table>
				</div>
			</div>
		';
		echo $view;
	}

	public function exportJob(){
		$no 		= $this->input->post('nomor[]');
		$bulan 		= $this->input->post('bulan');
		$kategori 	= $this->input->post('kategori');
		$bulan2 	= $this->input->post('bulan2');
		$kategori2 	= $this->input->post('kategori2');
		$hari 		= $this->input->post('hari');
		$datanya = array();
		for ($i=0; $i < (count($no)/2); $i++) { 
			$baris['inv'] = $this->input->post('inv'.$no[$i].'');
			$baris['item'] = $this->input->post('item'.$no[$i].'');
			$baris['desc'] = $this->input->post('desc'.$no[$i].'');
			$baris['jml_plan'] = $this->input->post('jml_plan'.$no[$i].'');
			$baris['jml_akt'] = $this->input->post('jml_akt'.$no[$i].'');
			$baris['jml_min'] = $this->input->post('jml_min'.$no[$i].'');
			$baris['jml_com'] = $this->input->post('jml_com'.$no[$i].'');
			$baris['jml_pl'] = $this->input->post('jml_pl'.$no[$i].'');
			$baris['jml_plmin'] = $this->input->post('jml_plmin'.$no[$i].'');
			$baris['jml_cmin'] = $this->input->post('jml_cmin'.$no[$i].'');
			for ($x=0; $x < $hari; $x++) { 
				$baris['plan'.$x.''] = $this->input->post('plan'.$no[$i].''.($x+1).'');
				$baris['akt'.$x.''] = $this->input->post('akt'.$no[$i].''.($x+1).'');
				$baris['min'.$x.''] = $this->input->post('min'.$no[$i].''.($x+1).'');
				$baris['com'.$x.''] = $this->input->post('com'.$no[$i].''.($x+1).'');
				$baris['pl'.$x.''] = $this->input->post('pl'.$no[$i].''.($x+1).'');
				$baris['plmin'.$x.''] = $this->input->post('plmin'.$no[$i].''.($x+1).'');
				$baris['cmin'.$x.''] = $this->input->post('cmin'.$no[$i].''.($x+1).'');
			}
			array_push($datanya, $baris);
		}

		$total['jml_item'] = $this->input->post('jml_item');
		$total['ttl_jml_plan'] = $this->input->post('ttl_jml_plan');
		$total['ttl_jml_akt'] = $this->input->post('ttl_jml_akt');
		$total['ttl_jml_min'] = $this->input->post('ttl_jml_min');
		$total['ttl_jml_com'] = $this->input->post('ttl_jml_com');
		$total['ttl_jml_pl'] = $this->input->post('ttl_jml_pl');
		$total['ttl_jml_plmin'] = $this->input->post('ttl_jml_plmin');
		$total['ttl_jml_cmin'] = $this->input->post('ttl_jml_cmin');
		for ($t=0; $t < $hari; $t++) { 
			$total['ttl_plan'.$t.''] = $this->input->post('total_plan'.$t.'');
			$total['ttl_akt'.$t.''] = $this->input->post('total_akt'.$t.'');
			$total['ttl_min'.$t.''] = $this->input->post('total_min'.$t.'');
			$total['ttl_com'.$t.''] = $this->input->post('total_com'.$t.'');
			$total['ttl_pl'.$t.''] = $this->input->post('total_pl'.$t.'');
			$total['ttl_plmin'.$t.''] = $this->input->post('total_plmin'.$t.'');
			$total['ttl_cmin'.$t.''] = $this->input->post('total_cmin'.$t.'');
		}
		// echo "<pre>";print_r($no);exit();

		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Monitoring Job Produksi")
					->setSubject("CV. KHS")
					->setDescription("Monitoring Job Produksi")
					->setKeywords("MJP");
		
		$style_title = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style1 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'bdeefc'),
			),
			'font' => array(
				'bold' => true,
				'wrap' => true,
			), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style2 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style3 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		$style4 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'E6E8E6'),
			),
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		if ($hari == 31) {
			$akhir = 'AI';
			$ajml = 'AJ';
		}elseif ($hari == 30) {
			$akhir = 'AH';
			$ajml = 'AI';
		}elseif ($hari == 29){
			$akhir = 'AG';
			$ajml = 'AH';
		}else {
			$akhir = 'AF';
			$ajml = 'AG';
		}

		//TITLE
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "MONITORING JOB PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$akhir."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Kategori"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B2', ": ".$kategori); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Bulan"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B3', ": ".$bulan); 

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "KODE");
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "DESKRIPSI");
		$excel->setActiveSheetIndex(0)->setCellValue('D5', "");
		$excel->setActiveSheetIndex(0)->setCellValue('E5', "TANGGAL");
		$excel->getActiveSheet()->mergeCells("A5:A6"); 
		$excel->getActiveSheet()->mergeCells("B5:B6"); 
		$excel->getActiveSheet()->mergeCells("C5:C6"); 
		$excel->getActiveSheet()->mergeCells("D5:D6"); 
		$excel->getActiveSheet()->mergeCells("E5:".$akhir."5"); 
		
		$row = 6;
		$col = 4;
		for ($i=0; $i < $hari ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
			$col++;
		}
		$excel->setActiveSheetIndex(0)->setCellValue("".$ajml."5", "JUMLAH");
		$excel->getActiveSheet()->mergeCells("".$ajml."5:".$ajml."6"); 
		
		$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("E5:".$akhir."6")->applyFromArray($style1);
		for ($n=4; $n < ($hari+5) ; $n++) { // styling tanggal col 4 - akhir
			$a = $this->numbertoalpha($n);
			$excel->getActiveSheet()->getStyle("".$a."6")->applyFromArray($style1);
		}
		$excel->getActiveSheet()->getStyle("".$ajml."5:".$ajml."6")->applyFromArray($style1);
		
		$no=1;
		$numrow = 7;
		$sesuatu = 6;
		foreach ($datanya as $d) {	
			// echo "<pre>";print_r($d);exit();
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $d['item']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $d['desc']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "P");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+1), "A");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+2), "(A - P)");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+3), "PL");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+4), "(PL - P)");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+5), "C");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+6), "(C - P)");
			$row = $numrow;
			for ($p=0; $p < 7; $p++) { 
				$col = 4;
				for ($i=0; $i < $hari ; $i++) { // value per tanggal
					if ($p == 0) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['plan'.$i.'']);
					}elseif ($p == 1) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['akt'.$i.'']);
					}elseif ($p == 2) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['min'.$i.'']);
					}elseif($p == 3) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['pl'.$i.'']);
					}elseif($p == 4) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['plmin'.$i.'']);
					}elseif($p == 5) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['com'.$i.'']);
					}elseif($p == 6) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['cmin'.$i.'']);
					}
					$col++;
				}
				$ket_jml = $p == 0 ? $d['jml_plan'] : (
					$p == 1 ? $d['jml_akt'] : (
						$p == 2 ? $d['jml_min'] : (
							$p == 3 ? $d['jml_pl'] : (
								$p == 4 ? $d['jml_plmin'] : (
									$p == 5 ? $d['jml_com'] : $d['jml_cmin'] 
									) 
								) 
							)
						)
					);
				$excel->setActiveSheetIndex(0)->setCellValue($ajml.$row, $ket_jml);
				$row++;
			}

			$baris2 = $numrow + 1;
			$baris3 = $numrow + 2;
			$baris4 = $numrow + 3;
			$baris5 = $numrow + 4;
			$baris6 = $numrow + 5;
			$merge = $numrow + 6;
			// echo "<pre>";print_r($numrow);exit();
			$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
			$excel->getActiveSheet()->mergeCells("B$numrow:B$merge"); 
			$excel->getActiveSheet()->mergeCells("C$numrow:C$merge"); 
			for ($i=0; $i < 7 ; $i++) { 
				$baris = $numrow+$i;
				$excel->getActiveSheet()->getStyle("A$baris")->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle("B$baris")->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle("C$baris")->applyFromArray($style2);
				
				for ($n=3; $n < ($hari+5) ; $n++) { // styling kolom tanggal/baris
					$a = $this->numbertoalpha($n);
					$excel->getActiveSheet()->getStyle("$a$baris")->applyFromArray($style3);
				}
			}
			$numrow = $merge + 1;
			$no++;
		}
		//total
		$baris2 = $numrow + 1;
		$baris3 = $numrow + 2;
		$baris4 = $numrow + 3;
		$baris5 = $numrow + 4;
		$baris6 = $numrow + 5;
		$merge = $numrow + 6;
		$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "Total"); 
		$excel->setActiveSheetIndex(0)->setCellValue("B$numrow", $total['jml_item']); 
		$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
		$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
		$excel->getActiveSheet()->mergeCells("B$numrow:C$merge"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$numrow", "P"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$baris2", "A"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$baris3", "(A - P)"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$baris4", "PL"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$baris5", "(PL - P)"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$baris6", "C"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$merge", "(C - P)"); 
		$row = $numrow;
		for ($p=0; $p < 7; $p++) { 
			$col = 4;
			for ($i=0; $i < $hari ; $i++) { // value per tanggal
				if ($p == 0) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_plan'.$i.'']);
				}elseif ($p == 1) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_akt'.$i.'']);
				}elseif ($p == 2) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_min'.$i.'']);
				}elseif($p == 3) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_pl'.$i.'']);
				}elseif($p == 4) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_plmin'.$i.'']);
				}elseif($p == 5) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_com'.$i.'']);
				}elseif($p == 6) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_cmin'.$i.'']);
				}
				$a = $this->numbertoalpha($col);
				$excel->getActiveSheet()->getStyle("$a$row")->applyFromArray($style4);
				$col++;
			}
			$ket_jml = $p == 0 ? $total['ttl_jml_plan'] : (
				$p == 1 ? $total['ttl_jml_akt'] : (
					$p == 2 ? $total['ttl_jml_min'] : (
						$p == 3 ? $total['ttl_jml_pl'] : (
							$p == 4 ? $total['ttl_jml_plmin'] : (
								$p == 5 ? $total['ttl_jml_com'] : $total['ttl_jml_cmin']
								)
							)
						)
					)
				);
			$excel->setActiveSheetIndex(0)->setCellValue($ajml.$row, $ket_jml);
			$excel->getActiveSheet()->getStyle("A$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("B$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("C$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("D$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle($ajml.$row)->applyFromArray($style4);
			$row++;
		}
		$excel->getActiveSheet(0)->setTitle("Monitoring Job Produksi");
		// WIDTH
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		for($col = 'D'; $col !== $ajml; $col++) { // autowidth
			$excel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
		}
		$excel->getActiveSheet()->getColumnDimension($ajml)->setWidth(10); 
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);


		//SHEET 2 COMMENT
		$excel->createSheet();
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "MONITORING JOB PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$akhir."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		$excel->setActiveSheetIndex(1)->setCellValue('A2', "Kategori"); 
		$excel->setActiveSheetIndex(1)->setCellValue('B2', ": ".$kategori); 
		
		$excel->setActiveSheetIndex(1)->setCellValue('A3', "Bulan"); 
		$excel->setActiveSheetIndex(1)->setCellValue('B3', ": ".$bulan); 

		$excel->setActiveSheetIndex(1)->setCellValue('A5', "NO.");
		$excel->setActiveSheetIndex(1)->setCellValue('B5', "KODE");
		$excel->setActiveSheetIndex(1)->setCellValue('C5', "DESKRIPSI");
		$excel->setActiveSheetIndex(1)->setCellValue('D5', "");
		$excel->setActiveSheetIndex(1)->setCellValue('E5', "TANGGAL");
		$excel->getActiveSheet()->mergeCells("A5:A6"); 
		$excel->getActiveSheet()->mergeCells("B5:B6"); 
		$excel->getActiveSheet()->mergeCells("C5:C6"); 
		$excel->getActiveSheet()->mergeCells("D5:D6"); 
		$excel->getActiveSheet()->mergeCells("E5:".$akhir."5"); 
		
		$row = 6;
		$col = 4;
		for ($i=0; $i < $hari ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
			$col++;
		}
		
		$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("E5:".$akhir."6")->applyFromArray($style1);
		for ($n=4; $n < ($hari+4) ; $n++) { // styling tanggal col 4 - akhir
			$a = $this->numbertoalpha($n);
			$excel->getActiveSheet()->getStyle("".$a."6")->applyFromArray($style1);
		}

		$no=1;
		$numrow = 7;
		$sesuatu = 6;
		foreach ($datanya as $d) {	
			// echo "<pre>";print_r($kategori);exit();
			$excel->setActiveSheetIndex(1)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(1)->setCellValue('B'.$numrow, $d['item']);
			$excel->setActiveSheetIndex(1)->setCellValue('C'.$numrow, $d['desc']);
			$excel->setActiveSheetIndex(1)->setCellValue('D'.$numrow, "(A - P)");
			$excel->setActiveSheetIndex(1)->setCellValue('D'.($numrow+1), "(PL - P)");
			$excel->setActiveSheetIndex(1)->setCellValue('D'.($numrow+2), "(C - P)");
			$row = $numrow;
			for ($p=0; $p < 3; $p++) { 
				$col = 4;
				for ($i=0; $i < $hari ; $i++) { // value per tanggal
					if ($p == 0) {
						$comment = $this->getComment($kategori2, $bulan2, $d['inv'], ($i+1), 'PA');
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $comment);
					}elseif ($p == 1) {
						$comment = $this->getComment($kategori2, $bulan2, $d['inv'], ($i+1), 'PLP');
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $comment);
					}elseif ($p == 2) {
						$comment = $this->getComment($kategori2, $bulan2, $d['inv'], ($i+1), 'PC');
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $comment);
					}
					$col++;
				}
				$row++;
			}

			$baris2 = $numrow + 1;
			$merge = $numrow + 2;
			// echo "<pre>";print_r($numrow);exit();
			$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
			$excel->getActiveSheet()->mergeCells("B$numrow:B$merge"); 
			$excel->getActiveSheet()->mergeCells("C$numrow:C$merge"); 
			for ($i=0; $i < 3 ; $i++) { 
				$baris = $numrow+$i;
				$excel->getActiveSheet()->getStyle("A$baris")->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle("B$baris")->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle("C$baris")->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle("D$baris")->applyFromArray($style3);
				
				for ($n=4; $n < ($hari+4) ; $n++) { // styling kolom tanggal/baris
					$a = $this->numbertoalpha($n);
					$excel->getActiveSheet()->getStyle("$a$baris")->applyFromArray($style2);
				}
			}
			$numrow = $merge + 1;
			$no++;
		}
				


		// WIDTH
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		for($col = 'D'; $col !== $ajml; $col++) { // autowidth
			$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		$excel->getActiveSheet()->getColumnDimension($ajml)->setWidth(10); 
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(1)->setTitle("Comment");
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Monitoring-Job-Produksi-'.$kategori.'-'.$bulan.'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

	
	public function exportJobPLA(){
		$no 		= $this->input->post('nomor[]');
		$bulan 		= $this->input->post('bulan');
		$kategori 	= $this->input->post('kategori');
		$bulan2 		= $this->input->post('bulan2');
		$kategori2 	= $this->input->post('kategori2');
		$hari 		= $this->input->post('hari');
		$ket 		= $this->input->post('ket');
		$datanya = array();
		for ($i=0; $i < (count($no)/2); $i++) { 
			$baris['inv'] = $this->input->post('inv'.$no[$i].'');
			$baris['item'] = $this->input->post('item'.$no[$i].'');
			$baris['desc'] = $this->input->post('desc'.$no[$i].'');
			$baris['jml_plan'] = $this->input->post('jml_plan'.$no[$i].'');
			if ($ket == 'PA') {
				$baris['jml_pa'] = $this->input->post('jml_akt'.$no[$i].'');
				$baris['jml_min'] = $this->input->post('jml_min'.$no[$i].'');
			}elseif($ket == 'PLP'){
				$baris['jml_pa'] = $this->input->post('jml_pl'.$no[$i].'');
				$baris['jml_min'] = $this->input->post('jml_plmin'.$no[$i].'');
			}elseif($ket == 'PC'){
				$baris['jml_pa'] = $this->input->post('jml_com'.$no[$i].'');
				$baris['jml_min'] = $this->input->post('jml_cmin'.$no[$i].'');
			}
			for ($x=0; $x < $hari; $x++) { 
				$baris['plan'.$x.''] = $this->input->post('plan'.$no[$i].''.($x+1).'');
				if ($ket == 'PA') {
					$baris['pa'.$x.''] = $this->input->post('akt'.$no[$i].''.($x+1).'');
					$baris['min'.$x.''] = $this->input->post('min'.$no[$i].''.($x+1).'');
				}elseif($ket == 'PLP'){
					$baris['pa'.$x.''] = $this->input->post('pl'.$no[$i].''.($x+1).'');
					$baris['min'.$x.''] = $this->input->post('plmin'.$no[$i].''.($x+1).'');
				}elseif($ket == 'PC'){
					$baris['pa'.$x.''] = $this->input->post('com'.$no[$i].''.($x+1).'');
					$baris['min'.$x.''] = $this->input->post('cmin'.$no[$i].''.($x+1).'');
				}
			}
			array_push($datanya, $baris);
		}


		
		$total['jml_item'] = $this->input->post('jml_item');
		$total['ttl_jml_plan'] = $this->input->post('ttl_jml_plan');
		if ($ket == 'PA') {
			$total['ttl_jml_pa'] = $this->input->post('ttl_jml_akt');
			$total['ttl_jml_min'] = $this->input->post('ttl_jml_min');
		}elseif($ket == 'PLP'){
			$total['ttl_jml_pa'] = $this->input->post('ttl_jml_pl');
			$total['ttl_jml_min'] = $this->input->post('ttl_jml_plmin');
		}elseif($ket == 'PC'){
			$total['ttl_jml_pa'] = $this->input->post('ttl_jml_com');
			$total['ttl_jml_min'] = $this->input->post('ttl_jml_cmin');
		}
		for ($t=0; $t < $hari; $t++) { 
			$total['ttl_plan'.$t.''] = $this->input->post('total_plan'.$t.'');
			if ($ket == 'PA') {
				$total['ttl_pa'.$t.''] = $this->input->post('total_akt'.$t.'');
				$total['ttl_min'.$t.''] = $this->input->post('total_min'.$t.'');
			}elseif($ket == 'PLP'){
				$total['ttl_pa'.$t.''] = $this->input->post('total_pl'.$t.'');
				$total['ttl_min'.$t.''] = $this->input->post('total_plmin'.$t.'');
			}elseif($ket == 'PC'){
				$total['ttl_pa'.$t.''] = $this->input->post('total_com'.$t.'');
				$total['ttl_min'.$t.''] = $this->input->post('total_cmin'.$t.'');
			}
		}
		// echo "<pre>";print_r($no);exit();

		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Monitoring Job Produksi")
					->setSubject("CV. KHS")
					->setDescription("Monitoring Job Produksi")
					->setKeywords("MJP");
		
		$style_title = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style1 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'bdeefc'),
			),
			'font' => array(
				'bold' => true,
				'wrap' => true,
			), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style2 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style3 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		$style4 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'E6E8E6'),
			),
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		if ($hari == 31) {
			$akhir = 'AI';
			$ajml = 'AJ';
		}elseif ($hari == 30) {
			$akhir = 'AH';
			$ajml = 'AI';
		}elseif ($hari == 29){
			$akhir = 'AG';
			$ajml = 'AH';
		}else {
			$akhir = 'AF';
			$ajml = 'AG';
		}

		//TITLE
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "MONITORING JOB PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$akhir."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Kategori"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B2', ": ".$kategori); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Bulan"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B3', ": ".$bulan); 

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "KODE");
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "DESKRIPSI");
		$excel->setActiveSheetIndex(0)->setCellValue('D5', "");
		$excel->setActiveSheetIndex(0)->setCellValue('E5', "TANGGAL");
		$excel->getActiveSheet()->mergeCells("A5:A6"); 
		$excel->getActiveSheet()->mergeCells("B5:B6"); 
		$excel->getActiveSheet()->mergeCells("C5:C6"); 
		$excel->getActiveSheet()->mergeCells("D5:D6"); 
		$excel->getActiveSheet()->mergeCells("E5:".$akhir."5"); 
		
		$row = 6;
		$col = 4;
		for ($i=0; $i < $hari ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
			$col++;
		}
		$excel->setActiveSheetIndex(0)->setCellValue("".$ajml."5", "JUMLAH");
		$excel->getActiveSheet()->mergeCells("".$ajml."5:".$ajml."6"); 
		
		$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("E5:".$akhir."6")->applyFromArray($style1);
		for ($n=4; $n < ($hari+5) ; $n++) { // styling tanggal col 4 - akhir
			$a = $this->numbertoalpha($n);
			$excel->getActiveSheet()->getStyle("".$a."6")->applyFromArray($style1);
		}
		$excel->getActiveSheet()->getStyle("".$ajml."5:".$ajml."6")->applyFromArray($style1);
		
		$no=1;
		$numrow = 7;
		$sesuatu = 6;
		$pa = $ket == 'PA' ? 'A' : (
				$ket == 'PLP' ? 'PL' : 'C' );
		$min = $ket == 'PA' ? '(A - P)' : (
				$ket == 'PLP' ? '(PL - P)' : '(C - P)');
		foreach ($datanya as $d) {	
			// echo "<pre>";print_r($d);exit();
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $d['item']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $d['desc']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "P");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+1), $pa);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+2), $min);
			$row = $numrow;
			for ($p=0; $p < 4; $p++) { 
				$col = 4;
				for ($i=0; $i < $hari ; $i++) { // value per tanggal
					if ($p == 0) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['plan'.$i.'']);
					}elseif ($p == 1) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['pa'.$i.'']);
					}elseif ($p == 2) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['min'.$i.'']);
					}
					$col++;
				}
				$ket_jml = $p == 0 ? $d['jml_plan'] : (
					$p == 1 ? $d['jml_pa'] : $d['jml_min'] 
					);
				$excel->setActiveSheetIndex(0)->setCellValue($ajml.$row, $ket_jml);
				$row++;
			}

			$baris2 = $numrow + 1;
			$merge = $numrow + 2;
			// echo "<pre>";print_r($numrow);exit();
			$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
			$excel->getActiveSheet()->mergeCells("B$numrow:B$merge"); 
			$excel->getActiveSheet()->mergeCells("C$numrow:C$merge"); 
			for ($i=0; $i < 4 ; $i++) { 
				$baris = $numrow+$i;
				$excel->getActiveSheet()->getStyle("A$baris")->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle("B$baris")->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle("C$baris")->applyFromArray($style2);
				
				for ($n=3; $n < ($hari+5) ; $n++) { // styling kolom tanggal/baris
					$a = $this->numbertoalpha($n);
					$excel->getActiveSheet()->getStyle("$a$baris")->applyFromArray($style3);
				}
			}
			$numrow = $merge + 1;
			$no++;
		}
		//total
		$baris2 = $numrow + 1;
		$merge = $numrow + 2;
		$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "Total"); 
		$excel->setActiveSheetIndex(0)->setCellValue("B$numrow", $total['jml_item']); 
		$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
		$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
		$excel->getActiveSheet()->mergeCells("B$numrow:C$merge"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$numrow", "P"); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$baris2", $pa); 
		$excel->setActiveSheetIndex(0)->setCellValue("D$merge", $min); 
		$row = $numrow;
		for ($p=0; $p < 3; $p++) { 
			$col = 4;
			for ($i=0; $i < $hari ; $i++) { // value per tanggal
				if ($p == 0) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_plan'.$i.'']);
				}elseif ($p == 1) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_pa'.$i.'']);
				}elseif ($p == 2) {
					$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $total['ttl_min'.$i.'']);
				}
				$a = $this->numbertoalpha($col);
				$excel->getActiveSheet()->getStyle("$a$row")->applyFromArray($style4);
				$col++;
			}
			$ket_jml = $p == 0 ? $total['ttl_jml_plan'] : (
				$p == 1 ? $total['ttl_jml_pa'] : $total['ttl_jml_min'] 
				);
			$excel->setActiveSheetIndex(0)->setCellValue($ajml.$row, $ket_jml);
			$excel->getActiveSheet()->getStyle("A$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("B$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("C$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("D$row")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle($ajml.$row)->applyFromArray($style4);
			$row++;
		}
				
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		for($col = 'D'; $col !== $ajml; $col++) { // autowidth
			$excel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
		}
		$excel->getActiveSheet()->getColumnDimension($ajml)->setWidth(10); 
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet(0)->setTitle("Monitoring Job Produksi");

		//SHEET 2
		$excel->createSheet();
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "MONITORING JOB PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$akhir."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		$excel->setActiveSheetIndex(1)->setCellValue('A2', "Kategori"); 
		$excel->setActiveSheetIndex(1)->setCellValue('B2', ": ".$kategori); 
		
		$excel->setActiveSheetIndex(1)->setCellValue('A3', "Bulan"); 
		$excel->setActiveSheetIndex(1)->setCellValue('B3', ": ".$bulan); 

		$excel->setActiveSheetIndex(1)->setCellValue('A5', "NO.");
		$excel->setActiveSheetIndex(1)->setCellValue('B5', "KODE");
		$excel->setActiveSheetIndex(1)->setCellValue('C5', "DESKRIPSI");
		$excel->setActiveSheetIndex(1)->setCellValue('D5', "");
		$excel->setActiveSheetIndex(1)->setCellValue('E5', "TANGGAL");
		$excel->getActiveSheet()->mergeCells("A5:A6"); 
		$excel->getActiveSheet()->mergeCells("B5:B6"); 
		$excel->getActiveSheet()->mergeCells("C5:C6"); 
		$excel->getActiveSheet()->mergeCells("D5:D6"); 
		$excel->getActiveSheet()->mergeCells("E5:".$akhir."5"); 
		
		$row = 6;
		$col = 4;
		for ($i=0; $i < $hari ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
			$col++;
		}
		
		$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("E5:".$akhir."6")->applyFromArray($style1);
		for ($n=4; $n < ($hari+4) ; $n++) { // styling tanggal col 4 - akhir
			$a = $this->numbertoalpha($n);
			$excel->getActiveSheet()->getStyle("".$a."6")->applyFromArray($style1);
		}
		
		$no=1;
		$numrow = 7;
		$sesuatu = 6;
		foreach ($datanya as $d) {	
			// echo "<pre>";print_r($d);exit();
			$excel->setActiveSheetIndex(1)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(1)->setCellValue('B'.$numrow, $d['item']);
			$excel->setActiveSheetIndex(1)->setCellValue('C'.$numrow, $d['desc']);
			$excel->setActiveSheetIndex(1)->setCellValue('D'.$numrow, $min);
			$col = 4;
			for ($i=0; $i < $hari ; $i++) { // value per tanggal
				$comment = $this->getComment($kategori2, $bulan2, $d['inv'], ($i+1), $ket);
				$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $numrow, $comment);
				$col++;
			}

			// $baris = $numrow+$i;
			$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style2);
			$excel->getActiveSheet()->getStyle("C$numrow")->applyFromArray($style2);
			$excel->getActiveSheet()->getStyle("D$numrow")->applyFromArray($style3);
			for ($n=4; $n < ($hari+4) ; $n++) { // styling kolom tanggal/numrow
				$a = $this->numbertoalpha($n);
				$excel->getActiveSheet()->getStyle("$a$numrow")->applyFromArray($style2);
			}
			$numrow++;
			$no++;
		}
				
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		for($col = 'D'; $col !== $ajml; $col++) { // autowidth
			$excel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
		}
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(1)->setTitle("Comment");
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Monitoring-Job-Produksi-'.$kategori.'-'.$bulan.'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
	

	public function numbertoalpha($n){
		for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
		$r = chr($n%26 + 0x41) . $r;
		return $r;
	}

	public function getComment($kategori, $bulan, $inv, $tgl, $ket){
		if ($ket == 'PA') {
			$comment = $this->M_monitoring->getcomment($kategori, $bulan, $inv, $tgl);
		}elseif ($ket == 'PLP') {
			$comment = $this->M_monitoring->getcommentPL($kategori, $bulan, $inv, $tgl);
		}else {
			$comment = $this->M_monitoring->getcommentC($kategori, $bulan, $inv, $tgl);
		}
		$hasil = !empty($comment) ? $comment[0]['KETERANGAN'] : '';
		return $hasil;
	}

	public function exportReport(){
		$kategori 	= $this->input->post('kategori[]');
		$kategori2 	= $this->input->post('kategori2[]');
		$bulan		= $this->input->post('bulan[]');
		$bulan2		= explode("/", $bulan[0]);
		$bulan2		= $bulan2[1].$bulan2[0];
		$tglawal	= $this->input->post('tglawal[]');
		$tglakhir	= $this->input->post('tglakhir[]');
			// echo "<pre>";print_r($tglakhir);exit();

		for ($i=0; $i < count($kategori) ; $i++) { 
			$datanya[$kategori[$i]] = array();
			$nomor = $this->input->post('nomor'.$i.'[]');
			$baris['jml_item'] = $this->input->post('jml_item'.$i.'');
			$baris['ttl_jml_plan'] = $this->input->post('ttl_jml_plan'.$i.'');
			$baris['ttl_jml_akt'] = $this->input->post('ttl_jml_akt'.$i.'');
			$baris['ttl_jml_min'] = $this->input->post('ttl_jml_min'.$i.'');
			$baris['ttl_jml_pl'] = $this->input->post('ttl_jml_pl'.$i.'');
			$baris['ttl_jml_plmin'] = $this->input->post('ttl_jml_plmin'.$i.'');
			$baris['ttl_jml_com'] = $this->input->post('ttl_jml_com'.$i.'');
			$baris['ttl_jml_cmin'] = $this->input->post('ttl_jml_cmin'.$i.'');
			for ($j=0; $j < count($nomor)/2 ; $j++) { 
				$baris['item'] = $this->input->post('item'.$i.($j+1).'');
				$baris['desc'] = $this->input->post('desc'.$i.($j+1).'');
				$baris['inv'] = $this->input->post('inv'.$i.($j+1).'');
				$baris['jml_plan'] = $this->input->post('jml_plan'.$i.($j+1).'');
				$baris['jml_akt'] = $this->input->post('jml_akt'.$i.($j+1).'');
				$baris['jml_min'] = $this->input->post('jml_min'.$i.($j+1).'');
				$baris['jml_pl'] = $this->input->post('jml_pl'.$i.($j+1).'');
				$baris['jml_plmin'] = $this->input->post('jml_plmin'.$i.($j+1).'');
				$baris['jml_com'] = $this->input->post('jml_com'.$i.($j+1).'');
				$baris['jml_cmin'] = $this->input->post('jml_cmin'.$i.($j+1).'');
				for ($p=0; $p < ($tglakhir[0] - $tglawal[0] +1) ; $p++) { 
					$baris['plan'.$p.''] = $this->input->post('plan'.$i.($j+1).$p.'');
					$baris['akt'.$p.''] = $this->input->post('akt'.$i.($j+1).$p.'');
					$baris['min'.$p.''] = $this->input->post('min'.$i.($j+1).$p.'');
					$baris['pl'.$p.''] = $this->input->post('pl'.$i.($j+1).$p.'');
					$baris['plmin'.$p.''] = $this->input->post('plmin'.$i.($j+1).$p.'');
					$baris['com'.$p.''] = $this->input->post('com'.$i.($j+1).$p.'');
					$baris['cmin'.$p.''] = $this->input->post('cmin'.$i.($j+1).$p.'');
					$baris['total_plan'.$p.''] = $this->input->post('total_plan'.$i.$p.'');
					$baris['total_akt'.$p.''] = $this->input->post('total_akt'.$i.$p.'');
					$baris['total_min'.$p.''] = $this->input->post('total_min'.$i.$p.'');
					$baris['total_pl'.$p.''] = $this->input->post('total_pl'.$i.$p.'');
					$baris['total_plmin'.$p.''] = $this->input->post('total_plmin'.$i.$p.'');
					$baris['total_com'.$p.''] = $this->input->post('total_com'.$i.$p.'');
					$baris['total_cmin'.$p.''] = $this->input->post('total_cmin'.$i.$p.'');
				}
			array_push($datanya[$kategori[$i]], $baris);
			}
			
		}
			// echo "<pre>";print_r($datanya);exit();

		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Monitoring Job Produksi")
					->setSubject("CV. KHS")
					->setDescription("Monitoring Job Produksi")
					->setKeywords("MJP");
		
		$style_title = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style1 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'bdeefc'),
			),
			'font' => array(
				'bold' => true,
				'wrap' => true,
			), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style2 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style3 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		$style4 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'E6E8E6'),
			),
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		$akhir_tgl1 = ($tglakhir[0] - $tglawal[0]) + 4;
		$akhir_tgl = $this->numbertoalpha($akhir_tgl1);
		// echo "<pre>";print_r($akhir_tgl);exit();
		$akhir1 = $akhir_tgl1 + 1;
		$akhir = $this->numbertoalpha($akhir1);
		$numjdl = 2;
		//TITLE
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "MONITORING JOB PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$akhir."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		foreach ($datanya as $key => $value) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numjdl, "Kategori"); 
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numjdl, ": ".$key); 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.($numjdl+1), "Periode"); 
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numjdl+1), ": ".$tglawal[0]."/".$bulan[0]." - ".$tglakhir[0]."/".$bulan[0].""); 
			$merg = $numjdl + 2;
			$merg2 = $numjdl + 3;
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$merg, "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$merg, "KODE");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$merg, "DESKRIPSI");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$merg, "");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$merg, "TANGGAL");
			$excel->getActiveSheet()->mergeCells("A$merg:A$merg2"); 
			$excel->getActiveSheet()->mergeCells("B$merg:B$merg2"); 
			$excel->getActiveSheet()->mergeCells("C$merg:C$merg2"); 
			$excel->getActiveSheet()->mergeCells("D$merg:D$merg2"); 
			$excel->getActiveSheet()->mergeCells("E$merg:".$akhir_tgl.$merg.""); 
			
			$row = $merg2; $col = 4;
			for ($i=($tglawal[0]-1); $i < $tglakhir[0] ; $i++) { //tanggal 1 - akhir
				$col2 = $this->numbertoalpha($col);
				$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
				$excel->getActiveSheet()->getStyle("".$col2.$row."")->applyFromArray($style1);
				$col++;
			}
			$excel->setActiveSheetIndex(0)->setCellValue("".$akhir.$merg."", "JUMLAH");
			$excel->getActiveSheet()->mergeCells("".$akhir.$merg.":".$akhir.$merg2.""); 
			
			$excel->getActiveSheet()->getStyle('A'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('B'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('B'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('C'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('C'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('D'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('D'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("E$merg:".$akhir.$merg."")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("".$akhir.$merg.":".$akhir.$merg2."")->applyFromArray($style1);

		// echo "<pre>";print_r($value);exit();
			
			$no=1;
			$numrow = $merg2 + 1;
			foreach ($value as $d) {	
				// echo "<pre>";print_r($d);exit();
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $d['item']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $d['desc']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "P");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+1), "A");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+2), "(A - P)");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+3), "PL");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+4), "(PL - P)");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+5), "C");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+6), "(C - P)");
				$row = $numrow;
				for ($p=0; $p < 7; $p++) { 
					$col = 4;
					for ($i=0; $i < ($tglakhir[0] - $tglawal[0] +1) ; $i++) { // value per tanggal
						if ($p == 0) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['plan'.$i.'']);
						}elseif ($p == 1) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['akt'.$i.'']);
						}elseif ($p == 2) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['min'.$i.'']);
						}elseif($p == 3) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['pl'.$i.'']);
						}elseif($p == 4) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['plmin'.$i.'']);
						}elseif($p == 5) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['com'.$i.'']);
						}elseif($p == 6) {
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['cmin'.$i.'']);
						}
						$col++;
					}
					$ket_jml = $p == 0 ? $d['jml_plan'] : (
						$p == 1 ? $d['jml_akt'] : (
							$p == 2 ? $d['jml_min'] : (
								$p == 3 ? $d['jml_pl'] : (
									$p == 4 ? $d['jml_plmin'] : (
										$p == 5 ? $d['jml_com'] : $d['jml_cmin'] 
										) 
									) 
								)
							)
						);
					$excel->setActiveSheetIndex(0)->setCellValue($akhir.$row, $ket_jml);
					$row++;
				}

				$baris2 = $numrow + 1;
				$baris3 = $numrow + 2;
				$baris4 = $numrow + 3;
				$baris5 = $numrow + 4;
				$baris6 = $numrow + 5;
				$merge = $numrow + 6;
				// echo "<pre>";print_r($numrow);exit();
				$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
				$excel->getActiveSheet()->mergeCells("B$numrow:B$merge"); 
				$excel->getActiveSheet()->mergeCells("C$numrow:C$merge"); 
				for ($i=0; $i < 7 ; $i++) { 
					$baris = $numrow+$i;
					$excel->getActiveSheet()->getStyle("A$baris")->applyFromArray($style3);
					$excel->getActiveSheet()->getStyle("B$baris")->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle("C$baris")->applyFromArray($style2);
					
					for ($n=3; $n < ($akhir1+1) ; $n++) { // styling kolom tanggal/baris
						$a = $this->numbertoalpha($n);
						$excel->getActiveSheet()->getStyle("$a$baris")->applyFromArray($style3);
					}
				}
				$numrow = $merge + 1;
				$no++;
			}
			//total
			$baris2 = $numrow + 1;
			$baris3 = $numrow + 2;
			$baris4 = $numrow + 3;
			$baris5 = $numrow + 4;
			$baris6 = $numrow + 5;
			$merge = $numrow + 6;
			$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "Total"); 
			$excel->setActiveSheetIndex(0)->setCellValue("B$numrow", $value[0]['jml_item']); 
			$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
			$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
			$excel->getActiveSheet()->mergeCells("B$numrow:C$merge"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$numrow", "P"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$baris2", "A"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$baris3", "(A - P)"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$baris4", "PL"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$baris5", "(PL - P)"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$baris6", "C"); 
			$excel->setActiveSheetIndex(0)->setCellValue("D$merge", "(C - P)"); 
			$row = $numrow;
			for ($p=0; $p < 7; $p++) { 
				$col = 4;
				for ($i=0; $i < ($tglakhir[0] - $tglawal[0] +1) ; $i++) { // value per tanggal
					if ($p == 0) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_plan'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_plan'];
					}elseif ($p == 1) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_akt'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_akt'];
					}elseif ($p == 2) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_min'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_min'];
					}elseif($p == 3) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_pl'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_pl'];
					}elseif($p == 4) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_plmin'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_plmin'];
					}elseif($p == 5) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_com'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_com'];
					}elseif($p == 6) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value[0]['total_cmin'.$i.'']);
						$ket_jml = $value[0]['ttl_jml_cmin'];
					}
				$a = $this->numbertoalpha($col);
				$excel->getActiveSheet()->getStyle("$a$row")->applyFromArray($style4);
				$col++;
				}
				$excel->setActiveSheetIndex(0)->setCellValue($akhir.$row, $ket_jml);
				$excel->getActiveSheet()->getStyle("A$row")->applyFromArray($style4);
				$excel->getActiveSheet()->getStyle("B$row")->applyFromArray($style4);
				$excel->getActiveSheet()->getStyle("C$row")->applyFromArray($style4);
				$excel->getActiveSheet()->getStyle("D$row")->applyFromArray($style4);
				$excel->getActiveSheet()->getStyle($akhir.$row)->applyFromArray($style4);
				$row++;
			}


			$numjdl = $merge +5;
		}
		
		$excel->getActiveSheet(0)->setTitle("Monitoring Job Produksi");		
		
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		for($col = 'D'; $col !== $akhir; $col++) { // autowidth
			$excel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
		}
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		

		//SHEET 2 COMMENT
		$numcmt = 2;
		$akhir = $akhir1 - 1;
		$akhir = $this->numbertoalpha($akhir);
		$akhir2 = $this->numbertoalpha($akhir1);
		$excel->createSheet();
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "MONITORING JOB PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$akhir."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);

		$c = 0;
		foreach ($datanya as $key => $value) {
			$excel->setActiveSheetIndex(1)->setCellValue('A'.$numcmt, "Kategori"); 
			$excel->setActiveSheetIndex(1)->setCellValue('B'.$numcmt, ": ".$key); 
			$excel->setActiveSheetIndex(1)->setCellValue('A'.($numcmt+1), "Periode"); 
			$excel->setActiveSheetIndex(1)->setCellValue('B'.($numcmt+1), ": ".$tglawal[0]."/".$bulan[0]." - ".$tglakhir[0]."/".$bulan[0].""); 
			$merg = $numcmt + 2;
			$merg2 = $numcmt + 3;
			$excel->setActiveSheetIndex(1)->setCellValue('A'.$merg, "NO.");
			$excel->setActiveSheetIndex(1)->setCellValue('B'.$merg, "KODE");
			$excel->setActiveSheetIndex(1)->setCellValue('C'.$merg, "DESKRIPSI");
			$excel->setActiveSheetIndex(1)->setCellValue('D'.$merg, "");
			$excel->setActiveSheetIndex(1)->setCellValue('E'.$merg, "TANGGAL");
			$excel->getActiveSheet()->mergeCells("A$merg:A$merg2"); 
			$excel->getActiveSheet()->mergeCells("B$merg:B$merg2"); 
			$excel->getActiveSheet()->mergeCells("C$merg:C$merg2"); 
			$excel->getActiveSheet()->mergeCells("D$merg:D$merg2"); 
			$excel->getActiveSheet()->mergeCells("E$merg:".$akhir_tgl.$merg.""); 
			
			$row = $merg2; $col = 4;
			for ($i=($tglawal[0]-1); $i < $tglakhir[0] ; $i++) { //tanggal 1 - akhir
				$col2 = $this->numbertoalpha($col);
				$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
				$excel->getActiveSheet()->getStyle("".$col2.$row."")->applyFromArray($style1);
				$col++;
			}
			$excel->getActiveSheet()->getStyle('A'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('B'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('B'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('C'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('C'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('D'.$merg)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('D'.$merg2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("E$merg:".$akhir.$merg."")->applyFromArray($style1);

			$no=1;
			$numrow = $merg2 + 1;
			foreach ($value as $d) {	
				// echo "<pre>";print_r($kategori);exit();
				$excel->setActiveSheetIndex(1)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(1)->setCellValue('B'.$numrow, $d['item']);
				$excel->setActiveSheetIndex(1)->setCellValue('C'.$numrow, $d['desc']);
				$excel->setActiveSheetIndex(1)->setCellValue('D'.$numrow, "(A - P)");
				$excel->setActiveSheetIndex(1)->setCellValue('D'.($numrow+1), "(PL - P)");
				$excel->setActiveSheetIndex(1)->setCellValue('D'.($numrow+2), "(C - P)");
				$row = $numrow;
				for ($p=0; $p < 3; $p++) { 
					$col = 4;
					$tgl = $tglawal[0];
					for ($i=0; $i < ($tglakhir[0] - $tglawal[0] + 1) ; $i++) { // value per tanggal
						if ($p == 0) {
							$comment = $this->getComment($kategori2[$c], $bulan2, $d['inv'], $tgl, 'PA');
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $comment);
						}elseif ($p == 1) {
							$comment = $this->getComment($kategori2[$c], $bulan2, $d['inv'], $tgl, 'PLP');
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $comment);
						}elseif ($p == 2) {
							$comment = $this->getComment($kategori2[$c], $bulan2, $d['inv'], $tgl, 'PC');
							$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $comment);
						}
						$col++; $tgl++;
					}
					$row++;
				}
				
				$baris2 = $numrow + 1;
				$merge = $numrow + 2;
				// echo "<pre>";print_r($numrow);exit();
				$excel->getActiveSheet()->mergeCells("A$numrow:A$merge"); 
				$excel->getActiveSheet()->mergeCells("B$numrow:B$merge"); 
				$excel->getActiveSheet()->mergeCells("C$numrow:C$merge"); 
				for ($i=0; $i < 3 ; $i++) { 
					$baris = $numrow+$i;
					$excel->getActiveSheet()->getStyle("A$baris")->applyFromArray($style3);
					$excel->getActiveSheet()->getStyle("B$baris")->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle("C$baris")->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle("D$baris")->applyFromArray($style3);
					
					for ($n=4; $n < $akhir1 ; $n++) { // styling kolom tanggal/baris
						$a = $this->numbertoalpha($n);
						$excel->getActiveSheet()->getStyle("$a$baris")->applyFromArray($style2);
					}
				}
				$numrow = $merge + 1;
				$no++;

			}
			$numcmt = $merge +5;
			$c++;
		}


		$excel->getActiveSheet(1)->setTitle("Comment");
		// WIDTH
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		for($col = 'D'; $col !== $akhir2; $col++) { // autowidth
			$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);


		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Monitoring-Job-Produksi.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');

	}


}