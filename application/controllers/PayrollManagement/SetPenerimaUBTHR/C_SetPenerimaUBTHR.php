<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SetPenerimaUBTHR extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetPenerimaUBTHR/M_setpenerimaubthr');
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
        $data['SubMenuOne'] = 'Set Penerima UBTHR';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $SetPenerimaUBTHR = $this->M_setpenerimaubthr->get_all();

        $data['setpenerimaubthr_data'] = $SetPenerimaUBTHR;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/SetPenerimaUBTHR/V_index', $data);
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

        $row = $this->M_setpenerimaubthr->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Penerima UBTHR',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_setting' => $row->id_setting,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'kd_status_kerja' => $row->kd_status_kerja,
				'persentase_thr' => $row->persentase_thr,
				'persentase_ubthr' => $row->persentase_ubthr,
				'kd_petugas' => $row->kd_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/SetPenerimaUBTHR/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetPenerimaUBTHR'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Penerima UBTHR',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
			'pr_master_status_kerja' => $this->M_setpenerimaubthr->get_pr_master_status_kerja(),
            'action' => site_url('PayrollManagement/SetPenerimaUBTHR/save'),
			'pg' => 'a',

			'id_setting' => set_value(''),
			'tgl_berlaku' => set_value(''),
			'tgl_tberlaku' => set_value(''),
			'kd_status_kerja' => set_value(''),
			'persentase_thr' => set_value(''),
			'persentase_ubthr' => set_value(''),
			'kd_petugas' => set_value(''),
			'tgl_record' => set_value(''),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/SetPenerimaUBTHR/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
        $data = array(

			'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
			'tgl_tberlaku' => '9999-12-31',
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
			'persentase_thr' => $this->input->post('txtPersentaseTHR',TRUE),
			'persentase_ubthr' => $this->input->post('txtPersentaseUBTHR',TRUE),
			'kd_petugas' => $this->session->userdata('userid'),
			'tgl_record' => date('Y-m-d H:i:s'),
		);

		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
		);

		$ru_data = array(
			'tgl_tberlaku' => $this->input->post('txtTglBerlaku',TRUE),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create set UBTHR tgl_berlaku=".$this->input->post('txtTglBerlaku')." kd_status_kerja=".$this->input->post('cmbKdStatusKerja');
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->M_setpenerimaubthr->update_data($ru_where,$ru_data);
        $this->M_setpenerimaubthr->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/SetPenerimaUBTHR'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_setpenerimaubthr->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Penerima UBTHR',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'pr_master_status_kerja' => $this->M_setpenerimaubthr->get_pr_master_status_kerja(),
				'action' => site_url('PayrollManagement/SetPenerimaUBTHR/saveUpdate'),
				'pg' => 'c',

				'id_setting' => $row->id_setting,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'kd_status_kerja' => $row->kd_status_kerja,
				'persentase_thr' => $row->persentase_thr,
				'persentase_ubthr' => $row->persentase_ubthr,
				'kd_petugas' => $row->kd_petugas,
				'tgl_record' => $row->tgl_record,
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/SetPenerimaUBTHR/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetPenerimaUBTHR'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

        $data = array(

			'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
			'tgl_tberlaku' => '9999-12-31',
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
			'persentase_thr' => $this->input->post('txtPersentaseTHR',TRUE),
			'persentase_ubthr' => $this->input->post('txtPersentaseUBTHR',TRUE),
			'kd_petugas' => $this->session->userdata('userid'),
			'tgl_record' => $this->input->post('txtTanggalRecord',TRUE),

		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update set UBTHR ID=".$this->input->post('txtIdSetting');
        $this->log_activity->activity_log($aksi, $detail);
        //

            $this->M_setpenerimaubthr->update($this->input->post('txtIdSetting', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetPenerimaUBTHR'));
    }

    public function delete($id)
    {
        $row = $this->M_setpenerimaubthr->get_by_id($id);

        if ($row) {
            $this->M_setpenerimaubthr->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set UBTHR ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetPenerimaUBTHR'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetPenerimaUBTHR'));
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

/* End of file C_SetPenerimaUBTHR.php */
/* Location: ./application/controllers/PayrollManagement/SetPenerimaUBTHR/C_SetPenerimaUBTHR.php */
/* Generated automatically on 2016-11-24 09:46:53 */
