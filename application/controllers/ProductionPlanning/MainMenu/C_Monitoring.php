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
		$this->load->model('ProductionPlanning/MainMenu/M_itemplan');
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
        
        $data['highPriority']   = array();
        $data['normalPriority'] = array();

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

        if (count($section) > 1) {
            $this->load->view('ProductionPlanning/MainMenu/Monitoring/V_MonitoringMultiple', $data);
        }else{
            $this->load->view('ProductionPlanning/MainMenu/Monitoring/V_MonitoringSingle', $data);
        }
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
                    if ($i !== 1) {
                        $valPlanCumul = array(
                            'label' => $i,
                            'prosentase_plan' => $valPlan[$i-1]['prosentase_plan'],
                            'prosentase_achieve' => $valPlan[$i-1]['prosentase_achieve']
                        );
                        $valPlan[$i] = $valPlanCumul;
                    }else{
                        $valPlan[$i] = $valPlanDefault;
                    }
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
        $a          = $this->M_dataplan->getDataPlanUpdate($section);
        if (!empty($a)) {
            foreach ($a as $aval) {
                $is = $this->M_itemplan->getItemData($section,$aval['item_code']);
                
                // ---- ngambil data transaction di oracle hari ini ----
                if (!empty($is) && $is[0]['from_inventory'] == NULL) {
                    $getItemTransaction = $this->M_dataplan->getItemTransaction(1,$is[0]['from_inventory'],$is[0]['completion'],$aval['item_code'],$is[0]['locator_id']);
                }elseif(!empty($is) && $is[0]['from_inventory'] !== NULL){
                    $getItemTransaction = $this->M_dataplan->getItemTransaction(FALSE,$is[0]['from_inventory'],$is[0]['to_inventory'],$aval['item_code'],$is[0]['locator_id']);
                }

                if (!empty($getItemTransaction) && $getItemTransaction[0]['ACHIEVE_READY'] > 0) {

                    // ---- checking achieve qty di postg apakah kosong atau tidak----
                    if ($aval['achieve_qty'] !== null || $aval['achieve_qty'] !== 0) {
                        $kurang = $aval['need_qty'] - $aval['achieve_qty'];

                        // ---- checking achieve ready apakah lebih besar atau lebih kecil ----
                        if ($getItemTransaction[0]['ACHIEVE_READY'] > $kurang) {
                            $achieve_sisa   = $getItemTransaction[0]['ACHIEVE_READY'] - $kurang;
                            $achieve_qty    = $aval['achieve_qty']+$kurang;
                            $terpakai_baru  = $kurang;
                        }else{
                            $achieve_sisa   = 0;
                            $achieve_qty    = $aval['achieve_qty']+$getItemTransaction[0]['ACHIEVE_READY'];
                            $terpakai_baru  = $getItemTransaction[0]['ACHIEVE_READY'];
                        }
                    }else{

                        // ---- checking achieve ready apakah lebih besar atau lebih kecil ----
                        if ($getItemTransaction[0]['ACHIEVE_READY'] > $aval['need_qty']) {
                            $achieve_sisa   = $getItemTransaction[0]['ACHIEVE_READY'] - $aval['need_qty'];
                            $achieve_qty    = $aval['need_qty'];
                            $terpakai_baru  = $aval['need_qty'];
                        }else{
                            $achieve_sisa   = 0;
                            $achieve_qty    = $getItemTransaction[0]['ACHIEVE_READY'];
                            $terpakai_baru  = $getItemTransaction[0]['ACHIEVE_READY'];
                        }
                    }

                    $dataUpd = array(
                        'achieve_qty'       => $achieve_qty,
                        'last_delivery'     => $getItemTransaction[0]['LAST_DELIVERY'],
                        'last_updated_by'   => $user_id,
                        'last_updated_date' => date("Y-m-d H:i:s")
                    );
                    
                    // ---- Update achieve_QTY dan last deliv di postgre ----
                    $this->M_dataplan->update('pp.pp_daily_plans', 'daily_plan_id', $dataUpd, $aval['daily_plan_id']);

                    // ---- Update attributer10 di oracle utk tanda QTY yang sudah terpakai ----
                    if ($is[0]['from_inventory'] == NULL) {
                        $attrUpd = $this->M_monitoring->updateAttr10(1,$is[0]['from_inventory'],$is[0]['completion'],$aval['item_code'],$is[0]['locator_id'],$terpakai_baru,$getItemTransaction[0]['LAST_DELIVERY']);
                    }elseif($is[0]['from_inventory'] !== NULL){
                        $attrUpd = $this->M_monitoring->updateAttr10(FALSE,$is[0]['from_inventory'],$is[0]['to_inventory'],$aval['item_code'],$is[0]['locator_id'],$terpakai_baru,$getItemTransaction[0]['LAST_DELIVERY']);
                    }
                }
            }
        }

        $b = $this->M_dataplan->getDataPlan($id=false,$section);
        if (!empty($b)) {
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
                        <td style="width: 5%;">NO</td>
                        <td style="width: 15%;">ITEM</td>
                        <td style="width: 25%;">DESC</td>
                        <td>PRIOR</td>
                        <td>NEED QTY</td>
                        <td>DUE TIME</td>
                        <td>ACHIEVE QTY</td>
                        <td>LAST DELIVERY</td>
                        <td>STATUS</td>
                    </tr>
                </thead>';
            $no         = 1;
            $checkpoint = 1;
            if (!empty($high)) {
                echo '<tbody id="highPriority" style="font-weight: bold;">';
                foreach ($high as $h){
                    echo '<tr class="plan-undone-high">
                            <td>'.$no++.'</td>
                            <td>'.$h['item_code'].'</td>
                            <td>';
                                if (strlen($h['item_description']) > 25) {
                                    echo substr($h['item_description'],0,25).' ...';
                                }else{
                                    echo $h['item_description'];
                                }
                            echo '</td>
                            <td>';
                                if ($h['priority'] == 'NORMAL') {
                                    echo "N";
                                }else{
                                    echo $h['priority'];
                                }
                            echo '</td>
                            <td>'.$h['need_qty'].'</td>
                            <td>'.date('d/m H:i', strtotime($h['due_time'])).'</td>
                            <td>';
                                if ($h['achieve_qty'] == null) {
                                    echo "0";
                                }else{
                                    echo $h['achieve_qty'];
                                }
                            echo '</td>
                            <td>';
                                if ($h['last_delivery'] == null) {
                                    echo "-";
                                }else{
                                    echo $h['last_delivery'];
                                }
                            echo '</td>
                            <td>'.$h['status'].'</td>
                        </tr>';
                    $checkpoint++;
                }
                echo '</tbody>';
            }

            if (!empty($normal)) {
                echo '<input type="hidden" name="checkpointBegin" data-secid="'.$section.'" value="'.$checkpoint.'">
                <tbody id="normalPriority" style="font-weight: bold;">';
                foreach ($normal as $n ){
                    echo '<tr class="plan-undone-normal"';
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
                        <td>';
                            if (strlen($n['item_description']) > 25) {
                                echo substr($n['item_description'],0,25).' ...';
                            }else{
                                echo $n['item_description'];
                            }
                        echo '</td>
                        <td>';
                            if ($n['priority'] == 'NORMAL') {
                                echo "N";
                            }else{
                                echo $n['priority'];
                            }
                        echo '</td>
                        <td>'.$n['need_qty'].'</td>
                        <td>'.date('d/m H:i', strtotime($n['due_time'])).'</td>
                        <td>';
                            if ($n['achieve_qty'] == null) {
                                echo "0";
                            }else{
                                echo $n['achieve_qty'];
                            }
                        echo '</td>
                        <td>';
                            if ($n['last_delivery'] == null) {
                                echo "-";
                            }else{
                                echo $n['last_delivery'];
                            }
                        echo '</td>
                        <td>'.$n['status'].'</td>
                    </tr>';
                }
                echo '</tbody>
                    <input type="hidden" name="checkpointEnd" data-secid="'.$section.'" value="'.$checkpoint.'">';
            }
        }else{
            echo '<thead class="bg-primary" style="font-weight: bold; font-size: 14px;">
                    <tr>
                        <td style="width: 5%;">NO</td>
                        <td style="width: 15%;">ITEM</td>
                        <td style="width: 25%;">DESC</td>
                        <td>PRIOR</td>
                        <td>NEED QTY</td>
                        <td>DUE TIME</td>
                        <td>ACHIEVE QTY</td>
                        <td>LAST DELIVERY</td>
                        <td>STATUS</td>
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
        if (empty($achieve)) {
            echo "ACHIEVEMENT = 0 %";
        }else{
            echo "ACHIEVEMENT = ".$achieve[0]['percentage'];
        }
    }
}