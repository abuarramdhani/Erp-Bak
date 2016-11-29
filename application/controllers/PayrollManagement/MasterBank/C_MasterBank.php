<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterBank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterBank/M_masterbank');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	public function index(){
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterBank = $this->M_masterbank->get_all();

        $data['masterBank_data'] = $masterBank;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterBank/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id){
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterbank->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'kd_bank' => $row->kd_bank,
				'bank' => $row->bank,
				'pot_transfer' => $row->pot_transfer,
				'pot_transfer_tg_prshn' => $row->pot_transfer_tg_prshn,
				'kd_bank_induk' => $row->kd_bank_induk,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterBank/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterBank'));
        }
    }

    public function create(){

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Payroll Management',
            'SubMenuOne' => '',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterBank/save'),
				'kd_bank' => set_value(''),
			'bank' => set_value('bank'),
			'pot_transfer' => set_value('pot_transfer'),
			'pot_transfer_tg_prshn' => set_value('pot_transfer_tg_prshn'),
			'pr_master_bank_induk_data' => $this->M_masterbank->get_pr_master_bank_induk_data(),
			'kd_bank_induk' => set_value('kd_bank_induk'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterBank/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();

            $data = array(
				'kd_bank' => $this->input->post('txtKdBankNew',TRUE),
				'bank' => $this->input->post('txtBank',TRUE),
				'pot_transfer' => $this->input->post('txtPotTransfer',TRUE),
				'pot_transfer_tg_prshn' => $this->input->post('txtPotTransferTgPrshn',TRUE),
				'kd_bank_induk' => $this->input->post('cmbKdBankInduk',TRUE),
			);

            $this->M_masterbank->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterBank'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterbank->get_by_id($id);
		
        
		if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterBank/saveUpdate'),
				'kd_bank' => set_value('cmbKdBank', $row->kd_bank),
				'bank' => set_value('cmbBank', $row->bank),
				'pot_transfer' => set_value('cmbPotTransfer', $row->pot_transfer),
				'pot_transfer_tg_prshn' => set_value('cmbPotTransferTgPrshn', $row->pot_transfer_tg_prshn),
				'kd_bank_induk' => set_value('cmbKdBankInduk', $row->kd_bank_induk),
				'pr_master_bank_induk_data' => $this->M_masterbank->get_pr_master_bank_induk_data(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterBank/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterBank'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

        $data = array(
			'kd_bank' => $this->input->post('txtKdBankNew',TRUE),
			'bank' => $this->input->post('txtBank',TRUE),
			'pot_transfer' => $this->input->post('txtPotTransfer',TRUE),
			'pot_transfer_tg_prshn' => $this->input->post('txtPotTransferTgPrshn',TRUE),
			'kd_bank_induk' => $this->input->post('cmbKdBankInduk',TRUE),
		);

        $this->M_masterbank->update($this->input->post('txtKdBank', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('PayrollManagement/MasterBank'));
	}

    public function delete($id)
    {
        $row = $this->M_masterbank->get_by_id($id);

        if ($row) {
            $this->M_masterbank->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterBank'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterBank'));
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

/* End of file C_MasterBank.php */
/* Location: ./application/controllers/PayrollManagement/MasterBank/C_MasterBank.php */
/* Generated automatically on 2016-11-24 09:57:43 */