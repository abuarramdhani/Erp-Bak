<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamPengurangPajak extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetPengurangPajak/M_masterparampengurangpajak');
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
        $data['SubMenuOne'] = 'Set Pengurang Pajak';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterParamPengurangPajak = $this->M_masterparampengurangpajak->get_all();

        $data['masterParamPengurangPajak_data'] = $masterParamPengurangPajak;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamPengurangPajak/V_index', $data);
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

        $row = $this->M_masterparampengurangpajak->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Pengurang Pajak',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
				'id_setting' => $row->id_setting,
				'periode_pengurang_pajak' => $row->periode_pengurang_pajak,
				'max_jab' => $row->max_jab,
				'persentase_jab' => $row->persentase_jab,
				'max_pensiun' => $row->max_pensiun,
				'persentase_pensiun' => $row->persentase_pensiun,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamPengurangPajak/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPengurangPajak'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Pengurang Pajak',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterParamPengurangPajak/save'),
				'id_setting' => set_value(''),
			'periode_pengurang_pajak' => set_value('periode_pengurang_pajak'),
			'max_jab' => set_value('max_jab'),
			'persentase_jab' => set_value('persentase_jab'),
			'max_pensiun' => set_value('max_pensiun'),
			'persentase_pensiun' => set_value('persentase_pensiun'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamPengurangPajak/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

		//MASTER INSERT NEW
		$data = array(
			'periode_pengurang_pajak' => $this->input->post('txtPeriodePengurangPajak',TRUE),
			'max_jab' => str_replace(',','',$this->input->post('txtMaxJab',TRUE)),
			'persentase_jab' => $this->input->post('txtPersentaseJab',TRUE),
			'max_pensiun' => str_replace(',','',$this->input->post('txtMaxPensiun',TRUE)),
			'persentase_pensiun' => $this->input->post('txtPersentasePensiun',TRUE),
		);

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> $this->input->post('txtPeriodePengurangPajak',TRUE),
		);

		//RIWAYAT INSERT NEW
		$ri_data = array(
			'tgl_berlaku' 				=> $this->input->post('txtPeriodePengurangPajak',TRUE),
			'tgl_tberlaku' 				=> '9999-12-31',
			'max_jab' 					=> str_replace(',','',$this->input->post('txtMaxJab',TRUE)),
			'persentase_jab' 			=> $this->input->post('txtPersentaseJab',TRUE),
			'max_pensiun' 				=> str_replace(',','',$this->input->post('txtMaxPensiun',TRUE)),
			'persentase_pensiun' 		=> $this->input->post('txtPersentasePensiun',TRUE),
			'kode_petugas' 				=> $this->session->userdata('userid'),
			'tgl_record' 				=> date('Y-m-d H:i:s'),
		);

		$this->M_masterparampengurangpajak->master_delete();
		$this->M_masterparampengurangpajak->insert($data);
		$this->M_masterparampengurangpajak->riwayat_update($ru_where,$ru_data);
		$this->M_masterparampengurangpajak->riwayat_insert($ri_data);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add set Pengurang pajak periode=".$this->input->post('txtPeriodePengurangPajak');
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterParamPengurangPajak'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparampengurangpajak->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Pengurang Pajak',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamPengurangPajak/saveUpdate'),
				'id_setting' => set_value('txtIdSetting', $row->id_setting),
				'periode_pengurang_pajak' => set_value('txtPeriodePengurangPajak', $row->periode_pengurang_pajak),
				'max_jab' => set_value('txtMaxJab', $row->max_jab),
				'persentase_jab' => set_value('txtPersentaseJab', $row->persentase_jab),
				'max_pensiun' => set_value('txtMaxPensiun', $row->max_pensiun),
				'persentase_pensiun' => set_value('txtPersentasePensiun', $row->persentase_pensiun),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamPengurangPajak/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPengurangPajak'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        $data = array(
				'periode_pengurang_pajak' => $this->input->post('txtPeriodePengurangPajak',TRUE),
				'max_jab' => str_replace(',','',$this->input->post('txtMaxJab',TRUE)),
				'persentase_jab' => $this->input->post('txtPersentaseJab',TRUE),
				'max_pensiun' => str_replace(',','',$this->input->post('txtMaxPensiun',TRUE)),
				'persentase_pensiun' => $this->input->post('txtPersentasePensiun',TRUE),
			);

			$data_riwayat = array(
				'tgl_berlaku' => $this->input->post('txtPeriodePengurangPajak',TRUE),
				'max_jab' => str_replace(',','',$this->input->post('txtMaxJab',TRUE)),
				'persentase_jab' => $this->input->post('txtPersentaseJab',TRUE),
				'max_pensiun' => str_replace(',','',$this->input->post('txtMaxPensiun',TRUE)),
				'persentase_pensiun' => $this->input->post('txtPersentasePensiun',TRUE),
				'kode_petugas' 				=> $this->session->userdata('userid'),
				'tgl_record' 				=> date('Y-m-d H:i:s'),
			);

			$ru_where = array(
				'tgl_tberlaku' => '9999-12-31',
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set Pengurang pajak ID=".$this->input->post('txtIdSetting');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_masterparampengurangpajak->update($this->input->post('txtIdSetting', TRUE), $data);
            $this->M_masterparampengurangpajak->riwayat_update($ru_where, $data_riwayat);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPengurangPajak'));

    }

    public function delete($id)
    {
        $row = $this->M_masterparampengurangpajak->get_by_id($id);

        if ($row) {
            $this->M_masterparampengurangpajak->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set Pengurang pajak ID=".$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPengurangPajak'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPengurangPajak'));
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

/* End of file C_MasterParamPengurangPajak.php */
/* Location: ./application/controllers/PayrollManagement/SetPengurangPajak/C_MasterParamPengurangPajak.php */
/* Generated automatically on 2016-11-26 11:08:47 */
