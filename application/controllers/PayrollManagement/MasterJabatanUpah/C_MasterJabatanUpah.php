<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterJabatanUpah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
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
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['header_data'] = $this->M_masterjabatanupah->get_header();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterJabatanUpah/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	/* NEW DATA */
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
            
			$this->M_masterjabatanupah->insert_header($data);
            $header_id = $this->db->insert_id();



			$this->session->set_flashdata('message', 'Create Record Success');
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
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
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
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
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
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
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
            
			$this->M_masterjabatanupah->update_header($header_id, $data);



			$this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterJabatanUpah'));
    }

    public function checkSession(){
        if($this->session->is_logged){
            
        }else{
            redirect(site_url());
        }
    }
    

}

/* End of file C_MasterJabatanUpah.php */
/* Location: ./application/controllers/PayrollManagement/MainMenu/C_MasterJabatanUpah.php */
/* Generated automatically on 2016-12-24 08:50:04 */