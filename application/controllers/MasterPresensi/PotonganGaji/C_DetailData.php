<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_DetailData extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        if(!$this->session->is_logged){ redirect(''); }
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/PotonganGaji/M_detaildata');
    }
    
	public function index() {
        $potonganId = $this->input->post('potonganId');
        if(empty($potonganId)) { echo '<b>Tidak dapat menerima ID potongan...</b>'; die; }
		$data['UserMenu'] = $this->M_user->getUserMenu($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->session->userid, $this->session->responsibility_id);
        $data['Title'] = 'Detail Data';
        $data['Menu'] = $data['SubMenuOne'] = $data['SubMenuTwo'] = null;
        $potongan = $this->M_detaildata->getPotongan($potonganId);
        $data['potonganId'] = $potonganId;
        $data['pekerja'] = $potongan->noind.' - '.$potongan->nama;
        $data['tipePembayaran'] = $potongan->tipe_pembayaran;
        $data['jenisPotongan'] = $potongan->jenis_potongan;
        $data['periode'] = date('F Y', strtotime($potongan->periode_mulai_potong));
        $data['nominalTotal'] = $potongan->nominal_total;
        $data['simulasi'] = $this->M_detaildata->getPotonganDetail($potonganId);
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPresensi/PotonganGaji/V_DetailData', $data);
		$this->load->view('V_Footer', $data);
	}
}