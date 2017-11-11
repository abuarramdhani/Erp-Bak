<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_LimbahTransaksi extends CI_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_limbahtransaksi');

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

		$data['Title'] = 'Limbah Masuk';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['data'] = $this->M_limbahtransaksi->getLimbahTransaksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['getSeksi']= $this->M_limbahtransaksi->getSeksi();
		$data['perlakuan']= $this->M_limbahtransaksi->getPerlakuan();

		$data['Title'] = 'Limbah Masuk';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbJenisLimbahHeader', 'jenis', 'required');
		$this->form_validation->set_rules('cmbSumberLimbahHeader', 'sumber', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahTransaksi/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_transaksi' => date("Y-m-d", strtotime($this->input->post('txtTanggalTransaksiHeader',TRUE))),
				'jenis_limbah' => $this->input->post('cmbJenisLimbahHeader',TRUE),
				'sumber_limbah' => $this->input->post('cmbSumberLimbahHeader',TRUE),
				'jenis_sumber' => $this->input->post('cmbJenisSumberHeader',TRUE),
				'satuan' => $this->input->post('cmbSatuanHeader',TRUE),
				'jumlah' => $this->input->post('txtJumlahHeader',TRUE),
				'perlakuan' => $this->input->post('cmbPerlakuanHeader',TRUE),
				'maks_penyimpanan' => date("Y-m-d", strtotime($this->input->post('txtMaksPenyimpananHeader',TRUE))),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'creation_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
    		);
			$this->M_limbahtransaksi->setLimbahTransaksi($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('WasteManagement/LimbahTransaksi'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['getSeksi']= $this->M_limbahtransaksi->getSeksi();
		$data['perlakuan']= $this->M_limbahtransaksi->getPerlakuan();

		$data['Title'] = 'Limbah Masuk';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahTransaksi'] = $this->M_limbahtransaksi->getLimbahTransaksi($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbJenisLimbahHeader', 'jenis', 'required');
		$this->form_validation->set_rules('cmbSumberLimbahHeader', 'sumber', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahTransaksi/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_transaksi' => date("Y-m-d", strtotime($this->input->post('txtTanggalTransaksiHeader',TRUE))),
				'jenis_limbah' => $this->input->post('cmbJenisLimbahHeader',TRUE),
				'sumber_limbah' => $this->input->post('cmbSumberLimbahHeader',TRUE),
				'jenis_sumber' => $this->input->post('cmbJenisSumberHeader',TRUE),
				'satuan' => $this->input->post('cmbSatuanHeader',TRUE),
				'jumlah' => $this->input->post('txtJumlahHeader',TRUE),
				'perlakuan' => $this->input->post('cmbPerlakuanHeader',TRUE),
				'maks_penyimpanan' => date("Y-m-d", strtotime($this->input->post('txtMaksPenyimpananHeader',TRUE))),
				'last_updated' => date('Y-m-d h:i:s'),
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_limbahtransaksi->updateLimbahTransaksi($data, $plaintext_string);

			redirect(site_url('WasteManagement/LimbahTransaksi'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Masuk';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahTransaksi'] = $this->M_limbahtransaksi->getLimbahTransaksi($plaintext_string);
		$data['user'] = $this->M_limbahtransaksi->getUser();	
		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahtransaksi->deleteLimbahTransaksi($plaintext_string);

		redirect(site_url('WasteManagement/LimbahTransaksi'));
    }

	public function kirimApprove($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
	
		$this->M_limbahtransaksi->kirimApprove($plaintext_string);

		redirect(site_url('WasteManagement/LimbahTransaksi'));
	}

	public function kirimReject($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahtransaksi->kirimReject($plaintext_string);

		redirect(site_url('WasteManagement/LimbahTransaksi'));
	}

	public function ReportHarian()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Report Limbah Masuk';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Report Limbah Masuk';
		$data['SubMenuTwo'] = 'Report Limbah Masuk Harian'; 

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['data'] = $this->M_limbahtransaksi->getLimbahTransaksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_ReportHarian', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ReportBulanan()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Report Limbah Masuk';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Report Limbah Masuk';
		$data['SubMenuTwo'] = 'Report Limbah Masuk Bulanan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['data'] = $this->M_limbahtransaksi->getLimbahTransaksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_ReportBulanan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataReportHarian()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Report Limbah Masuk';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Report Limbah Masuk';
		$data['SubMenuTwo'] = 'Report Limbah Masuk Harian';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenislimbah = $this->input->post('jenis_limbah',true);

		$periode = $this->input->post('periode', true);
		if($periode == '') {
			$tanggalawal = '';
			$tanggalakhir = '';
		} else {
			$periode = explode('-', $periode);

			$buattanggalawal 	= str_replace('/', '-', $periode[0]);
			$buattanggalakhir	= str_replace('/', '-', $periode[1]);
			$tanggalawal 		= date('Y-m-d', strtotime($buattanggalawal));
			$tanggalakhir 		= date('Y-m-d', strtotime($buattanggalakhir));
		}
		
		$data['tanggalawal'] = $tanggalawal;
		$data['tanggalakhir']= $tanggalakhir;
		$data['jenislimbah'] = $jenislimbah;

		$data['tanggalawalformatindo'] 	= date('d-m-Y',strtotime($tanggalawal));
		$data['tanggalakhirformatindo']	= date('d-m-Y',strtotime($tanggalakhir));

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['filter_data'] = $this->M_limbahtransaksi->filterData($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_ReportHarian', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataReportBulanan()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Report Limbah Masuk';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Report Limbah Masuk';
		$data['SubMenuTwo'] = 'Report Limbah Masuk Bulanan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenislimbah = $this->input->post('jenis_limbah',true);

		$periode = $this->input->post('periode', true);
		if($periode == '') {
			$tanggalawal = '';
			$tanggalakhir = '';
		} else {
			$periode = explode('-', $periode);

			$buattanggalawal 	= str_replace('/', '-', $periode[0]);
			$buattanggalakhir	= str_replace('/', '-', $periode[1]);
			$tanggalawal 		= date('Y-m-d', strtotime($buattanggalawal));
			$tanggalakhir 		= date('Y-m-d', strtotime($buattanggalakhir));
		}
		
		$data['tanggalawal'] = $tanggalawal;
		$data['tanggalakhir']= $tanggalakhir;
		$data['jenislimbah'] = $jenislimbah;

		$data['tanggalawalformatindo'] 	= date('d-m-Y',strtotime($tanggalawal));
		$data['tanggalakhirformatindo']	= date('d-m-Y',strtotime($tanggalakhir));

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['filter_data'] = $this->M_limbahtransaksi->filterData($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_ReportBulanan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakExcelHarian($tanggalawallink,$tanggalakhirlink)
    {
            $this->load->library("Excel");

            $tanggalawalx = str_replace('.', '-', $tanggalawallink);
            $tanggalakhirx = str_replace('.', '-', $tanggalakhirlink);

            $tanggalawal = $this->input->post('excelTglAwal');
            $tanggalakhir = $this->input->post('excelTglAkhir');
            $jenisLimbah = $this->input->post('exceljenislimbah'); 

			if($tanggalawal == '') $tanggalawal = '';
			if($tanggalakhir == '') $tanggalakhir = '';
			if($jenisLimbah == null) $jenisLimbah == ''; 

			$data['tanggalawal'] = $tanggalawal; 
			$data['tanggalakhir'] = $tanggalakhir; 

			$datetime1 = new DateTime($data['tanggalawal']);
			$datetime2 = new DateTime($data['tanggalakhir']);
			$interval = $datetime1->diff($datetime2);
			$data['jumlahHari'] = (int)$interval->format('%a');

			$data['tanggalawalformatindo'] 	= date('d-M-Y',strtotime($tanggalawal));
			$data['tanggalakhirformatindo']	= date('d-M-Y',strtotime($tanggalakhir));

			$data['perlakuan'] = $this->M_limbahtransaksi->getPerlakuan();
            $data['filter_data'] = $this->M_limbahtransaksi->filterData($tanggalawal,$tanggalakhir,$jenisLimbah);
            
            $this->load->view('WasteManagement/LimbahTransaksi/V_ExcelHarian', $data, true);
    }

    public function cetakExcelBulanan($tanggalawallink,$tanggalakhirlink)
    {
            $this->load->library("Excel");

            $tanggalawalx = str_replace('.', '-', $tanggalawallink);
            $tanggalakhirx = str_replace('.', '-', $tanggalakhirlink);

            $tanggalawal = $this->input->post('excelTglAwal');
            $tanggalakhir = $this->input->post('excelTglAkhir');
            $jenisLimbah = $this->input->post('exceljenislimbah'); 

			if($tanggalawal == '') $tanggalawal = '';
			if($tanggalakhir == '') $tanggalakhir = '';
			if($jenisLimbah == null) $jenisLimbah == ''; 

			$data['tanggalawal'] = $tanggalawal; 
			$data['tanggalakhir'] = $tanggalakhir; 

			$listBulan = array();
			$tgl = date("Ym", strtotime($data['tanggalawal']));
			while($tgl <= date("Ym", strtotime($data['tanggalakhir']))){
				$hasil = substr($tgl, 4);
				array_push($listBulan, $hasil);
			    if(substr($tgl, 4, 2) == "12")
			        $tgl = (date("Y", strtotime($tgl."01")) + 1)."01";
			    else
			        $tgl++;
			}
			
			$data['listBulan']=array();
			foreach ($listBulan as $i => $bulan) {
				if($bulan == '01') {
					$bulan = 'Januari';
				}elseif($bulan == '02') {
					$bulan = 'Februari';
				}elseif($bulan == '03') {
					$bulan = 'Maret';
				}elseif($bulan == '04') {
					$bulan = 'April';
				}elseif($bulan == '05') {
					$bulan = 'Mei';
				}elseif($bulan == '06') {
					$bulan = 'Juni';
				}elseif($bulan == '07') {
					$bulan = 'Juli';
				}elseif($bulan == '08') {
					$bulan = 'Agustus';
				}elseif($bulan == '09') {
					$bulan = 'September';
				}elseif($bulan == '10') {
					$bulan = 'Oktober';
				}elseif($bulan == '11') {
					$bulan = 'November';
				}elseif($bulan == '12') {
					$bulan = 'Desember';
				}																				
				array_push($data['listBulan'], $bulan);
															
			}

			$data['tanggalawalformatindo'] 	= date('d-F-Y',strtotime($tanggalawal));
			$data['tanggalakhirformatindo']	= date('d-F-Y',strtotime($tanggalakhir));

			$tglindo1 = explode('-', $data['tanggalawalformatindo']);
			$tglindo2 = explode('-', $data['tanggalakhirformatindo']);

			$data['tglindo1'] = $tglindo1[1].' - '.$tglindo1[2];
			$data['tglindo2'] = $tglindo2[1].' - '.$tglindo2[2];

			$data['perlakuan'] = $this->M_limbahtransaksi->getPerlakuan();
			$data['jumlahlimbah'] = $this->M_limbahtransaksi->TotalLimbahBulanan();
            $data['filter_data'] = $this->M_limbahtransaksi->filterData($tanggalawal,$tanggalakhir,$jenisLimbah);
            
            $this->load->view('WasteManagement/LimbahTransaksi/V_ExcelBulanan', $data, true);
    }

	public function Record()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Masuk';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['data'] = $this->M_limbahtransaksi->getLimbahTransaksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataRecord()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Masuk';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenislimbah = $this->input->post('jenis_limbah',true);

		$periode = $this->input->post('periode', true);
		if($periode == '') {
			$tanggalawal = '';
			$tanggalakhir = '';
		} else {
			$periode = explode('-', $periode);

			$buattanggalawal 	= str_replace('/', '-', $periode[0]);
			$buattanggalakhir	= str_replace('/', '-', $periode[1]);
			$tanggalawal 		= date('Y-m-d', strtotime($buattanggalawal));
			$tanggalakhir 		= date('Y-m-d', strtotime($buattanggalakhir));
		}
		
		$data['tanggalawal'] = $tanggalawal;
		$data['tanggalakhir']= $tanggalakhir;
		$data['jenislimbah'] = $jenislimbah;

		$data['jenis_limbah']= $this->M_limbahtransaksi->getJenisLimbah();
		$data['filter_data'] = $this->M_limbahtransaksi->filterData($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahTransaksi/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

}

/* End of file C_LimbahTransaksi.php */
/* Location: ./application/controllers/WasteManagement/MainMenu/C_LimbahTransaksi.php */
/* Generated automatically on 2017-08-01 11:38:56 */