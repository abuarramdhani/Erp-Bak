<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
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
		$this->load->model('Monitoringsubkont/M_monitoring');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}
	// kj

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Monitoringsubkont/V_Filter');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

		public function sugesti()
	{
		
		$subkt = $this->input->get('term',TRUE);
		// echo "<pre>"; print_r($vendor);exit();
		$subkont = strtoupper($subkt);
		$data = $this->M_monitoring->subkontt($subkont);
		echo json_encode($data);
		// Console.log ($vendor);

	}

		public function sugesti2()
	{
		
		$ass = $this->input->get('term',TRUE);
		// echo "<pre>"; print_r($vendor);exit();
		$assyassy = strtoupper($ass);
		$data = $this->M_monitoring->assy($assyassy);
		echo json_encode($data);
		// Console.log ($vendor);

	}



	public function search()
	{

		$tanggal1 	= $this->input->post('tgAwal');
		$tanggal2 	=$this->input->post('tgAkhir');
		$no_job 	=$this->input->post('job');
		$subkont = $this->input->post('namasubkont');
		$kompo = $this->input->post('kompp');

		// echo "<pre>";print_r($kompo);exit();
		
		$job=NULL;
		$tanggal=NULL;
		$subkontname= null;
		$komponen=null;

		if ($no_job != ''){
			$job = "AND we.wip_entity_name = '$no_job'";
		}
		else{
			$job ='';
		}
		
		if ($tanggal1 != '' AND $tanggal2 != ''){
			$tanggal = "AND trunc(mtrh.creation_date) between to_date('$tanggal1', 'DD/MM/YYYY') and to_date('$tanggal2', 'DD/MM/YYYY')";
		}
		else{
			$tanggal ='';
		}
		if ($subkont != ''){
			$subkontname = "AND pv.vendor_name = '$subkont'";
		}
		else{
			$subkontname ='';
		}
		if ($kompo != ''){
			$komponen = "AND msib2.segment1 = '$kompo'";
		}
		else{
			$komponen ='';
		}
		

		// echo"<pre>";print_r($atr);exit();
		$i=0;
		$datakumpul = array();
		$header = $this->M_monitoring->caridong($job,$tanggal,$subkontname,$komponen);
		// echo"<pre>";print_r($header);exit();

		foreach ($header as $key => $value) {
			$datakumpul[$i]['NO_JOB'] 			= $header[$i]['NO_JOB'];
			$datakumpul[$i]['ASSY'] 			= $header[$i]['ASSY'];
			$datakumpul[$i]['QTY_JOB'] 			= $header[$i]['QTY_JOB'];
			$datakumpul[$i]['TGL_TRANSACT_MO'] 	= $header[$i]['TGL_TRANSACT_MO'];
			$datakumpul[$i]['ASSY_DESC'] 		= $header[$i]['ASSY_DESC'];
			$datakumpul[$i]['VENDOR_NAME'] 		= $header[$i]['VENDOR_NAME'];
			$datakumpul[$i]['DETAIL'] 			= $this->M_monitoring->detail($value['NO_JOB']);

			if ($datakumpul[$i]['DETAIL'] != " ") {

				$datakumpul[$i]['QTY_KEMBALI'] 	= " ";
				$datakumpul[$i]['DELIVE'] = " ";

				$a=0;
				foreach ($datakumpul[$i]['DETAIL'] as $val) {
					$datakumpul[$i]['DETAIL'][$a]['SUM_DELIVE'] = " ";
					
					$datakumpul[$i]['QTY_KEMBALI'] += $val['QTY_RECEIPT'];
					$datakumpul[$i]['DETAIL'][$a]['DELIVER'] 		= $this->M_monitoring->deliv($val['NO_PO'],$val['NO_RECEIPT']);
					// $datakumpul[$i]['PENDOR'] 		= $val['VENDOR_NAME'];
					$datakumpul[$i]['DETAIL'][$a]['PLUS'] = $this->M_monitoring->detailplus($val['NO_RECEIPT'], $val['NO_JOB']);
				

					if ($datakumpul[$i]['DETAIL'][$a]['DELIVER'] != " " ) {
						// $b=0;
						$jum= count($datakumpul[$i]['DETAIL'][$a]['DELIVER']);
						foreach ($datakumpul[$i]['DETAIL'][$a]['DELIVER'] as $vav) {
							if ($jum != 1) {
								$datakumpul[$i]['DETAIL'][$a]['SUM_DELIVE'] += $vav['QTY_DELIVER'];
							} else {
								$datakumpul[$i]['DETAIL'][$a]['SUM_DELIVE']  = $vav['QTY_DELIVER'];
							}


							// echo "<pre>";print_r($datakumpul[$i]['DETAIL'][$a]['DELIVER']);
							// $b++;
						}
					}	
						$datakumpul[$i]['DELIVE'] += $datakumpul[$i]['DETAIL'][$a]['SUM_DELIVE'];
					$a++;

				}
			}
			$i++;
		}
		$data['value'] = $datakumpul;
	
		// echo"<pre>";print_r($data['value']);exit();

		$this->load->view('Monitoringsubkont/V_Monitoring',$data);	
	}
}