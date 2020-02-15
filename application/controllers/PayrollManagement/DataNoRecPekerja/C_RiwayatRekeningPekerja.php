<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatRekeningPekerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/DataNoRecPekerja/M_riwayatrekeningpekerja');
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
        $data['SubMenuOne'] = 'Master Rekening Pekerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatRekeningPekerja = $this->M_riwayatrekeningpekerja->get_all(date('Y-m-d'));

        $data['riwayatRekeningPekerja_data'] = $riwayatRekeningPekerja;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_index', $data);
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

        $row = $this->M_riwayatrekeningpekerja->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Pekerja',
            	'SubMenuOne' => 'Master Rekening Pekerja',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_riw_rek_pkj' => $row->id_riw_rek_pkj,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'noind' => $row->noind,
				'kd_bank' => $row->kd_bank,
				'no_rekening' => $row->no_rekening,
				'nama_pemilik_rekening' => $row->nama_pemilik_rekening,
				'kode_petugas' => $row->kode_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Pekerja',
            'SubMenuOne' => 'Master Rekening Pekerja',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/RiwayatRekeningPekerja/save'),
				'id_riw_rek_pkj' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'noind' => set_value('noind'),
			'pr_master_bank_data' => $this->M_riwayatrekeningpekerja->get_pr_master_bank_data(),
			'kd_bank' => set_value('kd_bank'),
			'no_rekening' => set_value('no_rekening'),
			'nama_pemilik_rekening' => set_value('nama_pemilik_rekening'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_record' => set_value('tgl_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_bank' => $this->input->post('cmbKdBank',TRUE),
				'no_rekening' => $this->input->post('txtNoRekening',TRUE),
				'nama_pemilik_rekening' => strtoupper($this->input->post('txtNamaPemilikRekening',TRUE)),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);

			$data_update	= array(
				'tgl_tberlaku' => $this->input->post('txtTglBerlaku',TRUE),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create Master Rekening Pekerja noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_riwayatrekeningpekerja->update_riwayat($this->input->post('txtNoind',TRUE),'9999-12-31',$data_update);
            $this->M_riwayatrekeningpekerja->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatrekeningpekerja->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Pekerja',
                'SubMenuOne' => 'Master Rekening Pekerja',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatRekeningPekerja/saveUpdate'),
				'id_riw_rek_pkj' => set_value('txtIdRiwRekPkj', $row->id_riw_rek_pkj),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'noind' => set_value('txtNoind', $row->noind),
				'kd_bank' => set_value('txtKdBank', $row->kd_bank),
				'no_rekening' => set_value('txtNoRekening', $row->no_rekening),
				'nama_pemilik_rekening' => set_value('txtNamaPemilikRekening', $row->nama_pemilik_rekening),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_record' => set_value('txtTglRecord', $row->tgl_record),
                'pr_master_bank_data' => $this->M_riwayatrekeningpekerja->get_pr_master_bank_data(),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatRekeningPekerja/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();


            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_bank' => $this->input->post('cmbKdBank',TRUE),
				'no_rekening' => $this->input->post('txtNoRekening',TRUE),
				'nama_pemilik_rekening' => strtoupper($this->input->post('txtNamaPemilikRekening',TRUE)),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Master Rekening Pekerja ID=".$this->input->post('txtIdRiwRekPkj');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_riwayatrekeningpekerja->update($this->input->post('txtIdRiwRekPkj', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));

    }

    public function delete($id)
    {
        $row = $this->M_riwayatrekeningpekerja->get_by_id($id);

        if ($row) {
            $this->M_riwayatrekeningpekerja->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Master Rekening Pekerja ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
        }
    }

    public function import(){
		$config['upload_path'] = 'assets/upload/importPR/masterrekening/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '6000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterrekening/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);
                $data_exist = array();
                $i = 0;
                foreach ($csv_array as $row) {
					$check = $this->M_riwayatrekeningpekerja->checkExist($row['NOIND']);
					if(empty($check)){
						//ROW DATA
                		$data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'kd_bank' => $row['KD_BANK'],
							'no_rekening' => $row['NO_REK'],
							'nama_pemilik_rekening' => $row['NAMA_REKENING'],
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_record' => date('Y-m-d H:i:s'),
	                    );
						$this->M_riwayatrekeningpekerja->insert($data);
					}else{
						$data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'kd_bank' => $row['KD_BANK'],
							'no_rekening' => $row['NO_REK'],
							'nama_pemilik_rekening' => $row['NAMA_REKENING'],
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_record' => date('Y-m-d H:i:s'),
	                    );
						$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
						$this->M_riwayatrekeningpekerja->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
						$this->M_riwayatrekeningpekerja->insert($data);
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
				$this->session->set_flashdata('message', 'Update Record Success');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
				unlink($file_path);
				redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
            } else {
                $this->load->view('csvindex');
            }
        }
    }

    public function upload() {

        $config['upload_path'] = 'assets/upload/importPR/masterrekening';
        $config['file_name'] = 'RiwayatRekeningPekerja-'.time();
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) {
            echo $this->upload->display_errors();
        }
        else {
            $file_data  = $this->upload->data();
            $filename   = $file_data['file_name'];
            $file_path  = 'assets/upload/importPR/masterrekening/'.$file_data['file_name'];

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
        $file_path  = 'assets/upload/importPR/masterrekening/'.$filename;
        $importData = $this->csvimport->get_array($file_path);

        foreach ($importData as $row) {
           $data = array(
               'tgl_berlaku' => $row['TGL_BERLAKU'],
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $row['NOIND'],
				'kd_bank' => $row['KD_BANK'],
				'no_rekening' => $row['NO_REK'],
				'nama_pemilik_rekening' => $row['NAMA_REKENING'],
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
            );

            $this->M_riwayatrekeningpekerja->insert($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
				 "success_import" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/RiwayatRekeningPekerja'));
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

/* End of file C_RiwayatRekeningPekerja.php */
/* Location: ./application/controllers/PayrollManagement/DataNoRecPekerja/C_RiwayatRekeningPekerja.php */
/* Generated automatically on 2016-11-26 10:45:12 */
