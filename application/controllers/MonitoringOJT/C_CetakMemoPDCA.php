<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CetakMemoPDCA extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');
		$this->load->library('pdf');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_cetakmemopdca');
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

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Pelaksanaan PDCA', 'Cetak', 'Memo Pelaksanaan PDCA');

		$data['daftar_cetak_memo_pdca']		=	$this->M_cetakmemopdca->cetak_memo_pdca();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_CetakMemoPDCA_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$this->form_validation->set_rules('cmbPekerjaOJT', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('txaIsiMemoPDCA', 'Memo', 'required');
		$this->form_validation->set_rules('txtTanggalPDCA[]', 'Tanggal PDCA 1', 'required');
		$this->form_validation->set_rules('numLebarKertas', 'Lebar Kertas', 'required');
		$this->form_validation->set_rules('numTinggiKertas', 'Tinggi Kertas', 'required');
		$this->form_validation->set_rules('numBatasTepiAtas', 'Batas Tepi Atas', 'required');
		$this->form_validation->set_rules('numBatasTepiBawah', 'Batas Tepi Bawah', 'required');
		$this->form_validation->set_rules('numBatasTepiKiri', 'Batas Tepi Kiri', 'required');
		$this->form_validation->set_rules('numBatasTepiKanan', 'Batas Tepi Kanan', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Pelaksanaan PDCA', 'Cetak', 'Memo Pelaksanaan PDCA');

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_CetakMemoPDCA_Create',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
			$memo 						=	$this->input->post('txaIsiMemoPDCA');
			$proses_pdca 				=	$this->input->post('txtTanggalPDCA');
			$lebar_kertas 				=	$this->input->post('numLebarKertas', TRUE);
			$tinggi_kertas 				=	$this->input->post('numTinggiKertas', TRUE);
			$margin_atas 				=	$this->input->post('numBatasTepiAtas', TRUE);
			$margin_bawah 				=	$this->input->post('numBatasTepiBawah', TRUE);
			$margin_kiri 				=	$this->input->post('numBatasTepiKiri', TRUE);
			$margin_kanan 				=	$this->input->post('numBatasTepiKanan', TRUE);

			$create_memo_pdca 			=	array
											(
												'id_pekerja'				=>	$id_pekerja,
												'memo'						=>	$memo,
												'lebar_kertas'				=>	$lebar_kertas,
												'tinggi_kertas'				=>	$tinggi_kertas,
												'margin_atas'				=>	$margin_atas,
												'margin_bawah'				=>	$margin_bawah,
												'margin_kiri'				=>	$margin_kiri,
												'margin_kanan'				=>	$margin_kanan,
												'create_timestamp'			=>	$execution_timestamp,
												'create_user'				=>	$user,
											);
			$id_proses_memo_pdca =	$this->M_cetakmemopdca->create_memo_pdca($create_memo_pdca);
			$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca', array('id_proses_memo_pdca =' => $id_proses_memo_pdca), 'CREATE');

			foreach ($proses_pdca as $prosespdca)
			{
				$create_memo_pdca_ref 	=	array
														(
															'id_proses_memo_pdca'	=>	$id_proses_memo_pdca,
															'id_proses'				=>	$prosespdca,
															'create_timestamp'		=>	$execution_timestamp,
															'create_user'			=>	$user,
														);
				$id_proses_memo_pdca_ref	=	$this->M_cetakmemopdca->create_memo_pdca_ref($create_memo_pdca_ref);
				$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca_ref', array('id_proses_memo_pdca_ref =' => $id_proses_memo_pdca_ref), 'CREATE');
			}
			redirect('OnJobTraining/CetakMemoPDCA');
		}
	}

	public function export_pdf($id_proses_memo_pdca)
	{
		$id_proses_memo_pdca_decode 	= $this->general->dekripsi($id_proses_memo_pdca);

		$memo_pdf		=	$this->M_cetakmemopdca->cetak_memo_pdca($id_proses_memo_pdca_decode);

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
								'P'
							);
		$filename	=	'MonitoringOJT_'.'MemoPDCA'.'_'.$memo_pdf['nomor_induk_pekerja_ojt'].'-'.$memo_pdf['nama_pekerja_ojt'].'_'.date('Ymd').'.pdf';			
		$pdf->AddPage();
		$pdf->WriteHTML($memo_pdf[0]['memo']);

		$pdf->Output($filename, 'I');
	}

	public function update($id_proses_memo_pdca)
	{
		$this->form_validation->set_rules('cmbPekerjaOJT', 'Pekerja OJT', 'required');
		$this->form_validation->set_rules('txaIsiMemoPDCA', 'Memo', 'required');
		$this->form_validation->set_rules('txtTanggalPDCA[]', 'Tanggal PDCA 1', 'required');
		$this->form_validation->set_rules('numLebarKertas', 'Lebar Kertas', 'required');
		$this->form_validation->set_rules('numTinggiKertas', 'Tinggi Kertas', 'required');
		$this->form_validation->set_rules('numBatasTepiAtas', 'Batas Tepi Atas', 'required');
		$this->form_validation->set_rules('numBatasTepiBawah', 'Batas Tepi Bawah', 'required');
		$this->form_validation->set_rules('numBatasTepiKiri', 'Batas Tepi Kiri', 'required');
		$this->form_validation->set_rules('numBatasTepiKanan', 'Batas Tepi Kanan', 'required');

		$id_proses_memo_pdca_decode 	=	$this->general->dekripsi($id_proses_memo_pdca);

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Pelaksanaan PDCA', 'Cetak', 'Memo Pelaksanaan PDCA');

			$data['id']							=	$id_proses_memo_pdca;
			$data['daftar_cetak_memo_pdca']		=	$this->M_cetakmemopdca->cetak_memo_pdca($id_proses_memo_pdca_decode);
			$data['daftar_cetak_memo_pdca_ref']	=	$this->M_cetakmemopdca->cetak_memo_pdca_ref($id_proses_memo_pdca_decode);			

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_CetakMemoPDCA_Update',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
			$memo 						=	$this->input->post('txaIsiMemoPDCA');
			$proses_pdca 				=	$this->input->post('txtTanggalPDCA');
			$lebar_kertas 				=	$this->input->post('numLebarKertas', TRUE);
			$tinggi_kertas 				=	$this->input->post('numTinggiKertas', TRUE);
			$margin_atas 				=	$this->input->post('numBatasTepiAtas', TRUE);
			$margin_bawah 				=	$this->input->post('numBatasTepiBawah', TRUE);
			$margin_kiri 				=	$this->input->post('numBatasTepiKiri', TRUE);
			$margin_kanan 				=	$this->input->post('numBatasTepiKanan', TRUE);

			$update_memo_pdca 			=	array
											(
												'id_pekerja'				=>	$id_pekerja,
												'memo'						=>	$memo,
												'lebar_kertas'				=>	$lebar_kertas,
												'tinggi_kertas'				=>	$tinggi_kertas,
												'margin_atas'				=>	$margin_atas,
												'margin_bawah'				=>	$margin_bawah,
												'margin_kiri'				=>	$margin_kiri,
												'margin_kanan'				=>	$margin_kanan,
												'create_timestamp'			=>	$execution_timestamp,
												'create_user'				=>	$user,
											);
			$this->M_cetakmemopdca->update_memo_pdca($update_memo_pdca, $id_proses_memo_pdca_decode);
			$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca', array('id_proses_memo_pdca =' => $id_proses_memo_pdca_decode), 'UPDATE');

			$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca_ref', array('id_proses_memo_pdca =' => $id_proses_memo_pdca_decode), 'DELETE');
			$this->M_cetakmemopdca->delete_memo_pdca_ref($id_proses_memo_pdca_decode);

			foreach ($proses_pdca as $prosespdca)
			{
				$create_memo_pdca_ref 	=	array
														(
															'id_proses_memo_pdca'	=>	$id_proses_memo_pdca_decode,
															'id_proses'				=>	$prosespdca,
															'create_timestamp'		=>	$execution_timestamp,
															'create_user'			=>	$user,
														);
				$id_proses_memo_pdca_ref	=	$this->M_cetakmemopdca->create_memo_pdca_ref($create_memo_pdca_ref);
				$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca_ref', array('id_proses_memo_pdca_ref =' => $id_proses_memo_pdca_ref), 'CREATE');
			}
			redirect('OnJobTraining/CetakMemoPDCA');
		}
	}

	public function delete($id_proses_memo_pdca)
	{
		$id_proses_memo_pdca_decode 	=	$this->general->dekripsi($id_proses_memo_pdca);

		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca_ref', array('id_proses_memo_pdca =' => $id_proses_memo_pdca_decode), 'DELETE');
		$this->monitoringojt->ojt_history('ojt', 'tb_proses_memo_pdca', array('id_proses_memo_pdca =' => $id_proses_memo_pdca_decode), 'DELETE');
		$this->M_cetakmemopdca->delete_memo_pdca_ref($id_proses_memo_pdca_decode);
		$this->M_cetakmemopdca->delete_memo_pdca($id_proses_memo_pdca_decode);
		redirect('OnJobTraining/CetakMemoPDCA');
	}

	//	Javascript Functions
	//	{
			public function proses_ojt_pekerja()
			{
				$keyword 				=	strtoupper($this->input->get('term'));
				$id_pekerja 			=	$this->input->get('id_pekerja');
				$proses_ojt_pekerja 	=	$this->M_cetakmemopdca->proses_ojt_pekerja($id_pekerja, $keyword);
				echo json_encode($proses_ojt_pekerja);
			}

			public function isi_memo_pdca()
			{
				$data['isi_memo_pdca'] 		=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';
				$id_pekerja 			=	$this->input->post('cmbPekerjaOJT');
				$tanggal_pdca 			=	$this->input->post('txtTanggalPDCA');
				$tanggal_cetak 			=	date('d F Y');

				if ( $id_pekerja !== FALSE )
				{
					$format_memo 		=	$this->M_cetakmemopdca->format('PDCA');

					$format 				=	$format_memo[0]['memo'];

					$nama_pekerja_ojt			=	'';
					$nomor_induk_pekerja_ojt	=	'';
					$seksi_pekerja_ojt 			=	'';
					$tanggal_awal_orientasi_ojt	=	'';
					$tanggal_akhir_orientasi_ojt=	'';

					$detail_pekerja_ojt		=	$this->M_cetakmemopdca->detail_pekerja_ojt($id_pekerja);
					foreach ($detail_pekerja_ojt as $detail)
					{
						$nama_pekerja_ojt 			=	$detail['nama_pekerja_ojt'];
						$nomor_induk_pekerja_ojt	=	$detail['nomor_induk_pekerja_ojt'];
						$seksi_pekerja_ojt			=	$detail['seksi_pekerja_ojt'];
						$tanggal_awal_orientasi_ojt =	date('d-m-Y', strtotime($detail['tgl_awal']));
						$tanggal_akhir_orientasi_ojt=	date('d-m-Y', strtotime($detail['tgl_akhir']));
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

					$tanggal_cetak 			=	str_replace($bulan_en, $bulan_id, $tanggal_cetak);

					$proses_ojt 	=	$this->M_cetakmemopdca->proses_ojt_pekerja($id_pekerja, FALSE, $tanggal_pdca);
					$proses 		= 	array();

					$variabel_format 	=	array
											(
												'[nama_pekerja_ojt]',
												'[nomor_induk_pekerja_ojt]',
												'[seksi_pekerja_ojt]',
												'[tanggal_awal_orientasi_ojt]',
												'[tanggal_akhir_orientasi_ojt]',
												'[tanggal_cetak]',
											);

					$variabel_ubah		=	array
											(
												$nama_pekerja_ojt,
												$nomor_induk_pekerja_ojt,
												$seksi_pekerja_ojt,
												$tanggal_awal_orientasi_ojt,
												$tanggal_akhir_orientasi_ojt,
												$tanggal_cetak,
											);

					$indeks 	=	0;
					foreach ($proses_ojt as $ojt)
					{
						if ( strtotime($ojt['tgl_akhir']) > strtotime($ojt['tgl_awal']) )
						{
							$tanggal 	=	date('d-m-Y', strtotime($ojt['tgl_awal'])).' s.d. '.date('d-m-Y', strtotime($ojt['tgl_akhir']));
						}
						else
						{
							$tanggal 	=	date('d-m-Y', strtotime($ojt['tgl_awal']));
						}

						$variabel_format[]	=	'[tanggal_pdca_'.($indeks+1).']';
						$variabel_ubah[]	=	$tanggal;

						$indeks++;
					}

					$format 								=	str_replace($variabel_format, $variabel_ubah, $format);
					$data['isi_memo_pdca'] 					=	$format;
				}
				echo json_encode($data);
			}
	//	}
}