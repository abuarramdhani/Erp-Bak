<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamTarifJamsostek extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifJamsostek/M_masterparamtarifjamsostek');
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
        $masterParamTarifJamsostek = $this->M_masterparamtarifjamsostek->get_all();

        $data['masterParamTarifJamsostek_data'] = $masterParamTarifJamsostek;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterparamtarifjamsostek->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'periode_jst' => $row->periode_jst,
				'jkk' => $row->jkk,
				'jht_karyawan' => $row->jht_karyawan,
				'jht_perusahaan' => $row->jht_perusahaan,
				'jkm' => $row->jkm,
				'jpk_lajang' => $row->jpk_lajang,
				'jpk_nikah' => $row->jpk_nikah,
				'batas_jpk' => $row->batas_jpk,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
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
            'action' => site_url('PayrollManagement/MasterParamTarifJamsostek/save'),
				'periode_jst' => set_value(''),
			'jkk' => set_value('jkk'),
			'jht_karyawan' => set_value('jht_karyawan'),
			'jht_perusahaan' => set_value('jht_perusahaan'),
			'jkm' => set_value('jkm'),
			'jpk_lajang' => set_value('jpk_lajang'),
			'jpk_nikah' => set_value('jpk_nikah'),
			'batas_jpk' => set_value('batas_jpk'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

        
            $data = array(
                'periode_jst' => $this->input->post('txtPeriodeJst_new',TRUE),
				'jkk' => $this->input->post('txtJkk',TRUE),
				'jht_karyawan' => $this->input->post('txtJhtKaryawan',TRUE),
				'jht_perusahaan' => $this->input->post('txtJhtPerusahaan',TRUE),
				'jkm' => $this->input->post('txtJkm',TRUE),
				'jpk_lajang' => $this->input->post('txtJpkLajang',TRUE),
				'jpk_nikah' => $this->input->post('txtJpkNikah',TRUE),
				'batas_jpk' => $this->input->post('txtBatasJpk',TRUE),
			);

            $this->M_masterparamtarifjamsostek->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamtarifjamsostek->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamTarifJamsostek/saveUpdate'),
                'periode_jst' => set_value('txtPeriodeJst_new', $row->periode_jst),
				'periode_jst' => set_value('txtPeriodeJst', $row->periode_jst),
				'jkk' => set_value('txtJkk', $row->jkk),
				'jht_karyawan' => set_value('txtJhtKaryawan', $row->jht_karyawan),
				'jht_perusahaan' => set_value('txtJhtPerusahaan', $row->jht_perusahaan),
				'jkm' => set_value('txtJkm', $row->jkm),
				'jpk_lajang' => set_value('txtJpkLajang', $row->jpk_lajang),
				'jpk_nikah' => set_value('txtJpkNikah', $row->jpk_nikah),
				'batas_jpk' => set_value('txtBatasJpk', $row->batas_jpk),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        
            $data = array(
                'periode_jst' => $this->input->post('txtPeriodeJst_new',TRUE),
				'jkk' => $this->input->post('txtJkk',TRUE),
				'jht_karyawan' => $this->input->post('txtJhtKaryawan',TRUE),
				'jht_perusahaan' => $this->input->post('txtJhtPerusahaan',TRUE),
				'jkm' => $this->input->post('txtJkm',TRUE),
				'jpk_lajang' => $this->input->post('txtJpkLajang',TRUE),
				'jpk_nikah' => $this->input->post('txtJpkNikah',TRUE),
				'batas_jpk' => $this->input->post('txtBatasJpk',TRUE),
			);

            $this->M_masterparamtarifjamsostek->update($this->input->post('txtPeriodeJst', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        
    }

    public function delete($id)
    {
        $row = $this->M_masterparamtarifjamsostek->get_by_id($id);

        if ($row) {
            $this->M_masterparamtarifjamsostek->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
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

/* End of file C_MasterParamTarifJamsostek.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek.php */
/* Generated automatically on 2016-11-29 09:11:10 */