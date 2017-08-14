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
		$this->load->model('GeneralAffair/MainMenu/M_limbahkeluar');

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

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/LimbahKeluar/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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
			$this->load->view('GeneralAffair/LimbahKeluar/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'tanggal_keluar' => date("Y-m-d", strtotime($this->input->post('txtTanggalKeluarHeader'))),
				'jumlah_keluar' => $this->input->post('txtJumlahKeluarHeader'),
				'tujuan_limbah' => $this->input->post('txtTujuanLimbahHeader'),
				'nomor_dok' => $this->input->post('txtNomorDokHeader'),
				'sisa_limbah' => $this->input->post('txtSisaLimbahHeader'),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'creation_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'jenis_limbah' => $this->input->post('cmbJenisLimbahHeader'),
    		);
			$this->M_limbahkeluar->setLimbahKeluar($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/LimbahKeluar'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtTanggalKeluarHeader', 'tanggal', 'required');
		$this->form_validation->set_rules('txtTujuanLimbahHeader', 'tujuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/LimbahKeluar/V_update', $data);
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
				'jenis_limbah' => $this->input->post('cmbJenisLimbahHeader',TRUE),
    			);
			$this->M_limbahkeluar->updateLimbahKeluar($data, $plaintext_string);

			redirect(site_url('GeneralAffair/LimbahKeluar'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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
		$this->load->view('GeneralAffair/LimbahKeluar/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->deleteLimbahKeluar($plaintext_string);

		redirect(site_url('GeneralAffair/LimbahKeluar'));
    }

    public function kirimApprove($id)
    {
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->approval($plaintext_string);

		redirect(site_url('GeneralAffair/LimbahKeluar'));
    }

    public function kirimReject($id)
    {
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkeluar->reject($plaintext_string);

		redirect(site_url('GeneralAffair/LimbahKeluar'));	
    }

	public function Record()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/LimbahKeluar/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataRecord()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Record Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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
		$data['filter_data'] = $this->M_limbahkeluar->filterData($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/LimbahKeluar/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Report()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Report Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_limbahkeluar->getLimbahKeluar();
		$data['jenis_limbah']= $this->M_limbahkeluar->getJenisLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/LimbahKeluar/V_Report', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FilterDataReport()
	{	
		$user_id = $this->session->userid;

		$data['Title'] = 'Report Limbah Keluar';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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
		$data['filter_data'] = $this->M_limbahkeluar->filterData($tanggalawal,$tanggalakhir,$jenislimbah);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/LimbahKeluar/V_Report', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakExcel()
    {
            $this->load->library("Excel/PHPExcel");

            $tanggalawal = $this->input->post('excelTglAwal');
            $tanggalakhir = $this->input->post('excelTglAkhir');
            $jenisLimbah = $this->input->post('exceljenislimbah'); 
			if($tanggalawal == '') $tanggalawal = '';
			if($tanggalakhir == '') $tanggalakhir = '';
			if($jenisLimbah == null) $jenisLimbah == ''; 

            $data['filter_data'] = $this->M_limbahkeluar->filterData($tanggalawal,$tanggalakhir,$jenisLimbah);
           
            $this->load->view('GeneralAffair/LimbahKeluar/V_Excel', $data, true);
    } 


}

/* End of file C_LimbahKeluar.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_LimbahKeluar.php */
/* Generated automatically on 2017-08-09 12:34:02 */