<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SetGajiUMP extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetGajiUMP/M_setgajiump');
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
        $data['SubMenuOne'] = 'Set Gaji UMP';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $SetGajiUMP = $this->M_setgajiump->get_all();

        $data['setgajiump_data'] = $SetGajiUMP;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/SetGajiUMP/V_index', $data);
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

        $row = $this->M_setgajiump->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Tarif UMP',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kode_ump' => $row->kode_ump,
				'ump' => $row->ump,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/SetGajiUMP/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetGajiUMP'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Tarif UMP',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/SetGajiUMP/save'),
			'id_lokasi_kerja' => set_value('id_lokasi_kerja'),
			'kode_ump' => set_value(''),
			'ump' => set_value(''),
			'pr_lokasi_kerja_data' => $this->M_setgajiump->get_lokasi_kerja(),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/SetGajiUMP/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
        $data = array(
			'kode_ump' => date('YmdHis'),
			'ump' => str_replace(',','',$this->input->post('txtUMP',TRUE)),
			'id_lokasi_kerja'	=>	$this->input->post('txtLokasiKerja',TRUE),
		);

		$data_riwayat = array(
			'id_riw_gaji_ump'	=>	date('YmdHis'),
			'id_kantor_asal'	=>	$this->input->post('txtLokasiKerja',TRUE),
			'id_lokasi_kerja'	=>	$this->input->post('txtLokasiKerja',TRUE),
			'ump'	=>	 str_replace(',','',$this->input->post('txtUMP',TRUE)),
			'tgl_berlaku'	=> date('Y-m-d'),
			'tgl_tberlaku'	=> date('9999-12-31'),
			'kd_petugas'	=> $this->session->userdata('userid'),
			'tgl_rec'	=> date('Y-m-d H:i:s'),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create set UMP ID=".date('YmdHis');
        $this->log_activity->activity_log($aksi, $detail);
        //

		//MASTER DELETE
		$dl_where = array(
			'id_lokasi_kerja'	=>	$this->input->post('txtLokasiKerja',TRUE),
		);

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
			'id_lokasi_kerja'	=>	$this->input->post('txtLokasiKerja',TRUE),
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);

        $this->M_setgajiump->master_delete($dl_where);
        $this->M_setgajiump->insert($data);
		$this->M_setgajiump->riwayat_update($ru_where,$ru_data);
        $this->M_setgajiump->insert_riwayat($data_riwayat);
        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/SetGajiUMP'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_setgajiump->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Tarif UMP',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/SetGajiUMP/saveUpdate'),
				'kode_ump' => set_value('txtKdStatusKerja', $row->kode_ump),
				'id_lokasi_kerja' => set_value('txtLokasiKerja', $row->id_lokasi_kerja),
				'ump' => set_value('txtStatusKerja', $row->ump),
				'pr_lokasi_kerja_data' => $this->M_setgajiump->get_lokasi_kerja(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/SetGajiUMP/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetGajiUMP'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

        $data = array(
			'ump' => str_replace(',','',$this->input->post('txtUMP',TRUE)),
		);
		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
			'id_lokasi_kerja'	=>	$this->input->post('txtLokasiKerja',TRUE),
		);
		$ru_data = array(
			'tgl_berlaku' => date('Y-m-d'),
			'ump' => str_replace(',','',$this->input->post('txtUMP',TRUE)),
			'kd_petugas'	=> $this->session->userdata('userid'),
			'tgl_rec'	=> date('Y-m-d H:i:s'),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update set UMP Kode_UMP=".$this->input->post('txtKodeUMP');
        $this->log_activity->activity_log($aksi, $detail);
        //

            $this->M_setgajiump->update($this->input->post('txtKodeUMP', TRUE), $data);
			$this->M_setgajiump->riwayat_update($ru_where,$ru_data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetGajiUMP'));
    }

    public function delete($id)
    {
        $row = $this->M_setgajiump->get_by_id($id);

        if ($row) {
            $this->M_setgajiump->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set UMP ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetGajiUMP'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetGajiUMP'));
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

/* End of file C_SetGajiUMP.php */
/* Location: ./application/controllers/PayrollManagement/SetGajiUMP/C_SetGajiUMP.php */
/* Generated automatically on 2016-11-24 09:46:53 */
