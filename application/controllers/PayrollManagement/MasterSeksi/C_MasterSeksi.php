<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterSeksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterSeksi/M_masterseksi');
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
        $masterSeksi = $this->M_masterseksi->get_all();

        $data['masterSeksi_data'] = $masterSeksi;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterSeksi/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterseksi->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'kodesie' => $row->kodesie,
				'dept' => $row->dept,
				'bidang' => $row->bidang,
				'unit' => $row->unit,
				'seksi' => $row->seksi,
				'pekerjaan' => $row->pekerjaan,
				'golkerja' => $row->golkerja,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterSeksi/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterSeksi'));
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
            'action' => site_url('PayrollManagement/MasterSeksi/save'),
				'kodesie' => set_value(''),
			'dept' => set_value('dept'),
			'bidang' => set_value('bidang'),
			'unit' => set_value('unit'),
			'seksi' => set_value('seksi'),
			'pekerjaan' => set_value('pekerjaan'),
			'golkerja' => set_value('golkerja'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterSeksi/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
		$data = array(
			'kodesie' => $this->input->post('txtKodesieNew',TRUE),
			'dept' => $this->input->post('cmbDept',TRUE),
			'bidang' => $this->input->post('txtBidang',TRUE),
			'unit' => $this->input->post('txtUnit',TRUE),
			'seksi' => $this->input->post('txtSeksi',TRUE),
			'pekerjaan' => $this->input->post('txtPekerjaan',TRUE),
			'golkerja' => $this->input->post('txtGolkerja',TRUE),
		);

            $this->M_masterseksi->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterSeksi'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterseksi->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterSeksi/saveUpdate'),
				'kodesie' => set_value('txtKodesie', $row->kodesie),
				'dept' => set_value('txtDept', $row->dept),
				'bidang' => set_value('txtBidang', $row->bidang),
				'unit' => set_value('txtUnit', $row->unit),
				'seksi' => set_value('txtSeksi', $row->seksi),
				'pekerjaan' => set_value('txtPekerjaan', $row->pekerjaan),
				'golkerja' => set_value('txtGolkerja', $row->golkerja),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterSeksi/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterSeksi'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();
        $data = array(
			'kodesie' => $this->input->post('txtKodesieNew',TRUE),
			'dept' => $this->input->post('cmbDept',TRUE),
			'bidang' => $this->input->post('txtBidang',TRUE),
			'unit' => $this->input->post('txtUnit',TRUE),
			'seksi' => $this->input->post('txtSeksi',TRUE),
			'pekerjaan' => $this->input->post('txtPekerjaan',TRUE),
			'golkerja' => $this->input->post('txtGolkerja',TRUE),
			);

            $this->M_masterseksi->update($this->input->post('txtKodesie', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterSeksi'));
    }

    public function delete($id)
    {
        $row = $this->M_masterseksi->get_by_id($id);

        if ($row) {
            $this->M_masterseksi->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterSeksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterSeksi'));
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

/* End of file C_MasterSeksi.php */
/* Location: ./application/controllers/PayrollManagement/MasterSeksi/C_MasterSeksi.php */
/* Generated automatically on 2016-11-24 09:48:55 */