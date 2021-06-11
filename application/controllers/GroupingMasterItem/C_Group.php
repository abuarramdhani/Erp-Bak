<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Group extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        $this->load->library('session');
        $this->load->model('M_Index');
        $this->load->model('GroupingMasterItem/M_group');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) { } else {
            redirect();
        }
    }

    public function index()
    {
        $this->checkSession();

        $user_id = $this->session->userid;
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        
        $data['header'] = $this->M_group->get_data_group_header();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('GroupingMasterItem/V_index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function get_detail_group($header_id)
    {
        $this->checkSession();

        $user_id = $this->session->userid;

        $data['Menu'] = '';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['datas'] = $this->M_group->get_data_group_line($header_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('GroupingMasterItem/V_detail', $data);
        $this->load->view('V_Footer', $data);
    }

    public function input_group_item($id = null){
        $this->checkSession();

        $user_id = $this->session->userid;

        $data['Menu'] = '';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['action'] = 'input';
        if($id != null){
            $data['action'] = 'update';
        }

        if($id != null){
            $data['header'] = $this->M_group->get_data_group_header($id);
            $data['lines'] = $this->M_group->get_data_group_line($id);
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('GroupingMasterItem/V_input', $data);
        $this->load->view('V_Footer', $data);
    }

    public function get_data_items()
    {
        $code = $_POST['search'];
        $items = $this->M_group->get_data_items($code);
        echo json_encode($items);
    }

    public function save_data_items()
    {
        $user = $this->session->userdata['user'];

        if ($_POST['status'] == 'DELETE'){
            $this->M_group->delete_data_group($_POST['id'], 'header', 'header');
            $this->M_group->delete_data_group($_POST['id'], 'line', 'header');
        } else {
            $header = $_POST['header'];
            $lines = $_POST['lines'];
            $rm_lines = $_POST['rm_lines'];
            $action = $_POST['action'];
            $id = $_POST['id'];
            // $source = $_POST['source'];

            if($action == 'SAVE'){
                $header_id = $this->M_group->insert_data_group_header($header['group_name'], $header['description'], $user);
                $id = $header_id[0]['HEADER_ID'];
            } else if ($action == 'UPDATE'){
                $this->M_group->update_data_group_header($header['group_name'], $header['description'], $user, $id);
                foreach ($rm_lines as $key => $rm) {
                    $this->M_group->delete_data_group($rm, 'line', 'line');
                }
            }
            foreach ($lines as $key => $line) {
                if ($line != -1){
                    $this->M_group->insert_data_group_line($id, $line, $user);
                }
            }
        }

        echo 1;
    }

    public function input_excel()
    {
        $file = $_FILES['file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        $data['excel'] = array();
        $index = 0;

        foreach ($sheets as $key => $row) {
            $items = $this->M_group->get_detail_item($row['A']);
            $item = array(
                'item_code' => $row['A'],
                'desc' => $items[0]['DESCRIPTION'],
                'type' => $items[0]['TYPE_CODE'],
                'item_id' => $items[0]['ITEM_ID'],
            );
            array_push($data['excel'], $item);
            $index++;
        }

        $this->load->view('GroupingMasterItem/V_excel', $data);
    }
}
?>