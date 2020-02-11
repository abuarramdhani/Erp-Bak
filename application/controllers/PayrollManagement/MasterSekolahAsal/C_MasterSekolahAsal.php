<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterSekolahAsal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterSekolahAsal/M_mastersekolahasal');
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
        $data['SubMenuOne'] = 'Master Sekolah Asal';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterSekolahAsal = $this->M_mastersekolahasal->get_all();

        $data['masterSekolahAsal_data'] = $masterSekolahAsal;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterSekolahAsal/V_index', $data);
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

        $row = $this->M_mastersekolahasal->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Data',
            	'SubMenuOne' => 'Master Sekolah Asal',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'noind' => $row->noind,
				'pendidikan' => $row->pendidikan,
				'sekolah' => $row->sekolah,
				'jurusan' => $row->jurusan,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterSekolahAsal/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSekolahAsal'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Sekolah Asal',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterSekolahAsal/save'),
			'noind' => set_value(''),
			'pendidikan' => set_value('pendidikan'),
			'sekolah' => set_value('sekolah'),
			'jurusan' => set_value('jurusan'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterSekolahAsal/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

		$data = array(
			'noind' => $this->input->post('txtNoindNew',TRUE),
			'pendidikan' => $this->input->post('txtPendidikan',TRUE),
			'sekolah' => $this->input->post('txtSekolah',TRUE),
			'jurusan' => $this->input->post('txtJurusan',TRUE),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add master sekolah asal noind=".$this->input->post('txtNoindNew');
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->M_mastersekolahasal->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
				 "success_import" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterSekolahAsal'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_mastersekolahasal->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Sekolah Asal',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterSekolahAsal/saveUpdate'),
				'noind' => set_value('txtNoind', $row->noind),
				'pendidikan' => set_value('txtPendidikan', $row->pendidikan),
				'sekolah' => set_value('txtSekolah', $row->sekolah),
				'jurusan' => set_value('txtJurusan', $row->jurusan),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterSekolahAsal/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSekolahAsal'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();
		$data = array(
			'noind' => $this->input->post('txtNoindNew',TRUE),
			'pendidikan' => $this->input->post('txtPendidikan',TRUE),
			'sekolah' => $this->input->post('txtSekolah',TRUE),
			'jurusan' => $this->input->post('txtJurusan',TRUE),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update master sekolah asal noind=".$this->input->post('txtNoind')." noind_new=".$this->input->post('txtNoindNew');
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->M_mastersekolahasal->update($this->input->post('txtNoind', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
				 "success_update" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterSekolahAsal'));

    }

    public function delete($id)
    {
        $row = $this->M_mastersekolahasal->get_by_id($id);

        if ($row) {
            $this->M_mastersekolahasal->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master sekolah asal ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSekolahAsal'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSekolahAsal'));
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

/* End of file C_MasterSekolahAsal.php */
/* Location: ./application/controllers/PayrollManagement/MasterSekolahAsal/C_MasterSekolahAsal.php */
/* Generated automatically on 2016-11-24 09:58:05 */
