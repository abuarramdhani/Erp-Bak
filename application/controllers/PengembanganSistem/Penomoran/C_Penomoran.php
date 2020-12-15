<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_Penomoran extends CI_Controller
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
		//Pengembangan Sistem
        $data['Penomoran'] = $this->M_pengsistem->responsibility_penomoran($user_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/V_Index', $data);
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
        $data['listdatafp'] = $this->M_pengsistem->list_data_fp();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/flowproses/V_Index', $data);
        $this->load->view('V_Footer', $data);

	}

	public function cek_nomor_flow()
	{
		$seksi = $_POST['seksi'];

		$data = $this->M_pengsistem->cek_data_nomor_fp($seksi)[0]['max'];

		echo json_encode($data);
	}

	public function inputdata_fp()
	{
		$doc = 'FP';
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

		$totaldata = $this->M_pengsistem->cek_data_nomor_fp($seksi)[0]['max'];
		echo $totaldata;

		if ($totaldata>0) {
			$nomor = $totaldata+1;
		
		$nomor = sprintf('%03d',$nomor);

			$data 		= array( 'nomor_doc' => $doc.'-'.$seksi.'-'.$nomor,
						'doc' 				=> $doc,
						'judul_doc' 		=> $judul,
						'seksi_pengguna'	=> $seksi,
						'date_rev'			=> $date,
						'number_rev'		=> $number_rev,
						'pic_doc'			=> $pic_name,
						'a'					=> $pic_id,
						'status_doc'		=> $status,
						'seksi_full'		=> $seksi_full,
						'nomor_flow'		=> $nomor,
						'date_input'		=> $date_input,
					);
		}else{
			$data		 = array(
						'nomor_doc' 		=> $doc.'-'.$seksi.'-'.'001',
						'doc' 				=> $doc,
						'judul_doc'			=> $judul,
						'seksi_pengguna'	=> $seksi,
						'date_rev'			=> $date,
						'number_rev'		=> $number_rev,
						'pic_doc'			=> $pic_name,
						'a'					=> $pic_id,
						'status_doc'		=> $status,
						'seksi_full'		=> $seksi_full,
						'nomor_flow'		=> '001',
						'date_input'		=> $date_input,
						);
		}
		
			$this->M_pengsistem->get_inputdata_fp($data);
			redirect('PengembanganSistem/Flow_Proses');
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
        $this->load->view('PengembanganSistem/Penomoran/flowproses/V_Readfp', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_flow($id)
	{
		$number_flow = $this->input->post('nomor_doc');
			$kodepisah = explode('-', $number_flow);
			$doc= $kodepisah[0];
			$seksi = $kodepisah[1];
			$kode = $kodepisah[2];

		$search = $this->M_pengsistem->seksiunit($seksi);
		foreach ($search as $key) {
			$seksi_full = $key['seksi'];
		}
		$judul_fp = $this->input->post('judul_fp');
		$pic = $this->input->post('pic_fp');
			$pic_doc = explode(' - ', $pic);
				$pic_id = $pic_doc[0];
				$pic_name = $pic_doc[1];
		$status = $this->input->post('status_fp');
		$date_update = date('d-m-Y h:i:sa');
		$date = date('Y-m-d',strtotime($this->input->post('date_rev_fp')));
		$rev = $this->input->post('number_rev_fp');
		$number_rev = sprintf('%02d',$rev);

		$data 		= array( 
					'nomor_doc' 		=> $number_flow,
					'doc' 				=> $doc,
					'judul_doc'			=> $judul_fp,
					'seksi_pengguna'	=> $seksi,
					'date_rev'			=> $date,
					'number_rev'		=> $number_rev,
					'pic_doc'			=> $pic_name,
					'a'					=> $pic_id,
					'status_doc'		=> $status,
					'seksi_full'		=> $seksi_full,
					'nomor_flow'		=> $kode,
					'date_input'		=> $date_update,
				);
				
		$this->M_pengsistem->update_flow_fp($data,$id);
		redirect('PengembanganSistem/Flow_Proses');
	}

	public function upload_data_flow($id)
	{
		// print_r($_POST);exit();
		$status = strtoupper($this->input->post('doc_status'));
		$judul = strtoupper($this->input->post('nama_file'));
		$id_data = strtoupper($this->input->post('id'));

		if ($_FILES == false) {
			echo 0;
		}else{

			if(!is_dir('.assets/upload/PengembanganSistem/fp'))
			{
				mkdir('.assets/upload/PengembanganSistem/fp', 0777, true); 
				chmod('.assets/upload/PengembanganSistem/fp', 0777);
			}else {
				chmod('.assets/upload/PengembanganSistem/fp', 0777); 
			}

			$data_file = $_FILES['fileupload']['name'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('.',$nmfile);
					$s = $l[1];
				$fls = preg_replace("![^a-z0-9]+!i", "_", $judul);
			$judul_baru = $id_data.'-'.$fls.'.'.$s;
			$nama_baru = preg_replace("/[\/\&%#\$]/", "_", $judul_baru);
			
			$config['upload_path'] 			= 'assets/upload/PengembanganSistem/fp/';
			$config['allowed_types']		= '*';
			$config['max_size']             = 0;
			// $config['max_width']            = 1000;
			// $config['max_height']           = 7680;
			$config['file_name'] = $nama_baru;
// print_r($nama_baru);exit();
			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			// aktifkan kode di bawah ini untuk melihat pesan error saat upload file
			echo 'error';
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					'status_doc' =>$status
					
				);

				$this->M_pengsistem->upload_file_fp($data,$id);
				echo 1;
	
			}
		}
	
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
        $data['listdatacopwi'] = $this->M_pengsistem->list_data_copwi();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/copwi/V_Index', $data);
        $this->load->view('V_Footer', $data);

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

		$totaldata = $this->M_pengsistem->set_total_copwi($seksi_cw,$number_sop,$doc_cw)[0]['count'];
		echo $totaldata;
		$totaldoc = $this->M_pengsistem->cek_data_nomor_copwi($doc_cw,$seksi_cw,$number_sop)[0]['max'];
		echo $totaldoc;

		if ($totaldata>0) {
			$nomor = $totaldoc+1;

		$nomor = sprintf('%03d',$nomor);

			$data 		= array( 
						'doc' 				=> $doc_cw,
						'nomor_doc' 		=> $doc_cw.'-'.$seksi_cw.'-'.$number_sop.'-'.$nomor,
						'judul_doc' 		=> $judul_cw,
						'date_rev'			=> $date_rev,
						'pic_doc'			=> $pic_name,
						'a'					=> $pic_id,
						'status_doc'		=> $status_cw,
						'seksi_full'		=> $seksifull,
						'nomor_copwi'		=> $nomor,
						'date_input'		=> $date_input,
						'number_sop'		=> $number_sop,
						'seksi_sop'			=> $sop_cw,
						'number_rev'		=> $number_rev,
						'jenis_doc_cw'		=> $item_doc_cw,
					);
		}else{
			$data		 = array(
						'doc' 				=> $doc_cw,
						'nomor_doc' 		=> $doc_cw.'-'.$seksi_cw.'-'.$number_sop.'-'.'001',
						'judul_doc' 		=> $judul_cw,
						'date_rev'			=> $date_rev,
						'pic_doc'			=> $pic_name,
						'a'					=> $pic_id,
						'status_doc'		=> $status_cw,
						'seksi_full'		=> $seksifull,
						'nomor_copwi'		=> '001',
						'date_input'		=> $date_input,
						'number_sop'		=> $number_sop,
						'seksi_sop'			=> $sop_cw,
						'number_rev'		=> $number_rev,
						'jenis_doc_cw'		=> $item_doc_cw,
						);
		}

		$this->M_pengsistem->get_inputdata_copwi($data);
			redirect('PengembanganSistem/cop_wi');
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
        $this->load->view('PengembanganSistem/Penomoran/copwi/V_Read_cw', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_copwi($id)
  	{
		$number_doc_cw = $this->input->post('nomor_doc');
			$kode_cop_wi = explode('-', $number_doc_cw);
			$cop_wi= $kode_cop_wi[0];
			$seksi_small = $kode_cop_wi[1];
			$nomor_sop_doc = $kode_cop_wi[2];
			$number_kode_doc = $kode_cop_wi[3];
		$judul_doc = $this->input->post('judulcw');
		$jenis_doc = $this->input->post('cop_wi_cw');
		$seksi_cw = $this->input->post('seksi_cw');
			$search = $this->M_pengsistem->seksiunit($seksi_cw);
			foreach ($search as $key) {
				$seksifull = $key['seksi'];
			}
		$doc_cw = $this->input->post('doc_cw');
		$pic_doc = $this->input->post('pic_cw');
			$pic_doc_split = explode(' - ', $pic_doc);
				$pic_id		= $pic_doc_split[0];
				$pic_name 	= $pic_doc_split[1];
		$status_doc = $this->input->post('status_cw');
		$date_rev_doc = date('Y-m-d',strtotime($this->input->post('date_rev_cw')));
		$date_update = date('d-m-Y h:i:sa');
		$number_rev_doc = $this->input->post('number_rev_cw');

		$nomor_rev = sprintf('%02d',$number_rev_doc);

		$data		 = array(
					'nomor_doc'			=> $number_doc_cw,
					'judul_doc'			=> $judul_doc,
					'seksi_sop'			=> $seksi_cw,
					'seksi_full'		=> $seksifull,
					'doc'				=> $cop_wi,
					'pic_doc'			=> $pic_name,
					'a'					=> $pic_id,
					'status_doc'		=> $status_doc,
					'date_rev'			=> $date_rev_doc,
					'date_update'		=> $date_update,
					'number_rev'		=> $number_rev_doc,
					'number_sop'		=> $nomor_sop_doc,
					'jenis_doc_cw'		=> $doc_cw,
					'nomor_copwi'		=> $number_kode_doc
					);
					
		$this->M_pengsistem->update_cope($data,$id);
		redirect('PengembanganSistem/cop_wi');
		}

	public function upload_data_copwi($id)
	{
		// print_r($_POST);exit();
		$status = strtoupper($this->input->post('doc_status'));
		$judul = strtoupper($this->input->post('nama_file'));
		$id_data = strtoupper($this->input->post('id'));

		if ($_FILES == false) {
			echo 0;
		}else{

			if(!is_dir('.assets/upload/PengembanganSistem/copwi'))
			{
				mkdir('.assets/upload/PengembanganSistem/copwi', 0777, true); 
				chmod('.assets/upload/PengembanganSistem/copwi', 0777);
			}else {
				chmod('.assets/upload/PengembanganSistem/copwi', 0777); 
			}

			$data_file = $_FILES['fileupload']['name'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('.',$nmfile);
					$s = $l[1];
					$fls = preg_replace("![^a-z0-9]+!i", "_", $judul);
			$judul_baru = $id_data.'-'.$fls.'.'.$s;
			$nama_baru = preg_replace("/[\/\&%#\$]/", "_", $judul_baru);
			
			$config['upload_path'] 			= 'assets/upload/PengembanganSistem/copwi/';
			$config['allowed_types']		= '*';
			$config['max_size']             = 0;
			// $config['max_width']            = 1000;
			// $config['max_height']           = 7680;
			$config['file_name'] = $nama_baru;

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			// aktifkan kode di bawah ini untuk melihat pesan error saat upload file
			  echo "error";
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					'status_doc' =>$status
					
				);

				$this->M_pengsistem->upload_file_copwi($data,$id);
				echo 1;
	
			}
		}
	
	}

	public function delete_data_copwi($id)
	{

		$this->M_pengsistem->delete_copwi($id);
		echo 1;
	}
	

	//User Manual

	public function usermanual()
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
        $data['listdataum'] = $this->M_pengsistem->list_data_um();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

		// $data['show'] = $this->M_outpart->getAllIn();
		// print_r($data['Penomoran']);
		// exit();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/usermanual/V_Index', $data);
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

		$data = $this->M_pengsistem->cek_data_nomor_um($data_number);

		echo json_encode($data);
	}

	public function input_data_um()
	{
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

		$totaldata = $this->M_pengsistem->set_total_um($seksi_um,$number_sop,$doc)[0]['count'];
		echo $totaldata;
		$totaldoc = $this->M_pengsistem->set_number_um($seksi_um,$number_sop,$doc)[0]['max'];
		echo $totaldoc;

		if ($totaldata>0) {
			$nomor = $totaldoc+1;

		$nomor = sprintf('%03d',$nomor);

			$data 		= array( 
						'doc' 				=> 'User Manual',
						'nomor_doc' 		=> $doc_um.'-'.$seksi_um.'-'.$number_sop.'-'.$nomor,
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
						'nomor_um'		=> $nomor,
						'a'					=> $pic_id
					);
		}else{
			$data		 = array(
						'doc' 				=> 'User Manual',
						'nomor_doc' 		=> $doc_um.'-'.$seksi_um.'-'.$number_sop.'-001',
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
						'nomor_um'			=> '001',
						'a'					=> $pic_id
						);
		}
		
			$this->M_pengsistem->get_inputdata_um($data);
			redirect('PengembanganSistem/Usermanual');
	}

	public function edit_um($data_edit)
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

		// $data['show'] = $this->M_outpart->getAllIn();
		// print_r($data['listdatafp']);
		// exit();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/usermanual/V_Read_um', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_um($id)
  	{
		$number_doc_um = $this->input->post('number_doc_um');
			$kode_um = explode('-', $number_doc_um);
			$um= $kode_um[0];
			$seksi_small = $kode_um[1];
			$nomor_sop_doc = $kode_um[2];
			$number_kode_doc = $kode_um[3];
		$judul_doc = $this->input->post('judul_um');
		$jenis_doc = $this->input->post('cop_wi_cw');
		$seksi_um = $this->input->post('seksi_um');
			$search = $this->M_pengsistem->seksiunit($seksi_um);
			foreach ($search as $key) {
				$seksifull = $key['seksi'];
			}
		$doc_um = $this->input->post('doc_um');
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
						'number_sop'		=> $nomor_sop_doc,
						'seksi_sop'			=> $seksi_small,
						'date_rev'			=> $date_rev_doc,
						'number_rev'		=> $number_rev_doc,
						'pic_doc'			=> $pic_name,
						'status_doc'		=> $status_doc,
						'date_update'		=> $date_update,
						'nomor_um'			=> $number_kode_doc,
						'a'					=> $pic_id,
					);
					// print_r($data);exit();
		$this->M_pengsistem->update_data_um($data,$id);
		redirect('PengembanganSistem/Usermanual');
	}

	public function upload_data_um($id)
	{
		// print_r($_POST);exit();
		$status = strtoupper($this->input->post('doc_status'));
		$judul = strtoupper($this->input->post('nama_file'));
		$number_file = strtoupper($this->input->post('id'));

		if ($_FILES == false) {
			echo 0;
		}else{

			if(!is_dir('.assets/upload/PengembanganSistem/um'))
			{
				mkdir('.assets/upload/PengembanganSistem/um', 0777, true);
				chmod('.assets/upload/PengembanganSistem/um', 0777);
			}else {
				chmod('.assets/upload/PengembanganSistem/um', 0777); 
			}


			$data_file = $_FILES['fileupload']['name'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('.',$nmfile);
					$s = $l[1];
				$fls = preg_replace("![^a-z0-9]+!i", "_", $judul);
			$judul_baru = $number_file.'-'.$fls.'.'.$s;
			$nama_baru = preg_replace("/[\/\&%#\$]/", "_", $judul_baru);
			
			$config['upload_path'] 			= 'assets/upload/PengembanganSistem/um/';
			$config['allowed_types']		= '*';
			$config['max_size']             = 0;
			// $config['max_width']            = 1000;
			// $config['max_height']           = 7680;
			$config['file_name'] = $nama_baru;

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			// aktifkan kode di bawah ini untuk melihat pesan error saat upload file
			echo "error";
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					'status_doc' =>$status
					
				);

				$this->M_pengsistem->upload_file_um($data,$id);
				echo 1;
	
			}
		}
	
	}

	public function delete_data_um($id)
	{
		$this->M_pengsistem->delete_um($id);
		echo 1;
	}

	//DOKUMEN MEMO


	public function hitung_data()
	{
		$kode = $_POST['kode_doc'];
		$param_date = $_POST['param_date'];

		$data = $this->M_pengsistem->total_data($param_date,$kode)[0]['count'];
		
		echo json_encode($data);
	}

	public function memo_surat()
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
        $data['listdata_memo'] = $this->M_pengsistem->list_data_memo();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

		// $data['show'] = $this->M_outpart->getAllIn();
		// print_r($data['Penomoran']);
		// exit();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/memo/V_Index', $data);
        $this->load->view('V_Footer', $data);
		
	}
	
	public function input_data_ms()
	{
		$date      = date('Y-m-d',strtotime($this->input->post('date_ms')));
		$kode_doc      = $this->input->post('kode_ms');
		$doc_ditujukan      = $this->input->post('ditujukan_ms');
		$sie_penerima      = $this->input->post('siepenerima_ms');
		$r2sys      = $this->input->post('r2sys');
		$pic_doc      = $this->input->post('pic_ms');
		$date_distribusi      = date('Y-m-d',strtotime($this->input->post('date_distribusi')));

		$perihal_doc      = $this->input->post('perihal_ms');
		$date_input = date('Y-m-d h:i:sa');
		$seleksi_date = explode('-',$date);
		$tahun = $seleksi_date[0];	
		$bulan = $seleksi_date[1];
		$hari = $seleksi_date[2];
		$param = $tahun."-".$bulan;

		$totaldata = $this->M_pengsistem->getCountData($param,$kode_doc)[0]['count'];
		echo $totaldata;

		if ($totaldata>0) {
			$nomor = $totaldata+1;

		$nomor = sprintf('%03d',$nomor);
			$data		  = array(
						'number_memo' => $nomor.'/KU/PS/Ke-'.$kode_doc.'/'.$bulan.'/'.$tahun ,
						'date_doc'     => $date ,
						'for_doc'     => $doc_ditujukan, 
						'seksi_depart'     => $sie_penerima, 
						'pic_doc	'     => $pic_doc, 
						'date_distribusion'     => $date_distribusi,
						'perihal_doc'     => $perihal_doc, 
						'kode_doc'     => $kode_doc , 
						'conect'     => $r2sys , 
						'date_input'     => $date_input
						);
		}else{
			$data		 = array(
						'number_memo' => '001/KU/PS/Ke-'.$kode_doc.'/'.$bulan.'/'.$tahun ,
						'date_doc'     => $date ,
						'for_doc'     => $doc_ditujukan, 
						'seksi_depart'     => $sie_penerima, 
						'pic_doc'     => $pic_doc, 
						'date_distribusion'     => $date_distribusi, 
						'perihal_doc'     => $perihal_doc, 
						'kode_doc'     => $kode_doc, 
						'conect'     => $r2sys , 
						'date_input'     => $date_input
						);
		}
		
		$this->M_pengsistem->get_kode($data);
		redirect('PengembanganSistem/surat_memo');
	}

	public function edit_memo($setdata)
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
        $data['listdata_memo'] = $this->M_pengsistem->list_edit_memo($setdata);
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

		// $data['show'] = $this->M_outpart->getAllIn();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/memo/V_Read_memo', $data);
        $this->load->view('V_Footer', $data);

	}
	
	public function update_data_ms($id)
	{
		$doc_ditujukan      = $this->input->post('ditujukan_ms');
		$sie_penerima      = $this->input->post('siepenerima_ms');
		$pic_doc      = $this->input->post('pembuat_ms');
		$date_distribusi      = date('Y-m-d',strtotime($this->input->post('date_distribusi')));

		$perihal_doc      = $this->input->post('perihal_ms');
		$date_update = date('Y-m-d h:i:sa');

			$data		  = array(
						'for_doc'     => $doc_ditujukan, 
						'seksi_depart'     => $sie_penerima, 
						'pic_doc	'     => $pic_doc, 
						'date_distribusion'     => $date_distribusi,
						'perihal_doc'     => $perihal_doc, 
						'date_update'     => $date_update
						);
						
		$this->M_pengsistem->get_update_code($data,$id);
		redirect('PengembanganSistem/surat_memo');
	}

	public function upload_data_ms($id_data)
	{
		$judul = strtoupper($this->input->post('nama_file'));
		$number_file = "Memo";

		if ($_FILES == false) {
			echo 0;
		}else{

			if(!is_dir('.assets/upload/PengembanganSistem/memo'))
			{
				mkdir('.assets/upload/PengembanganSistem/memo', 0777, true);
				chmod('.assets/upload/PengembanganSistem/memo', 0777);
			}else {
				chmod('.assets/upload/PengembanganSistem/memo', 0777); 
			}


			$data_file = $_FILES['fileupload']['name'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('.',$nmfile);
					$s = $l[1];
				$fls = preg_replace("![^a-z0-9]+!i", "_", $judul);
			$judul_baru = $number_file.'-'.$fls.'.'.$s;
			
			$config['upload_path'] 			= 'assets/upload/PengembanganSistem/memo/';
			$config['allowed_types']		= '*';
			$config['max_size']             = 0;
			// $config['max_width']            = 1000;
			// $config['max_height']           = 7680;
			$config['file_name'] = $judul_baru;

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			// aktifkan kode di bawah ini untuk melihat pesan error saat upload file
			echo "error";
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					
				);

				$this->M_pengsistem->upload_file_code($data,$id_data);
				echo 1;
	
			}
		}
	
	}

	public function delete_data_code($id)
	{

		$this->M_pengsistem->delete_code($id);
		redirect('PengembanganSistem/surat_memo');
	}

	//OPERATOR LKH

	public function lkh_ps()
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
        // $data['listdata_lkh'] = $this->M_pengsistem->list_data_lkh();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();

		$user = $this->session->user;
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$param = ($bulan."-".$tahun);
		$data['tahun'] = $tahun;
		$data['bulan'] = $bulan;
		$data['listdata_lkh'] = $this->M_pengsistem->set_lkh($param,$user);
			if ($bulan == '') {
		$data['listdata_lkh'] = $this->M_pengsistem->set_lkh1($user);
			}
