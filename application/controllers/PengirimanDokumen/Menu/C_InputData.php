<?php 

class C_InputData extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PengirimanDokumen/M_inputdata');    

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }

        $this->checkSession();
        
        $user_id = $this->session->userid;

        $this->data['SubMenuOne'] = '';
        $this->data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $this->data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $this->data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    }

    function checkSession()
    {
        if (!$this->session->is_logged) {
            redirect();
        }
    }

    function index(){
        $data = $this->ajaxShowInput('array');
        $kodesie = substr($this->session->kodesie,0,7);
        $this->data['seksi'] = ucwords(strtolower($this->M_inputdata->getNameSeksi($kodesie)));
// echo "<pre>";print_r($data);die;
        $table = '';
        $i = 0;
        foreach($data as $res){
            $i++;
            $id         = $res['id_data'];
            $noind      = $res['noind'];
            $nama       = $res['nama'];
            $ket        = $res['keterangan'];
            $tgl_input  = $res['tgl_input'];
            $tanggal    = $res['tanggal'];
            $status     = $res['status'];
            $alasan     = $res['alasan'];
            $approver1  = $res['approver1'];
            $approver2  = $res['approver2'];

            switch($status){
                case '0':
                    $status = '<td class="bg-yellow">Pending</td>';
                    break;
                case '1':
                    $status = '<td class="bg-blue">Approve by '.ucwords(strtolower($approver1)).'</td>';
                    if($approver2 === ''){
                        $status = '<td class="bg-green">Approve by '.ucwords(strtolower($approver1)).'</td>';
                    }
                    break;
                case '2':
                    $status = '<td class="bg-red">Reject by '.ucwords(strtolower($approver1)).'</td>';
                    break;
                case '3':
                    $status = '<td class="bg-green">Approve by '.ucwords(strtolower($approver2)).'</td>';
                    break;
                case '4':
                    $status = '<td class="bg-red">Reject by '.ucwords(strtolower($approver2)).'</td>';
                    break;
                default:
                    $status = 'null';
            }

            if($alasan == null){
                $alasan =  '';
            }else if(strlen($alasan) > 20){
                $alasan =  substr($alasan,0,20).'...';
            }

            $table .=   "<tr>
                            <td>$i</td>
                            <td>$noind</td>
                            <td>$nama</td>
                            <td class='detail' data-id='$id' data-app1='$approver1' data-app2='$approver2'>$ket</td>
                            <td>$tgl_input</td>
                            <td>$tanggal</td>
                            $status
                            <td>$alasan</td>
                        </tr>";
        }

        $this->data['table'] = $table;

        $this->data['Menu'] = 'Input Data';
        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/V_InputData', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function ajaxShowInput($type=false){
        $kodesie = substr($this->session->kodesie,0,7);

        $result = $this->M_inputdata->ajaxShowInput($kodesie);
        
        if($type){
            return $result;
        }
        echo json_encode($result);
    }

    function ajaxNoind(){
        $params     = strtoupper($_GET['params']);
        $result     = $this->M_inputdata->ajaxNoInd($params);

        echo json_encode($result);
    }

    function ajaxListMaster(){
        $result = $this->M_inputdata->ajaxListMaster();

        echo json_encode($result);
    }

    function ajaxInputData(){
        $noind      = $_POST['noind'];
        
        $allNoind   = explode(',', $noind);
        
        foreach($allNoind as $noind){
            $id_master  = $_POST['ket'];
            $date       = $_POST['date'];
    
            $this->M_inputdata->ajaxInputData($noind,$id_master,$date);
        }

    }

    function ajaxShowDetail(){
        $id = $_GET['id'];

        //return nama seksi 1, 2 & riwayatnya
        $result = $this->M_inputdata->ajaxShowDetail($id);
        $countApproval = $this->M_inputdata->countApproval($result['0']['id_master']);
        
        $htmlHistory = '';
        foreach($result as $item){
            $user = $item['user'];
            $name = $this->M_inputdata->getNameByNoind($user);
            $time = date('Y-m-d H:i:s', strtotime($item['tgl_update']));

            $status = $item['status']; 
            if($status == 0){
                $font = "class='font-orange'";
                $action = 'Create';
            }elseif($status == 1 || $status == 3){
                $font = "class='font-green'";
                if($status == 1 && $countApproval == 2){
                    $font = "class='font-blue'";
                }
                $action = 'Approved';                
            }else{
                $font = "class='font-red'";
                $action = 'Rejected';
            }

            $level = $item['level'];
            if($level == 0){
                $ket = "User | ";
            }elseif($level == 1){
                $ket = "Approver 1 | ";
            }else{
                $ket = "Approver 2 | ";
            }

            $htmlHistory .= "<p $font>($time) -> $ket $user - $name $action</p>";
        }
        echo $htmlHistory;
    }
}
