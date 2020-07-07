<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Transaksi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('MonitoringCuttingTool/M_transaksi');
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
		$data['Title'] = 'Monitoring Transaksi';
		$data['Menu'] = 'Monitoring Transaksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCuttingTool/V_Transaksi',$data);
		$this->load->view('V_Footer',$data);
    }

    public function getbulan(){
        $bln = ['0' => ['bulan'=>'January', 'val' => 'Jan-'.date('Y').''],
                '1' => ['bulan'=>'February', 'val' => 'Feb-'.date('Y').''],
                '2' => ['bulan'=>'March', 'val' => 'Mar-'.date('Y').''],
                '3' => ['bulan'=>'April', 'val' => 'Apr-'.date('Y').''],
                '4' => ['bulan'=>'May', 'val' => 'May-'.date('Y').''],
                '5' => ['bulan'=>'June', 'val' => 'Jun-'.date('Y').''],
                '6' => ['bulan'=>'July', 'val' => 'Jul-'.date('Y').''],
                '7' => ['bulan'=>'August', 'val' => 'Aug-'.date('Y').''],
                '8' => ['bulan'=>'September', 'val' => 'Sep-'.date('Y').''],
                '9' => ['bulan'=>'Oktober', 'val' => 'Okt-'.date('Y').''],
                '10' => ['bulan'=>'November', 'val' => 'Nov-'.date('Y').''],
                '11' => ['bulan'=>'Desember', 'val' => 'Des-'.date('Y').''],];
        echo json_encode($bln);
    }

    public function getbulan2(){
        $bln = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 
        'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        // echo "<pre>";print_r($bln);exit();
        return $bln;
    }

    public function cuttingtoolbaru(){
        $getdata = $this->M_transaksi->getdataBaru();
        $data['data'] = $this->olahdata($getdata);
        $data['bulan'] = $this->getbulan2();
        $this->load->view('MonitoringCuttingTool/V_TblBaru', $data);
    }
    
    public function cuttingtoolresharp(){
        $getdata = $this->M_transaksi->getdataResharp();
        $data['data'] = $this->olahdata($getdata);
        $data['bulan'] = $this->getbulan2();
        $this->load->view('MonitoringCuttingTool/V_Resharpening', $data);
    }

    public function cuttingtooltumpul(){
        $getdata = $this->M_transaksi->getdataTumpul();
        $data['data'] = $this->olahdata($getdata);
        $data['bulan'] = $this->getbulan2();
        $this->load->view('MonitoringCuttingTool/V_TblTumpul', $data);
    }

    public function olahdata($getdata){
        $tampung = array();
        foreach ($getdata as $key => $val) {
            $tampung[$key]['ITEM'] = $val['ITEM'];
            $tampung[$key]['DESCRIPTION'] = $val['DESCRIPTION'];
            $tampung[$key]['TOTAL_IN'] = 0;
            $tampung[$key]['TOTAL_OUT'] = 0;
            for ($a=0; $a < date('m') ; $a++) { 
                $b = ''.sprintf("%02d", ($a+1)).'-'.date('Y').'';
                $tampung[$key][$b]['IN'] = 0;
                $tampung[$key][$b]['OUT'] = 0;
            }
            if (date('n') < 12) {
                for ($f= $a; $f < 12 ; $f++) { 
                    $c = ''.sprintf("%02d", ($f+1)).'-'.date('Y').'';
                    $tampung[$key][$c]['IN'] = '';
                    $tampung[$key][$c]['OUT'] = '';
                }
            }
            $in = $this->M_transaksi->cariin($val['ITEM']);
            for ($d=0; $d < count($in); $d++) { 
                $tampung[$key][$in[$d]['BULAN']]['IN'] += $in[$d]['TOTAL_IN'];
                $tampung[$key]['TOTAL_IN'] += $in[$d]['TOTAL_IN'];
            }
            $out = $this->M_transaksi->cariout($val['ITEM']);
            for ($e=0; $e < count($out); $e++) { 
                $tampung[$key][$out[$e]['BULAN']]['OUT'] += $out[$e]['TOTAL_OUT'];
                $tampung[$key]['TOTAL_OUT'] += $out[$e]['TOTAL_OUT'];
            }
            // echo "<pre>";print_r($tampung);exit();
        }
        return $tampung;
    }
    
    public function DetailTransaksiBaru($no){
        $data['item'] = $this->input->post('item_baru'.$no.'');
        $data['desc'] = $this->input->post('desc_baru'.$no.'');
        $data['bulan'] = $this->input->post('bulan_baru'.$no.'');
        // echo "<pre>";print_r($data);exit();

        $data['datain'] = $this->M_transaksi->getdetailIN($data['bulan'], $data['item']);
        $data['dataout'] = $this->M_transaksi->getdetailOUT($data['bulan'], $data['item']);

		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Monitoring Transaksi';
		$data['Menu'] = 'Monitoring Transaksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringCuttingTool/V_DetailTransaksi', $data);
		$this->load->view('V_Footer',$data);
    }
    
    
    public function DetailTransaksiResharp($no){
        $data['item'] = $this->input->post('item_resharp'.$no.'');
        $data['desc'] = $this->input->post('desc_resharp'.$no.'');
        $data['bulan'] = $this->input->post('bulan_resharp'.$no.'');
        // echo "<pre>";print_r($data);exit();

        $data['datain'] = $this->M_transaksi->getdetailIN($data['bulan'], $data['item']);
        $data['dataout'] = $this->M_transaksi->getdetailOUT($data['bulan'], $data['item']);

		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Monitoring Transaksi';
		$data['Menu'] = 'Monitoring Transaksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringCuttingTool/V_DetailTransaksi', $data);
		$this->load->view('V_Footer',$data);
    }

    
    public function DetailTransaksiTumpul($no){
        $data['item'] = $this->input->post('item_tumpul'.$no.'');
        $data['desc'] = $this->input->post('desc_tumpul'.$no.'');
        $data['bulan'] = $this->input->post('bulan_tumpul'.$no.'');
        // echo "<pre>";print_r($data);exit();

        $data['datain'] = $this->M_transaksi->getdetailIN($data['bulan'], $data['item']);
        $data['dataout'] = $this->M_transaksi->getdetailOUT($data['bulan'], $data['item']);

		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Monitoring Transaksi';
		$data['Menu'] = 'Monitoring Transaksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringCuttingTool/V_DetailTransaksi', $data);
		$this->load->view('V_Footer',$data);
    }
    
}