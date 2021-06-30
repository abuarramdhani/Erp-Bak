<?php
defined('BASEPATH') or die('No direct script access allowed');
class C_Grafik extends CI_Controller
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
			$this->load->model('FlowProses/M_Grafik');

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
			$data['datagraf'] = $this->M_Grafik->getData();

			$datadump = array();
			$recapDay = array();
			$recapComp = array();
			$arraytampung = array();
			$arraytampung2 = array();
			$sum = 0;
			foreach ($data['datagraf'] as $key => $value) {
				$exp = explode(' ', $value['weekly']);
				$arraytampung[$exp[0]] = $value['count'];
			}

			if ($data['datagraf']) {
				$exp = explode(' ', $data['datagraf'][0]['weekly']);
				$tglawal = $exp[0];
			}
			$minggu_selanjutnya = $tglawal;
			$sekarangharike = date('w');

			$tglsekarang = date('Y-m-d');
			$hariseninmingguini = date("Y-m-d", strtotime("-".($sekarangharike-1)." day", strtotime($tglsekarang)));


			$a =0;
			while ($minggu_selanjutnya <= $hariseninmingguini) {
				$date_tglawal = strtotime($minggu_selanjutnya);
				$dateyangdicari =  date('Y-m-d',$date_tglawal);
				if (isset($arraytampung[$dateyangdicari])) {
					$datadump[$a]['u'] = $arraytampung[$dateyangdicari];
					$sum += $arraytampung[$dateyangdicari];
					$datadump[$a]['su'] = $sum;
				}else{
					$datadump[$a]['u'] = 0;
					$sum += 0;
					$datadump[$a]['su'] = $sum;
				}
				$awal = $minggu_selanjutnya;
				$date_mingguselanjutnya = strtotime("+7 day",$date_tglawal);
				$minggu_selanjutnya = date('Y-m-d',$date_mingguselanjutnya);
				$akhir = date('Y-m-d',strtotime("+6 day",strtotime($awal)));
				$datadump[$a]['range'] = $awal.' '.$akhir;
				$a++;
			}

			if ($data['datagraf']) {
				$awal = $tglawal;
				$date_tglawal =strtotime($tglawal);
				$akhir = date('Y-m-d',strtotime("+6 day",$date_tglawal));
				// echo $tglawal.'<>'.$akhir;
				// exit();
				$data['daily'] = $this->M_Grafik->getDaily($tglawal,$akhir);
				foreach ($data['daily'] as $key => $value) {
					$exp = explode(' ', $value['daily']);
					$arraytampung2[$exp[0]] = $value['count'];
				}
				$a =0;
				while ($tglawal <= $akhir) {
					$dateyangdicari = date('Y-m-d',strtotime($tglawal));
					if (isset($arraytampung2[$dateyangdicari])) {
						$recapDay[$a]['su'] = $arraytampung2[$dateyangdicari];
					}else{
						$recapDay[$a]['su'] = 0;
					}
					$recapDay[$a]['tgl'] = str_replace('-', ',', $dateyangdicari);
					$date_selanjutnya = strtotime("+1 day",strtotime($tglawal));
					$tglawal = date('Y-m-d',$date_selanjutnya);
					$a++;
				}

				$getComp = $this->M_Grafik->getDailyCOmpo($awal,$akhir);
				if ($getComp) {
					$recapComp = $getComp;
				}
			}


			$data['recap'] = $datadump;
			$data['recapDay'] = $recapDay;
			$data['recapComp'] = $recapComp;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProses/Grafik/V_Index',$data);
			$this->load->view('V_Footer',$data);
			$this->load->view('FlowProses/Grafik/V_Chart',$data);
		}

		public function getGrafik()
		{
			$range = $this->input->post('range');
			$ke = $this->input->post('ke');
			$arrrange = explode(' ', $range);
			$awal = $arrrange[0];
			$akhir = $arrrange[1];
			$arraytampung2 = array();
			$recapComp = array();

				$data['daily'] = $this->M_Grafik->getDaily($awal,$akhir);
				foreach ($data['daily'] as $key => $value) {
					$exp = explode(' ', $value['daily']);
					$arraytampung2[$exp[0]] = $value['count'];
				}
				$a =0;
				$day1 = $awal;
				while ($day1 <= $akhir) {
					$dateyangdicari = date('Y-m-d',strtotime($day1));
					if (isset($arraytampung2[$dateyangdicari])) {
						$recapDay[$a]['su'] = $arraytampung2[$dateyangdicari];
					}else{
						$recapDay[$a]['su'] = 0;
					}
					$recapDay[$a]['tgl'] = str_replace('-', ',', $dateyangdicari);
					$date_selanjutnya = strtotime("+1 day",strtotime($day1));
					$day1 = date('Y-m-d',$date_selanjutnya);
					$a++;
				}

				$getComp = $this->M_Grafik->getDailyCOmpo($awal,$akhir);
				if ($getComp) {
					foreach ($getComp as $key => $value) {
						$recapComp[$key]['tgl'] = date('Y-m-d',strtotime($value['created_date']));
						$recapComp[$key]['cd_comp'] = $value['component_code'];
						$recapComp[$key]['desc_prod'] = $value['product_name'];
					}
				}
				$data['recapDay'] = $recapDay;
				$data['ke'][0]['ke'] = $ke;
				$data['recapComp'] = $recapComp;
			// $this->load->view('FlowProses/Grafik/V_Chart2',$data);
				echo json_encode($data);

		}

}
