<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_Seksi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('General');
		$this->load->library('ciqrcode');
		$this->load->model('M_Index');
		
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PengembanganSistem/M_pengsistem');
		// $this->load->library('excel');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
		}
    }

	public function index()
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/V_Index', $data);
        $this->load->view('V_Footer', $data);
	}

	public function select_seksi()
	{
		$seksi = $_POST['seksi'];

		$data = $this->M_pengsistem->input_select_seksi($seksi);

		echo json_encode($data);
	}

	public function select_all_seksi()
	{
		$seksi = $_GET['seksi'];
		$data = $this->M_pengsistem->input_select_seksi($seksi);

		echo json_encode($data);
	}

	public function ambilSemuaPekerja()
	{
		$noind = $_GET['noind'];
		$data = $this->M_pengsistem->ambilPekerja($noind);

		echo json_encode($data);
	}

	public function flow_proses()
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//Pengembangan Sistem
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);
        $data['listdatafp'] = $this->M_pengsistem->list_data_fp();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();
		$data['user'] = $this->session->employee;
		$data['dept'] = $parameter[0]['dept'];

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/flowproses/V_Index', $data);
        $this->load->view('V_Footer', $data);

	}

	public function cek_nomor_flow()
	{
		$number_doc = $_POST['stdnumber'];

		$data = $this->M_pengsistem->cek_nomor_fp($number_doc)[0]['count'];
		
		echo json_encode($data);
	}

	public function inputdata_fp()
	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

		$numberstd = $this->input->post('numberstd');
			$a = explode("-",$numberstd);
			$s = count($a);
		$judul = $this->input->post('judul_fp');
		$seksi = $this->input->post('seksi_fp');
			$search = $this->M_pengsistem->seksiunit($seksi);
			foreach ($search as $key) {
				$seksi_full = $key['seksi'];
			}
		$date = date('Y-m-d',strtotime($this->input->post('date_rev_fp')));
		$number = $this->input->post('number_rev_fp');
			$number_rev = sprintf('%02d',$number);
		$pic = $this->input->post('pic_fp');
			$pic_doc = explode(' - ', $pic);
				$pic_id = $pic_doc[0];
				$pic_name = $pic_doc[1];
		$status = $this->input->post('status_fp');
		$date_input = date('d-m-Y h:i:sa');
		$nomor = explode('-',$numberstd);
			$a = count($nomor);	

			$nomor1 = sprintf('%03d',$nomor[$a-1]);
			$j = $_FILES['file']['name'];
			if ($j !== '') {
				$f = true;
			}else {
				$f = false;
			}
		if ($_FILES == $f) {
			
			if(!is_dir('.assets/upload/PengembanganSistem/fp'))
			{
				mkdir('.assets/upload/PengembanganSistem/fp', 0777, true); 
				chmod('.assets/upload/PengembanganSistem/fp', 0777);
			}else {
				chmod('.assets/upload/PengembanganSistem/fp', 0777); 
			}
			$data_file = $_FILES['file']['name'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('.',$nmfile);
					$s = $l[1];
				$fls = preg_replace("![^a-z0-9]+!i", "_", $judul);
			$judul_baru = $numberstd.'-'.$fls.'.'.$s;
			$nama_baru = preg_replace("/[\/\&%#\$]/", "_", $judul_baru);
			
			$config['upload_path'] 			= 'assets/upload/PengembanganSistem/fp/';
			$config['allowed_types']		= '*';
			$config['max_size']             = 0;
			// $config['max_width']            = 1000;
			// $config['max_height']           = 7680;
			$config['file_name'] = $nama_baru;
			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if ((($type == "video/mp4") || ($type == "video/mp3") || ($type == "video/AVI") || ($type == "video/x-flv")) && ($size == "50000000")) {
				$msg="Jenis file tidak sesuai atau ukuran file terlalu besar!";
				echo "<p align=\"center\">$msg</p>";
			}

			// qr_image
			
				$qr_image= $nama_baru.'.png';
				$params['data'] = 'http://erp.quick.com/assets/upload/PengembanganSistem/fp/'.$nama_baru;
				$params['level'] = 'H';
				$params['size'] = 8;
				$params['savename'] =FCPATH."assets/upload/PengembanganSistem/fp/".$qr_image;
				$this->ciqrcode->generate($params);
				
				if (!$this->upload->do_upload('file')) {
				$error = array('error' => $this->upload->display_errors());
			  	echo "error";
			  	print_r($error);exit;
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area

				$data 		= array( 'nomor_doc' => $numberstd,
							'doc' 				=> $a[0],
							'judul_doc' 		=> $judul,
							'seksi_pengguna'	=> $seksi,
							'date_rev'			=> $date,
							'number_rev'		=> $number_rev,
							'pic_doc'			=> $pic_name,
							'a'					=> $pic_id,
							'status_doc'		=> $status,
							'seksi_full'		=> $seksi_full,
							'nomor_flow'		=> $nomor1,
							'date_input'		=> $date_input,
							'file'				=> $judul_baru,
							'link_file' 		=> 'assets/upload/PengembanganSistem/fp/'.$judul_baru,
							'user'				=> $this->session->employee,
							'dept'				=> $parameter[0]['dept'],
						);
				}
			}else{
				$data 		= array( 'nomor_doc' => $numberstd,
							'doc' 				=> $a[0],
							'judul_doc' 		=> $judul,
							'seksi_pengguna'	=> $seksi,
							'date_rev'			=> $date,
							'number_rev'		=> $number_rev,
							'pic_doc'			=> $pic_name,
							'a'					=> $pic_id,
							'status_doc'		=> $status,
							'seksi_full'		=> $seksi_full,
							'nomor_flow'		=> $nomor1,
							'date_input'		=> $date_input,
							'user'				=> $this->session->employee,
							'dept'				=> $parameter[0]['dept'],
						);
		}
		$this->M_pengsistem->get_inputdata_fp($data);
		redirect('DokumenUnit/Flow_Proses');
	}

	public function edit_flow($data_edit)
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//Pengembangan Sistem
        $data['listdatafp'] = $this->M_pengsistem->list_edit_fp($data_edit);
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/flowproses/V_Readfp', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_flow($id)
	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

		$numberstd = $this->input->post('nomor_doc');
			$a = explode("-",$numberstd);
			$s = count($a);

		$seksi	= $this->input->post('seksi_fp');
		$search = $this->M_pengsistem->seksiunit($seksi);
		foreach ($search as $key) {
			$seksi_full = $key['seksi'];
		}
		$judul_fp = $this->input->post('judul_fp');
		$pic = $this->input->post('pic_fp');
			$pic_doc = explode(' - ', $pic);

		$status = $this->input->post('status_fp');
		$date_update = date('d-m-Y h:i:sa');
		$date = date('Y-m-d',strtotime($this->input->post('date_rev_fp')));
		$rev = $this->input->post('number_rev_fp');
		$number_rev = sprintf('%02d',$rev);
		$nomor = explode('-',$numberstd);
			$a = count($nomor);	

			$nomor1 = sprintf('%03d',$nomor[$a-1]);

		$data 		= array( 
					'nomor_doc' 		=> $numberstd,
					'doc' 				=> $a[0],
					'judul_doc'			=> $judul_fp,
					'seksi_pengguna'	=> $seksi,
					'date_rev'			=> $date,
					'number_rev'		=> $number_rev,
					'pic_doc'			=> $pic_doc[1],
					'a'					=> $pic_doc[0],
					'status_doc'		=> $status,
					'seksi_full'		=> $seksi_full,
					'nomor_flow'		=> $nomor1,
					'date_input'		=> $date_update,
					'user'				=> $this->session->employee,
					'dept'				=> $parameter[0]['dept'],
				);
				
		$this->M_pengsistem->update_flow_fp($data,$id);
		redirect('DokumenUnit/Flow_Proses');
	}

	public function delete_data_flow($id)
	{
		$this->M_pengsistem->delete_flow($id);
		echo 1;
	}

	//COP_WI

	public function cop_wi()
	{
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//Pengembangan Sistem
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);
        $data['listdatacopwi'] = $this->M_pengsistem->list_data_copwi();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();
		$data['user'] = $this->session->employee;
		$data['dept'] = $parameter[0]['dept'];
		
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/copwi/V_Index', $data);
        $this->load->view('V_Footer', $data);

	}

	public function cek_nomora_copwi()
	{
		$number_doc = $_POST['stdnumber'];

		$data = $this->M_pengsistem->set_totala_copwi($number_doc)[0]['count'];
		
		echo json_encode($data);
	}

	public function cek_nomor_copwi()
	{
		$doc = $_POST['cop_wi'];
		$seksi = $_POST['seksi_doc'];
		$number_sop = $_POST['number_sop'];

		$data = $this->M_pengsistem->cek_data_nomor_copwi($doc,$seksi,$number_sop)[0]['max'];
		
		echo json_encode($data);
	}
	
	public function inputdata_copwi()
	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

		$stdnumber = $this->input->post('stdnumbercop');
		$judul_cw = $this->input->post('judul_cw');
		$item_doc_cw = $this->input->post('doc_cw');
		$doc_cw = $this->input->post('doccopwi_cw');
		$seksi_cw = $this->input->post('seksi_cw');
			$search = $this->M_pengsistem->seksiunit($seksi_cw);
			foreach ($search as $key) {
				$seksifull = $key['seksi'];
			}
		$date_rev = date('Y-m-d', strtotime($this->input->post('date_rev_cw')));
		$number = $this->input->post('number_rev_cw');
			$number_rev = sprintf('%02d',$number);
		$pic_doc = $this->input->post('pic_cw');
			$pic_doc_split = explode(' - ', $pic_doc);
				$pic_id		= $pic_doc_split[0];
				$pic_name 	= $pic_doc_split[1];
		$status_cw = $this->input->post('status_cw');
		$number_sop = $this->input->post('number_sop_cw');
		$sop_cw = $this->input->post('sop_cw');
		$date_input = date('d-m-Y h:i:sa');
			$nomor = explode('-',$stdnumber);
				$a = count($nomor);	

			$nomor1 = sprintf('%03d',$nomor[$a-1]);
			$j = $_FILES['file']['name'];
			if ($j !== '') {
				$f = false;
			}else {
				$f = true;
			}

		if ($_FILES == $f) {
				
			$data 		= array( 
				'doc' 				=> $doc_cw,
				'nomor_doc' 		=> $stdnumber,
				'judul_doc' 		=> $judul_cw,
				'date_rev'			=> $date_rev,
				'pic_doc'			=> $pic_name,
				'a'					=> $pic_id,
				'status_doc'		=> $status_cw,
				'seksi_full'		=> $seksifull,
				'nomor_copwi'		=> $nomor1,
				'date_input'		=> $date_input,
				'number_sop'		=> $number_sop,
				'seksi_sop'			=> $sop_cw,
				'number_rev'		=> $number_rev,
				'jenis_doc_cw'		=> $item_doc_cw,
				'user'				=> $this->session->employee,
				'dept'				=> $parameter[0]['dept'],
			);
		}else{

			if(!is_dir('.assets/upload/PengembanganSistem/copwi'))
			{
				mkdir('.assets/upload/PengembanganSistem/copwi', 0777, true); 
				chmod('.assets/upload/PengembanganSistem/copwi', 0777);
			}else {
				chmod('.assets/upload/PengembanganSistem/copwi', 0777); 
			}

			$data_file = $_FILES['file']['name'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('.',$nmfile);
					$s = $l[1];
					$fls = preg_replace("![^a-z0-9]+!i", "_", $judul_cw);
			$judul_baru = $stdnumber.'-'.$fls.'.'.$s;
			$nama_baru	= preg_replace("/[\/\&%#\$]/", "_", $judul_baru);
			$type		= $_FILES['file']['type'];
			$size		= $_FILES['file']['size'];

			$config['upload_path'] 			= 'assets/upload/PengembanganSistem/copwi/';
			$config['allowed_types']		= '*';
			$config['max_size']             = 0;
			// $config['max_width']            = 1000;
			// $config['max_height']           = 7680;
			$config['file_name'] = $nama_baru;

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if ((($type == "video/mp4") || ($type == "video/mp3") || ($type == "video/AVI") || ($type == "video/x-flv")) && ($size == "50000000")) {
				$msg="Jenis file tidak sesuai atau ukuran file terlalu besar!";
				echo "<p align=\"center\">$msg</p>";
			}
			// qr_image
			
				$qr_image= $nama_baru.'.png';
				$params['data'] = 'http://erp.quick.com/assets/upload/PengembanganSistem/copwi/'.$nama_baru;
				$params['level'] = 'H';
				$params['size'] = 8;
				$params['savename'] =FCPATH."assets/upload/PengembanganSistem/copwi/qrcop/".$qr_image;
				$this->ciqrcode->generate($params);
			//end_upload qr_image
				if (!$this->upload->do_upload('file')) {
				$error = array('error' => $this->upload->display_errors());
			  	echo "error";
			  	print_r($error);exit;
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
				
				$data 		= array( 
					'doc' 				=> $doc_cw,
					'nomor_doc' 		=> $stdnumber,
					'judul_doc' 		=> $judul_cw,
					'date_rev'			=> $date_rev,
					'pic_doc'			=> $pic_name,
					'a'					=> $pic_id,
					'status_doc'		=> $status_cw,
					'seksi_full'		=> $seksifull,
					'nomor_copwi'		=> $nomor1,
					'date_input'		=> $date_input,
					'number_sop'		=> $number_sop,
					'seksi_sop'			=> $sop_cw,
					'number_rev'		=> $number_rev,
					'jenis_doc_cw'		=> $item_doc_cw,
					'link_file' 		=> 'assets/upload/PengembanganSistem/copwi/'.$judul_baru,
					'file' 				=> $judul_baru,
					'user'				=> $this->session->employee,
					'dept'				=> $parameter[0]['dept'],
				);
	
			}
		}
		$this->M_pengsistem->get_inputdata_copwi($data);
			redirect('DokumenUnit/cop_wi');
	}

	public function edit_copwi($data_edit)
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//Pengembangan Sistem
        $data['listdatacw'] = $this->M_pengsistem->list_edit_copwi($data_edit);
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/copwi/V_Read_cw', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_copwi($id)
  	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

		$number_doc_cw = $this->input->post('nomor_doc');
			$kode_cop_wi = explode('-', $number_doc_cw);
			$s = count($kode_cop_wi);
		$judul_doc = $this->input->post('judulcw');
		$jenis_doc = $this->input->post('cop_wi_cw');
		$seksi_cw = $this->input->post('seksi_cw');
			$search = $this->M_pengsistem->seksiunit($seksi_cw);
			foreach ($search as $key) {
				$seksifull = $key['seksi'];
			}
		$pic_doc = $this->input->post('pic_cw');
			$pic_doc_split = explode(' - ', $pic_doc);
				$pic_id		= $pic_doc_split[0];
				$pic_name 	= $pic_doc_split[1];
		$status_doc = $this->input->post('status_cw');
		$date_rev_doc = date('Y-m-d',strtotime($this->input->post('date_rev_cw')));
		$date_update = date('d-m-Y h:i:sa');
		$number_rev_doc = $this->input->post('number_rev_cw');
		$number_sop = $this->input->post('number_sop_cw');

		$nomor_rev = sprintf('%02d',$number_rev_doc);

		$data		 = array(
					'nomor_doc'			=> $number_doc_cw,
					'judul_doc'			=> $judul_doc,
					'seksi_sop'			=> $seksi_cw,
					'seksi_full'		=> $seksifull,
					'doc'				=> $jenis_doc,
					'pic_doc'			=> $pic_name,
					'a'					=> $pic_id,
					'status_doc'		=> $status_doc,
					'date_rev'			=> $date_rev_doc,
					'date_update'		=> $date_update,
					'number_rev'		=> $number_rev_doc,
					'number_sop'		=> $number_sop,
					'nomor_copwi'		=> $kode_cop_wi[$s-1],
					'user'				=> $this->session->employee,
					'dept'				=> $parameter[0]['dept'],
					);

		$this->M_pengsistem->update_cope($data,$id);
		redirect('DokumenUnit/cop_wi');
		}

	public function delete_data_copwi($id)
	{

		$this->M_pengsistem->delete_copwi($id);
		echo 1;
	}
	

	//User Manual

	public function user_manual()
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//Pengembangan Sistem
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);
        $data['listdataum'] = $this->M_pengsistem->list_data_um();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();
		$data['user'] = $this->session->employee;
		$data['dept'] = $parameter[0]['dept'];

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/usermanual/V_Index', $data);
        $this->load->view('V_Footer', $data);

	}

	public function hitung_data_um()
	{
		$seksi = $_POST['seksi_um'];
		$doc = $_POST['doc_um'];
		$sop = $_POST['number_sop'];

		$data = $this->M_pengsistem->set_number_um($seksi,$sop,$doc)[0]['max'];
		
		echo json_encode($data);
	}

	public function cek_nomor_um()
	{
		$data_number = $_POST['number_um'];

		$data = $this->M_pengsistem->cek1_data_nomor_um($data_number)[0]['count'];

		echo json_encode($data);
	}

	public function input_data_um()
	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

		$stdnumber = $this->input->post('numberstd');
		$judul_um = $this->input->post('judul_um');
		$item_doc_um = $this->input->post('doc_um');
		$doc = 'User Manual';
		$doc_um = 'UM';
		$seksi_um = $this->input->post('seksi_um');
			$search = $this->M_pengsistem->seksiunit($seksi_um);
			foreach ($search as $key) {
				$seksifull = $key['seksi'];
			}
		$date_rev = date('Y-m-d', strtotime($this->input->post('date_rev_um')));
		$number = $this->input->post('number_rev-fp');
			$number_rev = sprintf('%02d',$number);
		$pic_doc = $this->input->post('pic_um');
			$pic_doc_split = explode(' - ', $pic_doc);
				$pic_id		= $pic_doc_split[0];
				$pic_name 	= $pic_doc_split[1];
		$status_um = $this->input->post('status_um');
		$number_sop = $this->input->post('number_sop_um');
		$sop_um = $this->input->post('sop_um');
		$date_input = date('Y-m-d h:i:sa');
		$nomor = explode('-',$stdnumber);
			$a = count($nomor);	

		$nomor1 = sprintf('%03d',$nomor[$a-1]);
		$j = $_FILES['file']['name'];
		if ($j !== '') {
			$f = false;
		}else {
			$f = true;
		}

	if ($_FILES == $f) {
			
		$data 		= array( 
			'doc' 				=> 'User Manual',
			'nomor_doc' 		=> $stdnumber,
			'judul_doc' 		=> $judul_um,
			'seksi_pengguna'	=> $seksifull,
			'jenis_doc'			=> $item_doc_um,
			'number_sop'		=> $number_sop,
			'seksi_sop'			=> $sop_um,
			'date_rev'			=> $date_rev,
			'number_rev'		=> $number_rev,
			'pic_doc'			=> $pic_name,
			'status_doc'		=> $status_um,
			'date_input'		=> $date_input,
			'nomor_um'			=> $nomor1,
			'a'					=> $pic_id,
			'user'				=> $this->session->employee,
			'dept'				=> $parameter[0]['dept'],
		);
	}else{

		if(!is_dir('.assets/upload/PengembanganSistem/um'))
		{
			mkdir('.assets/upload/PengembanganSistem/um', 0777, true); 
			chmod('.assets/upload/PengembanganSistem/um', 0777);
		}else {
			chmod('.assets/upload/PengembanganSistem/um', 0777); 
		}

		$data_file = $_FILES['file']['name'];

		$pathh = null;
		$nmfile = $data_file;
			$l = explode('.',$nmfile);
				$s = $l[1];
				$fls = preg_replace("![^a-z0-9]+!i", "_", $judul_um);
		$judul_baru = $stdnumber.'-'.$fls.'.'.$s;
		$nama_baru	= preg_replace("/[\/\&%#\$]/", "_", $judul_baru);
		$type		= $_FILES['file']['type'];
		$size		= $_FILES['file']['size'];

		$config['upload_path'] 			= 'assets/upload/PengembanganSistem/um/';
		$config['allowed_types']		= '*';
		$config['max_size']             = 0;
		// $config['max_width']            = 1000;
		// $config['max_height']           = 7680;
		$config['file_name'] = $nama_baru;

		$this->load->library('upload', $config);

		$this->upload->initialize($config);
		if ((($type == "video/mp4") || ($type == "video/mp3") || ($type == "video/AVI") || ($type == "video/x-flv")) && ($size == "50000000")) {
			$msg="Jenis file tidak sesuai atau ukuran file terlalu besar!";
			echo "<p align=\"center\">$msg</p>";
		}
		// qr_image
		
			$qr_image= $nama_baru.'.png';
			$params['data'] = 'http://erp.quick.com/assets/upload/PengembanganSistem/um/'.$nama_baru;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."assets/upload/PengembanganSistem/um/".$qr_image;
			$this->ciqrcode->generate($params);
		//end_upload qr_image
			if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			  echo "error";
			  print_r($error);exit;
			} else {
			array('upload_data' => $this->upload->data());
			$path = $config['upload_path'].$config['file_name'];
			//end upload file area
			
			$data 		= array( 
				'doc' 				=> 'User Manual',
				'nomor_doc' 		=> $stdnumber,
				'judul_doc' 		=> $judul_um,
				'seksi_pengguna'	=> $seksifull,
				'jenis_doc'			=> $item_doc_um,
				'number_sop'		=> $number_sop,
				'seksi_sop'			=> $sop_um,
				'date_rev'			=> $date_rev,
				'number_rev'		=> $number_rev,
				'pic_doc'			=> $pic_name,
				'status_doc'		=> $status_um,
				'date_input'		=> $date_input,
				'nomor_um'			=> $nomor1,
				'a'					=> $pic_id,
				'link_file' 		=> 'assets/upload/PengembanganSistem/um/'.$judul_baru,
				'file' 				=> $judul_baru,
				'user'				=> $this->session->employee,
				'dept'				=> $parameter[0]['dept'],
			);

		}
	}
			$this->M_pengsistem->get_inputdata_um($data);
			redirect('DokumenUnit/user_manual');
	}

	public function edit_UM($data_edit)
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//Pengembangan Sistem
        $data['listdataum'] = $this->M_pengsistem->list_edit_um($data_edit);
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Dokumenunit/usermanual/V_Read_um', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_UM($id)
  	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

		$number_doc_um = $this->input->post('numberstd');
			$kode_um = explode('-', $number_doc_um);
			$s = count($kode_um);

		$judul_doc = $this->input->post('judul_um');
		$jenis_doc = $this->input->post('cop_wi_cw');
		$seksi_um = $this->input->post('seksi_um');
			$search = $this->M_pengsistem->seksiunit($seksi_um);
			foreach ($search as $key) {
				$seksifull = $key['seksi'];
			}
		$doc_um = $this->input->post('doc_um');
		$sop_um = $this->input->post('sop_um');
		$number_sop = $this->input->post('number_sop_um');
		$pic_doc = $this->input->post('pic_um');
			$pic_doc_split = explode(' - ', $pic_doc);
				$pic_id		= $pic_doc_split[0];
				$pic_name 	= $pic_doc_split[1];
		$status_doc = $this->input->post('status_um');
		$date_rev_doc = date('Y-m-d',strtotime($this->input->post('date_rev_um')));
		$date_update = date('Y-m-d h:i:sa');
		$number_rev_doc = $this->input->post('number_rev_um');

		$nomor_rev = sprintf('%02d',$number_rev_doc);

		$data		 = array(
						'doc' 				=> 'User Manual',
						'nomor_doc' 		=> $number_doc_um,
						'judul_doc' 		=> $judul_doc,
						'seksi_pengguna'	=> $seksifull,
						'jenis_doc'			=> $doc_um,
						'number_sop'		=> $number_sop,
						'seksi_sop'			=> $sop_um,
						'date_rev'			=> $date_rev_doc,
						'number_rev'		=> $number_rev_doc,
						'pic_doc'			=> $pic_name,
						'status_doc'		=> $status_doc,
						'date_update'		=> $date_update,
						'nomor_um'			=> $kode_um[$s-1],
						'a'					=> $pic_id,
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
					);
					
		$this->M_pengsistem->update_data_um($data,$id);
		redirect('DokumenUnit/user_manual');
	}

	public function delete_data_um($id)
	{
		$this->M_pengsistem->delete_um($id);
		echo 1;
	}
}