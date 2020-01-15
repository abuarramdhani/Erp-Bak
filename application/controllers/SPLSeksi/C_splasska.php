<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);
class C_splasska extends CI_Controller {
	function __construct() {
        parent::__construct();

        $this->load->library('session');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SPLSeksi/M_splasska');
		$this->load->model('SPLSeksi/M_splkasie');
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
		$data = $this->menu('', '', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/AssKa/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function data_spl(){	
		$this->checkSession();
		$wkt_validasi = $this->session->spl_validasi_waktu_asska;
		if (time() - $wkt_validasi > 120) {
			$this->session->spl_validasi_asska = FALSE;
			redirect(site_url('SPL'));
		}
		$this->session->spl_validasi_waktu_asska = time();
		$data = $this->menu('', '', '');
		$data['lokasi'] = $this->M_splseksi->show_lokasi();
		$data['jari'] = $this->M_splseksi->getJari($this->session->userid);
		if ($this->input->get('stat')) {
			$status = $this->input->get('stat');
			$data_spl = array();
			if ($status == 'Baru') {
				$show_list_spl = $this->M_splseksi->show_spl2('0%',$this->session->user,'5');
			}elseif ($status == 'Tolak') {
				$show_list_spl = $this->M_splseksi->show_spl2('2%',$this->session->user,'5');
			}else{
				$show_list_spl = $this->M_splseksi->show_spl2('%',$this->session->user,'5');
			}
			foreach($show_list_spl as $sls){
				$index = array();
				$btn_hapus = "";
				if ($sls['Status'] == '01' or $sls['Status'] == '31' or $sls['Status'] == '35') {
					$btn_hapus = "<a href='".site_url('SPL/HapusLembur/'.$sls['ID_SPL'])."' title='Hapus'><i class='fa fa-fw fa-trash'></i></a>";
				}
				$index[] = "<a href='".site_url('SPL/EditLembur/'.$sls['ID_SPL'])."' title='Detail'><i class='fa fa-fw fa-search'></i></a>
					$btn_hapus";
				$index[] = $sls['Tgl_Lembur'];
				$index[] = $sls['Noind'];
				$index[] = $sls['nama'];
				$index[] = $sls['kodesie'];
				$index[] = $sls['seksi'];
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
				$index[] = $sls['Deskripsi']." ".$sls['User_']." (".$sls['user_approve'].")";
				$index[] = $sls['Tgl_Berlaku'];

				$data_spl[] = $index;
			}
			$data['data'] = $data_spl;
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/AssKa/V_data_spl',$data);
		$this->load->view('V_Footer',$data);
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

	public function hitung_jam_lembur($noind, $kode_lembur, $tgl, $mulai, $selesai, $break, $istirahat){ //latest
		$day   = date('w', strtotime($tgl));

		$hari_indo = "Minggu Senin Selasa Rabu Kamis Jumat Sabtu";
		$array_hari = explode(' ', $hari_indo);
		//--------------------core variable
		$KET  		= $this->M_splseksi->getKeteranganJamLembur($noind);
		$JENIS_HARI	= $this->M_splseksi->getJenisHari($tgl, $noind);
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
		 	$zero = 24*60; // jam sehari dalam menit
		 	$z = $zero - $a;
		 	$lama_lembur = $z+$b;
		}else{
			$lama_lembur = $b-$a;
		}

		$shift = $this->M_splseksi->selectShift($noind, $tgl);
		if($kode_lembur == '005'){
			$shift = (strtotime($shift->jam_plg) - strtotime($shift->jam_msk));
			$shift = $shift/60;
		 	$result = $lama_lembur-$shift;
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

				foreach($allShift as $shift){
					$rest_start = strtotime($shift['ist_mulai']);
					$rest_end   = strtotime($shift['ist_selesai']);

					if($rest_start == $rest_end){
						continue;
					}

					//biar jam break tidak terdouble
					if(in_array($rest_start, $distinct_start)){
						continue;
					}else{
						$distinct_start[] = $rest_start;
					}

					$overtime_start = strtotime($mulai);
					$overtime_end   = strtotime($selesai);

					if (($rest_start > $overtime_start && $rest_end < $overtime_end)) { // jika jam istirahat masuk range lembur
						$ISTIRAHAT = $ISTIRAHAT + 45;
					}else if($rest_start > $overtime_start && $rest_end > $overtime_end && $rest_start < $overtime_end){
						$ISTIRAHAT = $ISTIRAHAT + (45 + ($overtime_end - $rest_end)/60);
					}
				}
			}
			
			if ($break == 'Y') { //jika pekerja memilih istirahat
				$BREAK = 0;
				$distinct_start = [];

				foreach($allShift as $shift){
					$break_start = strtotime($shift['break_mulai']);
					$break_end   = strtotime($shift['break_selesai']);

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

					$overtime_start = strtotime($mulai);
					$overtime_end   = strtotime($selesai);
				
					if ($break_start > $overtime_start && $break_end < $overtime_end) { // jika jam istirahat masuk range lembur
						$BREAK = $BREAK + 15;
					}else if($break_start > $overtime_start && $break_end > $overtime_end && $break_start < $overtime_end){
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

	public function cut_kodesie($id){
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
		$this->session->spl_validasi_waktu_asska = time();
		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');
		$kodesie = $this->input->post('kodesie');

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
		$show_list_spl = $this->M_splasska->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie, $kodesie);
		foreach($show_list_spl as $sls){
			$index = array();

			if($sls['Status'] == "21"){
				$index[] = '<input type="checkbox" name="splid[]" class="spl-chk-data"
					value="'.$sls['ID_SPL'].'" style="width:20px; height:20px; vertical-align:bottom;">';
			}else{
				$index[] = "";
			}

			$index[] = $sls['Tgl_Lembur'];
			$index[] = $sls['Noind'];
			$index[] = $sls['nama'];
			$index[] = $sls['kodesie'];
			$index[] = $sls['seksi'];
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
			$index[] = $sls['Deskripsi']." ".$sls['User_']." - ".$this->M_splkasie->getName($sls['User_']);
			$index[] = $sls['Tgl_Berlaku'];

			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	public function data_spl_approv($id, $stat, $ket){
		$this->checkSession();
		$this->session->spl_validasi_waktu_asska = time();
		$user = $this->session->user;
		$data_spl = $this->M_splseksi->show_current_spl('', '', '', $id);

		foreach($data_spl as $ds){
			// Generate ID Riwayat
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
			if(empty($maxid)){
				$splr_id = "0000000001";
			}else{
				$splr_id = $maxid->id;
				$splr_id = substr("0000000000", 0, 10-strlen($splr_id)).$splr_id;
			}

			// Approv or Cancel
			if($stat == "25"){
				$log_jenis = "Approve";
				$spl_ket = $ket." (Approve By AssKa)";
			}else{
				$log_jenis = "Cancel";
				$spl_ket = $ket." (Cancel By AssKa)";
			}

			// Insert data
			$log_ket = "Noind:".$ds['Noind']." Tgl:".$ds['Tgl_Lembur']." Kd:".$ds['Kd_Lembur'].
				" Jam:".$ds['Jam_Mulai_Lembur']."-".$ds['Jam_Akhir_Lembur']." Break:".$ds['Break'].
				" Ist:".$ds['Istirahat']." Pek:".$ds['Pekerjaan']."<br />";

			$data_log = array(
				"wkt" => date('Y-m-d H:i:s'),
				"menu" => "AssKa",
				"jenis" => $log_jenis,
				"ket" => $log_ket,
				"noind" => $user);
			$to_log = $this->M_splseksi->save_log($data_log);

			$data_spl = array(
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Status" => $stat,
				"User_" => $user);
			$to_spl = $this->M_splseksi->update_spl($data_spl, $id);

			$data_splr = array(
				"ID_Riwayat" => $splr_id,
				"ID_SPL" => $id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $ds['Tgl_Lembur'],
				"Noind" => $ds['Noind'],
				"Noind_Baru" => "0000000",
				"Kd_Lembur" => $ds['Kd_Lembur'],
				"Jam_Mulai_Lembur" => $ds['Jam_Mulai_Lembur'],
				"Jam_Akhir_Lembur" => $ds['Jam_Akhir_Lembur'],
				"Break" => $ds['Break'],
				"Istirahat" => $ds['Istirahat'],
				"Pekerjaan" => $ds['Pekerjaan'],
				"Status" => $stat,
				"User_" => $user,
				"Revisi" => "0",
				"Keterangan" => $spl_ket,
				"target" => $ds['target'],
				"realisasi" => $ds['realisasi'],
				"alasan_lembur" => $ds['alasan_lembur']);
			$to_splr = $this->M_splseksi->save_splr($data_splr);
		}
	}

	public function update_datapresensi($spl_id){
		$this->checkSession();
		$si = $spl_id;
		$jml_lembur = 0;
		$cek_tspl = $this->M_splasska->cek_spl($si);
		// print_r($cek_tspl);exit();
		if(floatval($cek_tspl->jml_lembur) > 0){
			if ($cek_tspl->kode == '004') {
				$wkt_pkj = $this->M_splasska->get_wkt_pkj($cek_tspl->noind,$cek_stpl->$tanggal);
				$jml_lembur = floatval($cek_tspl->jml_lembur) - $wkt_pkj;
			}else{
				$jml_lembur = floatval($cek_tspl->jml_lembur);
			}
		}

		if($cek_tspl->kode == '004'){
			if ($jml_lembur > 8) {
				$lembur1 = ($jml_lembur - 8) * 4;
				$lembur2 = 3;
				$lembur3 = 14;
			}else if($jml_lembur > 7){
				$lembur1 = ($jml_lembur - 7) * 3;
				$lembur2 = 14;
				$lembur3 = 0;
			}else{
				$lembur1 = $jml_lembur * 2;
				$lembur2 = 0;
				$lembur3 = 0;
			}
		}else{
			if($jml_lembur > 1){
				$lembur1 = ($jml_lembur - 1) * 2;
				$lembur2 = 1.5;
				$lembur3 = 0;
			}else{
				$lembur1 = ($jml_lembur - 8)* 1.5;
				$lembur2 = 0;
				$lembur3 = 0;
			}
		}
		$lembur = $lembur1 + $lembur2 + $lembur3;
		// echo $lembur;print_r($cek_tspl);exit();
		if($cek_tspl->kode == '004'){
			$cek_hl = $this->M_splasska->cek_hl($cek_tspl->noind,$cek_tspl->tanggal);
			if ($cek_hl == 0) {
				$this->M_splasska->insert_tdatapresensi_hl($cek_tspl->awal,$cek_tspl->akhir,$cek_tspl->noind,$cek_tspl->tanggal,$lembur);
				$this->M_splasska->tlog();
			}
		}else{
			$cek_tdatapresensi = $this->M_splasska->cek_tdatapresensi($cek_tspl->noind,$cek_tspl->tanggal);
			if ($cek_tdatapresensi->kd_ket == 'PKJ') {
				$this->M_splasska->update_tdatapresensi('PLB',$cek_tspl->noind,$cek_tspl->tanggal,$lembur);
			}elseif($cek_tdatapresensi->kd_ket == 'PDL'){
				$this->M_splasska->update_tdatapresensi('PDB',$cek_tspl->noind,$cek_tspl->tanggal,$lembur);
			}
		}
	}

	public function send_email_2($status,$spl_id,$ket){
		$this->checkSession();
		$this->session->spl_validasi_waktu_asska = time();
		$user = $this->session->user;
		$spl_id = explode('.', $spl_id);
		$idspl = "";
		foreach ($spl_id as $id) {
			if ($idspl == "") {
				$idspl .= "'".$id."'";
			}else{
				$idspl .= ",'".$id."'";
			}
		}
		$pesan = $this->M_splkasie->show_spl_byid_2($idspl);
		$tgl_lembur = "";
		$pkj_lembur = "";
		$brk_lembur = "";
		$ist_lembur	= "";
		$jns_lembur = "";
		$no = 1;
		$data = array();
		$number = 0;
		$op_spl = "";
		foreach ($pesan as $key) {
			if ($op_spl !== $key['user_']) {
				if ($number !== 0) {
					$data[$number]['isiPesan'] .= "</table>";
				}
				$number++;
				$data[$number]['user'] = $key['user_'];
				$data[$number]['isiPesan'] = "<table style='border-collapse: collapse;width: 100%'>";
				$data[$number]['email'] = $this->M_splkasie->getEmailAddress($key['user_']);
			}else{

			}
			if ($tgl_lembur !== $key['tgl_lembur'] or $pkj_lembur !== $key['Pekerjaan'] or $brk_lembur !== $key['Break'] or $ist_lembur !== $key['Istirahat'] or $jns_lembur !== $key['Kd_Lembur']) {
				$no = 1;
				$data[$number]['isiPesan'] .= "	<tr><td>&nbsp;</td></tr>
								<tr><td>Tanggal</td><td colspan='7'> : ".$key['tgl_lembur']."</td></tr>
								<tr><td>Waktu</td><td colspan='7'> : ".$key['jam_mulai_lembur']." - ".$key['Jam_Akhir_Lembur']."</td></tr>
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
			$data[$number]['isiPesan'] .= "<tr>
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
			$op_spl = $key['user_'];
		}
		$data[$number]['isiPesan'] .= "</table>";
		// print_r($data);exit();
		$this->load->library('PHPMailerAutoload');
		if ($status == '25' or $status == '21') {
			//approve
			foreach ($data as $dt) {
				$message = "<h4>Lembur</h4><hr>
							Kepada Yth Bapak/Ibu<br><br>

							Kami informasikan bahwa SPL yang anda inputkan<br>
							telah di <b>Approve</b> oleh Ass. Ka. Unit.<br>
							Berikut ini daftar yang telah di Approve oleh : <b>$user</b><br>
							dengan keterangan : <b>$ket</b><br><br>
							".$dt['isiPesan']."
							<br>
							Anda dapat melakukan pengecekan di link berikut :<br>
							- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

							<small>Email ini digenerate melalui sistem erp.quick.com pada ".date('d-m-Y H:i:s').".<br>
							Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>";
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = "m.quick.com";
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						));
				$mail->Username = "no-reply";
				$mail->Password = "123456";
				$mail->setFrom("no-reply@quick.com", 'Email Sistem');
				$mail->addAddress("", 'Monitoring Transaction');
				$mail->addAddress($dt['email'], 'Lembur (Approve Asska)');
				$mail->Subject = 'SPL Anda telah di Approve';
				$mail->msgHTML($message);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
			}
		}else{
			//reject
			foreach ($data as $dt) {
				$message = "<h4>Lembur</h4><hr>
							Kepada Yth Bapak/Ibu<br><br>

							Kami informasikan bahwa SPL yang anda inputkan<br>
							telah di <b>Reject</b> oleh Ass. Ka. Unit.<br>
							Berikut ini daftar yang telah di Reject oleh : <b>$user</b><br>
							dengan keterangan : <b>$ket</b><br><br>
							".$dt['isiPesan']."
							<br>
							Anda dapat melakukan pengecekan di link berikut :<br>
							- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

							<small>Email ini digenerate melalui sistem erp.quick.com pada ".date('d-m-Y H:i:s').".<br>
							Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>";

				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = "m.quick.com";
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						));
				$mail->Username = "no-reply";
				$mail->Password = "123456";
				$mail->setFrom("no-reply@quick.com", 'Email Sistem');
				$mail->addAddress("", 'Monitoring Transaction');
				$mail->addAddress($dt['email'], 'Lembur (Approve Asska)');
				$mail->Subject = 'SPL Anda telah di Reject';
				$mail->msgHTML($message);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
			}
		}
	}

	function fp_proces(){
		$time_limit_ver = "10";
		$user_id = $this->input->get('userid');
		$kd_finger = $this->input->get('finger_id');
		$finger	= $this->M_splasska->show_finger_user(array('user_id' => $user_id, 'kd_finger' => $kd_finger));

		$status = $this->input->get('stat');
		$ket = $this->input->get('ket');
		$spl_id = $this->input->get('data');

		echo "
		$user_id;".$finger->finger_data.";SecurityKey;".$time_limit_ver.";".site_url("ALA/Approve/fp_verification?status=$status&spl_id=$spl_id&ket=$ket&finger_id=$kd_finger").";".site_url("ALA/Approve/fp_activation").";extraParams";
		// variabel yang di tmpilkan belum bisa di ubah
	}

	function fp_activation(){
		$filter = array("Verification_Code" => $_GET['vc']);
		$data = $this->M_splasska->show_finger_activation($filter);
		echo $data->Activation_Code.$data->SN;
	}

	function fp_verification(){
		$data = explode(";",$_POST['VerPas']);
		$user_id = $data[0];
		$vStamp = $data[1];
		$time = $data[2];
		$sn = $data[3];

		$filter 	= array("SN" => $sn);
		$kd_finger = $this->input->get('finger_id');
		$fingerData = $this->M_splasska->show_finger_user(array('user_id' => $user_id, 'kd_finger' => $kd_finger));
		$device 	= $this->M_splasska->show_finger_activation($filter);

		$salt = md5($sn.$fingerData->finger_data.$device->Verification_Code.$time.$user_id.$device->VKEY);

		if (strtoupper($vStamp) == strtoupper($salt)) {
			$status = $_GET['status'];
			$spl_id = $_GET['spl_id'];
			$ket = $_GET['ket'];

			echo site_url("ALA/Approve/fp_succes?status=$status&spl_id=$spl_id&ket=$ket");
		}else{
			echo "Parameter invalid..";
		}
	}

	function fp_succes(){
		$status = $_GET['status'];
		$spl_id = $_GET['spl_id'];
		$ket = $_GET['ket'];
		$reject = "";
		foreach(explode('.', $spl_id) as $si){
			if($status == '35'){
				$recheck_spl = $this->M_splasska->recheck_spl($si);
				if($recheck_spl == 0){
					$this->data_spl_approv($si, $status, $ket);
					$this->update_datapresensi($si);
				}else{
					if ($reject == "") {
						$reject .= $si;
					}else{
						$reject .= ".".$si;
					}
				}
			}
		}

		$this->send_email_2($status,$spl_id,$ket);
		$this->session->spl_validasi_waktu_asska = time();
		redirect(site_url("ALA/Approve/result_reject/".$reject));
		// echo "Memproses data lembur<br>";
		// echo "<script>window.close();</script>";
	}

	function result_reject($spl_id = FALSE){
		$data = $this->menu('', '', '');
		$data_spl = array();
		$number = 0;
		if ($spl_id !== FALSE) {
			foreach (explode(".", $spl_id) as $si) {
				$jml_lembur = 0;
				$cek_tspl = $this->M_splasska->cek_spl($si);
				// print_r($cek_tspl);exit();
				if(floatval($cek_tspl->jml_lembur) > 0){
					if ($cek_tspl->kode == '004') {
						$wkt_pkj = $this->M_splasska->get_wkt_pkj($cek_tspl->noind,$cek_stpl->$tanggal);
						$jml_lembur = floatval($cek_tspl->jml_lembur) - $wkt_pkj;
					}else{
						$jml_lembur = floatval($cek_tspl->jml_lembur);
					}
				}

				if($cek_tspl->kode == '004'){
					if ($jml_lembur > 8) {
						$lembur1 = ($jml_lembur - 8) * 4;
						$lembur2 = 3;
						$lembur3 = 14;
					}else if($jml_lembur > 7){
						$lembur1 = ($jml_lembur - 7) * 3;
						$lembur2 = 14;
						$lembur3 = 0;
					}else{
						$lembur1 = $jml_lembur * 2;
						$lembur2 = 0;
						$lembur3 = 0;
					}
				}else{
					if($jml_lembur > 1){
						$lembur1 = ($jml_lembur - 1) * 2;
						$lembur2 = 1.5;
						$lembur3 = 0;
					}else{
						$lembur1 = ($jml_lembur - 8)* 1.5;
						$lembur2 = 0;
						$lembur3 = 0;
					}
				}
				$lembur = $lembur1 + $lembur2 + $lembur3;
				$tdatapresensi = $this->M_splasska->get_tdatapresensi($cek_tspl->noind,$cek_tspl->tanggal);
				$data_spl[$number] = array(
					'tanggal' => $cek_tspl->tanggal,
					'noind' => $cek_tspl->noind,
					'lembur' => $lembur,
					'lembur_2' => $tdatapresensi->total_lembur
				);
			}

		}
		$data['data']	= $data_spl;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/AssKa/V_result',$data);
		$this->load->view('V_Footer',$data);
	}

}
