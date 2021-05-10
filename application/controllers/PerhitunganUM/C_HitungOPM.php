<?php defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', '-1');

class C_HitungOPM extends CI_Controller {
    public function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('PerhitunganUM/M_hitungopm');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
    
    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
    }
    
    public function index(){
		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		
		$data['Menu'] = 'Hitung Utilitas Mesin OPM';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganUM/V_HitungOPM',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function getResources(){
		$routclass = $this->input->get('routclass');
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_hitungopm->getResources($routclass, $term);
		echo json_encode($data);
    }
    
    public function getData(){
        $routclass 		= $this->input->post('routclass');
		$plan			= $this->input->post('plan');
		$rsrc			= $this->input->post('rsrc');
        $data['routclass'] 	= $routclass; 
		$data['plan'] 	= $plan; 
		$data['rsrc'] 	= $rsrc; 
        
        $hasil = $this->M_hitungopm->getDataOPM($routclass, $rsrc);
		// echo "<pre>"; print_r($hasil);exit();

        
        // pengelompokan array table result
		$j = 0;	// Index per CC
		$k = 0;	// Index per data detail CC
		$m = 0;	// Index Memory mesin	
		$tampungan = array();	
		$mesin = array();	
		$rata = array();	
		$result = array();
        $result[$j]['Merge'] = 1; // Jumlah Merge CC-RC-DR-JM
        
        for ($i=0; $i < sizeof($hasil); $i++) {
            // Initial First Data
			if ($i == '0') {
				$result[$j]['Detail'][$k]['cost_center'] 	= $hasil[$i]['COST_CENTER'];
				$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['RESOURCES'];
				$result[$j]['Detail'][$k]['deskripsi'] 		= $hasil[$i]['RESOURCE_DESC'];
				$result[$j]['Detail'][$k]['jenis_mesin'] 	= $hasil[$i]['JENIS_RESOURCE'];
			 	$result[$j]['Detail'][$m]['mesin'] 			= $hasil[$i]['NO_MESIN'];
				$result[$j]['Detail'][$m]['tag_number'] 	= $hasil[$i]['TAG_NUMBER'];
				$result[$j]['Detail'][$k]['item_id'] 		= $hasil[$i]['INVENTORY_ITEM_ID'];
				$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['KODE_KOMPONEN'];
				$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['DESCRIPTION'];
				$result[$j]['Detail'][$k]['cycle_time'] 	= sprintf("%f",$hasil[$i]['RESOURCE_USAGE']);
				$Item_Opr	= $hasil[$i]['KODE_KOMPONEN'];
				$nomesin 	= $result[$j]['Detail'][$m]['mesin'];
				array_push($tampungan, $Item_Opr);  
				array_push($mesin, $nomesin); 
				$k++;
			}else {
                if ($hasil[$i]['TAG_NUMBER'] == $hasil[$i-1]['TAG_NUMBER']) {
                    if (in_array($hasil[$i]['KODE_KOMPONEN'], $tampungan)){
						// Okelah, Ya sudahlah
					}else{
                        $result[$j]['Detail'][$k]['cost_center'] 	= '';
						$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['RESOURCES'];
						$result[$j]['Detail'][$k]['deskripsi'] 		= '';
						$result[$j]['Detail'][$k]['jenis_mesin'] 	= '';
						$result[$j]['Detail'][$k]['mesin'] 			= '';
						$result[$j]['Detail'][$k]['tag_number'] 	= '';
						$result[$j]['Detail'][$k]['item_id'] 		= $hasil[$i]['INVENTORY_ITEM_ID'];
						$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['KODE_KOMPONEN'];
						$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['DESCRIPTION'];
						$result[$j]['Detail'][$k]['cycle_time'] 	= sprintf("%f",$hasil[$i]['RESOURCE_USAGE']);
						$result[$j]['Merge']++;
						$Item_Opr	= $hasil[$i]['KODE_KOMPONEN'];
			 			array_push($tampungan, $Item_Opr);
						$k++;
                    }
                    // Jaga2 klo mesin sama tapi beda CC
					if ($hasil[$i]['COST_CENTER'] != $hasil[$i-1]['COST_CENTER']) {
						$tampungan=array();
						$k=0;
						$m=0;
						$j++;
						$hasil[$j]['Merge']=1;
						$result[$j]['Detail'][$k]['cost_center'] 	= $hasil[$i]['COST_CENTER'];
						$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['RESOURCES'];
						$result[$j]['Detail'][$k]['deskripsi'] 		= $hasil[$i]['RESOURCE_DESC'];
						$result[$j]['Detail'][$k]['jenis_mesin'] 	= $hasil[$i]['JENIS_RESOURCE'];
						$result[$j]['Detail'][$k]['mesin'] 			= $hasil[$i]['NO_MESIN'];
						$result[$j]['Detail'][$k]['tag_number'] 	= $hasil[$i]['TAG_NUMBER'];
						$result[$j]['Detail'][$k]['item_id'] 		= $hasil[$i]['INVENTORY_ITEM_ID'];
						$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['KODE_KOMPONEN'];
						$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['DESCRIPTION'];
						$result[$j]['Detail'][$k]['cycle_time'] 	= sprintf("%f",$hasil[$i]['RESOURCE_USAGE']);
						$k++;
					}
                }else{
                    if ($hasil[$i]['COST_CENTER'] == $hasil[$i-1]['COST_CENTER']) {
                        if (in_array($hasil[$i]['KODE_KOMPONEN'], $tampungan)) {
                            if (sizeof($tampungan) <= sizeof($mesin)) {
                                $m++;
								$result[$j]['Detail'][$m]['cost_center'] 	= '';
								$result[$j]['Detail'][$m]['resource_code']	= $hasil[$i]['RESOURCES'];;
								$result[$j]['Detail'][$m]['deskripsi'] 		= '';
								$result[$j]['Detail'][$m]['jenis_mesin'] 	= '';
								$result[$j]['Detail'][$m]['mesin'] 			= $hasil[$i]['NO_MESIN'];
								$result[$j]['Detail'][$m]['tag_number'] 	= $hasil[$i]['TAG_NUMBER'];
								$result[$j]['Detail'][$m]['item_id'] 		= $hasil[$i]['INVENTORY_ITEM_ID'];
								$result[$j]['Detail'][$m]['item'] 			= '';
								$result[$j]['Detail'][$m]['item_desc'] 		= '';
								$result[$j]['Detail'][$m]['cycle_time'] 	= sprintf("%f",$hasil[$i]['RESOURCE_USAGE']);
								$result[$j]['Detail'][$m]['pod1'] 			= '';
								$result[$j]['Detail'][$m]['pod2'] 			= '';
								$result[$j]['Detail'][$m]['pod3'] 			= '';
								$result[$j]['Merge']++;
								$nomesin = $result[$j]['Detail'][$m]['mesin'];
								array_push($mesin, $nomesin);
                            }else {
								$m++;
								$result[$j]['Detail'][$m]['mesin'] 		= $hasil[$i]['NO_MESIN'];
								$result[$j]['Detail'][$m]['tag_number'] = $hasil[$i]['TAG_NUMBER'];
								$nomesin = $result[$j]['Detail'][$m]['mesin'];
								array_push($mesin, $nomesin);  
							}
                        }else{
                            $m=$k;
							$result[$j]['Detail'][$k]['cost_center'] 	= '';
							$result[$j]['Detail'][$k]['resource_code']	= '';
							$result[$j]['Detail'][$k]['deskripsi'] 		= '';
							$result[$j]['Detail'][$k]['jenis_mesin'] 	= '';
							$result[$j]['Detail'][$k]['mesin'] 			= $hasil[$i]['NO_MESIN'];
							$result[$j]['Detail'][$k]['tag_number'] 	= $hasil[$i]['TAG_NUMBER'];
							$result[$j]['Detail'][$k]['item_id'] 		= $hasil[$i]['INVENTORY_ITEM_ID'];
							$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['KODE_KOMPONEN'];
							$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['DESCRIPTION'];
							$result[$j]['Detail'][$k]['cycle_time'] 	= sprintf("%f",$hasil[$i]['RESOURCE_USAGE']);
							$result[$j]['Merge']++;
							$k++;
                        }
                    }else{
                        $tampungan=array();
						$mesin=array();
						$rata=array();
						$k=0;
						$m=0;
						$j++;
						$result[$j]['Merge']=1;
						$result[$j]['Detail'][$k]['cost_center'] 	= $hasil[$i]['COST_CENTER'];
						$result[$j]['Detail'][$k]['resource_code']	= $hasil[$i]['RESOURCES'];
						$result[$j]['Detail'][$k]['deskripsi'] 		= $hasil[$i]['RESOURCE_DESC'];
						$result[$j]['Detail'][$k]['jenis_mesin'] 	= $hasil[$i]['JENIS_RESOURCE'];
						$result[$j]['Detail'][$k]['mesin'] 			= $hasil[$i]['NO_MESIN'];
						$result[$j]['Detail'][$k]['tag_number'] 	= $hasil[$i]['TAG_NUMBER'];
						$result[$j]['Detail'][$k]['item_id'] 		= $hasil[$i]['INVENTORY_ITEM_ID'];
						$result[$j]['Detail'][$k]['item'] 			= $hasil[$i]['KODE_KOMPONEN'];
						$result[$j]['Detail'][$k]['item_desc'] 		= $hasil[$i]['DESCRIPTION'];
						$result[$j]['Detail'][$k]['cycle_time'] 	= sprintf("%f",$hasil[$i]['RESOURCE_USAGE']);
						$Item_Opr = $hasil[$i]['KODE_KOMPONEN'];
						array_push($tampungan, $Item_Opr);
						$nomesin = $result[$j]['Detail'][$m]['mesin'];
						array_push($mesin, $nomesin); 
						$k++;
                    }
                }
            }
		}

		$data['result'] = $result;

		// echo "<pre>"; print_r($data['result']);exit();
		
		$data['headerbln'] = $this->M_hitungopm->getHeaderBln();
        
        $this->load->view('PerhitunganUM/V_TableHitungOPM', $data);
	}
	
	public function getsapod($value='')
    {
      echo json_encode($this->M_hitungopm->getsapod($this->input->post('item_id'), $this->input->post('plan')));
	}
	
	public function exportDataPUM(){
		$cost1 			= $this->input->post('cost_center[]');
		$resource1 		= $this->input->post('resource_code[]');
		$desc1 			= $this->input->post('deskripsi[]');
		$jenis_mesin1 	= $this->input->post('jenis_mesin[]');
		$mesin1 		= $this->input->post('mesin[]');
		$tag_number1 	= $this->input->post('tag_number[]');
		$item_code1 	= $this->input->post('item[]');
		$item_desc1 	= $this->input->post('item_desc[]');
		$cycle_time1 	= $this->input->post('cycle_time[]');
		$routclass1		= $this->input->post('routclass[]');
		$merge			= $this->input->post('merge[]');
		$sa				= $this->input->post('sa[]');
		$pod1			= $this->input->post('pod1[]');
		$pod2			= $this->input->post('pod2[]');
		$pod3			= $this->input->post('pod3[]');
		$bulan1			= $this->input->post('bulan1[]');
		$bulan2			= $this->input->post('bulan2[]');
		$bulan3			= $this->input->post('bulan3[]');
		$ratabulan		= $this->input->post('ratabulan[]');
		$jam1			= $this->input->post('jam1[]');
		$jam2			= $this->input->post('jam2[]');
		$jam3			= $this->input->post('jam3[]');
		$ratajam		= $this->input->post('ratajam[]');
		$totaljam		= $this->input->post('totaljam[]');
		$utilitas		= $this->input->post('utilitas[]');

		// echo "<pre>"; print_r($item_code1);exit();
		$classrout 		= $routclass1[0];

		$datapum = array();
		for ($i=0; $i < count($item_code1) ; $i++) { 
			$array = array(
				'cost_center' 	=> $cost1[$i],
				'resource_code' => $resource1[$i],
				'deskripsi' 	=> $desc1[$i],
				'jenis_mesin' 	=> $jenis_mesin1[$i],
				'nomesin' 		=> $mesin1[$i],
				'tag_number' 	=> $tag_number1[$i],
				'item_code' 	=> $item_code1[$i],
				'item_desc' 	=> $item_desc1[$i],
				'cycle_time' 	=> $cycle_time1[$i],
				'merge' 		=> $merge[$i],
				'sa' 			=> $sa[$i],
				'pod1' 			=> $pod1[$i],
				'pod2' 			=> $pod2[$i],
				'pod3' 			=> $pod3[$i],
				'bulan1' 		=> $bulan1[$i],
				'bulan2' 		=> $bulan2[$i],
				'bulan3' 		=> $bulan3[$i],
				'ratabulan' 	=> $ratabulan[$i],
				'jam1' 			=> $jam1[$i],
				'jam2' 			=> $jam2[$i],
				'jam3' 			=> $jam3[$i],
				'ratajam' 		=> $ratajam[$i],
				'totaljam' 		=> $totaljam[$i],
				'utilitas' 		=> $utilitas[$i],
			);
			array_push($datapum, $array);
		}

		// $tahun 	= date("Y");
		$header_bulan = $this->M_hitungopm->getHeaderBln();
		$hdr_bulan1 = $header_bulan[0]['BULAN'];
		$hdr_bulan2 = $header_bulan[1]['BULAN'];
		$hdr_bulan3 = $header_bulan[2]['BULAN'];
		$periode_awal= substr($header_bulan[0]['BULAN'],0,3);
		$periode_akhir = substr($header_bulan[2]['BULAN'],0,3);
		$tahun = date("Y");
		$periode = $periode_awal.'-'.$periode_akhir.' '.$tahun;

		// echo "<pre>"; print_r($hdr_bulan1);exit();

		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
							->setLastModifiedBy('Quick')
							->setTitle("Perhitungan UM OPM")
							->setSubject("CV. KHS")
							->setDescription("Perhitungan Utilitas Mesin OPM")
							->setKeywords("PUM OPM");

		// style excel
		$style_title = array(
			'font' => array(
				'bold' => true,
				'size' => 15
			), 
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'			=> true
			),
			'borders' => array(
				'top'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN), 
				'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style1 = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER, 
			),
		);
		$style2 = array(
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'			=> true
			),
			'borders' => array(
				'top' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN), 
				'right' 	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style_ket = array(
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER, 
			),
		);
		$style_row = array(
			'alignment'=> array(
				'vertical'	=> PHPExcel_Style_Alignment::VERTICAL_CENTER, 
				'wrap'	 	=> true
			),
			'borders' => array(
				'top' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN), 
				'right' 	=> array('style' => PHPExcel_Style_Border::BORDER_THIN), 
				'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN), 
				'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		// title
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "FORM PERHITUNGAN NEED SHIFT MESIN PRODUKSI"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "CV. KARYA HIDUP SENTOSA PUSAT"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKSI : $classrout"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "PERIODE : $periode"); 
		$excel->getActiveSheet()->mergeCells('A1:Q1'); 
		$excel->getActiveSheet()->mergeCells('A2:Q2'); 
		$excel->getActiveSheet()->mergeCells('A3:Q3'); 
		$excel->getActiveSheet()->mergeCells('A4:Q4'); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_title);
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_title);
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_title);

		// header
		$excel->setActiveSheetIndex(0)->setCellValue('A6', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B6', "COST CENTER");
		$excel->setActiveSheetIndex(0)->setCellValue('C6', "RESOURCE CODE");
		$excel->setActiveSheetIndex(0)->setCellValue('D6', "DESKRIPSI");
		$excel->setActiveSheetIndex(0)->setCellValue('E6', "JENIS MESIN");
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "NO. MESIN");
		$excel->setActiveSheetIndex(0)->setCellValue('G6', "TAG NUMBER");
		$excel->setActiveSheetIndex(0)->setCellValue('H6', "KOMPONEN YANG DI KERJAKAN");
		$excel->setActiveSheetIndex(0)->setCellValue('H7', "KODE KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('I7', "DESKRIPSI KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('J6', "OPR SEQ");
		$excel->setActiveSheetIndex(0)->setCellValue('K6', "PLAN PRODUKSI (PCS)");
		$excel->setActiveSheetIndex(0)->setCellValue('K7', "$hdr_bulan1");
		$excel->setActiveSheetIndex(0)->setCellValue('L7', "$hdr_bulan2");
		$excel->setActiveSheetIndex(0)->setCellValue('M7', "$hdr_bulan3");
		$excel->setActiveSheetIndex(0)->setCellValue('N7', "RATA-RATA 1 BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('O6', "CYCLE TIME (HR)");
		$excel->setActiveSheetIndex(0)->setCellValue('P6', "TOTAL JAM DIBUTUHKAN");
		$excel->setActiveSheetIndex(0)->setCellValue('P7', "$hdr_bulan1");
		$excel->setActiveSheetIndex(0)->setCellValue('Q7', "$hdr_bulan2");
		$excel->setActiveSheetIndex(0)->setCellValue('R7', "$hdr_bulan3");
		$excel->setActiveSheetIndex(0)->setCellValue('S7', "RATA-RATA 1 BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('T6', "TOTAL JAM DIBUTUHKAN PER BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('U6', "UTILITAS MESIN(%)");
		$excel->setActiveSheetIndex(0)->setCellValue('T1', "STANDAR JAM AKTIF");
		$excel->setActiveSheetIndex(0)->setCellValue('T2', "487,5 JAM");
		$excel->getActiveSheet()->mergeCells('A6:A7'); 
		$excel->getActiveSheet()->mergeCells('B6:B7'); 
		$excel->getActiveSheet()->mergeCells('C6:C7');
		$excel->getActiveSheet()->mergeCells('D6:D7'); 
		$excel->getActiveSheet()->mergeCells('E6:E7'); 
		$excel->getActiveSheet()->mergeCells('F6:F7');
		$excel->getActiveSheet()->mergeCells('G6:G7');
		$excel->getActiveSheet()->mergeCells('H6:I6');
		$excel->getActiveSheet()->mergeCells('J6:J7');
		$excel->getActiveSheet()->mergeCells('K6:N6');
		$excel->getActiveSheet()->mergeCells('O6:O7');
		$excel->getActiveSheet()->mergeCells('P6:S6');
		$excel->getActiveSheet()->mergeCells('T6:T7');
		$excel->getActiveSheet()->mergeCells('U6:U7');

		// style header
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U7')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('T2')->applyFromArray($style1);

		// data
		if (count($datapum) == 0){
			$excel->setActiveSheetIndex(0)->setCellValue('A8');
			$excel->setActiveSheetIndex(0)->setCellValue('B8');
			$excel->setActiveSheetIndex(0)->setCellValue('C8');
			$excel->setActiveSheetIndex(0)->setCellValue('E8');
			$excel->setActiveSheetIndex(0)->setCellValue('F8');
			$excel->setActiveSheetIndex(0)->setCellValue('G8');
			$excel->setActiveSheetIndex(0)->setCellValue('H8');
			$excel->setActiveSheetIndex(0)->setCellValue('I8');
			$excel->setActiveSheetIndex(0)->setCellValue('J8');
			$excel->setActiveSheetIndex(0)->setCellValue('K8');
			$excel->setActiveSheetIndex(0)->setCellValue('L8');
			$excel->setActiveSheetIndex(0)->setCellValue('M8');
			$excel->setActiveSheetIndex(0)->setCellValue('N8');
			$excel->setActiveSheetIndex(0)->setCellValue('O8');
			$excel->setActiveSheetIndex(0)->setCellValue('P8');
			$excel->setActiveSheetIndex(0)->setCellValue('Q8');
			$excel->setActiveSheetIndex(0)->setCellValue('R8');
			$excel->setActiveSheetIndex(0)->setCellValue('S8');
			$excel->setActiveSheetIndex(0)->setCellValue('T8');
			$excel->setActiveSheetIndex(0)->setCellValue('U8');

			$excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('R8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('S8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('T8')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('U8')->applyFromArray($style_col);
		}else{
			$no=1;
			$numrow = 8;
			$sesuatu = $numrow;
			for ($i=0; $i < sizeof($datapum); $i++) {
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $datapum[$i]['cost_center']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $datapum[$i]['resource_code']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $datapum[$i]['deskripsi']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $datapum[$i]['jenis_mesin']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $datapum[$i]['nomesin']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $datapum[$i]['tag_number']);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $datapum[$i]['item_code']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $datapum[$i]['item_desc']);
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, NULL);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $datapum[$i]['bulan1']);
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $datapum[$i]['bulan2']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $datapum[$i]['bulan3']);
				$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $datapum[$i]['ratabulan']);
				$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $datapum[$i]['cycle_time']);
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $datapum[$i]['jam1']);
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $datapum[$i]['jam2']);
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $datapum[$i]['jam3']);
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $datapum[$i]['ratajam']);
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $datapum[$i]['totaljam']);
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $datapum[$i]['utilitas']);

				if(!empty($datapum[$i]['item_code'])){
					$sesuatu = $numrow;
				}
				if(!empty($datapum[$i]['cost_center'])){
					$no++; 
				}

				// merge jika item_code cuma 1
				if(empty($datapum[$i]['item_code'])){
					// echo "<pre>"; print_r($sesuatu); echo "<br/>"; print_r($numrow); exit();
					$excel->getActiveSheet()->mergeCells("H$sesuatu:H$numrow"); 
					$excel->getActiveSheet()->mergeCells("I$sesuatu:I$numrow"); 
					$excel->getActiveSheet()->mergeCells("J$sesuatu:J$numrow"); 
					$excel->getActiveSheet()->mergeCells("K$sesuatu:K$numrow"); 
					$excel->getActiveSheet()->mergeCells("L$sesuatu:L$numrow"); 
					$excel->getActiveSheet()->mergeCells("M$sesuatu:M$numrow"); 
					$excel->getActiveSheet()->mergeCells("N$sesuatu:N$numrow"); 
					$excel->getActiveSheet()->mergeCells("O$sesuatu:O$numrow"); 
					$excel->getActiveSheet()->mergeCells("P$sesuatu:P$numrow"); 
					$excel->getActiveSheet()->mergeCells("Q$sesuatu:Q$numrow"); 
					$excel->getActiveSheet()->mergeCells("R$sesuatu:R$numrow"); 
					$excel->getActiveSheet()->mergeCells("S$sesuatu:S$numrow"); 
				}

				// merge cost
				$tambah = $numrow + $datapum[$i]['merge'] - 1;
				if($datapum[$i]['cost_center'] != ''){
					$excel->getActiveSheet()->mergeCells("A$numrow:A$tambah"); 
					$excel->getActiveSheet()->mergeCells("B$numrow:B$tambah"); 
					$excel->getActiveSheet()->mergeCells("C$numrow:C$tambah"); 
					$excel->getActiveSheet()->mergeCells("D$numrow:D$tambah"); 
					$excel->getActiveSheet()->mergeCells("E$numrow:E$tambah"); 
				}

				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style2);
				$numrow++; 
			}
		}

			// keterangan & ttd dibawah data
			// $rowrata 	= sizeof($datapum)+ 8;
			// $rowave 	= sizeof($datapum)+ 7;
			$rowPUM 	= sizeof($datapum) + 10;
			$rowPUM2 	= $rowPUM + 1;
			$rowPUM3 	= $rowPUM2 + 1;
			$rowPUM4 	= $rowPUM3 + 1;
			$rowtanggal = $rowPUM4 + 8;
			$rowbuat 	= $rowtanggal + 2;
			$rowjbt 	= $rowbuat + 1;
			$rownama 	= $rowjbt + 4;
			$tanggal 	= date("d F Y");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM, "Data di atas adalah data dr PPIC yang sudah approval s/d Ka. Dept. Produksi");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM2, "% Utilitas Mesin = Total Jam Dibutuhkan per Bulan : Jam Standar Aktif dalam 1 bulan");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM3, "Jam Standar Aktif dalam 1 bulan = 25 hari x 3 shift x 6.5 jam = 487.5 jam");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$rowPUM4, "Apabila perhitungan utilitas mesin lebih dari 100%, maka akan dianggap 100%");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowtanggal, "Yogyakarta, $tanggal");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowbuat, "Dibuat");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$rowbuat, "Diperiksa");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$rowbuat, "Mengetahui");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowjbt, "Kasie PPIC $classrout");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$rowjbt, "Koord PPIC");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$rowjbt, "Kadept Produksi");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$rownama, "(                                        )");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$rownama, "(                                        )");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$rownama, "(                                        )");
			// $excel->setActiveSheetIndex(0)->setCellValue('U'.$rowrata, "=ROUND(AVERAGE(U8:U$rowave), 2)");

			$excel->getActiveSheet()->getStyle('B'.$rowPUM)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$rowPUM2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$rowPUM3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('B'.$rowPUM4)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle('D'.$rowtanggal)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('D'.$rowbuat)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('F'.$rowbuat)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('H'.$rowbuat)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('D'.$rowjbt)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('F'.$rowjbt)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('H'.$rowjbt)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('D'.$rownama)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('F'.$rownama)->applyFromArray($style_ket);
			$excel->getActiveSheet()->getStyle('H'.$rownama)->applyFromArray($style_ket);
			// $excel->getActiveSheet()->getStyle('U'.$rowrata)->applyFromArray($style_ket);

			// Set width kolom
			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('O')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Perhitungan Utilitas Mesin OPM");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="PerhitunganUMOPM_'.$classrout.'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

}

?>