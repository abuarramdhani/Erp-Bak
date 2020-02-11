<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterParamKompJab extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/SetKomponenGajiJabatan/M_masterparamkompjab');
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

        $data['Menu'] = 'Set Parameter';
        $data['SubMenuOne'] = 'Set Komponen Gaji Jabatan';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterParamKompJab = $this->M_masterparamkompjab->get_all();

        $data['masterParamKompJab_data'] = $masterParamKompJab;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamKompJab/V_index', $data);
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

        $row = $this->M_masterparamkompjab->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Set Parameter',
            	'SubMenuOne' => 'Set Komponen Gaji Jabatan',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_komp_jab' => $row->id_komp_jab,
				'kd_status_kerja' => $row->kd_status_kerja,
				'kd_jabatan' => $row->kd_jabatan,
				'ip' => $row->ip,
				'ik' => $row->ik,
				'ims' => $row->ims,
				'imm' => $row->imm,
				'pot_duka' => $row->pot_duka,
				'spsi' => $row->spsi,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamKompJab/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamKompJab'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Set Parameter',
            'SubMenuOne' => 'Set Komponen Gaji Jabatan',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/MasterParamKompJab/save'),
				'id_komp_jab' => set_value(''),
			'pr_master_status_kerja_data' => $this->M_masterparamkompjab->get_pr_master_status_kerja_data(),
			'kd_status_kerja' => set_value('kd_status_kerja'),
			'pr_master_jabatan_data' => $this->M_masterparamkompjab->get_pr_master_jabatan_data(),
			'kd_jabatan' => set_value('kd_jabatan'),
			'ip' => set_value('ip'),
			'ik' => set_value('ik'),
			'ims' => set_value('ims'),
			'imm' => set_value('imm'),
			'pot_duka' => set_value('pot_duka'),
			'spsi' => set_value('spsi'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterParamKompJab/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

		$check = $this->M_masterparamkompjab->get_by_id($this->input->post('txtIdKompJabNew',TRUE));
		if($check){
			$data = array(
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'ip' => str_replace(",","",$this->input->post('txtIp',TRUE)),
				'ik' => str_replace(",","",$this->input->post('txtIk',TRUE)),
				'ims' => str_replace(",","",$this->input->post('txtIms',TRUE)),
				'imm' => str_replace(",","",$this->input->post('txtImm',TRUE)),
				'pot_duka' => str_replace(",","",$this->input->post('txtPotDuka',TRUE)),
				'spsi' => str_replace(",","",$this->input->post('txtSpsi',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update set komponen gaji jabatan ID=".$this->input->post('txtIdKompJabNew');
            $this->log_activity->activity_log($aksi, $detail);
            //
			$this->M_masterparamkompjab->update($this->input->post('txtIdKompJabNew',TRUE),$data);
		}else{
			$data = array(
				'id_komp_jab' => $this->input->post('txtIdKompJabNew',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'ip' => str_replace(",","",$this->input->post('txtIp',TRUE)),
				'ik' => str_replace(",","",$this->input->post('txtIk',TRUE)),
				'ims' => str_replace(",","",$this->input->post('txtIms',TRUE)),
				'imm' => str_replace(",","",$this->input->post('txtImm',TRUE)),
				'pot_duka' => str_replace(",","",$this->input->post('txtPotDuka',TRUE)),
				'spsi' => str_replace(",","",$this->input->post('txtSpsi',TRUE)),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Add set komponen gaji jabatan ID=".$this->input->post('txtIdKompJabNew');
            $this->log_activity->activity_log($aksi, $detail);
            //
			$this->M_masterparamkompjab->insert($data);
		}

		$ru_where = array(
			'tgl_tberlaku' => '9999-12-31',
			'id_komp_jab' => $this->input->post('txtIdKompJabNew',TRUE),
		);

		$ru_data = array(
			'tgl_tberlaku' => $this->input->post('txtPeriodeKompJabatan',TRUE),
		);

		$ri_data = array(
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
			'tgl_berlaku' => $this->input->post('txtPeriodeKompJabatan',TRUE),
			'tgl_tberlaku' => '9999-12-31',
			'id_komp_jab' => $this->input->post('txtIdKompJabNew',TRUE),
			'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
			'ip' => str_replace(",","",$this->input->post('txtIp',TRUE)),
			'ik' => str_replace(",","",$this->input->post('txtIk',TRUE)),
			'ims' => str_replace(",","",$this->input->post('txtIms',TRUE)),
			'imm' => str_replace(",","",$this->input->post('txtImm',TRUE)),
			'pot_duka' => str_replace(",","",$this->input->post('txtPotDuka',TRUE)),
			'spsi' => str_replace(",","",$this->input->post('txtSpsi',TRUE)),
			'kode_petugas' => $this->session->userdata('userid'),
			'tgl_record' => date('Y-m-d H:i:s'),
		);

		$this->M_masterparamkompjab->update_riwayat($ru_where,$ru_data);
		$this->M_masterparamkompjab->insert_riwayat($ri_data);
        $this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
				 "success_insert" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterParamKompJab'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterparamkompjab->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Set Parameter',
                'SubMenuOne' => 'Set Komponen Gaji Jabatan',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterParamKompJab/saveUpdate'),
				'pr_master_status_kerja_data' => $this->M_masterparamkompjab->get_pr_master_status_kerja_data(),
				'pr_master_jabatan_data' => $this->M_masterparamkompjab->get_pr_master_jabatan_data(),

				'id_komp_jab' => set_value('txtIdKompJab', $row->id_komp_jab),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'kd_jabatan' => set_value('txtKdJabatan', $row->kd_jabatan),
				'ip' => set_value('txtIp', $row->ip),
				'ik' => set_value('txtIk', $row->ik),
				'ims' => set_value('txtIms', $row->ims),
				'imm' => set_value('txtImm', $row->imm),
				'pot_duka' => set_value('txtPotDuka', $row->pot_duka),
				'spsi' => set_value('txtSpsi', $row->spsi),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterParamKompJab/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamKompJab'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();
        $data = array(
			'id_komp_jab' => $this->input->post('txtIdKompJabNew',TRUE),
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
			'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
			'ip' => $this->input->post('txtIp',TRUE),
			'ik' => $this->input->post('txtIk',TRUE),
			'ims' => $this->input->post('txtIms',TRUE),
			'imm' => $this->input->post('txtImm',TRUE),
			'pot_duka' => $this->input->post('txtPotDuka',TRUE),
			'spsi' => $this->input->post('txtSpsi',TRUE),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update set komponen gaji jabatan ID=".$this->input->post('txtIdKompJabNew');
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->M_masterparamkompjab->update($this->input->post('txtIdKompJab', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		$ses=array(
				 "success_update" => 1
			);
		$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/MasterParamKompJab'));
    }

    public function delete($id)
    {
        $row = $this->M_masterparamkompjab->get_by_id($id);

        if ($row) {
            $this->M_masterparamkompjab->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete set komponen gaji jabatan ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamKompJab'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterParamKompJab'));
        }
    }

	  public function import() {
        $config['upload_path'] = 'assets/upload/importPR/masterparamkompjab/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterparamkompjab/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
					$check = $this->M_masterparamkompjab->get_by_id($row['ID_KOMP_JAB']);
                    if($check){
                        $data = array(
                            'kd_status_kerja' => $row['KD_STATUS_KERJA'],
                            'kd_jabatan' => $row['KD_JABATAN'],
                            'ip' => $row['IP'],
                            'ik' => $row['IK'],
                            'ims' => $row['IMS'],
                            'imm' => $row['IMM'],
                            'pot_duka' => $row['POT_DUKA'],
                            'spsi' => $row['SPSI'],
                        );
						// echo $row['ID_KOMP_JAB']."update";
                        $this->M_masterparamkompjab->update($row['ID_KOMP_JAB'],$data);
                    }else{
                        $data = array(
                            'id_komp_jab' => $row['ID_KOMP_JAB'],
                            'kd_status_kerja' => $row['KD_STATUS_KERJA'],
                            'kd_jabatan' => $row['KD_JABATAN'],
                            'ip' => $row['IP'],
                            'ik' => $row['IK'],
                            'ims' => $row['IMS'],
                            'imm' => $row['IMM'],
                            'pot_duka' => $row['POT_DUKA'],
                            'spsi' => $row['SPSI'],
                        );
						// echo $row['ID_KOMP_JAB']."insert";
                        $this->M_masterparamkompjab->insert($data);
                    }
                }
				$this->session->set_flashdata('flashSuccess', 'This is a success message.');
				$ses=array(
					 "success_import" => 1
				);

				$this->session->set_userdata($ses);
                unlink($file_path);
                redirect(base_url().'PayrollManagement/MasterParamKompJab');

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

/* End of file C_MasterParamKompJab.php */
/* Location: ./application/controllers/PayrollManagement/SetKomponenGajiJabatan/C_MasterParamKompJab.php */
/* Generated automatically on 2016-11-26 10:33:55 */
