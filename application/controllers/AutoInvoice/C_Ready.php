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

class C_Ready extends CI_Controller
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
        $this->load->model('AutoInvoice/M_autoinvoice');

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

        $data['Title'] = 'DO Ready To Ship Confirm';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('AutoInvoice/V_Ready', $data);
        // $this->load->view('AutoInvoice/V_Foot');
        $this->load->view('V_Footer', $data);
    }
    public function ListReady()
    {

        // FTP Connect
        $sftp = new SFTP('produksi.quick.com');
        error_reporting(0);
        if (!$sftp->login('root', '123456')) {
            throw new Exception('Gagal melakukan autentikasi ke Server Produksi.');
        }

        $files = $sftp->nlist('/var/www/html/api-scanner-doc-satpam/assets/img/docsatpam',true);
        $DoReady = $this->M_autoinvoice->DoReady();

        for ($i=0; $i < count($files); $i++) { 
            $info = pathinfo($files[$i]);
            $name = basename($files[$i],'.'.$info['extension']);
            $files[$i] = $name;
        }

        for ($i=0; $i < count($DoReady); $i++) { 
            if(in_array($DoReady[$i]['NO_SPB'], $files)){
                $DoReady[$i]['LINK'] = $DoReady[$i]['NO_SPB'];
            } else if (in_array($DoReady[$i]['NO_DO'], $files)){
                $DoReady[$i]['LINK'] = $DoReady[$i]['NO_DO'];
            } else {
                $DoReady[$i]['LINK'] = '-';
            }
        }

        $data['DoReady'] = $DoReady;

        $this->load->view('AutoInvoice/V_ListReady', $data);
        // $this->load->view('AutoInvoice/V_Foot');
    }
    public function ListDetailDo()
    {
        $do = $_POST['do'];
        $DetailDO = $this->M_autoinvoice->DetailDO($do);

        $data['DetailDO'] = $DetailDO;

        $this->load->view('AutoInvoice/V_ListDetailDO', $data);
    }
    public function InsertProcessDO()
    {
        $do = $_POST['do'];

        // echo "<pre>";
        // print_r($do);
        // exit();
        $induk = $this->session->user;
        for ($i = 0; $i < sizeof($do); $i++) {
            $this->M_autoinvoice->InsertProcessDO($induk, $do[$i]);
        }
    }
}
