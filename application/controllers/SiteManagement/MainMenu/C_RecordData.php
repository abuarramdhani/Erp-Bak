<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RecordData extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('Personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SiteManagement/MainMenu/M_recorddata');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	//Kamar Mandi

	public function CeilingFan()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Kamar Mandi';
		$data['SubMenuTwo'] = 'Ceiling Fan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['CeilingFan'] = $this->M_recorddata->dataCeilingFan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_CeilingFan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Lantai()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Kamar Mandi';
		$data['SubMenuTwo'] = 'Lantai';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Lantai'] = $this->M_recorddata->dataLantai();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Lantai', $data);
		$this->load->view('V_Footer',$data);
	}

	//Lantai Parkir

	public function LPMaintenance()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Lantai Parkir (Maintenance)';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Maintenance'] = $this->M_recorddata->dataLPMaintenance();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_LPMaintenance', $data);
		$this->load->view('V_Footer',$data);
	}

	//Tong Sampah

	public function TongSampah()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Tong Sampah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['TongSampah'] = $this->M_recorddata->dataTongSampah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_TongSampah', $data);
		$this->load->view('V_Footer',$data);
	}

	//Lahan

	public function LahanKarangwaru()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Lahan';
		$data['SubMenuTwo'] = 'Karangwaru';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Karangwaru'] = $this->M_recorddata->dataLahanKarangwaru();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Karangwaru', $data);
		$this->load->view('V_Footer',$data);
	}

	public function LahanPetinggen()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Lahan';
		$data['SubMenuTwo'] = 'Petinggen';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Petinggen'] = $this->M_recorddata->dataLahanPetinggen();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Petinggen', $data);
		$this->load->view('V_Footer',$data);
	}

	public function PembersihanSajadah()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Pembersihan Karpet Sajadah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Sajadah'] = $this->M_recorddata->dataKarpetSajadah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Sajadah', $data);
		$this->load->view('V_Footer',$data);
	}

	public function deleteDataSiteManagement()
	{	$menu = $this->input->get('menu');
		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_recorddata->deleteDataSiteManagement($plaintext_string);

		if ($menu=='Petinggen') {
			redirect(site_url('SiteManagement/RecordData/LahanPetinggen'));	
		}elseif ($menu=='Karangwaru') {
			redirect(site_url('SiteManagement/RecordData/LahanKarangwaru'));
		}elseif ($menu=='Sampah') {
			redirect(site_url('SiteManagement/RecordData/TongSampah'));
		}elseif ($menu=='Parkir') {
			redirect(site_url('SiteManagement/RecordData/LPMaintenance'));
		}elseif ($menu=='Lantai') {
			redirect(site_url('SiteManagement/RecordData/Lantai'));
		}elseif ($menu=='CeilingFan') {
			redirect(site_url('SiteManagement/RecordData/CeilingFan'));
		}elseif ($menu=='Sajadah') {
			redirect(site_url('SiteManagement/RecordData/PembersihanSajadah'));
		}
	}

	public function TimbanganSampah()
    {
    	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Timbangan Sampah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['sampah'] = $this->M_recorddata->sampah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/TimbanganSampah/V_Index', $data);
		$this->load->view('V_Footer',$data);
    }

    public function TambahTimbanganSampah()
    {
    	$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Timbangan Sampah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['sampah'] = $this->M_recorddata->sampah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/TimbanganSampah/V_Create', $data);
		$this->load->view('V_Footer',$data);
    }

    public function SimpanTimbanganSampah()
    {
    	// print_r($_POST);
    	$no_urut = $this->input->post('txtNoUrut');
    	$tgl_timbang = $this->input->post('txtTglTimbang');
    	$no_kendaraan = $this->input->post('txtNoKendaraan');
    	$asal_sampah = $this->input->post('txtAsalSampah');
    	$jenis_mobil = $this->input->post('txtJenisMobil');
    	$sopir = $this->input->post('txtSopir');
    	$timbangan_1 = $this->input->post('txtBerat1');
    	$timbangan_2 = $this->input->post('txtBerat2');
    	$netto = $this->input->post('txtBeratNetto');
    	$wkt_timbangan = $this->input->post('txtWktTimbangan');

    	$inputSampah	=	array
    	(
    		'no_urut'				=>	$no_urut,
    		'no_kendaraan'				=>	$no_kendaraan,
    		'asal_sampah'				=>	$asal_sampah,
    		'jenis_mobil'				=>	$jenis_mobil,
    		'nama_sopir'				=>	$sopir,
    		'berat_timbangan_1'				=>	$timbangan_1,
    		'berat_timbangan_2'				=>	$timbangan_2,
    		'berat_netto'				=>	$netto,
    		'waktu'				=>	$wkt_timbangan,
    		'tgl_timbangan'				=>	$tgl_timbang,
    	);

    	$this->M_recorddata->SimpanTimbanganSampah($inputSampah);
    	redirect('SiteManagement/RecordData/TimbanganSampah');
    }

    public function editSampah($id)
    {
    	$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Timbangan Sampah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['sampah'] = $this->M_recorddata->dataSampah($id);
		// print_r($data['sampah']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/TimbanganSampah/V_Update', $data);
		$this->load->view('V_Footer',$data);
    }

    public function UpdateTimbanganSampah()
    {
    	// print_r($_POST);
    	$no_urut = $this->input->post('txtNoUrut');
    	$id = $this->input->post('txtId');
    	$tgl_timbang = $this->input->post('txtTglTimbang');
    	$no_kendaraan = $this->input->post('txtNoKendaraan');
    	$asal_sampah = $this->input->post('txtAsalSampah');
    	$jenis_mobil = $this->input->post('txtJenisMobil');
    	$sopir = $this->input->post('txtSopir');
    	$timbangan_1 = $this->input->post('txtBerat1');
    	$timbangan_2 = $this->input->post('txtBerat2');
    	$netto = $this->input->post('txtBeratNetto');
    	$wkt_timbangan = $this->input->post('txtWktTimbangan');

    	$inputSampah	=	array
    	(
    		'no_urut'					=>	$no_urut,
    		'no_kendaraan'				=>	$no_kendaraan,
    		'asal_sampah'				=>	$asal_sampah,
    		'jenis_mobil'				=>	$jenis_mobil,
    		'nama_sopir'				=>	$sopir,
    		'berat_timbangan_1'			=>	$timbangan_1,
    		'berat_timbangan_2'			=>	$timbangan_2,
    		'berat_netto'				=>	$netto,
    		'waktu'						=>	$wkt_timbangan,
    		'tgl_timbangan'				=>	$tgl_timbang,
    	);

    	$this->M_recorddata->UpdateTimbanganSampah($inputSampah,$id);
    	redirect('SiteManagement/RecordData/TimbanganSampah');
    }

    public function deleteSampah($id)
    {
    	$this->M_recorddata->DeleteTimbanganSampah($id);
    	redirect('SiteManagement/RecordData/TimbanganSampah');
    }

    public function JasaSedotWC()
    {
    	$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Jasa Sedot WC';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['wc'] = $this->M_recorddata->dataWc();
		// print_r($data['sampah']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/JasaSedotWC/V_Index', $data);
		$this->load->view('V_Footer',$data);
    }
    public function TambahJasaSedotWC()
    {
    	$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Jasa Sedot WC';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/JasaSedotWC/V_Create', $data);
		$this->load->view('V_Footer',$data);
    }

    public function SimpanSedotWC()
    {
    	// print_r($_POST);exit();
    	$tanggal = $this->input->post('txtTanggal');
    	$hari = $this->input->post('txtHari');
    	$seksi = $this->input->post('txtSeksi');
    	$jumlah = $this->input->post('txtJumlah');
    	$order = $this->input->post('txtOrder');
    	$lokasi = $this->input->post('txtLokasi');

    	$inputJasa	=	array
    	(
    		'tanggal'			=>	$tanggal,
    		'hari'				=>	$hari,
    		'seksi'				=>	$seksi,
    		'jumlah'			=>	$jumlah,
    		'pemberi_order'		=>	$order,
    		'lokasi'			=>	$lokasi,
    	);

    	$this->M_recorddata->SimpanJasaSedotWC($inputJasa);
    	redirect('SiteManagement/RecordData/JasaSedotWC');
    }

    public function editJasa($id)
    {
    	$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Jasa Sedot WC';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['editwc'] = $this->M_recorddata->editWc($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/JasaSedotWC/V_Update', $data);
		$this->load->view('V_Footer',$data);
    }

    public function UpdateSedotWC()
    {
    	$id = $this->input->post('txtId');
    	$tanggal = $this->input->post('txtTanggal');
    	$hari = $this->input->post('txtHari');
    	$seksi = $this->input->post('txtSeksi');
    	$jumlah = $this->input->post('txtJumlah');
    	$order = $this->input->post('txtOrder');
    	$lokasi = $this->input->post('txtLokasi');

    	$inputJasa	=	array
    	(
    		'tanggal'			=>	$tanggal,
    		'hari'				=>	$hari,
    		'seksi'				=>	$seksi,
    		'jumlah'			=>	$jumlah,
    		'pemberi_order'		=>	$order,
    		'lokasi'			=>	$lokasi,
    	);

    	$this->M_recorddata->UpdateJasaSedotWC($inputJasa, $id);
    	redirect('SiteManagement/RecordData/JasaSedotWC');
    }

    public function deleteJasa($id)
    {
    	$this->M_recorddata->DeleteJasaSedotWC($id);
    	redirect('SiteManagement/RecordData/JasaSedotWC');
    }

    public function exportdata()
    {
    	$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();

		$data = $this->M_recorddata->dataWc();

		$objPHPExcel->getProperties()->setCreator('KHS ERP')
             ->setTitle("Record Data Penggunaan Jasa Sedot WC")
             ->setSubject("Sedot WC")
             ->setDescription("Laporan Record Data Penggunaan Jasa Sedot WC")
             ->setKeywords("Record Data Penggunaan Jasa Sedot WC");

         $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara horizontal (left)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara horizontal (right)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
           'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bababa')
          )
        );  

        $style_col1 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );
        $style_col2 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bababa')
          )
        );

        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Hari / Tanggal");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Lokasi");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Seksi Pemakai");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Jumlah");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Pemberi Order");
        // PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        for ($c=0; $c < 6; $c++) {
        	$kolom_new = PHPExcel_Cell::stringFromColumnIndex($c);
        	$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'1')->applyFromArray($style_col);
        }
        foreach(range('A','G') as $columnID) {
        	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        	->setAutoSize(true);
        }
//data----------------------
        $tgl_local = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($row['tanggal'])));
        $baris = 2;
        $kolom = 0;
        $kolom_tgl = 1;
        $row = 1;
        foreach ($data as $key ) {
        	$kolom_new = PHPExcel_Cell::stringFromColumnIndex($kolom);
        	$kolom_new_1 = PHPExcel_Cell::stringFromColumnIndex($kolom_tgl);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.$baris, $row);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new_1.$baris, $key['hari'].', '.$tgl_local);
        	$row++;
        	$baris++;
        }

		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$objPHPExcel->getActiveSheet()->setTitle('Penggunaan Jasa Sedot WC');

		$objPHPExcel->setActiveSheetIndex(0);  
		$filename = urlencode("Record_Data_Penggunaan_Jasa_Sedot_WC.xls");

	      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	      header('Cache-Control: max-age=0'); //no cache

	      $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
	      $objWriter->save('php://output');
    }
}