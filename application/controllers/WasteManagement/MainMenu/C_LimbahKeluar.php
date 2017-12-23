<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_LimbahKeluar extends CI_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_limbahkeluar');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();
		$data['perlakuan']= $this->M_limbahkeluar->getPerlakuan();
		$data['satuan'] = $this->M_limbahkeluar->getSatuan();

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtTanggalKeluarHeader', 'tanggal', 'required');
		$this->form_validation->set_rules('txtTujuanLimbahHeader', 'tujuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahKeluar/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_keluar' => date("Y-m-d", strtotime($this->input->post('txtTanggalKeluarHeader'))),
				'jumlah_keluar' => $this->input->post('txtJumlahKeluarHeader', TRUE),
				'tujuan_limbah' => $this->input->post('txtTujuanLimbahHeader', TRUE),
				'nomor_dok' => $this->input->post('txtNomorDokHeader', TRUE),
				'sisa_limbah' => $this->input->post('txtSisaLimbahHeader', TRUE),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'creation_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'jenis_limbah' => $this->input->post('cmbJenisLimbahKeluarHeader', TRUE),
				'perlakuan' => $this->input->post('cmbPerlakuanHeader',TRUE),
				'satuan' => $this->input->post('cmbSatuanHeader', TRUE),
				'sumber_limbah' => $this->input->post('cmbJenisSumberHeader', TRUE),
    		);

			$this->M_limbahkeluar->setLimbahKeluar($data);

			redirect(site_url('WasteManagement/LimbahKeluar/sendMail/create'));
		} //t coba create dulu
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahKeluar'] = $this->M_limbahkeluar->getLimbahKeluar($plaintext_string);
		$data['jenis_limbah'] = $this->M_limbahkeluar->getJenisLimbah();
		$data['perlakuan']= $this->M_limbahkeluar->getPerlakuan();
		$data['satuan'] = $this->M_limbahkeluar->getSatuan();

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtTanggalKeluarHeader', 'tanggal', 'required');
		$this->form_validation->set_rules('txtTujuanLimbahHeader', 'tujuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahKeluar/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_keluar' => date('Y-m-d',strtotime($this->input->post('txtTanggalKeluarHeader',TRUE))),
				'jumlah_keluar' => $this->input->post('txtJumlahKeluarHeader',TRUE),
				'tujuan_limbah' => $this->input->post('txtTujuanLimbahHeader',TRUE),
				'nomor_dok' => $this->input->post('txtNomorDokHeader',TRUE),
				'sisa_limbah' => $this->input->post('txtSisaLimbahHeader',TRUE),
				'last_updated' => date('Y-m-d h:i:s'),
				'last_updated_by' => $this->session->userid,
				'jenis_limbah' => $this->input->post('cmbJenisLimbahKeluarHeader',TRUE),
				'perlakuan' => $this->input->post('cmbPerlakuanHeader',TRUE),
				'satuan' => $this->input->post('cmbSatuanHeader', TRUE),
				'sumber_limbah' => $this->input->post('cmbJenisSumberHeader', TRUE),
    			);
			$this->M_limbahkeluar->updateLimbahKeluar($data, $plaintext_string);

			redirect(site_url('WasteManagement/LimbahKeluar/sendMail/edit'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahKeluar'] = $this->M_limbahkeluar->getLimbahKeluar($plaintext_string);
		$data['User'] = $this->M_limbahkeluar->getUser();

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->deleteLimbahKeluar($plaintext_string);

		redirect(site_url('WasteManagement/LimbahKeluar/sendMail/delete'));
    }

    public function kirimApprove($id)
    {
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->approval($plaintext_string);

		redirect(site_url('WasteManagement/LimbahKeluar'));
    }

    public function kirimReject($id)
    {
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->reject($plaintext_string);

		redirect(site_url('WasteManagement/LimbahKeluar'));	
    }

	public function Record()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Keluar';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['limbah_keluar'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataRecord()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Keluar';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenislimbah = $this->input->post('jenis_limbah',true);

		$periode = $this->input->post('periode', true);
		if($periode == '') {
			$tanggalawal = '';
			$tanggalakhir = '';
		} else {
			$periode = explode('-', $periode);

			$buattanggalawal 	= str_replace('/', '-', $periode[0]);
			$buattanggalakhir	= str_replace('/', '-', $periode[1]);
			$tanggalawal 		= date('Y-m-d', strtotime($buattanggalawal));
			$tanggalakhir 		= date('Y-m-d', strtotime($buattanggalakhir));
		}                                    

		$data['tanggalawal'] = $tanggalawal;
		$data['tanggalakhir']= $tanggalakhir;
		$data['jenislimbah'] = $jenislimbah;

		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();
		$data['filterKeluar'] = $this->M_limbahkeluar->filterLimbahKeluar($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Report()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Logbook Harian';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Logbook Harian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['limbah_keluar'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['limbah_masuk'] = $this->M_limbahkeluar->getLimbahTransaksi();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();
		$data['user_name'] = $this->M_limbahkeluar->getUser();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Logbook', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataReport()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Logbook Harian Limbah B3';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Logbook Harian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenislimbah = $this->input->post('jenis_limbah',true);
		$username = $this->input->post('user_name',true);

		$periode = $this->input->post('periode', true);
		if($periode == '') {
			$tanggalawal = '';
			$tanggalakhir = '';
		} else {
			$periode = explode('-', $periode);

			$buattanggalawal 	= str_replace('/', '-', $periode[0]);
			$buattanggalakhir	= str_replace('/', '-', $periode[1]);
			$tanggalawal 		= date('Y-m-d', strtotime($buattanggalawal));
			$tanggalakhir 		= date('Y-m-d', strtotime($buattanggalakhir));
		}

		$data['tanggalawal'] = $tanggalawal;
		$data['tanggalakhir'] = $tanggalakhir;
		$data['jenislimbah'] = $jenislimbah;
		$data['NamaUser'] = $username;

		$data['tanggalawalformatindo'] 	= date('d-m-Y',strtotime($tanggalawal));
		$data['tanggalakhirformatindo']	= date('d-m-Y',strtotime($tanggalakhir));

		$data['jenis_limbah'] = $this->M_limbahkeluar->getJenisLimbah();
		$data['user_name'] = $this->M_limbahkeluar->getUser();
		$data['filterMasuk'] = $this->M_limbahkeluar->filterLimbahMasuk($tanggalawal,$tanggalakhir,$jenislimbah); 
		$data['filterKeluar'] = $this->M_limbahkeluar->filterLimbahKeluar($tanggalawal,$tanggalakhir,$jenislimbah); 

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Logbook', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakExcel($tanggalawallink,$tanggalakhirlink)
    {
            $this->load->library("Excel");

            $tanggalawalx = str_replace('.', '-', $tanggalawallink);
            $tanggalakhirx = str_replace('.', '-', $tanggalakhirlink);

            $tanggalawal = $this->input->post('excelTglAwal');
            $tanggalakhir = $this->input->post('excelTglAkhir');
            $jenisLimbah = $this->input->post('exceljenislimbah');
            $UserName = $this->input->post('excelusername'); 

			if($tanggalawal == '') $tanggalawal = '';
			if($tanggalakhir == '') $tanggalakhir = '';
			if($jenisLimbah == null) $jenisLimbah == '';

			$data['tanggalawal'] = $tanggalawal; 
			$data['tanggalakhir'] = $tanggalakhir;
			$data['user'] = $UserName;

			$listBulan = array();
			$tgl = date("Ym", strtotime($data['tanggalawal']));
			while($tgl <= date("Ym", strtotime($data['tanggalakhir']))){
				$hasil = substr($tgl, 4);
				array_push($listBulan, $hasil);
			    if(substr($tgl, 4, 2) == "12")
			        $tgl = (date("Y", strtotime($tgl."01")) + 1)."01";
			    else
			        $tgl++;
			}

			$data['listBulan']=array();
			foreach ($listBulan as $i => $bulan) {
				if($bulan == '01') {
					$bulan = 'Januari';
				}elseif($bulan == '02') {
					$bulan = 'Februari';
				}elseif($bulan == '03') {
					$bulan = 'Maret';
				}elseif($bulan == '04') {
					$bulan = 'April';
				}elseif($bulan == '05') {
					$bulan = 'Mei';
				}elseif($bulan == '06') {
					$bulan = 'Juni';
				}elseif($bulan == '07') {
					$bulan = 'Juli';
				}elseif($bulan == '08') {
					$bulan = 'Agustus';
				}elseif($bulan == '09') {
					$bulan = 'September';
				}elseif($bulan == '10') {
					$bulan = 'Oktober';
				}elseif($bulan == '11') {
					$bulan = 'November';
				}elseif($bulan == '12') {
					$bulan = 'Desember';
				}																				
				array_push($data['listBulan'], $bulan);
															
			}

			$allBulan = '';
			$jmlBulan = count($data['listBulan']);
			for($b = 0; $b < $jmlBulan; $b++) {
				if($b == ($jmlBulan-1)) {
					$allBulan .= $data['listBulan'][$b];
				} else {
					$allBulan .= $data['listBulan'][$b].', ';	
				}
			}

			$data['allBulan'] = $allBulan;

            $data['filterMasuk'] = $this->M_limbahkeluar->filterLimbahMasuk($tanggalawal,$tanggalakhir,$jenisLimbah); 
			$data['filterKeluar'] = $this->M_limbahkeluar->filterLimbahKeluar($tanggalawal,$tanggalakhir,$jenisLimbah);
           
            $this->load->view('WasteManagement/LimbahKeluar/V_Excel', $data, true);
    }

    public function selectJenisLimbah(){
		$JenisLimbah_id = $this->input->post('cmbJenisLimbahKeluarHeader');
		$SatuanLimbahKeluar = $this->M_limbahkeluar->selectSatuanLimbah($JenisLimbah_id);
		$SumberLimbahKeluar = $this->M_limbahkeluar->selectSumberLimbah($JenisLimbah_id);

		foreach ($SatuanLimbahKeluar as $SL) {
			$data['limbah_satuan'] = $SL['limbah_satuan'];
		}

		foreach ($SumberLimbahKeluar as $Sumber) {
			$data['sumber'] = $Sumber['sumber'];
		}
		
		echo json_encode($data);
	} 

	function sendMail($action){ 

		$this->load->library('PHPMailerAutoload');

		if($action == 'edit') {
			$keterangan = 'mengubah';
		} elseif($action == 'create') {
			$keterangan = 'menambahkan';
		} elseif($action == 'delete') {
			$keterangan = 'menghapus';
		}

		$mail = new PHPMailer(); 
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        $mail->isSMTP();
        $mail->Host = 'mail.quick.com';
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

        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$message 	= '	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://wwwhtml4/loose.dtd">
				<html>
				<head>
			 	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			  	<title>Mail Generated By System</title>
			  	<style>
				#main 	{
   	 						border: 1px solid black;
   	 						text-align: center;
   	 						border-collapse: collapse;
   	 						width: 100%;
						}
				#detail {
   	 						border: 1px solid black;
   	 						text-align: justify;
   	 						border-collapse: collapse;					
						}

			  	</style>
				</head>
				<body>
						<h3 style="text-decoration: underline;">Waste Management</h3>
					<hr/>
				
					<p> Admin WM telah <b>'.$keterangan.'</b> data <b>Limbah Keluar</b>
					</p>
					<hr/>
					<p>
					Salam,
					<br/>
					<br/>
					<br/>
					<b style="text-decoration: underline;">Pengelola</b>
					<br/>
					</p>
					
				</body>
				</html>';
		
        $mail->setFrom('noreply@quick.com', 'Email Sistem');
        $mail->addAddress('ayu_rakhmadani@quick.com','Ayu Rakhmadani');
        $mail->addAddress('aljir_arafat@quick.com','Aljir Arafat');
        $mail->addAddress('arina_salma@quick.com','Arina Salma Rosyidah');
        $mail->Subject = 'Waste Management';
		$mail->msgHTML($message);
		
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		} else {
			redirect(base_url('WasteManagement/LimbahKeluar'));
		}
	}

}

/* End of file C_LimbahKeluar.php */
/* Location: ./application/controllers/WasteManagement/MainMenu/C_LimbahKeluar.php */
/* Generated automatically on 2017-08-09 12:34:02 */