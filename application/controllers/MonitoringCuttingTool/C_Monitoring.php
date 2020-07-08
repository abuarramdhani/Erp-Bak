<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('MonitoringCuttingTool/M_monitoring');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		// $this->checkSession();
		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Monitoring Cutting Tool';
		$data['Menu'] = 'Monitoring Cutting Tool';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCuttingTool/V_Monitoring',$data);
		$this->load->view('V_Footer',$data);
    }

    public function mon_cuttingtool(){
        $getdata    = $this->M_monitoring->getdataBaru();
        $resharp    = $this->M_monitoring->getdataResharp();
        $tumpul     = $this->M_monitoring->getdataTumpul();
        $in         = $this->M_monitoring->getrataIN();
        $out        = $this->M_monitoring->getrataOUT();
        $outstand   = $this->M_monitoring->getOutstanding();
        $tampung    = array();
        
        foreach ($getdata as $key => $val) {
            $tampung[$key]['ITEM']          = $val['ITEM'];
            $tampung[$key]['DESCRIPTION']   = $val['DESCRIPTION'];

            $carimin = $this->carimin($val['ITEM']);
            $tampung[$key]['MIN']   = $carimin['MIN'];
            $tampung[$key]['MAX']   = $carimin['MAX'];

            $tampung[$key]['TKS_N'] = $val['ONHAND_TR_TKS'];
            $tampung[$key]['TKS_R'] = $this->cariresharp($resharp, $val['ITEM']);
            $tampung[$key]['TKS_T'] = $this->caritumpul($tumpul, $val['ITEM']);

            $tampung[$key]['MOQ']       = $val['MOQ'];
            $tampung[$key]['LEADTIME']  = $val['TOTAL_LEADTIME'];

            $rata = $this->cari_in_out($in,$out, $val['ITEM']);
            $tampung[$key]['RATA_BARU_IN']      = $rata['baruin'];
            $tampung[$key]['RATA_BARU_OUT']     = $rata['baruout'];
            $tampung[$key]['RATA_RESHARP_IN']   = $rata['resharpin'];
            $tampung[$key]['RATA_RESHARP_OUT']  = $rata['resharpout'];
            $tampung[$key]['RATA_TUMPUL_IN']    = $rata['tumpulin'];
            $tampung[$key]['RATA_TUMPUL_OUT']   = $rata['tumpulout'];
            $tampung[$key]['OUTSTANDING'] =  $this->cariOutstanding($outstand,$val['ITEM']);
            // echo "<pre>";print_r($tampung);exit();
        }
        // echo "<pre>";print_r($tampung);exit();
        
        $data['data'] = $tampung;
        $this->load->view('MonitoringCuttingTool/V_TblMonitoring', $data);
    }

    public function cariresharp($resharp, $item){
        $val = '';
        foreach ($resharp as $key => $value) {
            // echo "<pre>";print_r($value);exit();
            if ($value['BARU'] == $item) {
                $val = $value['ONHAND_TR_TKS'];
            }else {
                $val = $val;
            }
        }
        return $val;
    }

    public function caritumpul($tumpul, $item){
        $val = '';
        foreach ($tumpul as $key => $value) {
            if ($item == $value['BARU']) {
                $val = $value['ONHAND_TR_TKS'];
            }else {
                $val = $val;
            }
        }
        return $val;
    }

    public function cari_in_out($in, $out, $item){
        $baruin = 0; $baruout = 0;
        $resharpin = 0; $resharpout = 0;
        $tumpulin = 0; $tumpulout = 0;
        // $in = $this->M_monitoring->getrataIN($item);
        foreach ($in as $key => $value) {
            if (stripos($value['ITEM'], $item) !== FALSE) {
                $kode = substr($value['ITEM'], -2);
                if ($kode == '-R') {
                    $resharpin += $value['TOTAL_IN'];
                }elseif ($kode == '-T') {
                    $tumpulin += $value['TOTAL_IN'];
                }else {
                    $baruin += $value['TOTAL_IN'];
                }
            }
        }
        
        // $out = $this->M_monitoring->getrataOUT($item);
        foreach ($out as $key => $value) {
            if (stripos($value['ITEM'], $item) !== FALSE) {
                $kode = substr($value['ITEM'], -2);
                if ($kode == '-R') {
                    $resharpout += $value['TOTAL_OUT'];
                }elseif ($kode == '-T') {
                    $tumpulout += $value['TOTAL_OUT'];
                }else {
                    $baruout += $value['TOTAL_OUT'];
                }
            }
        }
        $bln = date('n');
        $data = array('baruin' => $baruin/$bln, 'baruout' => $baruout/$bln,
                    'resharpin' => $resharpin/$bln, 'resharpout' => $resharpout/$bln,
                    'tumpulin' => $tumpulin/$bln, 'tumpulout' => $tumpulout/$bln);
        return $data;
    }

    public function carimin($item){
        $cari = $this->M_monitoring->carimin($item);
        $tampung = array();
        if (!empty($cari)) {
            $tampung['MIN'] = $cari[0]['min_tr_tks'];
            $tampung['MAX'] = $cari[0]['max_tr_tks'];
        }else {
            $tampung['MIN'] = '';
            $tampung['MAX'] = '';
        }
        return $tampung;
    }

    public function cariOutstanding($outstand, $item){
        $val = '';
        foreach ($outstand as $key => $value) {
            if ($value['ITEM'] == $item) {
                $val = $value['DUE_QUANTITY'];
            }else {
                $val = $val;
            }
        }
        return $val;
    }
    
}