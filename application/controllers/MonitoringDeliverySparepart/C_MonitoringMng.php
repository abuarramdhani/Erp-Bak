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
		$this->load->model('MonitoringDeliverySparepart/M_monitoringMng');

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

		$data['Title'] = 'Monitoring Management';
		$data['Menu'] = 'Monitoring Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_monitoringMng->dataMonMng();
		// echo "<pre>"; print_r($data['data']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$cek = $this->M_monitoringMng->cekHak($user);
		// if ($cek[0]['hak_akses'] == 'Koordinator') {
			$this->load->view('MonitoringDeliverySparepart/V_MonitoringMng', $data);
		// }else {
		// 	$this->load->view('MonitoringDeliverySparepart/V_Salah', $data);
		// }
		$this->load->view('V_Footer',$data);
		}
		
	function getCompCode(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringMng->getCompCode($term);
		echo json_encode($data);
	}

	function getDescCode()
	{
		$par  = $this->input->post('par');
		$data = $this->M_monitoringMng->getDescCode($par);
    	echo json_encode($data[0]['DESCRIPTION']);
	}

	function getBomVersion(){
		$term = $this->input->get('par');
		$term = strtoupper($term);
		$data = $this->M_monitoringMng->getBomVersion($term);
		// echo "<pre>";print_r($par);exit();
		echo json_encode($data);
	}

    
    function saveMonMng(){
		$cek			= $this->M_monitoringMng->cekHeader();
		$id				= $cek[0]['jumlah'] + 1;
		$component_code = $this->input->post('compCode');
		$component_desc = $this->input->post('comDesc');
		$bom_version 	= $this->input->post('bomVer');
		$cari			= $this->M_monitoringMng->getDataBom($component_code, $bom_version);
		$periode 		= $this->input->post('periodeMon');
		$tglTarget 		= $this->input->post('tglTarget');
		$qty 			= $this->input->post('qty');
		
		// echo "<pre>"; print_r($cari);exit();
		for ($x=0; $x < count($qty) ; $x++) { 
			$tgl1 = explode(' ', $tglTarget[$x]);
			$tgl2 = $tgl1[0];
			$tgl  = sprintf("%02d", $tgl2);

			$cekMon = $this->M_monitoringMng->cekData($component_code, $bom_version, $periode);
			if (empty($cekMon)) {
				$saveHeader = $this->M_monitoringMng->saveheaderMon($component_code, $component_desc, $bom_version, $periode, $id);
				$saveTarget = $this->M_monitoringMng->saveTarget($id, $tgl, $qty[$x], $component_code);
			}else {
				$saveTarget = $this->M_monitoringMng->saveTarget($cekMon[0]['id'], $tgl, $qty[$x], $component_code);
			}
		}
		// $cekMon = $this->M_monitoringMng->cekData($component_code, $bom_version, $periode);
		$cekInput = $this->M_monitoringMng->cekBom($component_code, $bom_version);
		// echo "<pre>"; print_r($bom_version);exit();
		if (!empty($cekInput)) {
			for ($i=0; $i < count($cari) ; $i++) { 
				if ($cari[$i]['assembly_num'] == $component_code) {
					$save = $this->M_monitoringMng->saveMonitoring($cari[$i]['root_assembly'], $cari[$i]['assembly_num'], $cari[$i]['component_num'], $cari[$i]['item_type'], $cari[$i]['qty'], $cari[$i]['assembly_path'], $cari[$i]['bom_level'], $cari[$i]['is_cycle'], $cari[$i]['identitas_bom'], $periode, $id);
				}else {
					$save = $this->M_monitoringMng->saveMonitoring($cari[$i]['root_assembly'], $cari[$i]['assembly_num'], $cari[$i]['component_num'], $cari[$i]['item_type'], $cari[$i]['qty'], $cari[$i]['assembly_path'], $cari[$i]['bom_level'], $cari[$i]['is_cycle'], $cari[$i]['identitas_bom'], $periode, $id);
				}
			}
		}
		
		redirect(base_url('MonitoringDeliverySparepart/MonitoringManagement'));
	}

	function detailMonitoringMng($root, $period){
		$user = $this->session->user;
		$hak = $this->M_monitoringMng->cekHak($user);

		$pecah1	= explode("%20", $period);
		$period = implode(" ",$pecah1);
		$datanya = $this->M_monitoringMng->getDetail($root, $period);
		$depth = intval($this->M_monitoringMng->getDept2($root));
		$data['root'] = $root;
		$desc = $this->M_monitoringMng->desc($root);
		$data['desc'] = $desc[0]['component_desc'];

		$data['Depth'] = $depth;
		$data['BOM'] = $datanya;

		foreach ($datanya as $v) {
			$data['List'][$v['bom_level']][] = $v;
		}

		$data['Tree'] = $this->buildTree($data['BOM'], $root);
		// $data['htmllist'] = $this->makeHeader($datanya,$depth,$depth, $period, $data['BOM'], $hak);
		$data['htmllist'] = $this->MakeTable($data['Tree'],$depth,$depth);
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

	// public function makeHeader($array, $depth, $depthasli, $period, $bom, $hak){
	// 	// echo "<pre>";print_r($hak);exit();
	// 	$bulan1 = $array[0]['periode_monitoring'];
	// 	$bulan2 = explode(" ", $bulan1);
	// 	$bulan 	= $bulan2[0];
	// 	$tahun	= $bulan2[1];

	// 	$header = $this->M_monitoringMng->getHeader($bulan1);
		
	// }

	public function MakeTable($array, $depth, $depthasli){
		$bulan1 = $array[0]['periode_monitoring'];
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
			$dept = $this->M_monitoringMng->getseksi($subArray['component_num']);
			if (empty($dept)) {
				$seksi = '';
			}else {
				$seksi = $dept[0]['DEPARTMENT_CLASS_CODE'];
			}
			// echo "<pre>"; print_r($bln);exit();
			if (array_key_exists('CHILDREN', $subArray)) {
				$bln = $this->targetQTY($subArray['component_num'], $bulan1, $subArray['root_assembly']);
				// echo "<pre>";print_r($bln);exit();
				if($subArray['bom_level'] != 1) {
					$headini = 'class="'.$subArray['assembly_num'].' collapse"';
				} else {
					$headini = '';
				}
				
				$output .= '<tbody '.$headini.'>
						        <tr class="clickable" data-toggle="collapse" data-target=".'.$subArray['component_num'].'" aria-expanded="false" aria-controls="'.$subArray['component_num'].'">
						            <td style="padding-left: '.(20*$kedalaman).'px;"><i class="fa fa-plus" aria-hidden="true"></i></td>
						            <td style="padding-left: '.(20*$kedalaman).'px;">'.$subArray['bom_level'].'</td>
						          	<td style="padding-left: '.(20*$kedalaman).'px;"><input type="hidden" id="compnum'.$subArray['idunix'].'" value="'.$subArray['component_num'].'">'.$subArray['component_num'].'</td>  
									<td>'.$subArray['item_type'].'</td>
									<td>'.$subArray['qty'].'</td>
									<td>'.$seksi.'</td>
									<input type="hidden" id="root'.$subArray['idunix'].'" value="'.$subArray['root_assembly'].'">
									<input type="hidden" id="idbom'.$subArray['idunix'].'" value="'.$subArray['id'].'">
									<input type="hidden" id="version'.$subArray['idunix'].'" value="'.$subArray['identitas_bom'].'">
									'.$bln.'
						        </tr>
						    </tbody>'.$this->MakeTable($subArray['CHILDREN'], $depth-1, $depthasli);
			} else {
				$bln = $this->targetQTY($subArray['component_num'], $bulan1, $subArray['root_assembly']);
				// echo "<pre>"; print_r($bln);exit();
				if ($depth == $subArray['bom_level']) {
					$anak = 'collapse in';
				} else {
					$anak = 'collapse';
				}
				$output .= '<tbody class="'.$subArray['assembly_num'].' '.$anak.'">
						        <tr >
						            <td style="padding-left: '.(20*$kedalaman).'px;">-</td>
						            <td style="padding-left: '.(20*$kedalaman).'px;">'.$subArray['bom_level'].'</td>
						          	<td style="padding-left: '.(20*$kedalaman).'px;"><input type="hidden" id="compnum'.$subArray['idunix'].'" value="'.$subArray['component_num'].'">'.$subArray['component_num'].'</td>
									<td>'.$subArray['item_type'].'</td>
									<td>'.$subArray['qty'].'</td>
									<td>'.$seksi.'</td>
									<input type="hidden" id="root'.$subArray['idunix'].'" value="'.$subArray['root_assembly'].'">
									<input type="hidden" id="idbom'.$subArray['idunix'].'" value="'.$subArray['id'].'">
									<input type="hidden" id="version'.$subArray['idunix'].'" value="'.$subArray['identitas_bom'].'">
									'.$bln.'
						        </tr>
						    </tbody>
				';
			}
		}	
		return $output;
	}
	
	function deleteData($component_code, $id){
		$deleteMonitoring = $this->M_monitoringMng->deleteMonitoring($component_code, $id);
		$deleteHeader = $this->M_monitoringMng->deleteHeader($component_code, $id);
		$deleteTarget = $this->M_monitoringMng->deleteTarget($component_code, $id);
		$deleteAktual = $this->M_monitoringMng->deleteAktual($component_code, $id);
		
		redirect(base_url('MonitoringDeliverySparepart/MonitoringManagement'));
	}
		
	function targetQTY($compnum, $periode, $root){
		$bulan2 = explode(" ", $periode);
		$bulan 	= $bulan2[0];
		$tahun 	= $bulan2[1];
		$datanya = $this->M_monitoringMng->getDetail2($root, $periode, $compnum);
		// echo "<pre>"; print_r($datanya);exit();
		$bln = '';
		foreach ($datanya as $key) {
			if ($bulan == 'Jan' || $bulan == 'Mar' || $bulan == 'May' || $bulan == 'Jul' || $bulan == 'Ags' || $bulan == 'Oct' || $bulan == 'Dec') {
				for ($i=1; $i < 32; $i++) { 
					$no = sprintf("%02d", $i);
					$target = $no + $key['bom_level'];
					$target = sprintf("%02d", $target);
					$cek2 = $this->M_monitoringMng->getqtyTarget($key['root_assembly'], $key['id'], $target);
					// echo "<pre>";print_r($cek2);exit();
					if (!empty($cek2) && $key['bom_level'] == 1) {
						$qtyTarget = $cek2[0]['qty_target'] * $key['qty'] ;
					}elseif(!empty($cek2) && $key['bom_level'] != 1){
						$jumlah = array();
						$pisah = explode(' <-- ', $key['assembly_path']);
						for ($q=1; $q < $key['bom_level']; $q++) { 
							$cari = $this->M_monitoringMng->cariqtySebelumnya($pisah[$q], $key['id']);
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
					$bln .= "<td><input type='text' style='width:30px' id='qty".$i.$key['idunix']."' value='".$qtyTarget."' ></td>";
				}
			}elseif ($bulan == 'Apr' || $bulan == 'Jun' || $bulan == 'Sep' || $bulan == 'Nov') {
				for ($i=1; $i < 31; $i++) { 
					$no = sprintf("%02d", $i);
					$target = $no + $key['bom_level'];
					$target = sprintf("%02d", $target);
					$cek2 = $this->M_monitoringMng->getqtyTarget($key['root_assembly'], $key['id'], $target);
					if (!empty($cek2) && $key['bom_level'] == 1) {
						$qtyTarget = $cek2[0]['qty_target'] * $key['qty'] ;
					}elseif(!empty($cek2) && $key['bom_level'] != 1){
						$jumlah = array();
						$pisah = explode(' <-- ', $key['assembly_path']);
						for ($q=1; $q < $key['bom_level']; $q++) { 
							$cari = $this->M_monitoringMng->cariqtySebelumnya($pisah[$q], $key['id']);
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
					$bln .= "<td><input type='text' style='width:30px' id='qty".$i.$key['idunix']."' value='".$qtyTarget."' ></td>";
				}
			}elseif ($bulan == 'Feb') {
				if ($tahun%4 == 0) {
					for ($i=1; $i < 30; $i++) { 
						$no = sprintf("%02d", $i);
						$target = $no + $key['bom_level'];
						$target = sprintf("%02d", $target);
						$cek2 = $this->M_monitoringMng->getqtyTarget($key['root_assembly'], $key['id'], $target);
						if (!empty($cek2) && $key['bom_level'] == 1) {
							$qtyTarget = $cek2[0]['qty_target'] * $key['qty'] ;
						}elseif(!empty($cek2) && $key['bom_level'] != 1){
							$jumlah = array();
							$pisah = explode(' <-- ', $key['assembly_path']);
							for ($q=1; $q < $key['bom_level']; $q++) { 
								$cari = $this->M_monitoringMng->cariqtySebelumnya($pisah[$q], $key['id']);
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
						$bln .= "<td><input type='text' style='width:30px' id='qty".$i.$key['idunix']."' value='".$qtyTarget."' ></td>";
					}
				}else {
					for ($i=1; $i < 29; $i++) { 
						$no = sprintf("%02d", $i);
						$target = $no + $key['bom_level'];
						$target = sprintf("%02d", $target);
						$cek2 = $this->M_monitoringMng->getqtyTarget($key['root_assembly'], $key['id'], $target);
						if (!empty($cek2) && $key['bom_level'] == 1) {
							$qtyTarget = $cek2[0]['qty_target'] * $key['qty'] ;
						}elseif(!empty($cek2) && $key['bom_level'] != 1){
							$jumlah = array();
							$pisah = explode(' <-- ', $key['assembly_path']);
							for ($q=1; $q < $key['bom_level']; $q++) { 
								$cari = $this->M_monitoringMng->cariqtySebelumnya($pisah[$q], $key['id']);
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
						$bln .= "<td><input type='text' style='width:30px' id='qty".$i.$key['idunix']."' value='".$qtyTarget."' ></td>";
					}
				}
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


	// function saveQtyTarget(){
	// 	$i 				= $this->input->post('no');
	// 	$tgl2 			= sprintf("%02d", $i);
	// 	$qty 			= $this->input->post('qty');
	// 	$compnum 		= $this->input->post('compnum');
	// 	$root 			= $this->input->post('root');
	// 	$id 			= $this->input->post('idBom');
	// 	$bom_version 	= $this->input->post('version');
	// 	$cari			= $this->M_monitoringMng->getDataBom($root, $bom_version);
		
	// 	// echo "<pre>"; print_r($id);exit();
	// 	// if (!empty($cek2)) {
	// 	// 	if (empty($cek)) {
	// 	// 		$saveHeader = $this->M_monitoringMng->saveheaderMon($component_code, $component_desc, $bom_version, $periode, $id);
	// 	// 		$saveTarget = $this->M_monitoringMng->saveTarget($id, $tglTarget, $qty, $component_code);
	// 	// 	}else {
	// 		$tglTarget = $tgl2.' '.$bom_version;
	// 		// echo "<pre>"; print_r($tglTarget);exit();
	// 			$saveTarget = $this->M_monitoringMng->saveTarget($id, $tglTarget, $qty, $root);
	// 	// 	}

	// 		$coba = $qty;
	// 		for ($i=0; $i < count($cari) ; $i++) { 
	// 			// $cek = $this->M_monitoringMng->cekData($component_code, $bom_version);
	// 			// if (!empty($cek)) {
	// 				if ($cari[$i]['assembly_num'] == $root) {
	// 					$qty1 = $qty * $cari[$i]['qty'];
	// 					$coba = $qty1;
	// 					$tgl3 = $tgl2 - $cari[$i]['bom_level'];
	// 					$tgl = sprintf("%02d", $tgl3);
	// 					$update = $this->M_monitoringMng->updateMonitoring($cari[$i]['root_assembly'], $cari[$i]['component_num'], $cari[$i]['bom_level'], $cari[$i]['identitas_bom'], $qty1, $tgl, $id);
	// 				}else {
	// 					if ($cari[$i]['bom_level'] == 2) {
	// 						$qty1= $coba * $cari[$i]['qty'] ;
	// 						$coba2 = $qty1;
	// 					}else {
	// 						$qty1 = $coba2 * $cari[$i]['qty'];
	// 					}
	// 					$tgl3 = $tgl2 - $cari[$i]['bom_level'];
	// 					$tgl = sprintf("%02d", $tgl3);
	// 					$update = $this->M_monitoringMng->updateMonitoring($cari[$i]['root_assembly'], $cari[$i]['component_num'], $cari[$i]['bom_level'], $cari[$i]['identitas_bom'], $qty1, $tgl, $id);
	// 				}
	// 		// 	}else {
	// 		// 		if ($cari[$i]['assembly_num'] == $component_code) {
	// 		// 			$qty1 = $qty * $cari[$i]['qty'];
	// 		// 			$coba = $qty1;
	// 		// 			$save = $this->M_monitoringMng->saveMonitoring($cari[$i]['root_assembly'], $cari[$i]['assembly_num'], $cari[$i]['component_num'], $cari[$i]['item_type'], $cari[$i]['qty'], $cari[$i]['assembly_path'], $cari[$i]['bom_level'], $cari[$i]['is_cycle'], $cari[$i]['identitas_bom'], $qty1, $tgl2, $periode, $id);
	// 		// 		}else {
	// 		// 			if ($cari[$i]['bom_level'] == 2) {
	// 		// 				$qty1= $coba * $cari[$i]['qty'] ;
	// 		// 				$coba2 = $qty1;
	// 		// 			}else {
	// 		// 				$qty1 = $coba2 * $cari[$i]['qty'];
	// 		// 			}
	// 		// 			$slsh = $cari[$i]['bom_level'] - 1;
	// 		// 			$tgl3 = $tgl2 - $slsh;
	// 		// 			$tgl = sprintf("%02d", $tgl3);
	// 		// 			$save = $this->M_monitoringMng->saveMonitoring($cari[$i]['root_assembly'], $cari[$i]['assembly_num'], $cari[$i]['component_num'], $cari[$i]['item_type'], $cari[$i]['qty'], $cari[$i]['assembly_path'], $cari[$i]['bom_level'], $cari[$i]['is_cycle'], $cari[$i]['identitas_bom'], $qty1, $tgl, $periode, $id);
	// 		// 		}
	// 		// 	}
				
	// 		// }
	// 	// }else {
	// 	}
	// 	redirect(base_url('MonitoringDeliverySparepart/MonitoringManagement'));
	// }

}