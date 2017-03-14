<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamKompUmum extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetKomponenGajiUmum/M_masterparamkompumum');
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
		$dt	= date('Y-m-d');
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterParamKompUmum = $this->M_masterparamkompumum->get_all($dt);

        $data['masterParamKompUmum_data'] = $masterParamKompUmum;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamKompUmum/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterparamkompumum->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'um' => $row->um,
				'ubt' => $row->ubt,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamKompUmum/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
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
            'action' => site_url('PayrollManagement/MasterParamKompUmum/save'),
			'um' => set_value(''),
			'ubt' => set_value('ubt'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamKompUmum/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

            $data = array(
				'um' => $this->input->post('txtUmNew',TRUE),
				'ubt' => $this->input->post('txtUbt',TRUE),
			);
			
			$data_riwayat = array(
				'id_riwayat' => date('Ymd'),
				'tgl_berlaku' => date('Y-m-d'),
				'tgl_tberlaku' => '9999-12-31',
				'um' => $this->input->post('txtUmNew',TRUE),
				'ubt' => $this->input->post('txtUbt',TRUE),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);

            $this->M_masterparamkompumum->insert($data);
			$last_insert_id = $this->M_masterparamkompumum->check_riwayat();
			foreach($last_insert_id as $row){
				$last_id = $row->id_riwayat;
			}
			
			$data_update = array(
				'tgl_tberlaku' => date('Y-m-d'),
			);
            $this->M_masterparamkompumum->update_riwayat($last_id,$data_update);
            $this->M_masterparamkompumum->insert_riwayat($data_riwayat);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamkompumum->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamKompUmum/saveUpdate'),
				'um' => set_value('txtUm', $row->um),
				'ubt' => set_value('txtUbt', $row->ubt),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamKompUmum/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

            $data = array(
				'um' => $this->input->post('txtUmNew',TRUE),
				'ubt' => $this->input->post('txtUbt',TRUE),
			);

            $this->M_masterparamkompumum->update($this->input->post('txtUm', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
    }

    public function delete($id)
    {
        $row = $this->M_masterparamkompumum->get_by_id($id);

        if ($row) {
            $this->M_masterparamkompumum->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
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

/* End of file C_MasterParamKompUmum.php */
/* Location: ./application/controllers/PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum.php */
/* Generated automatically on 2016-11-26 13:39:51 */