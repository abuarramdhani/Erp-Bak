<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Overdue extends CI_Controller
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
		$this->load->model('RekapLppb/RekapLppb/M_overdue');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Overdue';
		$data['Menu'] = 'Overdue';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['tahun'] = date('Y');

        // $month = strtoupper(date("M"));
		$year = strtoupper(date("Y"));
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
		// $data['data'] = $this->M_overdue->getDataRekap($year);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapLppb/RekapLppb/V_Overdue');
		$this->load->view('V_Footer',$data);
	}

	public function searchOverdue()
	{
        $tahun = $this->input->post('tahun');
		$year = substr($tahun,-4);
        $io = $this->input->post('id_org');
        // echo "<pre>"; print_r($year); exit();

        $data['data'] = $this->M_overdue->getDataRekap($year, $io);
        $this->load->view('RekapLppb/RekapLppb/V_TblOverdue', $data);

    }
}