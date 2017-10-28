<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ProductionPlanning/MainMenu/M_monitoring');
    }
	
	public function checkSession()
    {
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['section'] 		= $this->M_dataplan->getSection($user_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/Monitoring/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

    public function Open()
    {
    	$user_id 	= $this->session->userid;
    	$section 	= $this->input->post('section');
        $datplan    = array();
    	$datDailyAchieve= array();
    	$datsec 	= array();
    	foreach ($section as $val) {
            $datplan[] = $this->M_dataplan->getDataPlan($id=false,$val);
    		$datDailyAchieve[] = $this->M_monitoring->getDailyAchieve($val);
    	}

        $data['section']        = $this->M_dataplan->getSection();
        $data['secAchieve']     = $datDailyAchieve;
        $data['infoJob']        = $this->M_monitoring->getInfoJobs();
        $data['achieveAll']     = $this->M_monitoring->getAchievementAllFab();
        $data['selectedSection']= $section;
        
        $data['highPriority']= array();
        $data['normalPriority']= array();

        foreach ($datplan as $dp => $val1) {
            $h = 0;
            $n = 0;
            if (empty($val1)) {
                $data['highPriority'][$dp][0] = false;
                $data['normalPriority'][$dp][0] = false;
            }else{
                foreach ($val1 as $key => $val2) {
                    if ($val2['priority'] == '1') {
                        $data['highPriority'][$dp][$h++] = $val2;
                    }else{
                        $data['normalPriority'][$dp][$n++] = $val2;
                    }
                }
            }
        }
        
        $this->load->view('ProductionPlanning/MainMenu/Monitoring/V_Monitoring', $data);
    }

    public function getSumPlanMonth()
    {
        $section        = $this->input->post('section');
        $sumPlan        = $this->M_monitoring->getSumPlanMonth($section);
        $valPlan        = array();
        for ($i=1; $i <= date('t'); $i++) {
            $checkout = 0;
            $valPlanDefault = array(
                'label' => $i,
                'prosentase_plan' => 0,
                'prosentase_achieve' => 0
            );
            foreach ($sumPlan as $sp) {
                if ($i == (int)substr($sp['hari'], 0,2)) {
                    $valPlan[$i] = $sp;
                    $checkout = 1;
                }
                elseif ($checkout == 0) {
                    $valPlan[$i] = $valPlanDefault;
                }
            }
        }
        $data['plan'] = $valPlan;
        echo json_encode($data);
    }

    public function getDailyPlan()
    {
        $user_id    = $this->session->userid;
        $section    = $this->input->post('sectionId');
        $datplan    = array();
        $a = $this->M_dataplan->getDataPlan($id=false,$section);
        if (!empty($a)) {
            foreach ($a as $aval) {
                $subInv = $this->M_dataplan->getSection($user_id,$aval['section_id']);
                foreach ($subInv as $si) {
                    if ($si['from_inventory'] == 'JOB') {
                        $getItemTransaction = $this->M_dataplan->getItemTransaction(1,$si['from_inventory'],$si['to_inventory'],$aval['item_code'],$si['locator_id']);
                    }else{
                        $getItemTransaction = $this->M_dataplan->getItemTransaction(FALSE,$si['from_inventory'],$si['to_inventory'],$aval['item_code'],$si['locator_id']);
                    }
                    if (!empty($getItemTransaction)) {
                        $dataUpd = array(
                            'achieve_qty'       => $getItemTransaction[0]['ACHIEVE_QTY'],
                            'last_delivery'     => $getItemTransaction[0]['LAST_DELIVERY'],
                            'last_updated_date' => date("Y-m-d H:i:s")
                        );
                        $this->M_dataplan->update($dataUpd, $aval['daily_plan_id']);
                    }
                }
            }
            $b = $this->M_dataplan->getDataPlan($id=false,$section);
            $high   = array();
            $normal = array();
            $h = 0;
            $n = 0;

            foreach ($b as $dp) {
                if ($dp['priority'] == '1' && $dp['status'] == 'NOT OK') {
                    $high[$h++] = $dp;
                }else{
                    $normal[$n++] = $dp;
                }
            }
            echo '<thead class="bg-primary" style="font-weight: bold; font-size: 14px;">
                    <tr>
                        <td>NO</td>
                        <td>ITEM</td>
                        <td>DESC</td>
                        <td>PRIORITY</td>
                        <td>NEED QTY</td>
                        <td>DUE TIME</td>
                        <td>ACHIEVE QTY</td>
                        <td>LAST DELIVERY</td>
                        <td>STATUS</td>
                    </tr>
                </thead>';
            $no = 1;
            $checkpoint = 1;
            if (!empty($high)) {
                echo '<tbody id="highPriority">';
                foreach ($high as $h){
                    if ($h['achieve_qty'] >= $h['need_qty']) {
                        $classStatus = "plan-done";
                    }else{
                        $classStatus = "plan-undone-high";
                    }
                    echo '<tr class="'.$classStatus.'">
                            <td>'.$no++.'</td>
                            <td>'.$h['item_code'].'</td>
                            <td>';
                                if (strlen($h['item_description']) > 20) {
                                    echo substr($h['item_description'],0,20).'...';
                                }else{
                                    echo $h['item_description'];
                                }
                            echo '</td>
                            <td>'.$h['priority'].'</td>
                            <td>'.$h['need_qty'].'</td>
                            <td>'.$h['due_time'].'</td>
                            <td>'.$h['achieve_qty'].'</td>
                            <td>'.$h['last_delivery'].'</td>
                            <td>'.$h['status'].'</td>
                        </tr>';
                    $checkpoint++;
                }
                echo '</tbody>';
            }
            if (!empty($normal)) {
                echo '<input type="hidden" name="checkpointBegin" data-secid="'.$section.'" value="'.$checkpoint.'">
                <tbody id="normalPriority">';
                foreach ($normal as $n ){
                    if ($n['achieve_qty'] >= $n['need_qty']) {
                        $classStatus = "plan-done";
                    }else{
                        $classStatus = "plan-undone-normal";
                    }
                    echo '<tr class="'.$classStatus.'"';
                        if ($checkpoint > 6) {
                            echo " data-showid='".$checkpoint."'";
                            echo " data-showstat='0'";
                            echo " style='display:none;'";
                            $checkpoint++;
                        }else{
                            echo " data-showid='".$checkpoint."'";
                            echo " data-showstat='1'";
                            $checkpoint++;
                        } echo '>
                        <td>'.$no++.'</td>
                        <td>'.$n['item_code'].'</td>
                        <td>'.$n['item_description'].'</td>
                        <td>'.$n['priority'].'</td>
                        <td>'.$n['need_qty'].'</td>
                        <td>'.$n['due_time'].'</td>
                        <td>'.$n['achieve_qty'].'</td>
                        <td>'.$n['last_delivery'].'</td>
                        <td>'.$n['status'].'</td>
                    </tr>';
                }
                echo '</tbody>
                    <input type="hidden" name="checkpointEnd" data-secid="'.$section.'" value="'.$checkpoint.'">';
            }
        }else{
            echo '<thead class="bg-primary" style="font-weight: bold; font-size: 16px;">
                    <tr>
                        <td>No</td>
                        <td>Item</td>
                        <td>Desc</td>
                        <td>Priority</td>
                        <td>Need Qty</td>
                        <td>Due Time</td>
                        <td>Achieve Qty</td>
                        <td>Last Delivery</td>
                        <td>Status</td>
                    </tr>
                </thead>';
        }
    }

    public function getAchieveAllFab()
    {
        $achieveAll = $this->M_monitoring->getAchievementAllFab();

        echo '<tr>
            <td colspan="2"><b>ACHIEVEMENT ALL FAB</b></td>
        </tr>';
        foreach ($achieveAll as $aa) {
            echo '<tr>
                <td style="width: 70%">
                    <b>'.$aa['section_name'].'</b>
                </td>
                <td style="width: 30%">
                    <b>'.$aa['percentage'].'</b>
                </td>
            </tr>}';
        }
    }

    public function getInfoJob()
    {
        $data = $this->M_monitoring->getInfoJobs();
        echo '<tr>
            <td>JOB RELEASED</td>
            <td class="text-right">'.$data[0]['RELEASED_JUMLAH_JOB'].'</td>
            <td class="text-right">'.$data[0]['RELEASED_JUMLAH_PART'].'</td>
        </tr>
        <tr>
            <td>JOB PENDING PICKLIST</td>
            <td class="text-right">'.$data[0]['PENDING_JUMLAH_JOB'].'</td>
            <td class="text-right">'.$data[0]['PENDING_JUMLAH_PART'].'</td>
        </tr>
        <tr>
            <td>TOTAL JOB COMPLETE 1 BULAN</td>
            <td class="text-right">'.$data[0]['COMPLETE_JUMLAH_JOB'].'</td>
            <td class="text-right">'.$data[0]['COMPLETE_JUMLAH_PART'].'</td>
        </tr>
        <tr>
            <td>JOB TERLAMA</td>
            <td colspan="2">'.date('d, F Y', strtotime($data[0]['JOB_TERLAMA'])).'</td>
        </tr>';
    }

    public function getAchievement()
    {
        $secid  = $this->input->post('sectionId');
        $achieve= $this->M_monitoring->getDailyAchieve($secid);
        echo "ACHIEVEMENT = ".$achieve[0]['percentage'];
    }
}