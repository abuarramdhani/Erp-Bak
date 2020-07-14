<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Presensi_DL extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
		$this->load->helper('url');
        $this->load->helper('html');
          //load the login model
		$this->load->library('Log_Activity');
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('Presensi/MainMenu/M_presensi_dl');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect();
		}
	}

public function Index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$noind = $this->input->get('noind');
		$awl = $this->input->get('awl');
		$akh = $this->input->get('akh');

		if(empty($noind) && !empty($awl)){
			$where_dl = "where DATE_FORMAT(tab.aktual,'%Y-%m-%d') between '".$awl."' and '".$akh."'";
		}elseif(!empty($noind) && empty($awl)){
			$where_dl = "where tp.noind='".$noind."'";
		}elseif(!empty($noind) && !empty($awl)){
			$where_dl = "where tp.noind='".$noind."' and DATE_FORMAT(tab.aktual,'%Y-%m-%d') between '".$awl."' and '".$akh."'";
		}else{
			$where_dl = "where DATE_FORMAT(tab.aktual,'%Y-%m-%d')='".date('Y-m-d')."'";
		}

		if(empty($noind) && !empty($awl)){
			$where_prs = "where tgl_realisasi between '".$awl."' and '".$akh."'";
		}elseif(!empty($noind) && empty($awl)){
			$where_prs = "where noind='".$noind."'";
		}elseif(!empty($noind) && !empty($awl)){
			$where_prs = "where noind='".$noind."' and tgl_realisasi between '".$awl."' and '".$akh."'";
		}else{
			$where_prs = "where tgl_realisasi='".date('Y-m-d')."'";
		}

		$data['Menu'] = 'Presensi';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['SubMenuTwo'] = 'Presensi DL';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['Title'] = 'Monitoring Presensi Dinas Luar';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tspdl'] 		= $this->M_presensi_dl->ambilPekerjaDL($where_dl);
		$data['presensidl'] = $this->M_presensi_dl->cekPresensiDL($where_prs);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiDL/V_index', $data);
		$this->load->view('V_Footer',$data);

	}

public function get_js_pekerja()
	{
		$this->checkSession();

		$employee = $_GET['p'];
		$employee = strtoupper($employee);
		$data = $this->M_presensi_dl->getPekerja($employee);
		echo json_encode($data);
	}

public function get_js_kendaraan()
	{
		$this->checkSession();
		$kendaraan = $_GET['p'];
		$kendaraan = strtoupper($kendaraan);
		$data = $this->M_presensi_dl->getkendaraan($kendaraan);
		echo json_encode($data);
	}

public function get_js_seksi()
	{
		$this->checkSession();

		$seksi = $_GET['p'];
		$seksi = strtoupper($seksi);
		$data = $this->M_presensi_dl->getSeksi($seksi);
		echo json_encode($data);
	}

// public function seksi_disabled(){
// 		$noind = $this->input->post('noind');
// 		$get_seksi = $this->M_presensi_dl->getSeksi_byID($noind);
// 	}

