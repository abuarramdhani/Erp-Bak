<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiHutang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiHutang/M_transaksihutang');
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
		$id = $this->input->get('id');
        $transaksiHutang = $this->M_transaksihutang->get_all($id);

        $data['transaksiHutang_data'] = $transaksiHutang;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHutang/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_transaksihutang->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_transaksi_hutang' => $row->id_transaksi_hutang,
				'no_hutang' => $row->no_hutang,
				'tgl_transaksi' => $row->tgl_transaksi,
				'jenis_transaksi' => $row->jenis_transaksi,
				'jumlah_transaksi' => $row->jumlah_transaksi,
				'lunas' => $row->lunas,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiHutang/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
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
			'pr_jns_transaksi_data' => $this->M_transaksihutang->get_pr_jns_transaksi_data(),
            'action' => site_url('PayrollManagement/TransaksiHutang/save'),
			
			'id_transaksi_hutang' => set_value(''),
			'no_hutang' => set_value('no_hutang'),
			'tgl_transaksi' => set_value('tgl_transaksi'),
			'jenis_transaksi' => set_value('jenis_transaksi'),
			'jumlah_transaksi' => set_value('jumlah_transaksi'),
			'lunas' => set_value('lunas'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHutang/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
		$data = array(
			'id_transaksi_hutang' => $this->input->post('txtIdTransaksiHutangNew',TRUE),
			'no_hutang' => $this->input->post('txtNoHutang',TRUE),
			'tgl_transaksi' => $this->input->post('txtTglTransaksi',TRUE),
			'jenis_transaksi' => $this->input->post('cmbJenisTransaksi',TRUE),
			'jumlah_transaksi' => $this->input->post('txtJumlahTransaksi',TRUE),
			'lunas' => $this->input->post('cmbLunas',TRUE),
		);

        $this->M_transaksihutang->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/TransaksiHutang'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_transaksihutang->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
				'pr_jns_transaksi_data' => $this->M_transaksihutang->get_pr_jns_transaksi_data(),
                'action' => site_url('PayrollManagement/TransaksiHutang/saveUpdate'),

				'id_transaksi_hutang' => set_value('cmbIdTransaksiHutang', $row->id_transaksi_hutang),
				'no_hutang' => set_value('cmbNoHutang', $row->no_hutang),
				'tgl_transaksi' => set_value('cmbTglTransaksi', $row->tgl_transaksi),
				'jenis_transaksi' => set_value('cmbJenisTransaksi', $row->jenis_transaksi),
				'jumlah_transaksi' => set_value('cmbJumlahTransaksi', $row->jumlah_transaksi),
				'lunas' => set_value('cmbLunas', $row->lunas),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiHutang/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();
        $data = array(
			'id_transaksi_hutang' => $this->input->post('txtIdTransaksiHutangNew',TRUE),
			'no_hutang' => $this->input->post('txtNoHutang',TRUE),
			'tgl_transaksi' => $this->input->post('txtTglTransaksi',TRUE),
			'jenis_transaksi' => $this->input->post('cmbJenisTransaksi',TRUE),
			'jumlah_transaksi' => $this->input->post('txtJumlahTransaksi',TRUE),
			'lunas' => $this->input->post('cmbLunas',TRUE),
		);

        $this->M_transaksihutang->update($this->input->post('txtIdTransaksiHutang', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		redirect(site_url('PayrollManagement/TransaksiHutang'));
    }

    public function delete($id)
    {
        $row = $this->M_transaksihutang->get_by_id($id);

        if ($row) {
            $this->M_transaksihutang->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
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

/* End of file C_TransaksiHutang.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiHutang/C_TransaksiHutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */