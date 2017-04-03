<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_KompTambLain extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/KomponenTambahanLain/M_komptamblain');
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
        $KompTambLain = $this->M_komptamblain->get_all();

        $data['KompTambLain_data'] = $KompTambLain;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTambLain/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $row = $this->M_komptamblain->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Payroll Management',
            	'SubMenuOne' => '',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            
				'id_komp_pot_lain' => $row->id_komp_pot_tam,
				'tanggal' => $row->tanggal,
				'noind' => $row->noind,
				'tambahan' => $row->tamb_lain,
				'potongan' => $row->pot_lain,
				'stat' => $row->stat,
				'desc_' => $row->ket,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTambLain/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KompTambLain'));
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
            'action' => site_url('PayrollManagement/KompTambLain/save'),
				'id_komp_pot_lain' => set_value(''),
			'periode' => set_value('tanggal'),
			'pr_master_pekerja_data' => $this->M_komptamblain->get_pr_master_pekerja_data(),
			'noind' => set_value('noind'),
			'tambahan' => set_value('tamb_lain'),
			'potongan' => set_value('pot_lain'),
			'stat' => set_value('stat'),
			'desc_' => set_value('ket'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTambLain/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();

            $data = array(
				'id_komp_pot_tam'	=> date('YmdHis'),
				'tanggal' => $this->input->post('txtPeriode',TRUE),
				'noind' => $this->input->post('txtNoind',TRUE),
				'tamb_lain' => str_replace(',','',$this->input->post('txtTambahan',TRUE)),
				'pot_lain' => str_replace(',','',$this->input->post('txtPotongan',TRUE)),
				'ket' => $this->input->post('txtDesc',TRUE),
			);

            $this->M_komptamblain->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('PayrollManagement/KompTambLain'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_komptamblain->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Payroll Management',
                'SubMenuOne' => '',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/KompTambLain/saveUpdate'),
				'id_komp_pot_lain' => set_value('txtId', $row->id_komp_pot_tam),
				'periode' => set_value('txtPeriode', $row->tanggal),
				'noind' => set_value('txtNoind', $row->noind),
				'tambahan' => set_value('txtTambahan', $row->tamb_lain),
				'potongan' => set_value('txtPotongan',$row->pot_lain),
				'desc_' => set_value('txtDesc', $row->desc_),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTambLain/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KompTambLain'));
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
				'id_komp_pot_tam'	=> date('YmdHis'),
				'tanggal' => $this->input->post('txtPeriode',TRUE),
				'noind' => $this->input->post('cmbNoind',TRUE),
				'tamb_lain' => str_replace(',','',$this->input->post('txtTambahan',TRUE)),
				'pot_lain' => str_replace(',','',$this->input->post('txtPotongan',TRUE)),
				'ket' => $this->input->post('txtDesc',TRUE),
			);

            $this->M_komptamblain->update($this->input->post('txtId', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('PayrollManagement/KompTambLain'));
        }
    }

    public function delete($id)
    {
        $row = $this->M_komptamblain->get_by_id($id);

        if ($row) {
            $this->M_komptamblain->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/KompTambLain'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/KompTambLain'));
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
		// $this->form_validation->set_rules('txtTambahan', 'Tambahan', 'integer');
		// $this->form_validation->set_rules('txtDesc', 'Desc ', 'max_length[30]');
	}

}

/* End of file C_KompTambLain.php */
/* Location: ./application/controllers/PayrollManagement/KomponenTambahan/C_KompTambLain.php */
/* Generated automatically on 2016-11-28 14:26:31 */