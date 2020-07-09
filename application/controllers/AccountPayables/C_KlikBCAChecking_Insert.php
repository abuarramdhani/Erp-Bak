<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_KlikBCAchecking_Insert extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		include APPPATH . 'libraries/simple_html_dom.php';
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		  //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AccountPayables/M_klikbcachecking_insert');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
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

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/KlikBCAChecking/Insert/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	function proses_upload(){
		$fileName = trim(addslashes($_FILES['userfile']['name']));
		$fileName = str_replace(' ', '_', $fileName);
		$config['upload_path']   = 'upload-bca/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'htm';
		$this->load->library('upload',$config);

		if($this->upload->do_upload('userfile')){
			sleep(2);
			$file_data 		= $this->upload->data();
			$inputFileName 	= 'upload-bca/'.$file_data['file_name'];

			$html	= file_get_html($inputFileName);
			$Odd	= $html->find('.clsForm tr td');

			
			if($_POST['fileType']=="TYP1"){
				
				//SESAMA BCA
				foreach ($Odd as $key => $value) {
					if (substr($value->plaintext, 0, 1) !== ":" AND substr($value->plaintext, 0, 1) !== "&") {
						$collected_data[] = str_replace(':&nbsp;&nbsp;', '', $value->plaintext);
					}
				}
				$pengirim			= (explode("/",$collected_data[1]));
				$penerima 			= (explode("/",$collected_data[2]));
				$no_referensi 		= str_replace(array(' '), '', $collected_data[0]);
				$no_rek_pengirim	= str_replace(array('&nbsp;', ' '), '', $pengirim[0]);
				$no_rek_penerima	= str_replace(array('&nbsp;', ' '), '', $penerima[0]);
				$nama_pengirim		= str_replace(array('&nbsp;'), '', $pengirim[1]);
				$nama_penerima		= str_replace(array('&nbsp;'), '', $penerima[1]);
				$jumlah				= str_replace(array('Rp&nbsp;', ',', ' '), '', $collected_data[3]);
				$berita				= str_replace(array('  '), '', $collected_data[4]);
				$jenis_transfer		= str_replace(array('  ','&nbsp;'), '', $collected_data[6]);
				$user_id 			= $this->session->userid;
				
				$htmldata = array(
					'no_referensi' 		=> $no_referensi,
					'no_rek_pengirim' 	=> $no_rek_pengirim,
					'no_rek_penerima' 	=> $no_rek_penerima,
					'nama_pengirim' 	=> $nama_pengirim,
					'nama_penerima' 	=> $nama_penerima,
					'jumlah' 			=> $jumlah,
					'berita' 			=> $berita,
					'jenis_transfer' 	=> $jenis_transfer,
					'uploaded_by' 		=> $user_id,
					'upload_date'		=> 'now()',
				);

			}elseif($_POST['fileType']=="TYP2"){
				
				//BANK LAIN
				foreach ($Odd as $key => $value) {
					if (substr($value->plaintext, 0, 13) == ":&nbsp;&nbsp;") {
						$collected_data[] = str_replace(':&nbsp;&nbsp;', '', $value->plaintext);
					}
				}
				
				//echo "<pre>";
				//print_r($collected_data);

				$pengirim			= (explode("/",$collected_data[1]));
				$no_referensi 		= str_replace(array(' '), '', $collected_data[0]);
				$no_rek_pengirim	= str_replace(array('&nbsp;', ' '), '', $pengirim[0]);
				$no_rek_penerima	= str_replace(array('&nbsp;', ' '), '', $collected_data[6]);
				$nama_pengirim		= str_replace(array('&nbsp;'), '', $pengirim[1]);
				$nama_penerima		= str_replace(array('&nbsp;', '  '), '', $collected_data[7]);
				$jumlah				= str_replace(array('Rp', '&nbsp;', ',', ' '), '', $collected_data[8]);
				$nama_alias			= str_replace(array('&nbsp;', '  '), '', $collected_data[3]);
				$bank_tujuan		= str_replace(array('&nbsp;', '  '), '', $collected_data[4]);
				$kota_bank			= str_replace(array('&nbsp;', '  '), '', $collected_data[5]);

				if ('RTGS'!=str_replace(array('&nbsp;', '  '), '', $collected_data[10]))
				{
				//echo "bukanrtgs";
				$biaya				= '0';
				$layanan_transfer	= str_replace(array('&nbsp;', '  '), '', $collected_data[9]);
				$berita				= str_replace(array('  '), '', $collected_data[10]);
				$jenis_transfer		= str_replace(array('&nbsp;', '  '), '', $collected_data[11]);
				}
				else
				{
				//echo "RTGS";
				$biaya				= str_replace(array('Rp', '&nbsp;', ',', ' '), '', $collected_data[9]);
				$layanan_transfer	= str_replace(array('&nbsp;', '  '), '', $collected_data[10]);
				$berita				= str_replace(array('  '), '', $collected_data[11]);
				$jenis_transfer		= str_replace(array('&nbsp;', '  '), '', $collected_data[12]);

				}

				$user_id 			= $this->session->userid;

				$htmldata = array(
					'no_referensi' 		=> $no_referensi,
					'no_rek_pengirim' 	=> $no_rek_pengirim,
					'no_rek_penerima' 	=> $no_rek_penerima,
					'nama_pengirim' 	=> $nama_pengirim,
					'nama_penerima' 	=> $nama_penerima,
					'jumlah' 			=> $jumlah,
					'berita' 			=> $berita,
					'jenis_transfer' 	=> $jenis_transfer,
					'nama_alias' 		=> $nama_alias,
					'bank_tujuan' 		=> $bank_tujuan,
					'kota_bank' 		=> $kota_bank,
					'biaya' 			=> $biaya,
					'layanan_transfer' 	=> $layanan_transfer,
					'uploaded_by' 		=> $user_id,
					'upload_date'		=> 'now()',
				);
			
			}elseif($_POST['fileType']=="TYP3"){
			
				//CASH MANAGEMENT
				foreach ($Odd as $key => $value) {
					if (substr($value->plaintext, 0, 13) == ":&nbsp;&nbsp;") {
						$collected_data[] = str_replace(':&nbsp;&nbsp;', '', $value->plaintext);
					}
				}

				$pengirim			= (explode("/",$collected_data[1]));
				$penerima 			= (explode("/",$collected_data[2]));
				$no_referensi 		= str_replace(array(' '), '', $collected_data[0]);
				$no_rek_pengirim	= str_replace(array('&nbsp;', ' '), '', $pengirim[0]);
				$no_rek_penerima	= str_replace(array('&nbsp;', ' '), '', $penerima[0]);
				$nama_pengirim		= str_replace(array('&nbsp;'), '', $pengirim[1]);
				$nama_penerima		= str_replace(array('&nbsp;'), '', $penerima[1]);
				$jumlah				= str_replace(array('Rp&nbsp;', ',', ' '), '', $collected_data[3]);
				$berita				= str_replace(array('  '), '', $collected_data[4]);
				$jenis_transfer		= str_replace(array('  ','&nbsp;'), '', $collected_data[5]);
				$user_id 			= $this->session->userid;

				$htmldata = array(
					'no_referensi' 		=> $no_referensi,
					'no_rek_pengirim' 	=> $no_rek_pengirim,
					'no_rek_penerima' 	=> $no_rek_penerima,
					'nama_pengirim' 	=> $nama_pengirim,
					'nama_penerima' 	=> $nama_penerima,
					'jumlah' 			=> $jumlah,
					'berita' 			=> $berita,
					'jenis_transfer' 	=> $jenis_transfer,
					'uploaded_by' 		=> $user_id,
					'upload_date'		=> 'now()',
				);

			}
		
			$filewithoutx		= str_replace(array('.htm'), '', $file_data['file_name']);

			$duplicate 			= $this->M_klikbcachecking_insert->SearchRecap($no_rek_penerima,$berita);
			if(empty($duplicate)){
				$this->M_klikbcachecking_insert->InsertRecap($htmldata);
				print_r('<b>'.$file_data['file_name'].'</b> upload sukses');
			}else{
				print_r('<b>'.$file_data['file_name'].'</b> data sudah ada <a href="'.base_url('AccountPayables/KlikBCAChecking/Insert/replace/'.$filewithoutx).'/'.$_POST['fileType'].'" target="_blank">[REPLACE]</a>');
			}
		}
	}

	function replace($html,$type){
		$inputFileName 	= 'upload-bca/'.$html.'.htm';

		$html	= file_get_html($inputFileName);
		$Odd	= $html->find('.clsForm tr td');

		if($type=="TYP1"){
				
			//SESAMA BCA
			foreach ($Odd as $key => $value) {
				if (substr($value->plaintext, 0, 1) !== ":" AND substr($value->plaintext, 0, 1) !== "&") {
					$collected_data[] = str_replace(':&nbsp;&nbsp;', '', $value->plaintext);
				}
			}
			$pengirim			= (explode("/",$collected_data[1]));
			$penerima 			= (explode("/",$collected_data[2]));
			$no_referensi 		= str_replace(array(' '), '', $collected_data[0]);
			$no_rek_pengirim	= str_replace(array('&nbsp;', ' '), '', $pengirim[0]);
			$no_rek_penerima	= str_replace(array('&nbsp;', ' '), '', $penerima[0]);
			$nama_pengirim		= str_replace(array('&nbsp;'), '', $pengirim[1]);
			$nama_penerima		= str_replace(array('&nbsp;'), '', $penerima[1]);
			$jumlah				= str_replace(array('Rp&nbsp;', ',', ' '), '', $collected_data[3]);
			$berita				= str_replace(array('  '), '', $collected_data[4]);
			$jenis_transfer		= str_replace(array('  ','&nbsp;'), '', $collected_data[6]);
			$user_id 			= $this->session->userid;
			
			$htmldata = array(
				'no_referensi' 		=> $no_referensi,
				'no_rek_pengirim' 	=> $no_rek_pengirim,
				'no_rek_penerima' 	=> $no_rek_penerima,
				'nama_pengirim' 	=> $nama_pengirim,
				'nama_penerima' 	=> $nama_penerima,
				'jumlah' 			=> $jumlah,
				'berita' 			=> $berita,
				'jenis_transfer' 	=> $jenis_transfer,
				'uploaded_by' 		=> $user_id,
				'upload_date'		=> 'now()',
			);

		}elseif($type=="TYP2"){
			
			//BANK LAIN
			foreach ($Odd as $key => $value) {
				if (substr($value->plaintext, 0, 13) == ":&nbsp;&nbsp;") {
					$collected_data[] = str_replace(':&nbsp;&nbsp;', '', $value->plaintext);
				}
			}
			$pengirim			= (explode("/",$collected_data[1]));
			$no_referensi 		= str_replace(array(' '), '', $collected_data[0]);
			$no_rek_pengirim	= str_replace(array('&nbsp;', ' '), '', $pengirim[0]);
			$no_rek_penerima	= str_replace(array('&nbsp;', ' '), '', $collected_data[6]);
			$nama_pengirim		= str_replace(array('&nbsp;'), '', $pengirim[1]);
			$nama_penerima		= str_replace(array('&nbsp;', '  '), '', $collected_data[7]);
			$jumlah				= str_replace(array('Rp', '&nbsp;', ',', ' '), '', $collected_data[8]);
			$berita				= str_replace(array('  '), '', $collected_data[11]);
			$jenis_transfer		= str_replace(array('&nbsp;', '  '), '', $collected_data[12]);
			$nama_alias			= str_replace(array('&nbsp;', '  '), '', $collected_data[3]);
			$bank_tujuan		= str_replace(array('&nbsp;', '  '), '', $collected_data[4]);
			$kota_bank			= str_replace(array('&nbsp;', '  '), '', $collected_data[5]);
			$biaya				= str_replace(array('Rp', '&nbsp;', ',', ' '), '', $collected_data[8]);
			$layanan_transfer	= str_replace(array('&nbsp;', '  '), '', $collected_data[10]);
			$user_id 			= $this->session->userid;

			$htmldata = array(
				'no_referensi' 		=> $no_referensi,
				'no_rek_pengirim' 	=> $no_rek_pengirim,
				'no_rek_penerima' 	=> $no_rek_penerima,
				'nama_pengirim' 	=> $nama_pengirim,
				'nama_penerima' 	=> $nama_penerima,
				'jumlah' 			=> $jumlah,
				'berita' 			=> $berita,
				'jenis_transfer' 	=> $jenis_transfer,
				'nama_alias' 		=> $nama_alias,
				'bank_tujuan' 		=> $bank_tujuan,
				'kota_bank' 		=> $kota_bank,
				'biaya' 			=> $biaya,
				'layanan_transfer' 	=> $layanan_transfer,
				'uploaded_by' 		=> $user_id,
				'upload_date'		=> 'now()',
			);
		
		}elseif($type=="TYP3"){
		
			//CASH MANAGEMENT
			foreach ($Odd as $key => $value) {
				if (substr($value->plaintext, 0, 13) == ":&nbsp;&nbsp;") {
					$collected_data[] = str_replace(':&nbsp;&nbsp;', '', $value->plaintext);
				}
			}

			$pengirim			= (explode("/",$collected_data[1]));
			$penerima 			= (explode("/",$collected_data[2]));
			$no_referensi 		= str_replace(array(' '), '', $collected_data[0]);
			$no_rek_pengirim	= str_replace(array('&nbsp;', ' '), '', $pengirim[0]);
			$no_rek_penerima	= str_replace(array('&nbsp;', ' '), '', $penerima[0]);
			$nama_pengirim		= str_replace(array('&nbsp;'), '', $pengirim[1]);
			$nama_penerima		= str_replace(array('&nbsp;'), '', $penerima[1]);
			$jumlah				= str_replace(array('Rp&nbsp;', ',', ' '), '', $collected_data[3]);
			$berita				= str_replace(array('  '), '', $collected_data[4]);
			$jenis_transfer		= str_replace(array('  ','&nbsp;'), '', $collected_data[5]);
			$user_id 			= $this->session->userid;

			$htmldata = array(
				'no_referensi' 		=> $no_referensi,
				'no_rek_pengirim' 	=> $no_rek_pengirim,
				'no_rek_penerima' 	=> $no_rek_penerima,
				'nama_pengirim' 	=> $nama_pengirim,
				'nama_penerima' 	=> $nama_penerima,
				'jumlah' 			=> $jumlah,
				'berita' 			=> $berita,
				'jenis_transfer' 	=> $jenis_transfer,
				'uploaded_by' 		=> $user_id,
				'upload_date'		=> 'now()',
			);

		}

		$this->M_klikbcachecking_insert->DeleteRecap($no_rek_penerima,$berita);
		$this->M_klikbcachecking_insert->InsertRecap($htmldata);
		echo "<script>window.close();</script>";
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
}