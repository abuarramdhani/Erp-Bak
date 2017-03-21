<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_StandartJamUmum extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetStandartJamUmum/M_standartjamumum');
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
        $standartJamUmum = $this->M_standartjamumum->get_all();

        $data['standartJamUmum_data'] = $standartJamUmum;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/StandartJamUmum/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_standartjamumum->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'kode_standart_jam' => $row->kode_standart_jam,
				'jml_std_jam_per_bln' => $row->jml_std_jam_per_bln,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/StandartJamUmum/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/StandartJamUmum'));
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
            'action' => site_url('PayrollManagement/StandartJamUmum/save'),
				'kode_standart_jam' => set_value(''),
			'jml_std_jam_per_bln' => set_value('jml_std_jam_per_bln'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/StandartJamUmum/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

	
		
		//MASTER INSERT NEW
        $data = array(
			'kode_standart_jam' => date('YmdHis'),
			'jml_std_jam_per_bln' => $this->input->post('txtJmlStdJamPerBln',TRUE),
		);
		
		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'tgl_tberlaku' 			=> '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 			=> date('Y-m-d'),
		);
		
		//RIWAYAT INSERT NEW
		$ri_data = array(
			'kode_standart_jam'		=> date('YmdHis'),
			'jml_std_jam_per_bln'	=> $this->input->post('txtJmlStdJamPerBln',TRUE),
			'tgl_berlaku' 			=> date('Y-m-d'),
			'tgl_tberlaku' 			=> '9999-12-31',
			'kd_petugas' 			=> $this->session->userdata('userid'),
			'tgl_rec' 				=> date('Y-m-d H:i:s'),
		);
		
		$this->M_standartjamumum->master_delete($md_where);
		$this->M_standartjamumum->insert($data);
		$this->M_standartjamumum->riwayat_update($ru_where,$ru_data);
		$this->M_standartjamumum->riwayat_insert($ri_data);

        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/StandartJamUmum'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_standartjamumum->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/StandartJamUmum/saveUpdate'),
				'kode_standart_jam' => set_value('txtKodeStandartJam', $row->kode_standart_jam),
				'jml_std_jam_per_bln' => set_value('txtJmlStdJamPerBln', $row->jml_std_jam_per_bln),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/StandartJamUmum/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/StandartJamUmum'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        $data = array(
			'jml_std_jam_per_bln' => $this->input->post('txtJmlStdJamPerBln',TRUE),
		);

        $this->M_standartjamumum->update($data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('PayrollManagement/StandartJamUmum'));
    }

    public function delete($id)
    {
        $row = $this->M_standartjamumum->get_by_id($id);

        if ($row) {
            $this->M_standartjamumum->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/StandartJamUmum'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/StandartJamUmum'));
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
		$this->form_validation->set_rules('txtJmlStdJamPerBln', 'Jml Std Jam Per Bln', 'max_length[4]');
	}

}

/* End of file C_StandartJamUmum.php */
/* Location: ./application/controllers/PayrollManagement/SetStandartJamUmum/C_StandartJamUmum.php */
/* Generated automatically on 2016-11-26 08:14:19 */