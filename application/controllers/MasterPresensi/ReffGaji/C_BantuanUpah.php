<?php 
defined('BASEPATH') or exit("No Direct Script Access Allowed");
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
/**
 * 
 */
class C_BantuanUpah extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_bantuanupah');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged)){
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan Kebijakan Bantuan Upah Covid 19';
		$data['Menu'] 			= 	'Penggajian';
		$data['SubMenuOne'] 	= 	'Bantuan Upah Covid 19';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['record'] = $this->M_bantuanupah->getBantuanUpahAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/BantuanUpah/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Proses()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan Kebijakan Bantuan Upah Covid 19';
		$data['Menu'] 			= 	'Penggajian';
		$data['SubMenuOne'] 	= 	'Bantuan Upah Covid 19';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['hubker'] = $this->M_bantuanupah->getHubunganKerja();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/BantuanUpah/V_Proses',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Hitung()
	{
		$user = $this->session->user;
		$periode = $this->input->get('periode');
		$hubker  = $this->input->get('hubker');
		$prd 	= explode(" - ", $periode);
		$awal 	= $prd[0];
		$akhir 	= $prd[1];
		$awal_bulan_lalu = date('Y-m-01',strtotime($akhir." - 1 month"));
		$akhir_bulan_lalu = date('Y-m-d',strtotime($awal_bulan_lalu." + 1 month - 1 day"));
		
		$pekerja = $this->M_bantuanupah->getPekerja($hubker,$awal,$akhir);
		$jumlah_total = count($pekerja);
		$this->M_bantuanupah->insertProgress($user,$jumlah_total);
		$progres = 0;
		$this->M_bantuanupah->updateProgress($user,$progres,"Mempersiapkan Data");
		session_write_close();
		flush();

		$bantuanUpah = array(
			'created_by' 			=> $this->session->user,
			'periode_awal' 			=> $awal,
			'periode_akhir' 		=> $akhir,
			'status_hubungan_kerja' => !empty($hubker) ? implode(",", $hubker) : 'All'
		);
		$id_bantuan_upah = $this->M_bantuanupah->insertBantuanUpah($bantuanUpah);

		if (!empty($pekerja)) {
			foreach ($pekerja as $pkj) {
				$hasil = $this->M_bantuanupah->getHasil($pkj['noind'],$awal,$akhir);
				if (!empty($hasil)) {
					foreach ($hasil as $res) {
						$if 	= 0;
						$ip 	= 0;
						$ik 	= 0;
						$ipt 	= 0;
						$bulan_lalu = $this->M_bantuanupah->getTanggalDataPres($res['noind'],$res['alasan'],$awal_bulan_lalu,$akhir_bulan_lalu);
						if (!empty($bulan_lalu)) {
							foreach($bulan_lalu as $bl){
								$ip 	+= $this->M_bantuanupah->hitungIp($res['noind'],$bl['tanggal']);
								$ipt 	+= $this->M_bantuanupah->hitungIpt($res['noind'],$bl['tanggal']);
								$ik 	+= $this->M_bantuanupah->hitungIk($res['noind'],$bl['tanggal']);
							}
						}

						$bulan_ini = $this->M_bantuanupah->getTanggalDataPres($res['noind'],$res['alasan'],$awal,$akhir);
						if (!empty($bulan_ini)) {
							foreach($bulan_ini as $bi){
								$if 	+= $this->M_bantuanupah->hitungIf($res['noind'],$bi['tanggal']);
							}
						}

						$bantuanUpahDetail = array(
							'id_bantuan_upah' 			=> $id_bantuan_upah,
							'noind' 					=> $res['noind'], 
							'nama' 						=> $res['nama'], 
							'lokasi_kerja' 				=> $res['lokasi_kerja'],
							'kom_gp'		 			=> trim($res['gp_jumlah']) != '-' ? $res['gp_jumlah'] : null ,
							'kom_if' 					=> trim($res['if_jumlah']) != '-' ? $if : null ,
							'kom_ip'		 			=> trim($res['ip_jumlah']) != '-' ? $ip : null , 
							'kom_ipt' 					=> trim($res['ipt_jumlah']) != '-' ? $ipt : null ,
							'kom_ik' 					=> trim($res['ik_jumlah']) != '-' ? $ik : null ,
							'kom_ikr' 					=> trim($res['ikr_jumlah']) != '-' ? $ip : null ,
							'kom_ins_kepatuhan'			=> trim($res['ins_patuh_jumlah']) != '-' ? $res['ins_patuh_jumlah'] : null ,
							'kom_ins_kemahalan'			=> trim($res['ins_mahal_jumlah']) != '-' ? $res['ins_mahal_jumlah'] : null ,
							'kom_ins_penempatan'		=> trim($res['ins_tempat_jumlah']) != '-' ? $res['ins_tempat_jumlah'] : null ,
							'persen_gp'		 			=> trim($res['gp_persen']) != '-' ? 1 * str_replace("%", "", $res['gp_persen']) : null ,
							'persen_if' 				=> trim($res['if_persen']) != '-' ? 1 * str_replace("%", "", $res['if_persen']) : null ,
							'persen_ip'		 			=> trim($res['ip_persen']) != '-' ? 1 * str_replace("%", "", $res['ip_persen']) : null , 
							'persen_ipt' 				=> trim($res['ipt_persen']) != '-' ? 1 * str_replace("%", "", $res['ipt_persen']) : null ,
							'persen_ik' 				=> trim($res['ik_persen']) != '-' ? 1 * str_replace("%", "", $res['ik_persen']) : null ,
							'persen_ikr' 				=> trim($res['ikr_persen']) != '-' ? 1 * str_replace("%", "", $res['ikr_persen']) : null ,
							'persen_ins_kepatuhan'		=> trim($res['ins_patuh_persen']) != '-' ? 1 * str_replace("%", "", $res['ins_patuh_persen']) : null ,
							'persen_ins_kemahalan'		=> trim($res['ins_mahal_persen']) != '-' ? 1 * str_replace("%", "", $res['ins_mahal_persen']) : null ,
							'persen_ins_penempatan'		=> trim($res['ins_tempat_persen']) != '-' ? 1 * str_replace("%", "", $res['ins_tempat_persen']) : null ,
							'keterangan' 				=> '',
							'kategori' 					=> $res['alasan'],
							'tanggal_perhitungan_awal' 	=> $res['mulai'],
							'tanggal_perhitungan_akhir' => $res['selesai']
						);
						$this->M_bantuanupah->insertBantuanUpahDetail($bantuanUpahDetail);
					}
				}

				$progres +=1;
				$this->M_bantuanupah->updateProgress($user,$progres,'Memproses '.$pkj['noind']);
				session_write_close();
				flush();
			}
		}

		$detail = $this->M_bantuanupah->getBantuanUpahDetail($id_bantuan_upah);
		$id_encrypted = $this->encrypt->encode($id_bantuan_upah);
		$id_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encrypted);
		$result = array(
			'detail' => $detail,
			'id' => $id_encrypted
		);
		echo json_encode($result);
	}

	public function cekProgress()
	{
		$user = $this->input->get('user');
		$data = $this->M_bantuanupah->getProgress($user);
		if (!empty($data)) {
			if ($data->progress == $data->total) {
				$this->M_bantuanupah->deleteProgress($user);
			}
			$json = array(
				'progress' 		=> floor(($data->progress/$data->total)*100),
				'keterangan' 	=> $data->keterangan
			);
			echo json_encode($json);
		}else{
			echo "kosong";
		}
	}

	public function Detail($encryptedId)
	{
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encryptedId);
 		$id = $this->encrypt->decode($id);

 		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan Kebijakan Bantuan Upah Covid 19';
		$data['Menu'] 			= 	'Penggajian';
		$data['SubMenuOne'] 	= 	'Bantuan Upah Covid 19';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
 		$data['detail'] = $this->M_bantuanupah->getBantuanUpahDetail($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/BantuanUpah/V_Detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Excel($encryptedId)
	{
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encryptedId);
 		$id = $this->encrypt->decode($id);		

 		$data = $this->M_bantuanupah->getBantuanUpah($id);
 		$detail = $this->M_bantuanupah->getBantuanUpahDetail($id);

 		// echo "<pre>";
 		// print_r($detail);

 		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();

		$worksheet->setCellValue('A1','Periode');
		$worksheet->setCellValue('A2','Status Hubungan Kerja');

		$worksheet->setCellValue('C1',": ".strftime("%d %B %Y",strtotime($data->periode_awal))." s/d ".strftime("%d %B %Y",strtotime($data->periode_akhir)));
		$worksheet->setCellValue('D2',": ".$data->status_hubungan_kerja);

		$worksheet->mergeCells('A1:B1');
		$worksheet->mergeCells('A2:C2');
		$worksheet->mergeCells('C1:D1');

		$worksheet->setCellValue('A3','No.');
		$worksheet->setCellValue('B3','No. Induk');
		$worksheet->setCellValue('C3','Nama');
		$worksheet->setCellValue('D3','Tanggal Perhitungan');
		$worksheet->setCellValue('E3','Lokasi Kerja');
		$worksheet->setCellValue('F3','GP');
		$worksheet->setCellValue('H3','IF');
		$worksheet->setCellValue('J3','IP');
		$worksheet->setCellValue('L3','IPT');
		$worksheet->setCellValue('N3','IK');
		$worksheet->setCellValue('P3','IKR');
		$worksheet->setCellValue('R3','Ins. Kepatuhan');
		$worksheet->setCellValue('T3','Ins. Kemahalan');
		$worksheet->setCellValue('V3','Ins. Penempatan');
		$worksheet->setCellValue('X3','Kategori');
		$worksheet->setCellValue('Y3','Keterangan');

		$worksheet->mergeCells('A3:A4');
		$worksheet->mergeCells('B3:B4');
		$worksheet->mergeCells('C3:C4');
		$worksheet->mergeCells('D3:D4');
		$worksheet->mergeCells('E3:E4');
		$worksheet->mergeCells('F3:G3');
		$worksheet->mergeCells('H3:I3');
		$worksheet->mergeCells('J3:K3');
		$worksheet->mergeCells('L3:M3');
		$worksheet->mergeCells('N3:O3');
		$worksheet->mergeCells('P3:Q3');
		$worksheet->mergeCells('R3:S3');
		$worksheet->mergeCells('T3:U3');
		$worksheet->mergeCells('V3:W3');
		$worksheet->mergeCells('X3:X4');
		$worksheet->mergeCells('Y3:Y4');

		$worksheet->setCellValue('F4','Kom');
		$worksheet->setCellValue('G4','(%)');
		$worksheet->setCellValue('H4','Kom');
		$worksheet->setCellValue('I4','(%)');
		$worksheet->setCellValue('J4','Kom');
		$worksheet->setCellValue('K4','(%)');
		$worksheet->setCellValue('L4','Kom');
		$worksheet->setCellValue('M4','(%)');
		$worksheet->setCellValue('N4','Kom');
		$worksheet->setCellValue('O4','(%)');
		$worksheet->setCellValue('P4','Kom');
		$worksheet->setCellValue('Q4','(%)');
		$worksheet->setCellValue('R4','Kom');
		$worksheet->setCellValue('S4','(%)');
		$worksheet->setCellValue('T4','Kom');
		$worksheet->setCellValue('U4','(%)');
		$worksheet->setCellValue('V4','Kom');
		$worksheet->setCellValue('W4','(%)');

		if (isset($detail) && !empty($detail)) {
			$nomor = 1;
			$x = 5;
			foreach ($detail as $dt) {
				
				$worksheet->setCellValue('A'.$x,$nomor);
				$worksheet->setCellValue('B'.$x,$dt['noind']);
				$worksheet->setCellValue('C'.$x,$dt['nama']);
                $worksheet->setCellValue('D'.$x,$dt['tanggal_perhitungan_awal']." s/d ".$dt['tanggal_perhitungan_akhir']);
                $worksheet->setCellValue('E'.$x,$dt['lokasi_kerja']);
                $worksheet->setCellValue('F'.$x,$dt['kom_gp']);
                $worksheet->setCellValue('G'.$x,$dt['persen_gp']);
                $worksheet->setCellValue('H'.$x,$dt['kom_if']);
                $worksheet->setCellValue('I'.$x,$dt['persen_if']);
                $worksheet->setCellValue('J'.$x,$dt['kom_ip']);
                $worksheet->setCellValue('K'.$x,$dt['persen_ip']);
                $worksheet->setCellValue('L'.$x,$dt['kom_ipt']);
                $worksheet->setCellValue('M'.$x,$dt['persen_ipt']);
                $worksheet->setCellValue('N'.$x,$dt['kom_ik']);
                $worksheet->setCellValue('O'.$x,$dt['persen_ik']);
                $worksheet->setCellValue('P'.$x,$dt['kom_ikr']);
                $worksheet->setCellValue('Q'.$x,$dt['persen_ikr']);
                $worksheet->setCellValue('R'.$x,$dt['kom_ins_kepatuhan']);
                $worksheet->setCellValue('S'.$x,$dt['persen_ins_kepatuhan']);
                $worksheet->setCellValue('T'.$x,$dt['kom_ins_kemahalan']);
                $worksheet->setCellValue('U'.$x,$dt['persen_ins_kemahalan']);
                $worksheet->setCellValue('V'.$x,$dt['kom_ins_penempatan']);
                $worksheet->setCellValue('W'.$x,$dt['persen_ins_penempatan']);
                $worksheet->setCellValue('X'.$x,$dt['kategori']);
                $worksheet->setCellValue('Y'.$x,$dt['keterangan']);
			
				$nomor++;
				$x++;
			}
		}


		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap' => true
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_HAIR)
				),
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00ffff00')
				)
			),
			'A3:Y4'
		);

		$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_HAIR)
				)
			),
			'A5:Y'.($x - 1)
		);

		$worksheet->freezePane("E5");

		$worksheet->getColumnDimension('A')->setAutoSize(true);
		$worksheet->getColumnDimension('B')->setAutoSize(true);
		$worksheet->getColumnDimension('C')->setAutoSize(true);
		$worksheet->getColumnDimension('D')->setAutoSize(true);
		$worksheet->getColumnDimension('E')->setAutoSize(true);
		$worksheet->getColumnDimension('X')->setAutoSize(true);
		$worksheet->getColumnDimension('Y')->setAutoSize(true);

		$filename ='BantuanUpah-'.date('Ymd_His').'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	public function Pdf($encryptedId)
	{
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encryptedId);
 		$id = $this->encrypt->decode($id);		

 		$data['data'] = $this->M_bantuanupah->getBantuanUpah($id);
 		$data['detail'] = $this->M_bantuanupah->getBantuanUpahDetail($id);

 		// echo "<pre>";
 		// print_r($detail);

 		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4-L',0,'monospace',5,5,5,10,0,5);
		$filename = 'Gaji.pdf';
		$waktu = strftime("%d %B %Y wkt. %X");
		$html = $this->load->view('MasterPresensi/ReffGaji/BantuanUpah/V_Pdf',$data, true);
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." (.........) pada tgl. ".$waktu.". Halaman {PAGENO} dari {nb}</i>");
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function Hapus($encryptedId)
	{
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encryptedId);
 		$id = $this->encrypt->decode($id);

 		$this->M_bantuanupah->deleteBantuanUpah($id);
 		$this->M_bantuanupah->deleteBantuanUpahDetail($id);

 		$record = $this->M_bantuanupah->getBantuanUpahAll();
 		$data = array();

 		if (isset($record) && !empty($record)) {
			foreach ($record as $rec) {
				$id_encrypted = $this->encrypt->encode($rec['id']);
				$id_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encrypted);
				
				$data[] = array(
					'id' => $id_encrypted,
					'tanggal' => strftime("%d %B %Y <br> %X",strtotime($rec['created_at'])),
					'user' => $rec['created_by']." - ".$rec['nama'],
					'periode' => strftime("%d %B %Y",strtotime($rec['periode_awal']))." s/d ".strftime("%d %B %Y",strtotime($rec['periode_akhir'])),
					'hubker' => $rec['status_hubungan_kerja']
				);

			}
		}

 		echo json_encode($data);
	}
}