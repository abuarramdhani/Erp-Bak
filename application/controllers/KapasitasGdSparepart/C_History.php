<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_History extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_history');
		$this->load->model('KapasitasGdSparepart/M_packing');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'History SPB/DO';
		$data['Menu'] = 'History SPB/DO';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $val = $this->M_history->getDataSPB('');
        // echo "<pre>";print_r($val);exit();
        $tampung = array();
        $colypcs = array();
        $masuk = array();
        $tgl = array();
        $a = 0;
        for ($i=0; $i < count($val); $i++) { 
            // if (count($tampung) < 10) {
            if (!in_array($val[$i]['JAM_INPUT'], $tgl)) {
                array_push($tgl, $val[$i]['JAM_INPUT']);
                $tampung[$a]['TANGGAL'] = $val[$i]['TGL_INPUT'];
                $tampung[$a]['TGL_INPUT'] = $val[$i]['JAM'];
                $plyn = $this->M_history->getDataSPB("and selesai_pelayanan like to_date('".$val[$i]['JAM_INPUT']."','DD/MM/YYYY')");
                $tampung[$a]['PELAYANAN'] = 0;
                for ($l=0; $l < count($plyn); $l++) { 
                    if ($plyn[$l]['WAKTU_PELAYANAN'] != '') {
                        $plyn1 = explode(":", $plyn[$l]['WAKTU_PELAYANAN']);
                        $plyn2 = ($plyn1[0]*3600) + ($plyn1[1]*60) + $plyn1[2];
                        $tampung[$a]['PELAYANAN'] += $plyn2;
                    }
                }
                if (count($plyn) == 0) {
                    $bagi = 1;
                }else {
                    $bagi = count($plyn);
                }
                $tampung[$a]['PELAYANAN'] = round($tampung[$a]['PELAYANAN'] / $bagi, 3);
                
                $pglr = $this->M_history->getDataSPB("and selesai_pengeluaran like to_date('".$val[$i]['JAM_INPUT']."','DD/MM/YYYY')");
                $tampung[$a]['PENGELUARAN'] = 0;
                for ($l=0; $l < count($pglr); $l++) { 
                    if ($pglr[$l]['WAKTU_PENGELUARAN'] != '') {
                        $pglr1 = explode(":", $pglr[$l]['WAKTU_PENGELUARAN']);
                        $pglr2 = ($pglr1[0]*3600) + ($pglr1[1]*60) + $pglr1[2];
                        $tampung[$a]['PENGELUARAN'] += $pglr2;
                    }
                }
                if (count($pglr) == 0) {
                    $bagi = 1;
                }else {
                    $bagi = count($pglr);
                }
                $tampung[$a]['PENGELUARAN'] = round($tampung[$a]['PENGELUARAN'] / $bagi, 3);
                
                $pck = $this->M_history->getDataSPB("and selesai_packing like to_date('".$val[$i]['JAM_INPUT']."','DD/MM/YYYY')");
                $tampung[$a]['PACKING'] = 0;
                $tampung[$a]['COLY'] = 0;
                $tampung[$a]['LEMBAR_PACK'] = 0;
                $tampung[$a]['PCS_PACK'] = 0;
                for ($l=0; $l < count($pck); $l++) { 
                    if ($pck[$l]['WAKTU_PACKING'] != '') {
                        $pck1 = explode(":", $pck[$l]['WAKTU_PACKING']);
                        $pck2 = ($pck1[0]*3600) + ($pck1[1]*60) + $pck1[2];
                        $tampung[$a]['PACKING'] += $pck2;
                    }
                    $tampung[$a]['LEMBAR_PACK'] += 1;
                    $tampung[$a]['PCS_PACK'] += $pck[$l]['JUMLAH_PCS'];
                    $coly = $this->M_packing->cekPacking($pck[$l]['NO_DOKUMEN']);
                    if (!empty($coly)) {
                        $tampung[$a]['COLY'] += count($coly);
                    }
                }
                if (count($pck) == 0) {
                    $bagi = 1;
                }else {
                    $bagi = count($pck);
                }
                $tampung[$a]['PACKING'] = round($tampung[$a]['PACKING'] / $bagi, 3);
                
            $a++;
            }            

            if ($i == 0) {
                $m = 0;
                $tampung[$m]['LEMBAR_MASUK'] = 0;
                $tampung[$m]['PCS_MASUK'] = 0;
                $tampung[$m]['LEMBAR_MASUK'] += 1;
                $tampung[$m]['PCS_MASUK'] += $val[$i]['JUMLAH_PCS'];
            }else {
                if ($val[$i]['JAM_INPUT'] == $val[$i-1]['JAM_INPUT']) {
                    $tampung[$m]['LEMBAR_MASUK'] += 1;
                    $tampung[$m]['PCS_MASUK'] += $val[$i]['JUMLAH_PCS'];
                }else {
                    $m = $m + 1;
                    $tampung[$m]['LEMBAR_MASUK'] = 0;
                    $tampung[$m]['PCS_MASUK'] = 0;
                    $tampung[$m]['LEMBAR_MASUK'] += 1;
                    $tampung[$m]['PCS_MASUK'] += $val[$i]['JUMLAH_PCS'];
                }
            }
        }

        // $tampung[0]['TGL_INPUT'] = date('dmY');
        // $tampung[0]['TANGGAL'] = date('dmY');
        // $tampung[0]['PELAYANAN'] = date('dmY');
        // $tampung[0]['PENGELUARAN'] = date('dmY');
        // $tampung[0]['PACKING'] = date('dmY');
        // $tampung[0]['COLY'] = date('dmY');
        // $tampung[0]['LEMBAR_PACK'] = date('dmY');
        // $tampung[0]['PCS_PACK'] = date('dmY');
        // $tampung[0]['LEMBAR_MASUK'] = date('dmY');
        // $tampung[0]['PCS_MASUK'] = date('dmY');

        $data['data'] = $tampung;
        // echo "<pre>";print_r($tampung);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('KapasitasGdSparepart/V_History', $data);
        $this->load->view('V_Footer',$data);
    }


}
