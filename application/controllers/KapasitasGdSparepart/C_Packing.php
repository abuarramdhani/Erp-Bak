<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Packing extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_packing');

		$this->checkSession();
	}


	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			session_destroy();
			redirect('');
		}
	}


	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Packing';
		$data['Menu'] = 'Packing';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');
		$data['value'] = $this->M_packing->tampilhariini();
		$packing = $this->M_packing->dataPacking($date);
		$data['data']= $packing;
		// for ($i=0; $i <count($packing); $i++) { 
		// 	if ($packing[$i]['WAKTU_PACKING']) {
		// 		$data['selisih'][$i] = $packing[$i]['WAKTU_PACKING'];
		// 	}else{
			// $jenis = $packing[$i]['JENIS_DOKUMEN'];
			// $nospb = $packing[$i]['NO_DOKUMEN'];
			// $waktu1 = strtotime('2020-02-13 06:23:06');
			// $waktu2 = strtotime('2020-02-12 10:19:10');
			// $selisih = ($waktu1 - $waktu2);
			// $jam = floor($selisih/(60*60));
			// $menit = $selisih - $jam * (60 * 60);
			// $htgmenit = floor($menit/60) * 60;
			// $detik = $menit - $htgmenit;
			// $data['selisih'] = $jam.':'.floor($menit/60).':'.$detik;
			// $slsh = $data['selisih'][$i];
			// $query = "set waktu_packing = '$slsh'"; 
			// $saveselisih = $this->M_packing->saveWaktu($jenis, $nospb, $query);
		// 	}
		// }
		// echo "<pre>"; 
		// print_r($waktu1);
		// echo "<br>"; 
		// print_r($waktu2);
		// echo "<br>"; 
		// print_r($data['selisih']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Packing', $data);
		$this->load->view('V_Footer',$data);
	}


	public function getPIC()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_packing->getPIC($term);
		echo json_encode($data);
	}


	public function getPacking()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_packing->tampilhariini();
		$data['noind']  = $this->M_packing->getPIC2();
        $this->load->view('KapasitasGdSparepart/V_Ajax_Packing', $data);
    }


	public function getSelesaiPacking()
	{
		$this->checkSession();
    	$date = date('d/m/Y');
		$packing 		= $this->M_packing->dataPacking($date);
		$data['data']	= $packing;
		$data['noind']  = $this->M_packing->getPIC(null);
        $this->load->view('KapasitasGdSparepart/V_Ajax_Selesai_Packing', $data);
	}


	public function updateMulai()
	{
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$pic 	= $this->input->post('pic');
		
		$cek = $this->M_packing->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PACKING'] == '') {
			$this->M_packing->SavePacking($date, $jenis, $nospb, $pic);
		}
	}


	public function updateSelesai()
	{
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');
		$pic 	= $this->input->post('pic');
		// $jml_colly 		= $this->input->post('jml_colly');
		// $kardus_kecil 	= $this->input->post('kardus_kecil');
		// $kardus_sdg 	= $this->input->post('kardus_sdg');
		// $kardus_bsr 	= $this->input->post('kardus_bsr');
		// $karung 		= $this->input->post('karung');
		// echo "<pre>";print_r($karung);exit();

		$cek = $this->M_packing->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PACKING'] == '') {
			$waktu1 	= strtotime($mulai);
			$waktu2 	= strtotime($selesai);
			$selisih 	= ($waktu2 - $waktu1);
			$jam 		= floor($selisih/(60*60));
			$menit 		= $selisih - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik 		= $menit - $htgmenit;
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;	
		} else {
			$a = explode(':', $cek[0]['WAKTU_PACKING']);
			$jamA 	= $a[0] * 3600;
			$menitA = $a[1] * 60;
			$waktuA = $jamA + $menitA + $a[2];

			$waktu1 = strtotime($mulai);
			$waktu2 = strtotime($selesai);
			$waktuB = $waktu2 - $waktu1;
			$jumlah = $waktuA + $waktuB;
			$jam 	= floor($jumlah/(60*60));
			$menit 	= $jumlah - $jam * (60 * 60);
			$htgmenit = floor($menit/60) * 60;
			$detik 	= $menit - $htgmenit;
			$slsh 	= $jam.':'.floor($menit/60).':'.$detik;
		}
		
		$this->M_packing->SelesaiPacking($date, $jenis, $nospb, $slsh, $pic);
		// $this->M_packing->insertColly($nospb, $jml_colly, $kardus_kecil, $kardus_sdg, $kardus_bsr, $karung);
	}


	public function pauseSPB()
	{
		$nospb = $this->input->post('no_spb');
		$jenis = $this->input->post('jenis');
		$mulai = $this->input->post('mulai');
		$selesai = $this->input->post('wkt');

		$waktu1		= strtotime($mulai);
		$waktu2 	= strtotime($selesai);
		$selisih 	= $waktu2 - $waktu1;
		$jam 		= floor($selesai / (60 * 60));
		$menit 		= $selisih - $jam * (60 * 60);
		$htgmenit 	= floor($menit / 60) * 60;
		$detik 		= $menit - $htgmenit;
		$slsh 		= $jam.':'.floor($menit / 60).':'.$detik;

		$this->M_packing->waktuPacking($nospb, $jenis, $slsh);
	}


	public function modalColly2(){
		$data['date'] 	= $this->input->post('date');
		$data['jenis']	= $this->input->post('jenis');
		$data['nospb'] 	= $this->input->post('no_spb');
		$data['mulai'] 	= $this->input->post('mulai');
		$data['selesai'] = $this->input->post('wkt');
		$data['pic'] 	= $this->input->post('pic');
		$data['nomor'] 	= $this->input->post('no');
		$data['ket']	= 'packing';

		$data['data'] = $this->M_packing->cekPacking($data['nospb']);
		
		$this->load->view('KapasitasGdSparepart/V_ModalArsipColy', $data);
		// echo "<pre>";print_r($cek);exit();
	}


	public function saveberatPacking(){
		$no_spb = $this->input->post('no_spb');
		$jenis = $this->input->post('jenis_kemasan');
		$berat = $this->input->post('berat');
		$no = $this->input->post('no');
		$cek = $this->M_packing->cekBeratPacking($no_spb, $no);
		// echo "<pre>";print_r($cek);exit();
		if (empty($cek)) {
			$save = $this->M_packing->insertBerat($no_spb, $jenis, $berat, $no);
			echo "save";
		}else {
			$save = $this->M_packing->updateBerat($no_spb, $jenis, $berat, $no);
			echo "update";
		}
	}

	public function gantiPacking(){
		$no_spb = $this->input->post('no_spb');
		$jenis = $this->input->post('jenis_kemasan');
		$berat = $this->input->post('berat');
		$no = $this->input->post('no');
		$save = $this->M_packing->updateBerat($no_spb, $jenis, $berat, $no);
		// echo "<pre>";print_r($save);exit();
	}

	
	public function getData()
    {
    	$data['colly'] = $this->M_packing->getDataPacking($this->input->post('no_spb'));
    	$data['total'] = $this->M_packing->getTotalColly($this->input->post('no_spb'));

        $this->load->view('KapasitasGdSparepart/V_Ajax_Colly', $data);
    }

    public function cekItem()
    {
    	echo json_encode($this->M_packing->cekItem(
          	$this->input->post('item'),
          	$this->input->post('colly')
         ));
    }


    public function updateQtyVerif()
    {
    	$update = $this->M_packing->updateQtyVerif(
    		$this->input->post('qty_verif'),
    		$this->input->post('colly'),
    		$this->input->post('item')
    	);
    }


    public function cekColly()
    {
    	echo json_encode($this->M_packing->cekColly(
          	$this->input->post('colly')
         ));
    }


    public function updateBeratColly()
    {
    	$update = $this->M_packing->updateBeratColly(
    		$this->input->post('berat'),
    		$this->input->post('colly')
    	);
    }


    public function updateJenisColly()
    {
    	$update = $this->M_packing->updateJenisColly(
    		$this->input->post('jenis'),
    		$this->input->post('colly')
    	);
    }


    public function cekTransact()
    {
    	echo json_encode($this->M_packing->cekTransact(
          	$this->input->post('no_spb')
         ));
    }


    public function transactDOSP()
    {	
    	$user = $this->session->userdata('user');
    	$data['dosp'] = $this->M_packing->getAPIdata($this->input->post('no_spb'));

    	$this->M_packing->transactDOSP($data['dosp'][0]['REQUEST_NUMBER'], $data['dosp'][0]['ORGANIZATION_ID']);
    // 	$this->M_packing->closeLine($data['dosp'][0]['HEADER_ID'], $user);

    // 	if ($data['dosp'][0]['DELIVERY_TYPE'] == 'SPB') {
    // 		$this->M_packing->autoInterorg($this->input->post('no_spb'));
    // 	}
    // 	else {
    		
    // 	}
    }


  //   public function cetakSM($colly)
  //   {
  //       $data['get_header'] = $this->M_packing->headfootPL($colly);

  //       $id = $data['get_header'][0]['REQUEST_NUMBER'];

  //       // $data['get_body'] = $this->M_packing->bodyPL($id);
		// $data['get_colly'] = $this->M_packing->getTotalColly($id);
  //       $data['total_colly'] = sizeof($data['get_colly']);
  //       $data['this_colly'] = $colly;

  //       // echo "<pre>";
  //       // print_r($data);
  //       // die();

  //       if (!empty($id)) {
  //           // ====================== do something =========================
  //           $this->load->library('Pdf');
  //           $this->load->library('ciqrcode');

  //           $pdf 		= $this->pdf->load();
  //           $pdf 		= new mPDF('utf-8', array(110 , 80), 0, '', 3, 3, 3, 0, 0, 0);

  //           // ------ GENERATE QRCODE ------
  //           if (!is_dir('./assets/img/monitoringDOSPQRCODE')) {
  //               mkdir('./assets/img/monitoringDOSPQRCODE', 0777, true);
  //               chmod('./assets/img/monitoringDOSPQRCODE', 0777);
  //           }

  //           $params['data']		= $data['get_header'][0]['REQUEST_NUMBER'];
  //           $params['level']	= 'H';
  //           $params['size']		= 4;
  //           $params['black']	= array(255,255,255);
  //           $params['white']	= array(0,0,0);
  //           $params['savename'] = './assets/img/monitoringDOSPQRCODE/'.$data['get_header'][0]['REQUEST_NUMBER'].'.png';
            
  //           $this->ciqrcode->generate($params);
           
  //           ob_end_clean() ;
            
  //           $filename 	= 'Shipping_Mark_'.$colly.'.pdf';
  //           $cetakPL	= $this->load->view('KapasitasGdSparepart/V_Pdf_SM', $data, true);
            
  //           $pdf->SetFillColor(0,255,0);
  //           $pdf->WriteHTML($cetakPL);
  //           $pdf->Output($filename, 'I');

  //       // ========================end process=========================
  //       } else {
	 //        echo json_encode(array(
	 //          	'success' => false,
	 //          	'message' => 'id is null'
	 //        ));
  //       }

  //       if (!unlink($params['savename'])) {
  //           echo("Error deleting");
  //       } else {
  //           unlink($params['savename']);
  //       }
  //   }
}