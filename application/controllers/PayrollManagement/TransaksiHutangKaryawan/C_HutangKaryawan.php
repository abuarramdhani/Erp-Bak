<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_HutangKaryawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiHutangKaryawan/M_hutangkaryawan');
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
        $hutangKaryawan = $this->M_hutangkaryawan->get_all();

        $data['hutangKaryawan_data'] = $hutangKaryawan;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/HutangKaryawan/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_hutangkaryawan->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'no_hutang' => $row->no_hutang,
				'noind' => $row->noind,
				'tgl_pengajuan' => $row->tgl_pengajuan,
				'total_hutang' => $row->total_hutang,
				'jml_cicilan' => $row->jml_cicilan,
				'status_lunas' => $row->status_lunas,
				'kode_petugas' => $row->kode_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/HutangKaryawan/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/HutangKaryawan'));
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
            'action' => site_url('PayrollManagement/HutangKaryawan/save'),
				'no_hutang' => set_value(''),
			'noind' => set_value('noind'),
			'tgl_pengajuan' => set_value('tgl_pengajuan'),
			'total_hutang' => set_value('total_hutang'),
			'jml_cicilan' => set_value('jml_cicilan'),
			'status_lunas' => set_value('status_lunas'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_record' => set_value('tgl_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/HutangKaryawan/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

		$data = array(
			'no_hutang' => $this->input->post('txtNoHutangNew',TRUE),
			'noind' => $this->input->post('txtNoind',TRUE),
			'tgl_pengajuan' => $this->input->post('txtTglPengajuan',TRUE),
			'total_hutang' => $this->input->post('txtTotalHutang',TRUE),
			'jml_cicilan' => $this->input->post('txtJmlCicilan',TRUE),
			'status_lunas' => $this->input->post('cmbStatusLunas',TRUE),
			'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
			'tgl_record' => date('Y-m-d H:i:s'),
		);

        $this->M_hutangkaryawan->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/HutangKaryawan'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_hutangkaryawan->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/HutangKaryawan/saveUpdate'),
				'no_hutang' => set_value('txtNoHutang', $row->no_hutang),
				'noind' => set_value('txtNoind', $row->noind),
				'tgl_pengajuan' => set_value('txtTglPengajuan', $row->tgl_pengajuan),
				'total_hutang' => set_value('txtTotalHutang', $row->total_hutang),
				'jml_cicilan' => set_value('txtJmlCicilan', $row->jml_cicilan),
				'status_lunas' => set_value('txtStatusLunas', $row->status_lunas),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_record' => set_value('txtTglRecord', $row->tgl_record),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/HutangKaryawan/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/HutangKaryawan'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();

        $data = array(
			'no_hutang' => $this->input->post('txtNoHutangNew',TRUE),
			'noind' => $this->input->post('txtNoind',TRUE),
			'tgl_pengajuan' => $this->input->post('txtTglPengajuan',TRUE),
			'total_hutang' => $this->input->post('txtTotalHutang',TRUE),
			'jml_cicilan' => $this->input->post('txtJmlCicilan',TRUE),
			'status_lunas' => $this->input->post('cmbStatusLunas',TRUE),
			'kode_petugas' => $this->input->post('txtKodePetugas',TRUE),
			'tgl_record' => $this->input->post('txtTglRecord',TRUE),
		);

        $this->M_hutangkaryawan->update($this->input->post('txtNoHutang', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('PayrollManagement/HutangKaryawan'));
        
    }

    public function delete($id)
    {
        $row = $this->M_hutangkaryawan->get_by_id($id);

        if ($row) {
            $this->M_hutangkaryawan->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/HutangKaryawan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/HutangKaryawan'));
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

/* End of file C_HutangKaryawan.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiHutangKaryawan/C_HutangKaryawan.php */
/* Generated automatically on 2016-12-01 11:08:18 */