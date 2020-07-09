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
			redirect('');
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
        $m = 0;
        $date = date('d/m/Y');
        if ($val[0]['JAM_INPUT'] != $date) {
            array_push($tgl, $date);
            $tampung[$a]['TGL_INPUT']   = strtoupper(date('d-M-y'));
            $hitung = $this->perhitungan($date);
            $tampung[$a]['PELAYANAN']   = $hitung['pelayanan'];
            $tampung[$a]['PENGELUARAN'] = $hitung['pengeluaran'];
            $tampung[$a]['PACKING']     = $hitung['packing'];
            $tampung[$a]['COLY']        = $hitung['coly'];
            $tampung[$a]['LEMBAR_PACK'] = $hitung['lembar_pack'];
            $tampung[$a]['PCS_PACK']    = $hitung['pcs_pack'];
            $tampung[$a]['JML_PACK']    = $hitung['jml_pack'];
            $tampung[$a]['ITEM_KELUAR'] = $hitung['item_out'];
            $tampung[$a]['ITEM_PGLR']   = $hitung['item_pglr'];
            $tampung[$a]['ITEM_PLYN']   = $hitung['item_plyn'];
            $tampung[$m]['LEMBAR_MASUK'] = 0;
            $tampung[$m]['PCS_MASUK']   = 0;
            $tampung[$m]['ITEM_MASUK']  = 0;
        $a++; $m++;
        }

        for ($i=0; $i < count($val); $i++) { 
            // if (count($tampung) < 10) {
            if (!in_array($val[$i]['JAM_INPUT'], $tgl)) {
                array_push($tgl, $val[$i]['JAM_INPUT']);
                $tampung[$a]['TGL_INPUT']   = $val[$i]['JAM'];
                $hitung = $this->perhitungan($val[$i]['JAM_INPUT']);
                $tampung[$a]['PELAYANAN']   = $hitung['pelayanan'];
                $tampung[$a]['PENGELUARAN'] = $hitung['pengeluaran'];
                $tampung[$a]['PACKING']     = $hitung['packing'];
                $tampung[$a]['COLY']        = $hitung['coly'];
                $tampung[$a]['LEMBAR_PACK'] = $hitung['lembar_pack'];
                $tampung[$a]['PCS_PACK']    = $hitung['pcs_pack'];
                $tampung[$a]['JML_PACK']    = $hitung['jml_pack'];
                $tampung[$a]['ITEM_MASUK']  = $hitung['item_in'];
                $tampung[$a]['ITEM_KELUAR'] = $hitung['item_out'];
                $tampung[$a]['ITEM_PGLR']   = $hitung['item_pglr'];
                $tampung[$a]['ITEM_PLYN']   = $hitung['item_plyn'];
                $tampung[$a]['LEMBAR_MASUK']= $hitung['lembar_masuk'];
                $tampung[$a]['PCS_MASUK']   = $hitung['pcs_masuk'];
            $a++;
            }            
        }

        $data['data'] = $tampung;
        // echo "<pre>";print_r($tampung);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('KapasitasGdSparepart/V_History', $data);
        $this->load->view('V_Footer',$data);
    }

    public function perhitungan($date){
        $masuk = $this->M_history->getDataSPB("and TRUNC(jam_input) = to_date('".$date."', 'DD/MM/YYYY')");
        $in = 0;
        $lembar_masuk = 0;
        $pcs_masuk = 0;
        for ($l=0; $l < count($masuk) ; $l++) { 
            $in += $masuk[$l]['JUMLAH_ITEM'];
            $pcs_masuk += $masuk[$l]['JUMLAH_PCS'];
            $lembar_masuk += 1;
        }
        // echo "<pre>";print_r($in);exit();

        $plyn = $this->M_history->dataPlyn($date);
        // $plyn = $this->M_history->getDataSPB("and selesai_pelayanan like to_date('".$date."','DD/MM/YYYY')");
        $pelayanan = 0;
        $item_plyn = 0;
        for ($l=0; $l < count($plyn); $l++) { 
            if ($plyn[$l]['WAKTU_PELAYANAN'] != '') {
                $plyn1 = explode(":", $plyn[$l]['WAKTU_PELAYANAN']);
                $plyn2 = ($plyn1[0]*3600) + ($plyn1[1]*60) + $plyn1[2];
                $pelayanan += $plyn2;
                $item_plyn += $plyn[$l]['JUMLAH_ITEM'];
            }
        }
        if (count($plyn) == 0) {
            $bagi = 1;
        }else {
            $bagi = count($plyn);
        }
        $pelayanan = round($pelayanan / $bagi);
        
        $pglr = $this->M_history->dataPglr($date);
        // $pglr = $this->M_history->getDataSPB("and selesai_pengeluaran like to_date('".$date."','DD/MM/YYYY')");
        $pengeluaran = 0;
        $item_pglr = 0;
        for ($l=0; $l < count($pglr); $l++) { 
            if ($pglr[$l]['WAKTU_PENGELUARAN'] != '') {
                $pglr1 = explode(":", $pglr[$l]['WAKTU_PENGELUARAN']);
                $pglr2 = ($pglr1[0]*3600) + ($pglr1[1]*60) + $pglr1[2];
                $pengeluaran += $pglr2;
                $item_pglr += $pglr[$l]['JUMLAH_ITEM'];
            }
        }
        if (count($pglr) == 0) {
            $bagi = 1;
        }else {
            $bagi = count($pglr);
        }
        $pengeluaran = round($pengeluaran / $bagi);
        
        $pck = $this->M_history->dataPck($date);
        // $pck = $this->M_history->getDataSPB("and selesai_packing like to_date('".$date."','DD/MM/YYYY')");
        $packing = 0;
        $coly = 0;
        $lembar_pack = 0;
        $pcs_pack = 0;
        $out = 0;
        for ($l=0; $l < count($pck); $l++) { 
            if ($pck[$l]['WAKTU_PACKING'] != '') {
                $pck1 = explode(":", $pck[$l]['WAKTU_PACKING']);
                $pck2 = ($pck1[0]*3600) + ($pck1[1]*60) + $pck1[2];
                $packing += $pck2;
            }
            $lembar_pack += 1;
            $pcs_pack += $pck[$l]['JUMLAH_PCS'];
            $coly2 = $this->M_packing->cekPacking($pck[$l]['NO_DOKUMEN']);
            if (!empty($coly2)) {
                $coly += count($coly2);
            }
            $out += $pck[$l]['JUMLAH_ITEM'];
        }
        if (count($pck) == 0) {
            $bagi = 1;
        }else {
            $bagi = count($pck);
        }
        $packing = round($packing / $bagi);
        $jml_pack = round($pcs_pack/50);
        
        $tampung = array(
            'pelayanan'     => $pelayanan,
            'pengeluaran'   => $pengeluaran,
            'packing'       => $packing,
            'coly'          => $coly,
            'lembar_pack'   => $lembar_pack,
            'pcs_pack'      => $pcs_pack,
            'jml_pack'      => $jml_pack,
            'item_in'       => $in,
            'item_out'      => $out,
            'item_plyn'     => $item_plyn,
            'item_pglr'     => $item_pglr,
            'lembar_masuk'  => $lembar_masuk,
            'pcs_masuk'     => $pcs_masuk,
        );

        return $tampung;
    }

}
