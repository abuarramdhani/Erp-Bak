<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Rekap extends CI_Controller
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
		$this->load->model('MonitoringGdSparepart/M_rekap');

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
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap';
		$data['Menu'] = 'Rekap';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringGdSparepart/V_Rekap', $data);
		$this->load->view('V_Footer',$data);
    }

    public function getRekap(){
        $date = date('d/m/Y');
        $subinv = $this->input->post('subinv');
        $masuk = $this->M_rekap->getMasuk($date, $subinv);
        $pcs = $this->M_rekap->getpcs($date, $subinv);
        $data['pcs'] = $pcs[0]['PCS'];
        $data['sudah'] = 0;
        $data['belum'] = 0;
        $data['masuk'] = 0;
        $data['lembar_sudah'] = 0;
        $data['lembar_belum'] = 0;
        $asal = array();
        $i = 0;
        $from = array();
        $msk = array();
        foreach ($masuk as $val) {
            $cari = $this->pencarian($val);
            if (!in_array($cari['asal'], $from)) {
                array_push($from, $cari['asal']);
                $asal[$cari['asal']]['belum'] = 0;
                $asal[$cari['asal']]['pcs_belum'] = 0;
                $asal[$cari['asal']]['sudah'] = 0;
                $asal[$cari['asal']]['pcs_sudah'] = 0;
                $asal[$cari['asal']]['lembar_sudah'] = 0;
                $asal[$cari['asal']]['lembar_belum'] = 0;
            }
            if ($cari['status'] == 'Belum terlayani') {
                $asal[$cari['asal']]['belum'] += 1;
                $asal[$cari['asal']]['pcs_belum'] += $val['QTY'];
            }else {
                $asal[$cari['asal']]['sudah'] += 1;
                $asal[$cari['asal']]['pcs_sudah'] += $val['QTY'];
            }
            if (!in_array($val['NO_DOCUMENT'], $msk)) {
                array_push($msk, $val['NO_DOCUMENT']);
                $data['masuk'] += 1;
                if ($cari['hitung_bd'] == $cari['hitung_ket']) {
                    $data['sudah'] += 1;
                    $asal[$cari['asal']]['lembar_sudah'] += 1;
                } else {
                    $data['belum'] += 1;
                    $asal[$cari['asal']]['lembar_belum'] += 1;
                }
            }
            $i++;
        }
        $data['asal'] = $asal;
        // echo "<pre>";print_r($asal);exit();
        $this->load->view('MonitoringGdSparepart/V_TblRekap2', $data);
    }

    public function searchRekap(){
		$tglAwl = $this->input->post('tglAwl');
        $tglAkh = $this->input->post('tglAkh');
        $subinv = $this->input->post('subinv');

		$tanggal1 	= new DateTime($tglAwl);
		$tanggal2 	= new DateTime($tglAkh);
		$end 		= $tanggal2->modify('+1 day'); 
		$interval 	= new DateInterval('P1D');
		$daterange 	= new DatePeriod($tanggal1, $interval ,$end);
		$i = 0;
		foreach ($daterange as $date) {
			$tanggal[$i] 	= $date->format("d/m/Y");
			$tgl[$i] 		= $date->format("d-M-Y");
			$i++;
		}
		$data['tglAwal'] = $tanggal[0];
		$x = count($tanggal) -1;
        $data['tglAkhir'] = $tanggal[$x];
        
        $hasil = array();
        for ($a=0; $a < count($tanggal) ; $a++) { 
            $hasil[$a]['tanggal'] = $tgl[$a];
            $masuk = $this->M_rekap->getMasuk($tanggal[$a], $subinv);
            // $hasil[$a]['masuk'] = count($masuk);
            $pcs = $this->M_rekap->getpcs($tanggal[$a], $subinv);
            $hasil[$a]['pcs'] = $pcs[0]['PCS'];
            $hasil[$a]['sudah'] = 0;
            $hasil[$a]['belum'] = 0;
            $hasil[$a]['masuk'] = 0;
            $asal = array();
            $from = array();
            $i = 0;
            $msk = array();
            foreach ($masuk as $val) {
                $cari = $this->pencarian($val);
                if (!in_array($cari['asal'], $from)) {
                    array_push($from, $cari['asal']);
                    $asal[$cari['asal']]['belum'] = 0;
                    $asal[$cari['asal']]['pcs_belum'] = 0;
                    $asal[$cari['asal']]['sudah'] = 0;
                    $asal[$cari['asal']]['pcs_sudah'] = 0;
                    $asal[$cari['asal']]['lembar_sudah'] = 0;
                    $asal[$cari['asal']]['lembar_belum'] = 0;
                }
                if ($cari['status'] == 'Belum terlayani') {
                    $asal[$cari['asal']]['belum'] += 1;
                    $asal[$cari['asal']]['pcs_belum'] += $val['QTY'];
                }else {
                    $asal[$cari['asal']]['sudah'] += 1;
                    $asal[$cari['asal']]['pcs_sudah'] += $val['QTY'];
                }
                if (!in_array($val['NO_DOCUMENT'], $msk)) {
                    array_push($msk, $val['NO_DOCUMENT']);
                    $hasil[$a]['masuk'] += 1;
                    if ($cari['hitung_bd'] == $cari['hitung_ket']) {
                        $hasil[$a]['sudah'] += 1;
                        $asal[$cari['asal']]['lembar_sudah'] += 1;
                    } else {
                        $hasil[$a]['belum'] += 1;
                        $asal[$cari['asal']]['lembar_belum'] += 1;
                    }
                }
                $i++;
            }
            $hasil[$a]['asal'] = $asal;
        }
        $data['hasil'] = $hasil;
        // echo "<pre>";print_r($hasil);exit();

        $this->load->view('MonitoringGdSparepart/V_TblRekap', $data);

    }

    public function pencarian($val){
        $hasil = array();
        $item = $this->M_rekap->getitem($val['NO_DOCUMENT']);
        if ($val['JENIS_DOKUMEN'] == 'IO') {
            $getKet = $this->M_rekap->getKet($val['NO_DOCUMENT']);
            $gudang = $this->M_rekap->gdAsalIO($val['NO_DOCUMENT']);
            if (empty($gudang)) {
                $hasil['asal'] = '';
            }else {
                $hasil['asal'] = $gudang[0]['GUDANG_ASAL'];
            }
        }else if ($val['JENIS_DOKUMEN'] == 'LPPB') {
            $getKet = $this->M_rekap->getKetLPPB($val['NO_DOCUMENT']);
            $hasil['asal'] = 'PPB';
        }else if($val['JENIS_DOKUMEN'] == 'KIB'){
            $cek = $this->M_rekap->cariKib($val['NO_DOCUMENT']);
			if (!empty($cek)) {
				$getKet = $this->M_rekap->getKetKIB($val['NO_DOCUMENT']);
			}else {
				$getKet = $item;
			}
            $gudang = $this->M_rekap->gdAsalKIB($val['NO_DOCUMENT']);
            if (empty($gudang)) {
                $hasil['asal'] = '';
            }else {
                $hasil['asal'] = $gudang[0]['SUBINVENTORY_CODE'];
            }
        }else if($val['JENIS_DOKUMEN'] == 'MO'){
			$getKet = $this->M_rekap->getKetMO($val['NO_DOCUMENT']);;
			$gudang = $this->M_rekap->gdAsalMO($val['NO_DOCUMENT']);
			if (empty($gudang)) {
				$hasil['asal'] = '';
			}else {
				$hasil['asal'] = $gudang[0]['FROM_SUBINVENTORY_CODE'];
			}
        }elseif ($val['JENIS_DOKUMEN'] == 'FPB') {
			$gudang = $this->M_rekap->getKetFPB($val['NO_DOCUMENT']);
			if (empty($gudang)) {
				$hasil['asal'] = '';
				$hasil['status'] = '';
			}else {
				$hasil['asal'] = $gudang[0]['SEKSI_KIRIM'];
				$hasil['status'] = 'Sudah terlayani';
				for ($i=0; $i < count($gudang) ; $i++) { 
					$hasil['status'] = $gudang[$i]['STATUS'] == 6 ? $hasil['status'] : 'Belum terlayani';
				}
            }
            $hasil['hitung_bd'] = 1;
            $hasil['hitung_ket'] = $hasil['status'] == 'Sudah terlayani' ? 1 : 0;
		}elseif ($val['JENIS_DOKUMEN'] == 'SPBSPI') {
            $gudang = $this->M_rekap->getDataSPBSPI($val['NO_DOCUMENT']);
			if (empty($gudang)) {
				$hasil['asal'] = '';
				$hasil['status'] = '';
			}else {
				$hasil['asal'] = $gudang[0]['SUBINVENTORY_CODE'];
				$hasil['status'] = 'Sudah terlayani';
				for ($i=0; $i < count($gudang) ; $i++) { 
					$hasil['status'] = !empty($gudang[$i]['TRANSACT_BY']) ? $hasil['status'] : 'Belum terlayani';
				}
			}
            $hasil['hitung_bd'] = 1;
            $hasil['hitung_ket'] = $hasil['status'] == 'Sudah terlayani' ? 1 : 0;
		}
		if ($val['JENIS_DOKUMEN'] != 'FPB' && $val['JENIS_DOKUMEN'] != 'SPBSPI') {
			$hasil['hitung_bd'] = count($item);
            $hasil['hitung_ket'] = count($getKet);
            if ($hasil['hitung_bd'] <= $hasil['hitung_ket']) {
                $hasil['status'] = 'Sudah terlayani';
            } else {
                $hasil['status']  = 'Belum terlayani';
            }
		}

        return $hasil;
    }

    public function exportRekap(){
        $tanggal 	= $this->input->post('tanggal[]');
        $asal       = $this->input->post('asal[]');
        $lembar_sudah = $this->input->post('lembar_sudah[]');
        $item_sudah = $this->input->post('item_sudah[]');
        $pcs_sudah 	= $this->input->post('pcs_sudah[]');
        $lembar_belum = $this->input->post('lembar_belum[]');
        $item_belum = $this->input->post('item_belum[]');
        $pcs_belum 	= $this->input->post('pcs_belum[]');

        $get = array();
        for ($i=0; $i < count($asal) ; $i++) { 
            $array = array(
                'tanggal'		=> $tanggal[$i],
                'asal' 	        => $asal[$i],
                'lembar_sudah' 	=> $lembar_sudah[$i],
                'item_sudah' 	=> $item_sudah[$i],
                'pcs_sudah' 	=> $pcs_sudah[$i],
                'lembar_belum'	=> $lembar_belum[$i],
                'item_belum' 	=> $item_belum[$i],
                'pcs_belum' 	=> $pcs_belum[$i]
            );
            array_push($get, $array);
        }
        // echo "<pre>"; print_r($dataMGS);exit();

        include APPPATH.'third_party/Excel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('CV. KHS')
                    ->setLastModifiedBy('Quick')
                    ->setTitle("Monitoring Gudang Sparepart")
                    ->setSubject("CV. KHS")
                    ->setDescription("Monitoring Gudang Sparepart")
                    ->setKeywords("MGS");
        //style
        $style_title = array(
            'font' => array(
                'bold' => true,
                'size' => 15
            ), 
            'alignment' => array(
                'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $style_col = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'bdeefc'),
            ),
            'font' => array('bold' => true), 
            'alignment' => array(
                'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'			=> true
            ),
            'borders' => array(
                'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
            )
        );
        $style2 = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'		 => true
            ),
            'borders' => array(
                'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                'bottom' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Rekap Asal Gudang Sparepart"); 
        $excel->getActiveSheet()->mergeCells('A1:I1'); 
        $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO.");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "TANGGAL");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "ASAL GUDANG");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "SUDAH TERLAYANI");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "Lembar");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "Item");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "Pcs");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "BELUM TERLAYANI");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "Lembar");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "Item");
        $excel->setActiveSheetIndex(0)->setCellValue('I4', "Pcs");
        $excel->getActiveSheet()->mergeCells('A3:A4'); 
        $excel->getActiveSheet()->mergeCells('B3:B4'); 
        $excel->getActiveSheet()->mergeCells('C3:C4'); 
        $excel->getActiveSheet()->mergeCells('D3:F3'); 
        $excel->getActiveSheet()->mergeCells('G3:I3'); 

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);

        $no = 1;
        $numrow = 5;
        // foreach ($dataMGS as $dM) {
        $mrg = 5;	
        for ($i=0; $i < count($get) ; $i++) { 
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $get[$i]['tanggal']);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $get[$i]['asal']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $get[$i]['lembar_sudah']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $get[$i]['item_sudah']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $get[$i]['pcs_sudah']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $get[$i]['lembar_belum']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $get[$i]['item_belum']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $get[$i]['pcs_belum']);

            if ($i != 0 && $get[$i]['tanggal'] == $get[$i-1]['tanggal']) {
                $excel->getActiveSheet()->mergeCells("A$mrg:A$numrow"); 
                $excel->getActiveSheet()->mergeCells("B$mrg:B$numrow"); 
                $mrg = $numrow+1;
                // echo "<pre>";print_r($numrow);
                $no++;
            }

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
        $numrow++;
        }
        // exit();

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(13); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(13); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(13);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Rekap Asal Gudang Sparepart");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap_Asal_Gudang_Sparepart.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
		
	}

    
}