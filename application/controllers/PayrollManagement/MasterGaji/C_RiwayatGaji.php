<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatGaji extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
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
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatGaji = $this->M_riwayatgaji->get_all();

        $data['riwayatGaji_data'] = $riwayatGaji;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatGaji/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_riwayatgaji->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
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
            redirect(site_url('PayrollManagement/RiwayatGaji'));
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
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_hubungan_kerja' => $this->input->post('cmbKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'gaji_pokok' => $this->input->post('txtGajiPokok',TRUE),
				'i_f' => $this->input->post('txtIF',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_record' => $this->input->post('txtTglRecord',TRUE),
			);

            $this->M_riwayatgaji->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatgaji->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
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
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        
            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => $this->input->post('txtTglTberlaku',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_hubungan_kerja' => $this->input->post('cmbKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('cmbKdJabatan',TRUE),
				'gaji_pokok' => $this->input->post('txtGajiPokok',TRUE),
				'i_f' => $this->input->post('txtIF',TRUE),
				'kd_petugas' => $this->input->post('txtKdPetugas',TRUE),
				'tgl_record' => $this->input->post('txtTglRecord',TRUE),
			);

            $this->M_riwayatgaji->update($this->input->post('txtIdRiwGaji', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        
    }

    public function delete($id)
    {
        $row = $this->M_riwayatgaji->get_by_id($id);

        if ($row) {
            $this->M_riwayatgaji->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/RiwayatGaji'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
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
	                    	'noind' => $row['NOIND'],
							'kd_hubungan_kerja' => $row['KD_HUB_KER'],
							'kd_status_kerja' => $row['KD_STATUS_'],
							'nik' => $row['NIK'],
							'no_kk' => $row['NO_KK'],
							'nama' => $row['NAMA'],
							'id_kantor_asal' => $row['ID_KANT_AS'],
							'id_lokasi_kerja' => $row['ID_LOK_KER'],
							'jns_kelamin' => $row['JENKEL'],
							'tempat_lahir' => $row['TEMPAT_LHR'],
							'tgl_lahir' => $row['TGL_LHR'],
							'alamat' => $row['ALAMAT'],
							'desa' => $row['DESA'],
							'kecamatan' => $row['KEC'],
							'kabupaten' => $row['KAB'],
							'provinsi' => $row['PROVINSI'],
							'kode_pos' => $row['KODE_POS'],
							'no_hp' => $row['NO_HP'],
							'gelar_d' => $row['GELARD'],
							'gelar_b' => $row['GELARB'],
							'pendidikan' => $row['PENDIDIKAN'],
							'jurusan' => $row['JURUSAN'],
							'sekolah' => $row['SEKOLAH'],
							'stat_nikah' => $row['STAT_NIKAH'],
							'tgl_nikah' => $row['TGL_NIKAH'],
							'jml_anak' => $row['JML_ANAK'],
							'jml_sdr' => $row['JML_SDR'],
							'diangkat' => $row['DIANGKAT'],
							'masuk_kerja' => $row['MASUK_KERJ'],
							'kodesie' => $row['KODESIE'],
							'gol_kerja' => $row['GOL_KERJA'],
							'kd_asal_outsourcing' => $row['KD_ASAL_OS'],
							'kd_jabatan' => str_replace("'","",$row['KD_JABATAN']),
							'jabatan' => $row['JABATAN'],
							'npwp' => $row['NPWP'],
							'no_kpj' => $row['NO_KPJ'],
							'lm_kontrak' => $row['LM_KONTRAK'],
							'akh_kontrak' => $row['AKH_KONTRA'],
							'stat_pajak' => $row['STAT_PAJAK'],
							'jt_anak' => $row['JT_ANAK'],
							'jt_bkn_anak' => $row['JT_BKN_ANA'],
							'tgl_spsi' => $row['TGL_SPSI'],
							'no_spsi' => $row['NO_SPSI'],
							'tgl_kop' => $row['TGL_KOP'],
							'no_koperasi' => $row['NO_KOPERAS'],
							'keluar' => $row['KELUAR'],sayang
							'tgl_keluar' => $row['TGL_KELUAR'],
							'kd_pkj' => $row['KD_PKJ'],
							'angg_jkn' => $row['ANGG_JKN'],
							'noind_baru' => $row['NOIND_BARU'],
	                    );

                    	//CHECK IF EXIST
                    	$noind = str_pad($row['NOIND'], 5, "0", STR_PAD_LEFT);
	                   	$check = $this->M_masterpekerja->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
	                    }else{
	                    	$this->M_masterpekerja->insert($data);
	                    }

                	}else{
                		//ROW DATA
                		$data = array(
	                    	'noind' => $row['noind'],
							'kd_hubungan_kerja' => $row['kd_hubungan_kerja'],
							'kd_status_kerja' => $row['kd_status_kerja'],
							'nik' => $row['nik'],
							'no_kk' => $row['no_kk'],
							'nama' => $row['nama'],
							'id_kantor_asal' => $row['id_kantor_asal'],
							'id_lokasi_kerja' => $row['id_lokasi_kerja'],
							'jns_kelamin' => $row['jns_kelamin'],
							'tempat_lahir' => $row['tempat_lahir'],
							'tgl_lahir' => $row['tgl_lahir'],
							'alamat' => $row['alamat'],
							'desa' => $row['desa'],
							'kecamatan' => $row['kecamatan'],
							'kabupaten' => $row['kabupaten'],
							'provinsi' => $row['provinsi'],
							'kode_pos' => $row['kode_pos'],
							'no_hp' => $row['no_hp'],
							'gelar_d' => $row['gelar_d'],
							'gelar_b' => $row['gelar_b'],
							'pendidikan' => $row['pendidikan'],
							'jurusan' => $row['jurusan'],
							'sekolah' => $row['sekolah'],
							'stat_nikah' => $row['stat_nikah'],
							'tgl_nikah' => $row['tgl_nikah'],
							'jml_anak' => $row['jml_anak'],
							'jml_sdr' => $row['jml_sdr'],
							'diangkat' => $row['diangkat'],
							'masuk_kerja' => $row['masuk_kerja'],
							'kodesie' => $row['kodesie'],
							'gol_kerja' => $row['gol_kerja'],
							'kd_asal_outsourcing' => $row['kd_asal_outsourcing'],
							'kd_jabatan' => str_replace("'","",$row['kd_jabatan']),
							'jabatan' => $row['jabatan'],
							'npwp' => $row['npwp'],
							'no_kpj' => $row['no_kpj'],
							'lm_kontrak' => $row['lm_kontrak'],
							'akh_kontrak' => $row['akh_kontrak'],
							'stat_pajak' => $row['stat_pajak'],
							'jt_anak' => $row['jt_anak'],
							'jt_bkn_anak' => $row['jt_bkn_anak'],
							'tgl_spsi' => $row['tgl_spsi'],
							'no_spsi' => $row['no_spsi'],
							'tgl_kop' => $row['tgl_kop'],
							'no_koperasi' => $row['no_koperasi'],
							'keluar' => $row['keluar'],
							'tgl_keluar' => $row['tgl_keluar'],
							'kd_pkj' => $row['kd_pkj'],
							'angg_jkn' => $row['angg_jkn'],
							'noind_baru' => $row['noind_baru'],
	                    );

	                    //CHECK IF EXIST
                    	$noind = str_pad($row['noind'], 5, "0", STR_PAD_LEFT);
	                   	$check = $this->M_masterpekerja->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
	                    }else{
	                    	$this->M_masterpekerja->insert($data);
	                    }
	                    
                	}
                }

                //LOAD EXIST DATA VERIFICATION PAGE
                $this->checkSession();
        		$user_id = $this->session->userid;
        
        		$data['Menu'] = 'Payroll Management';
        		$data['SubMenuOne'] = '';
        		$data['SubMenuTwo'] = '';

		        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		        $data['data_exist'] = $data_exist;
        		$masterPekerja = $this->M_masterpekerja->get_all();

		        $this->load->view('V_Header',$data);
		        $this->load->view('V_Sidemenu',$data);
		        $this->load->view('PayrollManagement/MasterPekerja/V_Upload', $data);
		        $this->load->view('V_Footer',$data);
                unlink($file_path);

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
                'tgl_berlaku' => $row['tgl_berlaku'],
                'tgl_tberlaku' => $row['tgl_tberlaku'],
                'noind' => $row['noind'],
                'kd_hubungan_kerja' => $row['kd_hubungan_kerja'],
                'kd_status_kerja' => $row['kd_status_kerja'],
                'kd_jabatan' => $row['kd_jabatan'],
                'gaji_pokok' => $row['gaji_pokok'],
                'i_f' => $row['i_f'],
                'kd_petugas' => $row['kd_petugas'],
                'tgl_record' => $row['tgl_record'],
            );
            $this->M_riwayatgaji->insert($data);
        }

        $this->session->set_flashdata('message', 'Create Record Success');
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