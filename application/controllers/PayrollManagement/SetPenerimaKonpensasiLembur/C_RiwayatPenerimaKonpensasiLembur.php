<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatPenerimaKonpensasiLembur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetPenerimaKonpensasiLembur/M_riwayatpenerimakonpensasilembur');
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
        $data['SubMenuOne'] = 'Set Penerima Komp Lembur';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatPenerimaKonpensasiLembur = $this->M_riwayatpenerimakonpensasilembur->get_all();

        $data['riwayatPenerimaKonpensasiLembur_data'] = $riwayatPenerimaKonpensasiLembur;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatPenerimaKonpensasiLembur/V_index', $data);
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

        $row = $this->M_riwayatpenerimakonpensasilembur->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Penerima Komp Lembur',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_riwayat' => $row->id_riwayat,
				'id_kantor_asal' => $row->id_kantor_asal,
				'id_lokasi_kerja' => $row->id_lokasi_kerja,
				'kd_status_kerja' => $row->kd_status_kerja,
				'kd_jabatan' => $row->kd_jabatan,
				'min_masa_kerja' => $row->min_masa_kerja,
				'prosentase' => $row->prosentase,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'kode_petugas' => $row->kode_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatPenerimaKonpensasiLembur/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Penerima Komp Lembur',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur/save'),
			'id_riwayat' => set_value(''),
			'pr_kantor_asal_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_kantor_asal_data(),
			'id_kantor_asal' => set_value('id_kantor_asal'),
			'pr_lokasi_kerja_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_lokasi_kerja_data(),
			'id_lokasi_kerja' => set_value('id_lokasi_kerja'),
			'pr_master_status_kerja_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_master_status_kerja_data(),
			'kd_status_kerja' => set_value('kd_status_kerja'),
			'pr_master_jabatan_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_master_jabatan_data(),
			'kd_jabatan' => set_value('kd_jabatan'),
			'min_masa_kerja' => set_value('min_masa_kerja'),
			'prosentase' => set_value('prosentase'),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_record' => set_value('tgl_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatPenerimaKonpensasiLembur/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

            $data = array(
				'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
				'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'min_masa_kerja' => $this->input->post('txtMinMasaKerja',TRUE),
				'prosentase' => $this->input->post('txtProsentase',TRUE),
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);

            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create set Komp Lembur KD_JABATAN=".$this->input->post('cmbKdJabatan');
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_riwayatpenerimakonpensasilembur->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatpenerimakonpensasilembur->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Penerima Komp Lembur',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur/saveUpdate'),
				'id_riwayat' => set_value('txtIdRiwayat', $row->id_riwayat),
				'pr_kantor_asal_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_kantor_asal_data(),
				'pr_lokasi_kerja_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_lokasi_kerja_data(),
				'pr_master_status_kerja_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_master_status_kerja_data(),
				'pr_master_jabatan_data' => $this->M_riwayatpenerimakonpensasilembur->get_pr_master_jabatan_data(),
				'id_kantor_asal' => set_value('txtIdKantorAsal', $row->id_kantor_asal),
				'id_lokasi_kerja' => set_value('txtIdLokasiKerja', $row->id_lokasi_kerja),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'kd_jabatan' => set_value('txtKdJabatan', $row->kd_jabatan),
				'min_masa_kerja' => set_value('txtMinMasaKerja', $row->min_masa_kerja),
				'prosentase' => set_value('txtProsentase', $row->prosentase),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_record' => set_value('txtTglRecord', $row->tgl_record),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatPenerimaKonpensasiLembur/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

            $data = array(
				'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
				'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'min_masa_kerja' => $this->input->post('txtMinMasaKerja',TRUE),
				'prosentase' => $this->input->post('txtProsentase',TRUE),
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
				'tgl_record' => $this->input->post('txtTglRecord',TRUE),
			);

            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set Komp Lembur ID=".$this->input->post('txtIdRiwayat');
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_riwayatpenerimakonpensasilembur->update($this->input->post('txtIdRiwayat', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur'));
    }

    public function delete($id)
    {
        $row = $this->M_riwayatpenerimakonpensasilembur->get_by_id($id);

        if ($row) {
            $this->M_riwayatpenerimakonpensasilembur->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set Komp Lembur ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur'));
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

/* End of file C_RiwayatPenerimaKonpensasiLembur.php */
/* Location: ./application/controllers/PayrollManagement/SetPenerimaKonpensasiLembur/C_RiwayatPenerimaKonpensasiLembur.php */
/* Generated automatically on 2016-11-26 10:04:26 */
