<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatPotDanaPensiun extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/IuranPensiun/M_riwayatpotdanapensiun');
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
        $riwayatPotDanaPensiun = $this->M_riwayatpotdanapensiun->get_all();

        $data['riwayatPotDanaPensiun_data'] = $riwayatPotDanaPensiun;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatPotDanaPensiun/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_riwayatpotdanapensiun->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_riw_pens' => $row->id_riw_pens,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'noind' => $row->noind,
				'pot_pensiun' => $row->pot_pensiun,
				'kd_petugas' => $row->kd_petugas,
				'tgl_jam_record' => $row->tgl_jam_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatPotDanaPensiun/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
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
            'action' => site_url('PayrollManagement/RiwayatPotDanaPensiun/save'),
				'id_riw_pens' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'noind' => set_value('noind'),
			'pot_pensiun' => set_value('pot_pensiun'),
			'kd_petugas' => set_value('kd_petugas'),
			'tgl_jam_record' => set_value('tgl_jam_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatPotDanaPensiun/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

        
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'pot_pensiun' => $this->input->post('txtPotPensiun',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_jam_record' => $this->input->post('txtTglJamRecord',TRUE),
			);

            $this->M_riwayatpotdanapensiun->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatpotdanapensiun->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatPotDanaPensiun/saveUpdate'),
				'id_riw_pens' => set_value('txtIdRiwPens', $row->id_riw_pens),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'noind' => set_value('txtNoind', $row->noind),
				'pot_pensiun' => set_value('txtPotPensiun', $row->pot_pensiun),
				'kd_petugas' => set_value('txtKdPetugas', $row->kd_petugas),
				'tgl_jam_record' => set_value('txtTglJamRecord', $row->tgl_jam_record),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatPotDanaPensiun/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'pot_pensiun' => $this->input->post('txtPotPensiun',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_jam_record' => $this->input->post('txtTglJamRecord',TRUE),
			);

            $this->M_riwayatpotdanapensiun->update($this->input->post('txtIdRiwPens', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        
    }

    public function delete($id)
    {
        $row = $this->M_riwayatpotdanapensiun->get_by_id($id);

        if ($row) {
            $this->M_riwayatpotdanapensiun->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
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

/* End of file C_RiwayatPotDanaPensiun.php */
/* Location: ./application/controllers/PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun.php */
/* Generated automatically on 2016-11-26 10:45:31 */