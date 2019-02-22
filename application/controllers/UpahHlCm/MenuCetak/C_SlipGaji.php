<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
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
		if ($noind == null) {
			$pnoind = "";
		}else{
			$pnoind = "AND tp.noind='$noind'";
		};
		$tgl = date('F-Y',strtotime($periodew[0]));
		$data['kom'] = $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$pnoind);
		$data['nom'] = $this->M_prosesgaji->ambilNominalGaji();

		$kom 	= $data['kom'];
		$nom 	= $data['nom'];
		$row 	= 0;
		$total_semua = 0;
		foreach ($kom as $key) {

			$gpokok  = $key['gpokok'];
			$um		 = $key['um'];
			$lembur  = $key['lembur'];
			$cekUbahPekerjaan = $this->M_prosesgaji->getUbahPekerjaan($key['noind'],$key['kdpekerjaan'],$tanggalawal,$tanggalakhir,'cek');
			if ($cekUbahPekerjaan == 1) {
				$tanggalPerubahan = $this->M_prosesgaji->getUbahPekerjaan($key['noind'],$key['kdpekerjaan'],$tanggalawal,$tanggalakhir,'tanggal');
				
				foreach ($tanggalPerubahan as$val) {
					$dataPerubahanSebelum = $this->M_prosesgaji->getNominalPerubahan($tanggalawal,$val['tanggal_akhir_berlaku'],$key['noind']);
					for ($i=0; $i < 8; $i++) { 
						if ($val['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $val['kode_pekerjaan2']==$nom[$i]['kode_pekerjaan']) {
							$nominalgpokok = $nom[$i]['nominal'];
						}
						if ($val['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
							$nominalum = $nom[$i]['uang_makan'];
						}
					}
					foreach ($dataPerubahanSebelum as $value) {
						$gajipokok1 	= $value['gpokok']*$nominalgpokok;
						$uangmakan1 	= $value['um']*$nominalum;
						$gajilembur1 	= $value['lembur']*($nominalgpokok/7);
						$total 			= $gajipokok1+$gajilembur1+$uangmakan1;
						$data['res'][$row]['gp1'] = $value['gpokok'];
						$data['res'][$row]['nomgp1'] = $nominalgpokok;
						$data['res'][$row]['um1'] = $value['um'];
						$data['res'][$row]['nomum1'] = $nominalum;
						$data['res'][$row]['lmbr1'] = $value['lembur'];
						$data['res'][$row]['nomlmbr1'] = $nominalgpokok/7;

					}
					$dataPerubahanSesudah = $this->M_prosesgaji->getNominalPerubahan($val['tanggal_mulai_berlaku'],$tanggalakhir,$key['noind']);
					for ($i=0; $i < 8; $i++) { 
						if ($val['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $val['kode_pekerjaan']==$nom[$i]['kode_pekerjaan']) {
							$nominalgpokok = $nom[$i]['nominal'];
						}
						if ($val['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
							$nominalum = $nom[$i]['uang_makan'];
						}
					}
					foreach ($dataPerubahanSesudah as $value) {
						$gajipokok2 	= $value['gpokok']*$nominalgpokok;
						$uangmakan2 	= $value['um']*$nominalum;
						$gajilembur2 = $value['lembur']*($nominalgpokok/7);
						$total 		+= $gajipokok2+$gajilembur2+$uangmakan2;
						$gajipokok 	= $gajipokok1+$gajipokok2;
						$uangmakan 	= $uangmakan1+$uangmakan2;
						$gajilembur = $gajilembur1+$gajilembur2;
						$gajilembur = number_format($gajilembur,'0','.','');
						$total 		= number_format($total,'0','.','');
						$data['res'][$row]['gp2'] = $value['gpokok'];
						$data['res'][$row]['nomgp2'] = $nominalgpokok;
						$data['res'][$row]['um2'] = $value['um'];
						$data['res'][$row]['nomum2'] = $nominalum;
						$data['res'][$row]['lmbr2'] = $value['lembur'];
						$data['res'][$row]['nomlmbr2'] = $nominalgpokok/7;
					}
				}
			}else{
				for ($i=0; $i < 8; $i++) { 
					if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
						$nominalgpokok = $nom[$i]['nominal'];
					}
					if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
						$nominalum = $nom[$i]['uang_makan'];
					}
				}

				$gajipokok 	= $gpokok*$nominalgpokok;
				$uangmakan 	= $um*$nominalum;
				$gajilembur = $lembur*($nominalgpokok/7);
				$gajilembur = number_format($gajilembur,'0','.','');
				$total 		= $gajipokok+$gajilembur+$uangmakan;
				$total 		= number_format($total,'0','.','');
				$data['res'][$row]['gp'] = $gpokok;
				$data['res'][$row]['nomgp'] = $nominalgpokok;
				$data['res'][$row]['um'] = $um;
				$data['res'][$row]['nomum'] = $nominalum;
				$data['res'][$row]['lmbr'] = $lembur;
				$data['res'][$row]['nomlmbr'] = $nominalgpokok/7;
			}

			$data['res'][$row]['lokasi_kerja'] = $key['lokasi_kerja'];
			$data['res'][$row]['noind'] = $key['noind'];
			$data['res'][$row]['nama'] = $key['nama'];
			$data['res'][$row]['pekerjaan'] = $key['pekerjaan'];
			$data['res'][$row]['total_terima'] = $total;
			
			$row++;
		}

		// echo "<pre>";
		// print_r($data['res']);exit();
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A5-L', 8, '', 5, 5, 5, 15, 10, 20);
		$filename = 'Slip_gaji-'.$tgl.'.pdf';

		$html = $this->load->view('UpahHlCm/MenuCetak/V_cetakSlip', $data, true);

		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'D');


	}
}
