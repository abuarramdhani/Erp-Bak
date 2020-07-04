<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_settingMinMaxOPM extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        //load the login model
        $this->load->library('session');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('SettingMinMaxOPM/M_settingminmaxopm');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    //------------------------show the dashboard-----------------------------
    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_Index');
        $this->load->view('V_Footer', $data);
    }

    public function getRouteODM()
    {
        $data = $this->M_settingminmaxopm->TampilRoutingClassODM();
        echo '<option></option>';
        foreach ($data as $route) {
            echo '<option>'.$route['ROUTING_CLASS'].'</option>';
        }
    }
    public function getRouteOPM()
    {
        $data = $this->M_settingminmaxopm->TampilRoutingClass();
        echo '<option></option>';
        foreach ($data as $route) {
            echo '<option>'.$route['ROUTING_CLASS'].'</option>';
        }
    }

    public function Edit()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_Tampil');
        $this->load->view('V_Footer', $data);
    }

    public function IE()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_TampilIE');
        $this->load->view('V_Footer', $data);
    }

    public function EditbyRoute()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        if ($this->session->flashdata('route') == null) {
            $org = $this->input->post('org');
            $route = $this->input->post('routing_class');
        } elseif ($this->session->flashdata('route') != null) {
            $org = $this->session->flashdata('org');
            $route = $this->session->flashdata('route');
        }


        $data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();
        if ($org == 'OPM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
        } elseif ($org == 'ODM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMaxODM($route);
        }
        $data['org'] = $org;
        $data['routeaktif'] = $route;

        if ($data['minmax'] == null) {
            $this->session->set_flashdata('kosong', 'Mohon Untuk Input Ulang');
            redirect(base_url('SettingMinMax/Edit/'));
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_Tampil_byRoute');
        $this->load->view('V_Footer', $data);
    }

    public function SaveLimit()
    {
        echo "<pre>";
        print_r($_POST);
        exit();
        $org = $_POST['org'];
        $route = $_POST['route'];
        $panjang = count($_POST['seg1']);
        echo "<pre>";
        echo $panjang;
        echo "<pre>";
        echo $org;
        echo "<pre>";
        echo $route;
        for ($i=0; $i < $panjang; $i++) {
            $itemcode = $_POST['seg1'][$i];
            if (array_key_exists("limitjob", $_POST)) {
                if (array_key_exists($i, $_POST['limitjob'])) {
                    $limit = 'Y';
                } else {
                    $limit = null;
                }
            } else {
                $limit = null;
            }

            $data =$this->M_settingminmaxopm->savebulk($itemcode, $limit);
            echo "<pre>";
            echo "item : ".$itemcode;
            echo "<pre>";
            echo "limit : ".$limit;
        }
        // echo $data;
        exit();
        $this->session->set_flashdata('org', $org);
        $this->session->set_flashdata('route', $route);
        redirect(base_url('SettingMinMax/EditbyRoute/'));
    }

    public function updateKilat()
    {
        $data = $this->input->post('data');
        $code = $this->input->post('code');
        $this->M_settingminmaxopm->savebulk($code, $data);
        echo json_encode($code);
    }

    public function EditbyRouteIE()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        if ($this->session->flashdata('route') == null) {
            $org = $this->input->post('org');
            $route = $this->input->post('routing_class');
        } elseif ($this->session->flashdata('route') != null) {
            $org = $this->session->flashdata('org');
            $route = $this->session->flashdata('route');
        }


        $data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();
        if ($org == 'OPM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
        } elseif ($org == 'ODM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMaxODM($route);
        }
        $data['org'] = $org;
        $data['routeaktif'] = $route;

        if ($data['minmax'] == null) {
            $this->session->set_flashdata('kosong', 'Mohon Untuk Input Ulang');
            redirect(base_url('SettingMinMax/IE/'));
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_Tampil_byRouteIE');
        $this->load->view('V_Footer', $data);

        // echo"<pre>";
        // print_r($data);
        // exit();
    }

    public function EditItem($org, $route, $itemcode)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['routeaktif'] = $route;
        if ($org == 'ODM') {
            $data['item_minmax'] = $this->M_settingminmaxopm->TampilDataItemMinMaxODM($route, $itemcode);
        } elseif ($org == 'OPM') {
            $data['item_minmax'] = $this->M_settingminmaxopm->TampilDataItemMinMax($route, $itemcode);
        }
        $data['org'] = $org;
        $data['No_induk'] = $this->session->user;
        ;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_Tampil_Edit_Minmax');
        $this->load->view('V_Footer', $data);
    }

    public function SaveMinMax()
    {
        // echo "<pre>";
        // print_r($_POST['limitjob']);
        // exit();
        $org = $this->input->post('org');
        $induk = $this->input->post('induk');
        $route = $this->input->post('route');
        $itemcode = $this->input->post('segment1');
        $min 	= $this->input->post('min');
        $max 	= $this->input->post('max');
        $rop 	= $this->input->post('rop');
        if (array_key_exists("limitjob", $_POST)) {
            $limit = 'Y';
        // echo "ada";
        } else {
            $limit = null;
            // echo "tidak ada";
        }


        $data =$this->M_settingminmaxopm->save($itemcode, $min, $max, $rop, $induk, $limit);

        // echo $data;
        // exit()
        $this->session->set_flashdata('org', $org);
        $this->session->set_flashdata('route', $route);
        redirect(base_url('SettingMinMax/EditbyRoute/'));
    }

    //upload file ke tmp
    private function do_upload($filename)
    {
        if (!is_dir('./tmp')) {
            mkdir('./tmp', 0777, true);
            chmod('./tmp', 0777);
        }

        $config['upload_path']          = './tmp/';
        $config['allowed_types']        = 'csv|xls|xlxs';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['overwrite'] 			= true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (! $this->upload->do_upload($filename)) {
            $error = array('error' => $this->upload->display_errors());
        // $this->load->view('upload_form', $error);
                // echo "<pre>";
                // print_r($error);exit()
        } else {
            $data = array('upload_data' => $this->upload->data());
            // $this->load->view('upload_success', $data);
                // echo "Berhasil";
        }
    }

    public function Import()
    {
        if (isset($_POST)) {
            $fileUpload = $_FILES['fileCsv']['tmp_name'];

            try {
                $inputFileName = str_replace(" ", "_", $fileUpload);
                $filetype = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($filetype);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);

                $readData = array();
                $tmpData = array();
                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                    $worksheetTitle = $worksheet->getTitle();
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn =  $worksheet->getHighestColumn();
                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                    $nsColumn = ord($highestColumn) - 64;

                    $index = 1;
                    for ($row=3; $row <= $highestRow ; $row++) {
                        $val = array();
                        for ($col=1; $col <= $highestColumnIndex ; $col++) {
                            $cell = $worksheet->getCellByColumnAndRow($col, $row);
                            $val[]= $cell->getValue();
                        }

                        $tmpData = array(
                            'SEGMENT1' => $val[0],
                            'DESCRIPTION' => $val[1],
                            'PRIMARY_UOM_CODE' => $val[2],
                            'MIN' => $val[3],
                            'MAX' => $val[4],
                            'ROP' => $val[5],
                            'LIMITJOB' => $val[6]

                        );

                        // echo "<pre>";
                        // print_r()
                        //insert to db? by row
                        array_push($readData, $tmpData);
                        $this->M_settingminmaxopm->saveImport(
                            $tmpData['SEGMENT1'],
                            $tmpData['MIN'],
                            $tmpData['MAX'],
                            $tmpData['ROP'],
                            $tmpData['LIMITJOB']
                        );
                    }
                }

                echo json_encode($readData);
                // echo 1;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }


    public function serversideMinMax()
    {
        $org = $this->input->post('org');
        $route = $this->input->post('route');

        $data['org'] = $org;
        $data['routeaktif'] = $route;

        if ($org == 'OPM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
        } elseif ($org == 'ODM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMaxODM($route);
        }

        $this->load->view('SettingMinMaxOPM/Ajax/V_ajax', $data);

    }

    public function serversideMinMaxIE()
    {
        $org = $this->input->post('org');
        $route = $this->input->post('route');

        $data['org'] = $org;
        $data['routeaktif'] = $route;

        if ($org == 'OPM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
        } elseif ($org == 'ODM') {
            $data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMaxODM($route);
        }

        $this->load->view('SettingMinMaxOPM/Ajax/V_ajaxIE', $data);

    }

    public function generateOptionTahun()
    {
        $tahun = date("Y");
        $option[10] = $tahun;
        for ($i=1; $i <= 10; $i++) { 
            $option[10+$i] = $tahun+$i;
            $option[10-$i] = $tahun-$i;
        }
        return $option;
    }

    public function effectiveDays()
    {   $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


        $user = $this->session->user;
        $optionTahun = $this->generateOptionTahun();
        ksort($optionTahun);
        $data['optionTahun'] = $optionTahun;

        $dataEfektif = $this->M_settingminmaxopm->tampilDataEfektif();
        $data['HariEfektif'] = $dataEfektif;
        $data['user'] = $user;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('SettingMinMaxOPM/V_EffectiveDays', $data);
        $this->load->view('V_Footer', $data);
        
    }

    public function SaveHariEffektif(){
        $tahun = $this->input->post('tahun');
        $jan = $this->input->post('januari');
        $feb = $this->input->post('februari');
        $mar = $this->input->post('maret');
        $apr = $this->input->post('april');
        $mei = $this->input->post('mei');
        $jun = $this->input->post('juni');
        $jul = $this->input->post('juli');
        $agu = $this->input->post('agustus');
        $sep = $this->input->post('september');
        $okt = $this->input->post('oktober');
        $nov = $this->input->post('november');
        $des = $this->input->post('desember');
        $user = $this->input->post('user');

        $isYearExist = $this->cekYearExist($tahun);
        if ($isYearExist === TRUE) {
            $this->M_settingminmaxopm->updateEffectiveday($tahun, $jan, $feb, $mar, $apr, $mei, $jun, $jul, $agu, $sep, $okt, $nov, $des, $user);
        } elseif ($isYearExist === FALSE) {
            $this->M_settingminmaxopm->saveEffectiveday($tahun, $jan, $feb, $mar, $apr, $mei, $jun, $jul, $agu, $sep, $okt, $nov, $des, $user);
        }
        // echo "<pre>";
        // print_r($hasil);
        // exit();



        redirect('SettingMinMax/Efectivedays');
    }

    public function cekYearExist($tahun){
        $exist = $this->M_settingminmaxopm->isYearExist($tahun);
        if ($exist > 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


}
