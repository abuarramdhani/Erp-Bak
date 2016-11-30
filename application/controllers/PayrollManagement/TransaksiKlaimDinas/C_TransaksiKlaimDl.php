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
            $this->create();
        }
        else{
            $data = array(
				'tanggal' => $this->input->post('txtTanggal',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'klaim_dl' => $this->input->post('txtKlaimDl',TRUE),
			);

            $this->M_transaksiklaimdl->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        }
    }

    public function update($id)
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
                'action' => site_url('PayrollManagement/TransaksiKlaimDl/saveUpdate'),
				'id_klaim_dl' => set_value('txtIdKlaimDl', $row->id_klaim_dl),
				'tanggal' => set_value('txtTanggal', $row->tanggal),
				'noind' => set_value('txtNoind', $row->noind),
				'klaim_dl' => set_value('txtKlaimDl', $row->klaim_dl),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimDl/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
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
            $data = array(
				'tanggal' => $this->input->post('txtTanggal',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'klaim_dl' => $this->input->post('txtKlaimDl',TRUE),
			);

            $this->M_transaksiklaimdl->update($this->input->post('txtIdKlaimDl', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_transaksiklaimdl->get_by_id($id);

        if ($row) {
            $this->M_transaksiklaimdl->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/TransaksiKlaimDl'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
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
		$this->form_validation->set_rules('txtKlaimDl', 'Klaim Dl', 'integer');
	}

}

/* End of file C_TransaksiKlaimDl.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiKlaimDinas/C_TransaksiKlaimDl.php */
/* Generated automatically on 2016-11-30 09:42:19 */