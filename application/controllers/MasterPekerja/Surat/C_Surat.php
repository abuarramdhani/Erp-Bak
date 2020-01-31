<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class C_Surat extends CI_Controller 
	{

		function __construct()
		{
			parent::__construct();

			$this->load->library('General');

			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MasterPekerja/Surat/M_surat');

			date_default_timezone_set('Asia/Jakarta');

			$this->checkSession();
		}

		public function checkSession()
		{
			if(!($this->session->is_logged))
			{
				redirect('');
			}
		}

		public function preview()
		{
			$jenis_surat 			=	$this->input->post('txtFormatSurat', TRUE);
			$status_staf			=	$this->input->post('txtStatusStaf', TRUE);

			if ( empty($status_staf) )
			{
				$error = 'Anda belum memilih pekerja. Dimohon untuk memilih pekerja dahulu.';
				echo "<script>alert('$error');</script>";
				exit();
			}

			$tanggal_cetak 			=	$this->input->post('txtTanggalCetak', TRUE);
			$tanggal_berlaku 		=	$this->input->post('txtTanggalBerlaku', TRUE);

			$data['kode_surat']		=	'XXXXX';
			$data['nomor_surat']	=	0;
			$data['hal_surat']		=	'HALAL';
			$data['preview'] 		=	$this->C_Mutasi->prosesPreviewMutasi();

			// 	Kode, Nomor, dan Hal Surat
			//	{
					$status_staf_bool 	=	FALSE;
					if( strpos($status_staf, "NON") !== FALSE )
					{
						$status_staf_bool 	=	FALSE;	
					}
					else
					{
						$status_staf_bool 	=	TRUE;
					}

					$tahun_cetak 	=	date('Y', strtotime($tanggal_cetak));
					$bulan_cetak 	=	date('n', strtotime($tanggal_cetak));
					$tahun_berlaku 	=	date('Y', strtotime($tanggal_berlaku));
					$bulan_berlaku 	=	date('n', strtotime($tanggal_berlaku));

					// 	Cek kode surat
					// 	{
							$tabel_kode_surat 	=	$this->M_surat->kode_surat($jenis_surat, $status_staf_bool);
							
							if( empty($tabel_kode_surat) )
							{
								echo 'Kode surat tidak ditemukan.<br/>Mohon input terlebih dahulu.';
								exit();
							}
							else
							{
								$data['kode_surat'] 	=	$tabel_kode_surat[0]['kode_surat'];
							}
					//	}

					// 	Ambil Nomor Surat Baru
					// 	{
							$tabel_arsip_nomor_surat 	=	$this->M_surat->nomor_surat($data['kode_surat'], 'max', $tahun_cetak, $bulan_cetak);

							
							if( empty($tabel_arsip_nomor_surat) )
							{
								$data['nomor_surat']	=	'001';
							}
							else
							{
								$data['nomor_surat']	=	$tabel_arsip_nomor_surat[0]['hitung']+1;
								if ($data['nomor_surat'] < 10) {
									$data['nomor_surat'] = '00'.$data['nomor_surat'];
								}elseif ($data['nomor_surat'] > 10 && $data['nomor_surat'] < 100) {
									$data['nomor_surat'] = '0'.$data['nomor_surat'];
								}
							}
					//	}

					//	Hal Surat
					// 	{
							$data['hal_surat']		=	$jenis_surat;
					//	}
			//	}

			// 	Preview Surat
			//	{
						
			//	}

			echo json_encode($data);
		}

		// 	Javascript
		//	{
				public function daftar_pekerja_sp3() {
					$pekerja = $this->M_surat->pekerjaSP3(strtoupper($this->input->get('term', TRUE)));
					echo json_encode($pekerja);
				}
				
				public function daftar_pekerja_aktif()
				{
					$keyword 	 	=	strtoupper($this->input->get('term', TRUE));
					$aktif 			=	1;
					$pekerja		=	$this->M_surat->pekerja($keyword, $aktif);
					echo json_encode($pekerja);
				}

				public function finger_reference()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$finger_reference 	=	$this->M_surat->finger_reference($keyword);
					// echo "<pre>"; print_r($keyword); exit();
					echo json_encode($finger_reference);
				}

				public function daftar_pekerja_pengangkatan()
				{
					$keyword 	 	=	strtoupper($this->input->get('term', TRUE));
					$aktif 			=	1;
					$pekerja		=	$this->M_surat->pekerja_staf($keyword);
					echo json_encode($pekerja);
				}
				public function daftar_pekerja_pengangkatan_non()
				{
					$keyword 	 	=	strtoupper($this->input->get('term', TRUE));
					$aktif 			=	1;
					$pekerja		=	$this->M_surat->pekerja_non_staf($keyword);
					echo json_encode($pekerja);
				}

				public function daftar_kode_jabatan_kerja()
				{
					$keyword 		=	strtoupper($this->input->get('term', TRUE));
					$kode_jabatan 	=	$this->M_surat->kode_jabatan_kerja($keyword);
					echo json_encode($kode_jabatan);
				}

				public function daftar_lokasi_kerja()
				{
					$keyword 		=	strtoupper($this->input->get('term', TRUE));
					$lokasi_kerja 	=	$this->M_surat->lokasi_kerja($keyword);
					echo json_encode($lokasi_kerja);
				}

				public function detail_pekerja()
				{
					$noind 			=	$this->input->post('noind');
					$detail_pekerja	=	$this->M_surat->detail_pekerja($noind);
					$kodelokasi 	= $this->M_surat->kodefinger($noind);
					$lokasi_finger = $this->M_surat->lokasifinger($kodelokasi);
					if (empty($lokasi_finger) || $kodelokasi == '0') {
						$lokasi_finger[0]['id_lokasi']   = "Lebih dari satu finger";
						$lokasi_finger[0]['device_name'] = "";
					}else{
						$lokasi_finger = $lokasi_finger;
					}
					// echo "<pre>"; print_r($lokasi_finger); exit();
					$data['kodesie'] 					= 	$detail_pekerja[0]['kodesie'];
					$data['posisi'] 					= 	$detail_pekerja[0]['posisi'];
					$data['kode_pekerjaan'] 			= 	$detail_pekerja[0]['kode_pekerjaan'];
					$data['nama_pekerjaan'] 			= 	$detail_pekerja[0]['nama_pekerjaan'];
					$data['golongan_pekerjaan'] 		= 	$detail_pekerja[0]['golkerja'];
					$data['kode_lokasi_kerja'] 			= 	$detail_pekerja[0]['kode_lokasi_kerja'];
					$data['nama_lokasi_kerja'] 			= 	$detail_pekerja[0]['nama_lokasi_kerja'];
					$data['kode_jabatan'] 				= 	$detail_pekerja[0]['kode_jabatan'];
					$data['jenis_jabatan'] 				= 	$detail_pekerja[0]['jenis_jabatan'];
					$data['nama_jabatan'] 				= 	$detail_pekerja[0]['nama_jabatan'];
					$data['tempat_makan1'] 				= 	$detail_pekerja[0]['tempat_makan1'];
					$data['tempat_makan2'] 				= 	$detail_pekerja[0]['tempat_makan2'];
					$data['status_staf'] 				= 	$detail_pekerja[0]['status_staf'];
					$data['jabatan_dl'] 				= 	$detail_pekerja[0]['jabatan_dl'];
					$data['id_lokasifinger'] 			= 	$lokasi_finger[0]['id_lokasi'];
					$data['lokasi_finger'] 				= 	$lokasi_finger[0]['device_name'];
					$data['kd_status'] 					= 	$detail_pekerja[0]['kd_status'];
					$data['nama_status'] 				= 	trim($detail_pekerja[0]['nama_status']);
					$data['nama_jabatan_upah'] 			= 	trim($detail_pekerja[0]['nama_jabatan_upah']);
					
					$kode_induk = array('A', 'H', 'K', 'P', 'E');
					if(in_array(substr($noind,0,1), $kode_induk)){
						$custom_jabatan = "OPERATOR ".$detail_pekerja[0]['seksi'];;
					}else{
						$custom_jabatan = $detail_pekerja[0]['nama_jabatan'];
					}
					if($detail_pekerja[0]['kode_lokasi_kerja'] == "02"){
						$custom_alamatperusahaan = "Jl. Dudukan, Tuksono, Sentolo, Kulonprogo 55664";
					}else{
						$custom_alamatperusahaan = "Jl. Magelang No. 144 Yogyakarta 55241";
					}
					
					$data['alamat']						=	$detail_pekerja[0]['alamat'];
					$data['custom_jabatan']				=	$custom_jabatan;
					$data['nama_perusahaan']			=	"CV. Karya Hidup Sentosa";
					$data['alamat_perusahaan']			=	$custom_alamatperusahaan;

					if ( empty($data['kode_pekerjaan']) && empty($data['nama_pekerjaan']) )
					{
						$data['kode_pekerjaan'] 			= 	'';
						$data['nama_pekerjaan'] 			= 	'';
					}
					// echo "<pre>";
					// print_r($data);exit();
					echo json_encode($data);
				}

				public function daftar_seksi()
				{
					$keyword 	 	=	strtoupper($this->input->get('term', TRUE));
					$tseksi			=	$this->M_surat->tseksi($keyword);
					echo json_encode($tseksi);
				}

				public function daftar_golongan_pekerjaan()
				{
					$keyword 	 		=	strtoupper($this->input->get('term', TRUE));
					$kode_status_kerja 	=	$this->input->get('kode_status_kerja', TRUE);
					$golongan_pekerjaan	=	$this->M_surat->golongan_pekerjaan($kode_status_kerja, $keyword);
					echo json_encode($golongan_pekerjaan);
				}

				public function daftar_tempat_makan()
				{
					$keyword 		=	strtoupper($this->input->get('term', TRUE));
					$tempat_makan 	=	$this->M_surat->tempat_makan($keyword);
					echo json_encode($tempat_makan);
				}

				public function daftar_pekerjaan()
				{
					$keyword 		=	strtoupper($this->input->get('term', TRUE));
					$pekerjaan 		=	$this->M_surat->pekerjaan($keyword);
					echo json_encode($pekerjaan);
				}

				public function daftar_nama_status()
				{
					$keyword 			=	strtoupper($this->input->get('term', TRUE));
					$nama_status 		=	$this->M_surat->getNamaStatus();
					echo json_encode($nama_status);
				}

				public function daftar_nama_jabatan_upah()
				{
					$keyword 			=	strtoupper($this->input->get('term', TRUE));
					$nama_jabatan 		=	$this->M_surat->getNamaJabatanUpah();
					echo json_encode($nama_jabatan);
				}

		//	}
	}
