<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_KompTamb extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/KomponenTambahan/M_komptamb');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
		$this->load->library('Encrypt');
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Komp. Kena/Tdk Kena Pajak';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $kompTamb = $this->M_komptamb->get_all();

        $data['kompTamb_data'] = $kompTamb;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTamb/V_index', $data);
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
        $plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_komptamb->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Komponen Penggajian',
            	'SubMenuOne' => 'Komp. Kena/Tdk Kena Pajak',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id' => $row->id,
				'periode' => $row->periode,
				'noind' => $row->noind,
				'tambahan' => $row->tambahan,
				'stat' => $row->stat,
				'desc_' => $row->desc_,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTamb/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTamb'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Komponen Penggajian',
            'SubMenuOne' => 'Komp. Kena/Tdk Kena Pajak',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/KompTamb/save'),
				'id' => set_value(''),
			'periode' => set_value('periode'),
			'pr_master_pekerja_data' => $this->M_komptamb->get_pr_master_pekerja_data(),
			'noind' => set_value('noind'),
			'tambahan' => set_value('tambahan'),
			'stat' => set_value('stat'),
			'desc_' => set_value('desc_'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTamb/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();
		$dt = explode("/",$this->input->post('txtPeriode',TRUE));
		$tgl_transaksi = $dt[1]."-".$dt[0];
            $data = array(
				'periode' => $tgl_transaksi,
				'noind' => $this->input->post('txtNoind',TRUE),
				'tambahan' => str_replace('.','',$this->input->post('txtTambahan',TRUE)),
				'stat' => $this->input->post('cmbStat',TRUE),
				'desc_' => $this->input->post('txtDesc',TRUE),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create Komponen Tambahan pajak noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_komptamb->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTamb'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id_e = $this->encrypt->decode($plaintext_string);
        $row = $this->M_komptamb->get_by_id($id_e);

        if ($row) {
            $data = array(
                'Menu' => 'Komponen Penggajian',
                'SubMenuOne' => 'Komp. Kena/Tdk Kena Pajak',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/KompTamb/saveUpdate/'.$id),
				'id' => set_value('txtId', $row->id),
				'periode' => set_value('txtPeriode', date("m/Y",strtotime($row->periode))),
				'noind' => set_value('txtNoind', $row->noind),
				'tambahan' => set_value('txtTambahan', number_format((int)$row->tambahan,0,",",".")),
				'stat' => set_value('txtStat', $row->stat),
				'desc_' => set_value('txtDesc', $row->desc_),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTamb/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTamb'));
        }
    }

    public function saveUpdate($id)
    {
        $this->formValidation();
			$dt = explode("/",$this->input->post('txtPeriode',TRUE));
			$tgl_transaksi = $dt[1]."-".$dt[0];
			$data = array(
				'periode' => $tgl_transaksi,
				'noind' => $this->input->post('txtNoind',TRUE),
				'tambahan' => str_replace('.','',$this->input->post('txtTambahan',TRUE)),
				'stat' => $this->input->post('cmbStat',TRUE),
				'desc_' => $this->input->post('txtDesc',TRUE),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Komponen Tambahan pajak ID=".$this->input->post('txtId');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_komptamb->update($this->input->post('txtId', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTamb'));
    }

    public function delete($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_komptamb->get_by_id($id);
        if ($row) {
            $this->M_komptamb->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Komponen Tambahan pajak ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTamb'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTamb'));
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
		// $this->form_validation->set_rules('txtTambahan', 'Tambahan', 'integer');
		// $this->form_validation->set_rules('txtDesc', 'Desc ', 'max_length[30]');
	}

}

/* End of file C_KompTamb.php */
/* Location: ./application/controllers/PayrollManagement/KomponenTambahan/C_KompTamb.php */
/* Generated automatically on 2016-11-28 14:26:31 */
