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
		$this->load->model('MonitoringOJT/M_cetakmemojadwaltraining');

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

			//------------Memo Pindah Lokasi Makan------------//

			public function index_PindahMakan()
			{

				$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Pindah Lokasi Makan', 'Cetak', 'Memo Pindah Makan');

				$data['tampil_memo'] = $this->M_cetakmemojadwaltraining->tampilData();

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('MonitoringOJT/V_CetakMemoPindahMakan_Index',$data);
				$this->load->view('V_Footer',$data);
			}

			public function create_MemoPindahMakan()
			{
				$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Memo Pindah Lokasi Makan', 'Cetak', 'Memo Pindah Makan');
				$today = date('Y-m-d');

				$data['pdev'] = $this->M_cetakmemojadwaltraining->getPdev();

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('MonitoringOJT/V_CetakMemoPindahMakan_Create',$data);
				$this->load->view('V_Footer',$data);
			}

			public function isi_PindahMakan()
			{
				$training			= $this->input->post('ojt_jenis');
				$id_pekerja 	=	$this->input->post('cmbPekerjaOJT');
				$periode 			=	$this->input->post('txtPeriode');
				$nomor				= $this->input->post('txtNoMemo');
				$lokasi				= $this->input->post('txtRuangTraining');
				$tertanda			= $this->input->post('cmbtertandaOJT');

				if (!empty($training) && !empty($periode) && !empty($nomor) && !empty($lokasi) && !empty($tertanda)) {
					$pisah = explode(" - ", $periode);
					$periode_awal = $pisah[0];
					$pisahperiode1 = explode("-", $periode_awal);
					$tgl_awal	= $pisahperiode1[2];
					$bln_awal	= $pisahperiode1[1];
					$thn_awal	= $pisahperiode1[0];

					$periode_akhir = $pisah[1];
					$pisahperiode2 = explode("-", $periode_akhir);
					$tgl_akhir = $pisahperiode2[2];
					$bln_akhir = $pisahperiode2[1];
					$thn_akhir = $pisahperiode2[0];

					$hari_awal	= date("l", strtotime($periode_awal));
					$hari_akhir = date("l", strtotime($periode_akhir));
					$hari_default = array(
						'',
						'Senin',
						'Selasa',
						'Rabu',
						'Kamis',
						'Jumat',
						'Sabtu',
						'Minggu',
					);
					if ($hari_awal == 'Monday') {
						$hari_awal = $hari_default[1];
					}elseif ($hari_awal == 'Tuesday') {
						$hari_awal = $hari_default[2];
					}elseif ($hari_awal == 'Wednesday') {
						$hari_awal = $hari_default[3];
					}elseif ($hari_awal == 'Thursday') {
						$hari_awal = $hari_default[4];
					}elseif ($hari_awal == 'Friday') {
						$hari_awal = $hari_default[5];
					}elseif ($hari_awal == 'Saturday') {
						$hari_awal = $hari_default[6];
					}elseif ($hari_awal == 'Sunday') {
						$hari_awal = $hari_default[7];
					}

					if ($hari_akhir == 'Monday') {
						$hari_akhir = $hari_default[1];
					}elseif ($hari_akhir == 'Tuesday') {
						$hari_akhir = $hari_default[2];
					}elseif ($hari_akhir == 'Wednesday') {
						$hari_akhir = $hari_default[3];
					}elseif ($hari_akhir == 'Thursday') {
						$hari_akhir = $hari_default[4];
					}elseif ($hari_akhir == 'Friday') {
						$hari_akhir = $hari_default[5];
					}elseif ($hari_akhir == 'Saturday') {
						$hari_akhir = $hari_default[6];
					}elseif ($hari_akhir == 'Sunday') {
						$hari_akhir = $hari_default[7];
					}

					$bulan = array(
					"",
					"Januari",
					"Februari",
					"Maret",
					"April",
					"Mei",
					"Juni",
					"Juli",
					"Agustus",
					"September",
					"Oktober",
					"November",
					"Desember"
					);
					if ($bln_awal == '01') {
						$month = $bulan[1];
					}elseif ($bln_awal == '02') {
						$month = $bulan[2];
					}elseif ($bln_awal == '03') {
						$month = $bulan[3];
					}elseif ($bln_awal == '04') {
						$month = $bulan[4];
					}elseif ($bln_awal == '05') {
						$month = $bulan[5];
					}elseif ($bln_awal == '06') {
						$month = $bulan[6];
					}elseif ($bln_awal == '07') {
						$month = $bulan[7];
					}elseif ($bln_awal == '08') {
						$month = $bulan[8];
					}elseif ($bln_awal == '09') {
						$month = $bulan[9];
					}elseif ($bln_awal == '10') {
						$month = $bulan[10];
					}elseif ($bln_awal == '11') {
						$month = $bulan[11];
					}elseif ($bln_awal == '12') {
						$month = $bulan[12];
					}

					if ($bln_akhir == '01') {
						$month_akhir = $bulan[1];
					}elseif ($bln_akhir == '02') {
						$month_akhir = $bulan[2];
					}elseif ($bln_akhir == '03') {
						$month_akhir = $bulan[3];
					}elseif ($bln_akhir == '04') {
						$month_akhir = $bulan[4];
					}elseif ($bln_akhir == '05') {
						$month_akhir = $bulan[5];
					}elseif ($bln_akhir == '06') {
						$month_akhir = $bulan[6];
					}elseif ($bln_akhir == '07') {
						$month_akhir = $bulan[7];
					}elseif ($bln_akhir == '08') {
						$month_akhir = $bulan[8];
					}elseif ($bln_akhir == '09') {
						$month_akhir = $bulan[9];
					}elseif ($bln_akhir == '10') {
						$month_akhir = $bulan[10];
					}elseif ($bln_akhir == '11') {
						$month_akhir = $bulan[11];
					}elseif ($bln_akhir == '12') {
						$month_akhir = $bulan[12];
					}

					$month_tertanda = date('m');

					if ($month_tertanda == '01') {
						$bulan_tertanda = $bulan[1];
					}elseif ($month_tertanda == '02') {
						$bulan_tertanda = $bulan[2];
					}elseif ($month_tertanda == '03') {
						$bulan_tertanda = $bulan[3];
					}elseif ($month_tertanda == '04') {
						$bulan_tertanda = $bulan[4];
					}elseif ($month_tertanda == '05') {
						$bulan_tertanda = $bulan[5];
					}elseif ($month_tertanda == '06') {
						$bulan_tertanda = $bulan[6];
					}elseif ($month_tertanda == '07') {
						$bulan_tertanda = $bulan[7];
					}elseif ($month_tertanda == '08') {
						$bulan_tertanda = $bulan[8];
					}elseif ($month_tertanda == '09') {
						$bulan_tertanda = $bulan[9];
					}elseif ($month_tertanda == '10') {
						$bulan_tertanda = $bulan[10];
					}elseif ($month_tertanda == '11') {
						$bulan_tertanda = $bulan[11];
					}elseif ($month_tertanda == '12') {
						$bulan_tertanda = $bulan[12];
					}

					if ($training == 'Training Public Speaking') {
						$jenis_training		= 'PUBLIC SPEAKING';
						$hari_training 		= $hari_awal;
						$tanggal_training = $tgl_awal." ".$month." ".$thn_awal;
						$rentang 					= "1";
					}elseif ($training == 'Training PDCA & A3 Report') {
						$jenis_training		= 'TRAINING PDCA';
						$hari_training = $hari_awal." - ".$hari_akhir;
						if ($month == $month_akhir) {
							$tanggal_training = $tgl_awal." - ".$tgl_akhir." ".$month." ".$thn_akhir;
						}elseif ($month != $month_akhir) {
							$tanggal_training = $tgl_awal." ".$month." ".$thn_awal." - ".$tgl_akhir." ".$month_akhir." ".$thn_akhir;
						}
						$rentang = "3";
					}

					$data_peserta = $this->M_cetakmemojadwaltraining->getPekerjaTraining($jenis_training, $periode_awal, $periode_akhir);

					$no_unik = 1;
					$tabelnew = '<table style="width: 90%; border: 1px solid black; border-collapse: collapse; text-align: center; margin-left: 10%;">
												<tbody>
												<tr>
													<td style="text-align: center; width:4%; border: 1px solid black; background-color: grey;">
														<strong>
														NO
														</strong>
													</td>
													<td style="text-align: center; width: 11%; border: 1px solid black; background-color: grey;">
														<strong>
														NO<br>
														INDUK
														</strong>
													</td>
													<td style="text-align: center; width: 35%; border: 1px solid black; background-color: grey;">
														<strong>
														NAMA
														</strong>
													</td>
													<td style="text-align: center; width: 40%; border: 1px solid black; background-color: grey;">
														<strong>
														SEKSI
														</strong>
													</td>
												</tr>';
					foreach ($data_peserta as $key) {
						$tabelnew .= "<tr><td style='text-align: center; border: 1px solid black;'>{$no_unik}</td><td style='text-align: center; border: 1px solid black;'>{$key['noind']}</td><td style='text-align: center; border: 1px solid black;'>{$key['employee_name']}</td><td style='text-align: center; border: 1px solid black;'>{$key['section_name']}</td></tr>";
						$no_unik++;
					}
					$tabelnew .= "</tbody></table>";

					$templateMemo = $this->M_cetakmemojadwaltraining->getTemplate();
					$templateMemo = $templateMemo[0]['memo'];
					$parameter_diubah = array
															(
																'[tabel_list_peserta]',
																'[no_memo]',
																'[jenis_training]',
																'[hari_training]',
																'[tgl_training]',
																'[ruang_training]',
																'[jml_hari]',
																'[tgl_cetak]',
																'[perwakilan_pdev]'
															);
					$parameter_replace = array
															(
																$tabelnew,
																$nomor,
																$training,
																$hari_training,
																$tanggal_training,
																$lokasi,
																$rentang,
																date('d')." ".$bulan_tertanda." ".date('Y'),
																$tertanda
															);

					$cetakTemplate = str_replace($parameter_diubah, $parameter_replace, $templateMemo);
					$data['isi_memopindahmakan']	=	$cetakTemplate;
				}else{
					$data['isi_memopindahmakan'] 	=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';
				}

				echo json_encode($data);
			}

			public function saveMemoPindahMakan()
			{
				$user 					= $this->session->user;
				$eksekusi 			= date('Y-m-d H:i:s');
				$periode 				=	$this->input->post('txtPeriode');
				$memo						= $this->input->post('txaIsiMemoPindahMakan');
				$lebar					= $this->input->post('numLebarKertas');
				$tinggi					= $this->input->post('numTinggiKertas');
				$margin_atas		= $this->input->post('numBatasTepiAtas');
				$margin_bawah		= $this->input->post('numBatasTepiBawah');
				$margin_kanan		= $this->input->post('numBatasTepiKanan');
				$margin_kiri		= $this->input->post('numBatasTepiKiri');
				$jenis					= $this->input->post('ojt_jenis');
				$nomor					= $this->input->post('txtNoMemo');
				$ruang					= $this->input->post('txtRuangTraining');
				$tertanda				= $this->input->post('cmbtertandaOJT');

				$periode1				= explode(" - ", $periode);
				$periode_awal 	= $periode1[0];
				$periode_akhir 	= $periode1[1];

				if ($periode_awal == $periode_akhir) {
					$save_period = $periode_awal;
				}elseif ($periode_awal != $periode_akhir) {
					$save_period = $periode;
				}

				$saveMemo = array
										(
											'periode_memo' 			=> $save_period,
											'memo' 							=> $memo,
											'lebar_kertas' 			=> $lebar,
											'tinggi_kertas'			=> $tinggi,
											'margin_atas' 			=> $margin_atas,
											'margin_bawah' 			=> $margin_bawah,
											'margin_kanan' 			=> $margin_kanan,
											'margin_kiri' 			=> $margin_kiri,
											'last_update_date'	=> $eksekusi,
											'last_update_user'	=> $user,
											'create_date' 			=> $eksekusi,
											'create_user' 			=> $user,
											'jenis_memo'				=> $jenis,
											'no_memo'						=> $nomor,
											'ruang_training'		=> $ruang,
											'tertanda'					=> $tertanda,
										);
				$proses_memo = $this->M_cetakmemojadwaltraining->saveMemo($saveMemo);

				$max = $this->M_cetakmemojadwaltraining->getmaxid();
				$saveHistory = array
											(
												'id_memo' 					=> $max,
												'periode_memo' 			=> $save_period,
												'memo' 							=> $memo,
												'lebar_kertas' 			=> $lebar,
												'tinggi_kertas'			=> $tinggi,
												'margin_atas' 			=> $margin_atas,
												'margin_bawah' 			=> $margin_bawah,
												'margin_kanan' 			=> $margin_kanan,
												'margin_kiri' 			=> $margin_kiri,
												'last_update_date'	=> $eksekusi,
												'last_update_user'	=> $user,
												'create_date' 			=> $eksekusi,
												'create_user' 			=> $user,
												'jenis_memo'				=> $jenis,
												'no_memo'						=> $nomor,
												'ruang_training'		=> $ruang,
												'tertanda'					=> $tertanda,
												'history_type'			=> 'CREATE',
											);
				$proses_memo = $this->M_cetakmemojadwaltraining->saveMemoHistory($saveHistory);

				redirect('OnJobTraining/MemoPindahMakan');
			}

			public function export_pdf_memo_makan($id)
			{
				$id 	= $this->general->dekripsi($id);
				$date = date('Y-m-d');
				$data = $this->M_cetakmemojadwaltraining->getDataMemo($id);

				$pdf 	=	$this->pdf->load();
				$pdf 	=	new 	mPDF
									(
										'utf-8',
										array
										(
											$data[0]['lebar_kertas'],
											$data[0]['tinggi_kertas']
										),
										10,
										"",
										$data[0]['margin_kiri'],
										$data[0]['margin_kanan'],
										$data[0]['margin_atas'],
										$data[0]['margin_bawah'],
										0,
										0,
										'P');
				$filename	=	'Memo Pindah Lokasi Makan '." ".$date.'.pdf';
				$pdf->SetTitle('Memo Pindah Lokasi Makan '." ".$date.'.pdf');

				$pdf->WriteHTML($data[0]['memo']);

				$pdf->Output($filename, 'I');
			}

			public function updatePindahMakan($id)
			{
				$id 	= $this->general->dekripsi($id);
				$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Edit Memo Pindah Lokasi Makan', 'Cetak', 'Memo Pindah Makan');

				$data['edit_memo']				=	$this->M_cetakmemojadwaltraining->getDataMemo($id);
				$data['pdev'] 						= $this->M_cetakmemojadwaltraining->getPdev();
				$new											= $this->M_cetakmemojadwaltraining->getTertanda($id);
				$data['tertanda']					= $this->M_cetakmemojadwaltraining->getTertandaNew($new);
				$data['id']								= $id;

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('MonitoringOJT/V_CetakMemoPindahMakan_Update',$data);
				$this->load->view('V_Footer',$data);
			}

			public function saveUpdate($id)
			{
				$user 					= $this->session->user;
				$eksekusi 			= date('Y-m-d H:i:s');
				$periode 				=	$this->input->post('txtPeriode');
				$memo						= $this->input->post('txaIsiMemoPindahMakan');
				$lebar					= $this->input->post('numLebarKertas');
				$tinggi					= $this->input->post('numTinggiKertas');
				$margin_atas		= $this->input->post('numBatasTepiAtas');
				$margin_bawah		= $this->input->post('numBatasTepiBawah');
				$margin_kanan		= $this->input->post('numBatasTepiKanan');
				$margin_kiri		= $this->input->post('numBatasTepiKiri');
				$jenis					= $this->input->post('ojt_jenis');
				$nomor					= $this->input->post('txtNoMemo');
				$ruang					= $this->input->post('txtRuangTraining');
				$tertanda				= $this->input->post('cmbtertandaOJT');

				$periode1				= explode(" - ", $periode);
				$periode_awal 	= $periode1[0];
				$periode_akhir 	= $periode1[1];

				if ($periode_awal == $periode_akhir) {
					$save_period = $periode_awal;
				}elseif ($periode_awal != $periode_akhir) {
					$save_period = $periode;
				}

				$saveMemo = array
										(
											'periode_memo' 			=> $save_period,
											'memo' 							=> $memo,
											'lebar_kertas' 			=> $lebar,
											'tinggi_kertas'			=> $tinggi,
											'margin_atas' 			=> $margin_atas,
											'margin_bawah' 			=> $margin_bawah,
											'margin_kanan' 			=> $margin_kanan,
											'margin_kiri' 			=> $margin_kiri,
											'last_update_date'	=> $eksekusi,
											'jenis_memo'				=> $jenis,
											'no_memo'						=> $nomor,
											'ruang_training'		=> $ruang,
											'tertanda'					=> $tertanda,
										);
				$proses_memo = $this->M_cetakmemojadwaltraining->updateMemo($id,$saveMemo);

				$saveHistory = array
											(
												'id_memo' 					=> $id,
												'periode_memo' 			=> $save_period,
												'memo' 							=> $memo,
												'lebar_kertas' 			=> $lebar,
												'tinggi_kertas'			=> $tinggi,
												'margin_atas' 			=> $margin_atas,
												'margin_bawah' 			=> $margin_bawah,
												'margin_kanan' 			=> $margin_kanan,
												'margin_kiri' 			=> $margin_kiri,
												'last_update_date'	=> $eksekusi,
												'last_update_user'	=> $user,
												'create_date'				=> $eksekusi,
												'create_user'				=> $user,
												'jenis_memo'				=> $jenis,
												'no_memo'						=> $nomor,
												'ruang_training'		=> $ruang,
												'tertanda'					=> $tertanda,
												'history_type'			=> 'UPDATE',
											);
				$proses_memo = $this->M_cetakmemojadwaltraining->saveMemoHistory($saveHistory);

				redirect('OnJobTraining/MemoPindahMakan');
			}

			public function deleteMemo($id)
			{
				$id 	= $this->general->dekripsi($id);
				$user 					= $this->session->user;
				$eksekusi 			= date('Y-m-d H:i:s');

				$dataAll = $this->M_cetakmemojadwaltraining->getDataMemo($id);

				$saveHistory = array
											(
												'id_memo' 					=> $id,
												'periode_memo' 			=> $dataAll[0]['periode_memo'],
												'memo' 							=> $dataAll[0]['memo'],
												'lebar_kertas' 			=> $dataAll[0]['lebar_kertas'],
												'tinggi_kertas'			=> $dataAll[0]['tinggi_kertas'],
												'margin_atas' 			=> $dataAll[0]['margin_atas'],
												'margin_bawah' 			=> $dataAll[0]['margin_bawah'],
												'margin_kanan' 			=> $dataAll[0]['margin_kanan'],
												'margin_kiri' 			=> $dataAll[0]['margin_kiri'],
												'last_update_date'	=> $eksekusi,
												'last_update_user'	=> $user,
												'create_date'				=> $eksekusi,
												'create_user'				=> $user,
												'jenis_memo'				=> $dataAll[0]['jenis_memo'],
												'no_memo'						=> $dataAll[0]['no_memo'],
												'ruang_training'		=> $dataAll[0]['ruang_training'],
												'tertanda'					=> $dataAll[0]['tertanda'],
												'history_type'			=> 'DELETE',
											);
				$proses_memo = $this->M_cetakmemojadwaltraining->saveMemoHistory($saveHistory);

				$delete = $this->M_cetakmemojadwaltraining->deleteMemo($id);
				redirect('OnJobTraining/MemoPindahMakan');
			}
}
