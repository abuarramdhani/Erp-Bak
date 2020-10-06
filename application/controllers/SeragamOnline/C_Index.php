<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* bagian awal dari menu seragam online
* IDE AWAL
* hanya menggunakan 1 view SeragamOnline/MasterData/V_Tipe_Baju
* menggunakan js/ajax sebagai CRUD nya
*/
class C_Index extends CI_Controller
{
	
	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        $this->load->library('General');
        //load the login model
        $this->load->library('session');

        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('SeragamOnline/M_seragam');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    public function index()
    {
    	$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Seragam Online', '', '', '');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SeragamOnline/V_Index',$data);
		$this->load->view('V_Footer',$data);
    }

    public function TipeBaju()
    {
        $user_id = $this->session->userid;
        
        $data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Tipe Baju', 'Master Data', 'Tipe Baju', '');
        $data['tabel'] = 'ttipe_baju';
        $data['info'] = 'Tipe Baju';
        
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('SeragamOnline/MasterData/V_Tipe_Baju',$data);
        $this->load->view('V_Footer',$data);
    }

    public function JenisBaju()
    {
        $user_id = $this->session->userid;
        
        $data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Jenis Baju', 'Master Data', 'Jenis Baju', '');
        $data['jnsBaju'] = $this->M_seragam->getJnsBaju();
        $data['tpBaju'] = $this->M_seragam->getTipeBaju('ttipe_baju', '*');
        $data['info'] = 'Jenis Baju';

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('SeragamOnline/MasterData/V_Jenis_Baju',$data);
        $this->load->view('V_Footer',$data);
    }

    public function Ukuran()
    {
        $user_id = $this->session->userid;
        
        $data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Ukuran', 'Master Data', 'Ukuran', '');
        $data['tabel'] = 'tukuran';
        $data['info'] = 'Ukuran';

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('SeragamOnline/MasterData/V_Tipe_Baju',$data);
        $this->load->view('V_Footer',$data);
    }

    public function JenisCelana()
    {
        $user_id = $this->session->userid;
        
        $data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Jenis Celana', 'Master Data', 'Jenis Celana', '');
        $data['tabel'] = 'tjenis_celana';
        $data['info'] = 'Jenis Celana';

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('SeragamOnline/MasterData/V_Tipe_Baju',$data);
        $this->load->view('V_Footer',$data);
    }

    public function JenisTopi()
    {
        $user_id = $this->session->userid;
        
        $data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Jenis Topi', 'Master Data', 'Jenis Topi', '');
        $data['tabel'] = 'tjenis_topi';
        $data['info'] = 'Jenis Topi';

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('SeragamOnline/MasterData/V_Tipe_Baju',$data);
        $this->load->view('V_Footer',$data);
    }


    public function getTableTipe()
    {
        /*
        $tabel berasal dati tabel yang di masukkan di fungsi getTableMasterOs
        berasal dari view masing2 maseter data misal getTableMasterOs('ttipe_baju');
        */
        $tabel = $this->input->post('tabel');
        if ($tabel == 'ttipe_baju') {
            $value = "id, tipe txt, satuan";
        }elseif ($tabel == 'tukuran') {
            $value = "id, ukuran txt";
        }else{
             $value = "id, jenis txt";
        }

        switch ($tabel) {//daftar table erp.so
            case "ttipe_baju":
            $kolom =  "Tipe Baju";
            $kolom2 =  "Satuan";
            break;
            case "tjenis_baju":
            $kolom =  "Jenis Baju";
            $kolom2 =  "";
            break;
            case "tukuran":
            $kolom =  "Ukuran";
            $kolom2 =  "";
            break;
            case "tjenis_celana":
            $kolom =  "Jenis Celana";
            $kolom2 =  "";
            break;
            case "tjenis_topi":
            $kolom =  "Jenis Topi";
            $kolom2 =  "";
            break;
            default:
            $kolom =  "???";
            $kolom2 =  "";
        }

        $data['kolom'] = $kolom;
        $data['kolom2'] = $kolom2;
        $data['list'] = $this->M_seragam->getTipeBaju($tabel, $value);
        $html = $this->load->view('SeragamOnline/MasterData/V_Tipe_Baju_Tabel', $data);
        echo json_encode($html);
    }

    public function addTableTipe()
    {
        $tabel = $this->input->post('tabel');
        if ($tabel == 'ttipe_baju') {
            $data['tipe'] = $this->input->post('data');
            $data['satuan'] = $this->input->post('satuan');
        }elseif ($tabel == 'tjenis_baju') {
            $data['jenis'] = $this->input->post('jnsBaju');
            $data['id_tipe_baju'] = $this->input->post('jnsTipe');
        }elseif ($tabel == 'tukuran') {
            $data['ukuran'] = $this->input->post('data');
        }else{
            $data['jenis'] = $this->input->post('data');
        }
        $ins = $this->M_seragam->inMaster($tabel, $data);
        if ($ins == 'oke') {
            $d['text'] = 'Data Berhasil Di Tambahkan';
        }else{
            $d['text'] = 'Terjadi Kesalahan (Error)!';
        }
        echo json_encode($d);
    }

    public function addTableTipeNoajax()
    {
        $redirect = '';
        $tabel = $this->input->post('tabel');
        if ($tabel == 'tjenis_baju') {
            $data['jenis'] = $this->input->post('jnsBaju');
            $data['id_tipe_baju'] = $this->input->post('jnsTipe');
            $redirect = 'SeragamOnline/MasterData/JenisBaju';
        }
        $ins = $this->M_seragam->inMaster($tabel, $data);
        redirect($redirect);
    }

    public function edTableTipe()
    {
        $id = $this->input->post('id');
        $tabel = $this->input->post('tabel');
        if ($tabel == 'ttipe_baju') {
            $data['tipe'] = $this->input->post('data');
            $data['satuan'] = $this->input->post('satuan');
        }elseif ($tabel == 'tukuran') {
            $data['ukuran'] = $this->input->post('data');
        }else{
            $data['jenis'] = $this->input->post('data');
        }
        $up = $this->M_seragam->upMaster($tabel, $data, $id);
        if ($up == 'oke') {
            $d['text'] = 'Data Berhasil Di Edit';
        }else{
            $d['text'] = 'Terjadi Kesalahan (Error)!';
        }
        echo json_encode($d);
    }
    public function edTableTipenoAjax()
    {
        $id = $this->input->post('id');
        $redirect = '';
        $tabel = $this->input->post('tabel');
        if ($tabel == 'tjenis_baju') {
            $data['jenis'] = $this->input->post('jnsBaju');
            $data['id_tipe_baju'] = $this->input->post('jnsTipe');
            $redirect = 'SeragamOnline/MasterData/JenisBaju';
        }
        $ins = $this->M_seragam->upMaster($tabel, $data, $id);
        redirect($redirect);
    }

    public function delTableTipe()
    {
        $id = $this->input->post('id');
        $tabel = $this->input->post('tabel');
        $del = $this->M_seragam->delMaster($tabel, $id);
        if ($del == 'oke') {
            $d['text'] = 'Data Berhasil Di Hapus';
        }else{
            $d['text'] = 'Terjadi Kesalahan (Error)!';
        }
        echo json_encode($d);
    }
}