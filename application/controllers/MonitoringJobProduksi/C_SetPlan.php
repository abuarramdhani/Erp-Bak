<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SetPlan extends CI_Controller
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
		$this->load->model('MonitoringJobProduksi/M_setplan');

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

		$data['Title'] = 'Set Plan Produksi';
		$data['Menu'] = 'Set Plan Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kategori'] = $this->M_setplan->getCategory();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_SetPlan', $data);
		$this->load->view('V_Footer',$data);
	}
    
    public function search(){
        $kategori   = $this->input->post('kategori');
		$bulan      = $this->input->post('bulan');
        $bulan 		= explode("/", $bulan);
		$data['bulan'] = $bulan[1].$bulan[0];
        // echo "<pre>";print_r($bulan);exit();
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
		
		$getdata	= $this->M_setplan->getdataMonitoring($kategori);
		$getplandate	= $this->M_setplan->getPlanDate('');
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$item = $this->M_setplan->getitem2($value['INVENTORY_ITEM_ID']);
			$plan = $this->M_setplan->getPlan("where inventory_item_id = ".$value['INVENTORY_ITEM_ID']." and month = ".$data['bulan']."");
			$getdata[$key]['ITEM'] = $item[0]['SEGMENT1'];
			$getdata[$key]['DESKRIPSI'] = $item[0]['DESCRIPTION'];
			if (!empty($plan)) {
				$getdata[$key]['PLAN_ID'] = $plan[0]['PLAN_ID'];
				for ($i=0; $i < $data['hari']; $i++) { 
					$getdata[$key][$i] = $this->getPlanDate($plan[0]['PLAN_ID'], ($i+1), $getplandate);
				}
			}else {
				$getdata[$key]['PLAN_ID'] = '';
				for ($i=0; $i < $data['hari'] ; $i++) { 
					$getdata[$key][$i] = '';
				}
			}
			array_push($datanya, $getdata[$key]);
		}
		$data['data'] = $datanya;

        $this->load->view('MonitoringJobProduksi/V_TblSetplan', $data);
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
	
	public function saveSetplan(){
		$bulan = $this->input->post('bulan');
		$id_plan = $this->input->post('id_plan');
		$inv_id = $this->input->post('item');
		$plan = $this->input->post('plan');
		$tgl = $this->input->post('tgl');
		// echo "<pre>";print_r($plan);exit();
		if (empty($id_plan)) {
			$cekid 			= $this->M_setplan->getPlan('order by plan_id desc');
			$id 			= !empty($cekid) ? $cekid[0]['PLAN_ID'] + 1 : 1;
			$savePlan 		= $this->M_setplan->savePlan($id, $inv_id, $bulan);
			$saveplandate 	= $this->M_setplan->savePlanDate($id, $tgl, $plan);
		}else {
			$cekdate = $this->M_setplan->getPlanDate("where plan_id = ".$id_plan." and date_plan = ".$tgl."");
			if (!empty($cekdate) && !empty($plan)) {
				$update = $this->M_setplan->updatePlanDate($id_plan, $tgl, $plan);
			}elseif (empty($cekdate) && !empty($plan)) {
				$save = $this->M_setplan->savePlanDate($id_plan, $tgl, $plan);
			}elseif (!empty($cekdate) && empty($plan)) {
				$delete = $this->M_setplan->deletePlanDate($id_plan, $tgl);
			}
		}
	}

	// public function savePlan(){
	// 	$bulan 		= $this->input->post('bulan');
	// 	$kategori 	= $this->input->post('kategori');
	// 	$item 		= $this->input->post('item[]');
	// 	$plan 		= $this->input->post('plan[]');
	// 	$plan2 = count($plan)/count($item);
	// 	$plann = $plan2;
	// 	$p = 0;
	// 	// echo "<pre>";print_r($plan2);exit();
	// 	for ($i=0; $i < count($item) ; $i++) { 
	// 		$plan3 = array();
	// 		for ($x=$p; $x < $plan2 ; $x++) { 
	// 			array_push($plan3, $plan[$x]);
	// 		}
	// 		$p = $plan2;
	// 		$plan2 = $plan2 + $plann;
	// 		$cekdata = $this->M_setplan->getPlan("where inventory_item_id = ".$item[$i]." and month = $bulan");
	// 		if (empty($cekdata)) {
	// 			$cekid = $this->M_setplan->getPlan('order by plan_id desc');
	// 			$id = !empty($cekid) ? $cekid[0]['PLAN_ID'] + 1 : 1;
	// 			$savePlan = $this->M_setplan->savePlan($id, $item[$i], $bulan);
	// 			for ($a=0; $a < count($plan3) ; $a++) { 
	// 				if (!empty($plan3[$a])) {
	// 					$this->M_setplan->savePlanDate($id, ($a+1), $plan3[$a]);
	// 				}
	// 			}
	// 		}else {
	// 			for ($b=0; $b < count($plan3) ; $b++) { 
	// 				$cekdate = $this->M_setplan->getPlanDate("where plan_id = ".$cekdata[0]['PLAN_ID']." and date_plan = ".($b+1)."");
	// 				if (!empty($cekdate) && !empty($plan3[$b])) {
	// 					$update = $this->M_setplan->updatePlanDate($cekdata[0]['PLAN_ID'], ($b+1), $plan3[$b]);
	// 				}elseif (empty($cekdate) && !empty($plan3[$b])) {
	// 					$save = $this->M_setplan->savePlanDate($cekdata[0]['PLAN_ID'], ($b+1), $plan3[$b]);
	// 				}elseif (!empty($cekdate) && empty($plan3[$b])) {
	// 					$delete = $this->M_setplan->deletePlanDate($cekdata[0]['PLAN_ID'], ($b+1));
	// 				}
	// 			}
	// 		}
	// 	}
	// 	redirect(base_url('MonitoringJobProduksi/SetPlan'));
	// }



}