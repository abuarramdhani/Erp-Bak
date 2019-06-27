<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Order extends CI_Controller
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
		$this->load->library('ciqrcode');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3V2/MainMenu/M_order');
		$this->load->model('P2K3V2/P2K3Admin/M_dtmasuk');
		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
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

		$data['Title'] = 'Order';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind 						= $this->session->user;
		$data['seksi'] 				= $this->M_order->getSeksi($noind);
		$data['tampil_data'] 		= $this->M_order->ambil_data();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	
	public function list_order()
	{
		$user = $this->session->username;
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->session->user;

		$kodesie 					= $this->session->kodesie;
		$data['seksi'] 				= $this->M_order->getSeksi($noind);
		$data['tampil_data'] 		= $this->M_order->tampil_data($kodesie);
		$cek 						= $this->M_order->tampil_data($kodesie);
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		// echo "<pre>"; print_r($data['daftar_pekerjaan']);exit();
		$c = count($data['tampil_data'])-1;
		$data['jmlOrder'] = 'false';
		if ($c >= 0) {
			if ($cek[$c]['periode'] == date("Y-m", strtotime(" +1 months")) && $cek[$c]['status'] == '1') {
				$data['jmlOrder'] = 'true';
			}else{
				$data['jmlOrder'] = 'false';
			}
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/Order/V_List_Order', $data);
		$this->load->view('V_Footer',$data);
	}

	public function approve($id_kebutuhan,$id_kebutuhan_detail)
	{	
		$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['cek']	= $this->M_order->join_3($id_kebutuhan_detail);

		$status				= '1';
		$status1 = array(
			'status' 			=> $status,
			'status_updated'	=> date('Y-m-d H:i:s'),
			'status_updated_by'	=> $this->session->user,
			);
		$this->M_order->update_status($id_kebutuhan_detail,$status1);

		$c_status			= 't';
		$status2 = array(
			'checked_status' => $c_status, 
			);
		$this->M_order->update_c_status($id_kebutuhan,$status2);
				// redirect('P2K3/Order/list_order');
				// echo '<script language="javascript">';
				// echo 'history.go(-1);alert("message successfully sent")';
				// echo '</script>';
		redirect($_SERVER['HTTP_REFERER']);
				// redirect($_SERVER['REQUEST_URI'], 'refresh');
	}

	public function reject($id_kebutuhan_detail)
	{	
		$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['cek']	= $this->M_order->join_3($id_kebutuhan_detail);

		$status				= '2';
		$status1 = array(
			'status' 			=> $status,
			'status_updated'	=> date('Y-m-d H:i:s'),
			'status_updated_by'	=> $this->session->user,
			);

		$this->M_order->update_status($id_kebutuhan_detail,$status1);
		redirect($_SERVER['HTTP_REFERER']);
				// redirect('P2K3/Order/list_order');
	}

	public function input()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Edit Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kodesie 					= $this->session->kodesie;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/Order/V_Reset', $data);
		$this->load->view('V_Footer',$data);
		
		
	}

	public function save_data(){
		$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		echo "<pre>";print_r($_POST); exit();
//=============================================k3.k3_kebutuhan==============================================
		$periode 	= $this->input->post('k3_periode');
		$data = array(
			'periode' 			=> $periode,
			'kodesie' 			=> $kodesie,
			'user_created'		=> $this->session->user,
			'create_timestamp'	=> date('Y-m-d H:i:s'),
			);

		$this->M_order->save_dataPeriode($data);
				// $header_id = $this->db->insert_id();
				// print_r($header_id);
				// exit();

//=============================================k3.k3_kebutuhan_detail=======================================
		$ttl_baris	= sizeof($this->input->post('txtJenisAPD'));
		for ($i=0; $i < $ttl_baris; $i++) { 
			$ttl_order	= 0;
			$ttl_req	= 0;
			$jumlah1 = array();
			$jumlah2 = array();
			$ttl_kolom	= sizeof($this->input->post("numJumlah[]"));

			for ($a=0; $a < $ttl_kolom ; $a++) { 
				$ttl_req	+= $this->input->post("numJumlah[$a][$i]") * $this->input->post("pkjJumlah[$a][$i]");
				$jumlah = $this->input->post("numJumlah[$a][$i]");
				$jumlah2x = $this->input->post("pkjJumlah[$a][$i]");
				$jumlah1[] = $jumlah;
				$jumlah2[] = $jumlah2x;
			}
			$ttl_order = $ttl_req + $this->input->post("txtKebutuhanUmum[$i]");

			$jenis_apd	= $this->input->post('txtJenisAPD[]');
			foreach ($jenis_apd as $apd) {
				$id_apd				= $header_id;
				$apd 				= $this->input->post("txtJenisAPD[$i]");
				$kode				= $this->input->post("txtKodeItem[$i]");
				$panggil			= $this->M_order->getNamaApd($kode);
				$namaApd 			= $panggil[0]['item'];
				$ttl_kebutuhan		= $ttl_req;
				$total 				= $ttl_order;		
				$kebutuhan 			= $this->input->post("txtKebutuhanUmum[$i]");
				$keterangan			= $this->input->post("txtKeterangan[$i]");					
			}

			$lines = array(
				'id_kebutuhan'	=>	$id_apd,
				'item'			=>	$namaApd,
				'kode_item'		=>	$kode,
				'ttl_order'		=>	$total,
				'ttl_request'	=>	$ttl_kebutuhan,
				'jml_umum'		=>	$kebutuhan,
				'desc'			=> 	$keterangan,
				'status'		=> 	'0',
				'create_date'	=>  date('Y-m-d H:i:s')
				);
			$this->M_order->save_data_apd($lines);
							// $id = $this->db->insert_id();	
//=============================================k3.k3_kebutuhan_pekerja=======================================
			$id_pekerja						= $id;
			$jml_apd 						= implode(',', $jumlah1);
			$jml_pkj 						= implode(',', $jumlah2);
			$data["kode_pekerjaan[$i][$a]"]	= $this->M_order->kode_pekerjaan($kodesie);
			$kd_pkrj 						= $data["kode_pekerjaan[$i][$a]"];	
			$data_pkerja = array();
			foreach ($kd_pkrj as $kd) {
				$data_pkerja[]	= $kd['kdpekerjaan']; 
			}
			$kd_pkj = implode(',', $data_pkerja);

			$tbl_pekerja = array(
				'id_kebutuhan_detail'	=> $id_pekerja,
				'kd_pekerjaan'			=> $kd_pkj,
				'jml'					=> $jml_apd,
				'jml_pkj'				=> $jml_pkj,
				);

			$this->M_order->save_data_pekerja($tbl_pekerja);
			$id_log	= $this->db->insert_id();
//===============================================k3.k3_log===================================================
			$id_history = $id_log;

			$history = array(
				'id_kebutuhan'	=> $id_history,
				'create_date'	=> date('Y-m-d H:i:s'),
				'create_user'	=> $this->session->user,
				'history_type'	=> 'create',
				);

			$this->M_order->history_log($history);
		}

		redirect('P2K3_V2/Order/list_order');
	}

	public function edit($id_kebutuhan_detail)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kodesie = $this->session->kodesie;
		$data['daftar_pekerjaan'] = $this->M_order->daftar_pekerjaan($kodesie);

		$data['edit']	= $this->M_order->tampil_data_edit($id_kebutuhan_detail);
		// echo "<pre>";print_r($data['edit']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/Order/V_Edit', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function update_data($id_kebutuhan_detail, $kodesie)	
	{
			// echo "<pre>"; print_r($_POST); exit();
		$user1 = $this->session->user;
		$data['approveString'] 		= $this->M_order->approveString($user1);
			// print_r($data['approveString']); exit();
		$sie = $kodesie;
		$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
	//=============================================k3.k3_kebutuhan_detail=======================================
		$ttl_baris	= sizeof($this->input->post('txtJenisAPD'));
		for ($i=0; $i < $ttl_baris; $i++) { 
			$ttl_order	= 0;
			$ttl_req	= 0;
			$jumlah1 	= array();
			$jumlah2 	= array();
			$ttl_kolom	= sizeof($this->input->post("numJumlah[]"));
			$coba = "";
			for ($a=0; $a < $ttl_kolom ; $a++) { 
				$ttl_req	+= $this->input->post("numJumlah[$a][$i]") * $this->input->post("pkjJumlah[$a][$i]");
				$jumlah = $this->input->post("numJumlah[$a][$i]");
						// if (empty($jumlah)) {
						// 	$jumlah = 0;
						// }
				$jumlah2x = $this->input->post("pkjJumlah[$a][$i]");
						// if (empty($jumlah2x)) {
						// 	$jumlah2x = 0;
						// }
				$jumlah1[] = $jumlah;
				$jumlah2[] = $jumlah2x;
						// $d = $this->input->post("pkjJumlah[$a][$i]");
						// $coba = $coba."ttl_reg :".$ttl_req."d :".$d;
			}
					// echo $coba;exit();
			$ttl_order = $ttl_req + $this->input->post("txtKebutuhanUmum[$i]");
			$jenis_apd	= $this->input->post('txtJenisAPD[]');
			foreach ($jenis_apd as $apd) {
				$apd 				= $this->input->post("txtJenisAPD[$i]");
				$kode 				= $this->input->post("txtKodeItem[$i]");
				$panggil			= $this->M_order->getNamaApd($kode);
				$namaApd 			= $panggil[0]['item'];
				$ttl_kebutuhan		= $ttl_req;
				$total 				= $ttl_order;		
				$kebutuhan			= $this->input->post("txtKebutuhanUmum[$i]");
				$keterangan			= $this->input->post("txtKeterangan[$i]");					
			}

			$lines = array(
				'item'			=>	$namaApd,
				'kode_item'		=>	$kode,
				'ttl_order'		=>	$total,
				'ttl_request'	=>	$ttl_kebutuhan,
				'jml_umum'		=>	$kebutuhan,
				'desc'			=> 	$keterangan,
				);
			if ($total < 1) {
				echo "<script type='text/javascript'>alert('Jumlah order tidak boleh 0');</script>";
			}else{
				$this->M_order->update_kebutuhan_detail($lines,$id_kebutuhan_detail);
	//=============================================k3.k3_kebutuhan_pekerja=======================================
				$jml_apd 						= implode(',',$jumlah1) ;
				$jml_pkj 						= implode(',',$jumlah2) ;
				$data["kode_pekerjaan[$i][$a]"]	= $this->M_order->kode_pekerjaan($kodesie);
				$kd_pkrj 						= $data["kode_pekerjaan[$i][$a]"];	
				$data_pkerja = array();
				foreach ($kd_pkrj as $kd) {
					$data_pkerja[]	= $kd['kdpekerjaan']; 
				}
				$kd_pkj = implode(',', $data_pkerja);

				$tbl_pekerja = array(
					'kd_pekerjaan'			=> $kd_pkj,
					'jml'					=> $jml_apd,
					'jml_pkj'				=> $jml_pkj,
					);

				$this->M_order->update_kebutuhan_pekerja($tbl_pekerja,$id_kebutuhan_detail);
			}
		}

	//===============================================k3.k3_log===================================================
		$id_apdet 	= $this->M_order->ambil_id($id_kebutuhan_detail);
		$id_hs 		= $id_apdet[0]['id_kebutuhan_pekerja'];
		$history = array(
			'id_kebutuhan'	=> $id_hs,
			'update_date'	=> date('Y-m-d H:i:s'),
			'update_user'	=> $this->session->user,
			'history_type'	=> 'update',
			);
		$this->M_order->history($history);
							// header("location:javascript://history.go(-1)");
		if ($data['approveString']  == 'f'){
								// $this->list_order();
			redirect('P2K3_V2/Order/list_order/');
		}else{
			redirect('P2K3_V2/Order/listPerSie/'.$sie);
		}
		
	}

	public function delete_apd($id_kebutuhan_detail)
	{
		$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);

		$id_apdet 	= $this->M_order->ambil_id($id_kebutuhan_detail);
		$id_hs 		= $id_apdet[0]['id_kebutuhan_pekerja'];

		$history = array(
			'id_kebutuhan'	=> $id_hs,
			'delete_date'	=> date('Y-m-d H:i:s'),
			'delete_user'	=> $this->session->user,
			'history_type'	=> 'delete',
			);
		$this->M_order->history($history);
		$this->M_order->delete_apd($id_kebutuhan_detail);
		$this->M_order->delete_apd2($id_kebutuhan_detail);
		redirect($_SERVER['HTTP_REFERER']);
				// redirect('P2K3/Order/list_order');
	}

	public function input_bulan_lalu($id_kebutuhan_detail)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kodesie = $this->session->kodesie;
		$data['daftar_pekerjaan'] = $this->M_order->daftar_pekerjaan($kodesie);
			// $data['input']	= $this->M_order->getId($id_kebutuhan_detail);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/Order/V_Input', $data);
		$this->load->view('V_Footer',$data);
	}

	public function reset()
	{
		$user = $this->session->username;
		$kodesie 					= $this->session->kodesie;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Edit Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		$data['max_pekerja']	= 	count($this->M_order->maxPekerja($kodesie));
		// echo $data['max_pekerja'];exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/Order/V_Reset', $data);
		$this->load->view('V_Footer',$data);
	}

	/*public function save_reset()
		{
			$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
	//=============================================k3.k3_kebutuhan==============================================
		$periode 	= $this->input->post('k3_periode');
				$data = array(
					'periode' 			=> $periode,
					'kodesie' 			=> $kodesie,
					'user_created'		=> $this->session->user,
					'create_timestamp'	=> date('Y-m-d H:i:s'),
					);

				$this->M_order->save_dataPeriode($data);
				$header_id = $this->db->insert_id();

	//=============================================k3.k3_kebutuhan_detail=======================================
		$ttl_baris	= sizeof($this->input->post('txtJenisAPD'));
		for ($i=0; $i < $ttl_baris; $i++) { 
				$ttl_order	= 0;
				$ttl_req	= 0;
				$jumlah1 = array();
				$ttl_kolom	= sizeof($this->input->post("numJumlah[]"));

				for ($a=0; $a < $ttl_kolom ; $a++) { 
					$ttl_req	+= $this->input->post("numJumlah[$a][$i]");
					$jumlah = $this->input->post("numJumlah[$a][$i]");
					$jumlah1[] = $jumlah;
				}
					$ttl_order = $ttl_req + $this->input->post("txtKebutuhanUmum[$i]");
					

				$jenis_apd	= $this->input->post('txtJenisAPD[]');
					foreach ($jenis_apd as $apd) {
						$id_apd				= $header_id;
						$apd 				= $this->input->post("txtJenisAPD[$i]");
						$kode				= $this->input->post("txtKodeItem[$i]");
						$panggil			= $this->M_order->getNamaApd($kode);
						$namaApd 			= $panggil[0]['item'];
						$ttl_kebutuhan		= $ttl_req;
						$total 				= $ttl_order;		
						$kebutuhan 			= $this->input->post("txtKebutuhanUmum[$i]");
						$keterangan			= $this->input->post("txtKeterangan[$i]");					
						}

							$lines = array(
								'id_kebutuhan'	=>	$id_apd,
								'item'			=>	$namaApd,
								'kode_item'		=>	$kode,
								'ttl_order'		=>	$total,
								'ttl_request'	=>	$ttl_kebutuhan,
								'jml_umum'		=>	$kebutuhan,
								'desc'			=> 	$keterangan,
								'status'		=>	'0',
								'create_date'	=>	date('Y-m-d H:i:s')
								);
							$this->M_order->save_data_apd($lines);
							$id = $this->db->insert_id();	
	//=============================================k3.k3_kebutuhan_pekerja=======================================
						$id_pekerja						= $id;
						$jml_apd 						= implode(',', $jumlah1);
						$data["kode_pekerjaan[$i][$a]"]	= $this->M_order->kode_pekerjaan($kodesie);
						$kd_pkrj 						= $data["kode_pekerjaan[$i][$a]"];	
						$data_pkerja = array();
						foreach ($kd_pkrj as $kd) {
							$data_pkerja[]	= $kd['kdpekerjaan']; 
							}
						$kd_pkj = implode(',', $data_pkerja);

							$tbl_pekerja = array(
								'id_kebutuhan_detail'	=> $id_pekerja,
								'kd_pekerjaan'			=> $kd_pkj,
								'jml'					=> $jml_apd,
							);
		
					$this->M_order->save_data_pekerja($tbl_pekerja);
					$id_log	= $this->db->insert_id();
	//===============================================k3.k3_log===================================================
					$id_history = $id_log;

					$history = array(
						'id_kebutuhan'	=> $id_history,
						'create_date'	=> date('Y-m-d H:i:s'),
						'create_user'	=> $this->session->user,
						'history_type'	=> 'create',
						);

					$this->M_order->history_log($history);
					}
					redirect('P2K3/Order/list_order');
				}*/

				public function export()
				{
					$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
					$kodesie = $this->session->kodesie;
					$noind = $this->session->user;
					$data['seksi'] = $this->M_order->getSeksi($noind);
					$header = $data['seksi'];
					$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
					$objPHPExcel = new PHPExcel();

					$objPHPExcel->getProperties()->setCreator('KHS ERP')
					->setTitle("DAFTAR KEBUTUHAN SARANA P2K3")
					->setSubject("SARANA P2K3")
					->setDescription("Laporan Kebutuhan Sarana P2K3")
					->setKeywords("Kebutuhan Sarana P2K3");

					$style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara horizontal (left)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara horizontal (right)
            ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
          'fill' => array(
          	'type' => PHPExcel_Style_Fill::FILL_SOLID,
          	'color' => array('rgb' => 'bababa')
          	)
          );  

					$style_col1 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
          );
					$style_col2 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
          'fill' => array(
          	'type' => PHPExcel_Style_Fill::FILL_SOLID,
          	'color' => array('rgb' => 'bababa')
          	)
          );

					$style_row = array(
						'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
						'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
						);

       	// $jarak = array_chunk(range('D', 'Z'), 2);
					$range = range('D','Z');
					$range2 = range('E','Z',2);
					$n = array('KEBUTUHAN UMUM','TOTAL ORDER','TOTAL PEMAKAIAN','KETERANGAN','STATUS');
					$hitung = count($data['daftar_pekerjaan']);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A15', $hitung);
					$statik	= $hitung+5;
					$hitung2 = 3+ (2*count($data['daftar_pekerjaan']));

					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR KEBUTUHAN SARANA P2K3");
					$objPHPExcel->getActiveSheet()->mergeCells('A1:L2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "DEPARTEMENT");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', "BIDANG");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', "UNIT");
        $objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
        $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
        $objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "NO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "NAMA APD");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "KODE ITEM");
        $i=3;
        foreach ($data['daftar_pekerjaan'] as $key) {
        	$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i);
        	$kolom_new2 = PHPExcel_Cell::stringFromColumnIndex($i+1);
    		// if ($i == $hitung) {
    			// $range = range('D','Z');
    			// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($range[$i].'15', 'benar');
    		// }
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.'8', $key['pekerjaan']);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new2.'8','Jumlah Pekerja ('.$key['pekerjaan'].')');
    		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($range2[$i].'8', 'Jumlah Pekerja ('.$key['pekerjaan'].')');
        	$i +=2;
        }

        $tbl =0;
        $i_new = $i;
    	for ($x=$hitung; $x <$statik ; $x++) { //$x=3 ; $x < 8 
    		$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i_new);
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.'8', $n[$tbl]);
    		$tbl++;
    		$i_new++;
    	}

    	$rg = range('D','Z');
    	$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	for ($b=0; $b < $hitung2; $b++) {
    		$kolom_new = PHPExcel_Cell::stringFromColumnIndex($b);
    		$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	}
    	$tbl =0;
    	$i_new2 = $i;
    	for ($x=$hitung; $x<$statik ; $x++) { 
    		$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i_new2);
    		$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8', $n[$tbl])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		$tbl++;
    		$i_new2++;
    	}
    	

        // PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        // foreach(range('A', 'Z') as $columnID) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        //         ->setAutoSize(true);
        // }

    	$ra = range('D', 'Z');
    	$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col2);
    	$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col2);
    	$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col2);
    	$objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col1);
    	$objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col1);
    	$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col1);
    	$objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col1);
    	$objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col1);
    	$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col1);
    	$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
    	$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
    	$objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
    	for ($c=0; $c < $hitung2; $c++) {
    		$kolom_new = PHPExcel_Cell::stringFromColumnIndex($c);
    		$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8')->applyFromArray($style_col);
    	}

    	$tbl = 0;
    	$i_new3 = $i;
    	for ($x=$hitung; $x < $statik; $x++) { 
    		$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i_new3);
    		$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8', $n[$tbl])->applyFromArray($style_col);
    		$tbl++;
    		$i_new3++;
    	}	


    	$export = $this->M_order->tampil_data($kodesie);

    	$no = 1;
    	$numrow = 9; 
    	$r = range('D', 'Z');
    	$r2 = range('E', 'Z', 2);
    	$r3 = range('E', 'Z');
        	//menampilkan departement,bidang,unit
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', ': '.$header[0]['dept']);	        
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', ': '.$header[0]['bidang']);	        
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', ': '.$header[0]['unit']);	        
    	foreach($export as $dt){
    		$e = 0;
    		$search =array('0','1','2');
    		$change = array('pending','approve','reject');
    		$ubah = str_replace($search, $change, $dt['status']);
    		$f = array($dt['jml_umum'],$dt['ttl_order'],$dt['ttl_pakai'],$dt['desc'],$ubah);

        	//menampilkan data apd
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $dt['item']);
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $dt['kode_item']);
    		$i=3;
    		foreach ($data['daftar_pekerjaan'] as $dp) {
    			$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i);
    			$kolom_new2 = PHPExcel_Cell::stringFromColumnIndex($i+1);
    			$jumlah = explode(',',$dt['jml']);
    			$jumlah2 = explode(',',$dt['jml_pkj']);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.$numrow, $jumlah[$e]);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new2.$numrow, $jumlah2[$e]);
    			$e++;
    			$i +=2;}

    			$tbl = 0;
    			$i_new = $i;
    			for ($x=$hitung; $x < $statik; $x++) { 
    				$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i_new);
    				$objPHPExcel->setActiveSheetIndex()->setCellValue($kolom_new.$numrow, $f[$tbl]);
    				$tbl++;
    				$i_new++;}	


    				$objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    				$objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    				$objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);


    				$e = 0;
    				$i_new3 = 3;
    				for ($x=0; $x < $hitung2; $x++) { 
    					$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i_new3);
    					$objPHPExcel->getActiveSheet()->getStyle($kolom_new.$numrow)->applyFromArray($style_row);
    					$e++;
    					$i_new3++;
    				}

    				$tbl = 0;
    				$i_new2 = $i;
    				for ($x=$hitung; $x < $statik; $x++) { 
    					$kolom_new = PHPExcel_Cell::stringFromColumnIndex($i_new2);
    					$objPHPExcel->getActiveSheet()->getStyle($kolom_new.$numrow, $f[$tbl])->applyFromArray($style_row);
    					$tbl++;
    					$i_new2++;}	

    					$no++;
    					$numrow++;
    				}

    				$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

    				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    				$objPHPExcel->getActiveSheet()->setTitle('DAFTAR KEBUTUHAN P2K3');

    				$objPHPExcel->setActiveSheetIndex(0);  
    				$filename = urlencode("Daftar Kebutuhan P2K3 ".date("Y-m-d").".ods");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

              $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
              $objWriter->save('php://output');

              redirect('P2K3_V2/Order/list_order');
          }

          public function getItem()
          {
          	$item = $_GET['s'];
          	$data = $this->M_order->getItem($item);
          	echo json_encode($data);
          }

	// public function Seksi()
	// {
	// 	$seksi = strtoupper($this->input->get('term'));
	// 	$data = $this->M_order->getUnit;
	// 	echo json_encode($data);
	// }

          public function detail()
          {
          	$id_kebutuhan = $this->input->post('phoneData');
          	if(isset($id_kebutuhan) and !empty($id_kebutuhan)){
          		$records = $this->M_order->join_2($id_kebutuhan);
          		if (empty($records)) {
          			echo '<center><ul class="list-group"><li class="list-group-item">'.'Order Telah di Hapus'.'</li></ul></center>';
          		}else{
          			echo '<table class="table table-bordered table-hover table-striped text-center">
          			<tr>
          				<th>NO</th>
          				<th>NAMA APD</th>
          				<th>JUMLAH</th>
          				<th>STATUS</th>
          			</tr>';
          			$i = 1;
          			$search = array('0','1','2');
          			$change = array('Pending', 'Approved', 'Rejected');
          			foreach($records as $key){
          				echo '<tr>
          				<td>'.$i.'</td>
          				<td>'.$key["item"].'</td>
          				<td>'.$key["ttl_order"].'</td>
          				<td>'. str_replace($search, $change, $key['status']).'
          				</td>
          				<!-- <td><?php echo $id_kebutuhan; ?></td> -->
          			</tr>';
          			$i++;
          		}
          		echo '</table>';
          	}
          }
          else {
          	echo '<center><ul class="list-group"><li class="list-group-item">'.'Data Kosong'.'</li></ul></center>';
          }	
      }

      public function listAll()
      {


      	$user = $this->session->username;
      	$user1 = $this->session->user;
      	$user_id = $this->session->userid;

      	$data['Title'] = 'Order';
      	$data['Menu'] = 'Input Order';
      	$data['SubMenuOne'] = '';
      	$data['SubMenuTwo'] = '';

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	$noind = $this->session->user;

      	$kodesie 					= $this->session->kodesie;
      	$data['seksi'] 				= $this->M_order->getSeksi($noind);
      	$data['tampil_data'] 		= $this->M_order->tampil_data($kodesie);
		// $data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		// $data['approve'] 			= $this->M_order->approve($user1);
      	$data['approveString'] 		= $this->M_order->approveString($user1);
      	$data['namaSeksi']			= $this->M_order->getNamaSeksi();
      	$today						= date('F');

      	if ($data['approveString'] == 'f'){
      		$this->list_order();
      	}

      	$this->load->view('V_Header',$data);
      	$this->load->view('V_Sidemenu',$data);
      	$this->load->view('P2K3V2/Order/V_list_all', $data);
      	$this->load->view('V_Footer',$data);
      }

      public function listPerSie($kode_seksi)
      {
      	$user = $this->session->username;
      	$user1 = $this->session->user;
      	$user_id = $this->session->userid;

      	$sie = $kode_seksi;
      	$data['Title'] = 'Order';
      	$data['Menu'] = 'Input Order';
      	$data['SubMenuOne'] = '';
      	$data['SubMenuTwo'] = '';

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	$noind = $this->session->user;

      	$kodesie 					= $this->session->kodesie;
      	$data['seksi'] 				= $this->M_order->getSeksi($noind);
      	$data['tampil_data'] 		= $this->M_order->tampil_data($sie);
		// print_r($data['tampil_data']);exit();
      	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($sie);
		// echo $kode_seksi; echo "<pre>";print_r($data['daftar_pekerjaan']);exit();

      	$data['approve'] 			= $this->M_order->approve($user1);
      	$data['approveString'] 		= $this->M_order->approveString($user1);
      	$data['namaSeksi']			= $this->M_order->getNamaSeksi();
      	$data['listSeksi']			= $this->M_order->getListSeksi($sie);
      	$today						= date('F');

      	$this->load->view('V_Header',$data);
      	$this->load->view('V_Sidemenu',$data);
      	$this->load->view('P2K3V2/Order/V_ListPerSeksi', $data);
      	$this->load->view('V_Footer',$data);

      }

      public function error_found(){
      	echo "Error Mas";
      }

      public function approval(){
      	$kodesie = $this->session->kodesie;
      	$noind = $this->session->user;
      	$data['seksi'] 		= $this->M_order->getSeksi($noind);
      	$data['pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
      	$data['data']	 	= $this->M_order->tampil_data($kodesie);
		// echo "<pre>";
		// print_r($data);
		// exit();
		// $this->load->view('P2K3/Order/V_approval', $data);
      	$this->load->library('pdf');

      	$pdf = $this->pdf->load();
      	$pdf = new mPDF('','F4-L',0,'',10,10,10,10,10,10);
      	$filename = 'P2K3Seksi.pdf';

      	$html = $this->load->view('P2K3V2/Order/V_approval', $data, true);

      	$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
      	$pdf->WriteHTML($stylesheet1,1);
      	$pdf->WriteHTML($html, 2);
      	$pdf->Output($filename, 'I');
      }

      public function UploadApproval(){
      	$kodesie = $this->session->kodesie;
      	$data	 	= $this->M_order->tampil_data($kodesie);
      	date_default_timezone_set('Asia/Jakarta');
      	if(!empty($_FILES['k3_approval']['name']))
      	{
      		$direktori_file						= $_FILES['k3_approval']['name'];
      		$ekstensi_file						= pathinfo($direktori_file,PATHINFO_EXTENSION);
      		$nama_file						= "P2K3-Order-Approval-".str_replace(' ', '_', date('Y-m-d_His')).".".$ekstensi_file;
				// $nama_BPKB							= filter_var($_FILES['FotoBPKB']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

      		$config['upload_path']          = './assets/upload/P2K3DocumentApproval';
				// $config['allowed_types']        = 'jpg|png|gif|';
      		$config['allowed_types']        = '*';
      		$config['max_size']				= 50000;
      		$config['file_name']		 	= $nama_file;
      		$config['overwrite'] 			= TRUE;


      		$this->upload->initialize($config);

      		if ($this->upload->do_upload('k3_approval')) 
      		{
      			$this->upload->data();
      		} 
      		else 
      		{

      			$errorinfo = $this->upload->display_errors();
      			echo $errorinfo;exit();
      		}

      		foreach ($data as $key) {
      			$this->M_order->updateDocumentApproval($nama_file,$key['id_kebutuhan']);
    				// echo $key['id_kebutuhan'];
      		}
    			// echo $nama_file;exit();
      		redirect(base_url('P2K3_V2/Order/list_order'));
      	}

      }

      public function inputStandarKebutuhan()
      {
      	$user = $this->session->username;
      	$user_id = $this->session->userid;
      	$noind = $this->session->user;
      	$kodesie = $this->session->kodesie;

      	$data['Title'] = 'Input Standar Kebutuhan';
      	$data['Menu'] = 'Input Standar Kebutuhan';
      	$data['SubMenuOne'] = '';
      	$data['SubMenuTwo'] = '';

      	$data['seksi'] 		= $this->M_order->getSeksi($noind);
      	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
      	// print_r($data['daftar_pekerjaan']);exit();

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	$noind 	= $this->session->user;
      	$tgl = date('Y-m');
      	$data['inputStandar'] = $this->M_order->getInputstd($kodesie);
      	// print_r($data['inputStandar']);exit();

      	$this->load->view('V_Header',$data);
      	$this->load->view('V_Sidemenu',$data);
      	$this->load->view('P2K3V2/Order/V_Input_Standar', $data);
      	$this->load->view('V_Footer',$data);
      }

      public function inputStandarAPD(){
      	$user = $this->session->username;
      	$user_id = $this->session->userid;
      	$noind = $this->session->user;
      	$kodesie = $this->session->kodesie;

      	$data['Title'] = 'Input Standar Kebutuhan';
      	$data['Menu'] = 'Input Standar Kebutuhan';
      	$data['SubMenuOne'] = '';
      	$data['SubMenuTwo'] = '';

      	$data['seksi'] 		= $this->M_order->getSeksi($noind);
      	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	$noind 						= $this->session->user;

      	$this->load->view('V_Header',$data);
      	$this->load->view('V_Sidemenu',$data);
      	$this->load->view('P2K3V2/Order/V_Input_Standar_APD', $data);
      	$this->load->view('V_Footer',$data);
      }

      public function approveStandar()
      {
      	$user = $this->session->username;
      	$user_id = $this->session->userid;
      	$noind = $this->session->user;
      	$kodesie = $this->session->kodesie;
		// echo substr($noind, 0,1);exit();

      	$data['Title'] = 'Approve Atasan';
      	$data['Menu'] = 'Approve Atasan';
      	$data['SubMenuOne'] = 'Approve Standar';
      	$data['SubMenuTwo'] = '';

      	$data['seksi'] 		= $this->M_order->getSeksi($noind);
      	// print_r($data['seksi']);exit();
      	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	$tgl = date('Y-m');
      	$data['inputStandar'] = $this->M_order->getInputstd2($tgl, $kodesie);
      	// print_r($data['inputStandar']);exit();
      	$n = substr($noind, 0,1);
      	if ($n == 'B' || $n == 'D' || $n == 'J' || $noind == 'F2229') {
      		$this->load->view('V_Header',$data);
      		$this->load->view('V_Sidemenu',$data);
      		$this->load->view('P2K3V2/Order/V_Approve_standar', $data);
      		$this->load->view('V_Footer',$data);
      	}else{
      		$this->load->view('V_Header',$data);
      		$this->load->view('V_Sidemenu',$data);
      		$this->load->view('P2K3V2/Order/V_Akses_deny2', $data);
      		$this->load->view('V_Footer',$data);
      	}
      }

      public function submitStandar()
      {
      	$this->load->library('PHPMailerAutoload');
      	$noind = $this->session->user;
      	$seksi 		= $this->M_order->getSeksi($noind);

      	//masuk ke database
      	$noind = $this->session->user;
      	$id = $this->input->post('p2k3_idStandar');
      	$status = $this->input->post('p2k3_action');
      	$st = '1';
      	if ($status == 'reject') {
      		$st = '2';
      	}
      	foreach ($id as $key) {
      		$update = $this->M_order->updateSt($st, $key, $noind);
      	}

      	$message = '	<!DOCTYPE HTML">
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
						<h3 style="text-decoration: underline;">P2K3 TIM V.2</h3>
					<hr/>
				
					<p>Anda mendapatkan kiriman update standar kebutuhan APD dari seksi '.$seksi[0]['section'].'
					</p>
					<hr/>
					<p>
					Untuk melihat/mengelola, silahkan login ke ERP
					</p>
					
				</body>
				</html>';
		$emel = $this->M_dtmasuk->getEmail();
		$arr = array();
		foreach ($emel as $key) {
			$arr[] = $key['email'];
		}
		// print_r($arr); exit();

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
        $mail->setFrom('noreply@quick.com', 'P2K3');
    	$mail->addAddress('enggal_aldiansyah@quick.com');
    	foreach ($arr as $key) {
    		$mail->addAddress($key);
    	}
        $mail->Subject = 'NEW!!! P2K3 Approval Standar Kebutuhan';
		$mail->msgHTML($message);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		} else {
      		redirect('P2K3_V2/Order/approveStandar');
		}

      }

      public function submitOrder($id, $st)
      {
      	$noind = $this->session->user;
      	$update = $this->M_order->updateOr($st, $id, $noind);

      	redirect('P2K3_V2/Order/approveOrder');
      }

      public function approveOrder()
      {
      	$user = $this->session->username;
      	$user_id = $this->session->userid;
      	$noind = $this->session->user;
      	$kodesie = $this->session->kodesie;

      	$data['Title'] = 'Approve Atasan';
      	$data['Menu'] = 'Approve Atasan';
      	$data['SubMenuOne'] = 'Approve Order';
      	$data['SubMenuTwo'] = '';

      	$data['seksi'] 		= $this->M_order->getSeksi($noind);
      	$data['inputOrder'] 		= $this->M_order->getInputOrder($kodesie);
      	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	$n = substr($noind, 0,1);
      	if ($n == 'B' || $n == 'D' || $n == 'J' || $noind == 'F2229') {
      		$this->load->view('V_Header',$data);
      		$this->load->view('V_Sidemenu',$data);
      		$this->load->view('P2K3V2/Order/V_Approve_Order', $data);
      		$this->load->view('V_Footer',$data);
      	}else{
      		$this->load->view('V_Header',$data);
      		$this->load->view('V_Sidemenu',$data);
      		$this->load->view('P2K3V2/Order/V_Akses_deny', $data);
      		$this->load->view('V_Footer',$data);
      	}
      }

      public function MonitoringApd()
      {
      	$user = $this->session->username;
      	$user_id = $this->session->userid;
      	$noind = $this->session->user;
      	$kodesie = $this->session->kodesie;

      	$data['Title'] = 'Monitoring APD';
      	$data['Menu'] = 'Monitoring APD';
      	$data['SubMenuOne'] = '';
      	$data['SubMenuTwo'] = '';

      	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
      	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
      	$data['seksi'] 		= $this->M_order->getSeksi($noind);
      	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);

      	$pr = $this->input->post('k3_periode');
      	$m = substr($pr, 0,2);
      	$y = substr($pr, 5,5);
      	$periode = $pr;
      	$pr = $y.'-'.$m;
		// echo $pr;exit();
      	if (empty($pr)) {
      		$pr = date('Y-m');
      		$periode = date('m - Y');
      	}
      	$jml = '';
      	$data['pr'] = $periode;
      	$data['listmonitor'] = $this->M_order->listmonitor($kodesie, $pr);
      	foreach ($data['listmonitor'] as $key) {
      		$a = $key['jml_item'];
      		$b = $key['jml_pekerja'];
      		$c = $key['jml_kebutuhan_umum'];
      		$d = $key['jml_kebutuhan_staff'];
      		$e = $key['jml_pekerja_staff'];
      		$a = explode(',', $a);
      		$b = explode(',', $b);
      		$hit = count($a);
      		for ($i=0; $i < $hit; $i++) { 
      			$jml += ($a[$i]*$b[$i]); 
      		}
      		$jml = $jml+$c+($d*$e);
      		$min = ($jml-$key['jml_bon']);
      		$push = array(	"total"	=> $jml,
      			"min"	=>	$min,);
      		array_splice($key,4,2,$push);
      		$new[] = $key;
      		$data['listmonitor'] = $new;
      		$jml = 0;
      	}
		// echo "<pre>";
		// print_r($data['listmonitor']);exit();

      	$this->load->view('V_Header',$data);
      	$this->load->view('V_Sidemenu',$data);
      	$this->load->view('P2K3V2/Order/V_Monitoring_APD', $data);
      	$this->load->view('V_Footer',$data);
      }

      public function saveInputStandar()
      {
		// print_r($_POST);exit();
      	// $tglNow = date('Y-m');
      	// $cek = $this->M_order->cektgl($tglNow);
      	// if ($cek > 0) {
      	// 	echo "Anda Sudah Menginputkan Standar APD";
      	// 	exit();
      	// }
      	$kodesie = $this->session->kodesie;
      	$daftar_pekerjaan	= $this->M_order->daftar_pekerjaan($kodesie);
      	$item = $this->input->post('txtKodeItem');
      	$umum = $this->input->post('txtkebUmum');
      	$staff = $this->input->post('txtkebStaff');
      	$jumlah = $this->input->post('p2k3_isk_standar');
      	$tgl_input = date('Y-m-d H:i:s');
      	$ks = substr($kodesie, 0,7);
      	// echo $ks;exit();
		// implode kdpekerjaan
      	foreach ($daftar_pekerjaan as $key) {
      		$kd[] = $key['kdpekerjaan'];
      	}
      	$kd_pkj = implode(',', $kd);

		//implode jumlah
      	$a = 0;
      	for ($i=0; $i < count($item); $i++) {
      		for ($x=$a; $x < (count($daftar_pekerjaan)*($i+1)); $x++) { 
      			$jml[$i][] = $jumlah[$x];
      		}

      		$data = array(
      			'kode_item'	=>	$item[$i],
      			'kd_pekerjaan'	=> $kd_pkj,
      			'jml_item'	=>	implode(',', $jml[$i]),
      			'kodesie'	=>	$kodesie,
      			'jml_kebutuhan_umum'	=>	$umum[$i],
      			'jml_kebutuhan_staff'	=>	$staff[$i],
      			'tgl_input'	=>	$tgl_input,
      			'status'	=>	'0',
      			);
      		$a += count($daftar_pekerjaan);
			// echo "<pre>";
			// print_r($data);
			// echo "<br>";
      		$input = $this->M_order->save_standar($data);
      	}
      	redirect('P2K3_V2/Order/inputStandarKebutuhan');
      }

      public function save_pekerja()
      {
      	// print_r($_POST);exit();
      	$kodesie = $this->session->kodesie;
      	$cek2 = $this->M_order->ceklineOrder($kodesie);
      	// if ($cek2 > 0) {
      	// 	echo "Anda Sudah Input Order!";exit();
      	// }
      	$daftar_pekerjaan	= $this->M_order->daftar_pekerjaan($kodesie);
      	$jml = $this->input->post('pkjJumlah');
      	$staff = $this->input->post('staffJumlah');
      	$periode = $this->input->post('k3_periode');

      	foreach ($daftar_pekerjaan as $key) {
      		$kd[] = $key['kdpekerjaan'];
      	}
      	$kd_pkj = implode(',', $kd);
      	$jml_pkj = implode(',', $jml);
      	$tgl_input = date('Y-m-d H:i:s');
      	$ks = substr($kodesie, 0,7);
      	// echo $ks;exit();
      	$data = array(
      		'kd_pekerjaan'	=> $kd_pkj,
      		'jml_pekerja'	=>	$jml_pkj,
      		'jml_pekerja_staff'	=>	$staff,
      		'kodesie'	=>	$ks,
      		'tgl_input'	=>	$tgl_input,
      		'status'	=>	'0',
      		'periode'	=>	$periode,
      		);
      	$inputPkj = $this->M_order->inputPkj($data);
      	redirect('P2K3_V2/Order/list_order');
      }

      public function cekOrder()
      {
      	$ks = $this->input->get('ks');
      	// echo $ks;exit();
      	$ceklineOrder = $this->M_order->ceklineOrder($ks);
      	echo json_encode($ceklineOrder);
      	// echo $ceklineOrder;
      }

      public function modal()
      {
      	$ks = $this->input->post('ks');
      	$pr = $this->input->post('pr');
      	if(isset($ks) and !empty($ks)){
      		$records = $this->M_order->listmonitor($ks, $pr);
      		// echo "<pre>"; print_r($records);exit();
      		if (empty($records)) {
      			echo '<center><ul class="list-group"><li class="list-group-item">'.'Order Belum di Approve'.'</li></ul></center>';
      		}else{
      			echo '<table class="table table-bordered table-hover table-striped text-center">
      			<tr>
      				<th>NO</th>
      				<th>NAMA APD</th>
      				<th>JUMLAH</th>
      			</tr>';
      			$x = 1;
      			$jml='';
      			// echo "<pre>";
      			// print_r($records);exit();
      			foreach($records as $key){
      				$a = $key['jml_item'];
      				$b = $key['jml_pekerja'];
      				$c = $key['jml_kebutuhan_umum'];
      				$d = $key['jml_kebutuhan_staff'];
      				$e = $key['jml_pekerja_staff'];
      				$a = explode(',', $a);
      				$b = explode(',', $b);
      				$hit = count($a);
      				for ($i=0; $i < $hit; $i++) { 
      					$jml += ($a[$i]*$b[$i]); 
      				}
      				$jml = $jml+$c+($d*$e);
      				echo '<tr>
      				<td>'.$x.'</td>
      				<td>'.$key["item"].'</td>
      				<td>'.$jml.'</td>
      			</tr>';
      			$x++;
      			$jml = 0;
      		}
      		echo '</table>';
      	}
      }
      else {
      	echo '<center><ul class="list-group"><li class="list-group-item">'.'Data Kosong'.'</li></ul></center>';
      }	
  }

  public function InputBon()
  {
  	$user = $this->session->username;
  	$user_id = $this->session->userid;
  	$noind = $this->session->user;
  	$kodesie = $this->session->kodesie;

  	$data['Title'] = 'Input Bon';
  	$data['Menu'] = 'Input Bon';
  	$data['SubMenuOne'] = '';
  	$data['SubMenuTwo'] = '';

  	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
  	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
  	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

  	$ks = $kodesie;
  	$pr = $this->input->post('k3_periode');
  	$m = substr($pr, 0,2);
  	$y = substr($pr, 5,5);
  	$periode = $pr;
  	$pr = $y.'-'.$m;
		// echo $pr;exit();
  	if (empty($pr)) {
  		$pr = date('Y-m');
  		$periode = date('m - Y');
  	}
  	$data['pr'] = $periode;
  	$data['ks'] = $ks;
  	$data['pri'] = $pr;
  	$data['listtobon'] = $this->M_dtmasuk->listtobon($ks, $pr);
  	$data['lokasi'] = $this->M_order->lokasi();
  	$jml = '';
  	foreach ($data['listtobon'] as $key) {
  		$a = $key['jml_item'];
  		$b = $key['jml_pekerja'];
  		$c = $key['jml_kebutuhan_umum'];
  		$d = $key['jml_kebutuhan_staff'];
  		$e = $key['jml_pekerja_staff'];
  		$a = explode(',', $a);
  		$b = explode(',', $b);
  		$hit = count($a);
  		for ($i=0; $i < $hit; $i++) { 
  			$jml += ($a[$i]*$b[$i]); 
  		}
  		$jml = $jml+$c+($d*$e);
  		$push = array("total"=> $jml);
  		array_splice($key,5,1,$push);
  		$new[] = $key;
  		$data['listtobon'] = $new;
  		$jml = 0;
  	}
  	$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
  	if (empty($data['seksi'])) {
  		$data['seksi'] = array('section_name' 	=>	'');
  	}
		// echo "<pre>";
		// print_r($data['listtobon']);exit();

  	$this->load->view('V_Header',$data);
  	$this->load->view('V_Sidemenu',$data);
  	$this->load->view('P2K3V2/Order/V_Input_Bon', $data);
  	$this->load->view('V_Footer',$data);
  }

  public function searchOracle()
  {
  	$term = $this->input->get('s');
  	// echo $term;exit();

  	$pemakai = $this->M_order->getOr($term);
  	// print_r($datha);
  	// echo json_encode($datha);
  	echo '<option></option>';
  	foreach ($pemakai as $data_pemakai) {
  		echo '<option value="'.$data_pemakai['COST_CENTER'].'/'.$data_pemakai['PEMAKAI'].'">['.$data_pemakai['COST_CENTER'].'] - '.$data_pemakai['PEMAKAI'].'</option>';
  	}
  }
  public function pemakai_2()
  {

  	$pemakai_2 	= $this->input->post('pemakai_2');
  	$pemakai 	= $this->M_order->pemakai_2($pemakai_2);

  	foreach ($pemakai as $data_pemakai) {
  		echo $data_pemakai['COST_CENTER'].'|'.$data_pemakai['KODE_CABANG'];
  	}
  }
  public function gudang()
  {
  	$lokasi	= $this->input->post('lokasi_id');
  	$gudang=$this->M_order->gudang($lokasi);

  	echo '<option></option>';
  	foreach ($gudang as $data_gudang) {
  		echo '<option value="'.$data_gudang['SECONDARY_INVENTORY_NAME'].'">['.$data_gudang['SECONDARY_INVENTORY_NAME'].'] '.$data_gudang['DESCRIPTION'].'</option>';
  	}
  }

  public function SubmitInputBon()
  {
  	// echo "<pre>";
  	// print_r($_POST);
  	// exit();

  	$tgl = date('Y-m-d H:i:s');
  	$tanggal = date('d M Y');
  	$noind = $this->session->user;
  	$apd = $this->input->post('p2k3_apd');
  	$nama_apd = $this->input->post('p2k3_nama_apd');
  	$satuan_apd = $this->input->post('p2k3_satuan_apd');
  	$bon = $this->input->post('p2k3_jmlBon');
  	$pr = $this->input->post('p2k3_pr');
  	$ks = $this->input->post('p2k3_ks');
  	$ks = substr($ks, 0,7);
		// echo $ks;exit();
  	$jml_k = $this->input->post('p2k3_jmlKebutuhan');
  	$sisa_saldo = $this->input->post('p2k3_sisaSaldo');

  	$pemakai = $this->input->post('txt_pemakai_2');
  	$pemakai = explode('/', $pemakai);
  	$pemakai = $pemakai[0];
  	$cost_center = $this->input->post('txt_cost');
  	$kode_cabang = $this->input->post('kode_cabang1');
  	$lokasi = $this->input->post('txt_lokasi');
  	$gudang = $this->input->post('txt_gudang');
  	$seksi = $this->input->post('p2k3_seksi_bon');
  	$lokator = $this->input->post('txt_locator');

  	$account = $this->M_order->account('APD', $cost_center);

  	$number = $this->M_order->getNum();
  	$d = date('ymd');
  	$noBon = '9'.$d.'00';
  	if (strlen($number) > 2) {
  		$noBon = $number;
  	}
  	++$noBon;
		// $t = date('M', strtotime('-1 month'));
		// print_r($account);exit();

  	for ($i=0; $i < count($apd); $i++) { 
  		if ($bon[$i] == '0') {
  			// $data = '0';
  		}else{
  		$data = array(
  			'periode'	=>	$pr,
  			'kodesie'	=>	$ks,
  			'tgl_bon'	=>	$tgl,
  			'item_code'	=>	$apd[$i],
  			'jml_bon'	=>	$bon[$i],
  			'input_by'	=>	$noind,
  			'jml_kebutuhan'	=>	$jml_k[$i],
  			'sisa_saldo'	=>	$sisa_saldo[$i],
  			'no_bon'	=>	$noBon,
  			);
  		$input = $this->M_dtmasuk->insertBon($data);

  		$data2 = array(
  			'kode_barang'	=>	$apd[$i],
  			'nama_barang'	=>	$nama_apd[$i],
  			'satuan'		=>	$satuan_apd[$i],
  			'permintaan'	=>	$bon[$i],
  			'keterangan'	=>	'UNTUK KEBUTUHAN APD PERIODE '.$pr,
  			'cost_center'	=>	$cost_center,
  			'penggunaan'	=>	'BARANG P2K3 & APD',
  			'seksi_bon'		=>	$seksi,
  			'tujuan_gudang'	=>	$gudang,
  			'tanggal'		=>	date('d M Y'),
  			'no_bon'		=>	$noBon,
  			'pemakai'		=>	$pemakai,
  			'jenis_pemakai'	=>	'Seksi',
  			'lokasi'		=>	$lokasi,
  			'lokator'		=>	$lokator,
  			'account'		=>	$account,
  			'kode_cabang'	=>	$kode_cabang,
  			);
  		$input2 = $this->M_dtmasuk->insertBonIm($data2);
		// print_r($data2); 
  		}
		// exit();
  	}
  	// exit();
		//PDF Untuk Bon

  	$this->load->library('ciqrcode');
  	if(!is_dir('./assets/img/temp_qrcode'))
  	{
  		mkdir('./assets/img/temp_qrcode', 0777, true);
  		chmod('./assets/img/temp_qrcode', 0777);
  	}
  	$lembar = ceil(count($apd)/10);
		// echo $lembar;exit();
  	$y = 0;
  	$k = 1;
  	for ($i=0; $i < $lembar; $i++) {
  		$max = (10*$k);
  		$data_array_2 = array();
  		for ($x=$y; $x < $max; $x++) {
  			
  			if ($x < count($apd) ) {
  				if ($bon[$x] == '0') {
					//do not  					
  				}else{
  				$data_array_2[] = array(
  					'kode' => $apd[$x],
  					'nama' => $nama_apd[$x],
  					'satuan' => $satuan_apd[$x],
  					'diminta' => $bon[$x],
  					'account' => $account,
  					'ket' => 'UNTUK KEBUTUHAN APD PERIODE '.$pr,
  					);
  				}
  			}else{
  				$data_array_2[] = array(
  					'kode' => '',
  					'nama' => '',
  					'satuan' => '',
  					'diminta' => '', 
  					'ket' => '',
  					'account' => '',
  					'produk' => '',
  					'exp' =>'',
  					'lokasi_simpanku' => ''
  					);
  			}
			// echo $x; 
  		}
		// print_r($data_array_2);

  		$data_array[] = array(
  			'nomor' => $noBon,
  			'tgl' => $tanggal,
  			'gudang' => $gudang,
  			'seksi' => $seksi,
  			'pemakai' => $pemakai,
  			'rdPemakai' => 'Seksi',
  			'fungsi' => 'BARANG P2K3 & APD',
  			'cost' => $cost_center,
  			'kocab' => $kode_cabang,
  			'data_body' => $data_array_2,
  			);
  		$y = $y + 10;
  		$k++;
  	}
// 		print_r($data_array);
// exit();
  	$params['data']		= $noBon;
  	$params['level']	= 'H';
  	$params['size']		= 10;
  	$config['black']	= array(224,255,255);
  	$config['white']	= array(70,130,180);
  	$params['savename'] = './assets/img/temp_qrcode/'.$noBon.'.png';
  	$this->ciqrcode->generate($params);

  	$data['kumpulandata'] = $data_array;
		// print_r($data_array);
		// exit;
  	$this->load->library('Pdf');
  	$pdf = $this->pdf->load();
  	$pdf = new mPDF('',array(210,148.5),0,'',10,10,5,0,0,5,'P');
  	$filename = $nomor_urut.'-Bon-Bppbg.pdf';
  	$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
  	$html = $this->load->view('P2K3V2/Order/V_pdfBon', $data, true);
		// echo ($html);
		// exit();


  	$pdf->setFooter('<div style="float: left; margin-right: 30px; width:200px">
  		<i style="font-size: 10px;margin-right: 10%">FRM-WHS-02-PDN-02 (Rev.04)</i>
  	</div>
  	<div style="float: left; width: 350px; background-color=red">
  		<i style="padding-left: 60%; font-size: 10px;margin-left: 10%">**) Pengebonan komponen/material produksi harus disetujui PPIC</i>
  	</div>
  	<div style="float: right; width: 100px">
  		<i style="padding-left: 60%; font-size: 10px;margin-left: 10%">Hal. {PAGENO} dari {nb}</i>
  	</div>');
  	$pdf->WriteHTML($stylesheet,1);
  	$pdf->WriteHTML($html);
  	$pdf->Output($filename, 'I');
  }

  public function lokator()
  {
  	$gudang	= $this->input->post('gudang_id');
  	$lokator=$this->M_order->lokator($gudang);

  	echo '<option></option>';
  	foreach ($lokator as $data_lokator) {
  		echo '<option value="'.$data_lokator['LOCATOR_ID'].'">'.$data_lokator['SEGMENT1'].'</option>';
  	}
  }
}