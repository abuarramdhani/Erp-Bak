<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Bom extends CI_Controller
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
		$this->load->model('MonitoringDeliverySparepart/M_bom');

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
		$user = $this->session->user;


		$data['Title'] = 'BoM Management';
		$data['Menu'] = 'BoM Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_bom->getHeader();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$cek = $this->M_bom->cekHak($user);
		// if ($cek[0]['hak_akses'] == 'Koordinator') {
			$this->load->view('MonitoringDeliverySparepart/V_Bom', $data);
		// }else {
		// 	$this->load->view('MonitoringDeliverySparepart/V_Salah', $data);
		// }
		$this->load->view('V_Footer',$data);
	}

	function buildTree(array $elements, $parentId) {
	    $branch = array();

	    foreach ($elements as $element) {
	    	// $idcomp = $element['COMPONENT_NUM'];
	        if ($element['ASSEMBLY_NUM'] == $parentId) {
	            $children = $this->buildTree($elements, $element['COMPONENT_NUM']);
	            if ($children) {
	                $element['CHILDREN'] = $children;
	            }
	            $branch[] = $element;
	        }
	    }
	    return $branch;
	}

	public function MakeList($array, $depth, $depthasli, $kelas, $x){
		// $warna = array( '#fff2f2', '#fef8e8', '#f5f9e8', '#f0fafc', '#f8f2fd');
		$warna = array( '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1');
		$kedalaman = $depthasli-$depth;
		//Base case: an empty array produces no list
		if (empty($array)) return '';

		//Recursive Step: make a list with child lists
		// $kelas2 = '';
		$output = '';
		foreach ($array as $key => $subArray) {	
			if ($depth == $subArray['BOM_LEVEL']){
				$kelas2 = $subArray['COMPONENT_NUM'];
				$kelas3 = $subArray['COMPONENT_NUM'];
			}else {
				$kelas = $kelas;
				$kelas2 = $this->getKelas2($subArray['ASSEMBLY_PATH'], $subArray['BOM_LEVEL']);
				$kelas3 = $subArray['COMPONENT_NUM'];
						// echo "<pre>"; print_r($kelas2);exit();
			}		
			if (array_key_exists('CHILDREN', $subArray)) {				
				$output .= '<div class="col-md-11"><a href="#'.$subArray['COMPONENT_NUM'].'" id="tabel'.$x.$subArray['BOM_LEVEL'].'" class="list-group-item '.$kelas2.' '.$kelas3.'" style="padding-left: '.(45*$kedalaman).'px; background-color: '.$warna[($kedalaman % 5)].'; " data-toggle="collapse"> <i class="glyphicon glyphicon-chevron-right"></i>
							<b>NAMA KOMPONEN : </b>'.$subArray['COMPONENT_NUM'].' ('.$subArray['DESCRIPTION'].') </br>
							<b>BOM_LEVEL : </b>'.$subArray['BOM_LEVEL'].'</br>
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="root_assembly[]" value="'.$subArray['ROOT_ASSEMBLY'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_num[]" value="'.$subArray['ASSEMBLY_NUM'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="compnum'.$kelas.$x.$subArray['BOM_LEVEL'].'" name="item[]" value="'.$subArray['COMPONENT_NUM'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="desc[]" value="'.$subArray['DESCRIPTION'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="qty[]" value="'.$subArray['QTY'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_path[]" value="'.$subArray['ASSEMBLY_PATH'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="bom_level[]" value="'.$subArray['BOM_LEVEL'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="is_cycle[]" value="'.$subArray['IS_CYCLE'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="btn'.$kelas.$x.$subArray['BOM_LEVEL'].'" value="trash">
							</a>
							</div>
							<div class="col-md-1">
								<button type="button" id="btn'.$x.$subArray['BOM_LEVEL'].'" class="text-red" value="trash" style="background-color:inherit;border:none;" onclick="haha('.$x.$subArray['BOM_LEVEL'].', '.$kelas.$x.$subArray['BOM_LEVEL'].')"><i class="fa fa-2x fa-trash" style="margin-top:15px"></i></button>
							</div>
								<div class="list-group collapse" id="'.$subArray['COMPONENT_NUM'].'">'.$this->makeList($subArray['CHILDREN'], $depth-1, $depthasli, $kelas, $x);
				} else {				
				$output .= '<div class="col-md-11"><a id="tabel'.$x.$subArray['BOM_LEVEL'].'" style="padding-left: '.(45*$kedalaman).'px; background-color: '.$warna[($kedalaman % 5)].';" class="list-group-item '.$kelas2.' '.$kelas3.'">
							<b>NAMA KOMPONEN : </b>'.$subArray['COMPONENT_NUM'].' ('.$subArray['DESCRIPTION'].')</br>
							<b>BOM_LEVEL : </b>'.$subArray['BOM_LEVEL'].'</br>
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="root_assembly[]" value="'.$subArray['ROOT_ASSEMBLY'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_num[]" value="'.$subArray['ASSEMBLY_NUM'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="compnum'.$kelas.$x.$subArray['BOM_LEVEL'].'" name="item[]" value="'.$subArray['COMPONENT_NUM'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="desc[]" value="'.$subArray['DESCRIPTION'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="qty[]" value="'.$subArray['QTY'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_path[]" value="'.$subArray['ASSEMBLY_PATH'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="bom_level[]" value="'.$subArray['BOM_LEVEL'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="is_cycle[]" value="'.$subArray['IS_CYCLE'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="btn'.$kelas.$x.$subArray['BOM_LEVEL'].'" value="trash">
							</a> </div>
							<div class="col-md-1">
								<button type="button" id="btn'.$x.$subArray['BOM_LEVEL'].'" class="text-red" style="background-color:inherit;border:none" onclick="haha('.$x.$subArray['BOM_LEVEL'].', '.$kelas.$x.$subArray['BOM_LEVEL'].')"><i class="fa fa-2x fa-trash" style="margin-top:15px"></i></button>
							</div>';
			}
			if ($depth == $subArray['BOM_LEVEL']){
				$kelas++;
			}else {
			}
			$x++;
		}
		$output .= '</div>';
		
		return $output;

	}

	public function getKelas2($compnum, $level){
		$b = '';
		if ($level == 1) {
			$b = '';
		}else{
			$a = explode("<--", $compnum);
			for ($i=0; $i < count($a); $i++) { 
				$b .= $a[$i].' ';
			}
		}
		return $b;
	}
	

	public function GenerateBoM(){

		$item = $this->input->post("rootCode");
		$data['item'] = $item;
		$desc = $this->M_bom->getDesc($item);
		$data['desc'] = $desc[0]['DESCRIPTION'];
		$datanya = $this->M_bom->getBoM($item);
		$depth = intval($this->M_bom->getDepthBom($item));

		$data['Depth'] = $depth;
		$data['BOM'] = $datanya;
		// foreach ($datanya as $ue) {
		// 	$data['BOM'][$ue['COMPONENT_NUM']] = $ue;
		// }

		foreach ($datanya as $v) {
			$data['List'][$v['BOM_LEVEL']][] = $v;
		}
		$kelas = 1;
		$x = 1;
		// $coba = 'kelas'.$x;
		$data['Tree'] = $this->buildTree($data['BOM'], $item);
		$data['htmllist'] = $this->MakeList($data['Tree'],$depth,$depth, $kelas, $x);
		// for ($i=1; $i <= $depth; $i++) { 
		// 	foreach ($datanya as $v) {
		// 		if ($v['BOM_LEVEL'] == $i) {
		// 			$data['BOM'][$item][$v['COMPONENT_NUM']]= null;
		// 		}
		// 	}
		// 	echo "<pre>";
		// 	print_r($data['BOM']);
		// 	exit();
		// }

		// echo "<pre>";
		// print_r($datanya);
		// print_r($data['BOM']);
		// echo $item;
		// exit();
		$this->checkSession();
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'BoM Management';
		$data['Menu'] = 'BoM Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringDeliverySparepart/V_BomGenerate', $data);
		$this->load->view('V_Footer',$data);
	}

	function saveBom(){
		$cek			= $this->M_bom->cekHeader();
		$id				= $cek[0]['jumlah'] + 1;
		$component_code	= $this->input->post('rootCode');
		$component_desc	= $this->input->post('rootDesc');
		$identitas_bom 	= $this->input->post('idBom');
		$keterangan 	= $this->input->post('ket');
		$root_assembly 	= $this->input->post('root_assembly[]');
		$assebly_num 	= $this->input->post('assembly_num[]');
		$component_num 	= $this->input->post('item[]');
		$item_type 		= $this->input->post('desc[]');
		$assembly_path 	= $this->input->post('assembly_path[]');
		$qty 			= $this->input->post('qty[]');
		$bom_level 		= $this->input->post('bom_level[]');
		$is_cycle 		= $this->input->post('is_cycle[]');
		$saveHeader = $this->M_bom->saveHeader($id, $component_code, $component_desc, $identitas_bom, $keterangan);
		for ($i=0; $i < count($component_num); $i++) { 
		// echo "<pre>"; print_r($id);exit();

			$save = $this->M_bom->saveBom($root_assembly[$i], $assebly_num[$i], $component_num[$i], $item_type[$i], $qty[$i], $assembly_path[$i], $bom_level[$i], $is_cycle[$i], $identitas_bom, $id);
		}
		redirect(base_url('MonitoringDeliverySparepart/BomManagement'));
		
	}


	function detailBom($root, $id){
		$datanya = $this->M_bom->getDetail2($root, $id);
		$depth = intval($this->M_bom->getDept2($root));
		$data['root'] = $root;
		$desc = $this->M_bom->desc($root);
		$data['desc'] = $desc[0]['component_desc'];

		$data['Depth'] = $depth;
		$data['BOM'] = $datanya;

		foreach ($datanya as $v) {
			$data['List'][$v['bom_level']][] = $v;
		}

		$kelas = 1;
		$x = 1;
		$data['Tree'] = $this->buildTree2($data['BOM'], $root);
		$data['htmllist'] = $this->MakeTable2($data['Tree'],$depth,$depth, $kelas, $x);
		// echo "<pre>"; print_r($datanya);exit();

		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'BoM Management';
		$data['Menu'] = 'BoM Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MonitoringDeliverySparepart/V_DetailBom', $data);
		$this->load->view('V_Footer',$data);

	}
	
	public function buildTree2(array $elements, $parentId) {
	    $branch = array();

	    foreach ($elements as $element) {
	    	// $idcomp = $element['COMPONENT_NUM'];
	        if ($element['assembly_num'] == $parentId) {
	            $children = $this->buildTree2($elements, $element['component_num']);
	            if ($children) {
	                $element['CHILDREN'] = $children;
	            }
	            $branch[] = $element;
	        }
	    }

	    return $branch;
	}	
	public function MakeTable2($array, $depth, $depthasli, $kelas, $x){
		// $warna = array( '#fff2f2', '#fef8e8', '#f5f9e8', '#f0fafc', '#f8f2fd');
		$warna = array( '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1');
		$kedalaman = $depthasli-$depth;
		//Base case: an empty array produces no list
		if (empty($array)) return '';

		//Recursive Step: make a list with child lists
		// $kelas2 = '';
		$output = '';
		foreach ($array as $key => $subArray) {	
			if ($depth == $subArray['bom_level']){
				$kelas2 = $subArray['component_num'];
				$kelas3 = $subArray['component_num'];
			}else {
				$kelas  = $kelas;
				$kelas2 = $this->getKelas2($subArray['assembly_path'], $subArray['bom_level']);
				$kelas3 = $subArray['component_num'];
						// echo "<pre>"; print_r($kelas2);exit();
			}		
			if (array_key_exists('CHILDREN', $subArray)) {				
				$output .= '<div class="col-md-11"><a href="#'.$subArray['component_num'].'" id="tabel'.$x.$subArray['bom_level'].'" class="list-group-item '.$kelas2.' '.$kelas3.'" style="padding-left: '.(45*$kedalaman).'px; background-color: '.$warna[($kedalaman % 5)].'; " data-toggle="collapse"> <i class="glyphicon glyphicon-chevron-right"></i>
							<b>NAMA KOMPONEN : </b>'.$subArray['component_num'].' ('.$subArray['item_type'].') </br>
							<b>bom_level : </b>'.$subArray['bom_level'].'</br>
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="root_assembly[]" value="'.$subArray['root_assembly'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_num[]" value="'.$subArray['assembly_num'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="compnum'.$kelas.$x.$subArray['bom_level'].'" name="item[]" value="'.$subArray['component_num'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="desc[]" value="'.$subArray['item_type'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="qty[]" value="'.$subArray['qty'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_path[]" value="'.$subArray['assembly_path'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="bom_level[]" value="'.$subArray['bom_level'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="is_cycle[]" value="'.$subArray['is_cycle'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="btn'.$kelas.$x.$subArray['bom_level'].'" value="trash">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="idunix[]" value="'.$subArray['id'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="identitas[]" value="'.$subArray['identitas_bom'].'">
							</a>
							</div>
							<div class="col-md-1">
								<button type="button" id="btn'.$x.$subArray['bom_level'].'" class="text-red" value="trash" style="background-color:inherit;border:none;" onclick="haha('.$x.$subArray['bom_level'].', '.$kelas.$x.$subArray['bom_level'].')"><i class="fa fa-2x fa-trash" style="margin-top:15px"></i></button>
							</div>
								<div class="list-group collapse" id="'.$subArray['component_num'].'">'.$this->MakeTable2($subArray['CHILDREN'], $depth-1, $depthasli, $kelas, $x);
				} else {				
				$output .= '<div class="col-md-11"><a id="tabel'.$x.$subArray['bom_level'].'" style="padding-left: '.(45*$kedalaman).'px; background-color: '.$warna[($kedalaman % 5)].';" class="list-group-item '.$kelas2.' '.$kelas3.'">
							<b>NAMA KOMPONEN : </b>'.$subArray['component_num'].' ('.$subArray['item_type'].')</br>
							<b>BOM_LEVEL : </b>'.$subArray['bom_level'].'</br>
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="root_assembly[]" value="'.$subArray['root_assembly'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_num[]" value="'.$subArray['assembly_num'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="compnum'.$kelas.$x.$subArray['bom_level'].'" name="item[]" value="'.$subArray['component_num'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="desc[]" value="'.$subArray['item_type'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="qty[]" value="'.$subArray['qty'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="assembly_path[]" value="'.$subArray['assembly_path'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="bom_level[]" value="'.$subArray['bom_level'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="is_cycle[]" value="'.$subArray['is_cycle'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" id="btn'.$kelas.$x.$subArray['bom_level'].'" value="trash">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="idunix[]" value="'.$subArray['id'].'">
							<input type="hidden" class="'.$kelas2.' '.$kelas3.'" name="identitas[]" value="'.$subArray['identitas_bom'].'">
							</a> </div>
							<div class="col-md-1">
								<button type="button" id="btn'.$x.$subArray['bom_level'].'" class="text-red" style="background-color:inherit;border:none" onclick="haha('.$x.$subArray['bom_level'].', '.$kelas.$x.$subArray['bom_level'].')"><i class="fa fa-2x fa-trash" style="margin-top:15px"></i></button>
							</div>';
			}
			if ($depth == $subArray['bom_level']){
				$kelas++;
			}else {
			}
			$x++;
		}
		$output .= '</div>';
		
		return $output;
	}


	public function cekIdentitas(){
		$version = $this->input->post('version');
		$root = $this->input->post('root');

		$cek = $this->M_bom->cekIdentitas($version, $root);
		// echo "<pre>"; print_r($cek);exit();

		if (!empty($cek)) {
			$alert = "Identitas sudah dipakai.";
		}else{
			$alert = '';
		}
		print_r($alert);
	}

	function updateBom(){
		// $cek			= $this->M_bom->cekHeader();
		$id				= $this->input->post('idunix[]');
		$identitas_bom 	= $this->input->post('identitas[]');
		$root_assembly 	= $this->input->post('root_assembly[]');
		$assebly_num 	= $this->input->post('assembly_num[]');
		$component_num 	= $this->input->post('item[]');
		$item_type 		= $this->input->post('desc[]');
		$assembly_path 	= $this->input->post('assembly_path[]');
		$qty 			= $this->input->post('qty[]');
		$bom_level 		= $this->input->post('bom_level[]');
		$is_cycle 		= $this->input->post('is_cycle[]');

		$delete = $this->M_bom->deleteMonitoring($id[0], $root_assembly[0], $identitas_bom[0]);
		for ($i=0; $i < count($component_num); $i++) { 
		// echo "<pre>"; print_r($id);exit();

			$update = $this->M_bom->saveBom($root_assembly[$i], $assebly_num[$i], $component_num[$i], $item_type[$i], $qty[$i], $assembly_path[$i], $bom_level[$i], $is_cycle[$i], $identitas_bom[$i], $id[$i]);
		}
		redirect(base_url('MonitoringDeliverySparepart/BomManagement'));
	}

	function deleteBom($component_code, $id){
		$this->M_bom->deleteBom($component_code, $id);
		$this->M_bom->deleteHeader($component_code, $id);
		redirect(base_url('MonitoringDeliverySparepart/BomManagement'));
	}
	
	
}