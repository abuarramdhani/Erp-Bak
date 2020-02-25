<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class C_SlipGaji extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_cetakdata');
		$this->load->model('UpahHlCm/M_prosesgaji');
		  
		// if($this->session->userdata('logged_in')!=TRUE) {
		// 	$this->load->helper('url');
		// 	$this->session->set_userdata('last_page', current_url());
		// 		  //redirect('index');
		// 	$this->session->set_userdata('Responsbility', 'some_value');
		// }
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGaji();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MenuCetak/V_SlipGaji',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	public function ambilPekerja()
	{
		$p = strtoupper($this->input->get('term'));
		$data = $this->M_cetakdata->ambilPekerja($p);

		echo json_encode($data);
	}
	public function cetakpdf()
	{
		$this->load->library('pdf');

		$data['periode'] = $this->input->post('periode');
		$periodew = explode(' - ', $data['periode']);
		$tanggalawal = date('Y-m-d',strtotime($periodew[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periodew[1]));
		$noind = $this->input->post('noindPekerja');
		$status = $this->input->post('statusPekerja');
		$tgl = date('F-Y',strtotime($periodew[0]));

		$data['kom'] = $this->M_prosesgaji->getHlcmSlipGajiPrint($tanggalawal,$tanggalakhir,$noind,$status);
		// echo "<pre>";print_r($data['kom']);exit();
		$data['nom'] = $this->M_prosesgaji->ambilNominalGaji();
		$data['potongan_tambahan'] = $this->M_cetakdata->ambilPotTam($tanggalawal,$tanggalakhir);
		$data['potongan_tambahan_detail'] = $this->M_cetakdata->ambilPotTam_detail($tanggalawal,$tanggalakhir);

		$kom 	= $data['kom'];
		$nom 	= $data['nom'];
		$row 	= 0;
		$total_semua = 0;
		$data['res'] = array();
		foreach ($kom as $key) {
			$cek_puasa = $this->M_prosesgaji->cekPuasa($key['noind']);
			if ($key['status_perubahan'] == 't' or $key['status_perubahan'] == 'true') {
				$data_detail = $this->M_prosesgaji->getProsesDetail($key['periode'],$key['noind']);
				$xx = 1;
				foreach ($data_detail as$val) {
					for ($i=0; $i < 8; $i++) { 
						if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kode_pekerjaan']==$nom[$i]['kode_pekerjaan']) {
							$nominalgpokok = $nom[$i]['nominal'];
						}
						if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
							$nominalum = $nom[$i]['uang_makan'];
							$nominalump = $nom[$i]['uang_makan_puasa'];
						}
					}
					$data['res'][$row]['gp'.$xx] = $val['jml_gp'];
					$data['res'][$row]['nomgp'.$xx] = $nominalgpokok;
					$data['res'][$row]['um'.$xx] = $val['jml_um'];
					$data['res'][$row]['nomum'.$xx] = $nominalum;
					$data['res'][$row]['ump'.$xx] = $val['jml_ump'];
					if ($cek_puasa > 0) {
						$data['res'][$row]['nomump'.$xx] = $nominalump;
					}else{
						$data['res'][$row]['nomump'.$xx] = $nominalum;
					}
					$data['res'][$row]['lmbr'.$xx] = $val['jml_lbr'];
					$data['res'][$row]['nomlmbr'.$xx] = $nominalgpokok/7;
					$xx++;
				}
			}else{
				for ($i=0; $i < 8; $i++) { 
					if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kode_pekerjaan']==$nom[$i]['kode_pekerjaan']) {
						$nominalgpokok = $nom[$i]['nominal'];
					}
					if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
						$nominalum = $nom[$i]['uang_makan'];
						$nominalump = $nom[$i]['uang_makan_puasa'];
					}
				}

				$data['res'][$row]['gp'] = $key['jml_gp'];
				$data['res'][$row]['nomgp'] = $nominalgpokok;
				$data['res'][$row]['um'] = $key['jml_um'];
				$data['res'][$row]['nomum'] = $nominalum;
				$data['res'][$row]['ump'] = $key['jml_ump'];
				if ($cek_puasa > 0) {
					$data['res'][$row]['nomump'] = $nominalump;
				}else{
					$data['res'][$row]['nomump'] = $nominalum;
				}
				$data['res'][$row]['lmbr'] = $key['jml_lbr'];
				$data['res'][$row]['nomlmbr'] = $nominalgpokok/7;
			}

			$data['res'][$row]['lokasi_kerja'] = $key['lokasi_kerja'];
			$data['res'][$row]['noind'] = $key['noind'];
			$data['res'][$row]['nama'] = $key['nama'];
			$data['res'][$row]['pekerjaan'] = $key['pekerjaan'];
			$data['res'][$row]['total_terima'] = $key['total_bayar'];
			$data['res'][$row]['tambahan'] = 0;
			$data['res'][$row]['tambahan_gp'] = 0;
			$data['res'][$row]['tambahan_lembur'] = 0;
			$data['res'][$row]['tambahan_um'] = 0;
			$data['res'][$row]['tambahan_gp_per_a'] = 0;
			$data['res'][$row]['tambahan_lembur_per_a'] = 0;
			$data['res'][$row]['tambahan_um_per_a'] = 0;
			$data['res'][$row]['tambahan_gp_total'] = 0;
			$data['res'][$row]['tambahan_lembur_total'] = 0;
			$data['res'][$row]['tambahan_um_total'] = 0;
			$data['res'][$row]['potongan'] = 0;
			$data['res'][$row]['potongan_gp'] = 0;
			$data['res'][$row]['potongan_lembur'] = 0;
			$data['res'][$row]['potongan_um'] = 0;
			$data['res'][$row]['potongan_gp_per_a'] = 0;
			$data['res'][$row]['potongan_lembur_per_a'] = 0;
			$data['res'][$row]['potongan_um_per_a'] = 0;
			$data['res'][$row]['potongan_gp_total'] = 0;
			$data['res'][$row]['potongan_lembur_total'] = 0;
			$data['res'][$row]['potongan_um_total'] = 0;

			if(!empty($data['potongan_tambahan'])){

				foreach ($data['potongan_tambahan'] as $pot_tam) {
					if($key['noind'] == $pot_tam['noind']){
						$data['res'][$row]['total_terima'] += $pot_tam['total_gp'] + $pot_tam['total_um'] + $pot_tam['total_lembur'];
					}
				}

				foreach ($data['potongan_tambahan_detail'] as $pot_tam_detail) {
					if($key['noind'] == $pot_tam_detail['noind']){
						if($pot_tam_detail['sumber'] == 'tambahan'){
							$data['res'][$row]['tambahan'] = 1;
							$data['res'][$row]['tambahan_gp'] += $pot_tam_detail['gp'];
							$data['res'][$row]['tambahan_lembur'] += $pot_tam_detail['lembur'];
							$data['res'][$row]['tambahan_um'] += $pot_tam_detail['um'];
							$data['res'][$row]['tambahan_gp_per_a'] = $pot_tam_detail['gp_perhari'];
							$data['res'][$row]['tambahan_lembur_per_a'] = $pot_tam_detail['lembur_perjam'];
							$data['res'][$row]['tambahan_um_per_a'] = $pot_tam_detail['um_perhari'];
							$data['res'][$row]['tambahan_gp_total'] += $pot_tam_detail['nominal_gp'];
							$data['res'][$row]['tambahan_lembur_total'] += $pot_tam_detail['nominal_lembur'];
							$data['res'][$row]['tambahan_um_total'] += $pot_tam_detail['nominal_um'];
						}else{
							$data['res'][$row]['potongan'] = 1;
							$data['res'][$row]['potongan_gp'] += $pot_tam_detail['gp'];
							$data['res'][$row]['potongan_lembur'] += $pot_tam_detail['lembur'];
							$data['res'][$row]['potongan_um'] += $pot_tam_detail['um'];
							$data['res'][$row]['potongan_gp_per_a'] = $pot_tam_detail['gp_perhari'];
							$data['res'][$row]['potongan_lembur_per_a'] = $pot_tam_detail['lembur_perjam'];
							$data['res'][$row]['potongan_um_per_a'] = $pot_tam_detail['um_perhari'];
							$data['res'][$row]['potongan_gp_total'] += $pot_tam_detail['nominal_gp'];
							$data['res'][$row]['potongan_lembur_total'] += $pot_tam_detail['nominal_lembur'];
							$data['res'][$row]['potongan_um_total'] += $pot_tam_detail['nominal_um'];
						}
						
					}
				}
				
			}

			$row++;
		}

		// echo "<pre>";
		// print_r($data['res']);exit();
		$pdf = $this->pdf->load();
		//$pdf = new mPDF('utf-8', 'A5-L', 8, '', 5, 5, 5, 15, 10, 20);
		$pdf = new mPDF('utf-8' , array(215,140),8,'', 7, 7, 0, 0, 0,0);
				
		$filename = 'Slip_gaji-'.$tgl.'.pdf';
		// $this->load->view('UpahHlCm/MenuCetak/V_cetakSlip', $data);
		$html = $this->load->view('UpahHlCm/MenuCetak/V_cetakSlip', $data, true);

		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');


	}
}
