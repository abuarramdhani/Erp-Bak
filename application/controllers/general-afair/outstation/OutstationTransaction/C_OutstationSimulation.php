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

		//$data['Area'] = $this->M_Simulation->show_area();
		//$data['CityType'] = $this->M_Simulation->show_city_type();
		$data['City'] = $this->M_Simulation->show_city();
		$data['Employee'] = $this->M_Simulation->show_employee();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_NewSimulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function load_process(){
		if($this->input->post('acc_check') == 1){
			$include_acc = 1;
		}else{
			$include_acc = 0;
		}
		$position_id = $this->input->post('txt_position_id');
		$destination = $this->input->post('txt_city_id');
		$destination_ex = explode('-', $destination);
		$city_id = $destination_ex[0];
		$area_id = $destination_ex[1];	//$this->input->post('txt_area_id');
		if ($area_id == '39') {
			$is_foreign = 1;
		}
		else{
			$is_foreign = 0;
		}
		$city_type_id = $destination_ex[2];	//$this->input->post('txt_city_type_id');
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

		if ($depart_time <= '07:00') {
			$i = 1;
		}
		elseif ($depart_time > '07:00' && $depart_time < '12:00') {
			$i = 2;
		}
		elseif ($depart_time > '12:00' && $depart_time < '18.30') {
			$i = 3;
		}

		if ($return_time > '07:00' && $return_time < '12:00') {
			$x = 1;
		}
		elseif ($return_time > '12:00' && $return_time < '18:30') {
			$x = 2;
		}
		elseif ($return_time >= '18:30') {
			$x = 3;
		}

		$y=3;
		$begin = new DateTime( $depart_tgl );
		$end = new DateTime( $return_tgl_fix );
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		$count = $begin->diff($end)->days;
		/*
		echo '
			<thead>
				<tr class="bg-primary">
					<th width="5%"><center>No</center></th>
					<th width="10%"><center>Date</center></th>
					<th><center>Time</center></th>
					<th><center>Meal Allowance</center></th>
					<th><center>Accomodation Allowance</center></th>
					<th><center>Group</center></th>
					<th><center>USH</center></th>
					<th><center>Total</center></th>
				</tr>
			</thead>
			<tbody>
		';
		*/
		$indexx=0;
		$meal_pagi = 0;
		$meal_siang = 0;
		$meal_malam = 0;
		$nom_meal_pagi = '';
		$nom_meal_siang = '';
		$nom_meal_malam = '';
		$nom_inn_malam = '';
		$meal_number = array();
		$acc_number = array();
		$ush_number = array();
		$group_id = array();
		$nom_inn_malam = '0';

		foreach ( $period as $dt ){
			$check_holiday = $this->M_Simulation->check_holiday($dt->format('Y-m-d'),$dt->format('Y-m-d') );
			$have_holiday = "0";
			if ($dt->format('N') > 6 || $check_holiday > 0) {
				$have_holiday = "1";
			}

			$count--;
			if ($count == 0) {
				$waktu_kembali = $x;
				$return_time_now = $return_time;
			}
			else {
				$waktu_kembali = 3;
				$return_time_now = "23:00:00";
			}
				for ($time=$i; $time <= $waktu_kembali; $time++) {
					$meal_allowance = $this->M_Simulation->show_meal_allowance($position_id, $area_id, $time_name[$time]);
					$accomodation_allowance = $this->M_Simulation->show_accomodation_allowance($position_id, $area_id, $city_type_id);
					$group_ush = $this->M_Simulation->show_group_ush($position_id, $return_time_now, $have_holiday, $is_foreign);
					/*
					foreach ($accomodation_allowance as $aa) {
						if ($time == $y and $include_acc == 1) {
							$acc_nominal = $aa['nominal'];
						}else{
							$acc_nominal = '0';
						}
						$acc = $acc_nominal;
						$string = array('Rp',',00','.');
						$remover = array('');

						$acc_number = str_replace($string, $remover, $acc);
					}

					foreach ($meal_allowance as $ma) {
						$meal = $ma['nominal'];
						$meal_time = $ma['time_name'];
						$string = array('Rp',',00','.');
						$remover = array('');

						$meal_number = str_replace($string, $remover, $meal);
					}

					foreach ($group_ush as $grp) {
						if ($time == $i) {
							$group_name = $grp['group_name'];
							$nominal_ush = $grp['nominal'];
						}else{
							$group_name = '-';
							$nominal_ush = '0';
						}
								
						$string = array('Rp',',00','.');
						$remover = array('');

						$ush_number = str_replace($string, $remover, $nominal_ush);
					}

					$total = $meal_number+$acc_number+$ush_number;
					echo '
						<tr>
							<td width="5%"></td>
							<td width="10%">'.$dt->format( "Y-m-d\n" ).'</td>
							<td>'.$meal_time.'</td>
							<td style="text-align: right">Rp'.number_format($meal_number , 2, '.', ',').'</td>
							<td style="text-align: right">Rp'.number_format($acc_number , 2, '.', ',').'</td>
							<td>'.$group_name.'</td>
							<td style="text-align: right">Rp'.number_format($ush_number , 2, '.', ',').'</td>
							<td style="text-align: right">Rp'.number_format($total , 2, '.', ',').'</td>
						</tr>';
					*/

					foreach ($accomodation_allowance as $aa) {
						$indexx++;

						if ($time == $y and $include_acc == 1) {
							$acc_nominal = $aa['nominal'];
							$nom_inn_malam = $aa['nominal'];
						}else{
							$acc_nominal = '0';
						}
						$acc = array($indexx =>$acc_nominal);
						$string = array('Rp',',00','.');
						$remover = array('');

						$acc_number[$indexx] = str_replace($string, $remover, $acc[$indexx]);
					}

					foreach ($meal_allowance as $ma) {
						$indexx++;

						$meal = array($indexx => $ma['nominal']);
						if (strtolower($ma['time_name']) == strtolower("Pagi")) {
							$meal_pagi++;
							$nom_meal_pagi = $ma['nominal'];
						}
						if (strtolower($ma['time_name']) == strtolower("Siang")) {
							$meal_siang++;
							$nom_meal_siang = $ma['nominal'];
						}
						if (strtolower($ma['time_name']) == strtolower("Malam")) {
							$meal_malam++;
							$nom_meal_malam = $ma['nominal'];
						}
						$string = array('Rp',',00','.');
						$remover = array('');

						$meal_number[$indexx] = str_replace($string, $remover, $meal[$indexx]);
					}

					foreach ($group_ush as $grp) {
						$indexx++;

						if ($time == $i) {
							$nominal_ush = array($indexx => $grp['nominal']);
							array_push($group_id, array('id' => $grp['group_name'], 'nominal' => $grp['nominal']) );

							//echo "lalala: ".$grp['group_id']."<br>"; exit;
						}else{
							$nominal_ush[$indexx] = '0';
						}
						$string = array('Rp',',00','.');
						$remover = array('');

						$ush_number[$indexx] = str_replace($string, $remover, $nominal_ush[$indexx]);
					}

					$total_meal = array_sum($meal_number);
					$total_acc = array_sum($acc_number);
					$total_ush = array_sum($ush_number);
					$total_all = $total_meal+$total_acc+$total_ush;
				}
				$i=1;
		}
		/*
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
		*/
		echo '<div class="col-md-6">';

		if($meal_allowance){
			$total_meal_pagi = $meal_pagi*$nom_meal_pagi;
			$total_meal_siang = $meal_siang*$nom_meal_siang;
			$total_meal_malam = $meal_malam*$nom_meal_malam;
			echo'
				<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									Meal
								</div>
								<div class="col-md-8">
									<div class="row">
										<table>
											<tr>
												<td>'.$meal_pagi.' Pagi</td>
												<td>&emsp;X&emsp;</td>
												<td>Rp.'.number_format($nom_meal_pagi , 2, ',', '.').'</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.'.number_format($total_meal_pagi , 2, ',', '.').'</td>
											</tr>
											<tr>
												<td>'.$meal_siang.' Siang</td>
												<td>&emsp;X&emsp;</td>
												<td>Rp.'.number_format($nom_meal_siang , 2, ',', '.').'</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.'.number_format($total_meal_siang , 2, ',', '.').'</td>
											</tr>
											<tr>
												<td>'.$meal_malam.' Malam</td>
												<td>&emsp;X&emsp;</td>
												<td>Rp.'.number_format($nom_meal_malam , 2, ',', '.').'</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.'.number_format($total_meal_malam , 2, ',', '.').'</td>
											</tr>
											<tr>
												<td colspan="3">Total Meal Allowance</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.'.number_format($total_meal , 2, ',', '.').'</td>
											</tr>
										</table>
									</div>
								</div>
				</div>';
		}else{
			echo'
				<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									Meal
								</div>
								<div class="col-md-8">
									<div class="row">
										<table>
											<tr>
												<td>0 Pagi</td>
												<td>&emsp;X&emsp;</td>
												<td>Rp.0,00</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.0,00</td>
											</tr>
											<tr>
												<td>0 Siang</td>
												<td>&emsp;X&emsp;</td>
												<td>Rp.0,00</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.0,00</td>
											</tr>
											<tr>
												<td>0 Malam</td>
												<td>&emsp;X&emsp;</td>
												<td>Rp.0,00</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.0,00</td>
											</tr>
											<tr>
												<td colspan="3">Total Meal Allowance</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.0,00</td>
											</tr>
										</table>
									</div>
								</div>
				</div>';
		}
		if($accomodation_allowance){
			echo'
				<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									Accomodation
								</div>
								<div class="col-md-8">
									<div class="row">
										<table>
											<tr>
												<td>'.$meal_malam.' Malam</td>
												<td>&emsp;X&emsp;</td>
												<td align="right">Rp.'.number_format($nom_inn_malam , 2, ',', '.').'</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.'.number_format($total_acc , 2, ',', '.').'</td>
											</tr>
											<tr>
												<td colspan="3">Total Accomodation Allowance</td>
												<td>&emsp;=&emsp;</td>
												<td>Rp.'.number_format($total_acc , 2, ',', '.').'</td>
											</tr>
										</table>
									</div>
								</div>
				</div>';
		}else{
			echo'
				<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									Accomodation
								</div>
								<div class="col-md-8">
									<div class="row">
										<table>
											<tr>
												<td>0 Malam</td>
												<td>&emsp;X&emsp;</td>
												<td align="right">Rp.0,00</td>
												<td>&emsp;=&emsp;</td>
												<td align="right">Rp.0,00</td>
											</tr>
											<tr>
												<td colspan="3">Total Accomodation Allowance</td>
												<td>&emsp;=&emsp;</td>
												<td>Rp.0,00</td>
											</tr>
										</table>
									</div>
								</div>
				</div>';
		}
		if($group_ush){
			echo '
				<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									 USH
								</div>
								<div class="col-md-8">
									<div class="row">
										<table>';

										array_push($group_id, array('id' => '0', 'nominal' => '0'));
			
										$ush_id="";
										$ush_count = 0;
										foreach ($group_id as $gi) {
											if($gi['id'] == $ush_id || $ush_id == ""){
												$ush_count++;
												$ush_name = $gi['id'];
												$ush_nom = $gi['nominal'];
												$ush_tot = $ush_count*$ush_nom;
											}else{
												echo'
												<tr>
													<td>'.$ush_count.' '.$ush_name.'</td>
													<td>&emsp;X&emsp;</td>
													<td align="right">Rp.'.number_format($ush_nom , 2, ',', '.').'</td>
													<td>&emsp;=&emsp;</td>
													<td align="right">Rp.'.number_format($ush_tot , 2, ',', '.').'</td>
												</tr>';

												$ush_count = 1;
												$ush_name = $gi['id'];
												$ush_nom = $gi['nominal'];
												$ush_tot = $ush_count*$ush_nom;
											}
											$ush_id = $gi['id'];
										}

											echo'
											<tr>
												<td colspan="3">Total USH Allowance</td>
												<td>&emsp;=&emsp;</td>
												<td>Rp.'.number_format($total_ush , 2, ',', '.').'</td>
											</tr>
										</table>
									</div>
								</div>
				</div>';	
		}else{
			echo'
				<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-7">
									 USH
								</div>
								<div class="col-md-5">
									<p id="ush-estimate">Rp0,00</p>
								</div>
				</div>';
		}
		echo'</div>
			<div class="col-md-6">
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									Total Estimated
								</div>
								<div class="col-md-8">
									<p id="total-estimate">Rp.'.number_format($total_all , 2, ',', '.').'</p>
								</div>
							</div>
			</div>';
	}

	public function save_Simulation(){
		if($this->input->post('acc_check') == 1){
			$include_acc = 1;
		}else{
			$include_acc = 0;
		}
		$employee_id = $this->input->post('txt_employee_id');
		$position_id = $this->input->post('txt_position_id');
		$destination = $this->input->post('txt_city_id');
		$destination_ex = explode('-', $destination);
		$city_id = $destination_ex[0];
		$area_id = $destination_ex[1];	//$this->input->post('txt_area_id');
		if ($area_id == '39') {
			$is_foreign = 1;
		}
		else{
			$is_foreign = 0;
		}
		$city_type_id = $destination_ex[2];	//$this->input->post('txt_city_type_id');
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
		$this->M_Simulation->new_simulation($employee_id,$city_id,$area_id,$city_type_id,$depart,$return,$include_acc);

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
			$check_holiday = $this->M_Simulation->check_holiday($dt->format('Y-m-d'),$dt->format('Y-m-d') );
			$have_holiday = "0";
			if ($dt->format('N') > 6 || $check_holiday > 0) {
				$have_holiday = "1";
			}

			$count--;
			if ($count == 0) {
				$waktu_kembali = $x;
				$return_time_now = $return_time;
			}
			else {
				$waktu_kembali = 3;
				$return_time_now = "23:00:00";
			}
				for ($time=$i; $time <= $waktu_kembali; $time++) {
					$meal_allowance = $this->M_Simulation->show_meal_allowance($position_id,$area_id,$time_name[$time]);
					$accomodation_allowance = $this->M_Simulation->show_accomodation_allowance($position_id,$area_id,$city_type_id);
					$group_ush = $this->M_Simulation->show_group_ush($position_id, $return_time_now, $have_holiday, $is_foreign);
					foreach ($accomodation_allowance as $aa) {
						if ($time == $y and $include_acc == 1) {
							$acc_nominal = $aa['nominal'];
						}else{
							$acc_nominal = '0';
						}

						$acc = $acc_nominal;
						$string = array('Rp',',00','.');
						$remover = array('');

						$acc_number = str_replace($string, $remover, $acc);
					}

					foreach ($meal_allowance as $ma) {
						$meal = $ma['nominal'];
						$time_id = $ma['time_id'];
						$string = array('Rp',',00','.');
						$remover = array('');

						$meal_number = str_replace($string, $remover, $meal);
					}

					
					foreach ($group_ush as $grp) {
						if ($time == $i) {
							$group_id = $grp['group_id'];
							$nominal_ush = $grp['nominal'];
						}else{
							$group_id = 'NULL';
							$nominal_ush = '0';
						}
								
						$string = array('Rp',',00','.');
						$remover = array('');

						$ush_number = str_replace($string, $remover, $nominal_ush);
					}
					$date = $dt->format( "Y-m-d" );////

					//Insert Simulation Detail
					$this->M_Simulation->new_simulation_detail($date,$time_id,$meal_number,$acc_number,$group_id,$ush_number);
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

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_simulation'] = $this->M_Simulation->select_edit_simulation($simulation_id);
		//$data['Area'] = $this->M_Simulation->show_area();
		//$data['CityType'] = $this->M_Simulation->show_city_type();
		$data['City'] = $this->M_Simulation->show_city();
		$data['Employee'] = $this->M_Simulation->show_employee();
		$data['GroupUSH'] = $this->M_Simulation->show_group_ush_all();
		$data['Simulation_detail'] = $this->M_Simulation->select_simulation_detail($simulation_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_EditSimulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_Simulation(){
		if($this->input->post('acc_check') == 1){
			$include_acc = 1;
		}else{
			$include_acc = 0;
		}
		$simulation_id = $this->input->post('txt_simulation_id');
		$employee_id = $this->input->post('txt_employee_id');
		$position_id = $this->input->post('txt_position_id');
		$destination = $this->input->post('txt_city_id');
		$destination_ex = explode('-', $destination);
		$city_id = $destination_ex[0];
		$area_id = $destination_ex[1];	//$this->input->post('txt_area_id');
		if ($area_id == '39') {
			$is_foreign = 1;
		}
		else{
			$is_foreign = 0;
		}
		$city_type_id = $destination_ex[2];	//$this->input->post('txt_city_type_id');
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
		$this->M_Simulation->update_simulation($simulation_id,$employee_id,$city_id,$area_id,$city_type_id,$depart,$return,$include_acc);
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
			$check_holiday = $this->M_Simulation->check_holiday($dt->format('Y-m-d'),$dt->format('Y-m-d') );
			$have_holiday = "0";
			if ($dt->format('N') > 6 || $check_holiday > 0) {
				$have_holiday = "1";
			}

			$count--;
			if ($count == 0) {
				$waktu_kembali = $x;
				$return_time_now = $return_time;
			}
			else {
				$waktu_kembali = 3;
				$return_time_now = "23:00:00";
			}
				for ($time=$i; $time <= $waktu_kembali; $time++) {
					$meal_allowance = $this->M_Simulation->show_meal_allowance($position_id,$area_id,$time_name[$time]);
					$accomodation_allowance = $this->M_Simulation->show_accomodation_allowance($position_id,$area_id, $city_type_id);
					$group_ush = $this->M_Simulation->show_group_ush($position_id, $return_time_now, $have_holiday, $is_foreign);
					foreach ($accomodation_allowance as $aa) {
						if ($time == $y and $include_acc == 1) {
							$acc_nominal = $aa['nominal'];
						}else{
							$acc_nominal = '0';
						}

						$acc = $acc_nominal;
						$string = array('Rp',',00','.');
						$remover = array('');

						$acc_number = str_replace($string, $remover, $acc);
					}

					foreach ($meal_allowance as $ma) {
						$meal = $ma['nominal'];
						$time_id = $ma['time_id'];
						$string = array('Rp',',00','.');
						$remover = array('');

						$meal_number = str_replace($string, $remover, $meal);
					}

					foreach ($group_ush as $grp) {
						if ($time == $i) {
							$group_id = $grp['group_id'];
							$nominal_ush = $grp['nominal'];
						}else{
							$group_id = 'NULL';
							$nominal_ush = '0';
						}
								
						$string = array('Rp',',00','.');
						$remover = array('');

						$ush_number = str_replace($string, $remover, $nominal_ush);
					}

					$date = $dt->format( "Y-m-d" );

					//Insert Simulation Detail
					$this->M_Simulation->update_simulation_detail($simulation_id,$date,$time_id,$meal_number,$acc_number,$group_id,$ush_number);
				}
				$i=1;
		}

		redirect('Outstation/simulation');
	}

	public function delete_simulation($simulation_id){
		$this->M_Simulation->delete_simulation($simulation_id);
			
		redirect('Outstation/simulation');
	}

	public function print_simulation($simulation_id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(165,105), 0, '', 3, 3, 3, 3);

		$filename = 'Simulation_Detail_'.time();
		$this->checkSession();

		$data['data_simulation'] = $this->M_Simulation->select_edit_simulation($simulation_id);
		$data['GroupUSH'] = $this->M_Simulation->show_group_ush_all();
		$data['Simulation_detail'] = $this->M_Simulation->select_simulation_detail($simulation_id);
		$data['total_nominal'] = $this->M_Simulation->sum_simulation_nominal($simulation_id);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		
		$html = $this->load->view('general-afair/outstation/OutstationTransaction/Simulation/V_PrintSimulation', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}
}
