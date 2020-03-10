<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatPotDanaPensiun extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->library('csvimport');
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

        $data['Menu'] = 'Master Pekerja';
        $data['SubMenuOne'] = 'Iuran Pensiun';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatPotDanaPensiun = $this->M_riwayatpotdanapensiun->get_all(date('Y-m-d'));

        $data['riwayatPotDanaPensiun_data'] = $riwayatPotDanaPensiun;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatPotDanaPensiun/V_index', $data);
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

        $row = $this->M_riwayatpotdanapensiun->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Pekerja',
            	'SubMenuOne' => 'Iuran Pensiun',
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
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Pekerja',
            'SubMenuOne' => 'Iuran Pensiun',
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
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'pot_pensiun' => str_replace(',','',$this->input->post('txtPotPensiun',TRUE)),
				'kd_petugas' => $this->session->userdata('userid'),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
			);
			$data_riwayat = array(
				'tgl_tberlaku'	=> $this->input->post('txtTglBerlaku',TRUE),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create Master Iuran Pensiun noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //
			$this->M_riwayatpotdanapensiun->update_riwayat($this->input->post('txtNoind',TRUE),'9999-12-31',$data_riwayat);
            $this->M_riwayatpotdanapensiun->insert($data);

			$check = $this->M_riwayatpotdanapensiun->check_master($this->input->post('txtNoind',TRUE));
			if($check){
				$data_update_master = array(
					'pot_pensiun' => str_replace(',','',$this->input->post('txtPotPensiun',TRUE)),
				);
				$this->M_riwayatpotdanapensiun->update_master($this->input->post('txtNoind',TRUE),$data_update_master);
			}else{
				$data_insert_master = array(
					'noind' => $this->input->post('txtNoind',TRUE),
					'pot_pensiun' => str_replace(',','',$this->input->post('txtPotPensiun',TRUE)),
				);
				$this->M_riwayatpotdanapensiun->insert_master($data_insert_master);
			}
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatpotdanapensiun->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Pekerja',
                'SubMenuOne' => 'Iuran Pensiun',
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
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();


            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'pot_pensiun' => str_replace(',','',$this->input->post('txtPotPensiun',TRUE)),
				'kd_petugas' => $this->session->userdata('userid'),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
			);

            $this->M_riwayatpotdanapensiun->update($this->input->post('txtIdRiwPens', TRUE), $data);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Master Iuran Pensiun ID=".$this->input->post('txtIdRiwPens');
            $this->log_activity->activity_log($aksi, $detail);
            //
			$data_update_master = array(
				'pot_pensiun' => str_replace(',','',$this->input->post('txtPotPensiun',TRUE)),
			);
			$this->M_riwayatpotdanapensiun->update_master($this->input->post('txtNoind',TRUE),$data_update_master);

            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));

    }

    public function delete($id)
    {
        $row = $this->M_riwayatpotdanapensiun->get_by_id($id);

        if ($row) {
            $this->M_riwayatpotdanapensiun->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Master Iuran Pensiun ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
        }
    }

    public function import(){
		$config['upload_path'] = 'assets/upload/importPR/iuranpensiun/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '6000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/iuranpensiun/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);
                $data_exist = array();
                $i = 0;
                foreach ($csv_array as $row) {
					$check = $this->M_riwayatpotdanapensiun->checkExist($row['NOIND']);
					if(empty($check)){
						//ROW DATA
                		$data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'pot_pensiun' => $row['POT_PENSIUN'],
							'kd_petugas' => $this->session->userdata('userid'),
							'tgl_jam_record' => date('Y-m-d H:i:s'),
	                    );

	                    //CHECK IF EXIST
                    	$noind = $row['NOIND'];
	                   	$check = $this->M_riwayatpotdanapensiun->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
							$this->M_riwayatpotdanapensiun->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
							$this->M_riwayatpotdanapensiun->insert($data);
	                    }else{
	                    	$this->M_riwayatpotdanapensiun->insert($data);
	                    }
					}else{
						//ROW DATA
	                    $data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'pot_pensiun' => $row['POT_PENSIUN'],
							'kd_petugas' => $this->session->userdata('userid'),
							'tgl_jam_record' => date('Y-m-d H:i:s'),
	                    );

                    	//CHECK IF EXIST
                    	$noind = $row['NOIND'];
	                   	$check = $this->M_riwayatpotdanapensiun->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
							$this->M_riwayatpotdanapensiun->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
							$this->M_riwayatpotdanapensiun->insert($data);
	                    }else{
	                    	$this->M_riwayatpotdanapensiun->insert($data);
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
				redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
            } else {
                $this->load->view('csvindex');
            }
        }
    }

    public function upload() {

        $config['upload_path'] = 'assets/upload/importPR/iuranpensiun';
        $config['file_name'] = 'IuranPensiun-'.time();
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) {
            echo $this->upload->display_errors();
        }
        else {
            $file_data  = $this->upload->data();
            $filename   = $file_data['file_name'];
            $file_path  = 'assets/upload/importPR/iuranpensiun/'.$file_data['file_name'];

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
        $file_path  = 'assets/upload/importPR/iuranpensiun/'.$filename;
        $importData = $this->csvimport->get_array($file_path);

        foreach ($importData as $row) {
           $data = array(
               	'tgl_berlaku' => $row['TGL_BERLAKU'],
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $row['NOIND'],
				'pot_pensiun' => $row['POT_PENSIUN'],
				'kd_petugas' => $this->session->userdata('userid'),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
            );

            $this->M_riwayatpotdanapensiun->insert($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_import" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/RiwayatPotDanaPensiun'));
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
