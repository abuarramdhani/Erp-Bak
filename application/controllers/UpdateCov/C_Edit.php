<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Edit extends CI_Controller
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

        $data['Title'] = 'Edit';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $ind = $this->session->user;
        $data['ToEdit'] = $this->M_update->dataToEdit($ind);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('UpdateCov/V_Edit', $data);
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function Inactive()
    {
        $id = $this->input->post('i');
        $this->M_update->inactiveSlide($id);
    }
    public function Active()
    {
        $id = $this->input->post('i');
        $this->M_update->ActiveSlide($id);
    }
    public function EditGambar($w)
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Edit';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $img = $this->M_update->getImg($w);

        $data['img'] = $img;
        $data['w'] = $w;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('UpdateCov/V_EditImg', $data);
        $this->load->view('V_Footer', $data);
    }
    public function SaveImgEdit($i)
    {
        $e = explode('-', $i);

        $u = $this->input->post('urutanImgbaru' . $e[1]);

        $img = $_FILES['edImg' . $e[1]]['name'];
        $imge = explode(".", $img);

        $temp_name = $_FILES['edImg' . $e[1]]['tmp_name'];

        $filename = "assets/upload/KHS_SLIDE_SHOW/" . $imge[0] . $u . '.' . $imge[1];

        if (file_exists($filename)) {
            move_uploaded_file($temp_name, $filename);
        } else {
            move_uploaded_file($temp_name, $filename);
        }

        $this->M_update->InsertIdSlideShowLine($e[0], $filename);

        redirect('Slideshow/EditData/EditGambar/' . $e[0]);
    }
    public function ModalUpImg()
    {
        $line = $this->input->post('line_id');
        $urutan = $this->input->post('urutan');

        echo '
        <form name="Orderform" class="form-horizontal" action="' . base_url('Slideshow/EditData/UpdateImg') . '" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
           <input type="hidden" value="' . $line . '" name="lineeee">
           <input type="hidden" value="' . $urutan . '" name="urrrr">
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Img</label></div>
                <div class="col-md-4">
                    <input type="file" class="form-control" accept= ".png,.jpg,.jpeg" name="ImEdit">
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12" style="text-align:center"><button class="btn btn-success">Update</button></div>
            </div>
        </form>
        ';
    }
    public function UpdateImg()
    {
        $line = $this->input->post('lineeee');
        $urutan = $this->input->post('urrrr');

        $imgtodelete = $this->M_update->getImgtoDelete($line);
        unlink($imgtodelete[0]['FILE_DIR_ADDRESS']);


        $temp_name = $_FILES['ImEdit']['tmp_name'];
        $img = $_FILES['ImEdit']['name'];
        $imge = explode(".", $img);
        $filename = "assets/upload/KHS_SLIDE_SHOW/" . $imge[0] . $urutan . '.' . $imge[1];

        if (file_exists($filename)) {
            move_uploaded_file($temp_name, $filename);
        } else {
            move_uploaded_file($temp_name, $filename);
        }

        $this->M_update->UpdateGambar($filename, $line);


        redirect('Slideshow/EditData');
    }
    public function InactiveImg()
    {
        $line = $this->input->post('i');
        $this->M_update->inactiveGambar($line);
    }
    public function ActiveImg()
    {
        $line = $this->input->post('i');
        $this->M_update->ActiveGambar($line);
    }
    public function HapusImg()
    {
        $line = $this->input->post('i');
        $imgtodelete = $this->M_update->getImgtoDelete($line);
        unlink($imgtodelete[0]['FILE_DIR_ADDRESS']);
        $this->M_update->DeleteImg($line);
    }
    public function HapusSlideShow()
    {
        $head_id = $this->input->post('i');
        $imgtodelete = $this->M_update->getImgtoDelete2($head_id);
        for ($i = 0; $i < sizeof($imgtodelete); $i++) {
            unlink($imgtodelete[$i]['FILE_DIR_ADDRESS']);
        }
        $this->M_update->DeleteHeader($head_id);
        $this->M_update->DeleteLine($head_id);
    }
}
