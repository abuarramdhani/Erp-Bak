<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamPtkp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifPTKP/M_masterparamptkp');
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
        $masterParamPtkp = $this->M_masterparamptkp->get_all();

        $data['masterParamPtkp_data'] = $masterParamPtkp;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamPtkp/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterparamptkp->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_setting' => $row->id_setting,
				'periode' => $row->periode,
				'status_pajak' => $row->status_pajak,
				'ptkp_per_tahun' => $row->ptkp_per_tahun,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamPtkp/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
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
            'action' => site_url('PayrollManagement/MasterParamPtkp/save'),
				'id_setting' => set_value(''),
			'periode' => set_value('periode'),
			'status_pajak' => set_value('status_pajak'),
			'ptkp_per_tahun' => set_value('ptkp_per_tahun'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamPtkp/V_form', $data);
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
				'status_pajak' => $this->input->post('txtStatusPajak',TRUE),
				'ptkp_per_tahun' => $this->input->post('txtPtkpPerTahun',TRUE),
			);

            $this->M_masterparamptkp->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        }
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamptkp->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamPtkp/saveUpdate'),
				'id_setting' => set_value('txtIdSetting', $row->id_setting),
				'periode' => set_value('txtPeriode', $row->periode),
				'status_pajak' => set_value('txtStatusPajak', $row->status_pajak),
				'ptkp_per_tahun' => set_value('txtPtkpPerTahun', $row->ptkp_per_tahun),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamPtkp/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
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
				'status_pajak' => $this->input->post('txtStatusPajak',TRUE),
				'ptkp_per_tahun' => $this->input->post('txtPtkpPerTahun',TRUE),
			);

            $this->M_masterparamptkp->update($this->input->post('txtIdSetting', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_masterparamptkp->get_by_id($id);

        if ($row) {
            $this->M_masterparamptkp->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
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
		$this->form_validation->set_rules('txtPeriode', 'Periode', 'max_length[6]');
		$this->form_validation->set_rules('txtStatusPajak', 'Status Pajak', 'max_length[3]');
		$this->form_validation->set_rules('txtPtkpPerTahun', 'Ptkp Per Tahun', 'max_length[10]');
	}

}

/* End of file C_MasterParamPtkp.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifPTKP/C_MasterParamPtkp.php */
/* Generated automatically on 2016-11-26 09:02:07 */