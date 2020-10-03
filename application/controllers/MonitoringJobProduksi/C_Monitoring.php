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
    
    public function search(){
        $kategori   	= $this->input->post('kategori');
		$ctgr 			= $this->M_monitoring->getCategory("where id_category = '".$kategori."'");
		$bulan      	= $this->input->post('bulan');
		$data['kategori'] 	= $ctgr[0]['CATEGORY_NAME'];
		$data['kategori2'] 	= $kategori;
		$data['bulan'] 	= $bulan;
		$bulan 			= explode("/", $bulan);
		$inibulan		= $bulan[1].$bulan[0];
		$data['bulan2'] = $inibulan;

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
		$total['item'] = $total['ttl_jml_plan'] = $total['ttl_jml_akt'] = $total['ttl_jml_min'] = $total['ttl_jml_com'] = 0;
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
					$getdata[$key]['jml_plan'] += $getdata[$key]['plan'.$i.''] == '' ? 0 : $getdata[$key]['plan'.$i.''];
					
					$getdata[$key]['akt'.$i.''] = $aktual[0];
					$getdata[$key]['com'.$i.''] = $aktual[2];
					$getdata[$key]['jml_akt'] += $aktual[0] == '' ? 0 : $aktual[0];
					$getdata[$key]['jml_com'] += $aktual[2] == '' ? 0 : $aktual[2];
					if ($data['bulan'] == date('m/Y')) {
						if ($i < date('d')) {
							$getdata[$key]['min'.$i.''] = $aktual[1];
							$getdata[$key]['jml_min'] += $aktual[1] == '' ? 0 : $aktual[1];
						}else {
							$getdata[$key]['min'.$i.''] = '';
						}
					}else {
						$getdata[$key]['min'.$i.''] = $aktual[1];
						$getdata[$key]['jml_min'] += $aktual[1] == '' ? 0 : $aktual[1];
					}
					
					if ($key == 0) {
						$total['ttl_plan'.$i.''] = $getdata[$key]['plan'.$i.''] != '' ? $getdata[$key]['plan'.$i.''] : 0;
						$total['ttl_akt'.$i.''] = $aktual[0] == '' ? 0 : $aktual[0];
						$total['ttl_com'.$i.''] = $aktual[2] == '' ? 0 : $aktual[2];
						$total['ttl_min'.$i.''] = $aktual[1] == '' ? 0 : $aktual[1];
					}else {
						$total['ttl_plan'.$i.''] += $getdata[$key]['plan'.$i.''] != '' ? $getdata[$key]['plan'.$i.''] : 0;
						$total['ttl_akt'.$i.''] += $aktual[0] == '' ? 0 : $aktual[0];
						$total['ttl_com'.$i.''] += $aktual[2] == '' ? 0 : $aktual[2];
						$total['ttl_min'.$i.''] += $aktual[1] == '' ? 0 : $aktual[1];
					}
				}
				if ($ket == 'oke') {
					array_push($datanya,$getdata[$key]);
					$total['item'] += 1;
					$total['ttl_jml_plan'] += $getdata[$key]['jml_plan'];
					$total['ttl_jml_akt'] += $getdata[$key]['jml_akt'];
					$total['ttl_jml_min'] += $getdata[$key]['jml_min'];
					$total['ttl_jml_com'] += $getdata[$key]['jml_com'];
				}
			}
		}
		$data['data'] = $datanya;
		$data['total'] = $total;
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

	public function commentmin(){
		$item 		= $this->input->post('item');
		$desc 		= $this->input->post('desc');
		$inv 		= $this->input->post('inv');
		$bulan 		= $this->input->post('bulan');
		$bulan2 	= $this->input->post('bulan2');
		$kategori 	= $this->input->post('kategori');
		$tgl 		= $this->input->post('tgl');
		
		$comment = $this->M_monitoring->getcomment($kategori, $bulan, $inv, $tgl);
		if (!empty($comment)) {
			$komen = $comment[0]['KETERANGAN'];
			$save = 'style="display:none"';
			$edit = '';
			$diss = 'readonly';
		}else {
			$komen = $save = $diss = '';
			$edit = 'style="display:none"';
		}

		$view = '<div class="modal-header" style="font-size:25px;background-color:#FFB670">
					<i class="fa fa-list-alt"></i> Comment Min
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="panel-body">
						<input type="hidden" id="kategori" value="'.$kategori.'">
						<input type="hidden" id="bulan" value="'.$bulan2.'">
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
								<button type="button" id="savecommentmin" class="btn btn-danger" onclick="saveCommentmin(this)" '.$save.'><i class="fa fa-save"></i> Save</button>
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
		$hari 		= $this->input->post('hari');
		$datanya = array();
		for ($i=0; $i < (count($no)/2); $i++) { 
			$baris['item'] = $this->input->post('item'.$no[$i].'');
			$baris['desc'] = $this->input->post('desc'.$no[$i].'');
			$baris['jml_plan'] = $this->input->post('jml_plan'.$no[$i].'');
			$baris['jml_akt'] = $this->input->post('jml_akt'.$no[$i].'');
			$baris['jml_min'] = $this->input->post('jml_min'.$no[$i].'');
			$baris['jml_com'] = $this->input->post('jml_com'.$no[$i].'');
			for ($x=0; $x < $hari; $x++) { 
				$baris['plan'.$x.''] = $this->input->post('plan'.$no[$i].''.($x+1).'');
				$baris['akt'.$x.''] = $this->input->post('akt'.$no[$i].''.($x+1).'');
				$baris['min'.$x.''] = $this->input->post('min'.$no[$i].''.($x+1).'');
				$baris['com'.$x.''] = $this->input->post('com'.$no[$i].''.($x+1).'');
			}
			array_push($datanya, $baris);
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
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+2), "(-)");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow+3), "C");
			$row = $numrow;
			for ($p=0; $p < 4; $p++) { 
				$col = 4;
				for ($i=0; $i < $hari ; $i++) { // value per tanggal
					if ($p == 0) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['plan'.$i.'']);
					}elseif ($p == 1) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['akt'.$i.'']);
					}elseif ($p == 2) {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['min'.$i.'']);
					}else {
						$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $d['com'.$i.'']);
					}
					$col++;
				}
				$ket_jml = $p == 0 ? $d['jml_plan'] : (
					$p == 1 ? $d['jml_akt'] : (
						$p == 2 ? $d['jml_min'] : $d['jml_com']
					)
				);
				$excel->setActiveSheetIndex(0)->setCellValue($ajml.$row, $ket_jml);
				$row++;
			}

			$merge = $numrow + 3;
			$baris2 = $numrow + 1;
			$baris3 = $numrow + 2;
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
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Monitoring Job Produksi");
		$excel->setActiveSheetIndex(0);
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


}