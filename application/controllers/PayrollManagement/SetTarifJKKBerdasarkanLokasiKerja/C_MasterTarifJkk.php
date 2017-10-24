<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterTarifJkk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/M_mastertarifjkk');
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
        $masterTarifJkk = $this->M_mastertarifjkk->get_all();

        $data['masterTarifJkk_data'] = $masterTarifJkk;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterTarifJkk/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_mastertarifjkk->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_tarif_jkk' => $row->id_tarif_jkk,
				'id_kantor_asal' => $row->id_kantor_asal,
				'id_lokasi_kerja' => $row->id_lokasi_kerja,
				'tarif_jkk' => $row->tarif_jkk,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterTarifJkk/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterTarifJkk'));
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
            'action' => site_url('PayrollManagement/MasterTarifJkk/save'),
			'id_tarif_jkk' => set_value('id_tarif_jkk'),
			'pr_kantor_asal_data' => $this->M_mastertarifjkk->get_pr_kantor_asal_data(),
			'id_kantor_asal' => set_value('id_kantor_asal'),
			'pr_lokasi_kerja_data' => $this->M_mastertarifjkk->get_pr_lokasi_kerja_data(),
			'id_lokasi_kerja' => set_value('id_lokasi_kerja'),
			'tarif_jkk' => set_value('tarif_jkk'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterTarifJkk/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();
		
		$getId = $this->M_mastertarifjkk->getId();
		if(empty($getId)){
			$get = 1 ;
		}else{
			$get = (int)$getId->id_tarif_jkk + 1;
		}
		
        //MASTER DELETE CURRENT
		$md_where = array(
			'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
			'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
		);
		
		//MASTER INSERT NEW
        $data = array(
			'id_tarif_jkk' => $get,
			'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
			'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
			'tarif_jkk' => $this->input->post('txtTarifJkk',TRUE),
		);
		
		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'id_kantor_asal' 	=> $this->input->post('cmbIdKantorAsal',TRUE),
			'id_lokasi_kerja' 	=> $this->input->post('cmbIdLokasiKerja',TRUE),
			'tgl_tberlaku' 		=> '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku' 		=> date('Y-m-d'),
			'status_aktif' 		=> '0',
		);
		
		//RIWAYAT INSERT NEW
		$ri_data = array(
			'tgl_berlaku' 		=> date('Y-m-d'),
			'tgl_tberlaku' 		=> '9999-12-31',
			'id_kantor_asal'	=> $this->input->post('cmbIdKantorAsal',TRUE),
			'id_lokasi_kerja' 	=> $this->input->post('cmbIdLokasiKerja',TRUE),
			'tarif_jkk' 		=> $this->input->post('txtTarifJkk',TRUE),
			'kd_petugas' 		=> $this->session->userdata('userid'),
			'tgl_rec' 		=> date('Y-m-d H:i:s'),
			'status_aktif' 		=> '1',
		);

		$this->M_mastertarifjkk->master_delete($md_where);
		$this->M_mastertarifjkk->insert($data);
		$this->M_mastertarifjkk->riwayat_update($ru_where,$ru_data);
		$this->M_mastertarifjkk->riwayat_insert($ri_data);
		
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/MasterTarifJkk'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_mastertarifjkk->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterTarifJkk/saveUpdate'),
				'id_tarif_jkk' => set_value('txtIdTarifJkk', $row->id_tarif_jkk),
				'id_kantor_asal' => set_value('txtIdKantorAsal', $row->id_kantor_asal),
				'id_lokasi_kerja' => set_value('txtIdLokasiKerja', $row->id_lokasi_kerja),
				'tarif_jkk' => set_value('txtTarifJkk', $row->tarif_jkk),
                'pr_kantor_asal_data' => $this->M_mastertarifjkk->get_pr_kantor_asal_data(),
                'pr_lokasi_kerja_data' => $this->M_mastertarifjkk->get_pr_lokasi_kerja_data(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterTarifJkk/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterTarifJkk'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

		$data = array(
			'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
			'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
			'tarif_jkk' => $this->input->post('txtTarifJkk',TRUE),
		);
		$ru_data = array(
			'tgl_berlaku' 		=> date('Y-m-d'),
			'tarif_jkk' => $this->input->post('txtTarifJkk',TRUE),
		);	
		$ru_where = array(
			'id_kantor_asal' 	=> $this->input->post('cmbIdKantorAsal',TRUE),
			'id_lokasi_kerja' 	=> $this->input->post('cmbIdLokasiKerja',TRUE),
			'tgl_tberlaku' 		=> '9999-12-31',
		);
            $this->M_mastertarifjkk->update($this->input->post('txtIdTarifJkk', TRUE), $data);
			$this->M_mastertarifjkk->riwayat_update($ru_where,$ru_data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterTarifJkk'));
        
    }

    public function delete($id)
    {
        $row = $this->M_mastertarifjkk->get_by_id($id);

        if ($row) {
            $this->M_mastertarifjkk->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterTarifJkk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterTarifJkk'));
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

/* End of file C_MasterTarifJkk.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk.php */
/* Generated automatically on 2016-11-26 13:01:11 */