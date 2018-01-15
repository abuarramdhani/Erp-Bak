<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StorageMonitoring extends CI_Controller {

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
        $this->load->model('ProductionPlanning/MainMenu/M_storagemonitoring');
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
        $data['storagepp']      = $this->M_storagemonitoring->getStoragePP();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('ProductionPlanning/MainMenu/StorageMonitoring/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

    public function Open()
    {
        $storage_name = $this->input->post('storage_name');
        $data['storage']	= $this->M_storagemonitoring->getStoragePP($storage_name);
        $datplan            = $this->M_storagemonitoring->getPlanStorage($storage_name);
        $data['achieveAll'] = $this->M_monitoring->getAchievementAllFab();
        $data['stgAchieve'] = $this->M_storagemonitoring->getDailyAchieve($storage_name);

        $h = 0;
        $n = 0;

        if (empty($datplan)) {
            $data['highPriority']   = false;
            $data['normalPriority'] = false;
        }else{
            $data['highPriority']   = array();
            $data['normalPriority'] = array();
            foreach ($datplan as $dp) {
                if ($dp['priority'] == '1') {
                    $data['highPriority'][$h++] = $dp;
                }else{
                    $data['normalPriority'][$n++] = $dp;
                }
            }
        }

        $this->load->view('ProductionPlanning/MainMenu/StorageMonitoring/V_StorageMonitoring',$data);
    }

    public function getAchievement()
    {
        $storage_name  = $this->input->post('storage_name');
        $achieve = $this->M_storagemonitoring->getDailyAchieve($storage_name);
        if (empty($achieve)) {
            echo "ACHIEVEMENT = 0 %";
        }else{
            echo "ACHIEVEMENT = ".$achieve[0]['percentage'];
        }
    }

    public function getDailyPlanStg()
    {
        $storage_name  = $this->input->post('storage_name');

        $b = $this->M_storagemonitoring->getPlanStorage($storage_name);
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
                        <td>NO</td>
                        <td style="width: 15%;">ITEM</td>
                        <td>DESC</td>
                        <td>PRIORITY</td>
                        <td>NEED QTY</td>
                        <td style="width: 15%;">DUE TIME</td>
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
                                if (strlen($h['item_description']) > 15) {
                                    echo substr($h['item_description'],0,15).' ...';
                                }else{
                                    echo $h['item_description'];
                                }
                            echo '</td>
                            <td>'.$h['priority'].'</td>
                            <td>'.$h['need_qty'].'</td>
                            <td>'.$h['due_time'].'</td>
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
                echo '<input type="hidden" name="checkpointBegin" value="'.$checkpoint.'">
                <tbody id="normalPriority" style="font-weight: bold;">';
                foreach ($normal as $n ){
                    echo '<tr class="plan-undone-normal"';
                        if ($checkpoint > 12) {
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
                            if (strlen($n['item_description']) > 15) {
                                echo substr($n['item_description'],0,15).' ...';
                            }else{
                                echo $n['item_description'];
                            }
                        echo '</td>
                        <td>'.$n['priority'].'</td>
                        <td>'.$n['need_qty'].'</td>
                        <td>'.$n['due_time'].'</td>
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
                    <input type="hidden" name="checkpointEnd" value="'.$checkpoint.'">';
            }
        }else{
            echo '<thead class="bg-primary" style="font-weight: bold; font-size: 14px;">
                    <tr>
                        <td>NO</td>
                        <td style="width: 15%;">ITEM</td>
                        <td>DESC</td>
                        <td>PRIORITY</td>
                        <td>NEED QTY</td>
                        <td style="width: 15%;">DUE TIME</td>
                        <td>ACHIEVE QTY</td>
                        <td>LAST DELIVERY</td>
                        <td>STATUS</td>
                    </tr>
                </thead>';
        }
    }
}