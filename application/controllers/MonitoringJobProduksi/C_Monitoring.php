<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringJobProduksi/M_monitoring');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Job Produksi';
		$data['Menu'] = 'Monitoring Job Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kategori'] = $this->M_monitoring->getCategory();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function search(){
        $kategori   	= $this->input->post('kategori');
		$bulan      	= $this->input->post('bulan');
		$data['kategori'] 	= $kategori;
		$data['bulan'] 	= $bulan;
		$bulan 			= explode("/", $bulan);
		$inibulan		= $bulan[1].$bulan[0];
		// echo "<pre>";print_r($getdata);exit();

        if ($bulan[0] == '01' || $bulan[0] == '03' || $bulan[0] == '05' || $bulan[0] == '07' || $bulan[0] == '08' || $bulan[0] == '10' || $bulan[0] == '12') {
            $data['hari'] = 31;
        }elseif ($bulan[0] == '04' || $bulan[0] == '06' || $bulan[0] == '09' || $bulan[0] == '11') {
            $data['hari'] = 30;
        }elseif ($bulan[0] == '02') {
            if ($bulan[1]%4 == 0) {
                $data['hari'] = 29;
            }else {
                $data['hari'] = 28;
            }
		}

		$getdata = $this->M_monitoring->getdataMonitoring($kategori);
		$cariakt = $this->M_monitoring->getAktual($kategori, $data['bulan']);
		$getplandate = $this->M_monitoring->getPlanDate();
		// echo "<pre>";print_r($cariakt);exit();
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$item = $this->M_monitoring->getitem($value['INVENTORY_ITEM_ID']);
			$plan = $this->M_monitoring->getPlan($value['INVENTORY_ITEM_ID'], $inibulan);
			$getdata[$key]['ITEM'] = $item[0]['SEGMENT1'];
			$getdata[$key]['DESC'] = $item[0]['DESCRIPTION'];
			if (!empty($plan)) {
				for ($i=0; $i < $data['hari'] ; $i++) { 
					$getdata[$key]['plan'.$i.''] = $this->getPlanDate($plan[0]['PLAN_ID'], ($i+1), $getplandate);
					$tgl = $inibulan.sprintf("%02d", ($i+1));
					$aktual = $this->aktualmin($value['INVENTORY_ITEM_ID'], $tgl, $getdata[$key]['plan'.$i.''], $cariakt);
					$getdata[$key]['akt'.$i.''] = $aktual[0];
					$getdata[$key]['min'.$i.''] = $aktual[1];
				}
			}else {
				for ($i=0; $i < $data['hari'] ; $i++) { 
					$getdata[$key]['plan'.$i.''] =  '';
					$tgl = $inibulan.sprintf("%02d", ($i+1));
					$aktual = $this->aktualmin($value['INVENTORY_ITEM_ID'], $tgl, $getdata[$key]['plan'.$i.''], $cariakt);
					$getdata[$key]['akt'.$i.''] = $aktual[0];
					$getdata[$key]['min'.$i.''] = $aktual[1];
				}
			}
			// echo "<pre>";print_r($getdata[$key]);exit();

			array_push($datanya,$getdata[$key]);
		}
		$data['data'] = $datanya;
		// echo "<pre>";print_r($getdata);exit();

        $this->load->view('MonitoringJobProduksi/V_TblMonitoring', $data);
	}
	
	public function getPlanDate($id, $tgl, $data){
		$value = '';
		foreach ($data as $key => $val) {
			if ($val['PLAN_ID'] == $id && $val['DATE_PLAN'] == $tgl) {
				$value = $val['VALUE_PLAN'];
			}else {
				$value = $value;
			}
		}
		return $value;
	}

	public function aktualmin($inv_id, $tgl, $plan, $cariakt){
		$aktual = '';
		foreach ($cariakt as $key => $val) {
			if ($val['INVENTORY_ITEM_ID'] == $inv_id && $val['TGL_URUT'] == $tgl) {
				$aktual = $val['QUANTITY_COMPLETE'];
			}else {
				$aktual = $aktual;
			}
		}
		if ($plan == '' && $aktual != '') {
			$min = 'invalid';
		}elseif ($plan == '' && $aktual == '') {
			$min = '';
		}elseif ($plan != '' && $aktual == '') {
			$min = $plan;
		}else {
			$min = $plan - $aktual;
		}
		$data = array($aktual, $min);
		return $data;
	}
	
	public function simulasi($no, $tgl)
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Simulasi Job Produksi';
		$data['Menu'] = 'Monitoring Job Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['no'] 		= $no;
		$data['tanggal'] 	= $tgl;
        $data['kategori']  	= $this->input->post('kategori'.$no.'');
		$data['bulan'] 		= $this->input->post('bulan'.$no.'');
		$data['item'] 		= $this->input->post('item'.$no.'');
		$data['desc'] 		= $this->input->post('desc'.$no.'');
		$data['plan'] 		= $this->input->post('plan'.$no.''.$tgl.'');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Simulasi', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function searchSimulasi(){
		$item = $this->input->post('item');
		$qty = $this->input->post('qty');

		$data['data'] = $this->M_monitoring->getdataSimulasi($item, $qty);
		// echo "<pre>";print_r($data['data']);exit();
		$this->load->view('MonitoringJobProduksi/V_TblSimulasi', $data);
	}


}