<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterStatusKerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterStatusKerja/M_masterstatuskerja');
        $this->load->library('csvimport');
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

        $data['Menu'] = 'Master Data';
        $data['SubMenuOne'] = 'Master Status Kerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterStatusKerja = $this->M_masterstatuskerja->get_all();

        $data['masterStatusKerja_data'] = $masterStatusKerja;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterStatusKerja/V_index', $data);
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

        $row = $this->M_masterstatuskerja->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kd_status_kerja' => $row->kd_status_kerja,
				'status_kerja' => $row->status_kerja,
				'status_kerja_singkat' => $row->status_kerja_singkat,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterStatusKerja/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterStatusKerja'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Status Kerja',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterStatusKerja/save'),
				'kd_status_kerja' => set_value(''),
			'status_kerja' => set_value('status_kerja'),
			'status_kerja_singkat' => set_value('status_kerja_singkat'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterStatusKerja/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

            $data = array(
				'kd_status_kerja' => strtoupper($this->input->post('txtKdStatusKerjaNew',TRUE)),
				'status_kerja' => strtoupper($this->input->post('txtStatusKerja',TRUE)),
				'status_kerja_singkat' => strtoupper($this->input->post('txtStatusKerjaSingkat',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Add kd_status_kerja=".strtoupper($this->input->post('txtKdStatusKerjaNew',TRUE))." Status kerja =".strtoupper($this->input->post('txtStatusKerja',TRUE));
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_masterstatuskerja->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterStatusKerja'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterstatuskerja->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Status Kerja',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterStatusKerja/saveUpdate'),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'status_kerja' => set_value('txtStatusKerja', $row->status_kerja),
				'status_kerja_singkat' => set_value('txtStatusKerjaSingkat', $row->status_kerja_singkat),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterStatusKerja/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterStatusKerja'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

            $data = array(
				'kd_status_kerja' => strtoupper($this->input->post('txtKdStatusKerjaNew',TRUE)),
				'status_kerja' => strtoupper($this->input->post('txtStatusKerja',TRUE)),
				'status_kerja_singkat' => strtoupper($this->input->post('txtStatusKerjaSingkat',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update kd_status_kerja=".strtoupper($this->input->post('txtKdStatusKerjaNew',TRUE))." Status kerja =".strtoupper($this->input->post('txtStatusKerja',TRUE));
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_masterstatuskerja->update(strtoupper($this->input->post('txtKdStatusKerja', TRUE)), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterStatusKerja'));
    }

    public function delete($id)
    {
        $row = $this->M_masterstatuskerja->get_by_id($id);

        if ($row) {
            $this->M_masterstatuskerja->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete status kerja ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterStatusKerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterStatusKerja'));
        }
    }

     public function import() {

        $config['upload_path'] = 'assets/upload/importPR/masterstatuskerja/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterstatuskerja/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
					$check = $this->M_masterstatuskerja->get_by_id($row['KD_STAT']);
                    if($check){
                        $data = array(
                            'status_kerja' => $row['STAT_KER'],
                        );
                        $this->M_masterstatuskerja->update($row['KD_STAT'],$data);
                    }else{
                        $data = array(
                            'kd_status_kerja' => strtoupper($row['KD_STAT']),
                            'status_kerja' => strtoupper($row['STAT_KER']),
                        );
                        $this->M_masterstatuskerja->insert($data);
                    }
                }
				$this->session->set_flashdata('flashSuccess', 'This is a success message.');
				$ses=array(
					 "success_import" => 1
				);

				$this->session->set_userdata($ses);
                unlink($file_path);
                redirect(base_url().'PayrollManagement/MasterStatusKerja');

            } else {
                $this->load->view('csvindex');
            }
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

/* End of file C_MasterStatusKerja.php */
/* Location: ./application/controllers/PayrollManagement/MasterStatusKerja/C_MasterStatusKerja.php */
/* Generated automatically on 2016-11-24 09:46:53 */
