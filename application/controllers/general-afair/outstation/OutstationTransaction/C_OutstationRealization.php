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
		$position_id = $this->input->post('txt_position_id');
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
		$indexx=0;
		$meal_pagi = 0;
		$meal_siang = 0;
		$meal_malam = 0;
		$nom_meal_pagi = '';
		$nom_meal_siang = '';
		$nom_meal_malam = '';
		$nom_inn_malam = '';
		foreach ( $period as $dt ){
			$count--;
			if ($count == 0) {
				$waktu_kembali = $x;
			}
			else {
				$waktu_kembali = 3;
			}
				for ($time=$i; $time <= $waktu_kembali; $time++) {
					$meal_allowance = $this->M_Realization->show_meal_allowance($position_id,$area_id,$time_name[$time]);
					$accomodation_allowance = $this->M_Realization->show_accomodation_allowance($position_id,$area_id,$city_type_id);
					$group_ush = $this->M_Realization->show_group_ush($position_id,$return_time);
					
					foreach ($accomodation_allowance as $aa) {
						foreach ($meal_allowance as $ma) {
							foreach ($group_ush as $grp) {
								$indexx++;
								if ($time == $y) {
									$acc_nominal = $aa['nominal'];
									$nom_inn_malam = $aa['nominal'];
								}
								else{
									$acc_nominal = '0';
								}
								if ($time == $i) {
									$nominal_ush = array($indexx => $grp['nominal']);
									//$nominal_ush[$indexx] = $grp['nominal'];
								}
								else{
									$nominal_ush[$indexx] = '0';
								}
								$meal = array($indexx => $ma['nominal']);
								$acc = array($indexx =>$acc_nominal);
								//$meal[$indexx] = $ma['nominal'];
								//$acc[$indexx] = $acc_nominal;
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

								$acc_number[$indexx] = str_replace($string, $remover, $acc[$indexx]);

								$ush_number[$indexx] = str_replace($string, $remover, $nominal_ush[$indexx]);

								//$total[$indexx] = $meal_number[$indexx]+$acc_number[$indexx]+$ush_number[$indexx];
								$total_meal = array_sum($meal_number);
								$total_acc = array_sum($acc_number);
								$total_ush = array_sum($ush_number);
								$total_all = $total_meal+$total_acc+$total_ush;
							}
						}
					}

				}
				$i=1;
		}
				if($meal_allowance AND $accomodation_allowance AND $group_ush){
					$total_meal_pagi = $meal_pagi*$nom_meal_pagi;
					$total_meal_siang = $meal_siang*$nom_meal_siang;
					$total_meal_malam = $meal_malam*$nom_meal_malam;
					echo '
						<div class="col-md-6">
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
							</div>
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
							</div>
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									 USH
								</div>
								<div class="col-md-8">
									<div class="row">
										<p id="ush-estimate">Rp.'.number_format($total_ush , 2, ',', '.').'</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4">
									Total Estimated
								</div>
								<div class="col-md-8">
									<p id="total-estimate">Rp.'.number_format($total_all , 2, ',', '.').'</p>
								</div>
							</div>
						</div>
						';
				}
				else{
					echo '
						<div class="col-md-6">
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
							</div>
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
							</div>
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-7">
									 USH
								</div>
								<div class="col-md-5">
									<p id="ush-estimate">Rp0,00</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-5">
									Total Estimated
								</div>
								<div class="col-md-5">
									<p id="total-estimate">Rp0,00</p>
								</div>
							</div>
						</div>
						';
				}
	}

	public function save_Realization()
	{
		$employee_id = $this->input->post('txt_employee_id');
		$position_id = $this->input->post('txt_position_id');
		$area_id = $this->input->post('txt_area_id');
		$city_type_id = $this->input->post('txt_city_type_id');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$bon_string = $this->input->post('txt_bon');
		$data_count = $this->input->post('txt_data_counter');

		$string = array('Rp','.');

		$bon = str_replace($string, '', $bon_string);

		$this->M_Realization->new_realization($employee_id,$area_id,$city_type_id,$depart,$return,$bon);

		for ($i=0; $i < $data_count; $i++){ 
			$component_id = $this->input->post('txt_component['.$i.']');
			$info = $this->input->post('txt_info['.$i.']');
			$qty = $this->input->post('txt_qty['.$i.']');
			$component_nominal_string = $this->input->post('txt_component_nominal['.$i.']');
			$string = array('Rp','.');

			$component_nominal = str_replace($string, '', $component_nominal_string);


			if(strlen($component_id) > 0 && strlen($info) > 0 && strlen($qty) > 0 && strlen($component_nominal) > 0){
				$this->M_Realization->new_realization_detail($component_id,$info,$qty,$component_nominal);
			}
		}

		redirect('Outstation/realization');
	}

	public function edit_Realization($realization_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_realization'] = $this->M_Realization->select_edit_Realization($realization_id);
		$data['data_realization_detail'] = $this->M_Realization->select_edit_Realization_detail($realization_id);
		$data['Area'] = $this->M_Realization->show_area();
        $data['CityType'] = $this->M_Realization->show_city_type();
        $data['Employee'] = $this->M_Realization->show_employee();
        $data['Component'] = $this->M_Realization->show_component();

        foreach ($data['data_realization'] as $realization) {
        	$position_id = $realization['outstation_position'];
        	$area_id = $realization['area_id'];
			$city_type_id = $realization['city_type_id'];
			$bon = $realization['bon_nominal'];
			$depart = $realization['depart_time'];
				$depart_ex =explode(' ', $depart);
					$depart_tgl = $depart_ex[0];
					$depart_wkt = $depart_ex[1];
						$depart_wkt_ex = explode(':', $depart_wkt);
							$depart_time = $depart_wkt_ex[0].':'.$depart_wkt_ex[1];
			$return = $realization['return_time'];
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
			$indexx=0;
			$data['meal_pagi'] = 0;
			$data['meal_siang'] = 0;
			$data['meal_malam'] = 0;
			$data['nom_meal_pagi'] = '';
			$data['nom_meal_siang'] = '';
			$data['nom_meal_malam'] = '';
			$data['nom_inn_malam'] = '';
			foreach ( $period as $dt ){
				$count--;
				if ($count == 0) {
					$waktu_kembali = $x;
				}
				else {
					$waktu_kembali = 3;
				}
					for ($time=$i; $time <= $waktu_kembali; $time++) {
						$meal_allowance = $this->M_Realization->show_meal_allowance($position_id,$area_id,$time_name[$time]);
						$accomodation_allowance = $this->M_Realization->show_accomodation_allowance($position_id,$area_id,$city_type_id);
						$group_ush = $this->M_Realization->show_group_ush($position_id,$return_time);
						
						foreach ($accomodation_allowance as $aa) {
							foreach ($meal_allowance as $ma) {
								foreach ($group_ush as $grp) {
									$indexx++;
									if ($time == $y) {
										$acc_nominal = $aa['nominal'];
										$data['nom_inn_malam'] = $aa['nominal'];
									}
									else{
										$acc_nominal = '0';
									}
									if ($time == $i) {
										$nominal_ush = array($indexx => $grp['nominal']);
										//$nominal_ush[$indexx] = $grp['nominal'];
									}
									else{
										$nominal_ush[$indexx] = '0';
									}
									$meal = array($indexx => $ma['nominal']);
									$acc = array($indexx =>$acc_nominal);
									//$meal[$indexx] = $ma['nominal'];
									//$acc[$indexx] = $acc_nominal;
									if (strtolower($ma['time_name']) == strtolower("Pagi")) {
										$data['meal_pagi']++;
										$data['nom_meal_pagi'] = $ma['nominal'];
									}
									if (strtolower($ma['time_name']) == strtolower("Siang")) {
										$data['meal_siang']++;
										$data['nom_meal_siang'] = $ma['nominal'];
									}
									if (strtolower($ma['time_name']) == strtolower("Malam")) {
										$data['meal_malam']++;
										$data['nom_meal_malam'] = $ma['nominal'];
									}

									$string = array('Rp',',00','.');
									$remover = array('');

									$meal_number[$indexx] = str_replace($string, $remover, $meal[$indexx]);

									$acc_number[$indexx] = str_replace($string, $remover, $acc[$indexx]);

									$ush_number[$indexx] = str_replace($string, $remover, $nominal_ush[$indexx]);

									//$total[$indexx] = $meal_number[$indexx]+$acc_number[$indexx]+$ush_number[$indexx];
									$total_meal = array_sum($meal_number);
									$total_acc = array_sum($acc_number);
									$total_ush = array_sum($ush_number);
									$total_all = $total_meal+$total_acc+$total_ush;
								}
							}
						}

					}
					$i=1;
			}
					if($meal_allowance AND $accomodation_allowance AND $group_ush){
						$data['total_meal_pagi'] = $data['meal_pagi']*$data['nom_meal_pagi'];
						$data['total_meal_siang'] = $data['meal_siang']*$data['nom_meal_siang'];
						$data['total_meal_malam'] = $data['meal_malam']*$data['nom_meal_malam'];
						$data['total_meal'] = 'Rp'.number_format($total_meal , 2, ',', '.');
						$data['total_acc'] = 'Rp'.number_format($total_acc , 2, ',', '.');
						$data['total_ush'] = 'Rp'.number_format($total_ush , 2, ',', '.');
						$data['total_all'] = 'Rp'.number_format($total_all , 2, ',', '.');
					}
					else{
						$data['total_meal_pagi'] = 'Rp0,00';
						$data['total_meal_siang'] = 'Rp0,00';
						$data['total_meal_malam'] = 'Rp0,00';
						$data['total_meal'] = 'Rp0,00';
						$data['total_acc'] = 'Rp0,00';
						$data['total_ush'] = 'Rp0,00';
						$data['total_all'] = 'Rp0,00';
					}
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationTransaction/Realization/V_EditRealization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_Realization(){
		$realization_id = $this->input->post('txt_realization_id');
		$employee_id = $this->input->post('txt_employee_id');
		$area_id = $this->input->post('txt_area_id');
		$city_type_id = $this->input->post('txt_city_type_id');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$bon_string = $this->input->post('txt_bon');
		$data_count = $this->input->post('txt_data_counter');
		
		$string = array('Rp','.');

		$bon = str_replace($string, '', $bon_string);

		$this->M_Realization->update_realization($realization_id,$employee_id,$area_id,$city_type_id,$depart,$return,$bon);
		$this->M_Realization->delete_before_update($realization_id);

		for ($i=0; $i < $data_count; $i++){ 
			$component_id = $this->input->post('txt_component['.$i.']');
			$info = $this->input->post('txt_info['.$i.']');
			$qty = $this->input->post('txt_qty['.$i.']');
			$component_nominal_string = $this->input->post('txt_component_nominal['.$i.']');
			$string = array('Rp','.');

			$component_nominal = str_replace($string, '', $component_nominal_string);


			if(strlen($component_id) > 0 && strlen($info) > 0 && strlen($qty) > 0 && strlen($component_nominal) > 0){
				$this->M_Realization->update_realization_detail($realization_id,$component_id,$info,$qty,$component_nominal);
			}
		}

		//redirect('Outstation/realization');
	}

	public function delete_realization($realization_id){
		$this->M_Realization->delete_realization($realization_id);
			
		redirect('Outstation/realization');
	}


	public function print_realization($realization_id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(165,105), 0, '', 3, 3, 3, 3);

		$filename = 'Simulation_Detail_'.time();
		$this->checkSession();

		$data['data_realization'] = $this->M_Realization->select_edit_Realization($realization_id);
		$data['Component'] = $this->M_Realization->show_component();
		$data['data_realization_detail'] = $this->M_Realization->select_edit_Realization_detail($realization_id);

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('general-afair/outstation/OutstationTransaction/Realization/V_PrintRealization', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}
}
