<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Bom extends CI_Controller
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
		$this->load->model('RKHKasie/M_rkhkasie');
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

		$data['Title'] = 'Daftar BOM';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RKHKasie/V_Bom');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
	public function getKodbar()
	{	
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_rkhkasie->getKodbar($term);
		echo json_encode($data);
		
	}
	public function getBom()
	{
		$kodeitem = $this->input->post('kodeitem');

		$result_bom =  $this->M_rkhkasie->getResultBom($kodeitem);

		// echo "<pre>";print_r($result_bom);exit();
		$i=0;
		foreach ($result_bom as $bom) {
			$detail_bom = $this->M_rkhkasie->getDetailBom($bom['KODE_BARANG']);
			if ($detail_bom ==null) {
				$result_bom[$i]['DETAIL_BOM']=null;

			} else if ($detail_bom !=null) {
				
				$b=0;
				foreach ($detail_bom as $detbom) {
					$result_bom[$i]['DETAIL_BOM'][$b]['KODE'] = $detbom['COMPONENT_NUM'];
					$result_bom[$i]['DETAIL_BOM'][$b]['NAMA'] = $detbom['DESCRIPTION'];
					$result_bom[$i]['DETAIL_BOM'][$b]['QTY'] = round($detbom['QTY'],4);

					$b++;	
				}
			}


			$i++;
		}

		// echo "<pre>";print_r($result_bom);exit();

		$data['result_bom'] = $result_bom;

		$this->load->view('RKHKasie/V_BomResult',$data);

	}


}