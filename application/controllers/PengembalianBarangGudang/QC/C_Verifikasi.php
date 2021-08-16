<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Verifikasi extends CI_Controller {
    public function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
        $this->load->library('session');
		$this->load->library('form_validation');
        $this->load->library('PHPMailerAutoload');
        
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PengembalianBarangGudang/M_pengembalianbrg');
        
        $this->checkSession();
    }
    
    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
    }

    public function index(){
		$user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Verifikasi QC';
        $data['Menu'] = 'Verifikasi';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['getPengembalian'] = $this->M_pengembalianbrg->getDataVerif();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PengembalianBarangGudang/V_Verifikasi', $data);
        $this->load->view('V_Footer',$data);
    }

    public function UpdateStatusVerifQC(){
        $id_pengembalian = $this->input->post('id_pengembalian');
        $status_verifikasi = $this->input->post('status_verifikasi');
        $tgl_verif = gmdate("Y/m/d H:i:s", time()+60*60*7);
        
        $update = $this->M_pengembalianbrg->UpdateStatusVerifQC($id_pengembalian, $status_verifikasi, $tgl_verif);
    }

    public function UpdateKetVerif(){
        $id_pengembalian = $this->input->post('id_pengembalian');
        $ket_verif = $this->input->post('ket_verif');
        
        $update = $this->M_pengembalianbrg->UpdateKetVerif($id_pengembalian, $ket_verif);
    }

    public function UpdateSeksiPenerimaBrg(){
        $id_pengembalian = $this->input->post('id_pengembalian');
        $subinv_penerima_brg = $this->input->post('subinv_penerima_brg');
        $loc_penerima_brg = $this->input->post('loc_penerima_brg');
        
        $update = $this->M_pengembalianbrg->UpdateSeksiPenerimaBrg($id_pengembalian, $subinv_penerima_brg, $loc_penerima_brg);
    }

    public function EmailGudang($id_pengembalian){
        $getData = $this->M_pengembalianbrg->getData($id_pengembalian);

        $getEmail = $this->M_pengembalianbrg->getEmailGudang();
        $UserEmail = $getEmail[0]['email'];

        $link = base_url("PengembalianBarangGudang/Monitoring");

        $mail = new PHPMailer();
		$mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        
        $mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;
		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
        $mail->addAddress($UserEmail);
        
        $isi = 'QC telah memberikan hasil verifikasi, dengan detail berikut :<br/>
        Kode Komponen &nbsp;: '.$getData[0]['KODE_KOMPONEN'].'<br/>
        Nama Komponen &nbsp;: '.$getData[0]['NAMA_KOMPONEN'].'<br/>
        Qty Komponen &nbsp;: '.$getData[0]['QTY_KOMPONEN'].'<br/>
        Kasus &nbsp;: '.$getData[0]['ALASAN_PENGEMBALIAN'].'<br/>
        Hasil Verifikasi &nbsp;: '.$getData[0]['STATUS_VERIFIKASI'].'<br/>
        Keterangan Verifikasi &nbsp;: '.$getData[0]['KETERANGAN'].'<br/>
        Seksi Penerima Barang &nbsp;: '.$getData[0]['LOCATOR'].'<br/>
        Tanggal Verifikasi &nbsp;: '.$getData[0]['TGL_VERIFIKASI'].'<br/>
        Mohon untuk meneruskan proses penanganan barang kembalian dalam waktu max 1x24 jam dari tanggal verifikasi QC<br/><br/>
        Klik link untuk meneruskan proses <a href="'.$link.'" >disini</a>.
        <br/>';

        $mail->Subject = 'Hasil Verifikasi QC';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			$result = "Error";
		} else {
			$result = "Success";
			echo json_encode($result);
		}
    }

    public function getData(){
        $id_pengembalian = strtoupper($this->input->post('id_pengembalian'));
        
        $data = $this->M_pengembalianbrg->getData($id_pengembalian);
        echo json_encode($data);
    }

    public function SaveUpdate(){
        if ($this->input->is_ajax_request()) {
            $id_pengembalian = $this->input->post('id_pengembalian');
            $seksi = $this->input->post('seksi');
            // print_r($id_pengembalian); exit;

            $data = $this->M_pengembalianbrg->SaveUpdate($id_pengembalian, $seksi);
            echo json_encode($data);
            // $data = [
            //     'locator_penerima_barang' => $this->input->post('seksi')
            // ];
            // $final = $this->M_pengembalianbrg->SaveUpdate($this->input->post('id_pengembalian'), $data);
            // echo json_encode($final);
        }else {
            echo "Akses Diblokir!";
        }
    }

    public function exportDataBlmVerif(){
        $getdata = $this->M_pengembalianbrg->getDataBlmVerif();
        // echo "<pre>"; print_r($getdata); exit();

        include APPPATH.'third_party/Excel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('CV. KHS')
	                 ->setLastModifiedBy('Quick')
	                 ->setTitle("VerifPengembalianBrgGdg")
	                 ->setSubject("CV. KHS")
	                 ->setDescription("Verif Pengembalian Brg Gdg")
                     ->setKeywords("Verif PBG");
        // style excel
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
        $style_row = array(
			'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                'wrap'	 => true
			),
			'borders' => array(
                'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'bottom'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'left'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
        );

        // title
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP KOMPONEN BELUM VERIFIKASI");
		$excel->getActiveSheet()->mergeCells('A1:G1'); 
        $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
        
        // header
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "KODE KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "QTY KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "ALASAN PENGEMBALIAN");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "TGL ORDER VERIFIKASI");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "STATUS VERIFIKASI");

        // style header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

        $no=1;
        $numrow = 4;
        foreach ($getdata as $val) {
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['KODE_KOMPONEN']);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['NAMA_KOMPONEN']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['QTY_KOMPONEN']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['ALASAN_PENGEMBALIAN']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['TGL_ORDER_VERIFIKASI']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['STATUS_VERIFIKASI']);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);

            $no++;
            $numrow++; 
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(35); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Verif Pengembalian Brg Gdg");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap Komponen Belum Verifikasi.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}

?>