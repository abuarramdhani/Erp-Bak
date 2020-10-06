<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_PoLog extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if($this->session->is_logged){
		}else{
            redirect();
        }

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model("PurchaseManagementSendPO/MainMenu/M_polog");
    }
    public function index()
	{

		$user_id = $this->session->userid;

		$data['Menu'] = 'Po Log';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['PoLog'] = $this->M_polog->getDataPO();
        

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('PurchaseManagementSendPO/MainMenu/V_PoLog',$data);
        $this->load->view('V_Footer',$data);
    }

    public function edit()
    {
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Edit PO Not Confirmed';
        $data['SubMenuOne'] = '';

        $data['UserMenu']       = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        if (!isset($_GET['po_number'])) {
            redirect('PurchaseManagementSendPO/PoLog');
        }
        $data['po_number'] = $_GET['po_number'];


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PurchaseManagementSendPO/MainMenu/V_EditPoLog', $data);
        $this->load->view('V_Footer', $data);
    }

    public function save()
    {
        $po_number = $this->input->post('po_number');
        $vendor_confirm_date = $this->input->post('vendor_confirm_date');
        $vendor_confirm_method = $this->input->post('vendor_confirm_method');
        $vendor_confirm_pic = htmlspecialchars($this->input->post('vendor_confirm_pic'));

        $name = $_FILES["lampiran_po"]["name"];
        $ext = end((explode(".", $name)));

        if (!($ext == 'pdf' OR $ext == 'jpeg' OR $ext == 'jpg' OR $ext == 'png' OR $ext == 'xls' OR $ext == 'xlsx' OR $ext == 'ods' OR $ext == 'odt' OR $ext == 'txt' OR $ext == 'doc' OR $ext == 'docx')) {
            $this->output
				->set_status_header(400)
				->set_content_type('application/json')
				->set_output(json_encode("File yang anda masukkan salah"));
        } else {
            $config['upload_path']          = './assets/upload/PurchaseManagementSendPO/LampiranPO';
            $config['allowed_types']        = 'pdf|jpeg|jpg|png|xls|xlsx|ods|odt|txt|doc|docx';
            $config['overwrite']            = TRUE;
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('lampiran_po')) {
                $error = array('error' => $this->upload->display_errors());
    
                print_r($error);
            } else {
                $file = array('upload_data' => $this->upload->data());
                $nama_lampiran = $file['upload_data']['raw_name'];
            }
                $this->M_polog->updateVendorData($po_number, $vendor_confirm_date, $vendor_confirm_method, $vendor_confirm_pic, $nama_lampiran);
                $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode("File yang anda masukkan sudah benar"));
        }
        
    }


}