<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);
class C_splseksi extends CI_Controller {
	function __construct() {
        parent::__construct();

        $this->load->library('session');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		date_default_timezone_set('Asia/Jakarta');
    }

    public function checkSession(){
		if($this->session->is_logged){
			// any
		}else{
			redirect('');
		}
	}

    public function menu($a, $b, $c){
    	$this->checkSession();
    	$user_id = $this->session->userid;

		$data['Menu'] = $a;
		$data['SubMenuOne'] = $b;
		$data['SubMenuTwo'] = $c;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		return $data;
    }

    public function index(){
    	$this->checkSession();

		$this->session->sex = $this->M_splseksi->getSexEmployee($this->session->user);
		$data = $this->menu('', '', '');
		$data['responsibility_id'] = $this->session->responsibility_id;
		$data['jari'] = $this->M_splseksi->getJari($this->session->userid);

		$data['rekap_spl'] = $this->M_splseksi->getRekapSpl($this->session->user,'7');
		if ($this->session->spl_validasi_operator == TRUE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SPLSeksi/Seksi/Pusat/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$this->load->view('V_Header',$data);
			$this->load->view('SPLSeksi/Seksi/Pusat/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}

	}

	public function data_spl(){
		$data = $this->menu('', '', '');
		$data['lokasi'] = $this->M_splseksi->show_lokasi();
		if ($this->input->get('stat')) {
			$status = $this->input->get('stat');
			$data_spl = array();
			if ($status == 'Baru') {
				$show_list_spl = $this->M_splseksi->show_spl2('0%',$this->session->user,'7');
			}elseif ($status == 'Tolak') {
				$show_list_spl = $this->M_splseksi->show_spl2('2%',$this->session->user,'7');
			}else{
				$show_list_spl = $this->M_splseksi->show_spl2('%',$this->session->user,'7');
			}

			foreach($show_list_spl as $sls){
				$index = array();
				$btn_hapus = "";
				if ($sls['Status'] == '01' or $sls['Status'] == '31' or $sls['Status'] == '35') {
					$btn_hapus = "<a data-id='{$sls['ID_SPL']}' data-noind='{$sls['Noind']}' data-nama='{$sls['nama']}' onclick='deleteLembur($(this))' title='Hapus'><i class='fa fa-fw fa-trash'></i></a>";
				}
				$index[] = "<a href='".site_url('SPL/Pusat/EditLembur/'.$sls['ID_SPL'])."' title='Detail'><i class='fa fa-fw fa-search'></i></a>
					$btn_hapus";
				$index[] = $sls['Deskripsi']." ".$sls['User_']." (".$sls['user_approve'].")";
				$index[] = $sls['Tgl_Lembur'];
				$index[] = $sls['Noind'];
				$index[] = $sls['nama'];
				// $index[] = $sls['kodesie'];
				// $index[] = $sls['seksi'];
				$index[] = $this->convertUnOrderedlist($sls['Pekerjaan']);
				$index[] = $sls['nama_lembur'];
				$index[] = $sls['Jam_Mulai_Lembur'];
				$index[] = $sls['Jam_Akhir_Lembur'];
				$index[] = $sls['Break'];
				$index[] = $sls['Istirahat'];
				$index[] = $this->hitung_jam_lembur($sls['Noind'], $sls['Kd_Lembur'], $sls['Tgl_Lembur'], $sls['Jam_Mulai_Lembur'], $sls['Jam_Akhir_Lembur'], $sls['Break'], $sls['Istirahat']);
				$index[] = $this->convertUnOrderedlist($sls['target']);
				$index[] = $this->convertUnOrderedlist($sls['realisasi']);
				$index[] = $sls['alasan_lembur'];
				$index[] = $sls['Tgl_Berlaku'];

				$data_spl[] = $index;
			}
			$data['data'] = $data_spl;
		}
		// print_r($data['data']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/Pusat/V_data_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function hitung_jam_lembur($noind, $kode_lembur, $tgl, $mulai, $selesai, $break, $istirahat){ //latest 27/03/2020
		$shift = $this->M_splseksi->selectShift($noind, $tgl);
		$day   = date('w', strtotime($tgl));

		$hari_indo = "Minggu Senin Selasa Rabu Kamis Jumat Sabtu";
		$array_hari = explode(' ', $hari_indo);
		$bedaHari = strtotime($mulai) > strtotime($selesai) ? true : false;
		//--------------------core variable
		$KET  		= $this->M_splseksi->getKeteranganJamLembur($noind);
		// $JENIS_HARI	= $this->M_splseksi->getJenisHari($tgl, $noind); // useless, u can delete it
		$JENIS_HARI = $shift ? 'Biasa' : 'Libur';
		$HARI 		= $array_hari[$day];
		//-----------------------
		$treffjamlembur = $this->M_splseksi->treffjamlembur($KET, $JENIS_HARI, $HARI);

		//----cari berapa menit lemburnya
		$first = explode(':', $mulai);
		$second = explode(':', $selesai);

		if(count($first) == 1){
			$first[1] = 00;
		}

		if(count($second) == 1){
			$second[1] = 00;
		}

		$a = $first[0]*60+$first[1];
		$b = $second[0]*60+$second[1];

		if($a>$b){
		 	$zero = 24*60; // 1 day in minutes
		 	$z = $zero - $a;
		 	$lama_lembur = $z+$b;
		}else{
			$lama_lembur = $b-$a;
		}

		if($kode_lembur == '005'){
			$shiftmsk = strtotime($tgl." ".$shift->jam_msk);
			$shiftklr = strtotime($shift->jam_plg) < strtotime($shift->jam_msk) ? 
						strtotime('+1 day '.$tgl." ".$shift->jam_plg) : 
						strtotime($tgl." ".$shift->jam_plg);

			$jamshift = $shiftklr - $shiftmsk;
			$jamshift = $jamshift/60;
		 	$result = $lama_lembur-$jamshift;
		}else{
		 	$result = $lama_lembur;
		}
		//-----end cari menit lembur

		//-----------------------core variable
		$MENIT_LEMBUR = $result;
		//buat jaga jaga error
		$BREAK = $break == 'Y' ? 15 : 0;
		$ISTIRAHAT = $istirahat == 'Y' ? 45 : 0;

		$allShift = $this->M_splseksi->selectAllShift($tgl);

		if(!empty($allShift)){
			if ($istirahat == 'Y') { //jika pekerja memilih istirahat
				$ISTIRAHAT = 0;
				$distinct_start = [];

				foreach($allShift as $item){
					$rest_start = (strtotime($item['ist_mulai']) < strtotime($mulai)) ? strtotime('+1 day '.$tgl." ".$item['ist_mulai']) : strtotime($tgl." ".$item['ist_mulai']);
					$rest_end   = (strtotime($item['ist_selesai']) < strtotime($mulai)) ? strtotime('+1 day '.$tgl." ".$item['ist_selesai']) : strtotime($tgl." ".$item['ist_selesai']);

					// lembur datang pulang
					if( $kode_lembur == '005' 
						&& $rest_start >= $shiftmsk
						&& $rest_end <= $shiftklr
					  ) {
						continue;
					}

					if($rest_start == $rest_end){
						continue;
					}

					//biar jam break tidak terdouble
					if(in_array($rest_start, $distinct_start)){
						continue;
					}else{
						$distinct_start[] = $rest_start;
					}

					$overtime_start = strtotime($tgl." ".$mulai);
					$overtime_end   = (strtotime($mulai)  > strtotime($selesai)) ? strtotime('+1 day '.$tgl." ".$selesai) : strtotime($tgl." ".$selesai);

					if (($rest_start >= $overtime_start && $rest_end <= $overtime_end)) { // jika jam istirahat masuk range lembur
						$ISTIRAHAT = $ISTIRAHAT + 45;
					}else if($rest_start >= $overtime_start && $rest_end >= $overtime_end && $rest_start <= $overtime_end){
						$ISTIRAHAT = $ISTIRAHAT + (45 + ($overtime_end - $rest_end)/60);
					}
				}
			}
			
			if ($break == 'Y') { //jika pekerja memilih istirahat
				$BREAK = 0;
				$distinct_start = [];

				foreach($allShift as $item){
					$break_start = (strtotime($item['break_mulai']) < strtotime($mulai)) ? strtotime('+1 day '.$tgl." ".$item['break_mulai']) : strtotime($tgl." ".$item['break_mulai']);
					$break_end   = (strtotime($item['break_selesai']) < strtotime($mulai)) ? strtotime('+1 day '.$tgl." ".$item['break_selesai']) : strtotime($tgl." ".$item['break_selesai']);

					// lembur datang dan pulang
					if( $kode_lembur == '005' 
						&& $break_start >= $shiftmsk
						&& $break_end <= $shiftklr
					  ) {
						continue;
					}

					//jika tidak ada istirahat, lewati
					if($break_start == $break_end){
						continue;
					}

					//biar jam break tidak terdouble
					if(in_array($break_start, $distinct_start)){
						continue;
					}else{
						$distinct_start[] = $break_start;
					}

					$overtime_start = strtotime($tgl." ".$mulai);
					$overtime_end   = (strtotime($mulai)  > strtotime($selesai)) ? strtotime('+1 day '.$tgl." ".$selesai) : strtotime($tgl." ".$selesai);
				
					if ($break_start >= $overtime_start && $break_end <= $overtime_end) { // jika jam istirahat masuk range lembur
						$BREAK = $BREAK + 15;
					}else if($break_start >= $overtime_start && $break_end >= $overtime_end && $break_start <= $overtime_end){
						$BREAK = $BREAK + (15 + ($overtime_end - $break_end)/60);
					}
				}
			}
		}

		//----------------------
		$estimasi = 0;
		if(!empty($treffjamlembur)):
			$total_lembur = $MENIT_LEMBUR-($BREAK+$ISTIRAHAT);

			$i = 0;
			while($total_lembur > 0){
				$jml_jam = $treffjamlembur[$i]['jml_jam'] * 60;
				$pengali = $treffjamlembur[$i]['pengali'];

				if($total_lembur > $jml_jam){

					$estimasi = $estimasi + $jml_jam * $pengali/60;
					$total_lembur = $total_lembur - $jml_jam;
				}else{

					$estimasi = $estimasi + ($total_lembur * $pengali/60);
					$estimasi = number_format($estimasi,2);
					$total_lembur = 0;
				}
				$i++;
			}
		else:
			$estimasi = "tdk bisa diproses";
		endif;

		return $estimasi;
	}


	public function ajax_count_overtime(){
		$noind 	= $_REQUEST['noind'];
		$kd    	= $_REQUEST['type'];
		$tgl 	= $_REQUEST['date'];
		$start 	= $_REQUEST['start'];
		$end 	= $_REQUEST['end'];
		$break 	= $_REQUEST['isbreak'];
		$rest 	= $_REQUEST['isrest'];

		$overtime = $this->hitung_jam_lembur($noind, $kd, $tgl, $start, $end, $break, $rest);
		echo $overtime;
	}

	public function show_pekerja(){
		$this->checkSession();
		$key = $_GET['key'];
		$key2 = $_GET['key2'];
		$user = $this->session->user;

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data = $this->M_splseksi->show_pekerja($key, $key2, $akses_sie);
 		echo json_encode($data);
	}

	public function show_pekerja2(){
		$this->checkSession();
		$key = $_GET['key'];

		$data = $this->M_splseksi->show_pekerja2($key);
 		echo json_encode($data);
	}

	public function show_pekerja3(){
		$this->checkSession();
		$key = $_GET['key'];
		$key2 = $_GET['key2'];
		$noind = explode(".", $key2);
		$ni = "";
		foreach ($noind as $val) {
			if ($ni == "") {
				$ni .= "'$val'";
			}else{
				$ni .= ",'$val'";
			}

		}

		$user = $this->session->user;

		//get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'],0,7).'00');
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}
		$data = $this->M_splseksi->show_pekerja3($key,$ni,$akses_sie);

		//$data = $this->M_splseksi->show_pekerja4($key,$ni);//hanya pekerja 1 seksi
 		echo json_encode($data);
	}

	public function show_shift(){
		$this->checkSession();
		$key = $_GET['key'];
		$tgl = $_GET['key2'];
		$data = $this->M_splseksi->getShiftMemo($key,$tgl);
 		echo json_encode($data);
	}

	public function show_seksi(){
		$this->checkSession();
		$key = $_GET['key'];
		$key2 = $_GET['key2'];
		$user = $this->session->user;

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data = $this->M_splseksi->show_seksi($key, $key2, $akses_sie);
 		echo json_encode($data);
	}

	public function cut_kodesie($id){
		$this->checkSession();
		$z = 0;
		for($x=-1; $x>=-strlen($id); $x--){
			if(substr($id, $x, 1) == "0"){
				$z++;
			}else{
				break;
			}
		}

		$data = substr($id, 0, strlen($id)-$z);
		return $data;
	}

	public function data_spl_filter(){
		$this->checkSession();
		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data_spl = array();
		$show_list_spl = $this->M_splseksi->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie);
		foreach($show_list_spl as $sls){
			$index = array();
			$btn_hapus = "";
			if ($sls['Status'] == '01' or $sls['Status'] == '31' or $sls['Status'] == '35') {
				$btn_hapus = "<a data-id='{$sls['ID_SPL']}' data-noind='{$sls['Noind']}' data-nama='{$sls['nama']}' onclick='deleteLembur($(this))' title='Hapus'><i class='fa fa-fw fa-trash'></i></a>";
			}
			$index[] = "<a href='".site_url('SPL/Pusat/EditLembur/'.$sls['ID_SPL'])."' title='Detail'><i class='fa fa-fw fa-search'></i></a>
				$btn_hapus";
			$index[] = $sls['Deskripsi']." ".$sls['User_']." (".$sls['user_approve'].")";
			$index[] = $sls['Tgl_Lembur'];
			$index[] = $sls['Noind'];
			$index[] = $sls['nama'];
			// $index[] = $sls['kodesie'];
			// $index[] = $sls['seksi'];
			$index[] = $this->convertUnOrderedlist($sls['Pekerjaan']);
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['Jam_Mulai_Lembur'];
			$index[] = $sls['Jam_Akhir_Lembur'];
			$index[] = $sls['Break'];
			$index[] = $sls['Istirahat'];
			$index[] = $this->hitung_jam_lembur($sls['Noind'], $sls['Kd_Lembur'], $sls['Tgl_Lembur'], $sls['Jam_Mulai_Lembur'], $sls['Jam_Akhir_Lembur'], $sls['Break'], $sls['Istirahat']);
			$index[] = $this->convertUnOrderedlist($sls['target']);
			$index[] = $this->convertUnOrderedlist($sls['realisasi']);
			$index[] = $sls['alasan_lembur'];
			$index[] = $sls['Tgl_Berlaku'];

			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	function convertUnOrderedlist($data){
		//separator ; (semicolon)
		$item = explode(';', $data);
		$html = "<ul>";
			foreach($item as $key){
				$html .= "<li>$key</li>";
			}
		$html .= "</ul>";
		return $html;
	}

	public function data_spl_cetak(){
		$this->checkSession();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data['data_spl'] = $this->M_splseksi->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie);
		$filename = 'Surat Perintah Lembur.pdf';
		$pdf = new mPDF('','A4-L', 0, '', 5, 5, 5, 5);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));

