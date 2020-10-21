<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Requestjenis extends CI_Controller
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
        $this->load->model('DbHandling/M_dbhandling');

        $this->checkSession();
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('index');
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Request';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('DbHandling/SEKSI/V_RequestJenisHandling');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function loadviewreqjns()
    {
        $req = $this->M_dbhandling->selectreqmasterhandling();
        $data['req'] = $req;
        $this->load->view('DbHandling/SEKSI/V_TblReqMastHand', $data);
    }
    public function ViewAddMasterhandling()
    {
        $tambahmasterhandling = '
                <div class="panel-body">                            
                    <div class="col-md-5" style="text-align: right;"><label>Nama Handling</label></div>                                        
                    <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" name="namahandling" id="namaahandling" class="form-control" /></div>
                </div>
                <div class="panel-body">                            
                    <div class="col-md-5" style="text-align: right;"><label>Kode Handling</label></div>                                        
                    <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" name="kodehandling" id="kodeehandling" class="form-control" /><span style="display:none;color:red;font-size:9pt" id="keterangansimbole">*Kode Handling tersebut sudah digunakan</span></div>
                    <div class="col-md-2" style="text-align: left;"id="simbolverifykod" ></div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="text-align:right"><button class="btn btn-success buttonnsave" disabled="disabled">Save</button></div>
                </div>';

        echo $tambahmasterhandling;
    }
    public function insertmasterhandling()
    {
        $namahandling = $this->input->post('namahandling');
        $kodehandling = $this->input->post('kodehandling');
        $requester = $this->session->user;
        $tgl_request = date('Y-m-d');

        $this->M_dbhandling->insertreqhandling($namahandling, $kodehandling, $requester, $tgl_request);
    }
    public function deletereqmashand()
    {
        $id = $this->input->post('id');
        $this->M_dbhandling->deletereqmashand($id);
    }
}
