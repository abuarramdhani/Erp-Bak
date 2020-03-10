<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_KantorAsal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterKantorAsal/M_kantorasal');
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
        $data['SubMenuOne'] = 'Master Kantor Asal';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $kantorAsal = $this->M_kantorasal->get_all();

        $data['kantorAsal_data'] = $kantorAsal;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KantorAsal/V_index', $data);
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

        $row = $this->M_kantorasal->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Data',
            	'SubMenuOne' => 'Master Kantor Asal',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_kantor_asal' => $row->id_kantor_asal,
				'kantor_asal' => $row->kantor_asal,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KantorAsal/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KantorAsal'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Data',
            'SubMenuOne' => 'Master Kantor Asal',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/KantorAsal/save'),
				'id_kantor_asal' => set_value(''),
			'kantor_asal' => set_value('kantor_asal'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KantorAsal/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();

		$data = array(
			'id_kantor_asal' => strtoupper($this->input->post('txtIdKantorAsalNew',TRUE)),
			'kantor_asal' => strtoupper($this->input->post('txtKantorAsal',TRUE)),
		);

        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Add Master kantor asal ID=".strtoupper($this->input->post('txtIdKantorAsalNew',TRUE))." kantorasal=".strtoupper($this->input->post('txtKantorAsal',TRUE));
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->M_kantorasal->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
					 "success_insert" => 1
				);
		$this->session->set_userdata($ses);
		redirect(site_url('PayrollManagement/KantorAsal'));
	}

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_kantorasal->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Data',
                'SubMenuOne' => 'Master Kantor Asal',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/KantorAsal/saveUpdate'),
				'id_kantor_asal' => set_value('txtIdKantorAsal', $row->id_kantor_asal),
				'kantor_asal' => set_value('txtKantorAsal', $row->kantor_asal),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KantorAsal/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KantorAsal'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();

		$data = array(
			'id_kantor_asal' => strtoupper($this->input->post('txtIdKantorAsalNew',TRUE)),
			'kantor_asal' => strtoupper($this->input->post('txtKantorAsal',TRUE)),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "update master kantor asal ID=".strtoupper($this->input->post('txtIdKantorAsal'));
        $this->log_activity->activity_log($aksi, $detail);
        //

        $this->M_kantorasal->update(strtoupper($this->input->post('txtIdKantorAsal', TRUE)), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
					 "success_update" => 1
				);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/KantorAsal'));
    }

    public function delete($id)
    {
        $row = $this->M_kantorasal->get_by_id($id);

        if ($row) {
            $this->M_kantorasal->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete master kantor asal ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KantorAsal'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KantorAsal'));
        }
    }

	    public function import() {
        $config['upload_path'] = 'assets/upload/importPR/kantorasal/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/kantorasal/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
					$check = $this->M_kantorasal->get_by_id($row['ID_']);
                    if($check){
                        $data = array(
                            'kantor_asal'      => $row['LOKASI_KERJA'],
                        );
                        $this->M_kantorasal->update($row['ID_'],$data);
                    }else{
                        $data = array(
                            'id_kantor_asal'   => strtoupper($row['ID_']),
                            'kantor_asal'      => strtoupper($row['LOKASI_KERJA']),
                        );
                        $this->M_kantorasal->insert($data);
                    }
                }
				$this->session->set_flashdata('message', 'Record Not Found');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
                unlink($file_path);
                redirect(base_url().'PayrollManagement/KantorAsal');

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

/* End of file C_KantorAsal.php */
/* Location: ./application/controllers/PayrollManagement/MasterKantorAsal/C_KantorAsal.php */
/* Generated automatically on 2016-11-24 09:50:39 */
