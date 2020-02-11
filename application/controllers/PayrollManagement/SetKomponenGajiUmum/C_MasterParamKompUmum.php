<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamKompUmum extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
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

        $data['Menu'] = 'Set Parameter';
        $data['SubMenuOne'] = 'Set Komponen Gaji Umum';
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

        $row = $this->M_masterparamkompumum->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Komponen Gaji Umum',
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
			$ses=array(
					 "not_found" => 1
				);
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Komponen Gaji Umum',
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
				'um' => str_replace('.','',$this->input->post('txtUmNew',TRUE)),
				'ubt' => str_replace('.','',$this->input->post('txtUbt',TRUE)),
			);

			$data_riwayat = array(
				'id_riwayat' => date('YmdHis'),
				'tgl_berlaku' => date('Y-m-d'),
				'tgl_tberlaku' => '9999-12-31',
				'um' => str_replace('.','',$this->input->post('txtUmNew',TRUE)),
				'ubt' => str_replace('.','',$this->input->post('txtUbt',TRUE)),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);

			$check	= $this->M_masterparamkompumum->check();
			if($check){
				$this->M_masterparamkompumum->update($data);
                //insert to sys.log_activity
                $aksi = 'Payroll Management';
                $detail = "Update set komponen gaji Umum um=".$this->input->post('txtUmNew');
                $this->log_activity->activity_log($aksi, $detail);
                //
			}else{
				$this->M_masterparamkompumum->insert($data);
                //insert to sys.log_activity
                $aksi = 'Payroll Management';
                $detail = "Add set komponen gaji Umum um=".$this->input->post('txtUmNew');
                $this->log_activity->activity_log($aksi, $detail);
                //
			}

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
			$ses=array(
				 "success_insert" => 1
			);
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamkompumum->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Komponen Gaji Umum',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamKompUmum/saveUpdate'),
				'um' => set_value('txtUm', number_format((int)$row->um,0,",",".")),
				'ubt' => set_value('txtUbt', number_format((int)$row->ubt,0,",",".")),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamKompUmum/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
				 "not_found" => 1
			);
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

            $data = array(
				'um' => str_replace(',','',$this->input->post('txtUmNew',TRUE)),
				'ubt' => str_replace(',','',$this->input->post('txtUbt',TRUE)),
			);

            $this->M_masterparamkompumum->update($data);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set komponen gaji Umum um=".$this->input->post('txtUmNew');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
				 "success_update" => 1
			);
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
    }

    public function delete($id)
    {
        $row = $this->M_masterparamkompumum->get_by_id($id);

        if ($row) {
            $this->M_masterparamkompumum->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set komponen gaji Umum ID=".$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
				 "success_delete" => 1
			);
            redirect(site_url('PayrollManagement/MasterParamKompUmum'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
				 "not_found" => 1
			);
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
