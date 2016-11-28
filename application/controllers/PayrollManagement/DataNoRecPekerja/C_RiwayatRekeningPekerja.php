<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatRekeningPekerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/DataNoRecPekerja/M_riwayatrekeningpekerja');
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
        $riwayatRekeningPekerja = $this->M_riwayatrekeningpekerja->get_all();

        $data['riwayatRekeningPekerja_data'] = $riwayatRekeningPekerja;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_riwayatrekeningpekerja->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_riw_rek_pkj' => $row->id_riw_rek_pkj,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'noind' => $row->noind,
				'kd_bank' => $row->kd_bank,
				'no_rekening' => $row->no_rekening,
				'nama_pemilik_rekening' => $row->nama_pemilik_rekening,
				'kode_petugas' => $row->kode_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
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
            'action' => site_url('PayrollManagement/RiwayatRekeningPekerja/save'),
				'id_riw_rek_pkj' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'noind' => set_value('noind'),
			'pr_master_bank_data' => $this->M_riwayatrekeningpekerja->get_pr_master_bank_data(),
			'kd_bank' => set_value('kd_bank'),
			'no_rekening' => set_value('no_rekening'),
			'nama_pemilik_rekening' => set_value('nama_pemilik_rekening'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_record' => set_value('tgl_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_bank' => $this->input->post('cmbKdBank',TRUE),
				'no_rekening' => $this->input->post('txtNoRekening',TRUE),
				'nama_pemilik_rekening' => $this->input->post('txtNamaPemilikRekening',TRUE),
				'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
				'tgl_record' => $this->input->post('txtTglRecord',TRUE),
			);

            $this->M_riwayatrekeningpekerja->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatrekeningpekerja->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatRekeningPekerja/saveUpdate'),
				'id_riw_rek_pkj' => set_value('txtIdRiwRekPkj', $row->id_riw_rek_pkj),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'noind' => set_value('txtNoind', $row->noind),
				'kd_bank' => set_value('txtKdBank', $row->kd_bank),
				'no_rekening' => set_value('txtNoRekening', $row->no_rekening),
				'nama_pemilik_rekening' => set_value('txtNamaPemilikRekening', $row->nama_pemilik_rekening),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_record' => set_value('txtTglRecord', $row->tgl_record),
                'pr_master_bank_data' => $this->M_riwayatrekeningpekerja->get_pr_master_bank_data(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_bank' => $this->input->post('cmbKdBank',TRUE),
				'no_rekening' => $this->input->post('txtNoRekening',TRUE),
				'nama_pemilik_rekening' => $this->input->post('txtNamaPemilikRekening',TRUE),
				'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
				'tgl_record' => $this->input->post('txtTglRecord',TRUE),
			);

            $this->M_riwayatrekeningpekerja->update($this->input->post('txtIdRiwRekPkj', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        
    }

    public function delete($id)
    {
        $row = $this->M_riwayatrekeningpekerja->get_by_id($id);

        if ($row) {
            $this->M_riwayatrekeningpekerja->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
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

/* End of file C_RiwayatRekeningPekerja.php */
/* Location: ./application/controllers/PayrollManagement/DataNoRecPekerja/C_RiwayatRekeningPekerja.php */
/* Generated automatically on 2016-11-26 10:45:12 */