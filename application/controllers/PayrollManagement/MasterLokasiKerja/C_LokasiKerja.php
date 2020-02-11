<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_LokasiKerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterLokasiKerja/M_lokasikerja');
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
        $data['SubMenuOne'] = 'Master Lokasi Kerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $lokasiKerja = $this->M_lokasikerja->get_all();

        $data['lokasiKerja_data'] = $lokasiKerja;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/LokasiKerja/V_index', $data);
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

        $row = $this->M_lokasikerja->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Data',
            	'SubMenuOne' =>'Master Lokasi Kerja',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_lokasi_kerja' => $row->id_lokasi_kerja,
				'lokasi_kerja' => $row->lokasi_kerja,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/LokasiKerja/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/LokasiKerja'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' =>'Master Lokasi Kerja',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/LokasiKerja/save'),
				'id_lokasi_kerja' => set_value(''),
			'lokasi_kerja' => set_value('lokasi_kerja'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/LokasiKerja/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();

		$data = array(
			'id_lokasi_kerja' => strtoupper($this->input->post('txtIdLokasiKerjaNew',TRUE)),
			'lokasi_kerja' => strtoupper($this->input->post('txtLokasiKerja',TRUE)),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Save master lokasi kerja ID=".strtoupper($this->input->post('txtIdLokasiKerjaNew'));
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->M_lokasikerja->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
					 "success_insert" => 1
				);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/LokasiKerja'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_lokasikerja->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' =>'Master Lokasi Kerja',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/LokasiKerja/saveUpdate'),
				'id_lokasi_kerja' => set_value('txtIdLokasiKerja', $row->id_lokasi_kerja),
				'lokasi_kerja' => set_value('txtLokasiKerja', $row->lokasi_kerja),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/LokasiKerja/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/LokasiKerja'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

		$data = array(
			'id_lokasi_kerja' => strtoupper($this->input->post('txtIdLokasiKerjaNew',TRUE)),
			'lokasi_kerja' => strtoupper($this->input->post('txtLokasiKerja',TRUE)),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update master lokasi kerja ID=".strtoupper($this->input->post('txtIdLokasiKerja'));
        $this->log_activity->activity_log($aksi, $detail);
        //

		$this->M_lokasikerja->update(strtoupper($this->input->post('txtIdLokasiKerja', TRUE)), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
				 "success_update" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/LokasiKerja'));

    }

    public function delete($id)
    {
        $row = $this->M_lokasikerja->get_by_id($id);

        if ($row) {
            $this->M_lokasikerja->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master lokasi kerja ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/LokasiKerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/LokasiKerja'));
        }
    }

	  public function import() {
        $config['upload_path'] = 'assets/upload/importPR/lokasikerja/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/lokasikerja/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
					$check = $this->M_lokasikerja->get_by_id($row['ID_']);
                    if($check){
                        $data = array(
                            'lokasi_kerja'      => $row['LOKASI_KERJA'],
                        );
                        $this->M_lokasikerja->update($row['ID_'],$data);
                    }else{
                        $data = array(
                            'id_lokasi_kerja'   => strtoupper($row['ID_']),
                            'lokasi_kerja'      => strtoupper($row['LOKASI_KERJA']),
                        );
                        $this->M_lokasikerja->insert($data);
                    }
                }
				$this->session->set_flashdata('message', 'Record Not Found');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
                unlink($file_path);
                redirect(base_url().'PayrollManagement/LokasiKerja');

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

/* End of file C_LokasiKerja.php */
/* Location: ./application/controllers/PayrollManagement/MasterLokasiKerja/C_LokasiKerja.php */
/* Generated automatically on 2016-11-24 09:53:38 */
