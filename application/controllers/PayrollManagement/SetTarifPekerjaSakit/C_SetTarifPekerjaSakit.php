<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SetTarifPekerjaSakit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifPekerjaSakit/M_settarifpekerjasakit');
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
        $data['SubMenuOne'] = 'Set Tarif Pekerja Sakit';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $SetTarifPekerjaSakit = $this->M_settarifpekerjasakit->get_all();

        $data['settarifpekerjasakit_data'] = $SetTarifPekerjaSakit;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/SetTarifPekerjaSakit/V_index', $data);
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

        $row = $this->M_settarifpekerjasakit->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Tarif Pekerja Sakit',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kd_tarif' => $row->kd_tarif,
				'tingkatan' => $row->tingkatan,
				'bulan_awal' => $row->bulan_awal,
				'bulan_akhir' => $row->bulan_akhir,
				'persentase' => $row->persentase,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/SetTarifPekerjaSakit/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetTarifPekerjaSakit'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Tarif Pekerja Sakit',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/SetTarifPekerjaSakit/save'),

			'kd_tarif' => set_value(''),
			'tingkatan' => set_value(''),
			'bulan_awal' => set_value(''),
			'bulan_akhir' => set_value(''),
			'persentase' => set_value(''),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/SetTarifPekerjaSakit/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();

		//MASTER DELETE CURRENT
		$md_where = array(
			'tingkatan' 	=> $this->input->post('txtTingkatan',TRUE),
		);

		//MASTER INSERT NEW
        $data = array(
			'kd_tarif' 		=> date('YmdHis'),
			'tingkatan' 	    => $this->input->post('txtTingkatan',TRUE),
			'bulan_awal' 	=> $this->input->post('txtBulanAwal',TRUE),
			'bulan_akhir' 	=> $this->input->post('txtBulanAkhir',TRUE),
			'persentase' 	=> $this->input->post('txtPersentase',TRUE),
		);

		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'tingkatan' 	    => $this->input->post('txtTingkatan',TRUE),
			'tgl_tberlaku' 	=> '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 	=> date('Y-m-d'),
		);

		//RIWAYAT INSERT NEW
		$ri_data = array(
			'kd_tarif' 		=> date('YmdHis'),
			'tingkatan' 	=> $this->input->post('txtTingkatan',TRUE),
			'bulan_awal' 	=> $this->input->post('txtBulanAwal',TRUE),
			'bulan_akhir' 	=> $this->input->post('txtBulanAkhir',TRUE),
			'persentase' 	=> $this->input->post('txtPersentase',TRUE),
			'tgl_berlaku' 	=> date('Y-m-d'),
			'tgl_tberlaku' 	=> '9999-12-31',
			'kd_petugas' 	=> $this->session->userdata('userid'),
			'tgl_rec' 		=> date('Y-m-d H:i:s'),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create set Tarif pekerja sakit kode=".date('YmdHis')." tingkatan=".$this->input->post('txtTingkatan');
        $this->log_activity->activity_log($aksi, $detail);
        //

		$this->M_settarifpekerjasakit->master_delete($md_where);
		$this->M_settarifpekerjasakit->insert($data);
		$this->M_settarifpekerjasakit->riwayat_update($ru_where,$ru_data);
		$this->M_settarifpekerjasakit->riwayat_insert($ri_data);

        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/SetTarifPekerjaSakit'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_settarifpekerjasakit->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Tarif Pekerja Sakit',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/SetTarifPekerjaSakit/saveUpdate'),

				'kd_tarif' => $row->kd_tarif,
				'tingkatan' => $row->tingkatan,
				'bulan_awal' => $row->bulan_awal,
				'bulan_akhir' => $row->bulan_akhir,
				'persentase' => $row->persentase,
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/SetTarifPekerjaSakit/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetTarifPekerjaSakit'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

        $data = array(
			'bulan_awal' => $this->input->post('txtBulanAwal',TRUE),
			'bulan_akhir' => $this->input->post('txtBulanAkhir',TRUE),
			'persentase' => $this->input->post('txtPersentase',TRUE),
		);

		$ru_where = array(
			'tingkatan' 	    => $this->input->post('txtTingkatan',TRUE),
			'tgl_tberlaku' 	=> '9999-12-31',
		);
		$ru_data = array(
			'tgl_berlaku' 	=> date('Y-m-d'),
			'bulan_awal' => $this->input->post('txtBulanAwal',TRUE),
			'bulan_akhir' => $this->input->post('txtBulanAkhir',TRUE),
			'persentase' => $this->input->post('txtPersentase',TRUE),
			'kd_petugas' 	=> $this->session->userdata('userid'),
			'tgl_rec' 		=> date('Y-m-d H:i:s'),

		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update set Tarif pekerja sakit tingakatan=".$this->input->post('txtPersentase');
        $this->log_activity->activity_log($aksi, $detail);
        //

		$this->M_settarifpekerjasakit->update($this->input->post('txtTingkatan',TRUE), $data);
		$this->M_settarifpekerjasakit->riwayat_update($ru_where,$ru_data);
		$this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
				 "success_update" => 1
			);
		$this->session->set_userdata($ses);
		redirect(site_url('PayrollManagement/SetTarifPekerjaSakit'));
    }

    public function delete($id)
    {
        $row = $this->M_settarifpekerjasakit->get_by_id($id);

        if ($row) {
            $this->M_settarifpekerjasakit->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set Tarif pekerja sakit ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetTarifPekerjaSakit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/SetTarifPekerjaSakit'));
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

/* End of file C_SetTarifPekerjaSakit.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifPekerjaSakit/C_SetTarifPekerjaSakit.php */
/* Generated automatically on 2016-11-24 09:46:53 */
