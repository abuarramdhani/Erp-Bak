<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterBank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
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

        $data['Menu'] = 'Master Data';
        $data['SubMenuOne'] = 'Master Bank';
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
		$this->session->unset_userdata('success_import');
		$this->session->unset_userdata('success_delete');
		$this->session->unset_userdata('success_update');
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('not_found');
    }

	public function read($id){
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterbank->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Data',
            	'SubMenuOne' => 'Master Bank',
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
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBank'));
        }
    }

    public function create(){

        $this->checkSession();
        $user_id = $this->session->userid;

		$create = $this->M_masterbank->get_kode_bank();
		if($create){
			$kd = (int)$create+1;
		}else{
			$kd = 1;
		}
        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Bank',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterBank/save'),
			'kd_bank' => $kd,
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

		//GET LATEST ID RIWAYAT
		$rs_where = array(
			'kd_bank' 		=> strtoupper($this->input->post('txtKdBankNew',TRUE)),
			'tgl_tberlaku' 	=> '9999-12-31',
		);

		$as = $this->M_masterbank->get_idrb($rs_where);
		$as_num = substr($as, 3);
		$as_num = $as_num+1;
		$fix = str_pad($as_num, 4, '0', STR_PAD_LEFT);
		$id_riwayat_bank_new = strtoupper($this->input->post('txtKdBankNew',TRUE)).$fix;

		//MASTER DELETE CURRENT
		$md_where = array(
			'kd_bank' => strtoupper($this->input->post('txtKdBankNew',TRUE)),
			'bank' => strtoupper($this->input->post('txtBank',TRUE)),
			'kd_bank_induk' => strtoupper($this->input->post('cmbKdBankInduk',TRUE)),
		);

		//MASTER INSERT NEW
		$data = array(
			'kd_bank' => strtoupper($this->input->post('txtKdBankNew',TRUE)),
			'bank' => strtoupper($this->input->post('txtBank',TRUE)),
			'pot_transfer' => str_replace('.','',$this->input->post('txtPotTransfer',TRUE)),
			'pot_transfer_tg_prshn' => str_replace('.','',$this->input->post('txtPotTransferTgPrshn',TRUE)),
			'kd_bank_induk' => strtoupper($this->input->post('cmbKdBankInduk',TRUE)),
		);

		//MASTER CHANGE CURRENT
		$ru_where = array(
			'kd_bank' 		=> strtoupper($this->input->post('txtKdBankNew',TRUE)),
			'bank' 			=> strtoupper($this->input->post('txtBank',TRUE)),
			'kd_bank_induk' => strtoupper($this->input->post('cmbKdBankInduk',TRUE)),
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'kd_bank' 		=> strtoupper($this->input->post('txtKdBankNew',TRUE)),
			'bank' 			=> strtoupper($this->input->post('txtBank',TRUE)),
			'kd_bank_induk' => strtoupper($this->input->post('cmbKdBankInduk',TRUE)),
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);

		//MASTER INSERT NEW
		$ri_data = array(
			'id_riwayat_bank'		=> $id_riwayat_bank_new,
			'kd_bank' 				=> strtoupper($this->input->post('txtKdBankNew',TRUE)),
			'bank' 					=> strtoupper($this->input->post('txtBank',TRUE)),
			'tgl_berlaku' 			=> date('Y-m-d'),
			'tgl_tberlaku' 			=> '9999-12-31',
			'pot_transfer' 			=> str_replace('.','',$this->input->post('txtPotTransfer',TRUE)),
			'pot_transfer_tg_prshn' => str_replace('.','',$this->input->post('txtPotTransferTgPrshn',TRUE)),
			'kode_petugas' 			=> '0001225',
			'tgl_record' 			=> date('Y-m-d H:i:s'),
			'kd_bank_induk' 		=> strtoupper($this->input->post('cmbKdBankInduk',TRUE)),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add Mater Bank kd_bank=".strtoupper($this->input->post('txtKdBankIndukNew'));
        $this->log_activity->activity_log($aksi, $detail);
        //
		$this->M_masterbank->master_delete($md_where);
		$this->M_masterbank->insert($data);
		$this->M_masterbank->riwayat_update($ru_where,$ru_data);
		$this->M_masterbank->riwayat_insert($ri_data);


            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
				 "success_insert" => 1
			);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBank'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterbank->get_by_id($id);


		if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Bank',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterBank/saveUpdate'),
				'kd_bank' => set_value('cmbKdBank', $row->kd_bank),
				'bank' => set_value('cmbBank', $row->bank),
				'pot_transfer' => set_value('cmbPotTransfer', number_format((int)$row->pot_transfer,0,",",".")),
				'pot_transfer_tg_prshn' => set_value('cmbPotTransferTgPrshn', number_format((int)$row->pot_transfer_tg_prshn,0,",",".")),
				'kd_bank_induk' => set_value('cmbKdBankInduk', $row->kd_bank_induk),
				'pr_master_bank_induk_data' => $this->M_masterbank->get_pr_master_bank_induk_data(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterBank/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBank'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

        $data = array(
			'bank' => strtoupper($this->input->post('txtBank',TRUE)),
			'pot_transfer' => str_replace('.','',$this->input->post('txtPotTransfer',TRUE)),
			'pot_transfer_tg_prshn' => str_replace('.','',$this->input->post('txtPotTransferTgPrshn',TRUE)),
			'kd_bank_induk' => strtoupper($this->input->post('cmbKdBankInduk',TRUE)),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update Mater Bank kd_bank=".strtoupper($this->input->post('txtKdBankIndukNew'));
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->M_masterbank->update(strtoupper($this->input->post('txtKdBankNew', TRUE)), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
				 "success_update" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterBank'));
	}

    public function delete($id)
    {
        $row = $this->M_masterbank->get_by_id($id);

        if ($row) {
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master bank ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_masterbank->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBank'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
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
