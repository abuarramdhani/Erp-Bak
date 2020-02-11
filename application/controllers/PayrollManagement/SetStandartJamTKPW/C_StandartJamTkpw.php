<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_StandartJamTkpw extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetStandartJamTKPW/M_standartjamtkpw');
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
        $data['SubMenuOne'] = 'Set Standart Jam TKPW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $standartJamTkpw = $this->M_standartjamtkpw->get_all();

        $data['standartJamTkpw_data'] = $standartJamTkpw;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/StandartJamTkpw/V_index', $data);
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

        $row = $this->M_standartjamtkpw->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Standart Jam TKPW',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kode_standart_jam' => $row->kode_standart_jam,
				'jml_std_jam_per_bln' => $row->jml_std_jam_per_bln,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/StandartJamTkpw/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/StandartJamTkpw'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Standart Jam TKPW',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/StandartJamTkpw/save'),
			'kode_standart_jam' => set_value(''),
			'jml_std_jam_per_bln' => set_value('jml_std_jam_per_bln'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/StandartJamTkpw/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){

		$this->formValidation();

		//MASTER INSERT NEW
        $data = array(
			'kode_standart_jam' 	=> date('YmdHis'),
			'jml_std_jam_per_bln'	=> $this->input->post('txtJmlStdJamPerBln',TRUE),
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

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create set Jam Umum TKPW Kode=".date('YmdHis')." jumlah standar jam =". $this->input->post('txtJmlStdJamPerBln');
        $this->log_activity->activity_log($aksi, $detail);
        //

		$this->M_standartjamtkpw->master_delete();
		$this->M_standartjamtkpw->insert($data);
		$this->M_standartjamtkpw->riwayat_update($ru_where,$ru_data);
		$this->M_standartjamtkpw->riwayat_insert($ri_data);

        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/StandartJamTkpw'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_standartjamtkpw->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Standart Jam TKPW',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/StandartJamTkpw/saveUpdate'),
				'kode_standart_jam' => set_value('txtKodeStandartJam', $row->kode_standart_jam),
				'jml_std_jam_per_bln' => set_value('txtJmlStdJamPerBln', $row->jml_std_jam_per_bln),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/StandartJamTkpw/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/StandartJamTkpw'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();
        $data = array(
			'jml_std_jam_per_bln' => $this->input->post('txtJmlStdJamPerBln',TRUE),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update set Jam Umum TKPW Jumlah=".$this->input->post('txtJmlStdJamPerBln');
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->M_standartjamtkpw->update($data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/StandartJamTkpw'));
    }

    public function delete($id)
    {
        $row = $this->M_standartjamtkpw->get_by_id($id);

        if ($row) {
            $this->M_standartjamtkpw->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set Jam Umum TKPW ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/StandartJamTkpw'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/StandartJamTkpw'));
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

/* End of file C_StandartJamTkpw.php */
/* Location: ./application/controllers/PayrollManagement/SetStandartJamTKPW/C_StandartJamTkpw.php */
/* Generated automatically on 2016-11-26 08:13:40 */
