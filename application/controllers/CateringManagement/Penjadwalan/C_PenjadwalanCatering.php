<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_PenjadwalanCatering extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Penjadwalan/M_penjadwalancatering');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Penjadwalan Catering';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['katering'] = $this->M_penjadwalancatering->getCatering();

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === TRUE) {
			$arrData = array(
				'periode' 	=> $this->input->post('txtperiodePenjadwalanCatering'),
				'kode'		=> $this->input->post('txtCateringPenjadwalanCatering')
			);

			$encrypted_periode = $this->encrypt->encode($arrData['periode']);
	        $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
	        $encrypted_kode = $this->encrypt->encode($arrData['kode']);
	        $encrypted_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_kode);
			redirect(site_url('CateringManagement/PenjadwalanCatering/Read/'.$encrypted_periode."/".$encrypted_kode));

		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Penjadwalan/PenjadwalanCatering/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create($periode,$kd)
	{
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$kode_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$kode_text = $this->encrypt->decode($kode_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Create Penjadwalan Catering';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['katering'] = $this->M_penjadwalancatering->getCatering();

		$data['select'] = array(
			'periode' => $periode_text,
			'kode' => $kode_text
		);
		$data['encrypted'] = $periode."/".$kd;

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			// print_r($data['select']);exit();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Penjadwalan/PenjadwalanCatering/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			
				
			$periode = $this->input->post('txtPeriodePenjadwalanCateringCreate');
			$periode = explode(" - ",$periode);
			$s1 = $this->input->post('checkShift1');
			$s2 = $this->input->post('checkShift2');
			$s3 = $this->input->post('checkShift3');

			if (empty($s1)) {
				$s1 = "0";
			}
			if (empty($s2)) {
				$s2 = "0";
			}
			if (empty($s3)) {
				$s3 = "0";
			}

			$check = $this->M_penjadwalancatering->getCheckJadwalCatering($periode,$kode_text);

			if (empty($check)) {
				$arrData = array(
					'awal' => $periode['0'],
					'akhir' => $periode['1'],
					'kd' => $kode_text,
					's1' => $s1,
					's2' => $s2,
					's3' => $s3
				);
				$this->M_penjadwalancatering->insertJadwalCatering($arrData);
				redirect(site_url('CateringManagement/PenjadwalanCatering/Read/'.$data['encrypted']));
				// redirect(site_url('CateringManagement/PenjadwalanCatering'));
			}else{
				$data['hasilcheck'] = $check;
				$data['hasilinput']= array(
					'awal' => $periode['0'],
					'akhir' => $periode['1'],
					'kd' => $kode_text,
					's1' => $s1,
					's2' => $s2,
					's3' => $s3
				);

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CateringManagement/Penjadwalan/PenjadwalanCatering/V_create.php',$data);
				$this->load->view('V_Footer',$data);
			}
		}
	}

	public function Read($periode,$kd)
	{
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$kode_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$kode_text = $this->encrypt->decode($kode_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Penjadwalan Catering';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['katering'] = $this->M_penjadwalancatering->getCatering();

			$arrData = array(
				'periode' 	=> $periode_text,
				'kode'		=> $kode_text
			);
			$data['select'] = $arrData;
			$jadwal = $this->M_penjadwalancatering->getJadwalCatering($arrData);
			$akhir = $this->M_penjadwalancatering->getJadwalCateringAkhir($arrData);
			if (!empty($akhir)) {
				$akhir = $akhir['0']['tanggal'];
			}
			// echo "<pre>";print_r($jadwal);exit();
			$table = "";
			$angka = 1;
			$tanggal = "";
			$shift1 = "";
			$shift2 = "";
			$shift3 = "";
			foreach ($jadwal as $key) {
				if ($key['hari'] == '1') {
					if ($key['fs_tujuan_shift1'] == 't') {
						$s1 = 'Kirim';
					}else{
						$s1 = '-';
					}
					if ($key['fs_tujuan_shift2'] == 't') {
						$s2 = 'Kirim';
					}else{
						$s2 = '-';
					}
					if ($key['fs_tujuan_shift3'] == 't') {
						$s3 = 'Kirim';
					}else{
						$s3 = '-';
					}

					$encrypted_periode = $this->encrypt->encode($key['tanggal']." ".$key['bulan']." - ".$key['tanggal']." ".$key['bulan']);
                    $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
                    $encrypted_isi = $this->encrypt->encode($s1." ".$s2." ".$s3);
                    $encrypted_isi = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_isi);
					$encrypted_kode = $this->encrypt->encode($key['fs_kd_katering']);
                    $encrypted_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_kode);

					$table = $table."<tr>
										<td>".$angka."</td>
										<td>".$key['tanggal']." ".$key['bulan']."</td>
										<td>".$key['fs_nama_katering']."</td>
										<td>".$s1."</td>
										<td>".$s2."</td>
										<td>".$s3."</td>
										<td>
											<a href='".site_url('CateringManagement/PenjadwalanCatering/Edit/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."'  class='fa fa-edit fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
											<a href='".site_url('CateringManagement/PenjadwalanCatering/Delete/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."' class='fa fa-trash fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini ?\")'></a>
										</td>
									</tr>";
					$angka++;
					$tanggal = "";

				}else{
					$libur = $this->M_penjadwalancatering->getHariLibur($key['fd_tanggal']);
					if (!empty($libur)) {
						if ($key['fs_tujuan_shift1'] == 't') {
							$s1 = 'Kirim';
						}else{
							$s1 = '-';
						}
						if ($key['fs_tujuan_shift2'] == 't') {
							$s2 = 'Kirim';
						}else{
							$s2 = '-';
						}
						if ($key['fs_tujuan_shift3'] == 't') {
							$s3 = 'Kirim';
						}else{
							$s3 = '-';
						}

						$encrypted_periode = $this->encrypt->encode($key['tanggal']." ".$key['bulan']." - ".$key['tanggal']." ".$key['bulan']);
                        $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
                        $encrypted_isi = $this->encrypt->encode($s1." ".$s2." ".$s3);
                        $encrypted_isi = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_isi);
						$encrypted_kode = $this->encrypt->encode($key['fs_kd_katering']);
                        $encrypted_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_kode);

						$table = $table."<tr>
											<td>".$angka."</td>
											<td>".$key['tanggal']." ".$key['bulan']."</td>
											<td>".$key['fs_nama_katering']."</td>
											<td>".$s1."</td>
											<td>".$s2."</td>
											<td>".$s3."</td>
											<td>
												<a href='".site_url('CateringManagement/PenjadwalanCatering/Edit/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."'  class='fa fa-edit fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
												<a href='".site_url('CateringManagement/PenjadwalanCatering/Delete/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."' class='fa fa-trash fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini ?\")'></a>
											</td>
										</tr>";
						$angka++;
						$tanggal = "";
					}else{
						if ($tanggal == "") {
							$tanggal = $key['tanggal'];
							$libur = $this->M_penjadwalancatering->getHariLiburHplus($key['fd_tanggal']);
							$arrData = array(
								'tanggal' => $key['fd_tanggal'],
								'katering' => $key['fs_kd_katering'],
								's1' => $key['fs_tujuan_shift1'],
								's2' => $key['fs_tujuan_shift2'],
								's3' => $key['fs_tujuan_shift3']
							);
							$hplus = $this->M_penjadwalancatering->getJadwalCateringHplus($arrData);
							if ($key['hari'] == "07" or !empty($libur) or empty($hplus) or $key['tanggal'] == $akhir) {
								if ($key['fs_tujuan_shift1'] == 't') {
									$s1 = 'Kirim';
								}else{
									$s1 = '-';
								}
								if ($key['fs_tujuan_shift2'] == 't') {
									$s2 = 'Kirim';
								}else{
									$s2 = '-';
								}
								if ($key['fs_tujuan_shift3'] == 't') {
									$s3 = 'Kirim';
								}else{
									$s3 = '-';
								}

								$encrypted_periode = $this->encrypt->encode($key['tanggal']." ".$key['bulan']." - ".$key['tanggal']." ".$key['bulan']);
                                $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
                                $encrypted_isi = $this->encrypt->encode($s1." ".$s2." ".$s3);
                                $encrypted_isi = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_isi);
								$encrypted_kode = $this->encrypt->encode($key['fs_kd_katering']);
                                $encrypted_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_kode);

								$table = $table."<tr>
													<td>".$angka."</td>
													<td>".$key['tanggal']." ".$key['bulan']."</td>
													<td>".$key['fs_nama_katering']."</td>
													<td>".$s1."</td>
													<td>".$s2."</td>
													<td>".$s3."</td>
													<td>
														<a href='".site_url('CateringManagement/PenjadwalanCatering/Edit/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."'  class='fa fa-edit fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
														<a href='".site_url('CateringManagement/PenjadwalanCatering/Delete/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."' class='fa fa-trash fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini ?\")'></a>
													</td>
												</tr>";
								$angka++;
								$tanggal = "";
							}
						}else{
							$arrData = array(
								'tanggal' => $key['fd_tanggal'],
								'katering' => $key['fs_kd_katering'],
								's1' => $key['fs_tujuan_shift1'],
								's2' => $key['fs_tujuan_shift2'],
								's3' => $key['fs_tujuan_shift3']
							);
							$libur = $this->M_penjadwalancatering->getHariLiburHplus($key['fd_tanggal']);
							$hplus = $this->M_penjadwalancatering->getJadwalCateringHplus($arrData);
							if (empty($hplus) or $key['hari'] == "07" or !empty($libur) or $key['tanggal'] == $akhir) {
								if ($key['fs_tujuan_shift1'] == 't') {
									$s1 = 'Kirim';
								}else{
									$s1 = '-';
								}
								if ($key['fs_tujuan_shift2'] == 't') {
									$s2 = 'Kirim';
								}else{
									$s2 = '-';
								}
								if ($key['fs_tujuan_shift3'] == 't') {
									$s3 = 'Kirim';
								}else{
									$s3 = '-';
								}

								$encrypted_periode = $this->encrypt->encode($tanggal." ".$key['bulan']." - ".$key['tanggal']." ".$key['bulan']);
                                $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
                                $encrypted_isi = $this->encrypt->encode($s1." ".$s2." ".$s3);
                                $encrypted_isi = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_isi);
								$encrypted_kode = $this->encrypt->encode($key['fs_kd_katering']);
                                $encrypted_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_kode);

								$table = $table."<tr>
													<td>".$angka."</td>
													<td>".$tanggal." - ".$key['tanggal']." ".$key['bulan']."</td>
													<td>".$key['fs_nama_katering']."</td>
													<td>".$s1."</td>
													<td>".$s2."</td>
													<td>".$s3."</td>
													<td>
														<a href='".site_url('CateringManagement/PenjadwalanCatering/Edit/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."'  class='fa fa-edit fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
														<a href='".site_url('CateringManagement/PenjadwalanCatering/Delete/'.$encrypted_kode."/".$encrypted_periode."/".$encrypted_isi)."' class='fa fa-trash fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini ?\")'></a>
													</td>
												</tr>";
								$angka++;
								$tanggal = "";
							}

							
						}
					}
				}
			}
			$data['table'] = $table;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Penjadwalan/PenjadwalanCatering/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Edit($kd,$periode,$isi)
	{
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$isi_text = str_replace(array('-','_','~'), array('+','/','='), $isi);
		$isi_text = $this->encrypt->decode($isi_text);
		$kode_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$kode_text = $this->encrypt->decode($kode_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Penjadwalan Catering';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['katering'] = $this->M_penjadwalancatering->getCatering();
		$data['encrypted'] = $kd."/".$periode."/".$isi;
		$periodeaa = explode(" - ", $periode_text);
		$isi = explode(" ", $isi_text);
		$awal_text =$periodeaa['0'];
		$akhir_text =$periodeaa['1'];
		$bulan2 = $this->M_penjadwalancatering->getMonth2($awal_text);
		$bulan = $this->M_penjadwalancatering->getMonth($bulan2['0']['tanggal']);
		$s1 = $isi['0'];
		$s2 = $isi['1'];
		$s3 = $isi['2'];
		$data['select'] = array(
			'awal' => $awal_text,
			'akhir' => $akhir_text,
			'kode' => $kode_text,
			's1' => $s1,
			's2' => $s2,
			's3' => $s3,
			'bulan' => $bulan['0']['tanggal'],
			'bulan2' => $bulan2['0']['tanggal']
		);
		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Penjadwalan/PenjadwalanCatering/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$periodex = $this->input->post('txtPeriodePenjadwalanCateringCreate');
			$periodex = explode(" - ",$periodex);
			$s1 = $this->input->post('checkShift1');
			$s2 = $this->input->post('checkShift2');
			$s3 = $this->input->post('checkShift3');

			if (empty($s1)) {
				$s1 = "0";
			}
			if (empty($s2)) {
				$s2 = "0";
			}
			if (empty($s3)) {
				$s3 = "0";
			}

			$arrData = array(
				'awal' => $periodex['0'],
				'akhir' => $periodex['1'],
				'kd' => $kode_text,
				's1' => $s1,
				's2' => $s2,
				's3' => $s3
			);
			$periodey = explode(" ", $periodex['0']);
			$encrypted_periode = $this->encrypt->encode($periodey['1']." ".$periodey['2']);
            $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
			$this->M_penjadwalancatering->updateJadwalCatering($arrData);
			redirect(site_url('CateringManagement/PenjadwalanCatering/Read/'.$encrypted_periode.'/'.$kd));
		}

		
	}

	public function Distribusi($periode,$kd = FALSE)
	{
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		if ($kd !== FALSE) {
			$kode_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
			$kode_text = $this->encrypt->decode($kode_text);
			$jadwal = $this->M_penjadwalancatering->getCateringByKd($kode_text);
			
			
			
		}else{
			$jadwal = $this->M_penjadwalancatering->getCatering();
		}
		// echo "<pre>";
		// print_r($jadwal);exit;

		$table = "";

		foreach ($jadwal as $value) {
			$arrData = array(
			'periode' 	=> $periode_text,
			'kode'		=> $value['fs_kd_katering']
			);
			$this->M_penjadwalancatering->deleteTampilPesanan($arrData['periode'],$arrData['kode']);
			$jadwal = $this->M_penjadwalancatering->getJadwalCateringDistribusi($arrData);
			$akhir = $this->M_penjadwalancatering->getJadwalCateringAkhir($arrData);
			if (!empty($akhir)) {
				$akhir = $akhir['0']['tanggal'];
			}
			// echo "<pre>";print_r($jadwal);exit();
			
			$angka = 1;
			$tanggal = "";
			$shift1 = "";
			$shift2 = "";
			$shift3 = "";

			foreach ($jadwal as $key) {
				if ($key['hari'] == '1') {
					if ($key['fs_tujuan_shift1'] == 't') {
						$s1 = '1';
					}else{
						$s1 = '0';
					}
					if ($key['fs_tujuan_shift2'] == 't') {
						$s2 = '1';
					}else{
						$s2 = '0';
					}
					if ($key['fs_tujuan_shift3'] == 't') {
						$s3 = '1';
					}else{
						$s3 = '0';
					}

					$data = array(
									'fs_tanggal' 		=> intval($key['tanggal']).$key['bulan'],
									'fs_kd_katering' 	=> $key['fs_kd_katering'],
									'fs_tujuan_shift1' 	=> $s1,
									'fs_tujuan_shift2' 	=> $s2,
									'fs_tujuan_shift3' 	=> $s3,
									'fs_index' 			=> $angka
								);
					$this->M_penjadwalancatering->insertTampilPesanan($data);
					
					$angka++;
					$tanggal = "";

				}else{
					$libur = $this->M_penjadwalancatering->getHariLibur($key['fd_tanggal']);
					if (!empty($libur)) {
						if ($key['fs_tujuan_shift1'] == 't') {
							$s1 = '1';
						}else{
							$s1 = '0';
						}
						if ($key['fs_tujuan_shift2'] == 't') {
							$s2 = '1';
						}else{
							$s2 = '0';
						}
						if ($key['fs_tujuan_shift3'] == 't') {
							$s3 = '1';
						}else{
							$s3 = '0';
						}

						$data = array(
									'fs_tanggal' 		=> intval($key['tanggal']).$key['bulan'],
									'fs_kd_katering' 	=> $key['fs_kd_katering'],
									'fs_tujuan_shift1' 	=> $s1,
									'fs_tujuan_shift2' 	=> $s2,
									'fs_tujuan_shift3' 	=> $s3,
									'fs_index' 			=> $angka
								);
						$this->M_penjadwalancatering->insertTampilPesanan($data);
						
						$angka++;
						$tanggal = "";
					}else{
						if ($tanggal == "") {
							$tanggal = $key['tanggal'];
							$libur = $this->M_penjadwalancatering->getHariLiburHplus($key['fd_tanggal']);
							$arrData = array(
								'tanggal' => $key['fd_tanggal'],
								'katering' => $key['fs_kd_katering'],
								's1' => $key['fs_tujuan_shift1'],
								's2' => $key['fs_tujuan_shift2'],
								's3' => $key['fs_tujuan_shift3']
							);
							$hplus = $this->M_penjadwalancatering->getJadwalCateringHplus($arrData);
							if ($key['hari'] == "07" or !empty($libur) or empty($hplus)  or $key['tanggal'] == $akhir) {
								if ($key['fs_tujuan_shift1'] == 't') {
									$s1 = '1';
								}else{
									$s1 = '0';
								}
								if ($key['fs_tujuan_shift2'] == 't') {
									$s2 = '1';
								}else{
									$s2 = '0';
								}
								if ($key['fs_tujuan_shift3'] == 't') {
									$s3 = '1';
								}else{
									$s3 = '0';
								}

								$data = array(
									'fs_tanggal' 		=> intval($key['tanggal']).$key['bulan'],
									'fs_kd_katering' 	=> $key['fs_kd_katering'],
									'fs_tujuan_shift1' 	=> $s1,
									'fs_tujuan_shift2' 	=> $s2,
									'fs_tujuan_shift3' 	=> $s3,
									'fs_index' 			=> $angka
								);
								$this->M_penjadwalancatering->insertTampilPesanan($data);
								
								$angka++;
								$tanggal = "";
							}
						}else{
							$arrData = array(
								'tanggal' => $key['fd_tanggal'],
								'katering' => $key['fs_kd_katering'],
								's1' => $key['fs_tujuan_shift1'],
								's2' => $key['fs_tujuan_shift2'],
								's3' => $key['fs_tujuan_shift3']
							);
							$libur = $this->M_penjadwalancatering->getHariLiburHplus($key['fd_tanggal']);
							$hplus = $this->M_penjadwalancatering->getJadwalCateringHplus($arrData);
							if (empty($hplus) or $key['hari'] == "07" or !empty($libur) or $key['tanggal'] == $akhir) {
								if ($key['fs_tujuan_shift1'] == 't') {
									$s1 = '1';
								}else{
									$s1 = '0';
								}
								if ($key['fs_tujuan_shift2'] == 't') {
									$s2 = '1';
								}else{
									$s2 = '1';
								}
								if ($key['fs_tujuan_shift3'] == 't') {
									$s3 = '1';
								}else{
									$s3 = '0';
								}

								$data = array(
									'fs_tanggal' 		=> intval($tanggal)." - ".intval($key['tanggal']).$key['bulan'],
									'fs_kd_katering' 	=> $key['fs_kd_katering'],
									'fs_tujuan_shift1' 	=> $s1,
									'fs_tujuan_shift2' 	=> $s2,
									'fs_tujuan_shift3' 	=> $s3,
									'fs_index' 			=> $angka
								);
								$this->M_penjadwalancatering->insertTampilPesanan($data);
								
								$angka++;
								$tanggal = "";
							}

							
						}
					}
				}
			}
		}

		
			
		echo "<table>".$table."</table>";echo "hahah";

		if ($kd !== False) {
			redirect(site_url('CateringManagement/PenjadwalanCatering/Read/'.$periode."/".$kd));
		}else{
			redirect(site_url('CateringManagement/PenjadwalanOtomatis/Finish/'.$periode));
		}

	}

	public function Delete($kd,$periode,$isi){
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$isi_text = str_replace(array('-','_','~'), array('+','/','='), $isi);
		$isi_text = $this->encrypt->decode($isi_text);
		$kode_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$kode_text = $this->encrypt->decode($kode_text);

		$periode_text = explode(" - ",$periode_text);
		$isi_text = explode(" ", $isi_text);
		if ($isi_text['0'] == 'Kirim') {
			$s1 = '1';
		}else{
			$s1 = '0';
		}
		if ($isi_text['1'] == 'Kirim') {
			$s2 = '1';
		}else{
			$s2 = '0';
		}
		if ($isi_text['2'] == 'Kirim') {
			$s3 = '1';
		}else{
			$s3 = '0';
		}
		$Data = array(
			'kd' => $kode_text, 
			'awal' => $periode_text['0'], 
			'akhir' => $periode_text['1'], 
			's1' => $s1, 
			's2' => $s2, 
			's3' => $s3, 
		);
		$this->M_penjadwalancatering->deleteJadwalCatering($Data);
		$periode = $this->M_penjadwalancatering->getMonth2($periode_text['0']);
		$encrypted_periode = $this->encrypt->encode($periode['0']['tanggal']);
        $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
		redirect(site_url('CateringManagement/PenjadwalanCatering/Read/'.$encrypted_periode."/".$kd));
	}
}
?>