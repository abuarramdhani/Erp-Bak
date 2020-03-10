<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatSetAsuransi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetPenerimaAsuransi/M_riwayatsetasuransi');
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
        $data['SubMenuOne'] = 'Set Tarif Asuransi';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatSetAsuransi = $this->M_riwayatsetasuransi->get_all();

        $data['riwayatSetAsuransi_data'] = $riwayatSetAsuransi;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatSetAsuransi/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatsetasuransi->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Tarif Asuransi',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_set_asuransi' => $row->id_set_asuransi,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'kd_status_kerja' => $row->kd_status_kerja,
				'jkk' => $row->jkk,
				'jkm' => $row->jkm,
				'jht_kary' => $row->jht_kary,
				'jht_prshn' => $row->jht_prshn,
				'jkn_kary' => $row->jkn_kary,
				'jkn_prshn' => $row->jkn_prshn,
				'jpn_kary' => $row->jpn_kary,
				'jpn_prshn' => $row->jpn_prshn,
				'kd_petugas' => $row->kd_petugas,
				'tgl_rec' => $row->tgl_rec,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatSetAsuransi/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatSetAsuransi'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Tarif Asuransi',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/RiwayatSetAsuransi/save'),
				'id_set_asuransi' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'pr_master_status_kerja_data' => $this->M_riwayatsetasuransi->get_pr_master_status_kerja_data(),
			'kd_status_kerja' => set_value('kd_status_kerja'),
			'jkk' => set_value('jkk'),
			'jkm' => set_value('jkm'),
			'jht_kary' => set_value('jht_kary'),
			'jht_prshn' => set_value('jht_prshn'),
			'jkn_kary' => set_value('jkn_kary'),
			'jkn_prshn' => set_value('jkn_prshn'),
			'jpn_kary' => set_value('jpn_kary'),
			'jpn_prshn' => set_value('jpn_prshn'),
			'kd_petugas' => set_value('kd_petugas'),
			'tgl_rec' => set_value('tgl_rec'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatSetAsuransi/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'jkk' => $this->input->post('txtJkk',TRUE),
				'jkm' => $this->input->post('txtJkm',TRUE),
				'jht_kary' => $this->input->post('txtJhtKary',TRUE),
				'jht_prshn' => $this->input->post('txtJhtPrshn',TRUE),
				'jkn_kary' => $this->input->post('txtJknKary',TRUE),
				'jkn_prshn' => $this->input->post('txtJknPrshn',TRUE),
				'jpn_kary' => $this->input->post('txtJpnKary',TRUE),
				'jpn_prshn' => $this->input->post('txtJpnPrshn',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_rec' => date('Y-m-d H:i:s'),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Add set penerima asuransi kd_status_kerja=".$this->input->post('cmbKdStatusKerja');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_riwayatsetasuransi->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/RiwayatSetAsuransi'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatsetasuransi->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Tarif Asuransi',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatSetAsuransi/saveUpdate'),
				'pr_master_status_kerja_data' => $this->M_riwayatsetasuransi->get_pr_master_status_kerja_data(),
				'id_set_asuransi' => set_value('txtIdSetAsuransi', $row->id_set_asuransi),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'jkk' => set_value('txtJkk', $row->jkk),
				'jkm' => set_value('txtJkm', $row->jkm),
				'jht_kary' => set_value('txtJhtKary', $row->jht_kary),
				'jht_prshn' => set_value('txtJhtPrshn', $row->jht_prshn),
				'jkn_kary' => set_value('txtJknKary', $row->jkn_kary),
				'jkn_prshn' => set_value('txtJknPrshn', $row->jkn_prshn),
				'jpn_kary' => set_value('txtJpnKary', $row->jpn_kary),
				'jpn_prshn' => set_value('txtJpnPrshn', $row->jpn_prshn),
				'kd_petugas' => set_value('txtKdPetugas', $row->kd_petugas),
				'tgl_rec' => set_value('txtTglRec', $row->tgl_rec),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatSetAsuransi/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatSetAsuransi'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'jkk' => $this->input->post('txtJkk',TRUE),
				'jkm' => $this->input->post('txtJkm',TRUE),
				'jht_kary' => $this->input->post('txtJhtKary',TRUE),
				'jht_prshn' => $this->input->post('txtJhtPrshn',TRUE),
				'jkn_kary' => $this->input->post('txtJknKary',TRUE),
				'jkn_prshn' => $this->input->post('txtJknPrshn',TRUE),
				'jpn_kary' => $this->input->post('txtJpnKary',TRUE),
				'jpn_prshn' => $this->input->post('txtJpnPrshn',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_rec' => $this->input->post('txtTglRec',TRUE),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set penerima asuransi ID=".$this->input->post('txtIdSetAsuransi');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_riwayatsetasuransi->update($this->input->post('txtIdSetAsuransi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/RiwayatSetAsuransi'));

    }

    public function delete($id)
    {
        $row = $this->M_riwayatsetasuransi->get_by_id($id);

        if ($row) {
            $this->M_riwayatsetasuransi->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set penerima asuransi ID=".$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/RiwayatSetAsuransi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatSetAsuransi'));
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

/* End of file C_RiwayatSetAsuransi.php */
/* Location: ./application/controllers/PayrollManagement/SetPenerimaAsuransi/C_RiwayatSetAsuransi.php */
/* Generated automatically on 2016-11-26 13:10:18 */
