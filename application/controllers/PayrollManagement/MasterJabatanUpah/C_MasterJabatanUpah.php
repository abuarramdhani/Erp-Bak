<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterJabatanUpah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
		$this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterJabatanUpah/M_masterjabatanupah');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	/* LIST DATA */
    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Master Data';
        $data['SubMenuOne'] = 'Master Jabatan Upah';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['header_data'] = $this->M_masterjabatanupah->get_header();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterJabatanUpah/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_import');
		$this->session->unset_userdata('success_delete');
		$this->session->unset_userdata('success_update');
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('not_found');
    }

	/* NEW DATA */
    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;
        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Jabatan Upah',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'form_action' => site_url('PayrollManagement/MasterJabatanUpah/save'),
		);
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterJabatanUpah/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    /* SAVE NEW DATA */
    function save()
    {
            $data = array(
				'jabatan_upah' => strtoupper($this->input->post('txtJabatanUpahHeader',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Add jabatan upah=".strtoupper($this->input->post('txtJabatanUpahHeader',TRUE));
            $this->log_activity->activity_log($aksi, $detail);
            //
			$this->M_masterjabatanupah->insert_header($data);
            $header_id = $this->db->insert_id();
			$this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));

    }

    /* READ DATA */
    function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterjabatanupah->get_header_by_id($id);
        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Jabatan Upah',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                /* Data Header */
                'kd_jabatan_upah' => $row->kd_jabatan_upah,
                'jabatan_upah' => $row->jabatan_upah,

			);
			$this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterJabatanUpah/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
        }
    }

    /* DELETE DATA */
    function delete($id)
    {
        $row = $this->M_masterjabatanupah->get_header_by_id($id);

        if ($row) {
            $this->M_masterjabatanupah->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master jabatan Upah ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
        }
    }

    /* UPDATE DATA */
    function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterjabatanupah->get_header_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Jabatan Upah',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'form_action' => site_url('PayrollManagement/MasterJabatanUpah/saveUpdate'),
                'kd_jabatan_upah' => set_value('txtKdJabatanUpahHeader',$row->kd_jabatan_upah),
				'jabatan_upah' => set_value('txtJabatanUpahHeader', $row->jabatan_upah),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterJabatanUpah/V_update', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
        }
    }


    /* SAVE UPDATE DATA */
    function saveUpdate()
    {
        $header_id = $this->input->post('txtKdJabatanUpahHeader');

            $data = array(
				'jabatan_upah' => strtoupper($this->input->post('txtJabatanUpahHeader',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update master jabatan Upah ID=$header_id";
            $this->log_activity->activity_log($aksi, $detail);
            //
			$this->M_masterjabatanupah->update_header($header_id, $data);
			$this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
    }

    public function checkSession(){
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }

	  public function import(){
		$config['upload_path'] = 'assets/upload/importPR/masterjabatanupah/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '6000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterjabatanupah/'.$filename;

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);
                $data_exist = array();
                $i = 0;
                foreach ($csv_array as $row) {
					$checkstd = $this->M_masterjabatanupah->get_header_by_id($row['KD_JAB_UPAH']);
                    if($checkstd){

 						//ROW DATA
	                    $data = array(
							'jabatan_upah' => $row['JAB_UPAH'],
	                    );
	                    $this->M_masterjabatanupah->update_header($row['KD_JAB_UPAH'],$data);
                	}else{
                		//ROW DATA
                		$data = array(
	                    	'kd_jabatan_upah' => $row['KD_JAB_UPAH'],
							'jabatan_upah' => $row['JAB_UPAH'],
	                    );
	                    $this->M_masterjabatanupah->insert_header($data);
                	}
                }
				unlink($file_path);
                //LOAD EXIST DATA VERIFICATION PAGE
                $this->checkSession();
        		$user_id = $this->session->userid;

        		$data['Menu'] = 'Master Data';
        		$data['SubMenuOne'] = 'Master Jabatan Upah';
        		$data['SubMenuTwo'] = '';

		        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		        $data['data_exist'] = $data_exist;
				$this->session->set_flashdata('message', 'Record Not Found');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
				redirect(site_url('PayrollManagement/MasterJabatanUpah'));
            } else {
                $this->load->view('csvindex');
            }
        }
    }

    public function upload() {

        $config['upload_path'] = 'assets/upload/importPR/masterjabatanupah';
        $config['file_name'] = 'MasterJabatanUpah-'.time();
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) {
            echo $this->upload->display_errors();
        }
        else {
            $file_data  = $this->upload->data();
            $filename   = $file_data['file_name'];
            $file_path  = 'assets/upload/importPR/masterjabatanupah/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)){
                $data = $this->csvimport->get_array($file_path);
                $this->import($data, $filename);
            }
            else {
                $this->import($data = array(), $filename = '');
            }
        }
    }

    public function saveImport(){
        $filename = $this->input->post('txtFileName');
        $file_path  = 'assets/upload/importPR/masterjabatanupah/'.$filename;
        $importData = $this->csvimport->get_array($file_path);

        foreach ($importData as $row) {
           $data = array(
				'kd_jabatan_upah' => $row['KD_JAB_UPAH'],
				'jabatan_upah' => $row['JAB_UPAH'],
            );

            $this->M_masterjabatanupah->insert_header($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
		$this->session->set_flashdata('message', 'Record Not Found');
		$ses=array(
				 "success_import" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
    }


}

/* End of file C_MasterJabatanUpah.php */
/* Location: ./application/controllers/PayrollManagement/MainMenu/C_MasterJabatanUpah.php */
/* Generated automatically on 2016-12-24 08:50:04 */
