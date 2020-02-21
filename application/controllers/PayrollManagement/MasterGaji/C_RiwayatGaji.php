<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatGaji extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterGaji/M_riwayatgaji');
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

        $data['Menu'] = 'Master Pekerja';
        $data['SubMenuOne'] = 'Master Gaji';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatGaji = $this->M_riwayatgaji->get_all(date('Y-m-d'));

        $data['riwayatGaji_data'] = $riwayatGaji;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatGaji/V_index', $data);
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

        $row = $this->M_riwayatgaji->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Pekerja',
            	'SubMenuOne' => 'Master Gaji',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_riw_gaji' => $row->id_riw_gaji,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'noind' => $row->noind,
				'kd_hubungan_kerja' => $row->kd_hubungan_kerja,
				'kd_status_kerja' => $row->kd_status_kerja,
				'kd_jabatan' => $row->kd_jabatan,
				'gaji_pokok' => $row->gaji_pokok,
				'i_f' => $row->i_f,
				'kd_petugas' => $row->kd_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatGaji/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Pekerja',
            'SubMenuOne' => 'Master Gaji',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/RiwayatGaji/save'),
				'id_riw_gaji' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'noind' => set_value('noind'),
			'pr_hub_kerja_data' => $this->M_riwayatgaji->get_pr_hub_kerja_data(),
			'kd_hubungan_kerja' => set_value('kd_hubungan_kerja'),
			'pr_master_status_kerja_data' => $this->M_riwayatgaji->get_pr_master_status_kerja_data(),
			'kd_status_kerja' => set_value('kd_status_kerja'),
			'pr_master_jabatan_data' => $this->M_riwayatgaji->get_pr_master_jabatan_data(),
			'kd_jabatan' => set_value('kd_jabatan'),
			'gaji_pokok' => set_value('gaji_pokok'),
			'i_f' => set_value('i_f'),
			'kd_petugas' => set_value('kd_petugas'),
			'tgl_record' => set_value('tgl_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatGaji/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();


            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_hubungan_kerja' => $this->input->post('cmbKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'gaji_pokok' => str_replace(',','',$this->input->post('txtGajiPokok',TRUE)),
				'i_f' => str_replace(',','',$this->input->post('txtIF',TRUE)),
				'kd_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);
			$data_riwayat = array (
				'tgl_tberlaku' => $this->input->post('txtTglBerlaku',TRUE),
			);

            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create Master Gaji noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_riwayatgaji->update_riwayat($this->input->post('txtNoind',TRUE),'9999-12-31',$data_riwayat);
            $this->M_riwayatgaji->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatGaji'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatgaji->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Pekerja',
                'SubMenuOne' => 'Master Gaji',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatGaji/saveUpdate'),
				'id_riw_gaji' => set_value('txtIdRiwGaji', $row->id_riw_gaji),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'noind' => set_value('txtNoind', $row->noind),
				'kd_hubungan_kerja' => set_value('txtKdHubunganKerja', $row->kd_hubungan_kerja),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'kd_jabatan' => set_value('txtKdJabatan', $row->kd_jabatan),
				'gaji_pokok' => set_value('txtGajiPokok', $row->gaji_pokok),
				'i_f' => set_value('txtIF', $row->i_f),
				'kd_petugas' => set_value('txtKdPetugas', $row->kd_petugas),
				'tgl_record' => set_value('txtTglRecord', $row->tgl_record),
                'pr_hub_kerja_data' => $this->M_riwayatgaji->get_pr_hub_kerja_data(),
                'pr_master_status_kerja_data' => $this->M_riwayatgaji->get_pr_master_status_kerja_data(),
                'pr_master_jabatan_data' => $this->M_riwayatgaji->get_pr_master_jabatan_data(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatGaji/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();


            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_hubungan_kerja' => $this->input->post('cmbKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'gaji_pokok' => str_replace(',','',$this->input->post('txtGajiPokok',TRUE)),
				'i_f' => str_replace(',','',$this->input->post('txtIF',TRUE)),
				'kd_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);

            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Master Gaji noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_riwayatgaji->update($this->input->post('txtIdRiwGaji', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatGaji'));

    }

    public function delete($id)
    {
        $row = $this->M_riwayatgaji->get_by_id($id);

        if ($row) {
            $this->M_riwayatgaji->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Master Gaji ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        }
    }

 public function import() {

        $config['upload_path'] = 'assets/upload/importPR/mastergaji/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '6000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/mastergaji/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);
                $data_exist = array();
                $i = 0;
                foreach ($csv_array as $row) {
                    if(array_key_exists('KD_HUB_KER', $row)){

 						//ROW DATA
	                    $data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'kd_hubungan_kerja' => $row['KD_HUBKER'],
							'kd_status_kerja' => $row['KD_STATUS_KER'],
							'kd_jabatan' => $row['KD_JABATAN'],
							'gaji_pokok' => $row['GAJI_POKOK'],
							'i_f' => $row['I_F'],
							'kd_petugas' => $this->session->userdata('userid'),
							'tgl_record' => date('Y-m-d H:i:s'),
	                    );

                    	//CHECK IF EXIST
                    	$noind = $row['NOIND'];
	                   	$check = $this->M_riwayatgaji->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
							$this->M_riwayatgaji->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
							$this->M_riwayatgaji->insert($data);
	                    }else{
	                    	$this->M_riwayatgaji->insert($data);
	                    }

                	}else{
                		//ROW DATA
                		$data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'kd_hubungan_kerja' => $row['KD_HUBKER'],
							'kd_status_kerja' => $row['KD_STATUS_KER'],
							'kd_jabatan' => $row['KD_JABATAN'],
							'gaji_pokok' => $row['GAJI_POKOK'],
							'i_f' => $row['I_F'],
							'kd_petugas' => $this->session->userdata('userid'),
							'tgl_record' => date('Y-m-d H:i:s'),
	                    );

	                    //CHECK IF EXIST
                    	$noind = $row['NOIND'];
	                   	$check = $this->M_riwayatgaji->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
							$this->M_riwayatgaji->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
							$this->M_riwayatgaji->insert($data);
	                    }else{
	                    	$this->M_riwayatgaji->insert($data);
	                    }

                	}
                }

                //LOAD EXIST DATA VERIFICATION PAGE
                $this->checkSession();
        		$user_id = $this->session->userid;

        		$data['Menu'] = 'Master Pekerja';
        		$data['SubMenuOne'] = '';
        		$data['SubMenuTwo'] = '';

		        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		        $data['data_exist'] = $data_exist;
				$this->session->set_flashdata('message', 'Create Record Success');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
				unlink($file_path);
				redirect(site_url('PayrollManagement/RiwayatGaji'));
                } else {
                $this->load->view('csvindex');
            }
        }
    }

    public function upload() {

        $config['upload_path'] = 'assets/upload/importPR';
        $config['file_name'] = 'MasterGaji-'.time();
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
                $this->load->view('csvindex', $data);
            }
        }
    }

    public function saveImport(){
        $filename = $this->input->post('txtFileName');
        $file_path  = 'assets/upload/importPR/'.$filename;
        $importData = $this->csvimport->get_array($file_path);

        foreach ($importData as $row) {
            $data = array(
               'tgl_berlaku' => $row['TGL_BERLAKU'],
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $row['NOIND'],
				'kd_hubungan_kerja' => $row['KD_HUBKER'],
				'kd_status_kerja' => $row['KD_STATUS_KER'],
				'kd_jabatan' => $row['KD_JABATAN'],
				'gaji_pokok' => $row['GAJI_POKOK'],
				'i_f' => $row['I_F'],
				'kd_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
            );
            $this->M_riwayatgaji->insert($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_import" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/RiwayatGaji'));
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

/* End of file C_RiwayatGaji.php */
/* Location: ./application/controllers/PayrollManagement/MasterGaji/C_RiwayatGaji.php */
/* Generated automatically on 2016-11-26 11:55:54 */
