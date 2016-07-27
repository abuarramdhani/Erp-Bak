<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationSimulation extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationTransaction/M_Simulation');
		  
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
		$data['Title'] = 'List Simulation';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Simulation';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_simulation'] = $this->M_Simulation->show_simulation();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_Simulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function new_Simulation()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Simulation';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Simulation';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Area'] = $this->M_Simulation->show_area();
		$data['CityType'] = $this->M_Simulation->show_city_type();
		$data['Employee'] = $this->M_Simulation->show_employee();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_NewSimulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function load_process(){
		$area_id = $this->input->post('txt_area_id');
		$city_type_id = $this->input->post('txt_city_type_id');
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
		echo '
			<thead>
				<tr class="bg-primary">
					<th width="5%">No</th>
					<th width="10%">Date</th>
					<th>Time</th>
					<th>Meal Allowance</th>
					<th>Accomodation Allowance</th>
					<th>Group</th>
					<th>USH</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
		';
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

								$string = array('Rp',',00','.');
								$remover = array('');

								$meal_number = str_replace($string, $remover, $meal);

								$acc_number = str_replace($string, $remover, $acc);

								$ush_number = str_replace($string, $remover, $nominal_ush);

								$total = $meal_number+$acc_number+$ush_number;
									echo '
									<tr>
										<td width="5%"></td>
										<td width="10%">'.$dt->format( "Y-m-d\n" ).'</td>
										<td>'.$ma['time_name'].'</td>
										<td style="text-align: right">Rp'.number_format($meal_number , 2, '.', ',').'</td>
										<td style="text-align: right">Rp'.number_format($acc_number , 2, '.', ',').'</td>
										<td>'.$group_name.'</td>
										<td style="text-align: right">Rp'.number_format($ush_number , 2, '.', ',').'</td>
										<td style="text-align: right">Rp'.number_format($total , 2, '.', ',').'</td>
									</tr>
								';
							}
						}
					}
				}
				$i=1;
		}
		echo '
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">Total</td>
					<td style="text-align: right">-</td>
					<td style="text-align: right">-</td>
					<td></td>
					<td style="text-align: right">-</td>
					<td style="text-align: right">-</td>
				</tr>
			</tfoot>
		';
	}

	public function save_Simulation()
	{
		$employee_id = $this->input->post('txt_employee_id');
		$area_id = $this->input->post('txt_area_id');
		$city_type_id = $this->input->post('txt_city_type_id');
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

		//Insert Simulation
		$this->M_Simulation->new_simulation($employee_id,$area_id,$city_type_id,$depart,$return);

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
									$group_id = $grp['group_id'];
									$nominal_ush = $grp['nominal'];
								}
								else{
									$group_id = 'NULL';
									$nominal_ush = '0';
								}
								$meal = $ma['nominal'];
								$time_id = $ma['time_id'];////
								$acc = $acc_nominal;

								$string = array('Rp',',00','.');
								$remover = array('');

								$meal_number = str_replace($string, $remover, $meal);

								$acc_number = str_replace($string, $remover, $acc);

								$ush_number = str_replace($string, $remover, $nominal_ush);

								$date = $dt->format( "Y-m-d" );////

								//Insert Simulation Detail
								$this->M_Simulation->new_simulation_detail($date,$time_id,$meal_number,$acc_number,$group_id,$ush_number);
							}
						}
					}
				}
				$i=1;
		}

		redirect('Outstation/simulation');
	}

	public function edit_Simulation($simulation_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Simulation';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Simulation';

		$data['Employee'] = $this->M_Simulation->show_employee();
        $data['area_data'] = $this->M_Simulation->show_area();
        $data['city_type_data'] = $this->M_Simulation->show_city_type();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_simulation'] = $this->M_Simulation->select_edit_simulation($simulation_id);
		$data['Area'] = $this->M_Simulation->show_area();
		$data['CityType'] = $this->M_Simulation->show_city_type();
		$data['Employee'] = $this->M_Simulation->show_employee();
		$data['GroupUSH'] = $this->M_Simulation->show_group_ush_all();
		$data['Simulation_detail'] = $this->M_Simulation->select_simulation_detail($simulation_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_EditSimulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_Simulation(){
		$simulation_id = $this->input->post('txt_simulation_id');
		$employee_id = $this->input->post('txt_employee_id');
		$area_id = $this->input->post('txt_area_id');
		$city_type_id = $this->input->post('txt_city_type_id');
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

		//Insert Simulation
		$this->M_Simulation->update_simulation($simulation_id,$employee_id,$area_id,$city_type_id,$depart,$return);
		$this->M_Simulation->delete_before_insert($simulation_id);

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
									$group_id = $grp['group_id'];
									$nominal_ush = $grp['nominal'];
								}
								else{
									$group_id = 'NULL';
									$nominal_ush = '0';
								}
								$meal = $ma['nominal'];
								$time_id = $ma['time_id'];////
								$acc = $acc_nominal;

								$string = array('Rp',',00','.');
								$remover = array('');

								$meal_number = str_replace($string, $remover, $meal);

								$acc_number = str_replace($string, $remover, $acc);

								$ush_number = str_replace($string, $remover, $nominal_ush);

								$date = $dt->format( "Y-m-d" );////

								//Insert Simulation Detail
								$this->M_Simulation->update_simulation_detail($simulation_id,$date,$time_id,$meal_number,$acc_number,$group_id,$ush_number);
							}
						}
					}
				}
				$i=1;
		}

		redirect('Outstation/simulation');
	}

	public function print_simulation($simulation_id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', 'A4-L');

		$filename = 'Simulation_Detail_'.time();
		$this->checkSession();

		$data['data_simulation'] = $this->M_Simulation->select_edit_simulation($simulation_id);
		$data['Area'] = $this->M_Simulation->show_area();
		$data['CityType'] = $this->M_Simulation->show_city_type();
		$data['Employee'] = $this->M_Simulation->show_employee();
		$data['GroupUSH'] = $this->M_Simulation->show_group_ush_all();
		$data['Simulation_detail'] = $this->M_Simulation->select_simulation_detail($simulation_id);
		$data['total_nominal'] = $this->M_Simulation->sum_simulation_nominal($simulation_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_EditSimulation',$data);
		$this->load->view('V_Footer',$data);
		$html = $this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_PrintSimulation', $data, true);

		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}
}
