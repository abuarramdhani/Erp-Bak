<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');

include(APPPATH . 'third_party/phpseclib/Net/SSH2.php');
include(APPPATH . 'third_party/phpseclib/Net/SFTP.php');
include(APPPATH . 'third_party/phpseclib/Crypt/RSA.php');
include(APPPATH . 'third_party/phpseclib/Math/BigInteger.php');
include(APPPATH . 'third_party/phpseclib/Crypt/Hash.php');
include(APPPATH . 'third_party/phpseclib/Crypt/Random.php');
include(APPPATH . 'third_party/phpseclib/Crypt/Base.php');
include(APPPATH . 'third_party/phpseclib/Crypt/Rijndael.php');
include(APPPATH . 'third_party/phpseclib/Crypt/AES.php');
include(APPPATH . 'third_party/phpseclib/Crypt/Blowfish.php');
include(APPPATH . 'third_party/phpseclib/Crypt/DES.php');
include(APPPATH . 'third_party/phpseclib/Crypt/RC2.php');
include(APPPATH . 'third_party/phpseclib/Crypt/RC4.php');
include(APPPATH . 'third_party/phpseclib/Crypt/TripleDES.php');
include(APPPATH . 'third_party/phpseclib/Crypt/Twofish.php');

use phpseclib\Net\SFTP;

class C_Monspb extends CI_Controller
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
        $this->load->model('MonitoringSPB/M_monspb');

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

        $data['Title'] = 'Monitoring SPB';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $header = $this->M_monspb->ListSpb();

        // $data['header'] = $header;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringSPB/V_List', $data);
        $this->load->view('V_Footer', $data);
    }
    public function DetailSPB()
    {
        $spb = $this->input->post('s');
        $line = $this->M_monspb->DetailSpb($spb);

        // echo "<pre>";
        // print_r($line);
        // exit();

        $data['line'] = $line;

        $this->load->view('MonitoringSPB/V_DetailSPB', $data);
    }
    function selectIOSpb()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        if ($term == null) {
            $and = '';
        } else {
            $and = "WHERE ORGANIZATION_CODE like '%$term%'";
        }
        $data = $this->M_monspb->selectIO($and);

        echo json_encode($data);
    }
    public function getListSPB()
    {
        $recipt_date = $this->input->post('recipt_date');
        $io = $this->input->post('io');
        $status_transact = $this->input->post('status_transact');
        $status_interorg = $this->input->post('status_interorg');

        $and1 = null;
        $and2 = null;
        $and3 = null;
        $and4 = null;

        $where = null;

        if ($status_transact != null || $status_transact != "") {
            $where = "WHERE TRANSACT_STATUS = '$status_transact'";
        }
        if ($status_interorg != null || $status_interorg != "") {
            if ($where != null) {
                $where = $where . "AND INTERORG_STATUS = '$status_interorg'";
            } else {
                $where = "WHERE INTERORG_STATUS = '$status_interorg'";
            }
        }
        if ($io != null || $io != "") {
            if ($where != null) {
                $where = $where . "AND IO_TUJUAN = '$io'";
            } else {
                $where = "WHERE IO_TUJUAN = '$io'";
            }
        }
        if ($recipt_date != null || $recipt_date != "") {
            if ($recipt_date == 1) {
                if ($where != null) {
                    $where = $where . "AND TANGGAL_RECEIPT is NULL ";
                } else {
                    $where = "WHERE TANGGAL_RECEIPT is NULL";
                }
            } else {
                if ($where != null) {
                    $where = $where . "AND TANGGAL_RECEIPT is NOT NULL ";
                } else {
                    $where = "WHERE TANGGAL_RECEIPT is NOT NULL";
                }
            }
        }

        $header = $this->M_monspb->ListSpb($where);

        $sftp = new SFTP('produksi.quick.com');
        error_reporting(0);
        if (!$sftp->login('root', '123456')) {
            throw new Exception('Gagal melakukan autentikasi ke Server Produksi.');
        }

        $files = $sftp->nlist('/var/www/html/api-scanner-doc-satpam/assets/img/docsatpam', true);

        for ($i = 0; $i < count($files); $i++) {
            $info = pathinfo($files[$i]);
            $name = basename($files[$i], '.' . $info['extension']);
            $files[$i] = $name;
        }

        for ($i = 0; $i < count($header); $i++) {
            if (in_array($header[$i]['NO_SPB'], $files)) {
                $header[$i]['LINK'] = $header[$i]['NO_SPB'];
            } else {
                $header[$i]['LINK'] = '-';
            }
        }

        $data['header'] = $header;

        $this->load->view('MonitoringSPB/V_tbl_List', $data);

        // echo "<pre>";
        // print_r($header);
        // print_r($files);

        // exit();
    }
}
