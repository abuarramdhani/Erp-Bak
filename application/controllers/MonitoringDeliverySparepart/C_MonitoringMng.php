<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MonitoringMng extends CI_Controller
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
		$this->load->model('MonitoringDeliverySparepart/M_monmng');

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
		$username = $this->session->username;
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title'] = 'Monitoring Management';
		$data['Menu'] = 'Monitoring Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_monmng->dataMonMng();
		// echo "<pre>"; print_r($data['data']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('MonitoringDeliverySparepart/V_MonitoringMng', $data);
		$this->load->view('V_Footer',$data);
		}
		
	function getCompCode(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monmng->getCompCode($term);
		echo json_encode($data);
	}

	function getDescCode()
	{
		$par  = $this->input->post('par');
		$data = $this->M_monmng->getDescCode($par);
    	echo json_encode($data[0]['DESCRIPTION']);
	}

	function getBomVersion(){
		$term = $this->input->get('par');
		$term = strtoupper($term);
		$data = $this->M_monmng->getBomVersion($term);
		// echo "<pre>";print_r($par);exit();
		echo json_encode($data);
	}

    
    function saveMonMng(){
		$cek			= $this->M_monmng->cekHeader();
		$id				= $cek[0]['id'] + 1;
		$component_code = $this->input->post('compCode');
		$component_desc = $this->input->post('comDesc');
		$bom_version 	= $this->input->post('bomVer');
		$cari			= $this->M_monmng->getDataBom($component_code, $bom_version);
		$periode 		= $this->input->post('periodeMon');
		$tglTarget 		= $this->input->post('tglTarget');
		$qty 			= $this->input->post('qty');
		
		// echo "<pre>"; print_r($cari);exit();
		$cekInput = $this->M_monmng->cekBom($component_code, $bom_version);
		if (!empty($cekInput)) {
			for ($x=0; $x < count($qty) ; $x++) { 
				$tgl1 = explode(' ', $tglTarget[$x]);
				$tgl2 = $tgl1[0];
				$tgl  = sprintf("%02d", $tgl2);

				$cekMon = $this->M_monmng->cekData($component_code, $bom_version, $periode);
				if (empty($cekMon)) {
					$saveHeader = $this->M_monmng->saveheaderMon($component_code, $component_desc, $bom_version, $periode, $id);
					$saveTarget = $this->M_monmng->saveTarget($id, $tgl, $qty[$x], $component_code);
					for ($i=0; $i < count($cari) ; $i++) { 
						$save = $this->M_monmng->saveMonitoring($cari[$i]['root_assembly'], $cari[$i]['assembly_num'], $cari[$i]['component_num'], $cari[$i]['item_type'], $cari[$i]['qty'], $cari[$i]['assembly_path'], $cari[$i]['bom_level'], $cari[$i]['is_cycle'], $cari[$i]['identitas_bom'], $periode, $id);
					}
				}else {
					$saveTarget = $this->M_monmng->saveTarget($cekMon[0]['id'], $tgl, $qty[$x], $component_code);
				}
			}
		}
		
		redirect(base_url('MonitoringDeliverySparepart/MonitoringManagement'));
	}

	function detailMonitoringMng($root, $period){
		$user = $this->session->user;
		$hak = $this->M_monmng->cekHak($user);

		$pecah1	= explode("%20", $period);
		$period = implode(" ",$pecah1);
		$datanya = $this->M_monmng->getDetail($root, $period);
		$depth = intval($this->M_monmng->getDept2($root));
		$data['root'] = $root;
		$desc = $this->M_monmng->desc($root);
		$data['desc'] = $desc[0]['component_desc'];

		$data['Depth'] = $depth;
		$data['BOM'] = $datanya;

		foreach ($datanya as $v) {
			$data['List'][$v['bom_level']][] = $v;
		}

		$data['Tree'] = $this->buildTree($data['BOM'], $root);
		$data['htmllist'] = $this->makeHeader($datanya,$depth,$depth, $period, $data['BOM']);
		// $data['htmllist'] = $this->MakeTable($data['Tree'],$depth,$depth);
		$bulan1 = $datanya[0]['periode_monitoring'];
		$bulan2 = explode(" ", $bulan1);
		$bulan = $bulan2[0];
		$tahun = $bulan2[1];
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		// echo "<pre>";print_r($data['bulan']);exit();

		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Management';
		$data['Menu'] = 'Monitoring Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MonitoringDeliverySparepart/V_TblMonitoringMng', $data);
		$this->load->view('V_Footer',$data);

    }

	function buildTree(array $elements, $parentId) {
	    $branch = array();

	    foreach ($elements as $element) {
	    	// $idcomp = $element['COMPONENT_NUM'];
	        if ($element['assembly_num'] == $parentId) {
	            $children = $this->buildTree($elements, $element['component_num']);
	            if ($children) {
	                $element['CHILDREN'] = $children;
	            }
	            $branch[] = $element;
	        }
	    }

	    return $branch;
	}	

	public function makeHeader($array, $depth, $depthasli, $period, $bom){
		$bulan1 = $array[0]['periode_monitoring'];
		$bulan2 = explode(" ", $bulan1);
		$bulan 	= $bulan2[0];
		$tahun	= $bulan2[1];
		$kedalaman = $depthasli-$depth;

		$header = $this->M_monmng->getHeader($bulan1);
		
		foreach ($header as $val) {
			$dept = $this->M_monmng->getseksi($val['component_code']);
			if (empty($dept)) {
				$seksi = '';
			}else {
				$seksi = $dept[0]['DEPARTMENT_CLASS_CODE'];
			}

			$bln2 = '';
			if ($bulan == 'Jan' || $bulan == 'Mar' || $bulan == 'May' || $bulan == 'Jul' || $bulan == 'Ags' || $bulan == 'Oct' || $bulan == 'Dec') {
				$x = 32;
			}elseif ($bulan == 'Apr' || $bulan == 'Jun' || $bulan == 'Sep' || $bulan == 'Nov') {
				$x = 31;
			}elseif ($bulan == 'Feb') {
				if ($tahun%4 == 0) {
					$x = 30;
				}else {
					$x = 29;
				}
			}

			for ($i=1; $i < $x; $i++) {
				$no2 = sprintf("%02d", $i);
				$cek = $this->M_monmng->getqtyTarget($val['component_code'], $val['id'], $no2);
				if (!empty($cek)) {
					// echo "<pre>";print_r($cek);exit();
					$qtyTarget = $cek[0]['qty_target'];
				}else{
					$qtyTarget = '';
				}
				$bln2 .= "<td><input type='text' style='width:30px;background-color:#82e4ff;' class='text-center' id='qty".$i.$val['id']."'  value='".$qtyTarget."' onchange='saveQtyTarget2(".$i.",".$val['id'].")'></td>";
			}

			$tree 	= $this->buildTree($bom, $val['component_code']);
			$output = $this->MakeTable($tree, $depth, $depthasli, $period);
			// echo "<pre>";print_r($output);exit();

			$header2 = '<tbody>
							<tr data-toggle="collapse" data-target=".'.$val['component_code'].'" aria-expanded="false" aria-controls="'.$val['component_code'].'"  onclick="ganti('.$val['id'].')">
								<td style="padding-left: '.(20*$kedalaman).'px;"><i id="icon'.$val['id'].'" class="fa fa-minus" aria-hidden="true"></i></td>
								<td style="padding-left: '.(20*$kedalaman).'px;"><b>Root Assembly</b></td>
								<td style="padding-left: '.(20*$kedalaman).'px;"><input type="hidden" id="compnum'.$val['id'].'" value="'.$val['component_code'].'">'.$val['component_code'].'</td>  
								<td colspan="5"><input type="hidden" id="desc'.$val['id'].'" value="'.$val['component_desc'].'">'.$val['component_desc'].'</td>
								<td></td>
								<td>'.$seksi.'</td>
								<input type="hidden" id="root'.$val['id'].'" value="'.$val['component_code'].'">
								<input type="hidden" id="idbom'.$val['id'].'" value="'.$val['id'].'">
								<input type="hidden" id="version'.$val['id'].'" value="'.$val['identitas_bom'].'">
								<input type="hidden" id="tanda'.$val['id'].'" value="minus">
								'.$bln2.'
							</tr>
							'.$output.'
						</tbody>';
		}
		return $header2;
		
	}

	public function MakeTable($array, $depth, $depthasli, $period){
		$bulan1 = $period;
		$bulan2 = explode(" ", $bulan1);
		$bulan  = $bulan2[0];
		$tahun  = $bulan2[1];
		// $warna = array( '#fff2f2', '#fef8e8', '#f5f9e8', '#f0fafc', '#f8f2fd');
		$warna = array( '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1');
		$kedalaman = $depthasli-$depth;
		//Base case: an empty array produces no list
		if (empty($array)) return '';

		//Recursive Step: make a list with child lists
		
		$output = '';
		foreach ($array as $key => $subArray) {
			$dept = $this->M_monmng->getseksi($subArray['component_num']);
			if (empty($dept)) {
				$seksi = '';
			}else {
				$seksi = $dept[0]['DEPARTMENT_CLASS_CODE'];
			}

			$pisah = explode(" <-- ", $subArray['assembly_path']);
			$col = '';
			for ($p=0; $p < count($pisah) ; $p++) { 
				$col .= $pisah[$p].' ';
			}
			// echo "<pre>"; print_r($bln);exit();
			if (array_key_exists('CHILDREN', $subArray)) {
				$bln = $this->targetQTY($subArray['component_num'], $bulan1, $subArray['root_assembly'], $subArray['idunix']);				
				$output .= '<tr class="'.$col.' collapse in" data-toggle="collapse" data-target=".'.$subArray['component_num'].'" aria-expanded="false" aria-controls="'.$subArray['component_num'].'" onclick="ganti('.$subArray['idunix'].')">
								<td style="padding-left: '.(15*$kedalaman).'px;"><i id="icon'.$subArray['idunix'].'" name="icon" class="fa fa-minus '.$col.'"></i></td>
								<td style="padding-left: '.(20*$kedalaman).'px;">'.$subArray['bom_level'].'</td>
								<td style="padding-left: '.(20*$kedalaman).'px;"><input type="hidden" id="compnum'.$subArray['idunix'].'" value="'.$subArray['component_num'].'">'.$subArray['component_num'].'</td>  
								<td colspan="5">'.$subArray['item_type'].'</td>
								<td>'.$subArray['qty'].'</td>
								<td>'.$seksi.'</td>
								<input type="hidden" id="root'.$subArray['idunix'].'" value="'.$subArray['root_assembly'].'">
								<input type="hidden" id="idbom'.$subArray['idunix'].'" value="'.$subArray['id'].'">
								<input type="hidden" id="version'.$subArray['idunix'].'" value="'.$subArray['identitas_bom'].'">
								<input type="hidden" id="tanda'.$subArray['idunix'].'" name="tanda" class="'.$col.'" value="minus">
								'.$bln.'
							</tr>'.$this->MakeTable($subArray['CHILDREN'], $depth-1, $depthasli, $period);
			} else {
				$bln = $this->targetQTY($subArray['component_num'], $bulan1, $subArray['root_assembly'], $subArray['idunix']);
				$output .= '<tr class="'.$col.' collapse in">
								<td style="padding-left: '.(20*$kedalaman).'px;"></td>
								<td style="padding-left: '.(20*$kedalaman).'px;">'.$subArray['bom_level'].'</td>
								<td style="padding-left: '.(20*$kedalaman).'px;"><input type="hidden" id="compnum'.$subArray['idunix'].'" value="'.$subArray['component_num'].'">'.$subArray['component_num'].'</td>
								<td colspan="5">'.$subArray['item_type'].'</td>
								<td>'.$subArray['qty'].'</td>
								<td>'.$seksi.'</td>
								<input type="hidden" id="root'.$subArray['idunix'].'" value="'.$subArray['root_assembly'].'">
								<input type="hidden" id="idbom'.$subArray['idunix'].'" value="'.$subArray['id'].'">
								<input type="hidden" id="version'.$subArray['idunix'].'" value="'.$subArray['identitas_bom'].'">
								'.$bln.'
							</tr>';
			}
		}	
		return $output;
	}
	
	function deleteData($component_code, $id){
		$deleteMonitoring = $this->M_monmng->deleteMonitoring($component_code, $id);
		$deleteHeader = $this->M_monmng->deleteHeader($component_code, $id);
		$deleteTarget = $this->M_monmng->deleteTarget($component_code, $id);
		$deleteAktual = $this->M_monmng->deleteAktual($component_code, $id);
		
		redirect(base_url('MonitoringDeliverySparepart/MonitoringManagement'));
	}
		
	function targetQTY($compnum, $periode, $root, $idunix){
		$bulan2 = explode(" ", $periode);
		$bulan 	= $bulan2[0];
		$tahun 	= $bulan2[1];
		$datanya = $this->M_monmng->getDetail2($root, $periode, $compnum, $idunix);
		// echo "<pre>"; print_r($datanya);exit();
		$bln = '';
		foreach ($datanya as $key) {
			if ($bulan == 'Jan' || $bulan == 'Mar' || $bulan == 'May' || $bulan == 'Jul' || $bulan == 'Ags' || $bulan == 'Oct' || $bulan == 'Dec') {
				$x = 32;
			}elseif ($bulan == 'Apr' || $bulan == 'Jun' || $bulan == 'Sep' || $bulan == 'Nov') {
				$x = 31;
			}elseif ($bulan == 'Feb') {
				if ($tahun%4 == 0) {
					$x = 30;
				}else {
					$x = 29;
				}
			}

			for ($i=1; $i < $x; $i++) { 
				$no = sprintf("%02d", $i);
				$target = $no + $key['bom_level'];
				$target = sprintf("%02d", $target);
				$cek2 = $this->M_monmng->getqtyTarget($key['root_assembly'], $key['id'], $target);
				if (!empty($cek2) && $key['bom_level'] == 1) {
					$qtyTarget = $cek2[0]['qty_target'] * $key['qty'] ;
				}elseif(!empty($cek2) && $key['bom_level'] != 1){
					$jumlah = array();
					$pisah = explode(' <-- ', $key['assembly_path']);
					for ($q=1; $q < $key['bom_level']; $q++) { 
						$cari = $this->M_monmng->cariqtySebelumnya($pisah[$q], $key['id']);
							array_push($jumlah, $cari[0]['qty']);
					}
					$kali = 1;
					for ($k=0; $k < count($jumlah); $k++) { 
						$kali *= $jumlah[$k];
					}
					$qtyTarget = $cek2[0]['qty_target'] * $kali * $key['qty'];
				}else{
					$qtyTarget = '';
				}
				$bln .= "<td><input type='text' class='text-center' style='width:30px;background-color:#82e4ff' id='qty".$i.$key['idunix']."' value='".$qtyTarget."' ></td>";
			}
		}
		return $bln;
		// echo "<pre>"; print_r($bln);exit();
	}

	public function cekTglTarget(){
		$periode = $this->input->post('periode');
		$tgl = $this->input->post('tgl');
		if ($periode == '' || $tgl == '') {
			$bulan1 = '';
			$bulan2 = '';
		}else {
			$pisah = explode(" ", $periode);
			$bulan1 = $pisah[0];
			$pisah2 = explode(" ", $tgl);
			$bulan2 = $pisah2[1];
		}

		if ($bulan1 != $bulan2) {
			$alert = 'Bulan target tidak sama dengan periode.';
		}else {
			$alert = '';
		}
		print_r($alert);
	}

}