<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_User extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		//load the login model
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->model('M_index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemAdministration/MainMenu/M_responsibility');
		//$this->load->model('Setting/M_usermenu');
		//$this->load->library('encryption');
		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
			//redirect('Home');
		} else {
			redirect('');
		}
		if ($this->session->userLevel == 'U') {
			redirect('');
		}
	}

	public function index()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->username;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;

		$data['Menu'] = 'User';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';

		//Variabel tambahan pada halaman index (data seluruh user)
		$data['AllUser'] = $this->M_user->getUser();

		//Load halaman
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SystemAdministration/MainMenu/User/V_Index', $data);
		$this->load->view('V_Footer', $data);

		if ($this->session->insertuser) {
			$this->session->unset_userdata("insertuser");
		}

		if ($this->session->updateuser) {
			$this->session->unset_userdata("updateuser");
		}

		if ($this->session->deleteuser) {
			$this->session->unset_userdata("deleteuser");
		}
	}

	public function NewUser()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;

		$data['Menu'] = 'User';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility();


		$this->form_validation->set_rules('txtUsername', 'username', 'required');
		$this->form_validation->set_rules('txtPassword', 'Password', 'required');

		$data['title'] = 'Create User';

		if ($this->form_validation->run() === FALSE) {
			//$this->load->view('templates/header', $data);
			//Load halaman
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemAdministration/MainMenu/User/V_create', $data);
			$this->load->view('V_Footer', $data);
			//$this->load->view('templates/footer');

		} else {
			$data = array(
				'user_name' 	=> $this->input->post('txtUsername'),
				'user_password'	=> md5($this->input->post('txtPassword')),
				'employee_id' => ($this->input->post('slcEmployee')) ? $this->input->post('slcEmployee') : NULL,
				'creation_date' =>  $this->input->post('hdnDate'),
				'created_by' =>  $this->input->post('hdnUser')
			);

			$this->M_user->setUser($data);
			$insert_id = $this->db->insert_id();

			$responsibility_id = $this->input->post('slcUserResponsbility');
			$active = $this->input->post('slcActive');
			$lokal		= $this->input->post('slcLokal');
			$internet	= $this->input->post('slcInternet');

			$i = 0;
			foreach ($responsibility_id as $loop) {
				$data_responsbility[$i] = array(
					'user_group_menu_id' 	=> $responsibility_id[$i],
					'user_id'				=> $insert_id,
					'active'				=> $active[$i],
					'creation_date' 		=> $this->input->post('hdnDate'),
					'created_by' 			=> $this->input->post('hdnUser'),
					'lokal'					=> $lokal[$i],
					'internet'				=> $internet[$i]
				);
				$this->M_user->setUserResponsbility($data_responsbility[$i]);
				$i++;
			}

			$aksi = 'Create User';
			$detail = 'Create User ' . $this->input->post('txtUsername');
			$this->log_activity->activity_log($aksi, $detail);

			redirect('SystemAdministration/User');
		}
	}

	public function UpdateUser($id)
	{
		$user_id = $this->session->userid;

		$data['Menu'] = 'User'; //menu title
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility();


		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);


		$data['UserResponsibility'] = $this->M_user->getUserResponsibility($plaintext_string);
		// print_r($data['UserResponsibility']);exit();
		// echo $plaintext_string;exit();

		$data['UserData'] = $this->M_user->getUser($plaintext_string);
		$data['id'] = $id;

		$this->form_validation->set_rules('txtUsername', 'username', 'required');

		$data['title'] = 'Create User';

		if ($this->form_validation->run() === FALSE) {
			//$this->load->view('templates/header', $data);

			//Load halaman
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemAdministration/MainMenu/User/V_update', $data);
			$this->load->view('V_Footer', $data);
		} else {
			if ($this->input->post('txtPassword') != '' and $this->input->post('txtPasswordCheck') != '') {
				$data = array(
					'employee_id' =>  $this->input->post('slcEmployee'),
					'user_password'	=> md5($this->input->post('txtPassword')),
					'creation_date' =>  $this->input->post('hdnDate'),
					'created_by' =>  $this->input->post('hdnUser')
				);
			} else {
				$data = array(
					'employee_id' =>  $this->input->post('slcEmployee'),
					'creation_date' =>  $this->input->post('hdnDate'),
					'created_by' =>  $this->input->post('hdnUser')
				);
			}
			$this->M_user->updateUser($data, $plaintext_string);

			$aksi = 'Update User';
			$detail = 'Update User ' . $this->input->post('txtUsername');
			$this->log_activity->activity_log($aksi, $detail);

			$responsibility_id = $this->input->post('slcUserResponsbility');
			$active = $this->input->post('slcActive');
			$user_application_id = $this->input->post('hdnUserApplicationId');

			$i = 0;
			$lokal		= $this->input->post('slcLokal');
			$internet	= $this->input->post('slcInternet');

			foreach ($responsibility_id as $loop) {

				$data_responsbility[$i] = array(
					'user_group_menu_id' 	=> $responsibility_id[$i],
					'user_id'				=> $plaintext_string,
					'active'				=> $active[$i],
					'last_update_date' 		=> $this->input->post('hdnDate'),
					'last_updated_by' 		=> $this->input->post('hdnUser'),
					'creation_date' 		=> $this->input->post('hdnDate'),
					'created_by' 			=> $this->input->post('hdnUser'),
					'lokal'					=> $lokal[$i],
					'internet'				=> $internet[$i]
				);

				// print_r($data_responsbility);exit();
				if (count($responsibility_id) > 0) {
					if ($user_application_id[$i] == 0) {
						unset($data_responsbility[$i]['last_update_date']);
						unset($data_responsbility[$i]['last_updated_by']);
						$this->M_user->setUserResponsbility($data_responsbility[$i]);
					} else {
						unset($data_responsbility[$i]['creation_date']);
						unset($data_responsbility[$i]['created_by']);
						$UserResponsibility = $this->M_user->getUserResponsibility($plaintext_string, "", $user_application_id[$i]);
						if (
							$data_responsbility[$i]['user_group_menu_id'] != $UserResponsibility[0]['user_group_menu_id']
							or $data_responsbility[$i]['active'] != $UserResponsibility[0]['active'] or $data_responsbility[$i]['lokal'] != $UserResponsibility[0]['lokal'] or $data_responsbility[$i]['internet'] != $UserResponsibility[0]['internet']
						) {
							$this->M_user->UpdateUserResponsbility($data_responsbility[$i], $user_application_id[$i]);
						}
					}
				}
				$i++;
			}
			// print_r($data_responsbility);
			// print_r($user_application_id);
			redirect('SystemAdministration/User');
		}
	}

	public function ChangePassword($id)
	{

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		//echo $plaintext_string;

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->username;
		$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$data['MenuTitle'] = "Setting";
		$data['SubMenuTitle'] = "User";


		$data['ProvinceData'] = $this->M_index->getAllProvince();
		//Variabel tambahan pada halaman index (data seluruh user)
		$data['UserData'] = $this->M_user->getUserDataById($plaintext_string);
		foreach ($data['UserData'] as $ud) {
			$area = $ud['coverage_area'];
		}
		$area = str_replace('"', '', $area);
		$ex = explode(',', $area);
		foreach ($ex as $e => $key) {
			$data['area' . $key] = 1;
		}

		$aksi = 'Change Password';
		$detail = 'Change Password';
		$this->log_activity->activity_log($aksi, $detail);

		//Load halaman
		$this->load->view('CatalogMonitoring/V_Header', $data);
		$this->load->view('CatalogMonitoring/V_Sidemenu', $data);
		$this->load->view('CatalogMonitoring/V_ChangePassword', $data);
		$this->load->view('CatalogMonitoring/V_Footer', $data);
	}

	public function SaveUpdate()
	{
		//mendapatkan variabel post
		$username = $this->input->post('workerid');
		$emp_id = $this->input->post('empid');
		$password = $this->input->post('password');
		if ($password == "") {
		} else {
			$password = md5($this->input->post('password'));
		}

		$allarea = $this->input->post('allarea');
		$apbn = $this->input->post('apbn');
		if ($allarea == '1') {
			$cvr = "";
		} else {
			$coverage = $this->input->post('coverage');
			$cvr = "";
			$i = 1;
			foreach ($coverage as $cv) {
				if ($i == 1) {
					$cvr = '"' . $cv . '"';
				} else {
					$cvr = $cvr . ',"' . $cv . '"';
				}
				$i++;
			}
		}

		$this->M_user->SaveUpdateUser($username, $password, $emp_id, $allarea, $cvr, $apbn);

		$aksi = 'Update User';
		$detail = 'Update User ' . $this->input->post('txtUsername');
		$this->log_activity->activity_log($aksi, $detail);

		$ses = array(
			'updateuser' => 1
		);
		$this->session->set_userdata($ses);
		redirect('Setting/User');
	}

	public function SaveUpdatePassword()
	{
		//mendapatkan variabel post
		$username = $this->input->post('workerid');
		$emp_id = $this->input->post('empid');
		$password = $this->input->post('password');
		if ($password == "") {
		} else {
			$password = md5($this->input->post('password'));
		}

		$allarea = $this->input->post('allarea');
		$apbn = $this->input->post('apbn');
		if ($allarea == '1') {
			$cvr = "";
		} else {
			$coverage = $this->input->post('coverage');
			$cvr = "";
			$i = 1;
			foreach ($coverage as $cv) {
				if ($i == 1) {
					$cvr = '"' . $cv . '"';
				} else {
					$cvr = $cvr . ',"' . $cv . '"';
				}
				$i++;
			}
		}

		$this->M_user->SaveUpdateUser($username, $password, $emp_id, $allarea, $cvr, $apbn);

		$ses = array(
			'updateuser' => 1
		);
		$this->session->set_userdata($ses);
		redirect('Home');
	}

	public function DeleteUser($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_user->DeleteUser($plaintext_string);
		$this->M_usermenu->DeleteUserMenu($plaintext_string);

		$ses = array(
			'deleteuser' => 1
		);
		$this->session->set_userdata($ses);

		redirect('Setting/User');
	}

	public function DeleteUserResponsibility($user_application_id)
	{
		$this->M_user->DeleteUserResponsbility($user_application_id);
		$aksi = 'Delete User Responsibility';
		$detail = 'Delete User Responsibility ' . $user_application_id;
		$this->log_activity->activity_log($aksi, $detail);
		echo $user_application_id;
	}

	//Memanggil ajax optionlist user dengan select2
	public function OptionList()
	{
		$q = strtoupper($this->input->get('term')); //variabel kode pegawai
		$hasil = $this->M_user->getEmployeeByCode($q);
		echo json_encode($hasil);
	}

	//Memanggil ajax optionlist user dengan select2
	public function OptionList2()
	{
		$q = strtoupper($this->input->get('term')); //variabel kode pegawai
		$hasil = $this->M_user->getEmployeeByCode2($q);
		echo json_encode($hasil);
	}

	//Memanggil ajax optionlist user dengan chosen
	public function WorkerChosen()
	{
		$q = strtoupper($this->input->post('data[q]')); //variabel kode pegawai
		$worker = $this->M_user->getEmployeeLikeCode($q);
		echo json_encode(array('q' => $q, 'results' => $worker));
	}

	//ajax untuk mengisi nama pekerja setelah kode pekerja dipilih
	public function fill_workername()
	{
		$id = $this->input->post("id");  //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy($id);
		foreach ($worker as $wk) {
			echo trim($wk->employee_name);
		}
	}

	//ajax untuk mengisi seksi pekerja setelah kode pekerja dipilih
	public function fill_workersection()
	{
		$id = $this->input->post("id");  //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy($id);
		foreach ($worker as $wk) {
			echo trim($wk->section_name);
		}
	}

	//ajax untuk mengisi lokasi pekerja setelah kode pekerja dipilih
	public function fill_branch()
	{
		$id = $this->input->post("id");  //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy($id);
		foreach ($worker as $wk) {
			if (trim($wk->location_name) == "") {
				echo trim($wk->section_name);
			} else {
				echo trim($wk->location_name);
			}
		}
	}


	//ajax untuk mengisi id lokasi pekerja setelah kode pekerja dipilih
	public function fill_branchid()
	{
		$id = $this->input->post("id"); //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy($id);
		foreach ($worker as $wk) {
			echo $wk->location_name;
		}
	}

	//ajax untuk mengisi id lokasi pekerja setelah kode pekerja dipilih
	public function fill_empid()
	{
		$id = $this->input->post("id"); //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy($id);
		foreach ($worker as $wk) {
			echo $wk->employee_id;
		}
	}

	public function checkStatus()
	{
		$id = $this->input->post("id"); //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy2($id);
		if ($worker > 0) {
			echo "This worker is already exist, please choose another user";
		} else {
			echo "";
		}
	}

	public function checkStatus2()
	{
		$id = $this->input->post("id"); //variabel id pegawai
		$worker = $this->M_user->getEmployeeNameBy2($id);
		if ($worker > 0) {
			echo true;
		} else {
			echo false;
		}
	}

	//Fumgsi validasi dengan ajax untuk mengecek apakah user sudah ada di database
	public function CekExist()
	{
		$username = strtoupper($_POST['workerid']);  //id pekerja yang akan dicek

		// Check its existence (for example, execute a query from the database) ...
		$exist = $this->M_user->isUserExist($username); // fungsi untuk mengecek keberadaan
		// Finally, return a JSON
		if ($exist) {
			$valid = false; // kembalikan nilai false, jika ada datanya
		} else {
			$valid = true; // kembalikan nilai true, jika belum ada datanya
		}

		//mengubah hasil kembalian ke dalam format json agar bisa dikenali oleh plugin bootstrap validation
		echo json_encode(array(
			'valid' => $valid,
		));
	}

	public function ListUser()
	{
		//get data dalam bentuk array dari database
		$user = $this->M_user->getAllUserData();

		//define variable
		$output = array();
		$a = 1;
		$i = 0;
		//loop data yang didapat dari database untuk dibentuk ke format datatable
		foreach ($user as $k => $value) {
			//menyimpan data hasil get ke dalam format datatables
			$output[] = array_values($value);

			//get variable yang dibutuhkan untuk action
			$code = $output[$i][1]; //get nama
			$nama = $output[$i][2]; //get nama

			//get customer_id lalu meng-encript nya
			$encrypted_string = $this->encrypt->encode($output[$i][0]);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			//Setting array
			array_shift($output[$i]); //keluarkan id agar tidak ditampilkan
			array_unshift($output[$i], "$a"); //masukkan no urut di index paling depan
			//Memasukkan action pada kolom paling akhir
			array_push(
				$output[$i],
				'	<a href="' . site_url() . 'Setting/User/UpdateUser/' . $encrypted_string . '" style="width:30%;" class="btn btn-info"><i class="fa fa-edit"></i> <span class="reup">&nbsp;Edit</span></a> &nbsp;
								<a href="' . site_url() . 'Setting/UserMenu/SetAccess/' . $encrypted_string . '" style="width:30%;" class="btn btn-warning"><i class="fa fa-edit"></i> <span class="reup">&nbsp;Access</span></a> &nbsp;
								<a href="#" style="width:30%;" onclick="callModal(\'' . site_url('Setting/User/DeleteUser/' . $encrypted_string) . '\',\' User ' . $code . ' (' . $nama . ') \',event)" class="btn btn-danger"><i class="fa fa-close"></i> <span class="reup">&nbsp;Delete</span></a>
							'
			);
			$a++;
			$i++;
		}

		//menampilkan data dalam bentuk json untuk dilempar ke datatable
		echo json_encode(array('data' => $output));
	}

	public function tes()
	{
		$worker = $this->M_user->getEmployeeNameBy3("A0978");

		foreach ($worker as $wk) {
			$area = $wk['coverage_area'];
		}

		$area1 = str_replace('"', "'", $area);
		echo $area1;
	}

	public function getCheckUser()
	{
		$text = $this->input->post('text');
		$data = $this->M_user->getCheckUser($text);
		$angka = 0;
		foreach ($data as $key) {
			$encrypted_string = $this->encrypt->encode($key['user_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$data[$angka]['user_id'] = base_url('SystemAdministration/User/UpdateUser/' . $encrypted_string);
			$angka++;
		}
		echo json_encode($data);
	}

	public function getCheckEmployee()
	{
		$text = $this->input->post('text');
		$data = $this->M_user->getCheckEmployee($text);
		$angka = 0;
		foreach ($data as $key) {
			$encrypted_string = $this->encrypt->encode($key['user_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$data[$angka]['user_id'] = base_url('SystemAdministration/User/UpdateUser/' . $encrypted_string);
			$angka++;
		}
		echo json_encode($data);
	}
}
