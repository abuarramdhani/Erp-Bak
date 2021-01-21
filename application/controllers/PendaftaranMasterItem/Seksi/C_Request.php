<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Request extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PendaftaranMasterItem/M_request');
		$this->load->model('PendaftaranMasterItem/M_settingdata');

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

		$data['Title'] = 'Request Master Item';
		$data['Menu'] = 'Request Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view'] = 'req';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}

	public function kodeuom(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getUOM("where kode_uom like '%$term%' or uom like '%$term%'");
		echo json_encode($data);
	}
	
	public function getOrgAssign(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getOrgAssign($term);
		echo json_encode($data);
	}
	
	public function getOrgAssign2(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getOrgGroup($term);
		echo json_encode($data);
	}
	
	public function getItem(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getNamaBarang("AND (msib.segment1 like '%$term%' OR msib.description like '%$term%')");
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function cekItem(){
		$term 	= $this->input->get('term',TRUE);
		$term 	= strtoupper($term);
		$item2 	= $this->input->get('item2',TRUE);
		$ket 	= 'tidak'; // ket awal -> item belum terdaftar
		$data 	= $this->M_request->getNamaBarang("AND msib.segment1 = '$term'");
		$ket 	= !empty($data) ? 'ada' : $ket; // jika sudah ada di msib ket berubah jadi 'ada', kalau tidak ket tidak berubah
		$data2 	= $this->M_request->dataItem("where kode_item = '".$term."'");
		$ket 	= !empty($data2) ? 'ada' : $ket; // jika sudah didaftarkan di master item sebelumnya ket berubah jadi 'ada', kalau tidak ket tidak berubah
		$data3 	= $this->M_request->dataTimKode2($term);
		$ket 	= !empty($data3) ? 'ada' : $ket; // jika sudah didaftarkan di revisi tim kode barang master item sebelumnya ket berubah jadi 'ada', kalau tidak ket tidak berubah
		for ($i=0; $i < count($item2) ; $i++) { // jika sudah dipakai di kode item lain di no dokumen yang sama ket berubah jadi 'ada', kalau tidak ket tidak berubah
			$ket = $term == $item2[$i] ? 'ada' : $ket;
		}
		// echo "<pre>";print_r($data);exit();
		echo json_encode($ket);
	}
	
	public function getDescription(){
		$term = $this->input->post('item');
		$term = strtoupper($term);
		$data = $this->M_request->getDesc($term);
		$hasil = array($data[0]['DESCRIPTION'], $data[0]['INVENTORY_ITEM_ID'], $data[0]['PRIMARY_UOM_CODE']);
		echo json_encode($hasil);
	}
	
	public function org_group(){
		$group = $this->input->post('group');
		$data['org'] = explode('; ', $group);
		$this->load->view('PendaftaranMasterItem/V_RequestOrgGroup', $data);
	}
	
	public function viewrequest(){
		$ket = $this->input->post('ket'); // jenis data yang akan ditampilkan
		$apk = $this->input->post('apk'); // nama responsibility
		$bts = $this->input->post('batas'); // batas data yang akan ditampilkan
		$data['data'] 	= $this->getdata($ket, $apk, $bts);
		$data['warna']	= $this->input->post('warna'); // warna tabel
		$data['iniket'] = $this->input->post('name'); // nama tabel biar beda per resp.
        $this->load->view('PendaftaranMasterItem/V_TblRequest', $data);
	}
	
	public function getdata($ket, $apk, $bts){
		$getdata = $this->M_request->cekheader('order by id_request desc');
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$seksi = $this->M_request->getseksi('id_seksi = '.$value['ID_SEKSI'].''); // cari nama seksi
			$getdata[$key]['SEKSI'] = !empty($seksi) ? $seksi[0]['NAMA_SEKSI'] : 'Seksi tidak ditemukan';
			if ($value['STATUS'] == 'Pengecekan Tim Kode Barang') {
				$status = 1;
			}elseif ($value['STATUS'] == 'Pengecekan Akuntansi') {
				$status = 2;
			}elseif ($value['STATUS'] == 'Pengecekan Pembelian') {
				$status = 3;
			}elseif ($value['STATUS'] == 'Pengecekan PIEA') {
				$status = 4;
			}elseif ($value['STATUS'] == 'Finished') {
				$status = 5;
			}
			// echo "<pre>";print_r($apk);exit();
			if ($apk == 'seksi' || $apk == 'timkode') { // untuk resp. pendaftaran master item dan tim kode barang
				if ($ket == 'ongoing' || $ket == 'performed') { // tabel on going dan performed
					if ($status != $bts) { // batas dari status tidak sama dengan batas yang ditentukan (lihat customPMI)
						array_push($datanya, $getdata[$key]); // simpan datanya
					}
				}else {
					if ($status == $bts) { // batas dari status sama dengan batas yang ditentukan (lihat customPMI)
						array_push($datanya, $getdata[$key]);
					}
				}
			}else {
				if ($ket == 'incoming') { // tabel incoming
					if ($status < $bts) { // batas dari status < batas yang ditentukan (lihat customPMI)
						array_push($datanya, $getdata[$key]);
					}
				}elseif ($ket == 'needed') {
					if ($status == $bts) {
						array_push($datanya, $getdata[$key]);
					}
				}elseif ($ket == 'performed') {
					if ($status > $bts) {
						array_push($datanya, $getdata[$key]);
					}
				}
			}
		}
		return $datanya;
	}

	public function tambahrequest(){ // request baru
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Request Master Item';
		$data['Menu'] = 'Request Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noid = $this->session->user;
		$cari = $this->M_request->getseksiunit($noid);
		$data['seksi'] = $cari[0]['seksi'];
		$data['org_group'] = $this->M_request->getOrgGroup('');
		// echo "<pre>";print_r($data['org_group']);exit();

		$kode = $this->M_request->getseksi("nama_seksi = '".$data['seksi']."'");
		$data['kode_seksi'] = !empty($kode) ? $kode[0]['KODE_SEKSI'] : '';
		$data['id_seksi'] 	= !empty($kode) ? $kode[0]['ID_SEKSI'] : '';
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('PendaftaranMasterItem/V_RequestBaru', $data);
		$this->load->view('V_Footer',$data);
	}

	public function tambahbaristabelreq(){
		$number 	= $this->input->post('number'); 
		$seksi 		= $this->input->post('seksi'); 
		$kode 		= $this->input->post('kode'); 
		$status 	= $this->input->post('status'); 
		$item 		= strtoupper($this->input->post('item')); 
		$desc 		= strtoupper($this->input->post('desc')); 
		$item_id 	= $this->input->post('inv_item_id'); 
		$uom 		= $this->input->post('uom'); 
		$dual_uom 	= $this->input->post('dual_uom');
		$isi_dual 	= $this->input->post('isi_dual');
		$makebuy 	= $this->input->post('makebuy');
		$stock 		= $this->input->post('stock'); 
		$no_serial 	= $this->input->post('no_serial'); 
		$inspect 	= $this->input->post('inspect'); 
		$org		= $this->input->post('org');
		$org_assign = ''; 
		for ($i=0; $i < count($org); $i++) { 
			if ($i == 0) {
				$org_assign .= $org[$i];
			}else {
				$org_assign .= '; '.$org[$i];
			}
		}
		$odm 		= $this->input->post('odm');
		$opm 		= $this->input->post('opm');
		$jual 		= $this->input->post('jual'); 
		$latar 		= $this->input->post('latar'); 
		$keterangan = $this->input->post('keterangan'); 
		// echo "<pre>";print_r($org);exit();
		$odm2 = !empty($odm) ? '<i class="fa fa-check" style="color:green"></i>' : '';
		$opm2 = !empty($opm) ? '<i class="fa fa-check" style="color:green"></i>' : '';
		$jual2 = !empty($jual) ? '<i class="fa fa-check" style="color:green"></i>' : '';

		$tr = '<tr id="baris'.$number.'">
					<td><input type="hidden" name="status2" value="'.$status.'">'.$status.'
						<input type="hidden" name="seksi2" value="'.$seksi.'">
						<input type="hidden" name="kode2" value="'.$kode.'">
						<input type="hidden" name="latar2" value="'.$latar.'">
						<input type="hidden" name="item_id2" value="'.$item_id.'">
						<input type="hidden" class="ininumber" value="'.$number.'"></td>
					<td><input type="hidden" name="item2" class="item2" value="'.$item.'">'.$item.'</td>
					<td><input type="hidden" name="desc2" value="'.$desc.'">'.$desc.'</td>
					<td><input type="hidden" name="uom2" value="'.$uom.'">'.$uom.'</td>
					<td><input type="hidden" name="dual_uom2" value="'.$dual_uom.'">'.$dual_uom.'</td>
					<td><input type="hidden" name="isi_dual2" value="'.$isi_dual.'">'.$isi_dual.'</td>
					<td><input type="hidden" name="makebuy2" value="'.$makebuy.'">'.$makebuy.'</td>
					<td><input type="hidden" name="stock2" value="'.$stock.'">'.$stock.'</td>
					<td><input type="hidden" name="no_serial2" value="'.$no_serial.'">'.$no_serial.'</td>
					<td><input type="hidden" name="inspect2" value="'.$inspect.'">'.$inspect.'</td>
					<td><input type="hidden" name="org2" value="'.$org_assign.'">'.$org_assign.'</td>
					<td><input type="hidden" name="odm2" value="'.$odm.'">'.$odm2.'</td>
					<td><input type="hidden" name="opm2" value="'.$opm.'">'.$opm2.'</td>
					<td><input type="hidden" name="jual2" value="'.$jual.'">'.$jual2.'</td>
					<td><input type="hidden" name="keterangan2" value="'.$keterangan.'">'.$keterangan.'</td>
					<td><button class="btn btn-danger" onclick="deletebaris('.$number.')"><i class="fa fa-minus"></i></button></td>
				</tr>';
		echo $tr;
	}

	public function cekuser(){
		$user 	= $this->session->user;
		$cek 	= $this->M_settingdata->cekemail($user);
		$hasil 	= !empty($cek) ? 'ada' : 'tidak';
		echo $hasil;
	}

	public function saverequest(){
		$seksi 		= $this->input->post('seksi'); 
		$id_kode 	= $this->input->post('id_kode'); 
		$kode 		= $this->input->post('kode'); 
		$status 	= $this->input->post('status'); 
		$item 		= $this->input->post('item'); 
		$desc 		= $this->input->post('desc'); 
		$item_id 	= $this->input->post('item_id'); 
		$uom	 	= $this->input->post('uom'); 
		$dual_uom 	= $this->input->post('dual_uom');
		$isi_dual 	= $this->input->post('isi_dual');
		$makebuy 	= $this->input->post('makebuy');
		$stock 		= $this->input->post('stock'); 
		$no_serial 	= $this->input->post('no_serial'); 
		$inspect 	= $this->input->post('inspect'); 
		$org 		= $this->input->post('org'); 
		$odm 		= $this->input->post('odm');
		$opm 		= $this->input->post('opm');
		$jual 		= $this->input->post('jual'); 
		$latar 		= $this->input->post('latar'); 
		$keterangan = $this->input->post('keterangan'); 
		$tanggal 	= gmdate("d/m/Y H:i:s", time()+60*60*7);
		$pic 		= $this->session->user;
		// echo "<pre>";print_r($item);exit();
		$cek = $this->M_request->cekheader("where to_char(tgl_request, 'MM/YYYY') = '".date('m/Y')."' order by id_request desc");
		if (!empty($cek)) {
			$no = explode("-", $cek[0]['NO_DOKUMEN']);
			$no = $no[4] + 1;
			$no = sprintf("%03d", $no);
			$no = 'FMI-'.$kode[0].'-'.date('y').'-'.date('m').'-'.$no;
		}else {
			$no = 'FMI-'.$kode[0].'-'.date('y').'-'.date('m').'-001';
		}

		$cekidreq 	= $this->M_request->cekheader('order by id_request desc');
		$idreq 		= !empty($cekidreq) ? $cekidreq[0]['ID_REQUEST'] + 1 : 1;
		$cekheader 	= $this->M_request->cekheader("where id_request = '$idreq'"); 
		if (empty($cekheader)) {
			$kirim = 'Akuntansi'; // tujuan kirim email awal
			for ($i=0; $i < count($item) ; $i++) {
				if ($status[$i] == 'P') { // jika terdapat pendaftaran baru/P, tujuan kirim jadi ke Tim Kode Barang
					$kirim = 'Tim Kode Barang'; 
				}else {
					$kirim = $kirim; 
				}
				$cekIdItem 	= $this->M_request->dataItem('order by id_item desc');
				$id_item 	= !empty($cekIdItem) ? $cekIdItem[0]['ID_ITEM'] + 1 : 1;
				$kode_item 	= strtoupper($item[$i]);
				$descitem 	= strtoupper($desc[$i]);
				
				$cariuom = $this->M_request->getUOM("where kode_uom like '%".$uom[$i]."%' or uom like '%".$uom[$i]."%'"); // cari id uom
				if (!empty($cariuom)) { // data uom ada
					$kode_uom = $cariuom[0]['ID_UOM']; // ambil idnya
				}else { // data uom tidak ada
					$cekid = $this->M_request->getUOM("order by id_uom desc");
					$kode_uom = !empty($cekid) ? $cekid[0]['ID_UOM'] + 1 : 1; // buat id uom
					$this->M_request->saveuom($kode_uom, $uom[$i], $uom[$i]);
				}
				//save item yang direquest pendaftaran item
				$item_req	= $this->M_request->saverequest($idreq, $id_item, $status[$i], $item_id[$i], $kode_item, $descitem, $kode_uom, $dual_uom[$i],
							$makebuy[$i], $stock[$i], $no_serial[$i], $inspect[$i], $latar[$i], $keterangan[$i], $isi_dual[$i]);
				// save org assignnya
				$org_asg 	= explode('; ', $org[$i]);
				for ($o=0; $o < count($org_asg); $o++) { 
					$org_assign = $this->M_request->saveOrgAssign($id_item, $org_asg[$o]);
				}
				// save proses lanjutan
				$save_proses = $this->M_request->saveProsesLanjutan($id_item, $odm[$i], $opm[$i], $jual[$i]);
			}
			
			$header = $this->M_request->saveheader($idreq, $no, $id_kode, $tanggal, $pic, $kirim);

			// kirim email ke tujuan kirim
			$mail = new PHPMailer();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			// set smtp
			$mail->isSMTP();
			$mail->Host = 'm.quick.com';
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true)
			);
			$mail->Username = 'no-reply';
			$mail->Password = '123456';
			$mail->WordWrap = 50;
			// set email content
			$mail->setFrom('no-reply@quick.com', 'Email Sistem');
			// cari email berdasarkan tujuan kirim
			$email = $this->M_settingdata->dataEmail("where username = '$kirim'");
			// echo "<pre>";print_r($email);
			foreach ($email as $a) {
				$mail->addAddress($a['EMAIL']);   
				// echo $a['email'];    
			}
			
			$isi = '<h4>PENDAFTARAN MASTER ITEM</h4>
					<b>No Dokumen : '.$no.'</b><br><br>';
			for ($i=0; $i < count($item) ; $i++) {
				if ($status[$i] == 'P') {
					$sts = 'Pendaftaran Baru';
				}elseif ($status[$i] == 'R') {
					$sts = 'Revisi';
				}elseif ($status[$i] == 'I') {
					$sts = 'Inactive';
				}
				
				if ($kirim == 'Tim Kode Barang') { // jika tujuan kirim tim kode barang
					if ($status[$i] == 'P') { // hanya yang pendaftaran baru
						$isi .= '<b>Status : </b>'.$sts.'<br>';
						$isi .= '<b>Kode Item : </b>'.$item[$i].'<br>';
						$isi .= '<b>Deskripsi : </b>'.$desc[$i].'<br><br>';
					}
				}else { // jika tujuan kirim akuntansi
					$isi .= '<b>Status : </b>'.$sts.'<br>';
					$isi .= '<b>Kode Item : </b>'.$item[$i].'<br>';
					$isi .= '<b>Deskripsi : </b>'.$desc[$i].'<br><br>';
				}
			}
			
			$mail->Subject = 'Request Pendaftaran Master Item';
			$mail->msgHTML($isi);
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit();
			} else {
				// echo "Message sent!..<br>";
			}
		}
		echo $no;
	}

	public function lengkapidata($getdata){ // cari data yang dibutuhkan function lain
		$sts = 0; $mk = 0;
		foreach ($getdata as $key => $val) {
			$org = $this->M_request->dataOrgAssign($val['ID_ITEM']); // cari data org assign sesuai id itemnya
			$org_assign = '';
			for ($i=0; $i < count($org) ; $i++) { 
				$org_assign .= $i == 0 ? $org[$i]['ORG_ASSIGN'] : '; '.$org[$i]['ORG_ASSIGN'];
			}
			$getdata[$key]['ORG_ASSIGN'] = $org_assign;
			//untuk bagian ttd v_footerpdf
			$getdata[$key]['KET_TKB'] = $sts = $val['STATUS_REQUEST'] == 'P' ? 1 : $sts; 
			$getdata[$key]['KET_PMB'] = $mk = $val['STATUS_REQUEST'] != 'R' && ($val['MAKE_BUY'] != 'MAKE') ? 1 : $mk;
		}
		return $getdata;
	}

	public function modalDetail(){
		$no 					= $this->input->post('no');
		$data['ket'] 			= $this->input->post('ket');
		$header['no_dokumen'] 	= $this->input->post('nodoc');
		$header['seksi'] 		= $this->input->post('seksi');
		$header['tgl'] 			= $this->input->post('tgl');
		$header['status'] 		= $this->input->post('status');
		
		$getdata = $this->M_request->getdatafull('and kpr.id_request = '.$no.' order by kpr.id_item');
		$data['data'] = $this->lengkapidata($getdata); // cari data yang mau ditampilkan
		$data['header'] = $header;
		// echo "<pre>";print_r($data);exit();
		$this->load->view('PendaftaranMasterItem/V_DetailRequest', $data);
	}

	public function PrintRequest($no){
		$header 	= $this->M_request->cekheader("where id_request = '$no'");
		$seksi 		= $this->M_request->getseksi('id_seksi = '.$header[0]['ID_SEKSI'].'');
		$header[0]['SEKSI'] = !empty($seksi) ? $seksi[0]['NAMA_SEKSI'] : 'Seksi tidak ditemukan';
		$getdata 	= $this->M_request->getdatafull('and kpr.id_request = '.$no.' order by kpr.id_item');
		$inidata 	= $this->lengkapidata($getdata); // cari data yang mau ditampilkan
		$data['data'] 	= $inidata;
		$data['header'] = $header;
		
		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4-L', 0, '', 5, 5, 30, 55, 5, 5);
		$filename 	= 'Pendaftaran_Master_Item.pdf';
		$head = $this->load->view('PendaftaranMasterItem/V_HeaderPdf', $data, true);
		$html = $this->load->view('PendaftaranMasterItem/V_PdfRequest', $data, true);
		$foot = $this->load->view('PendaftaranMasterItem/V_FooterPdf', $data, true);
		ob_end_clean();
		$pdf->SetHTMLHeader($head);	
		$pdf->SetHTMLFooter($foot);		
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');
	}



}