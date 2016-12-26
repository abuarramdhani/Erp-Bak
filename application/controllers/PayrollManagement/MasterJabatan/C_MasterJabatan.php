<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterJabatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterJabatan/M_masterjabatan');
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
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterJabatan = $this->M_masterjabatan->get_all();

        $data['masterJabatan_data'] = $masterJabatan;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterJabatan/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterjabatan->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'kd_jabatan' => $row->kd_jabatan,
				'jabatan' => $row->jabatan,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterJabatan/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterJabatan'));
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
            'action' => site_url('PayrollManagement/MasterJabatan/save'),
				'kd_jabatan' => set_value(''),
			'jabatan' => set_value('jabatan'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterJabatan/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();

        $data = array(
			'kd_jabatan' => $this->input->post('txtKdJabatanNew',TRUE),
			'jabatan' => $this->input->post('txtJabatan',TRUE),
		);

        $this->M_masterjabatan->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/MasterJabatan'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterjabatan->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterJabatan/saveUpdate'),
				'kd_jabatan' => set_value('txtKdJabatan', $row->kd_jabatan),
				'jabatan' => set_value('txtJabatan', $row->jabatan),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterJabatan/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterJabatan'));
        }
    }

    public function saveUpdate(){
       $data = array(
			'kd_jabatan' => $this->input->post('txtKdJabatanNew',TRUE),
			'jabatan' => $this->input->post('txtJabatan',TRUE),
		);

        $qwer = $this->M_masterjabatan->update($this->input->post('txtKdJabatan', TRUE), $data);
		$this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('PayrollManagement/MasterJabatan'));
    }

    public function delete($id)
    {
        $row = $this->M_masterjabatan->get_by_id($id);

        if ($row) {
            $this->M_masterjabatan->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterJabatan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterJabatan'));
        }
    }

    public function import() {
       
        $config['upload_path'] = 'assets/upload/importPR/masterjabatan/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterjabatan/'.$file_data['file_name'];
                
            if ($this->csvimport->get_array($file_path)) {
                
                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
                    if(array_key_exists('KODE_JABAT', $row)){ 
                        $data = array(
                            'kd_jabatan' => $row['KODE_JABAT'],
                            'jabatan' => $row['NAMA_JABAT'],
                        );
                        $this->M_masterjabatan->insert($data);
                    }else{
                        $data = array(
                            'kd_jabatan' => $row['kd_jabatan'],
                            'jabatan' => $row['jabatan'],
                        );
                        $this->M_masterjabatan->insert($data);
                    }
                }
                unlink($file_path);
                redirect(base_url().'PayrollManagement/MasterJabatan');

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

    public function formValidation(){}

}

/* End of file C_MasterJabatan.php */
/* Location: ./application/controllers/PayrollManagement/MasterJabatan/C_MasterJabatan.php */
/* Generated automatically on 2016-11-24 09:47:28 */