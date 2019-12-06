<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Perbaikan extends CI_Controller
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
		$this->load->model('RekapLppb/RekapLppb/M_perbaikan');

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

		$data['Title'] = 'Perbaikan';
		$data['Menu'] = 'Perbaikan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        // $data['bulan'] = date('M-Y');

        // $month = strtoupper(date("M"));
		// $year = strtoupper(date("Y"));
		// $data['monthnow'] = ".$month.";

		// $navbulan = array
		// (
		// 		array("1","bln" => "DEC","mon" => "DEC-$year","selisih" => ""),
		// 		array("2","bln" => "NOP","mon" => "NOP-$year","selisih" => ""),
		// 		array("3","bln" => "OCT","mon" => "OCT-$year","selisih" => ""),
		// 		array("4","bln" => "SEP","mon" => "SEP-$year","selisih" => ""),
		// 		array("5","bln" => "AUG","mon" => "AUG-$year","selisih" => ""),
		// 		array("6","bln" => "JUL","mon" => "JUL-$year","selisih" => ""),
		// 		array("7","bln" => "JUN","mon" => "JUN-$year","selisih" => ""),
		// 		array("8","bln" => "MAY","mon" => "MAY-$year","selisih" => ""),
		// 		array("9","bln" => "APR","mon" => "APR-$year","selisih" => ""),
		// 		array("10","bln" => "MAR","mon" => "MAR-$year","selisih" => ""),
		// 		array("11","bln" => "FEB","mon" => "FEB-$year","selisih" => ""),
		// 		array("12","bln" => "JAN","mon" => "JAN-$year","selisih" => "")
		// 		);

		// for ($i=0; $i <count($navbulan) ; $i++) { 
		// 	$prmbulan = $navbulan[$i]['mon'];
		// 	$hasil = $this->M_input->getSelisih($prmbulan);
		// 	if ($hasil != null) {
		// 		$navbulan[$i]['selisih'] = $hasil['0']['SELISIH'];
		// 	}
		// } 
		// $data['navbulan']= $navbulan;
		// $prmmonth = strtoupper(date("M-Y"));
		// $data['data'] = $this->M_perbaikan->getDataRekap($prmmonth);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapLppb/RekapLppb/V_Perbaikanfix');
		$this->load->view('V_Footer',$data);
	}

	function searchIO()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_perbaikan->selectIO($term);
		echo json_encode($data);
	}

	public function searchPerbaikan()
	{
        $no_recipt = $this->input->post('no_recipt');
        $no_po = $this->input->post('no_po');
        $item = $this->input->post('item');
		$io = $this->input->post('id_org');
		$data['io'] = $io;
		
		if ($no_recipt != '') {
			$norecipt = "AND rsh.receipt_num = '$no_recipt'";
		}else{
			$norecipt = '';
		}

		if ($no_po != '') {
			$nopo = "and pha.SEGMENT1 = '$no_po'";
		}else{
			$nopo = '';
		}
		if ($item != '') {
			$item2 = "and msib.segment1 = '$item'";
		}else{
			$item2 = '';
		}
        // echo "<pre>"; print_r($io); exit();

        $data['data'] = $this->M_perbaikan->getDataRekap($norecipt, $nopo, $io, $item2);
        $this->load->view('RekapLppb/RekapLppb/V_TblPerbaikan', $data);

    }
}