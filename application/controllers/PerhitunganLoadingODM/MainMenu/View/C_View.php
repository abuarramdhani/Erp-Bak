<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_View extends CI_Controller
{
	
	function __construct()
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
			$this->load->model('PerhitunganLoadingODM/M_PerhitunganLoadingODM');
			$this->load->model('PerhitunganLoadingODM/M_view');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PerhitunganLoadingODM/MainMenu/View/V_View',$data);
			$this->load->view('V_Footer',$data);
			// echo '<pre>';
			// print_r($data);
			// exit;
		}
	function DeptClass()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_view->selectDeptClass($term);
		echo json_encode($data);
	}

	function DeptCode()
	{
		$deptclass = $this->input->post('deptclass');
		$data = $this->M_view->selectDeptCode($deptclass);
		echo json_encode($data);
	}

	public function searchData()
	{
		$available_op = $this->input->post('available_op');
		$hari_kerja = $this->input->post('hari_kerja');
		$input_parameter = $this->input->post('input_parameter');
		$deptclass = $this->input->post('deptclass');
		$deptcode = $this->input->post('deptcode');
		// $monthPeriode = date('M-y', strtotime($this->input->post('monthPeriode')));
		$monthPeriode = date('y-M', strtotime($this->input->post('monthPeriode')));
		$monthPeriode1 = explode('-', $monthPeriode);
		$year = $monthPeriode1[0];
		$month = $monthPeriode1[1];
		$monthPeriode2 = implode('-', [$month, $year]);
		// echo"<pre>";print_r($monthPeriode2);exit();
		//$datadt = $this->M_view->searchdata($available_op,$hari_kerja,$input_parameter,$deptclass,$deptcode,$monthPeriode);
		$data = array('dataform' =>  $this->M_view->searchdata($available_op,$hari_kerja,$input_parameter,$deptclass,$deptcode,$monthPeriode2),
						'available_op' => $available_op,
						'hari_kerja' => $hari_kerja,
						'input_parameter' => $input_parameter,
						'deptclass' => $deptclass,
						'deptcode' => $deptcode,
						'monthPeriode' => $monthPeriode2); 
		// echo"<pre>"; print_r($data); exit();
		$this->load->view('PerhitunganLoadingODM/MainMenu/View/V_Result',$data);
	}

	public function savetable(){
		// echo '<pre>'; print_r($_POST); exit;
		$resources = $this->input->post('resources');
		$resource_desc = $this->input->post('resource_desc');
		$item_code = $this->input->post('item_code');
		$item_desc = $this->input->post('item_desc');
		$cycle_time = $this->input->post('cycle_time');
		$qty_op = $this->input->post('qty_op');
		$tgt_shift = $this->input->post('tgt_shift');
		$needs = $this->input->post('needs');
		$need_shift = $this->input->post('need_shift');
		$total_need_shift = $this->input->post('total_need_shift');
		$available_op = $this->input->post('available_op');
		$available_shift = $this->input->post('available_shift');
		$loading = $this->input->post('loading');
		$needs_op = $this->input->post('needs_op');

		$hari_kerja = $this->input->post('hari_kerja');
		$input_parameter = $this->input->post('input_parameter');
		$deptclass = $this->input->post('deptclass');
		$monthPeriode = $this->input->post('monthPeriode');

		$datatabel = array(
			'RESOURCES'=> $resources,
			'RESOURCE_DESC' => $resource_desc,
			'ITEM_CODE' => $item_code,
			'ITEM_DESCRIPTION' => $item_desc,
			'CYCLE_TIME' => $cycle_time,
			'QTY_OP' => $qty_op,
			'TGT_SHIFT' => $tgt_shift,
			'NEEDS' => $needs,
			'NEEDS_SHIFT' => $need_shift,
			'TOTAL_NEEDS_SHIFT' => $total_need_shift,
			'AVAILABLE_OP' => $available_op,
			'AVAILABLE_SHIFT' => $available_shift,
			'LOADING' => $loading,
			'NEEDS_OP' => $needs_op
		);

		// print_r('<pre>'); print_r(count($datatabel['RESOURCES'])); exit;
		for ($i=0; $i < count($datatabel['RESOURCES']) ; $i++) { 
			$tabledata[$i]['RESOURCES'] = $datatabel['RESOURCES'][$i];
			$tabledata[$i]['RESOURCE_DESC'] = $datatabel['RESOURCE_DESC'][$i];
			$tabledata[$i]['ITEM_CODE'] = $datatabel['ITEM_CODE'][$i];
			$tabledata[$i]['ITEM_DESCRIPTION'] = $datatabel['ITEM_DESCRIPTION'][$i];
			$tabledata[$i]['CYCLE_TIME'] = $datatabel['CYCLE_TIME'][$i];
			$tabledata[$i]['QTY_OP'] = $datatabel['QTY_OP'][$i];
			$tabledata[$i]['TGT_SHIFT'] = $datatabel['TGT_SHIFT'][$i];
			$tabledata[$i]['NEEDS'] = $datatabel['NEEDS'][$i];
			$tabledata[$i]['NEEDS_SHIFT'] = $datatabel['NEEDS_SHIFT'][$i];
			$tabledata[$i]['TOTAL_NEEDS_SHIFT'] = $datatabel['TOTAL_NEEDS_SHIFT'][$i];
			$tabledata[$i]['AVAILABLE_OP'] = $datatabel['AVAILABLE_OP'][$i];
			$tabledata[$i]['AVAILABLE_SHIFT'] = $datatabel['AVAILABLE_SHIFT'][$i];
			$tabledata[$i]['LOADING'] = $datatabel['LOADING'][$i];
			$tabledata[$i]['NEEDS_OP'] = $datatabel['NEEDS_OP'][$i];
		}

		// print_r('<pre>'); print_r($tabledata); exit;

		foreach ($tabledata as $kunci) {
			$cek = $this->M_view->cektabel($deptclass, $kunci['RESOURCES'], $monthPeriode, $kunci['ITEM_CODE']);
			//  echo'<pre>'; print_r(sizeof($cek)); exit;
			if(count($cek) > 0){
				$this->M_view->update(array(
					'RESOURCES'=> $kunci['RESOURCES'],
					'RESOURCE_DESC' => $kunci['RESOURCE_DESC'],
					'ITEM_CODE' => $kunci['ITEM_CODE'],
					'ITEM_DESCRIPTION' => $kunci['ITEM_DESCRIPTION'],
					'CYCLE_TIME' => $kunci['CYCLE_TIME'],
					'QTY_OP' => $kunci['QTY_OP'],
					'TGT_SHIFT' => $kunci['TGT_SHIFT'],
					'NEEDS' => $kunci['NEEDS'],
					'NEEDS_SHIFT' => $kunci['NEEDS_SHIFT'],
					'TOTAL_NEEDS_SHIFT' => $kunci['TOTAL_NEEDS_SHIFT'],
					'AVAILABLE_OP' => $kunci['AVAILABLE_OP'],
					'AVAILABLE_SHIFT' => $kunci['AVAILABLE_SHIFT'],
					'LOADING' => $kunci['LOADING'],
					'NEEDS_OP' =>$kunci['NEEDS_OP'],
					'JUMLAH_HARI_KERJA' => 	$hari_kerja,
					'PARAMETER' => $input_parameter,
					'DEPARTMENT_CLASS' => $deptclass,
					'PERIODE' => $monthPeriode
				));
				break;
			} else {
				$this->M_view->saveData(array(
					'RESOURCES'=> $kunci['RESOURCES'],
					'RESOURCE_DESC' => $kunci['RESOURCE_DESC'],
					'ITEM_CODE' => $kunci['ITEM_CODE'],
					'ITEM_DESCRIPTION' => $kunci['ITEM_DESCRIPTION'],
					'CYCLE_TIME' => $kunci['CYCLE_TIME'],
					'QTY_OP' => $kunci['QTY_OP'],
					'TGT_SHIFT' => $kunci['TGT_SHIFT'],
					'NEEDS' => $kunci['NEEDS'],
					'NEEDS_SHIFT' => $kunci['NEEDS_SHIFT'],
					'TOTAL_NEEDS_SHIFT' => $kunci['TOTAL_NEEDS_SHIFT'],
					'AVAILABLE_OP' => $kunci['AVAILABLE_OP'],
					'AVAILABLE_SHIFT' => $kunci['AVAILABLE_SHIFT'],
					'LOADING' => $kunci['LOADING'],
					'NEEDS_OP' =>$kunci['NEEDS_OP'],
					'JUMLAH_HARI_KERJA' => 	$hari_kerja,
					'PARAMETER' => $input_parameter,
					'DEPARTMENT_CLASS' => $deptclass,
					'PERIODE' => $monthPeriode
				));
			}
			// echo '<pre>';
			// print_r ($cek);
		}
		// exit();
		// for($i = 0; $i < count($datatabel[0]['RESOURCES']); $i++) {
		// 	$this->M_view->saveData(
		// 		array(
		// 			'RESOURCES'=> $datatabel[0]['RESOURCES'][$i],
		// 			'RESOURCE_DESC' => $datatabel[0]['RESOURCE_DESC'][$i],
		// 			'ITEM_CODE' => $datatabel[0]['ITEM_CODE'][$i],
		// 			'ITEM_DESCRIPTION' => $datatabel[0]['ITEM_DESCRIPTION'][$i],
		// 			'CYCLE_TIME' => $datatabel[0]['CYCLE_TIME'][$i],
		// 			'QTY_OP' => $datatabel[0]['QTY_OP'][$i],
		// 			'TGT_SHIFT' => $datatabel[0]['TGT_SHIFT'][$i],
		// 			'NEEDS' => $datatabel[0]['NEEDS'][$i],
		// 			'NEEDS_SHIFT' => $datatabel[0]['NEEDS_SHIFT'][$i],
		// 			'TOTAL_NEEDS_SHIFT' => $datatabel[0]['TOTAL_NEEDS_SHIFT'][$i],
		// 			'AVAILABLE_OP' => $datatabel[0]['AVAILABLE_OP'][$i],
		// 			'AVAILABLE_SHIFT' => $datatabel[0]['AVAILABLE_SHIFT'][$i],
		// 			'LOADING' => $datatabel[0]['LOADING'][$i],
		// 			'NEEDS_OP' =>$datatabel[0]['NEEDS_OP'][$i],
		// 			'JUMLAH_HARI_KERJA' => 	$hari_kerja,
		// 			'PARAMETER' => $input_parameter,
		// 			'DEPARTMENT_CLASS' => $deptclass,
		// 			'PERIODE' => $monthPeriode
		// 		)
		// 	);
		// }

		$this->session->set_flashdata('response',"Saved");
		redirect(base_url('PerhitunganLoadingODM/View'));
	}
}