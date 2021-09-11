<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MonitoringOrder extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderToolMaking/M_monitoringorder');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Order';
		$data['Menu'] = 'Request Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->session->user;
		$data['siapa'] = 'Kasie PPC TM';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderToolMaking/V_MonitoringOrder', $data);
		$this->load->view('V_Footer',$data);
	}
	// view detail ada di c_monitoringorder folder approval tool making

	function getUser(){
		$term = $this->input->get('term',TRUE);
		$term = 'TOOL MAKING';
		$data = $this->M_monitoringorder->getUser($term);
		echo json_encode($data);
	}
		
	public function savedatafix(){
		$nama 			= $this->input->post('revisi[]'); // hal yg direvisi
		$isi 			= $this->input->post('isi_rev[]'); // value revisi
		$no_order 		= $this->input->post('no_order');
		$ket 			= $this->input->post('ket'); // detail tabel baru/ modifikasi/ rekondisi
		$assign_order   = $this->input->post('assign_order');
		$estimasi_finish= $this->input->post('estimasi_finish');
		$no_alat_tm    	= $this->input->post('no_alat_tm');
		$keterangan     = $this->input->post('keterangan');
		$jml_alat     	= $this->input->post('jml_alat');
		$jml_alat		= $jml_alat == '' || $jml_alat == 0 ? 1 : $jml_alat;
		
		$action = 1; // action auto accept wkwkw
		$cek = $this->M_monitoringorder->cekaction($no_order, "and person = 9"); // status 9 = sudah approve resp otm - tool making
		if (empty($cek)) {
			$this->M_monitoringorder->saveaction($no_order, 9, $action, $keterangan, date('Y-m-d H:i:s'), $this->session->user);
		}else {
			$this->M_monitoringorder->updateaction($no_order, 9, $action, $keterangan, date('Y-m-d H:i:s'), $this->session->user);
		}

			// echo "<pre>";print_r($ket);exit();
		$noalat = !empty($no_alat_tm) ? $no_alat_tm : "";
		if ($ket == 'Modifikasi') {
			$this->M_monitoringorder->updatemodif($no_order, $assign_order, $estimasi_finish, $noalat);
			$getdata = $this->M_monitoringorder->getdatamodif("where no_order = '".$no_order."'");
		}elseif($ket == 'Rekondisi') {
			$this->M_monitoringorder->updaterekon($no_order, $assign_order, $estimasi_finish, $noalat);
			$getdata = $this->M_monitoringorder->getdatarekondisi("where no_order = '".$no_order."'");
		}else {
			$this->M_monitoringorder->updatebaru($no_order, $assign_order, $estimasi_finish, $noalat);
			$getdata = $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		}

		// order lantuma
		$fix = $this->getdatafix($getdata, $ket, '');
		if(stripos($fix['jenis'], 'FIXTURE') !== FALSE || stripos($fix['jenis'], 'MASTER') !== FALSE || stripos($fix['jenis'], 'GAUGE') !== FALSE || stripos($fix['jenis'], 'ALAT LAIN') !== FALSE) {
			// memisahkan jenis dan keterangan jenis
			if (stripos($fix['jenis'], 'FIXTURE') !== FALSE) {
				$jenis = substr($fix['jenis'],0,7);
			}elseif (stripos($fix['jenis'], 'MASTER') !== FALSE) {
				$jenis = substr($fix['jenis'],0,6);
			}elseif (stripos($fix['jenis'], 'GAUGE') !== FALSE) {
				$jenis = substr($fix['jenis'],0,5);
			}elseif (stripos($fix['jenis'], 'ALAT LAIN') !== FALSE) {
				$jenis = substr($fix['jenis'],0,9);
			}
		}else {
			$jenis = $fix['jenis'];
		}

		$user2 = explode("; ", $fix['user_nama']);
		
		for ($t=0; $t < $jml_alat; $t++) { 
			$noorder = $jml_alat == 1 ? $no_order : $this->buat_noorder($no_order, $t);
			$torder = array('fd_tgl_order' 	=> DateTime::createFromFormat('d/m/Y', $fix['tgl_order'])->format('Y-m-d'),
						'fd_tgl_tmc' 	=> date('Y-m-d'),
						'fs_no_order' 	=> $noorder,
						'fs_seksi' 		=> $fix['seksi'],
						'fs_no_tool' 	=> $ket == 'Baru' ? $noalat : $fix['no_alat'],
						'fs_nm_tool' 	=> $jenis,
						'fs_kd_komp' 	=> $fix['kodekomp'],
						'fs_nm_komp' 	=> $fix['namakomp'],
						'fs_type' 		=> $fix['tipe_produk'],
						'fs_kasus' 		=> $ket == 'Baru' ? 'Buat Baru' : $fix['alasan'],
						'fs_status_alat'=> $ket == 'Modifikasi' ? 'Modif' : $ket,
						'fs_kelompok' 	=> $jenis,
						'fd_tgl_backtmc'=> '9999-01-01',
						'fs_solusi' 	=> $fix['referensi'],
						'fs_status_mat'=> '',
						'fd_tgl_mach'	=> '9999-01-01',
						'fd_tgl_est' 	=> empty($estimasi_finish) ? '9999-01-01' : DateTime::createFromFormat('d/m/Y', $estimasi_finish)->format('Y-m-d'),
						'fd_tgl_real'	=> '9999-01-01',
						'fd_tgl_gambar' => DateTime::createFromFormat('d/m/Y', $fix['tgl_rilis'])->format('Y-m-d'),
						'fs_catatan'	=> '',
						'fs_kerja' 		=> $assign_order,
						'fs_no_trial'	=> '',
						'fd_tgl_trial'	=> '9999-01-01',
						'fd_tgl_ptr'	=> '9999-01-01',
						'fs_saran_ptr'	=> '',
						'fd_tgl_kiab'	=> '9999-01-01',
						'fs_saran_kiab'	=> '',
						'fs_hasil'		=> '',
						'fs_kirim'		=> '',
						'fd_tgl_kirim'	=> '9999-01-01',
						'fs_catkirim'	=> '',
						'fs_catorder'	=> '',
						'fd_tgl_est_trial'=> '9999-01-01',
						'fd_est_kirim_user'=> '9999-01-01',
						'fd_tgl_kirim'=> '9999-01-01',
						'fd_tgl_usulan' => DateTime::createFromFormat('d/m/Y', $fix['tgl_usul'])->format('Y-m-d'),
						'fs_nm_mesin' 	=> $ket == 'Baru' ? $fix['mesin'] : '',
						'fs_no_asset' 	=> $ket == 'Baru' ? $fix['no_proposal'] : '',
						'fs_user' 		=> count($user2) < ($t+1) ? $user2[0] : $user2[$t],
						'fs_status' 	=> 'PPC TM',
						'fs_kerja_mach' => $assign_order,
			);
			$save = $this->M_monitoringorder->save_torder($torder); 

			$tdetail = array('fd_tgl_order' => DateTime::createFromFormat('d/m/Y', $fix['tgl_order'])->format('Y-m-d'),
							'fs_no_order' 	=> $noorder,
							'fs_no_tool' 	=> $ket == 'Baru' ? $noalat : $fix['no_alat'],
							'fs_proses'.$fix['proses_ke'].'' => $fix['poin'],
							'fd_tgl_kirim8'	=> '9999-01-01',
							'fd_tgl_back8'	=> '9999-01-01',
							'fd_tgl_kirim9'	=> '9999-01-01',
							'fd_tgl_back9'	=> '9999-01-01',
							'fs_proses9'	=> '',
							'fs_proses10'	=> '',
							'fd_tgl_kirim10'=> '9999-01-01',
							'fd_tgl_assy'	=> '9999-01-01',
							'fs_kelompok'	=> $jenis,
							'fs_proses_lanjut' 	=> '',
							'fs_ket' 		=> $ket == 'Baru' ? 'baru' : '',
			);
			$save = $this->M_monitoringorder->save_torder_detail($tdetail); 
		}
		// echo "<pre>";print_r($fix);exit();
		
	redirect(base_url('OrderToolMakingTM/MonitoringOrder/'));
	}

	public function buat_noorder($no_order, $n){
		for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
		$r = chr($n%26 + 0x41) . $r;
		return $no_order.$r;
	}
		
	public function PrintOrderModifikasi($no_order){
		$getdata = $this->M_monitoringorder->getdatamodif("where no_order = '".$no_order."'");
		$ket = 'Modifikasi';
		$data['fix'] = $this->getdatafix($getdata, $ket, ''); // cari data yg akan ditampilkan
		$data['approval'] = $this->getapproval($no_order);
		$data['komen'] = $this->getKomen($no_order);
		// echo "<pre>";print_r($data['komen']);exit();
		
		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4-L', 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'ImportToolRoom.pdf';
		$html = $this->load->view('OrderToolMaking/V_PdfOrder', $data, true);
		ob_end_clean();
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');
	}

	public function PrintOrderRekondisi($no_order){
		$getdata = $this->M_monitoringorder->getdatarekondisi("where no_order = '".$no_order."'");
		$ket = 'Rekondisi';
		$data['fix'] = $this->getdatafix($getdata, $ket, ''); // cari data yg akan ditampilkan
		$data['approval'] = $this->getapproval($no_order);
		$data['komen'] = $this->getKomen($no_order);
		// echo "<pre>";print_r($data['komen']);exit();
		
		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4-L', 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'ImportToolRoom.pdf';
		$html = $this->load->view('OrderToolMaking/V_PdfOrder', $data, true);
		ob_end_clean();
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');
	}

	public function PrintOrderBaru($no_order){
		$getdata = $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		$ket = 'Baru';
		$data['fix'] = $this->getdatafix($getdata, $ket, ''); // cari data yg akan ditampilkan
		$data['approval'] = $this->getapproval($no_order);
		$data['komen'] = $this->getKomen($no_order);
		// echo "<pre>";print_r($data['komen']);exit();
		// echo "<pre>";print_r($data['approval']);exit();
		
		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4-L', 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'ImportToolRoom.pdf';
		$html = $this->load->view('OrderToolMaking/V_PdfOrder', $data, true);
		ob_end_clean();
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');
	}
	
	public function PrintAsset($no_order){
		$getdata = $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		$ket = 'Baru';
		$data['fix'] = $this->getdatafix($getdata, $ket, ''); // cari data yg akan ditampilkan
		$data['approval'] = $this->getapproval2($no_order);
		// echo "<pre>";print_r($data['komen']);exit();
		// echo "<pre>";print_r($data['fix']);exit();
		
		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4-P', 0, '', 8, 8, 8, 8, 0, 0);
		$filename 	= 'ImportToolRoom.pdf';
		$html = $this->load->view('OrderToolMaking/V_PdfAsset', $data, true);
		ob_end_clean();
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');
	}

	public function getapproval2($no_order){
		$data = $this->M_monitoringorder->cekapproval2($no_order);
		$approval[2] = $approval[9] = $approval[6] = $approval[7] = array();
		for ($i=0; $i < count($data) ; $i++) { 
			$nama = $this->M_monitoringorder->getseksiunit($data[$i]['approved_by']);
			$data[$i]['nama_approver'] = !empty($nama) ? $nama[0]['nama'] : '';
			$approval[$data[$i]['approval']] = $data[$i];
		}
		return $approval;
	}
	
	public function getapproval($no_order){
		$data = $this->M_monitoringorder->cekapproval($no_order);
		$approval = array();
		for ($i=0; $i < count($data) ; $i++) { 
			$approval[] = $data[$i]['approval'];
		}
		return $approval;
	}

	public function getdatafix($data, $ket){ // cari data yg akan ditampilkan
		$fix = array();
		foreach ($data as $key => $val) {
			$fix['ket'] 		= $ket;
			$fix['no_order'] 	= $val['no_order'];
			$fix['tgl_order'] 	= date('d/m/Y', strtotime($val['tgl_order']));
			$fix['pengorder'] 	= $val['pengorder'];
			$nama = $this->M_monitoringorder->getseksiunit($val['pengorder']);
			$fix['nama_pengorder'] 		= $nama[0]['nama'];
			$fix['seksi'] 		= $val['seksi'];
			$fix['unit'] 		= $val['unit'];
			$fix['jenis'] 		= $val['jenis'];
			$fix['user_nama'] 	= $this->carirevisi($val['no_order'], $val['nama_user'], 'User');
			// $fix['file_proposal'] = $val['file_proposal'];
			// $fix['no_proposal'] = $this->carirevisi($val['no_order'], $val['no_proposal'], 'No Proposal');
			$fix['tgl_usul'] 	= $this->carirevisi($val['no_order'], date('d/m/Y', strtotime($val['tgl_usulan'])), 'Usulan Order Selesai');
			$fix['gamker'] 		= $val['gambar_kerja'];
			$fix['folder_gamker'] = $this->carirevisi($val['no_order'], $val['gambar_kerja'], 'Gambar Produk');
			$fix['skets'] 		= $val['skets'];
			$fix['skets'] 		= $this->carirevisi($val['no_order'], $val['skets'], 'Skets');
			$fix['kodekomp'] 	= $this->carirevisi($val['no_order'], $val['kode_komponen'], 'Kode Komponen');
			$fix['namakomp'] 	= $this->carirevisi($val['no_order'], $val['nama_komponen'], 'Nama Komponen');
			$fix['tipe_produk'] = $this->carirevisi($val['no_order'], $val['tipe_produk'], 'Tipe Produk');
			$fix['tgl_rilis'] 	= $this->carirevisi($val['no_order'], date('d/m/Y', strtotime($val['tgl_rilis'])), 'Tanggal Rilis Gambar');
			$fix['poin_awal']	= $val['poin'];
			$fix['poin'] 		= $this->carirevisi($val['no_order'], $val['poin'], 'Proses');
			$fix['rev_poin_by'] = $this->carirevisiby($val['no_order'], $val['poin'], 'Proses');
			$fix['proses_ke'] 	= $this->carirevisi($val['no_order'], $val['proses_ke'], 'Proses Ke');
			$fix['dari'] 		= $this->carirevisi($val['no_order'], $val['dari'], 'Dari');
			$fix['referensi'] 	= $this->carirevisi($val['no_order'], $val['referensi'], 'Referensi / Datum Alat Bantu');
			$fix['action']		= $this->cariaction($val['no_order'], 'Kepala Seksi Tool Making');
			$fix['no_alat_tm'] 	= $val['no_alat_tm'];
			$fix['assign_order'] = $val['assign_order'];
			$fix['assign_approval'] = $val['assign_approval'];
			$nama = $this->M_monitoringorder->getseksiunit($val['assign_approval']);
			$fix['nama_assignapproval'] = $nama[0]['nama'];
			$fix['assign_desainer'] = $val['assign_desainer'];
			$fix['stp_gambar_kerja'] = $val['stp_gambar_kerja'];
			$fix['status_order'] = $val['status_order'];
			$fix['pengorder'] = $val['pengorder'];
			$fix['reject_by'] = $val['reject_by'];
			$fix['alasan_reject'] = $val['alasan_reject'];
			$fix['estimasi_finish'] = $val['estimasi_finish'] == '' || $val['estimasi_finish'] == '0001-01-01 BC' ? '' : date('d/m/Y', strtotime($val['estimasi_finish']));
		
			if ($ket == 'Baru') {
				$fix['file_proposal'] = $val['file_proposal'];
				$fix['no_proposal'] = $val['no_proposal'];
				$fix['mesin'] 		= $this->carirevisi($val['no_order'], $val['mesin'], 'Mesin Yang Digunakan');
				$fix['dimensi'] 	= $this->carirevisi($val['no_order'], $val['dimensi'], 'Dimensi dan Toleransi (Untuk Gauge)');
				$fix['flow_sebelum']= $this->carirevisi($val['no_order'], $val['flow_sebelum'], 'Flow Proses Sebelumnya');
				$sebelum 			= explode(' - ', $fix['flow_sebelum']);
				$fix['f_sebelum']	= $sebelum[0];
				$fix['flow_sesudah']= $this->carirevisi($val['no_order'], $val['flow_sesudah'], 'Flow Proses Sesudahnya');
				$sesudah 			= explode(' - ', $fix['flow_sesudah']);
				$fix['f_sesudah']	= $sesudah[0];
				$fix['acuan_alat'] 	= $this->carirevisi($val['no_order'], $val['acuan_alat_bantu'], 'Acuan Alat Bantu');
				$fix['layout_alat'] = $this->carirevisi($val['no_order'], $val['layout_alat_bantu'], 'Layout Alat Bantu');
				$fix['material'] 	= $this->carirevisi($val['no_order'], $val['material_blank'], 'Material Blank (Khusus DIES)');
				$fix['jml_alat']	= $this->carirevisi($val['no_order'], $val['jumlah_alat'], 'Jumlah Alat');
				$fix['distribusi']	= $this->carirevisi($val['no_order'], $val['distribusi'], 'Distribusi');
				$fix['alasan_asset'] = $this->carirevisi($val['no_order'], $val['alasan_asset'], 'Alasan Asset');
			}else {
				$fix['alasan'] 		= $this->carirevisi($val['no_order'], $val['alasan_modifikasi'], 'Alasan Modifikasi');
				$fix['no_alat'] 	= $this->carirevisi($val['no_order'], $val['no_alat_bantu'], 'No Alat Bantu');
				$fix['inspection_report'] 	= $val['inspection_report'];
			}
		}
		
		return $fix;
	}

	public function getKomen($no_order){
		$getdata = $this->M_monitoringorder->cekaction($no_order, '');
		usort($getdata, function($a, $b) {
			return $a['person'] - $b['person'];
		});
		$komen = array();
		$i = 0;
		foreach ($getdata as $key => $value) {
			if (!empty($value['keterangan'])) {
				$komen[$i]['person'] = $this->cariapp($value['person']);
				$komen[$i]['keterangan'] = $value['keterangan'];
				$i++;
			}

		}
		return $komen;
	}

	public function cariapp($siapa){
		// $person = untuk mencari status approval berdasarkan responsibility yg dibuka user login
		$person = $siapa == 1 ? 'Kasie Pengorder' : // resp. order tool making, 1 = belum approve (status approvalnya)
					($siapa == 2 ? 'Ass Ka Nit Pengorder' : // resp approval tool making, 2 = sudah approve askanit pengorder
					($siapa == 3 ? 'Kasie PE' : //resp. order tool making - pe
					($siapa == 4 ? 'Ass Ka Nit PE' : // resp. order tool making - askanit pe
					($siapa == 5 ? 'Designer Produk' : // resp. order tool making - designer
					($siapa == 6 ? 'Unit QA/QC' : // resp. order tool making - qc qa
					($siapa == 7 ? 'KaDep Produksi' : // resp. order tool making - kadep produksi
					($siapa == 8 ? 'Ass Ka Nit TM' : // resp. order tool making - askanit tool making
					($siapa == 9 ? 'Kasie PPC TM' : '')))))))); // resp order tool making - tool making
		return $person;
	}
		
	public function carirevisi($no_order, $val, $cek){
		$cari 	= $this->M_monitoringorder->cekrevisi($cek, $no_order);
		
		if ($cek == 'Gambar Produk') { // hal yang dicek
			$gb = explode(';', $val);
			for ($i=0; $i < count($gb) ; $i++) { 
				$cari 	= $this->M_monitoringorder->cekrevisi2($cek, $no_order, $gb[$i]); // cek revisi dari approval terbaru
				if (!empty($cari)) { // ada revisi -> ambil data file dari folder $hasil
					$hasil[] = $cari[0]['person'] == 2 ? 'Ass_Ka_Nit_Pengorder' :
							($cari[0]['person'] == 5 ? 'Designer_Produk' :
							($cari[0]['person'] == 3 ? 'Kasie_PE' : 
							($cari[0]['person'] == 4 ? 'Ass_Ka_Nit_PE' : 'Pengorder')));
				}else { // tidak ada revisi -> ambil data file dari folder Pengorder
					$hasil[] = 'Pengorder';
				}
			}
		}elseif($cek == 'Skets'){
			if (!empty($cari)) { // ada revisi -> ambil data file dari folder $hasil
				$hasil = $cari[0]['person'] == 2 ? 'Ass_Ka_Nit_Pengorder' :
						($cari[0]['person'] == 5 ? 'Designer_Produk' :
						($cari[0]['person'] == 3 ? 'Kasie_PE' : 
						($cari[0]['person'] == 4 ? 'Ass_Ka_Nit_PE' : 'Pengorder')));
			}else { // tidak ada revisi -> ambil data file dari folder Pengorder
				$hasil = 'Pengorder';
			}
		}else {
			$hasil 	= !empty($cari) ? $cari[0]['value_rev'] : $val;
		}
		return $hasil;
	}
	
	public function carirevisiby($no_order, $val, $cek){
		$cari 	= $this->M_monitoringorder->cekrevisi($cek, $no_order);
		$hasil 	= !empty($cari) ? $this->cariapp($cari[0]['person']) : '';
		return $hasil;
	}

	public function cariaction($no_order, $siapa){
		$cari = $this->M_monitoringorder->cekaction($no_order, "and person = 9");
		$acc = !empty($cari) ? 'Accept' : '';
		$ket = !empty($cari) ? $cari[0]['keterangan'] : '';
		// echo "<pre>";print_r($cari);exit();

		$action = array('action' => $acc, 'keterangan' => $ket);
		return $action;
	}

}