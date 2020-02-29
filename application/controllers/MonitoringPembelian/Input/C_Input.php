<?php if (!(defined('BASEPATH'))) {
    exit('No direct script access allowed');
}

class C_Input extends CI_Controller
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringPembelian/Monitoring/M_input');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			}else{
				redirect();
			}
	}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['Input']  = $this->M_input->getData();
			
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPembelian/Monitoring/V_Input',$data);
		$this->load->view('V_Footer',$data);

	}

    // public function getAjaxPembelian()
    // {
    // 	$data['Input'] = $this->M_input->getData();
    //
    // 	if (empty($data['Input'])) {
    // 		$data['Input'] = [];
    // 		echo json_encode($this->load->view('MonitoringPembelian/Monitoring/Ajax/V_AjaxPembelian', $data));
    // 	}else {
    // 		echo json_encode($this->load->view('MonitoringPembelian/Monitoring/Ajax/V_AjaxPembelian', $data));
    // 	}
    // }
    public function getCodeItem()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_input->searchselect2($term));
    }

    public function getAjaxPembelian()
    {
        $fetch_data = $this->M_input->make_datatables();
        $data = array();
        $no=1;
        foreach ($fetch_data as $row) {

						if ($row->CETAK == '0') {
							$sudahbelum = 'BELUM CETAK';
              $style = 'style="color: deepskyblue;"';
						} elseif ($row->CETAK == '1') {
							$sudahbelum = 'SUDAH CETAK';
              $style = 'style="color: crimson;"';
						}

            if  ($row->STATUS == 'UNAPPROVED'){
                $styleStatus = 'style="color: #ffc313";';
            } elseif ($row->STATUS == 'APPROVED') {
                $styleStatus = 'style="color: #529ecc";';
            } elseif ($row->STATUS == 'REJECTED') {
                $styleStatus = 'style="color: #aa1d05";';
            }

            $sub_array   = array();
            $sub_array[] = $no++;
						$sub_array[] = '<b '.$style.'>'.$sudahbelum.$row->CETAK.'</b>';
						$sub_array[] = $row->UPDATE_ID;
						$sub_array[] = $row->UPDATE_DATE;
						$sub_array[] = $row->SEGMENT1;
						$sub_array[] = $row->DESCRIPTION;
						$sub_array[] = $row->PRIMARY_UOM_CODE;
						$sub_array[] = $row->SECONDARY_UOM_CODE;
						$sub_array[] = $row->FULL_NAME;
						$sub_array[] = $row->PREPROCESSING_LEAD_TIME;
						$sub_array[] = $row->PREPARATION_PO;
						$sub_array[] = $row->DELIVERY;
						$sub_array[] = $row->FULL_LEAD_TIME;
						$sub_array[] = $row->POSTPROCESSING_LEAD_TIME;
						$sub_array[] = $row->TOTAL_LEADTIME;
						$sub_array[] = $row->MINIMUM_ORDER_QUANTITY;
						$sub_array[] = $row->FIXED_LOT_MULTIPLIER;
						$sub_array[] = $row->ATTRIBUTE18;
						$sub_array[] = $row->KETERANGAN;
						$sub_array[] = $row->RECEIVE_CLOSE_TOLERANCE;
						$sub_array[] = $row->QTY_RCV_TOLERANCE;
						$sub_array[] =  '<b '.$styleStatus.'>'.$row->STATUS.'</b>';

            $data[] = $sub_array;
        }
        $output = array(
             "draw"                  =>     intval($_POST["draw"]),
             "recordsTotal"          =>     $this->M_input->get_all_data(),
             "recordsFiltered"       =>     $this->M_input->get_filtered_data(),
             "data"                  =>     $data
    );
        echo json_encode($output);
    }

    public function getAjaxPembelianfilter2()
    {
        $filter = $this->input->post('status');
        $fetch_data = $this->M_input->make_datatables2($filter);
        $data = array();
        $no=1;
        foreach ($fetch_data as $row) {

            if ($row->CETAK == '0') {
              $sudahbelum = 'BELUM CETAK';
              $style = 'style="color: deepskyblue;"';
            } elseif ($row->CETAK == '1') {
              $sudahbelum = 'SUDAH CETAK';
              $style = 'style="color: crimson;"';
            }

            if  ($row->STATUS == 'UNAPPROVED'){
                $styleStatus = 'style="color: #ffc313";';
            } elseif ($row->STATUS == 'APPROVED') {
                $styleStatus = 'style="color: #529ecc";';
            } elseif ($row->STATUS == 'REJECTED') {
                $styleStatus = 'style="color: #aa1d05";';
            }

            $sub_array   = array();
            $sub_array[] = $no++;
            $sub_array[] = '<b '.$style.'>'.$sudahbelum.'</b>';
            $sub_array[] = $row->UPDATE_ID;
            $sub_array[] = $row->UPDATE_DATE;
            $sub_array[] = $row->SEGMENT1;
            $sub_array[] = $row->DESCRIPTION;
            $sub_array[] = $row->PRIMARY_UOM_CODE;
            $sub_array[] = $row->SECONDARY_UOM_CODE;
            $sub_array[] = $row->FULL_NAME;
            $sub_array[] = $row->PREPROCESSING_LEAD_TIME;
            $sub_array[] = $row->PREPARATION_PO;
            $sub_array[] = $row->DELIVERY;
            $sub_array[] = $row->FULL_LEAD_TIME;
            $sub_array[] = $row->POSTPROCESSING_LEAD_TIME;
            $sub_array[] = $row->TOTAL_LEADTIME;
            $sub_array[] = $row->MINIMUM_ORDER_QUANTITY;
            $sub_array[] = $row->FIXED_LOT_MULTIPLIER;
            $sub_array[] = $row->ATTRIBUTE18;
            $sub_array[] = $row->KETERANGAN;
            $sub_array[] = $row->RECEIVE_CLOSE_TOLERANCE;
            $sub_array[] = $row->QTY_RCV_TOLERANCE;
            $sub_array[] =  '<b '.$styleStatus.'>'.$row->STATUS.'</b>';

            $data[] = $sub_array;
        }
        $output = array(
             "draw"                  =>     intval($_POST["draw"]),
             "recordsTotal"          =>     $this->M_input->get_all_data2(),
             "recordsFiltered"       =>     $this->M_input->get_filtered_data2(),
             "data"                  =>     $data
    );
        echo json_encode($output);
    }

	// public 	

}