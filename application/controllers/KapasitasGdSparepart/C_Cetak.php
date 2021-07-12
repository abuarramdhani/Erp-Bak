<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Cetak extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('KapasitasGdSparepart/M_cetak');

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

		$data['Title'] = 'Cetak SPB/DOSP';
		$data['Menu'] = 'Cetak SPB/DOSP';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');
		// $date2 = gmdate('d/m/Y H:i:s', time()+60*60*7);
		// $date2 = date('d/m/Y', strtotime('+1 days'));
		$data['value'] 	= $this->M_cetak->siapCetak();
		// $pelayanan 		= $this->M_cetak->dataPelayanan($date);
		// $data['data']	= $pelayanan;
		// for ($i=0; $i <count($data['value']); $i++) {
		// 	$getstatus = $this->M_cetak->getStatus($data['value'][$i]['NO_DOKUMEN']);
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
		$this->load->view('KapasitasGdSparepart/V_Cetak', $data);
		$this->load->view('V_Footer',$data);
	}


	public function getCetakDO()
    {
    	$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_cetak->siapCetak();
		$data['noind']  = $this->M_cetak->getPIC();
		// $pelayanan 		= $this->M_cetak->dataPelayanan($date);
		// $data['data']	= $pelayanan;
        $this->load->view('KapasitasGdSparepart/V_Ajax_Cetak_DO', $data);
    }


	public function getSelesaiCetakDO()
	{
		$this->checkSession();
    	$date = date('d/m/Y');
		$data['value'] 	= $this->M_cetak->sudahCetak();
		$data['noind']  = $this->M_cetak->getPIC(null);
        $this->load->view('KapasitasGdSparepart/V_Ajax_Selesai_Cetak_DO', $data);
	}

	public function cetakDOSP($id)
    {
        $data['get_header'] = $this->M_cetak->headfootSurat($id);
        $data['get_body'] = $this->M_cetak->bodySurat($id);
				$data['get_colly'] = $this->M_cetak->getTotalColly($id);
        $data['total_colly'] = sizeof($data['get_colly']);
        $data['get_berat'] = $this->M_cetak->getTotalBerat($id);
 				$data['get_do'] = $this->M_cetak->getDofromSPB($id);
				$body = $data['get_body'];
				foreach ($body as $key => $value) {
					$tampung[] = $value;
					if (sizeof($tampung) == 22 || $key == sizeof($body) - 1 ) {
						$one_page_is[] = $tampung;
						$tampung = [];
					}
				}

				// echo "<pre>";
				// print_r($body);
				// die;

				$data['get_body'] = $one_page_is;

        if (!empty($id)) {
            // ====================== do something =========================
            $this->load->library('Pdf');
            $this->load->library('ciqrcode');

            $pdf = $this->pdf->load();
            $pdf = new mPDF('utf-8', array(202.5 , 267), 0, '', 3, 3, 3, 0, 0, 0);

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

            $this->M_cetak->insertCetak($id);

            $filename 	= $data['get_header'][0]['TIPE'].'_'.$data['get_header'][0]['REQUEST_NUMBER'].'.pdf';
            $cetakDOSP	= $this->load->view('KapasitasGdSparepart/V_Pdf_DOSP', $data, true);

            if (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 1) {
              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br><br>';
            } elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 2) {
              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br>';
            } elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 3) {
              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br>';
            } elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 4) {
              $a = '<br>'.$data['get_header'][0]['CATATAN'].'<br>';
            } elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 5) {
              $a = $data['get_header'][0]['CATATAN'];
            } elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 0) {
              $a = '<br><br><br><br><br>';
            }

            if (!empty($data['get_header'][0]['APPROVE_TO_1'])) {
              $appr = '<center>Approved by <br>'.$data['get_header'][0]['APPROVE_TO_1'].'<br><br><br>'.$data['get_header'][0]['APPROVE_TONAME'].'</center>';
            } else {
              $appr = '';
            }

            if (!empty($data['get_header'][0]['CREATED_BY'])) {
              $appr2 = '<center>Approved by <br>'.$data['get_header'][0]['CREATED_BY'].'<br><br><br>'.$data['get_header'][0]['CREATED_BYNAME'].'</center>';
            }else {
              $appr2 = '';
            }
            // $newDate = date("m-d-Y", strtotime($orgDate));
            $pdf->SetHTMLFooter(
			'<table style="width: 100%; border-collapse: collapse !important; margin-top: 2px; overflow: wrap;">
        		<tr style="width: 100%">
        			<td rowspan="2" style="white-space: pre-line; vertical-align: top; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
								Catatan : '.$data['get_do'][0]['BATCH_ID'].'
                		'.strtoupper($a).'
        			</td>
        			<td rowspan="3" style="vertical-align: top; width: 98px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
        				Penerima Barang :
        				<br><br>
        				Tgl. ________
        				<br><br><br><br><br><br><br><br>
        			</td>
        			<td rowspan="3" style="vertical-align: top; width: 90px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
        				Pengirim : <br> <br>
        				Tgl. _______
        				<br><br><br><br><br><br><br><br>
        			</td>
		            <td rowspan="3" style="vertical-align: top; width: 90px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
		              	Pengeluaran : <br> <br>
		                Tgl. _______
		                <br><br><br><br><br><br><br><br>
		            </td>
        			<td rowspan="3" style="vertical-align: top; width: 95px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
        				Gudang : <br><br>
        				Tgl. '.$data['get_header'][0]['ASSIGN_DATE'].'
        				<br><br><br><br><br><br>REYNALDI, NELSON
        			</td>
        			<td colspan="2" style="vertical-align: top; border-right: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; height: 20px!important;">
        				Pemasaran :
        			</td>
        		</tr>
        		<tr>
        			<td rowspan="2" style="vertical-align: top; width: 100px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
        				Mengetahui :
                		<br><br>'.$appr.'
        			</td>
        			<td rowspan="2" style="vertical-align: top; width: 100px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; font-size: 10px; padding: 5px">
        				Tgl. '.$data['get_header'][0]['CREATION_DATE'].'
        				<br><br>'.$appr2.'
        			</td>
        		</tr>
        		<tr>
        			<td style="vertical-align: top; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 8.5px; padding: 5px; height: 60px!important;">
        				Perhatian :<br>Barang yang dibeli tidak dapat dikembalikan, kecuali ada perjanjian sebelumnya.
        			</td>
        		</tr>
        	</table>
            <i style="font-size:10px;">
             	*Putih : Ekspedisi &nbsp;&nbsp;&nbsp;&nbsp;
            	Merah : Marketing &nbsp;&nbsp;&nbsp;&nbsp;
            	Kuning : Akuntansi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	Hijau : Customer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	Biru : Gudang
            </i>'
			);
            $pdf->SetFillColor(0,255,0);
            // $pdf->SetAlpha(0.4);
            $pdf->WriteHTML($cetakDOSP);
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
        } else {
            unlink($params['savename']);
        }
    }

		public function cetakDOSP2($id)
		{
			$xyz = explode('_', $id);
			$id = $xyz[0];

			$data['get_header'] = $this->M_cetak->headfootSurat($id);
			foreach ($data['get_header'] as $key => $value) {
				$getnama_app1 = $this->db->query("SELECT employee_name
																		FROM
																			er.er_employee_all
																		WHERE
																			employee_code = '{$value['APPROVE_TO_1']}'")->row_array();
				$data['get_header'][$key]['APPROVE_TONAME'] = $getnama_app1['employee_name'];

				$getnama_created_by = $this->db->query("SELECT employee_name
																		FROM
																			er.er_employee_all
																		WHERE
																			employee_code = '{$value['CREATED_BY']}'")->row_array();
				$data['get_header'][$key]['CREATED_BYNAME'] = $getnama_created_by['employee_name'];
			}
			$data['get_body'] = $this->M_cetak->bodySurat($id);
			$data['get_colly'] = $this->M_cetak->getTotalColly($id);
			$data['total_colly'] = sizeof($data['get_colly']);
			$data['get_berat'] = $this->M_cetak->getTotalBerat($id);
			$data['get_do'] = $this->M_cetak->getDofromSPB($id);
			$body = $data['get_body'];
			foreach ($body as $key => $value) {
				$tampung[] = $value;
				if (sizeof($tampung) == 22 || $key == sizeof($body) - 1 ) {
					$one_page_is[] = $tampung;
					$tampung = [];
				}
			}

			$data['get_body'] = $one_page_is;
			// echo "<pre>";
			// print_r($data['get_header']);
			// die;
			if (!empty($id)) {
					// ====================== do something =========================
					$this->load->library('Pdf');
					$this->load->library('ciqrcode');

					$pdf = $this->pdf->load();
					$pdf = new mPDF('utf-8', array(202.5 , 267), 0, '', 3, 2, 3, 0, 0, 16);

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
					if ($xyz[1] == 'y') {
						$this->M_cetak->insertCetak($id);
					}

					ob_end_clean() ;

					$filename 	= $data['get_header'][0]['TIPE'].'_'.$data['get_header'][0]['REQUEST_NUMBER'].'.pdf';
					$cetakDOSP	= $this->load->view('KapasitasGdSparepart/V_Pdf_DOSP_No_Border', $data, true);

					if (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 1) {
						$a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br><br>';
					} elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 2) {
						$a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br><br>';
					} elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 3) {
						$a = '<br>'.$data['get_header'][0]['CATATAN'].'<br><br>';
					} elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 4) {
						$a = '<br>'.$data['get_header'][0]['CATATAN'].'<br>';
					} elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 5) {
						$a = $data['get_header'][0]['CATATAN'];
					} elseif (ceil(strlen($data['get_header'][0]['CATATAN'])/25) == 0) {
						$a = '<br><br><br><br><br>';
					}

					if (!empty($data['get_header'][0]['APPROVE_TO_1'])) {
						$appr = '<center>Approved by <br>'.$data['get_header'][0]['APPROVE_TO_1'].'<br><br><br>'.$data['get_header'][0]['APPROVE_TONAME'].'</center>';
					} else {
						$appr = '';
					}

					if (!empty($data['get_header'][0]['CREATED_BY'])) {
						$appr2 = '<center>Approved by <br>'.$data['get_header'][0]['CREATED_BY'].'<br><br><br>'.$data['get_header'][0]['CREATED_BYNAME'].'</center>';
					}else {
						$appr2 = '';
					}
					// $newDate = date("m-d-Y", strtotime($orgDate));
					$pdf->SetHTMLFooter(
					'<table style="width: 100%; border-collapse: collapse !important; margin-top: 2px; overflow: wrap;">
					<tr style="width: 100%;">
						<td rowspan="2" style="white-space: pre-line; vertical-align: top; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px">
						 		<br>'.$data['get_do'][0]['BATCH_ID'].'
									'.strtoupper($a).'
						</td>
						<td rowspan="3" style="vertical-align: top; width: 98px; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px;">

							<br><br>

							<br><br><br><br><br><br><br>
						</td>
						<td rowspan="3" style="vertical-align: top; width: 90px; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px">
							 <br> <br>

							<br><br><br><br><br><br><br>
						</td>
							<td rowspan="3" style="vertical-align: top; width: 95px; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px">
									<br> <br>

									<br><br><br><br><br><br><br>
							</td>
						<td rowspan="3" style="vertical-align: top; width: 90px; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px;padding-top:4.2mm">
						 <br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data['get_header'][0]['ASSIGN_DATE'].'
							<br><br><br><br><br>NELSON REYNALDI
						</td>
						<td colspan="2" style="vertical-align: top; border-right: 1px solid white; border-top: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px; height: 20px!important;">

						</td>
					</tr>
					<tr>
						<td rowspan="2" style="vertical-align: top; width: 90px; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px;padding-top:3mm;padding-left:1mm">

							<br><br>'.$appr.'
						</td>
						<td rowspan="2" style="vertical-align: top; width: 80px; border-top: 1px solid white; border-bottom: 1px solid white; border-left: 1px solid white; border-right: 1px solid white; font-size: 10px; padding: 5px;padding-top:5.9mm;padding-left:2.5mm">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data['get_header'][0]['CREATION_DATE'].'
							<br>'.$appr2.'
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 8.5px; padding: 5px; height: 60px!important;">

						</td>
					</tr>
				</table>'
		);
					$pdf->SetFillColor(0,255,0);
					// $pdf->SetAlpha(0.4);
					$pdf->WriteHTML($cetakDOSP);
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
			} else {
					unlink($params['savename']);
			}
		}

		public function cetakSPB3($id)
		{
			$xyz = explode('_', $id);
			$id = $xyz[0];

			$data['get_header'] = $this->M_cetak->headfootSurat($id);

			foreach ($data['get_header'] as $key => $value) {
				$getnama_app1 = $this->db->query("SELECT employee_name
																		FROM
																			er.er_employee_all
																		WHERE
																			employee_code = '{$value['APPROVE_TO_1']}'")->row_array();
				$data['get_header'][$key]['APPROVE_TONAME'] = $getnama_app1['employee_name'];

				$getnama_created_by = $this->db->query("SELECT employee_name
																		FROM
																			er.er_employee_all
																		WHERE
																			employee_code = '{$value['CREATED_BY']}'")->row_array();
				$data['get_header'][$key]['CREATED_BYNAME'] = $getnama_created_by['employee_name'];
			}

			// echo "<pre>";
			// print_r($data['get_header']);
			// die;

			$body = $this->M_cetak->bodySurat($id);
			foreach ($body as $key => $value) {
				$tampung[] = $value;
				if (sizeof($tampung) == 27 || $key == sizeof($body) - 1 ) {
					$one_page_is[] = $tampung;
					$tampung = [];
				}
			}
			$data['get_body'] = $one_page_is;
			// echo "<pre>";
			// print_r($one_page_is);
			// die;
			$data['get_colly'] = $this->M_cetak->getTotalColly($id);
			$data['total_colly'] = sizeof($data['get_colly']);
			$data['get_berat'] = $this->M_cetak->getTotalBerat($id);
			$data['get_do'] = $this->M_cetak->getDofromSPB($id);

			$data['row'] = $data['get_header'][0];

			if (!empty($id)) {
					// ====================== do something =========================
					$this->load->library('Pdf');
					$this->load->library('ciqrcode');

					$pdf = $this->pdf->load();
					$pdf = new mPDF('utf-8',array(216 , 280), 0, '', 6, 0, 4, 0);

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
					if ($xyz[1] == 'y') {
						$this->M_cetak->insertCetak($id);
					}

					$filename 	= $data['get_header'][0]['TIPE'].'_'.$data['get_header'][0]['REQUEST_NUMBER'].'.pdf';
					$cetakDOSP	= $this->load->view('KapasitasGdSparepart/V_Pdf_SPB_No_Border', $data, true);


					$pdf->SetFillColor(0,255,0);
					// $pdf->SetAlpha(0.4);
					$pdf->WriteHTML($cetakDOSP);
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
			} else {
					unlink($params['savename']);
			}
		}
}
