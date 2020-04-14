<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Hitung extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('PerhitunganUM/M_hitung');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		// $this->checkSession();
		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		// $username 	 = $this->M_hitung->username($user);
		// $data['name'] = $username[0]['FIRST_NAME'].' '.$username[0]['MIDDLE_NAMES'].' '.$username[0]['LAST_NAME'];
		// echo "<pre>"; print_r($data['name']);exit();
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganUM/V_Hitung',$data);
		$this->load->view('V_Footer',$data);
		
	}

	function DeptClass()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_hitung->seksidept($term);
		echo json_encode($data);
	}

	public function search()
	{
		$deptclass 		= $this->input->post('deptclass');
		$plan			= $this->input->post('plan');
		$data['username'] = $this->input->post('username');
		$data['dept'] 	= $deptclass; 
		$data['plan'] 	= $plan; 

		$data['value'] = $this->M_hitung->dataPUM($plan, $deptclass);
		$stock = $this->M_hitung->stockawal($deptclass, $plan);
		// echo "<pre>"; print_r($data['value']);exit();

		if($deptclass == 'PAINT'){
			$j=0;
			foreach ($data['value'] as $val) {
				$data['value'][$j]['JENIS_MESIN'] = 'LINE ';
				$j++;
			}
		}

		$i=0;
		foreach ($data['value'] as $val) {
			$data['value'][$i]['STOK_AWAL'] = '0';
			$i++;
		}
		
		foreach ($stock as $key) {
			$i = 0;
			foreach ($data['value'] as $value) {
				if($value['KODE_KOMPONEN'] == $key['KODE_KOMPONEN']){
					$data['value'][$i]['STOK_AWAL'] = $key['STOK_AWAL'];
				}
				$i++;
			}
		}
		// echo "<pre>"; print_r($data['value']); exit();

		// pengelompokan array
		$a = 1/3*sizeof($data['value']); //bulan ke-2
		$b = 2/3*sizeof($data['value']); //bulan ke-3
		$hasil = array();
		for ($i=0; $i < 1/3*sizeof($data['value']); $i++) {
			$hasil[$i]['cost_center']	= $data['value'][$i]['COST_CENTER'];
			$hasil[$i]['resource_code']	= $data['value'][$i]['RESOURCE_CODE'];
			$hasil[$i]['deskripsi']		= $data['value'][$i]['DESKRIPSI'];
			$hasil[$i]['jenis_mesin']	= $data['value'][$i]['JENIS_MESIN'];
			$hasil[$i]['Mesin']			= $data['value'][$i]['NO_MESIN'];
			$hasil[$i]['tag_number']	= $data['value'][$i]['TAG_NUMBER'];
			$hasil[$i]['Item']			= $data['value'][$i]['KODE_KOMPONEN'];
			$hasil[$i]['Description']	= $data['value'][$i]['DESKRIPSI_KOMPONEN'];
			$hasil[$i]['cycle_time']	= sprintf("%f",$data['value'][$i]['USAGE_RATE']);
			$hasil[$i]['stock'] 		= $data['value'][$i]['STOK_AWAL'];
			$hasil[$i]['qty1'] 			= $data['value'][$i]['QTY'];
			$hasil[$i]['qty2'] 			= $data['value'][$a]['QTY'];
			$hasil[$i]['qty3'] 			= $data['value'][$b]['QTY'];
			$hasil[$i]['opr_seq'] 		= $data['value'][$i]['OPR_SEQ'];
			$hasil[$i]['bln1'] 			= $data['value'][$i]['PERIODE'];
			$hasil[$i]['bln2'] 			= $data['value'][$a]['PERIODE'];
			$hasil[$i]['bln3'] 			= $data['value'][$b]['PERIODE'];
			$hasil[$i]['periode1']		= substr($data['value'][$i]['PERIODE'],0,3);
			$hasil[$i]['periode2']		= substr($data['value'][$b]['PERIODE'],0,3);
			$a++; 
			$b++;
		}
		$data['hasil'] 	= $hasil;
		// echo "<pre>"; print_r($data['hasil']); exit();
		$this->load->view('PerhitunganUM/V_TableHitung', $data);
	}

	function hitungan(){
		$cost 		= $this->input->post('cost_center[]');
		$resource 	= $this->input->post('resource_code[]');
		$desc 		= $this->input->post('deskripsi[]');
		$mesin 		= $this->input->post('mesin[]');
		$tag_number = $this->input->post('tag_number[]');
		$item_code 	= $this->input->post('item_code[]');
		$item_desc 	= $this->input->post('item_desc[]');
		$cycle_time = $this->input->post('cycle_time[]');
		$stock 		= $this->input->post('stock[]');
		$qty1 		= $this->input->post('qty1[]');
		$qty2 		= $this->input->post('qty2[]');
		$qty3 		= $this->input->post('qty3[]');
		$jenis_mesin = $this->input->post('jenis_mesin[]');
		$dept 		= $this->input->post('dept[]');
		$plan 		= $this->input->post('plan[]');
		$opr_seq 	= $this->input->post('opr_seq[]');
		$periode 	= $this->input->post('periode[]');
		$bln1 		= $this->input->post('bln1[]');
		$bln2 		= $this->input->post('bln2[]');
		$bln3 		= $this->input->post('bln3[]');
		$username 	= $this->input->post('username[]');
		// echo "<pre>"; print_r($dept); exit();
		
		$data['dept']		= $dept[0];
		$data['periode']	= $periode[0];
		$data['bln1'] 		= $bln1[0];
		$data['bln2'] 		= $bln2[0];
		$data['bln3']		= $bln3[0];

		// perhitungan data
		$hasil = array();
		for ($i=0; $i < sizeof($item_code); $i++) {
			$hasil[$i]['cost_center']	= $cost[$i];
			$hasil[$i]['resource_code']	= $resource[$i];
			$hasil[$i]['deskripsi']		= $desc[$i];
			$hasil[$i]['jenis_mesin']	= $jenis_mesin[$i];
			$hasil[$i]['Mesin']			= $mesin[$i];
			$hasil[$i]['tag_number']	= $tag_number[$i];
			$hasil[$i]['Item']			= $item_code[$i];
			$hasil[$i]['item_desc']		= $item_desc[$i];
			$hasil[$i]['cycle_time']	= $cycle_time[$i];
			$hasil[$i]['stock'] 		= $stock[$i];
			$hasil[$i]['qty1'] 			= $qty1[$i];
			$hasil[$i]['qty2'] 			= $qty2[$i];
			$hasil[$i]['qty3'] 			= $qty3[$i];
			$hasil[$i]['opr_seq']		= $opr_seq[$i];

		// Awal Perhitungan
			if($stock[$i] > $qty1[$i]){
				$data['Bulan1'][$i]	= '0';
				$data['sisa1'][$i] 	= $stock[$i] - $qty1[$i];
			}else{
				$data['Bulan1'][$i] = $qty1[$i] - $stock[$i];
				$data['sisa1'][$i] 	= '0';
			}
			if($data['sisa1'][$i] > $qty2[$i]){
				$data['Bulan2'][$i] = '0';
				$data['sisa2'][$i] 	= $data['sisa1'][$i] - $qty2[$i];
			}else{
				$data['Bulan2'][$i] = $qty2[$i] - $data['sisa1'][$i];
				$data['sisa2'][$i] 	= '0';
			}
			if($data['sisa2'][$i] > $qty3[$i]){
				$data['Bulan3'][$i] = '0';
			}else{
				$data['Bulan3'][$i] = $qty3[$i] - $data['sisa2'][$i];
			}
			
			$hasil[$i]['Rata2Bulan'] 	= round(($data['Bulan1'][$i]+$data['Bulan2'][$i]+$data['Bulan3'][$i])/3);
			$hasil[$i]['Jam1'] 			= round($data['Bulan1'][$i]*$cycle_time[$i],2);
			$hasil[$i]['Jam2'] 			= round($data['Bulan2'][$i]*$cycle_time[$i],2);
			$hasil[$i]['Jam3'] 			= round($data['Bulan3'][$i]*$cycle_time[$i],2);
			$hasil[$i]['RataJam'] 		= round(($hasil[$i]['Jam1']+$hasil[$i]['Jam2']+$hasil[$i]['Jam3'])/3,2);

			// Akhir Hitungan
			$hasil[$i]['Bulan1']		= $data['Bulan1'][$i];
			$hasil[$i]['Bulan2']		= $data['Bulan2'][$i];
			$hasil[$i]['Bulan3']		= $data['Bulan3'][$i];
		}

		// pengelompokan array table result
		$j = 0;					// Index per CC
		$k = 0;					// Index per data detail CC
		$m = 0;					// Index Memory mesin	
		$tampungan = array();	
		$mesin = array();	
		$rata = array();	
		$result = array();
		$result[$j]['Merge'] = 1; // Jumlah Merge CC-RC-DR-JM

		for ($i=0; $i < sizeof($hasil); $i++) {	
			// Initial First Data
			if ($i == '0') {
				$result[$j]['Detail'][$k]['cost_center'] 	= $hasil[$i]['cost_center'];
				$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['resource_code'];
				$result[$j]['Detail'][$k]['deskripsi'] 		= $hasil[$i]['deskripsi'];
				$result[$j]['Detail'][$k]['jenis_mesin'] 	= $hasil[$i]['jenis_mesin'];
			 	$result[$j]['Detail'][$m]['mesin'] 			= $hasil[$i]['Mesin'];
				$result[$j]['Detail'][$m]['tag_number'] 	= $hasil[$i]['tag_number'];
				$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['Item'];
				$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['item_desc'];
				$result[$j]['Detail'][$k]['bulan1'] 		= $hasil[$i]['Bulan1'];
				$result[$j]['Detail'][$k]['bulan2'] 		= $hasil[$i]['Bulan2'];
				$result[$j]['Detail'][$k]['bulan3'] 		= $hasil[$i]['Bulan3'];
				$result[$j]['Detail'][$k]['ratabulan'] 		= $hasil[$i]['Rata2Bulan'];
				$result[$j]['Detail'][$k]['cycle_time'] 	= $hasil[$i]['cycle_time'];
				$result[$j]['Detail'][$k]['jam1'] 			= $hasil[$i]['Jam1'];
				$result[$j]['Detail'][$k]['jam2'] 			= $hasil[$i]['Jam2'];
				$result[$j]['Detail'][$k]['jam3'] 			= $hasil[$i]['Jam3'];
				$result[$j]['Detail'][$k]['ratajam'] 		= $hasil[$i]['RataJam'];
				$result[$j]['Detail'][$k]['opr_seq'] 		= $hasil[$i]['opr_seq'];
				$Item_Opr	= $hasil[$i]['Item'].$hasil[$i]['opr_seq'];
				$nomesin 	= $result[$j]['Detail'][$m]['mesin'];
				$ratajam 	= $result[$j]['Detail'][$k]['ratajam'];
				array_push($tampungan, $Item_Opr);  
				array_push($mesin, $nomesin);  
				array_push($rata, $ratajam);  
				$k++;
			} else {
				// The rest 
				if ($hasil[$i]['tag_number'] == $hasil[$i-1]['tag_number'] ) {
					if (in_array($hasil[$i]['Item'].$hasil[$i]['opr_seq'], $tampungan)){
						// Okelah, Ya sudahlah
					}else{
						$result[$j]['Detail'][$k]['cost_center'] 	= '';
						$result[$j]['Detail'][$k]['resource_code']	= '';
						$result[$j]['Detail'][$k]['deskripsi'] 		= '';
						$result[$j]['Detail'][$k]['jenis_mesin'] 	= '';
						$result[$j]['Detail'][$k]['mesin'] 			= '';
						$result[$j]['Detail'][$k]['tag_number'] 	= '';
						$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['Item'];
						$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['item_desc'];
						$result[$j]['Detail'][$k]['bulan1'] 		= $hasil[$i]['Bulan1'];
						$result[$j]['Detail'][$k]['bulan2'] 		= $hasil[$i]['Bulan2'];
						$result[$j]['Detail'][$k]['bulan3'] 		= $hasil[$i]['Bulan3'];
						$result[$j]['Detail'][$k]['ratabulan'] 		= $hasil[$i]['Rata2Bulan'];
						$result[$j]['Detail'][$k]['cycle_time'] 	= $hasil[$i]['cycle_time'];
						$result[$j]['Detail'][$k]['jam1'] 			= $hasil[$i]['Jam1'];
						$result[$j]['Detail'][$k]['jam2'] 			= $hasil[$i]['Jam2'];
						$result[$j]['Detail'][$k]['jam3'] 			= $hasil[$i]['Jam3'];
						$result[$j]['Detail'][$k]['ratajam'] 		= $hasil[$i]['RataJam'];
						$result[$j]['Detail'][$k]['opr_seq'] 		= $hasil[$i]['opr_seq'];
						$result[$j]['Merge']++;
						$Item_Opr = $hasil[$i]['Item'].$hasil[$i]['opr_seq'];
						$ratajam 	= $result[$j]['Detail'][$k]['ratajam'];
			 			array_push($tampungan, $Item_Opr);
						array_push($rata, $ratajam);  
						$k++;
			 		}
			 		// Jaga2 klo mesin sama tapi beda CC
					if ($hasil[$i]['cost_center'] != $hasil[$i-1]['cost_center']) {
						$tampungan=array();
						$k=0;
						$m=0;
						$j++;
						$hasil[$j]['Merge']=1;
						$result[$j]['Detail'][$k]['cost_center'] 	= $hasil[$i]['cost_center'];
						$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['resource_code'];
						$result[$j]['Detail'][$k]['deskripsi'] 		= $hasil[$i]['deskripsi'];
						$result[$j]['Detail'][$k]['jenis_mesin'] 	= $hasil[$i]['jenis_mesin'];
						$result[$j]['Detail'][$k]['mesin'] 			= $hasil[$i]['Mesin'];
						$result[$j]['Detail'][$k]['tag_number'] 	= $hasil[$i]['tag_number'];
						$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['Item'];
						$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['item_desc'];
						$result[$j]['Detail'][$k]['bulan1'] 		= $hasil[$i]['Bulan1'];
						$result[$j]['Detail'][$k]['bulan2'] 		= $hasil[$i]['Bulan2'];
						$result[$j]['Detail'][$k]['bulan3'] 		= $hasil[$i]['Bulan3'];
						$result[$j]['Detail'][$k]['ratabulan'] 		= $hasil[$i]['Rata2Bulan'];
						$result[$j]['Detail'][$k]['cycle_time'] 	= $hasil[$i]['cycle_time'];
						$result[$j]['Detail'][$k]['jam1'] 			= $hasil[$i]['Jam1'];
						$result[$j]['Detail'][$k]['jam2'] 			= $hasil[$i]['Jam2'];
						$result[$j]['Detail'][$k]['jam3'] 			= $hasil[$i]['Jam3'];
						$result[$j]['Detail'][$k]['ratajam'] 		= $hasil[$i]['RataJam'];
						$result[$j]['Detail'][$k]['opr_seq'] 		= $hasil[$i]['opr_seq'];
						$k++;
					}
				// -------------------------------------
				} else{
					if ($hasil[$i]['cost_center'] == $hasil[$i-1]['cost_center']) {
						if (in_array($hasil[$i]['Item'].$hasil[$i]['opr_seq'], $tampungan)) {
							if (sizeof($tampungan) <= sizeof($mesin)) {
								$m++;
								$result[$j]['Detail'][$m]['cost_center'] 	= '';
								$result[$j]['Detail'][$m]['resource_code']	= '';
								$result[$j]['Detail'][$m]['deskripsi'] 		= '';
								$result[$j]['Detail'][$m]['jenis_mesin'] 	= '';
								$result[$j]['Detail'][$m]['mesin'] 			= $hasil[$i]['Mesin'];
								$result[$j]['Detail'][$m]['tag_number'] 	= $hasil[$i]['tag_number'];
								$result[$j]['Detail'][$m]['item'] 			= '';
								$result[$j]['Detail'][$m]['item_desc'] 		= '';
								$result[$j]['Detail'][$m]['bulan1'] 		= '';
								$result[$j]['Detail'][$m]['bulan2'] 		= '';
								$result[$j]['Detail'][$m]['bulan3'] 		= '';
								$result[$j]['Detail'][$m]['ratabulan'] 		= '';
								$result[$j]['Detail'][$m]['cycle_time'] 	= '';
								$result[$j]['Detail'][$m]['jam1'] 			= '';
								$result[$j]['Detail'][$m]['jam2'] 			= '';
								$result[$j]['Detail'][$m]['jam3'] 			= '';
								$result[$j]['Detail'][$m]['ratajam'] 		= '';
								$result[$j]['Detail'][$m]['opr_seq'] 		= '';
								$result[$j]['Merge']++;
								$nomesin = $result[$j]['Detail'][$m]['mesin'];
								array_push($mesin, $nomesin);
							}else {
								$m++;
							$result[$j]['Detail'][$m]['mesin'] = $hasil[$i]['Mesin'];
							$result[$j]['Detail'][$m]['tag_number'] = $hasil[$i]['tag_number'];
							$nomesin = $result[$j]['Detail'][$m]['mesin'];
							array_push($mesin, $nomesin);  
							}
						} else{
							$m=$k;
							$result[$j]['Detail'][$k]['cost_center'] 	= '';
							$result[$j]['Detail'][$k]['resource_code']	= '';
							$result[$j]['Detail'][$k]['deskripsi'] 		= '';
							$result[$j]['Detail'][$k]['jenis_mesin'] 	= '';
							$result[$j]['Detail'][$k]['mesin'] 			= $hasil[$i]['Mesin'];
							$result[$j]['Detail'][$k]['tag_number'] 	= $hasil[$i]['tag_number'];
							$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['Item'];
							$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['item_desc'];
							$result[$j]['Detail'][$k]['bulan1'] 		= $hasil[$i]['Bulan1'];
							$result[$j]['Detail'][$k]['bulan2'] 		= $hasil[$i]['Bulan2'];
							$result[$j]['Detail'][$k]['bulan3'] 		= $hasil[$i]['Bulan3'];
							$result[$j]['Detail'][$k]['ratabulan'] 		= $hasil[$i]['Rata2Bulan'];
							$result[$j]['Detail'][$k]['cycle_time'] 	= $hasil[$i]['cycle_time'];
							$result[$j]['Detail'][$k]['jam1'] 			= $hasil[$i]['Jam1'];
							$result[$j]['Detail'][$k]['jam2'] 			= $hasil[$i]['Jam2'];
							$result[$j]['Detail'][$k]['jam3'] 			= $hasil[$i]['Jam3'];
							$result[$j]['Detail'][$k]['ratajam'] 		= $hasil[$i]['RataJam'];
							$result[$j]['Detail'][$k]['opr_seq'] 		= $hasil[$i]['opr_seq'];
							$result[$j]['Merge']++;
							$k++;
						}
					}else{
						$tampungan=array();
						$mesin=array();
						$rata=array();
						$k=0;
						$m=0;
						$j++;
						$result[$j]['Merge']=1;
						$result[$j]['Detail'][$k]['cost_center'] 	= $hasil[$i]['cost_center'];
						$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['resource_code'];
						$result[$j]['Detail'][$k]['deskripsi'] 		= $hasil[$i]['deskripsi'];
						$result[$j]['Detail'][$k]['jenis_mesin'] 	= $hasil[$i]['jenis_mesin'];
						$result[$j]['Detail'][$k]['mesin'] 			= $hasil[$i]['Mesin'];
						$result[$j]['Detail'][$k]['tag_number'] 	= $hasil[$i]['tag_number'];
						$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['Item'];
						$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['item_desc'];
						$result[$j]['Detail'][$k]['bulan1'] 		= $hasil[$i]['Bulan1'];
						$result[$j]['Detail'][$k]['bulan2'] 		= $hasil[$i]['Bulan2'];
						$result[$j]['Detail'][$k]['bulan3'] 		= $hasil[$i]['Bulan3'];
						$result[$j]['Detail'][$k]['ratabulan'] 		= $hasil[$i]['Rata2Bulan'];
						$result[$j]['Detail'][$k]['cycle_time'] 	= $hasil[$i]['cycle_time'];
						$result[$j]['Detail'][$k]['jam1'] 			= $hasil[$i]['Jam1'];
						$result[$j]['Detail'][$k]['jam2'] 			= $hasil[$i]['Jam2'];
						$result[$j]['Detail'][$k]['jam3'] 			= $hasil[$i]['Jam3'];
						$result[$j]['Detail'][$k]['ratajam'] 		= $hasil[$i]['RataJam'];
						$result[$j]['Detail'][$k]['opr_seq'] 		= $hasil[$i]['opr_seq'];
						$Item_Opr = $hasil[$i]['Item'].$hasil[$i]['opr_seq'];
						array_push($tampungan, $Item_Opr);
						$nomesin = $result[$j]['Detail'][$m]['mesin'];
						array_push($mesin, $nomesin);  
						$ratajam = $result[$j]['Detail'][$k]['ratajam'];
						array_push($rata, $ratajam);  
						$k++;
					}
				}
			}
			// hitung totaljam & utilitas
			if ($result[$j]['Detail'][0]['jenis_mesin'] == 'GROUP') {
				$totaljam = array_sum($rata);
				$result[$j]['totaljam'] = round($totaljam/sizeof($mesin), 2);
				$utilitas = round($result[$j]['totaljam']/487.5*100, 2);
				if ($utilitas > 100) {
					$result[$j]['utilitas'] = '100';
				}else{
					$result[$j]['utilitas'] = $utilitas;
				}
			}else{
				$totaljam = array_sum($rata);
				$result[$j]['totaljam'] = round($totaljam, 2);
				$utilitas = round($totaljam/487.5*100, 2);
				if ($utilitas > 100) {
					$result[$j]['utilitas'] = '100';
				}else{
					$result[$j]['utilitas'] = $utilitas;
				}
			}
		}

		$data['result'] = $result;



		// pengelompokan array table result
		$x = 0;					// Index per CC
		$y = 0;					// Index per data detail CC
		$z = 0;					// Index Memory mesin	
		$tampungan2 = array();	
		$mesin2 = array();	
		$rata2 = array();	
		$insert = array();
		$insert[$x]['Merge'] = 1; // Jumlah Merge CC-RC-DR-JM

		for ($a=0; $a < sizeof($hasil); $a++) {	
			// Initial First Data
			if ($a == '0') {
				$insert[$x]['Detail'][$y]['cost_center'] 	= $hasil[$a]['cost_center'];
				$insert[$x]['Detail'][$y]['resource_code']	= $hasil[$a]['resource_code'];
				$insert[$x]['Detail'][$y]['jenis_mesin'] 	= $hasil[$a]['jenis_mesin'];
			 	$insert[$x]['Detail'][$z]['mesin'] 			= $hasil[$a]['Mesin'];
				$insert[$x]['Detail'][$z]['tag_number'] 	= $hasil[$a]['tag_number'];
				$insert[$x]['Detail'][$y]['item'] 			= $hasil[$a]['Item'];
				$insert[$x]['Detail'][$y]['ratajam'] 		= $hasil[$a]['RataJam'];
				$insert[$x]['Detail'][$y]['opr_seq'] 		= $hasil[$a]['opr_seq'];
				$insert[$x]['Detail'][$y]['username'] 		= $username[0];
				$Item_Opr	= $hasil[$a]['Item'].$hasil[$a]['opr_seq'];
				$nomesin 	= $insert[$x]['Detail'][$z]['mesin'];
				$ratajam 	= $insert[$x]['Detail'][$y]['ratajam'];
				array_push($tampungan2, $Item_Opr);  
				array_push($mesin2, $nomesin);  
				array_push($rata2, $ratajam);  
				$y++;
			} else {
				// The rest 
				if ($hasil[$a]['tag_number'] == $hasil[$a-1]['tag_number'] ) {

					if (in_array($hasil[$a]['Item'].$hasil[$a]['opr_seq'], $tampungan2)){
						// Okelah, Ya sudahlah
					}else{
						$insert[$x]['Detail'][$y]['cost_center'] 	= $hasil[$a]['cost_center'];
						$insert[$x]['Detail'][$y]['resource_code']	= $hasil[$a]['resource_code'];
						$insert[$x]['Detail'][$y]['jenis_mesin'] 	= $hasil[$a]['jenis_mesin'];
						$insert[$x]['Detail'][$y]['mesin'] 			= $hasil[$a]['Mesin'];
						$insert[$x]['Detail'][$y]['tag_number'] 	= $hasil[$a]['tag_number'];
						$insert[$x]['Detail'][$y]['item'] 			= $hasil[$a]['Item'];
						$insert[$x]['Detail'][$y]['ratajam'] 		= $hasil[$a]['RataJam'];
						$insert[$x]['Detail'][$y]['opr_seq'] 		= $hasil[$a]['opr_seq'];
						$insert[$x]['Detail'][$y]['username'] 		= $username[0];
						$result[$x]['Merge']++;
						$Item_Opr	= $hasil[$a]['Item'].$hasil[$a]['opr_seq'];
						$ratajam 	= $insert[$x]['Detail'][$y]['ratajam'];
						array_push($tampungan2, $Item_Opr);  
						array_push($rata2, $ratajam);  
						$y++;
			 		}
			 		// Jaga2 klo mesin sama tapi beda CC
					if ($hasil[$a]['cost_center'] != $hasil[$a-1]['cost_center']) {
						$tampungan2=array();
						$y=0;
						$z=0;
						$x++;
						$hasil[$x]['Merge']=1;
						$insert[$x]['Detail'][$y]['cost_center'] 	= $hasil[$a]['cost_center'];
						$insert[$x]['Detail'][$y]['resource_code']	= $hasil[$a]['resource_code'];
						$insert[$x]['Detail'][$y]['jenis_mesin'] 	= $hasil[$a]['jenis_mesin'];
						$insert[$x]['Detail'][$y]['mesin'] 			= $hasil[$a]['Mesin'];
						$insert[$x]['Detail'][$y]['tag_number'] 	= $hasil[$a]['tag_number'];
						$insert[$x]['Detail'][$y]['item'] 			= $hasil[$a]['Item'];
						$insert[$x]['Detail'][$y]['ratajam'] 		= $hasil[$a]['RataJam'];
						$insert[$x]['Detail'][$y]['opr_seq'] 		= $hasil[$a]['opr_seq'];
						$insert[$x]['Detail'][$y]['username'] 		= $username[0];
						$y++;
					}
				// -------------------------------------
				} else{
					if ($hasil[$a]['cost_center'] == $hasil[$a-1]['cost_center']) {
						if (in_array($hasil[$a]['Item'].$hasil[$a]['opr_seq'], $tampungan2)) {
							if (sizeof($tampungan2) <= sizeof($mesin2)) {
								$z++;
								$insert[$x]['Detail'][$z]['cost_center'] 	= $hasil[$a]['cost_center'];
								$insert[$x]['Detail'][$z]['resource_code']	= $hasil[$a]['resource_code'];
								$insert[$x]['Detail'][$z]['jenis_mesin'] 	= $hasil[$a]['jenis_mesin'];
								$insert[$x]['Detail'][$z]['mesin'] 			= $hasil[$a]['Mesin'];
								$insert[$x]['Detail'][$z]['tag_number'] 	= $hasil[$a]['tag_number'];
								$insert[$x]['Detail'][$z]['item'] 			= $hasil[$a]['Item'];
								$insert[$x]['Detail'][$z]['ratajam'] 		= $hasil[$a]['RataJam'];
								$insert[$x]['Detail'][$z]['opr_seq'] 		= $hasil[$a]['opr_seq'];
								$insert[$x]['Detail'][$z]['username'] 		= $username[0];
								$insert[$x]['Merge']++;
								$nomesin = $insert[$x]['Detail'][$z]['mesin'];
								array_push($mesin2, $nomesin);
							}else {
								$z++;
							$insert[$x]['Detail'][$z]['mesin'] = $hasil[$a]['Mesin'];
							$insert[$x]['Detail'][$z]['tag_number'] = $hasil[$a]['tag_number'];
							$nomesin = $insert[$x]['Detail'][$z]['mesin'];
							array_push($mesin2, $nomesin);  
							}
						} else{
							$z=$y;
							$insert[$x]['Detail'][$y]['cost_center'] 	= $hasil[$a]['cost_center'];
							$insert[$x]['Detail'][$y]['resource_code']	= $hasil[$a]['resource_code'];
							$insert[$x]['Detail'][$y]['jenis_mesin'] 	= $hasil[$a]['jenis_mesin'];
							$insert[$x]['Detail'][$y]['mesin'] 			= $hasil[$a]['Mesin'];
							$insert[$x]['Detail'][$y]['tag_number'] 	= $hasil[$a]['tag_number'];
							$insert[$x]['Detail'][$y]['item'] 			= $hasil[$a]['Item'];
							$insert[$x]['Detail'][$y]['ratajam'] 		= $hasil[$a]['RataJam'];
							$insert[$x]['Detail'][$y]['opr_seq'] 		= $hasil[$a]['opr_seq'];
							$insert[$x]['Detail'][$y]['username'] 		= $username[0];
							$insert[$x]['Merge']++;
							$y++;
						}
					}else{
						$tampungan2=array();
						$mesin2=array();
						$rata2=array();
						$y=0;
						$z=0;
						$x++;
						$insert[$x]['Merge']=1;
						$insert[$x]['Detail'][$y]['cost_center'] 	= $hasil[$a]['cost_center'];
						$insert[$x]['Detail'][$y]['resource_code']	= $hasil[$a]['resource_code'];
						$insert[$x]['Detail'][$y]['jenis_mesin'] 	= $hasil[$a]['jenis_mesin'];
						$insert[$x]['Detail'][$y]['mesin'] 			= $hasil[$a]['Mesin'];
						$insert[$x]['Detail'][$y]['tag_number'] 	= $hasil[$a]['tag_number'];
						$insert[$x]['Detail'][$y]['item'] 			= $hasil[$a]['Item'];
						$insert[$x]['Detail'][$y]['ratajam'] 		= $hasil[$a]['RataJam'];
						$insert[$x]['Detail'][$y]['opr_seq'] 		= $hasil[$a]['opr_seq'];
						$insert[$x]['Detail'][$y]['username'] 		= $username[0];
						$Item_Opr = $hasil[$a]['Item'].$hasil[$a]['opr_seq'];
						array_push($tampungan2, $Item_Opr);
						$nomesin = $insert[$x]['Detail'][$z]['mesin'];
						array_push($mesin2, $nomesin);  
						$ratajam = $insert[$x]['Detail'][$y]['ratajam'];
						array_push($rata2, $ratajam);  
						$y++;
					}
				}
			}
			// hitung totaljam & utilitas
			if ($insert[$x]['Detail'][0]['jenis_mesin'] == 'GROUP') {
				$totaljam = array_sum($rata2);
				$insert[$x]['totaljam'] = round($totaljam/sizeof($mesin2), 2);
				$utilitas = round($insert[$x]['totaljam']/487.5*100, 2);
				if ($utilitas > 100) {
					$insert[$x]['utilitas'] = '100';
				}else{
					$insert[$x]['utilitas'] = $utilitas;
				}
			}else{
				$totaljam = array_sum($rata2);
				$insert[$x]['totaljam'] = round($totaljam, 2);
				$utilitas = round($totaljam/487.5*100, 2);
				if ($utilitas > 100) {
					$insert[$x]['utilitas'] = '100';
				}else{
					$insert[$x]['utilitas'] = $utilitas;
				}
			}
		}

		$data['insert'] = $insert;
		// echo "<pre>"; print_r($insert); exit();
		$data['plan'] = $plan[0];
		$cari = $this->M_hitung->cariHasilPUM($data['dept'], $data['plan']);
		if (!empty($cari)) {
			$data['tanggal'] = $cari[0]['LAST_UPDATE_DATE'];
			$cariuser = $this->M_hitung->seksi($cari[0]['LAST_UPDATE_BY']);
			$data['nama_user'] = $cariuser[0]['FIRST_NAME'].' '.$cariuser[0]['MIDDLE_NAMES'].' '.$cariuser[0]['LAST_NAME'];
		}else{
			$data['tanggal'] = '';
			$data['nama_user'] = '';
		}



		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganUM/V_Result',$data);
		$this->load->view('V_Footer',$data);
		
	}

	function exportDataPUM(){
		$cost1 			= $this->input->post('cost_center[]');
		$resource1 		= $this->input->post('resource_code[]');
		$desc1 			= $this->input->post('deskripsi[]');
		$jenis_mesin1 	= $this->input->post('jenis_mesin[]');
		$mesin1 		= $this->input->post('mesin[]');
		$tag_number1 	= $this->input->post('tag_number[]');
		$item_code1 	= $this->input->post('item_code[]');
		$item_desc1 	= $this->input->post('item_desc[]');
		$bulana 		= $this->input->post('b1[]');
		$bulanb			= $this->input->post('b2[]');
		$bulanc 		= $this->input->post('b3[]');
		$ratabulan1 	= $this->input->post('rata[]');
		$cycle_time1 	= $this->input->post('cycle_time[]');
		$jama 			= $this->input->post('jam1[]');
		$jamb 			= $this->input->post('jam2[]');
		$jamc 			= $this->input->post('jam3[]');
		$ratajam1 		= $this->input->post('rata_jam[]');
		$totaljam1 		= $this->input->post('total_jam[]');
		$utilitas1		= $this->input->post('utilitas[]');
		$dept1			= $this->input->post('dept[]');
		$merge			= $this->input->post('merge[]');
		$periode1		= $this->input->post('periode[]');
		$bln1			= $this->input->post('bln1[]');
		$bln2			= $this->input->post('bln2[]');
		$bln3			= $this->input->post('bln3[]');
		$opr_seq		= $this->input->post('opr_seq[]');
		// echo "<pre>"; print_r($ratautilitas); exit();
		
		$seksi 		= $dept1[0];
		$sd 		= $this->M_hitung->seksidept($seksi);
		$seksidept 	= $sd[0]['SEKSI'];
		$periode 	= $periode1[0];
		$bln1 		= $bln1[0];
		$bln2 		= $bln2[0];
		$bln3 		= $bln3[0];
		// echo "<pre>"; print_r($ratautilitas); exit();

		$datapum = array();
		for ($i=0; $i < count($item_code1) ; $i++) { 
			$array = array(
				'cost_center' 	=> $cost1[$i],
				'resource_code' => $resource1[$i],
				'deskripsi' 	=> $desc1[$i],
				'jenis_mesin' 	=> $jenis_mesin1[$i],
				'nomesin' 		=> $mesin1[$i],
				'tag_number' 	=> $tag_number1[$i],
				'item_code' 	=> $item_code1[$i],
				'item_desc' 	=> $item_desc1[$i],
				'bulan1' 		=> $bulana[$i],
				'bulan2' 		=> $bulanb[$i],
				'bulan3' 		=> $bulanc[$i],
				'ratabulan' 	=> $ratabulan1[$i],
				'cycle_time' 	=> $cycle_time1[$i],
				'jam1' 			=> $jama[$i],
				'jam2' 			=> $jamb[$i],
				'jam3' 			=> $jamc[$i],
				'ratajam' 		=> $ratajam1[$i],
				'totaljam' 		=> $totaljam1[$i],
				'utilitas' 		=> $utilitas1[$i],
				'merge' 		=> $merge[$i],
				'opr_seq' 		=> $opr_seq[$i],
			);
			array_push($datapum, $array);
		}
		// echo "<pre>"; print_r(sizeof($datapum)); exit();

		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
	                 ->setLastModifiedBy('Quick')
	                 ->setTitle("Perhitungan UM")
	                 ->setSubject("CV. KHS")
	                 ->setDescription("Perhitungan Utilitas Mesin")
					 ->setKeywords("PUM");
		// style excel
		$style_title = array(
			'font' => array(
				'bold' => true,
				'size' => 15
			), 
			'alignment' => array(
				'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'			=> true
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style1 = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
			),
		);
		$style2 = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'		 => true
			),
			'borders' => array(
				'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style_ket = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
			),
		);
		$style_row = array(
			'alignment' => array(
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
			  'wrap'	 => true
			),
			'borders' => array(
			  'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			  'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			  'bottom'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			  'left'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		// title
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "FORM PERHITUNGAN NEED SHIFT MESIN PRODUKSI"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "CV. KARYA HIDUP SENTOSA PUSAT"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKSI : $seksidept"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "PERIODE : $periode"); 
		$excel->getActiveSheet()->mergeCells('A1:Q1'); 
		$excel->getActiveSheet()->mergeCells('A2:Q2'); 
		$excel->getActiveSheet()->mergeCells('A3:Q3'); 
		$excel->getActiveSheet()->mergeCells('A4:Q4'); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_title);
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_title);
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_title);
		
		// header
		$excel->setActiveSheetIndex(0)->setCellValue('A6', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B6', "COST CENTER");
		$excel->setActiveSheetIndex(0)->setCellValue('C6', "RESOURCE CODE");
		$excel->setActiveSheetIndex(0)->setCellValue('D6', "DESKRIPSI");
		$excel->setActiveSheetIndex(0)->setCellValue('E6', "JENIS MESIN");
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "NO. MESIN");
		$excel->setActiveSheetIndex(0)->setCellValue('G6', "TAG NUMBER");
		$excel->setActiveSheetIndex(0)->setCellValue('H6', "KOMPONEN YAG DI KERJAKAN");
		$excel->setActiveSheetIndex(0)->setCellValue('H7', "KODE KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('I7', "DESKRIPSI KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('J6', "OPR SEQ");
		$excel->setActiveSheetIndex(0)->setCellValue('K6', "PLAN PRODUKSI (PCS)");
		$excel->setActiveSheetIndex(0)->setCellValue('K7', "$bln1");
		$excel->setActiveSheetIndex(0)->setCellValue('L7', "$bln2");
		$excel->setActiveSheetIndex(0)->setCellValue('M7', "$bln3");
		$excel->setActiveSheetIndex(0)->setCellValue('N7', "RATA-RATA 1 BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('O6', "CYCLE TIME (HR)");
		$excel->setActiveSheetIndex(0)->setCellValue('P6', "TOTAL JAM DIBUTUHKAN");
		$excel->setActiveSheetIndex(0)->setCellValue('P7', "$bln1");
		$excel->setActiveSheetIndex(0)->setCellValue('Q7', "$bln2");
		$excel->setActiveSheetIndex(0)->setCellValue('R7', "$bln3");
		$excel->setActiveSheetIndex(0)->setCellValue('S7', "RATA-RATA 1 BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('T6', "TOTAL JAM DIBUTUHKAN PER BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('U6', "UTILITAS MESIN(%)");
		$excel->setActiveSheetIndex(0)->setCellValue('T1', "STANDAR JAM AKTIF");
		$excel->setActiveSheetIndex(0)->setCellValue('T2', "487,5 JAM");
		$excel->getActiveSheet()->mergeCells('A6:A7'); 
		$excel->getActiveSheet()->mergeCells('B6:B7'); 
		$excel->getActiveSheet()->mergeCells('C6:C7');
		$excel->getActiveSheet()->mergeCells('D6:D7'); 
		$excel->getActiveSheet()->mergeCells('E6:E7'); 
		$excel->getActiveSheet()->mergeCells('F6:F7');
		$excel->getActiveSheet()->mergeCells('G6:G7');
		$excel->getActiveSheet()->mergeCells('H6:I6');
		$excel->getActiveSheet()->mergeCells('J6:J7');
		$excel->getActiveSheet()->mergeCells('K6:N6');
		$excel->getActiveSheet()->mergeCells('O6:O7');
		$excel->getActiveSheet()->mergeCells('P6:S6');
		$excel->getActiveSheet()->mergeCells('T6:T7');
		$excel->getActiveSheet()->mergeCells('U6:U7');
		
		// style header
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('T2')->applyFromArray($style1);

		// data
		if (count($datapum) == 0){
			$excel->setActiveSheetIndex(0)->setCellValue('A8');
			$excel->setActiveSheetIndex(0)->setCellValue('B8');
			$excel->setActiveSheetIndex(0)->setCellValue('C8');
			$excel->setActiveSheetIndex(0)->setCellValue('E8');
			$excel->setActiveSheetIndex(0)->setCellValue('F8');
			$excel->setActiveSheetIndex(0)->setCellValue('G8');
			$excel->setActiveSheetIndex(0)->setCellValue('H8');
			$excel->setActiveSheetIndex(0)->setCellValue('I8');
			$excel->setActiveSheetIndex(0)->setCellValue('J8');
			$excel->setActiveSheetIndex(0)->setCellValue('K8');
			$excel->setActiveSheetIndex(0)->setCellValue('L8');
			$excel->setActiveSheetIndex(0)->setCellValue('M8');
			$excel->setActiveSheetIndex(0)->setCellValue('N8');
			$excel->setActiveSheetIndex(0)->setCellValue('O8');
			$excel->setActiveSheetIndex(0)->setCellValue('P8');
			$excel->setActiveSheetIndex(0)->setCellValue('Q8');
			$excel->setActiveSheetIndex(0)->setCellValue('R8');
			$excel->setActiveSheetIndex(0)->setCellValue('S8');
			$excel->setActiveSheetIndex(0)->setCellValue('T8');
			$excel->setActiveSheetIndex(0)->setCellValue('U8');

			$excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('R8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('S8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('T8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('U8')->applyFromArray($style_col);
		}else {
			$no=1;
			$numrow = 8;
			$sesuatu = $numrow;
				// foreach ($datapum as $d) {	
					for ($i=0; $i < sizeof($datapum); $i++) {
						$datapum[$i]['groupoii']=''; 
					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $datapum[$i]['cost_center']);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $datapum[$i]['resource_code']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $datapum[$i]['deskripsi']);
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $datapum[$i]['jenis_mesin']);
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $datapum[$i]['nomesin']);
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $datapum[$i]['tag_number']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $datapum[$i]['item_code']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $datapum[$i]['item_desc']);
					$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $datapum[$i]['opr_seq']);
					$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $datapum[$i]['bulan1']);
					$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $datapum[$i]['bulan2']);
					$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $datapum[$i]['bulan3']);
					$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $datapum[$i]['ratabulan']);
					$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $datapum[$i]['cycle_time']);
					$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $datapum[$i]['jam1']);
					$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $datapum[$i]['jam2']);
					$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $datapum[$i]['jam3']);
					$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $datapum[$i]['ratajam']);
					if ($datapum[$i]['jenis_mesin'] == 'LINE ') {
						$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $datapum[$i]['totaljam']);
						$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $datapum[$i]['utilitas']);
						$datapum[$i]['groupoii']='';
					}else if ($datapum[$i]['jenis_mesin'] == 'GROUP') {
						if ($datapum[$i]['tag_number'] != '') {
							$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $datapum[$i]['totaljam']);
							$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $datapum[$i]['utilitas']);
							$datapum[$i]['groupoii']='';
						}
					}else if ($datapum[$i]['tag_number'] != '' && $datapum[$i]['jenis_mesin'] == '' && $datapum[$i-1]['jenis_mesin'] == 'GROUP') {
							$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $datapum[$i]['totaljam']);
							$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $datapum[$i]['utilitas']);
							$datapum[$i]['groupoii']='GROUP';
					
					}else if ($datapum[$i]['tag_number'] != '' && $datapum[$i]['jenis_mesin'] == '' && $datapum[$i-1]['jenis_mesin'] == '' && $datapum[$i-1]['groupoii'] == 'GROUP') {
						$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $datapum[$i]['totaljam']);
						$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $datapum[$i]['utilitas']);
						$datapum[$i]['groupoii']='GROUP';
					}else {$datapum[$i]['groupoii']='';}

					
					if(!empty($datapum[$i]['item_code'])){
						$sesuatu = $numrow;
					}
					if(!empty($datapum[$i]['cost_center'])){
						$no++; 
					}
					
					// merge jika item_code cuma 1
					if(empty($datapum[$i]['item_code'])){
						// echo "<pre>"; print_r($sesuatu); echo "<br/>"; print_r($numrow); exit();
						$excel->getActiveSheet()->mergeCells("H$sesuatu:H$numrow"); 
						$excel->getActiveSheet()->mergeCells("I$sesuatu:I$numrow"); 
						$excel->getActiveSheet()->mergeCells("J$sesuatu:J$numrow"); 
						$excel->getActiveSheet()->mergeCells("K$sesuatu:K$numrow"); 
						$excel->getActiveSheet()->mergeCells("L$sesuatu:L$numrow"); 
						$excel->getActiveSheet()->mergeCells("M$sesuatu:M$numrow"); 
						$excel->getActiveSheet()->mergeCells("N$sesuatu:N$numrow"); 
						$excel->getActiveSheet()->mergeCells("O$sesuatu:O$numrow"); 
						$excel->getActiveSheet()->mergeCells("P$sesuatu:P$numrow"); 
						$excel->getActiveSheet()->mergeCells("Q$sesuatu:Q$numrow"); 
						$excel->getActiveSheet()->mergeCells("R$sesuatu:R$numrow"); 
						$excel->getActiveSheet()->mergeCells("S$sesuatu:S$numrow"); 
					}

					// merge cost - jenis mesin
					$tambah = $numrow + $datapum[$i]['merge'] - 1;
					if($datapum[$i]['cost_center'] != ''){
						$excel->getActiveSheet()->mergeCells("A$numrow:A$tambah"); 
						$excel->getActiveSheet()->mergeCells("B$numrow:B$tambah"); 
						$excel->getActiveSheet()->mergeCells("C$numrow:C$tambah"); 
						$excel->getActiveSheet()->mergeCells("D$numrow:D$tambah"); 
						$excel->getActiveSheet()->mergeCells("E$numrow:E$tambah"); 
					}

					// merge totaljam & utilitas LINE
					if($datapum[$i]['jenis_mesin'] == 'LINE '){
						$excel->getActiveSheet()->mergeCells("T$numrow:T$tambah"); 
						$excel->getActiveSheet()->mergeCells("U$numrow:U$tambah"); 
					}

					$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style2);
				$numrow++; 
					}
			}

			// keterangan & ttd dibawah data
			$rowrata 	= sizeof($datapum)+ 8;
			$rowave 	= sizeof($datapum)+ 7;
			$rowPUM 	= sizeof($datapum) + 10;
			$rowPUM2 	= $rowPUM + 1;
			$rowPUM3 	= $rowPUM2 + 1;
			$rowPUM4 	= $rowPUM3 + 1;
			$rowtanggal = $rowPUM4 + 8;
			$rowbuat 	= $rowtanggal + 2;
			$rowjbt 	= $rowbuat + 1;
			$rownama 	= $rowjbt + 4;
			$tanggal 	= date("d F Y");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM, "Data di atas adalah data dr PPIC yang sudah approval s/d Ka. Dept. Produksi");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM2, "% Utilitas Mesin = Total Jam Dibutuhkan per Bulan : Jam Standar Aktif dalam 1 bulan");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM3, "Jam Standar Aktif dalam 1 bulan = 25 hari x 3 shift x 6.5 jam = 487.5 jam");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM4, "Apabila perhitungan utilitas mesin lebih dari 100%, maka akan dianggap 100%");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowtanggal, "Yogyakarta, $tanggal");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowbuat, "Dibuat");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$rowbuat, "Diperiksa");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$rowbuat, "Mengetahui");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowjbt, "Kasie PPIC $seksi");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$rowjbt, "Koord PPIC");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$rowjbt, "Kadept Produksi");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rownama, "(                                        )");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$rownama, "(                                        )");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$rownama, "(                                        )");
			$excel->setActiveSheetIndex(0)->setCellValue('U'.$rowrata, "=ROUND(AVERAGE(U8:U$rowave), 2)");


			$excel->getActiveSheet()->getStyle('B'.$rowPUM)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$rowPUM2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$rowPUM3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$rowPUM4)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('D'.$rowtanggal)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('D'.$rowbuat)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('F'.$rowbuat)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('H'.$rowbuat)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('D'.$rowjbt)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('F'.$rowjbt)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('H'.$rowjbt)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('D'.$rownama)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('F'.$rownama)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('H'.$rownama)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('U'.$rowrata)->applyFromArray($style_ket);

			// Set width kolom
			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('O')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
			
			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			// Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Perhitungan Utilitas Mesin");
			$excel->setActiveSheetIndex(0);
			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="PerhitunganUM_'.$seksi.'.xlsx"'); 
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		
	}

	public function insertPUM(){
		$resource 	= $this->input->post('resource');
		$nomesin 	= $this->input->post('nomesin');
		$tagnum 	= $this->input->post('tagnum');
		$jenis 		= $this->input->post('jenis');
		$cost 		= $this->input->post('cost');
		$deptclass 	= $this->input->post('deptclass');
		$username 	= $this->input->post('username');
		$utilitas 	= $this->input->post('utilitas');
		$last_update 	= $this->input->post('last_update');
		$plan 		= $this->input->post('plan');
		$date 		= date('d/m/Y');
		// echo "<pre>";print_r($resource);exit();

		$delete = $this->M_hitung->deletePUM($deptclass[0], $plan);
		for ($i=0; $i < count($resource); $i++) { 
			$cek = $this->M_hitung->cekPUM($resource[$i], $tagnum[$i], $cost[$i], $deptclass[$i], $plan);
			if (empty($cek)) {
				$insert = $this->M_hitung->insertPUM($resource[$i], $nomesin[$i], $tagnum[$i], $jenis[$i], $cost[$i], $deptclass[$i], $username[$i], $utilitas[$i], $date, $plan);
			}else {
				
			}
		}
	}
	
}