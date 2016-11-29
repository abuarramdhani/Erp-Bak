<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterPekerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterPekerja/M_masterpekerja');
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
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterPekerja = $this->M_masterpekerja->get_all();

        $data['masterPekerja_data'] = $masterPekerja;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterPekerja/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_masterpekerja->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'noind' => $row->noind,
				'kd_hubungan_kerja' => $row->kd_hubungan_kerja,
				'kd_status_kerja' => $row->kd_status_kerja,
				'nik' => $row->nik,
				'no_kk' => $row->no_kk,
				'nama' => $row->nama,
				'id_kantor_asal' => $row->id_kantor_asal,
				'id_lokasi_kerja' => $row->id_lokasi_kerja,
				'jns_kelamin' => $row->jns_kelamin,
				'tempat_lahir' => $row->tempat_lahir,
				'tgl_lahir' => $row->tgl_lahir,
				'alamat' => $row->alamat,
				'desa' => $row->desa,
				'kecamatan' => $row->kecamatan,
				'kabupaten' => $row->kabupaten,
				'provinsi' => $row->provinsi,
				'kode_pos' => $row->kode_pos,
				'no_hp' => $row->no_hp,
				'gelar_d' => $row->gelar_d,
				'gelar_b' => $row->gelar_b,
				'pendidikan' => $row->pendidikan,
				'jurusan' => $row->jurusan,
				'sekolah' => $row->sekolah,
				'stat_nikah' => $row->stat_nikah,
				'tgl_nikah' => $row->tgl_nikah,
				'jml_anak' => $row->jml_anak,
				'jml_sdr' => $row->jml_sdr,
				'diangkat' => $row->diangkat,
				'masuk_kerja' => $row->masuk_kerja,
				'kodesie' => $row->kodesie,
				'gol_kerja' => $row->gol_kerja,
				'kd_asal_outsourcing' => $row->kd_asal_outsourcing,
				'kd_jabatan' => $row->kd_jabatan,
				'jabatan' => $row->jabatan,
				'npwp' => $row->npwp,
				'no_kpj' => $row->no_kpj,
				'lm_kontrak' => $row->lm_kontrak,
				'akh_kontrak' => $row->akh_kontrak,
				'stat_pajak' => $row->stat_pajak,
				'jt_anak' => $row->jt_anak,
				'jt_bkn_anak' => $row->jt_bkn_anak,
				'tgl_spsi' => $row->tgl_spsi,
				'no_spsi' => $row->no_spsi,
				'tgl_kop' => $row->tgl_kop,
				'no_koperasi' => $row->no_koperasi,
				'keluar' => $row->keluar,
				'tgl_keluar' => $row->tgl_keluar,
				'kd_pkj' => $row->kd_pkj,
				'angg_jkn' => $row->angg_jkn,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterPekerja/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterPekerja'));
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
            'action' => site_url('PayrollManagement/MasterPekerja/save'),
				'noind' => set_value(''),
			'kd_hubungan_kerja' => set_value('kd_hubungan_kerja'),
			'pr_master_status_kerja_data' => $this->M_masterpekerja->get_pr_master_status_kerja_data(),
			'kd_status_kerja' => set_value('kd_status_kerja'),
			'nik' => set_value('nik'),
			'no_kk' => set_value('no_kk'),
			'nama' => set_value('nama'),
			'pr_kantor_asal_data' => $this->M_masterpekerja->get_pr_kantor_asal_data(),
			'id_kantor_asal' => set_value('id_kantor_asal'),
			'pr_lokasi_kerja_data' => $this->M_masterpekerja->get_pr_lokasi_kerja_data(),
			'id_lokasi_kerja' => set_value('id_lokasi_kerja'),
			'jns_kelamin' => set_value('jns_kelamin'),
			'tempat_lahir' => set_value('tempat_lahir'),
			'tgl_lahir' => set_value('tgl_lahir'),
			'alamat' => set_value('alamat'),
			'desa' => set_value('desa'),
			'kecamatan' => set_value('kecamatan'),
			'kabupaten' => set_value('kabupaten'),
			'provinsi' => set_value('provinsi'),
			'kode_pos' => set_value('kode_pos'),
			'no_hp' => set_value('no_hp'),
			'gelar_d' => set_value('gelar_d'),
			'gelar_b' => set_value('gelar_b'),
			'pendidikan' => set_value('pendidikan'),
			'jurusan' => set_value('jurusan'),
			'sekolah' => set_value('sekolah'),
			'stat_nikah' => set_value('stat_nikah'),
			'tgl_nikah' => set_value('tgl_nikah'),
			'jml_anak' => set_value('jml_anak'),
			'jml_sdr' => set_value('jml_sdr'),
			'diangkat' => set_value('diangkat'),
			'masuk_kerja' => set_value('masuk_kerja'),
			'kodesie' => set_value('kodesie'),
			'gol_kerja' => set_value('gol_kerja'),
			'kd_asal_outsourcing' => set_value('kd_asal_outsourcing'),
			'kd_jabatan' => set_value('kd_jabatan'),
			'pr_master_jabatan_data' => $this->M_masterpekerja->get_pr_master_jabatan_data(),
			'jabatan' => set_value('jabatan'),
			'npwp' => set_value('npwp'),
			'no_kpj' => set_value('no_kpj'),
			'lm_kontrak' => set_value('lm_kontrak'),
			'akh_kontrak' => set_value('akh_kontrak'),
			'stat_pajak' => set_value('stat_pajak'),
			'jt_anak' => set_value('jt_anak'),
			'jt_bkn_anak' => set_value('jt_bkn_anak'),
			'tgl_spsi' => set_value('tgl_spsi'),
			'no_spsi' => set_value('no_spsi'),
			'tgl_kop' => set_value('tgl_kop'),
			'no_koperasi' => set_value('no_koperasi'),
			'keluar' => set_value('keluar'),
			'tgl_keluar' => set_value('tgl_keluar'),
			'kd_pkj' => set_value('kd_pkj'),
			'angg_jkn' => set_value('angg_jkn'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterPekerja/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

            $data = array(
				'noind' => $this->input->post('txtNoindNew',TRUE),
				'kd_hubungan_kerja' => $this->input->post('txtKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'nik' => $this->input->post('txtNik',TRUE),
				'no_kk' => $this->input->post('txtNoKk',TRUE),
				'nama' => $this->input->post('txtNama',TRUE),
				'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
				'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
				'jns_kelamin' => $this->input->post('cmbJnsKelamin',TRUE),
				'tempat_lahir' => $this->input->post('txtTempatLahir',TRUE),
				'tgl_lahir' => $this->input->post('txtTglLahir',TRUE),
				'alamat' => $this->input->post('txtAlamat',TRUE),
				'desa' => $this->input->post('txtDesa',TRUE),
				'kecamatan' => $this->input->post('txtKecamatan',TRUE),
				'kabupaten' => $this->input->post('txtKabupaten',TRUE),
				'provinsi' => $this->input->post('txtProvinsi',TRUE),
				'kode_pos' => $this->input->post('txtKodePos',TRUE),
				'no_hp' => $this->input->post('txtNoHp',TRUE),
				'gelar_d' => $this->input->post('txtGelarD',TRUE),
				'gelar_b' => $this->input->post('txtGelarB',TRUE),
				'pendidikan' => $this->input->post('txtPendidikan',TRUE),
				'jurusan' => $this->input->post('txtJurusan',TRUE),
				'sekolah' => $this->input->post('txtSekolah',TRUE),
				'stat_nikah' => $this->input->post('txtStatNikah',TRUE),
				'tgl_nikah' => $this->input->post('txtTglNikah',TRUE),
				'jml_anak' => $this->input->post('txtJmlAnak',TRUE),
				'jml_sdr' => $this->input->post('txtJmlSdr',TRUE),
				'diangkat' => $this->input->post('txtDiangkat',TRUE),
				'masuk_kerja' => $this->input->post('txtMasukKerja',TRUE),
				'kodesie' => $this->input->post('txtKodesie',TRUE),
				'gol_kerja' => $this->input->post('txtGolKerja',TRUE),
				'kd_asal_outsourcing' => $this->input->post('txtKdAsalOutsourcing',TRUE),
				'kd_jabatan' => $this->input->post('txtKdJabatan',TRUE),
				'jabatan' => $this->input->post('cmbJabatan',TRUE),
				'npwp' => $this->input->post('txtNpwp',TRUE),
				'no_kpj' => $this->input->post('txtNoKpj',TRUE),
				'lm_kontrak' => $this->input->post('txtLmKontrak',TRUE),
				'akh_kontrak' => $this->input->post('txtAkhKontrak',TRUE),
				'stat_pajak' => $this->input->post('txtStatPajak',TRUE),
				'jt_anak' => $this->input->post('txtJtAnak',TRUE),
				'jt_bkn_anak' => $this->input->post('txtJtBknAnak',TRUE),
				'tgl_spsi' => $this->input->post('txtTglSpsi',TRUE),
				'no_spsi' => $this->input->post('txtNoSpsi',TRUE),
				'tgl_kop' => $this->input->post('txtTglKop',TRUE),
				'no_koperasi' => $this->input->post('txtNoKoperasi',TRUE),
				'keluar' => $this->input->post('txtKeluar',TRUE),
				'tgl_keluar' => $this->input->post('txtTglKeluar',TRUE),
				'kd_pkj' => $this->input->post('txtKdPkj',TRUE),
				'angg_jkn' => $this->input->post('txtAnggJkn',TRUE),
			);

            $this->M_masterpekerja->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/MasterPekerja'));
        
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterpekerja->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/MasterPekerja/saveUpdate'),
				
				'pr_master_status_kerja_data' => $this->M_masterpekerja->get_pr_master_status_kerja_data(),
				'pr_kantor_asal_data' => $this->M_masterpekerja->get_pr_kantor_asal_data(),
				'pr_lokasi_kerja_data' => $this->M_masterpekerja->get_pr_lokasi_kerja_data(),
				'pr_master_jabatan_data' => $this->M_masterpekerja->get_pr_master_jabatan_data(),
				
				'noind' => set_value('txtNoind', $row->noind),
				'kd_hubungan_kerja' => set_value('txtKdHubunganKerja', $row->kd_hubungan_kerja),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'nik' => set_value('txtNik', $row->nik),
				'no_kk' => set_value('txtNoKk', $row->no_kk),
				'nama' => set_value('txtNama', $row->nama),
				'id_kantor_asal' => set_value('txtIdKantorAsal', $row->id_kantor_asal),
				'id_lokasi_kerja' => set_value('txtIdLokasiKerja', $row->id_lokasi_kerja),
				'jns_kelamin' => set_value('txtJnsKelamin', $row->jns_kelamin),
				'tempat_lahir' => set_value('txtTempatLahir', $row->tempat_lahir),
				'tgl_lahir' => set_value('txtTglLahir', $row->tgl_lahir),
				'alamat' => set_value('txtAlamat', $row->alamat),
				'desa' => set_value('txtDesa', $row->desa),
				'kecamatan' => set_value('txtKecamatan', $row->kecamatan),
				'kabupaten' => set_value('txtKabupaten', $row->kabupaten),
				'provinsi' => set_value('txtProvinsi', $row->provinsi),
				'kode_pos' => set_value('txtKodePos', $row->kode_pos),
				'no_hp' => set_value('txtNoHp', $row->no_hp),
				'gelar_d' => set_value('txtGelarD', $row->gelar_d),
				'gelar_b' => set_value('txtGelarB', $row->gelar_b),
				'pendidikan' => set_value('txtPendidikan', $row->pendidikan),
				'jurusan' => set_value('txtJurusan', $row->jurusan),
				'sekolah' => set_value('txtSekolah', $row->sekolah),
				'stat_nikah' => set_value('txtStatNikah', $row->stat_nikah),
				'tgl_nikah' => set_value('txtTglNikah', $row->tgl_nikah),
				'jml_anak' => set_value('txtJmlAnak', $row->jml_anak),
				'jml_sdr' => set_value('txtJmlSdr', $row->jml_sdr),
				'diangkat' => set_value('txtDiangkat', $row->diangkat),
				'masuk_kerja' => set_value('txtMasukKerja', $row->masuk_kerja),
				'kodesie' => set_value('txtKodesie', $row->kodesie),
				'gol_kerja' => set_value('txtGolKerja', $row->gol_kerja),
				'kd_asal_outsourcing' => set_value('txtKdAsalOutsourcing', $row->kd_asal_outsourcing),
				'kd_jabatan' => set_value('txtKdJabatan', $row->kd_jabatan),
				'jabatan' => set_value('txtJabatan', $row->jabatan),
				'npwp' => set_value('txtNpwp', $row->npwp),
				'no_kpj' => set_value('txtNoKpj', $row->no_kpj),
				'lm_kontrak' => set_value('txtLmKontrak', $row->lm_kontrak),
				'akh_kontrak' => set_value('txtAkhKontrak', $row->akh_kontrak),
				'stat_pajak' => set_value('txtStatPajak', $row->stat_pajak),
				'jt_anak' => set_value('txtJtAnak', $row->jt_anak),
				'jt_bkn_anak' => set_value('txtJtBknAnak', $row->jt_bkn_anak),
				'tgl_spsi' => set_value('txtTglSpsi', $row->tgl_spsi),
				'no_spsi' => set_value('txtNoSpsi', $row->no_spsi),
				'tgl_kop' => set_value('txtTglKop', $row->tgl_kop),
				'no_koperasi' => set_value('txtNoKoperasi', $row->no_koperasi),
				'keluar' => set_value('txtKeluar', $row->keluar),
				'tgl_keluar' => set_value('txtTglKeluar', $row->tgl_keluar),
				'kd_pkj' => set_value('txtKdPkj', $row->kd_pkj),
				'angg_jkn' => set_value('txtAnggJkn', $row->angg_jkn),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterPekerja/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterPekerja'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

            $data = array(
				'noind' => $this->input->post('txtNoindNew',TRUE),
				'kd_hubungan_kerja' => $this->input->post('txtKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('cmbKdStatusKerja',TRUE),
				'nik' => $this->input->post('txtNik',TRUE),
				'no_kk' => $this->input->post('txtNoKk',TRUE),
				'nama' => $this->input->post('txtNama',TRUE),
				'id_kantor_asal' => $this->input->post('cmbIdKantorAsal',TRUE),
				'id_lokasi_kerja' => $this->input->post('cmbIdLokasiKerja',TRUE),
				'jns_kelamin' => $this->input->post('cmbJnsKelamin',TRUE),
				'tempat_lahir' => $this->input->post('txtTempatLahir',TRUE),
				'tgl_lahir' => $this->input->post('txtTglLahir',TRUE),
				'alamat' => $this->input->post('txtAlamat',TRUE),
				'desa' => $this->input->post('txtDesa',TRUE),
				'kecamatan' => $this->input->post('txtKecamatan',TRUE),
				'kabupaten' => $this->input->post('txtKabupaten',TRUE),
				'provinsi' => $this->input->post('txtProvinsi',TRUE),
				'kode_pos' => $this->input->post('txtKodePos',TRUE),
				'no_hp' => $this->input->post('txtNoHp',TRUE),
				'gelar_d' => $this->input->post('txtGelarD',TRUE),
				'gelar_b' => $this->input->post('txtGelarB',TRUE),
				'pendidikan' => $this->input->post('txtPendidikan',TRUE),
				'jurusan' => $this->input->post('txtJurusan',TRUE),
				'sekolah' => $this->input->post('txtSekolah',TRUE),
				'stat_nikah' => $this->input->post('txtStatNikah',TRUE),
				'tgl_nikah' => $this->input->post('txtTglNikah',TRUE),
				'jml_anak' => $this->input->post('txtJmlAnak',TRUE),
				'jml_sdr' => $this->input->post('txtJmlSdr',TRUE),
				'diangkat' => $this->input->post('txtDiangkat',TRUE),
				'masuk_kerja' => $this->input->post('txtMasukKerja',TRUE),
				'kodesie' => $this->input->post('txtKodesie',TRUE),
				'gol_kerja' => $this->input->post('txtGolKerja',TRUE),
				'kd_asal_outsourcing' => $this->input->post('txtKdAsalOutsourcing',TRUE),
				'kd_jabatan' => $this->input->post('txtKdJabatan',TRUE),
				'jabatan' => $this->input->post('cmbJabatan',TRUE),
				'npwp' => $this->input->post('txtNpwp',TRUE),
				'no_kpj' => $this->input->post('txtNoKpj',TRUE),
				'lm_kontrak' => $this->input->post('txtLmKontrak',TRUE),
				'akh_kontrak' => $this->input->post('txtAkhKontrak',TRUE),
				'stat_pajak' => $this->input->post('txtStatPajak',TRUE),
				'jt_anak' => $this->input->post('txtJtAnak',TRUE),
				'jt_bkn_anak' => $this->input->post('txtJtBknAnak',TRUE),
				'tgl_spsi' => $this->input->post('txtTglSpsi',TRUE),
				'no_spsi' => $this->input->post('txtNoSpsi',TRUE),
				'tgl_kop' => $this->input->post('txtTglKop',TRUE),
				'no_koperasi' => $this->input->post('txtNoKoperasi',TRUE),
				'keluar' => $this->input->post('txtKeluar',TRUE),
				'tgl_keluar' => $this->input->post('txtTglKeluar',TRUE),
				'kd_pkj' => $this->input->post('txtKdPkj',TRUE),
				'angg_jkn' => $this->input->post('txtAnggJkn',TRUE),
			);

            $this->M_masterpekerja->update($this->input->post('txtNoind', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/MasterPekerja'));
    }

    public function delete($id)
    {
        $row = $this->M_masterpekerja->get_by_id($id);

        if ($row) {
            $this->M_masterpekerja->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/MasterPekerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/MasterPekerja'));
        }
    }
	
	//CLICK BUTTON IMPORT THEN LOAD IMPORT INFORMATION PAGE (FM)
	function importpekerja() {
       
		$config['upload_path'] = 'assets/upload/importPR/masterpekerja/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000';
		$this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
		else {	$file_data 	= $this->upload->data();
				$filename	= $file_data['file_name'];
				$file_path 	= 'assets/upload/importPR/masterpekerja/'.$file_data['file_name'];
				
			if ($this->csvimport->get_array($file_path)) {
                $data['csvarray'] = $this->csvimport->get_array($file_path);
				$data['filename'] = $filename;
				
				$this->checkSession();
				$user_id = $this->session->userid;

				$data['Menu'] = 'Dashboard';
				$data['SubMenuOne'] = '';
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('PayrollManagement/MasterPekerja/V_Upload',$data);
				$this->load->view('V_Footer',$data);
            } else {
                $this->load->view('csvindex');
			}
        }
    }
	
	//CONFIRM INFORMATION PAGE THEN EXECUTE UPDATE QUERY (FM)
	function confirmpekerja(){
		
		$filename	= $this->input->POST('TxtFileName');
        $file_path 	= 'assets/upload/importPR/masterpekerja/'.$filename;
		$csv_array 	= $this->csvimport->get_array($file_path);

		foreach ($csv_array as $row) {
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
				'kd_jabatan' => $row['kd_jabatan'],
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
			);
			$this->M_masterpekerja->insert($data);
		}
		unlink($file_path);
        redirect(base_url().'PayrollManagement/MasterPekerja');
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

/* End of file C_MasterPekerja.php */
/* Location: ./application/controllers/PayrollManagement/MasterPekerja/C_MasterPekerja.php */
/* Generated automatically on 2016-11-26 11:32:52 */