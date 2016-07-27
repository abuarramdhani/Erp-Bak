<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationRealization extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('general-afair/outstation/OutstationTransaction/M_Realization');
		  
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
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'List Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_realization'] = $this->M_Realization->show_realization();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Realization/V_Realization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function new_Realization()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
        $data['Area'] = $this->M_Realization->show_area();
        $data['CityType'] = $this->M_Realization->show_city_type();
        $data['Employee'] = $this->M_Realization->show_employee();
        $data['Component'] = $this->M_Realization->show_component();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Realization/V_NewRealization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function load_process(){
		$area_id = $this->input->post('txt_area_id');
		$city_type_id = $this->input->post('txt_city_type_id');
		$bon = $this->input->post('txt_bon');
		$depart = $this->input->post('txt_depart');
			$depart_ex =explode(' ', $depart);
				$depart_tgl = $depart_ex[0];
				$depart_wkt = $depart_ex[1];
					$depart_wkt_ex = explode(':', $depart_wkt);
						$depart_time = $depart_wkt_ex[0].':'.$depart_wkt_ex[1];
		$return = $this->input->post('txt_return');
			$return_ex =explode(' ', $return);
				$return_tgl = $return_ex[0];
				$return_tgl_fix = date('Y-m-d', strtotime("+1 day", strtotime($return_tgl)));
				$return_wkt = $return_ex[1];
					$return_wkt_ex = explode(':', $return_wkt);
						$return_time = $return_wkt_ex[0].':'.$return_wkt_ex[1];
		$time_name = array('1' => 'pagi', '2' => 'siang', '3' => 'malam');

		if ($depart_time <= '08:00') {
			$i = 1;
		}
		elseif ($depart_time > '08:00' && $depart_time < '16:00') {
			$i = 2;
		}
		elseif ($depart_time >= '16:00') {
			$i = 3;
		}

		if ($return_time <= '08:00') {
			$x = 1;
		}
		elseif ($return_time > '08:00' && $return_time < '18:00') {
			$x = 2;
		}
		elseif ($return_time >= '18:00') {
			$x = 3;
		}

		$y=3;
		$begin = new DateTime( $depart_tgl );
		$end = new DateTime( $return_tgl_fix );
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		$count = $begin->diff($end)->days;
		foreach ( $period as $dt ){
			$count--;
			if ($count == 0) {
				$waktu_kembali = $x;
			}
			else {
				$waktu_kembali = 3;
			}
				for ($time=$i; $time <= $waktu_kembali; $time++) {
					$meal_allowance = $this->M_Simulation->show_meal_allowance($area_id, $time_name[$time]);
					$accomodation_allowance = $this->M_Simulation->show_accomodation_allowance($area_id, $city_type_id);
					$group_ush = $this->M_Simulation->show_group_ush($return_time);
					foreach ($accomodation_allowance as $aa) {
						foreach ($meal_allowance as $ma) {
							foreach ($group_ush as $grp) {
								if ($time == $y) {
									$acc_nominal = $aa['nominal'];
								}
								else{
									$acc_nominal = '0';
								}
								if ($time == $i) {
									$group_name = $grp['group_name'];
									$nominal_ush = $grp['nominal'];
								}
								else{
									$group_name = '-';
									$nominal_ush = '0';
								}
								$meal = $ma['nominal'];
								$acc = $acc_nominal;
								$meal_rep = str_replace('Rp', '', $meal);
								$meal_rep1 = str_replace(',00', '', $meal_rep);
								$meal_rep2 = str_replace('.', '', $meal_rep1);

								$acc_rep = str_replace('Rp', '', $acc);
								$acc_rep1 = str_replace(',00', '', $acc_rep);
								$acc_rep2 = str_replace('.', '', $acc_rep1);

								$ush_rep = str_replace('Rp', '', $nominal_ush);
								$ush_rep1 = str_replace(',00', '', $ush_rep);
								$ush_rep2 = str_replace('.', '', $ush_rep1);

								$total = $meal_rep2+$acc_rep2+$ush_rep2;
									echo '
									<tr>
										<td width="5%"></td>
										<td width="10%">'.$dt->format( "Y-m-d\n" ).'</td>
										<td>'.$ma['time_name'].'</td>
										<td style="text-align: right">Rp'.number_format($meal_rep2 , 2, '.', ',').'</td>
										<td style="text-align: right">Rp'.number_format($acc_rep2 , 2, '.', ',').'</td>
										<td>'.$group_name.'</td>
										<td style="text-align: right">Rp'.number_format($ush_rep2 , 2, '.', ',').'</td>
										<td style="text-align: right">Rp'.number_format($total , 2, '.', ',').'</td>
									</tr>
								';
							}
						}
					}
				}
				$i=1;
		}
	}

	public function save_Realization()
	{
		$employee_id = $this->input->post('txt_employee_id');
		$destination = $this->input->post('txt_destination');
		$city_type = $this->input->post('txt_city_type');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$total = $this->input->post('txt_total');

		$this->M_Realization->new_realization($position_id,$area_id ,$city_type);

		redirect('Outstation/realization');
	}

	public function edit_Realization($realization)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';
		$data['Employee'] = $this->M_Realization->show_employee();
        $data['area_data'] = $this->M_Realization->show_area();
        $data['city_type_data'] = $this->M_Realization->show_city_type();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_realization'] = $this->M_Realization->select_edit_Realization($realization);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Realization/V_EditRealization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_Realization()
	{$employee_id = $this->input->post('txt_employee_id');
		$destination = $this->input->post('txt_destination');
		$city_type = $this->input->post('txt_city_type');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$bon = $this->input->post('txt_bon');

		$this->M_Realization->update_realization($realization,$employee_id,$area_id,$city_type);

		redirect('Outstation/realization');
	}
}
