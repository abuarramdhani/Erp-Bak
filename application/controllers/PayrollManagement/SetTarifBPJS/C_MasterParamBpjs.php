<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamBpjs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
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

        $data['Menu'] = 'Set Parameter';
        $data['SubMenuOne'] = 'Set Tarif BPJS';
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

        $row = $this->M_masterparambpjs->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Tarif BPJS',
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
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Tarif BPJS',
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

    public function save(){
        $this->formValidation();

		//MASTER INSERT NEW
		$data = array(
			'batas_max_jkn' => str_replace(',','',$this->input->post('txtBatasMaxJkn',TRUE)),
			'jkn_tg_kary' => $this->input->post('txtJknTgKary',TRUE),
			'jkn_tg_prshn' => $this->input->post('txtJknTgPrshn',TRUE),
			'batas_max_jpn' => str_replace(',','',$this->input->post('txtBatasMaxJpn',TRUE)),
			'jpn_tg_kary' => $this->input->post('txtJpnTgKary',TRUE),
			'jpn_tg_prshn' => $this->input->post('txtJpnTgPrshn',TRUE),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create set JKN batas_max_jkn=".str_replace(',','', $this->input->post('txtBatasMaxJkn'));
        $this->log_activity->activity_log($aksi, $detail);
        //

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);

		//RIWAYAT INSERT NEW
		$ri_data = array(
			'tgl_berlaku' 	=> date('Y-m-d'),
			'tgl_tberlaku' 	=> '9999-12-31',
			'batas_max_jkn' => str_replace(',','',$this->input->post('txtBatasMaxJkn',TRUE)),
			'jkn_tg_kary' 	=> $this->input->post('txtJknTgKary',TRUE),
			'jkn_tg_prshn' 	=> $this->input->post('txtJknTgPrshn',TRUE),
			'batas_max_jpn' => str_replace(',','',$this->input->post('txtBatasMaxJpn',TRUE)),
			'jpn_tg_kary' 	=> $this->input->post('txtJpnTgKary',TRUE),
			'jpn_tg_prshn' 	=> $this->input->post('txtJpnTgPrshn',TRUE),
			'kode_petugas' 	=> $this->session->userdata('userid'),
			'tgl_record' 	=> date('Y-m-d H:i:s'),
		);

        $this->M_masterparambpjs->master_delete();
		$this->M_masterparambpjs->insert($data);
		$this->M_masterparambpjs->riwayat_update($ru_where,$ru_data);
		$this->M_masterparambpjs->riwayat_insert($ri_data);

        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterParamBpjs'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparambpjs->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Tarif BPJS',
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
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
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
				'batas_max_jkn' => str_replace(',','',$this->input->post('txtBatasMaxJkn',TRUE)),
				'jkn_tg_kary' => $this->input->post('txtJknTgKary',TRUE),
				'jkn_tg_prshn' => $this->input->post('txtJknTgPrshn',TRUE),
				'batas_max_jpn' => str_replace(',','',$this->input->post('txtBatasMaxJpn',TRUE)),
				'jpn_tg_kary' => $this->input->post('txtJpnTgKary',TRUE),
				'jpn_tg_prshn' => $this->input->post('txtJpnTgPrshn',TRUE),
			);
		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'batas_max_jkn' => str_replace(',','',$this->input->post('txtBatasMaxJkn',TRUE)),
			'jkn_tg_kary' => $this->input->post('txtJknTgKary',TRUE),
			'jkn_tg_prshn' => $this->input->post('txtJknTgPrshn',TRUE),
			'batas_max_jpn' => str_replace(',','',$this->input->post('txtBatasMaxJpn',TRUE)),
			'jpn_tg_kary' => $this->input->post('txtJpnTgKary',TRUE),
			'jpn_tg_prshn' => $this->input->post('txtJpnTgPrshn',TRUE),
			'tgl_tberlaku' 	=> date('Y-m-d'),
			'kode_petugas' 	=> $this->session->userdata('userid'),
		);

            $this->M_masterparambpjs->update($this->input->post('txtIdSetting', TRUE), $data);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set JKN ID=".$this->input->post('txtIdSetting');
            $this->log_activity->activity_log($aksi, $detail);
            //
			$this->M_masterparambpjs->riwayat_update($ru_where,$ru_data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_masterparambpjs->get_by_id($id);

        if ($row) {
            $this->M_masterparambpjs->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set JKN ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamBpjs'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
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
