<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiKlaimSisaCuti extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiKlaimSisaCuti/M_transaksiklaimsisacuti');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $transaksiKlaimSisaCuti = $this->M_transaksiklaimsisacuti->get_all();

        $data['transaksiKlaimSisaCuti_data'] = $transaksiKlaimSisaCuti;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_transaksiklaimsisacuti->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_cuti' => $row->id_cuti,
				'noind' => $row->noind,
				'periode' => $row->periode,
				'sisa_cuti' => $row->sisa_cuti,
				'jumlah_klaim' => $row->jumlah_klaim,
				'kode_petugas' => $row->kode_petugas,
				'tgl_jam_record' => $row->tgl_jam_record,
				'kd_jns_transaksi' => $row->kd_jns_transaksi,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Payroll Management',
            'SubMenuOne' => '',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/TransaksiKlaimSisaCuti/save'),
				'id_cuti' => set_value(''),
			'noind' => set_value('noind'),
			'periode' => set_value('periode'),
			'sisa_cuti' => set_value('sisa_cuti'),
			'jumlah_klaim' => set_value('jumlah_klaim'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_jam_record' => set_value('tgl_jam_record'),
			'pr_jns_transaksi_data' => $this->M_transaksiklaimsisacuti->get_pr_jns_transaksi_data(),
			'kd_jns_transaksi' => set_value('kd_jns_transaksi'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
        $data = array(
			'noind' => $this->input->post('txtNoind',TRUE),
			'periode' => $this->input->post('txtPeriode',TRUE),
			'sisa_cuti' => $this->input->post('txtSisaCuti',TRUE),
			'jumlah_klaim' => $this->input->post('txtJumlahKlaim',TRUE),
			'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
			'tgl_jam_record' => date('Y-m-d H:i:s'),
			'kd_jns_transaksi' => $this->input->post('cmbKdJnsTransaksi',TRUE),
		);

            $this->M_transaksiklaimsisacuti->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_transaksiklaimsisacuti->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/TransaksiKlaimSisaCuti/saveUpdate'),
				'pr_jns_transaksi_data' => $this->M_transaksiklaimsisacuti->get_pr_jns_transaksi_data(),
				'id_cuti' => set_value('cmbIdCuti', $row->id_cuti),
				'noind' => set_value('cmbNoind', $row->noind),
				'periode' => set_value('cmbPeriode', $row->periode),
				'sisa_cuti' => set_value('cmbSisaCuti', $row->sisa_cuti),
				'jumlah_klaim' => set_value('cmbJumlahKlaim', $row->jumlah_klaim),
				'kode_petugas' => set_value('cmbKodePetugas', $row->kode_petugas),
				'tgl_jam_record' => set_value('cmbTglJamRecord', $row->tgl_jam_record),
				'kd_jns_transaksi' => set_value('cmbKdJnsTransaksi', $row->kd_jns_transaksi),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        if ($this->form_validation->run() == FALSE) {
            $this->update();
        }
        else{
            $data = array(
				'noind' => $this->input->post('txtNoind',TRUE),
				'periode' => $this->input->post('txtPeriode',TRUE),
				'sisa_cuti' => $this->input->post('txtSisaCuti',TRUE),
				'jumlah_klaim' => $this->input->post('txtJumlahKlaim',TRUE),
				'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
				'tgl_jam_record' => $this->input->post('txtTglJamRecord',TRUE),
				'kd_jns_transaksi' => $this->input->post('cmbKdJnsTransaksi',TRUE),
			);

            $this->M_transaksiklaimsisacuti->update($this->input->post('txtIdCuti', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_transaksiklaimsisacuti->get_by_id($id);

        if ($row) {
            $this->M_transaksiklaimsisacuti->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function checkSession(){
        if($this->session->is_logged){
            
        }else{
            redirect(site_url());
        }
    }

    public function formValidation()
    {
	}

}

/* End of file C_TransaksiKlaimSisaCuti.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti.php */
/* Generated automatically on 2016-11-28 14:06:59 */