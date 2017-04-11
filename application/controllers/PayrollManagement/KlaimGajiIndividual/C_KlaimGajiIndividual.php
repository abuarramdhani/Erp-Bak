<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_KlaimGajiIndividual extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/KlaimGajiIndividual/M_klaimgajiindividual');
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
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KlaimGajiIndividual/V_index', $data);
        $this->load->view('V_Footer',$data);
    }
	
	public function search()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
		$periode = $this->input->post('txtPeriodeHitung',TRUE);
		$year	 = substr($periode,0,4);
		$month	 = substr($periode,5,2);
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $KlaimGajiIndividual = $this->M_KlaimGajiIndividual->get_all($year,$month);

        $data['KlaimGajiIndividual_data'] = $KlaimGajiIndividual;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KlaimGajiIndividual/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_KlaimGajiIndividual->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_gajian_personalia' => $row->id_gajian_personalia,
				'tanggal' => $row->tanggal,
				'noind' => $row->noind,
				'kd_hubungan_kerja' => $row->kd_hubungan_kerja,
				'kd_status_kerja' => $row->kd_status_kerja,
				'kd_jabatan' => $row->kd_jabatan,
				'kodesie' => $row->kodesie,
				'ip' => $row->ip,
				'ik' => $row->ik,
				'i_f' => $row->i_f,
				'if_htg_bln_lalu' => $row->if_htg_bln_lalu,
				'ubt' => $row->ubt,
				'upamk' => $row->upamk,
				'um' => $row->um,
				'ims' => $row->ims,
				'imm' => $row->imm,
				'lembur' => $row->lembur,
				'htm' => $row->htm,
				'ijin' => $row->ijin,
				'htm_htg_bln_lalu' => $row->htm_htg_bln_lalu,
				'ijin_htg_bln_lalu' => $row->ijin_htg_bln_lalu,
				'pot' => $row->pot,
				'tamb_gaji' => $row->tamb_gaji,
				'hl' => $row->hl,
				'ct' => $row->ct,
				'putkop' => $row->putkop,
				'plain' => $row->plain,
				'pikop' => $row->pikop,
				'pspsi' => $row->pspsi,
				'putang' => $row->putang,
				'dl' => $row->dl,
				'tkpajak' => $row->tkpajak,
				'ttpajak' => $row->ttpajak,
				'pduka' => $row->pduka,
				'utambahan' => $row->utambahan,
				'btransfer' => $row->btransfer,
				'denda_ik' => $row->denda_ik,
				'p_lebih_bayar' => $row->p_lebih_bayar,
				'pgp' => $row->pgp,
				'tlain' => $row->tlain,
				'xduka' => $row->xduka,
				'ket' => $row->ket,
				'cicil' => $row->cicil,
				'ubs' => $row->ubs,
				'ubs_rp' => $row->ubs_rp,
				'p_um_puasa' => $row->p_um_puasa,
				'kd_jns_transaksi' => $row->kd_jns_transaksi,
				'kode_petugas' => $row->kode_petugas,
				'tgl_jam_record' => $row->tgl_jam_record,
				'kd_log_trans' => $row->kd_log_trans,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KlaimGajiIndividual/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KlaimGajiIndividual'));
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
            'action' => site_url('PayrollManagement/KlaimGajiIndividual/save'),
				'id_gajian_personalia' => set_value(''),
			'tanggal' => set_value('tanggal'),
			'noind' => set_value('noind'),
			'kd_hubungan_kerja' => set_value('kd_hubungan_kerja'),
			'kd_status_kerja' => set_value('kd_status_kerja'),
			'kd_jabatan' => set_value('kd_jabatan'),
			'kodesie' => set_value('kodesie'),
			'ip' => set_value('ip'),
			'ik' => set_value('ik'),
			'i_f' => set_value('i_f'),
			'if_htg_bln_lalu' => set_value('if_htg_bln_lalu'),
			'ubt' => set_value('ubt'),
			'upamk' => set_value('upamk'),
			'um' => set_value('um'),
			'ims' => set_value('ims'),
			'imm' => set_value('imm'),
			'lembur' => set_value('lembur'),
			'htm' => set_value('htm'),
			'ijin' => set_value('ijin'),
			'htm_htg_bln_lalu' => set_value('htm_htg_bln_lalu'),
			'ijin_htg_bln_lalu' => set_value('ijin_htg_bln_lalu'),
			'pot' => set_value('pot'),
			'tamb_gaji' => set_value('tamb_gaji'),
			'hl' => set_value('hl'),
			'ct' => set_value('ct'),
			'putkop' => set_value('putkop'),
			'plain' => set_value('plain'),
			'pikop' => set_value('pikop'),
			'pspsi' => set_value('pspsi'),
			'putang' => set_value('putang'),
			'dl' => set_value('dl'),
			'tkpajak' => set_value('tkpajak'),
			'ttpajak' => set_value('ttpajak'),
			'pduka' => set_value('pduka'),
			'utambahan' => set_value('utambahan'),
			'btransfer' => set_value('btransfer'),
			'denda_ik' => set_value('denda_ik'),
			'p_lebih_bayar' => set_value('p_lebih_bayar'),
			'pgp' => set_value('pgp'),
			'tlain' => set_value('tlain'),
			'xduka' => set_value('xduka'),
			'ket' => set_value('ket'),
			'cicil' => set_value('cicil'),
			'ubs' => set_value('ubs'),
			'ubs_rp' => set_value('ubs_rp'),
			'p_um_puasa' => set_value('p_um_puasa'),
			'kd_jns_transaksi' => set_value('kd_jns_transaksi'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_jam_record' => set_value('tgl_jam_record'),
			'kd_log_trans' => set_value('kd_log_trans'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KlaimGajiIndividual/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        else{
            $data = array(
				'tanggal' => $this->input->post('txtTanggal',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_hubungan_kerja' => $this->input->post('txtKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('txtKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('txtKdJabatan',TRUE),
				'kodesie' => $this->input->post('txtKodesie',TRUE),
				'ip' => $this->input->post('txtIp',TRUE),
				'ik' => $this->input->post('txtIk',TRUE),
				'i_f' => $this->input->post('txtIF',TRUE),
				'if_htg_bln_lalu' => $this->input->post('txtIfHtgBlnLalu',TRUE),
				'ubt' => $this->input->post('txtUbt',TRUE),
				'upamk' => $this->input->post('txtUpamk',TRUE),
				'um' => $this->input->post('txtUm',TRUE),
				'ims' => $this->input->post('txtIms',TRUE),
				'imm' => $this->input->post('txtImm',TRUE),
				'lembur' => $this->input->post('txtLembur',TRUE),
				'htm' => $this->input->post('txtHtm',TRUE),
				'ijin' => $this->input->post('txtIjin',TRUE),
				'htm_htg_bln_lalu' => $this->input->post('txtHtmHtgBlnLalu',TRUE),
				'ijin_htg_bln_lalu' => $this->input->post('txtIjinHtgBlnLalu',TRUE),
				'pot' => $this->input->post('txtPot',TRUE),
				'tamb_gaji' => $this->input->post('txtTambGaji',TRUE),
				'hl' => $this->input->post('txtHl',TRUE),
				'ct' => $this->input->post('txtCt',TRUE),
				'putkop' => $this->input->post('txtPutkop',TRUE),
				'plain' => $this->input->post('txtPlain',TRUE),
				'pikop' => $this->input->post('txtPikop',TRUE),
				'pspsi' => $this->input->post('txtPspsi',TRUE),
				'putang' => $this->input->post('txtPutang',TRUE),
				'dl' => $this->input->post('txtDl',TRUE),
				'tkpajak' => $this->input->post('txtTkpajak',TRUE),
				'ttpajak' => $this->input->post('txtTtpajak',TRUE),
				'pduka' => $this->input->post('txtPduka',TRUE),
				'utambahan' => $this->input->post('txtUtambahan',TRUE),
				'btransfer' => $this->input->post('txtBtransfer',TRUE),
				'denda_ik' => $this->input->post('txtDendaIk',TRUE),
				'p_lebih_bayar' => $this->input->post('txtPLebihBayar',TRUE),
				'pgp' => $this->input->post('txtPgp',TRUE),
				'tlain' => $this->input->post('txtTlain',TRUE),
				'xduka' => $this->input->post('txtXduka',TRUE),
				'ket' => $this->input->post('txtKet',TRUE),
				'cicil' => $this->input->post('txtCicil',TRUE),
				'ubs' => $this->input->post('txtUbs',TRUE),
				'ubs_rp' => $this->input->post('txtUbsRp',TRUE),
				'p_um_puasa' => $this->input->post('txtPUmPuasa',TRUE),
				'kd_jns_transaksi' => $this->input->post('txtKdJnsTransaksi',TRUE),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
				'kd_log_trans' => $this->input->post('txtKdLogTrans',TRUE),
			);

            $this->M_KlaimGajiIndividual->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/KlaimGajiIndividual'));
        }
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_KlaimGajiIndividual->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/KlaimGajiIndividual/saveUpdate'),
				'id_gajian_personalia' => set_value('txtIdGajianPersonalia', $row->id_gajian_personalia),
				'tanggal' => set_value('txtTanggal', $row->tanggal),
				'noind' => set_value('txtNoind', $row->noind),
				'kd_hubungan_kerja' => set_value('txtKdHubunganKerja', $row->kd_hubungan_kerja),
				'kd_status_kerja' => set_value('txtKdStatusKerja', $row->kd_status_kerja),
				'kd_jabatan' => set_value('txtKdJabatan', $row->kd_jabatan),
				'kodesie' => set_value('txtKodesie', $row->kodesie),
				'ip' => set_value('txtIp', $row->ip),
				'ik' => set_value('txtIk', $row->ik),
				'i_f' => set_value('txtIF', $row->i_f),
				'if_htg_bln_lalu' => set_value('txtIfHtgBlnLalu', $row->if_htg_bln_lalu),
				'ubt' => set_value('txtUbt', $row->ubt),
				'upamk' => set_value('txtUpamk', $row->upamk),
				'um' => set_value('txtUm', $row->um),
				'ims' => set_value('txtIms', $row->ims),
				'imm' => set_value('txtImm', $row->imm),
				'lembur' => set_value('txtLembur', $row->lembur),
				'htm' => set_value('txtHtm', $row->htm),
				'ijin' => set_value('txtIjin', $row->ijin),
				'htm_htg_bln_lalu' => set_value('txtHtmHtgBlnLalu', $row->htm_htg_bln_lalu),
				'ijin_htg_bln_lalu' => set_value('txtIjinHtgBlnLalu', $row->ijin_htg_bln_lalu),
				'pot' => set_value('txtPot', $row->pot),
				'tamb_gaji' => set_value('txtTambGaji', $row->tamb_gaji),
				'hl' => set_value('txtHl', $row->hl),
				'ct' => set_value('txtCt', $row->ct),
				'putkop' => set_value('txtPutkop', $row->putkop),
				'plain' => set_value('txtPlain', $row->plain),
				'pikop' => set_value('txtPikop', $row->pikop),
				'pspsi' => set_value('txtPspsi', $row->pspsi),
				'putang' => set_value('txtPutang', $row->putang),
				'dl' => set_value('txtDl', $row->dl),
				'tkpajak' => set_value('txtTkpajak', $row->tkpajak),
				'ttpajak' => set_value('txtTtpajak', $row->ttpajak),
				'pduka' => set_value('txtPduka', $row->pduka),
				'utambahan' => set_value('txtUtambahan', $row->utambahan),
				'btransfer' => set_value('txtBtransfer', $row->btransfer),
				'denda_ik' => set_value('txtDendaIk', $row->denda_ik),
				'p_lebih_bayar' => set_value('txtPLebihBayar', $row->p_lebih_bayar),
				'pgp' => set_value('txtPgp', $row->pgp),
				'tlain' => set_value('txtTlain', $row->tlain),
				'xduka' => set_value('txtXduka', $row->xduka),
				'ket' => set_value('txtKet', $row->ket),
				'cicil' => set_value('txtCicil', $row->cicil),
				'ubs' => set_value('txtUbs', $row->ubs),
				'ubs_rp' => set_value('txtUbsRp', $row->ubs_rp),
				'p_um_puasa' => set_value('txtPUmPuasa', $row->p_um_puasa),
				'kd_jns_transaksi' => set_value('txtKdJnsTransaksi', $row->kd_jns_transaksi),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_jam_record' => set_value('txtTglJamRecord', $row->tgl_jam_record),
				'kd_log_trans' => set_value('txtKdLogTrans', $row->kd_log_trans),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KlaimGajiIndividual/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KlaimGajiIndividual'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        if ($this->form_validation->run() == FALSE) {
            $this->update();
        }
        else{
            $data = array(
				'tanggal' => $this->input->post('txtTanggal',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'kd_hubungan_kerja' => $this->input->post('txtKdHubunganKerja',TRUE),
				'kd_status_kerja' => $this->input->post('txtKdStatusKerja',TRUE),
				'kd_jabatan' => $this->input->post('txtKdJabatan',TRUE),
				'kodesie' => $this->input->post('txtKodesie',TRUE),
				'ip' => $this->input->post('txtIp',TRUE),
				'ik' => $this->input->post('txtIk',TRUE),
				'i_f' => $this->input->post('txtIF',TRUE),
				'if_htg_bln_lalu' => $this->input->post('txtIfHtgBlnLalu',TRUE),
				'ubt' => $this->input->post('txtUbt',TRUE),
				'upamk' => $this->input->post('txtUpamk',TRUE),
				'um' => $this->input->post('txtUm',TRUE),
				'ims' => $this->input->post('txtIms',TRUE),
				'imm' => $this->input->post('txtImm',TRUE),
				'lembur' => $this->input->post('txtLembur',TRUE),
				'htm' => $this->input->post('txtHtm',TRUE),
				'ijin' => $this->input->post('txtIjin',TRUE),
				'htm_htg_bln_lalu' => $this->input->post('txtHtmHtgBlnLalu',TRUE),
				'ijin_htg_bln_lalu' => $this->input->post('txtIjinHtgBlnLalu',TRUE),
				'pot' => $this->input->post('txtPot',TRUE),
				'tamb_gaji' => $this->input->post('txtTambGaji',TRUE),
				'hl' => $this->input->post('txtHl',TRUE),
				'ct' => $this->input->post('txtCt',TRUE),
				'putkop' => $this->input->post('txtPutkop',TRUE),
				'plain' => $this->input->post('txtPlain',TRUE),
				'pikop' => $this->input->post('txtPikop',TRUE),
				'pspsi' => $this->input->post('txtPspsi',TRUE),
				'putang' => $this->input->post('txtPutang',TRUE),
				'dl' => $this->input->post('txtDl',TRUE),
				'tkpajak' => $this->input->post('txtTkpajak',TRUE),
				'ttpajak' => $this->input->post('txtTtpajak',TRUE),
				'pduka' => $this->input->post('txtPduka',TRUE),
				'utambahan' => $this->input->post('txtUtambahan',TRUE),
				'btransfer' => $this->input->post('txtBtransfer',TRUE),
				'denda_ik' => $this->input->post('txtDendaIk',TRUE),
				'p_lebih_bayar' => $this->input->post('txtPLebihBayar',TRUE),
				'pgp' => $this->input->post('txtPgp',TRUE),
				'tlain' => $this->input->post('txtTlain',TRUE),
				'xduka' => $this->input->post('txtXduka',TRUE),
				'ket' => $this->input->post('txtKet',TRUE),
				'cicil' => $this->input->post('txtCicil',TRUE),
				'ubs' => $this->input->post('txtUbs',TRUE),
				'ubs_rp' => $this->input->post('txtUbsRp',TRUE),
				'p_um_puasa' => $this->input->post('txtPUmPuasa',TRUE),
				'kd_jns_transaksi' => $this->input->post('txtKdJnsTransaksi',TRUE),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_jam_record' => date('Y-m-d H:i:s'),
				'kd_log_trans' => $this->input->post('txtKdLogTrans',TRUE),
			);

            $this->M_KlaimGajiIndividual->update($this->input->post('txtIdGajianPersonalia', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/KlaimGajiIndividual'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_KlaimGajiIndividual->get_by_id($id);

        if ($row) {
            $this->M_KlaimGajiIndividual->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/KlaimGajiIndividual'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KlaimGajiIndividual'));
        }
    }

    public function import() {
       
        $config['upload_path'] = 'assets/upload/importPR/klaimgajiindividual/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/klaimgajiindividual/'.$file_data['file_name'];
                
            if ($this->csvimport->get_array($file_path)) {
                
                $csv_array  = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
						$check = $this->M_KlaimGajiIndividual->check($row['ID']);
	                    if($check){
							 $data_update = array(
									'tanggal' 				=> $row['PERIODE'],
									'noind' 					=> $row['NOIND'],
									'kd_status_kerja' 	=> $row['STATUS_KER'],
									'kd_jabatan' 			=> str_replace("'","",$row['KODE_JABAT']),
									'kodesie' 				=> $row['KODESIE'],
									'ip' 					=> $row['IP'],
									'ik' 					=> $row['IK'],
									'i_f' 					=> $row['IF'],
									'if_htg_bln_lalu' 	=> $row['IF_BL_LALU'],
									'ubt' 					=> $row['UBT'],
									'upamk' 			=> $row['UPAMK'],
									'um' 					=> $row['UM'],
									'ims' 					=> $row['IMS'],
									'imm' 					=> $row['IMM'],
									'lembur' 				=> $row['LEMBUR'],
									'htm' 					=> $row['HTM'],
									'ijin' 					=> $row['IJIN'],
									'pot' 					=> $row['POT'],
									'tamb_gaji' 			=> $row['TAMB_GAJI'],
									'hl' 					=> $row['HL'],
									'ct' 					=> $row['CT'],
									'putkop' 				=> $row['PUTKOP'],
									'plain' 				=> $row['PLAIN'],
									'pikop' 				=> $row['PIKOP'],
									'pspsi' 				=> $row['PSPSI'],
									'putang' 				=> $row['PUTANG'],
									'dl' 					=> $row['DL'],
									'tkpajak' 				=> $row['TKPAJAK'],
									'ttpajak' 				=> $row['TTPAJAK'],
									'pduka' 				=> $row['PDUKA'],
									'utambahan' 			=> $row['UTAMBAHAN'],
									'btransfer' 			=> $row['BTRANSFER'],
									'denda_ik' 				=> $row['DENDA_IK'],
									'p_lebih_bayar' 		=> $row['P_LEBIH_BA'],
									'pgp' 					=> $row['PGP'],
									'tlain' 				=> $row['TLAIN'],
									'xduka' 				=> $row['XDUKA'],
									'ket' 					=> $row['KET'],
									'cicil' 				=> $row['CICIL'],
									'ubs'				 	=> $row['UBS'],
									'ubs_rp' 				=> $row['UBS_RP'],
									'p_um_puasa' 			=> $row['P_UM_PUASA'],
									'kd_jns_transaksi' 		=> $row['KD_JNS_TRA'],
									'noind_baru' 		=> $row['NOIND_BARU'],
									'kode_petugas' 			=> $this->session->userdata('userid'),
									'tgl_jam_record' 		=> date('Y-m-d H:i:s'),
								);
								$this->M_KlaimGajiIndividual->update($row['ID'],$data_update);
						}else{
							 $data = array(
									'id_gajian_personalia' 	=> $row['ID'],
									'tanggal' 				=> $row['PERIODE'],
									'noind' 					=> $row['NOIND'],
									'kd_status_kerja' 	=> $row['STATUS_KER'],
									'kd_jabatan' 			=> str_replace("'","",$row['KODE_JABAT']),
									'kodesie' 				=> $row['KODESIE'],
									'ip' 					=> $row['IP'],
									'ik' 					=> $row['IK'],
									'i_f' 					=> $row['IF'],
									'if_htg_bln_lalu' 	=> $row['IF_BL_LALU'],
									'ubt' 					=> $row['UBT'],
									'upamk' 			=> $row['UPAMK'],
									'um' 					=> $row['UM'],
									'ims' 					=> $row['IMS'],
									'imm' 					=> $row['IMM'],
									'lembur' 				=> $row['LEMBUR'],
									'htm' 					=> $row['HTM'],
									'ijin' 					=> $row['IJIN'],
									'pot' 					=> $row['POT'],
									'tamb_gaji' 			=> $row['TAMB_GAJI'],
									'hl' 					=> $row['HL'],
									'ct' 					=> $row['CT'],
									'putkop' 				=> $row['PUTKOP'],
									'plain' 				=> $row['PLAIN'],
									'pikop' 				=> $row['PIKOP'],
									'pspsi' 				=> $row['PSPSI'],
									'putang' 				=> $row['PUTANG'],
									'dl' 					=> $row['DL'],
									'tkpajak' 				=> $row['TKPAJAK'],
									'ttpajak' 				=> $row['TTPAJAK'],
									'pduka' 				=> $row['PDUKA'],
									'utambahan' 			=> $row['UTAMBAHAN'],
									'btransfer' 			=> $row['BTRANSFER'],
									'denda_ik' 				=> $row['DENDA_IK'],
									'p_lebih_bayar' 		=> $row['P_LEBIH_BA'],
									'pgp' 					=> $row['PGP'],
									'tlain' 				=> $row['TLAIN'],
									'xduka' 				=> $row['XDUKA'],
									'ket' 					=> $row['KET'],
									'cicil' 				=> $row['CICIL'],
									'ubs'				 	=> $row['UBS'],
									'ubs_rp' 				=> $row['UBS_RP'],
									'p_um_puasa' 			=> $row['P_UM_PUASA'],
									'kd_jns_transaksi' 		=> $row['KD_JNS_TRA'],
									'noind_baru' 		=> $row['NOIND_BARU'],
									'kode_petugas' 			=> $this->session->userdata('userid'),
									'tgl_jam_record' 		=> date('Y-m-d H:i:s'),
								);
								$this->M_KlaimGajiIndividual->insert($data);
						}
                }
                unlink($file_path);
                redirect(base_url().'PayrollManagement/KlaimGajiIndividual');

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

/* End of file C_KlaimGajiIndividual.php */
/* Location: ./application/controllers/PayrollManagement/DataHariMasuk/C_KlaimGajiIndividual.php */
/* Generated automatically on 2016-11-29 11:21:18 */