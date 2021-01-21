<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Setting extends CI_Controller
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
		$this->load->model('PendaftaranMasterItem/M_settingdata');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Setting Data';
		$data['Menu'] = 'Setting Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view']   = 'piea';
        $data['seksi']  = $this->M_settingdata->dataseksi('order by id_seksi desc');
        $data['uom']    = $this->M_settingdata->datauom('order by id_uom desc');
        $data['email']  = $this->M_settingdata->dataEmail("where username = 'PIEA'"); // untuk modal tambah email save email di c_settingemail folder tim kode barang
        $data['org']    = $this->M_settingdata->dataorg('order by group_name');
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_SettingData', $data);
		$this->load->view('V_Footer',$data);
    }
    
	public function getseksi(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_settingdata->getseksi($term);
		echo json_encode($data);
	}
    
    public function tambahseksi(){
		$this->load->view('PendaftaranMasterItem/V_ModalTambahSeksi');
    }
    
    public function tambahuom(){
		$this->load->view('PendaftaranMasterItem/V_ModalTambahUOM');
    }
    
    public function tambahorg(){
		$this->load->view('PendaftaranMasterItem/V_ModalTambahOrg');
    }
    
    public function editorg(){
        $data['id']     = $this->input->post('id');
        $getdata        = $this->M_settingdata->dataorg('where id_org = '.$data['id'].'');
        $data['data']   = $getdata;
        $data['org']    = explode("; ", $getdata[0]['ORG_ASSIGN']);

		$this->load->view('PendaftaranMasterItem/V_ModalEditOrg', $data);
    }

    public function saveseksi(){
        $seksi  = $this->input->post('seksi');
        $kode   = strtoupper($this->input->post('kode_seksi'));
        $cekid  = $this->M_settingdata->dataseksi('order by id_seksi desc');
        $id     = !empty($cekid) ? $cekid[0]['ID_SEKSI'] + 1 : 1;

        $cekseksi = $this->M_settingdata->dataseksi("where kode_seksi = '$kode' or nama_seksi = '$seksi'");
        if (empty($cekseksi)) {
            $this->M_settingdata->saveseksi($id, $kode, $seksi);
        }

		redirect(base_url('MasterItemPIEA/SettingData/'));
    }
    
    public function saveuom(){
        $uom    = $this->input->post('uom');
        $kode   = strtoupper($this->input->post('kode_uom'));
        $cekid  = $this->M_settingdata->datauom('order by id_uom desc');
        $id     = !empty($cekid) ? $cekid[0]['ID_UOM'] + 1 : 1;

        $cekuom = $this->M_settingdata->datauom("where kode_uom = '$kode' or uom = '$uom'");
        if (empty($cekuom)) {
            $this->M_settingdata->saveuom($id, $kode, $uom);
        }
		redirect(base_url('MasterItemPIEA/SettingData/'));
    }

    public function cekORG(){
        $nama = $this->input->post('nama');
        $cek = $this->M_settingdata->dataORG("where group_name = '".$nama."' ");
        $hasil = empty($cek) ? 'tidak' : 'ada';
        echo json_encode($hasil);
    }
    
    public function saveorg(){
        $name       = strtoupper($this->input->post('nama'));
        $org_assign = $this->input->post('org_assign[]');
        $list = '';
        for ($i=0; $i < count($org_assign) ; $i++) { 
            $list .= $i == 0 ? $org_assign[0] : '; '.$org_assign[$i];
        }
        $cekid      = $this->M_settingdata->dataorg('order by id_org desc');
        $id         = !empty($cekid) ? $cekid[0]['ID_ORG'] + 1 : 1;

        $cekorg = $this->M_settingdata->dataorg("where group_name = '$name'");
        if (empty($cekorg)) {
            $this->M_settingdata->saveorg($id, $name, $list);
        }
        redirect(base_url('MasterItemPIEA/SettingData/'));
    }
    
    public function updateorg(){
        $id         = $this->input->post('id_group');
        $name       = strtoupper($this->input->post('nama'));
        $org_assign = $this->input->post('org_assign[]');
        $list = '';
        for ($i=0; $i < count($org_assign) ; $i++) { 
            $list .= $i == 0 ? $org_assign[0] : '; '.$org_assign[$i];
        }
        
        $this->M_settingdata->updateorg($id, $name, $list);
        
        redirect(base_url('MasterItemPIEA/SettingData/'));
    }

    public function deleteseksi(){
        $id     = $this->input->post('id');
        $kode   = $this->input->post('kode');
        $this->M_settingdata->delseksi($id, $kode);
    }
    
    public function deleteuom(){
        $id     = $this->input->post('id');
        $kode   = $this->input->post('kode');
        $this->M_settingdata->deluom($id, $kode);
    }
    
    public function deleteorg(){
        $id     = $this->input->post('id');
        $kode   = $this->input->post('nama');
        $this->M_settingdata->delorg($id, $kode);
    }


}