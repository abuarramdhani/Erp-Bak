<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParameterTarifPph extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifPPH/M_masterparametertarifpph');
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
        $data['SubMenuOne'] = 'Set Tarif PPH';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterParameterTarifPph = $this->M_masterparametertarifpph->get_all();

        $data['masterParameterTarifPph_data'] = $masterParameterTarifPph;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParameterTarifPph/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparametertarifpph->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Tarif PPH',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kd_pph' => $row->kd_pph,
				'batas_bawah' => $row->batas_bawah,
				'batas_atas' => $row->batas_atas,
				'persen' => $row->persen,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParameterTarifPph/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParameterTarifPph'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Tarif PPH',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterParameterTarifPph/save'),
			'kd_pph' => set_value(''),
			'batas_bawah' => set_value('batas_bawah'),
			'batas_atas' => set_value('batas_atas'),
			'persen' => set_value('persen'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParameterTarifPph/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

		//MASTER DELETE CURRENT
		$md_where = array(
			'kd_pph' => $this->input->post('txtKdPphNew',TRUE),
		);

		//MASTER INSERT NEW
		$data = array(
			'kd_pph' => $this->input->post('txtKdPphNew',TRUE),
			'batas_bawah' => str_replace(',','',$this->input->post('txtBatasBawah',TRUE)),
			'batas_atas' => str_replace(',','',$this->input->post('txtBatasAtas',TRUE)),
			'persen' => $this->input->post('txtPersen',TRUE),
		);

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'kd_pph' => $this->input->post('txtKdPphNew',TRUE),
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);

		//RIWAYAT INSERT NEW
		$ri_data = array(
			'tgl_berlaku' 		=> date('Y-m-d'),
			'tgl_tberlaku' 		=> '9999-12-31',
			'kd_pph' 			=> $this->input->post('txtKdPphNew',TRUE),
			'batas_bawah' 		=> str_replace(',','',$this->input->post('txtBatasBawah',TRUE)),
			'batas_atas' 		=> str_replace(',','',$this->input->post('txtBatasAtas',TRUE)),
			'persen' 			=> $this->input->post('txtPersen',TRUE),
			'kode_petugas' 		=> $this->session->userdata('userid'),
			'tgl_jam_record' 	=> date('Y-m-d H:i:s'),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add set Tarif PPH kd_pph=".$this->input->post('txtKdPph');
        $this->log_activity->activity_log($aksi, $detail);
        //
		$this->M_masterparametertarifpph->master_delete($md_where);
		$this->M_masterparametertarifpph->insert($data);
		$this->M_masterparametertarifpph->riwayat_update($ru_where,$ru_data);
		$this->M_masterparametertarifpph->riwayat_insert($ri_data);

        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/MasterParameterTarifPph'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparametertarifpph->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Tarif PPH',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParameterTarifPph/saveUpdate'),
				'kd_pph' => set_value('txtKdPph', $row->kd_pph),
				'batas_bawah' => set_value('txtBatasBawah', $row->batas_bawah),
				'batas_atas' => set_value('txtBatasAtas', $row->batas_atas),
				'persen' => set_value('txtPersen', $row->persen),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParameterTarifPph/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParameterTarifPph'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        $data = array(
			'kd_pph' => $this->input->post('txtKdPphNew',TRUE),
			'batas_bawah' => str_replace(',','',$this->input->post('txtBatasBawah',TRUE)),
			'batas_atas' => str_replace(',','',$this->input->post('txtBatasAtas',TRUE)),
			'persen' => $this->input->post('txtPersen',TRUE),
		);

		$data_riwayat = array(
			'batas_bawah' => str_replace(',','',$this->input->post('txtBatasBawah',TRUE)),
			'batas_atas' => str_replace(',','',$this->input->post('txtBatasAtas',TRUE)),
			'persen' => $this->input->post('txtPersen',TRUE),
			'tgl_berlaku' 		=> date('Y-m-d'),
			'kode_petugas' 		=> $this->session->userdata('userid'),
			'tgl_jam_record' 	=> date('Y-m-d H:i:s'),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update set Tarif PPH kd_pph=".$this->input->post('txtKdPph')." menjadi ".$this->input->post('txtKdPphNew');
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->M_masterparametertarifpph->update($this->input->post('txtKdPph', TRUE), $data);
        $this->M_masterparametertarifpph->update_riwayat($this->input->post('txtKdPphNew', TRUE), $data_riwayat);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('PayrollManagement/MasterParameterTarifPph'));
    }

    public function delete($id)
    {
        $row = $this->M_masterparametertarifpph->get_by_id($id);

        if ($row) {
            $this->M_masterparametertarifpph->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set Tarif PPH ID=".$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterParameterTarifPph'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterParameterTarifPph'));
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

/* End of file C_MasterParameterTarifPph.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifPPH/C_MasterParameterTarifPph.php */
/* Generated automatically on 2016-11-26 09:37:36 */
