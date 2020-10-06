<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('JembatanTimbang/M_index');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('');
        }
    }

    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $data['show'] = $this->M_outpart->getAllIn();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JembatanTimbang/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function History()
    {
        $this->checkSession();
        $user_id             = $this->session->userid;
        $data['username']    = $this->session->user;
        $passwordArr         = $this->db->get_where('sys.sys_user', ['user_id' => $user_id])->row_array();
        $data['password']    = $passwordArr['user_password'];

        $data['Menu'] = 'History Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        // $berat = explode(",",$this->input->post('berat1'));

        // $data['get'] = $this->db->where('weight !=', '')
        //                         ->where('weight_2 !=', '')
        //                         ->get('jti.jt_weight_histories')->result_array();

        $data['get'] = $this->db->select('
                              jti.jt_documents.id as document_id,
                              jti.jt_documents.document_number,
                              jti.jt_documents.estimation,
                              jti.jt_documents.type,
                              jti.jt_document_type.name as document_type,
                              jti.jt_tickets_1.ticket_number as ticket_number,
                              jti.jt_tickets_1.vehicle_number,
                              jti.jt_tickets_1.created_by,
                              jti.jt_tickets_1.created_at,
                              jti.jt_tickets_1.driver_id as driver_id,
                              jti.jt_tickets_2.ticket_number as ticket_number_2,
                              jti.jt_drivers.name,
                              jti.jt_drivers.id as driver_id,
                              jti.jt_weight_histories.weight,
                              jti.jt_weight_histories.weight_2,
                              jti.jt_weight_histories.operator_name,
                            ')
                            ->join('jti.jt_tickets_1', 'jti.jt_tickets_1.document_id = jti.jt_documents.id', 'left')
                            ->join('jti.jt_tickets_2', 'jti.jt_tickets_2.ticket_number = jti.jt_tickets_1.ticket_number', 'left')
                            ->join('jti.jt_drivers', 'jti.jt_drivers.document_id = jti.jt_documents.id', 'left')
                            ->join('jti.jt_document_type', 'jti.jt_document_type.id = jti.jt_documents.document_type', 'left')
                            ->join('jti.jt_weight_histories', 'jti.jt_weight_histories.ticket_number = jti.jt_tickets_1.ticket_number', 'left')
                            ->where('jti.jt_weight_histories.weight !=', null)
                            ->order_by('jti.jt_documents.id', 'DESC')
                            ->get('jti.jt_documents')
                            ->result_array();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JembatanTimbang/V_History', $data);
        $this->load->view('V_Footer', $data);
    }

    public function Cetak()
    {
        $this->checkSession();
        $user_id             = $this->session->userid;
        $data['username']    = $this->session->user;
        $passwordArr         = $this->db->get_where('sys.sys_user', ['user_id' => $user_id])->row_array();
        $data['password']    = $passwordArr['user_password'];

        $data['Menu'] = 'Transaction Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        // $berat = explode(",",$this->input->post('berat1'));

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JembatanTimbang/V_Cetak', $data);
        $this->load->view('V_Footer', $data);
    }

}
