<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_Sweep extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Hardware/M_sweep');

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		// $this->load->model('Grapic/M_index');
		$this->checkSession();
	}

	public function checkSession() {
		if(!$this->session->is_logged) { redirect('index'); }
	}

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Hardware', 'Hardware', 'Hardware', '', '');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function inputData()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Hardware', 'Hardware', 'Input Data', '', '');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/Sweeping/V_Input',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getDataUser()
	{
		$string = $_GET['q'];
		$data = $this->M_sweep->getDataUser(strtoupper($string));
		echo json_encode($data);
	}

	public function getDescriptionUser()
	{	
		$noInduk = $_GET['noind'];
		$data = $this->M_sweep->getDescriptionUser($noInduk);
		echo json_encode($data);
	}

	public function saveData()
	{
		$noAsset 		= $this->input->post('txtNoAsset');
		$noind 			= $this->input->post('slcNoInduk');
		$nama 			= $this->input->post('txtNama');
		$seksi 			= $this->input->post('txtSeksi');
		$lokasi 		= $this->input->post('slcLokasi');
		$ipAddress 		= $this->input->post('txtIpAddress');
		$sistemOperasi 	= $this->input->post('txtOS');
		$windowsKey 	= $this->input->post('txtWindowsKey');
		$merk 			= $this->input->post('txtMerk');
		$mainboard 		= $this->input->post('txtMainboard');
		$processor 		= $this->input->post('txtProcessor');
		$harddisk 		= $this->input->post('txtHarddisk');
		$typeRam 		= $this->input->post('txtTypeRam');
		$sizeRam 		= $this->input->post('txtSizeRam');
		$vgaCard 		= $this->input->post('txtVgaCard');
		$typeMemoryVga 	= $this->input->post('txtTypeMemoryVga');
		$sizeMemoryVga 	= $this->input->post('txtSizeMemoryVga');
		$cdrom 			= $this->input->post('txtCdRom');
		$lanCard 		= $this->input->post('txtLanCard');
		$aplikasi1 		= $this->input->post('txtAplikasi1');
		$aplikasi2 		= $this->input->post('txtAplikasi2');
		$aplikasi3 		= $this->input->post('txtAplikasi3');
		$aplikasi4 		= $this->input->post('txtAplikasi4');
		$aplikasi5 		= $this->input->post('txtAplikasi5');
		$aplikasi6 		= $this->input->post('txtAplikasi6');
		$aplikasi7 		= $this->input->post('txtAplikasi7');

		$EmailSeksi 	= $this->input->post('txtEmailSeksi');
		$EmailPekerja 	= $this->input->post('txtEmailPekerja');
		$akunPidgin 	= $this->input->post('txtPidgin');
		$voip 			= $this->input->post('txtVoip');
		$openOfice 		= $this->input->post('openOfice');
		$wps 			= $this->input->post('wps');
		$pidginVer 		= $this->input->post('pidgin');
		$thunderbird 	= $this->input->post('thunderbird');
		$chrome 		= $this->input->post('chrome');
		$ie 			= $this->input->post('ie');
		$mozzila 		= $this->input->post('mozzila');
		$teamviewer 	= $this->input->post('Tviewer');
		$vnc_viewer 	= $this->input->post('Vviewer');

		$verifikasi 	= $this->input->post('verifikasi');
		if ($verifikasi) {//can u solve this....
			$remark = 1;
			$remark_date = date('Y-m-d H:i:s');
			$remark_kolom = 'remark_date';
		}else{
			$remark = 0;
			$remark_kolom = 'remark';
			$remark_date = 0;
		}

		$dataUmum = array(
			'no_asset' 			=> strtoupper($noAsset),
			'no_ind'	 		=> strtoupper($noind),
			'nama'	 	 		=> strtoupper($nama),
			'seksi'	 			=> strtoupper($seksi),
			'lokasi' 			=> strtoupper($lokasi),
			'ip_address' 		=> strtoupper($ipAddress),
			'sistem_operasi' 	=> strtoupper($sistemOperasi), 
			'windows_key' 		=> strtoupper($windowsKey),
			'merk' 				=> strtoupper($merk),
			'mainboard'	 		=> strtoupper($mainboard),
			'processor' 		=> strtoupper($processor),
			'harddisk' 			=> strtoupper($harddisk),
			'type_ram' 			=> strtoupper($typeRam),
			'size_ram' 			=> strtoupper($sizeRam),
			'vga_card' 			=> strtoupper($vgaCard),
			'type_vga' 			=> strtoupper($typeMemoryVga),
			'size_vga' 			=> strtoupper($sizeMemoryVga),
			'cd_rom' 			=> strtoupper($cdrom),
			'lan_card' 			=> strtoupper($lanCard),
			'aplikasi_1' 		=> strtoupper($aplikasi1),
			'aplikasi_2' 		=> strtoupper($aplikasi2),
			'aplikasi_3' 		=> strtoupper($aplikasi3),
			'aplikasi_4' 		=> strtoupper($aplikasi4),
			'aplikasi_5' 		=> strtoupper($aplikasi5),
			'aplikasi_6' 		=> strtoupper($aplikasi6),
			'aplikasi_7' 		=> strtoupper($aplikasi7),
			'tgl_input' 		=> date('Y-m-d H:i:s'),
			'petugas_input' 	=> strtoupper($this->session->userdata('user')),
			'email_seksi' 		=> $EmailSeksi,
			'email_pekerja' 	=> $EmailPekerja,
			'pidgin_akun' 		=> $akunPidgin,
			'voip' 				=> strtoupper($voip),
			'creation_date' 	=> date('Y-m-d H:i:s'),
			'created_by' 		=> strtoupper($this->session->userdata('user')),
			'remark' 			=> strtoupper($remark),
			$remark_kolom 		=> strtoupper($remark_date),
			'open_office' 		=> strtoupper($openOfice),
			'wps' 				=> strtoupper($wps),
			'thunderbird' 		=> strtoupper($thunderbird),
			'browser_chrome' 	=> strtoupper($chrome),
			'browser_ie' 		=> strtoupper($ie),
			'browser_mozilla' 	=> strtoupper($mozzila),
			'pidgin' 			=> strtoupper($pidginVer),
			'team_viewer' 		=> strtoupper($teamviewer),
			'vnc_viewer' 		=> strtoupper($vnc_viewer),
			);

		$this->M_sweep->saveDataUmum($dataUmum);

		redirect('hardware/input-data');
	}

	public function viewData()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Hardware', 'Hardware', 'View Data', '', '');
		$data['user'] = $this->session->userdata('user');
		$data['listdata'] = $this->M_sweep->getData();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/Sweeping/V_View_Data',$data);
		$this->load->view('V_Footer',$data);
	}

	public function viewDetailData($id)
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Hardware', 'Hardware', 'View Data', '', '');
		$data['detailData'] = $this->M_sweep->getDetailData($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/Sweeping/V_View_Detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleteKey($id)
	{
		$hasil = $this->M_sweep->deleteKey($id);
		redirect('hardware/view-data');
	}

	public function editData($id)
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Hardware', 'Hardware', 'View Data', '', '');

		$data['detailData'] = $this->M_sweep->getDetailData($id);
		$getslc = $this->M_sweep->getSlc();
		$arr =array();
		$a = 0; foreach ($getslc as $slc) {
			// $arr[$a++] = $value;
			for ($i=1; $i < 11; $i++) { 
				$nama = 'bajakan_'.$i;
				if ($slc[$nama] != "") {
					$arr[$i] = $slc[$nama];
				}
			}
			$arr2[$a] = implode(',', $arr);
			$a++;
		}
		$arr3 = implode(',',$arr2);
		$arr4 = explode(',', $arr3);
		$slc = array_map("unserialize", array_unique(array_map("serialize", $arr4)));
		$data['slc'] = $slc;
		// echo "<pre>";
		// print_r($data['detailData']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/Sweeping/V_Edit_Data',$data);
		$this->load->view('V_Footer',$data);
	}

	public function updateData()
	{
		$checkId = $this->input->post('hdnCheckId');
		$user = $this->session->userdata('user');

		// $noAsset = $this->input->post('txtNoAsset');
		// $noind = $this->input->post('slcNoInduk');
		// $nama = $this->input->post('txtNama');
		// $seksi = $this->input->post('txtSeksi');
		//$lokasi = $this->input->post('slcLokasi');
		$ipAddress = $this->input->post('txtIpAddress');
		//$sistemOperasi = $this->input->post('txtOS');
		$windowsKey = $this->input->post('txtWindowsKey');
		$merk = $this->input->post('txtMerk');
		$mainboard = $this->input->post('txtMainboard');
		//$processor = $this->input->post('txtProcessor');
		$harddisk = $this->input->post('txtHarddisk');
		//$typeRam = $this->input->post('txtTypeRam');
		$sizeRam = $this->input->post('txtSizeRam');
		$vgaCard = $this->input->post('txtVgaCard');
		$typeMemoryVga = $this->input->post('txtTypeMemoryVga');
		$sizeMemoryVga = $this->input->post('txtSizeMemoryVga');
		//$cdrom = $this->input->post('txtCdRom');
		$lanCard = $this->input->post('txtLanCard');
		$aplikasi1 = $this->input->post('txtAplikasi1');
		$aplikasi2 = $this->input->post('txtAplikasi2');
		$aplikasi3 = $this->input->post('txtAplikasi3');
		$aplikasi4 = $this->input->post('txtAplikasi4');
		$aplikasi5 = $this->input->post('txtAplikasi5');
		$aplikasi6 = $this->input->post('txtAplikasi6');
		$aplikasi7 = $this->input->post('txtAplikasi7');
		$bajakan = $this->input->post('bajakan');
		$bajakan1 = $this->input->post('txtBajakan1');
		$alasan1  = $this->input->post('txtalasan1');
		$bajakan2 = $this->input->post('txtBajakan2');
		$alasan2  = $this->input->post('txtalasan2');
		$bajakan3 = $this->input->post('txtBajakan3');
		$alasan3  = $this->input->post('txtalasan3');
		$bajakan4 = $this->input->post('txtBajakan4');
		$alasan4  = $this->input->post('txtalasan4');
		$bajakan5 = $this->input->post('txtBajakan5');
		$alasan5  = $this->input->post('txtalasan5');
		$bajakan6 = $this->input->post('txtBajakan6');
		$alasan6  = $this->input->post('txtalasan6');
		$bajakan7 = $this->input->post('txtBajakan7');
		$alasan7  = $this->input->post('txtalasan7');
		$bajakan8 = $this->input->post('txtBajakan8');
		$alasan8  = $this->input->post('txtalasan8');
		$bajakan9 = $this->input->post('txtBajakan9');
		$alasan9  = $this->input->post('txtalasan9');
		$bajakan10 = $this->input->post('txtBajakan10');
		$alasan10  = $this->input->post('txtalasan10');
		$petugasreview= $this->input->ip_address();

		$EmailSeksi 	= $this->input->post('txtEmailSeksi');
		$EmailPekerja 	= $this->input->post('txtEmailPekerja');
		$akunPidgin 	= $this->input->post('txtPidgin');
		$voip 			= $this->input->post('txtVoip');
		$openOfice 		= $this->input->post('openOfice');
		$wps 			= $this->input->post('wps');
		$pidginVer 		= $this->input->post('pidgin');
		$thunderbird 	= $this->input->post('thunderbird');
		$chrome 		= $this->input->post('chrome');
		$ie 			= $this->input->post('ie');
		$mozzila 		= $this->input->post('mozzila');
		$teamviewer 	= $this->input->post('Tviewer');
		$vnc_viewer 	= $this->input->post('Vviewer');

		$verifikasi 		= $this->input->post('verifikasi');
		$verifikasi_state	= $this->input->post('verifikasi_state');

		$dataUmum = array(
			//'no_asset' 		=> $noAsset,	 
			// 'no_ind'	 		=> $noind,
			// 'nama'	 	 	=> $nama,
			// 'seksi'	 		=> $seksi,
			//'lokasi' 			=> $lokasi,
			'ip_address' 		=> $ipAddress,
			//'sistem_operasi' 	=>	$sistemOperasi, 
			'windows_key' 		=> $windowsKey,
			'merk' 				=> $merk,
			'mainboard'	 		=> $mainboard,
			//'processor' 		=> $processor,
			'harddisk' 			=> $harddisk,
			//'type_ram' 		=> $typeRam,
			'size_ram' 			=> $sizeRam,
			'vga_card' 			=> $vgaCard,
			'type_vga' 			=>	$typeMemoryVga,
			'size_vga' 			=>	$sizeMemoryVga,
			//'cd_rom' 			=> $cdrom,
			'lan_card' 			=> $lanCard,
			'aplikasi_1' 		=> $aplikasi1,
			'aplikasi_2' 		=> $aplikasi2,
			'aplikasi_3' 		=> $aplikasi3,
			'aplikasi_4' 		=> $aplikasi4,
			'aplikasi_5' 		=> $aplikasi5,
			'aplikasi_6' 		=> $aplikasi6,
			'aplikasi_7' 		=> $aplikasi7,
			'tgl_review' 		=> date('Y-m-d H:i:s'),
			'bajakan_1'  		=> $bajakan1,
			'bajakan_1_alasan' 	=> $alasan1,
			'bajakan_2'  		=> $bajakan2,
			'bajakan_2_alasan' 	=> $alasan2,
			'bajakan_3'  		=> $bajakan3,
			'bajakan_3_alasan' 	=> $alasan3,
			'bajakan_4'  		=> $bajakan4,
			'bajakan_4_alasan' 	=> $alasan4,
			'bajakan_5'  		=> $bajakan5,
			'bajakan_5_alasan' 	=> $alasan5,
			'bajakan_6'  		=> $bajakan6,
			'bajakan_6_alasan' 	=> $alasan6,
			'bajakan_7'  		=> $bajakan7,
			'bajakan_7_alasan' 	=> $alasan7,
			'bajakan_8'  		=> $bajakan8,
			'bajakan_8_alasan' 	=> $alasan8,
			'bajakan_9'  		=> $bajakan9,
			'bajakan_9_alasan' 	=> $alasan9,
			'bajakan_10'  		=> $bajakan10,
			'bajakan_10_alasan' => $alasan10,
			'petugas_review' 	=> $petugasreview ,
			'windows_bajakan' 	=> $bajakan,
			'last_update_date' 	=> date('Y-m-d H:i:s'),
			'last_update_by' 	=> $user,
			'open_office' 		=> strtoupper($openOfice),
			'wps' 				=> strtoupper($wps),
			'thunderbird' 		=> strtoupper($thunderbird),
			'browser_chrome' 	=> strtoupper($chrome),
			'browser_ie' 		=> strtoupper($ie),
			'browser_mozilla' 	=> strtoupper($mozzila),
			'pidgin' 			=> strtoupper($pidginVer),
			'team_viewer' 		=> strtoupper($teamviewer),
			'vnc_viewer' 		=> strtoupper($vnc_viewer),
			'email_seksi' 		=> $EmailSeksi,
			'email_pekerja' 	=> $EmailPekerja,
			'pidgin_akun' 		=> $akunPidgin,
			'voip' 				=> strtoupper($voip),
			);


		if ($verifikasi == $verifikasi_state) {// maybe like this
			echo "sama";
		}else{
			if ($verifikasi) {
				$dataUmum['remark'] = 1;
				$dataUmum['remark_date'] = date('Y-m-d H:i:s');
			}else{
				$dataUmum['remark'] = 0;
				$dataUmum['remark_date'] = 'NULL';
			}
		}

		$detailData = $this->M_sweep->getDetailData($checkId);
		for ($i=0; $i < count($detailData); $i++) { 
			$imArr = implode(', ', array_keys($detailData[$i]));
			$escaped_values = array_map('pg_escape_string', array_values($detailData[$i]));
			$values  = implode("', '", $escaped_values);
		}
		$this->M_sweep->insertHistory($imArr, $values);

		$this->M_sweep->updateDataUmum($checkId, $dataUmum);

		redirect('hardware/view-data');
	}
}