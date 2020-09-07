<?php if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
/*
 * 
 */

class C_RekapSeksi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('form_validation');
        $this->load->library('session');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PerizinanPribadi/M_index');
        $this->load->model('ADMCabang/M_presensiharian');
        $this->load->model('ADMSeleksi/M_penyerahan');

        $this->checkSession();
        date_default_timezone_set('Asia/Jakarta');
    }

    /* CHECK SESSION */
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
        $user = $this->session->username;
        $user_id = $this->session->userid;
        $no_induk = $this->session->user;
        $kodesie = $this->session->kodesie;

        $data['Title'] = 'Rekap Perizinan Seksi';
        $data['Menu'] = 'Izin Pribadi';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $aksesRahasia = $this->M_index->allowedAccess('1');
        $paramedik = array_column($aksesRahasia, 'noind');

        $admin_hubker = $this->M_index->allowedAccess('2');
        $admin_hubker = array_column($admin_hubker, 'noind');

        if (in_array($no_induk, $paramedik)) {
            $data['UserMenu'] = $datamenu;
        } elseif (in_array($no_induk, $admin_hubker)) {
            unset($datamenu[0]);
            unset($datamenu[1]);
            $data['UserMenu'] = array_values($datamenu);
        } else {
            unset($datamenu[1]);
            unset($datamenu[2]);
            unset($datamenu[3]);
            $data['UserMenu'] = array_values($datamenu);
        }

        $data['data'] = $this->M_presensiharian->getSeksiByKodesie($kodesie);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PerizinanPribadi/V_RekapSeksi', $data);
        $this->load->view('V_Footer', $data);
    }
}
