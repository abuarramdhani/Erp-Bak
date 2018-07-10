<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CetakUndangan extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');
		$this->load->library('pdf');

		$this->load->model('SystemAdministration/MainMenu/M_user');
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

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Undangan', 'Cetak', 'Undangan');

		$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->undangan_cetak();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_CetakUndangan_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$this->form_validation->set_rules('cmbFormatUndangan', 'Jenis Undangan', 'required');
		$this->form_validation->set_rules('cmbPekerjaOJT', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('txaIsiUndangan', 'Undangan', 'required');
		$this->form_validation->set_rules('numLebarKertas', 'Lebar Kertas', 'required');
		$this->form_validation->set_rules('numTinggiKertas', 'Tinggi Kertas', 'required');
		$this->form_validation->set_rules('numBatasTepiAtas', 'Batas Tepi Atas', 'required');
		$this->form_validation->set_rules('numBatasTepiBawah', 'Batas Tepi Bawah', 'required');
		$this->form_validation->set_rules('numBatasTepiKiri', 'Batas Tepi Kiri', 'required');
		$this->form_validation->set_rules('numBatasTepiKanan', 'Batas Tepi Kanan', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Undangan', 'Cetak', 'Undangan');

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_CetakUndangan_Create',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$id_undangan 				=	$this->input->post('cmbFormatUndangan');
			$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
			$id_proses 					=	$this->input->post('cmbTahapanOJT');
			$undangan 					=	$this->input->post('txaIsiUndangan');
			$lebar_kertas 				=	$this->input->post('numLebarKertas');
			$tinggi_kertas 				=	$this->input->post('numTinggiKertas');
			$margin_atas 				=	$this->input->post('numBatasTepiAtas');
			$margin_bawah 				=	$this->input->post('numBatasTepiBawah');
			$margin_kiri 				=	$this->input->post('numBatasTepiKiri');
			$margin_kanan 				=	$this->input->post('numBatasTepiKanan');

			$create_undangan 		=	array
										(
											'id_undangan'			=>	$id_undangan,
											'id_pekerja' 			=>	$id_pekerja,
											'id_proses' 			=>	$id_proses,
											'undangan'				=>	$undangan,
											'lebar_kertas' 			=>	$lebar_kertas,
											'tinggi_kertas' 		=>	$tinggi_kertas,
											'margin_atas' 			=>	$margin_atas,
											'margin_bawah'			=>	$margin_bawah,
											'margin_kiri'			=>	$margin_kiri,
											'margin_kanan' 			=>	$margin_kanan,
											'create_timestamp'		=>	$execution_timestamp,
											'create_user'			=>	$user,
										);
			$id_proses_undangan 	=	$this->M_cetakundangan->create($create_undangan);

			$this->monitoringojt->ojt_history('ojt', 'tb_proses_undangan', array('id_proses_undangan =' => $id_proses_undangan), 'CREATE');
			redirect('OnJobTraining/CetakUndangan');
		}
	}

	public function export_pdf($id_proses_undangan)
	{
		$id_proses_undangan_decode 	= $this->general->dekripsi($id_proses_undangan);

		$undangan_pdf		=	$this->M_cetakundangan->export_pdf($id_proses_undangan_decode);

		$tanggal_proses 	=	'';
		if ( strtotime($undangan_pdf[0]['tgl_akhir']) > strtotime($undangan_pdf[0]['tgl_awal']))
		{
			$tanggal_proses 	=	date('Ymd', strtotime($undangan_pdf[0]['tgl_awal'])).date('Ymd', strtotime($undangan_pdf[0]['tgl_akhir']));
		}
		else
		{
			$tanggal_proses 	=	date('Ymd', strtotime($undangan_pdf[0]['tgl_awal']));	
		}

		$pdf 	=	$this->pdf->load();
		$pdf 	=	new 	mPDF
							(
								'utf-8', 
								array
								(
									$undangan_pdf[0]['lebar_kertas'],
									$undangan_pdf[0]['tinggi_kertas']
								), 
								8, 
								"", 
								$undangan_pdf[0]['margin_kiri'], 
								$undangan_pdf[0]['margin_kanan'], 
								$undangan_pdf[0]['margin_atas'], 
								$undangan_pdf[0]['margin_bawah'], 
								0, 
								0, 
								'P');
		$filename	=	'MonitoringOJT_'.$undangan_pdf[0]['judul'].'_'.$tanggal_proses.'_'.$undangan_pdf[0]['noind'].'-'.$undangan_pdf[0]['nama_pekerja_ojt'].date('Ymd').'.pdf';			
		$pdf->AddPage();
		$pdf->WriteHTML($undangan_pdf[0]['undangan']);

		$pdf->Output($filename, 'I');
	}

	public function update($id_proses_undangan)
	{
		$this->form_validation->set_rules('cmbFormatUndangan', 'Jenis Undangan', 'required');
		$this->form_validation->set_rules('cmbPekerjaOJT', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('txaIsiUndangan', 'Undangan', 'required');
		$this->form_validation->set_rules('numLebarKertas', 'Lebar Kertas', 'required');
		$this->form_validation->set_rules('numTinggiKertas', 'Tinggi Kertas', 'required');
		$this->form_validation->set_rules('numBatasTepiAtas', 'Batas Tepi Atas', 'required');
		$this->form_validation->set_rules('numBatasTepiBawah', 'Batas Tepi Bawah', 'required');
		$this->form_validation->set_rules('numBatasTepiKiri', 'Batas Tepi Kiri', 'required');
		$this->form_validation->set_rules('numBatasTepiKanan', 'Batas Tepi Kanan', 'required');

		$id_proses_undangan_decode 	= $this->general->dekripsi($id_proses_undangan);

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Undangan', 'Cetak', 'Undangan');

			$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->undangan_cetak($id_proses_undangan_decode);
			$data['id']							=	$id_proses_undangan;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_CetakUndangan_Update',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$id_undangan 				=	$this->input->post('cmbFormatUndangan');
			$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
			$id_proses 					=	$this->input->post('cmbTahapanOJT');
			$undangan 					=	$this->input->post('txaIsiUndangan');
			$lebar_kertas 				=	$this->input->post('numLebarKertas');
			$tinggi_kertas 				=	$this->input->post('numTinggiKertas');
			$margin_atas 				=	$this->input->post('numBatasTepiAtas');
			$margin_bawah 				=	$this->input->post('numBatasTepiBawah');
			$margin_kiri 				=	$this->input->post('numBatasTepiKiri');
			$margin_kanan 				=	$this->input->post('numBatasTepiKanan');

			$create_undangan 		=	array
										(
											'id_undangan'			=>	$id_undangan,
											'id_pekerja' 			=>	$id_pekerja,
											'id_proses' 			=>	$id_proses,
											'undangan'				=>	$undangan,
											'lebar_kertas' 			=>	$lebar_kertas,
											'tinggi_kertas' 		=>	$tinggi_kertas,
											'margin_atas' 			=>	$margin_atas,
											'margin_bawah'			=>	$margin_bawah,
											'margin_kiri'			=>	$margin_kiri,
											'margin_kanan' 			=>	$margin_kanan,
											'create_timestamp'		=>	$execution_timestamp,
											'create_user'			=>	$user,
										);
			$id_proses_undangan 	=	$this->M_cetakundangan->update($create_undangan, $id_proses_undangan_decode);

			$this->monitoringojt->ojt_history('ojt', 'tb_proses_undangan', array('id_proses_undangan =' => $id_proses_undangan_decode), 'UPDATE');
			redirect('OnJobTraining/CetakUndangan');
		}
	}

	public function delete($id_undangan)
	{
		$id_undangan_decode = $this->general->dekripsi($id_undangan);

		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$this->M_cetakundangan->delete($id_undangan_decode);

		$this->monitoringojt->ojt_history('ojt', 'tb_master_undangan', array('id_undangan =' => $id_undangan_decode), 'DELETE');
		redirect('OnJobTraining/CetakUndangan');
	}

	//	Javascript Functions
	//	{
			public function daftar_format_undangan()
			{
				$keyword 			=	strtoupper($this->input->get('term'));
				$daftarAtasan 		=	$this->M_cetakundangan->daftar_format_undangan($keyword);
				echo json_encode($daftarAtasan);
			}

			public function isi_undangan()
			{
				
				$data['isi_undangan'] 	=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';

				$id_undangan 			=	$this->input->post('cmbFormatUndangan');
				$id_pekerja 			=	$this->input->post('cmbPekerjaOJT');
				$id_proses 				=	$this->input->post('cmbTahapanOJT');


				if ( !( empty($id_undangan) AND empty($id_pekerja) ) )
				{
					$format_undangan 	=	$this->M_masterundangan->undangan($id_undangan);
					$info_pekerja 		=	$this->M_monitoring->ambilTabelDaftarPekerjaOJT($id_pekerja);
					$proses_ojt 		=	$this->M_monitoring->tahapan_pekerja_ojt(FALSE, FALSE, $id_proses);

					$format 				=	$format_undangan[0]['undangan'];
					$tanggal_awal_proses	=	$proses_ojt[0]['tgl_awal'];
					$tanggal_akhir_proses 	=	$proses_ojt[0]['tgl_akhir'];

					foreach ($info_pekerja as $pekerja)
					{
						$nama_pekerja_ojt 			=	$pekerja['nama_pekerja_ojt'];
						$nomor_induk_pekerja_ojt	=	$pekerja['nomor_induk_pekerja_ojt'];
						$seksi_pekerja_ojt 			=	$pekerja['seksi_pekerja_ojt'];
						$nama_atasan_pekerja 		=	$pekerja['nama_atasan_pekerja'];
						$nomor_induk_atasan_pekerja	=	$pekerja['nomor_induk_atasan_pekerja'];
						$hari_tanggal_proses 		=	'';
						$tanggal_cetak 				=	date('d F Y');

						$jabatan_atasan 			=	'';
						$jabatan_atasan_pekerja 	=	$this->M_email->jabatan_atasan_pekerja($nomor_induk_pekerja_ojt);
						for ($i=0; $i < count($jabatan_atasan_pekerja); $i++)
						{ 
							$jabatan_atasan 		.=	$jabatan_atasan_pekerja[$i]['jabatan'];
							if ( count($jabatan_atasan_pekerja) > 1 AND $i < (count($jabatan_atasan_pekerja)-1) )
							{
								$jabatan_atasan 	.=	'<br/>';
							}
						}

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

						if ( strtotime($tanggal_akhir_proses) > strtotime($tanggal_awal_proses) )
						{
							$hari_tanggal_proses 	=	date('l', strtotime($tanggal_awal_proses)).", ".date('d F Y', strtotime($tanggal_awal_proses))." s.d. ".date('l', strtotime($tanggal_akhir_proses)).", ".date('d F Y', strtotime($tanggal_akhir_proses));
						}
						else
						{
							$hari_tanggal_proses 	=	date('l', strtotime($tanggal_awal_proses)).", ".date('d F Y', strtotime($tanggal_awal_proses));
						}
						
						$tanggal_cetak 			=	str_replace($bulan_en, $bulan_id, $tanggal_cetak);
						$hari_tanggal_proses 	=	str_replace($bulan_en, $bulan_id, $hari_tanggal_proses);
						$hari_tanggal_proses 	=	str_replace($nama_hari_en, $nama_hari_id, $hari_tanggal_proses);						

						$variabel_format 	=	array
												(
													'[nama_atasan_pekerja]',
													'[jabatan_atasan_pekerja]',
													'[nomor_induk_pekerja_ojt]',
													'[nama_pekerja_ojt]',
													'[seksi_pekerja_ojt]',
												 	'[hari_tanggal_proses]',
												 	'[tanggal_cetak]',
												);

						$variabel_ubah		=	array
												(
													$nama_atasan_pekerja,
													$jabatan_atasan,
													$nomor_induk_pekerja_ojt,
													$nama_pekerja_ojt,
													$seksi_pekerja_ojt,
													$hari_tanggal_proses,
													$tanggal_cetak,
												);

						$format 				=	str_replace($variabel_format, $variabel_ubah, $format);
						$data['isi_undangan']	=	$format;
					}
				}

				echo json_encode($data);
			}
	//	}
}