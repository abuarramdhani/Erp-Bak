<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterSeksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterSeksi/M_masterseksi');
        $this->load->library('csvimport');
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

        $data['Menu'] = 'Master Data';
        $data['SubMenuOne'] = 'Master Seksi';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterSeksi = $this->M_masterseksi->get_all();

        $data['masterSeksi_data'] = $masterSeksi;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterSeksi/V_index', $data);
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

        $row = $this->M_masterseksi->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Data',
            	'SubMenuOne' => 'Master Seksi',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'kodesie' => $row->kodesie,
				'dept' => $row->dept,
				'bidang' => $row->bidang,
				'unit' => $row->unit,
				'seksi' => $row->seksi,
				'pekerjaan' => $row->pekerjaan,
				'golkerja' => $row->golkerja,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterSeksi/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterSeksi'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Seksi',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterSeksi/save'),
				'kodesie' => set_value(''),
			'dept' => set_value('dept'),
			'bidang' => set_value('bidang'),
			'unit' => set_value('unit'),
			'seksi' => set_value('seksi'),
			'pekerjaan' => set_value('pekerjaan'),
			'golkerja' => set_value('golkerja'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterSeksi/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
		$data = array(
			'kodesie' => strtoupper($this->input->post('txtKodesieNew',TRUE)),
			'dept' => strtoupper($this->input->post('cmbDept',TRUE)),
			'bidang' => strtoupper($this->input->post('txtBidang',TRUE)),
			'unit' => strtoupper($this->input->post('txtUnit',TRUE)),
			'seksi' => strtoupper($this->input->post('txtSeksi',TRUE)),
			'pekerjaan' => strtoupper($this->input->post('txtPekerjaan',TRUE)),
			'golkerja' => strtoupper($this->input->post('txtGolkerja',TRUE)),
		);

            $this->M_masterseksi->insert($data);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Add Master Seksi kd_sie=".strtoupper($this->input->post('txtKodesieNew',TRUE));
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSeksi'));
    }

    public function update($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterseksi->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Seksi',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterSeksi/saveUpdate'),
				'kodesie' => set_value('txtKodesie', $row->kodesie),
				'dept' => set_value('txtDept', $row->dept),
				'bidang' => set_value('txtBidang', $row->bidang),
				'unit' => set_value('txtUnit', $row->unit),
				'seksi' => set_value('txtSeksi', $row->seksi),
				'pekerjaan' => set_value('txtPekerjaan', $row->pekerjaan),
				'golkerja' => set_value('txtGolkerja', $row->golkerja),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterSeksi/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSeksi'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();
        $data = array(
			'kodesie' => strtoupper($this->input->post('txtKodesieNew',TRUE)),
			'dept' => strtoupper($this->input->post('cmbDept',TRUE)),
			'bidang' => strtoupper($this->input->post('txtBidang',TRUE)),
			'unit' => strtoupper($this->input->post('txtUnit',TRUE)),
			'seksi' => strtoupper($this->input->post('txtSeksi',TRUE)),
			'pekerjaan' => strtoupper($this->input->post('txtPekerjaan',TRUE)),
			'golkerja' => strtoupper($this->input->post('txtGolkerja',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Master Seksi kd_sie=".strtoupper($this->input->post('txtKodesie',TRUE))." menjadi=".strtoupper($this->input->post('txtKodesieNew', TRUE));
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_masterseksi->update(strtoupper($this->input->post('txtKodesie', TRUE)), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSeksi'));
    }

    public function delete($id)
    {
        $row = $this->M_masterseksi->get_by_id($id);

        if ($row) {
            $this->M_masterseksi->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master Seksi ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSeksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterSeksi'));
        }
    }

    public function import() {
        $config['upload_path'] = 'assets/upload/importPR/masterseksi/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterseksi/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
					$check = $this->M_masterseksi->get_by_id($row['KODESIE']);
                    if($check){
                        $data = array(
                            'dept'      => $row['DEPT'],
                            'bidang'    => $row['BIDANG'],
                            'unit'      => $row['UNIT'],
                            'seksi'     => $row['SEKSI'],
                            'pekerjaan' => $row['PEKERJAAN'],
                            'golkerja'  => $row['GOLKERJA'],
                        );
                        $this->M_masterseksi->update($row['KODESIE'],$data);
                    }else{
                        $data = array(
                            'kodesie'   => strtoupper($row['kodesie']),
                            'dept'      => strtoupper($row['dept']),
                            'bidang'    => strtoupper($row['bidang']),
                            'unit'      => strtoupper($row['unit']),
                            'seksi'     => strtoupper($row['seksi']),
                            'pekerjaan' => strtoupper($row['pekerjaan']),
                            'golkerja'  => strtoupper($row['golkerja']),
                        );
                        $this->M_masterseksi->insert($data);
                    }
                }
				$this->session->set_flashdata('message', 'Record Not Found');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
                unlink($file_path);
                redirect(base_url().'PayrollManagement/MasterSeksi');

            } else {
                $this->load->view('csvindex');
            }
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

/* End of file C_MasterSeksi.php */
/* Location: ./application/controllers/PayrollManagement/MasterSeksi/C_MasterSeksi.php */
/* Generated automatically on 2016-11-24 09:48:55 */