		$pdf->WriteHTML($stylesheet,1);
		$html = $this->load->view('SPLSeksi/Seksi/Pusat/V_cetak_spl',$data, true);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}

	public function hapus_spl($idspl){
		$this->checkSession();
		$to_hapus = $this->M_splseksi->drop_spl($idspl);
		redirect(base_url('SPL/Pusat/ListLembur'));
	}

	public function edit_spl($idspl){
		$this->checkSession();
		$data = $this->menu('', '', '');
		$data['jenis_lembur'] = $this->M_splseksi->show_jenis_lembur();
		$data['lembur'] = $this->M_splseksi->show_current_spl('', '', '', $idspl);
		$data['result'] = $this->input->get('result');
		// echo "<pre>";print_r($data);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/Pusat/V_edit_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit_spl_submit(){ // not work, this is muda muda
		$this->checkSession();
		$user_id = $this->session->user;
		$tanggal = $this->input->post('tanggal_0');
		$tanggal = date_format(date_create($tanggal), "Y-m-d");
		$mulai = $this->input->post('waktu_0');
		$mulai = date_format(date_create($mulai), "H:i:s");
		$selesai = $this->input->post('waktu_1');
		$selesai = date_format(date_create($selesai), "H:i:s");
		$lembur = $this->input->post('kd_lembur');
		$istirahat = $this->input->post('istirahat');
		$break = $this->input->post('break');
		$pekerjaan = $this->input->post('pekerjaan');
		$noind = $this->input->post("noind[0]");
		$target = $this->input->post("target[0]");
		$realisasi = $this->input->post("realisasi[0]");
		$alasan = $this->input->post("alasan[0]");
		$spl_id = $this->input->post('id_spl');
		$old_spl = $this->M_splseksi->show_current_spl('', '', '', $spl_id);
		$noind_baru = $this->M_splseksi->getNoindBaru($noind);

		// Generate ID Riwayat
		$maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
		if(empty($maxid)){
			$splr_id = "0000000001";
		}else{
			$splr_id = $maxid->id;
			$splr_id = substr("0000000000", 0, 10-strlen($splr_id)).$splr_id;
		}

		// Insert data
		$log_ket = "";
		foreach($old_spl as $os){
			$log_ket = "Noind:".$os['Noind']."->".$noind.
				" Tgl:".date_format(date_create($os['Tgl_Lembur']), "Y-m-d")."->".$tanggal.
				" Kd:".$os['Kd_Lembur']."->".$lembur.
				" Jam:".date_format(date_create($os['Jam_Mulai_Lembur']), "H:i:s")."-".date_format(date_create($os['Jam_Akhir_Lembur']), "H:i:s")."->".$mulai."-".$selesai.
				" Break:".$os['Break']."->".$break.
				" Ist:".$os['Istirahat']."->".$istirahat."<br />";
		}

		$data_log = array(
			"wkt" => date('Y-m-d H:i:s'),
			"menu" => "Operator",
			"jenis" => "Ubah",
			"ket" => $log_ket,
			"noind" => $user_id);
		$to_log = $this->M_splseksi->save_log($data_log);

		$data_spl = array(
			"Tgl_Berlaku" => date('Y-m-d H:i:s'),
			"Tgl_Lembur" => $tanggal,
			"Noind" => $noind,
			"Noind_Baru" => $noind_baru,
			"Kd_Lembur" => $lembur,
			"Jam_Mulai_Lembur" => $mulai,
			"Jam_Akhir_Lembur" => $selesai,
			"Break" => $break,
			"Istirahat" => $istirahat,
			"Pekerjaan" => $pekerjaan,
			"Status" => "01",
			"User_" => $user_id,
			"target" => $target,
			"realisasi" => $realisasi,
			"alasan_lembur" => $alasan);
		$to_spl = $this->M_splseksi->update_spl($data_spl, $spl_id);

		$data_splr = array(
			"ID_Riwayat" => $splr_id,
			"ID_SPL" => $spl_id,
			"Tgl_Berlaku" => date('Y-m-d H:i:s'),
			"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
			"Tgl_Lembur" => $tanggal,
			"Noind" => $noind,
			"Noind_Baru" => $noind_baru,
			"Kd_Lembur" => $lembur,
			"Jam_Mulai_Lembur" => $mulai,
			"Jam_Akhir_Lembur" => $selesai,
			"Break" => $break,
			"Istirahat" => $istirahat,
			"Pekerjaan" => $pekerjaan,
			"Status" => "01",
			"User_" => $user_id,
			"Revisi" => "0",
			"Keterangan" => "(Ubah)",
			"target" => $target,
			"realisasi" => $realisasi,
			"alasan_lembur" => $alasan);
		$to_splr = $this->M_splseksi->save_splr($data_splr);

		redirect(base_url('SPL/Pusat/EditLembur/'.$spl_id.'?result=1'));
	}

	public function new_spl(){
		$this->checkSession();
		$data = $this->menu('', '', '');
		$data['jenis_lembur'] = $this->M_splseksi->show_jenis_lembur();
		$data['result'] = $this->input->get('result');
		$data['exist'] = $this->input->get('exist');
		if(!empty($data['exist'])){
			$data['exist'] = str_replace('_', ', ', $data['exist']);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/Pusat/V_new_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cek_anonymous(){
		$this->checkSession();
		$error = "";
		$waktu0 = $this->input->post("waktu0");
		$waktu1 = $this->input->post("waktu1");
		$lembur = $this->input->post("lembur");
		$noind = $this->input->post("noind");
		$tanggal = $this->input->post("tanggal");
		$tanggal = date_format(date_create($tanggal), 'Y-m-d');

		$shift = $this->M_splseksi->show_current_shift($tanggal, $noind);
		if(!empty($shift)){
			if($lembur != "004"){
				foreach($shift as $s){
					// jam lembur
					if($waktu1<$waktu0 || ($s['jam_plg']<$s['jam_msk'] && $lembur=="002")){
						if($s['jam_plg']<$s['jam_msk'] && $lembur=="002"){
							$tanggal0 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
							$tanggal1 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
						}else{
							$tanggal0 = $tanggal;
							$tanggal1 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
						}
					}else{
						$tanggal0 = $tanggal;
						$tanggal1 = $tanggal;
					}
					$mulai = date_format(date_create($tanggal0), "Y-m-d")." ".$waktu0;
					$mulai = date_format(date_create($mulai), 'Y-m-d H:i:s');
					$selesai = date_format(date_create($tanggal1), "Y-m-d")." ".$waktu1;
					$selesai = date_format(date_create($selesai), 'Y-m-d H:i:s');

					// jam shift
					if($s['jam_plg']<$s['jam_msk']){
						$tanggal0 = $tanggal;
						$tanggal1 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
					}else{
						$tanggal0 = $tanggal;
						$tanggal1 = $tanggal;
					}
					$mangkat = date_format(date_create($tanggal0), "Y-m-d")." ".$s['jam_msk'];
					$mangkat = date_format(date_create($mangkat), 'Y-m-d H:i:s');
					$pulang = date_format(date_create($tanggal1), "Y-m-d")." ".$s['jam_plg'];
					$pulang = date_format(date_create($pulang), 'Y-m-d H:i:s');

					// cocokkkan
					if($mulai<$mangkat && $selesai>$pulang){
						$error = "[0] Waktu lembur melewati shift -> $mulai@$selesai@$mangkat@$pulang";

					}elseif($lembur=="002" && ($mulai<$pulang || $selesai<$pulang)){
						$error = "[1] Waktu lembur tidak sesuai -> $mulai@$selesai@$mangkat@$pulang";

					}elseif($lembur=="003" && ($mulai>$mangkat || $selesai>$mangkat)){
						$error = "[2] Waktu lembur tidak sesuai -> $mulai@$selesai@$mangkat@$pulang";

					}

				}
			}else{
				$error = "[0] Bukan merupakan hari libur";
			}
		}else{
			if($lembur != "004"){
				$error = "[1] Seharusnya merupakan hari libur";
			}
		}

		$lembur = $this->M_splseksi->show_current_spl($tanggal, $noind, $lembur, '');
		if(!empty($lembur)){
			$error = "Data lembur pernah di input";
		}

		echo $error;
	}

	public function cek_anonymous2(){
		$this->checkSession();

		function waktu($waktu = '1990-01-01') {
			return strtotime($waktu);
		}

		$error = "0";
		$errortext = "";
		$aktual_awal = "";
		$aktual_akhir = "";
		$masuk_shift = "";
		$keluar_shift = "";
		$awal_lembur = "";
		$akhir_lembur = "";
		$mulai_ist = "";
		$selesai_ist = "";
		$masuk_absen = "";
		$keluar_absen = "";

		$tanggal = $this->input->post("tanggal0");
		$tanggal = date_format(date_create($tanggal), 'Y-m-d');
		$tanggal1 = $this->input->post("tanggal1");
		$tanggal1 = date_format(date_create($tanggal1), 'Y-m-d');
		$waktu0 = $this->input->post("waktu0");
		$waktu1 = $this->input->post("waktu1");

		$lembur = $this->input->post("lembur");
		$noind = $this->input->post("noind");

		//untuk tgl lembur kemarin
		if(strtotime($tanggal) < strtotime(date('Y-m-d'))){
			$tim = $this->M_splseksi->getTim($noind,$tanggal);
			if (!empty($tim) && count($tim) > 0) {
				foreach ($tim as $tm) {
					if ($tm['point'] == '1') {
						$error = "1";
						$errortext = "Jam Absen Tidak Lengkap. silahkan membuat memo absen manual";
					}else{
						$error = "1";
						$errortext = "Kirim SPL Manual ke Seksi Hubungan Kerja";
					}
				}
			}else{
				$shift = $this->M_splseksi->show_current_shift(date('Y-m-d', strtotime($tanggal)), $noind);

				// untuk shift 3, select tgl sebelumnya
				if($lembur == '002' || $lembur == '001') {
					$presensi = $this->M_splseksi->getPresensi($noind, (!empty($shift) && trim($shift['0']['kd_shift']) == '3') ? date('Y-m-d', strtotime('-1 days '.$tanggal)) : $tanggal);
				} else {
					$presensi = $this->M_splseksi->getPresensi($noind, $tanggal);
				}
				if (!empty($presensi) && count($presensi) > 0) {
					foreach ($presensi as $datapres) {
						$shift = $datapres['kd_shift'];
						$masuk_shift = date_format(date_create($datapres['jam_msk']), 'Y-m-d H:i:s');
						$keluar_shift = date_format(date_create($datapres['jam_plg']), 'Y-m-d H:i:s');
						$masuk_absen = date_format(date_create($datapres['masuk']), 'Y-m-d H:i:s');
						$keluar_absen = date_format(date_create($datapres['keluar']), 'Y-m-d H:i:s');
						$awal_lembur = date_format(date_create($tanggal), "Y-m-d")." ".$waktu0;
						$awal_lembur = date_format(date_create($awal_lembur), 'Y-m-d H:i:s');
						$akhir_lembur = date_format(date_create($tanggal1), "Y-m-d")." ".$waktu1;
						$akhir_lembur = date_format(date_create($akhir_lembur), 'Y-m-d H:i:s');
						$mulai_ist = date_format(date_create($datapres['ist_mulai']), 'Y-m-d H:i:s');
						$selesai_ist = date_format(date_create($datapres['ist_selesai']), 'Y-m-d H:i:s');

						if ($lembur == '001') { // lembur istirahat
							if ($mulai_ist <= $awal_lembur && $awal_lembur <= $selesai_ist) {
								$aktual_awal = $awal_lembur;
								if ($mulai_ist <= $akhir_lembur && $akhir_lembur <= $selesai_ist) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $selesai_ist){
									$aktual_akhir = $selesai_ist;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}elseif($awal_lembur < $mulai_ist){
								$aktual_awal = $mulai_ist;
								if ($mulai_ist <= $akhir_lembur && $akhir_lembur <= $selesai_ist) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $selesai_ist){
									$aktual_akhir = $selesai_ist;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}else{
								$error = "1";
								$errortext = "Jam Awal Lembur Tidak Sesuai";
							}
						}elseif ($lembur == '002') { // lembur pulang
							if ($keluar_shift <= $awal_lembur && $awal_lembur <= $keluar_absen) {
								// awal lembur
								if ($masuk_absen > $awal_lembur) {
									$aktual_awal = $masuk_absen;
								} else {
									$aktual_awal = $awal_lembur;
								}

								// akhir lembur
								if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $keluar_absen){
									$aktual_akhir = $keluar_absen;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}elseif($awal_lembur < $keluar_shift){
								$aktual_awal = $keluar_shift;
								
								if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $keluar_absen){
									$aktual_akhir = $keluar_absen;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}else{
								$error = "1";
								$errortext = "Jam Awal Lembur Tidak Sesuai";
							}
						}elseif ($lembur == '003') { //lembur datang
							if ($masuk_absen <= $awal_lembur && $awal_lembur <= $masuk_shift) {
								$aktual_awal = $awal_lembur;
								if ($masuk_absen <= $akhir_lembur && $akhir_lembur <= $masuk_shift) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $masuk_shift){
									$aktual_akhir = $masuk_shift;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}elseif($awal_lembur <= $masuk_absen) {	
								$aktual_awal = $masuk_absen;
								if ($masuk_absen <= $akhir_lembur && $akhir_lembur <= $masuk_shift) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $masuk_shift){
									$aktual_akhir = $masuk_shift;
								}elseif($awal_lembur < $masuk_absen && $akhir_lembur <= $masuk_absen){
									$aktual_akhir = $akhir_lembur;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}else{
								$error = "1";
								$errortext = "Jam Awal Lembur Tidak Sesuai";
							}
						}elseif ($lembur == '005') { // lembur datang dan pulang
							if ($masuk_absen <= $awal_lembur && $awal_lembur <= $masuk_shift) {
								$aktual_awal = $awal_lembur;
								if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $keluar_absen){
									$aktual_akhir = $keluar_absen;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}elseif($awal_lembur <= $masuk_absen){
								$aktual_awal = $masuk_absen;
								if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
									$aktual_akhir = $akhir_lembur;
								}elseif($akhir_lembur > $keluar_absen){
									$aktual_akhir = $keluar_absen;
								}else{
									$error = "1";
									$errortext = "Jam Akhir Lembur Tidak Sesuai";
								}
							}else{
								$error = "1";
								$errortext = "Jam Awal Lembur Tidak Sesuai";
							}
						}else{
							$error = "1";
							$errortext = "Bukan Merupakan Hari Libur ";
						}
					}
				}else{
					if ($lembur == '004') { // lembur hari libur
						$awal_lembur = date_format(date_create($tanggal), "Y-m-d")." ".$waktu0;
						$awal_lembur = date_format(date_create($awal_lembur), 'Y-m-d H:i:s');
						$akhir_lembur = date_format(date_create($tanggal1), "Y-m-d")." ".$waktu1;
						$akhir_lembur = date_format(date_create($akhir_lembur), 'Y-m-d H:i:s');

						$shiftpekerja = $this->M_splseksi->getShiftpekerja($noind, $tanggal);

						if ($shiftpekerja == 0) {
							// todo select kecuali hari kemarin, absen pulang
							$absensi = $this->M_splseksi->getAbsensi($noind, $tanggal, $tanggal1);
                            if ($absensi->row()->jumlah == 0) {
                                $error = "1";
                                $errortext = "Tidak ada absen pada tanggal ".date('d-m-Y', strtotime($tanggal));
                            } else if ($tanggal1 == $tanggal && $absensi->row()->jumlah % 2 == 1) { // sama hari dan absennya ganjil
								$error = "1";
								$errortext = "Absen pada tanggal ".date('d-m-Y', strtotime($tanggal))." tidak lengkap mohon membuat memo absen, jam absen({$absensi->row()->in})";
							} else {	
								$absenMasuk = date('Y-m-d H:i:s', strtotime($absensi->row()->in));
								$absenPulang = date('Y-m-d H:i:s', strtotime($absensi->row()->out));
								// jika aktual absen < input akhir lembur, maka jam aktual akhir lembur ngikut absen
								// kalau lebih, maka ngikut inputan
								// echo $absenMasuk.' > '.$awal_lembur;
								$aktual_awal = (strtotime($absenMasuk) > strtotime($awal_lembur)) ? date('H:i:s', strtotime($absenMasuk)) : $awal_lembur;
								$aktual_akhir = (strtotime($absenPulang) < strtotime($akhir_lembur)) ? date('H:i:s', strtotime($absenPulang)) : $akhir_lembur;
							}
						} else {
							$error = "1";
							$errortext = "Lembur Tidak Valid (Terdapat Shift)";
						}
					}else{
						$error = "1";
						$errortext = "Tidak Bisa Input Lembur (Nomor Induk Tidak memiliki Absen PKJ atau PID pada tanggal tersebut)";
					}
				}
			}
		}else{ //input lembur di kedepannya || tgl lembur == tgl input
			$presensi = $this->M_splseksi->getPresensiPusat($noind,$tanggal); // cari shiftpekerja

			if (!empty($presensi) && count($presensi) > 0) {
				foreach ($presensi as $datapres) {
					$masuk_shift = date_format(date_create($datapres['jam_msk']), 'Y-m-d H:i:s');
					$keluar_shift = date_format(date_create($datapres['jam_plg']), 'Y-m-d H:i:s');
					$awal_lembur = date_format(date_create($tanggal), "Y-m-d")." ".$waktu0;
					$awal_lembur = date_format(date_create($awal_lembur), 'Y-m-d H:i:s');
					$akhir_lembur = date_format(date_create($tanggal1), "Y-m-d")." ".$waktu1;
					$akhir_lembur = date_format(date_create($akhir_lembur), 'Y-m-d H:i:s');
					$mulai_ist = date_format(date_create($datapres['ist_mulai']), 'Y-m-d H:i:s');
					$selesai_ist = date_format(date_create($datapres['ist_selesai']), 'Y-m-d H:i:s');

					if ($lembur == '001') { // lembur istirahat
						if ($mulai_ist <= $awal_lembur && $awal_lembur <= $selesai_ist) {
							$aktual_awal = $awal_lembur;
							if ($mulai_ist <= $akhir_lembur && $akhir_lembur <= $selesai_ist) {
								$aktual_akhir = $akhir_lembur;
							}elseif($akhir_lembur > $selesai_ist){
								$aktual_akhir = $selesai_ist;
							}else{
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai Jam Istirahat Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($mulai_ist))." - ".date('H:i:s', strtotime($selesai_ist)).")";
							}
						}elseif($awal_lembur < $mulai_ist){
							$aktual_awal = $mulai_ist;
							if ($mulai_ist <= $akhir_lembur && $akhir_lembur <= $selesai_ist) {
								$aktual_akhir = $akhir_lembur;
							}elseif($akhir_lembur > $selesai_ist){
								$aktual_akhir = $selesai_ist;
							}else{
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai Jam Istirahat Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($mulai_ist))." - ".date('H:i:s', strtotime($selesai_ist)).")";
							}
						}else{
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai Jam Istirahat Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($mulai_ist))." - ".date('H:i:s', strtotime($selesai_ist)).")";
						}
					}elseif ($lembur == '002') { // lembur pulang
						if ($keluar_shift <= $awal_lembur) {
							$aktual_awal = $awal_lembur;
							if ($keluar_shift <= $akhir_lembur) { // ini error buat shift 3
								$aktual_akhir = $akhir_lembur;
							}else{
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai Jam Pulang Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($keluar_shift)).")";
							}
							//echo $errortext;
						}elseif($awal_lembur <= $keluar_shift){
							$aktual_awal = $keluar_shift;
							if ($keluar_shift < $akhir_lembur) {
								$aktual_akhir = $akhir_lembur;
							}else{
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai Jam Pulang Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($keluar_shift)).")";
							}
						}else{
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai Jam Pulang Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($keluar_shift)).")";
						}
					}elseif ($lembur == '003') { //lembur datang
						if ($awal_lembur <= $masuk_shift) {
							$aktual_awal = $awal_lembur;
							if ( $akhir_lembur <= $masuk_shift) {
								$aktual_akhir = $akhir_lembur;
							}elseif($akhir_lembur > $masuk_shift){
								$aktual_akhir = $masuk_shift;
							}else{
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai Jam Masuk Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($masuk_shift)).")";
							}
						}else{
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai Jam Masuk Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($masuk_shift)).")";
						}
					}elseif ($lembur == '005') { // lembur datang dan pulang
						if ($awal_lembur <= $masuk_shift) {
							$aktual_awal = $awal_lembur;
							if ($keluar_shift <= $akhir_lembur) {
								$aktual_akhir = $akhir_lembur;
							}else{
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai Jam Masuk & Pulang Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($masuk_shift))." - ".date('H:i:s', strtotime($keluar_shift)).")";
							}
						}else{
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai Jam Masuk & Pulang Shift Pekerja, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($masuk_shift))." - ".date('H:i:s', strtotime($keluar_shift)).")";
						}
					}else{
						$error = "1";
						$errortext = "Bukan Merupakan Hari Libur Pekerja, Pekerja Memiliki Jam Shift, SHIFT {$datapres['kd_shift']} (".date('H:i:s', strtotime($masuk_shift))." - ".date('H:i:s', strtotime($keluar_shift)).")";
					}
				}
			}else{
				if ($lembur == '004') { // lembur hari libur

					$shiftpekerja = $this->M_splseksi->getShiftpekerja($noind,$tanggal);

					$awal_lembur = date_format(date_create($tanggal), "Y-m-d")." ".$waktu0;
					$awal_lembur = date_format(date_create($awal_lembur), 'Y-m-d H:i:s');
					$akhir_lembur = date_format(date_create($tanggal1), "Y-m-d")." ".$waktu1;
					$akhir_lembur = date_format(date_create($akhir_lembur), 'Y-m-d H:i:s');

					if ($shiftpekerja == 0) {
						$aktual_awal = $awal_lembur;
						$aktual_akhir = $akhir_lembur;
					}else{
						$error = "1";
						$errortext = "Lembur Tidak Valid";
					}
				}else{
					$error = "1";
					$errortext = "Tidak Bisa Input Lembur (Tidak Ada Absen Pada Tanggal Lembur Awal)";
				}
			}
		}

		// Pengecekan sudah punya SPL belum  pada hari dimana lembur ?
		$shift = $this->M_splseksi->show_current_shift(date('Y-m-d', strtotime($tanggal)), $noind);
		if ((!empty($shift) && trim($shift['0']['kd_shift']) == '3')) {
			$tanggal = date('Y-m-d', strtotime('-1 days '.$tanggal));
		}
		$checkSPL= $this->M_splseksi->checkingExistSPL($noind, $tanggal, $tanggal.$waktu0, $tanggal1.$waktu1);
		if($checkSPL['exist'] && $error == 0) {
			$error = 1;
			$errortext = "Sudah ada SPL di tanggal {$checkSPL['message']['tanggal']} ({$checkSPL['message']['jam']})";
		}

		if($tanggal.$waktu0 === $tanggal1.$waktu1){
			$error = 1;
			$errortext = 'Waktu lembur yang diambil tidak boleh sama !!!';
		}

		if(empty($lembur)){
			$error = 1;
			$errortext = 'Jenis Lembur belum diinput';
		}

		$presensi = array(
			'awal' 	=> date_format(date_create($aktual_awal),"H:i:s"),
			'akhir' => date_format(date_create($aktual_akhir),"H:i:s"),
			'error' => $error,
			'text'	=> $errortext,
			'masuk_shift' => $masuk_shift,
			'keluar_shift' => $keluar_shift,
			'masuk_absen' => $masuk_absen,
			'keluar_absen' => $keluar_absen,
			'awal_lembur' => $awal_lembur,
			'akhir_lembur' => $akhir_lembur,
			'mulai_ist' => $mulai_ist,
			'selesai_ist' => $selesai_ist
		);
		echo json_encode($presensi);
	}

	public function new_spl_submit(){
		$this->checkSession();
		$user_id = $this->session->user;
		$tanggal = $this->input->post('tanggal_0_simpan');
		$tanggal = date_format(date_create($tanggal), "Y-m-d");
		$tanggal1 = $this->input->post('tanggal_1_simpan');
		$tanggal1 = date_format(date_create($tanggal1), "Y-m-d");
		$mulai = $this->input->post('waktu_0_simpan');
		$mulai = date_format(date_create($mulai), "H:i:s");
		$selesai = $this->input->post('waktu_1_simpan');
		$selesai = date_format(date_create($selesai), "H:i:s");
		$lembur = $this->input->post('kd_lembur_simpan');
		$istirahat = $this->input->post('istirahat_simpan');
		$break = $this->input->post('break_simpan');
		$alasan = str_replace("'", '', $this->input->post('alasan_simpan'));
		$size = sizeof($this->input->post('noind'));
		$sendmail_splid = "";

		if($mulai == $selesai){
			redirect(base_url('SPL/Pusat/InputLembur?result=3'));
			return false;
		}

		$target = array();
		$target_satuan = array();
		$realisasi = array();
		$realisasi_satuan = array();

		// reindexing array
		$target_post_0 = $this->input->post('target');

		foreach($target_post_0 as $key => $value){
			$target_post[] = $_POST['target'][$key];
			$target_satuan_post[] = $_POST['target_satuan'][$key];
			$realisasi_post[] = $_POST['realisasi'][$key];
			$realisasi_satuan_post[] = $_POST['realisasi_satuan'][$key];
			$pekerjaan_post[] = $_POST['pekerjaan'][$key];
		}

		$is_notvalid = [];
		$review = array();

		for($x=0; $x<$size; $x++){
			$noind = $this->input->post("noind[$x]");
		
			// $allShift = $this->M_splseksi->selectAllShift($tanggal);

			// $allShift = array_map(function($waktu) use($tanggal) {
			// 	return array(
			// 		'break_mulai' => $tanggal." ".$waktu['break_mulai'], 
			// 		'break_selesai' => $tanggal." ".$waktu['break_selesai'],
			// 		'ist_mulai' => $tanggal." ".$waktu['ist_mulai'],
			// 		'ist_selesai' => $tanggal." ".$waktu['ist_selesai']
			// 	);
			// }, $allShift);

			$target = array();
			$realisasi = array();
			$j = 0;

			for ($j; $j < count($target_post[$x]); $j++) {
				$target[] = $target_post[$x][$j]." ".$target_satuan_post[$x][$j];
				$realisasi[] = $realisasi_post[$x][$j]." ".$realisasi_satuan_post[$x][$j];
			}

			$target = implode(';', $target);
			$realisasi = implode(';', $realisasi);

			$pekerjaan = $pekerjaan_post[$x];
			$pekerjaan = str_replace("'", '', implode(';', $pekerjaan));

			$mulai = $this->input->post("lembur_awal[$x]");
			$selesai = $this->input->post("lembur_akhir[$x]");

			// Agar SPL tidak ter double
			$shift = $this->M_splseksi->show_current_shift(date('Y-m-d', strtotime($tanggal)), $noind);
			if ((!empty($shift) && trim($shift['0']['kd_shift']) == '3')) {
				$tanggal_cek = date('Y-m-d', strtotime('-1 days '.$tanggal));
			}else{
				$tanggal_cek = $tanggal;
			}
			$checkSPL= $this->M_splseksi->checkingExistSPL($noind, $tanggal_cek, $tanggal." ".$mulai, $tanggal1." ".$selesai);
			if ($checkSPL['exist']) continue;

			// cek shift, khusus shift 3 , lembur selain lewat hari, dan lembur pulang, tanggal  dikurangi 1
			$shift = $this->M_splseksi->show_current_shift(date('Y-m-d', strtotime('-1 days '.$tanggal)), $noind);

			if (!empty($shift) && trim($shift['0']['kd_shift']) == '3' && strtotime($mulai) < strtotime($selesai) && $lembur == '002') {
				$tanggal = date('Y-m-d', strtotime('-1 days '.$tanggal));
			}

			// Generate ID SPL
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl", "ID_SPL");
			
			if (empty($maxid)) {
				$spl_id = "0000000001";
			} else {
				$spl_id = $maxid->id;
				$spl_id = substr("0000000000", 0, 10-strlen($spl_id)).$spl_id;
			}
			if ($sendmail_splid == "") {
				$sendmail_splid = "'$spl_id'";
			} else {
				$sendmail_splid .= ",'$spl_id'";
			}

			// Generate ID Riwayat
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");

			if (empty($maxid)) {
				$splr_id = "0000000001";
			} else {
				$splr_id = $maxid->id;
				$splr_id = substr("0000000000", 0, 10-strlen($splr_id)).$splr_id;
			}

			// Insert data
			$log_ket = "Noind:".$noind." Tgl:".$tanggal." Kd:".$lembur." Jam:".$mulai."-".$selesai.
				" Break:".$break." Ist:".$istirahat." Pek:".$pekerjaan." Stat:01 <br />";

			$data_log = array(
				"wkt" => date('Y-m-d H:i:s'),
				"menu" => "Operator",
				"jenis" => "Tambah",
				"ket" => $log_ket,
				"noind" => $user_id);
			$to_log = $this->M_splseksi->save_log($data_log);

			$noind_baru = $this->M_splseksi->getNoindBaru($noind);

			$tanggal_shift = $tanggal;
			$shift = $this->M_splseksi->show_current_shift($tanggal, $noind);
			if($lembur == '002' && $shift[0]['kd_shift'] == '3') {
				$tanggal_shift = date('d-m-Y', strtotime('-1 day '.$tanggal));
			}

			// generate review after submit
			array_push($review, array(
				'noind' => $noind,
				'nama' => $this->M_splseksi->getNameByNoind($noind),
				'tanggal' => $tanggal,
				'tanggal_shift' => $tanggal_shift,
				'lembur' => $this->getLembur($lembur),
				'awal' => $mulai,
				'akhir' => $selesai,
				'break' => $break == 1 ? 'Y' : 'N',
				'istirahat' => $istirahat == 1 ? 'Y' : 'N',
				'jam_lembur' => $this->hitung_jam_lembur($noind, $lembur, $tanggal, $mulai, $selesai, $break == 1 ? 'Y' : 'N', $istirahat == 1 ? 'Y' : 'N')
			));

			$data_spl = array(
				"ID_SPL" => $spl_id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $tanggal,
				"Noind" => $noind,
				"Noind_Baru" => $noind_baru,
				"Kd_Lembur" => $lembur,
				"Jam_Mulai_Lembur" => $mulai,
				"Jam_Akhir_Lembur" => $selesai,
				"Break" => $break,
				"Istirahat" => $istirahat,
				"Pekerjaan" => $pekerjaan,
				"Status" => "01",
				"User_" => $user_id,
				"target" => $target,
				"realisasi" => $realisasi,
				"alasan_lembur" => $alasan);
			$this->M_splseksi->save_spl($data_spl);

			$data_splr = array(
				"ID_Riwayat" => $splr_id,
				"ID_SPL" => $spl_id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $tanggal,
				"Noind" => $noind,
				"Noind_Baru" => $noind_baru,
				"Kd_Lembur" => $lembur,
				"Jam_Mulai_Lembur" => $mulai,
				"Jam_Akhir_Lembur" => $selesai,
				"Break" => $break,
				"Istirahat" => $istirahat,
				"Pekerjaan" => $pekerjaan,
				"Status" => "01",
				"User_" => $user_id,
				"Revisi" => "0",
				"Keterangan" => "(Tambah)",
				"target" => $target,
				"realisasi" => $realisasi,
				"alasan_lembur" => $alasan);
			$this->M_splseksi->save_splr($data_splr);
		}

		// set session review
		$this->session->set_flashdata('review' , $review);
		$this->session->set_flashdata('notif' , true);

		//mencegah agar spl tidak dapat diinput ketika pekerja memiliki spl dihari yg sama
		if (count($is_notvalid) > 0 && $size == count($is_notvalid)) {
			$exist = implode('_', $is_notvalid);
			redirect(base_url('SPL/Pusat/InputLembur?result=2&exist='.$exist)); //tidak muncul notif sukses, tapi muncul danger noind
			return false;
		} else if (count($is_notvalid) > 0) {
			$exist = implode('_', $is_notvalid);
			redirect(base_url('SPL/Pusat/InputLembur?result=1&exist='.$exist)); //muncul notif sukses, dan muncul danger noind
			$this->send_email($sendmail_splid);
			return false;
		}

		$this->send_email($sendmail_splid);

		redirect(base_url('SPL/Pusat/InputLembur?result=1'));
	}

	function getLembur($kode) {
		if(!$kode) return '-';

		$kd_lembur = array(
			'001' => 'Lembur Istirahat',
			'002' => 'Lembur Pulang',
			'003' => 'Lembur Datang',
			'004' => 'Lembur Hari Libur',
			'005' => 'Lembur Datang dan Pulang'
			);

		return $kd_lembur[$kode];
	}

	public function rekap_spl(){
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$data = $this->menu('', '', '');
		$data['noind'] = $this->M_splseksi->show_noind();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/Pusat/V_rekap_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function rekap_spl_filter(){
		$this->checkSession();
		$user = $this->session->user;
		$dari = date("Y-m-d", strtotime($this->input->post('dari')));
		$sampai = date("Y-m-d", strtotime($this->input->post('sampai')));
		$noi = $this->input->post('noi');
		$noind = $this->input->post('noind');

		if($noind == ""){ $noind = $noi; }

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$x = 1;
		$data_spl = array();
		$show_list_spl = $this->M_splseksi->show_rekap($dari, $sampai, $noind, $akses_sie);
		foreach($show_list_spl as $sls){
			$index = array();

			$index[] = $x;
			$index[] = $sls['tanggal'];
			$index[] = $sls['noind'];
			$index[] = $sls['nama'];
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['jam_msk'];
			$index[] = $sls['jam_klr'];
			$index[] = $sls['total_lembur'];

			$x++;
			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	public function send_email($spl_id) {
		$this->checkSession();
		$user = $this->session->user;

		$pesan = $this->M_splseksi->show_spl_byid($spl_id);

		$group_kodesie = [];
		foreach($pesan as $item){
			$group_kodesie[substr($item['kodesie'],0, 7)][] = $item; 
		}

		foreach($group_kodesie as $seksi){
			$akses_kue = $this->M_splseksi->show_pekerja('', $seksi['0']['Noind'], ''); // array noind, nama, kodesie dr salah 1 seksi
		
			$akses_sie = array();
			foreach($akses_kue as $ak){
				$akses_sie[] = substr($this->cut_kodesie($ak['kodesie']), 0, 7);
			}
	
			$data = [];
			foreach($akses_sie as $as){
				$e_asska = $this->M_splseksi->show_email_addres($as);
				foreach($e_asska as $ea){
					$data[] = $ea['internal_mail'];
				}
			}

			$isiPesan = "<table style='border-collapse: collapse;width: 100%'>";
			$pesan = $seksi;
	
			$tgl_lembur = "";
			$pkj_lembur = "";
			$brk_lembur = "";
			$ist_lembur	= "";
			$jns_lembur = "";
			$no = 1;
			foreach ($pesan as $key) {
				if ($tgl_lembur !== $key['tgl_lembur'] or $pkj_lembur !== $key['Pekerjaan'] or $brk_lembur !== $key['Break'] or $ist_lembur !== $key['Istirahat'] or $jns_lembur !== $key['Kd_Lembur']) {
					$no = 1;
					$isiPesan .= "	<tr><td>&nbsp;</td></tr><tr><td>Tanggal</td>
									<td colspan='7'> : ".$key['tgl_lembur']."</td></tr>
									<tr><td>jenis</td><td colspan='7'> : ".$key['nama_lembur']."</td></tr>
									<tr><td>Istirahat</td><td colspan='7'> : ".$key['Istirahat']."</td></tr>
									<tr><td>Break</td><td colspan='7'> : ".$key['Break']."</td></tr>
									<tr><td>Pekerjaan</td><td colspan='7'> : ".$key['Pekerjaan']."</td></tr>
									<tr>
										<td style='border: 1px solid black'>No</td>
										<td style='border: 1px solid black'>Pekerja</td>
										<td style='border: 1px solid black'>Kodesie</td>
										<td style='border: 1px solid black'>Seksi</td>
										<td style='border: 1px solid black'>Unit</td>
										<td style='border: 1px solid black'>Waktu Lembur</td>
										<td style='border: 1px solid black'>Target</td>
										<td style='border: 1px solid black'>Realisasi</td>
										<td style='border: 1px solid black'>Alasan</td>
									</tr>";
				}
				$isiPesan .= "<tr>
				<td style='border: 1px solid black;text-align: center'>$no</td>
				<td style='border: 1px solid black'>".$key['Noind']." ".$key['nama']."</td>
				<td style='border: 1px solid black;text-align: center'>".$key['kodesie']."</td>
				<td style='border: 1px solid black'>".$key['seksi']."</td>
				<td style='border: 1px solid black'>".$key['unit']."</td>
				<td style='border: 1px solid black'>".$key['jam_mulai_lembur']." - ".$key['Jam_Akhir_Lembur']."</td>
				<td style='border: 1px solid black;text-align: center'>".$key['target']."</td>
				<td style='border: 1px solid black;text-align: center'>".$key['realisasi']."</td>
				<td style='border: 1px solid black'>".$key['alasan_lembur']."</td>
				</tr>";
				$no++;
				$tgl_lembur = $key['tgl_lembur'] ;
				$pkj_lembur = $key['Pekerjaan'] ;
				$brk_lembur = $key['Break'] ;
				$ist_lembur = $key['Istirahat'] ;
				$jns_lembur = $key['Kd_Lembur'] ;
			}
			$isiPesan .= "</table>";

			$e = array(
				"actn" => "offline",
				"host" => "m.quick.com",
				"port" => 465,
				"user" => "no-reply",
				"pass" => "123456",
				"from" => "no-reply@quick.com",
				"adrs" => ""
			);
	
			$this->load->library('PHPMailerAutoload');
			$mail = new PHPMailer;
			//Tell PHPMailer to use SMTP
			$mail->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host = $e['host'];
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = $e['port'];
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					));
			//Username to use for SMTP authentication
			$mail->Username = $e['user'];
			//Password to use for SMTP authentication
			$mail->Password = $e['pass'];
			//Set who the message is to be sent from
			$mail->setFrom($e['from'], 'Email Sistem');
			//Set an alternative reply-to address
			// $mail->addReplyTo('it.sec3@quick.com', 'Khoerul Amri');
			//Set who the message is to be sent to
			$mail->addAddress($e['adrs'], 'Monitoring Transaction');
			foreach($data as $d){
				$mail->addAddress($d, 'Lembur (Approve Kasie)');
			}
			//Set the subject line
			$mail->Subject = 'Anda telah menerima permintaan approval spl';
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML("
			<h4>Lembur (Appove Kasie)</h4><hr>
			Kepada Yth Bapak/Ibu<br><br>

			Kami informasikan bahwa anda telah menerima permintaan<br>
			approval untuk keperluan lembur pekerja<br><br>
			$isiPesan
			<br>
			Anda dapat melakukan pengecekan di link berikut :<br>
			- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

			<small>Email ini digenerate melalui sistem erp.quick.com pada ".date('d-m-Y H:i:s').".<br>
			Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>");
			//send the message, check for errors
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo "Message sent!";
			}
		}
	}

	public function create_memo(){
		$this->checkSession();
		$noind = $this->input->get('noind');
		$tanggal = $this->input->get('tanggal');

		$data = $this->menu('', '', '');

		$data['data'] = $this->M_splseksi->getDataForMemo($noind,$tanggal);
		$data['alasan'] = $this->M_splseksi->getAlasanMemo();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/Pusat/V_create_memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submit_memo(){
		$this->checkSession();
		$data = array(
			'noind' => $this->input->post('txtNoind'),
			'tgl' => $this->input->post('txtTanggal'),
			'shift' => $this->input->post('txtShift'),
			'masuk' => $this->input->post('txtMasuk'),
			'pulang' => $this->input->post('txtKeluar'),
			'atasan' => $this->input->post('txtAtasan'),
			'atasan_dua' => $this->input->post('txtAtasan2'),
			'saksi' => $this->input->post('txtSaksi')
		);

		$id = $this->M_splseksi->insertMemo($data);

		$alasan = $this->input->post('txtAlasan');
		$alasan_info = $this->input->post('txtAlasanInfo');
		$a = 0;
		foreach ($alasan as $als) {
			$info = "";
			if (isset($alasan_info[$als])) {
				$info = $alasan_info[$als];
			}
			$data_dua[$a] = array(
				'absen_manual_id' => $id,
				'alasan_id' => $als,
				'info' => $info
			);
			$id_dua = $this->M_splseksi->insertAlasanMemo($data_dua[$a]);

			$a++;
		}


		echo $id;
	}

	public function pdf_memo(){
		$this->checkSession();
		$id = $this->input->get('id');
		$data['alasan_memo'] = $this->M_splseksi->show_AlasanMemo($id);
		$data['alasan_master'] = $this->M_splseksi->getAlasanMemo();
		$data['memo'] = $this->M_splseksi->show_memo($id);
		$data['tpribadi'] = $this->M_splseksi->show_pekerjamemo($data['memo']->noind);
		$data['shift'] = $this->M_splseksi->show_shiftmemo($data['memo']->shift,$data['memo']->tgl);
		$data['atasan'] = $this->M_splseksi->show_atasan($data['memo']->atasan,$data['memo']->atasan_dua,$data['memo']->noind);

		// echo "<pre>";print_r($data['memo']);echo "</pre><br>";echo "<pre>";print_r($data['alasan_memo']);echo "</pre><br>";exit();

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A5',0,'',0,0,0,0,0,0);
		$filename = 'Memo Prensensi '.time().'.pdf';

		$html = $this->load->view('SPLSeksi/Seksi/Pusat/V_pdf_memo', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');

		// $this->load->view('SPLSeksi/Seksi/V_pdf_memo', $data);
	}

	public function ajaxSendReminderEmail(){
		// digunakan untuk mengirim reminder email ke atasan seksi dimana SPL belum di approve
		// menggunakan api dari cronjob
		$is_login = $this->session->kodesie == '';
		if($is_login){
			echo "this api cannot accessed without login";
			die;
		}

		//lets execute the code
		$ch = curl_init();

		$endpoint = 'http://personalia.quick.com/cronjob/mysql_database.quick.com_API_notifikasi_lembur_per_seksi.php';
		$params = array(
			'kodesie' => $this->session->kodesie
		);
		$url = $endpoint . '?' . http_build_query($params);

		$a = curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);

		$res = array(
			'success' => true
		);

		echo json_encode($res);

	}

}
