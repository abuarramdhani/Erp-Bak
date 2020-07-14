<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_LimbahKeluar extends CI_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_limbahkeluar');

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

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();
		$data['perlakuan']= $this->M_limbahkeluar->getPerlakuan();
		$data['satuan'] = $this->M_limbahkeluar->getSatuan();

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtTanggalKeluarHeader', 'tanggal', 'required');
		$this->form_validation->set_rules('txtTujuanLimbahHeader', 'tujuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahKeluar/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_keluar' => date("Y-m-d", strtotime($this->input->post('txtTanggalKeluarHeader'))),
				'jumlah_keluar' => $this->input->post('txtJumlahKeluarHeader', TRUE),
				'tujuan_limbah' => $this->input->post('txtTujuanLimbahHeader', TRUE),
				'nomor_dok' => $this->input->post('txtNomorDokHeader', TRUE),
				'sisa_limbah' => $this->input->post('txtSisaLimbahHeader', TRUE),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'creation_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'jenis_limbah' => $this->input->post('cmbJenisLimbahKeluarHeader', TRUE),
				'perlakuan' => $this->input->post('cmbPerlakuanHeader',TRUE),
				'satuan' => $this->input->post('cmbSatuanHeader', TRUE),
				'sumber_limbah' => $this->input->post('cmbJenisSumberHeader', TRUE),
    		);

			$this->M_limbahkeluar->setLimbahKeluar($data);

			redirect(base_url('WasteManagement/LimbahKeluar'));
		} 
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahKeluar'] = $this->M_limbahkeluar->getLimbahKeluar($plaintext_string);
		$data['jenis_limbah'] = $this->M_limbahkeluar->getJenisLimbah();
		$data['perlakuan']= $this->M_limbahkeluar->getPerlakuan();
		$data['satuan'] = $this->M_limbahkeluar->getSatuan();

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtTanggalKeluarHeader', 'tanggal', 'required');
		$this->form_validation->set_rules('txtTujuanLimbahHeader', 'tujuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahKeluar/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_keluar' => date('Y-m-d',strtotime($this->input->post('txtTanggalKeluarHeader',TRUE))),
				'jumlah_keluar' => $this->input->post('txtJumlahKeluarHeader',TRUE),
				'tujuan_limbah' => $this->input->post('txtTujuanLimbahHeader',TRUE),
				'nomor_dok' => $this->input->post('txtNomorDokHeader',TRUE),
				'sisa_limbah' => $this->input->post('txtSisaLimbahHeader',TRUE),
				'last_updated' => date('Y-m-d h:i:s'),
				'last_updated_by' => $this->session->userid,
				'jenis_limbah' => $this->input->post('cmbJenisLimbahKeluarHeader',TRUE),
				'perlakuan' => $this->input->post('cmbPerlakuanHeader',TRUE),
				'satuan' => $this->input->post('cmbSatuanHeader', TRUE),
				'sumber_limbah' => $this->input->post('cmbJenisSumberHeader', TRUE),
    			);
			$this->M_limbahkeluar->updateLimbahKeluar($data, $plaintext_string);

			redirect(base_url('WasteManagement/LimbahKeluar'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahKeluar'] = $this->M_limbahkeluar->getLimbahKeluar($plaintext_string);
		$data['User'] = $this->M_limbahkeluar->getUser();

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->deleteLimbahKeluar($plaintext_string);

		redirect(base_url('WasteManagement/LimbahKeluar'));
    }

    public function kirimApprove($id)
    {
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->approval($plaintext_string);

		redirect(site_url('WasteManagement/LimbahKeluar'));
    }

    public function kirimReject($id)
    {
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->reject($plaintext_string);

		redirect(site_url('WasteManagement/LimbahKeluar'));	
    }

	public function Record()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Keluar';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Keluar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['limbah_keluar'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataRecord()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Keluar';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Keluar';
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

		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();
		$data['filterKeluar'] = $this->M_limbahkeluar->filterLimbahKeluar($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Report()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Logbook Harian';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Logbook Harian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['limbah_keluar'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['limbah_masuk'] = $this->M_limbahkeluar->getLimbahTransaksi();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();
		$data['user_name'] = $this->M_limbahkeluar->getUser();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Logbook', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataReport()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Logbook Harian Limbah B3';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Logbook Harian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenislimbah = $this->input->post('jenis_limbah',true);
		$username = $this->input->post('user_name',true);

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
		$data['tanggalakhir'] = $tanggalakhir;
		$data['jenislimbah'] = $jenislimbah;
		$data['NamaUser'] = $username;

		$data['tanggalawalformatindo'] 	= date('d-m-Y',strtotime($tanggalawal));
		$data['tanggalakhirformatindo']	= date('d-m-Y',strtotime($tanggalakhir));

		$data['jenis_limbah'] = $this->M_limbahkeluar->getJenisLimbah();
		$data['user_name'] = $this->M_limbahkeluar->getUser();
		$data['filterMasuk'] = $this->M_limbahkeluar->filterLimbahMasuk($tanggalawal,$tanggalakhir,$jenislimbah); 
		$data['filterKeluar'] = $this->M_limbahkeluar->filterLimbahKeluar($tanggalawal,$tanggalakhir,$jenislimbah); 

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKeluar/V_Logbook', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakExcel($tanggalawallink,$tanggalakhirlink)
    {
            $this->load->library("Excel");

            $tanggalawalx = str_replace('.', '-', $tanggalawallink);
            $tanggalakhirx = str_replace('.', '-', $tanggalakhirlink);

            $tanggalawal = $this->input->post('excelTglAwal');
            $tanggalakhir = $this->input->post('excelTglAkhir');
            $jenisLimbah = $this->input->post('exceljenislimbah');
            $UserName = $this->input->post('excelusername'); 

			if($tanggalawal == '') $tanggalawal = '';
			if($tanggalakhir == '') $tanggalakhir = '';
			if($jenisLimbah == null) $jenisLimbah == '';

			$data['tanggalawal'] = $tanggalawal; 
			$data['tanggalakhir'] = $tanggalakhir;
			$data['user'] = $UserName;

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

			$allBulan = '';
			$jmlBulan = count($data['listBulan']);
			for($b = 0; $b < $jmlBulan; $b++) {
				if($b == ($jmlBulan-1)) {
					$allBulan .= $data['listBulan'][$b];
				} else {
					$allBulan .= $data['listBulan'][$b].', ';	
				}
			}

			$data['allBulan'] = $allBulan;

            $data['filterMasuk'] = $this->M_limbahkeluar->filterLimbahMasuk($tanggalawal,$tanggalakhir,$jenisLimbah); 
			$data['filterKeluar'] = $this->M_limbahkeluar->filterLimbahKeluar($tanggalawal,$tanggalakhir,$jenisLimbah);
           
            $this->load->view('WasteManagement/LimbahKeluar/V_Excel', $data, true);
    }

    public function selectJenisLimbah(){
		$JenisLimbah_id = $this->input->post('cmbJenisLimbahKeluarHeader');
		$SatuanLimbahKeluar = $this->M_limbahkeluar->selectSatuanLimbah($JenisLimbah_id);
		$SumberLimbahKeluar = $this->M_limbahkeluar->selectSumberLimbah($JenisLimbah_id);

		foreach ($SatuanLimbahKeluar as $SL) {
			$data['limbah_satuan'] = $SL['limbah_satuan'];
		}

		foreach ($SumberLimbahKeluar as $Sumber) {
			$data['sumber'] = $Sumber['sumber'];
		}
		
		echo json_encode($data);
	}

	public function ApproveLimbahKeluar(){
		$this->checkSession();

		$id_lines = $this->input->post('idKeluar');
		$idLimbah = explode(',', $id_lines);
		for ($i=0; $i < (count($idLimbah)-1); $i++) { 
			$id = $idLimbah[$i];
			$this->M_limbahkeluar->approval($id);
		}

		echo json_encode(true);
	}

	public function RejectLimbahKeluar(){
		$this->checkSession();

		$id_lines = $this->input->post('idKeluar');
		$idLimbah = explode(',', $id_lines);
		for ($i=0; $i < (count($idLimbah)-1); $i++) { 
			$id = $idLimbah[$i];
			$this->M_limbahkeluar->reject($id);
		}

		echo json_encode(true);
	} 

}

/* End of file C_LimbahKeluar.php */
/* Location: ./application/controllers/WasteManagement/MainMenu/C_LimbahKeluar.php */
/* Generated automatically on 2017-08-09 12:34:02 */