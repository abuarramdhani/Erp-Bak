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
		$this->load->library('Encrypt');
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Komp. Potongan/Tambahan Lain';
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
        
        $row = $this->M_komptamblain->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Komponen Penggajian',
            	'SubMenuOne' => 'Komp. Potongan/Tambahan Lain',
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
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTambLain'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Komponen Penggajian',
            'SubMenuOne' => 'Komp. Potongan/Tambahan Lain',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/KompTambLain/save'),
			'id_komp_pot_tam' => set_value(''),
			'tanggal' => set_value('tanggal'),
			'noind' => set_value('noind'),
			'tamb_lain' => set_value('tamb_lain'),
			'pot_lain' => set_value('pot_lain'),
			'ket' => set_value('ket'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompTambLain/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();
		$dt = explode("/",$this->input->post('txtPeriode',TRUE));
		$tgl_transaksi = $dt[1]."-".$dt[0]."-01";
            $data = array(
				'id_komp_pot_tam'	=> date('YmdHis'),
				'tanggal' => $tgl_transaksi,
				'noind' => $this->input->post('txtNoind',TRUE),
				'tamb_lain' => str_replace('.','',$this->input->post('txtTambahan',TRUE)),
				'pot_lain' => str_replace('.','',$this->input->post('txtPotongan',TRUE)),
				'ket' => $this->input->post('txtDesc',TRUE),
			);

            $this->M_komptamblain->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTambLain'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;
		
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_komptamblain->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Komponen Penggajian',
                'SubMenuOne' => 'Komp. Potongan/Tambahan Lain',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/KompTambLain/saveUpdate'),
				'id_komp_pot_tam' => set_value('txtId', $row->id_komp_pot_tam),
				'tanggal' => set_value('txtPeriode', date("m/Y",strtotime($row->tanggal))),
				'noind' => set_value('txtNoind', $row->noind),
				'pot_lain' => set_value('txtTambahan', number_format((int)$row->tamb_lain,0,",",".")),
				'tamb_lain' => set_value('txtPotongan', number_format((int)$row->pot_lain,0,",",".")),
				'ket' => set_value('txtDesc', $row->ket),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/KompTambLain/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
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
			$dt = explode("/",$this->input->post('txtPeriode',TRUE));
			$tgl_transaksi = $dt[1]."-".$dt[0]."-01";
            $data = array(
				'id_komp_pot_tam'	=> date('YmdHis'),
				'tanggal' => $tgl_transaksi,
				'noind' => $this->input->post('txtNoind',TRUE),
				'tamb_lain' => str_replace('.','',$this->input->post('txtTambahan',TRUE)),
				'pot_lain' => str_replace('.','',$this->input->post('txtPotongan',TRUE)),
				'ket' => $this->input->post('txtDesc',TRUE),
			);

            $this->M_komptamblain->update($this->input->post('txtId', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTambLain'));
        }
    }

    public function delete($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_komptamblain->get_by_id($id);
        if ($row) {
            $this->M_komptamblain->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/KompTambLain'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
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
		$this->form_validation->set_rules('txtTambahan', 'char');
	}

}

/* End of file C_KompTambLain.php */
/* Location: ./application/controllers/PayrollManagement/KomponenTambahan/C_KompTambLain.php */
/* Generated automatically on 2016-11-28 14:26:31 */