<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CetakMemoJadwalTraining extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');
		$this->load->library('pdf');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_cetakmemojadwaltraining');
		$this->load->model('MonitoringOJT/M_cetakundangan');
		$this->load->model('MonitoringOJT/M_masterundangan');
		$this->load->model('MonitoringOJT/M_monitoring');
		$this->load->model('MonitoringOJT/M_email');

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

	public function index()
	{

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Jadwal Training', 'Cetak', 'Memo Jadwal Training');

		$data['daftar_cetak_memo_jadwal_training']		=	$this->M_cetakmemojadwaltraining->cetak_memo_jadwal_training();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_CetakMemoJadwalTraining_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$this->form_validation->set_rules('txtPeriode', 'Periode', 'required');
		$this->form_validation->set_rules('cmbPekerjaOJT[]', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('txaIsiMemoJadwalTraining', 'Memo', 'required');
		$this->form_validation->set_rules('txaIsiLampiranJadwalTraining', 'Lampiran', 'required');
		$this->form_validation->set_rules('cmbPosisiCetakMemo', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('cmbPosisiCetakLampiran', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('numLebarKertas', 'Lebar Kertas', 'required');
		$this->form_validation->set_rules('numTinggiKertas', 'Tinggi Kertas', 'required');
		$this->form_validation->set_rules('numBatasTepiAtas', 'Batas Tepi Atas', 'required');
		$this->form_validation->set_rules('numBatasTepiBawah', 'Batas Tepi Bawah', 'required');
		$this->form_validation->set_rules('numBatasTepiKiri', 'Batas Tepi Kiri', 'required');
		$this->form_validation->set_rules('numBatasTepiKanan', 'Batas Tepi Kanan', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Jadwal Training', 'Cetak', 'Memo Jadwal Training');

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_CetakMemoJadwalTraining_Create',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$periode 					=	$this->input->post('txtPeriode');
			$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
			$memo 						=	$this->input->post('txaIsiMemoJadwalTraining');
			$lampiran 					=	$this->input->post('txaIsiLampiranJadwalTraining');
			$posisi_cetak_memo 			=	$this->input->post('cmbPosisiCetakMemo');
			$posisi_cetak_lampiran 		=	$this->input->post('cmbPosisiCetakLampiran');			
			$lebar_kertas 				=	$this->input->post('numLebarKertas', TRUE);
			$tinggi_kertas 				=	$this->input->post('numTinggiKertas', TRUE);
			$margin_atas 				=	$this->input->post('numBatasTepiAtas', TRUE);
			$margin_bawah 				=	$this->input->post('numBatasTepiBawah', TRUE);
			$margin_kiri 				=	$this->input->post('numBatasTepiKiri', TRUE);
			$margin_kanan 				=	$this->input->post('numBatasTepiKanan', TRUE);

			$periode 					=	explode(' - ', $periode);
			$tanggal_periode_awal 		=	$periode[0];
			$tanggal_periode_akhir 		=	$periode[1];

			$create_memo_jadwal_training 	=	array
												(
													'tanggal_periode_awal'		=>	$tanggal_periode_awal,
													'tanggal_periode_akhir'		=>	$tanggal_periode_akhir,
													'memo'						=>	$memo,
													'lampiran'					=>	$lampiran,
													'posisi_cetak_memo'			=>	$posisi_cetak_memo,
													'posisi_cetak_lampiran'		=>	$posisi_cetak_lampiran,
													'lebar_kertas'				=>	$lebar_kertas,
													'tinggi_kertas'				=>	$tinggi_kertas,
													'margin_atas'				=>	$margin_atas,
													'margin_bawah'				=>	$margin_bawah,
													'margin_kiri'				=>	$margin_kiri,
													'margin_kanan'				=>	$margin_kanan,
													'create_timestamp'			=>	$execution_timestamp,
													'create_user'				=>	$user,
												);
			$id_proses_memo_jadwal_training =	$this->M_cetakmemojadwaltraining->create_memo_jadwal_training($create_memo_jadwal_training);
			$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training', array('id_proses_memo_jadwal_training =' => $id_proses_memo_jadwal_training), 'CREATE');

			foreach ($id_pekerja as $pekerja)
			{
				$create_memo_jadwal_training_ref 	=	array
														(
															'id_proses_memo_jadwal_training'	=>	$id_proses_memo_jadwal_training,
															'id_pekerja'						=>	$pekerja,
															'create_timestamp'					=>	$execution_timestamp,
															'create_user'						=>	$user,
														);
				$id_proses_memo_jadwal_training_ref	=	$this->M_cetakmemojadwaltraining->create_memo_jadwal_training_ref($create_memo_jadwal_training_ref);
				$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training_ref', array('id_proses_memo_jadwal_training_ref =' => $id_proses_memo_jadwal_training_ref), 'CREATE');
			}
			redirect('OnJobTraining/CetakMemoJadwalTraining');
		}
	}

	public function export_memo_pdf($id_proses_memo_jadwal_training)
	{
		$id_proses_memo_jadwal_training_decode 	= $this->general->dekripsi($id_proses_memo_jadwal_training);

		$memo_pdf		=	$this->M_cetakmemojadwaltraining->cetak_memo_jadwal_training($id_proses_memo_jadwal_training_decode);

		$pdf 	=	$this->pdf->load();
		$pdf 	=	new 	mPDF
							(
								'utf-8', 
								array
								(
									$memo_pdf[0]['lebar_kertas'],
									$memo_pdf[0]['tinggi_kertas']
								), 
								"", 
								"", 
								$memo_pdf[0]['margin_kiri'], 
								$memo_pdf[0]['margin_kanan'], 
								$memo_pdf[0]['margin_atas'], 
								$memo_pdf[0]['margin_bawah'], 
								0, 
								0, 
								$memo_pdf[0]['posisi_cetak_memo']
							);
		$filename	=	'MonitoringOJT_'.'MemoJadwalTraining'.'_'.$memo_pdf['tanggal_periode_awal'].'-'.$memo_pdf['tanggal_periode_akhir'].'_'.date('Ymd').'.pdf';			
		$pdf->AddPage();
		$pdf->WriteHTML($memo_pdf[0]['memo']);

		$pdf->Output($filename, 'I');
	}

	public function export_lampiran_pdf($id_proses_memo_jadwal_training)
	{
		$id_proses_memo_jadwal_training_decode 	= $this->general->dekripsi($id_proses_memo_jadwal_training);

		$memo_pdf		=	$this->M_cetakmemojadwaltraining->cetak_memo_jadwal_training($id_proses_memo_jadwal_training_decode);

		$pdf 	=	$this->pdf->load();
		$pdf 	=	new 	mPDF
							(
								'utf-8', 
								array
								(
									$memo_pdf[0]['lebar_kertas'],
									$memo_pdf[0]['tinggi_kertas']
								), 
								"", 
								"", 
								$memo_pdf[0]['margin_kiri'], 
								$memo_pdf[0]['margin_kanan'], 
								$memo_pdf[0]['margin_atas'], 
								$memo_pdf[0]['margin_bawah'], 
								0, 
								0, 
								$memo_pdf[0]['posisi_cetak_lampiran']
							);
		$filename	=	'MonitoringOJT_'.'MemoJadwalTraining'.'_'.$memo_pdf['tanggal_periode_awal'].'-'.$memo_pdf['tanggal_periode_akhir'].'_'.date('Ymd').'.pdf';			
		$pdf->AddPage();
		$pdf->WriteHTML($memo_pdf[0]['lampiran']);

		$pdf->Output($filename, 'I');
	}

	public function update($id_proses_memo_jadwal_training)
	{
		$this->form_validation->set_rules('txtPeriode', 'Periode', 'required');
		$this->form_validation->set_rules('cmbPekerjaOJT[]', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('txaIsiMemoJadwalTraining', 'Memo', 'required');
		$this->form_validation->set_rules('txaIsiLampiranJadwalTraining', 'Lampiran', 'required');
		$this->form_validation->set_rules('cmbPosisiCetakMemo', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('cmbPosisiCetakLampiran', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('numLebarKertas', 'Lebar Kertas', 'required');
		$this->form_validation->set_rules('numTinggiKertas', 'Tinggi Kertas', 'required');
		$this->form_validation->set_rules('numBatasTepiAtas', 'Batas Tepi Atas', 'required');
		$this->form_validation->set_rules('numBatasTepiBawah', 'Batas Tepi Bawah', 'required');
		$this->form_validation->set_rules('numBatasTepiKiri', 'Batas Tepi Kiri', 'required');
		$this->form_validation->set_rules('numBatasTepiKanan', 'Batas Tepi Kanan', 'required');

		$id_proses_memo_jadwal_training_decode 	=	$this->general->dekripsi($id_proses_memo_jadwal_training);

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Jadwal Training', 'Cetak', 'Memo Jadwal Training');

			$data['id']										=	$id_proses_memo_jadwal_training;
			$data['daftar_cetak_memo_jadwal_training']		=	$this->M_cetakmemojadwaltraining->cetak_memo_jadwal_training($id_proses_memo_jadwal_training_decode);
			$data['daftar_cetak_memo_jadwal_training_ref']	=	$this->M_cetakmemojadwaltraining->cetak_memo_jadwal_training_ref($id_proses_memo_jadwal_training_decode);			

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_CetakMemoJadwalTraining_Update',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$periode 					=	$this->input->post('txtPeriode');
			$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
			$memo 						=	$this->input->post('txaIsiMemoJadwalTraining');
			$lampiran 					=	$this->input->post('txaIsiLampiranJadwalTraining');
			$posisi_cetak_memo 			=	$this->input->post('cmbPosisiCetakMemo');
			$posisi_cetak_lampiran 		=	$this->input->post('cmbPosisiCetakLampiran');			
			$lebar_kertas 				=	$this->input->post('numLebarKertas', TRUE);
			$tinggi_kertas 				=	$this->input->post('numTinggiKertas', TRUE);
			$margin_atas 				=	$this->input->post('numBatasTepiAtas', TRUE);
			$margin_bawah 				=	$this->input->post('numBatasTepiBawah', TRUE);
			$margin_kiri 				=	$this->input->post('numBatasTepiKiri', TRUE);
			$margin_kanan 				=	$this->input->post('numBatasTepiKanan', TRUE);

			$periode 					=	explode(' - ', $periode);
			$tanggal_periode_awal 		=	$periode[0];
			$tanggal_periode_akhir 		=	$periode[1];

			$update_memo_jadwal_training 	=	array
												(
													'tanggal_periode_awal'		=>	$tanggal_periode_awal,
													'tanggal_periode_akhir'		=>	$tanggal_periode_akhir,
													'memo'						=>	$memo,
													'lampiran'					=>	$lampiran,
													'posisi_cetak_memo'			=>	$posisi_cetak_memo,
													'posisi_cetak_lampiran'		=>	$posisi_cetak_lampiran,
													'lebar_kertas'				=>	$lebar_kertas,
													'tinggi_kertas'				=>	$tinggi_kertas,
													'margin_atas'				=>	$margin_atas,
													'margin_bawah'				=>	$margin_bawah,
													'margin_kiri'				=>	$margin_kiri,
													'margin_kanan'				=>	$margin_kanan,
													'last_update_timestamp'		=>	$execution_timestamp,
													'last_update_user'			=>	$user,
												);
			$this->M_cetakmemojadwaltraining->update_memo_jadwal_training($update_memo_jadwal_training, $id_proses_memo_jadwal_training_decode);
			$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training', array('id_proses_memo_jadwal_training =' => $id_proses_memo_jadwal_training_decode), 'UPDATE');

			$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training_ref', array('id_proses_memo_jadwal_training =' => $id_proses_memo_jadwal_training_decode), 'DELETE');
			$this->M_cetakmemojadwaltraining->delete_memo_jadwal_training_ref($id_proses_memo_jadwal_training_decode);

			foreach ($id_pekerja as $pekerja)
			{
				$create_memo_jadwal_training_ref 	=	array
														(
															'id_proses_memo_jadwal_training'	=>	$id_proses_memo_jadwal_training_decode,
															'id_pekerja'						=>	$pekerja,
															'create_timestamp'					=>	$execution_timestamp,
															'create_user'						=>	$user,
														);
				$id_proses_memo_jadwal_training_ref	=	$this->M_cetakmemojadwaltraining->create_memo_jadwal_training_ref($create_memo_jadwal_training_ref);
				$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training_ref', array('id_proses_memo_jadwal_training_ref =' => $id_proses_memo_jadwal_training_ref), 'CREATE');
			}
			redirect('OnJobTraining/CetakMemoJadwalTraining');
		}
	}

	public function delete($id_proses_memo_jadwal_training)
	{
		$id_proses_memo_jadwal_training_decode 	=	$this->general->dekripsi($id_proses_memo_jadwal_training);

		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training_ref', array('id_proses_memo_jadwal_training =' => $id_proses_memo_jadwal_training_decode), 'DELETE');
		$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_jadwal_training', array('id_proses_memo_jadwal_training =' => $id_proses_memo_jadwal_training_decode), 'DELETE');
		$this->M_cetakmemojadwaltraining->delete_memo_jadwal_training_ref($id_proses_memo_jadwal_training_decode);
		$this->M_cetakmemojadwaltraining->delete_memo_jadwal_training($id_proses_memo_jadwal_training_decode);
		redirect('OnJobTraining/CetakMemoJadwalTraining');
	}

	//	Javascript Functions
	//	{
			public function daftar_pekerja_ojt()
			{
				$keyword 					=	strtoupper($this->input->get('term'));
				$periode 					=	$this->input->get('periode');

				$periode 					=	explode('|', $periode);
				$periode_awal 				=	$periode[0];
				$periode_akhir				=	$periode[1];

				$daftar_pekerja_ojt 		=	$this->M_monitoring->daftar_pekerja_ojt($keyword, $periode_awal, $periode_akhir);
				echo json_encode($daftar_pekerja_ojt);
			}

			public function isi_memo_jadwal_training()
			{
				$data['isi_memo_jadwal_training'] 		=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';
				$data['isi_lampiran_jadwal_training'] 	=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';

				$id_pekerja 			=	$this->input->post('cmbPekerjaOJT');
				$periode 				=	$this->input->post('txtPeriode');

				$periode 				=	explode(' - ', $periode);

				$periode_awal 			=	date('d F Y', strtotime($periode[0]));
				$periode_akhir 			=	date('d F Y', strtotime($periode[1]));
				$tanggal_cetak 			=	date('d F Y');

				if ( !( empty($id_pekerja) ) )
				{
					$format_memo 		=	$this->M_cetakmemojadwaltraining->format('JADWAL TRAINING');

					$format 				=	$format_memo[0]['memo'];

					$tabel_jadwal 			=	'
													<table style="width: 100%">
													<tbody>
													<tr>
														<td>
															<img src="http://erp.quick.com/assets/img/logo.png" style="background-color: initial; width: 25mm; vertical-align: middle; display: block; margin: auto;" alt="">
														</td>
														<td style="width: 90%; text-align: center;">
															<h1>MEMO</h1>
															<h2>PEOPLE DEVELOPMENT</h2>
															<h2>CV Karya Hidup Sentosa</h2>
														</td>
													</tr>
													</tbody>
													</table>
													<hr>
													<p>
														Lampiran Memo [no_memo]
													</p>
													<h4 style="text-align: center;">JADWAL TRAINING MASA ORIENTASI STAF D3/S1</h4>
													<table style="width: 100%; border: 1px solid black; border-collapse: collapse;" align="center">
												';
					
					$bulan_en 		=	array
										(
											'January',
											'February',
											'March',
											'April',
											'May',
											'June',
											'July',
											'August',
											'September',
											'October',
											'November',
											'December',
										);
					$bulan_id 		=	array
										(
											'Januari',
											'Februari',
											'Maret',
											'April',
											'Mei',
											'Juni',
											'Juli',
											'Agustus',
											'September',
											'Oktober',
											'November',
											'Desember',
										);
					$nama_hari_en 	=	array
										(
											'Monday',
											'Tuesday',
											'Wednesday',
											'Thursday',
											'Friday',
											'Saturday',
											'Sunday',
										);
					$nama_hari_id	=	array
										(
											'Senin',
											'Selasa',
											'Rabu',
											'Kamis',
											'Jumat',
											'Sabtu',
										);

					$tanggal_cetak 			=	str_replace($bulan_en, $bulan_id, $tanggal_cetak);
					$periode_awal 			=	str_replace($bulan_en, $bulan_id, $periode_awal);
					$periode_akhir 			=	str_replace($bulan_en, $bulan_id, $periode_akhir);

					$nama_tahapan 	=	array
			    						(
			    							'TANGGAL MASUK ORIENTASI',
			    							'SELESAI ORIENTASI',
			    							'POTENSIAL REVIEW',
			    							'PUBLIC SPEAKING',
			    							'TRAINING PDCA',
			    							'PENGUMPULAN PDCA',
			    						);

					$daftar_jadwal_pekerja_ojt 	=	$this->M_cetakmemojadwaltraining->jadwal_pekerja_ojt($id_pekerja, $nama_tahapan);
					$daftar_pekerja_ojt 		=	$this->M_cetakmemojadwaltraining->pekerja_ojt($id_pekerja);
					$daftar_tahapan_jadwal 		=	$this->M_cetakmemojadwaltraining->tahapan_jadwal($nama_tahapan);

					$daftar_atasan 			=	$this->M_cetakmemojadwaltraining->atasan($id_pekerja);
					$jumlah_atasan 			=	count($daftar_atasan);
					$tabel_daftar_atasan	=	'<table style="width: 100%; border: 1px solid black; border-collapse: collapse;" align="center">';
					$indeks_atasan 			=	1;

					//	Tabel daftar atasan
					//	{
							foreach ($daftar_atasan as $daftar_atasan)
							{
								if ( $indeks_atasan % 4 == 1 )
								{
									$tabel_daftar_atasan	.=	'<tr style="border: 1px solid black;">';
								}

								$tabel_daftar_atasan 	.=	'<td style="width: 25%; border: 1px solid black; vertical-align: middle; text-align: center;">'.$daftar_atasan['nama_atasan_pekerja'].'</td>';

								if ( $indeks_atasan % 4 == 0 )
								{
									$tabel_daftar_atasan	.=	'</tr>';
								}

								$indeks_atasan++;
							}

							if ( $indeks_atasan > ($jumlah_atasan+1))
							{
								$tabel_daftar_atasan	.=	'</tr>';
							}
							$tabel_daftar_atasan	.=	'</table>';
					//	}

					//	Tabel jadwal pekerja
					//	{
							$indeks_pekerja_ojt 	=	1;
							$tabel_jadwal 	.=	'
													<tr>
														<th style="text-align: center; vertical-align: middle; border: 1px solid black;">NO</th>
														<th style="text-align: center; vertical-align: middle; border: 1px solid black;">NOMOR INDUK</th>
														<th style="text-align: center; vertical-align: middle; border: 1px solid black;">NAMA</th>
														<th style="text-align: center; vertical-align: middle; border: 1px solid black;">SEKSI</th>
												';

							foreach ($daftar_tahapan_jadwal as $jadwal)
							{
								$tabel_jadwal 	.=	'<th style="text-align: center; vertical-align: middle; border: 1px solid black;">'.$jadwal['tahapan'].'</th>';
							}

							$tabel_jadwal 	.=	'</tr>';

							foreach ($daftar_pekerja_ojt as $pekerja_ojt)
							{
								$tabel_jadwal	.=	'<tr>';
								$tabel_jadwal 	.=	'<td style="vertical-align: middle; border: 1px solid black; white-space: nowrap;">'.$indeks_pekerja_ojt.'</td>';
								$tabel_jadwal 	.=	'<td style="vertical-align: middle; border: 1px solid black; white-space: nowrap;">'.$pekerja_ojt['noind'].'</td>';
								$tabel_jadwal 	.=	'<td style="vertical-align: middle; border: 1px solid black;">'.$pekerja_ojt['nama_pekerja_ojt'].'</td>';
								$tabel_jadwal 	.=	'<td style="vertical-align: middle; border: 1px solid black;">'.$pekerja_ojt['seksi_pekerja_ojt'].'</td>';

								foreach ($daftar_tahapan_jadwal as $jadwal)
								{
									foreach ($daftar_jadwal_pekerja_ojt as $jadwal_pekerja)
									{
										if ( $jadwal_pekerja['noind'] == $pekerja_ojt['noind'] )
										{
												if ( $jadwal_pekerja['tahapan'] == $jadwal['tahapan'] )
												{
													$tanggal_jadwal 	=	'';

													if ( strtotime($jadwal_pekerja['tgl_akhir']) > strtotime($jadwal_pekerja['tgl_awal']) )
													{
														$tanggal_jadwal 	=	date('d-m-Y', strtotime($jadwal_pekerja['tgl_awal'])).' s.d. '.date('d-m-Y', strtotime($jadwal_pekerja['tgl_akhir']));
													}
													else
													{
														$tanggal_jadwal 	=	date('d-m-Y', strtotime($jadwal_pekerja['tgl_awal']));
													}

													$tabel_jadwal	.=	'<td style="vertical-align: middle; border: 1px solid black; white-space: nowrap; text-align: center;">'.$tanggal_jadwal.'</td>';
												}
												elseif ( $jadwal_pekerja['tahapan'] == $jadwal['tahapan'] )
												{
													$tabel_jadwal	.=	'<td> - </td>';
												}
										}
									}
								}

								$tabel_jadwal	.=	'</tr>';

								$indeks_pekerja_ojt++;
							}

							$tabel_jadwal 	.=	'	
													</table>
													<br/>
													<table style="width: 100%">
													<tbody>
													<tr>
														<td style="text-align: center; width: 50%">
														</td>
														<td style="text-align: center; width: 50%">
															Yogyakarta, '.$tanggal_cetak.'
															<br>
															<br>
															<br>
															<br>
															<b style="text-decoration-line: underline;">Eka Yuana</b><br>
															<strong></strong>People Development
														</td>
													</tr>
													</tbody>
													</table>
												';
					//	}

					$variabel_format 	=	array
											(
												'[tabel_daftar_atasan]',
												'[periode_daftar_pekerja_ojt_awal]',
												'[periode_daftar_pekerja_ojt_akhir]',
												'[tanggal_cetak]',
											);

					$variabel_ubah		=	array
											(
												$tabel_daftar_atasan,
												$periode_awal,
												$periode_akhir,
												$tanggal_cetak,
											);

					$format 								=	str_replace($variabel_format, $variabel_ubah, $format);
					$data['isi_memo_jadwal_training']		=	$format;
					$data['isi_lampiran_jadwal_training']	=	$tabel_jadwal;
				}

				echo json_encode($data);
			}
	//	}
}