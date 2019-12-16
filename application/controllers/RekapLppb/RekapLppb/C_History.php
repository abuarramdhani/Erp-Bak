<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_History extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('RekapLppb/RekapLppb/M_history');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'History';
		$data['Menu'] = 'History';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['bulan'] = date('M-Y');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapLppb/RekapLppb/V_History');
		$this->load->view('V_Footer',$data);
    }
    
    function suggestItem()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_history->getItem($term);
		echo json_encode($data);
		// Console.log ($term)
    }
    
    function suggestDesc()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_history->getDesc($term);
		echo json_encode($data);
		// Console.log ($term)
	}

	public function searchHistory()
	{
        // $bulan = $this->input->post('bulan');
		$io     = $this->input->post('id_org');
		$item = $this->input->post('item');
		$desc = $this->input->post('desc');
		$tgl = $this->input->post('tgl');
		$data['io'] = $io;
        $prmbulan = strtoupper($tgl);
		// echo "<pre>"; print_r($prmbulan); exit();
		
		if ($item != '') {
			$item2 = "AND msib.segment1 = '$item'";
		}else{
			$item2 = '';
        }
        
        if ($desc != '') {
			$desc2 = "AND msib.description = '$desc'";
		}else{
			$desc2 = '';
		}

		if ($tgl != '') {
			$tanggal = "AND trunc(rsh.creation_date) between '$prmbulan' and '$prmbulan'";
		}else {
			$tanggal = '';
		}


        $data['data'] = $this->M_history->getDataRekap($item2, $desc2, $tanggal, $io);
        // echo "<pre>"; print_r($data['data']); exit();
        $this->load->view('RekapLppb/RekapLppb/V_TblHistory', $data);

	}

}
	
	