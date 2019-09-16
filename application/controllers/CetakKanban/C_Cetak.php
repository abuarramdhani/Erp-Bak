<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cetak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		//module from CI
		$this->load->model('M_index');
		$this->load->model('CetakKanban/M_cetak');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['deptclass'] = $this->M_cetak->getDeptClass();
		$data['status'] = $this->M_cetak->getStatus();

		// $data['shift'] = $this->M_cetak->getShift(FALSE);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakKanban/V_Cetak',$data);
		$this->load->view('V_Footer',$data);

	}

	public function getShift(){
		$date = $this->input->post('date');
		$date2 = explode('/', $date);
		$datenew = $date ? $date2[2].'/'.$date2[1].'/'.$date2[0] : '';
		$data = $this->M_cetak->getShift($datenew);
		echo json_encode($data);
	}

	public function getJobFrom(){
		$term = $this->input->get('term');
		$date = $this->input->get('date');
		$shift = $this->input->get('shift');

		$data = $this->M_cetak->getJobFrom($term,$date,$shift);
		echo json_encode($data);
	}

	public function search(){
		$date 		= $this->input->post('date');
		$shift 		= $this->input->post('shift');
		$deptclass 	= $this->input->post('deptclass');
		$jobfrom 	= $this->input->post('jobfrom');
		$jobto 		= $this->input->post('jobto');
		$status 	= $this->input->post('status');

		$data['value'] = $this->M_cetak->getData($date,$shift,$deptclass,$jobfrom,$jobto,$status);

		$this->load->view('CetakKanban/V_Result',$data);
	}

	// public function insertOracle(){
	// 	$kegunaan 	= $this->input->post('kegunaan[]');
	// 	$wipid 		= $this->input->post('WIP_ENTITY_ID[]');

	// 	// echo "<pre>"; print_r($kegunaan); exit();
	// 	$k = 0;
	// 	foreach ($kegunaan as $guna) {
	// 	// $apaya = $this->M_cetak->insertData($guna,$wipid[$k]);
	// 	$this->M_cetak->insertData($guna,$wipid[$k]);
	// 	$k++;
	// 	// echo "<pre>"; print_r($apaya); exit();

	// 	}
	// }

	public function Report(){
		// $kegunaan 	= $this->input->post('tujuanbaru[]');
		// $wipid 		= $this->input->post('wipidbaru[]');

		// $kegunaan = $_POST['tujuanbaru'];
		// $wipid = $_POST['wipidbaru'];

		$kegunaan 	= $this->input->post('tujuanbaru');
		$wipid 		= $this->input->post('wipidbaru');

		// echo "<pre>"; print_r($kegunaan);print_r($wipid);
		// exit();

		if ($kegunaan != "") {
			$k = 0;
			foreach ($kegunaan as $guna) {
			$data = $this->M_cetak->insertData($guna,$wipid[$k]);
			// echo json_encode($data);

			$k++;
			} 
		}else {
			
		}
		
		$data['STATUS_TYPE']			= $this->input->post('STATUS_TYPE[]');
		$data['JOB_NUMBER'] 			= $this->input->post('JOB_NUMBER[]');
		$data['ITEM_CODE'] 				= $this->input->post('ITEM_CODE[]');
		$data['DESCRIPTION'] 			= $this->input->post('DESCRIPTION[]');
		$data['DEPT_CLASS'] 			= $this->input->post('DEPT_CLASS[]');
		$data['SHIFT'] 					= $this->input->post('SHIFT[]');
		$data['NEED_BY'] 				= $this->input->post('NEED_BY[]');
		$data['TYPE_PRODUCT'] 		    = $this->input->post('TYPE_PRODUCT[]');
		$data['OPR_SEQ'] 				= $this->input->post('OPR_SEQ[]');
		$data['OPERATION'] 				= $this->input->post('OPERATION[]');
		$data['ACTIVITY'] 				= $this->input->post('ACTIVITY[]');
		$data['RESOURCES'] 				= $this->input->post('RESOURCES[]');
		$data['QR_CODE'] 				= $this->input->post('QR_CODE[]');
		$data['PREVIOUS_OPERATION'] 	= $this->input->post('PREVIOUS_OPERATION[]');
		$data['PREVIOUS_DEPT_CLASS']	= $this->input->post('PREVIOUS_DEPT_CLASS[]');
		$data['NEXT_OPERATION'] 		= $this->input->post('NEXT_OPERATION[]');
		$data['NEXT_DEPT_CLASS'] 		= $this->input->post('NEXT_DEPT_CLASS[]');
		$data['TARGETJS'] 				= $this->input->post('TARGETJS[]');
		$data['TARGETSK'] 				= $this->input->post('TARGETSK[]');
		$data['TARGET_PPIC'] 			= $this->input->post('TARGET_PPIC[]');
		$data['STATUS_STEP'] 			= $this->input->post('STATUS_STEP[]');
		$data['UOM_CODE'] 				= $this->input->post('UOM_CODE[]');
		$data['JML_OP'] 				= $this->input->post('JML_OP[]');
		$data['ROUTING_CLASS_DESC'] 	= $this->input->post('ROUTING_CLASS_DESC[]');
		$data['UNIT_VOLUME'] 			= $this->input->post('UNIT_VOLUME[]');
		$data['KODE_PROSES'] 			= $this->input->post('KODE_PROSES[]');
		$data['TUJUAN'] 				= $this->input->post('TUJUAN[]');
		$data['NO_MESIN'] 				= $this->input->post('NO_MESIN[]');
		$data['DATE'] 					= $this->input->post('SCHEDULED_START_DATE[]');

		$jumlah_baris = sizeof($data['JOB_NUMBER']);
		$temp = array();
		// $j=0;
		for ($i=0; $i < $jumlah_baris; $i++) {
			$a = array(
				'JOB_NUMBER' 			=> $data['JOB_NUMBER'][$i],
				'ITEM_CODE'				=> $data['ITEM_CODE'][$i],
				'DESCRIPTION' 			=> $data['DESCRIPTION'][$i],
				'DEPT_CLASS' 			=> $data['DEPT_CLASS'][$i],
				'SHIFT'					=> $data['SHIFT'][$i],
				'NEED_BY' 				=> $data['NEED_BY'][$i],
				'TYPE_PRODUCT' 			=> $data['TYPE_PRODUCT'][$i],
				'OPR_SEQ' 				=> $data['OPR_SEQ'][$i],
				'OPERATION' 			=> $data['OPERATION'][$i],
				'ACTIVITY' 				=> $data['ACTIVITY'][$i],
				'QR_CODE' 				=> $data['QR_CODE'][$i],
				'TARGET_PPIC' 			=> $data['TARGET_PPIC'][$i],
				'UOM_CODE' 				=> $data['UOM_CODE'][$i],
				'ROUTING_CLASS_DESC' 	=> $data['ROUTING_CLASS_DESC'][$i],
				'UNIT_VOLUME' 			=> $data['UNIT_VOLUME'][$i],
				'KODE_PROSES' 			=> $data['KODE_PROSES'][$i],
				'TUJUAN' 				=> $data['TUJUAN'][$i],
				'STATUS_TYPE'			=> $data['STATUS_TYPE'][$i],
				'DATE'					=> $data['DATE'][$i],
				// 'RESOURCES'				=> $data['RESOURCES'][$i],
				// 'PREVIOUS_OPERATION'		=> $data['PREVIOUS_OPERATION'][$i],
				// 'PREVIOUS_DEPT_CLASS' 	=> $data['PREVIOUS_DEPT_CLASS'][$i],
				// 'NEXT_OPERATION' 		=> $data['NEXT_OPERATION'][$i],
				// 'NEXT_DEPT_CLASS' 		=> $data['NEXT_DEPT_CLASS'][$i],
				// 'TARGETJS' 				=> $data['TARGETJS'][$i],
				// 'TARGETSK' 				=> $data['TARGETSK'][$i],
				// 'STATUS_STEP' 			=> $data['STATUS_STEP'][$i],
				// 'JML_OP'					=> $data['JML_OP'][$i],
				// 'NO_MESIN'				=> $data['NO_MESIN'][$i],
				);
			array_push($temp, $a);
		}
		$o = 0;
		foreach ($temp as $ey)  {
			$tuanggalan=date_create($ey['DATE']);
			$tgl = date_format($tuanggalan,"d/m/Y");
			$data['dataprint'][$o] = $this->M_cetak->getdataprint($tgl,$ey['SHIFT'],$ey['DEPT_CLASS'],$ey['JOB_NUMBER'],$ey['JOB_NUMBER'],$ey['STATUS_TYPE']);
			$data['proses'][$ey['JOB_NUMBER']]= $this->M_cetak->getProses($ey['JOB_NUMBER'],$tgl);
			$o++;
		}
		
		// $urutan = $this->M_cetak->getProses($ey['JOB_NUMBER'],$ey['JOB_NUMBER'],$tgl);

		// foreach ($data['proses'] as $hue) {
		// 	echo "<pre>";
		// 	print_r($hue);
		// }
		
		// print_r(count($data['dataprint']));
		// print_r($data['proses']);
		// print_r(count($data['proses']));
		// exit();
		
		ob_start();
		$this->load->library('ciqrcode');
		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		foreach ($temp as $show) {
			$params['data']		= ($show['QR_CODE']);
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($show['QR_CODE']).'.png';
			$this->ciqrcode->generate($params);

		}

		$data['data'] = $temp;
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8',array(210,330), 0, '', 1, 1, 1, 1, 1, 1);

		$tglNama = date("dmY");
		$filename = 'CetakKanban'.$tglNama.'.pdf';
    	$html = $this->load->view('CetakKanban/V_Report', $data, true);		//-----> Fungsi Cetak PDF
    	ob_end_clean();
    	$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
    	$pdf->Output($filename, 'I');

    }
}
