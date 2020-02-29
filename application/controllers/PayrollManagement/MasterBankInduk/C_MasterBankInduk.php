<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterBankInduk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterBankInduk/M_masterbankinduk');
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
        $data['SubMenuOne'] = 'Master Bank Induk';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterBankInduk = $this->M_masterbankinduk->get_all();

        $data['masterBankInduk_data'] = $masterBankInduk;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterBankInduk/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_import');
		$this->session->unset_userdata('success_delete');
		$this->session->unset_userdata('success_update');
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('not_found');
    }

	//LOAD READ PAGE
	public function read($id){
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterbankinduk->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Data',
            	'SubMenuOne' => 'Master Bank Induk',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kd_bank_induk' => $row->kd_bank_induk,
				'bank_induk' => $row->bank_induk,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterBankInduk/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBankInduk'));
        }
    }

	//LOAD CREATE PAGE
    public function create(){
        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Bank Induk',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterBankInduk/save'),
			'kd_bank_induk' => set_value(''),
			'bank_induk' => set_value(''),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterBankInduk/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
		$this->formValidation();

		//MASTER DELETE CURRENT
		$md_where = array(
			'kd_bank_induk' => strtoupper($this->input->post('txtKdBankIndukNew',TRUE)),
		);

		//MASTER INSERT NEW
		$data = array(
			'kd_bank_induk' => strtoupper($this->input->post('txtKdBankIndukNew',TRUE)),
			'bank_induk' => strtoupper($this->input->post('txtBankInduk',TRUE)),
		);

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'kd_bank_induk' => strtoupper($this->input->post('txtKdBankIndukNew',TRUE)),
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);

		//RIWAYAT INSERT NEW
		$ri_data = array(
			'kd_bank_induk' 		=> strtoupper($this->input->post('txtKdBankIndukNew',TRUE)),
			'bank_induk' 			=> strtoupper($this->input->post('txtBankInduk',TRUE)),
			'tgl_berlaku' 			=> date('Y-m-d'),
			'tgl_tberlaku' 			=> '9999-12-31',
			'kode_petugas' 			=> '0001225',
			'tgl_record' 			=> date('Y-m-d H:i:s'),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add Mater Bank Induk kd_bank=".strtoupper($this->input->post('txtKdBankIndukNew'));
        $this->log_activity->activity_log($aksi, $detail);
        //

		$this->M_masterbankinduk->master_delete($md_where);
		$this->M_masterbankinduk->insert($data);
		$this->M_masterbankinduk->riwayat_update($ru_where,$ru_data);
		$this->M_masterbankinduk->riwayat_insert($ri_data);

        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
				 "success_insert" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterBankInduk'));
    }


    public function update($id){
		$this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterbankinduk->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Bank Induk',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterBankInduk/saveUpdate'),
				'kd_bank_induk' => set_value('txtKdBankInduk', $row->kd_bank_induk),
				'bank_induk' => set_value('txtBankInduk', $row->bank_induk),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterBankInduk/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBankInduk'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

		$data = array(
			'bank_induk' => strtoupper($this->input->post('txtBankInduk',TRUE)),
			'kd_bank_induk' => strtoupper($this->input->post('txtKdBankIndukNew',TRUE)),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update Mater Bank Induk kd_bank=".strtoupper($this->input->post('txtKdBankIndukNew'));
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->M_masterbankinduk->update(strtoupper($this->input->post('txtKdBankInduk', TRUE)), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
				 "success_update" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterBankInduk'));
    }

    public function delete($id){
        $row = $this->M_masterbankinduk->get_by_id($id);

        if ($row) {
            $this->M_masterbankinduk->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master bank induk ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBankInduk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterBankInduk'));
        }
    }

    public function checkSession(){
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }

    public function formValidation(){
	}

}

/* End of file C_MasterBankInduk.php */
/* Location: ./application/controllers/PayrollManagement/MasterBankInduk/C_MasterBankInduk.php */
/* Generated automatically on 2016-11-24 09:56:50 */
