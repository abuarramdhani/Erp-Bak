<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterPekerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterPekerja/M_masterpekerja');
		$this->load->library('csvimport');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
		$this->load->library(array('Excel/PHPExcel','Excel/PHPExcel/IOFactory'));
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Master Pekerja';
        $data['SubMenuOne'] = 'Master Pekerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $hubker = $this->M_masterpekerja->get_hubker();

        $data['Hubker_data'] = $hubker;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/MasterPekerja/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_import');
		$this->session->unset_userdata('success_delete');
		$this->session->unset_userdata('success_update');
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('not_found');
    }

	public function search()
    {

		$statKerja = $this->input->post('txtKodeStatusKerja',TRUE);
		$prefix = $statusKerja = '';
		foreach ($statKerja as $t){
			$statusKerja .= $prefix . "'".str_replace(' ','',$t)."'";
			$prefix = ', ';
		}
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Master Pekerja';
        $data['SubMenuOne'] = 'Master Pekerja';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $masterPekerja = $this->M_masterpekerja->get_all($statusKerja);
		$hubker = $this->M_masterpekerja->get_hubker();

        $data['Hubker_data'] = $hubker;
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
            	'Menu' => 'Master Pekerja',
            	'SubMenuOne' => 'Master Pekerja',
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
				'noind_baru' => $row->noind_baru,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterPekerja/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterPekerja'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Pekerja',
            'SubMenuOne' => 'Master Pekerja',
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
			'noind_baru' => set_value('noind_baru'),
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
				'noind_baru' => $this->input->post('noinD_baru',TRUE),
			);

            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create Master Pekerja nik=".$this->input->post('txtNik');
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_masterpekerja->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterPekerja'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_masterpekerja->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Pekerja',
                'SubMenuOne' => 'Master Pekerja',
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
				'noind_baru' => set_value('noind_baru', $row->angg_jkn),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/MasterPekerja/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
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
				'noind_baru' => $this->input->post('noinD_baru',TRUE),
			);

            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Master Pekerja noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //

            $this->M_masterpekerja->update($this->input->post('txtNoind', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterPekerja'));
    }

    public function delete($id)
    {
        $row = $this->M_masterpekerja->get_by_id($id);

        if ($row) {
            $this->M_masterpekerja->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Master Pekerja ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterPekerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/MasterPekerja'));
        }
    }

   // public function doImport(){

		// $fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		// $fileName = str_replace(' ', '_', $fileName);

		// $config['upload_path'] = 'assets/upload/importPR/masterpekerja/';
		// $config['file_name'] = $fileName;
		// $config['allowed_types'] = '*';

		// $this->load->library('upload', $config);

		// $data['upload_data'] = '';
		// if ($this->upload->do_upload('file')) {
			// $uploadData = $this->upload->data();
			// $inputFileName = 'assets/upload/importPR/masterpekerja/'.$uploadData['file_name'];
			// $inputFileName = 'assets/upload/1490405144-PROD0117_(copy).dbf';
			// $db = dbase_open($inputFileName, 0);
			// print_r(dbase_get_header_info($db));
			// $db_rows = dbase_numrecords($db);
			// for ($i=1; $i <= $db_rows; $i++) {
				// $db_record = dbase_get_record_with_names($db, $i);

				// $dataCekUpdate = array(
					// 'rtrim(employee_code)' => rtrim(utf8_encode($db_record['NOIND'])),
				// );

				// $data = array(
					// 'noind' => utf8_encode($db_record['NOIND']),
							// 'kd_hubungan_kerja' => utf8_encode($db_record['KD_HUB_KER']),
							// 'kd_status_kerja' => utf8_encode($db_record['KD_STATUS_']),
							// 'nik' => utf8_encode($db_record['NIK']),
							// 'no_kk' => utf8_encode($db_record['NO_KK']),
							// 'nama' => utf8_encode($db_record['NAMA']),
							// 'id_kantor_asal' => utf8_encode($db_record['ID_KANT_AS']),
							// 'id_lokasi_kerja' => utf8_encode($db_record['ID_LOK_KER']),
							// 'jns_kelamin' => utf8_encode($db_record['JENKEL']),
							// 'tempat_lahir' => utf8_encode($db_record['TEMPAT_LHR']),
							// 'tgl_lahir' => utf8_encode($db_record['TGL_LHR']),
							// 'alamat' => utf8_encode($db_record['ALAMAT']),
							// 'desa' => utf8_encode($db_record['DESA']),
							// 'kecamatan' => utf8_encode($db_record['KEC']),
							// 'kabupaten' => utf8_encode($db_record['KAB']),
							// 'provinsi' => utf8_encode($db_record['PROVINSI']),
							// 'kode_pos' => utf8_encode($db_record['KODE_POS']),
							// 'no_hp' => utf8_encode($db_record['NO_HP']),
							// 'gelar_d' => utf8_encode($db_record['GELARD']),
							// 'gelar_b' => utf8_encode($db_record['GELARB']),
							// 'pendidikan' => utf8_encode($db_record['PENDIDIKAN']),
							// 'jurusan' => utf8_encode($db_record['JURUSAN']),
							// 'sekolah' => utf8_encode($db_record['SEKOLAH']),
							// 'stat_nikah' => utf8_encode($db_record['STAT_NIKAH']),
							// 'tgl_nikah' => utf8_encode($db_record['TGL_NIKAH']),
							// 'jml_anak' => utf8_encode($db_record['JML_ANAK']),
							// 'jml_sdr' => utf8_encode($db_record['JML_SDR']),
							// 'diangkat' => utf8_encode($db_record['DIANGKAT']),
							// 'masuk_kerja' => utf8_encode($db_record['MASUK_KERJ']),
							// 'kodesie' => utf8_encode($db_record['KODESIE']),
							// 'gol_kerja' => utf8_encode($db_record['GOL_KERJA']),
							// 'kd_asal_outsourcing' => utf8_encode($db_record['KD_ASAL_OS']),
							// 'kd_jabatan' => str_replace("'","",utf8_encode($db_record['KD_JABATAN'])),
							// 'jabatan' => utf8_encode($db_record['JABATAN']),
							// 'npwp' => utf8_encode($db_record['NPWP']),
							// 'no_kpj' => utf8_encode($db_record['NO_KPJ']),
							// 'lm_kontrak' => utf8_encode($db_record['LM_KONTRAK']),
							// 'akh_kontrak' => utf8_encode($db_record['AKH_KONTRA']),
							// 'stat_pajak' => utf8_encode($db_record['STAT_PAJAK']),
							// 'jt_anak' => utf8_encode($db_record['JT_ANAK']),
							// 'jt_bkn_anak' => utf8_encode($db_record['JT_BKN_ANA']),
							// 'tgl_spsi' => utf8_encode($db_record['TGL_SPSI']),
							// 'no_spsi' => utf8_encode($db_record['NO_SPSI']),
							// 'tgl_kop' => utf8_encode($db_record['TGL_KOP']),
							// 'no_koperasi' => utf8_encode($db_record['NO_KOPERAS']),
							// 'keluar' => utf8_encode($db_record['KELUAR']),
							// 'tgl_keluar' => utf8_encode($db_record['TGL_KELUAR']),
							// 'kd_pkj' => utf8_encode($db_record['KD_PKJ']),
							// 'angg_jkn' => utf8_encode($db_record['ANGG_JKN']),
							// 'noind_baru' => utf8_encode($db_record['NOIND_BARU']),
				// );

				// $cekUpdate = $this->M_masterpekerja->cekUpdate($dataCekUpdate);
				// if ($cekUpdate->num_rows() != 0) {
					// foreach ($cekUpdate->result() as $dataUpdateOld) {
						// $employee_id = $dataUpdateOld->employee_id;
					// }
					// $this->M_masterpekerja->updateMasterPekerja($data, $employee_id);
				// }
				// else{
					// $this->M_masterpekerja->setMasterPekerja($data);
				// }


				// print_r($data);

			// }
			// unlink($inputFileName);
			// redirect(site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi'));
		// }
		// else{
			// echo $this->upload->display_errors();
		// }
	// }


	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ IMPORT V1 ++++++++++++++++++++++++++++++++++++++++++++

	  public function import() {
		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '-1');
		error_reporting(E_ALL ^ E_NOTICE);
		$filename = $_FILES['file']['name'];
		$config['upload_path'] = './assets/upload/importPR/masterpekerja/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $filename;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

		$this->load->library('upload');
        $this->upload->initialize($config);

		if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();

		$media = $this->upload->data('file');

        $inputFileName = './assets/upload/importPR/masterpekerja/'.$filename;
		try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

		 $sheet = $objPHPExcel->getSheet(0);
		 if($sheet){
			$highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
							$noind = $rowData[0][0];
							$check = $this->M_masterpekerja->check($noind);
						if($check){
							$data = array(
									'kd_hubungan_kerja' => substr($rowData[0][2],0,3),
									'kd_status_kerja' => substr($rowData[0][3],0,1),
									'nik' => substr($rowData[0][4],0,20),
									'no_kk' => substr($rowData[0][5],0,20),
									'nama' => substr($rowData[0][6],0,50),
									'id_kantor_asal' => substr($rowData[0][7],0,3),
									'id_lokasi_kerja' => substr($rowData[0][8],0,3),
									'jns_kelamin' => substr($rowData[0][9],0,1),
									'tempat_lahir' => substr($rowData[0][10],0,30),
									'tgl_lahir' => date("Y-m-d",strtotime($rowData[0][11])),
									'alamat' => substr($rowData[0][12],0,100),
									'desa' => substr($rowData[0][13],0,30),
									'kecamatan' => substr($rowData[0][14],0,30),
									'kabupaten' => substr($rowData[0][15],0,30),
									'provinsi' => substr($rowData[0][16],0,30),
									'kode_pos' => substr($rowData[0][17],0,6),
									'no_hp' => substr($rowData[0][18],0,16),
									'gelar_d' => substr($rowData[0][19],0,6),
									'gelar_b' => substr($rowData[0][20],0,6),
									'pendidikan' => substr($rowData[0][21],0,7),
									'jurusan' => substr($rowData[0][22],0,30),
									'sekolah' => substr($rowData[0][23],0,60),
									'stat_nikah' => substr($rowData[0][24],0,2),
									'tgl_nikah' => date("Y-m-d",strtotime($rowData[0][25])),
									'jml_anak' => substr($rowData[0][26],0,2),
									'jml_sdr' => substr($rowData[0][27],0,2),
									'diangkat' => date("Y-m-d",strtotime($rowData[0][28])),
									'masuk_kerja' => date("Y-m-d",strtotime($rowData[0][29])),
									'kodesie' => substr($rowData[0][30],0,9),
									'gol_kerja' => substr($rowData[0][31],0,7),
									'kd_asal_outsourcing' => substr($rowData[0][32],0,4),
									'kd_jabatan' => substr(str_replace("'","",$rowData[0][33]),0,4),
									'jabatan' => substr($rowData[0][34],0,80),
									'npwp' => substr($rowData[0][35],0,20),
									'no_kpj' => substr($rowData[0][36],0,20),
									'lm_kontrak' => substr($rowData[0][37],0,2),
									'akh_kontrak' => date("Y-m-d",strtotime($rowData[0][38])),
									'stat_pajak' => substr($rowData[0][39],0,3),
									'jt_anak' => substr($rowData[0][40],0,1),
									'jt_bkn_anak' => substr($rowData[0][41],0,1),
									'tgl_spsi' => date("Y-m-d",strtotime($rowData[0][42])),
									'no_spsi' => substr($rowData[0][43],0,11),
									'tgl_kop' => date("Y-m-d",strtotime($rowData[0][44])),
									'no_koperasi' => substr($rowData[0][45],0,11),
									'keluar' => substr($rowData[0][46],0,1),
									'tgl_keluar' => date("Y-m-d",strtotime($rowData[0][47])),
									'kd_pkj' => substr($rowData[0][48],0,9),
									'angg_jkn' => substr($rowData[0][49],0,1),
									'noind_baru' => substr($rowData[0][1],0,7),
								);
							$this->M_masterpekerja->update($noind,$data);
						}else{
							$data = array(
									'noind' => substr($rowData[0][0],0,3),
									'kd_hubungan_kerja' => substr($rowData[0][2],0,3),
									'kd_status_kerja' => substr($rowData[0][3],0,1),
									'nik' => substr($rowData[0][4],0,20),
									'no_kk' => substr($rowData[0][5],0,20),
									'nama' => substr($rowData[0][6],0,50),
									'id_kantor_asal' => substr($rowData[0][7],0,3),
									'id_lokasi_kerja' => substr($rowData[0][8],0,3),
									'jns_kelamin' => substr($rowData[0][9],0,1),
									'tempat_lahir' => substr($rowData[0][10],0,30),
									'tgl_lahir' => date("Y-m-d",strtotime($rowData[0][11])),
									'alamat' => substr($rowData[0][12],0,100),
									'desa' => substr($rowData[0][13],0,30),
									'kecamatan' => substr($rowData[0][14],0,30),
									'kabupaten' => substr($rowData[0][15],0,30),
									'provinsi' => substr($rowData[0][16],0,30),
									'kode_pos' => substr($rowData[0][17],0,6),
									'no_hp' => substr($rowData[0][18],0,16),
									'gelar_d' => substr($rowData[0][19],0,6),
									'gelar_b' => substr($rowData[0][20],0,6),
									'pendidikan' => substr($rowData[0][21],0,7),
									'jurusan' => substr($rowData[0][22],0,30),
									'sekolah' => substr($rowData[0][23],0,60),
									'stat_nikah' => substr($rowData[0][24],0,2),
									'tgl_nikah' => date("Y-m-d",strtotime($rowData[0][25])),
									'jml_anak' => substr($rowData[0][26],0,2),
									'jml_sdr' => substr($rowData[0][27],0,2),
									'diangkat' => date("Y-m-d",strtotime($rowData[0][28])),
									'masuk_kerja' => date("Y-m-d",strtotime($rowData[0][29])),
									'kodesie' => substr($rowData[0][30],0,9),
									'gol_kerja' => substr($rowData[0][31],0,7),
									'kd_asal_outsourcing' => substr($rowData[0][32],0,4),
									'kd_jabatan' => substr(str_replace("'","",$rowData[0][33]),0,4),
									'jabatan' => substr($rowData[0][34],0,80),
									'npwp' => substr($rowData[0][35],0,20),
									'no_kpj' => substr($rowData[0][36],0,20),
									'lm_kontrak' => substr($rowData[0][37],0,2),
									'akh_kontrak' => date("Y-m-d",strtotime($rowData[0][38])),
									'stat_pajak' => substr($rowData[0][39],0,3),
									'jt_anak' => substr($rowData[0][40],0,1),
									'jt_bkn_anak' => substr($rowData[0][41],0,1),
									'tgl_spsi' => date("Y-m-d",strtotime($rowData[0][42])),
									'no_spsi' => substr($rowData[0][43],0,11),
									'tgl_kop' => date("Y-m-d",strtotime($rowData[0][44])),
									'no_koperasi' => substr($rowData[0][45],0,11),
									'keluar' => substr($rowData[0][46],0,1),
									'tgl_keluar' => date("Y-m-d",strtotime($rowData[0][47])),
									'kd_pkj' => substr($rowData[0][48],0,9),
									'angg_jkn' => substr($rowData[0][49],0,1),
									'noind_baru' => substr($rowData[0][1],0,7),
								);
							$this->M_masterpekerja->update($data);
						}
					}
					$this->session->set_flashdata('message', 'Record Not Found');
					$ses=array(
							 "success_import" => 1
						);
					$this->session->set_userdata($ses);
					unlink($file_path);
					// $delete = $this->db->query("delete from rec_master_pekerja where noind is null");
					redirect(site_url('PayrollManagement/MasterPekerja'));
		 }else{
			 redirect(site_url('PayrollManagement/MasterPekerja'));
		 }
    }

    public function importexist()
    {
        $noind = $this->input->post('txtNoind');
        $replace = $this->input->post('replace');
		$kd_hubungan_kerja = $this->input->post('txtKdHubunganKerja');
		$kd_status_kerja = $this->input->post('txtKdStatusKerja');
		$nik = $this->input->post('txtNik');
		$no_kk = $this->input->post('txtNoKk');
		$nama = $this->input->post('txtNama');
		$id_kantor_asal = $this->input->post('txtIdKantorAsal');
		$id_lokasi_kerja = $this->input->post('txtIdLokasiKerja');
		$jns_kelamin = $this->input->post('txtJnsKelamin');
		$tempat_lahir = $this->input->post('txtTempatLahir');
		$tgl_lahir = $this->input->post('txtTglLahir');
		$alamat = $this->input->post('txtAlamat');
		$desa = $this->input->post('txtDesa');
		$kecamatan = $this->input->post('txtKecamatan');
		$kabupaten = $this->input->post('txtKabupaten');
		$provinsi = $this->input->post('txtProvinsi');
		$kode_pos = $this->input->post('txtKodePos');
		$no_hp = $this->input->post('txtNoHp');
		$gelar_d = $this->input->post('txtGelarD');
		$gelar_b = $this->input->post('txtGelarB');
		$pendidikan = $this->input->post('txtPendidikan');
		$jurusan = $this->input->post('txtJurusan');
		$sekolah = $this->input->post('txtSekolah');
		$stat_nikah = $this->input->post('txtStatNikah');
		$tgl_nikah = $this->input->post('txtTglNikah');
		$jml_anak = $this->input->post('txtJmlAnak');
		$jml_sdr = $this->input->post('txtJmlSdr');
		$diangkat = $this->input->post('txtDiangkat');
		$masuk_kerja = $this->input->post('txtMasukKerja');
		$kodesie = $this->input->post('txtKodesie');
		$gol_kerja = $this->input->post('txtGolKerja');
		$kd_asal_outsourcing = $this->input->post('txtKdAsalOutsourcing');
		$kd_jabatan = $this->input->post('txtKdJabatan');
		$jabatan = $this->input->post('txtJabatan');
		$npwp = $this->input->post('txtNpwp');
		$no_kpj = $this->input->post('txtNoKpj');
		$lm_kontrak = $this->input->post('txtLmKontrak');
		$akh_kontrak = $this->input->post('txtAkhKontrak');
		$stat_pajak = $this->input->post('txtStatPajak');
		$jt_anak = $this->input->post('txtJtAnak');
		$jt_bkn_anak = $this->input->post('txtJtBknAnak');
		$tgl_spsi = $this->input->post('txtTglSpsi');
		$no_spsi = $this->input->post('txtNoSpsi');
		$tgl_kop = $this->input->post('txtTglKop');
		$no_koperasi = $this->input->post('txtNoKoperasi');
		$keluar = $this->input->post('txtKeluar');
		$tgl_keluar = $this->input->post('txtTglKeluar');
		$kd_pkj = $this->input->post('txtKdPkj');
		$angg_jkn = $this->input->post('txtAnggJkn');

    	$i=0;
    	foreach($noind as $loop){
				$data_exist[$i] = array(
					'noind' 			=> $noind[$i],
					'kd_hubungan_kerja' => $kd_hubungan_kerja[$i],
					'kd_status_kerja' 	=> $kd_status_kerja[$i],
					'nik' 				=> $nik[$i],
					'no_kk' 			=> $no_kk[$i],
					'nama' 				=> $nama[$i],
					'id_kantor_asal' 	=> $id_kantor_asal[$i],
					'id_lokasi_kerja' 	=> $id_lokasi_kerja[$i],
					'jns_kelamin' 		=> $jns_kelamin[$i],
					'tempat_lahir' 		=> $tempat_lahir[$i],
					'tgl_lahir' 		=> $tgl_lahir[$i],
					'alamat' 			=> $alamat[$i],
					'desa'				=> $desa[$i],
					'kecamatan' 		=> $kecamatan[$i],
					'kabupaten' 		=> $kabupaten[$i],
					'provinsi' 			=> $provinsi[$i],
					'kode_pos' 			=> $kode_pos[$i],
					'no_hp' 			=> $no_hp[$i],
					'gelar_d' 			=> $gelar_d[$i],
					'gelar_b' 			=> $gelar_b[$i],
					'pendidikan' 		=> $pendidikan[$i],
					'jurusan' 			=> $jurusan[$i],
					'sekolah' 			=> $sekolah[$i],
					'stat_nikah' 		=> $stat_nikah[$i],
					'tgl_nikah' 		=> $tgl_nikah[$i],
					'jml_anak' 			=> $jml_anak[$i],
					'jml_sdr' 			=> $jml_sdr[$i],
					'diangkat' 			=> $diangkat[$i],
					'masuk_kerja' 		=> $masuk_kerja[$i],
					'kodesie' 			=> $kodesie[$i],
					'gol_kerja' 		=> $gol_kerja[$i],
					'kd_asal_outsourcing' => $kd_asal_outsourcing[$i],
					'kd_jabatan' 		=> $kd_jabatan[$i],
					'jabatan' 			=> $jabatan[$i],
					'npwp' 				=> $npwp[$i],
					'no_kpj' 			=> $no_kpj[$i],
					'lm_kontrak' 		=> $lm_kontrak[$i],
					'akh_kontrak' 		=> $akh_kontrak[$i],
					'stat_pajak' 		=> $stat_pajak[$i],
					'jt_anak' 			=> $jt_anak[$i],
					'jt_bkn_anak' 		=> $jt_bkn_anak[$i],
					'tgl_spsi' 			=> $tgl_spsi[$i],
					'no_spsi' 			=> $no_spsi[$i],
					'tgl_kop' 			=> $tgl_kop[$i],
					'no_koperasi' 		=> $no_koperasi[$i],
					'keluar' 			=> $keluar[$i],
					'tgl_keluar' 		=> $tgl_keluar[$i],
					'kd_pkj'			=> $kd_pkj[$i],
					'angg_jkn' 			=> $angg_jkn[$i],
				);

				if($replace[$i] == 'yes'){
					$id = $noind[$i];
					$this->M_masterpekerja->delete($noind[$i]);
					$this->M_masterpekerja->insert($data_exist[$i]);
				}else{

				}

				$i++;
			}
			redirect(site_url('PayrollManagement/MasterPekerja'));

    }

	 // public function upload() {

        // $config['upload_path'] = 'assets/upload/importPR/masterPekerja/';
        // $config['file_name'] = 'MasterPekerja-'.time();
        // $config['allowed_types'] = 'csv';
        // $config['max_size'] = '1000';
        // $this->load->library('upload', $config);

        // if (!$this->upload->do_upload('importfile')) {
            // echo $this->upload->display_errors();
        // }
        // else {
            // $file_data  = $this->upload->data();
            // $filename   = $file_data['file_name'];
            // $file_path  = 'assets/upload/importPR/MasterPekerja/'.$file_data['file_name'];

            // if ($this->csvimport->get_array($file_path)){
                // $data = $this->csvimport->get_array($file_path);
                // $this->import($data, $filename);
            // }
            // else {
                // $this->import($data = array(), $filename = '');
            // }
        // }
    // }

	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ IMPORT V1 ++++++++++++++++++++++++++++++++++++++++++++

    public function checkSession(){
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }

	public function getNoind(){
		$string = strtoupper($this->input->get('term'));
		$data = $this->M_masterpekerja->get_noind($string);
		echo json_encode($data);
	}

    public function formValidation()
    {
	}

}

/* End of file C_MasterPekerja.php */
/* Location: ./application/controllers/PayrollManagement/MasterPekerja/C_MasterPekerja.php */
/* Generated automatically on 2016-11-26 11:32:52 */
