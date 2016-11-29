<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_KompTamb extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/KomponenTambahan/M_komptamb');
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
        $kompTamb = $this->M_komptamb->get_all();

        $data['kompTamb_data'] = $kompTamb;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTamb/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_komptamb->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id' => $row->id,
				'periode' => $row->periode,
				'noind' => $row->noind,
				'tambahan' => $row->tambahan,
				'stat' => $row->stat,
				'desc_' => $row->desc_,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTamb/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KompTamb'));
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
            'action' => site_url('PayrollManagement/KompTamb/save'),
				'id' => set_value(''),
			'periode' => set_value('periode'),
			'pr_master_pekerja_data' => $this->M_komptamb->get_pr_master_pekerja_data(),
			'noind' => set_value('noind'),
			'tambahan' => set_value('tambahan'),
			'stat' => set_value('stat'),
			'desc_' => set_value('desc_'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTamb/V_form', $data);
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
				'periode' => $this->input->post('txtPeriode',TRUE),
				'noind' => $this->input->post('cmbNoind',TRUE),
				'tambahan' => $this->input->post('txtTambahan',TRUE),
				'stat' => $this->input->post('cmbStat',TRUE),
				'desc_' => $this->input->post('txtDesc',TRUE),
			);

            $this->M_komptamb->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/KompTamb'));
        }
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_komptamb->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/KompTamb/saveUpdate'),
				'id' => set_value('txtId', $row->id),
				'periode' => set_value('txtPeriode', $row->periode),
				'noind' => set_value('txtNoind', $row->noind),
				'tambahan' => set_value('txtTambahan', $row->tambahan),
				'stat' => set_value('txtStat', $row->stat),
				'desc_' => set_value('txtDesc', $row->desc_),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTamb/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KompTamb'));
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
				'periode' => $this->input->post('txtPeriode',TRUE),
				'noind' => $this->input->post('cmbNoind',TRUE),
				'tambahan' => $this->input->post('txtTambahan',TRUE),
				'stat' => $this->input->post('cmbStat',TRUE),
				'desc_' => $this->input->post('txtDesc',TRUE),
			);

            $this->M_komptamb->update($this->input->post('txtId', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/KompTamb'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_komptamb->get_by_id($id);

        if ($row) {
            $this->M_komptamb->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/KompTamb'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KompTamb'));
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
		$this->form_validation->set_rules('txtTambahan', 'Tambahan', 'integer');
		$this->form_validation->set_rules('txtDesc', 'Desc ', 'max_length[30]');
	}

}

/* End of file C_KompTamb.php */
/* Location: ./application/controllers/PayrollManagement/KomponenTambahan/C_KompTamb.php */
/* Generated automatically on 2016-11-28 14:26:31 */