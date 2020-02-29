<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
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
		$this->load->model('MonitoringDeliverySparepart/M_monitoring');

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

		$data['Title'] = 'Monitoring';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$cek = $this->M_monitoring->cekHak($user);
		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		if ($cek[0]['hak_akses'] == 'Koordinator') {
			$data['UserMenu'] = $UserMenu;
		}else {
			$data['UserMenu'][] = $UserMenu[2];
		}
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['hak'] = $cek;
		// echo "<pre>";print_r($data['hak']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringDeliverySparepart/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
    }
    
    function searchData(){
			$user = $this->session->user;
			$hak = $this->M_monitoring->cekHak($user);

			$period 			= $this->input->post('periode');
			$deptclass 		= $this->input->post('dept');
			$datanya 			= $this->M_monitoring->getData($period);
			$data['datanya'] = $datanya;
			$data['BOM'] 	= $datanya;
			if (!empty($datanya)) {
				$depth 					= intval($this->M_monitoring->getData($period));
				$bulan 				  = explode(" ", $period);
				$data['bulan']	= $bulan[0];
				$data['tahun'] 	= $bulan[1];
			}else {
				$data['Tree'] 	= '';
				$depth 					= '';
				$bulan 				  = explode(" ", $period);
				$data['bulan']	= $bulan[0];
				$data['tahun'] 	= $bulan[1];
			}
			
			// echo "<pre>"; print_r($datanya);exit();
			// $datanya = $this->M_monitoring->getBoM();
			// $depth = intval($this->M_monitoring->getDepthBom());

			$data['Depth'] = $depth;
			// foreach ($datanya as $ue) {
			// 	$data['BOM'][$ue['COMPONENT_NUM']] = $ue;
			// }

			foreach ($datanya as $v) {
				$data['List'][$v['bom_level']][] = $v;
			}
			
			$htmllist = $this->makeHeader($datanya,$depth,$depth, $period, $data['BOM'], $deptclass, $hak);
			// $htmllist = $this->makeHeader($data['Tree'],$depth,$depth);
			if (empty($htmllist)) {
				$data['htmllist'] = '<center>Tidak ada delivery pada bulan ini<center>';
			}else{
				$data['htmllist'] = $htmllist;
			}		

					$this->load->view('MonitoringDeliverySparepart/V_TblMonitoring', $data);
    }

	function buildTree(array $elements, $parentId) {
		$branch = array();

	    foreach ($elements as $element) {
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


	public function makeHeader($array, $depth, $depthasli, $period, $bom, $deptclass, $hak){
		if (!empty($array)) {
			$bulan1 = $array[0]['periode_monitoring'];
			$bulan2 = explode(" ", $bulan1);
			$bulan 	= $bulan2[0];
			$tahun	= $bulan2[1];
		}else {
			$bulan1 = '';
			$bulan 	= '';
			$tahun 	= '';
		}

		$warna = array( '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1');
		$kedalaman = $depthasli-$depth;

		$header = $this->M_monitoring->getHeader($bulan1);
		// echo "<pre>"; print_r($header);exit();
		$header2 = '';
		for ($h=0; $h < count($header) ; $h++) { 
				$dept = $this->M_monitoring->getseksi($header[$h]['component_code']);
				if (empty($dept)) {
					$seksi = '';
				}else {
					$seksi = $dept[0]['DEPARTMENT_CLASS_CODE'];
				}
				if ($hak[0]['hak_akses'] == 'Koordinator') {
					$td = '';
					$bg1 = '#82e4ff';
					$bg2 = '#ffffa6';
					$tipe = '';
				}else {
					$tipe = 'display:none';
					if ($deptclass == $seksi) {
						$td = '';
						$bg1 = '#82e4ff';
						$bg2 = '#ffffa6';
					}else{
						$td = 'disabled';
						$bg1 = '';
						$bg2 = '';
					}
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
							$cek = $this->M_monitoring->cekAktual($header[$h]['component_code'], $header[$h]['component_code'], $header[$h]['identitas_bom'], $no2);
							if (!empty($cek)) {
								$qty = $cek[0]['qty_aktual'];
								if ($cek[0]['terima_komponen'] != '') {
									$color = 'text-black';
								}else {
									$color = 'text-red';
								}
							}else {
								$qty = '';
								$color = 'text-red';
							}
							
							$cek2 = $this->M_monitoring->getqtyTarget($header[$h]['component_code'], $header[$h]['id'], $no2);
							if (!empty($cek2)) {
								$qtyTarget = $cek2[0]['qty_target'];
							}else{
								$qtyTarget = '';
							}
							$bln2 .= "<td><input type='text' style='width:30px;background-color:".$bg1.";font-weight:bold' class='text-center' id='qty".$i.$header[$h]['id']."'  value='".$qtyTarget."' onchange='saveQtyTarget2(".$i.",".$header[$h]['id'].")' ".$td.">
												<input type='text' style='width:30px;background-color:".$bg2.";font-weight:bold' id='akt".$i.$header[$h]['id']."' class='terima".$header[$h]['id']." ".$color." text-center' value='".$qty."' onchange='saveAktual(".$i.",".$header[$h]['id'].",".$header[$h]['id'].")' ".$td."></td>";
						}

					$kodekomponen = array();
					$tree 	= $this->buildTree($bom, $header[$h]['component_code']);
					$output = $this->MakeTable($tree, $depth, $depthasli, $deptclass, $hak, $kodekomponen);
					$akt = $this->M_monitoring->cekAktual2($header[$h]['component_code'], $header[$h]['component_code'], $header[$h]['identitas_bom'], $header[$h]['id']);
					// echo "<pre>";print_r($akt);exit();
					$totalAkt = 0;
					for ($a=0; $a < count($akt) ; $a++) { 
						$totalAkt += $akt[$a]['qty_aktual'];
					}
					$trgt = $this->M_monitoring->getqtyTarget2($header[$h]['component_code'], $header[$h]['id']);
					$totalTrg = 0;
					for ($a=0; $a < count($trgt) ; $a++) { 
						$totalTrg += $trgt[$a]['qty_target'];
					}
					$presentase = $totalAkt / $totalTrg;
					// echo "<pre>"; print_r($bom);exit();
					if ($h % 2 == 0) {
						$warnatbody = '#fbc78d';
					} else {
						$warnatbody = '#aed581';
					}
					$header2 .= '<tbody style="background-color: '.$warnatbody.';">
												<tr data-toggle="collapse" data-target=".'.$header[$h]['component_code'].'" aria-expanded="false" aria-controls="'.$header[$h]['component_code'].'"  onclick="ganti('.$header[$h]['id'].')">
													<td style="padding-left: '.(20*$kedalaman).'px;"><i id="icon'.$header[$h]['id'].'" class="fa fa-minus" aria-hidden="true"></i></td>
													<td style="padding-left: '.(20*$kedalaman).'px;"><b>Root Assembly</b></td>
													<td style="padding-left: '.(20*$kedalaman).'px;"><input type="hidden" id="compnum'.$header[$h]['id'].'" value="'.$header[$h]['component_code'].'">'.$header[$h]['component_code'].'</td>  
													<td colspan="5"><input type="hidden" id="desc'.$header[$h]['id'].'" value="'.$header[$h]['component_desc'].'">'.$header[$h]['component_desc'].'</td>
													<td></td>
													<td>'.$seksi.'</td>
													<td><button type="button" class="btn btn-xs btn-info" style="'.$tipe.'" onclick="getModalTerima('.$header[$h]['id'].', '.$header[$h]['id'].')">Terima</button></td>
													<td style="font-size:15px">P <br> A</td>
													<input type="hidden" id="root'.$header[$h]['id'].'" value="'.$header[$h]['component_code'].'">
													<input type="hidden" id="idbom'.$header[$h]['id'].'" value="'.$header[$h]['id'].'">
													<input type="hidden" id="version'.$header[$h]['id'].'" value="'.$header[$h]['identitas_bom'].'">
													<input type="hidden" id="tanda'.$header[$h]['id'].'" value="minus">
													'.$bln2.'
													<td><input type="text" value="'.$totalTrg.'" class="text-center" style="width:30px;background-color:'.$bg1.'">
															<input type="text" value="'.$totalAkt.'" class="text-center" style="width:30px;background-color:'.$bg2.'"></td>
													<td>'.$presentase.'</td>
												</tr>
											'.$output.'
											</tbody>
											<tbody><tr><td></td></tr></tbody>';
		}
		return $header2;
	}

	public function MakeTable($array, $depth, $depthasli, $deptclass, $hak, $kodekomponen){
		if (!empty($array)) {
			$bulan1 = $array[0]['identitas_bom'];
			$bulan2 = explode(" ", $bulan1);
			$bulan  = $bulan2[0];
			$tahun  = $bulan2[1];
		}else {
			$bulan = '';
			$tahun = '';
		}
		// echo "<pre>"; print_r($bulan);exit();

		$warna = array( '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1', '#f1f1f1');
		$kedalaman = $depthasli-$depth;
		//Base case: an empty array produces no list
		if (empty($array)) return '';

		//Recursive Step: make a list with child lists	
		$output = '';
		foreach ($array as $key => $subArray) {
			$dept = $this->M_monitoring->getseksi($subArray['component_num']);
			if (empty($dept)) {
				$seksi = '';
			}else {
				$seksi = $dept[0]['DEPARTMENT_CLASS_CODE'];
			}
			
			if ($hak[0]['hak_akses'] == 'Koordinator') {
				$tipe = '';				
			}else {
				if ($subArray['bom_level'] == 1) {
					$tipe = 'display:none';
				}else {
					
				}

				if ($deptclass == $seksi) {
					$tp = $this->M_monitoring->getCode($subArray['component_num'], $subArray['id'], $subArray['bom_level']);
					for ($i=0; $i < count($tp) ; $i++) { 
						$kode = $tp[$i]['component_num'];
						array_push($kodekomponen, $kode);
					}
					$tipe = 'display:none';
				}else{
					if (in_array($subArray['component_num'], $kodekomponen)) {
						$tipe = '';
					}else {
						$tipe = 'display:none';	
					}
				}
			}
			// echo "<pre>";print_r($kodekomponen);exit();

			if (array_key_exists('CHILDREN', $subArray)) {
				$bln = $this->targetQTY($subArray['component_num'], $subArray['periode_monitoring'], $subArray['root_assembly'], $subArray['id'], $seksi, $deptclass, $hak, $subArray['idunix']);
				$pisah = explode(" <-- ", $subArray['assembly_path']);
				$col = '';
				for ($p=0; $p < count($pisah) ; $p++) { 
					$col .= $pisah[$p].' ';
				}
				$output .= '<tr class="'.$col.' collapse in" data-toggle="collapse" data-target=".'.$subArray['component_num'].'" aria-expanded="false" aria-controls="'.$subArray['component_num'].'" onclick="ganti('.$subArray['idunix'].')">
													<td style="padding-left: '.(15*$kedalaman).'px;"><i id="icon'.$subArray['idunix'].'" name="icon" class="fa fa-minus '.$col.'"></i></td>
													<td style="padding-left: '.(15*$kedalaman).'px;">'.$subArray['bom_level'].'</td>
													<td style="padding-left: '.(15*$kedalaman).'px;"><input type="hidden" id="compnum'.$subArray['idunix'].'" value="'.$subArray['component_num'].'">'.$subArray['component_num'].'</td>  
													<td colspan="5"><input type="hidden" id="desc'.$subArray['idunix'].'" value="'.$subArray['item_type'].'">'.$subArray['item_type'].'</td>
													<td>'.$subArray['qty'].'</td>
													<td>'.$seksi.'</td>
													<td><button type="button" class="btn btn-xs btn-info" onclick="getModalTerima('.$subArray['id'].', '.$subArray['idunix'].')" style="'.$tipe.'" >Terima</button></td>
													<td style="font-size:15px">P <br> A</td>
													<input type="hidden" id="root'.$subArray['idunix'].'" value="'.$subArray['root_assembly'].'">
													<input type="hidden" id="idbom'.$subArray['idunix'].'" value="'.$subArray['id'].'">
													<input type="hidden" id="version'.$subArray['idunix'].'" value="'.$subArray['identitas_bom'].'">
													<input type="hidden" id="tanda'.$subArray['idunix'].'" name="tanda" class="'.$col.'" value="minus">
													'.$bln.'
											</tr>'.$this->MakeTable($subArray['CHILDREN'], $depth-1, $depthasli, $deptclass, $hak, $kodekomponen);
			} else {
				$bln = $this->targetQTY($subArray['component_num'], $subArray['periode_monitoring'], $subArray['root_assembly'], $subArray['id'], $seksi, $deptclass, $hak, $subArray['idunix']);
				$pisah = explode(" <-- ", $subArray['assembly_path']);
				$col = '';
				for ($p=0; $p < count($pisah) ; $p++) { 
					$col .= $pisah[$p].' ';
				}
				$output .= '<tr class="'.$col.' collapse in">
											<td style="padding-left: '.(15*$kedalaman).'px;"></td>
											<td style="padding-left: '.(15*$kedalaman).'px;">'.$subArray['bom_level'].'</td>
											<td style="padding-left: '.(15*$kedalaman).'px;"><input type="hidden" id="compnum'.$subArray['idunix'].'" value="'.$subArray['component_num'].'">'.$subArray['component_num'].'</td>
											<td colspan="5"><input type="hidden" id="desc'.$subArray['idunix'].'" value="'.$subArray['item_type'].'">'.$subArray['item_type'].'</td>
											<td>'.$subArray['qty'].'</td>
											<td>'.$seksi.'</td>
											<td><button type="button" class="btn btn-xs btn-info" style="'.$tipe.'" onclick="getModalTerima('.$subArray['id'].', '.$subArray['idunix'].')">Terima</button></td>
											<td style="font-size:15px">P <br> A</td>
											<input type="hidden" id="root'.$subArray['idunix'].'" value="'.$subArray['root_assembly'].'">
											<input type="hidden" id="idbom'.$subArray['idunix'].'" value="'.$subArray['id'].'">
											<input type="hidden" id="version'.$subArray['idunix'].'" value="'.$subArray['identitas_bom'].'">
											'.$bln.'
										</tr>';
			}
		}	
		return $output;
	}

	function targetQTY($compnum, $periode, $root, $id, $seksi, $deptclass, $hak, $unix){
		$bulan2 = explode(" ", $periode);
		$bulan 	= $bulan2[0];
		$tahun 	= $bulan2[1];
		$datanya = $this->M_monitoring->getDetail2($compnum, $periode, $root, $id, $unix);
		
		$bln = '';
		foreach ($datanya as $key) {
			if ($hak[0]['hak_akses'] == 'Koordinator') {
				$td = '';
				$bg1 = '#82e4ff';
				$bg2 = '#ffffa6';
			}else {
				if ($deptclass == $seksi) {
					$td = '';
					$bg1 = '#82e4ff';
					$bg2 = '#ffffa6';
				}else{
					$td = 'disabled';
					$bg1 = '';
					$bg2 = '';
				}
			}
			$tampAkt = array();
			$tampTrg = array();
			if ($bulan == 'Jan' || $bulan == 'Mar' || $bulan == 'May' || $bulan == 'Jul' || $bulan == 'Ags' || $bulan == 'Oct' || $bulan == 'Dec') {
				$x = 34;
				$y = 32;
			}elseif ($bulan == 'Apr' || $bulan == 'Jun' || $bulan == 'Sep' || $bulan == 'Nov') {
				$x = 33;
				$y = 31;
			}elseif ($bulan == 'Feb') {
				if ($tahun%4 == 0) {
					$x = 32;
					$y = 30;
				}else {
					$x = 31;
					$y = 29;
			}
		}
		for ($i=1; $i < $x; $i++) { 
			if ($i < $y) {
				$no = sprintf("%02d", $i);
				$cek = $this->M_monitoring->cekAktual($key['root_assembly'], $key['component_num'], $key['identitas_bom'], $no);
				if (!empty($cek)) {
					$qty = $cek[0]['qty_aktual'];
					if ($cek[0]['terima_komponen'] != '') {
						$color = 'text-black';
					}else {
						$color = 'text-red';
					}
				}else {
					$qty = '';
					$color = 'text-red';
				}
				array_push($tampAkt, $qty);
				$qtyTarget = $this->iniTarget($no, $key);
				array_push($tampTrg, $qtyTarget);
				$bln .= "<td><input type='text' style='width:30px;background-color:".$bg1."' id='qty".$i.$key['idunix']."' class='text-center' value='".$qtyTarget."'  ".$td.">
									<input type='text' style='width:30px;background-color:".$bg2.";font-weight:bold' id='akt".$i.$key['idunix']."' class='terima".$key['idunix']." ".$color." text-center' value='".$qty."' onchange='saveAktual(".$i.",".$key['id'].",".$key['idunix'].")' ".$td."></td>";
			}elseif ($i == $y) {
				$totalTrg = array_sum($tampTrg);
				$totalAkt = array_sum($tampAkt);
				$bln .= "<td><input type='text' value='".$totalTrg."' class='text-center' style='width:30px;background-color:".$bg1."'>
										<input type='text' value='".$totalAkt."' class='text-center' style='width:30px;background-color:".$bg2.";font-weight:bold'></td>";
			}else {
				$totalTrg = array_sum($tampTrg);
				$totalAkt = array_sum($tampAkt);
				$presentase = $totalAkt / $totalTrg;
				$bln .= "<td>".$presentase."</td>";
			}
		}
	}
		return $bln;
	}

	public function iniTarget($no, $key){
		$target = $no + $key['bom_level'];
		$target = sprintf("%02d", $target);
		$cek2 = $this->M_monitoring->getqtyTarget($key['root_assembly'], $key['id'], $target);
		// echo "<pre>";print_r($target);exit();
					if (!empty($cek2) && $key['bom_level'] == 1) {
						$qtyTarget = $cek2[0]['qty_target'] * $key['qty'] ;
					}elseif(!empty($cek2) && $key['bom_level'] != 1){
						$jumlah = array();
						$haha = explode(' <-- ', $key['assembly_path']);
						for ($q=1; $q < $key['bom_level']; $q++) { 
							$cari = $this->M_monitoring->cariqtySebelumnya($haha[$q], $key['id']);
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
		return $qtyTarget;
	}

	public function saveQtyTarget(){
		$i 				= $this->input->post('no');
		$tgl2 		= sprintf("%02d", $i);
		$qty 			= $this->input->post('qty');
		$compnum 	= $this->input->post('compnum');
		$root 		= $this->input->post('root');
		$id 			= $this->input->post('idBom');
		$bom_version 	= $this->input->post('version');
		$idunix 	= $this->input->post('idunix');

		if ($qty != '') {
			$save = $this->M_monitoring->saveTarget($id, $qty, $root, $tgl2);
		}else {
			$this->M_monitoring->deleteTarget($id, $root, $tgl2);
		}
		// $update = $this->M_monitoring->updateMonitoring($root, $compnum, $idunix, $bom_version, $qty, $tgl2, $id);
	}

	public function saveQtyAktual(){
		$qty 			= $this->input->post('qty');
		$compnum 	= $this->input->post('compnum');
		$root 		= $this->input->post('root');
		$version 	= $this->input->post('periode');
		$id 			= $this->input->post('id1');
		$no 			= $this->input->post('no');
		$tgl 			= sprintf("%02d", $no);

		if ($qty != '') {
			$cek = $this->M_monitoring->cekQTY($id,$tgl);
			if (empty($cek)) {
				$save = $this->M_monitoring->saveAktual($compnum, $root, $id, $qty, $tgl, $version);
			}else {
				$save = $this->M_monitoring->updateAktual($id, $tgl, $qty);
			}
		}else {
			$this->M_monitoring->deleteAktual($id, $root, $tgl, $compnum);
		}
		
	}

	public function terimaKomponen(){
		$compnum 	= $this->input->post('compnum');
		$root 		= $this->input->post('root');
		$id				= $this->input->post('id1');
		$periode	= $this->input->post('periode');
		$tanggal 	= $this->input->post('tgl'); 
		$tgl			= sprintf("%02d", $tanggal);

		$this->M_monitoring->terimaKomponen($compnum, $root, $id, $periode, $tgl);
	}

	public function getModal(){
		$compnum 	= $this->input->post('compnum');
		$desc		 	= $this->input->post('desc');
		$root 		= $this->input->post('root');
		$id				= $this->input->post('id1');
		$idunix		= $this->input->post('id2');
		// echo "<pre>";print_r($id);exit();
		$data = $this->M_monitoring->getAktual($root, $id, $compnum);
		$tgl = '<center><h3>Komponen : </h3></center>
						<center><h4>'.$compnum.' - '.$desc.'</h4></center></br>
						<center><h4>Pilih tanggal :<h4></center>';
		if (empty($data)) {
			$tgl .= '<center><p class="text-red">Tidak ada tanggal aktual.</p></center>'; 
		}else{
				for ($i=0; $i < count($data) ; $i++) { 
						if ($data[$i]['terima_komponen'] == 1) {
								$icon = 'fa-check-square-o';
								$color = 'text-green';
						}else {
								$icon = 'fa-square-o';
								$color = 'text-red';
						}
						$tgl .= '<center><button type="button" id="btnterima'.$idunix.$i.'" class="btn btn-xs '.$color.'" style="background-color:inherit" onclick="terimaKomp('.$id.', '.$idunix.', '.$data[$i]['tanggal_aktual'].', '.$i.')"><i id="faterima'.$idunix.$i.'" class=" fa fa-2x '.$icon.'"></i></button> '.$data[$i]['tanggal_aktual'].' '.$data[$i]['identitas_bom'].'</center>';
			}
		}
		echo $tgl;
	}

}