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
		$this->load->model('JurnalPenilaian/M_cetakhasil');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
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

		//update table er.er_section
		$getL1 = $this->M_penilaiankinerja->listErSection('dev');
		$getL2 = $this->M_penilaiankinerja->listErSection('prod');
		
		for ($i=0; $i < count($getL1); $i++) { 
			if ($getL1[$i] != $getL2[$i]) {
				$id = $getL1[$i]['er_section_id'];
				$sc = empty($getL2[$i]['sort_code']) ? NULL:$getL2[$i]['sort_code'];
				$occ = empty($getL2[$i]['oracle_cost_code']) ? NULL:$getL2[$i]['oracle_cost_code'];
				$arr = array(
					'section_code' => $getL2[$i]['section_code'],
					'department_name' => $getL2[$i]['department_name'],
					'field_name' => $getL2[$i]['field_name'],
					'unit_name' => $getL2[$i]['unit_name'],
					'section_name' => $getL2[$i]['section_name'],
					'job_name' => $getL2[$i]['job_name'],
					'worker_group' => $getL2[$i]['worker_group'],
					'sort_code' => $sc,
					'oracle_cost_code' => $occ,
					);
				$up = $this->M_penilaiankinerja->updateErSeksi($arr, $id);
			}
		}
		// exit();

		$get_wk 	= $this->M_penilaiankinerja->get_worker($st,$end);
		
		foreach ($get_wk as $gw) 
		{
			if (!empty($gw['lokerja2'])) {
				$lokerja = $gw['lokerja2'];
			}else{
				$lokerja = $gw['lokerja'];
			}
			if (!empty($gw['seksi_lama'])) {
				$ex = explode(',', ($gw['seksi_lama']));
				$gw['dept'] = $ex[0];
				$gw['bidang'] = $ex[1];
				$gw['unit'] = $ex[2];
				$gw['seksi'] = $ex[3];
			}

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
								'lokasi_kerja'				=> $lokerja
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
								'lokasi_kerja'				=> $lokerja
							);
				$this->M_penilaiankinerja->insert_worker($insert);
			}
		}
		// exit();
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

		$pr = $this->M_cetakhasil->getPr($periode)->row_array();
		$peny = $this->M_cetakhasil->get_penyesuaian();
		$lnoind = implode("', '", array_column($daftarEvaluasiSeksi, 'noind'));
		$arrMutasi = $this->M_cetakhasil->getlmutasi($lnoind, $pr['periode_awal'], $pr['periode_akhir']);
		$arrKenaikan = $this->M_cetakhasil->getlkenaikan($lnoind, $periode);
		$arrKenaikan = array_column($arrKenaikan, 'nominal_kenaikan', 'noind');

		for ($i=0; $i < count($arrMutasi); $i++) {
			$id = $arrMutasi[$i]['noind'];
			if (isset($arrKenaikan[$id])) {
				$arrMutasi[$i]['kenaikan'] = $arrKenaikan[$id];
			}else{
				$arrMutasi[$i]['kenaikan'] = 0;
			}
		}
		// echo "<pre>";
		// print_r($arrData);exit();

		$diffPr = (date_diff(date_create($pr['periode_awal']),date_create($pr['periode_akhir']))->format("%a")+1);

		for ($i=0; $i < count($arrMutasi); $i++) { 
			$tglarr = explode(',', $arrMutasi[$i]['tglberlaku']);
			$lmarr = explode(',', $arrMutasi[$i]['lokasilm']);
			$lbarr = explode(',', $arrMutasi[$i]['lokasibr']);

			$indexmin = $pr['periode_awal'];
			$indexlast = $pr['periode_akhir'];
			$uang = $arrMutasi[$i]['kenaikan'];
			$uanglast = 0;
			for ($x=0; $x < count($tglarr); $x++) {
				if ($lbarr[$x] == '02') {
					$minbr = $peny['tuksono'];
				}elseif ($lbarr[$x] == '03') {
					$minbr = $peny['mlati'];
				}else{
					$minbr = 0;
				}

				if ($lmarr[$x] == '02') {
					$minlm = $peny['tuksono'];
				}elseif ($lmarr[$x] == '03') {
					$minlm = $peny['mlati'];
				}else{
					$minlm = 0;
				}

				if ($x == 0) {
					//jika di 0 gunakan min lokasi lama
					$uanglast += (date_diff(date_create($pr['periode_awal']),date_create($tglarr[$x]))->format("%a")+1)/$diffPr*($uang-$minlm);
				}else{
					$uanglast += date_diff(date_create($tglarr[$x-1]),date_create($tglarr[$x]))->format("%a")/$diffPr*($uang-$minlm);
				}

				//untuk terakhir
				if ($x == count($tglarr)-1) {
					$uanglast += date_diff(date_create($pr['periode_akhir']),date_create($tglarr[$x]))->format("%a")/$diffPr*($uang-$minbr);
				}
				// echo $uanglast.'<br>';
			}

			// $uang+=$uanglast;

			$arrMutasi[$i]['kenaikan'] = round($uanglast);
		}

		$arrmutnoind = array_column($arrMutasi, 'noind');

		for ($i=0; $i < count($daftarEvaluasiSeksi); $i++) { 
			if (array_search($daftarEvaluasiSeksi[$i]['noind'], $arrmutnoind) !== false) {
				$daftarEvaluasiSeksi[$i]['naik'] = $arrMutasi[array_search($daftarEvaluasiSeksi[$i]['noind'], $arrmutnoind)]['kenaikan'];				
			}
			$daftarEvaluasiSeksi[$i]['gpbaru'] = $daftarEvaluasiSeksi[$i]['naik']+$daftarEvaluasiSeksi[$i]['gpnaik'];
		}
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
