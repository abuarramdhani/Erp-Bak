<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Penalty extends CI_Controller
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
        $this->load->model('PenaltyCustomer/M_penalty');

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

        $data['Title'] = 'Daftar Customer Yang Memiliki Penalty';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PenaltyCustomer/V_List');
        $this->load->view('V_Footer', $data);
    }
    public function DataListVendor()
    {
        $penalty_vendor = $this->M_penalty->DataVendorPenalty();

        // echo "<pre>";
        // print_r($penalty_vendor);
        // exit();
        $data['penalty_vendor'] = $penalty_vendor;
        $this->load->view('PenaltyCustomer/V_TblList', $data);
    }
    public function Detail($relasi_id)
    {

        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Detail Penalty Customer';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['relasi'] = $relasi_id;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PenaltyCustomer/V_Detail', $data);
        $this->load->view('V_Footer', $data);
    }
    public function TblDetailRelasi()
    {
        $relasi_id = $_POST['relasi'];
        $penalty_detail = $this->M_penalty->DataVendorPenaltybyrelasiId($relasi_id);
        $total_penalty = array();
        for ($i = 0; $i < sizeof($penalty_detail); $i++) {
            array_push($total_penalty, $penalty_detail[$i]['NOMINAL_PENALTY']);
            $total = array_sum($total_penalty);
        }

        // echo "<pre>";
        // print_r($penalty_detail);
        // exit();

        $data['penalty_detail'] = $penalty_detail;
        $data['total_penalty'] = $total;

        $this->load->view('PenaltyCustomer/V_TblDetail', $data);
    }
    public function ModalSingleRecipt()
    {
        $inv_num = $_POST['inv_num'];
        $org = $_POST['org'];
        $bayar = $_POST['bayar'];

        $view = '
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Recipt Date</label></div>
                <div class="col-md-5"><input type="text" id="datpckrrcptdate" name="datpckrrcptdate" class="form-control"></div>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Recipt Method</label></div>
                <div class="col-md-5">
                    <select class="form-control" style="width:100%" id="SlcrcptMthd" name="SlcrcptMthd" data-placeholder="Select">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Nominal Recipt</label></div>
                <div class="col-md-5"><input name="nom_recipt[]" type="text" value="' . $bayar . '" class="form-control"></div>
                <input type="hidden" name="inv_num[]" value="' . $inv_num . '">
                <input type="hidden" name="org_id[]" value="' . $org . '">

            </div>
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Comments</label></div>
                <div class="col-md-5"><textarea name="commentsnyaa" class="form-control"></textarea></div>
            </div>
            <div class="panel-body">
                <div class="col-md-12" style="text-align:right">
                    <button class="btn btn-primary" onclick="CreateMiscRecipt()">OK</button>
                </div>
            </div>
        ';
        echo $view;
    }
    public function SelectReciptMethod()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        if ($term != NULL || $term != "") {
            $data = $this->M_penalty->ReciptMethod($term);
        }
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function CreateMiscRecipt()
    {
        $inv_num = $_POST['inv_num'];
        $org_id = $_POST['org_id'];
        $nom_recipt = $_POST['nom_recipt'];
        $recipt_method = $_POST['recipt_method'];
        $receipt_date = $_POST['receipt_date'];
        $comments = $_POST['comments'];
        $induk = $this->session->user;
        // $induk = 'B0661';

        // echo "<pre>";
        // print_r($_POST);
        // exit();
        // $responses = '';
        $responses = array();

        for ($i = 0; $i < sizeof($inv_num); $i++) {
            $hasil = $this->M_penalty->CreateMiscRecipt($inv_num[$i], $org_id[$i], $nom_recipt[$i], $recipt_method[0], $receipt_date[0], $comments[0], $induk);
            array_push($responses, $hasil);
        }
        $tr = '';
        for ($u = 0; $u < sizeof($responses); $u++) {
            $tr .= '<tr><th class="text-center">' . $responses[$u] . '</th></tr>';
        }
        $view = '<table class="table table-bordered table-striped"><thead>' . $tr . '</thead></table>';

        echo $view;
    }
    public function ModalMultipleRecipt()
    {
        $inv_num = $_POST['inv_num'];
        $org = $_POST['org_id'];
        $bayar = $_POST['nom_penalty'];
        $hidden = "";
        for ($i = 0; $i < sizeof($inv_num); $i++) {
            $hidden .= '
            <input name="nom_recipt[]" type="hidden" value="' . $bayar[$i] . '">
            <input type="hidden" name="inv_num[]" value="' . $inv_num[$i] . '">
            <input type="hidden" name="org_id[]" value="' . $org[$i] . '">';
        }

        $view = '
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Recipt Date</label></div>
                <div class="col-md-5"><input type="text" id="datpckrrcptdate" name="datpckrrcptdate" class="form-control"></div>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Recipt Method</label></div>
                <div class="col-md-5">
                    <select class="form-control" style="width:100%" id="SlcrcptMthd" name="SlcrcptMthd" data-placeholder="Select">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="text-align:right"><label>Comments</label></div>
                <div class="col-md-5"><textarea name="commentsnyaa" class="form-control"></textarea></div>
            </div>
            ' . $hidden . '
            <div class="panel-body">
                <div class="col-md-12" style="text-align:right">
                    <button class="btn btn-primary" onclick="CreateMiscRecipt()">OK</button>
                </div>
            </div>
        ';
        echo $view;
    }
    public function SelectReciptMethod2()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        if ($term != NULL || $term != "") {
            $term = "where RECEIPT_METHOD_ID = $term or RECEIPT_METHOD = '$term'";
            $data = $this->M_penalty->ReciptMethod2($term);
        } else {
            $data = $this->M_penalty->ReciptMethod2($term);
        }
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
}
