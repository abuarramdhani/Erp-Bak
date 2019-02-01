<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$data = $this->menu('', '', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function data_spl(){
		$data = $this->menu('', '', '');
		$data['lokasi'] = $this->M_splseksi->show_lokasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/V_data_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function show_pekerja(){
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

	public function show_seksi(){
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
			
			$index[] = "<a href='".site_url('SPL/EditLembur/'.$sls['ID_SPL'])."' title='Detail'><i class='fa fa-fw fa-search'></i></a>
				<a href='".site_url('SPL/HapusLembur/'.$sls['ID_SPL'])."' title='Hapus'><i class='fa fa-fw fa-trash'></i></a>";
			$index[] = $sls['Tgl_Lembur'];
			$index[] = $sls['Noind'];
			$index[] = $sls['nama'];
			$index[] = $sls['kodesie'];
			$index[] = $sls['seksi'];
			$index[] = $sls['Pekerjaan'];
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['Jam_Mulai_Lembur'];
			$index[] = $sls['Jam_Akhir_Lembur'];
			$index[] = $sls['Break'];
			$index[] = $sls['Istirahat'];
			$index[] = $sls['target'];
			$index[] = $sls['realisasi'];
			$index[] = $sls['alasan_lembur'];
			$index[] = $sls['Deskripsi']." ".$sls['User_'];
			$index[] = $sls['Tgl_Berlaku'];
			
			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	public function data_spl_cetak(){
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
		$html = $this->load->view('SPLSeksi/Seksi/V_cetak_spl',$data, true);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}

	public function hapus_spl($idspl){
		$to_hapus = $this->M_splseksi->drop_spl($idspl);
		redirect(base_url('SPL/ListLembur'));
	}

	public function edit_spl($idspl){
		$data = $this->menu('', '', '');
		$data['jenis_lembur'] = $this->M_splseksi->show_jenis_lembur();
		$data['lembur'] = $this->M_splseksi->show_current_spl('', '', '', $idspl);
		$data['result'] = $this->input->get('result');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/V_edit_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit_spl_submit(){
		$user_id = $this->session->user;
		$tanggal = $this->input->post('tanggal');
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
			"Noind_Baru" => "0000000",
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
			"Noind_Baru" => "0000000",
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

		redirect(base_url('SPL/EditLembur/'.$spl_id.'?result=1'));
	}

	public function new_spl(){
		$data = $this->menu('', '', '');
		$data['jenis_lembur'] = $this->M_splseksi->show_jenis_lembur();
		$data['result'] = $this->input->get('result');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/V_new_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cek_anonymous(){
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

	public function new_spl_submit(){
		$user_id = $this->session->user;
		$tanggal = $this->input->post('tanggal');
		$tanggal = date_format(date_create($tanggal), "Y-m-d");
		$mulai = $this->input->post('waktu_0');
		$mulai = date_format(date_create($mulai), "H:i:s");
		$selesai = $this->input->post('waktu_1');
		$selesai = date_format(date_create($selesai), "H:i:s");
		$lembur = $this->input->post('kd_lembur');
		$istirahat = $this->input->post('istirahat');
		$break = $this->input->post('break');
		$pekerjaan = $this->input->post('pekerjaan');
		$size = sizeof($this->input->post('noind'));

		for($x=0; $x<$size; $x++){
			$noind = $this->input->post("noind[$x]");
			$target = $this->input->post("target[$x]");
			$realisasi = $this->input->post("realisasi[$x]");
			$alasan = $this->input->post("alasan[$x]");

			// Generate ID SPL
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl", "ID_SPL");
			if(empty($maxid)){
				$spl_id = "0000000001";
			}else{
				$spl_id = $maxid->id;	
				$spl_id = substr("0000000000", 0, 10-strlen($spl_id)).$spl_id;
			}

			// Generate ID Riwayat
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
			if(empty($maxid)){
				$splr_id = "0000000001";
			}else{
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
			
			$data_spl = array(
				"ID_SPL" => $spl_id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $tanggal,
				"Noind" => $noind,
				"Noind_Baru" => "0000000",
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
			$to_spl = $this->M_splseksi->save_spl($data_spl);
			
			$data_splr = array(
				"ID_Riwayat" => $splr_id,
				"ID_SPL" => $spl_id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $tanggal,
				"Noind" => $noind,
				"Noind_Baru" => "0000000",
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
			$to_splr = $this->M_splseksi->save_splr($data_splr);

		}
		redirect(base_url('SPL/InputLembur?result=1'));
	}

	public function rekap_spl(){
		$data = $this->menu('', '', '');
		$data['noind'] = $this->M_splseksi->show_noind();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Seksi/V_rekap_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function rekap_spl_filter(){
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
	
}