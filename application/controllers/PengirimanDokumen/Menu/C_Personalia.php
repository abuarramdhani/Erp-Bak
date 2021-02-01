<?php

ini_set("memory_limit",-1);

class C_Personalia extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
            
        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
        $this->checkSession();

        $user_id = $this->session->userid;
        $this->load->model('PengirimanDokumen/M_inputdata');
        $this->load->model('PengirimanDokumen/M_personalia');
        

        $this->data['SubMenuOne'] = '';
        $this->data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $this->data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $this->data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $this->data['Menu'] = 'Approve Personalia';
    }

    function checkSession()
    {
        if (!$this->session->is_logged) {
            redirect();
        }
    }

    function PersonaliaOne(){
        //query pending 1,0
        $this->data['pending'] = $this->M_personalia->queryApprovalJumlah('pending',1);

        //query approved 1,1
        $this->data['approved'] = $this->M_personalia->queryApprovalJumlah('approved',1);

        //query rejected 1,2
        $this->data['rejected'] = $this->M_personalia->queryApprovalJumlah('rejected',1);

        $this->data['lv'] = 'One';

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_PersonaliaHome', $this->data);
        $this->load->view('V_Footer', $this->data);
        
    }

    function PersonaliaTwo(){
        //query pending 2,1
        $this->data['pending'] = $this->M_personalia->queryApprovalJumlah('pending',2);
        
        //query approved 2,3
        $this->data['approved'] = $this->M_personalia->queryApprovalJumlah('approved',2);
        
        //query rejected 2,4
        $this->data['rejected'] = $this->M_personalia->queryApprovalJumlah('rejected',2);

        $this->data['lv'] = 'Two';

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_PersonaliaHome', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function filter_dokumen_seksi($data){
        function filter_seksi($item){
            $kodesie = $_GET['seksi'];
            return $item['kd_sie'] == substr($kodesie, 0,7);
        }

        $filtered = array_filter($data, 'filter_seksi');
        return $filtered;
    }

    function filter_dokumen_lokasi($data){
        function filter_lokasi($item){
            $lk = $_GET['lokasi'];
            return $item['lokasi'] == $lk;
        }

        $filtered = array_filter($data, 'filter_lokasi');
        return $filtered;
    }

    function NewData($level){
        if($level == 1){
            $data = $this->M_personalia->queryApproval('pending',1);
        }else{
            $data = $this->M_personalia->queryApproval('pending',2);
        }

        $list_lokasi = $this->M_inputdata->getAllLoksi();
        $this->data['all_lokasi'] = array_column($list_lokasi, 'lokasi_kerja', 'id_');

        // filter seksi
        $this->data['is_get'] = false;
        $this->data['selected'] = false;
        if($this->input->get('seksi')){
            $data = $this->filter_dokumen_seksi($data);
            $this->data['is_get'] = true;
            $this->data['selected'] = substr($this->input->get('seksi'), 0, 7);
        }
        
        $this->data['c_lok'] = '00';
        if ($this->input->get('lokasi')) {
            $data = $this->filter_dokumen_lokasi($data);
            $this->data['c_lok'] = $this->input->get('lokasi');
        }
        $this->data['l_lokasi'] = $this->M_inputdata->getLokasi2();

        $this->data['seksi'] = $this->M_personalia->allSection();

        $this->data['table'] = $data;
        $this->data['lv']    = $level;

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_NewData', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function ajaxNewdata(){
        $level = $_GET['level'];
        if($level == 1){
            $data = $this->M_personalia->queryApproval('pending',1);
        }else{
            $data = $this->M_personalia->queryApproval('pending',2);
        }
        

        echo json_encode($data);
    }

    function Approved($level){
        $periode = $this->input->get('tanggal');
        if (isset($periode) && !empty($periode)) {
            $prd= explode(" - ", $periode);
            $start = $prd[0];
            $end = $prd[1];
        }else{
            $start = date('Y-m-d',strtotime(date('Y-m-d').' - 1 month'));
            $end = date('Y-m-d',strtotime(date('Y-m-d').' + 1 month'));
        }
        $this->data['start'] = $start;
        $this->data['end'] = $end;

        if($level == 1){
            $data = $this->M_personalia->queryApproval('approved',1,$start,$end);
        }else{
            $data = $this->M_personalia->queryApproval('approved',2,$start,$end);
        }
        // filter seksi
        $this->data['is_get'] = false;
        $this->data['selected'] = false;
        if($this->input->get('seksi')){
            $data = $this->filter_dokumen_seksi($data);
            $this->data['is_get'] = true;
            $this->data['selected'] = substr($this->input->get('seksi'), 0, 7);
        }

        $this->data['c_lok'] = '00';
        if ($this->input->get('lokasi')) {
            $data = $this->filter_dokumen_lokasi($data);
            $this->data['c_lok'] = $this->input->get('lokasi');
        }
        $this->data['l_lokasi'] = $this->M_inputdata->getLokasi2();

        $list_lokasi = $this->M_inputdata->getAllLoksi();
        $this->data['all_lokasi'] = array_column($list_lokasi, 'lokasi_kerja', 'id_');

        $this->data['seksi'] = $this->M_personalia->allSection();

        $this->data['table'] = $data;
        $this->data['lv']    = $level;
        $i=0;

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_Approved', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function Rejected($level){
        $periode = $this->input->get('tanggal');
        if (isset($periode) && !empty($periode)) {
            $prd= explode(" - ", $periode);
            $start = $prd[0];
            $end = $prd[1];
        }else{
            $start = date('Y-m-d',strtotime(date('Y-m-d').' - 1 month'));
            $end = date('Y-m-d',strtotime(date('Y-m-d').' + 1 month'));
        }
        $this->data['start'] = $start;
        $this->data['end'] = $end;
        
        if($level == 1){
            $data = $this->M_personalia->queryApproval('rejected',1,$start,$end);
        }else{
            $data = $this->M_personalia->queryApproval('rejected',2,$start,$end);
        }

        // filter seksi
        $this->data['is_get'] = false;
        $this->data['selected'] = false;
        if($this->input->get('seksi')){
            $data = $this->filter_dokumen_seksi($data);
            $this->data['is_get'] = true;
            $this->data['selected'] = substr($this->input->get('seksi'), 0, 7);
        }

        $this->data['c_lok'] = '00';
        if ($this->input->get('lokasi')) {
            $data = $this->filter_dokumen_lokasi($data);
            $this->data['c_lok'] = $this->input->get('lokasi');
        }
        $this->data['l_lokasi'] = $this->M_inputdata->getLokasi2();

        $list_lokasi = $this->M_inputdata->getAllLoksi();
        $this->data['all_lokasi'] = array_column($list_lokasi, 'lokasi_kerja', 'id_');

        $this->data['seksi'] = $this->M_personalia->allSection();

        $this->data['table'] = $data;
        $this->data['lv']    = $level;
        $i=0;
        
        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_Rejected', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function ApprovalData(){
        $idall  = $_POST['id_data'];
        $user   = $this->session->user;
        $level  = $_POST['level'];
        $stat   = $_POST['stat'];

        foreach($idall as $id){
            if($stat == 'approve'){
                $alasan = null;
                if($level == 1){
                    $status = 1;
                }else{
                    $status = 3;
                }
            }else{
                $alasan = $_POST['alasan'];
                if($level == 1){
                    $status = 2;
                }else{
                    $status = 4;
                }
            }

            //update tdata
            $data = array(
                'status' => $status,
                'alasan' => $alasan
            );
            $this->M_personalia->updateTdataById($data,$id);

            //insert ke triwayat
            $triwayat = array(
                'id_data' => $id,
                'status'  => $status,
                'user'    => $user,
                'level'   => $level,
                'seksi'   => substr($this->session->kodesie,0,7)
            );
            $this->M_personalia->insertRiwayat($triwayat); 
        };
    }

    //Menu Rekap
    function rekapAll($periode=false, $kodedokumen=false, $kodeseksi=false, $lokasi=false){
        $this->load->model('PengirimanDokumen/M_inputdata');
        $this->load->model('PengirimanDokumen/M_masterdata');

        $start = $end = date('Y-m-d');
        $info_periode = date('Y/m/d')." (Hari ini)";
        if(isset($_GET['periode'])){
            $range = explode(' - ', $_GET['periode']);
            $start = date('Y/m/d', strtotime($range['0']));
            $end   = date('Y/m/d', strtotime($range['1']));
            $info_periode = ($start == $end)? $start : $start." - ".$end;
        }

        $dokumen = '';
        if(isset($_GET['doc']) && $_GET['doc'] != 'all'){
            $kodedokumen = $_GET['doc'];
            $dokumen = "and tm.id='$kodedokumen'";
        }

        $seksi = '';
        if(isset($_GET['section']) && $_GET['section'] != 'all'){
            $kodeseksi = $_GET['section'];
            $seksi = "and substring(emp.section_code,0,8) = '$kodeseksi' ";
        }

        $lokasi = '';
        if(isset($_GET['lokasi']) && $_GET['lokasi'] != 'all'){
            $kodelokasi = $_GET['lokasi'];
            $lokasi = "and td.lokasi='$kodelokasi'";
        }


        $this->data['c_lok'] = '00';
        if ($this->input->get('lokasi')) {
            
            $this->data['c_lok'] = $this->input->get('lokasi');
        }
        $this->data['l_lokasi'] = $this->M_inputdata->getLokasi2();

        $list_lokasi = $this->M_inputdata->getAllLoksi();
        $this->data['all_lokasi'] = array_column($list_lokasi, 'lokasi_kerja', 'id_');

        $table = $this->M_personalia->getRekap($start,$end,$dokumen,$seksi,$lokasi);


        for($i=0; $i < count($table); $i++){
            $table[$i]['kodesie'] = $this->M_inputdata->getNameSeksi($table[$i]['kodesie']);
            if (in_array($table[$i]['status'], array('1','3'))) {
                $table[$i]['status'] = 'Diterima oleh seksi '.$this->M_inputdata->getNameSeksi($table[$i]['approver']);
            }else{
                $table[$i]['status'] = 'Ditolak oleh seksi '.$this->M_inputdata->getNameSeksi($table[$i]['approver']).' dengan alasan '.$table[$i]['alasan'];
            }
            $table[$i]['tgl_app'] = date('d/m/Y H:i:s', strtotime($table[$i]['app_time']));
        }

        $this->data['listDocument'] = $this->M_inputdata->ajaxListMaster();
        $this->data['listSeksi']    = $this->M_masterdata->ajaxSeksi();
        $this->data['table']        = $table;
        $this->data['info_periode'] = $info_periode;

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_Rekap', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function changeApproval(){
        $id         = $_POST['id']; 
        $approval   = $_POST['app'];
        $alasan     = $_POST['alasan'];
        $kodesie    = substr($this->session->kodesie,0,7);

        $this->M_personalia->changeApproval($id,$kodesie,$approval,$alasan);
        echo true;
    }

}

// its your mission to move query to model :)
