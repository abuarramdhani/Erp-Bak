<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set("Asia/Jakarta");

class C_PrintppCatering extends CI_Controller
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
		$this->load->model('CateringManagement/M_printppcatering');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Print PP';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Printpp'] = $this->M_printppcatering->getPrintpp();
		$data['Section'] = $this->M_printppcatering->getSection();
		$data['Branch'] = $this->M_printppcatering->getBranch();
		$data['CostCenter'] = $this->M_printppcatering->getCostCenter();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/PrintPPCatering/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Print PP';
		$data['Menu'] = 'Catering Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['Section'] = $this->M_printppcatering->getSection();
		$data['Branch'] = $this->M_printppcatering->getBranch();
		$data['CostCenter'] = $this->M_printppcatering->getCostCenter();
		$data['kodeItem']	=	$this->M_printppcatering->kodeItem();
		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNoPpHeader', 'no proposal', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/PrintPPCatering/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$temp = array(
				'no_pp' => $this->input->post('txtNoPpHeader'),
				'tgl_buat' => date("Y-m-d",strtotime($this->input->post('txtTglBuatHeader'))),
				'pp_kepada' => $this->input->post('cmbPpKepadaHeader'),
				'pp_jenis' => $this->input->post('cmbPpJenisHeader'),
				'pp_no_proposal' => $this->input->post('txtPpNoProposalHeader'),
				'pp_seksi_pemesan' => $this->input->post('cmbPpSeksiPemesanHeader'),
				'pp_branch' => $this->input->post('cmbPpBranchHeader'),
				'pp_cost_center' => $this->input->post('cmbPpCostCenterHeader'),
				'pp_kat_barang' => $this->input->post('cmbPpKatBarangHeader'),
				'pp_sub_invent' => 'EXP',
				'pp_siepembelian' => ($this->input->post('cmbPpSiepembelianHeader') == '' ? null : $this->input->post('cmbPpSiepembelianHeader')),
				'pp_tgl_siepembelian' => ($this->input->post('txtPpTglSiepembelianHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglSiepembelianHeader')))),
				'pp_direksi' => ($this->input->post('cmbPpDireksiHeader') == '' ? null : $this->input->post('cmbPpDireksiHeader')),
				'pp_tgl_direksi' => ($this->input->post('txtPpTglDireksiHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglDireksiHeader')))),
				'pp_kadept' => ($this->input->post('cmbPpKadeptHeader') == '' ? null : $this->input->post('cmbPpKadeptHeader')),
				'pp_tgl_kadept' => ($this->input->post('txtPpTglKadeptHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglKadeptHeader')))),
				'pp_kaunit' => ($this->input->post('cmbPpKaunitHeader') == '' ? null : $this->input->post('cmbPpKaunitHeader')),
				'pp_tgl_kaunit' => ($this->input->post('txtPpTglKaunitHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglKaunitHeader')))),
				'pp_kasie' => ($this->input->post('cmbPpKasieHeader') == '' ? null : $this->input->post('cmbPpKasieHeader')),
				'pp_tgl_kasie' => ($this->input->post('txtPpTglKasieHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglKasieHeader')))),
				'pp_catatan' => $this->input->post('txaPpCatatanHeader'),
    		);

			$this->M_printppcatering->createPrintpp($temp);
			$header_id = $this->db->insert_id();

			$kodeBarang = $this->input->post('txtPpKodebarangHeader', true);
			$kodebarang = $this->input->post('txtPpKodebarangHeader');
			$jumlahpp = $this->input->post('txtPpJumlahHeader');
			$satuan = $this->input->post('txtPpSatuanHeader');
			$namabarang =$this->input->post('txtPpNamaBarangHeader');
			$nbd = $this->input->post('txtPpNbdHeader');
			$keterangan = $this->input->post('txtPpKeteranganHeader');
			$supplier = $this->input->post('txtPpSupplierHeader');
			$branch_d = $this->input->post('txtPpBranchHeader');
			$cost_center_d = $this->input->post('txtPpCostCenterHeader');
			// echo "<pre>";
			// print_r($_POST);
			// exit();
			foreach ($kodeBarang as $key => $value) {
				$lines = array(
					'pp_id' => $header_id,
					'pp_kode_barang' => $kodebarang[$key],
					'pp_jumlah' => $jumlahpp[$key],
					'pp_satuan' => $satuan[$key],
					'pp_nama_barang' => $namabarang[$key],
					'pp_nbd' => date("Y-m-d",strtotime($nbd[$key])),
					'pp_keterangan' => $keterangan[$key],
					'pp_supplier' => $supplier[$key],
					'pp_branch' => $branch_d[$key],
					'pp_cost_center' => $cost_center_d[$key]
	    		);
	    		// echo "<pre>";
	    		// print_r($lines);
				$this->M_printppcatering->createPrintppDetail($lines);
			}
			// exit();
			redirect(site_url('CateringManagement/PrintPPCatering'));
		}
	}

	public function getQtyPerDeptBatch(){
		$tipe = $this->input->get('ppjenis');
		$location = $this->input->get('pplokasi');
		$tgl_awal = $this->input->get('ppawal');
		$tgl_akhir = $this->input->get('ppakhir');

		if ($tipe == '1') {
			$jenis_pesanan = '1';
		}elseif ($tipe == '2') {
			$jenis_pesanan = '0';
		}

		$lokasi = intval($location).'';

		$data = $this->M_printppcatering->getDeptQty($tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan);
		if (!empty($data)) {
			echo json_encode($data);
		}else{
			// echo "$tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan,$katering";
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Print PP';
		$data['Menu'] = 'Catering Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Printpp'] = $this->M_printppcatering->getPrintpp($plaintext_string);
		$data['PrintppDetail'] = $this->M_printppcatering->getPrintppDetail($plaintext_string);
		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['Section'] = $this->M_printppcatering->getSection();
		$data['Branch'] = $this->M_printppcatering->getBranch();
		$data['CostCenter'] = $this->M_printppcatering->getCostCenter();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNoPpHeader', 'no proposal', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/PrintPPCatering/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$temp = array(
				'no_pp' => $this->input->post('txtNoPpHeader',TRUE),
				'tgl_buat' => date("Y-m-d", strtotime($this->input->post('txtTglBuatHeader',TRUE))),
				'pp_kepada' => $this->input->post('cmbPpKepadaHeader',TRUE),
				'pp_jenis' => $this->input->post('cmbPpJenisHeader',TRUE),
				'pp_no_proposal' => $this->input->post('txtPpNoProposalHeader',TRUE),
				'pp_seksi_pemesan' => $this->input->post('cmbPpSeksiPemesanHeader',TRUE),
				'pp_branch' => $this->input->post('cmbPpBranchHeader',TRUE),
				'pp_cost_center' => $this->input->post('cmbPpCostCenterHeader',TRUE),
				'pp_kat_barang' => $this->input->post('cmbPpKatBarangHeader',TRUE),
				'pp_siepembelian' => ($this->input->post('cmbPpSiepembelianHeader') == '' ? null : $this->input->post('cmbPpSiepembelianHeader')),
				'pp_tgl_siepembelian' => ($this->input->post('txtPpTglSiepembelianHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglSiepembelianHeader')))),
				'pp_direksi' => ($this->input->post('cmbPpDireksiHeader') == '' ? null : $this->input->post('cmbPpDireksiHeader')),
				'pp_tgl_direksi' => ($this->input->post('txtPpTglDireksiHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglDireksiHeader')))),
				'pp_kadept' => ($this->input->post('cmbPpKadeptHeader') == '' ? null : $this->input->post('cmbPpKadeptHeader')),
				'pp_tgl_kadept' => ($this->input->post('txtPpTglKadeptHeader') == '' ? null : date("Y-m-d", strtotime($this->input->post('txtPpTglKadeptHeader',TRUE)))),
				'pp_kaunit' => ($this->input->post('cmbPpKaunitHeader') == '' ? null : $this->input->post('cmbPpKaunitHeader')),
				'pp_tgl_kaunit' => ($this->input->post('txtPpTglKaunitHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglKaunitHeader')))),
				'pp_kasie' => ($this->input->post('cmbPpKasieHeader') == '' ? null : $this->input->post('cmbPpKasieHeader')),
				'pp_tgl_kasie' => ($this->input->post('txtPpTglKasieHeader') == '' ? null : date("Y-m-d",strtotime($this->input->post('txtPpTglKasieHeader')))),
				'pp_catatan' => $this->input->post('txaPpCatatanHeader',TRUE),
    			);
			$this->M_printppcatering->updatePrintpp($temp, $plaintext_string);

			$kodeBarang = $this->input->post('txtPpKodebarangHeader', true);

			foreach ($kodeBarang as $key => $value) {
				$pp_id = $this->input->post('txtPpId');
				$pp_detail_id = $this->input->post('txtPpDetailId');
				$kodebarang = $this->input->post('txtPpKodebarangHeader');
				$jumlahpp = $this->input->post('txtPpJumlahHeader');
				$satuan = $this->input->post('txtPpSatuanHeader');
				$namabarang =$this->input->post('txtPpNamaBarangHeader');
				$nbd = $this->input->post('txtPpNbdHeader');
				$keterangan = $this->input->post('txtPpKeteranganHeader');
				$supplier = $this->input->post('txtPpSupplierHeader');
				if($pp_id[$key] == null || $pp_id[$key] == '') {
					$lines = array(
						'pp_id' => $plaintext_string,
						'pp_kode_barang' => $kodebarang[$key],
						'pp_jumlah' => $jumlahpp[$key],
						'pp_satuan' => $satuan[$key],
						'pp_nama_barang' => $namabarang[$key],
						'pp_nbd' => date("Y-m-d",strtotime($nbd[$key])),
						'pp_keterangan' => $keterangan[$key],
						'pp_supplier' => $supplier[$key],
		    		);
					$this->M_printppcatering->createPrintppDetail($lines);
				} else {
					$id_lines = str_replace(array('-', '_', '~'), array('+', '/', '='), $pp_detail_id[$key]);
					$id_lines = $this->encrypt->decode($id_lines);
					$lines = array(
						'pp_kode_barang' => $kodebarang[$key],
						'pp_jumlah' => $jumlahpp[$key],
						'pp_satuan' => $satuan[$key],
						'pp_nama_barang' => $namabarang[$key],
						'pp_nbd' => date("Y-m-d",strtotime($nbd[$key])),
						'pp_keterangan' => $keterangan[$key],
						'pp_supplier' => $supplier[$key],
		    		);
					$this->M_printppcatering->updatePrintppDetail($lines, $id_lines);
				}
			}

			redirect(site_url('CateringManagement/PrintPP'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Print PP';
		$data['Menu'] = 'Catering Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Printpp'] = $this->M_printppcatering->getPrintpp($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/PrintPPCatering/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_printppcatering->deletePrintpp($plaintext_string);

		redirect(site_url('CateringManagement/PrintPP'));
    }

    public function Employee()
	{
		$key = $_GET['q'];

		$data = $this->M_printppcatering->getEmployeeAll($key);
		echo json_encode($data);
	}

	public function deleteLines()
    {
    	$id = $this->input->post('idKU');
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_printppcatering->deletePrintppDetail($plaintext_string);

		echo json_encode(true);
    }

    public function cetakPDF($id)
    {	

    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;
		
		$data['Printpp'] = $this->M_printppcatering->getPrintpp($plaintext_string);
		$data['PrintppDetail'] = $this->M_printppcatering->getPrintppDetail($plaintext_string);
		$data['Section'] = $this->M_printppcatering->getSection();
		$data['Branch'] = $this->M_printppcatering->getBranch();
		$data['CostCenter'] = $this->M_printppcatering->getCostCenter();
		$data['Employee'] = $this->M_printppcatering->getEmployeeSelected();
		$data['waktu'] = date('d M Y H:i:s');
     	$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 33, 50, 5, 5, 'P');
		$filename = 'Print_PP.pdf';
		// echo "<pre>";print_r($data['PrintppDetail']);exit();
		$html = $this->load->view('CateringManagement/PrintPPCatering/V_printpp', $data, true);
		$header = $this->load->view('CateringManagement/PrintPPCatering/V_printpp_h', $data, true);
		$footer = $this->load->view('CateringManagement/PrintPPCatering/V_printpp_f', $data, true);
		$pdf->SetHTMLHeader($header);
		$pdf->SetHTMLFooter($footer);
		$pdf->WriteHTML($html, 2);
		// $pdf->Output($filename, 'D');
		$pdf->Output($filename, 'I');

	}

	public function export_data_load($id)
	{
		$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		// echo $plaintext_string;exit();
		$data['PrintppDetail'] = $this->M_printppcatering->getPrintppDetail($plaintext_string);
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator('KHS ERP')
             ->setTitle("Export Data Load")
             ->setSubject("Export Data Load")
             ->setDescription("Export Data Load")
             ->setKeywords("Export Data Load");

        for ($i=1; $i <= count($data['PrintppDetail']); $i++) { 
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, "tab");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "JASA");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$i, "TAB");
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$i, "*DN");
        }
        $i = 1;
        foreach ($data['PrintppDetail'] as $key) {
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $key['pp_kode_barang']);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $key['pp_jumlah']);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i, $key['pp_nama_barang']);

        	$i++;
        }
        


      	    $objPHPExcel->getActiveSheet()->setTitle('Export Data Load');
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("Export Data Load ".date("Y-m-d").".ods");
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header("Content-disposition: attachment; filename=\"".$filename."\""); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        	
            redirect('CateringManagement/PrintPP');
	}

	public function kodeItem2()
	{
		$keyword 	=	strtoupper($this->input->get('term'));
		$kodeItem	=	$this->M_printppcatering->kodeItem2($keyword);
		echo json_encode($kodeItem);
	}
	public function namaItem()
	{
		$item = $this->input->post('item');
		$namaItem	=	$this->M_printppcatering->namaItem($item);
		$data['namaBarang'] = $namaItem[0]['nama_item'];
		echo json_encode($data);
	}
}

/* End of file C_Printpp.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_Printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */