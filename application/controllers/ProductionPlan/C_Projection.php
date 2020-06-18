<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Projection extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		

		
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlan/M_productionplan');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){
			
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Production Plan Projection';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$month=date("F-Y");

		$dataplan = $this->M_productionplan->dataplan($month);
		$dataitem = $this->M_productionplan->datainserttampil();
		$hedbulan = date("F");

		
		$date=date("j");
		$batas = $date+7;


		$haha = array();
			$item_id = array();
		foreach ($dataplan as $plan) {
			$tgl_plan='';
			$x=0;
			if (!in_array($plan['id_item'], $item_id)) {
			array_push($item_id, $plan['id_item']);
					for ($i = $date ; $i < $batas ; $i++) { 
							$tgl_plan[] .= $plan['tgl_'.$i];
					}
					array_push($haha, $tgl_plan);
					foreach ($dataitem as $item) {
						if ($plan['id_item'] == $item['id_item']) {
							$haha[$x]['id_item'] = $item['id_item'];
							$haha[$x]['komponen'] = $item['kode_item'];
							$haha[$x]['jenis'] = $item['jenis'];
							$haha[$x]['desc_item'] = $item['desc_item'];

						}
				$x++;
				
				}
			}

		}

			// echo "<pre>"; print_r($haha);exit();

		$handle_bar = array();
		$body = array();
		$dos = array();
		$shortagehand=array();
		$shortagebody=array();
		$shortagedos=array();
		foreach ($haha as $plantgl) {
		$p1 = array();
		$p2 = array();
		$p3 = array();
		$p4 = array();
		$p5 = array();
		$p6 = array();
		$p7 = array();


		$projection = $this->M_productionplan->getprojection($plantgl[0],$plantgl[1],$plantgl[2],$plantgl[3],$plantgl[4],$plantgl[5],$plantgl[6],$plantgl['komponen']);

// foreach array hasil projection yg ditampilkan di tabel projection----------------------

				foreach ($projection as $pro) {
					$array = array(
						'jenis' => $plantgl['jenis'],
						'komponen' => $plantgl['desc_item'],
						'proyeksi1' => $pro['BISA1'] , 
						'proyeksi2' => $pro['BISA2'] , 
						'proyeksi3' => $pro['BISA3'] , 
						'proyeksi4' => $pro['BISA4'] , 
						'proyeksi5' => $pro['BISA5'] , 
						'proyeksi6' => $pro['BISA6'] , 
						'proyeksi7' => $pro['BISA7'] ,
						'kode' => $pro['COMPONENT_CODE'] ,
						'desc' => $pro['COMPONENT_DESC']
				);
				if ($plantgl['jenis'] == 'Handle Bar') {
					array_push($handle_bar, $array);
					array_push($p1, $pro['BISA1']);
					array_push($p2, $pro['BISA2']);
					array_push($p3, $pro['BISA3']);
					array_push($p4, $pro['BISA4']);
					array_push($p5, $pro['BISA5']);
					array_push($p6, $pro['BISA6']);
					array_push($p7, $pro['BISA7']);
					for ($a=0; $a < 1 ; $a++) { 
					$array_handle = array(
						'jenis' => $plantgl['jenis'],
						'komponen' => $plantgl['desc_item'],
						'qty_plan1' => $plantgl[0] , 
						'qty_plan2' =>$plantgl[1] , 
						'qty_plan3' => $plantgl[2], 
						'qty_plan4' => $plantgl[3] , 
						'qty_plan5' => $plantgl[4] , 
						'qty_plan6' => $plantgl[5], 
						'qty_plan7' =>$plantgl[6],
						'proyeksi1' => $p1[0] , 
						'proyeksi2' => $p2[0] , 
						'proyeksi3' => $p3[0] , 
						'proyeksi4' => $p4[0] , 
						'proyeksi5' =>$p5[0] , 
						'proyeksi6' => $p6[0] , 
						'proyeksi7' => $p7[0],
					);
				}
				} else if ($plantgl['jenis'] == 'Body') {
					array_push($body, $array);
					array_push($p1, $pro['BISA1']);
					array_push($p2, $pro['BISA2']);
					array_push($p3, $pro['BISA3']);
					array_push($p4, $pro['BISA4']);
					array_push($p5, $pro['BISA5']);
					array_push($p6, $pro['BISA6']);
					array_push($p7, $pro['BISA7']);
					for ($a=0; $a < 1 ; $a++) { 
					$array_body = array(
						'jenis' => $plantgl['jenis'],
						'komponen' => $plantgl['desc_item'],
						'qty_plan1' => $plantgl[0] , 
						'qty_plan2' =>$plantgl[1] , 
						'qty_plan3' => $plantgl[2], 
						'qty_plan4' => $plantgl[3] , 
						'qty_plan5' => $plantgl[4] , 
						'qty_plan6' => $plantgl[5], 
						'qty_plan7' =>$plantgl[6],
						'proyeksi1' => $p1[0] , 
						'proyeksi2' => $p2[0] , 
						'proyeksi3' => $p3[0] , 
						'proyeksi4' => $p4[0] , 
						'proyeksi5' =>$p5[0] , 
						'proyeksi6' => $p6[0] , 
						'proyeksi7' => $p7[0],
					);
				}
				} else if ($plantgl['jenis'] == 'Dos') {
					array_push($dos, $array);
					array_push($p1, $pro['BISA1']);
					array_push($p2, $pro['BISA2']);
					array_push($p3, $pro['BISA3']);
					array_push($p4, $pro['BISA4']);
					array_push($p5, $pro['BISA5']);
					array_push($p6, $pro['BISA6']);
					array_push($p7, $pro['BISA7']);
						for ($a=0; $a < 1 ; $a++) { 
					$array_dos = array(
						'jenis' => $plantgl['jenis'],
						'komponen' => $plantgl['desc_item'],
						'qty_plan1' => $plantgl[0] , 
						'qty_plan2' =>$plantgl[1] , 
						'qty_plan3' => $plantgl[2], 
						'qty_plan4' => $plantgl[3] , 
						'qty_plan5' => $plantgl[4] , 
						'qty_plan6' => $plantgl[5], 
						'qty_plan7' =>$plantgl[6],
						'proyeksi1' => $p1[0] , 
						'proyeksi2' => $p2[0] , 
						'proyeksi3' => $p3[0] , 
						'proyeksi4' => $p4[0] , 
						'proyeksi5' =>$p5[0] , 
						'proyeksi6' => $p6[0] , 
						'proyeksi7' => $p7[0],
					);
				}
				}	
				// echo "<pre>";print_r($p2);

			
			}
			


// foreach untuk buat array shortage hand----------------------------------------
		if ($plantgl['jenis'] == 'Handle Bar') {
				foreach ($handle_bar as $hand) {
				$g=1;
				for ($i=0; $i < 7 ; $i++) { 
						if ($hand['proyeksi'.$g] < $plantgl[$i]) {
							$array = array(
								'komponen' => $hand['kode'] , 
								'desc' => $hand['desc'] , 
								'qty' => $hand['proyeksi'.$g]
							);
							// if ($hand['jenis'] == 'Handle Bar') {
							
								array_push($shortagehand,$array);	
								
							// }
						}
					$g++;
				}
			}
		}else 
		

// foreach untuk buat array shortage body----------------------------------------

		if ($plantgl['jenis'] == 'Body') {
			foreach ($body as $bo) {
				$g=1;
				for ($i=0; $i < 7 ; $i++) { 
			// echo "<pre>";print_r($bo);
			// echo"<pre>";print_r($plantgl[$i]);exit();
						if ($bo['proyeksi'.$g] < $plantgl[$i]) {
							$array = array(
								'komponen' => $bo['kode'] , 
								'desc' => $bo['desc'] , 
								'qty' => $bo['proyeksi'.$g]
							);
							// if ($bo['jenis'] == 'Body') {

							array_push($shortagebody,$array);
							// }
						}
					$g++;
				}
			}
		} else
			

// foreach untuk buat array shortage dos----------------------------------------

		if ($plantgl['jenis'] == "Dos") {
				foreach ($dos as $do) {
				$g=1;
				for ($i=0; $i < 7 ; $i++) { 
						if ($do['proyeksi'.$g] < $plantgl[$i]) {
							$array = array(
								'komponen' => $do['kode'] , 
								'desc' => $do['desc'] , 
								'qty' => $do['proyeksi'.$g]
							);
							// if ($do['jenis'] == 'Dos') {

							array_push($shortagedos,$array);
							// }
						}
					$g++;
				}
			}
		}

		
	sort($p1);
	sort($p2);
	sort($p3);
	sort($p4);
	sort($p5);
	sort($p6);
	sort($p7);
		// echo "<pre>"; 
		// 		print_r($p1);
		// 		exit();
	}



// echo pre --------------------------------------------------

		// echo "<pre>"; 
		// print_r($array_handle);
		// print_r($array_body);
		// print_r($array_dos);
		// exit();

	

		$data['handle_bar'][0] = $array_handle;
		$data['body'][0] = $array_body;
		$data['dos'][0] = $array_dos;
		$data['shortagehand'] = $shortagehand;
		$data['shortagebody'] = $shortagebody;
		$data['shortagedos'] = $shortagedos;


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlan/V_Projection', $data);
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
	
}