<?php
defined('BASEPATH') or exit('tidak ada sistem yang aman');

class C_Batch extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SystemAdministration/MainMenu/M_batch');
    }

    // @return render view
    function index()
    {
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('SystemAdministration/MainMenu/M_responsibility');
        $this->load->model('SystemAdministration/MainMenu/M_menu');

        $user_id = $this->session->userid;

        $data['Menu'] = 'User';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SystemAdministration/MainMenu/Batch/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    // @params POST
    // @return echo boolean
    function addResponsibility()
    {
        $params = [
            'noind' => $this->input->post('noind'), // array
            'inet'  => $this->input->post('inet'), // 1 / 0
            'local' => $this->input->post('local'),
            'res_id' => $this->input->post('res_id'), // example: 1289
        ];
        $btn_val = $this->input->post('btn_val');
        if ($btn_val == 'addRespo') {
            echo $this->M_batch->addResponsbility($params) ? json_encode(array(
                'success' => true,
                'message' => "Sukses menambahkan responsbility"
            )) : json_encode(array(
                'success' => false,
                'message' => "Terjadi kesalahan"
            ));
        } else {
            $noind = str_replace(" ", "', '", $params['noind']);
            echo $this->M_batch->deleteResponsbility($noind, $params['res_id']) ? json_encode(array(
                'success' => true,
                'message' => "Sukses menghapus responsbility"
            )) : json_encode(array(
                'success' => false,
                'message' => "Terjadi kesalahan"
            ));
        }
    }

    // @params GET
    // @return json
    function preview_person()
    {
        if (!isset($_GET['noind'])) {
            echo json_encode(array(
                'success' => false,
                'data' => null
            ));
            return false;
        }

        $noind = $_GET['noind'];

        $params = array(
            'noind' => $noind
        );

        $preview = $this->M_batch->preview_person($params);

        $result = array(
            'success' => $preview ? true : false,
            'data' => $preview
        );

        echo json_encode($result);
    }

    // @return json
    function getResponsbility()
    {
        $this->load->model('SystemAdministration/MainMenu/M_responsibility');
        $data = $this->M_responsibility->getResponsibility();

        echo json_encode($data);
    }
}
