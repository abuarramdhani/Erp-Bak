<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiKlaimSisaCuti extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiKlaimSisaCuti/M_transaksiklaimsisacuti');
        $this->load->library('csvimport');
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
        $data['SubMenuOne'] = 'Klaim Sisa Cuti';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $transaksiKlaimSisaCuti = $this->M_transaksiklaimsisacuti->get_all();

        $data['transaksiKlaimSisaCuti_data'] = $transaksiKlaimSisaCuti;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_index', $data);
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

        $row = $this->M_transaksiklaimsisacuti->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Komponen Penggajian',
            	'SubMenuOne' => 'Klaim Sisa Cuti',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_cuti' => $row->id_cuti,
				'noind' => $row->noind,
				'periode' => $row->periode,
				'sisa_cuti' => $row->sisa_cuti,
				'jumlah_klaim' => $row->jumlah_klaim,
				'kode_petugas' => $row->kode_petugas,
				'tgl_jam_record' => $row->tgl_jam_record,
				'kd_jns_transaksi' => $row->kd_jns_transaksi,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Komponen Penggajian',
            'SubMenuOne' => 'Klaim Sisa Cuti',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/TransaksiKlaimSisaCuti/save'),
				'id_cuti' => set_value(''),
			'noind' => set_value('noind'),
			'periode' => set_value('periode'),
			'sisa_cuti' => set_value('sisa_cuti'),
			'jumlah_klaim' => set_value('jumlah_klaim'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_jam_record' => set_value('tgl_jam_record'),
			'pr_jns_transaksi_data' => $this->M_transaksiklaimsisacuti->get_pr_jns_transaksi_data(),
			'kd_jns_transaksi' => set_value('kd_jns_transaksi'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
        $data = array(
			'noind' => $this->input->post('txtNoind',TRUE),
			'periode' => $this->input->post('txtPeriode',TRUE),
			'sisa_cuti' => $this->input->post('txtSisaCuti',TRUE),
			'jumlah_klaim' => $this->input->post('txtJumlahKlaim',TRUE),
			'kode_petugas' => $this->session->userdata('userid'),
			'tgl_jam_record' => date('Y-m-d H:i:s'),
			'kd_jns_transaksi' => $this->input->post('cmbKdJnsTransaksi',TRUE),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create Komponen Transaksi Sisa Cuti noind=".$this->input->post('txtNoind');
        $this->log_activity->activity_log($aksi, $detail);
        //
            $this->M_transaksiklaimsisacuti->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
    }

    public function update($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_transaksiklaimsisacuti->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Komponen Penggajian',
                'SubMenuOne' => 'Klaim Sisa Cuti',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/TransaksiKlaimSisaCuti/saveUpdate'),
				'pr_jns_transaksi_data' => $this->M_transaksiklaimsisacuti->get_pr_jns_transaksi_data(),
				'id_cuti' => set_value('cmbIdCuti', $row->id_cuti),
				'noind' => set_value('cmbNoind', $row->noind),
				'periode' => set_value('cmbPeriode', $row->periode),
				'sisa_cuti' => set_value('cmbSisaCuti', $row->sisa_cuti),
				'jumlah_klaim' => set_value('cmbJumlahKlaim', $row->jumlah_klaim),
				'kode_petugas' => set_value('cmbKodePetugas', $row->kode_petugas),
				'tgl_jam_record' => set_value('cmbTglJamRecord', $row->tgl_jam_record),
				'kd_jns_transaksi' => set_value('cmbKdJnsTransaksi', $row->kd_jns_transaksi),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiKlaimSisaCuti/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();
            $data = array(
				'noind' => $this->input->post('txtNoind',TRUE),
				'periode' => $this->input->post('txtPeriode',TRUE),
				'sisa_cuti' => $this->input->post('txtSisaCuti',TRUE),
				'jumlah_klaim' => $this->input->post('txtJumlahKlaim',TRUE),
				'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
				'kd_jns_transaksi' => $this->input->post('cmbKdJnsTransaksi',TRUE),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Komponen Transaksi Sisa Cuti ID=".$this->input->post('txtIdCuti');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_transaksiklaimsisacuti->update($this->input->post('txtIdCuti', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
    }

    public function delete($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_transaksiklaimsisacuti->get_by_id($id);

        if ($row) {
            $this->M_transaksiklaimsisacuti->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Komponen Transaksi Sisa Cuti ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiKlaimSisaCuti'));
        }
    }

    public function import() {

        $config['upload_path'] = 'assets/upload/importPR/klaimsisacuti/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/klaimsisacuti/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
					$check = $this->M_transaksiklaimsisacuti->check($row['NOIND'],$row['PERIODE']);
					if($check){
						$data_where = array(
							'noind' => $row['NOIND'],
							'tgl_tberlaku' => '9999-12-31',
						);

						$getGp = $this->M_transaksiklaimsisacuti->getGajiPokok($data_where);
						if(empty($getGp)){
							$sisaKlaim = '-';
						}else{
							$sisaKlaim = round($row['SISA_CUTI'] * ($getGp/30),0);
						}

						$data_update = array(
							'sisa_cuti' => $row['SISA_CUTI'],
							'jumlah_klaim' => $sisaKlaim,
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_jam_record' => date('Y-m-d H:i:s'),
							'kd_jns_transaksi' => '6',
						);
						$this->M_transaksiklaimsisacuti->update_import($row['NOIND'],$row['PERIODE'],$data_update);
					}else{
						$data_where = array(
							'noind' => $row['NOIND'],
							'tgl_tberlaku' => '9999-12-31',
						);

						$getGp = $this->M_transaksiklaimsisacuti->getGajiPokok($data_where);
						if(empty($getGp)){
							$sisaKlaim = '-';
						}else{
							$sisaKlaim = round($row['SISA_CUTI'] * ($getGp/30),0);
						}

						$data = array(
							'noind' => $row['NOIND'],
							'periode' => $row['PERIODE'],
							'sisa_cuti' => $row['SISA_CUTI'],
							'jumlah_klaim' => $sisaKlaim,
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_jam_record' => date('Y-m-d H:i:s'),
							'kd_jns_transaksi' => '6',
						);
						$this->M_transaksiklaimsisacuti->insert($data);
					}
                }
				$this->session->set_flashdata('message', 'Success Import Data');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
                unlink($file_path);
                redirect(base_url().'PayrollManagement/TransaksiKlaimSisaCuti');

            } else {
                $this->load->view('csvindex');
            }
        }
    }

	public function getKlaimCuti(){
        $data_where = array(
            'noind' => $this->input->post('noind',TRUE),
            'tgl_tberlaku' => '9999-12-31',
        );

        $getGp = $this->M_transaksiklaimsisacuti->getGajiPokok($data_where);
		if(empty($getGp)){
			$sisaKlaim = '-';
		}else{
			$sisaKlaim = round($this->input->post('cuti',TRUE) * ($getGp->gaji_pokok/30),0);
		}

        echo $sisaKlaim;
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

/* End of file C_TransaksiKlaimSisaCuti.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti.php */
/* Generated automatically on 2016-11-28 14:06:59 */
