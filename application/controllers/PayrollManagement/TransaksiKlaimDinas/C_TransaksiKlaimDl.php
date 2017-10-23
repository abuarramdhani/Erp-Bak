<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiKlaimDl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiKlaimDinas/M_transaksiklaimdl');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
		$this->load->library('Encrypt');
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
        $transaksiKlaimDl = $this->M_transaksiklaimdl->get_all();

        $data['transaksiKlaimDl_data'] = $transaksiKlaimDl;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiKlaimDl/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_import');
		$this->session->unset_userdata('success_delete');
		$this->session->unset_userdata('success_update');
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('not_found');
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_transaksiklaimdl->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_klaim_dl' => $row->id_klaim_dl,
				'tanggal' => $row->tanggal,
				'noind' => $row->noind,
				'klaim_dl' => $row->klaim_dl,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimDl/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
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
            'action' => site_url('PayrollManagement/TransaksiKlaimDl/save'),
				'id_klaim_dl' => set_value(''),
			'tanggal' => set_value('tanggal'),
			'noind' => set_value('noind'),
			'klaim_dl' => set_value('klaim_dl'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiKlaimDl/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

        if ($this->form_validation->run() == FALSE) {
            // $this->create();
			echo "test";
        }
        else{
			$dt = explode("/",$this->input->post('txtTglTransaksi',TRUE));
			$varTgl = $dt[2]."-".$dt[1]."-".$dt[0];
            $data = array(
				'id_klaim_dl' => date('YmdHis'),
				'tanggal' => $varTgl,
				'noind' => $this->input->post('txtNoind',TRUE),
				'klaim_dl' => str_replace('.','',$this->input->post('txtKlaimDl',TRUE)),
			);

            $this->M_transaksiklaimdl->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        }
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_transaksiklaimdl->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/TransaksiKlaimDl/saveUpdate'),
				'id_klaim_dl' => set_value('txtIdKlaimDl', $row->id_klaim_dl),
				'tanggal' => set_value('txtTanggal', date("d/m/Y",strtotime($row->tanggal))),
				'noind' => set_value('txtNoind', $row->noind),
				'klaim_dl' => set_value('txtKlaimDl', number_format((int)$row->klaim_dl,0,",",".")),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimDl/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        if ($this->form_validation->run() == FALSE) {
            $this->update();
        }
        else{
			$dt = explode("/",$this->input->post('txtTglTransaksi',TRUE));
			$varTgl = $dt[2]."-".$dt[1]."-".$dt[0];
            $data = array(
				'tanggal' => $varTgl,
				'noind' => $this->input->post('txtNoind',TRUE),
				'klaim_dl' => str_replace('.','',$this->input->post('txtKlaimDl',TRUE)),
			);

            $this->M_transaksiklaimdl->update($this->input->post('txtIdKlaimDl', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        }
    }

    public function delete($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_transaksiklaimdl->get_by_id($id);

        if ($row) {
            $this->M_transaksiklaimdl->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
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
		$this->form_validation->set_rules('txtKlaimDl', 'varchar');
	}

}

/* End of file C_TransaksiKlaimDl.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiKlaimDinas/C_TransaksiKlaimDl.php */
/* Generated automatically on 2016-11-30 09:42:19 */