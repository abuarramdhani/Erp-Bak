 <?php defined('BASEPATH') ;
class C_MoveOrder extends CI_Controller
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
			$this->load->model('Inventory/M_moveorder','M_MoveOrder');
			  
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
		$data['dept'] = $this->M_MoveOrder->getDept();
		$data['shift'] = $this->M_MoveOrder->getShift(FALSE);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrder/V_MoveOrder',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getShift(){
		$date = $this->input->post('date');
		// $date = date('Y/m/d',strtotime($date));
		$date2 = explode('/', $date);
		$datenew = $date ? $date2[2].'/'.$date2[1].'/'.$date2[0] : '';
		$data = $this->M_MoveOrder->getShift($datenew);
		echo json_encode($data);
	}

	public function search(){
		$date = $this->input->post('date');
		$dept = $this->input->post('dept');
		if ($dept == 'SUBKT') {
			$shift = '';
			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
		} else {
			$shift = "and bcs.SHIFT_NUM = '".$this->input->post('shift')."'";
			$atr = ",khs_inv_qty_atr(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
		}
		$date2 = explode('/', $date);
		$datenew = $date ? $date2[1].'/'.$date2[0].'/'.$date2[2] : '';
		$date = strtoupper(date('d-M-y', strtotime($datenew)));

		$dataGET = $this->M_MoveOrder->search($date,$dept,$shift,$atr);
		
		// echo "<pre>";
		// print_r($date);
		// echo "<br>";
		// print_r($dept);
		// echo "<br>";
		// print_r($shift);		
		// echo "<br>";
		// print_r($dataGET);		
		// exit();
		
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			if (in_array($value['WIP_ENTITY_NAME'], $array_sudah)) {
				
			}else{
				array_push($array_sudah, $value['WIP_ENTITY_NAME']);
				if ($dept == 'SUBKT') {
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
					$getBody = $this->M_MoveOrder->getBody($value['WIP_ENTITY_NAME'],$atr);
				}else {
					$atr = ",khs_inv_qty_atr(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
					$getBody = $this->M_MoveOrder->getBody($value['WIP_ENTITY_NAME'],$atr);	
				}
				$array_terkelompok[$value['WIP_ENTITY_NAME']]['header'] = $value; 
				$array_terkelompok[$value['WIP_ENTITY_NAME']]['body'] = $getBody; 
			}

		}

		// echo "<pre>";
		// print_r($array_sudah);
		// print_r($array_terkelompok);
		// exit();

		foreach ($array_terkelompok as $key => $value) {
			// echo "<pre>";
			// print_r($value);
			// exit();
		 	$checkPicklist = $this->M_MoveOrder->checkPicklist($key);
		 	if ($checkPicklist) {
				$array_terkelompok[$key]['header']['KET'] = 1 ;
		 	}else{
				$array_terkelompok[$key]['header']['KET'] = 0 ;
		 	}
		 }


		$data['requirement'] = $array_terkelompok;

		// echo "<pre>";
		// print_r($data['requirement']);
		// exit();

		$this->load->view('Inventory/MainMenu/MoveOrder/V_Result',$data);
	}

	public function create(){
		// echo "<pre>";
		// print_r($_POST);
		// exit();
		
		$ip_address =  $this->input->ip_address();
		$job = $this->input->post('no_job');
		$err = $this->input->post('error_exist');
		
		$departement = $this->input->post('departement');
		if ($departement == 'SUBKT') {
			$nama_satu = $this->input->post('namaSatu');
			$nama_dua = $this->input->post('namaDua');
		} else {
			$nama_satu = '';
			$nama_dua = '';
		}

		$checkPicklist = $this->M_MoveOrder->checkPicklist($job);
		$array_mo = array();
		// echo "<pre>";
		// print_r($checkPicklist);
		// exit();
		if (count($checkPicklist) > 0) {
			foreach ($checkPicklist as $key => $value) {
				$no_mo = $value['REQUEST_NUMBER'];
				array_push($array_mo, $no_mo);
				//tinggal cetak jika sudah ada mo
			}
		// 	//pdfoutput
			$this->pdf($array_mo, $nama_satu, $nama_dua);
		} else {
			$qty 	  = $this->input->post('qty');
			$invID = $this->input->post('invID');
			$uom 		  = $this->input->post('uom');
			$job_id 	  = $this->input->post('job_id');
			$subinv_to 	  = $this->input->post('subinvto');
			$locator_to 	  = $this->input->post('locatorto');
			$subinv_from 	  = $this->input->post('subinvfrom');
			$locator_from 	  = $this->input->post('locatorfrom');

			//CHECK QTY VS ATR
			if ($departement == 'SUBKT') {
					$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
					$getQuantityActual = $this->M_MoveOrder->getQuantityActual($job,$atr);	
			}else {
					$atr = ",khs_inv_qty_atr(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
					$getQuantityActual = $this->M_MoveOrder->getQuantityActual($job,$atr);	
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
						$data[$subinv_from[$key]][] = array('NO_URUT' => '',
										'INVENTORY_ITEM_ID' => $value,
										'QUANTITY' => $qty[$key],
										'UOM' => $uom[$key],
										'IP_ADDRESS' => $ip_address,
										'JOB_ID' => $job_id[$key]);
						$data2[$subinv_from[$key]] = $locator_from[$key];

					}
					// echo "<pre>";
					// print_r($data);
					// exit();
					
					foreach ($data as $key => $value) {
						$i = 1; 
						// echo "PROSES SUB INV $key { ";
						foreach ($value as $key2 => $value2) {
							$dataNew = $value2;
							$dataNew['NO_URUT'] = $i;
							//create TEMP
							$this->M_MoveOrder->createTemp($dataNew);
							$i++;

						}
							//create MO         
							$this->M_MoveOrder->createMO($ip_address,$job_id[0],$subinv_to[0],$locator_to[0],$key,$data2[$key]);

							//delete
							$this->M_MoveOrder->deleteTemp($ip_address,$job_id[0]);
					}

					$checkPicklist = $this->M_MoveOrder->checkPicklist($job);
					foreach ($checkPicklist as $key => $value) {
						$no_mo = $value['REQUEST_NUMBER'];
						array_push($array_mo, $no_mo);
					}
			}
			// echo "<pre>";
			// print_r($array_mo);
			// exit();

			if ($array_mo) {
				$this->pdf($array_mo, $nama_satu, $nama_dua);
			}else{
				exit('Terjadi Kesalahan :(');
			}

		
		}
	}

	public function pdf($array_mo,$nama_satu, $nama_dua){
		// ------ GET DATA ------
		// print_r($array_mo);

			$temp_filename = array();
			foreach ($array_mo as $key => $mo) {

				$moveOrderAwal = $moveOrderAkhir = $mo;
				$mentahHead	= $this->M_MoveOrder->getHeader($moveOrderAwal, $moveOrderAkhir);
				$mentahLine	= $this->M_MoveOrder->getDetail($moveOrderAwal, $moveOrderAkhir);

				// echo "<pre>";
				// print_r($mentahHead);
				// exit();
				


		// ------ GENERATE QRCODE ------
				if(!is_dir('./assets/img'))
				{
					mkdir('./assets/img', 0777, true);
					chmod('./assets/img', 0777);
				}

				foreach ($mentahHead as $mh) {
					if ($mh['DEPARTMENT'] == 'SUBKT') {

						$headerTemp = $this->M_MoveOrder->getNomorHeader($mh['JOB_NO']);
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

		$kodeDepartement = $this->M_MoveOrder->checkDepartement($array_mo[0]);


		// ------ GENERATE PDF ------
			$this->load->library('Pdf');
			$pdf 				= $this->pdf->load();
			if (in_array('SUBKT', $kodeDepartement[0])) {
				// $pdf 				= new mPDF('utf-8',array(215,140), 0, '', 2, 2, 2,0);
				$pdf 				= new mPDF('utf-8',array(215, 140), 0, '', 2, 2, 55.5, 35, 2, 4);
			} else {
				$pdf 				= new mPDF('utf-8',array(215, 140), 0, '', 2, 2, 49.5, 25, 2, 4);	
			}
			
			// $pdf 				= new mPDF('utf-8','A5-L', 0, '', 2, 2, 18.5, 21, 2, 2);
			$filename			= 'Picklist_'.time().'.pdf';
			$a = 0;
			foreach ($array_mo as $key => $mo) {
				$moveOrderAwal = $moveOrderAkhir = $mo;
				$dataall[$a]['head']	= $this->M_MoveOrder->getHeader($moveOrderAwal, $moveOrderAkhir);
				$dataall[$a]['line']	= $this->M_MoveOrder->getDetail($moveOrderAwal, $moveOrderAkhir);
				$a++;
			}

			// echo "<pre>";

			$head		= array();
			$jobNo		= array();
			$gudang		= array();
			$line		= array();
			$pdf->SetTitle('Picklist_'.date('d/m/Y H/i/s').'.pdf');
			foreach ($dataall as $key => $value) {
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
					$data['dataall']['head'][0]['ALAMAT'] = $this->M_MoveOrder->getAlamat($value['head'][0]['JOB_NO']); //--->> ALAMAT CALLING
					$data['dataall']['head'][0]['HEADER_NO'] = $this->M_MoveOrder->getNomorHeader($value['head'][0]['JOB_NO']);
					// echo "<pre>";
		
					// $head = $this->load->view('Inventory/MainMenu/MoveOrder/V_Head2', $data, TRUE);
					$head = $this->load->view('Inventory/MainMenu/MoveOrder/V_Head2', $data, TRUE);
					$line = $this->load->view('Inventory/MainMenu/MoveOrder/V_Index2', $data, TRUE);
					$foot = $this->load->view('Inventory/MainMenu/MoveOrder/V_Foot2', $data, TRUE);
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
					// break;
				}
				//$pdf->WriteHTML($line,0);
			}
			$pdf->Output($filename, 'I');

			if (!empty($temp_filename)) {
				foreach ($temp_filename as $tf) {
					if(is_file($tf)){
						unlink($tf);
					}
				}
			}
	}

	public function createall(){
		$nama_satu = '';
		$nama_dua = '';
		$ip_address =  $this->input->ip_address();
		$no_job 	= $this->input->post('no_job');
		$qty 	  = $this->input->post('qty');
		$invID 		  = $this->input->post('invID');
		$uom 		  = $this->input->post('uom');
		$job_id 	  = $this->input->post('job_id');
		$subinv_to 	  = $this->input->post('subinvto');
		$locator_to 	  = $this->input->post('locatorto');
		$subinv_from 	  = $this->input->post('subinvfrom');
		$locator_from 	  = $this->input->post('locatorfrom');
		$selected = $this->input->post('selectedPicklistIMO');
		$arraySelected = explode('+', $selected);
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
				$i =1;
				if (in_array($no_job2[0], $arraySelected)){
					$checkPicklist = $this->M_MoveOrder->checkPicklist($no_job2[0]);
					if (count($checkPicklist) > 0) {
						foreach ($checkPicklist as $keymo => $valuemo) {
							$no_mo = $valuemo['REQUEST_NUMBER'];
							array_push($array_mo, $no_mo);
						}
					} else {
						$data = array();
						//CHECK QTY VS ATR
						$atr = ",khs_inv_qty_atr(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
						$getQuantityActual = $this->M_MoveOrder->getQuantityActual($no_job2[0],$atr);
						$errQty = array();
						foreach ($getQuantityActual as $kQty => $vQty) {
							if ($vQty['REQ'] > $vQty['ATR']){
								$err = 1;
							}else{
								$err = 0;
							}
							$errQty[] = $err;
						}

						if (in_array(1, $errQty)) {
							// START
								foreach ($no_job2 as $k => $v) {
									$data[$subinv_from2[$k]][] = array('NO_URUT' => '',
													'INVENTORY_ITEM_ID' => $invID2[$k],
													'QUANTITY' => $qty2[$k],
													'UOM' => $uom2[$k],
													'IP_ADDRESS' => $ip_address,
													'JOB_ID' => $job_id2[$k]);
									$data2[$subinv_from2[$k]] = $locator_from2[$k];

								}
								
								foreach ($data as $kSub => $vSub) {
									$i = 1; 
									foreach ($vSub as $key2 => $value2) {
										$dataNew = $value2;
										$dataNew['NO_URUT'] = $i;
										//create TEMP
										$this->M_MoveOrder->createTemp($dataNew);
										$i++;
									}
										//create MO         
										$this->M_MoveOrder->createMO($ip_address,$job_id2[0],$subinv_to2[0],$locator_to2[0],$kSub,$data2[$kSub]);


										//delete
										$this->M_MoveOrder->deleteTemp($ip_address,$job_id2[0]);
								}
							// END

								$checkPicklist = $this->M_MoveOrder->checkPicklist($job_id2[0]);
								foreach ($checkPicklist as $keymo => $valuemo) {
									$no_mo = $valuemo['REQUEST_NUMBER'];
									array_push($array_mo, $no_mo);
								}
							}
						}
					}
			}else{
				if (in_array($value, $arraySelected)){
					$checkPicklist = $this->M_MoveOrder->checkPicklist($value);
					if (count($checkPicklist) > 0) {
						foreach ($checkPicklist as $keymo => $valuemo) {
							$no_mo = $valuemo['REQUEST_NUMBER'];
							array_push($array_mo, $no_mo);
						}
					} else {
						//CHECK QTY VS ATR
						$atr = ",khs_inv_qty_atr(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
						$getQuantityActual = $this->M_MoveOrder->getQuantityActual($value,$atr);
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
							$data = array('NO_URUT' => 1,
									'INVENTORY_ITEM_ID' => $invID[$key],
									'QUANTITY' => $qty[$key],
									'UOM' => $uom[$key],
									'IP_ADDRESS' => $ip_address,
									'JOB_ID' => $job_id[$key]);
							// $data2[$subinv_from2[$k]] = $locator_from2[$k];
							//create TEMP


							$this->M_MoveOrder->createTemp($data);

							//create MO
							$this->M_MoveOrder->createMO($ip_address,$job_id[$key],$subinv_to[$key],$locator_to[$key],$subinv_from[$key],$locator_from[$key]);

							//delete
							$this->M_MoveOrder->deleteTemp($ip_address,$job_id[$key]);

							$checkPicklist = $this->M_MoveOrder->checkPicklist($value);
							foreach ($checkPicklist as $keymo => $valuemo) {
								$no_mo = $valuemo['REQUEST_NUMBER'];
								array_push($array_mo, $no_mo);
							}
						}
					}
				}
			}
		}

		// echo "<pre>";
		// print_r($array_mo);
		// exit();

		if ($array_mo) {
			$this->pdf($array_mo,$nama_satu,$nama_dua);
		}else{
			exit('Terjadi Kesalahan :(');
		}


	}
}