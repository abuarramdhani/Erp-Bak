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

        $data['Title'] = 'Approve Atasan';
        $data['Menu'] = 'Perizinan Pribadi';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $aksesRahasia = $this->M_index->allowedParamedik();
        $aksesRahasia = array_column($aksesRahasia, 'noind');

        if (in_array($no_induk, $aksesRahasia)) {
            $data['UserMenu'] = $datamenu;
        } else {
            unset($datamenu[1]);
            unset($datamenu[2]);
            $data['UserMenu'] = $datamenu;
        }

        $data['data'] = $this->M_presensiharian->getSeksiByKodesie($kodesie);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PerizinanPribadi/V_RekapSeksi', $data);
        $this->load->view('V_Footer', $data);
    }

    public function rekap()
    {
        $kd_sie = $this->session->kodesie;
        $noind = $this->session->user;
        $today = date('d M Y H:i:s');
        $kodesie = substr($kd_sie, 0, 7);
        $tanggal = $this->input->get('periodeRekap');
        $export = $this->input->get('valButton');
        $nama  = $this->M_index->getNamaByNoind($noind);
        $seksi = $this->M_penyerahan->getJabatanPreview($kd_sie);

        if (!empty($tanggal)) {
            $explode = explode(' - ', $tanggal);
            $tanggal1 = str_replace("/", '-', $explode[0]);
            $tanggal2 = str_replace("/", '-', $explode[1]);

            $tgl_awal = date('Y-m-d', strtotime($tanggal1));
            $tgl_akhir = date('Y-m-d', strtotime($tanggal2));
            $periode = "and ip.created_date::date between '$tgl_awal' and '$tgl_akhir'";
        } else {
            $periode = '';
        }

        $data['jenis'] = '2';
        $whereSeksi = "tp.kodesie like '$kodesie%'";
        $data['IzinApprove'] = $this->M_index->IzinApprove($periode, '', $whereSeksi);
        if ($export == 'Excel') {
            $data['date'] = date("d-m-Y");

            $this->load->library("Excel");
            $this->load->view('PerizinanPribadi/V_RekapExcel', $data);
        } elseif ($export == 'PDF') {
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf = new mPDF('utf-8', 'A4-L', 10, 8, 10, 10, 30, 15, 8, 20);
            $filename = 'Rekap Perizinan Perseksi.pdf';

            $html = $this->load->view('PerizinanPribadi/V_PDF', $data, true);
            $pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%" rowspan="2"><h2><b>Rekap Data Perizinan</b></h2></td>
						<td style="text-align: right;"><h5>Dicetak Oleh ' . $noind . ' - ' . $nama . ' pada Tanggal ' . $today . '</h5></td>
					</tr>
                    <tr>
						<td style="text-align: right;"><h5>Seksi : ' . ucwords(mb_strtolower($seksi)) . '</h5></td>
					</tr>
				</table>
			');

            $pdf->WriteHTML($html, 2);
            $pdf->setTitle($filename);
            $pdf->Output($filename, 'I');
        } else {
            $view = $this->load->view('PerizinanPribadi/V_Process', $data);
            echo json_encode($view);
        }
    }
}
