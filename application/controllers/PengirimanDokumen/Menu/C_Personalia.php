<?php

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
        $this->personalia = $this->load->database('personalia', true);

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

    function queryApproval($status, $level){ //nak ngene aku yo rakuat
        $kodesie = substr($this->session->kodesie, 0, 7);

        if($status == 'pending'){
            if($level == 1){
                $stat = '0';
                $where = "ap.kodesie='$kodesie' and ap.tingkat='$level' and td.status='$stat'";
            }else{
                $stat = '1';
                $where = "ap.kodesie='$kodesie' and ap.tingkat='$level' and tr.status='$stat' and td.status='$stat'";
            }

            $selecta = "SELECT td.id_data, 
                                td.noind, 
                                emp.employee_name nama,
                                substring(emp.section_code,0,8) kd_sie,
                                tm.keterangan, 
                                td.tanggal_start::date, 
                                td.tanggal_end::date,tr.status, 
                                max(tr.tgl_update)::date tgl_update, 
                                ap.kodesie, 
                                td.alasan,
                                td.lokasi,
                                ( select distinct coalesce(nullif(section_name, '-'), nullif(unit_name, '-'), nullif(field_name, '-'), nullif(department_name, '-')) 
                                  from er.er_section es inner join er.er_employee_all emp on substring(emp.section_code, 0,8) = substring(es.section_code,0,8)
                                  where emp.employee_code = td.noind limit 1
                                ) 
                                seksi_name
                        FROM ps.tdata td 
                                inner join ps.tappr ap on td.id_master = ap.id 
                                inner join ps.tmaster tm on tm.id = td.id_master
                                inner join ps.triwayat tr on tr.id_data = td.id_data
                                inner join er.er_employee_all emp on emp.employee_code = td.noind 
                        WHERE $where
                        GROUP BY td.id_data,td.noind, emp.employee_name, emp.section_code, tm.keterangan, td.tanggal_start, td.tanggal_end, tr.status, ap.kodesie, td.alasan, seksi_name, td.lokasi
            ;";
        }else{
            if ($status == 'approved') {
                if ($level == 1) {
                    $stat = '1';
                } else {
                    $stat = '3';
                }
            } else {
                if ($level == 1) {
                    $stat = '2';
                } else {
                    $stat = '4';
                }
            }

            $selecta = "SELECT td.id_data,
                                td.noind, 
                                emp.employee_name nama,
                                substring(emp.section_code, 0,8) kd_sie, 
                                tm.keterangan, 
                                td.tanggal_start::date, 
                                td.tanggal_end::date, 
                                tr.status,
                                max(tr.tgl_update)::date tgl_update, 
                                tr.seksi,
                                td.alasan,
                                td.lokasi,
                                ( select distinct coalesce(nullif(section_name, '-'), nullif(unit_name, '-'), nullif(field_name, '-'), nullif(department_name, '-')) 
                                  from er.er_section es inner join er.er_employee_all emp on substring(emp.section_code, 0,8) = substring(es.section_code,0,8)
                                  where emp.employee_code = td.noind limit 1
                                ) 
                                seksi_name
                        FROM ps.tdata td
                            inner join ps.tmaster tm on tm.id = td.id_master 
                            inner join ps.triwayat tr on tr.id_data = td.id_data 
                            inner join er.er_employee_all emp on emp.employee_code = td.noind 
                        WHERE tr.seksi='$kodesie' and tr.status = '$stat' and tr.level='$level' 
                        GROUP BY td.id_data,td.noind, emp.employee_name, emp.section_code, tm.keterangan, td.tanggal_start, td.tanggal_end, tr.status, tr.seksi, td.alasan, seksi_name,td.lokasi;
                        ";
        }
        
        return $this->db->query($selecta);
    }

    function getNameSeksiByNoind($noind){
        $sql = "SELECT kodesie FROM hrd_khs.tpribadi WHERE noind ='$noind' and keluar='0'";
        $kodesie = substr($this->personalia->query($sql)->row()->kodesie, 0, 7);

        $sql = "SELECT distinct seksi FROM hrd_khs.tseksi where substr(kodesie,0,8) = '$kodesie'";
        return $this->personalia->query($sql)->row()->seksi;
    }

    function PersonaliaOne(){
        //query pending 1,0
        $this->data['pending'] = $this->queryApproval('pending',1)->num_rows();

        //query approved 1,1
        $this->data['approved'] = $this->queryApproval('approved',1)->num_rows();

        //query rejected 1,2
        $this->data['rejected'] = $this->queryApproval('rejected',1)->num_rows();

        $this->data['lv'] = 'One';

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_PersonaliaHome', $this->data);
        $this->load->view('V_Footer', $this->data);
        
    }

    function PersonaliaTwo(){
        //query pending 2,1
        $this->data['pending'] = $this->queryApproval('pending',2)->num_rows();
        
        //query approved 2,3
        $this->data['approved'] = $this->queryApproval('approved',2)->num_rows();
        
        //query rejected 2,4
        $this->data['rejected'] = $this->queryApproval('rejected',2)->num_rows();

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

    function allSection(){
		$sql = "select kodesie, coalesce(nullif(trim(seksi), '-'), nullif(trim(unit),'-'), nullif(trim(bidang),'-'), dept) as nama from hrd_khs.tseksi where substring(kodesie, 8,11) = '00' and trim(seksi) <> '-' order by 1";
        return $this->personalia->query($sql)->result_object();
    }

    function NewData($level){
        if($level == 1){
            $data = $this->queryApproval('pending',1)->result_array();
        }else{
            $data = $this->queryApproval('pending',2)->result_array();
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

        $this->data['seksi'] = $this->allSection();

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
            $data = $this->queryApproval('pending',1)->result_array();
        }else{
            $data = $this->queryApproval('pending',2)->result_array();
        }
        

        echo json_encode($data);
    }

    function Approved($level){
        if($level == 1){
            $data = $this->queryApproval('approved',1)->result_array();
        }else{
            $data = $this->queryApproval('approved',2)->result_array();
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

        $this->data['seksi'] = $this->allSection();

        $this->data['table'] = $data;
        $this->data['lv']    = $level;
        $i=0;

        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/Personalia/V_Approved', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function Rejected($level){
        if($level == 1){
            $data = $this->queryApproval('rejected',1)->result_array();
        }else{
            $data = $this->queryApproval('rejected',2)->result_array();
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

        $this->data['seksi'] = $this->allSection();

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

        foreach($idall as $id):
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
            $sql = "UPDATE ps.tdata set status='$status', alasan='$alasan' where id_data='$id'";
            $this->db->query($sql);

            //insert ke triwayat
            $triwayat = array(
                'id_data' => $id,
                'status'  => $status,
                'user'    => $user,
                'level'   => $level,
                'seksi'   => substr($this->session->kodesie,0,7)
            );

            $this->db->insert('ps.triwayat', $triwayat);
        endforeach;
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



        $selectRekap = 
        "SELECT td.id_data, 
                td.noind, 
                emp.employee_name nama, 
                substring(emp.section_code,0,8) kodesie, 
                tm.id, 
                tm.keterangan, 
                td.status,
                (case when td.lokasi='01' then concat('JOGJA')  when td.lokasi='02' then concat('TUKSONO') else concat('-') end) as lok,
                td.tanggal_start::date, 
                td.tanggal_end::date, 
                tr.seksi as approver,
                tr.tgl_update as app_time
        FROM ps.tdata td 
            inner join er.er_employee_all emp on td.noind = emp.employee_code 
            inner join ps.tmaster tm on td.id_master = tm.id 
            inner join ps.triwayat tr on tr.id_data = td.id_data
        WHERE tanggal_end between '$start' and '$end' 
            and td.status not in ('0','2','4') 
            and tr.level = (select max(level) from ps.triwayat where id_data = td.id_data) 
            $dokumen 
            $seksi 
            $lokasi
        ORDER BY tanggal_end asc"; //query nya yang  ini ?
        //mungkin tapi kok query ada di controller
        //echo $selectRekap;exit();

        $table = $this->db->query($selectRekap)->result_array();

        for($i=0; $i < count($table); $i++){
            $table[$i]['kodesie'] = $this->M_inputdata->getNameSeksi($table[$i]['kodesie']);
            $table[$i]['status'] = 'Diterima oleh seksi '.$this->M_inputdata->getNameSeksi($table[$i]['approver']);
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

    function changeApproval(){ ///// thisss errooor
        $id         = $_POST['id']; 
        $approval   = $_POST['app'];
        $alasan     = $_POST['alasan'];
        $kodesie    = substr($this->session->kodesie,0,7);
        $user       = $this->session->user_id;

        $sql = "SELECT level FROM ps.triwayat WHERE id_data = '$id' AND seksi = '$kodesie' AND level <> '0' ;";
        $level = $this->db->query($sql)->row()->level;
        if($level == 1){
            if($approval == 'true'){ //true
                $sql  = "UPDATE ps.tdata SET status='1', alasan='' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status='1' WHERE id_data='$id' AND level = '$level';";
            }else{
                $sql  = "UPDATE ps.tdata set status='2', alasan='$alasan' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status = '2' WHERE id_data='$id' AND level = '1';";
                $sql .= "UPDATE ps.triwayat SET status = '4' WHERE id_data='$id' AND level = '2';";
            }
        }else{
            if($approval == 'true'){ //true
                $sql  = "UPDATE ps.tdata set status='3', alasan='' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status = '3' WHERE id_data='$id' AND level = '$level';";
            }else{
                $sql  = "UPDATE ps.tdata SET status='4', alasan='$alasan' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status = '2' WHERE id_data='$id' AND level = '1';";
                $sql .= "UPDATE ps.triwayat SET status = '4' WHERE id_data='$id' AND level = '2';";
            }
        }

        $this->db->query($sql);
        echo true;
    }

}

// its your mission to move query to model :)
