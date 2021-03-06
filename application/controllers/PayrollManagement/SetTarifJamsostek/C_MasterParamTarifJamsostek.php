<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamTarifJamsostek extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetTarifJamsostek/M_masterparamtarifjamsostek');
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
        $masterParamTarifJamsostek = $this->M_masterparamtarifjamsostek->get_all();

        $data['masterParamTarifJamsostek_data'] = $masterParamTarifJamsostek;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_index', $data);
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
        
        $row = $this->M_masterparamtarifjamsostek->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'periode_jst' => $row->periode_jst,
				'jkk' => $row->jkk,
				'jht_karyawan' => $row->jht_karyawan,
				'jht_perusahaan' => $row->jht_perusahaan,
				'jkm' => $row->jkm,
				'jpk_karyawan' => $row->jpk_karyawan,
				'jpk_perusahaan' => $row->jpk_perusahaan,
				'batas_jpk' => $row->batas_jpk,
				'batas_umur_jpk' => $row->batas_umur_jpk,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
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
            'action' => site_url('PayrollManagement/MasterParamTarifJamsostek/save'),
				'periode_jst' => set_value(''),
			'jkk' => set_value('jkk'),
			'jht_karyawan' => set_value('jht_karyawan'),
			'jht_perusahaan' => set_value('jht_perusahaan'),
			'jkm' => set_value('jkm'),
			'jpk_karyawan' => set_value('jpk_karyawan'),
			'jpk_perusahaan' => set_value('jpk_perusahaan'),
			'batas_jpk' => set_value('batas_jpk'),
			'batas_umur_jpk' => set_value('batas_umur_jpk'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();
		
		//MASTER INSERT NEW
        $data = array(
			'periode_jst' => $this->input->post('txtPeriodeJst_new',TRUE),
			'jkk' => $this->input->post('txtJkk',TRUE),
			'jht_karyawan' => $this->input->post('txtJhtKaryawan',TRUE),
			'jht_perusahaan' => $this->input->post('txtJhtPerusahaan',TRUE),
			'jkm' => $this->input->post('txtJkm',TRUE),
			'jpk_karyawan' => $this->input->post('txtJpkLajang',TRUE),
			'jpk_perusahaan' => $this->input->post('txtJpkNikah',TRUE),
			'batas_jpk' => str_replace(',','',$this->input->post('txtBatasJpk',TRUE)),
			'batas_umur_jpk' => str_replace(',','',$this->input->post('txtBatasUmurJpk',TRUE)),
		);
		
		//RIWAYAT CHANGE CURRENT
		$ru_where = array(
			'tgl_tberlaku' 	=> '9999-12-31',
		);
		$ru_data = array(
			'tgl_tberlaku'	=> date('Y-m-d'),
		);
		
		//RIWAYAT INSERT NEW
		$ri_data = array(
			'jkk' 					=> $this->input->post('txtJkk',TRUE),
			'jht_karyawan'			=> $this->input->post('txtJhtKaryawan',TRUE),
			'jht_perusahaan' 		=> $this->input->post('txtJhtPerusahaan',TRUE),
			'jkm' 					=> $this->input->post('txtJkm',TRUE),
			'jpk_karyawan' 			=> $this->input->post('txtJpkLajang',TRUE),
			'jpk_perusahaan' 			=> $this->input->post('txtJpkNikah',TRUE),
			'batas_jpk' 			=> str_replace(',','',$this->input->post('txtBatasJpk',TRUE)),		
			'batas_umur_jpk' 			=> str_replace(',','',$this->input->post('txtBatasUmurJpk',TRUE)),		
			'tgl_berlaku' 			=> date('Y-m-d'),
			'tgl_tberlaku' 			=> '9999-12-31',
			'kode_petugas' 			=> '0000001',
			'tgl_record' 			=> date('Y-m-d H:i:s'),
		);

		$this->M_masterparamtarifjamsostek->master_delete();
		$this->M_masterparamtarifjamsostek->insert($data);
		$this->M_masterparamtarifjamsostek->riwayat_update($ru_where,$ru_data);
		$this->M_masterparamtarifjamsostek->riwayat_insert($ri_data);
		
        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamtarifjamsostek->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamTarifJamsostek/saveUpdate'),
                'periode_jst' => set_value('txtPeriodeJst_new', $row->periode_jst),
				'periode_jst' => set_value('txtPeriodeJst', $row->periode_jst),
				'jkk' => set_value('txtJkk', $row->jkk),
				'jht_karyawan' => set_value('txtJhtKaryawan', $row->jht_karyawan),
				'jht_perusahaan' => set_value('txtJhtPerusahaan', $row->jht_perusahaan),
				'jkm' => set_value('txtJkm', $row->jkm),
				'jpk_karyawan' => set_value('txtJpkLajang', $row->jpk_lajang),
				'jpk_perusahaan' => set_value('txtJpkNikah', $row->jpk_nikah),
				'batas_jpk' => set_value('txtBatasJpk', $row->batas_jpk),
				'batas_umur_jpk' => set_value('txtBatasUmurJpk', $row->batas_umur_jpk),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamTarifJamsostek/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        
            $data = array(
                'periode_jst' => $this->input->post('txtPeriodeJst_new',TRUE),
				'jkk' => $this->input->post('txtJkk',TRUE),
				'jht_karyawan' => $this->input->post('txtJhtKaryawan',TRUE),
				'jht_perusahaan' => $this->input->post('txtJhtPerusahaan',TRUE),
				'jkm' => $this->input->post('txtJkm',TRUE),
				'jpk_lajang' => $this->input->post('txtJpkLajang',TRUE),
				'jpk_nikah' => $this->input->post('txtJpkNikah',TRUE),
				'batas_jpk' => str_replace(',','',$this->input->post('txtBatasJpk',TRUE)),
				'batas_umur_jpk' => str_replace(',','',$this->input->post('txtBatasUmurJpk',TRUE)),
			);

            $this->M_masterparamtarifjamsostek->update($this->input->post('txtPeriodeJst', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        
    }

    public function delete($id)
    {
        $row = $this->M_masterparamtarifjamsostek->get_by_id($id);

        if ($row) {
            $this->M_masterparamtarifjamsostek->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamTarifJamsostek'));
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

/* End of file C_MasterParamTarifJamsostek.php */
/* Location: ./application/controllers/PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek.php */
/* Generated automatically on 2016-11-29 09:11:10 */