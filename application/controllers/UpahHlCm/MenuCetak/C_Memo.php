<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Memo extends CI_Controller {

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
		$this->load->view('UpahHlCm/MenuCetak/V_Memo',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function cetakpdf()
	{
		$this->load->library('pdf');
		$data['nmr_memo'] = $this->input->post('nmr_memo');

		$data['periode'] = $this->input->post('periode');
		$periodew = explode(' - ', $data['periode']);
		$tanggalawal = date('Y-m-d',strtotime($periodew[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periodew[1]));

		$tgl = date('F-Y',strtotime($tanggalawal));
		$noind = "";

		$kom = $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$noind);
		$nom = $this->M_prosesgaji->ambilNominalGaji();

		$total_p_ktukang ="";
		$total_p_tukang ="";
		$total_p_serabutan ="";
		$total_p_tenaga ="";
		$total_t_ktukang ="";
		$total_t_tukang ="";
		$total_t_serabutan ="";
		$total_t_tenaga ="";
		foreach ($kom as $key) {
			$gpokok = $key['gpokok'];
			$um = $key['um'];
			$lembur = $key['lembur'];
			for ($i=0; $i < 8; $i++) { 
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
					$nominalgpokok = $nom[$i]['nominal'];
				}
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
					$nominalum = $nom[$i]['uang_makan'];
				}
			}
			
			$gajipokok = $gpokok*$nominalgpokok;
			$uangmakan = $um*$nominalum;
			$gajilembur = $lembur*($nominalgpokok/7);
			$total = $gajipokok+$gajilembur+$uangmakan;
			if ($key['lokasi_kerja'] == '01') {
				if ($key['pekerjaan'] == 'KEPALA TUKANG') {
					$total_p_ktukang = $total_p_ktukang+$total;
				}
				if ($key['pekerjaan'] == 'TUKANG') {
					$total_p_tukang = $total_p_tukang+$total;
				}
				if ($key['pekerjaan'] == 'SERABUTAN') {
					$total_p_serabutan = $total_p_serabutan+$total;
				}
				if ($key['pekerjaan'] == 'TENAGA') {
					$total_p_tenaga = $total_p_tenaga+$total;
				}
			}
			if ($key['lokasi_kerja'] == '02') {
				if ($key['pekerjaan'] == 'KEPALA TUKANG') {
					$total_t_ktukang = $total_t_ktukang+$total;
				}
				if ($key['pekerjaan'] == 'TUKANG') {
					$total_t_tukang = $total_t_tukang+$total;
				}
				if ($key['pekerjaan'] == 'SERABUTAN') {
					$total_t_serabutan = $total_t_serabutan+$total;
				}
				if ($key['pekerjaan'] == 'TENAGA') {
					$total_t_tenaga = $total_t_tenaga+$total;
				}
			}
		}
		$total_pusat = $total_p_ktukang+$total_p_tukang+$total_p_serabutan+$total_p_tenaga;
		$total_tuksono = $total_t_ktukang+$total_t_tukang+$total_t_serabutan+$total_t_tenaga;
		$totalsemua = $total_pusat+$total_tuksono;
		$data['total'] = array(
								'p_ktukang' => $total_p_ktukang,
								'p_tukang' => $total_p_tukang,
								'p_serabutan' => $total_p_serabutan,
								'p_tenaga' => $total_p_tenaga,
								't_ktukang' => $total_t_ktukang,
								't_tukang' => $total_t_tukang,
								't_serabutan' => $total_t_serabutan,
								't_tenaga' => $total_t_tenaga,
								'total_p' => $total_pusat,
								'total_t' => $total_tuksono,
								'total_semua' => $totalsemua,
							);
		// echo "<pre>";
		// print_r($data['total']);
		// exit();

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'F4', 8, '', 12, 15, 15, 15, 10, 20);
		$filename = 'Memo-'.$tgl.'.pdf';

		$html = $this->load->view('UpahHlCm/MenuCetak/V_cetakMemo', $data, true);

		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'D');


	}
}
