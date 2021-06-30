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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);
        $data['listdatafp'] = $this->M_pengsistem->list_data_fp();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();
		$data['user'] = $this->session->employee;
		$data['dept'] = $parameter[0]['dept'];

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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

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
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
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
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

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
					'user'				=> $this->session->employee,
					'dept'				=> $parameter[0]['dept'],
				);
				
		$this->M_pengsistem->update_flow_fp($data,$id);
		redirect('PengembanganSistem/Flow_Proses');
	}

	public function upload_data_flow($id)
	{
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

			$data_file = $_FILES['fileupload']['type'];
			$pathh = null;
			$nmfile = $data_file;
				$l = explode('/',$nmfile);
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

			if (file_exists($config['upload_path'].$config['file_name'])) {
				unlink($config['upload_path'].$config['file_name']);
			}

			// qr_image
			$qr_image= $nama_baru.'.png';
			$params['data'] = 'http://erp.quick.com/assets/upload/PengembanganSistem/fp/'.$nama_baru;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."assets/upload/PengembanganSistem/fp/".$qr_image;
			if (file_exists($params['savename'])) {
				unlink($params['savename']);
			}
			$this->ciqrcode->generate($params);
			//end

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			// untuk melihat pesan error saat upload file
			echo 'error';
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					'link_file' => 'assets/upload/PengembanganSistem/fp/'.$judul_baru,
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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);
        $data['listdatacopwi'] = $this->M_pengsistem->list_data_copwi();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();
		$data['user'] = $this->session->employee;
		$data['dept'] = $parameter[0]['dept'];

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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

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
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
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
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

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
					'nomor_copwi'		=> $number_kode_doc,
					'user'				=> $this->session->employee,
					'dept'				=> $parameter[0]['dept'],
					);
					
		$this->M_pengsistem->update_cope($data,$id);
		redirect('PengembanganSistem/cop_wi');
		}

	public function upload_data_copwi($id)
	{
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

			$data_file = $_FILES['fileupload']['type'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('/',$nmfile);
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

			if (file_exists($config['upload_path'].$config['file_name'])) {
				unlink($config['upload_path'].$config['file_name']);
			}

			// qr_image
			$qr_image= $nama_baru.'.png';
			$params['data'] = 'http://erp.quick.com/assets/upload/PengembanganSistem/copwi/'.$nama_baru;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."assets/upload/PengembanganSistem/copwi/qrcop/".$qr_image;

			if (file_exists($params['savename'])) {
				unlink($params['savename']);
			}
			$this->ciqrcode->generate($params);
			//end

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			  echo "error";
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					'link_file' => 'assets/upload/PengembanganSistem/copwi/'.$judul_baru,
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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);
        $data['listdataum'] = $this->M_pengsistem->list_data_um();
        $data['listseksi'] = $this->M_pengsistem->select_seksi();
        $data['listorg'] = $this->M_pengsistem->ambilSemuaPekerja();
		$data['user'] = $this->session->employee;
		$data['dept'] = $parameter[0]['dept'];

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
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

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
						'a'					=> $pic_id,
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
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
						'a'					=> $pic_id,
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
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

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/usermanual/V_Read_um', $data);
        $this->load->view('V_Footer', $data);
	}

	public function update_um($id)
  	{
		$kodeakses = $this->session->kodesie;
		$parameter = $this->M_pengsistem->find($kodeakses);

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
						'user'				=> $this->session->employee,
						'dept'				=> $parameter[0]['dept'],
					);
		$this->M_pengsistem->update_data_um($data,$id);
		redirect('PengembanganSistem/Usermanual');
	}

	public function upload_data_um($id)
	{
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


			$data_file = $_FILES['fileupload']['type'];

			$pathh = null;
			$nmfile = $data_file;
				$l = explode('/',$nmfile);
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

			if (file_exists($config['upload_path'].$config['file_name'])) {
				unlink($config['upload_path'].$config['file_name']);
			}

			// qr_image
			$qr_image= $nama_baru.'.png';
			$params['data'] = 'http://erp.quick.com/assets/upload/PengembanganSistem/um/'.$nama_baru;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."assets/upload/PengembanganSistem/um/".$qr_image;

			if (file_exists($params['savename'])) {
				unlink($params['savename']);
			}
			$this->ciqrcode->generate($params);
			//end

			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('fileupload')) {
			$error = array('error' => $this->upload->display_errors());
			echo "error";
			  print_r($error);
				} else {
				array('upload_data' => $this->upload->data());
				$path = $config['upload_path'].$config['file_name'];
				//end upload file area
		
				$data = array(
					'file' =>$judul_baru,
					'link_file' => 'assets/upload/PengembanganSistem/um/'.$judul_baru,
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

	public function hitung_data_memo()
	{
		$kode = $_POST['kode_doc'];
		$param_date = $_POST['param_date'];

		$data = $this->M_pengsistem->total_data($param_date,$kode)[0]['count'];
		
		echo json_encode($data);
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

	public function upload_file_ms($id_data)
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

	public function create_memo($id_a)
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
		$a = explode('ke',$id_a);
        $data['listdata'] = $this->M_pengsistem->data_cetakmemo($a[0]);
		$data['list'] = $this->M_pengsistem->list_edit_memo($a[0]);
		if ($a[1] == false) {
			$k = $this->M_pengsistem->data_cetakmemo($a[0]);
		}else {
			$k = $this->M_pengsistem->data_cetakmemo1($a[0],$a[1]);
		};
		if ($k == null) {
			$data['lists'] = null;
		} else {
			$data['lists'] = $k;
		}
		
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/Penomoran/memo/V_Create',$data);
        $this->load->view('V_Footer', $data);
	}
	
	public function creat_data_ms($id)
	{
		$nomor_surat = $this->input->post('number_surat');
		$perihal_doc = $this->input->post('perihal');
		$lampiran = $this->input->post('lampiran');
		$yth    	 = $this->input->post('yth');
		$body_surat  = $this->input->post('body_surat');
		$count = $this->M_pengsistem->countsm($id)[0]['count'];
		if ($count > 0) {
			$ke = $count + 1;
		
		$date_input = date('Y-m-d h:i:sa');
			$data		  = array(
						'id_data' => $id,
						'number_surat' => $nomor_surat,
						'perihal'     => $perihal_doc ,
						'lamp'     => $lampiran ,
						'yth'     => $yth, 
						'body_surat'     => $body_surat,
						'ke'	=> $ke
						);
		}else {
			$data		  = array(
						'id_data' => $id,
						'number_surat' => $nomor_surat,
						'perihal'     => $perihal_doc ,
						'lamp'     => $lampiran ,
						'yth'     => $yth, 
						'body_surat'     => $body_surat,
						'ke'	=> 1
						);
		}
		
		$this->M_pengsistem->getdatamemo($data);
		redirect('PengembanganSistem/sm/create_memo/'.$id.'ke'.$ke);
	}

	public function upload_file($id)
	{
		$file = $_FILES['upload']['tmp_name'];
		$file_name = $_FILES['upload']['name'];
		$file_name_array = explode(".", $file_name);
		$extension = end($file_name_array);
		$new_image_name = $id . '.' . $extension;
		
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
			$allowed_extension = array("jpg", "jpeg", "png","PNG","JPEG","JPG");
			if(in_array($extension, $allowed_extension))
			{
				move_uploaded_file($file, 'assets/upload/PengembanganSistem/memo/' . $new_image_name);
				$function_number = $_GET['CKEditorFuncNum'];
				$url = base_url().'assets/upload/PengembanganSistem/memo/' . $new_image_name;
				$message = '';
				echo"<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
	
			}
		}
	}

	public function cetak_memo($id)
	{
		$e = explode('ke',$id);
		$data['record'] = $this->M_pengsistem->data_cetakmemo1($e[0],$e[1]);

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','F4-P', 0, '', 10, 5, 40, 40,1);
		$pdf->defaultheaderline=0;
		$pdf->defaultfooterline=0;
		$filename = date('d-M-Y')."_memo.pdf";
		
		$html = $this->load->view('PengembanganSistem/Penomoran/memo/V_Cetakmemo',$data,true);
		$header = '<div style="padding-top: 0;">
			<img src="assets/img/kopsurat.png">
		</div>';
		$footer = '<div style="text-align: left; color: #0010aa"; font-family: unset; >
		<p style="font-style: unset;"><u>Cabang</u></p>
		<p style="font-weight: unset; font-style: unset; font-size: 8.7px;">Surabaya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Jl. Kebonrojo 6BB Telp. (031)35256587, 3525688, 35250706 Fax. (031)3540454 E-mail : sby@quick.co.id</p>
		<p style="font-weight: unset; font-style: unset; font-size: 8.7px;">Jakarta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Jl. Gajah Mada 154 Telp. (021)6292044, 6293428, 6490020 Fax. (021)6490013 E-mail : jkt@quick.co.id</p>
		<p style="font-weight: unset; font-style: unset; font-size: 8.7px;">Tanjungkarang : Jl. Raden Intan 159 Telp. (0720) 268498, 268495 Fax. (0721) 268498 E-mail : tkj@quick.co.id</p>
		<p style="font-weight: unset; font-style: unset; font-size: 8.7px;">Makasar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Jl. Kima 4 No. M4 Daya, Kec. Biringkanaya Telp. (0411) 514573, Fax. (0711) 514573 E-mail : mks@quick.co.id</p>
		<p style="font-weight: unset; font-style: unset; font-size: 8.7px;">Medan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Jl. Letda Sujono Komplek Pergudangan Tembung Intan No. 13 Medan, Indonesia Telp. (061) 7384680, Fax. (061) 7384680 E-mail : mdn@quick.co.id</p>
		<p style="font-style: unset;"><u>Cabang Pembantu</u></p>
		<p style="font-weight: unset; font-style: unset; font-size: 11px;">Sidrap &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Jl. Poros Parepare-Sidenreng Rappang, Kel. Batu Lamppa, Kec. Watang Pulu, Kab. Sidenreng Rappang, SULSEL <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telp. +62-82192906262, +62-88804250543 E-mail : sidrap@quick.co.id</p>
		</div>';

		$pdf->SetHeader($header);
		$pdf->SetFooter($footer);
		$pdf->WriteHTML($html);
		$pdf->Output($filename,'I');
	}

	public function delete_data_code($id)
	{
		$this->M_pengsistem->delete_code($id);
		echo 1 ;
	}

	public function delete_data_code1($id)
	{
		$this->M_pengsistem->delete_code1($id);
		echo 1 ;
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
					't' => $t,
					'i' => $i,
					'm' => $m,
					'sk' => $sk,
					'ct' => $ct,
					'ip' => $ip,
					'bulan' => $bulan.'-'.$tahun
					 );
		$this->M_pengsistem->get_lkh_input($data);
		redirect('PengembanganSistem/lkh_ps');
	}

	public function cetak_lkh()
	{
		$user = $this->session->user;
		$mounth = $this->input->post('bulan');
		$year = $this->input->post('tahun');
		$param = $this->input->post('data');
		$pic = $this->input->post('kasie');
		$data['record'] = $this->M_pengsistem->setdata($param,$user);
		$data['pic']	= $this->input->post('kasie');
		$data['date']	= $param;

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
		$param	= $this->input->post('data');

		if ($a = date('Y-m-d')) {
				$bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
			}   $s = explode('-',$a);
					$day = $s[2];
					$mon = $s[1];
					$year = $s[0];

					$f = explode('-',$param);
			$date_cetak = $bulanIndo[abs($f[0])]. ' ' .$f[1];
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

	public function excel_masterlist() 
	{
        $this->checkSession();
		$this->load->library('excel');
		
        $objPHPExcel = new PHPExcel();
        $formseksi = strtoupper($this->input->post('judulmasterlist'));
		$pic = explode("-", trim($this->input->post('picmasterlist')));
			$pic_masterlist = $pic[1];
		$post = $this->input->post('data');
		
		if ($a = date('Y-m-d')) {
				$bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
			}   $s = explode('-',$a);
					$day = $s[2];
					$mon = $s[1];
					$year = $s[0];
			$date_cetak = $bulanIndo[abs($mon - 1)]. ' ' .$year;
        $user_id = $this->session->user;
        $date_now = $day.' '.$bulanIndo[abs($mon)]. ' ' .$year ;
        // create file name
		$fileName = 'data-'.time().'.xlsx';
		if ($post == "UM") {
			$listdata = $this->M_pengsistem->setmasterlist($post);
				foreach ($listdata as $key ) {
					if ($key['doc'] = 'UM') {
						$list_data = 'User Manual';
						$list_cop = 'Working Instructions (WI /COP)';
						$list_date = 'V';
						$list_cope = null;
					} else {
						$list_data = null;
					}
				}
		} elseif ($post == "FP") {
			$listdata = $this->M_pengsistem->setmasterlist($post);
				foreach ($listdata as $key ) {
					if ($key['doc'] = 'FP') {
						$list_data = 'Flow Proses';
						$list_cop = 'Working Instructions (WI /COP)';
						$list_date = 'V';
						$list_cope = null;
					} else {
						$list_data = null;
					}
				}
		}elseif ($post == "COP") {
			$listdata = $this->M_pengsistem->setmasterlist($post);
				foreach ($listdata as $key ) {
					if ($key['doc'] = 'COP') {
						$list_data = 'User Manual';
						$list_cop = 'Working Instructions (WI /COP)';
						$list_cope = 'V';
						$list_date = null;
					} else {
						$list_data = null;
					}
				}
		}else {
			null;
		}

        $objPHPExcel = new PHPExcel();
        $objget = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();
        $objget->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objget->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setTop(0.4);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setRight(0.5);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setLeft(0.5);
        $objPHPExcel->getActiveSheet()
            ->getPageMargins()->setBottom(0.4);

		$titlejudul = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 16,
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

		$titleseksi = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 16,
			),
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
		);

		$styleleft = array(
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
		$stylecenter = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 10,
			),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
		);
		
		$stylecenter1 = array(
			'font'  => array(
				'bold'  => true,
                'size'	=> 10,
			),
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
		);

		$border = array(
			
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$stylecenterborderall = array(
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
				),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'DCDCDC')
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
		

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/logo.png');
		$objDrawing->setOffsetX(7);
		$objDrawing->setOffsetY(12);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setHeight(100);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/rectengle.png');
		$objDrawing->setOffsetX(7);
		$objDrawing->setOffsetY(2);
		$objDrawing->setResizeProportional(false);
		$objDrawing->setCoordinates('S2');
		$objDrawing->setHeight(15);
		$objDrawing->setWidth(18);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/rectengle.png');
		$objDrawing->setOffsetX(7);
		$objDrawing->setOffsetY(2);
		$objDrawing->setResizeProportional(false);
		$objDrawing->setCoordinates('S3');
		$objDrawing->setHeight(15);
		$objDrawing->setWidth(18);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/rectengle.png');
		$objDrawing->setOffsetX(7);
		$objDrawing->setOffsetY(2);
		$objDrawing->setResizeProportional(false);
		$objDrawing->setCoordinates('S4');
		$objDrawing->setHeight(15);
		$objDrawing->setWidth(18);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/rectengle.png');
		$objDrawing->setOffsetX(7);
		$objDrawing->setOffsetY(2);
		$objDrawing->setResizeProportional(false);
		$objDrawing->setCoordinates('S5');
		$objDrawing->setHeight(15);
		$objDrawing->setWidth(18);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/rectengle.png');
		$objDrawing->setOffsetX(7);
		$objDrawing->setOffsetY(2);
		$objDrawing->setResizeProportional(false);
		$objDrawing->setCoordinates('S6');
		$objDrawing->setHeight(15);
		$objDrawing->setWidth(18);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.87);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.43);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(43);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(4.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(8.57);
		
        // ----------------- KOP Dokumen -----------------
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B6');
        $objPHPExcel->getActiveSheet()->getStyle('A1:B6')->applyFromArray($titlejudul);
        $objPHPExcel->getActiveSheet()->mergeCells('C1:L3');
        $objPHPExcel->getActiveSheet()->getStyle('C1:L3')->applyFromArray($titlejudul);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:L6');
        $objPHPExcel->getActiveSheet()->getStyle('C4:L6')->applyFromArray($titleseksi);
        $objPHPExcel->getActiveSheet()->mergeCells('M1:R1');
        $objPHPExcel->getActiveSheet()->mergeCells('M5:R5');
        $objPHPExcel->getActiveSheet()->mergeCells('M6:R6');
        $objPHPExcel->getActiveSheet()->getStyle('M1:R6')->applyFromArray($stylecenter1);
        $objPHPExcel->getActiveSheet()->mergeCells('S1:Y1');
        $objPHPExcel->getActiveSheet()->getStyle('S1:Y1')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('S1:Y1')->applyFromArray($stylecenter);
        $objPHPExcel->getActiveSheet()->getStyle('S1:S6')->applyFromArray($stylecenter);
        $objPHPExcel->getActiveSheet()->mergeCells('T2:Y2');
        $objPHPExcel->getActiveSheet()->mergeCells('T3:Y3');
        $objPHPExcel->getActiveSheet()->mergeCells('T4:Y4');
        $objPHPExcel->getActiveSheet()->mergeCells('T5:Y5');
        $objPHPExcel->getActiveSheet()->mergeCells('T6:Y6');
        $objPHPExcel->getActiveSheet()->getStyle('T6:Y6')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('T1:Y6')->applyFromArray($styleleft);
		$objPHPExcel->getActiveSheet()->getStyle('S1:Y6')->applyFromArray($border);
        
        $objPHPExcel->getActiveSheet()->SetCellValue('C1','MASTERLIST OF DOCUMENT');
        $objPHPExcel->getActiveSheet()->SetCellValue('C4','UNIT '.$formseksi);
        $objPHPExcel->getActiveSheet()->SetCellValue('M1','Document Controller');
        $objPHPExcel->getActiveSheet()->SetCellValue('M5','('.$pic_masterlist.')');
        $objPHPExcel->getActiveSheet()->SetCellValue('M6',$date_now);
        $objPHPExcel->getActiveSheet()->getStyle('M1:R1')->applyFromArray($stylecenter);
        $objPHPExcel->getActiveSheet()->SetCellValue('S1','Kategori Dokumen');
        $objPHPExcel->getActiveSheet()->SetCellValue('T2','Standard Operating Procedure (SOP)');
        $objPHPExcel->getActiveSheet()->SetCellValue('T3', $list_cop);
        $objPHPExcel->getActiveSheet()->SetCellValue('S3', $list_cope);
        $objPHPExcel->getActiveSheet()->SetCellValue('T4', $list_data);
        $objPHPExcel->getActiveSheet()->SetCellValue('S4', $list_date);
        $objPHPExcel->getActiveSheet()->SetCellValue('T5','Eksternal Dokumen');
        $objPHPExcel->getActiveSheet()->SetCellValue('T6','Lain-lain : . . . . . . .');
		$objPHPExcel->getActiveSheet()->getStyle('T1:Y1')->applyFromArray($styleleft);
		
		// ----------------- Body Dokumen -----------------

        $objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
        $objPHPExcel->getActiveSheet()->mergeCells('B8:C9');
        $objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
        $objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
        $objPHPExcel->getActiveSheet()->getStyle('E8:E9')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('F8:F9');
        $objPHPExcel->getActiveSheet()->mergeCells('G8:X8');
        $objPHPExcel->getActiveSheet()->mergeCells('Y8:Y9');
        $objPHPExcel->getActiveSheet()->getStyle('A8:Y9')->applyFromArray($stylecenterborderall);
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A8','No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B8','No. Dokumen');
        $objPHPExcel->getActiveSheet()->SetCellValue('D8','Nama Dokumen');
        $objPHPExcel->getActiveSheet()->SetCellValue('E8','No. Revisi');
        $objPHPExcel->getActiveSheet()->SetCellValue('F8','Tgl Revisi');
        $objPHPExcel->getActiveSheet()->SetCellValue('G8','Distribusi terkendali');
        $objPHPExcel->getActiveSheet()->SetCellValue('G9','KKK');
        $objPHPExcel->getActiveSheet()->SetCellValue('H9','HRM');
        $objPHPExcel->getActiveSheet()->SetCellValue('I9','MKT');
        $objPHPExcel->getActiveSheet()->SetCellValue('J9','D&R');
        $objPHPExcel->getActiveSheet()->SetCellValue('K9','F&A');
        $objPHPExcel->getActiveSheet()->SetCellValue('L9','ITT');
        $objPHPExcel->getActiveSheet()->SetCellValue('M9','MTN');
        $objPHPExcel->getActiveSheet()->SetCellValue('N9','QAS');
        $objPHPExcel->getActiveSheet()->SetCellValue('O9','PUR');
        $objPHPExcel->getActiveSheet()->SetCellValue('P9','WHS');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q9','PPIC');
        $objPHPExcel->getActiveSheet()->SetCellValue('R9','FAB');
        $objPHPExcel->getActiveSheet()->SetCellValue('S9','PDE');
        $objPHPExcel->getActiveSheet()->SetCellValue('T9','TMK');
        $objPHPExcel->getActiveSheet()->SetCellValue('U9','QCT');
        $objPHPExcel->getActiveSheet()->SetCellValue('V9','RNI');
        $objPHPExcel->getActiveSheet()->SetCellValue('W9','PPB');
        $objPHPExcel->getActiveSheet()->SetCellValue('X9','RRM');
		$objPHPExcel->getActiveSheet()->SetCellValue('Y8','Ket.');
		
		// ----------------- PAGE BREAK -----------------
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 9);
		// ----------------- DATA -----------------
		$no = 1;
		$rowCount = 10;
		if ($post !== 'COP') {
			foreach ($listdata as $list) {
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':Y'.$rowCount)->applyFromArray($styleTitle2);
					$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':C'.$rowCount);
					$objPHPExcel->getActiveSheet()->getStyle('D10:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->applyFromArray($styleTitle2)->getAlignment()->setWrapText(true);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $no);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('B'.$rowCount, $list['nomor_doc']);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('D'.$rowCount, $list['judul_doc']);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('E'.$rowCount, $list['number_rev']);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('F'.$rowCount, date('d-m-Y',strtotime($list['date_rev'])));
					if ($list['seksi_pengguna'] == "KKK") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('G'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "HRM") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('H'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "MKT") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('I'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "D&R") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('J'.$rowCount, 'V');
					} else {
						null;
					}
					if (($list['seksi_pengguna'] == "F&A") or ($list['seksi_pengguna'] == "AKT")) {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('K'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "ITT") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('L'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "MTN") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('M'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "QAS") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('N'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "PUR") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('O'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "WHS") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('P'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "PPIC") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('Q'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "FAB") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('R'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "PDE") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('S'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "TMK") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('T'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "QCT") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('U'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "RNI") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('V'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "PPB") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('W'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_pengguna'] == "RRM") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('X'.$rowCount, 'V');
					} else {
						null;
					}
			$no++;
			$rowCount++;
			}
		} else {
			foreach ($listdata as $list) {
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':Y'.$rowCount)->applyFromArray($styleTitle2);
					$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':C'.$rowCount);
					$objPHPExcel->getActiveSheet()->getStyle('D10:C'.$objPHPExcel->getActiveSheet()->getHighestRow())->applyFromArray($styleTitle2)->getAlignment()->setWrapText(true);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $no);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('B'.$rowCount, $list['nomor_doc']);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('D'.$rowCount, $list['judul_doc']);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('E'.$rowCount, $list['number_rev']);
					$objPHPExcel->setActiveSheetIndex()->SetCellValue('F'.$rowCount, date('d-m-Y',strtotime($list['date_rev'])));
					if ($list['seksi_sop'] == "KKK") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('G'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "HRM") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('H'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "MKT") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('I'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "D&R") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('J'.$rowCount, 'V');
					} else {
						null;
					}
					if (($list['seksi_sop'] == "F&A") or ($list['seksi_sop'] == "AKT")) {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('K'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "ITT") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('L'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "MTN") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('M'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "QAS") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('N'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "PUR") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('O'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "WHS") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('P'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "PPIC") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('Q'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "FAB") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('R'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "PDE") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('S'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "TMK") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('T'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "QCT") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('U'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "RNI") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('V'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "PPB") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('W'.$rowCount, 'V');
					} else {
						null;
					}
					if ($list['seksi_sop'] == "RRM") {
						$objPHPExcel->setActiveSheetIndex()->SetCellValue('X'.$rowCount, 'V');
					} else {
						null;
					}
			$no++;
			$rowCount++;
			}
		}
		

		// ----------------- Final Process -----------------
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('LKH');
        $filename = "Masterlist". date("Y-m-d-H-i-s").".xlsx";
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
}