public function CariDataDinasLuar(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$v_pencarian	= $this->input->post('Pencarian');
		$v_noind		= $this->input->post('NamaPekerja');
		$v_tanggal 	= $this->input->post('txtTglBerangkat_prs');
		$v_dept		= $this->input->post('cmbDepartemen');
		$v_bidang		= $this->input->post('cmbBidang');
		$v_unit		= $this->input->post('cmbUnit');
		$v_seksi		= $this->input->post('cmbSeksi');
		// echo $v_unit;
		// exit();

		if ($v_tanggal!=null) {
			$split_tanggal = explode(' - ',$v_tanggal);
		}else{
			$split_tanggal = null;
		}

		$klausa_where = $this->klausa_where($v_noind,$split_tanggal[0],$split_tanggal[1],$v_dept,$v_bidang,$v_unit,$v_seksi);
		if ($v_noind==null && $v_tanggal==null && $v_dept==null && $v_bidang==null && $v_unit==null && $v_seksi==null || $v_dept=='0') {
			$condition = "where keluar=false";
		}else{
			$condition = "and keluar=false";
		}

		$data['Pencarian'] = $v_pencarian;
		if ($data['Pencarian']=='data') {
			$data['Presensi'] = $this->M_presensi_dl->pencarian_pekerja_dl($klausa_where);
		}elseif ($data['Pencarian']=='rekap') {
			$data['ConvertPresensi'] = $this->M_presensi_dl->convert_pekerja_dl($klausa_where,$split_tanggal[1]);
		}else{
			$data['Monitoring'] = $this->M_presensi_dl->monitoring_pekerja_dl($klausa_where,$condition);
		}

		$data['Menu'] = 'Presensi';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['SubMenuTwo'] = 'Presensi DL';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['Title'] = 'Monitoring Presensi Dinas Luar';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiDL/V_data', $data);
		$this->load->view('V_Footer',$data);

	}

	public function fileDinasLuar($spdl){
			$data['SuratTugas'] 		= $this->M_presensi_dl->getSuratTugas($spdl);
			//insert to sys.log_activity
			$aksi = 'Presensi DL';
			$detail = "Preview Surat Tugas spdl=$spdl";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 5, 5, 0, 0, 'P');
			$filename = 'SuratTugas.pdf';
			$html = $this->load->view('Presensi/MainMenu/PresensiDL/V_export',$data, true);
			$pdf->WriteHTML($html);
			$pdf->Output($filename, 'I');
	}

	private function klausa_where($noind,$tanggal1,$tanggal2,$dept,$bidang,$unit,$seksi){
		if($noind!=null || $tanggal1!=null || $dept!=null && $dept!='0'){
	            $where = "where";
	        }else{
	            $where = "";
	        }

	        if($seksi==null){
	            if($unit==null){
	                if($bidang==null){
	                    if($dept==null || $dept=='0'){
	                        $dept = "";
	                    }else{
	                        if($dept!=null && ($tanggal1!=null || $noind!=null)){
	                            $dept = "and left(kodesie,1)='$dept'";
	                        }else{
	                            $dept = "left(kodesie,1)='$dept'";
	                        }
	                    }
	                }else{
	                	if ($tanggal1!=null || $noind!=null) {
	                		$dept = "";
	                    	$bidang = "and left(kodesie,3)='$bidang'";
	                	}else {
		                    $dept = "";
		                    $bidang = "left(kodesie,3)='$bidang'";
	                	}
	                }
	            }else{
	            	if ($tanggal1!=null || $noind!=null) {
		                $dept = "";
		                $bidang = "";
		                $unit = "and left(kodesie,5)='$unit'";
	            	}else{
	            		$dept = "";
		                $bidang = "";
		                $unit = "left(kodesie,5)='$unit'";
	            	}
	            }
	        }else{
	        	if ($tanggal1!=null || $noind!=null) {
	        		$dept = "";
		            $bidang = "";
		            $unit = "";
		            $seksi = "and left(kodesie,7)='$seksi'";
	        	}else {
		            $dept = "";
		            $bidang = "";
		            $unit = "";
		            $seksi = "left(kodesie,7)='$seksi'";

	        	}
	        }
	        if($tanggal1!=null){
	            if($noind!=null){
	                $tanggal = "and tanggal between '$tanggal1' and '$tanggal2'";
	            }else{
	                $tanggal = "tanggal between '$tanggal1' and '$tanggal2'";
	            }
	        }else{
	        	$tanggal = "";
	        }
	        if($noind!=null){
	            $noind = "noind='$noind'";
	        }

	        $klausa_where = $where." ".$noind." ".$tanggal." ".$dept." ".$bidang." ".$unit." ".$seksi;
	        return $klausa_where;
	}

	public function editTanggalRealisasi($spdl){
		$this->checkSession();
		$user_id = $this->session->userid;

		$id = $this->input->get('id');

		$data['Menu'] = 'Presensi';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['SubMenuTwo'] = 'Presensi DL';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['Title'] = 'Monitoring Presensi Dinas Luar';

		$data['item_spdl'] = $this->M_presensi_dl->editSDPL($spdl);
		$data['item_pekerja'] = $this->M_presensi_dl->dataPekerja($id);
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['spdl'] = $spdl;
		$data['id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiDL/V_EditRealisasi', $data);
		$this->load->view('V_Footer',$data);
	}

	public function actEditTanggalRealisasi($spdl){
		$tanggal = $this->input->post('tglRealisasi');
		$waktu = $this->input->post('wktRealisasi');
		$id = $this->input->get('id');
		$length = count($tanggal);
		for($i=0;$i<$length;$i++){
			if(($i % 2) == 0){
	          $stat = 0;
	        }else{
	          $stat = 1;
	        }
			$update = $this->M_presensi_dl->updateRealisasi($spdl,$tanggal[$i],$waktu[$i],$stat);
			//insert to sys.log_activity
			$aksi = 'Presensi DL';
			$detail = "Update tanggal realisasi id=$id menjadi tanggal=$tanggal";
			$this->log_activity->activity_log($aksi, $detail);
			//
		}
		redirect(site_url('Presensi/PresensiDL/editTanggalRealisasi/'.$spdl."?id=".$id));
	    exit;
	}

	public function InsertPresensiManual(){
		date_default_timezone_set("Asia/Bangkok");
		$id = $this->input->post('NamaPekerja');
		$spdl = $this->input->post('txtSPDL');
		$tglBerangkat = $this->input->post('txtTglBerangkat');
		$timeBerangkat = date('H:i:s',strtotime($this->input->post('txtTimeBerangkat')));
		$tglPulang = $this->input->post('txtTglPulang');
		$timePulang = date('H:i:s',strtotime($this->input->post('txtTimePulang')));
		$date_now = date('Y-m-d');
		$time_now = date('H:i:s');
		$user_id = $this->session->userid;
		$getKodesie = $this->M_presensi_dl->dataPekerja($id);
		$kodesie = $getKodesie->kodesie;
			if($tglBerangkat != null and $tglPulang != null){
				$stat = "and stat in ('0','1')";
				//insert to sys.log_activity
				$aksi = 'Presensi';
				$detail = "Delete presensi SPDL=$spdl & Insert Presensi manual id=$id";
				$this->log_activity->activity_log($aksi, $detail);
				//
				$this->M_presensi_dl->deletePresensi($spdl,$stat);
				$this->M_presensi_dl->insertPresensi($date_now,$id,$kodesie,$time_now,$userid,null,0,$spdl,0,$tglBerangkat,$timeBerangkat);
				$this->M_presensi_dl->insertPresensi($date_now,$id,$kodesie,$time_now,$userid,null,0,$spdl,1,$tglPulang,$timePulang);
			}elseif($tglBerangkat != null and $tglPulang == null){
				$stat = "and stat in ('0')";
				//insert to sys.log_activity
				$aksi = 'Presensi';
				$detail = "Delete presensi SPDL=$spdl & Insert Presensi manual id=$id";
				$this->log_activity->activity_log($aksi, $detail);
				//
				$this->M_presensi_dl->deletePresensi($spdl,$stat);
				$this->M_presensi_dl->insertPresensi($date_now,$id,$kodesie,$time_now,$userid,null,0,$spdl,0,$tglBerangkat,$timeBerangkat);
			}elseif($tglPulang != null and $tglBerangkat == null){
				$stat = "and stat in ('1')";
				//insert to sys.log_activity
				$aksi = 'Presensi DL';
				$detail = "Delete presensi SPDL=$spdl & Insert Presensi manual id=$id";
				$this->log_activity->activity_log($aksi, $detail);
				//
				$this->M_presensi_dl->deletePresensi($spdl,$stat);
				$this->M_presensi_dl->insertPresensi($date_now,$id,$kodesie,$time_now,$userid,null,0,$spdl,1,$tglPulang,$timePulang);
			}else{
				//no action
			}
		redirect(site_url('Presensi/PresensiDL/'));
	}

	public function InputKendaraanManual(){
		date_default_timezone_set("Asia/Bangkok");
		$nopol = $this->input->post('NomorKendaraan');
		$noind = $this->input->post('NamaPekerja');
		$spdl = $this->input->post('txtSPDL');
		$kmberangkat = $this->input->post('txtKmBerangkat');
		$kmpulang = $this->input->post('txtKmPulang');
		$getKendaraan = $this->M_presensi_dl->getKendaraan($noind);

		$user_id = $this->session->userid;

		//insert to sys.log_activity
		$aksi = 'Presensi DL';
		$detail = "Insert Kendaraan Manual nopol=$nopol spdl=$spdl noind=$noind";
		$this->log_activity->activity_log($aksi, $detail);
		//

		if($kmberangkat!=null){
			$deleteKendaraan = $this->M_presensi_dl->deleteKendaraan($spdl,$noind,0);
			$insertBerangkat = $this->M_presensi_dl->insertKilometerKendaraan($nopol,date('Y-m-d'),date('H:i:s'),0,$noind,'-',0,$spdl,0,$user_id,$kmberangkat);
		}

		if($kmpulang!=null){
			$deleteKendaraan = $this->M_presensi_dl->deleteKendaraan($spdl,$noind,1);
			$insertPulang = $this->M_presensi_dl->insertKilometerKendaraan($nopol,date('Y-m-d'),date('H:i:s'),0,$noind,'-',1,$spdl,0,$user_id,$kmpulang);
		}
		redirect(site_url('Presensi/PresensiDL/'));
	}

	public function search_scan(){
		$tgl = $this->input->post('prs_tglfilterdl');
		$nama = $this->input->post('prs_pekerjaDL');
		$split_tanggal = explode("-", $tgl);

		redirect('Presensi/PresensiDL?noind='.$nama.'&awl='.date("Y-m-d",strtotime($split_tanggal[0])).'&akh='.date("Y-m-d",strtotime($split_tanggal[1])));
	}
}
