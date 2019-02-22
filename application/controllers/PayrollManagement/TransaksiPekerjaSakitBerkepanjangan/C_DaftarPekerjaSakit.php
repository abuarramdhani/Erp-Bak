<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DaftarPekerjaSakit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiPekerjaSakitBerkepanjangan/M_daftarpekerjasakit');
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
        $data['SubMenuOne'] = 'Pekerja Sakit Berkepanjangan';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $daftarPekerjaSakit = $this->M_daftarpekerjasakit->get_all();

        $data['daftarPekerjaSakit_data'] = $daftarPekerjaSakit;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/DaftarPekerjaSakit/V_index', $data);
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
        
        $row = $this->M_daftarpekerjasakit->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Komponen Penggajian',
            	'SubMenuOne' => 'Pekerja Sakit Berkepanjangan',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_setting' => $row->id_setting,
				'tanggal' => $row->tanggal,
				'noind' => $row->noind,
				'bulan_sakit' => $row->bulan_sakit,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/DaftarPekerjaSakit/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/DaftarPekerjaSakit'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Komponen Penggajian',
            'SubMenuOne' => 'Pekerja Sakit Berkepanjangan',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/DaftarPekerjaSakit/save'),
				'id_setting' => set_value(''),
			'tanggal' => set_value('tanggal'),
			'noind' => set_value('noind'),
			'bulan_sakit' => set_value('bulan_sakit'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/DaftarPekerjaSakit/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();
		$dt = explode("/",$this->input->post('txtTglTransaksi',TRUE));
		$varTgl = $dt[2]."-".$dt[1]."-".$dt[0];
		$varBln	= ($this->input->post('txtBulanSakit',TRUE) - 1); 
		$tgl_tberlaku = date("Y-m-d", strtotime("+".$varBln." month",strtotime($varTgl)));
            $data = array(
				'id_setting' => str_replace(" ","",$this->input->post('txtNoind',TRUE).date('Ymd')),
				'tanggal' => $varTgl,
				'noind' => $this->input->post('txtNoind',TRUE),
				'bulan_sakit' => $this->input->post('txtBulanSakit',TRUE),
				'tgl_tberlaku' => $tgl_tberlaku,
			);

            $this->M_daftarpekerjasakit->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/DaftarPekerjaSakit'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_daftarpekerjasakit->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Komponen Penggajian',
                'SubMenuOne' => 'Pekerja Sakit Berkepanjangan',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/DaftarPekerjaSakit/saveUpdate'),
				'id_setting' => set_value('txtIdSetting', $row->id_setting),
				'tanggal' => set_value('txtTglTransaksi', date("d/m/Y",strtotime($row->tanggal))),
				'noind' => set_value('txtNoind', $row->noind),
				'bulan_sakit' => set_value('txtBulanSakit', $row->bulan_sakit),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/DaftarPekerjaSakit/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/DaftarPekerjaSakit'));
        }
    }

    public function saveUpdate()
    {
        // $this->formValidation();

        // if ($this->form_validation->run() == FALSE) {
            // $this->update();
        // }
        // else{
			$dt = explode("/",$this->input->post('txtTglTransaksi',TRUE));
			$varTgl = $dt[2]."-".$dt[1]."-".$dt[0];
			$varBln	= $this->input->post('txtBulanSakit',TRUE);
			$tgl_tberlaku = date("Y-m-d", strtotime("+".$varBln." month",strtotime($varTgl)));
            $data = array(
				'tanggal' => $varTgl,
				'noind' => $this->input->post('txtNoind',TRUE),
				'bulan_sakit' => $this->input->post('txtBulanSakit',TRUE),
				'tgl_tberlaku' => $tgl_tberlaku,
			);

            $this->M_daftarpekerjasakit->update($this->input->post('txtIdSetting', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/DaftarPekerjaSakit'));
        // }
    }

    public function delete($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_daftarpekerjasakit->get_by_id($id);

        if ($row) {
            $this->M_daftarpekerjasakit->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/DaftarPekerjaSakit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/DaftarPekerjaSakit'));
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

/* End of file C_DaftarPekerjaSakit.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiPekerjaSakitBerkepanjangan/C_DaftarPekerjaSakit.php */
/* Generated automatically on 2016-11-29 10:08:11 */