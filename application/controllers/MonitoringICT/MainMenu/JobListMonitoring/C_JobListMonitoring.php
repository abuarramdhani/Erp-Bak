<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_JobListMonitoring extends CI_controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringICT/MainMenu/JobListMonitoring/M_joblistmonitoring');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession()
		{
			if($this->session->is_logged){
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
			$data['DataMonitoring'] = $this->M_joblistmonitoring->getData($user_id);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/JobListMonitoring/V_JobListMonitoring',$data);
			$this->load->view('V_Footer',$data);
		}

	public function detail($id_perangkat,$periode_id)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['DataPerangkat']  = $this->M_joblistmonitoring->getDetPerangkat($id_perangkat,$periode_id);
			$data['Aspek'] 			= $this->M_joblistmonitoring->getAspek($id_perangkat,$periode_id);
			$dataHasil = $this->M_joblistmonitoring->getHasil($id_perangkat);
			$i = 0;
			foreach ($dataHasil as $key) {
				$dataHasil[$i]['aspek_hasil'] = $this->M_joblistmonitoring->getDetailHasil($key['hasil_monitoring_id']);
				if ($dataHasil[$i]['nomor_order'] != null) {
					$idTicket = $dataHasil[$i]['nomor_order'];
					$statusOrder = $this->M_joblistmonitoring->getStatusOrder($idTicket);
					if ($statusOrder) {
						$dataHasil[$i]['status_order'] = $statusOrder[0]['state'];
						$dataHasil[$i]['ticket_id'] = $statusOrder[0]['ticket_id'];
					}
				}
				$i++;
			}
			$data['limit'] = 10;
			$data['DataHasil'] = $dataHasil;
			$data['id_perangkat'] = $id_perangkat;
			$data['id_periode'] = $periode_id;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/JobListMonitoring/V_DetailJobList',$data);
			$this->load->view('V_Footer',$data);
		}

	public function searchHasil()
		{
			$limit = $this->input->post('limit');
			$id_perangkat = $this->input->post('perangkat');
			$dataHasil = $this->M_joblistmonitoring->getHasil($id_perangkat,$limit);
			$i = 0;
			foreach ($dataHasil as $key) {
				$dataHasil[$i]['aspek_hasil'] = $this->M_joblistmonitoring->getDetailHasil($key['hasil_monitoring_id']);
				if ($dataHasil[$i]['nomor_order'] != null) {
					$idTicket = $dataHasil[$i]['nomor_order'];
					$statusOrder = $this->M_joblistmonitoring->getStatusOrder($idTicket);
					if ($statusOrder) {
						$dataHasil[$i]['status_order'] = $statusOrder[0]['state'];
						$dataHasil[$i]['ticket_id'] = $statusOrder[0]['ticket_id'];
					}
				}
				$i++;
			}
			$data['limit'] = $limit;
			$data['DataHasil'] = $dataHasil;
			$this->load->view('MonitoringICT/MainMenu/JobListMonitoring/V_TableDetail',$data);
		}

		public function create()
		{
			$file_server = $this->input->post('idPerangkat');
			$server_name = $this->input->post('nmPerangkat');
			$info 		 = $this->input->post('txtInfo');
			$period 	 = $this->input->post('idPeriod');
			$period = $period == null ? '0' : $period;
			$dataMon 	 = date('Y-m-d');
			$aspek_id 	 = $this->input->post('aspID[]');
			$aspek_desc  = $this->input->post('aspDESC[]');
				$user_id 	 = $this->session->userid;
				$employeeid  = $this->M_joblistmonitoring->getEmployeeId($user_id);
			$employee_id = $employeeid[0]['employee_id'];
			$employee_name = $employeeid[0]['employee_name'];
			//proses save monitoring
				$data = array('employee_id'    => $employee_id, 
							  'tgl_monitoring' => $dataMon.' 00:00:00' ,
							  'info' 		   => $info ,
							  'perangkat_id'   => $file_server,
							  'periode_monitoring_id' => $period);
			$save 	= $this->M_joblistmonitoring->save($data);
			$idMon  = $save;
			//proses save hasil monitoring
			//cek standar
			$i = 0;
			foreach ($aspek_id as $aspID) {
				$aspek_penilaian = $aspID;
				$standar_penilaian = $this->input->post('std_asp_'.$aspID);
				$jenis_penilaian = $this->input->post('jns_asp_'.$aspID);
				$hasil_penilaian = $this->input->post('asp_'.$aspID);
				if (strpos($standar_penilaian,'<' ) !== false) {
					$pembanding = str_replace('<', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil < $pembanding ? 1 : 0 ;
				}elseif (strpos($standar_penilaian,'=' ) !== false) {
					$pembanding = str_replace('=', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil == $pembanding ? 1 : 0 ;
				}
				elseif (strpos($standar_penilaian,'>' ) !== false) {
					$pembanding = str_replace('>', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil > $pembanding ? 1 : 0 ;
				}
				elseif (strpos($standar_penilaian,'!' ) !== false) {
					$pembanding = str_replace('!', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil != $pembanding ? 1 : 0 ;
				}
				elseif (strpos($standar_penilaian,'|' ) !== false) {
					$pembanding = explode('|', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = ($pembanding[0] <= $hasil) && ($hasil <= $pembanding[1]) ? 1 : 0 ;
				}
					if ($jenis_penilaian == 'nn') {
						$tStd = $standar_penilaian == '=1' ? 'YA' : 'TIDAK';
						$tHasil = $hasil_penilaian == '1' ? 'YA' : 'TIDAK'.' [TIDAK STANDAR]';
					}elseif ($jenis_penilaian == 'n') {
						$tStd = $standar_penilaian;
						$tHasil = $result_aspek[$i] == 0 ? $hasil_penilaian.' [TIDAK STANDAR]' : $hasil_penilaian;
					}
					$txt[] ="(Aspek : ".$aspek_desc[$i]." ; "
						  ."Standar :".$tStd." ;"
						  ."Hasil :".$tHasil." ) ";

				$i++;
				$data2 =  array('hasil_monitoring_id' => $idMon, 
							    'aspek_id' => $aspek_penilaian,
								'standar' => $standar_penilaian,
								'hasil_pengecekan' => $hasil_penilaian,
								'jenis_standar' => $jenis_penilaian);

				$this->M_joblistmonitoring->saveDetail($data2);


			}  
			if (in_array('0', $result_aspek)) {
				$debug="0";
				$config = array(
				        'url'=>'http://ictsupport.quick.com/ticket/upload/api/http.php/tickets.json',  
						'key'=>'CBFC05877A21C7783981D7CAEEA77CD1'  // API Key goes here
				);
				if($config['url'] === 'http://your.domain.tld/api/http.php/tickets.jso') {
				  echo "<p style=\"color:red;\"><b>Error: No URL</b><br>You have not configured this script with your URL!</p>";
				  echo "Please edit this file ".__FILE__." and add your URL at line 18.</p>";
				  die();  
				}		
				if(($config['key'] === 'yourApiKey'))  {
				  echo "<p style=\"color:red;\"><b>Error: No API Key</b><br>You have not configured this script with an API Key!</p>";
				  echo "<p>Please log into osticket as an admin and navigate to: Admin panel -> Manage -> Api Keys then add a new API Key.<br>";
				  echo "Once you have your key edit this file ".__FILE__." and add the key at line 19.</p>";
				  die();
				}
				$data = array(
				    'alert'       => true,
				    'autorespond' => true,
				    'name'        =>  'Seksi Komputer',  // from name aka User/Client Name
			        'nameId'      =>  $employee_name,
				    'voipInternal' => '12300',
				    'email'       =>  'prg@quick.com',  // from email aka User/Client Email
					'phone' 	  =>  '12300',  // phone number aka User/Client Phone Number
				    'subject'     =>   'Monitoring '.$server_name.' tidak sesuai standar',  // test subject, aka Issue Summary
				    'purpose'     =>   'Agar perangkat sesuai dengan standarnya' ,
				    'message'     =>   'Petugas '.$employee_name.' melakukan pengecekan '.$server_name.' pada '.date('d M Y').'  dengan hasil : '. 					implode(',', $txt).' .Tolong diperiksa dan diperbaiki agar perangkat tersebut sesuai dengan standarnya',
				    'ip'          =>    $_SERVER['REMOTE_ADDR'], 
				    'priority' 	  =>    '4',
					 'topicId'    =>    '71',
				);

				if($debug=='1') {
				  print_r($data);
				  die();
				}

				#pre-checks
				function_exists('curl_version') or die('CURL support required');
				function_exists('json_encode') or die('JSON support required');

				#set timeout
				set_time_limit(30);

				#curl post
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $config['url']);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.8');
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$result=curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);

				if ($code != 201)
				    die('Unable to create ticket: '.$result);

				$ticket_id = (int) $result;

				function IsNullOrEmptyString($question){
				    return (!isset($question) || trim($question)==='');
				}

				$this->M_joblistmonitoring->insTicketNumb($idMon,$ticket_id);
			}

			redirect('MonitoringICT/JobListMonitoring');
			
		}

	public function edit($id)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['DataHasil'] = $this->M_joblistmonitoring->getHasilEdit($id);
			$id_perangkat = $data['DataHasil'][0]['perangkat_id'];
			$id_period = $data['DataHasil'][0]['periode_monitoring_id'];
			$data['id_perangkat'] = $id_perangkat;
			$data['id_periode'] = $id_period;
			$data['id_monitoring'] = $id;
			$data['Aspek'] 			= $this->M_joblistmonitoring->getAspek($id_perangkat,$id_period);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/JobListMonitoring/V_EditJoblist',$data);
			$this->load->view('V_Footer',$data);
		}

	public function delete()
		{
			$id_perangkat = $this->input->post('idPerangkat');
			$id_period = $this->input->post('idPeriod');
			$id_monitoring = $this->input->post('idMonitoring');
			$this->M_joblistmonitoring->delete($id_monitoring);
			$this->detail($id_perangkat,$id_period);
		}

	public function saveEdit()
		{
			$id_monitoring = $this->input->post('idMonitor');
			$file_server = $this->input->post('idPerangkat');
			$server_name = $this->input->post('nmPerangkat');
			$info 		 = $this->input->post('txtInfo');
			$period 	 = $this->input->post('idPeriod');
			$dataMon 	 = date('Y-m-d');
			$aspek_id 	 = $this->input->post('aspID[]');
			$aspek_desc  = $this->input->post('aspDESC[]');
			$detail_id   = $this->input->post('detID[]');
				$user_id 	 = $this->session->userid;
				$employeeid  = $this->M_joblistmonitoring->getEmployeeId($user_id);
			$employee_id = $employeeid[0]['employee_id'];
			$employee_name = $employeeid[0]['employee_name'];
			//proses save monitoring
				$data = array('info' 		   => $info );
				$this->M_joblistmonitoring->saveEdit($data,$id_monitoring);
			//proses save hasil monitoring
			//cek standar
			$i = 0;
			foreach ($aspek_id as $aspID) {
				$aspek_penilaian = $aspID;
				$standar_penilaian = $this->input->post('std_asp_'.$aspID);
				$jenis_penilaian = $this->input->post('jns_asp_'.$aspID);
				$hasil_penilaian = $this->input->post('asp_'.$aspID);
				if (strpos($standar_penilaian,'<' ) !== false) {
					$pembanding = str_replace('<', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil < $pembanding ? 1 : 0 ;
				}elseif (strpos($standar_penilaian,'=' ) !== false) {
					$pembanding = str_replace('=', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil == $pembanding ? 1 : 0 ;
				}
				elseif (strpos($standar_penilaian,'>' ) !== false) {
					$pembanding = str_replace('>', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil > $pembanding ? 1 : 0 ;
				}
				elseif (strpos($standar_penilaian,'!' ) !== false) {
					$pembanding = str_replace('!', '', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = $hasil != $pembanding ? 1 : 0 ;
				}
				elseif (strpos($standar_penilaian,'|' ) !== false) {
					$pembanding = explode('|', $standar_penilaian);
					$hasil 	    = $hasil_penilaian;
					$result_aspek[$i] = ($pembanding[0] <= $hasil) && ($hasil <= $pembanding[1]) ? 1 : 0 ;
				}
					if ($jenis_penilaian == 'nn') {
						$tStd = $standar_penilaian == '=1' ? 'YA' : 'TIDAK';
						$tHasil = $hasil_penilaian == '1' ? 'YA' : 'TIDAK'.' [TIDAK STANDAR]';
					}elseif ($jenis_penilaian == 'n') {
						$tStd = $standar_penilaian;
						$tHasil = $result_aspek[$i] == 0 ? $hasil_penilaian.' [TIDAK STANDAR]' : $hasil_penilaian;
					}
					$txt[] ="(Aspek : ".$aspek_desc[$i]." ; "
						  ."Standar :".$tStd." ;"
						  ."Hasil :".$tHasil." ) ";

				$data2 =  array('hasil_monitoring_id' => $id_monitoring, 
							    'aspek_id' => $aspek_penilaian,
								'standar' => $standar_penilaian,
								'hasil_pengecekan' => $hasil_penilaian,
								'jenis_standar' => $jenis_penilaian);
				$this->M_joblistmonitoring->saveEditDetail($data2,$detail_id[$i]);
				$i++;


			}  
			if (in_array('0', $result_aspek)) {
				$debug="0";
				$config = array(
				        'url'=>'http://ictsupport.quick.com/ticket/upload/api/http.php/tickets.json',  
						'key'=>'CBFC05877A21C7783981D7CAEEA77CD1'  // API Key goes here
				);
				if($config['url'] === 'http://your.domain.tld/api/http.php/tickets.jso') {
				  echo "<p style=\"color:red;\"><b>Error: No URL</b><br>You have not configured this script with your URL!</p>";
				  echo "Please edit this file ".__FILE__." and add your URL at line 18.</p>";
				  die();  
				}		
				if(($config['key'] === 'yourApiKey'))  {
				  echo "<p style=\"color:red;\"><b>Error: No API Key</b><br>You have not configured this script with an API Key!</p>";
				  echo "<p>Please log into osticket as an admin and navigate to: Admin panel -> Manage -> Api Keys then add a new API Key.<br>";
				  echo "Once you have your key edit this file ".__FILE__." and add the key at line 19.</p>";
				  die();
				}
				$data = array(
				    'alert'       => true,
				    'autorespond' => true,
				    'name'        =>  'Seksi Komputer',  // from name aka User/Client Name
			        'nameId'      =>  $employee_name,
				    'voipInternal' => '12300',
				    'email'       =>  'prg@quick.com',  // from email aka User/Client Email
					'phone' 	  =>  '12300',  // phone number aka User/Client Phone Number
				    'subject'     =>   'Monitoring '.$server_name.' tidak sesuai standar',  // test subject, aka Issue Summary
				    'purpose'     =>   'Agar perangkat sesuai dengan standarnya' ,
				    'message'     =>   'Petugas '.$employee_name.' melakukan pengecekan '.$server_name.' pada '.date('d M Y').'  dengan hasil : '. 					implode(',', $txt).' .Tolong diperiksa dan diperbaiki agar perangkat tersebut sesuai dengan standarnya',
				    'ip'          =>    $_SERVER['REMOTE_ADDR'], 
				    'priority' 	  =>    '4',
					 'topicId'    =>    '71',
				);

				if($debug=='1') {
				  print_r($data);
				  die();
				}

				#pre-checks
				function_exists('curl_version') or die('CURL support required');
				function_exists('json_encode') or die('JSON support required');

				#set timeout
				set_time_limit(30);

				#curl post
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $config['url']);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.8');
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$result=curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);

				if ($code != 201)
				    die('Unable to create ticket: '.$result);

				$ticket_id = (int) $result;

				function IsNullOrEmptyString($question){
				    return (!isset($question) || trim($question)==='');
				}

				$this->M_joblistmonitoring->insTicketNumb($idMon,$ticket_id);
			}

			$this->detail($file_server,$period);
		}
}