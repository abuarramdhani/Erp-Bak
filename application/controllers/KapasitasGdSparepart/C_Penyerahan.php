<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Penyerahan extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_penyerahan');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Manifest SPB/DO';
		$data['Menu'] = 'Manifest SPB/DO';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Penyerahan', $data);
		$this->load->view('V_Footer',$data);
    }

    public function getData(){
        $tglAwal = $this->input->post('tglAwal');

		$nomor = $this->M_penyerahan->getNomorSPB($tglAwal);
		$data['spb'] = array();
		$a = 0;
		foreach ($nomor as $no) {
			// for ($a=0; $a < 8; $a++) {
			$getdata = $this->M_penyerahan->getDataSPB($no['no_SPB']);
			$berat = $this->M_penyerahan->cariberat($no['no_SPB']);
			// echo "<pre>";print_r($getdata);exit();
			if (!empty($getdata)) {
				if (!empty($berat)) {
					$spb = array();
					for ($i=0; $i < count($berat) ; $i++) {
						if ($i == 0) {
							$array = array(
								'MO_NUMBER' 		=> $getdata[0]['REQUEST_NUMBER'],
								'EXPEDITION_CODE' 	=> $getdata[0]['ATTRIBUTE15'],
								'TUJUAN' 			=> $getdata[0]['TUJUAN'],
								'SUM_PACKING_QTY' 	=> $getdata[0]['QTY_TRANSACT'],
								'ITEM_COLY' 		=> count($berat),
								'SUM_WEIGHT' 		=> $berat[$i]['BERAT'],
							);
						array_push($data['spb'], $array);
						}else {
							$data['spb'][$a]['SUM_WEIGHT'] = $data['spb'][$a]['SUM_WEIGHT'].', '.$berat[$i]['BERAT'];
						}
					}
				}else {
					$array = array(
						'MO_NUMBER' 		=> $getdata[0]['REQUEST_NUMBER'],
						'EXPEDITION_CODE' 	=> $getdata[0]['ATTRIBUTE15'],
						'TUJUAN' 			=> $getdata[0]['TUJUAN'],
						'SUM_PACKING_QTY' 	=> $getdata[0]['QTY_TRANSACT'],
						'ITEM_COLY' 		=> '',
						'SUM_WEIGHT' 		=> '',
					);
				array_push($data['spb'], $array);
				}
			}
			$a++;
		}
		// echo "<pre>";print_r($data['spb']);exit();

        $this->load->view('KapasitasGdSparepart/V_TblPenyerahan', $data);
	}

	public function cetakData(){
		$nospb 		= $this->input->post('nospb[]');
		$ekspedisi 	= $this->input->post('ekspedisi[]');
		$qty 		= $this->input->post('item[]');
		$berat 		= $this->input->post('berat[]');
		$tujuan 	= $this->input->post('tujuan[]');
		$scan 		= $this->input->post('jmlscan[]');
		// echo "<pre>";print_r($ekspedisi);exit();

		$coba = '';
		$exs = array();
		for ($i=0; $i < count($nospb); $i++) {
			if ($scan[$i] == $qty[$i]) {
				$coba[$ekspedisi[$i]][] = array(
					'no_dokumen' 	=> $nospb[$i],
					'tujuan' 		=> $tujuan[$i],
					'jumlah' 		=> $qty[$i],
					'berat' 		=> $berat[$i],
					'ekspedisi' 	=> $ekspedisi[$i],
					'scan' 			=> $scan[$i],
				);
				$pisah = explode(",", $berat[$i]);
				if (!in_array($ekspedisi[$i], $exs)) {
					array_push($exs, $ekspedisi[$i]);
					$size[$ekspedisi[$i]] = 0;
				}
				if (count($pisah) < 15) {
					$size[$ekspedisi[$i]] += 1;
				}elseif (count($pisah) > 14 && count($pisah) < 20) {
					$size[$ekspedisi[$i]] += 2;
				}else {
					$t = substr(count($pisah),0,1);
					$size[$ekspedisi[$i]] += $t;
				}
			}
		}
		// echo "<pre>";print_r($size);exit();

		$data['cetak'] = $coba;

		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','f4', 0, '', 5, 5, 22, 35, 7, 4);
		$filename 	= 'penyerahan-paket.pdf';
		$x = 0;
		foreach ($coba as $key => $val) {
			$data['size'] = $size[$key];
			$data['data'] = $val;
			$data['urut'] = $x;
			$data['eks'] = $key;
			$head 	= $this->load->view('KapasitasGdSparepart/V_Headpdf', $data, true);
			$html 	= $this->load->view('KapasitasGdSparepart/V_PdfPenyerahan', $data, true);
			$footer = $this->load->view('KapasitasGdSparepart/V_Footerpdf', $data, true);

		ob_end_clean();
		$pdf->SetHTMLHeader($head);
		$pdf->WriteHTML($html);
		$pdf->SetHTMLFooter($footer);
		// $pdf->debug = true;
		$x++;
		}
		$pdf->Output($filename, 'I');
			// echo "<pre>";print_r($data['exs']);exit();


	}


	public function getEkspedisi()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_penyerahan->getEkspedisi($term);
		echo json_encode($data);
	}


	public function getSiapManifest()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
    	$ekspedisi = $this->input->post('ekspedisi');

		$data['value'] 	= $this->M_penyerahan->getSiapManifest($ekspedisi);
		$data['noind']  = $this->M_penyerahan->getPIC();
        $this->load->view('KapasitasGdSparepart/V_Ajax_Penyerahan', $data);
    }


	// public function getManifest()
 //    {
 //    	$this->checkSession();
 //    	$date = date('d/m/Y');
	// 	$data['value'] 	= $this->M_penyerahan->dataManifest();
	// 	$data['noind']  = $this->M_penyerahan->getPIC();
	// 	// $data['noind']  = $this->M_penyerahan->getPIC(null);
	// 	// $pelayanan 		= $this->M_penyerahan->dataPelayanan($date);
	// 	// $data['data']	= $pelayanan;
 //        $this->load->view('KapasitasGdSparepart/V_Ajax_Penyerahan', $data);
 //    }


    public function getSudahManifest()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_penyerahan->dataSudahManifest();
		$data['noind']  = $this->M_penyerahan->getPIC();
		// $data['noind']  = $this->M_penyerahan->getPIC(null);
		// $pelayanan 		= $this->M_penyerahan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Selesai_Penyerahan', $data);
    }


    public function cekSiapManifest()
    {
    	echo json_encode($this->M_penyerahan->cekSiapManifest(
          	$this->input->post('no_spb'),
          	$this->input->post('ekspedisi')
        ));
    }


    public function cekSudahManifest()
    {
    	echo json_encode($this->M_penyerahan->cekSudahManifest(
          	$this->input->post('no_spb')
        ));
    }

    public function generateManifestNum()
    {
    	$new = $this->M_penyerahan->generateManifestNum();
    	$user = $this->session->userdata('user');

    	echo json_encode($new);
    }


    public function cetakMNF($id)
    {
    	$data['get_data'] = $this->M_penyerahan->getDataCetak($id);
			// echo "<pre>";print_r($data['get_data']);die;
    	$data['get_nama'] = $this->M_penyerahan->getNamaEkspedisi();
			// $data['get_body'] = $this->M_penyerahan->bodyPL($id);
			// $data['get_colly'] = $this->M_penyerahan->getTotalColly($id);
			// $data['total_colly'] = sizeof($data['get_colly']);
			// $data['total_berat'] = $this->M_penyerahan->getTotalBerat($id);
			// $data['petugas'] = $this->M_penyerahan->getAll($id);

        if (!empty($id)) {
            // ====================== do something =========================
            $this->load->library('Pdf');
            $this->load->library('ciqrcode');

            $pdf 		= $this->pdf->load();
            // $pdf 		= new mPDF('utf-8', 'F4', 0, '', 3, 3, 3, 0, 0, 0);
						$pdf    = new mPDF('utf-8', array(210 , 267), 0, '', 3, 3, 3, 0, 0, 0);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/monitoringDOSPQRCODE')) {
                mkdir('./assets/img/monitoringDOSPQRCODE', 0777, true);
                chmod('./assets/img/monitoringDOSPQRCODE', 0777);
            }

            $params['data']		= $data['get_data'][0]['MANIFEST_NUMBER'];
            $params['level']	= 'H';
            $params['size']		= 4;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/monitoringDOSPQRCODE/'.$data['get_data'][0]['MANIFEST_NUMBER'].'.png';

            $this->ciqrcode->generate($params);

            ob_end_clean() ;

            $filename 	= 'Manifest_'.$data['get_data'][0]['EKSPEDISI'].'_'.$data['get_data'][0]['MANIFEST_NUMBER'].'.pdf';
            $cetakPL	= $this->load->view('KapasitasGdSparepart/V_Pdf_MNF', $data, true);

            $pdf->SetFillColor(0,255,0);
            // $pdf->SetAlpha(0.4);
            $pdf->WriteHTML($cetakPL);
            $pdf->Output($filename, 'I');
        // ========================end process=========================
        } else {
	        echo json_encode(array(
	          	'success' => false,
	          	'message' => 'id is null'
	        ));
        }

        if (!unlink($params['savename'])) {
            echo("Error deleting");
        } else {
            unlink($params['savename']);
        }
    }


		//======== =======
		public function savePenyerahan($value='')
		{
			$reque = $this->input->post('request_number', true);
			$no_manifest = $this->input->post('no_manifest', true);
			$eks = $this->input->post('ekspedisi', true);
			echo json_encode($this->M_penyerahan->savePenyerahan($reque, $no_manifest, $eks));
		}

		public function cekudatransactblm($value='')
		{
			$rn = $this->input->post('request_number', true);
			echo json_encode($this->M_penyerahan->cekudatransactblm($rn));
		}
}
