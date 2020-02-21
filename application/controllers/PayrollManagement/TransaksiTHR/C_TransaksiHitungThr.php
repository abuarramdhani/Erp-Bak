<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiHitungThr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiTHR/M_transaksihitungthr');
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

        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'THR';
        $data['SubMenuTwo'] = '';

		$enc_dt	= $this->input->get('id');

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['action2'] = site_url('PayrollManagement/TransaksiHitungThr/search');
        $data['action'] = site_url('PayrollManagement/TransaksiHitungThr/hitung');
		if(!empty($enc_dt)){
			$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_dt);
			$dt = $this->encrypt->decode($plaintext_string);
			$data['transaksiHitungThr_data'] = $this->M_transaksihitungthr->get_all($dt);
			$data['dt'] = $dt;
			$data['enc_dt'] = $enc_dt;
		}

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHitungThr/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata("failed_import");
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

        $row = $this->M_transaksihitungthr->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Komponen Penggajian',
            	'SubMenuOne' => 'THR',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_transaksi_thr' => $row->id_transaksi_thr,
				'tanggal' => $row->tanggal,
				'periode' => $row->periode,
				'noind' => $row->noind,
				'kd_status_kerja' => $row->kd_status_kerja,
				'diangkat' => $row->diangkat,
				'lama_thn' => $row->lama_thn,
				'lama_bln' => $row->lama_bln,
				'gaji_pokok' => $row->gaji_pokok,
				'thr' => $row->thr,
				'persentase_ubthr' => $row->persentase_ubthr,
				'ubthr' => $row->ubthr,
				'kode_petugas' => $row->kode_petugas,
				'tgl_jam_record' => $row->tgl_jam_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiHitungThr/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Komponen Penggajian',
            'SubMenuOne' => 'THR',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
			'pr_master_status_kerja_data' => $this->M_transaksihitungthr->get_pr_master_status_kerja_data(),
            'action' => site_url('PayrollManagement/TransaksiHitungThr/save'),

			'id_transaksi_thr' 	=> set_value(''),
			'tanggal' 			=> set_value('tanggal'),
			'periode' 			=> set_value('periode'),
			'noind' 			=> set_value('noind'),
			'kd_status_kerja' 	=> set_value('kd_status_kerja'),
			'diangkat' 			=> set_value('diangkat'),
			'lama_thn' 			=> set_value('lama_thn'),
			'lama_bln' 			=> set_value('lama_bln'),
			'gaji_pokok' 		=> set_value('gaji_pokok'),
			'thr' 				=> set_value('thr'),
			'persentase_ubthr' 	=> set_value('persentase_ubthr'),
			'ubthr' 			=> set_value('ubthr'),
			'kode_petugas' 		=> set_value('kode_petugas'),
			'tgl_jam_record' 	=> set_value('tgl_jam_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHitungThr/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

		$data = array(
			'tanggal' => $this->input->post('txtTanggal',TRUE),
			'periode' => $this->input->post('txtPeriode',TRUE),
			'noind' => $this->input->post('txtNoind',TRUE),
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
			'diangkat' => $this->input->post('txtDiangkat',TRUE),
			'lama_thn' => $this->input->post('txtLamaThn',TRUE),
			'lama_bln' => $this->input->post('txtLamaBln',TRUE),
			'gaji_pokok' => $this->input->post('txtGajiPokok',TRUE),
			'thr' => $this->input->post('txtThr',TRUE),
			'persentase_ubthr' => $this->input->post('txtPersentaseUbthr',TRUE),
			'ubthr' => $this->input->post('txtUbthr',TRUE),
			'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
			'tgl_jam_record' => date('Y-m-d H:i:s'),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create Komponen Transaksi THR noind=".$this->input->post('txtNoind');
        $this->log_activity->activity_log($aksi, $detail);
        //
            $this->M_transaksihitungthr->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_transaksihitungthr->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Komponen Penggajian',
                'SubMenuOne' => 'THR',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/TransaksiHitungThr/saveUpdate'),
				'pr_master_status_kerja_data' => $this->M_transaksihitungthr->get_pr_master_status_kerja_data(),
				'id_transaksi_thr' => set_value('txtIdTransaksiThr', $row->id_transaksi_thr),
				'tanggal' => set_value('txtTanggal', $row->tanggal),
				'periode' => set_value('txtPeriode', $row->periode),
				'noind' => set_value('txtNoind', $row->noind),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'diangkat' => set_value('txtDiangkat', $row->diangkat),
				'lama_thn' => set_value('txtLamaThn', $row->lama_thn),
				'lama_bln' => set_value('txtLamaBln', $row->lama_bln),
				'gaji_pokok' => set_value('txtGajiPokok', $row->gaji_pokok),
				'thr' => set_value('txtThr', $row->thr),
				'persentase_ubthr' => set_value('txtPersentaseUbthr', $row->persentase_ubthr),
				'ubthr' => set_value('txtUbthr', $row->ubthr),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_jam_record' => set_value('txtTglJamRecord', $row->tgl_jam_record),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiHitungThr/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        $data = array(
			'tanggal' => $this->input->post('txtTanggal',TRUE),
			'periode' => $this->input->post('txtPeriode',TRUE),
			'noind' => $this->input->post('txtNoind',TRUE),
			'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
			'diangkat' => $this->input->post('txtDiangkat',TRUE),
			'lama_thn' => $this->input->post('txtLamaThn',TRUE),
			'lama_bln' => $this->input->post('txtLamaBln',TRUE),
			'gaji_pokok' => $this->input->post('txtGajiPokok',TRUE),
			'thr' => $this->input->post('txtThr',TRUE),
			'persentase_ubthr' => $this->input->post('txtPersentaseUbthr',TRUE),
			'ubthr' => $this->input->post('txtUbthr',TRUE),
			'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
			'tgl_jam_record' => date('Y-m-d H:i:s'),
		);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Update Komponen Transaksi THR ID=".$this->input->post('txtIdTransaksiThr');
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->M_transaksihitungthr->update($this->input->post('txtIdTransaksiThr', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/TransaksiHitungThr'));
    }

    public function delete($id)
    {
        $row = $this->M_transaksihitungthr->get_by_id($id);

        if ($row) {
            $this->M_transaksihitungthr->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Komponen Transaksi THR ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
        }
    }

    public function import(){
		$config['upload_path'] = 'assets/upload/importPR/transaksithr/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '6000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/transaksithr/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);
                $data_exist = array();
                $i = 0;
                foreach ($csv_array as $row) {
						$dt = explode("/",$row['PERIODE']);
						$periode = str_replace(" ","",$dt[1]."-".$dt[0]);
	                    $data = array(
	                    	'id_data_thr' => $row['ID_THR'],
							'periode' => $periode,
							'noind' => $row['NOIND'],
							'kd_status_kerja' => $row['KD_STATUS'],
							'diangkat' => date("Y-m-d",strtotime($row['DIANGKAT'])),
							'lama_thn' => $row['LM_THN'],
							'lama_bln' => $row['LM_BLN'],
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_jam_record' => date('Y-m-d H:i:s'),
	                    );

						$data_transaksi = array(
	                    	'id_transaksi_thr' => $row['ID_THR'],
							'periode' => $periode,
							'noind' => $row['NOIND'],
							'kd_status_kerja' => $row['KD_STATUS'],
							'diangkat' => date("Y-m-d",strtotime($row['DIANGKAT'])),
							'lama_thn' => $row['LM_THN'],
							'lama_bln' => $row['LM_BLN'],
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_jam_record' => date('Y-m-d H:i:s'),
	                    );

	                   	$check = $this->M_transaksihitungthr->check($row['ID_THR']);
	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'periode' => $periode,
								'noind' => $row['NOIND'],
								'kd_status_kerja' => $row['KD_STATUS'],
								'diangkat' => date("Y-m-d",strtotime($row['DIANGKAT'])),
								'lama_thn' => $row['LM_THN'],
								'lama_bln' => $row['LM_BLN'],
								'kode_petugas' => $this->session->userdata('userid'),
								'tgl_jam_record' => date('Y-m-d H:i:s'),
							);
							$this->M_transaksihitungthr->update_data($row['ID_THR'],$data_update);
	                    }else{
	                    	$this->M_transaksihitungthr->insert_data($data);
	                    }

						$check = $this->M_transaksihitungthr->check_transaksi($row['ID_THR']);
						 if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'periode' => $periode,
								'noind' => $row['NOIND'],
								'kd_status_kerja' => $row['KD_STATUS'],
								'diangkat' => date("Y-m-d",strtotime($row['DIANGKAT'])),
								'lama_thn' => $row['LM_THN'],
								'lama_bln' => $row['LM_BLN'],
								'kode_petugas' => $this->session->userdata('userid'),
								'tgl_jam_record' => date('Y-m-d H:i:s'),
							);
							$this->M_transaksihitungthr->update($row['ID_THR'],$data_update);
	                    }else{
	                    	$this->M_transaksihitungthr->insert($data_transaksi);
	                    }
                }

                //LOAD EXIST DATA VERIFICATION PAGE
                $this->checkSession();
        		$user_id = $this->session->userid;

        		$data['Menu'] = 'Komponen Penggajian';
        		$data['SubMenuOne'] = '';
        		$data['SubMenuTwo'] = '';

		        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		        $data['data_exist'] = $data_exist;
				unlink($file_path);
				$this->session->set_flashdata('flashSuccess', 'This is a success message.');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
				redirect(site_url('PayrollManagement/TransaksiHitungThr'));
            } else {
                // $this->load->view('csvindex');
				$this->session->set_flashdata('flashSuccess', 'This is a success message.');
				$ses=array(
						 "failed_import" => 1
					);
				$this->session->set_userdata($ses);
				redirect(site_url('PayrollManagement/TransaksiHitungThr'));
            }
        }
    }

    public function upload() {

        $config['upload_path'] = 'assets/upload/importPR/transaksithr';
        $config['file_name'] = 'TransaksiTHR-'.time();
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) {
            echo $this->upload->display_errors();
        }
        else {
            $file_data  = $this->upload->data();
            $filename   = $file_data['file_name'];
            $file_path  = 'assets/upload/importPR/transaksithr/'.$file_data['file_name'];

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
        $file_path  = 'assets/upload/importPR/transaksithr/'.$filename;
        $importData = $this->csvimport->get_array($file_path);

        foreach ($importData as $row) {
           $data = array(
               'id_data_thr' => $row['ID_THR'],
				'periode' => $periode,
				'noind' => $row['NOIND'],
				'kd_status_kerja' => $row['KD_STATUS'],
				'diangkat' => $row['DIANGKAT'],
				'lama_thn' => $row['LM_THN'],
				'lama_bln' => $row['LM_BLN'],
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
            );

            $this->M_transaksihitungthr->insert($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_import" => 1
				);
			$this->session->set_userdata($ses);
        redirect(site_url('PayrollManagement/TransaksiHitungThr'));
    }

    public function hitung(){
		$dt = explode("/",$this->input->post('txtPeriodeHitung',TRUE));
		$periode = $dt[1]."-".$dt[0];
        $hitung_data = $this->M_transaksihitungthr->get_hitung_data($periode);

		if(!empty($hitung_data)){
			foreach ($hitung_data as $row) {
				$ht_where = array(
					'id_transaksi_thr' => $row['id_transaksi_thr'],
				);

				$lama_thn = $row['lama_thn'];
				$lama_bln = $row['lama_bln'];
				$gaji_pokok = $row['gaji_pokok'];
				$persentase_thr = $row['persentase_thr'];
				$persentase_ubthr = $row['persentase_ubthr'];

				if ($lama_thn > 0) {
					$thr_awal = $gaji_pokok * 1;
					$ubthr_awal = $gaji_pokok * 1;
				}
				else{
					$thr_awal = $gaji_pokok * ($lama_bln/12);
					$ubthr_awal = $gaji_pokok * ($lama_bln/12);
				}

				$thr_akhir = $thr_awal * ($persentase_thr/100);
				$ubthr_akhir = $ubthr_awal * ($persentase_ubthr/100);

				$ht_data = array(
					'gaji_pokok' => $gaji_pokok,
					'tanggal' => date('Y-m-d'),
					'persentase_thr' => $persentase_thr,
					'thr' => round($thr_akhir, 2),
					'persentase_ubthr' => $persentase_ubthr,
					'ubthr' => round($ubthr_akhir, 2),
				);

				$this->M_transaksihitungthr->update_hitung($ht_where, $ht_data);
                //insert to sys.log_activity
                $aksi = 'Payroll Management';
                $detail = "Update Data thr ID=".$row['id_transaksi_thr'];
                $this->log_activity->activity_log($aksi, $detail);
                //
			}

			$enc_str = $this->encrypt->encode($periode);
			$enc_str = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_str);
			redirect(site_url('PayrollManagement/TransaksiHitungThr?id='.$enc_str.''));
		}else{
			$this->session->set_flashdata('flashSuccess', 'This is a success message.');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
			redirect(site_url('PayrollManagement/TransaksiHitungThr'));
		}
	}

	public function CetakStruk($id){
        $plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$periode = $this->encrypt->decode($plaintext_string);
		$this->checkSession();
		if ($periode != '') {

			$data['strukData'] = $this->M_transaksihitungthr->getTransaksiTHR($periode);
		}
		else{
			echo "";
		}

		$html = $this->load->view('PayrollManagement/TransaksiHitungThr/V_struk', $data, true);
		// print_r($data['strukData']);exit;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(215,140), 0, 'A4-P', 0, 0, 0, 0);

		$filename = 'Struk_THR'.time();

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
    }

    public function checkSession(){
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }

	public function search(){
		$this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'THR';
        $data['SubMenuTwo'] = '';
		$dt = explode("/",$this->input->post('txtPeriodeHitung',TRUE));
		$enc_dt = $dt[1]."-".$dt[0];

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['action2'] = site_url('PayrollManagement/TransaksiHitungThr/search');
        $data['action'] = site_url('PayrollManagement/TransaksiHitungThr/hitung');
        $data['transaksiHitungThr_data'] = $this->M_transaksihitungthr->get_by_period($enc_dt);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHitungThr/V_index', $data);
        $this->load->view('V_Footer',$data);
	}

    public function formValidation()
    {
	}

}

/* End of file C_TransaksiHitungThr.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiTHR/C_TransaksiHitungThr.php */
/* Generated automatically on 2016-11-28 15:07:51 */
