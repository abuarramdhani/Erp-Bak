<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Pelayanan extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_pelayanan');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			session_destroy();
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user = $this->session->userdata('user');
		$user_id = $this->session->userid;

		$data['Title'] = 'Pelayanan';
		$data['Menu'] = 'Pelayanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');
		// $date2 = gmdate('d/m/Y H:i:s', time()+60*60*7);
		// $date2 = date('d/m/Y', strtotime('+1 days'));
		$data['value'] 	= $this->M_pelayanan->tampilhariini();
		$pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		$data['data']	= $pelayanan;
		// for ($i=0; $i <count($data['value']); $i++) {
		// 	$getstatus = $this->M_pelayanan->getStatus($data['value'][$i]['NO_DOKUMEN']);
		// 	if (empty($getstatus)) {
		// 		$data['status'][$i] = 'Belum Allocate';
		// 	}else {
		// 		$data['status'][$i] = 'Sudah Allocate';
		// 	}
		// }

		// echo "<pre>";
		// print_r($user);
		// echo "<br>";
		// die();
		// print_r(count_chars($menit, 1));
		// echo "<br>";
		// print_r($data['selisih']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Pelayanan', $data);
		$this->load->view('V_Footer',$data);
	}


	public function getPIC()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_pelayanan->getPIC($term);
		echo json_encode($data);
	}


	public function updateMulai()
	{
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$pic 	= $this->input->post('pic');

		$user = $this->session->userdata('user');
		// $user_id = $this->session->userid;

		$cek = $this->M_pelayanan->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PELAYANAN'] == '') {
			$this->M_pelayanan->SavePelayanan($date, $jenis, $nospb, $pic);
			$this->M_pelayanan->SavePelayanan2($user, $pic, $nospb);
		}
	}


	public function updateSelesai()
	{
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');
		$pic 	= $this->input->post('pic');

		$cek = $this->M_pelayanan->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PELAYANAN'] == '') {
			$waktu1 	= strtotime($mulai);
			$waktu2 	= strtotime($selesai);
			$selisih 	= ($waktu2 - $waktu1);
			$jam 		= floor($selisih/(60*60));
			$menit 		= $selisih - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik 		= $menit - $htgmenit;
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
		}else {
			$a 			= explode(':', $cek[0]['WAKTU_PELAYANAN']);
			$jamA 		= $a[0] * 3600;
			$menitA 	= $a[1] * 60;
			$waktuA 	= $jamA + $menitA + $a[2];

			$waktu1 	= strtotime($mulai);
			$waktu2 	= strtotime($selesai);
			$waktuB 	= ($waktu2 - $waktu1);
			$jumlah 	= $waktuA + $waktuB;
			$jam 		= floor($jumlah/(60*60));
			$menit 		= $jumlah - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik 		= $menit - $htgmenit;
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
		}

		$this->M_pelayanan->SelesaiPelayanan($date, $jenis, $nospb, $slsh, $pic);
	}


	public function pauseSPB()
	{
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');

		$waktu1 	= strtotime($mulai);
		$waktu2 	= strtotime($selesai);
		$selisih 	= $waktu2 - $waktu1;
		$jam 		= floor($selisih / (60 * 60));
		$menit 		= $selisih - $jam * (60 * 60);
		$htgmenit 	= floor($menit / 60) * 60;
		$detik 		= $menit - $htgmenit;
		$slsh 		= $jam.':'.floor($menit / 60).':'.$detik;

		$this->M_pelayanan->WaktuPelayanan($jenis, $nospb, $slsh);
	}


	public function updateSelesai2()
	{
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');
		$pic 	= $this->input->post('pic');
		$jml 	= $this->input->post('j');
		// echo "<pre>";print_r($jml);exit();

		$cek = $this->M_pelayanan->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PELAYANAN'] == '') {
			$waktu1 	= strtotime($mulai);
			$waktu2 	= strtotime($selesai);
			$selisih 	= ($waktu2 - $waktu1)/$jml;
			$jam 		= floor($selisih/(60*60));
			$menit 		= $selisih - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik 		= floor($menit - $htgmenit);
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
		}else {
			$a 			= explode(':', $cek[0]['WAKTU_PELAYANAN']);
			$jamA 		= $a[0] * 3600;
			$menitA 	= $a[1] * 60;
			$waktuA 	= $jamA + $menitA + $a[2];

			$waktu1 	= strtotime($mulai);
			$waktu2 	= strtotime($selesai);
			$waktuB 	= ($waktu2 - $waktu1)/$jml;
			$jumlah 	= $waktuA + $waktuB;
			$jam 		= floor($jumlah/(60*60));
			$menit 		= $jumlah - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik 		= floor($menit - $htgmenit);
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
		}

		$this->M_pelayanan->SelesaiPelayanan($date, $jenis, $nospb, $slsh, $pic);
	}


    public function getJumlah()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
        echo json_encode($this->M_pelayanan->dataJumlah());
    }


	public function getNormal()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_pelayanan->dataNormal();
		$data['noind']  = $this->M_pelayanan->getPIC2();
		// $pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Normal', $data);
    }


    public function getUrgent()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_pelayanan->dataUrgent();
		$data['noind']  = $this->M_pelayanan->getPIC2();
		// $pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Urgent', $data);
    }


    public function getEceran()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_pelayanan->dataEceran();
		$data['noind']  = $this->M_pelayanan->getPIC2();
		// $pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Eceran', $data);
    }


    public function getBest()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_pelayanan->dataBest();
		$data['noind']  = $this->M_pelayanan->getPIC2();
		// $pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Best', $data);
    }


    public function getEcom()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_pelayanan->dataEcom();
		$data['noind']  = $this->M_pelayanan->getPIC2();
		// $pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Ecom', $data);
    }


	public function getCetak()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_pelayanan->dataCetak();
		$data['noind']  = $this->M_pelayanan->getPIC2();
        $this->load->view('KapasitasGdSparepart/V_Ajax_Cetak', $data);
    }


    public function getSelesai()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		$data['data']	= $pelayanan;
		$data['noind']  = $this->M_pelayanan->getPIC2();
        $this->load->view('KapasitasGdSparepart/V_Ajax_Selesai', $data);
    }


    public function getDetail()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['detail'] 	= $this->M_pelayanan->dataDetail($this->input->post('doc'));
		// $data['noind']  = $this->M_pelayanan->getPIC2();
		// $pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Detail', $data);
    }


		public function cetakPL($id)
		    {
						$body =  $this->M_pelayanan->bodyPL($id);
						foreach ($body as $key => $value) {
							$cek_banyak_colly[$value['COLLY_NUMBER']] = $value['COLLY_NUMBER'];
							$tampung[] = $value;
							if (sizeof($tampung) == 22 || $key == sizeof($body) - 1 ) {
								$one_page_is[] = $tampung;
								$tampung = [];
							}
						}

						if (!empty($one_page_is) && sizeof($cek_banyak_colly) != 1) {

							foreach ($one_page_is as $key99 => $value99) {

								if (sizeof($one_page_is[$key99]) == 22) {
									$coll_ = $one_page_is[$key99][21]['COLLY_NUMBER'];

									if (!empty($one_page_is[$key99+1][0]['COLLY_NUMBER'])) {
										$cek_kk = 0;
										foreach ($one_page_is[$key99+1] as $key_1 => $value_) {
											if ($value_['COLLY_NUMBER'] == $coll_) {
												$cek_kk = 1;
												break;
											}
										}

										if ($cek_kk) {
											foreach ($one_page_is[$key99] as $key_1 => $value_) {
												if ($value_['COLLY_NUMBER'] == $coll_) {
													$siap_pindah[] = $value_;
													unset($one_page_is[$key99][$key_1]);
												}
											}
											if (!empty($siap_pindah)) {
												foreach (array_reverse($siap_pindah) as $key_1 => $value_) {
													array_unshift($one_page_is[$key99+1], $value_);
												}
												$siap_pindah = [];
											}
										}

									}
								}elseif (sizeof($one_page_is[$key99]) > 22) {

									//pindah elemen kelebihan ke index seltelahnya
									$coll_kelebihan = $one_page_is[$key99][sizeof($one_page_is[$key99])-1]['COLLY_NUMBER'];
										foreach ($one_page_is[$key99] as $key_1 => $value_) {
											if ($value_['COLLY_NUMBER'] == $coll_kelebihan) {
												$siap_pindah_karna_kelebihan[] = $value_;
												unset($one_page_is[$key99][$key_1]);
											}
										}
										if (!empty($siap_pindah_karna_kelebihan)) {
											foreach (array_reverse($siap_pindah_karna_kelebihan) as $key_1 => $value_) {
												if (empty($one_page_is[$key99+1])) {
													$one_page_is[$key99+1] = [$value_];
												}else {
													array_unshift($one_page_is[$key99+1], $value_);
												}
											}
											$siap_pindah_karna_kelebihan = [];
										}

										//kembali ke pengecekan
										$coll_ = !empty($one_page_is[$key99][21]['COLLY_NUMBER']) ? $one_page_is[$key99][21]['COLLY_NUMBER'] : '';
										if (!empty($one_page_is[$key99+1][0]['COLLY_NUMBER'])) {

											$cek_kk = 0;
											foreach ($one_page_is[$key99+1] as $key_1 => $value_) {
												if ($value_['COLLY_NUMBER'] == $coll_) {
													$cek_kk = 1;
													break;
												}
											}

											if ($cek_kk) {
												foreach ($one_page_is[$key99] as $key_1 => $value_) {
													if ($value_['COLLY_NUMBER'] == $coll_) {
														$siap_pindah[] = $value_;
														unset($one_page_is[$key99][$key_1]);
													}
												}
												if (!empty($siap_pindah)) {
													foreach (array_reverse($siap_pindah) as $key_1 => $value_) {
														array_unshift($one_page_is[$key99+1], $value_);
													}
													$siap_pindah = [];
												}
											}

										}
								}

							}
						}
		        $data['get_header'] = $this->M_pelayanan->headfootPL($id);
		        // $data['get_body'] = $cek;
						$data['get_colly'] = $this->M_pelayanan->getTotalColly($id);
		        $data['total_colly'] = sizeof($data['get_colly']);
		        $data['total_berat'] = $this->M_pelayanan->getTotalBerat($id);
		        $data['petugas'] = $this->M_pelayanan->getAll($id);
		        $data['total_hal'] = $one_page_is;
						$data['jumlah_colly'] = sizeof($cek_banyak_colly);

		        if (!empty($id)) {
		            // ====================== do something =========================
		            $this->load->library('Pdf');
		            $this->load->library('ciqrcode');

		            $pdf 		= $this->pdf->load();
		            $pdf 		= new mPDF('utf-8', array(210 , 267), 0, '', 3, 3, 3, 0, 0, 0);

		            // ------ GENERATE QRCODE ------
		            if (!is_dir('./assets/img/monitoringDOSPQRCODE')) {
		                mkdir('./assets/img/monitoringDOSPQRCODE', 0777, true);
		                chmod('./assets/img/monitoringDOSPQRCODE', 0777);
		            }

		            $params['data']		= $data['get_header'][0]['REQUEST_NUMBER'];
		            $params['level']	= 'H';
		            $params['size']		= 4;
		            $params['black']	= array(255,255,255);
		            $params['white']	= array(0,0,0);
		            $params['savename'] = './assets/img/monitoringDOSPQRCODE/'.$data['get_header'][0]['REQUEST_NUMBER'].'.png';

		            $this->ciqrcode->generate($params);

		            // foreach ($data['get_colly'] as $colly) {
		            // 	$params2['data']		= $colly['COLLY_NUMBER'];
				        // $params2['level']		= 'H';
				        // $params2['size']		= 4;
				        // $params2['black']		= array(255,255,255);
				        // $params2['white']		= array(0,0,0);
				        // $params2['savename']	= './assets/img/monitoringDOQRCODE/'.$colly['COLLY_NUMBER'].'.png';
								//
				        // $this->ciqrcode->generate($params2);
		            // }

		            ob_end_clean() ;

		            $filename 	= 'Packing_List_'.$data['get_header'][0]['REQUEST_NUMBER'].'.pdf';
		            $cetakPL	= $this->load->view('KapasitasGdSparepart/V_Pdf_PL', $data, true);

		            if (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 1) {
		              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br><br><br>';
		            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 2) {
		              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br><br>';
		            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 3) {
		              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br>';
		            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 4) {
		              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br>';
		            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 5) {
		              $a = $data['get_header'][0]['CATATAN'];
		            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 0) {
		              $a = '<br><br><br><br><br><br>';
		            }


		            $pdf->SetFillColor(0,255,0);
		            // $pdf->SetAlpha(0.4);
		            $pdf->WriteHTML($cetakPL);
		            $pdf->Output($filename, 'I');
		        // ========================end process=========================
		        } else {
			        echo json_encode(array(
			          	'success' => false,
			          	'message' => 'id is null'
			        ));
		        }

		        if (!unlink($params['savename'])) {
		            echo("Error deleting");
		        }
		    }

			public function cetakPL2($id)
			    {
							$body =  $this->M_pelayanan->bodyPL($id);

							foreach ($body as $key2 => $value) {
								$tampung_master[$value['COLLY_NUMBER']][] = $value;
							}
							if (!empty($tampung_master)) {
								$tampung = [];
								$one_page_is = [];
								foreach ($tampung_master as $key => $value) {
									foreach ($value as $key2 => $value2) {
										$tampung[] = $value2;
										if (sizeof($tampung) == 4) {
											$one_page_is[] = $tampung;
											$tampung = [];
										}elseif (sizeof($tampung) < 4 && empty($value[$key2+1])) {
											$one_page_is[] = $tampung;
											$tampung = [];
										}
									}
									$tampung_master[$key] = $one_page_is;
									$one_page_is = [];
								}
							}

							// echo "<pre>";print_r($tampung_master);die;
			        $data['get_header'] = $this->M_pelayanan->headfootPL($id);
			        // $data['get_body'] = $cek;
							$data['get_colly'] = $this->M_pelayanan->getTotalColly($id);
			        $data['total_colly'] = sizeof($data['get_colly']);
			        $data['total_berat'] = $this->M_pelayanan->getTotalBerat($id);
			        $data['petugas'] = $this->M_pelayanan->getAll($id);
			        $data['total_hal'] = $tampung_master;


			        if (!empty($id)) {
			            // ====================== do something =========================
			            $this->load->library('Pdf');
			            $this->load->library('ciqrcode');

			            $pdf 		= $this->pdf->load();
			            $pdf 		= new mPDF('utf-8', array(210 , 297), 0, '', 3, 3, 3, 0, 0, 0);

			            // ------ GENERATE QRCODE ------
			            if (!is_dir('./assets/img/monitoringDOSPQRCODE')) {
			                mkdir('./assets/img/monitoringDOSPQRCODE', 0777, true);
			                chmod('./assets/img/monitoringDOSPQRCODE', 0777);
			            }

			            $params['data']		= $data['get_header'][0]['REQUEST_NUMBER'];
			            $params['level']	= 'H';
			            $params['size']		= 3;
			            $params['black']	= array(255,255,255);
			            $params['white']	= array(0,0,0);
			            $params['savename'] = './assets/img/monitoringDOSPQRCODE/'.$data['get_header'][0]['REQUEST_NUMBER'].'.png';

			            $this->ciqrcode->generate($params);

			            // foreach ($data['get_colly'] as $colly) {
			            // 	$params2['data']		= $colly['COLLY_NUMBER'];
					        // $params2['level']		= 'H';
					        // $params2['size']		= 4;
					        // $params2['black']		= array(255,255,255);
					        // $params2['white']		= array(0,0,0);
					        // $params2['savename']	= './assets/img/monitoringDOQRCODE/'.$colly['COLLY_NUMBER'].'.png';
									//
					        // $this->ciqrcode->generate($params2);
			            // }

			            ob_end_clean() ;

			            $filename 	= 'Packing_List_'.$data['get_header'][0]['REQUEST_NUMBER'].'.pdf';
			            $cetakPL	= $this->load->view('KapasitasGdSparepart/V_Pdf_PL_A5', $data, true);

			            if (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 1) {
			              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br><br><br>';
			            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 2) {
			              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br><br>';
			            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 3) {
			              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br>';
			            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 4) {
			              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br>';
			            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 5) {
			              $a = $data['get_header'][0]['CATATAN'];
			            }elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/27) == 0) {
			              $a = '<br><br><br><br><br><br>';
			            }


			            $pdf->SetFillColor(0,255,0);
			            // $pdf->SetAlpha(0.4);
			            $pdf->WriteHTML($cetakPL);
			            $pdf->Output($filename, 'I');
			        // ========================end process=========================
			        } else {
				        echo json_encode(array(
				          	'success' => false,
				          	'message' => 'id is null'
				        ));
			        }

			        if (!unlink($params['savename'])) {
			            echo("Error deleting");
			        }
			    }

    public function cetakSM($id)
    {
        $data['get_header'] = $this->M_pelayanan->headfootPL($id);
				$data['get_colly'] = $this->M_pelayanan->getTotalColly($id);
        $data['total_colly'] = sizeof($data['get_colly']);

        // echo "<pre>";
        // print_r($data);
        // die();

        if (!empty($id)) {
            // ====================== do something =========================
            $this->load->library('Pdf');
            $this->load->library('ciqrcode');

            $pdf 		= $this->pdf->load();
            $pdf 		= new mPDF('utf-8', array(110 , 80), 0, '', 3, 3, 3, 0, 0, 0);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/monitoringDOSPQRCODE')) {
                mkdir('./assets/img/monitoringDOSPQRCODE', 0777, true);
                chmod('./assets/img/monitoringDOSPQRCODE', 0777);
            }

            $params['data']		= $data['get_header'][0]['REQUEST_NUMBER'];
            $params['level']	= 'H';
            $params['size']		= 4;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/monitoringDOSPQRCODE/'.$data['get_header'][0]['REQUEST_NUMBER'].'.png';

            $this->ciqrcode->generate($params);

            ob_end_clean() ;

            $filename 	= 'Shipping_Mark_'.$data['get_header'][0]['REQUEST_NUMBER'].'.pdf';
            $cetakPL	= $this->load->view('KapasitasGdSparepart/V_Pdf_SM', $data, true);

            $pdf->SetFillColor(0,255,0);
            $pdf->WriteHTML($cetakPL);
            $pdf->Output($filename, 'I');

        // ========================end process=========================
        } else {
	        echo json_encode(array(
	          	'success' => false,
	          	'message' => 'id is null'
	        ));
        }

				if (!unlink($params['savename'])) {
						echo("Error deleting");
				}
    }
}
