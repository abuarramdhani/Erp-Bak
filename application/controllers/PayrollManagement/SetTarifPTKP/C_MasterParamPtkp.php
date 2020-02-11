<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamPtkp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifPTKP/M_masterparamptkp');
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
        $data['SubMenuOne'] = 'Set Tarif PTKP';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterParamPtkp = $this->M_masterparamptkp->get_all();

        $data['masterParamPtkp_data'] = $masterParamPtkp;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamPtkp/V_index', $data);
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

        $row = $this->M_masterparamptkp->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Tarif PTKP',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_setting' => $row->id_setting,
				'periode' => $row->periode,
				'status_pajak' => $row->status_pajak,
				'ptkp_per_tahun' => $row->ptkp_per_tahun,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamPtkp/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Tarif PTKP',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterParamPtkp/save'),
			'id_setting' => set_value(''),
			'periode' => set_value('periode'),
			'status_pajak' => set_value('status_pajak'),
			'ptkp_per_tahun' => set_value('ptkp_per_tahun'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamPtkp/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();
		$status_pajak 	= strtoupper($this->input->post('txtStatusPajak'));
		$periode 		= str_replace('-','',$this->input->post('txtTglBerlakuPtkp'));
		//MASTER DELETE CURRENT
		$md_where = array(
			'status_pajak' => strtoupper($this->input->post('txtStatusPajak',TRUE)),
		);

		//MASTER INSERT NEW
		$data = array(
			'periode' => $this->input->post('txtTglBerlakuPtkp',TRUE),
			'status_pajak' => strtoupper($this->input->post('txtStatusPajak',TRUE)),
			'ptkp_per_tahun' => str_replace(',','',$this->input->post('txtPtkpPerTahun',TRUE)),
		);

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'status_pajak' => strtoupper($this->input->post('txtStatusPajak',TRUE)),
			'tgl_tberlaku' => '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);
		$time	= date('His');
		//RIWAYAT INSERT NEW
		$ri_data = array(
			'id_riwayat_ptkp'		=> $status_pajak.$periode.$time,
			'periode'				=> $this->input->post('txtTglBerlakuPtkp',TRUE),
			'status_pajak' 			=> strtoupper($this->input->post('txtStatusPajak',TRUE)),
			'ptkp_per_tahun' 		=> str_replace(',','',$this->input->post('txtPtkpPerTahun',TRUE)),
			'tgl_berlaku' 			=> date('Y-m-d'),
			'tgl_tberlaku' 			=> '9999-12-31',
			'kode_petugas' 			=> $this->session->userdata('userid'),
			'tgl_record' 			=> date('Y-m-d H:i:s'),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add set Tarif PTKP ID=".$status_pajak.$periode.$time;
        $this->log_activity->activity_log($aksi, $detail);
        //
		$this->M_masterparamptkp->master_delete($md_where);
		$this->M_masterparamptkp->insert($data);
		$this->M_masterparamptkp->riwayat_update($ru_where,$ru_data);
		$this->M_masterparamptkp->riwayat_insert($ri_data);

		$this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
			 "success_insert" => 1
		);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterParamPtkp'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamptkp->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Tarif PTKP',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamPtkp/saveUpdate'),
				'id_setting' => set_value('txtIdSetting', $row->id_setting),
				'periode' => set_value('txtPeriode', $row->periode),
				'status_pajak' => set_value('txtStatusPajak', $row->status_pajak),
				'ptkp_per_tahun' => set_value('txtPtkpPerTahun', $row->ptkp_per_tahun),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamPtkp/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        if ($this->form_validation->run() == FALSE) {
            $this->update();
        }
        else{
            $data = array(
				'periode' => $this->input->post('txtTglBerlakuPtkp',TRUE),
				'status_pajak' => strtoupper($this->input->post('txtStatusPajak',TRUE)),
				'ptkp_per_tahun' => str_replace(',','',$this->input->post('txtPtkpPerTahun',TRUE)),
			);

			$data_riwayat = array(
				'periode' => $this->input->post('txtTglBerlakuPtkp',TRUE),
				'tgl_berlaku' => date('Y-m-d'),
				'ptkp_per_tahun' => str_replace(',','',$this->input->post('txtPtkpPerTahun',TRUE)),
				'tgl_berlaku' 			=> date('Y-m-d'),
				'kode_petugas' 			=> $this->session->userdata('userid'),
				'tgl_record' 			=> date('Y-m-d H:i:s'),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set Tarif PTKP ID=".$this->input->post('txtIdSetting');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_masterparamptkp->update($this->input->post('txtIdSetting', TRUE), $data);
            $this->M_masterparamptkp->update_riwayat(strtoupper($this->input->post('txtStatusPajak',TRUE)), $data_riwayat);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_masterparamptkp->get_by_id($id);
        if ($row) {
            $this->M_masterparamptkp->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set Tarif PTKP ID=".$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamPtkp'));
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
		$this->form_validation->set_rules('txtPeriode', 'Periode', 'max_length[6]');
		$this->form_validation->set_rules('txtStatusPajak', 'Status Pajak', 'max_length[3]');
		$this->form_validation->set_rules('txtPtkpPerTahun', 'Ptkp Per Tahun', 'max_length[10]');
	}

}

/* End of file C_MasterParamPtkp.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifPTKP/C_MasterParamPtkp.php */
/* Generated automatically on 2016-11-26 09:02:07 */
