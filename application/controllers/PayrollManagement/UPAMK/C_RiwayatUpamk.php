<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatUpamk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/UPAMK/M_riwayatupamk');
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
        $riwayatUpamk = $this->M_riwayatupamk->get_all();

        $data['riwayatUpamk_data'] = $riwayatUpamk;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatUpamk/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_riwayatupamk->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_upamk' => $row->id_upamk,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'periode' => $row->periode,
				'noind' => $row->noind,
				'upamk' => $row->upamk,
				'kd_petugas' => $row->kd_petugas,
				'tgl_rec' => $row->tgl_rec,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatUpamk/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatUpamk'));
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
            'action' => site_url('PayrollManagement/RiwayatUpamk/save'),
				'id_upamk' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'periode' => set_value('periode'),
			'noind' => set_value('noind'),
			'upamk' => set_value('upamk'),
			'kd_petugas' => set_value('kd_petugas'),
			'tgl_rec' => set_value('tgl_rec'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatUpamk/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

        
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'periode' => $this->input->post('txtPeriode',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'upamk' => $this->input->post('txtUpamk',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_rec' => $this->input->post('txtTglRec',TRUE),
			);

            $this->M_riwayatupamk->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/RiwayatUpamk'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatupamk->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatUpamk/saveUpdate'),
				'id_upamk' => set_value('txtIdUpamk', $row->id_upamk),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'periode' => set_value('txtPeriode', $row->periode),
				'noind' => set_value('txtNoind', $row->noind),
				'upamk' => set_value('txtUpamk', $row->upamk),
				'kd_petugas' => set_value('txtKdPetugas', $row->kd_petugas),
				'tgl_rec' => set_value('txtTglRec', $row->tgl_rec),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatUpamk/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatUpamk'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'periode' => $this->input->post('txtPeriode',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'upamk' => $this->input->post('txtUpamk',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_rec' => $this->input->post('txtTglRec',TRUE),
			);

            $this->M_riwayatupamk->update($this->input->post('txtIdUpamk', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/RiwayatUpamk'));
        
    }

    public function delete($id)
    {
        $row = $this->M_riwayatupamk->get_by_id($id);

        if ($row) {
            $this->M_riwayatupamk->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/RiwayatUpamk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/RiwayatUpamk'));
        }
    }

    public function import($data = array(), $filename = ''){

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Payroll Management',
            'SubMenuOne' => '',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/RiwayatUpamk/import'),
            'data' => $data,
            'filename' => $filename,
        );

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatUpamk/V_import', $data);
        $this->load->view('V_Footer',$data);
    }

    public function upload() {
       
        $config['upload_path'] = 'assets/upload/importPR';
        $config['file_name'] = 'MasterUPAMK-'.time();
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('importfile')) {
            echo $this->upload->display_errors();
        }
        else {
            $file_data  = $this->upload->data();
            $filename   = $file_data['file_name'];
            $file_path  = 'assets/upload/importPR/'.$file_data['file_name'];
            
            if ($this->csvimport->get_array($file_path)){
                $data = $this->csvimport->get_array($file_path);
                $this->import($data, $filename);
            }
            else {
                $this->import($data = array(), $filename = '');
            }
        }
    }

    public function saveImport(){
        $filename = $this->input->post('txtFileName');
        $file_path  = 'assets/upload/importPR/'.$filename;
        $importData = $this->csvimport->get_array($file_path);

        foreach ($importData as $row) {
            $data = array(
                'tgl_berlaku' => $row['tgl_berlaku'],
                'tgl_tberlaku' => $row['tgl_tberlaku'],
                'periode' => $row['periode'],
                'noind' => $row['noind'],
                'upamk' => $row['upamk'],
                'kd_petugas' => $row['kd_petugas'],
                'tgl_rec' => $row['tgl_rec'],
            );

            $this->M_riwayatupamk->insert($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/RiwayatUpamk'));
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

/* End of file C_RiwayatUpamk.php */
/* Location: ./application/controllers/PayrollManagement/UPAMK/C_RiwayatUpamk.php */
/* Generated automatically on 2016-11-26 10:46:42 */