// print_r($data['listdata_lkh']);exit();
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/operator/V_Index', $data);
        $this->load->view('V_Footer', $data);
	}

	public function input_lkh_proses()
	{
		$hari = $this->input->post('hari_masuk');
		$tanggal = $this->input->post('date_masuk');
		if ($tanggal == '') {
			$tanggalhasil = null;
		}else {
			$tanggalhasil = date('Y-m-d', strtotime($tanggal));
		}
		$uraian_pekerjaan = $this->input->post('uraian_pekerjaan');
		$kode = $this->input->post('kode_seksi');
		$aTarget = $this->input->post('total_target');
		$waktu_mulai = $this->input->post('waktu_mulai');
		$waktu_selesai = $this->input->post('waktu_selesai');
		$total_waktu = $this->input->post('total_waktu');
		$user = $this->session->user;
		$persen = $this->input->post('persen');
		// $persetujuan_kualitas = $this->input->post('persetujuan_kualitas');
		$t = $this->input->post('t');
		$i = $this->input->post('i');
		$m = $this->input->post('m');
		$sk = $this->input->post('sk');
		$ct = $this->input->post('ct');
		$ip = $this->input->post('ip');

		$date = explode('-',$tanggalhasil);
		$tahun = $date[0];
		$bulan = $date[1];
		$param = $tahun."-".$bulan;

		$data = array('harimasuk' => $hari,
					'tglmasuk' => $tanggalhasil ,
					'uraian_pekerjaan' => $uraian_pekerjaan,
					'kodesie' => $kode,
					'targetjob' => $aTarget,
					'waktu_mulai' => $waktu_mulai,
					'waktu_selesai' => $waktu_selesai,
					'total_waktu' => $total_waktu,
					'pic' => $user,
					'persen' => $persen,
					// 'persetujuan_kualitas' => $persetujuan_kualitas,
					't' => $t,
					'i' => $i,
					'm' => $m,
					'sk' => $sk,
					'ct' => $ct,
					'ip' => $ip,
					'bulan' => $bulan.'-'.$tahun
					 );
					//  print_r($data);exit();
		$this->M_pengsistem->get_lkh_input($data);
		redirect('PengembanganSistem/lkh_ps');
	}

	public function cetak_lkh()
	{
		$user = $this->session->user;
		$param = $this->input->post('data');
		$pic = $this->input->post('kasie');
		$data['record'] = $this->M_pengsistem->setdata($param,$user);
		$data['pic']	= $this->input->post('kasie');

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','F4-L', 0, '', 2, 2, 2, 2);
		$filename = date('d-M-Y')."_lkh.pdf";
		
		$html = $this->load->view('PengembanganSistem/operator/V_Print_Lkh',$data, true);

		$pdf->WriteHTML($html);
		$pdf->Output($filename,'I');
	}

	public function excel_lkh() 
	{
        $this->checkSession();
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $user = $this->session->employee;
        $kasie_pic = trim($this->input->post('kasie'));

		if ($a = date('Y-m-d')) {
				$bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
			}   $s = explode('-',$a);
					$day = $s[2];
					$mon = $s[1];
					$year = $s[0];
			$date_cetak = $bulanIndo[abs($mon - 1)]. ' ' .$year;
        $user_id = $this->session->user;
        $date_now = 'Yogyakarta, '.$day.' '.$bulanIndo[abs($mon)]. ' ' .$year ;
        $param = $this->input->post('data');
        // create file name
		$fileName = 'data-'.time().'.xlsx';
		
		$listInfo = $this->M_pengsistem->setdata($param,$user_id);
        $objPHPExcel = new PHPExcel();
        $objget = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();
        $objget->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objget->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setTop(0.4);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setRight(0.5);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setLeft(0.5);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setBottom(0.4);

            $styleTitle = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 14,
			),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
		);
		$styleTitle0 = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 10,
			),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
		);
		$styleotorisasi = array(
			'font'  => array(
				'bold'  => false,
                'size'	=> 10,
			),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
		);
		$styleTitle1 = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 10,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
        );

		$styleTitle2 = array(
			'font'  => array(
				'bold'  => false,
                'size'	=> 10,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
		);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(34);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
        $objPHPExcel->getActiveSheet()->getStyle('A4:A5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
        $objPHPExcel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
        $objPHPExcel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
        $objPHPExcel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
        $objPHPExcel->getActiveSheet()->getStyle('E4:E5')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
        $objPHPExcel->getActiveSheet()->getStyle('F4:G4')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->getStyle('F5:G5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('H4:H5');
        $objPHPExcel->getActiveSheet()->getStyle('H4:H5')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4:H5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('I4:I5');
        $objPHPExcel->getActiveSheet()->getStyle('I4:I5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('J4:J5');
        $objPHPExcel->getActiveSheet()->getStyle('J4:J5')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('J4:J5')->applyFromArray($styleTitle1);
        $objPHPExcel->getActiveSheet()->mergeCells('L4:Q4');
        $objPHPExcel->getActiveSheet()->getStyle('L4:Q5')->applyFromArray($styleTitle1);
        //set judul
        $objPHPExcel->getActiveSheet()->SetCellValue('A1','LAPORAN KERJA HARIAN ADMINISTRASI PENGEMBANGAN SISTEM');
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A2','NAMA');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2',": $user");
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($styleTitle0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A3','NO. INDUK');
        $objPHPExcel->getActiveSheet()->SetCellValue('B3',": $user_id");
        $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->applyFromArray($styleTitle0);
        //date cetak
        $objPHPExcel->getActiveSheet()->mergeCells('L3:Q3');
        $objPHPExcel->getActiveSheet()->getStyle('L3:Q3')->applyFromArray($styleTitle0);
        $objPHPExcel->getActiveSheet()->SetCellValue('L3',"Bulan : $date_cetak",'C');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleTitle0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Hari');
        $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Tanggal');
        $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Uraian Pekerjaan');
        $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Kode');
        $objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Target Waktu');
        $objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Waktu');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Mulai');
        $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Selesai');
        $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Total Waktu');
        $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Ip%');
        $objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Persetujuan Kualitas');
        $objPHPExcel->getActiveSheet()->SetCellValue('L4', 'Keterangan');
        $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'T');
        $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'I');
        $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'M');
        $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'SK');
        $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'CT');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'IP');
        // set Row
        $rowCount = 6;
        foreach ($listInfo as $list) {

			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->applyFromArray($styleTitle2);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$rowCount.':Q'.$rowCount)->applyFromArray($styleTitle2);
			$objPHPExcel->getActiveSheet()->getStyle('C5:C'.$objPHPExcel->getActiveSheet()->getHighestRow())->applyFromArray($styleTitle2)->getAlignment()->setWrapText(true);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $no);
			// $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->applyFromArray($styledate);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('A'.$rowCount, $list['harimasuk']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('B'.$rowCount, $list['tglmasuk']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('C'.$rowCount, $list['uraian_pekerjaan']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('D'.$rowCount, $list['kodesie']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('E'.$rowCount, $list['targetjob']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('F'.$rowCount, $list['waktu_mulai']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('G'.$rowCount, $list['waktu_selesai']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('H'.$rowCount, $list['total_waktu']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('I'.$rowCount, $list['persen']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('L'.$rowCount, $list['t']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('M'.$rowCount, $list['i']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('N'.$rowCount, $list['m']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('O'.$rowCount, $list['sk']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('P'.$rowCount, $list['ct']);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('Q'.$rowCount, $list['ip']);
            $rowCount++;
        }
        $rowCount+=0;
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':J'.$rowCount);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':J'.$rowCount)->applyFromArray($styleotorisasi);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $date_now);

        $rowCount+=3;
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':J'.$rowCount);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':J'.$rowCount)->applyFromArray($styleotorisasi);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '('.$kasie_pic.')');

		// ----------------- Final Process -----------------
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('LKH');
        $filename = "lkh". date("Y-m-d-H-i-s").".xlsx";
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setPreCalculateFormulas(true);
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
		$objWriter->save("php://output");
    }

	public function delete_lkh($id)
	{
		$this->M_pengsistem->delete_lkh_get($id);
		echo 1 ;
	}

	public function cek_tgl_lkh()
	{
		$data_user = $this->session->user;
		$data_number = $_POST['date_lkh'];

		$data = $this->M_pengsistem->cek_data_lkh($data_number, $data_user);

		echo json_encode($data);
	}

	public function input_dataseksi() {
		$singkat =$_POST['singkat'];
		$seksi =$_POST['lengkap'];

		$data = array('seksi' => $seksi,
					'singkat' => $singkat ,
					 );
					//  print_r($data);exit();
		$this->M_pengsistem->get_seksi_input($data);
		echo 1;
	}

	public function viewdataalert()
	{
		
		$data = $this->M_pengsistem->view_alret();
		
		$jsonResult = '{"data" : [ ';
			$i=0;
			   if($i != 0){
				   
				   $jsonResult =',';
			   }
			   $jsonResult =json_encode($data);
			   $i++;
			print_r($jsonResult);exit();
			$jsonResult = ']}';
			echo $jsonResult;
	}

	public function delete_alert($id)
	{
		$this->M_pengsistem->delete_alert_get($id);
		echo 1 ;
	}
}