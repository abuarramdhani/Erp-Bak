<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);

class C_JurnalPenilaianPersonalia extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_penilaiankinerja');
		$this->load->model('JurnalPenilaian/M_unitgroup');
		$this->load->model('JurnalPenilaian/M_kenaikan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
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
		$data['action'] = site_url().'PenilaianKinerja/JurnalPenilaianPersonalia/create';

		$data['periodicaly'] = $this->M_penilaiankinerja->list_periode();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Index',$data);
		$this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('success_delete');
	}

	//HALAMAN CREATE
	public function create(){
		// print_r($_POST);exit();
		$periode 	= $this->input->post('txtPeriode',true);

		$periode 		= 	explode(' - ', $periode);
		$periodeAwal  	= 	$periode[0];
		$periodeAkhir 	= 	$periode[1];

		$st 							= 	$periodeAwal;
		$end 							=	$periodeAkhir;

		$get_wk 	= $this->M_penilaiankinerja->get_worker($st,$end);
		// echo "<pre>";
		// print_r($get_wk);exit();
		foreach ($get_wk as $gw) 
		{
			$check = $this->M_penilaiankinerja->check($st, $end, $gw['noind']);
			if($check>0)
			{
				$update = 	array(
								'nama' 						=> $gw['nama'],
								't_tim' 					=> $gw['point'],
								't_sp'	 					=> $gw['sp'],
								'kodesie' 					=> $gw['kodesie'],
								'total_hari_sk'				=> $gw['total_hari_sk'],
								'total_bulan_sk'			=> $gw['total_bulan_sk'],
								'gol_kerja' 				=> $gw['golkerja'],
								'last_action_timestamp'		=> $this->general->ambilWaktuEksekusi(),
								'nama_departemen'			=> $gw['dept'],
								'nama_bidang'				=> $gw['bidang'],
								'nama_unit'					=> $gw['unit'],
								'nama_seksi'				=> $gw['seksi'],
								'lokasi_kerja'				=> $gw['lokerja']
							);
				$where =	array(
								'noind' 		=>	$gw['noind'],
								'periode_awal' 	=>	$st,
								'periode_akhir'	=>	$end,
							);
				$this->M_penilaiankinerja->update_worker($where,$update);
			}
			else
			{
				$insert =	array(
								'noind' 					=> $gw['noind'],
								'nama' 						=> $gw['nama'],
								't_tim' 					=> $gw['point'],
								't_sp' 						=> $gw['sp'],
								'kodesie' 					=> $gw['kodesie'],
								'total_hari_sk'				=> $gw['total_hari_sk'],
								'total_bulan_sk'			=> $gw['total_bulan_sk'],
								'periode_awal' 				=> $st,
								'periode_akhir'				=> $end,
								'periode'					=> date('Ym', strtotime($st)).'-'.date('Ym', strtotime($end)),
								'gol_kerja' 				=> $gw['golkerja'],
								'last_action_timestamp'		=> $this->general->ambilWaktuEksekusi(),
								'creation_timestamp'		=> $this->general->ambilWaktuEksekusi(),
								'nama_departemen'			=> $gw['dept'],
								'nama_bidang'				=> $gw['bidang'],
								'nama_unit'					=> $gw['unit'],
								'nama_seksi'				=> $gw['seksi'],
								'lokasi_kerja'				=> $gw['lokerja']
							);
				$this->M_penilaiankinerja->insert_worker($insert);
			}
		}

		$this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
			 "success_insert" => 1
		);
		$this->session->set_userdata($ses);
		redirect('PenilaianKinerja/JurnalPenilaianPersonalia');
	}


	public function view($periode){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['unit_group'] = $this->M_penilaiankinerja->load_unit_group_details();
		$data['assessment'] = $this->M_penilaiankinerja->load_assessment_by_periode($periode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/JurnalPenilaian/V_View',$data);
		$this->load->view('V_Footer',$data);
	}

	function delete(){
		$periode = $this->input->post('periodeJurnalPernilaian');
		$this->M_penilaiankinerja->deletejurnalpenilaian($periode);
		$this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
			 "success_delete" => 1
		);
		$this->session->set_userdata($ses);
		redirect('PenilaianKinerja/JurnalPenilaianPersonalia');
	}

	public function exportFormSeksi($periode)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		// $daftarGolonganKerja 	=	$this->M_kenaikan->ambilGolonganKerja();
		$daftarUnitGroup		=	$this->M_penilaiankinerja->ambilDaftarUnitGroup();
		$daftarEvaluasiSeksi 	=	$this->M_penilaiankinerja->ambilDaftarEvaluasiSeksi($periode);
		$daftarSeksiPenilaian	=	$this->M_penilaiankinerja->ambilDaftarSeksiPenilaian();
		$ambilPeriode 			=	$this->M_penilaiankinerja->ambilPeriode($periode);
		$data['periodeAwal']  	=	date('d-m-Y', strtotime($ambilPeriode[0]['periode_awal']));
		$data['periodeAkhir'] 	=	date('d-m-Y', strtotime($ambilPeriode[0]['periode_akhir']));
		$data['daftarEvaluasiSeksi']	=	$this->M_penilaiankinerja->ambilDaftarEvaluasiSeksi($periode);

		$daftarUnitPenilaian 	=	$this->M_penilaiankinerja->ambilDaftarUnitPenilaian($ambilPeriode[0]['periode_akhir']);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 11, "timesnewroman", 10, 7.5, 10, 20, 10, 10, 'P');

		$filename	=	'PenilaianKinerja-FormSeksi-'.$data['periodeAwal'].'-'.$data['periodeAkhir'].'.pdf';

	
		foreach ($daftarUnitPenilaian as $unitPenilaian) 
		{
			$golonganKerjaPerUnit	=	$this->M_penilaiankinerja->ambilGolonganKerjaPerUnit($unitPenilaian['kode_unit'], $ambilPeriode[0]['periode_akhir']);

			foreach ($golonganKerjaPerUnit as $golonganKerja) 
			{			
				// $data['seksi']					=	$seksiPenilaian['kodesie'];
				// $data['namaSeksi'] 				=	$seksiPenilaian['seksi'];
				$data['namaUnit']				=	$unitPenilaian['nama_unit'];
				$data['unit']					=	$unitPenilaian['kode_unit'];
				$data['golonganKerja']			=	$golonganKerja['golkerja'];
				$pdf->AddPage();
				$header 	=	$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Export_Form_Penilaian_Seksi_Header', $data, true);
				$body 		= 	$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Export_Form_Penilaian_Seksi', $data, true);
				$footer 	=	$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Export_Form_Penilaian_Seksi_Footer', $data, true);
				$pageFooter	=	$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Export_Form_Penilaian_Seksi_PageNumberFooter', $data, true);

				$pdf->SetHTMLFooter($pageFooter, '', true);
				$pdf->WriteHTML($header);
				$pdf->WriteHTML($body);
				$pdf->WriteHTML($footer);
				$data['no1']++;			
			}
		}

	

		$pdf->Output($filename, 'I');

	}

	public function exportExcelNilai($periode)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		// $daftarUnitGroup		=	$this->M_penilaiankinerja->ambilDaftarUnitGroup();
		$daftarEvaluasiSeksi 	=	$this->M_penilaiankinerja->ambilDataExportExcel($periode);
		$ambilPeriode 			=	$this->M_penilaiankinerja->ambilPeriode($periode);
		// $jumlahGolongan 		=	$this->M_unitgroup->ambilJumlahGolongan();
		// $jumlahGolongan 		=	$jumlahGolongan[0]['jumlah_golongan'];
		$data['periodeAwal']  	=	date('d-m-Y', strtotime($ambilPeriode[0]['periode_awal']));
		$data['periodeAkhir'] 	=	date('d-m-Y', strtotime($ambilPeriode[0]['periode_akhir']));

		$data['Title'] 	=	'Report Penilaian';
		$data['Menu'] = 'Jurnal Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['daftarEvaluasiSeksi']	=	$daftarEvaluasiSeksi;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/JurnalPenilaian/V_ReportNilai',$data);
		$this->load->view('V_Footer',$data);	
	}

	public function analisaGolongan($periode)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Jurnal Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $unitGroup 				=	$this->M_unitgroup->ambilNamaUnitGroup();
		$golonganKerja 			=	$this->M_kenaikan->ambilGolonganKerja();
		$jumlahGolongan 		= 	$this->M_unitgroup->ambilJumlahGolongan();
		$jumlahGolongan 		=	$jumlahGolongan[0]['jumlah_golongan'];

		$penggolonganRencana	=	array();
		$penggolonganHasil		=	array();


		for ($a = 0; $a < count($golonganKerja); $a++) 
		{ 
			for ($b = 0; $b < $jumlahGolongan ; $b++) 
			{
				$totalPekerjaRencana 			=	$this->M_penilaiankinerja->ambilTotalPekerjaGolonganRencana($golonganKerja[$a]['golkerja'], ($b+1));
				$penggolonganRencana[$a][$b] 	=	$totalPekerjaRencana;

				$totalPekerjaHasil 				=	$this->M_penilaiankinerja->ambilTotalPekerjaGolonganHasil($golonganKerja[$a]['golkerja'], ($b+1), $periode);
				$penggolonganHasil[$a][$b] 		=	$totalPekerjaHasil;
			}
		}

		// $data['unitGroup'] 				=	$unitGroup;
		$data['golonganKerja']			=	$golonganKerja;
		$data['jumlahGolongan']			=	$jumlahGolongan;
		$data['penggolonganRencana']	=	$penggolonganRencana;
		$data['penggolonganHasil']		=	$penggolonganHasil;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/JurnalPenilaian/V_AnalisaPenggolongan',$data);
		$this->load->view('V_Footer',$data);		
	}
	
}
