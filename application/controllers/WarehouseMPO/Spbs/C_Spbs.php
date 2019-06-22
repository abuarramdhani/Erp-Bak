<?php defined('BASEPATH') ;
class C_Spbs extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		  
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WarehouseMPO/Spbs/M_Spbs','M_Spbs'); //Model
		  
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

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['warehouse'] = $this->M_Spbs->getWarehouse();
		$data['SUBKONT'] = $this->M_Spbs->getSubkont();

		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WarehouseMPO/Pengeluaran/Spbs/V_Spbshome',$data);
		$this->load->view('V_Footer',$data);
	}

	public function search()
	{

		$data['NO_MOBIL'] = $this->M_Spbs->getNomorCar();

		$warehouse = '';
		$spbsAwal = '';
		$spbsAkhir = '';
		$kirimAwal = '';
		$kirimAkhir = '';
		$nomorSpbs = '';
		$namaSub = '';
		$noJob = '';
		$query ='';
		$queryJob1 ='';
		$queryJob2 ='';
		$komponen = '';

		$spbsQ = '';
		$kirimQ = '';
		$nomorSpbsQ = '';
		$namaSubQ = '';
		$queryJob1 = '';
		$queryJob2 = '';
		$komponenQ = '';

		//WAREHOUSE
		$warehouse = $this->input->post('warehouse');
		$warehouseQ = "";
		if ($warehouse) {
			$warehouseQ = "AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = '$warehouse'";
		}

		//SPBS DATE
		$spbs_awal = $this->input->post('spbsAwal');
		if($spbs_awal){
			$spbsAwal = date_format(date_create($spbs_awal),'d/M/Y');
		}

		$spbs_akhir = $this->input->post('spbsAkhir');
		if ($spbs_akhir) {
			$spbsAkhir = date_format(date_create($spbs_akhir),'d/M/Y');
		}

		if ($spbsAwal && $spbsAkhir) {
          $spbsQ = "AND TRUNC(mtrh.creation_date) between '$spbsAwal' and '$spbsAkhir'";
        }

        //TANGGAL
		$kirim_awal = $this->input->post('kirimAwal');
		if ($kirim_awal) {
			$kirimAwal = date_format(date_create($kirim_awal),'d/M/Y');
		}

		$kirim_akhir = $this->input->post('kirimAkhir');
		if ($kirim_akhir) {
			$kirimAkhir = date_format(date_create($kirim_akhir),'d/M/Y');
		}

        if ($kirimAwal && $kirimAkhir) {
          $kirimQ = "AND TRUNC(tmp.tgl_mulai) between '$kirimAwal' and '$kirimAkhir'";
        }

        //NOMOR SPBS
        $nomorSpbs = $this->input->post('nomorSpbs');
        if ($nomorSpbs) {
          $nomorSpbsQ = "AND mtrh.request_number LIKE '%$nomorSpbs%'";
        }

        //NAMA SUB
        $namaSub = $this->input->post('namaSub');
        if ($namaSub) {
          $namaSubQ = "AND pov.vendor_name LIKE '%$namaSub%'";
        }

        //NO JOB
        $noJob = $this->input->post('noJob');
        if ($noJob) {
          $queryJob1 = "AND gbh.batch_no LIKE '%$noJob%'";
          $queryJob2 = "AND we.wip_entity_name LIKE '%$noJob%'";
        }

        //KOMPONEN
        $komponen = $this->input->post('komponen');
        if ($komponen) {
        	$komponenQ = "AND msib.description LIKE '%$komponen%'";
        }


        //-----------------------FINAL QUERY ----------------------//
        if ($spbsQ || $kirimQ || $nomorSpbsQ || $namaSubQ || $queryJob1 || $queryJob2 || $komponenQ) {
			//disinikan jalanin model filterSearch yang tanpa Distinct
			$outpartAll = $this->M_Spbs->filterSearch($warehouseQ, $spbsQ, $kirimQ, $nomorSpbsQ, $namaSubQ, $queryJob1, $queryJob2, $komponenQ);
			
			//disini juga jalanin model filterSearchDistinct
			// $outpartAll = $this->M_Spbs->filterSearchDistinct($warehouseQ, $spbsQ, $kirimQ, $nomorSpbsQ, $namaSubQ, $queryJob1, $queryJob2, $komponenQ);
        } else {
			//disini jalanin model search tanpa distinct
			$outpartAll = $this->M_Spbs->search($warehouseQ);
			
			//disini jalanin model searchDistinct
		}
		//echo "<pre>"; 
		//print_r($outpartAll);
		//echo "</pre>"; 

		// //Memasukkan semua nama subkon ke satu array
		// foreach($outpartAll as $all){
		// 	$nama[] = $all['NAMA_SUBKON'];
		// }

		// //echo "<pre>"; 
		// //print_r($nama);
		// //echo "</pre>";

		// //cek nama yang sama
		// $countNama = array_count_values($nama);
		
		// //echo "<pre>"; 
		// //print_r($countNama);
		// //echo "</pre>";

		// foreach($outpartAll as $all){
		// 	// jika tidak ada yang sama
		// 	if($countNama[$all["NAMA_SUBKON"]] == 1){
		// 		$newArray[] = array(
		// 			"NAMA_SUBKON" => $all["NAMA_SUBKON"],
		// 			"NO_MOBIL" => $all["NO_MOBIL"],
		// 			"NO_SPBS" => $all["NO_SPBS"],
		// 			"LINE_NUMBER" => $all["LINE_NUMBER"],
		// 			"NO_JOB" => $all["NO_JOB"],
		// 			"TGL_SPBS" => $all["TGL_SPBS"],
		// 			"TGL_TERIMA" => $all["TGL_TERIMA"],
		// 			"INVENTORY_ITEM_ID" => $all["INVENTORY_ITEM_ID"],
		// 			"TGL_KIRIM" => $all["TGL_KIRIM"],
		// 			"ITEM_CODE" => $all["ITEM_CODE"],
		// 			"ITEM_DESC" => $all["ITEM_DESC"],
		// 			"QTY_DIMINTA" => $all["QTY_DIMINTA"],
		// 			"UOM" => $all["UOM"],
		// 			"SUBINV" => $all["SUBINV"],
		// 			"TGL_MULAI" => $all["TGL_MULAI"],
		// 			"TGL_SELESAI" => $all["TGL_SELESAI"],
		// 			"KETERANGAN" => $all["KETERANGAN"],
		// 			"JAM_MULAI" => $all["JAM_MULAI"],
		// 			"JAM_SELESAI" => $all["JAM_SELESAI"],
		// 			"LAMA" => $all["LAMA"],
		// 			"AVERAGE" => $all["AVERAGE"],
		// 			"KETERANGAN2" => $all["KETERANGAN2"],
		// 			"TRANSACTION_DATE" => $all["TRANSACTION_DATE"],
		// 		);
		// 	}else{
		// 		//jika ada yang sama
		// 		$no_mobil[] = $all["NO_MOBIL"];
		// 		$no_spbs[] = $all["NO_SPBS"];
		// 		$line_number[] = $all["LINE_NUMBER"];
		// 		$no_job[] = $all["NO_JOB"];
		// 		$tgl_spbs[] = $all["TGL_SPBS"];
		// 		$tgl_terima[] = $all["TGL_TERIMA"];
		// 		$inventory_item_id[] = $all["INVENTORY_ITEM_ID"];
		// 		$tgl_kirim[] = $all["TGL_KIRIM"];
		// 		$item_code[] = $all["ITEM_CODE"];
		// 		$item_desc[] = $all["ITEM_DESC"];
		// 		$qty_kirim[] = $all["QTY_DIMINTA"];
		// 		$uom[] = $all["UOM"];
		// 		$subinv[] = $all["SUBINV"];
		// 		$tgl_mulai[] = $all["TGL_MULAI"];
		// 		$tgl_selesai[] = $all["TGL_SELESAI"];
		// 		$keterangan[] = $all["KETERANGAN"];
		// 		$jam_mulai[] = $all["JAM_MULAI"];
		// 		$jam_selesai[] = $all["JAM_SELESAI"];
		// 		$lama[] = $all["LAMA"];
		// 		$average[] = $all["AVERAGE"];
		// 		$keterangan2[] = $all["KETERANGAN2"];
		// 		$transaction_date[]= $all["TRANSACTION_DATE"];
		// 	}
		// }

		// // menghitung semua value yang nama subkonnya sama
		// $countNoMobil = array_count_values($no_mobil);
		// $countNoSpbs = array_count_values($no_spbs);
		// $countLineNumber = array_count_values($line_number);
		// $countNoJob = array_count_values($no_job);
		// $countTglSpbs = array_count_values($tgl_spbs);
		// $countTglTerima = array_count_values($tgl_terima);
		// $countInventoryItemId = array_count_values($inventory_item_id);
		// $countTglKirim = array_count_values($tgl_kirim);
		// $countItemCode = array_count_values($item_code);
		// $countItemDesc = array_count_values($item_desc);
		// $countQtyKirim = array_count_values($qty_kirim);
		// $countUom = array_count_values($uom);
		// $countSubInv = array_count_values($subinv);
		// $countTglMulai = array_count_values($tgl_mulai);
		// $countTglSelesai = array_count_values($tgl_selesai);
		// $countKeterangan = array_count_values($keterangan);
		// $countJamMulai = array_count_values($jam_mulai);
		// $countJamSelesai = array_count_values($jam_selesai);
		// $countLama = array_count_values($lama);
		// $countAverage = array_count_values($average);
		// $countKeterangan2 = array_count_values($keterangan2);
		// $countTransactionDate = array_count_values($transaction_date);

		// foreach ($outpartAll as $key => $all) {
		// 	if($countNoMobil == 1){
		// 		foreach($no_mobil as $data){
					
		// 		}
		// 	}
		// }
		// echo "<pre>"; 
		// print_r($newArray);
		// echo "</pre>";

		// exit();

		$data['outpartAll'] = $outpartAll;
		$colum_sub  = array_column($outpartAll, 'NAMA_SUBKON');
		$count_sub = array_count_values($colum_sub);
		$data['count_sub'] = $count_sub;

        // echo "<pre>";
        // print_r($count_sub);
		// 		exit();
				
		$this->load->view('WarehouseMPO/Pengeluaran/Spbs/V_Resultspbs', $data);
	}

	public function insertData() {
		$NO_SPBS =$this->input->post('spbs');
		$INVENTORY_ITEM_ID =$this->input->post('inv_id');
		$TGL_MULAI = $this->input->post('kirimDate'); 
		$TGL_SELESAI = $this->revokeDate($this->input->post('terimaDate'));
		$JAM_MULAI =$this->input->post('jamMulai');
		$JAM_SELESAI =$this->input->post('jamAkhir');
		$NO_MOBIL =$this->input->post('noMobil');

		// echo $NO_SPBS;
		// echo "<br>".$INVENTORY_ITEM_ID;
		// echo "<br>".$TGL_MULAI;
		// echo "<br>".$TGL_SELESAI;
		// echo "<br>".$JAM_MULAI;
		// echo "<br>".$JAM_SELESAI;
		// echo "<br>".$NO_MOBIL ;
		// echo "<br>".$inv_id;
		// exit();

		$JAM_MULAI = str_replace('-', ':', $JAM_MULAI);
		$JAM_SELESAI = str_replace('-', ':', $JAM_SELESAI);
		//$this->M_Spbs->insertData($NO_SPBS, $INVENTORY_ITEM_ID, $TGL_MULAI.' '.$JAM_MULAI, $TGL_SELESAI.' '.$JAM_SELESAI, $NO_MOBIL);
		redirect();
	}

	// function revokeDate($date) {
	// 	if(empty($date)) return '';
	// 	$date = explode('-', $date);
	// 	switch($date[1]) {
	// 		case 'JAN':
	// 			$date[1] = '01';
	// 			break;
	// 		case 'FEB':
	// 			$date[1] = '02';
	// 			break;
	// 		case 'MAR':
	// 			$date[1] = '03';
	// 			break;
	// 		case 'APR':
	// 			$date[1] = '04';
	// 			break;
	// 		case 'MAY':
	// 			$date[1] = '05';
	// 			break;
	// 		case 'JUN':
	// 			$date[1] = '06';
	// 			break;
	// 		case 'JUL':
	// 			$date[1] = '07';
	// 			break;
	// 		case 'AUG':
	// 			$date[1] = '08';
	// 			break;
	// 		case 'SEP':
	// 			$date[1] = '09';
	// 			break;
	// 		case 'OCT':
	// 			$date[1] = '10';
	// 			break;
	// 		case 'NOV':
	// 			$date[1] = '11';
	// 			break;
	// 		case 'DEC':
	// 			$date[1] = '12';
	// 			break;
	// 	}
	// 	return '20'.$date[2].'-'.$date[1].'-'.$date[0];
	// }

	public function updateData() {
		$NO_SPBS = $this->input->post('spbs');
		$INVENTORY_ITEM_ID = $this->input->post('inv_id');
		$TGL_KIRIM = $this->input->post('kirimDate'); 
		$JAM_MULAI = $this->input->post('jamMulaiMPBG');
		$JAM_SELESAI = $this->input->post('jamAkhirMPBG');
		$QTY_KIRIM = $this->input->post('qtyKirim');
		$NO_MOBIL = $this->input->post('noMobil');
		$KETERANGAN = $this->input->post('keterangan');

		//echo '<script>alert('.$NO_SPBS.' '.$INVENTORY_ITEM_ID.' '.$TGL_KIRIM.' '.$JAM_MULAI.' '.$JAM_SELESAI.' '.$QTY_KIRIM.' '.$NO_MOBIL.' '.$KETERANGAN.')</script>';
		//exit();

		$TGL_MULAI = $TGL_KIRIM." ".$JAM_MULAI;
		$TGL_SELESAI = $TGL_KIRIM." ".$JAM_SELESAI;

		$date_start = strtotime($TGL_MULAI);
		$date_end = strtotime($TGL_SELESAI);

		$date_start = date("Y/m/d h:i:s", $date_start);
		$date_end = date("Y/m/d h:i:s", $date_end);
		// $date_start = date('YYYY/MM/DD HH24:MI:SS', $date_start);
		// $date_end = date('YYYY/MM/DD HH24:MI:SS', $date_end);

		// $data = array(
		// 	 'NO_SPBS'=>$NO_SPBS,
		// 	 'INVENTORY_ITEM_ID'=>$INVENTORY_ITEM_ID,
		// 	 'TGL_MULAI'=>($date_start),
		// 	 'TGL_SELESAI'=>($date_end),
		// 	 'NO_MOBIL'=>$NO_MOBIL
		// );

		// if($this->M_Spbs->updateData($NO_SPBS,$INVENTORY_ITEM_ID,$NO_MOBIL,$date_start,$date_end,$QTY_KIRIM,$KETERANGAN)
		// ) {
		// $this->M_Spbs->updateDataKet($KETERANGAN,$NO_SPBS,$INVENTORY_ITEM_ID);
		// $this->load->view('V_Resultspbs');
		// } else {
		// 	$this->output->append_output('GAGAL');
		// }
		// $this->load->view('V_Resultspbs');
		$this->M_Spbs->updateData($NO_SPBS,$INVENTORY_ITEM_ID,$NO_MOBIL,$date_start,$date_end,$QTY_KIRIM,$KETERANGAN);
		$this->M_Spbs->updateDataKet($KETERANGAN,$NO_SPBS,$INVENTORY_ITEM_ID);

		redirect("MonitoringBarangGudang/Pengeluaran/");
	} 



	//tutup class 
}
?> 


