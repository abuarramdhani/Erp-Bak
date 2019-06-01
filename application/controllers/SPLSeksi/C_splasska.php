<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_splasska extends CI_Controller {
	function __construct() {
        parent::__construct();

        $this->load->library('session');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SPLSeksi/M_splasska');
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
		$this->load->view('SPLSeksi/AssKa/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function data_spl(){
		$data = $this->menu('', '', '');
		$data['lokasi'] = $this->M_splseksi->show_lokasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/AssKa/V_data_spl',$data);
		$this->load->view('V_Footer',$data);
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

	public function data_spl_approv($id, $stat, $ket){
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

	function fp_proces(){
		$time_limit_ver = "10";
		$user_id = $this->input->get('userid');
		$finger	= $this->M_splasska->show_finger_user(array('user_id' => $user_id));

		$status = $this->input->get('stat');
		$ket = $this->input->get('ket');
		$spl_id = $this->input->get('data');

		echo "
		$user_id;".$finger->finger_data.";SecurityKey;".$time_limit_ver.";".site_url("ALA/Approve/fp_verification?status=$status&spl_id=$spl_id&ket=$ket").";".site_url("ALA/Approve/fp_activation").";extraParams";
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
		$fingerData = $this->M_splasska->show_finger_user(array('user_id' => $user_id));
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

		foreach(explode('.', $spl_id) as $si){
			$this->data_spl_approv($si, $status, $ket);
		}

		echo "Memproses data lembur<br>";
		echo "<script>window.close();</script>";
	}

}