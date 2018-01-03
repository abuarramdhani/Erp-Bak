<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_InputFileServer extends CI_Controller
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
			$this->load->model('MonitoringICT/MainMenu/MonitoringFileServer/M_MonitoringFileServer');
			  
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
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['RuangServer'] = $this->M_MonitoringFileServer->getServer();
			$data['Petugas']   = $this->M_MonitoringFileServer->getPetugas();
			$data['Aspek'] = $this->M_MonitoringFileServer->getAspek();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/MonitoringFileServer/V_InputFileServer',$data);
			$this->load->view('V_Footer',$data);
		}

	public function save()
		{
			$file_server = $this->input->post('slcFileServer');
			$info 		 = $this->input->post('txtInfo');
			$date 		 = $this->input->post('txtDate');
			$aspek_id 	 = $this->input->post('aspID[]');
			$aspek_desc  = $this->input->post('aspDESC[]');
			$employee_id = $this->input->post('slcPetugas');
				 $dt = str_replace('/', '-', $date);
			$dataMon = date('Y-m-d', strtotime($dt));

			//proses save monitoring
				$data = array('employee_id'    => $employee_id, 
							  'tgl_monitoring' => $dataMon.' 00:00:00' ,
							  'info' 		   => $info ,
							  'perangkat_id'   => $file_server);

			$save 	= $this->M_MonitoringFileServer->save($data);
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

					if ($jenis_penilaian == 'nn') {
						$tStd = $standar_penilaian == '=1' ? 'YA' : 'TIDAK';
						$tHasil = $hasil_penilaian == '1' ? 'YA' : '<b>TIDAK</b>';
					}elseif ($jenis_penilaian == 'n') {
						$tStd = $standar_penilaian;
						$tHasil = $hasil_penilaian;
					}
					$txt[] ="Aspek : ".$aspek_desc[$i]."<br>"
						  ."Standar :".$tStd."<br>"
						  ."Hasil :".$tHasil."<br>";

				$i++;
				$data2 =  array('hasil_monitoring_id' => $idMon, 
							    'aspek_id' => $aspek_penilaian,
								'standar' => $standar_penilaian,
								'hasil_pengecekan' => $hasil_penilaian,
								'jenis_standar' => $jenis_penilaian);

				$this->M_MonitoringFileServer->saveDetail($data2);


			}  implode('|', $txt);
			if (in_array('0', $result_aspek)) {
			}else{
			}
			redirect('MonitoringFileServer/Monitoring');
			
		}
		
}