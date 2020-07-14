<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DataLKHSeksi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_datalkhseksi');

		$this->checkSession();
		ini_set('max_execution_time', 0);
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data LKH Seksi';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function download_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Download Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_copy', $data);
		$this->load->view('V_Footer',$data);
	}

	public function check_server(){
		echo 1;
		sleep(5);
	}

	public function import_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Import Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doImport(){
		$this->session->set_userdata('ImportProgress', '0');

		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Import data LKH Seksi periode=$thn_gaji $bln_gaji";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/'.$uploadData['file_name'];
			// $inputFileName = 'assets/upload/1490405144-PROD0117_(copy).dbf';
			$db = dbase_open($inputFileName, 0);
			// print_r(dbase_get_header_info($db));
			$db_rows = dbase_numrecords($db);
			for ($i=1; $i <= $db_rows; $i++) {
				$db_record = dbase_get_record_with_names($db, $i);

				$data = array(
					'tgl' => utf8_encode($db_record['TGL']),
					'noind' => utf8_encode($db_record['NOIND']),
					'kode_barang' => utf8_encode($db_record['KODEPART']),
					'kode_proses' => utf8_encode($db_record['KODEPRO']),
					'jml_barang' => utf8_encode($db_record['JUMLAH']),
					'reject' => (utf8_encode($db_record['JUMLAH']) - utf8_encode($db_record['BAIK'])),
					'afmat' => utf8_encode($db_record['AFMAT']),
					'afmch' => utf8_encode($db_record['AFMCH']),
					'repair' => utf8_encode($db_record['REP']),
					'setting_time' => utf8_encode($db_record['SETTING']),
					'shift' => utf8_encode($db_record['SHIFT']),
					'status' => utf8_encode($db_record['STATUS']),
					'kode_barang_target_sementara' => utf8_encode($db_record['KODESAMA']),
					'kode_proses_target_sementara' => utf8_encode($db_record['PROSAMA']),
				);

				$this->M_datalkhseksi->setLKHSeksi($data);

				$ImportProgress = ($i/$db_rows)*100;
				$this->session->set_userdata('ImportProgress', $ImportProgress);
				flush();
			}
			unlink($inputFileName);
			//redirect(site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi'));
		}
		else{
			echo $this->upload->display_errors();
		}
	}

	public function clear_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Clear Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_clear', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doClearData(){
		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Delete data LKH Seksi periode=$thn_gaji $bln_gaji";
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->M_datalkhseksi->clearData($firstdate, $lastdate);
	}

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(
			0 => 'noind',
			1 => 'tgl',
			2 => 'noind',
			3 => 'kode_barang',
			4 => 'kode_proses',
			5 => 'jml_barang',
			6 => 'afmat',
			7 => 'afmch',
			8 => 'repair',
			9 => 'reject',
			10 => 'setting_time',
			11 => 'shift',
			12 => 'status',
			13 => 'kode_barang_target_sementara',
			14 => 'kode_proses_target_sementara'
		);

		$data_table = $this->M_datalkhseksi->getLKHSeksiDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_datalkhseksi->getLKHSeksiSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_datalkhseksi->getLKHSeksiOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_datalkhseksi->getLKHSeksiOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}

		$data = array();
		$no = 1;
		$data_array = $data_table->result_array();

		$json = "{";
		$json .= '"draw":'.intval( $requestData['draw'] ).',';
		$json .= '"recordsTotal":'.intval( $totalData ).',';
		$json .= '"recordsFiltered":'.intval( $totalFiltered ).',';
		$json .= '"data":[';

		$count = count($data_array);
		$no = 1;
		foreach ($data_array as $result) {
			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "'.$result['tgl'].'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kode_barang'].'", "'.$result['kode_proses'].'", "'.$result['jml_barang'].'", "'.$result['afmat'].'", "'.$result['afmch'].'", "'.$result['repair'].'", "'.$result['reject'].'", "'.$result['setting_time'].'", "'.$result['shift'].'", "'.$result['status'].'", "'.$result['kode_barang_target_sementara'].'", "'.$result['kode_proses_target_sementara'].'"],';
			}
			else{
				$json .= '["'.$no.'", "'.$result['tgl'].'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kode_barang'].'", "'.$result['kode_proses'].'", "'.$result['jml_barang'].'", "'.$result['afmat'].'", "'.$result['afmch'].'", "'.$result['repair'].'", "'.$result['reject'].'", "'.$result['setting_time'].'", "'.$result['shift'].'", "'.$result['status'].'", "'.$result['kode_barang_target_sementara'].'", "'.$result['kode_proses_target_sementara'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

	public function chart_ott(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Pekerja OTT';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_chart', $data);
		$this->load->view('V_Footer',$data);
	}

	public function data_chart($periode){
		$data['data_kasus_ott'] = $this->M_datalkhseksi->get_ott_data($periode, 1);

		$tetap = array("A", "B", "D", "E");
		$kontrak = array("H", "J");
		$os = array("K", "P");

		$grp_per_status = ""; $grp_per_sentase = ""; $grp_per_seksi = "";
		$grp_per_noind = "";  $grp_per_seksi2 = "";

		for($x=1; $x<=3; $x++){
			$status = "";
			$jan = 0; $feb = 0; $mar = 0; $apr = 0; $mei = 0; $jun = 0;
			$jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
			$tjan = 0; $tfeb = 0; $tmar = 0; $tapr = 0; $tmei = 0; $tjun = 0;
			$tjul = 0; $taug = 0; $tsep = 0; $toct = 0; $tnov = 0; $tdec = 0;

			if($x==1){
				$kode_jenis = $tetap; $nama_jenis = "TETAP";
			}elseif($x==2){
				$kode_jenis = $kontrak; $nama_jenis = "KONTRAK";
			}elseif($x==3){
				$kode_jenis = $os; $nama_jenis = "OS";
			}

			foreach($data['data_kasus_ott'] as $dko){
				if (in_array($dko['worker_status_code'], $kode_jenis)) {
				    if($dko['bln']==1){
				    	$jan = $jan + $dko['jumlah'];
				    }elseif($dko['bln']==2){
				    	$feb = $feb + $dko['jumlah'];
				    }elseif($dko['bln']==3){
				    	$mar = $mar + $dko['jumlah'];
				    }elseif($dko['bln']==4){
				    	$apr = $apr + $dko['jumlah'];
				    }elseif($dko['bln']==5){
				    	$mei = $mei + $dko['jumlah'];
				    }elseif($dko['bln']==6){
				    	$jun = $jun + $dko['jumlah'];
				    }elseif($dko['bln']==7){
				    	$jul = $jul + $dko['jumlah'];
				    }elseif($dko['bln']==8){
				    	$aug = $aug + $dko['jumlah'];
				    }elseif($dko['bln']==9){
				    	$sep = $sep + $dko['jumlah'];
				    }elseif($dko['bln']==10){
				    	$oct = $oct + $dko['jumlah'];
				    }elseif($dko['bln']==11){
				    	$nov = $nov + $dko['jumlah'];
				    }elseif($dko['bln']==12){
				    	$dec = $dec + $dko['jumlah'];
				    }
				}

				if($dko['bln']==1){
				    	$tjan = $tjan + $dko['jumlah'];
				}elseif($dko['bln']==2){
				    	$tfeb = $tfeb + $dko['jumlah'];
				}elseif($dko['bln']==3){
				    	$tmar = $tmar + $dko['jumlah'];
				}elseif($dko['bln']==4){
				    	$tapr = $tapr + $dko['jumlah'];
				}elseif($dko['bln']==5){
				    	$tmei = $tmei + $dko['jumlah'];
				}elseif($dko['bln']==6){
				    	$tjun = $tjun + $dko['jumlah'];
				}elseif($dko['bln']==7){
				    	$tjul = $tjul + $dko['jumlah'];
				}elseif($dko['bln']==8){
				    	$taug = $taug + $dko['jumlah'];
				}elseif($dko['bln']==9){
				    	$tsep = $tsep + $dko['jumlah'];
				}elseif($dko['bln']==10){
				    	$toct = $toct + $dko['jumlah'];
				}elseif($dko['bln']==11){
				    	$tnov = $tnov + $dko['jumlah'];
				}elseif($dko['bln']==12){
				    	$tdec = $tdec + $dko['jumlah'];
				}
			}
			@$pjan = round($jan/$tjan*100);	@$pfeb = round($feb/$tfeb*100);	@$pmar = round($mar/$tmar*100);	@$papr = round($apr/$tapr*100);
			@$pmei = round($mei/$tmei*100);	@$pjun = round($jun/$tjun*100);	@$pjul = round($jul/$tjul*100);	@$paug = round($aug/$taug*100);
			@$psep = round($sep/$tsep*100);	@$poct = round($oct/$toct*100);	@$pnov = round($nov/$tnov*100);	@$pdec = round($dec/$tdec*100);

			$ott_per_status[] = array('status'=>$nama_jenis, 'jan'=>$jan, 'feb'=>$feb, 'mar'=>$mar, 'apr'=>$apr, 'mei'=>$mei,
				 'jun'=>$jun, 'jul'=>$jul, 'aug'=>$aug, 'sep'=>$sep, 'okt'=>$oct, 'nov'=>$nov, 'dec'=>$dec );
			$grp_per_status .= "{name:'".$nama_jenis."', data:[".$jan.", ".$feb.", ".$mar.", ".$apr.", ".$mei.",
				 ".$jun.", ".$jul.", ".$aug.", ".$sep.", ".$oct.", ".$nov.", ".$dec."]},";

			$ott_per_sentase[] = array('status'=>$nama_jenis, 'jan'=>$pjan, 'feb'=>$pfeb, 'mar'=>$pmar, 'apr'=>$papr, 'mei'=>$pmei,
				 'jun'=>$pjun, 'jul'=>$pjul, 'aug'=>$paug, 'sep'=>$psep, 'okt'=>$poct, 'nov'=>$pnov, 'dec'=>$pdec );
			$grp_per_sentase .= "{name:'".$nama_jenis."', data:[".$pjan.", ".$pfeb.", ".$pmar.", ".$papr.", ".$pmei.",
				 ".$pjun.", ".$pjul.", ".$paug.", ".$psep.", ".$poct.", ".$pnov.", ".$pdec."]},";
		}
		@$pjan = $tjan/$tjan*100;	@$pfeb = $tfeb/$tfeb*100;	@$pmar = $tmar/$tmar*100;	@$papr = $tapr/$tapr*100;
		@$pmei = $tmei/$tmei*100;	@$pjun = $tjun/$tjun*100;	@$pjul = $tjul/$tjul*100;	@$paug = $taug/$taug*100;
		@$psep = $tsep/$tsep*100;	@$poct = $toct/$toct*100;	@$pnov = $tnov/$tnov*100;	@$pdec = $tdec/$tdec*100;

		$ott_per_status[] = array('status'=>'TOTAL', 'jan'=>$tjan, 'feb'=>$tfeb, 'mar'=>$tmar, 'apr'=>$tapr, 'mei'=>$tmei,
			 'jun'=>$tjun, 'jul'=>$tjul, 'aug'=>$taug, 'sep'=>$tsep, 'okt'=>$toct, 'nov'=>$tnov, 'dec'=>$tdec );
		$grp_per_status .= "{name: 'TOTAL', data:[".$tjan.", ".$tfeb.", ".$tmar.", ".$tapr.", ".$tmei.",
			 ".$tjun.", ".$tjul.", ".$taug.", ".$tsep.", ".$toct.", ".$tnov.", ".$tdec."]},";


		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$tmp = "";
		$jan = 0; $feb = 0; $mar = 0; $apr = 0; $mei = 0; $jun = 0;
		$jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
		$tjan = 0; $tfeb = 0; $tmar = 0; $tapr = 0; $tmei = 0; $tjun = 0;
		$tjul = 0; $taug = 0; $tsep = 0; $toct = 0; $tnov = 0; $tdec = 0;
		foreach($data['data_kasus_ott'] as $dko){
			if($tmp != "" && $tmp != $dko['section_name']){
				$ott_per_seksi[] = array('status'=>$tmp, 'jan'=>$jan, 'feb'=>$feb, 'mar'=>$mar, 'apr'=>$apr, 'mei'=>$mei,
					'jun'=>$jun, 'jul'=>$jul, 'aug'=>$aug, 'sep'=>$sep, 'okt'=>$oct, 'nov'=>$nov, 'dec'=>$dec );
				$grp_per_seksi .= "{name:'".$tmp."', data:[".$jan.", ".$feb.", ".$mar.", ".$apr.", ".$mei.",
				 ".$jun.", ".$jul.", ".$aug.", ".$sep.", ".$oct.", ".$nov.", ".$dec."]},";

				$jan = 0; $feb = 0; $mar = 0; $apr = 0; $mei = 0; $jun = 0;
				$jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
			}
			$tmp = $dko['section_name'];

			if($dko['bln']==1){
				$jan = $jan + $dko['jumlah'];
				$tjan = $tjan + $dko['jumlah'];
			}elseif($dko['bln']==2){
				$feb = $feb + $dko['jumlah'];
				$tfeb = $tfeb + $dko['jumlah'];
			}elseif($dko['bln']==3){
				$mar = $mar + $dko['jumlah'];
				$tmar = $tmar + $dko['jumlah'];
			}elseif($dko['bln']==4){
				$apr = $apr + $dko['jumlah'];
				$tapr = $tapr + $dko['jumlah'];
			}elseif($dko['bln']==5){
				$mei = $mei + $dko['jumlah'];
				$tmei = $tmei + $dko['jumlah'];
			}elseif($dko['bln']==6){
				$jun = $jun + $dko['jumlah'];
				$tjun = $tjun + $dko['jumlah'];
			}elseif($dko['bln']==7){
				$jul = $jul + $dko['jumlah'];
				$tjul = $tjul + $dko['jumlah'];
			}elseif($dko['bln']==8){
				$aug = $aug + $dko['jumlah'];
				$taug = $taug + $dko['jumlah'];
			}elseif($dko['bln']==9){
				$sep = $sep + $dko['jumlah'];
				$tsep = $tsep + $dko['jumlah'];
			}elseif($dko['bln']==10){
				$oct = $oct + $dko['jumlah'];
				$toct = $toct + $dko['jumlah'];
			}elseif($dko['bln']==11){
				$nov = $nov + $dko['jumlah'];
				$tnov = $tnov + $dko['jumlah'];
			}elseif($dko['bln']==12){
				$dec = $dec + $dko['jumlah'];
				$tdec = $tdec + $dko['jumlah'];
			}
		}
		$ott_per_seksi[] = array('status'=>$tmp, 'jan'=>$jan, 'feb'=>$feb, 'mar'=>$mar, 'apr'=>$apr, 'mei'=>$mei,
			'jun'=>$jun, 'jul'=>$jul, 'aug'=>$aug, 'sep'=>$sep, 'okt'=>$oct, 'nov'=>$nov, 'dec'=>$dec );
		$ott_per_seksi[] = array('status'=>'TOTAL', 'jan'=>$tjan, 'feb'=>$tfeb, 'mar'=>$tmar, 'apr'=>$tapr, 'mei'=>$tmei,
			'jun'=>$tjun, 'jul'=>$tjul, 'aug'=>$taug, 'sep'=>$tsep, 'okt'=>$toct, 'nov'=>$tnov, 'dec'=>$tdec );
		$grp_per_seksi .= "{name:'".$tmp."', data:[".$jan.", ".$feb.", ".$mar.", ".$apr.", ".$mei.",
				 ".$jun.", ".$jul.", ".$aug.", ".$sep.", ".$oct.", ".$nov.", ".$dec."]},";
		$grp_per_seksi .= "{name: 'TOTAL', data:[".$tjan.", ".$tfeb.", ".$tmar.", ".$tapr.", ".$tmei.",
			 ".$tjun.", ".$tjul.", ".$taug.", ".$tsep.", ".$toct.", ".$tnov.", ".$tdec."]},";

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$data['data_kasus_ott'] = $this->M_datalkhseksi->get_ott_data($periode, 2);

		$tmp = "";
		$jan = 0; $feb = 0; $mar = 0; $apr = 0; $mei = 0; $jun = 0;
		$jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
		$tjan = 0; $tfeb = 0; $tmar = 0; $tapr = 0; $tmei = 0; $tjun = 0;
		$tjul = 0; $taug = 0; $tsep = 0; $toct = 0; $tnov = 0; $tdec = 0;
		foreach($data['data_kasus_ott'] as $dko){
			if($tmp != "" && $tmp != $dko['worker_status_code']){
				$ott_per_noind[] = array('status'=>$tmp, 'jan'=>$jan, 'feb'=>$feb, 'mar'=>$mar, 'apr'=>$apr, 'mei'=>$mei,
					'jun'=>$jun, 'jul'=>$jul, 'aug'=>$aug, 'sep'=>$sep, 'okt'=>$oct, 'nov'=>$nov, 'dec'=>$dec );
				$grp_per_noind .= "{name:'".$tmp."', data:[".$jan.", ".$feb.", ".$mar.", ".$apr.", ".$mei.",
				 ".$jun.", ".$jul.", ".$aug.", ".$sep.", ".$oct.", ".$nov.", ".$dec."]},";

				$jan = 0; $feb = 0; $mar = 0; $apr = 0; $mei = 0; $jun = 0;
				$jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
			}
			$tmp = $dko['worker_status_code'];

			if($dko['bln']==1){
				$jan = $jan + $dko['jumlah'];
				$tjan = $tjan + $dko['jumlah'];
			}elseif($dko['bln']==2){
				$feb = $feb + $dko['jumlah'];
				$tfeb = $tfeb + $dko['jumlah'];
			}elseif($dko['bln']==3){
				$mar = $mar + $dko['jumlah'];
				$tmar = $tmar + $dko['jumlah'];
			}elseif($dko['bln']==4){
				$apr = $apr + $dko['jumlah'];
				$tapr = $tapr + $dko['jumlah'];
			}elseif($dko['bln']==5){
				$mei = $mei + $dko['jumlah'];
				$tmei = $tmei + $dko['jumlah'];
			}elseif($dko['bln']==6){
				$jun = $jun + $dko['jumlah'];
				$tjun = $tjun + $dko['jumlah'];
			}elseif($dko['bln']==7){
				$jul = $jul + $dko['jumlah'];
				$tjul = $tjul + $dko['jumlah'];
			}elseif($dko['bln']==8){
				$aug = $aug + $dko['jumlah'];
				$taug = $taug + $dko['jumlah'];
			}elseif($dko['bln']==9){
				$sep = $sep + $dko['jumlah'];
				$tsep = $tsep + $dko['jumlah'];
			}elseif($dko['bln']==10){
				$oct = $oct + $dko['jumlah'];
				$toct = $toct + $dko['jumlah'];
			}elseif($dko['bln']==11){
				$nov = $nov + $dko['jumlah'];
				$tnov = $tnov + $dko['jumlah'];
			}elseif($dko['bln']==12){
				$dec = $dec + $dko['jumlah'];
				$tdec = $tdec + $dko['jumlah'];
			}
		}
		$ott_per_noind[] = array('status'=>$tmp, 'jan'=>$jan, 'feb'=>$feb, 'mar'=>$mar, 'apr'=>$apr, 'mei'=>$mei,
			'jun'=>$jun, 'jul'=>$jul, 'aug'=>$aug, 'sep'=>$sep, 'okt'=>$oct, 'nov'=>$nov, 'dec'=>$dec );
		$ott_per_noind[] = array('status'=>'TOTAL', 'jan'=>$tjan, 'feb'=>$tfeb, 'mar'=>$tmar, 'apr'=>$tapr, 'mei'=>$tmei,
			'jun'=>$tjun, 'jul'=>$tjul, 'aug'=>$taug, 'sep'=>$tsep, 'okt'=>$toct, 'nov'=>$tnov, 'dec'=>$tdec );
		$grp_per_noind .= "{name:'".$tmp."', data:[".$jan.", ".$feb.", ".$mar.", ".$apr.", ".$mei.",
				 ".$jun.", ".$jul.", ".$aug.", ".$sep.", ".$oct.", ".$nov.", ".$dec."]},";
		$grp_per_noind .= "{name: 'TOTAL', data:[".$tjan.", ".$tfeb.", ".$tmar.", ".$tapr.", ".$tmei.",
			 ".$tjun.", ".$tjul.", ".$taug.", ".$tsep.", ".$toct.", ".$tnov.", ".$tdec."]},";

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$data['data_kasus_ott'] = $this->M_datalkhseksi->get_ott_data($periode, 3);

		$tmp = "";
		$sm = 0; $ma = 0; $mb = 0; $mc = 0; $md = 0;
		$pa = 0; $pb = 0; $pc = 0; $pp = 0; $cp = 0;
		foreach($data['data_kasus_ott'] as $dko){
			if($tmp != "" && $tmp != $dko['bln']){
				$grp_per_seksi2 .= "{name:'".$tmp."', data:[".$sm.", ".$ma.", ".$mb.", ".$mc.", ".$md.",
				 ".$pa.", ".$pb.", ".$pc.", ".$pp.", ".$cp."]},";

				$sm = 0; $ma = 0; $mb = 0; $mc = 0; $md = 0;
				$pa = 0; $pb = 0; $pc = 0; $pp = 0; $cp = 0;
			}
			$tmp = $dko['bln'];

			if (strpos($dko['section_name'], 'SHEET METAL') !== false) {
				$sm = $sm + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'MACHINING A') !== false) {
				$ma = $ma + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'MACHINING B') !== false) {
				$mb = $mb + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'MACHINING C') !== false) {
				$mc = $mc + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'MACHINING D') !== false) {
				$md = $md + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'PERAKITAN A') !== false) {
				$pa = $pa + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'PERAKITAN B') !== false) {
				$pb = $pb + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'PERAKITAN B') !== false) {
				$pb = $pb + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'PERAKITAN C') !== false) {
				$pc = $pc + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'PAINTING & PACKAGING') !== false) {
				$pp = $pp + $dko['jumlah'];
			}elseif (strpos($dko['section_name'], 'CETAKAN') !== false) {
				$cp = $cp + $dko['jumlah'];
			}
		}
		$grp_per_seksi2 .= "{name:'".$tmp."', data:[".$sm.", ".$ma.", ".$mb.", ".$mc.", ".$md.",
				".$pa.", ".$pb.", ".$pc.", ".$pp.", ".$cp."]},";

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$data['ott_per_status'] = $ott_per_status;
		$data['grp_per_status'] = $grp_per_status;

		$data['ott_per_sentase'] = $ott_per_sentase;
		$data['grp_per_sentase'] = $grp_per_sentase;

		$data['ott_per_seksi'] = $ott_per_seksi;
		$data['grp_per_seksi'] = $grp_per_seksi;

		$data['ott_per_noind'] = $ott_per_noind;
		$data['grp_per_noind'] = $grp_per_noind;

		$data['grp_per_seksi2'] = $grp_per_seksi2;

		return $data;
	}

	public function show_chart(){
		$data['thn_ott'] = $this->input->post('txtTahun');
		$to_proses_data = $this->data_chart($data['thn_ott']);

		$data['data_kasus_ott'] = $to_proses_data['data_kasus_ott'];
		$data['ott_per_status'] = $to_proses_data['ott_per_status'];
		$data['grp_per_status'] = $to_proses_data['grp_per_status'];
		$data['ott_per_sentase'] = $to_proses_data['ott_per_sentase'];
		$data['grp_per_sentase'] = $to_proses_data['grp_per_sentase'];
		$data['ott_per_seksi'] = $to_proses_data['ott_per_seksi'];
		$data['grp_per_seksi'] = $to_proses_data['grp_per_seksi'];
		$data['ott_per_noind'] = $to_proses_data['ott_per_noind'];
		$data['grp_per_noind'] = $to_proses_data['grp_per_noind'];
		$data['grp_per_seksi2'] = $to_proses_data['grp_per_seksi2'];

		//echo $grp_per_seksi."<br><br>";
		//echo $grp_per_seksi2;
		//exit;

		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Pekerja OTT';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_chart', $data);
		$this->load->view('V_Footer',$data);
	}

	public function download_pfd(){
		$data['GJPO'] = $this->input->post('GJPO');
	    $data['PJKO'] = $this->input->post('PJKO');
	    $data['JKOPS'] = $this->input->post('JKOPS');
	    $data['JKOPS2'] = $this->input->post('JKOPS2');
	    $data['DKO'] = $this->input->post('DKO');

	    $data['thn_ott'] = $this->input->post('txtTahun2');
		$to_proses_data = $this->data_chart($data['thn_ott']);

		$data['data_kasus_ott'] = $to_proses_data['data_kasus_ott'];
		$data['ott_per_status'] = $to_proses_data['ott_per_status'];
		$data['ott_per_sentase'] = $to_proses_data['ott_per_sentase'];
		$data['ott_per_seksi'] = $to_proses_data['ott_per_seksi'];
		$data['ott_per_noind'] = $to_proses_data['ott_per_noind'];
		//print_r($data['grp_per_status']);exit;

	    $this->load->library('pdf');
		$pdf = $this->pdf->load();

		$filename = 'Laporan Progres.pdf';
		$pdf=new mPDF('','A4-P', 0, '', 5, 5, 5, 5);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet,1);
		$html = $this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_chart_pdf',$data, true);
		$pdf->WriteHTML($html,2);

	    $pdf->Output($filename, 'I');
	}

	public function downloadExcel()
    {
		$filter = $this->input->get('filter');
		$column_table = array('', 'tgl', 'noind', 'employee_name', 'kode_barang', 'kode_proses', 'jml_barang', 'afmat', 'afmch', 'repair',
			'reject', 'setting_time', 'shift', 'status', 'kode_barang_target_sementara', 'kode_proses_target_sementara');
		$column_view = array('No', 'Tanggal', 'No Induk', 'Nama', 'Kode Barang', 'Kode Proses', 'Jml Barang', 'Afmat', 'Afmch', 'Repair',
			'Reject', 'Setting Time', 'Shift', 'Status', 'Kode Barang Target Sementara', 'Kode Proses Target Sementara');
		$data_table = $this->M_datalkhseksi->getLKHSeksiSearch($filter)->result_array();

		$this->load->library("Excel");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$column = 0;

		foreach($column_view as $cv){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $cv);
			$column++;
		}

		$excel_row = 2;
		foreach($data_table as $dt){
			$excel_col = 0;
			foreach($column_table as $ct){
				if($ct == ''){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $excel_row-1);
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $dt[$ct]);
				}
				$excel_col++;
			}
			$excel_row++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Quick ERP');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment;filename="DataLHKSeksi.xlsx"');
		$objWriter->save("php://output");
	}

	public function cek_data_lkh()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Cek Pekerja LKH';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_cek', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doCek_LKH()
	{
		$jenis = $_REQUEST['slcJenis'];
		$bulan = $_REQUEST['slcBulan'];
		$tahun = $_REQUEST['txtTahun'];

		$data['data_table'] = $this->M_datalkhseksi->get_Cek_LKH($jenis, $bulan, $tahun)->result_array();
		$data['jenis'] = $jenis;
 		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_hasil_cek', $data);
	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */
