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
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('ciqrcode');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3/MainMenu/M_order');
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
		// echo "<pre>";print_r($data['tampil_data']);exit();
		// $nom = $this->input->post('p2k3_masukan1');
		// $nom = 614;
		// $data['detail']				= $this->M_order->join_2();
		// $data['masukan'] = $this->M_order;->
		// $masukan = $this->input->post('masukan');
		// echo $masukan; exit();
		// echo "<pre>";
		//  print_r($data['detail']);
		//  exit();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);
		// echo $nom;
		// exit();
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
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		// echo "<pre>";print_r($data['daftar_pekerjaan']);exit();
		$data['approve'] 			= $this->M_order->approve($user1);
		$data['approveString'] 		= $this->M_order->approveString($user1);
		// print_r($data['approveString']);exit();
		$today						= date('F');

		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('P2K3/Order/V_List_Order', $data);
		// $this->load->view('V_Footer',$data);

		if ($data['approveString']  == 'f'){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('P2K3/Order/V_List_Order', $data);
			$this->load->view('V_Footer',$data);
		} else{
			// $this->listAll();
			redirect('p2k3adm/datamasuk');
		}

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
		$data['input']				= $this->M_order->tampil_data($kodesie);
		// echo "<pre>";print_r($data['input']);exit();

		if (empty($data['input'])) {
			$this->reset();
		}else{
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/Order/V_Input', $data);
		$this->load->view('V_Footer',$data);
		}

	}

	public function save_data(){
		$user_id					= $this->session->userid;
		$kodesie 					= $this->session->kodesie;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		// echo "<pre>";print_r($_POST); exit();
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
							$id = $this->db->insert_id();
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
					//insert to t_log
					$aksi = 'P2K3';
					$detail = "Add Kebutuhan ID=$id_log ";
					$this->log_activity->activity_log($aksi, $detail);
					//
					}

					redirect('P2K3/Order/list_order');
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
		$this->load->view('P2K3/Order/V_Edit', $data);
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
							//insert to sys.tlog_activity
							$aksi = 'P2K3';
							$detail = "Upate Kebutuhan ID= $id_hs ";
							$this->log_activity->activity_log($aksi, $detail);
							//
							// header("location:javascript://history.go(-1)");
							if ($data['approveString']  == 'f'){
								// $this->list_order();
								redirect('P2K3/Order/list_order/');
							}else{
							redirect('P2K3/Order/listPerSie/'.$sie);
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
				//insert to sys.tlog_activity
				$aksi = 'P2K3';
				$detail = "Delete APD Kebutuhan ID=$id_hs ";
				$this->log_activity->activity_log($aksi, $detail);
				//
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
			$this->load->view('P2K3/Order/V_Input', $data);
			$this->load->view('V_Footer',$data);
		}

		public function reset()
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
			$this->load->view('P2K3/Order/V_Reset', $data);
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

            redirect('P2K3/Order/list_order');
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
	                  <th>STATUS</th>
	              </tr>';
	         $i = 1;
	         $search = array('0','1','2');
	         $change = array('Pending', 'Approved', 'Rejected');
            foreach($records as $key){
             echo '<tr>
	                  <td>'.$i.'</td>
	                  <td>'.$key["item"].'</td>
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
		$this->load->view('P2K3/Order/V_list_all', $data);
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
		$this->load->view('P2K3/Order/V_ListPerSeksi', $data);
		$this->load->view('V_Footer',$data);

	}

	public function error_found(){
	  echo "Error Mas";
	}

	public function approval(){
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;
		$tanggal = $this->input->post('txtBulanTahun');
		$tgl = explode(' ', $tanggal);
		$month = $tgl['0'];
		$year = $tgl['1'];
		$data['seksi'] 		= $this->M_order->getSeksi($noind);
		$data['pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		$data['data']	 	= $this->M_order->tampil_data_2($kodesie,$month,$year);
		// echo "<pre>";
		// print_r($data);
		// exit();
		// $this->load->view('P2K3/Order/V_approval', $data);
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','F4-L',0,'',10,10,10,10,10,10);
		$filename = 'P2K3Seksi.pdf';

		$html = $this->load->view('P2K3/Order/V_approval', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function UploadApproval(){
		$kodesie = $this->session->kodesie;
		$tanggal = $this->input->post('txtBulanTahun');
		$tgl = explode(' ', $tanggal);
		$month = $tgl['0'];
		$year = $tgl['1'];
		$data	 	= $this->M_order->tampil_data_2($kodesie,$month,$year);
		date_default_timezone_set('Asia/Jakarta');
		if(!empty($_FILES['k3_approval']['name']))
		{
				$direktori_file						= $_FILES['k3_approval']['name'];
				$ekstensi_file						= pathinfo($direktori_file,PATHINFO_EXTENSION);
				$nama_file						= "P2K3-Order-Approval-".$kodesie."-".$year."_".$month."-".str_replace(' ', '_', date('Y-m-d_His')).".".$ekstensi_file;
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
					//insert to sys.t_log_activity
					$aksi = 'P2K3';
					$detail = "Update Dokumen approval ID= ".$key['id_kebutuhan'];
					$this->log_activity->activity_log($aksi, $detail);
					//
    			}
    			// echo $nama_file;exit();
    			redirect(base_url('P2K3/Order/list_order'));
    	}

	}
}
