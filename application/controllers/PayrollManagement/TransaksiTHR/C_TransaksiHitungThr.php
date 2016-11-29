<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiHitungThr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
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
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $transaksiHitungThr = $this->M_transaksihitungthr->get_all();

        $data['transaksiHitungThr_data'] = $transaksiHitungThr;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHitungThr/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_transaksihitungthr->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
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
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
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

            $this->M_transaksihitungthr->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_transaksihitungthr->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
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

        $this->M_transaksihitungthr->update($this->input->post('txtIdTransaksiThr', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('PayrollManagement/TransaksiHitungThr'));
    }

    public function delete($id)
    {
        $row = $this->M_transaksihitungthr->get_by_id($id);

        if ($row) {
            $this->M_transaksihitungthr->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHitungThr'));
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

/* End of file C_TransaksiHitungThr.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiTHR/C_TransaksiHitungThr.php */
/* Generated automatically on 2016-11-28 15:07:51 */