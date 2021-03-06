<?php defined('BASEPATH') ;
class C_MoveOrderOPM extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		 $this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        $this->load->library('ciqrcode');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('Inventory/M_moveorderopm');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
	}

	public function checkSession()
		{
			if($this->session->is_logged){
				}else{
					redirect();
				}

		}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['dept'] = $this->M_moveorderopm->getDept();
		$data['shift'] = $this->M_moveorderopm->getShift(FALSE);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrderOPM/V_MoveOrderOPM',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getShift(){
		$date = $this->input->post('date');
		// $date = date('Y/m/d',strtotime($date));
		$date2 = explode('/', $date);
		$datenew = $date ? $date2[2].'/'.$date2[1].'/'.$date2[0] : '';
		$data = $this->M_moveorderopm->getShift($datenew);
		echo json_encode($data);
	}

	public function search(){
		$date = $this->input->post('date');
		// $date_akhir = strtoupper(DateTime::createFromFormat('d/m/Y', $this->input->post('date2'))->format('d-M-y'));
		$dept = $this->input->post('dept');
		$shift1 = $this->input->post('shift');
		$ket	= $this->input->post('ket');
		$ket	= $ket == 1 ? 'SUDAH PICKLIST' : 'BELUM PICKLIST';
		if ($dept == 'SUBKT') {
			$shift = '';
			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
		} elseif(!empty($shift1)) {
			$shift = "and kqel.SHIFT = ".$this->input->post('shift')."";
			// $shift = "and bcs.SHIFT_NUM = '".$this->input->post('shift')."'";
			// EDIT LUTFI
			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
		}else {
			$shift = '';
			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
		}
		$date2 = explode('/', $date);
		$datenew = $date ? $date2[1].'/'.$date2[0].'/'.$date2[2] : '';
		$date = strtoupper(date('d-M-y', strtotime($datenew)));

		$dataGET = $this->M_moveorderopm->search($date,$dept,$shift,$atr, $ket);
		
		// echo "<pre>";
		// // print_r($date);
		// // echo "<br>";
		// // print_r($dept);
		// // echo "<br>";
		// // print_r($shift);		
		// // echo "<br>";
		// print_r($dataGET);		
		// exit();
		
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			$value['WIP_ENTITY_NAME'] = $value['NO_JOB'];
			$value['DEPT_CLASS'] = $value['DEPARTMENT_CLASS_CODE'];
			$value['ITEM_CODE'] = $value['ASSEMBLY'];
			$value['ITEM_DESC'] = $value['ASSY_DESC'];
			$value['DESCRIPTION'] = $value['SHIFT_DESC'];
			if (in_array($value['WIP_ENTITY_NAME'], $array_sudah)) {
				// echo "sudah ada";print_r($value['WIP_ENTITY_NAME']);echo"<br>";
			}else{
				// echo "memasukan ";print_r($value['WIP_ENTITY_NAME']);echo "<br>";
				array_push($array_sudah, $value['WIP_ENTITY_NAME']);
				if ($dept == 'SUBKT') {
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
					$getBody = $this->M_moveorderopm->getBody($value['WIP_ENTITY_NAME'],$atr,$dept);
				}else {
					// EDIT LUTFI
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
					$getBody = $this->M_moveorderopm->getBody($value['WIP_ENTITY_NAME'],$atr,$dept);
				}
				$sorting_1 = $sorting_2 = array();
				for ($i=0; $i < count($getBody); $i++) { 
					$bagi = $getBody[$i]['ATR'] / ($getBody[$i]['QUANTITY_PER_ASSEMBLY'] == 0 ? 1 : $getBody[$i]['QUANTITY_PER_ASSEMBLY']);
					$getBody[$i]['BAGI'] = $bagi;
					$sorting_1[$i] = $getBody[$i]['LOCATOR_ASAL'];
					$sorting_2[$i] = $getBody[$i]['BAGI'];
				}

				array_multisort($sorting_1, SORT_ASC, $sorting_2, SORT_ASC, $getBody);
				
				// usort($getBody, function($a, $b) {
				// 	return $a['BAGI'] - $b['BAGI'];
				// });

				$array_terkelompok[$value['WIP_ENTITY_NAME']]['header'] = $value; 
				$array_terkelompok[$value['WIP_ENTITY_NAME']]['body'] = $getBody; 
			}

		}

		// echo "<pre>";
		// // print_r($array_sudah);
		// print_r($array_terkelompok);
		// exit();

		foreach ($array_terkelompok as $key => $value) {
			// echo "<pre>";
			// print_r($value);
			// exit();
		 	$checkPicklist = $this->M_moveorderopm->checkPicklist($key);
		 	if ($checkPicklist) {
				$array_terkelompok[$key]['header']['KET'] = 1 ;
		 	}else{
				$array_terkelompok[$key]['header']['KET'] = 0 ;
		 	}
		 }


		$data['requirement'] = $array_terkelompok;
		$data['date'] = $date;
		$data['dept'] = $dept;
		$data['shift'] = $shift1;
		// echo "<pre>";
		// print_r($data['requirement']);
		// exit();

		$this->load->view('Inventory/MainMenu/MoveOrderOPM/V_ResultOPM',$data);
	}

	public function search2(){
		$nojob 	= $this->input->post('nojob');
		$no_job = '';
		for ($n=0; $n < count($nojob) ; $n++) { 
			if (!empty($nojob[$n])) {
				$no_job = empty($no_job) ? "'".$nojob[$n]."'" : $no_job.", '".$nojob[$n]."'";
			}
		}
		// echo "<pre>";
		// print_r($no_job);
		// exit();

		$dataGET = $this->M_moveorderopm->search2($no_job);
		
		// echo "<pre>";
		// // print_r($date);
		// // echo "<br>";
		// // print_r($dept);
		// // echo "<br>";
		// // print_r($shift);		
		// // echo "<br>";
		// print_r($dataGET);		
		// exit();
		
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			$value['WIP_ENTITY_NAME'] = $value['NO_JOB'];
			$value['DEPT_CLASS'] = $value['DEPARTMENT_CLASS_CODE'];
			$value['ITEM_CODE'] = $value['ASSEMBLY'];
			$value['ITEM_DESC'] = $value['ASSY_DESC'];
			$value['DESCRIPTION'] = $value['SHIFT_DESC'];
			if (in_array($value['WIP_ENTITY_NAME'], $array_sudah)) {
				// echo "sudah ada";print_r($value['WIP_ENTITY_NAME']);echo"<br>";
			}else{
				// echo "memasukan ";print_r($value['WIP_ENTITY_NAME']);echo "<br>";
				array_push($array_sudah, $value['WIP_ENTITY_NAME']);
				if ($value['DEPARTMENT_CLASS_CODE'] == 'SUBKT') {
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
					$getBody = $this->M_moveorderopm->getBody($value['WIP_ENTITY_NAME'],$atr,$value['DEPARTMENT_CLASS_CODE']);
				}else {
					// EDIT LUTFI
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
					$getBody = $this->M_moveorderopm->getBody($value['WIP_ENTITY_NAME'],$atr,$value['DEPARTMENT_CLASS_CODE']);
				}
				$sorting_1 = $sorting_2 = array();
				for ($i=0; $i < count($getBody); $i++) { 
					$bagi = $getBody[$i]['ATR'] / $getBody[$i]['QUANTITY_PER_ASSEMBLY'];
					$getBody[$i]['BAGI'] = $bagi;
					$sorting_1[$i] = $getBody[$i]['LOCATOR_ASAL'];
					$sorting_2[$i] = $getBody[$i]['BAGI'];
				}

				array_multisort($sorting_1, SORT_ASC, $sorting_2, SORT_ASC, $getBody);
				
				// usort($getBody, function($a, $b) {
				// 	return $a['BAGI'] - $b['BAGI'];
				// });

				$array_terkelompok[$value['WIP_ENTITY_NAME']]['header'] = $value; 
				$array_terkelompok[$value['WIP_ENTITY_NAME']]['body'] = $getBody; 
			}

		}

		// echo "<pre>";
		// // print_r($array_sudah);
		// print_r($array_terkelompok);
		// exit();

		foreach ($array_terkelompok as $key => $value) {
			// echo "<pre>";
			// print_r($value);
			// exit();
		 	$checkPicklist = $this->M_moveorderopm->checkPicklist($key);
		 	if ($checkPicklist) {
				$array_terkelompok[$key]['header']['KET'] = 1 ;
		 	}else{
				$array_terkelompok[$key]['header']['KET'] = 0 ;
		 	}
		 }


		$data['requirement'] = $array_terkelompok;
		$data['date'] = '';
		$data['dept'] = '';
		$data['shift'] = '';
		// echo "<pre>";
		// print_r($data['requirement']);
		// exit();

		$this->load->view('Inventory/MainMenu/MoveOrderOPM/V_ResultOPM',$data);
    }

    
	public function create(){
		// echo "<pre>";
		// print_r($_POST);
		// exit();
		$user_id = $this->session->user;
		
		$ip_address =  $this->input->ip_address();
		$job = $this->input->post('no_job');
		$err = $this->input->post('error_exist');
		$piklis = $this->input->post('piklis');
		
		$departement = $this->input->post('departement');
		if ($departement == 'SUBKT') {
			$nama_satu = $this->input->post('namaSatu');
			$nama_dua = $this->input->post('namaDua');
		} else {
			$nama_satu = '';
			$nama_dua = '';
		}

		$checkPicklist = $this->M_moveorderopm->checkPicklist($job);
		$array_mo = array();

		if (count($checkPicklist) > 0) {
			foreach ($checkPicklist as $key => $value) {
				$value['URUTAN_PICKLIST'] = 99;
				$no_mo = $value;
				array_push($array_mo, $no_mo);
				//tinggal cetak jika sudah ada mo
			}
		// 	//pdfoutput
			$this->pdf($array_mo, $nama_satu, $nama_dua,$piklis);
		} else {
			$qty 	  = $this->input->post('qty');
			$invID = $this->input->post('invID');
			$uom 		  = $this->input->post('uom');
			$job_id 	  = $this->input->post('job_id');
			$subinv_to 	  = $this->input->post('subinvto');
			$locator_to 	  = $this->input->post('locatorto');
			$subinv_from 	  = $this->input->post('subinvfrom');
			$locator_from 	  = $this->input->post('locatorfrom');
			$locator_fromid 	  = $this->input->post('locatorfromid');

			//CHECK QTY VS ATR
			if ($departement == 'SUBKT') {
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,wro.ATTRIBUTE1,wro.ATTRIBUTE2,'') atr";	
					$getQuantityActual = $this->M_moveorderopm->getQuantityActual($job,$atr);	
			}else {
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,wro.ATTRIBUTE1,wro.ATTRIBUTE2,'') atr";	
					$getQuantityActual = $this->M_moveorderopm->getQuantityActual($job,$atr);	
			}
			// echo "<pre>";
			// echo("MASUK SINI");
			// print_r($getQuantityActual);
			// exit();
			$errQty = array();

			foreach ($getQuantityActual as $kQty => $vQty) {
				if ($vQty['REQ'] > $vQty['ATR']){
					$err = 1;
				}else{
					$err = 0;
				}
				$errQty[] = $err;
			}
			// echo "<pre>";
			// print_r($errQty);
			// print_r($invID);
			// exit();

			//Seharusnya (!in_array(1,$errQty))
			if (!in_array(1, $errQty)) {
					foreach ($invID as $key => $value) {
						$data[$subinv_from[$key]][$locator_from[$key]][] = array('NO_URUT' => '',
										'INVENTORY_ITEM_ID' => $value,
										'QUANTITY' => $qty[$key],
										'UOM' => $uom[$key],
										'IP_ADDRESS' => $ip_address,
										'JOB_ID' => $job_id[$key]);
						$data2[$subinv_from[$key]][$locator_from[$key]][] = $locator_fromid[$key];
						$data3[$subinv_from[$key]][$locator_from[$key]][] = $locator_from[$key];
					}
					// echo "<pre>";
					// print_r($data);
					// exit();
					// echo "<pre>";
					$x = 1; $nok = 0;
					foreach ($data as $key => $value) {
						$i = 1;
						// echo "PROSES SUB INV $key { ";
						foreach ($value as $k => $val) {
							$nomor_mo = $job.'-'.$x;
							$locfrom = $data2[$key][$k][0];
							if ($key == 'SM-TKS') { // insert kib kanban
								if ($nok == 0) {
									$this->M_moveorderopm->createKIB($departement, $nomor_mo, $job, $this->session->user);
								}
								$nok++;
							}else {
								foreach ($val as $key2 => $value2) {
									$dataNew = $value2;
									$dataNew['NO_URUT'] = $i;
									//create TEMP
									// echo "insert<br>";
									// print_r($dataNew);echo "<br>";
									$this->M_moveorderopm->createTemp($dataNew);
									$i++;
		
								}
									// //create MO       
									// print_r($ip_address);echo "<br>";print_r($job_id);echo "<br>";print_r($subinv_to[0]);echo "<br>";
									// print_r($locator_to[0]);echo "<br>";print_r($key);echo "<br>";print_r($data2[key]);echo "<br>";print_r($user_id);
									// echo "<br>";
									$this->M_moveorderopm->createMO($ip_address,$job_id[0],$subinv_to[0],$locator_to[0],$key,$locfrom,$user_id,$nomor_mo);
		
									//delete
									// echo "<br>";echo "menjalankan perintah delete";echo "<br>";
									$this->M_moveorderopm->deleteTemp($ip_address,$job_id[0]);
							}
						$x++;
						}
					}

					$checkPicklist = $this->M_moveorderopm->checkPicklist($job);
					foreach ($checkPicklist as $key => $value) {
						$value['URUTAN_PICKLIST'] = 99;
						$no_mo = $value;
						array_push($array_mo, $no_mo);
					}
			}
			// exit();
			// echo "<pre>";
			// print_r($array_mo);
			// exit();

			if ($array_mo) {
				$this->pdf($array_mo, $nama_satu, $nama_dua,$piklis);
			}else{
				exit('Terjadi Kesalahan :(');
			}

		
		}
	}

	public function pdf($array_mo2,$nama_satu, $nama_dua, $piklis){
		// ------ GET DATA ------
		foreach ($array_mo2 as $key => $row) {
			// $return_urut[$key]  = $row['URUTAN_PICKLIST'];
			$return_fare[$key]  = $row['FROM_SUBINVENTORY_CODE'];
			$one_way_fare[$key] = $row['LOCATOR'];
		}
		// Sort the data with volume descending, edition ascending
		array_multisort($return_fare, SORT_ASC, $one_way_fare, SORT_ASC, $array_mo2);
		// echo "<pre>";print_r($array_mo2);exit();
		$array_mo = array();
		foreach ($array_mo2 as $key => $val) {
			$no_mo = $val['REQUEST_NUMBER'];
			array_push($array_mo, $no_mo);
		}
		// echo "<pre>";
		// print_r($array_mo);
		// exit();

			$temp_filename = array();
			foreach ($array_mo as $key => $mo) {

				$moveOrderAwal = $moveOrderAkhir = $mo;
				$mentahHead	= $this->M_moveorderopm->getHeader($moveOrderAwal, $moveOrderAkhir);
				$mentahLine	= $this->M_moveorderopm->getDetail($moveOrderAwal, $moveOrderAkhir);

				// echo "<pre>";
				// print_r($mentahLine);
				// exit();
				


		// ------ GENERATE QRCODE ------
				if(!is_dir('./assets/img'))
				{
					mkdir('./assets/img', 0777, true);
					chmod('./assets/img', 0777);
				}

				foreach ($mentahHead as $mh) {
					if ($mh['DEPARTMENT'] == 'SUBKT') {

						$headerTemp = $this->M_moveorderopm->getNomorHeader($mh['JOB_NO']);
						// echo "<pre>";
						// print_r($headerTemp);
						// exit();
						$params['data']		= $mh['MOVE_ORDER_NO'];
						$params['level']	= 'H';
						$params['size']		= 3;
						$config['black']	= array(224,255,255);
						$config['white']	= array(70,130,180);
						$params['savename'] = './assets/img/'.$mh['MOVE_ORDER_NO'].'.png';
						$this->ciqrcode->generate($params);
						array_push($temp_filename, $params['savename']);
					} else {
						$params['data']		= $mh['MOVE_ORDER_NO'];
						$params['level']	= 'H';
						$params['size']		= 3;
						$config['black']	= array(224,255,255);
						$config['white']	= array(70,130,180);
						$params['savename'] = './assets/img/'.$mh['MOVE_ORDER_NO'].'.png';
						$this->ciqrcode->generate($params);
						array_push($temp_filename, $params['savename']);
					}
				}
			}
			// exit();

			//-------------------------------------------------------------------------------generate pdf by departement

		$kodeDepartement = $this->M_moveorderopm->checkDepartement($array_mo[0]);


		// ------ GENERATE PDF ------
			$this->load->library('Pdf');
			$pdf 				= $this->pdf->load();
			if (in_array('SUBKT', $kodeDepartement[0])) {
				// $pdf 				= new mPDF('utf-8',array(215,140), 0, '', 2, 2, 2,0);
				$pdf 				= new mPDF('utf-8',array(215, 140), 0, '', 2, 2, 50, 35, 2, 4); //2, 2, 51, 35, 2, 4
			} else {
				$pdf 				= new mPDF('utf-8',array(215, 140), 0, '', 2, 2, 52, 25, 2, 4);	
			}
			
			// $pdf 				= new mPDF('utf-8','A5-L', 0, '', 2, 2, 18.5, 21, 2, 2);
			$filename			= 'Picklist_'.time().'.pdf';
			$a = 0;
			foreach ($array_mo as $key => $mo) {
				$moveOrderAwal = $moveOrderAkhir = $mo;
				$dataall[$a]['head']	= $this->M_moveorderopm->getHeader($moveOrderAwal, $moveOrderAkhir);
				$dataall[$a]['head'][0]['piklis'] = $piklis;
				$dataall[$a]['line']	= $this->M_moveorderopm->getDetail($moveOrderAwal, $moveOrderAkhir);
				$sub_assy = $dataall[$a]['head'][0]['PRODUK'];
				$dataall[$a]['head'][0]['urutan'] = $array_mo2[$key]['URUTAN_PICKLIST'];
				if ($sub_assy == 'AGF0000AA1AZ-0' || $sub_assy == 'AGF0000AA2AZ-0') {
					usort($dataall[$a]['line'], function($y, $z) {
						return strcasecmp($y['KODE_DESC'], $z['KODE_DESC']);
					});
				}
				$subinv = $dataall[$a]['head'][0]['LOKASI'];
				$lokator = $dataall[$a]['line'][0]['LOKATOR'];
				$dataall[$a]['beda']	= $this->M_moveorderopm->getPerbedaan($moveOrderAwal, $subinv, $lokator);
				$a++;
			}

			// echo "<pre>";
			// print_r($dataall);
			// exit();

			$head		= array();
			$jobNo		= array();
			$gudang		= array();
			$line		= array();
			$pdf->SetTitle('Picklist_'.date('d/m/Y H/i/s').'.pdf');
			foreach ($dataall as $key => $value) {
				// echo "<pre>";print_r($value);exit();
				$pdf->AliasNbPageGroups('[pagetotal]');
					foreach ($value['head'] as $key2 => $value2) {
						$judulAssembly = strlen($value2['PRODUK_DESC']);
					}
					$assemblyLength = ceil($judulAssembly/30);
				$data['assemblyLength'] = $assemblyLength;
				$data['dataall'] = $value;
				$data['urut'] = $key;
				// echo "<pre>";

				if ($value['head'][0]['DEPARTMENT'] == 'SUBKT') {

					//$data['dataall']['head'][0]['ALAMAT'] = 'Belum terdefinisi'; 
					$data['dataall']['head'][0]['NAMA_SATU'] = $nama_satu;
					$data['dataall']['head'][0]['NAMA_DUA'] = $nama_dua;
					$data['dataall']['head'][0]['ALAMAT'] = $this->M_moveorderopm->getAlamat($value['head'][0]['JOB_NO']); //--->> ALAMAT CALLING
					$data['dataall']['head'][0]['HEADER_NO'] = $this->M_moveorderopm->getNomorHeader($value['head'][0]['JOB_NO']);
					// echo "<pre>";
		
					// $head = $this->load->view('Inventory/MainMenu/MoveOrder/V_Head2', $data, TRUE);
					$head = $this->load->view('Inventory/MainMenu/MoveOrder/V_Head2', $data, TRUE);
					$line = $this->load->view('Inventory/MainMenu/MoveOrder/V_Index2', $data, TRUE);
					$foot = $this->load->view('Inventory/MainMenu/MoveOrder/V_Foot2', $data, TRUE);
					$pdf->SetHTMLHeader($head);
					$pdf->SetHTMLFooter($foot);
					$pdf->WriteHTML($line,0);
					// break;
				} else if ($value['head'][0]['piklis'] == '2') {
					
					$head = $this->load->view('Inventory/MainMenu/MoveOrder/V_Head3', $data, TRUE);
					$line = $this->load->view('Inventory/MainMenu/MoveOrder/V_Index3', $data, TRUE);
					$foot = $this->load->view('Inventory/MainMenu/MoveOrder/V_Foot', $data, TRUE);
					$pdf->SetHTMLHeader($head);
					$pdf->SetHTMLFooter($foot);
					$pdf->WriteHTML($line,0);
					// break;
				} else {
					$head = $this->load->view('Inventory/MainMenu/MoveOrder/V_Head', $data, TRUE);
					$line = $this->load->view('Inventory/MainMenu/MoveOrder/V_Index', $data, TRUE);
					$foot = $this->load->view('Inventory/MainMenu/MoveOrder/V_Foot', $data, TRUE);
					$pdf->SetHTMLHeader($head);
					$pdf->SetHTMLFooter($foot);
					$pdf->WriteHTML($line,0);
				}
				//$pdf->WriteHTML($line,0);
			}

			// echo "<pre>";
			// print_r($data);
			// exit();
			
			$pdf->Output($filename, 'I');

			if (!empty($temp_filename)) {
				foreach ($temp_filename as $tf) {
					if(is_file($tf)){
						unlink($tf);
					}
				}
			}
	}

	public function print_sticker(){
		$job = $this->input->post('nojob');
		$cek_item = $this->M_moveorderopm->count_itemMGA($job);
		echo $cek_item[0]['STIKER'];
	}

	public function createall(){
		// echo "<pre>";
		// print_r ($_POST);
		// exit();
		$user_id = $this->session->user;

		$nama_satu = '';
		$nama_dua = '';
		$ip_address =  $this->input->ip_address();
		$departement = $this->input->post('departement');
		$no_job 	= $this->input->post('no_job');
		$qty 	  = $this->input->post('qty');
		$invID 		  = $this->input->post('invID');
		$uom 		  = $this->input->post('uom');
		$job_id 	  = $this->input->post('job_id');
		$subinv_to 	  = $this->input->post('subinvto');
		$locator_to 	  = $this->input->post('locatorto');
		$subinv_from 	  = $this->input->post('subinvfrom');
		$locator_from 	  = $this->input->post('locatorfromid');
		$selected = $this->input->post('selectedPicklistIMO');
		$urutan = $this->input->post('urutanPicklistIMO');
		$piklis = $this->input->post('piklis');
		$arraySelected = explode('+', $selected);
		$arrayUrutan = explode('+', $urutan);
		$array_mo = array();

		foreach ($no_job as $key => $value) {

			if (strpos($value, '<>') !== false ) {
				$no_job2		= explode('<>', $no_job[$key]);
				$qty2			= explode('<>', $qty[$key]);
				$invID2			= explode('<>', $invID[$key]);
				$uom2			= explode('<>', $uom[$key]);
				$job_id2		= explode('<>', $job_id[$key]);
				$subinv_to2		= explode('<>', $subinv_to[$key]);
				$locator_to2	= explode('<>', $locator_to[$key]);
				$subinv_from2	= explode('<>', $subinv_from[$key]);
				$locator_from2	= explode('<>', $locator_from[$key]);
				$departement2	= explode('<>', $departement[$key]);
				$i =1;
				
				if (in_array($no_job2[0], $arraySelected)){
					$nourut = 99;
					if (!empty($urutan)) {
						foreach ($arrayUrutan as $urut) {
							if (strpos($urut, $no_job2[0]) !== false ) {
								$no_urutan = explode("_",$urut);
								$nourut = empty($no_urutan[0]) ? 99 : $no_urutan[0];
							}
						}
					}
					// echo "sebelum check picklist <br>";
					$checkPicklist = $this->M_moveorderopm->checkPicklist($no_job2[0]);
					// echo "checkPicklist";print_r($checkPicklist);echo"<br>";print_r($no_job2);echo "<br>";
					if (count($checkPicklist) > 0) {
						foreach ($checkPicklist as $keymo => $valuemo) {
							$valuemo['URUTAN_PICKLIST'] = $nourut;
							$no_mo = $valuemo;
							array_push($array_mo, $no_mo);
							// ECHO "tinggal cetak jika sudah ada mo";
						}
					} else {
						$data = array();
						//CHECK QTY VS ATR
						$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,wro.ATTRIBUTE1,wro.ATTRIBUTE2,'') atr";
						$getQuantityActual = $this->M_moveorderopm->getQuantityActual($no_job2[0],$atr);
						$errQty = array();
						foreach ($getQuantityActual as $kQty => $vQty) {
							if ($vQty['REQ'] > $vQty['ATR']){
								$err = 1;
							}else{
								$err = 0;
							}
							$errQty[] = $err;
						}

						if (!in_array(1, $errQty)) {
							// START
							$inv = array();
								foreach ($no_job2 as $k => $v) {
									if (in_array($invID2[$k], $inv)) {
										
									}else {
										array_push($inv, $invID2[$k]);
										$data[$v][$subinv_from2[$k]][$locator_from2[$k]][] = array('NO_URUT' => '',
													'INVENTORY_ITEM_ID' => $invID2[$k],
													'QUANTITY' => $qty2[$k],
													'UOM' => $uom2[$k],
													'IP_ADDRESS' => $ip_address,
													'JOB_ID' => $job_id2[$k]);
										$data2[$v][$subinv_from2[$k]][$locator_from2[$k]] = $locator_from2[$k];
									}

								}
								// echo "<pre>";
								// print_r($data);
								// exit();
								$x = 1; $nok = 0;
								foreach ($data[$no_job2[0]] as $kSub => $vSub) {
									$i = 1; 
									foreach ($vSub as $k => $val) {
										$nomor_mo = $no_job2[0].'-'.$x;
										if ($kSub == 'SM-TKS') {
												if ($nok == 0) {
													//insert kib      
													$this->M_moveorderopm->createKIB($departement2[0],$nomor_mo, $no_job2[0], $this->session->user);
												}
												$nok++;
											}else {
											foreach ($val as $key2 => $value2) {
												$dataNew = $value2;
												$dataNew['NO_URUT'] = $i;
												//create TEMP
												// echo "insert<br>";
												// print_r($dataNew);
												$this->M_moveorderopm->createTemp($dataNew);
												$i++;
											}
												//create MO       
												$this->M_moveorderopm->createMO($ip_address,$job_id2[0],$subinv_to2[0],$locator_to2[0],$kSub,$k,$user_id,$nomor_mo);
		
												//delete
												// echo "delete<br>";
												$this->M_moveorderopm->deleteTemp($ip_address,$job_id2[0]);
										}
										$x++;

								}
							}
							// END
								$checkPicklist = $this->M_moveorderopm->checkPicklist($no_job2[0]);
								// print_r($checkPicklist);
								foreach ($checkPicklist as $keymo => $valuemo) {
									$valuemo['URUTAN_PICKLIST'] = $nourut;
									$no_mo = $valuemo;
									array_push($array_mo, $no_mo);
								}
							}
						}
					} 
			}else{
				$nourut = 99;
				if (!empty($urutan)) {
					$nourut = 99;
					foreach ($arrayUrutan as $urut) {
						if (strpos($urut, $no_job2[0]) !== false ) {
							$no_urutan = explode("_",$urut);
							$nourut = empty($no_urutan[0]) ? 99 : $no_urutan[0];
						}
					}
				}
				// echo "masuk sini bruh";
				if (in_array($value, $arraySelected)){
					$checkPicklist = $this->M_moveorderopm->checkPicklist($value);
					if (count($checkPicklist) > 0) {
						foreach ($checkPicklist as $keymo => $valuemo) {
							$valuemo['URUTAN_PICKLIST'] = $nourut;
							$no_mo = $valuemo;
							array_push($array_mo, $no_mo);
						}
					} else {
						//CHECK QTY VS ATR
						$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,wro.ATTRIBUTE1,wro.ATTRIBUTE2,'') atr";
						$getQuantityActual = $this->M_moveorderopm->getQuantityActual($value,$atr);
						$errQty = array();
						foreach ($getQuantityActual as $kQty => $vQty) {
							if ($vQty['REQ'] > $vQty['ATR']){
								$err = 1;
							}else{
								$err = 0;
							}
							$errQty[] = $err;
						}
						// echo "masuk kesini<br>";
						$x=1;
						$nomor_mo = $$no_job.'-'.$x;
						if (!in_array(1, $errQty)) {
							$data = array('NO_URUT' => 1,
									'INVENTORY_ITEM_ID' => $invID[$key],
									'QUANTITY' => $qty[$key],
									'UOM' => $uom[$key],
									'IP_ADDRESS' => $ip_address,
									'JOB_ID' => $job_id[$key]);
							$data2[$subinv_from2[$k]] = $locator_from2[$k];
							//create TEMP

							// echo "insert1<br>";
							$this->M_moveorderopm->createTemp($data);


							//create MO
							$this->M_moveorderopm->createMO($ip_address,$job_id[$key],$subinv_to[$key],$locator_to[$key],$subinv_from[$key],$locator_from[$key],$user_id,$nomor_mo);

							//delete TEMP
							// echo "delete1<br>";
							$this->M_moveorderopm->deleteTemp($ip_address,$job_id[$key]);


							$checkPicklist = $this->M_moveorderopm->checkPicklist($value);

							foreach ($checkPicklist as $keymo => $valuemo) {
								$valuemo['URUTAN_PICKLIST'] = $nourut;
								$no_mo = $valuemo;
								array_push($array_mo, $no_mo);
							}
						}
					}
				}
			}
		}
		// exit();

		// echo "<br>";
		// print_r($array_mo);
		// exit();
		if ($array_mo) {
			$this->pdf($array_mo,$nama_satu,$nama_dua,$piklis);
		}else{
			exit('Terjadi Kesalahan :(');
		}
	}

	public function pdfPending(){
		$data['date'] = $this->input->post('date');
		$dept 	= $this->input->post('dept');
		$shift 	= $this->input->post('shift');
		$no_job = $this->input->post('no_job');
		$assy 	= $this->input->post('assy');

		$shift 	= $this->M_moveorderopm->getShift2($shift);
		$desc 	= $this->M_moveorderopm->getDescDept($dept);
		$data['shift'] 	= $shift[0]['DESCRIPTION'];
		$data['dept'] 	= $dept.' - '.$desc[0]['DESCRIPTION'];
		// echo "<pre>";print_r($desc);exit();

		$tampung = array();
		for ($i=0; $i < count($no_job) ; $i++) { 
			$no_job2	= explode('<>', $no_job[$i]);
			$assy2		= explode('<>', $assy[$i]);

			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,wro.ATTRIBUTE1,wro.ATTRIBUTE2,'') atr";
			$cari = $this->M_moveorderopm->getKurang($no_job2[0],$atr);
			foreach ($cari as $kQty => $vQty) {
				if ($vQty['REQ'] > $vQty['ATR']){
					$cek = $this->M_moveorderopm->checkPicklist($no_job2[0]);
					if (empty($cek)) {
						$array = array(
							'no_job' => $no_job2[0],
							'kode_assy' => $assy2[0],
							'item' => $vQty['ITEM_CODE'],
							'desc' => $vQty['ITEM_DESC'],
							'subinv' => $vQty['GUDANG_ASAL'],
							'req' => $vQty['REQ'],
							'stok' => $vQty['ATR'],
						);
					array_push($tampung, $array);
					}
				}
			}
		}
		// echo "<pre>";print_r($tampung);exit();
		$data['data'] = $tampung;

		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','a4', 0, '', 1, 1, 3, 1);
		$filename 	= 'report-pendingan-job.pdf';

		$html 	= $this->load->view('Inventory/MainMenu/MoveOrder/V_PdfKurang', $data, true);	

		ob_end_clean();
		$pdf->WriteHTML($html);											
		// $pdf->debug = true; 
		$pdf->Output($filename, 'I');

	}
	
}
