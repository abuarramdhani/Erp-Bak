<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamBpjs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifBPJS/M_masterparambpjs');
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
        $masterParamBpjs = $this->M_masterparambpjs->get_all();

        $data['masterParamBpjs_data'] = $masterParamBpjs;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamBpjs/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterparambpjs->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_setting' => $row->id_setting,
				'batas_max_jkn' => $row->batas_max_jkn,
				'jkn_tg_kary' => $row->jkn_tg_kary,
				'jkn_tg_prshn' => $row->jkn_tg_prshn,
				'batas_max_jpn' => $row->batas_max_jpn,
				'jpn_tg_kary' => $row->jpn_tg_kary,
				'jpn_tg_prshn' => $row->jpn_tg_prshn,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamBpjs/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
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
            'action' => site_url('PayrollManagement/MasterParamBpjs/save'),
				'id_setting' => set_value(''),
			'batas_max_jkn' => set_value('batas_max_jkn'),
			'jkn_tg_kary' => set_value('jkn_tg_kary'),
			'jkn_tg_prshn' => set_value('jkn_tg_prshn'),
			'batas_max_jpn' => set_value('batas_max_jpn'),
			'jpn_tg_kary' => set_value('jpn_tg_kary'),
			'jpn_tg_prshn' => set_value('jpn_tg_prshn'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamBpjs/V_form', $data);
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
				'batas_max_jkn' => $this->input->post('txtBatasMaxJkn',TRUE),
				'jkn_tg_kary' => $this->input->post('txtJknTgKary',TRUE),
				'jkn_tg_prshn' => $this->input->post('txtJknTgPrshn',TRUE),
				'batas_max_jpn' => $this->input->post('txtBatasMaxJpn',TRUE),
				'jpn_tg_kary' => $this->input->post('txtJpnTgKary',TRUE),
				'jpn_tg_prshn' => $this->input->post('txtJpnTgPrshn',TRUE),
			);

            $this->M_masterparambpjs->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
        }
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparambpjs->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamBpjs/saveUpdate'),
				'id_setting' => set_value('txtIdSetting', $row->id_setting),
				'batas_max_jkn' => set_value('txtBatasMaxJkn', $row->batas_max_jkn),
				'jkn_tg_kary' => set_value('txtJknTgKary', $row->jkn_tg_kary),
				'jkn_tg_prshn' => set_value('txtJknTgPrshn', $row->jkn_tg_prshn),
				'batas_max_jpn' => set_value('txtBatasMaxJpn', $row->batas_max_jpn),
				'jpn_tg_kary' => set_value('txtJpnTgKary', $row->jpn_tg_kary),
				'jpn_tg_prshn' => set_value('txtJpnTgPrshn', $row->jpn_tg_prshn),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamBpjs/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
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
				'batas_max_jkn' => $this->input->post('txtBatasMaxJkn',TRUE),
				'jkn_tg_kary' => $this->input->post('txtJknTgKary',TRUE),
				'jkn_tg_prshn' => $this->input->post('txtJknTgPrshn',TRUE),
				'batas_max_jpn' => $this->input->post('txtBatasMaxJpn',TRUE),
				'jpn_tg_kary' => $this->input->post('txtJpnTgKary',TRUE),
				'jpn_tg_prshn' => $this->input->post('txtJpnTgPrshn',TRUE),
			);

            $this->M_masterparambpjs->update($this->input->post('txtIdSetting', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_masterparambpjs->get_by_id($id);

        if ($row) {
            $this->M_masterparambpjs->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
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
		$this->form_validation->set_rules('txtJknTgKary', 'Jkn Tg Kary', 'max_length[5]');
		$this->form_validation->set_rules('txtJknTgPrshn', 'Jkn Tg Prshn', 'max_length[5]');
		$this->form_validation->set_rules('txtJpnTgKary', 'Jpn Tg Kary', 'max_length[5]');
		$this->form_validation->set_rules('txtJpnTgPrshn', 'Jpn Tg Prshn', 'max_length[5]');
	}

}

/* End of file C_MasterParamBpjs.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifBPJS/C_MasterParamBpjs.php */
/* Generated automatically on 2016-11-26 09:00:34 */