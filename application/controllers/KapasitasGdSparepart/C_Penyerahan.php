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
			redirect('index');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Penyerahan SPB/DO';
		$data['Menu'] = 'Penyerahan SPB/DO';
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
			}
		}
		// echo "<pre>";print_r($coba);exit();
		
		$data['cetak'] = $coba;

		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','f4', 0, '', 1, 1, 3, 1, 10, 10);
		$filename 	= 'penyerahan-paket.pdf';
		$x = 0;
		foreach ($coba as $key => $val) {
			$data['data'] = $val;
			$data['urut'] = $x;
			$data['eks'] = $key;
			// $head 	= $this->load->view('KapasitasGdSparepart/V_Headpdf', $data, true);	
			$html 	= $this->load->view('KapasitasGdSparepart/V_PdfPenyerahan', $data, true);	
			// $footer = $this->load->view('KapasitasGdSparepart/V_Footerpdf', $data, true);
			
		ob_end_clean();
		// $pdf->SetHTMLHeader($head);
		// $pdf->SetHTMLFooter($footer);
		$pdf->WriteHTML($html);												
		// $pdf->debug = true; 
		$x++;
		}	
		$pdf->Output($filename, 'I');
			// echo "<pre>";print_r($data['exs']);exit();


	}

}
