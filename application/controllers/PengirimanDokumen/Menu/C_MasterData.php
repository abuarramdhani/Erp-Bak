<?php 

class C_MasterData extends CI_Controller
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

        $this->load->model('PengirimanDokumen/M_masterdata');

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
        $data = $this->ajaxShowMaster('array');
        
        $table = '';
        $i = 0;
        foreach ($data as $res) {
            $i++;
            $id         = $res['id'];
            $id_master  = $res['id_master'];
            $ket        = $res['keterangan'];
            $kodesie1   = $res['kodesie1'];
            $kodesie2   = $res['kodesie2'];
            $seksi1     = $res['seksi1'];
            $seksi2     = $res['seksi2'];

            $table .= "<tr>
                        <td class='id'>$i</td>
                        <td class='code' data-id='$id'>$id_master</td>
                        <td class='ket'>$ket</td>
                        <td class='level1' data-kodesie='$kodesie1'>$seksi1</td>
                        <td class='level2' data-kodesie='$kodesie2'>$seksi2</td>
                        <td><button onclick='editMaster($id, $(this))' data-toggle='modal' data-target='#modalMaster' class='btn btn-sm btn-success'><i class='fa fa-edit'></i> edit</button>&nbsp<button onclick='deleteMaster($id)' class='btn btn-sm btn-danger' ><i class='fa fa-trash'></i>delete</button></td>
                    </tr>";
        }
        $this->data['table'] = $table;

        $this->data['Menu'] = 'Dashboard Pengiriman Dokumen';
        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/Menu/V_MasterData', $this->data);
        $this->load->view('V_Footer', $this->data);
    }

    function ajaxShowMaster($type=false){
        $result = $this->M_masterdata->ajaxShowMaster();

        if($type){
            return $result;
        }
        echo json_encode($result);
    }

    function ajaxSeksi(){
        $result = $this->M_masterdata->ajaxSeksi();
        echo json_encode($result);
    }

    function ajaxInsertMaster(){
        $id  = $_POST['kode'];
        $ket = $_POST['ket'];
        $lv1 = $_POST['level1'];
        $lv2 = $_POST['level2'];

        $this->M_masterdata->ajaxInsertMaster($id,$ket,$lv1,$lv2);

        echo "success";
    }

    function ajaxUpdateMaster(){
        $id     = $_POST['id'];
        $code   = $_POST['kode'];
        $ket    = $_POST['ket'];

        $lv1    = $_POST['level1'];
        $lv2    = $_POST['level2'];

        $this->M_masterdata->ajaxUpdateMaster($id,$code,$ket,$lv1,$lv2);
    }

    function ajaxDeleteMaster(){
        $id   = $_POST['id'];

        $this->M_masterdata->ajaxDeleteMaster($id);
    }
}
