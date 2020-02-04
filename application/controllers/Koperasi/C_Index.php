<?php
defined('BASEPATH') OR die('accessing error');

class C_Index extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        if(!$this->session->is_logged){
           redirect('/') ;
        }

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('Koperasi/M_koperasi');
    }

    function index() {
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Koperasi';

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Koperasi/V_Index');
        $this->load->view('Koperasi/V_Footer');
    }

    // to uploading file .dbf only
    function uploadFile() {
        $periode = $this->input->post('periode');
        // check periode
        $exist = $this->M_koperasi->checkPeriode($periode);

        if($exist){
            $result = array(
                'success' => false,
                'message' => 'Sudah ada data di periode '.$periode
            );
            echo json_encode($result);
            return false;
        }

        $get_ext = explode('.', $_FILES['file']['name']);
        if(strtolower(end($get_ext)) != 'DBF'){
            $result = array(
                'success' => false,
                'message' => 'Format file tidak diizinkan'
            );
        }

        $filename = date('Y-m', strtotime('01-'.$periode));
        // uploading file to asset
        $config['upload_path']          = './assets/upload/Koperasi/';
        $config['allowed_types']        = '*';
        $config['file_name']            = $filename.'.DBF'; // 2019-01
        $config['encrypt_name'] = TRUE;
        $config['overwrite']			= true;
        $config['max_size']             = 1024 * 10; // 10mb
        $this->load->library('upload', $config);

        $this->upload->do_upload('file');

        $parsed = $this->parseDBF($config['upload_path'].$config['file_name']);

        $result = array(
            'success' => true,
            'message' => $parsed
        );
        echo json_encode($result);
    }

    function saveToDatabase() {
        date_default_timezone_set("Asia/Jakarta");
        $periode = $this->input->post('periode');
        $shortPeriode = date('Y-m', strtotime('01-'.$periode));
        $user = $this->session->user;
        
        $fileName = $shortPeriode.'_'.date('YmdHis').'.DBF';
        $pathFile =  "./assets/upload/Koperasi/".$fileName;

        // rename file
        rename('./assets/upload/Koperasi/'.$shortPeriode.'.DBF', $pathFile);

        // check periode
        $exist = $this->M_koperasi->checkPeriode($shortPeriode);

        if($exist){
            $result = array(
                'success' => false,
                'message' => 'Sudah ada data di periode '.$periode
            );
            echo json_encode($result);
            return false;
        }

        // why this array started at 1 :u
        $data = $this->parseDBF($pathFile);
        $dataLength = count($data);

        $resultArray = array();
        for($x = 1; $x <= $dataLength; $x++) {
            $data[$x]['periode'] = "$shortPeriode";
            $data[$x]['upload_by'] = $user;
            $data[$x]['path_name'] = $fileName;

            // change index to lowercase
            $resultArray[] =  array_change_key_case($data[$x],CASE_LOWER);
        }

        foreach($resultArray as $item) {
            $this->M_koperasi->insertData($item);
        }

        $result = array(
            'success' => true,
            'message' => 'Sukses menyimpan data'
        );
        echo json_encode($result);
    }

    // parse dbf file to array
    function parseDBF($file) {
        // load third party
        require_once APPPATH."third_party/phpxbase/Column.php";
        require_once APPPATH."third_party/phpxbase/Record.php";
        require_once APPPATH."third_party/phpxbase/Memo.php";
        require_once APPPATH."third_party/phpxbase/Table.php";
        
        $table = new Xbase\Table($file);
        $row = 1;
        $data = [];

        while ($record=$table->nextRecord()) {
            foreach ($table->getColumns() as $i=>$c) {
                if($c->name == 'NO'){
                    continue;
                }
                $data[$row][$c->name] = $record->getString($c->name) ? $record->getString($c->name) : null;
            }
            $row++;
        }

        $table->close();
        return $data;
    }

    function getList() {
        $data = $this->M_koperasi->getList();
        echo json_encode($data);
    }

    function getListDetail() {
        $periode = $this->input->post('periode');
        $data = $this->M_koperasi->getListDetail($periode);
        echo json_encode($data);
    }

    function delList() {
        $periode = $this->input->post('periode');
        $result = $this->M_koperasi->delList($periode);
        echo json_encode(array(
            'success' => $result
        ));
    }
}
