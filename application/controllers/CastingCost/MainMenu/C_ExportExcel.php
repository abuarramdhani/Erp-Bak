<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ExportExcel extends CI_Controller {

public function __construct()
    {
      parent::__construct();
      $this->load->library('session');
      $this->load->library('Excel');
      $this->load->library('form_validation');
      $this->load->model('CastingCost/MainMenu/M_Casting');
      $this->load->model('CastingCost/MainMenu/M_ExportExcel');
    }
public function excel($message=NULL)
      {
        $id                 = $this->input->post('id');
        $period             = $this->input->post('slc_period');
        $year               = $this->input->post('slc_year');
        $cost_type          = $this->input->post('slc_cost_type');
        $io                 = $this->input->post('slc_io');
        $pemesan            = $this->input->post('txt_pemesan');
        $part_number        = $this->input->post('txt_partNumber');
        $desc               = $this->input->post('txt_description');
        $material_casting   = $this->input->post('txt_materialCasting');
        $berat_casting      = $this->input->post('berat_casting');
        $berat_remelt       = $this->input->post('berat_remelt');
        $berat_cairan       = $this->input->post('berat_cairan');
        $scrap              = $this->input->post('scrap');
        $yield_casting      = $this->input->post('yield_casting');
        $materialInti       = $this->input->post('txt_materialInti');
        $berat_inti         = $this->input->post('berat_inti');
        $target_inti        = $this->input->post('target_inti');
        $mesin_shelcore     = $this->input->post('txt_mesin_shelcore');
        $moulding           = $this->input->post('txt_moulding');
        $basic_tonage       = $this->input->post('basic_tonage');
        $target_pieces      = $this->input->post('target_pieces');
        $cavity_flask       = $this->input->post('cavity_flask');
        $target_flask       = $this->input->post('target_flask');
        $berat_pasir        = $this->input->post('berat_pasir');
        $batu_gerinda       = $this->input->post('batu_gerinda');
        $target_grinding    = $this->input->post('target_grinding');
        $pembuatan_pola     = $this->input->post('pembuatan_pola');
        $date_doc           = $this->input->post('txt_date');
        $no_doc             = $this->input->post('txt_no_doc');
        $dates       =  explode("-", $date_doc);
        $year_doc    =  substr($dates[0],2);
        $month_doc   =  $dates[1];
        $day_doc     =  $dates[2];
        $user_name          = $this->session->user;
        $material_melting        = $this->M_ExportExcel->getMaterial($material_casting);
        $cost_machine            = $this->M_ExportExcel->getCostMachine($mesin_shelcore);
        $cost_electric           = $this->M_ExportExcel->getCostElectric($mesin_shelcore);
        $cost_molding            = $this->M_ExportExcel->getCostMold();
        $cost_molding_electric   = $this->M_ExportExcel->getCostMoldElectric();
        $cost_finishing          = $this->M_ExportExcel->getCostFinishing();
        $cost_finishing_electric = $this->M_ExportExcel->getCostFinishingElectric();
            $this->M_Casting->updateStatus($id,$user_name);
        //part-number
        if ($part_number=='') {
            $part_number = '-';
        }
        //cost_shelcore_machine_and_electric
        if (empty($cost_machine[0]['cost'])) {
            $cost_machine_shelcore =0;
            }
            else{
                $cost_machine_shelcore = $cost_machine[0]['cost'];
            }

        if (empty($cost_electric[0]['cost'])) {
            $cost_electric_shelcore =0;
            }
            else{
                $cost_electric_shelcore = $cost_electric[0]['cost'];
            }

            //cost_molding_machine_and_electric
        if (empty($cost_molding[0]['cost'])) {
            $cost_machine_molding = 0;
            }
            else{
                $cost_machine_molding = $cost_molding[0]['cost'];
            }

        if (empty($cost_molding_electric[0]['cost'])) {
           $cost_electric_molding =0;
            }
            else{
                $cost_electric_molding =$cost_molding_electric[0]['cost'];
            }

        //rate_cost_melting
        $i = 0;
        foreach ($material_melting as $melt) {
            $kode = $melt['MATERIAL_CODE'];
            $rates= $this->M_ExportExcel->getRate($kode,$period,$year,$cost_type,$io);
            if (empty($rates[0]['MATERIAL_COST'])) {
                 $rate[$i] =0;
                }
                else {
                    $rate[$i] = $rates[0]['MATERIAL_COST'];
                }
            $i++;
            }

        //rate_cost_core
        $kode           = 'MFMC1R001';
        $rate_core      = $this->M_ExportExcel->getRate($kode,$period,$year,$cost_type,$io);
        if (empty($rate_core[0]['MATERIAL_COST'])) {
            $rate_core_val = 0;
            }
            else{
                $rate_core_val =$rate_core[0]['MATERIAL_COST'];
            }
        if ($target_inti =="") {
            $usage_rate_core =0; $target_inti =0;
            }
            else{
                $usage_rate_core =  7/$target_inti;
            }
        if ($berat_inti=="") {
            $berat_inti=0;
            }

        //rate_cost_molding
        $kodes       = array('MFMC1S003', 
                             'MFMC2G001',
                             'MFMC5C001',
                             'MFSF1S001', 
                             'MCAF22A02' );
        for ($i=0; $i < 5 ; $i++) { 
            $kode    = $kodes[$i];
            $rate_m  = $this->M_ExportExcel->getRate($kode,$period,$year,$cost_type,$io);
            if (empty($rate_m[0]['MATERIAL_COST'])) {
                $rate_mold_fins[$i] =0;
                }
                else{
                    $rate_mold_fins[$i] = $rate_m[0]['MATERIAL_COST'];
                }
            }


            //mulai
            $object = new PHPExcel();
            $object->getProperties()->setCreator("Quick")
                           ->setLastModifiedBy("Quick");
            $object->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $object->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

            $object->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(42);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(26);

            //font style
            $Font11Reg      = array('font'  => array( 'size' => 11,'bold'  => false,));
            $Font11Bold     = array('font'  => array( 'size' => 11,'bold'  => true,));
            $Font11BoldI    = array('font'  => array( 'size' => 11,'bold'  => true,'italic' => true));
            $Font11BoldU    = array('font'  => array( 'size' => 11,'bold'  => true,'underline' => true));
            $Font11BoldUI   = array('font'  => array( 'size' => 11,'bold'  => true,'underline' => true,'italic' => true));
            $Font14BoldU    = array('font'  => array( 'size' => 14,'bold'  => true,'underline' => true,));

            //style border
            $border_all     = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('black'),)));
            $border_top_bot = array('borders' => array( 
                                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),
                                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN )));
            $border_horizon = array('borders' => array(
                                    'horizontal' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN)));

            //type cell
            $object->getActiveSheet()->getStyle('B10:B11')->getNumberFormat()->setFormatCode('#,##0.00 "Kg"');
            $object->getActiveSheet()->getStyle('E10')->getNumberFormat()->setFormatCode('#,##0.00 "Kg"');
            $object->getActiveSheet()->getStyle('B14')->getNumberFormat()->setFormatCode('#,##0 "Kg/shift"');
            $object->getActiveSheet()->getStyle('B12')->getNumberFormat()->setFormatCode('0.00 "%"');
            $object->getActiveSheet()->getStyle('B13')->getNumberFormat()->setFormatCode('0 "%"');
            $object->getActiveSheet()->getStyle('E12')->getNumberFormat()->setFormatCode('#,##0 "Mold/Shift"');
            $object->getActiveSheet()->getStyle('E13')->getNumberFormat()->setFormatCode('#,##0 "Pcs/shift"');
            $object->getActiveSheet()->getStyle('E14')->getNumberFormat()->setFormatCode('#,##0 "Cavity/Flask"');
            $object->getActiveSheet()->getStyle('E6:E7')->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Kg"');

            //align
            $aligncenter = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
            $alignleft = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
            $alignright = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));        

            //Height
            $object->getActiveSheet()->getRowDimension('2')->setRowHeight(15);
            $object->getActiveSheet()->getRowDimension('3')->setRowHeight(24); 
            $object->getActiveSheet()->getRowDimension('4')->setRowHeight(15); 
            $object->getActiveSheet()->getRowDimension('5')->setRowHeight(14);

            //PENGAPLIKASIAN STYLE
            //font
            $object->getActiveSheet()->getStyle('A2')->applyFromArray($Font11BoldU);
            $object->getActiveSheet()->getStyle('E6:E7')->applyFromArray($Font11Bold);
            $object->getActiveSheet()->getStyle('B5')->applyFromArray($Font11Bold);
            $object->getActiveSheet()->getStyle('E13')->applyFromArray($Font11Bold);
            $object->getActiveSheet()->getStyle('A16') ->applyFromArray($Font11BoldU);
            $object->getActiveSheet()->getStyle('A17') ->applyFromArray($Font11BoldUI);
            $object->getActiveSheet()->getStyle('A18:E18') ->applyFromArray($Font11Bold);
            //align
            $object->getActiveSheet()->getStyle('A2:A3')->applyFromArray($aligncenter);
            $object->getActiveSheet()->getStyle('A5:D14')->applyFromArray($alignleft);
            $object->getActiveSheet()->getStyle('E5:E14')->applyFromArray($alignright);
            $object->getActiveSheet()->getStyle('E1')->applyFromArray($alignright);
            //border
            $object->getActiveSheet()->getStyle('A9:B14') ->applyFromArray($border_all);
            $object->getActiveSheet()->getStyle('D9:E14') ->applyFromArray($border_all);
            $object->getActiveSheet()->getStyle('A18:E18') ->applyFromArray($border_top_bot);

            //merge-cell
            $object->getActiveSheet()->mergeCells('A3:E3');
            $object->getActiveSheet()->mergeCells('A2:E2');
            $object->getActiveSheet()->mergeCells('D12:D13');

            $object->setActiveSheetIndex(0)
                    ->setCellValue('E1','No. Dokumen: ESTCAST/'.$year_doc.$month_doc.$day_doc.'/'.str_pad($no_doc, 4, '0', STR_PAD_LEFT))
                    ->setCellValue('A2','HARGA POKOK PRODUKSI PRODUK PENGECORAN LOGAM TUKSONO'.'('. $cost_type.')')
                    ->setCellValue('A3','□ PRODUK BARU                          □ REVIEW PRODUK                    □ PESANAN LUAR')
                    ->setCellValue('A5','Pemesan')->setCellValue('B5', $pemesan)
                    ->setCellValue('A6','Part Number')->setCellValue('B6',$part_number)
                    ->setCellValue('A7','Description')->setCellValue('B7',$desc)
                    ->setCellValue('D5','Tanggal Template')->setCellValue('E5',date('d-M-y'))
                    ->setCellValue('D6','HPP per PCS')->setCellValue('E6',"")
                    ->setCellValue('D7','HPP per Kg')->setCellValue('E7',"")
                    ->setCellValue('A9','Material Casting')->setCellValue('B9',$material_casting)
                    ->setCellValue('A10','Berat Casting')->setCellValue('B10',$berat_casting)
                    ->setCellValue('A11','Berat Cairan')->setCellValue('B11',$berat_cairan)
                    ->setCellValue('A12','Yield Casting')->setCellValue('B12',$yield_casting."%")
                    ->setCellValue('A13','Scrap')->setCellValue('B13',$scrap)
                    ->setCellValue('A14','Basic Tonage')->setCellValue('B14',$basic_tonage)
                    ->setCellValue('D9','Inti')->setCellValue('E9',$materialInti)
                    ->setCellValue('D10','Berat Inti')->setCellValue('E10',$berat_inti)
                    ->setCellValue('D11','Mesin Moulding')->setCellValue('E11',$moulding)
                    ->setCellValue('D12','Target Cetak Mold')->setCellValue('E12',$target_pieces)
                                                             ->setCellValue('E13',$target_flask)
                    ->setCellValue('D14','Cavity')->setCellValue('E14',$cavity_flask)
                    ->setCellValue('A16','Rincian Perhitungan')->setCellValue('A17','Material Melting')
                    ->setCellValue('A18','Item Code')->setCellValue('B18','Description')->setCellValue('C18','Qty')
                    ->setCellValue('D18','Rate')->setCellValue('E18','Total Cost');
             //--------------------------------------------------------------------------------------------------------------//
            $row = 19;
            $result_melt =0; $i =0;
            foreach ($material_melting as $melting) {
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row,$melting['MATERIAL_CODE'])
                    ->setCellValue('B'.$row,$melting['MATERIAL_NAME'])
                    ->setCellValue('C'.$row,$melting['QTY']*$berat_cairan)
                    ->setCellValue('D'.$row,$rate[$i])
                    ->setCellValue('E'.$row,$melting['QTY']*$berat_cairan*$rate[$i]);
             $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
             $object->getActiveSheet()->getStyle('C'.$row)->getNumberFormat()->setFormatCode('#,##0.0000 "'.$melting['UOM'].'"');
             $object->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/'.$melting['UOM'].'"');
             $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
            
             $result_melt +=(($melting['QTY']*$berat_cairan)*$rate[$i]);

                 $row++;$i++; 
                  }
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row,$result_melt); 
                    $object->getActiveSheet()->getStyle('E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
             //--------------------------------------------------------------------------------------------------------------//

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Material Pembuatan Inti');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Item Code')
                    ->setCellValue('B'.$row,'Description')
                    ->setCellValue('C'.$row,'Qty')
                    ->setCellValue('D'.$row,'Rate')->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'MFMC1R001')
                    ->setCellValue('B'.$row,'RESIN COATED SAND RC-5320')
                    ->setCellValue('C'.$row, $berat_inti)
                    ->setCellValue('D'.$row,$rate_core_val)->setCellValue('E'.$row, $berat_inti*$rate_core_val);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('C'.$row)->getNumberFormat()->setFormatCode('#,##0.0 "Kg"');
                    $object->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Kg"');
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
             
             $result_core = $berat_inti * $rate_core_val;
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_core);
                    $object->getActiveSheet()->getStyle('E'.$row) ->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
             //--------------------------------------------------------------------------------------------------------------//

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Material Molding');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Item Code')->setCellValue('B'.$row,'Description')->setCellValue('C'.$row,'Qty')
                    ->setCellValue('D'.$row,'Rate')->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);
                    $end  = $row; 
                    $end2 = $row+1;

            $qty_mold_silica      = $berat_pasir/100 / $cavity_flask;
            $rates_mold_silica    = $rate_mold_fins[0];
            $cost_mold_silica     = $qty_mold_silica * $rates_mold_silica;
            $qty_mold_bentonite   = 0.6625/100 * $berat_pasir / $cavity_flask;
            $rates_mold_bentonite = $rate_mold_fins[1];
            $cost_mold_bentonite  = $qty_mold_bentonite * $rates_mold_bentonite;
            $qty_mold_seacoal     = 0.2/100 * $berat_pasir / $cavity_flask;
            $rates_mold_seacoal   = $rate_mold_fins[2];
            $cost_mold_seacoal    = $qty_mold_seacoal * $rates_mold_seacoal;

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'MFMC1S003')
                    ->setCellValue('B'.$row,'PASIR SILICA AFS 52 - 62')
                    ->setCellValue('C'.$row, $qty_mold_silica)
                    ->setCellValue('D'.$row, $rates_mold_silica)
                    ->setCellValue('E'.$row, $cost_mold_silica)
                    
                    ->setCellValue('A'.$row+=1,'MFMC2G001')
                    ->setCellValue('B'.$row,'BENTONITE VOLCLAY')
                    ->setCellValue('C'.$row, $qty_mold_bentonite )
                    ->setCellValue('D'.$row, $rates_mold_bentonite)
                    ->setCellValue('E'.$row, $cost_mold_bentonite)
                    
                    ->setCellValue('A'.$row+=1,'MFMC5C001')
                    ->setCellValue('B'.$row,'SEA COAL 8')
                    ->setCellValue('C'.$row, $qty_mold_seacoal )
                    ->setCellValue('D'.$row, $rates_mold_seacoal)
                    ->setCellValue('E'.$row, $cost_mold_seacoal);
                    $object->getActiveSheet()->getStyle('D'.$end2.':E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Kg"');
                    $object->getActiveSheet()->getStyle('E'.$end2.':E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
                    $object->getActiveSheet()->getStyle('C'.$end2.':C'.$row)->getNumberFormat()->setFormatCode('#,##0.000 "Kg"');
           
             $result_mold   = ($cost_mold_silica) + ($cost_mold_bentonite) + ($cost_mold_seacoal);
           
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_mold);
                    $object->getActiveSheet()->getStyle('A'.$end.':E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('E'.$row) ->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
             //--------------------------------------------------------------------------------------------------------------//

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Material Finishing');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Item Code')
                    ->setCellValue('B'.$row,'Description')
                    ->setCellValue('C'.$row,'Qty')
                    ->setCellValue('D'.$row,'Rate')
                    ->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);
                    $end  = $row;
                    $end2 = $end+1;

            $qty_finish_steel   = 0.007 * $berat_cairan;
            $rates_finish_steel = $rate_mold_fins[3];
            $cost_finish_steel  = $qty_finish_steel * $rates_finish_steel;
            $qty_finish_gw      = $batu_gerinda;
            $rates_finish_gw    = $rate_mold_fins[4];
            $cost_finish_gw     = $qty_finish_gw * $rates_finish_gw;

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'MFSF1S001')
                    ->setCellValue('B'.$row,'STEEL SHOT S-550')
                    ->setCellValue('C'.$row, $qty_finish_steel)
                    ->setCellValue('D'.$row, $rates_finish_steel)
                    ->setCellValue('E'.$row, $cost_finish_steel)   
                    
                    ->setCellValue('A'.$row+=1,'MCAF22A02')
                    ->setCellValue('B'.$row,'GRIND. WHEEL DEPRESSED  A24QBF 27  180 X 6 X 22')
                    ->setCellValue('C'.$row, $qty_finish_gw )
                    ->setCellValue('D'.$row, $rates_finish_gw)
                    ->setCellValue('E'.$row, $cost_finish_gw);
                    $object->getActiveSheet()->getStyle('C'.$end2)->getNumberFormat()->setFormatCode('#,##0.00 "Kg"');
                    $object->getActiveSheet()->getStyle('D'.$end2.':E'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
                    $object->getActiveSheet()->getStyle('C'.$end2+=1)->getNumberFormat()->setFormatCode('#,##0.00 "Pieces"');
                    $object->getActiveSheet()->getStyle('D'.$end2.':E'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
             
             $result_finish = ($cost_finish_steel + $cost_finish_gw);
             $tot_material_cost = $result_melt + $result_core + $result_mold + $result_finish;
             
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_finish);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                    $object->getActiveSheet()->getStyle('A'.$end.':E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('D'.$row.':E'.$row) ->applyFromArray($Font11BoldI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('D'.$row+=1,'Total Biaya Material')
                    ->setCellValue('E'.$row, $tot_material_cost);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                    $object->getActiveSheet()->getStyle('E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('D'.$row.':E'.$row) ->applyFromArray($Font11BoldI);
             //--------------------------------------------------------------------------------------------------------------//


             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Pengurangan Remelt');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Item Code')
                    ->setCellValue('B'.$row,'Description')
                    ->setCellValue('C'.$row,'Qty')
                    ->setCellValue('D'.$row,'Rate')
                    ->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);
                    $end  = $row;
                    $end2 = $end+1;

             $qty_remelt     = $berat_remelt;
             $rates_remelt   = 5940;
             $cost_remelt    = $qty_remelt * $rates_remelt;

             $object->setActiveSheetIndex(0)
                  ->setCellValue('A'.$row+=1,'LJREM0002')
                  ->setCellValue('B'.$row,'REMELT / RETURN CAP FCD & FCV')
                  ->setCellValue('C'.$row, $qty_remelt)
                  ->setCellValue('D'.$row, $rates_remelt)
                  ->setCellValue('E'.$row, $cost_remelt);   
                        $result_finish = ( $cost_finish_steel+$cost_finish_gw);
                    $object->getActiveSheet()->getStyle('C'.$row)->getNumberFormat()->setFormatCode('#,##0.00 "Kg"');
                    $object->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
             
             $result_remelt                 = $cost_remelt;
             $result_material_min_remelt    = $tot_material_cost - $cost_remelt;
             
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_material_min_remelt)
                    ->setCellValue('D'.$row,'Total Biaya Material setelah Pengurangan Remelt');
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                    $object->getActiveSheet()->getStyle('A'.$end.':E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('D'.$row.':E'.$row) ->applyFromArray($Font11BoldI);
                    $object->getActiveSheet()->getStyle('D'.$row) ->applyFromArray($alignright);
             //--------------------------------------------------------------------------------------------------------------//

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Proses Pembuatan Inti');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Nama Resource')->setCellValue('B'.$row,'Tarif (Rate)')->setCellValue('C'.$row,'Resc Count')
                    ->setCellValue('D'.$row,'Usage Rate')->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);
                    $end   = $row; 
                    $end2  = $end+1; 
                    $end3  = $end2;
     
            $resccount_core_making_shelcore     = 1;
            $resccount_core_making_boli         = 1;
            $resccount_core_making_operator     = 2;
            $rate_core_making_operator          = 9306.76;
            $cost_core_making_shelcore          = $cost_machine_shelcore * $resccount_core_making_shelcore * $usage_rate_core;
            $cost_core_making_boli              = $cost_electric_shelcore * $resccount_core_making_boli * $usage_rate_core;
            $cost_core_making_operator          = $rate_core_making_operator * $resccount_core_making_operator * $usage_rate_core;
     
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,$mesin_shelcore)
                    ->setCellValue('B'.$row, $cost_machine_shelcore)
                    ->setCellValue('C'.$row, $resccount_core_making_shelcore)
                    ->setCellValue('D'.$row, $usage_rate_core)
                    ->setCellValue('E'.$row, $cost_core_making_shelcore)
                    
                    ->setCellValue('A'.$row+=1,'BOLI '.$mesin_shelcore)
                    ->setCellValue('B'.$row, $cost_electric_shelcore)
                    ->setCellValue('C'.$row, $resccount_core_making_boli)
                    ->setCellValue('D'.$row, $usage_rate_core)
                    ->setCellValue('E'.$row, $cost_core_making_boli)
                    
                    ->setCellValue('A'.$row+=1,'Operator')
                    ->setCellValue('B'.$row, $rate_core_making_operator)
                    ->setCellValue('C'.$row, $resccount_core_making_operator)
                    ->setCellValue('D'.$row, $usage_rate_core)
                    ->setCellValue('E'.$row, $cost_core_making_operator);

                    $object->getActiveSheet()->getStyle('C'.$end2.':C'.$end2+=1)->getNumberFormat()->setFormatCode('0 "Unit"');
                    $object->getActiveSheet()->getStyle('C'.$end2+=1)->getNumberFormat()->setFormatCode('0 "Org"');
                    $object->getActiveSheet()->getStyle('D'.$end3.':D'.$end2)->getNumberFormat()->setFormatCode('#,##0.00000 "Jam"');
                    $object->getActiveSheet()->getStyle('E'.$end3.':E'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
                    $object->getActiveSheet()->getStyle('B'.$end3.':B'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/jam"');
             
             $result_making_core = ($cost_core_making_shelcore + $cost_core_making_boli + $cost_core_making_operator);
             
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_making_core);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                    $object->getActiveSheet()->getStyle('A'.$end.':E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('D'.$row.':E'.$row) ->applyFromArray($Font11Bold);
             //--------------------------------------------------------------------------------------------------------------//

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Proses Line Molding');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Nama Resource')
                    ->setCellValue('B'.$row,'Tarif (Rate)')
                    ->setCellValue('C'.$row,'Resc Count')
                    ->setCellValue('D'.$row,'Usage Rate')
                    ->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);
                    $end  = $row; 
                    $end2 = $end+1;
                    $end3 = $end2;

            $resccount_line_molding_line        = 1;
            $resccount_line_molding_boli        = 1;
            $resccount_line_molding_operator    = 15;
            $usage_rate_line_molding            = 7 / $target_pieces;
            $rate_line_molding_operator         = 9306.76;
            $cost_line_molding_line             = $cost_machine_molding * $resccount_line_molding_line * $usage_rate_line_molding;
            $cost_line_molding_boli             = $cost_electric_molding * $resccount_line_molding_boli * $usage_rate_line_molding;
            $cost_line_molding_operator         = $rate_line_molding_operator * $resccount_line_molding_operator * $usage_rate_line_molding;

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Line Molding '.$moulding)
                    ->setCellValue('B'.$row, $cost_machine_molding)
                    ->setCellValue('C'.$row, $resccount_line_molding_line)
                    ->setCellValue('D'.$row, $usage_rate_line_molding)
                    ->setCellValue('E'.$row, $cost_line_molding_line)
                    
                    ->setCellValue('A'.$row+=1,'Biaya Listrik Line Molding '.$moulding)
                    ->setCellValue('B'.$row, $cost_electric_molding)
                    ->setCellValue('C'.$row, $resccount_line_molding_boli)
                    ->setCellValue('D'.$row, $usage_rate_line_molding)
                    ->setCellValue('E'.$row, $cost_line_molding_boli)
                    
                    ->setCellValue('A'.$row+=1,'Operator')
                    ->setCellValue('B'.$row, $rate_line_molding_operator)
                    ->setCellValue('C'.$row, $resccount_line_molding_operator)
                    ->setCellValue('D'.$row, $usage_rate_line_molding)
                    ->setCellValue('E'.$row, $cost_line_molding_operator);
                    
                    $object->getActiveSheet()->getStyle('C'.$end2.':C'.$end2+=1)->getNumberFormat()->setFormatCode('0 "Unit"');
                    $object->getActiveSheet()->getStyle('C'.$end2+=1)->getNumberFormat()->setFormatCode('0 "Org"');
                    $object->getActiveSheet()->getStyle('D'.$end3.':D'.$end2)->getNumberFormat()->setFormatCode('#,##0.00000 "Jam"');
                    $object->getActiveSheet()->getStyle('E'.$end3.':E'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
                    $object->getActiveSheet()->getStyle('B'.$end3.':B'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/jam"');
             
             $result_line_molding = ($cost_line_molding_line + $cost_line_molding_boli + $cost_line_molding_operator);
             
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_line_molding);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                    $object->getActiveSheet()->getStyle('A'.$end.':E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('D'.$row.':E'.$row) ->applyFromArray($Font11Bold);
             //--------------------------------------------------------------------------------------------------------------//

             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Proses Finishing');
                    $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font11BoldUI);
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Nama Resource')->setCellValue('B'.$row,'Tarif (Rate)')->setCellValue('C'.$row,'Resc Count')
                    ->setCellValue('D'.$row,'Usage Rate')->setCellValue('E'.$row,'Total Cost');
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($Font11Bold);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row) ->applyFromArray($border_top_bot);
                    $object->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($aligncenter);
                    $end   = $row;
                    $end2  = $end+1; 
                    $end3  = $end2;

             $resccount_finishing_finishing     = 1;
             $resccount_finishing_boli          = 1;
             $resccount_finishing_operator      = 2;
             $rate_finishing_operator           = 9306.76;
             $usage_rate_finishing              = 7 / $target_grinding;
             $cost_finishing_finishing          = $cost_finishing[0]['cost'] * $resccount_finishing_finishing * $usage_rate_finishing;
             $cost_finishing_boli               = $cost_finishing_electric[0]['cost'] * $resccount_core_making_boli * $usage_rate_finishing;
             $cost_finishing_operator           = $rate_finishing_operator * $resccount_finishing_operator * $usage_rate_finishing;
             
             $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row+=1,'Finishing')
                    ->setCellValue('B'.$row, $cost_finishing[0]['cost'])
                    ->setCellValue('C'.$row, $resccount_finishing_finishing)
                    ->setCellValue('D'.$row, $usage_rate_finishing)
                    ->setCellValue('E'.$row, $cost_finishing_finishing)

                    ->setCellValue('A'.$row+=1,'Biaya Listrik Finishing')
                    ->setCellValue('B'.$row, $cost_finishing_electric[0]['cost'])
                    ->setCellValue('C'.$row, $resccount_finishing_boli)
                    ->setCellValue('D'.$row, $usage_rate_finishing)
                    ->setCellValue('E'.$row, $cost_finishing_boli)

                    ->setCellValue('A'.$row+=1,'Operator')
                    ->setCellValue('B'.$row, $rate_finishing_operator)
                    ->setCellValue('C'.$row, $resccount_finishing_operator)
                    ->setCellValue('D'.$row, $usage_rate_finishing)
                    ->setCellValue('E'.$row, $cost_finishing_operator);

            $result_proccess_finishing = ( $cost_finishing_finishing + $cost_finishing_boli + $cost_finishing_operator );
              
                    $object->getActiveSheet()->getStyle('C'.$end2.':C'.$end2+=1)->getNumberFormat()->setFormatCode('0 "Unit"');
                    $object->getActiveSheet()->getStyle('C'.$end2+=1)->getNumberFormat()->setFormatCode('0 "Org"');
                    $object->getActiveSheet()->getStyle('D'.$end3.':D'.$end2)->getNumberFormat()->setFormatCode('#,##0.00000 "Jam"');
                    $object->getActiveSheet()->getStyle('E'.$end3.':E'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00');
                    $object->getActiveSheet()->getStyle('B'.$end3.':B'.$end2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/jam"');
             $object->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row+=1,$result_proccess_finishing);
                    $object->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                    $object->getActiveSheet()->getStyle('A'.$end.':E'.$row) ->applyFromArray($border_horizon);
                    $object->getActiveSheet()->getStyle('D'.$row.':E'.$row) ->applyFromArray($Font11Bold);
                    $end2 = $row;
                    $ends = $end2;
             //--------------------------------------------------------------------------------------------------------------//

            $tot_process            = $result_making_core + $result_line_molding + $result_proccess_finishing;
            $tot_casting            = ($result_material_min_remelt) + $tot_process;
            $tot_casting_kg         = $tot_casting / $berat_casting;
            $tot_casting_reject     = $tot_casting / (1 - ($scrap/100) );
            $tot_casting_reject_kg  = $tot_casting_reject / $berat_casting;

            $object->setActiveSheetIndex(0)
                    ->setCellValue('D'.$row+=2,'Total Biaya Proses')
                    ->setCellValue('E'.$row, $tot_process)

                    ->setCellValue('D'.$row+=2,'Total Biaya Casting')
                    ->setCellValue('E'.$row, $tot_casting)

                    ->setCellValue('D'.$row+=2,'Total Biaya Casting per KG')
                    ->setCellValue('E'.$row, $tot_casting_kg)

                    ->setCellValue('C'.$row+=2,'Total Biaya Casting setelah Memperhitungkan reject')
                    ->setCellValue('D'.$row, $scrap)
                    ->setCellValue('E'.$row, $tot_casting_reject)

                    ->setCellValue('C'.$row+=2,'Total Biaya Casting per Kg setelah Memperhitungkan reject')
                    ->setCellValue('D'.$row, 'Harga per Kilogram')
                    ->setCellValue('E'.$row, $tot_casting_reject_kg)
                    ->setCellValue('E6', $tot_casting_reject) 
                    ->setCellValue('E7', $tot_casting_reject_kg);
                     $end3 = $row-2;
                     $endcastkg = $row-5;

                     $object->getActiveSheet()->getStyle('E'.$ends.':E'.$endcastkg)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                     $object->getActiveSheet()->getStyle('E'.$endcastkg+=1)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Kg"');
                     $object->getActiveSheet()->getStyle('E'.$endcastkg+=2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Pcs"');
                     $object->getActiveSheet()->getStyle('E'.$endcastkg+=2)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00 "/Kg"');
                     $object->getActiveSheet()->getStyle('D'.$end3)->getNumberFormat()->setFormatCode('0 "%"');
                     $object->getActiveSheet()->getStyle('E'.$end3.':E'.$row) ->applyFromArray($Font14BoldU);
                     $object->getActiveSheet()->getStyle('E'.$end2.':E'.$end3-=1) ->applyFromArray($Font11Bold);
                     $object->getActiveSheet()->getStyle('A'.$end2.':D'.$row) ->applyFromArray($Font11BoldI);
                     $object->getActiveSheet()->getStyle('E'.$end3.':E'.$row+=1) ->applyFromArray($border_horizon);
                     $object->getActiveSheet()->getStyle('C'.$end3.':C'.$row) ->applyFromArray($alignright);
                     $end4 = $row;

            $object->setActiveSheetIndex(0)
                    ->setCellValue('B'.$row+=15,'Yogyakarta, '.date('d M Y'))
                    ->setCellValue('B'.$row+=1,'Dibuat Oleh,')->setCellValue('D'.$row,'Menyetujui,')
                    ->setCellValue('B'.$row+=4,'Artha Sakabuana')->setCellValue('D'.$row,'_____________')
                    ->setCellValue('B'.$row+=1,'Akuntansi Biaya');
                     $object->getActiveSheet()->getStyle('A'.$end4.':E'.$row) ->applyFromArray($aligncenter);

            $object->getActiveSheet()->setTitle('Pelaporan');
            $object->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.str_replace(" ","", $desc).'_'.$part_number.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            ob_clean();
            $objWriter->save('php://output');
      }

}
