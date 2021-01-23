<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Upload extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('UpdateCov/M_update');

        $this->checkSession();
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
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Upload Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);



        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('UpdateCov/V_Upload');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function Upload()
    {

        $user_id = $this->session->userid;

        $data['Title'] = 'Upload Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


        $head_id = $this->M_update->get_header_id();
        $created_by = $this->session->user;
        $nama = $_POST['nm_slide_show'];
        $cek = explode(" ", $nama);
        $c = count($cek);

        if ($c > 1) {
            $data['er'] = 'Mohon Cek Input Nama';
            $this->load->view('V_Header', $data);
            $this->load->view('V_Sidemenu', $data);
            $this->load->view('UpdateCov/V_Error', $data);
            $this->load->view('V_Footer', $data);
        } else {
            $this->M_update->InsertIdSlideShow($head_id[0]['NEXTVAL'], $nama, $created_by);
            $temp_name = $_FILES['gambarCov']['tmp_name'];
            $j = 1;
            for ($i = 0; $i < sizeof($temp_name); $i++) {
                $img = $_FILES['gambarCov']['name'][$i];
                $imge = explode(".", $img);
                $filename = "assets/upload/KHS_SLIDE_SHOW/" . $imge[0] . $j . '.' . $imge[1];
                if (file_exists($filename)) {
                    move_uploaded_file($temp_name[$i], $filename);
                } else {
                    move_uploaded_file($temp_name[$i], $filename);
                }
                $this->M_update->InsertIdSlideShowLine($head_id[0]['NEXTVAL'], $filename);
                $j++;
            }
            $data['namaa'] = $nama;
            $this->load->view('V_Header', $data);
            $this->load->view('V_Sidemenu', $data);
            $this->load->view('UpdateCov/V_Success', $data);
            $this->load->view('V_Footer', $data);
        }

        // redirect('Slide/Show/Name/' . $nama);
    }
}
